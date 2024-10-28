<?php

require_once '../others/class/comm_functions.php';
$app = new setting();

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'load_finish_orders') {
        $query = "SELECT
                order_summery.order_id,
                customer_details.customer_fullname,
                customer_details.customer_nic,
                customer_details.customer_contact,
                order_summery.order_tot_amt,
                order_summery.order_bal_amt,
                order_summery.order_advance_amt,
                measurement_type_details.measurement_name
                FROM
                order_summery
                INNER JOIN customer_details ON order_summery.customer_id = customer_details.customer_id
                INNER JOIN measurement_type_details ON order_summery.order_type = measurement_type_details.measurement_id
                WHERE
                order_summery.order_status = 3 AND
                (order_summery.order_id = '{$_POST['search']}' OR
                customer_details.customer_fullname LIKE '%{$_POST['search']}%' OR
                customer_details.customer_nic LIKE '{$_POST['search']}%' OR
                customer_details.customer_contact LIKE '{$_POST['search']}%')";
        $data = $app->basic_Select_Query($query);
        $tbl_data = '';
        $index = 1;
        foreach ($data AS $x) {
            $tbl_data .= '<tr>';
            $tbl_data .= '<td>' . $x['order_id'] . '</td>';
            $tbl_data .= '<td>' . $x['customer_fullname'] . '</td>';
            $tbl_data .= '<td>' . $x['customer_contact'] . '</td>';
            $tbl_data .= '<td>' . $x['measurement_name'] . '</td>';
            $tbl_data .= '<td>' . $x['order_tot_amt'] . '</td>';
            $tbl_data .= '<td>' . $x['order_advance_amt'] . '</td>';
            $tbl_data .= '<td>' . $x['order_bal_amt'] . '</td>';
            $tbl_data .= '<td> <button type="button" class="btn btn-primary float-right select" id="sel_' . $index . '" value="' . $x['order_tot_amt'] . '~' . $x['order_advance_amt'] . '~' . $x['order_bal_amt'] . '~' . $x['order_id'] . '">Select</button> </td>';
            $tbl_data .= '</tr>';
            $index++;
        }
        echo $tbl_data;
    } else if ($_POST['action'] == 'add_customer_payment') {
        $q1 = "INSERT INTO `customer_payment` "
                . "( `payment_order_id`, `payment_amount`, `payment_type`, `payment_mode`, `payment_card_type`, `payment_card_ref_details`,  `received_amount`, `customer_balance`,  `payment_system_user_id`) "
                . "VALUES "
                . "( '{$_POST['order_id']}', '{$_POST['payable_amt']}', '{$_POST['pay_type']}', 'Balance Payment', '{$_POST['card_type']}', '{$_POST['card_reference']}','{$_POST['received_amt']}', '{$_POST['balance_amt']}', '{$_SESSION['u_id']}' );";
        $result_1 = $app->basic_command_query($q1);
        if ($result_1) {
            $q2 = "UPDATE `order_summery` SET `order_bal_amt`=`order_bal_amt`-'{$_POST['payable_amt']}', `order_status` = '4' WHERE (`order_id`='{$_POST['order_id']}')";
            $app->basic_command_query($q2);
            echo 1;
        } else {
            echo 0;
        }
    }
}