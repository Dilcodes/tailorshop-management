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
                        <h3 class="card-title">System Stock Summery</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="row">
                        <div class="col-md-12">
                            <hr>
                            <!--================================================================================================================-->
                            <div class="row">
                                <div class="col-md-6 text-center">
                                    &nbsp;&nbsp;
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="materials" value="1" checked="">
                                        <label class="form-check-label" for="materials">Raw Materials</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="tools" value="2">
                                        <label class="form-check-label" for="tools">Tools</label>
                                    </div>
                                </div>
                                <div class="col-md-6 text-center">
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-3 col-form-label">Category: </label>
                                        <div class="col-sm-6">
                                            <select class="form-control" id="category"></select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--==================================================================================================================================-->
                            <input type="text" class="form-control text-center" style="background-color: black; color: #FAFAFA; font-size: 22px;" placeholder="S E A R C H    H E R E" id="search">
                            <table class="table table-bordered table-striped table-hover" id="view_tbl">
                                <thead class="table-success">
                                    <tr>
                                        <th>#</th>
                                        <th>Item Category</th>
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th style="text-align: right; padding-right: 40px" id="reorder_th">Reorder Level</th>
                                        <th style="text-align: right; padding-right: 40px">Available QTY</th>
                                    </tr>

                                </thead>
                                <tbody></tbody>
                            </table>
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

        <script type="text/javascript" src="./controller/view_stock_controller.js"></script>
    </body>
</html>
