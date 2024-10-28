<?php

require_once '../others/class/comm_functions.php';
$app = new setting();

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'load_orders') {
        $q = "";
        if ($_POST['type'] == 10) {
            $q = "order_summery.order_assign_tailor_id = '{$_POST['tailor_id']}'";
        } else if ($_POST['type'] == 1) {
            $q = "order_summery.order_status != '0'";
        } else {
            $q = "order_summery.order_status = '0'";
        }
        $tbl_data = '';
        $query = "SELECT
                  CONCAT_WS('~',customer_details.customer_fullname,customer_details.customer_nic) AS cus_detail,
                  order_summery.order_id,
                  order_summery.order_added_date,
                  measurement_type_details.measurement_name,
                  order_summery.order_req_date,
                  order_summery.order_status,
                  IF(order_status='0','Pending', if(order_status='1', 'Assigned', if(order_status='2', 'Mesurement Collected', if(order_status='3', 'Finished', if(order_status='4', 'Delivered', 'Canceled'))))) AS ord_staus
                  FROM
                  order_summery
                  INNER JOIN customer_details ON order_summery.customer_id = customer_details.customer_id
                  INNER JOIN measurement_type_details ON order_summery.order_type = measurement_type_details.measurement_id
                  WHERE " . $q . " ORDER BY
                  order_summery.order_req_date ASC";
        
        
        $data = $app->basic_Select_Query($query);
        $index = 1;
        foreach ($data AS $x) {
            $tbl_data .= '<tr>';
            $tbl_data .= '<td>' . $index . '</td>';
            $tbl_data .= '<td>' . $x['cus_detail'] . '</td>';
            $tbl_data .= '<td>' . $x['measurement_name'] . '</td>';
            $tbl_data .= '<td>' . $x['order_added_date'] . '</td>';
            $tbl_data .= '<td>' . $x['order_req_date'] . '</td>';
            $tbl_data .= '<td>' . $x['ord_staus'] . '</td>';
            if ($x['order_status'] == 0) {
                $tbl_data .= '<td><button type="button" class="btn btn-primary selectorder" value="' . $x['order_id'] . '" data-toggle="modal" data-target="#assignTailorModel">Assign to Tailer</button></td>';
            } else {
                $tbl_data .= '<td>-</td>';
            }
            $tbl_data .= '</tr>';

            $index++;
        }
        echo $tbl_data;
    } elseif ($_POST['action'] == 'load_tailors') {
        $options = '<option value="99">Select Tailor</option>';
        $query = "SELECT
                 CONCAT_WS('/',tailor_fullname,tailor_nic,tailor_contact) AS tai_detail,
                 tailor_details.tailor_id
                 FROM `tailor_details`
                 WHERE
                 tailor_details.tailor_status = 1";
        $data = $app->basic_Select_Query($query);
        foreach ($data AS $x) {
            $options .= '<option value="' . $x['tailor_id'] . '">' . $x['tai_detail'] . '</option>';
        }
        echo $options;
    } elseif ($_POST['action'] == 'assign_order_to_tailor') {
        $query = "UPDATE `order_summery` SET `order_assign_tailor_id`='{$_POST['tailor_id']}', `order_status` = 1 WHERE (`order_id`='{$_POST['order_id']}')";
        $result = $app->basic_command_query($query);
        if ($result) {
            echo 1;
        } else {
            echo 0;
        }
    }
}