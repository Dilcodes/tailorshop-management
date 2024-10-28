<?php

require_once '../others/class/comm_functions.php';
$app = new setting();

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'load_grn_number') {
        echo $next_grn_number = $app->get_next_autoincrement_ID('system_grn_details');
    } elseif ($_POST['action'] == 'load_suppliers') {
        $query = "SELECT
                  system_supplier_details.supplier_id,
                  system_supplier_details.supplier_name
                  FROM `system_supplier_details`
                  WHERE
                  system_supplier_details.supplier_status = 1";
        $option = '';
        $option .= '<option value="0">Select supplier</option>';
        $result = $app->basic_Select_Query($query);
        foreach ($result AS $x) {
            $option .= '<option value=' . $x['supplier_id'] . '>' . $x['supplier_name'] . '</option>';
        }
        echo $option;
    } elseif ($_POST['action'] == 'load_items') {
        $query = "SELECT
                  CONCAT_WS(' - ',item_code,item_name) AS item_details,
                  system_item_details.item_id
                  FROM
                  system_item_details
                  WHERE
                  system_item_details.item_status = 1";
        $option = '';
        $option .= '<option value="0">Select Item</option>';
        $result = $app->basic_Select_Query($query);
        foreach ($result AS $x) {
            $option .= '<option value=' . $x['item_id'] . '>' . $x['item_details'] . '</option>';
        }
        echo $option;
    } elseif ($_POST['action'] == 'add_grn_item') {
        $unit_cost = $_POST['grn_total_cost'] / $_POST['grn_added_quty'];
        $query = "INSERT INTO `system_grn_item_details` "
                . "( `grn_number`, `grn_item_id`, `grn_added_qty`, `grn_avilable_qty`, `grn_total_cost_price`, `grn_unit_cost` ) "
                . "VALUES "
                . "( '{$_POST['grn_number']}', '{$_POST['grn_item_id']}', '{$_POST['grn_added_quty']}', '{$_POST['grn_added_quty']}', '{$_POST['grn_total_cost']}', '{$unit_cost}' );";
        $result = $app->basic_command_query($query);
        if ($result) {
            $q2 = "INSERT INTO `systemMainStock` (
	`itmID`,
	`avalQty`,
	`lastUpdateQty`,
	`lastUpdateDate`,
	`lastUpdateUserID`)
        VALUES
	('{$_POST['grn_item_id']}','{$_POST['grn_added_quty']}','{$_POST['grn_added_quty']}',NOW(),'{$_SESSION['u_id']}') "
                    . "ON DUPLICATE KEY UPDATE "
                    . "`avalQty` = `avalQty`+ '{$_POST['grn_added_quty']}', `lastUpdateQty`='{$_POST['grn_added_quty']}',`lastUpdateDate`=NOW(),`lastUpdateUserID`='{$_SESSION['u_id']}';";
            $app->basic_command_query($q2);
            echo 1;
        } else {
            echo 0;
        }
    } elseif ($_POST['action'] == 'load_grn_final_total') {
        $query = "SELECT
                  SUM(system_grn_item_details.grn_total_cost_price) AS total_amount
                  FROM `system_grn_item_details`
                  WHERE
                  system_grn_item_details.grn_number = '{$_POST['grn_number']}';";
        $result = $app->basic_Select_Query($query);
        echo $total_amunt = $result[0]['total_amount'];
    } elseif ($_POST['action'] == 'added_items_load') {
        $query = "SELECT
                  CONCAT_WS('-',item_name,item_code) AS item_details,
                  system_grn_item_details.grn_item_tblid,
                  system_grn_item_details.grn_added_qty,
                  system_grn_item_details.grn_total_cost_price
                  FROM
                  system_grn_item_details
                  INNER JOIN system_item_details ON system_grn_item_details.grn_item_id = system_item_details.item_id
                  WHERE
                  system_grn_item_details.grn_number = '{$_POST['grn_number']}' AND
                  system_grn_item_details.grn_item_status = 1 
                  ORDER BY
                  system_grn_item_details.grn_item_tblid DESC";
        $app->json_encoded_select_query($query);
    } elseif ($_POST['action'] == 'finish_grn') {
        $query = "INSERT INTO `system_grn_details` ( `grn_date`, `grn_supplier_id`, `grn_total_amount`, `grn_paid_amount`, `grn_balance_amount`, `grn_added_user_id` ) "
                . "VALUES "
                . "( '{$_POST['grn_date']}', '{$_POST['supplier']}', '{$_POST['grn_final_total']}', '0.00', '{$_POST['grn_final_total']}', '{$_SESSION['u_id']}' );";
        $result = $app->basic_command_query($query);
        if ($result) {
            echo 1;
        } else {
            echo 0;
        }
    } elseif ($_POST['action'] == 'delete_grn_details') {
        $query = "DELETE FROM `system_grn_item_details` WHERE (`grn_item_tblid`='{$_POST['grn_item_tblid']}')";
        $result = $app->basic_command_query($query);
        if ($result) {
            echo 1;
        } else {
            echo 0;
        }
    } elseif ($_POST['action'] == 'check_added_item_count') {
        $query = "SELECT
                system_grn_item_details.grn_item_tblid
                FROM `system_grn_item_details`
                WHERE
                system_grn_item_details.grn_number = '{$_POST['grn_no']}'";
        $count = $app->row_count_quary($query);
        if ($count == 0) {
            echo 0;
        } else {
            echo 1;
        }
    }
}    