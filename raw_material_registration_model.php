<?php

require_once '../others/class/comm_functions.php';
$app = new setting();

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'add_new_category') {
        $category = $app->real_escape_string($_POST['category']);
        $query = "INSERT INTO `item_category` ( `item_category_name`, `item_category_type` ) VALUES ('{$_POST['category']}', '{$_POST['type']}');";
        $result = $app->basic_command_query($query);
        if ($result) {
            echo 1;
        } else {
            echo 0;
        }
    } elseif ($_POST['action'] == 'load_categories') {
        $query = "SELECT
                  item_category.item_category_id,
                  item_category.item_category_name
                  FROM `item_category`
                  WHERE
                  item_category.item_category_type = '{$_POST['type']}' 
                  ORDER BY
                  item_category.item_category_id DESC";
        $option = "<option value='0' selected>Select Category</option>'";
        $result = $app->basic_Select_Query($query);
        foreach ($result AS $x) {
            if ($_POST['selected'] == $x['item_category_id']) {
                $option .= '<option value=' . $x['item_category_id'] . ' selected="">' . $x['item_category_name'] . '</option>';
            } else {
                $option .= '<option value=' . $x['item_category_id'] . '>' . $x['item_category_name'] . '</option>';
            }
        }
        echo $option;
    } elseif ($_POST['action'] == 'add_new_measurement') {
        $query = "INSERT INTO `measurement_units` (`measure_unit_name`, `measure_unit_type`) VALUES ('{$_POST['unit']}', '{$_POST['type']}');";
        $result = $app->basic_command_query($query);
        if ($result) {
            echo 1;
        } else {
            echo 0;
        }
    } elseif ($_POST['action'] == 'load_units') {
        $query = "SELECT
                  measurement_units.measure_unit_id,
                  measurement_units.measure_unit_name
                  FROM
                  measurement_units
                  WHERE
                  measurement_units.measure_unit_type = '{$_POST['type']}' ORDER BY
                  measurement_units.measure_unit_id DESC";
        $option = '<option value="0" selected="">Select Measurement Unit</option>';
        $result = $app->basic_Select_Query($query);
        foreach ($result AS $x) {
            if ($_POST['selected'] == $x['measure_unit_id']) {
                $option .= '<option value=' . $x['measure_unit_id'] . ' selected="">' . $x['measure_unit_name'] . '</option>';
            } else {
                $option .= '<option value=' . $x['measure_unit_id'] . '>' . $x['measure_unit_name'] . '</option>';
            }
        }
        echo $option;
    } elseif ($_POST['action'] == 'save_raw_material_details') {
        $query = "INSERT INTO `system_item_details` "
                . "( `item_category_id`, `item_code`, `item_name`, `item_description`, `item_messure`, `item_reorder_level` ) "
                . "VALUES "
                . "( '{$_POST['category']}', '{$_POST['material_code']}', '{$_POST['name']}', '{$_POST['description']}', '{$_POST['unit_type']}', '{$_POST['reorder_level']}' );";
        $result = $app->basic_command_query($query);
        if ($result) {
            echo 1;
        } else {
            echo 0;
        }
    } elseif ($_POST['action'] == 'load_raw_material_details_table') {
        $query = "SELECT
                  CONCAT_WS('-',system_item_details.item_code,item_category.item_category_name,system_item_details.item_name) AS m_details,
                  measurement_units.measure_unit_name,
                  system_item_details.item_reorder_level,
                  system_item_details.item_id
                  FROM
                  system_item_details
                  INNER JOIN measurement_units ON system_item_details.item_messure = measurement_units.measure_unit_id
                  INNER JOIN item_category ON item_category.item_category_id = system_item_details.item_category_id
                  WHERE
                  (system_item_details.item_code LIKE '{$_POST['search']}%' OR
                  system_item_details.item_name LIKE '{$_POST['search']}%' OR
                  item_category.item_category_name LIKE '{$_POST['search']}%' OR
                  measurement_units.measure_unit_name LIKE '{$_POST['search']}%' OR
                  system_item_details.item_reorder_level LIKE '{$_POST['search']}%') AND
                  system_item_details.item_status = 1
                  ORDER BY
                  system_item_details.item_id DESC LIMIT 15";
        $result = $app->json_encoded_select_query($query);
    } elseif ($_POST['action'] == 'get_raw_material_details_for_update') {
        $query = "SELECT
                  item_category.item_category_type,
                  system_item_details.item_category_id,
                  system_item_details.item_code,
                  system_item_details.item_name,
                  system_item_details.item_description,
                  system_item_details.item_messure,
                  system_item_details.item_reorder_level
                  FROM
                  system_item_details
                  INNER JOIN item_category ON system_item_details.item_category_id = item_category.item_category_id
                  WHERE
                  system_item_details.item_id = '{$_POST['item_id']}'";
        $result = $app->json_encoded_select_query($query);
    } elseif ($_POST['action'] == 'update_raw_material_details') {
        $query = "UPDATE "
                . "`system_item_details` SET `item_category_id` = '{$_POST['category']}', `item_code` = '{$_POST['material_code']}', `item_name` = '{$_POST['name']}', `item_description` = '{$_POST['description']}', `item_messure` = '{$_POST['unit_type']}', `item_reorder_level` = '{$_POST['reorder_level']}' "
                . "WHERE "
                . "(`item_id` = '{$_POST['item_id']}');";
        $result = $app->basic_command_query($query);
        if ($result) {
            echo 1;
        } else {
            echo 0;
        }
    } elseif ($_POST['action'] == 'delete_raw_material_details') {
        $query = "UPDATE `system_item_details` SET `item_status`='0' WHERE (`item_id`='{$_POST['item_id']}')";
        $result = $app->basic_command_query($query);
        if ($result) {
            echo 1;
        } else {
            echo 0;
        }
    }
}