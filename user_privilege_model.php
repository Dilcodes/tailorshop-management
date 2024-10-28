<?php

require_once '../others/class/comm_functions.php';
$app = new setting();

if (isset($_POST['action'])) {  // Check if the 'action' is set in the POST request
    if ($_POST['action'] == 'load_user_selectbox') {  // If action is 'load_user_selectbox'
        // Query to load user details where status is active
        $query = "SELECT
                CONCAT_WS(' - ',system_user_fullname,system_user_nic,system_user_username) AS user_details,
                system_user_details.system_user_id
                FROM `system_user_details`
                WHERE
                system_user_details.system_user_status = 1";
        $result = $app->json_encoded_select_query($query);  // Execute the query and encode the result in JSON
    } elseif ($_POST['action'] == 'load_available_privileges') { // If action is 'load_available_privileges'
         // Query to load available privileges not assigned to the user
        $query = "SELECT
                 system_privilages.privilage_id,
                 system_privilages.privilage_name,
                 system_privilages.privilage_type
                 FROM `system_privilages`
                 WHERE
                 system_privilages.privilage_type != 0 AND
                 system_privilages.privilage_id NOT IN (SELECT
                 system_assigned_privilage.assigned_privilage_id
                 FROM `system_assigned_privilage`
                 WHERE
                 system_assigned_privilage.user_id = '{$_POST['userId']}')";
        $result = $app->json_encoded_select_query($query);
    } elseif ($_POST['action'] == 'load_assigned_privileges') {
         // Query to load privileges assigned to the user
        $query = "SELECT
                  system_assigned_privilage.assigned_privilage_id,
                  system_privilages.privilage_name
                  FROM
                  system_assigned_privilage
                  INNER JOIN system_privilages ON system_assigned_privilage.assigned_privilage_id = system_privilages.privilage_id
                  WHERE
                  system_assigned_privilage.user_id = {$_POST['userId']}";
        $result = $app->json_encoded_select_query($query);
    } elseif ($_POST['action'] == 'custom_add_privileges') {  // If action is 'custom_add_privileges'
        foreach ($_POST['selected_privilege'] AS $x) {
            $a = explode('~', $x);  // Split the privilege string
            $pr_id = $a[0];  // Get the privilege ID
            $main_id = $a[1]; // Get the main ID
            // Query to insert the selected privileges for the user
            $query = "INSERT INTO `system_assigned_privilage` (`user_id`, `assigned_privilage_id`, `privilage_main_id`) "
                    . "VALUES ('{$_POST['userId']}', '{$pr_id}', '{$main_id}');";
            $app->basic_command_query($query);
        }
        echo 1; //Return success response
    } elseif ($_POST['action'] == 'allprivileges_add') {
         // Query to select all privileges not assigned to the user
        $query = "SELECT
                 system_privilages.privilage_id,
                 system_privilages.privilage_name,
                 system_privilages.privilage_type
                 FROM `system_privilages`
                 WHERE
                 system_privilages.privilage_type != 0 AND
                 system_privilages.privilage_id NOT IN (SELECT
                 system_assigned_privilage.assigned_privilage_id
                 FROM `system_assigned_privilage`
                 WHERE
                 system_assigned_privilage.user_id = '{$_POST['userId']}')";
        $result = $app->basic_Select_Query($query);
        // Loop through the result and insert each privilege
        foreach ($result AS $x) {
            // Query to insert the privileges for the user
            $query = "INSERT INTO `system_assigned_privilage` (`user_id`, `assigned_privilage_id`, `privilage_main_id`) "
                    . "VALUES ('{$_POST['userId']}', '{$x['privilage_id']}', '{$x['privilage_type']}');";
            $app->basic_command_query($query);
        }
        echo 1;
    } elseif ($_POST['action'] == 'custom_remove_privileges') {
         // Loop through the selected privileges and delete them from the database
        foreach ($_POST['selected_privilege'] AS $x) {
            // Query to delete the selected privileges for the user
            $query = "DELETE FROM `system_assigned_privilage` WHERE (`user_id`='{$_POST['userId']}') AND (`assigned_privilage_id`='{$x}')";
            $app->basic_command_query($query);
        }
        echo 1;
    } elseif ($_POST['action'] == 'all_privileges_remove') {
        // Query to delete all privileges assigned to the user
        $query = "DELETE FROM `system_assigned_privilage` WHERE (`user_id`='{$_POST['userId']}')";
        $app->basic_command_query($query);
        echo 1;
    }
}