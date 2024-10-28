<?php

require_once '../others/class/comm_functions.php';
$app = new setting();

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'load_assign_orders') {
/*
        $query = "SELECT
                CONCAT_WS('~',customer_details.customer_fullname,customer_details.customer_nic,customer_details.customer_contact) AS cus_details, 
                order_summery.order_id,
                measurement_type_details.measurement_name,
                order_summery.order_added_date,
                order_summery.order_req_date,
                order_summery.order_type,
                order_summery.order_status,
                order_summery.order_sample_image
                FROM
                order_summery
                INNER JOIN customer_details ON order_summery.customer_id = customer_details.customer_id
                INNER JOIN measurement_type_details ON order_summery.order_type = measurement_type_details.measurement_id
                WHERE
                order_summery.order_assign_tailor_id = '{$_SESSION['u_id']}' 
                ORDER BY
                order_summery.order_req_date ASC";
 */
        $query="SELECT
                CONCAT_WS('~',customer_details.customer_fullname,customer_details.customer_nic,customer_details.customer_contact) AS cus_details, 
                order_summery.order_id,
                measurement_type_details.measurement_name,
                order_summery.order_added_date,
                order_summery.order_req_date,
                order_summery.order_type,
                order_summery.order_status,
                order_summery.order_sample_image
                FROM
                order_summery
                INNER JOIN customer_details ON order_summery.customer_id = customer_details.customer_id
                INNER JOIN measurement_type_details ON order_summery.order_type = measurement_type_details.measurement_id
                WHERE
                order_summery.order_status != 4 AND
                order_summery.order_assign_tailor_id = '{$_SESSION['u_id']}' AND
                (customer_details.customer_fullname LIKE '%{$_POST['search']}%' OR
                customer_details.customer_nic LIKE '%{$_POST['search']}%' OR
                customer_details.customer_contact LIKE '%{$_POST['search']}%' OR
                measurement_type_details.measurement_name LIKE '%{$_POST['search']}%' OR
                order_summery.order_added_date LIKE '%{$_POST['search']}%' OR
                order_summery.order_req_date LIKE '%{$_POST['search']}%')
                ORDER BY
                order_summery.order_req_date ASC";
        
                
        $data = $app->basic_Select_Query($query);
        $tbl_data = '';
        $index = 1;
        foreach ($data AS $x) {
            $sample_button = '';
            if ($x['order_sample_image'] != '0') {
                $sample_button = '<button type="button" value="' . $x['order_sample_image'] . '" class="btn btn-dark view_smpl_img" data-toggle="modal" data-target="#sampleImgModel" >View Sample Image</button>';
            }

            $tbl_data .= '<tr>';
            $tbl_data .= '<td>' . $index . '</td>';
            $tbl_data .= '<td>' . $x['cus_details'] . '</td>';
            $tbl_data .= '<td>' . $x['measurement_name'] . '</td>';
            $tbl_data .= '<td>' . $x['order_added_date'] . '</td>';
            $tbl_data .= '<td>' . $x['order_req_date'] . '</td>';
            if ($x['order_status'] == 1) {
                $tbl_data .= '<td>Pending For Collect Measurement</td>';
                $tbl_data .= '<td><button type="button" class="btn btn-primary selectorder" value="' . $x['order_id'] . '~' . $x['order_type'] . '~' . $x['measurement_name'] . '" data-toggle="modal" data-target="#assignTailorModel">Start Collect Messurements</button>' . $sample_button . '</td>';
            } elseif ($x['order_status'] == 2) {
                $tbl_data .= '<td style="color:green">Measurement collected</td>';
                $tbl_data .= '<td><button type="button" value="' . $x['order_id'] . '" class="btn btn-success viewMes" data-toggle="modal" data-target="#mesViewModel">View Meaurements</button>' . $sample_button . '&nbsp';
                $tbl_data .= '<button type="button" value="' . $x['order_id'] . '" class="btn btn-danger finishOrder" data-toggle="modal" >Finish</button></td>';
            } elseif ($x['order_status'] == 3) {
                $tbl_data .= '<td style="color:green">Finish Sewing </td>';
            } elseif ($x['order_status'] == 4) {
                $tbl_data .= '<td style="color:green">Payment Collected </td>';
            } else {
                $tbl_data .= '<td style="color:red">Order Canceled</td>';
            }
            $tbl_data .= '</tr>';
            $index++;
        }
        echo $tbl_data;
    } elseif ($_POST['action'] == 'start_collect_messurement') {
        $query = "UPDATE `order_summery` SET `order_status`='2' WHERE (`order_id`='{$_POST['order_id']}')";
        $result = $app->basic_command_query($query);
        if ($result) {
            
            echo 1;
        } else {
            echo 0;
        }
    } elseif ($_POST['action'] == 'getCollectedMesDetails') {
        $query = "SELECT
                       measurement_collect_details.measure_collect_tbl_id,
                       measurement_collect_details.measure_type,
                       measurement_collect_details.measure_size,
                       measurement_type_details.measurement_name,
                       CONCAT_WS(' / ',customer_details.customer_fullname,customer_details.customer_nic,customer_details.customer_contact) AS cusDetails
                       FROM
                       measurement_collect_details
                       INNER JOIN measurement_type_details ON measurement_collect_details.measure_item_id = measurement_type_details.measurement_id
                       INNER JOIN order_summery ON measurement_collect_details.order_number = order_summery.order_id
                       INNER JOIN customer_details ON order_summery.customer_id = customer_details.customer_id
                  WHERE
                  measurement_collect_details.order_number = '{$_POST['orderID']}'";
        $data = $app->basic_Select_Query($query);
        $formData = '';
        $itmName = '';
        $cusName = '';
        foreach ($data AS $z) {
            $formData .= '<div class="form-group row">
                             <label class="col-sm-3 col-form-label">' . $z['measure_type'] . '</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" data-tblID="' . $z['measure_collect_tbl_id'] . '" value="' . $z['measure_size'] . '" readonly="">
                                </div>
                          </div>';
            $itmName = $z['measurement_name'];
            $cusName = $z['cusDetails'];
        }
        echo $formData . '~' . $itmName . '~' . $cusName;
    } elseif ($_POST['action'] == 'handle_finish_order') {
        $query = "UPDATE `order_summery` SET `order_status`='3' WHERE (`order_id`='{$_POST['orderID']}')";
        $result = $app->basic_command_query($query);
        if ($result) {
            $q2 = "SELECT
                   CONCAT_WS(' / ',customer_fullname,customer_nic) AS cusDetails,
                   customer_details.customer_contact,
                   measurement_type_details.measurement_name
                   FROM
                   order_summery
                   INNER JOIN customer_details ON order_summery.customer_id = customer_details.customer_id
                   INNER JOIN measurement_type_details ON order_summery.order_type = measurement_type_details.measurement_id
                   WHERE
                   order_summery.order_id = '{$_POST['orderID']}'";
            $cusData = $app->basic_Select_Query($q2);
            echo $cusData[0]['cusDetails'] . '~' . $cusData[0]['customer_contact'] . '~' . $cusData[0]['measurement_name'];
        } else {
            echo 0;
        }
    }
}