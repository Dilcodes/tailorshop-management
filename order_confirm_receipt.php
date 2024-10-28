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
?>

<head>
    <style type="text/css">
        @media Print {
            .displayHide{
                display: none;
            }
        }

        th{
            padding: 1px;
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
                <span style="font-size: 15px;">Order Date : <?php echo $data[0]['order_added_date']; ?></span><br>
                <span style="font-size: 15px;">User : <?php echo $data[0]['system_user_fullname']; ?></span><br>
                <span style="font-size: 14px;">Customer : <?php echo $data[0]['cus_details']; ?></span><br>
            </th>
        </tr>
    </thead>
</table>
<table style="width: 9cm;" class="tbl_boder">
    <thead>
        <tr>
            <td style="text-align: left; padding-left: 5px;">Order Item</td>
            <td style="text-align: Right; padding: 5px;">Amount (Rs.)</td>
        </tr>
        <tr>
            <td style="text-align: left; padding-left: 5px;"><?php echo $data[0]['measurement_name']; ?></td>
            <td style="text-align: Right; padding: 5px;"><?php echo $data[0]['order_tot_amt']; ?></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;"> ***************** </td>
        </tr>
        <tr>
            <td style="text-align: left; padding-left: 5px;">Required Date</td>
            <td style="text-align: Right; padding: 5px;"><?php echo $data[0]['order_req_date']; ?></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;"> ***************************************** </td>
        </tr>
        <tr>
            <td style="text-align: left; padding-left: 5px;">Advanced Amount</td>
            <td style="text-align: Right; padding: 5px;"><?php echo $data[0]['order_advance_amt']; ?></td>
        </tr>
        <tr>
            <td style="text-align: left; padding-left: 5px;">Balance Amount</td>
            <td style="text-align: Right; padding: 5px;"><?php echo $data[0]['order_bal_amt']; ?></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center; padding : 5px;">Bill Note</td>
        </tr>
    </thead>
</table>

<table class="displayHide">
    <tr>
        <th><a href="./?location=new_order"><button type="button" style="background-color: #D9EDF7; width: 3cm; height: 1cm;" ><b>Back</b></button></a></th>
        <th><button type="button" onclick="window.print();" style="background-color: #D6E9C6; width: 3cm; height: 1cm;" ><b>Print Bill</b></button></th>
    </tr>
</table>

