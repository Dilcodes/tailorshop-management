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
                        <h3 class="card-title">Assign Order To Tailor</h3>
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
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="pending" value="0" checked="">
                                        <label class="form-check-label" for="pending">Pending</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="assigned" value="2">
                                        <label class="form-check-label" for="assigned">Assigned</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="tailor_wise" value="99">
                                        <label class="form-check-label" for="tailor_wise">Tailor wise</label>
                                    </div>
                                </div>
                                <div class="col-md-6 text-center d-none" id="tailorSection">
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-3 col-form-label">Select Tailor: </label>
                                        <div class="col-sm-6">
                                            <select class="form-control" id="tailors"></select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--==================================================================================================================================-->
                            <input type="text" class="form-control text-center" style="background-color: black; color: #FAFAFA; font-size: 22px;" placeholder="S E A R C H    H E R E" id="search">
                            <table class="table table-bordered table-striped table-hover" id="order_tbl">
                                <thead class="table-success">
                                    <tr>
                                        <th>#</th>
                                        <th>Customer</th>
                                        <th>Item</th>
                                        <th>Added Date</th>
                                        <th>Requested Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
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

        <!--=====================================Model====================================-->   
        <div class="modal fade" id="assignTailorModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Assign To Tailor</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12 text-center">
                            <div class="form-group row">
                                <label for="inputPassword3" class="col-sm-3 col-form-label">Select Tailor: </label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="tailors_2"></select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="assign">Assign Order</button>
                    </div>
                </div>
            </div>
        </div>
        <!--=========================================================================-->        

        <script type="text/javascript" src="./controller/assign_order_controller.js"></script>
    </body>
</html>
