<?php

require_once '../others/class/comm_functions.php';
$app = new setting();

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'load_items') {
        $query = "SELECT
                CONCAT_WS(' / ',system_item_details.item_code,system_item_details.item_name,item_category.item_category_name) AS item_details,
                system_item_details.item_id
                FROM
                system_item_details
                INNER JOIN item_category ON system_item_details.item_category_id = item_category.item_category_id
                WHERE
                system_item_details.item_status = 1";
        $data = $app->basic_Select_Query($query);
        $options = '<option value="0">Select Item</option>';
        foreach ($data AS $x) {
            $options .= '<option value="' . $x['item_id'] . '">' . $x['item_details'] . '</option>';
        }
        echo $options;
    } elseif ($_POST['action'] == 'load_stock_update_summery') {
        $query = "SELECT
                system_grn_item_details.grn_added_qty,
                system_grn_details.grn_added_sys_datetime
                FROM
                system_grn_item_details
                INNER JOIN system_grn_details ON system_grn_item_details.grn_number = system_grn_details.grn_number
                WHERE
                system_grn_item_details.grn_item_id = '{$_POST['itemID']}' AND
                system_grn_item_details.grn_item_status = 1";
        $data = $app->basic_Select_Query($query);
        $totUpdate = 0;
        $options = '';
        foreach ($data AS $x) {
            $totUpdate += $x['grn_added_qty'];
            $options .= '<option>Added QTY : ' . $x['grn_added_qty'] . ' / Added Date : ' . $x['grn_added_sys_datetime'] . '</option>';
        }
        echo $options . '~' . $totUpdate;
    } elseif ($_POST['action'] == 'load_item_issue_summery') {
        $query = "SELECT
                order_summery.order_mat_id,
                order_summery.order_mat_usege,
                order_summery.order_added_date,
                order_summery.order_id
                FROM `order_summery`
                WHERE
                order_summery.order_status = 3 OR
                order_summery.order_status = 2";     //status=3 finish 
        $data = $app->basic_Select_Query($query);
        $options = '';
        $matQty = 0;
        $totIssue = 0;
        foreach ($data AS $x) {
            $matID = explode('~', $x['order_mat_id']);
            $matUsage = explode('~', $x['order_mat_usege']);
            $index = 0;
            foreach ($matID AS $z) {
                if ($z == $_POST['itemID']) {
                    $matQty += $matUsage[$index];
                    $totIssue += $matUsage[$index];
                }
                $index++;
            }
            if ($matQty != 0) {
                $options .= '<option>Order No. : ' . $x['order_id'] . ' / Issue QTY : ' . $matQty . ' / Issue Date : ' . $x['order_added_date'] . '</option>';
                $matQty = 0;
            }
        }
        echo $options . '~' . $totIssue;
    }
}