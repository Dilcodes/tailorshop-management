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
                        <h3 class="card-title">New GRN</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="row">
                        <div class="col-md-6">
                            <!-- form start -->
                            <form class="form-horizontal">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">GRN No.</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control text-center" id="grn_no" style="font-weight: bold; background-color: greenyellow; font-size: 22px;" readonly="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-3 col-form-label">GRN Date</label>
                                        <div class="col-sm-9">
                                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                                <input type="text" class="form-control datepicker_grn" data-target="#reservationdate"  value="<?php echo date('Y-m-d'); ?>" id="grn_date">
                                                <div class="input-group-append">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div> 
                                            <h6 style="color: red" id="reservationdate_error" class="d-none">Date is required field</h6>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-3 col-form-label">GRN Supplier</label>
                                        <div class="col-sm-9">
                                            <select class="form-control chosen" id="grn_supplier"></select>
                                            <h6 style="color: red" id="grn_supplier_error" class="d-none">Please select a supplier</h6>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">GRN Item</label>
                                        <div class="col-sm-9">
                                            <select class="form-control chosen" id="grn_item"></select>
                                            <h6 style="color: red" id="grn_item_error" class="d-none">Please select an item</h6>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <form class="form-horizontal">
                                <div class="card-body">

                                    <div class="form-group row">
                                        <label for="quty" class="col-sm-3 col-form-label">Quantity</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="quty">
                                            <h6 style="color: red" id="add_quantity" class="d-none">Please Add Quantity</h6>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="total_cost" class="col-sm-3 col-form-label">Total Cost</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="total_cost">
                                            <h6 style="color: red" id="add_total_cost" class="d-none">Please Add Total Cost</h6>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="button" class="btn btn-default" id="reset">Reset</button>
                                    <button type="button" class="btn btn-primary float-right" id="add_item">Add Item</button>
                                </div>
                                <hr>
                                <div class="card-footer">
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-3 col-form-label">GRN Total</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control text-center" id="grn_total" style="background-color: #a0cfee; font-size: 24px; font-weight: bold" readonly="">
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-success float-right" id="finish">Finish GRN</button>
                                </div>
                                <!-- /.card-footer -->
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <hr>
                            <table class="table table-bordered table-striped table-hover" id="grn_added_itemtbl">
                                <thead class="table-success">
                                    <tr>
                                        <th>Item</th>
                                        <th>Added Qty</th>
                                        <th>Total Cost</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <h6 style="color: red" id="added_item_check" class="d-none">Please Add an item for this GRN</h6>
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
    </body>
</html>
<script type="text/javascript" src="./controller/grn_controller.js"></script>
