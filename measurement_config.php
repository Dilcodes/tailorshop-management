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
                        <h3 class="card-title"> Measurement & Usage Configuration</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="row">
                        <div class="col-md-5">
                            <!-- form start -->
                            <form class="form-horizontal">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Config ID</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control text-center" id="confID" readonly="" style="color: green; font-size: 22px; font-weight: bold">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Garment Item</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="item_name">
                                            <h6 style="color: red" id="garment_msg" class="d-none">This field is required</h6>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-3 col-form-label">Measurement</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="measurement">
                                            <h6 style="color: red" id="measurement_msg" class="d-none">This field is required</h6>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <button type="button" class="btn btn-info float-right" id="add">Add Measurement</button>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <h6><u>Material Usage</u></h6>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Material</label>
                                        <div class="col-sm-9">
                                            <select type="text" class="form-control" id="material"></select>
                                            <h6 style="color: red" id="material_msg" class="d-none">This field is required</h6>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-5 col-form-label">Customer selection</label>
                                        <div class="col-sm-7">
                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="cus_selection" value="1">Yes
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="cus_selection" checked="" value="0">No 
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-5 col-form-label">Usage Define</label>
                                        <div class="col-sm-7">
                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="usage" checked="" id="preD" value="1">Predefine
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="usage" id="cusD" value="0">Custom Define
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row" id="usage_section">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Usage</label>
                                        <div class="col-sm-9">
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <input class="form-control" id="usage">
                                                    <h6 style="color: red" id="usage_msg" class="d-none">This field is required</h6>
                                                </div>
                                                <div class="col-md-3">
                                                    <select class="form-control" id="unit_type"></select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <button type="button" class="btn btn-info float-right" id="add_usage">Add Usage</button>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="button" class="btn btn-default" id="reset">Reset</button>
                                    <button type="button" class="btn btn-success float-right" id="finish">Finish Configuration</button>
                                </div>
                                <!-- /.card-footer -->
                            </form>
                        </div>

                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <br>
                                    <h6>Added Measurements</h6>
                                    <hr>
                                    <table class="table table-bordered table-striped table-hover" id="config_tbl">
                                        <thead class="table-success">
                                            <tr>
                                                <th>Measurements</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <h6>Added Material Usage</h6>
                                    <hr>
                                    <table class="table table-bordered table-striped table-hover" id="usage_table">
                                        <thead class="table-success">
                                            <tr>
                                                <th>Material</th>
                                                <th>Customer Selection</th>
                                                <th>Usage Define</th>
                                                <th>Usage</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                    <h6 style="color: red" id="material_tbl_msg" class="d-none">Please Add Materials for this Configuration</h6>
                                </div>
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

        <script type="text/javascript" src="./controller/measurement_config_controller.js"></script>

    </body>
</html>
