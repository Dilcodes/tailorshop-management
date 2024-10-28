<?php

require_once '../others/class/comm_functions.php';
$app = new setting();

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'load_avilable_grns') {
        $query = "SELECT
                system_grn_details.grn_number,
                system_grn_details.grn_total_amount,
                system_grn_details.grn_date,
                system_grn_details.grn_balance_amount
                FROM `system_grn_details`
                WHERE
                system_grn_details.grn_supplier_id = '{$_POST['supplier_id']}' AND
                system_grn_details.grn_balance_amount != 0";
        $data = $app->basic_Select_Query($query);
        foreach ($data AS $x) {
            $options .= '<option value="' . $x['grn_number'] . '">GRN :' . $x['grn_number'] . ' / Date : ' . $x['grn_date'] . ' / Balance : ' . $x['grn_balance_amount'] . '</option>';
        }
        echo $options;
    } elseif ($_POST['action'] == 'add_grn_for_payments') {
        $selected_grns = $_POST['selected_grn'];
        foreach ($selected_grns AS $x) {
            $query = "INSERT INTO `selected_grn_for_supplier_payments` (`grn_id`) VALUES ('{$x}');";
            $app->basic_command_query($query);
        }
        echo 1;
    } elseif ($_POST['action'] == 'load_added_grn_for_payments') {
        $query = "SELECT
                  selected_grn_for_supplier_payments.grn_id,
                  system_grn_details.grn_date,
                  system_grn_details.grn_total_amount,
                  system_grn_details.grn_balance_amount
                  FROM
                  selected_grn_for_supplier_payments
                  INNER JOIN system_grn_details ON selected_grn_for_supplier_payments.grn_id = system_grn_details.grn_number";
        $data = $app->basic_Select_Query($query);
        $total_amount = 0;
        $addCount = 0;
        foreach ($data AS $x) {
            $total_amount += $x['grn_balance_amount'];
            $options .= '<option value="' . $x['grn_id'] . '" selected>GRN :' . $x['grn_id'] . ' / Date : ' . $x['grn_date'] . ' / Total : ' . $x['grn_total_amount'] . ' / Balance : ' . $x['grn_balance_amount'] . '</option>';
            $addCount++;
        }

        echo $options . '~' . $total_amount . '~' . $addCount;
    } elseif ($_POST['action'] == 'add_payment') {
        $grnNo = '';
        $a = 1;
        foreach ($_POST['selected_grn'] AS $x) {
            if ($a == 1) {
                $grnNo .= $x;
            } else {
                $grnNo .= '/' . $x;
            }
            $a++;
            if ($_POST['payGrnQnt'] == 1 && $_POST['balance'] != 0) {
                $q3 = "UPDATE `system_grn_details` SET `grn_paid_amount`=`grn_paid_amount`+'{$_POST['total_payable_amt']}', `grn_balance_amount`=`grn_balance_amount`-'{$_POST['total_payable_amt']}' WHERE (`grn_number`='{$x}')";
                $app->basic_command_query($q3);
            } else {
                $q4 = "UPDATE `system_grn_details` SET `grn_balance_amount`='0', `grn_status`='1' WHERE (`grn_number`='{$x}')";
                $app->basic_command_query($q4);
            }
        }
        $query = "INSERT INTO `supplier_payment_details` "
                . "( `sup_id`, `sup_payment_grn`, `sup_total_payment`, `sup_pay_type`, `cheque_number`, `cheque_date`, `reference_number`, `system_user` ) "
                . "VALUES "
                . "( '{$_POST['supplier_id']}', '{$grnNo}', '{$_POST['total_payable_amt']}', '{$_POST['pay_types']}', '{$_POST['cheque_number']}', '{$_POST['cheque_date']}', '{$_POST['reference']}', '{$_SESSION['u_id']}' );";
        $result = $app->basic_command_query($query);
        if ($result) {
            $q2 = "DELETE FROM `selected_grn_for_supplier_payments`";
            $app->basic_command_query($q2);
            echo 1;
        } else {
            echo 0;
        }
    } elseif ($_POST['action'] == 'clear_added_grn') {
        $query = "DELETE FROM `selected_grn_for_supplier_payments`";
        $app->basic_command_query($query);
    }
}
        