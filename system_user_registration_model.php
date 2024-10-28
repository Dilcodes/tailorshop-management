<?php
// Include the common functions file
require_once '../others/class/comm_functions.php';
// Create a new instance of the 'setting' class
$app = new setting();

// Check if the 'action' key exists in the POST request
if (isset($_POST['action'])) {
    if ($_POST['action'] == 'save_system_user_details') {  // Check if the action is to save system user details
        $encryptedPassword = $app->password_encript($_POST['password']);  //Encrypt the password
//        print_r($_POST);
        // Prepare the SQL query to insert user details into the database
        $query = "INSERT INTO `system_user_details` "
                . "( `system_user_fullname`, `system_user_nic`, `system_user_contact`, `system_user_email`, `system_user_address`, `system_user_username`, `system_user_password` ) "
                . "VALUES "
                . "( '{$_POST['fullname']}', '{$_POST['nic']}', '{$_POST['contact']}', '{$_POST['email']}', '{$_POST['address']}', '{$_POST['username']}', '{$encryptedPassword}' );";
        $result = $app->basic_command_query($query);  //Execute the query
        if ($result) { // Check if the query execution was successful
            echo 1;
        } else {
            echo 0;
        }
    } elseif ($_POST['action'] == 'load_system_user_registration_details_table') {  // Check if the action is to load the user registration details table
        // Prepare the SQL query to select user details based on the search term
        $query = "SELECT
                  CONCAT_WS('-',system_user_fullname,system_user_nic, system_user_contact, system_user_email, system_user_address) AS Sys_uder_details,
                  system_user_details.system_user_id
                  FROM
                  system_user_details
                  WHERE
                  system_user_details.system_user_status = 1 AND
                  (system_user_details.system_user_fullname LIKE '{$_POST['search']}%' OR
                  system_user_details.system_user_nic LIKE '{$_POST['search']}%' OR
                  system_user_details.system_user_contact LIKE '{$_POST['search']}%' OR
                  system_user_details.system_user_email LIKE '{$_POST['search']}%' OR
                  system_user_details.system_user_address LIKE '{$_POST['search']}%') ORDER BY
                  system_user_details.system_user_id DESC";
        $result = $app->json_encoded_select_query($query);   // Execute the query and encode the result in JSON format
    } elseif ($_POST['action'] == 'get_System_user_details_for_update') {
        $query = "SELECT
                  system_user_details.system_user_fullname,
                  system_user_details.system_user_nic,
                  system_user_details.system_user_contact,
                  system_user_details.system_user_email,
                  system_user_details.system_user_address,
                  system_user_details.system_user_username,
                  system_user_details.system_user_password
                  FROM
                  system_user_details
                  WHERE
                  system_user_details.system_user_id = '{$_POST['system_user_id']}'";
        $result = $app->json_encoded_select_query($query);
    } elseif ($_POST['action'] == 'update_system_user_details') {
        $query = "UPDATE `system_user_details` SET "
                . "`system_user_fullname` = '{$_POST['fullname']}', `system_user_nic` = '{$_POST['nic']}', `system_user_contact` = '{$_POST['contact']}', `system_user_email` = '{$_POST['email']}', `system_user_address` = '{$_POST['address']}', `system_user_username` = '{$_POST['username']}' "
                . "WHERE (`system_user_id` = '{$_POST['sysId']}');";
        $result = $app->basic_command_query($query);
        if ($result) {
            echo 1;
        } else {
            echo 0;
        }
    } elseif ($_POST['action'] == 'delete_system_user_details') {
        $query = "UPDATE `system_user_details` SET `system_user_status`='0' WHERE (`system_user_id` = '{$_POST['system_user_id']}')";
        $result = $app->basic_command_query($query);
        if ($result) {
            echo 1;
        } else {
            echo 0;
        }
    } elseif ($_POST['action'] == 'check_username') {
        $query = "SELECT
                 system_user_details.system_user_id
                 FROM `system_user_details`
                 WHERE
                 system_user_details.system_user_username = '{$_POST['username']}'";
        $count = $app->row_count_quary($query);  // Execute the query and count the number of rows returned
        if ($count == 1) { // Check if the username exists
            echo 1; // Output that the username exists
        } else {
            echo 0; // Output that the username does not exists
        }
    }
}
