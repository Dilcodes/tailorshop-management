<?php

require_once '../others/class/comm_functions.php';
$app = new setting();

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'get_system_summeries') {
        $q1 = "SELECT Count(customer_details.customer_id) AS cusCount FROM `customer_details` WHERE customer_details.customer_status = '1'";
        $q2 = "SELECT
             SUM((order_summery.order_tot_amt-order_summery.order_bal_amt)) AS received_amount
             FROM `order_summery`
             WHERE
             DATE_FORMAT(order_summery.order_added_date,'%Y-%m')  = DATE_FORMAT(CURDATE(),'%Y-%m')";
        $q3 = "";
        /*
        $q4 = "SELECT
             Count(order_summery.order_id) As active_order_counts
             FROM `order_summery`
             WHERE
             order_summery.order_bal_amt <> '0.00'";
        */
        //active orders=pending orders
        $q4 = "SELECT
             Count(order_summery.order_id) As active_order_counts   
             FROM `order_summery`
             WHERE
             order_summery.order_status = 0";
        $cusCount = $app->basic_Select_Query($q1);
        $receviwed_amt = $app->basic_Select_Query($q2);
//        $AAAA = $app->basic_Select_Query($q3);
        $active_orders = $app->basic_Select_Query($q4);

        echo $cusCount[0]['cusCount'] . '~' . $receviwed_amt[0]['received_amount'] . '~' . $active_orders[0]['active_order_counts'];
    } elseif ($_POST['action'] == 'load_ongoing_orders_to_tbl') {
        /*
        $query_1 = "SELECT
                    order_summery.order_id,
                    measurement_type_details.measurement_name,
                    IF(order_status=0,'Pending', IF(order_status=1,'Assigned', IF(order_status=2,'Measurement Collected', IF(order_status=3,'Finished', IF(order_status=4,'Payment Completed', IF(order_status=5,'Delivered', 'Canceled')))))) AS order_status,
                    order_summery.order_req_date
                    FROM
                    order_summery
                    INNER JOIN customer_details ON order_summery.customer_id = customer_details.customer_id
                    INNER JOIN measurement_type_details ON order_summery.order_type = measurement_type_details.measurement_id
                    WHERE
                    (order_summery.order_status = 1 OR order_summery.order_status = 2) AND
                    order_summery.order_req_date > CURDATE()
                    ORDER BY
                    order_summery.order_req_date ASC
                    LIMIT 7";
         */
         $query_1 = "SELECT
                    order_summery.order_id,
                    measurement_type_details.measurement_name,
                    IF(order_status=0,'Pending', IF(order_status=1,'Assigned', IF(order_status=2,'Measurement Collected', IF(order_status=3,'Finished', IF(order_status=4,'Payment Completed', IF(order_status=5,'Delivered', 'Canceled')))))) AS order_status,
                    order_summery.order_req_date
                    FROM
                    order_summery
                    INNER JOIN customer_details ON order_summery.customer_id = customer_details.customer_id
                    INNER JOIN measurement_type_details ON order_summery.order_type = measurement_type_details.measurement_id
                    WHERE
                    (order_summery.order_status = 1 OR order_summery.order_status = 2 )
                    ORDER BY
                    order_summery.order_req_date ASC
                    LIMIT 7";
        $data = $app->basic_Select_Query($query_1);
        $tbl_data = '';
        $index = 1;
        foreach ($data AS $x) {
            $tbl_data .= '<tr>';
            //$tbl_data .= '<td>' . $x['order_id'] . '</td>';
            $tbl_data .= '<td><a type="button" href="./?report=ongoing_order_summery">'.$x['order_id'].'</a></td>';
            $tbl_data .= '<td>' . $x['measurement_name'] . '</td>';
            $tbl_data .= '<td>' . $x['order_status'] . '</td>';
            $tbl_data .= '<td>' . $x['order_req_date'] . '</td>';
            //$tbl_data .= '<td> <button type="button" class="btn btn-primary float-right select" id="sel_' . $index . '" value="' . $x['order_tot_amt'] . '~' . $x['order_advance_amt'] . '~' . $x['order_bal_amt'] . '~' . $x['order_id'] . '">Select</button> </td>';
            $tbl_data .= '</tr>';
            $index++;
        }
        echo $tbl_data;
    }
}