<?php

require_once '../others/class/comm_functions.php';
$app = new setting();

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'save_supplier_details') {
        // $encryptedPassword = $app->password_encript($_POST['password']);
//        print_r($_POST);
        $query = "INSERT INTO `system_supplier_details` "
                . "( `supplier_name`, `supplier_contact`, `supplier_email`, `supplier_address`) "
                . "VALUES ( '{$_POST['sname']}', '{$_POST['contact']}', '{$_POST['email']}', '{$_POST['address']}');";
        $result = $app->basic_command_query($query);
        if ($result) {
            echo 1;
        } else {
            echo 0;
        }
    } elseif ($_POST['action'] == 'load_supplier_registration_details_table') {
        $query = "SELECT
                  CONCAT_WS('-',supplier_name, supplier_contact, supplier_email, supplier_address) AS supplier_details,
                  system_supplier_details.supplier_id
                  FROM `system_supplier_details`
                  WHERE
                  (system_supplier_details.supplier_name LIKE '{$_POST['search']}%' OR
                  system_supplier_details.supplier_contact LIKE '{$_POST['search']}%' OR
                  system_supplier_details.supplier_email LIKE '{$_POST['search']}%' OR
                  system_supplier_details.supplier_address LIKE '{$_POST['search']}%') AND
                  system_supplier_details.supplier_status = 1
                  ORDER BY
                  system_supplier_details.supplier_id DESC";
        $result = $app->json_encoded_select_query($query);
    } elseif ($_POST['action'] == 'get_supplier_details_for_update') {
        $query = "SELECT
                  system_supplier_details.supplier_name,
                  system_supplier_details.supplier_contact,
                  system_supplier_details.supplier_email,
                  system_supplier_details.supplier_address
                  FROM `system_supplier_details`
                  WHERE
                  system_supplier_details.supplier_id = '{$_POST['supplier_id']}'";
        $result = $app->json_encoded_select_query($query);
    } elseif ($_POST['action'] == 'update_supplier_details') {
        $query = "UPDATE `system_supplier_details` SET "
                . "`supplier_name` = '{$_POST['sname']}', `supplier_contact` = '{$_POST['contact']}',`supplier_email` = '{$_POST['email']}',`supplier_address` = '{$_POST['address']}' "
                . "WHERE (`supplier_id` = '{$_POST['sysId']}');";
                $result=$app->basic_command_query($query);
                if ($result) {
            echo 1;
        } else {
            echo 0;
        }
    } elseif ($_POST['action'] == 'delete_supplier_details') {
        $query="UPDATE `system_supplier_details` SET `supplier_status`='0' WHERE (`supplier_id`='{$_POST['supplier_id']}')";
        $result=$app->basic_command_query($query);
         if ($result) {
            echo 1;
        } else {
            echo 0;
        }
    }
}
    
 


//-----------soft Delete-----------------------------------------------------------
/*
 elseif ($_POST['action'] == 'delete_supplier_details') {
        $query="UPDATE `system_supplier_details` SET `supplier_status`='0' WHERE (`supplier_id`='{$_POST['supplier_id']}')";
        $result=$app->basic_command_query($query);
         if ($result) {
            echo 1;
        } else {
            echo 0;
        }
    }
 */