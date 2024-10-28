<?php

require_once '../others/class/comm_functions.php';
$app = new setting();

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'load_expenses_categories') {
        $query = "SELECT
                expense_category.exp_category_id,
                expense_category.exp_category_name
                FROM `expense_category`
                WHERE
                expense_category.exp_category_staus = 1";
        $data = $app->basic_Select_Query($query);
        $options = "<option value='0'>Select Category</option>";
        foreach ($data AS $x) {
            $options .= "<option value='" . $x['exp_category_id'] . "'>" . $x['exp_category_name'] . "</option>";
        }
        echo $options;
    } else if ($_POST['action'] == 'add_expense_details') {
        $query = "INSERT INTO `expense_details` "
                . "( `exp_cat_id`, `exp_amount`, `exp_description`, `exp_issue_date`, `exp_added_sys_user` ) "
                . "VALUES "
                . "('{$_POST['category']}', '{$_POST['amount']}', '{$_POST['description']}', '{$_POST['date']}', '{$_SESSION['u_id']}');";
        $result = $app->basic_command_query($query);
        if ($result) {
            echo 1;
        } else {
            echo 0;
        }
    } else if ($_POST['action'] == 'load_added_expenses_details') {

        $query = "SELECT
                expense_details.exp_amount,
                expense_details.exp_id,
                expense_details.exp_description,
                expense_details.exp_issue_date ,
                DATE_FORMAT(exp_issue_date,'%Y-%m') AS month
                FROM `expense_details`
                WHERE
                expense_details.exp_cat_id = '{$_POST['category']}' AND 
                DATE_FORMAT(exp_issue_date,'%Y-%m') LIKE '{$_POST['month']}%' AND "
                . "(expense_details.exp_description LIKE '{$_POST['search']}%' OR "
                . "DATE_FORMAT(exp_issue_date,'%Y-%m-%d') LIKE '{$_POST['search']}%') AND expense_details.exp_details_status=1";

       
        $data = $app->basic_Select_Query($query);
        $tbl_data = "";
        foreach ($data AS $x) {
            $tbl_data .= "<tr>";
            $tbl_data .= "<td>" . $x['exp_amount'] . "</td>";
            $tbl_data .= "<td>" . $x['exp_description'] . "</td>";
            $tbl_data .= "<td>" . $x['exp_issue_date'] . "</td>";

            if (date('Y-m') == $x['month']) {
                $tbl_data .= "<td><button type='button' class='btn btn-danger delete' value='" . $x['exp_id'] . "'>Remove</button></td>";
            } else {
                $tbl_data .= "<td>-</td>";
            }

            $tbl_data .= "</tr>";
        }
        echo $tbl_data;
    } else if ($_POST['action'] == 'delete_expenses_details') {
        $query = "UPDATE `expense_details` SET `exp_details_status`='0' WHERE (`exp_id`='{$_POST['exp_id']}')";
        $result = $app->basic_command_query($query);
        if ($result) {
            echo 1;
        } else {
            echo 0;
        }
    }
}