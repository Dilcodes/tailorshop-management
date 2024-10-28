<?php

require_once '../others/class/comm_functions.php';
$app = new setting();

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'load_current_stock') {
        $sub_q = "";
        if ($_POST['cat_id'] != 0) {
            $sub_q = " AND system_item_details.item_category_id = '{$_POST['cat_id']}'";
        }
        $query = "SELECT
                  system_grn_item_details.grn_avilable_qty,
                  system_item_details.item_code,
                  system_item_details.item_name,
                  item_category.item_category_name,
                  system_item_details.item_reorder_level
                  FROM
                  system_grn_item_details
                  INNER JOIN system_item_details ON system_grn_item_details.grn_item_id = system_item_details.item_id
                  INNER JOIN item_category ON system_item_details.item_category_id = item_category.item_category_id
                  WHERE
                  system_grn_item_details.grn_avilable_qty > 0 AND
                  system_grn_item_details.grn_item_status = 1 AND
                  (system_item_details.item_code LIKE '%{$_POST['search']}%' OR
                  system_item_details.item_name LIKE '%{$_POST['search']}%' OR
                  item_category.item_category_name LIKE '{$_POST['search']}%') AND
                  item_category.item_category_type = '{$_POST['type']}'" . $sub_q;
        $app->json_encoded_select_query($query);
    } elseif ($_POST['action'] == 'load_item_category') {
        $options = '';
        $query = "SELECT
                  item_category.item_category_id,
                  item_category.item_category_name
                  FROM `item_category`
                  WHERE
                  item_category.item_category_type = '{$_POST['type']}'";
        $result = $app->basic_Select_Query($query);
        $options .= '<option value="0">All</option>';
        foreach ($result AS $x) {
            $options .= '<option value="' . $x['item_category_id'] . '">' . $x['item_category_name'] . '</option>';
        }
        echo $options;
    }
}    