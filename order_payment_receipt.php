<?php
// Include the required PHP file that contains common functions
require_once './others/class/comm_functions.php';
// Create an instance of the setting class
$app = new setting();


$order_id = $_GET['order_id'];

$query = "SELECT
CONCAT_WS(' / ',customer_details.customer_fullname,customer_details.customer_nic,customer_details.customer_contact) AS cus_details,
measurement_type_details.measurement_name,
order_summery.order_added_date,
system_user_details.system_user_fullname,
order_summery.order_req_date,
order_summery.order_advance_amt,
order_summery.order_tot_amt,
order_summery.order_bal_amt
FROM
order_summery
INNER JOIN customer_details ON order_summery.customer_id = customer_details.customer_id
INNER JOIN measurement_type_details ON order_summery.order_type = measurement_type_details.measurement_id
INNER JOIN system_user_details ON order_summery.order_added_user = system_user_details.system_user_id
WHERE
order_summery.order_id = '$order_id'";
$data = $app->basic_Select_Query($query);

$query2 = "SELECT
customer_payment.payment_amount,
customer_payment.payment_type,
customer_payment.payment_mode,
customer_payment.payment_date_time,
customer_payment.received_amount,
customer_payment.customer_balance,
system_user_details.system_user_fullname
FROM
customer_payment
INNER JOIN system_user_details ON customer_payment.payment_system_user_id = system_user_details.system_user_id
WHERE
customer_payment.payment_order_id = '$order_id'";
$payment = $app->basic_Select_Query($query2);
?>

<head>
    <style type="text/css">
        @media Print {
            .displayHide{
                display: none;
            }
        }

        th{
            padding: 2px;
            text-align: center;
        }

        td{
            text-align: center;
        }

        .tbl_boder{
            border: 1px double black;
            border-collapse: collapse;
        }

        table.tbl_boder td, table.tbl_boder th {
            border: 1px double black;
        }

        .page_brack{
            page-break-after: always;
        }

    </style>
</head>

<table style="width: 9cm;" class="tbl_boder">
    <thead>
        <tr>
            <th style="text-align: center">
                <span style="font-size: 25px;">Ajantha Tailors & Curtains</span><br>
                <span style="font-size: 18px;">Kuliyapitiya Road, Katupotha</span><br>
                <span style="font-size: 18px;">076 - 422 4762</span><br>
            </th>
        </tr>
    </thead>
</table>
<table style="width: 9cm;" class="tbl_boder">
    <thead>
        <tr>
            <th style="text-align: left; padding-left: 5px;">
                <span style="font-size: 15px;">Order No : <?php echo $order_id; ?></span><br>
                <span style="font-size: 14px;">Payment Date/Time : <?php echo $payment[0]['payment_date_time']; ?></span><br>
                <span style="font-size: 15px;">User : <?php echo $payment[0]['system_user_fullname']; ?></span><br>
                <span style="font-size: 14px;">Customer : <?php echo $data[0]['cus_details']; ?></span><br>
            </th>
        </tr>
    </thead>
</table>
<table style="width: 9cm;" class="tbl_boder">
    <thead>
        <tr>
            <th style="text-align: left; padding-left: 5px;">Order Item</th>
            <th style="text-align: Right; padding: 5px;">Amount (Rs.)</th>
        </tr>
        <tr>
            <td style="text-align: left; padding-left: 5px;"><?php echo $data[0]['measurement_name']; ?></td>
            <td style="text-align: Right; padding: 5px;"><?php echo $data[0]['order_tot_amt']; ?></td>
        </tr>
       
        <tr>
            <td colspan="2" style="text-align: center;">***************************</td>
        </tr>
        <tr>
            <td style="text-align: Right; padding-left: 5px;">Advanced Amount</td>
            <td style="text-align: Right; padding: 5px;"><?php echo $data[0]['order_advance_amt']; ?></td>
        </tr>
        <tr>
            <td style="text-align: Right; padding-left: 5px;">Pay Amount</td>
            <td style="text-align: Right; padding: 5px;"><?php echo $payment[0]['payment_amount']; ?></td>
        </tr>
        <tr>
            <td style="text-align: Right; padding-left: 5px;">Pay Type</td>
            <td style="text-align: Right; padding: 5px;"><?php echo $payment[0]['payment_type']; ?></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;">***************************</td>
        </tr>
        <tr>
            <td style="text-align: left; padding-left: 5px;">Received Amount</td>
            <td style="text-align: Right; padding: 5px;"><?php echo $payment[0]['received_amount']; ?></td>
        </tr>
        <tr>
            <td style="text-align: left; padding-left: 5px;">Customer Balance</td>
            <td style="text-align: Right; padding: 5px;"><?php echo $payment[0]['customer_balance']; ?></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center; padding : 5px;">Thank you Come Again...</td>
        </tr>
    </thead>
</table>

<table class="displayHide">
    <tr>
        <th><a href="./?location=cus_payments"><button type="button" style="background-color: #D9EDF7; width: 3cm; height: 1cm;" ><b>Back</b></button></a></th>
        <th><button type="button" onclick="window.print();" style="background-color: #D6E9C6; width: 3cm; height: 1cm;" ><b>Print Bill</b></button></th>
    </tr>
</table>

