<?php

require_once '../others/class/comm_functions.php';
$app = new setting();

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'system_login') {
        $username = $_POST['username'];
        $password = $app->password_encript($_POST['password']);
        if ($_POST['logType'] == '1') {
            $query = "SELECT
                  system_user_details.system_user_fullname AS fname,
                  system_user_details.system_user_nic AS nic,
                  system_user_details.system_user_id AS u_id,
                  system_user_details.system_user_status AS status,
                  system_user_details.system_user_email AS email
                  FROM `system_user_details`
                  WHERE
                  system_user_details.system_user_password = '{$password}' AND
                  system_user_details.system_user_username = '{$username}'";
        } else {
            $query = "SELECT
                   tailor_details.tailor_id AS u_id,
                   tailor_details.tailor_fullname AS fname,
                   tailor_details.tailor_nic AS nic,
                   tailor_details.tailor_status AS status,
                   tailor_details.tailor_email AS email
                   FROM `tailor_details`
                   WHERE
                   tailor_details.tailor_user_name = '{$username}' AND
                   tailor_details.tailor_password = '{$password}'";
        }
        $count = $app->row_count_quary($query);
        if ($count == 1) {
            $data = $app->basic_Select_Query($query);
            if ($data[0]['status'] == 1) {
                $_SESSION['fname'] = $data[0]['fname'];
                $_SESSION['nic'] = $data[0]['nic'];
                $_SESSION['email'] = $data[0]['email'];
                $_SESSION['u_id'] = $data[0]['u_id'];
                $_SESSION['log_type'] = $_POST['logType'];
                echo 1;
            } elseif ($data[0]['status'] == 0) {
                echo 0;
            } else {
                echo 99;
            }
        } else {
            echo 2;
        }
    } else if ($_POST['action'] == 'system_logout') {
        unset($_SESSION['fname']);
        unset($_SESSION['nic']);
        unset($_SESSION['email']);
        unset($_SESSION['u_id']);
        unset($_SESSION['log_type']);
        echo 1;
    } else if ($_POST['action'] == 'change_password') {
        $password = $app->password_encript($_POST['old']);
        $newPassword = $app->password_encript($_POST['newPass']);
        if ($_SESSION['log_type'] == 1) {
            $q = "SELECT
              system_user_details.system_user_id
              FROM `system_user_details`
              WHERE
              system_user_details.system_user_id = '{$_SESSION['u_id']}' AND
              system_user_details.system_user_password = '{$password}'";
            $count = $app->row_count_quary($q);
            if ($count == 0) {
                echo 2;
            } else {
                $q2 = "UPDATE `system_user_details` SET `system_user_password`='{$newPassword}' WHERE (`system_user_id`='{$_SESSION['u_id']}')";
                $app->basic_command_query($q2);
                echo 1;
            }
        } else {
            $q = "SELECT
                  tailor_details.tailor_id
                  FROM `tailor_details`
                  WHERE
                  tailor_details.tailor_id = '{$_SESSION['u_id']}' AND
                  tailor_details.tailor_password = '{$password}'";
            $count = $app->row_count_quary($q);
            if ($count == 0) {
                echo 2;
            } else {
                $q2 = "UPDATE `tailor_details` SET `tailor_password`='{$newPassword}' WHERE (`tailor_id`='{$_SESSION['u_id']}')";
                $app->basic_command_query($q2);
                echo 1;
            }
        }
    }
}

    