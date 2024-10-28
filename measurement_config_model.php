<?php

require_once '../others/class/comm_functions.php';
$app = new setting();

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'add_usage_details') {
        $q5 = "SELECT measurement_type_details.measurement_id AS nextID FROM measurement_type_details WHERE measurement_type_details.measurement_status = 0";
        $count = $app->row_count_quary($q5);
        if ($count == 1) {
            $newID = $app->basic_Select_Query($q5);
        } else {
            $q6 = "SELECT
                   IFNULL(MAX(measurement_type_details.measurement_id)+1,1) AS nextID
                   FROM `measurement_type_details`";
            $newID = $app->basic_Select_Query($q6);
            $q7 = "INSERT INTO `measurement_type_details` (`measurement_id`, `measurement_name`, `measurement_type`, `measurement_status`) VALUES ('{$newID[0]['nextID']}', '-', '-', '0')";
            $app->basic_command_query($q7);
        }

        if ($_POST['usage_define'] != 0) {
            $usage = $_POST['usage'];
            $unit = $_POST['units'];
        } else {
            $usage = 0;
            $unit = 0;
        }
        $_SESSION['newID'] = $newID[0]['nextID'];
        $query_2 = "INSERT INTO `item_usage_details` "
                . "( `usage_item_id`, `usage_material_id`, `usage_cus_selection`, `usage_define`, `usage_count`, `usage_count_unit` ) "
                . "VALUES "
                . "( '{$newID[0]['nextID']}', '{$_POST['material']}', '{$_POST['customer_selection']}', '{$_POST['usage_define']}', '{$usage}', '{$unit}' );";
        $result = $app->basic_command_query($query_2);
        if ($result) {
            echo 1;
        } else {
            echo 0;
        }
    } elseif ($_POST['action'] == 'load_configID') {
        $q5 = "SELECT measurement_type_details.measurement_id AS nextID FROM measurement_type_details WHERE measurement_type_details.measurement_status = 0";
        $count = $app->row_count_quary($q5);
        if ($count == 1) {
            $newID = $app->basic_Select_Query($q5);
        } else {
            $q6 = "SELECT
                   IFNULL(MAX(measurement_type_details.measurement_id)+1,1) AS nextID
                   FROM `measurement_type_details`";
            $newID = $app->basic_Select_Query($q6);
        }
        echo $newID[0]['nextID'];
    } elseif ($_POST['action'] == 'configuration_finish') {
//        ################################################################################
        $q2 = "SELECT
               item_usage_details.usage_table_id
               FROM `item_usage_details`
               WHERE
               item_usage_details.usage_item_id = '{$_SESSION['newID']}'";
        $count = $app->row_count_quary($q2);
        if ($count > 0) {
            $query = "UPDATE `measurement_type_details` SET `measurement_name`='{$_POST['item_name']}', `measurement_type`='{$_POST['config_data']}', `measurement_status`='1' WHERE (`measurement_id`='{$_SESSION['newID']}')";
            $result = $app->basic_command_query($query);
            if ($result) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            echo 10;
        }
    } elseif ($_POST['action'] == 'load_rawmaterials') {
        $query = "SELECT
               system_item_details.item_id,
               CONCAT_WS('-',system_item_details.item_code,system_item_details.item_name,item_category.item_category_name) AS metarial_details
               FROM
               system_item_details
               INNER JOIN item_category ON system_item_details.item_category_id = item_category.item_category_id
               WHERE
               item_category.item_category_type = 1";
        $option = '';
        $option .= '<option value="0">Select Material</option>';
        $result = $app->basic_Select_Query($query);
        foreach ($result AS $x) {
            $option .= '<option value=' . $x['item_id'] . '>' . $x['metarial_details'] . '</option>';
        }
        echo $option;
    } elseif ($_POST['action'] == 'load_units') {
        $query = "SELECT
                  measurement_units.measure_unit_id,
                  measurement_units.measure_unit_name
                  FROM
                  measurement_units
                  WHERE
                  measurement_units.measure_unit_type = '1' ORDER BY
                  measurement_units.measure_unit_id DESC";
        $option = '';
        $result = $app->basic_Select_Query($query);
        foreach ($result AS $x) {
            $option .= '<option value=' . $x['measure_unit_id'] . '>' . $x['measure_unit_name'] . '</option>';
        }
        echo $option;
    } elseif ($_POST['action'] == 'load_added_materials') {
        $query = "SELECT
                  CONCAT_WS(' - ',system_item_details.item_name,system_item_details.item_code) AS met_Details,
                  IF(item_usage_details.usage_cus_selection = 1, 'Yes', 'No') cusSelection,
                  IF(item_usage_details.usage_define = 1, 'Predefine', 'Custom Define') usageDefine,
                  CONCAT_WS(' - ',item_usage_details.usage_count,measurement_units.measure_unit_name) AS usageData,
                  item_usage_details.usage_table_id
                  FROM
                  item_usage_details
                  INNER JOIN system_item_details ON item_usage_details.usage_material_id = system_item_details.item_id
                  LEFT JOIN measurement_units ON item_usage_details.usage_count_unit = measurement_units.measure_unit_id
                  WHERE
                  item_usage_details.usage_item_id = '{$_POST['confID']}'";
        $data = $app->basic_Select_Query($query);
        $tblData = '';
        foreach ($data AS $x) {
            $tblData .= '<tr>';
            $tblData .= '<td>' . $x['met_Details'] . '</td>';
            $tblData .= '<td>' . $x['cusSelection'] . '</td>';
            $tblData .= '<td>' . $x['usageDefine'] . '</td>';
            $tblData .= '<td>' . $x['usageData'] . '</td>';
            $tblData .= '<td><button type="button" class="btn btn-danger remove" value="' . $x['usage_table_id'] . '">Remove</button></td>';
            $tblData .= '</tr>';
        }
        echo $tblData;
    } elseif ($_POST['action'] == 'remove_added_material') {
        $query = "DELETE FROM `item_usage_details` WHERE (`usage_table_id`='{$_POST['tbl_id']}')";
        $result = $app->basic_command_query($query);
        if ($result) {
            echo 1;
        } else {
            echo 0;
        }
    }
}