<?php
// Include the required PHP file that contains common functions
require_once './others/class/comm_functions.php';
// Create an instance of the setting class
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
                        <h3 class="card-title">Supplier Payments</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="row">
                        <div class="col-md-6">
                            <!-- form start -->
                            <form class="form-horizontal">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Select Supplier</label>
                                        <div class="col-sm-9">
                                            <select class="form-control chosen" id="supplier"></select>                                        
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-3 col-form-label">Select GRN</label>
                                        <div class="col-sm-9">
                                            <select multiple="" class="form-control" id="grn" style="height: 150px"></select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-3 col-form-label"></label>
                                        <div class="col-sm-9">
                                            <button class="btn btn-dark col-sm-12" id="add_grn" type="button">Add GRN</button>
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-3 col-form-label">Selected GRN</label>
                                        <div class="col-sm-9">
                                            <select multiple="" class="form-control" style="height: 150px" id="selected_grn"></select>
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-3 col-form-label">Total Payable Amount</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="tot_amount">
                                        </div>
                                    </div>

                                    <!-- /.card-footer -->
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <form class="form-horizontal">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-3 col-form-label">Pay Types</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" id="pay_type">
                                            <option value="1">Cash</option>
                                            <option value="2">Cheque</option>
                                            <option value="3">Bank Transfer</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="check_Ref_section" class="d-none">
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-3 col-form-label">Cheque Number </label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="cheque_number">
                                        </div>
                                    </div>
                                    <div class="form-group row" >
                                        <label for="inputPassword3" class="col-sm-3 col-form-label">Cheque Date</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="cheque_date">
                                        </div>
                                    </div>
                                </div>
                                <div id="bank_Ref_section" class="d-none">
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-3 col-form-label">Reference Number </label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="ref_number">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="button" class="btn btn-default" id="reset">Reset</button>
                                <button type="button" class="btn btn-primary float-right" id="add_payment">Add Payment</button>
                            </div>
                    </div>
                    </form>
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
    <script type="text/javascript" src="./controller/supplier_payments_controller.js"></script>
</body>
</html>
