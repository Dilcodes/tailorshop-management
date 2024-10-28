<?php

require_once '../others/class/comm_functions.php';
$app = new setting();

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'load_customer_details') {
        // Query to fetch active customer details
        $query = "SELECT
                  CONCAT_WS('-',customer_nic,customer_fullname,customer_contact) AS cus_details,
                  customer_details.customer_id
                  FROM `customer_details`
                  WHERE
                  customer_details.customer_status = 1";
        $option = '';
        $option .= '<option value="0">Select Customer</option>';    //Default option
        $result = $app->basic_Select_Query($query);
        foreach ($result AS $x) {
            $option .= '<option value=' . $x['customer_id'] . '>' . $x['cus_details'] . '</option>';
        }
        echo $option;
    } elseif ($_POST['action'] == 'load_order_types') {
        // Query to fetch active order types
        $query = "SELECT
                 measurement_type_details.measurement_id,
                 measurement_type_details.measurement_name
                 FROM `measurement_type_details`
                 WHERE
                 measurement_type_details.measurement_status = 1";
        $option = '';
        $option .= '<option value="0">Select Oreder Type</option>';
        $result = $app->basic_Select_Query($query);
        foreach ($result AS $x) {
            $option .= '<option value=' . $x['measurement_id'] . '>' . $x['measurement_name'] . '</option>';
        }
        echo $option;
    } elseif ($_POST['action'] == 'set_form') {
        $formData = '';
        
        // Query to fetch material usage details based on order type
        $query = "SELECT
                item_usage_details.usage_material_id,
                item_usage_details.usage_cus_selection,
                item_usage_details.usage_define,
                item_usage_details.usage_count,
                item_usage_details.usage_count_unit,
                CONCAT_WS('-',system_item_details.item_code,system_item_details.item_name) AS rwData,
                measurement_units.measure_unit_name,
                item_category.item_category_id
                FROM
                item_usage_details
                LEFT JOIN system_item_details ON item_usage_details.usage_material_id = system_item_details.item_id
                LEFT JOIN measurement_units ON item_usage_details.usage_count_unit = measurement_units.measure_unit_id
                LEFT JOIN item_category ON system_item_details.item_category_id = item_category.item_category_id
                WHERE
                item_usage_details.usage_item_id = '{$_POST['order_type']}'";
        $result = $app->basic_Select_Query($query);
        $matQunt = 1;
        foreach ($result AS $x) {
            if ($x['usage_cus_selection'] == 0) {
                $formData .= '<div class="form-group row">
                               <label for="inputEmail3" class="col-sm-5 col-form-label">' . $x['rwData'] . '</label>
                               <div class="col-sm-5">';
            } else {
                $formData .= '<div class="form-group row">
                               <label for="inputEmail3" class="col-sm-5 col-form-label">Select Material</label>
                               <div class="col-sm-5">';
            }
            // Generate material selection input or dropdown based on usage_cus_selection
            if ($x['usage_cus_selection'] == 0) {
                $formData .= '<input type="text" class="form-control" id="mat_' . $matQunt . '" data-matID="' . $x['usage_material_id'] . '" value="' . $x['usage_material_id'] . '" readonly>';
            } else {
                // If custom selection, generate a dropdown with options fetched from the database
                $q2 = "SELECT
                       system_item_details.item_id,
                       CONCAT_WS('-',item_code,item_name) AS rwDetails
                       FROM `system_item_details`
                       WHERE
                       system_item_details.item_category_id = '{$x['item_category_id']}'";
                $rwOptions = '';   // Initialize variable to store dropdown options
                $rwData = $app->basic_Select_Query($q2);    //fetch options from Data Base
                foreach ($rwData AS $z) {
                    $rwOptions .= '<option value="' . $z['item_id'] . '">' . $z['rwDetails'] . '</option>';
                }
                $formData .= '<select class="form-control" id="mat_' . $matQunt . '">' . $rwOptions . '</select>';     // Add dropdown to form data
            }
            $formData .= '</div>';
            $formData .= '<div class="col-sm-2">';
            if ($x['usage_define'] == 1) {
                $formData .= '<input type="text" class="form-control" id="use_' . $matQunt . '" data-matuse="' . $x['usage_count'] . '" value="' . $x['usage_count'] . '" readonly>';
            } else {
                $formData .= '<input type="text" class="form-control" id="use_' . $matQunt . '" value="">';
            }
            $formData .= '</div>';
            $formData .= '</div>';
            $matQunt++;   //increment material quantity counter
        }
        echo $formData . '~' . $matQunt;
    } elseif ($_POST['action'] == 'load_order_id') {
        // Retrieve the next available order ID
        echo $order_id = $app->get_next_autoincrement_ID('order_summery');
    } elseif ($_POST['action'] == 'add_new_order') {
        $imgName = 0;
        if (isset($_SESSION['sample_img'])) {
            $imgName = $_SESSION['sample_img'];    // Get sample image name if available
        }
        
        // Query to insert a new order into the database
        $query = "INSERT INTO `order_summery` "
                . "( `customer_id`, `order_type`, `order_mat_id`, `order_mat_usege`, `order_added_date`, `order_added_user`, `order_req_date`, `order_advance_amt`, `order_tot_amt`, `order_bal_amt`, `order_sample_image`) "
                . "VALUES "
                . "( '{$_POST['customer']}', '{$_POST['order_type']}', '{$_POST['mat']}', '{$_POST['use']}', CURDATE(), '{$_SESSION['u_id']}','{$_POST['required_date']}','{$_POST['advanced_amt']}','{$_POST['total_amt']}','{$_POST['balance_amt']}','{$imgName}');";
        $result = $app->command_query_with_lastInset_ID($query);
        if ($result != -1) {
            unset($_SESSION['sample_img']);   // Clear session sample image
//==============================================================================            
           // Update material quantities in inventory
            $mat_id = explode('~', $_POST['mat']);
            $mat_usage = explode('~', $_POST['use']);
            $matCount = count($mat_id) - 1;
            for ($matCount; $matCount >= 0; $matCount--) {
                $q = "UPDATE `system_grn_item_details` SET `grn_avilable_qty`=`grn_avilable_qty`-'{$mat_usage[$matCount]}' WHERE (`grn_item_id`='{$mat_id[$matCount]}')";
                $app->basic_command_query($q);
            }
//==============================================================================            
            echo $result;
        } else {
            echo 0;   // Indicate failure
        }
    } elseif ($_POST['action'] == 'get_raw_material_cost') {
         // Calculate total cost of raw materials
        $rawid = explode("~", $_POST['mat']);
        $usage = explode("~", $_POST['use']);
//        print_r($usage)
        $totCost = 0;
        for ($x = 0; $x <= $_POST['raw_item_count'] - 1; $x++) {
            
            // Query to fetch unit cost of raw material
            $query = "SELECT
                      system_grn_item_details.grn_unit_cost
                      FROM `system_grn_item_details`
                      WHERE
                      system_grn_item_details.grn_item_id = '{$rawid[$x]}' AND
                      system_grn_item_details.grn_avilable_qty > 0
                      LIMIT 1";
            $data = $app->basic_Select_Query($query);
            $cost = $data[0]['grn_unit_cost'] * $usage[$x];  // Calculate cost for current item

            $totCost += $cost;   // Accumulate total cost
        }
        echo $totCost;
    }
}
    




