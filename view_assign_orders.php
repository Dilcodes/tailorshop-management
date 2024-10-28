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

        <style type="text/css">
            @media Print {
                .displayHide{
                    display: none;
                }
            }
        </style>
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
            <!-- <aside> mark content related to the main content but considered supplementary or separate -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <?php
                require_once './others/sub_pages/side_bar.php';
                ?>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <!--helps maintain consistency in the layout and presentation of the content across different pages of a website-->
            <div class="content-wrapper displayHide">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">View Assigned Orders</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="row">
                        <div class="col-md-12">

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

        <!--=================================================Model===========================================================================-->   
        <!-- Modal -->
        <div class="modal fade" id="mesViewModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">View Measurements</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Order ID</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" id="order_id" readonly="" style="font-size: 20px; font-weight: bold; text-align: center; background-color: #D1EDFF"> 
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Item</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" id="item" readonly="" style="font-size: 20px; font-weight: bold; text-align: center; background-color: #D1EDFF"> 
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-4 col-form-label">Customer Details</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" rows="3" id="cusDetails" readonly=""></textarea>
                                    </div>
                                </div>
                                <hr>
                                <span id="dynFormSection">
                                </span>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer displayHide">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="window.print()">Print</button>
                        <button type="button" class="btn btn-primary d-none">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!--===================================================================================================================================-->      
        
        <!--=================================================Model===========================================================================-->   
        <!-- Modal -->
        <div class="modal fade" id="sampleImgModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">View Sample Image</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal">
                            <div class="card-body">
                                <div class="row">
                                <div class="col-sm-12">
                                    <img src="" class="img-fluid mb-2" alt="black sample" width="600" id="img_pre">
                                </div>
                                <div class="col-sm3"></div>
                            </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer displayHide">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      
                    </div>
                </div>
            </div>
        </div>
        <!--===================================================================================================================================-->    

        <script type="text/javascript" src="./controller/view_assign_orders_controller.js"></script>
    </body>
</html>
