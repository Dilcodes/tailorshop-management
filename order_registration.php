<?php
require_once './others/class/comm_functions.php';
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
                        <h3 class="card-title">Add New Order</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="row">
                        <div class="col-md-6">
                            <!-- form start -->
                            <form class="form-horizontal">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Order ID</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="order_id" readonly="" style="font-size: 20px; font-weight: bold; text-align: center; background-color: #D1EDFF"> 
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="customer" class="col-sm-3 col-form-label">Customer <span class="text-danger"> *</span></label>  
                                        <div class="col-sm-6">
                                            <select class="form-control chosen" id="customer"> </select>
                                            <h6 style="color: red" id="customer_msg" class="d-none">This field is required</h6>
                                        </div>
                                        <div class="col-sm-3">
                                            <a type="button" href="./?location=cus_reg" class="btn btn-dark" id="add_new">Add New Customer</a>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="order_type" class="col-sm-3 col-form-label">Order Item <span class="text-danger"> *</span> </label> 
                                        <div class="col-sm-9">
                                            <select class="form-control" id="order_type"> </select>
                                            <h6 style="color: red" id="order_item_msg" class="d-none">This field is required</h6>
                                        </div>
                                    </div>
                                    <hr>
                                    <h6 style="color: green; text-align: right">*All Fabric Items Indicate <b>meters</b></h6>
                                    <hr>
                                    <div class="d-none" id="usageSection">
                                        <h5>Usage Details</h5>
                                        <div class="" id="di_content"></div>
                                    </div>
                                    <hr>

                                    <div class="form-group row">
                                        <label for="total_amt" class="col-sm-3 col-form-label">Total Amount <span class="text-danger"> *</span></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="total_amt"> 
                                            <h5 style="color: red" id="add_order_msg" class="d-none">Please Add Order Amount</h5>
                                            <h5 style="color: red" id="greater_than_raw_material" class="d-none">Total value Must Greater Than Raw Material Cost Price <span class="arrow">&rarr;</span></h5>
                                            <h6 style="color: red" id="Tot_amt_msg" class="d-none">This field is required</h6>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="advanced_amt" class="col-sm-3 col-form-label">Advanced Amount <span class="text-danger"> *</span></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="advanced_amt"> 
                                            <h6 style="color: red" id="advance_amt_message" class="d-none">Advanced amount must be less than Total amount & same or high material cost</h6>
                                            <h6 style="color: red" id="advanced_amt_msg" class="d-none">This field is required</h6>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-3 col-form-label">Balance Amount </label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="balance_amt" readonly=""> 
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-3 col-form-label">Required Date <span class="text-danger"> *</span></label>
                                        <div class="col-sm-6">
                                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                                <input class="form-control datepicker" data-target="#reservationdate"  value="" id="required_date"> 
                                                <div class="input-group-append">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                            <h6 style="color: red" id="required_date_msg" class="d-none">Please select a required date</h6>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="sampleImg" class="col-sm-3 col-form-label">Sample Image </label>
                                        <div class="col-sm-9">
                                            <input type="file" id="sampleImg">
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="button" class="btn btn-default" id="reset">Reset</button>
                                    <!-- then click 'Create Order' button generated a bill (view/order_confirm_receipt) -->
                                    <button type="button" class="btn btn-primary float-right" id="create_order">Create Order</button>
                                </div>
                                <!-- /.card-footer -->
                            </form>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <hr>
                                    <h5><u>Order Summery</u></h5>
                                    <hr>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <h6>Selected Item : <span id="selItem"></span></h6>
                                    <h6>Required Date : <span id="reqDate"></span></h6>
                                    <hr>
                                    <h6 class="text-primary" Raw Material Cost Price :  <span id="totRawCost"></span></h6>
                                    <button type="button" class="btn btn-outline-warning" id="cost_cal">Calculate Material Cost</button>
                                    <button class="btn btn-warning d-none" type="button" disabled id="loadinBtn">
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        Loading...
                                    </button>
                                    <hr>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-6">
                                    <img src="./others/images/sample.jpeg" class="img-fluid mb-2" alt="black sample" width="300" id="img_pre">
                                </div>
                                <div class="col-sm-3"></div>
                            </div>
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
        <input type="hidden" id="formFeleds" value="">
        <script type="text/javascript" src="./controller/order_registration_controller.js"></script>
    </body>
</html>
