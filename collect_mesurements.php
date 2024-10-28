

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
                        <h3 class="card-title">Collect Measurements</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="row">
                        
                        <div class="col-md-5">
                            <!-- form start -->
                            <form class="form-horizontal">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label" >Order Number</label>
                                        <div class="col-sm-9">
                                            <!-- This input field serves to present the order ID to users without allowing any alterations, enhancing the clarity and integrity of displayed information. -->
                                            <!-- Value: Dynamically populated using PHP, fetching the value of the "orderId" parameter from the URL. This enables the display of the corresponding order ID. -->
                                            <input type="text" class="form-control" id="order" readonly="" value="<?php echo $_GET['orderId']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-3 col-form-label">Item Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" readonly="" id="item" value="<?php echo $_GET['itmName']; ?>">
                                        </div>
                                    </div>
                                    <hr>
                                    <div id="dynSection"></div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    
                                    <button type="button" class="btn btn-dark" id="reset">Reset</button>
                                    <button type="button" class="btn btn-primary float-right" id="finish">Finish</button>
                                </div>
                                <!-- /.card-footer -->
                            </form>
                        </div>
                        
                        <div class="col-md-7">
                            <img src="./others/images/LogP5.JPG" width="100%">     
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
        <input type="hidden" id="formcount" value="">
        <input type="hidden" id="itemID" value="<?php echo $_GET['item']; ?>">
        <?php
        require_once './others/sub_pages/all_js.php';
        ?>

        <script type="text/javascript" src="./controller/collect_mesurements_controller.js"></script>

    </body>
</html>
