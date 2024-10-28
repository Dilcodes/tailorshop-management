<?php

require_once '../others/class/comm_functions.php';
$app = new setting();

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'save_customer_details') {
        $encryptedPassword = $app->password_encript($_POST['password']);
//        print_r($_POST);
        $query = "INSERT INTO `customer_details` "
                . "( `customer_fullname`, `customer_nic`, `customer_contact`, `customer_email`, `customer_address`, `customer_username`, `customer_password` ) "
                . "VALUES "
                . "( '{$_POST['fullname']}', '{$_POST['nic']}', '{$_POST['contact']}', '{$_POST['email']}', '{$_POST['address']}', '{$_POST['username']}', '{$encryptedPassword}' );";
        $result = $app->basic_command_query($query);
        if ($result) {
            echo 1;
        } else {
            echo 0;
        }
    } elseif ($_POST['action'] == 'load_customer_registration_details_table') {
        $query = "SELECT
                  CONCAT_WS('-',customer_fullname, customer_nic, customer_contact, customer_email, customer_address) AS cust_details,
                  customer_details.customer_id
                  FROM `customer_details`
                  WHERE
                  (customer_details.customer_fullname LIKE '{$_POST['search']}%' OR
                  customer_details.customer_nic LIKE '{$_POST['search']}%' OR
                  customer_details.customer_contact LIKE '{$_POST['search']}%' OR
                  customer_details.customer_email LIKE '{$_POST['search']}%' OR
                  customer_details.customer_address LIKE '{$_POST['search']}%') AND
                  customer_details.customer_status = 1
                  ORDER BY
                  customer_details.customer_id DESC";
        $result = $app->json_encoded_select_query($query);
    } elseif ($_POST['action'] == 'get_customer_details_for_update') {
        $query = "SELECT
                  customer_details.customer_fullname,
                  customer_details.customer_nic,
                  customer_details.customer_contact,
                  customer_details.customer_email,
                  customer_details.customer_address,
                  customer_details.customer_username,
                  customer_details.customer_password
                  FROM `customer_details`
                  WHERE
                  customer_details.customer_id = '{$_POST['customer_id']}'";
        $result = $app->json_encoded_select_query($query);
    } elseif ($_POST['action'] == 'update_customer_details') {
        $query = "UPDATE `customer_details` SET "
                . "`customer_fullname` = '{$_POST['fullname']}', `customer_nic` = '{$_POST['nic']}', `customer_contact` = '{$_POST['contact']}', `customer_email` = '{$_POST['email']}', `customer_address` = '{$_POST['address']}', `customer_username` = '{$_POST['username']}', `customer_password` = '{$_POST['password']}' "
                . "WHERE (`customer_id` = '{$_POST['sysId']}');";
        $result = $app->basic_command_query($query);
        if ($result) {
            echo 1;
        } else {
            echo 0;
        }
    } elseif ($_POST['action'] == 'delete_customer_details') {
        // $query = "UPDATE `customer_details` SET `customer_status`='0' WHERE (`customer_id` = '{$_POST['customer_id']}')";
        $q = "SELECT
                order_summery.order_id
                FROM
                order_summery
                INNER JOIN customer_details ON order_summery.customer_id = customer_details.customer_id
                WHERE
                order_summery.customer_id = '{$_POST['customer_id']}'";
        $count = $app->row_count_quary($q);
        if ($count == 0) {
            $query = "DELETE FROM `customer_details` WHERE (`customer_id`='{$_POST['customer_id']}')";
            $result = $app->basic_command_query($query);
            if ($result) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            echo 2;
        }
    } elseif ($_POST['action'] == 'check_username') {
        $query = "SELECT
                 customer_details.customer_id
                 FROM `customer_details`
                 WHERE
                 customer_details.customer_username = '{$_POST['username']}'";
        $count = $app->row_count_quary($query);
        if ($count == 1) {
            echo 1;
        } else {
            echo 0;
        }
    }
}



