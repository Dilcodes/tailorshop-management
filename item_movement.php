<?php
// Include the required PHP file that contains common functions
require_once './others/class/comm_functions.php';
// Create an instance of the setting class
$app = new setting();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
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
                <!-- Sidebar -->
                <?php
                require_once './others/sub_pages/side_bar.php';
                ?>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <div class="card card-info" style="background-color: lightgrey">
                    <div class="card-header">
                        <h3 class="card-title">Item Movement</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <hr>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label"><b>Select Item :</b></label>
                                <div class="col-sm-9">
                                    <select type="text" class="form-control" id="select_item"></select>
                                    <!-- <select type="text" class="form-control chosen" id="select_item"></select> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-5 text-center">
                            <h5><b>Stock Update Summery</b></h5>
                            <hr> 
                            <select type="text" class="form-control" id="stock_update_summery" multiple="" style="height: 350px; background-color: paleturquoise;"></select>
                        </div>

                        <div class="col-md-2" style="padding-top: 80px;  background-color: palegreen; margin-top: 60px">
                            <span><b>Selected Item :</b> </span><span id="selected_item"></span><br>
                            <hr>
                            <span style="font-weight: bold;">All Updated Quantity : </span><span id="all_update_qty"></span><br>
                            <hr>
                            <span style="font-weight: bold;">All Issue Quantity : </span><span id="all_issue_qty"></span><br>
                            <hr>
                            <span style="font-weight: bold;">Available Quantity : </span><span id="avialable_qty"></span>
                        </div>
                        <div class="col-md-5 text-center">
                            <h5><b>Item Issue Summery</b></h5>
                            <hr>
                            <select type="text" class="form-control" id="issue_details" multiple="" style="height: 350px; background-color: paleturquoise;"></select>
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

<script type="text/javascript" src="./controller/item_movement_controller.js"></script>
