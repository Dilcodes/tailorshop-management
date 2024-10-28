<?php

require_once '../others/class/comm_functions.php';
$app = new setting();

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'create_measurements_collect_form') {
        $item_id = $_POST['itemID'];
        $query = "SELECT
                measurement_type_details.measurement_type
                FROM `measurement_type_details`
                WHERE
                measurement_type_details.measurement_id = '{$item_id}'";
        $data = $app->basic_Select_Query($query);
        $measurements = $data[0]['measurement_type'];
        $x = explode('~', $measurements);
        $formData = '';
        $input = 1;
        foreach ($x AS $z) {
            $formData .= '<div class="form-group row">
                             <label for="' . $z . '" class="col-sm-3 col-form-label">' . $z . '</label>
                                <div class="col-sm-7">
                                  <input type="text" class="form-control mesurement_input" id="input_' . $input . '" data-type="' . $z . '" value="">
                                </div>
                                <div class="col-sm-2">
                                  <label class="col-sm-12 col-form-label">inches</label>
                                </div>
                          </div>';
            $input++;
        }
        $input = $input - 1;
        echo $formData . '~' . $input;
    } elseif ($_POST['action'] == 'finish_measurements') {
        $formData = $_POST['array'];
        // print_r($formData);
        foreach ($formData as $x) {
            $a = explode(':', $x);
            $query = "INSERT INTO `measurement_collect_details` "
                    . "( `order_number`, `measure_item_id`, `measure_type`, `measure_size` ) "
                    . "VALUES "
                    . "('{$_POST['order']}', '{$_POST['itemID']}', '{$a[0]}', '{$a[1]}');";
            $result = $app->basic_command_query($query);
        }
        $q2 = "UPDATE `order_summery` SET `order_status`='2' WHERE (`order_id`='{$_POST['order']}')";
        $result_2 = $app->basic_command_query($q2);
        if ($result_2) {
//==============================================================================   
            $q3 = "SELECT
                   order_summery.order_mat_id,
                   order_summery.order_mat_usege
                   FROM `order_summery`
                   WHERE
                   order_summery.order_id = '{$_POST['order']}'";
            $issueData = $app->basic_Select_Query($q3);
            foreach ($issueData AS $a) {
                $itmID = explode('~', $a['order_mat_id']);
                $itmIDCount = (count($itmID))-1;
                $usage = explode('~', $a['order_mat_usege']);
                for ($x = 0; $x <= $itmIDCount; $x++) {
                    $q4 = "UPDATE `systemmainstock` SET `avalQty`=`avalQty`-'{$usage[$x]}', `lastIssueQty`='{$usage[$x]}', `lastIssueDate`=NOW(), `lastIssueUserID`='{$_SESSION['u_id']}' WHERE (`itmID`='{$itmID[$x]}')";
                    $app->basic_command_query($q4);
                }
            }
//==============================================================================            
            echo 1;
        } else {
            echo 0;
        }
    }
}