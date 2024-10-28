<?php
// Importing necessary classes and functions
require_once './others/class/comm_functions.php';
// Creating an instance of the setting class
$app = new setting();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>OMS</title>
        <?php
        require_once './others/sub_pages/all_css.php';
        ?>
        <link rel="stylesheet" href="./others/css/bank_card.css">
    </head>
    <body class="hold-transition sidebar-mini">
        <!-- Site wrapper -->
        <div class="wrapper">
            <!-- Navbar -->
            <?php
            require_once './others/sub_pages/head.php';
            ?>
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <?php
                require_once './others/sub_pages/side_bar.php';
                ?>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Customer Payment</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-body">
                                <input type="text" class="form-control text-center" style="background-color: black; color: #FAFAFA; font-size: 22px;" placeholder="S E R C H    H E R E" id="search">
                                <table class="table table-bordered table-striped table-hover" id="finish_order_tbl">
                                    <thead class="table-success">
                                        <tr>
                                            <th>Order No.</th>
                                            <th>Name</th>
                                            <th>Contact</th>
                                            <th>Item</th>
                                            <th>Amount</th>
                                            <th>Advanced</th>
                                            <th>Balance</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                                <!-- form start -->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <form class="form-horizontal">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Total Amount</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" readonly="" id="total">
                                            <h6 style="color: red" id="Tot_amt_msg" class="d-none">This field is required, Select amount</h6>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-3 col-form-label">Advanced Amount</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" readonly="" id="advanced">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-3 col-form-label">Payable Amount</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" readonly="" style="background-color: black; color: greenyellow; font-size: 35px; font-weight: bold" id="pay">
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-footer -->
                            </form>
                        </div>
                        <div class="col-md-2"></div>
                        <div class="col-md-5">
                            <form class="form-horizontal">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Pay Type</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="payType">
                                                <option value="Cash">Cash</option>
                                                <option value="Card">Card</option>
                                            </select>
                                        </div>
                                        <h6 style="color: red" id="paytype_msg" class="d-none">This field is required</h6>

                                    </div>
                                    <div class="d-none" id="card-section">
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-3 col-form-label">Card Type</label>
                                            <div class="col-sm-9">
                                                <div class="paymentCont">
                                                    <div class="paymentWrap">
                                                        <div class="btn-group paymentBtnGroup btn-group-justified" data-toggle="buttons">
                                                            <label class="btn paymentMethod active" style="width: 60px;">
                                                                <div class="method visa"></div>
                                                                <input type="radio" value="visa" name="options" checked> 
                                                            </label>
                                                            <label class="btn paymentMethod">
                                                                <div class="method master-card"></div>
                                                                <input type="radio" value="master" name="options"> 
                                                            </label>
                                                        </div>        
                                                    </div>
                                                </div>   
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-3 col-form-label">Card Ref.</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="card_ref" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Received Amount</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="received" style="background-color: black; color: greenyellow; font-size: 35px; font-weight: bold">
                                            <h6 style="color: red" id="recAmt_check_msg" class="d-none">Received Amount Greater Than Balance Amount</h6>
                                            <h6 style="color: red" id="recAmtEmpty_check_msg" class="d-none">This field is required</h6>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-3 col-form-label">Balance Amount</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" readonly="" id="cus_balance" style="background-color: black; color: greenyellow; font-size: 35px; font-weight: bold">
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="button" class="btn btn-default" id="reset">Reset</button>
                                    <button type="button" class="btn btn-primary float-right" id="add_payment">Add Paymet</button>
                                </div>
                                <!-- /.card-footer -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content-wrapper -->

            <?php
            require_once './others/sub_pages/footer.php';
            ?>

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->
        </div>
        <!-- ./wrapper -->

        <?php
        require_once './others/sub_pages/all_js.php';
        ?>
        <script type="text/javascript" src="./controller/customer_payments_controller.js"></script>
    </body>
</html>
