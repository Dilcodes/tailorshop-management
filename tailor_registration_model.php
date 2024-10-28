<?php

require_once '../others/class/comm_functions.php';
$app = new setting();

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'save_tailor_details') {
        $encryptedPassword = $app->password_encript($_POST['password']);
//        print_r($_POST);
        $query = "INSERT INTO `tailor_details` "
                . "( `tailor_fullname`, `tailor_nic`, `tailor_gender`,`tailor_appointment_date`, `tailor_contact`, `tailor_email`, `tailor_address`, `tailor_user_name`, `tailor_password`, `tailor_add_user_id`) "
                . "VALUES "
                . "( '{$_POST['fullname']}', '{$_POST['nic']}', '{$_POST['gender']}', '{$_POST['appointment_date']}','{$_POST['contact']}', '{$_POST['email']}', '{$_POST['address']}', '{$_POST['username']}', '{$encryptedPassword}', '{$_SESSION['u_id']}');";
        $result = $app->basic_command_query($query);
        if ($result) {
            echo 1;
        } else {
            echo 0;
        }
    } elseif ($_POST['action'] == 'load_tailor_registration_details_table') {
        $query = "SELECT
                  CONCAT_WS('-',tailor_fullname,tailor_nic, tailor_gender, tailor_appointment_date, tailor_contact, tailor_email, tailor_address ) AS tailors_detail,
                  tailor_details.tailor_id
                  FROM `tailor_details`
                  WHERE
                  (tailor_details.tailor_fullname LIKE '{$_POST['search']}%' OR
                  tailor_details.tailor_nic LIKE '{$_POST['search']}%' OR
                  tailor_details.tailor_gender LIKE '{$_POST['search']}%' OR
                  tailor_details.tailor_appointment_date LIKE '{$_POST['search']}%' OR
                  tailor_details.tailor_contact LIKE '{$_POST['search']}%' OR
                  tailor_details.tailor_email LIKE '{$_POST['search']}%' OR
                  tailor_details.tailor_address LIKE '{$_POST['search']}%')AND
                  tailor_details.tailor_status = '1'
                  ORDER BY
                  tailor_details.tailor_id DESC";
        $result = $app->json_encoded_select_query($query);
    } elseif ($_POST['action'] == 'get_tailor_details_for_update') {
        $query = "SELECT
                  tailor_details.tailor_fullname,
                  tailor_details.tailor_nic,
                  tailor_details.tailor_gender,
                  tailor_details.tailor_appointment_date,
                  tailor_details.tailor_contact,
                  tailor_details.tailor_email,
                  tailor_details.tailor_address,
                  tailor_details.tailor_user_name,
                  tailor_details.tailor_password
                  FROM `tailor_details`
                  WHERE
                  tailor_details.tailor_id = '{$_POST['tailor_id']}'";
        $result = $app->json_encoded_select_query($query);
    } elseif ($_POST['action'] == 'update_tailor_details') {
        $query = "UPDATE `tailor_details` SET "
                . "`tailor_fullname` = '{$_POST['fullname']}', `tailor_nic` = '{$_POST['nic']}', `tailor_gender` = '{$_POST['gender']}', `tailor_appointment_date` = '{$_POST['appointment_date']}', `tailor_contact` = '{$_POST['contact']}', `tailor_email` = '{$_POST['email']}', `tailor_address` = '{$_POST['address']}' "
                . "WHERE (`tailor_id` = '{$_POST['sysId']}');";
        $result = $app->basic_command_query($query);
        if ($result) {
            echo 1;
        } else {
            echo 0;
        }
    } elseif ($_POST['action'] == 'delete_tailor_details') {
        $q = "SELECT
              order_summery.order_id
              FROM `order_summery`
              WHERE
              order_summery.order_assign_tailor_id = '{$_POST['tailor_id']}'";
        $count = $app->row_count_quary($q);
        if ($count == 0) {
            $query = "DELETE FROM `tailor_details` WHERE (`tailor_id`='{$_POST['tailor_id']}')";
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
                tailor_details.tailor_id
                FROM `tailor_details`
                WHERE
                tailor_details.tailor_user_name = '{$_POST['username']}'";
        $count = $app->row_count_quary($query);
        if ($count == 1) {
            echo 1;
        } else {
            echo 0;
        }
    }
}