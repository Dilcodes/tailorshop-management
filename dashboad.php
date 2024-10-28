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
    <body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
        <div class="wrapper">

            <!-- Preloader -->
            <div class="preloader flex-column justify-content-center align-items-center">
                <img class="animation__wobble" src="./others/images/Tshop logo.jpg" alt="AdminLTELogo" height="100" width="100">
            </div>

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
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <hr>
                <!-- /.content-header -->

                <!-- Main content -->
                <section class="content">
                    <?php
                    $type = $_SESSION['log_type'];
                    if ($type == 1) {
                        ?>
                        <div class="container-fluid">
                            <!-- Info boxes -->
                            <div class="row">

                                <!-- /.col -->
                                <div class="col-12 col-sm-6 col-md-3">
                                    <div class="info-box mb-3" style="background-color: snow" onmouseover="this.style.backgroundColor = '#c0c0c0';" onmouseout="this.style.backgroundColor = 'snow';">
                                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>
                                        <div class="info-box-content">
                                            <a type="button" href="./?report=sales_summery" class="btn btn-dark">
                                                <span class="info-box-text"><b>Monthly Sales (Rs.)</b></span>
                                                <span class="info-box-number" id="montly_total">0</span>
                                            </a>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>
                                <!-- /.col -->

                                <!-- fix for small devices only -->
                                <div class="clearfix hidden-md-up"></div>

                                <div class="col-12 col-sm-6 col-md-3">
                                    <div class="info-box mb-3" style="background-color: snow" onmouseover="this.style.backgroundColor = '#c0c0c0';" onmouseout="this.style.backgroundColor = 'snow';">
                                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

                                        <div class="info-box-content">
                                            <a type="button" href="./?location=view_stock" class="btn btn-dark">
                                                <span class="info-box-text"><b>View Stock</b></span>
                                                <span class="info-box-number" id="stock_value">Raw materials/ Tools</span>
                                            </a>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>
                                <!-- /.col -->
                                <div class="col-12 col-sm-6 col-md-3">
                                    <div class="info-box mb-3" style="background-color: snow" onmouseover="this.style.backgroundColor = '#c0c0c0';" onmouseout="this.style.backgroundColor = 'snow';">
                                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-clipboard-list"></i></span>

                                        <div class="info-box-content">
                                            <!-- active_orders = pending_orders -->
                                            <a type="button" href="./?report=active_order_details" class="btn btn-dark">  
                                                <span class="info-box-text"><b>Pending to Assign Orders</b></span>
                                                <span class="info-box-number" id="active_orders">0</span>
                                            </a>  
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>
                                <div class="col-12 col-sm-6 col-md-3">
                                    <div class="info-box" style="background-color: snow" onmouseover="this.style.backgroundColor = '#c0c0c0';" onmouseout="this.style.backgroundColor = 'snow';">
                                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

                                        <div class="info-box-content">
                                            <a type="button" href="./?report=cus_summery" class="btn btn-dark">
                                                <span class="info-box-text"><b> Total Customers</b></span>
                                                <span class="info-box-number" id="cus_total">0</span>
                                            </a>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="card-header border-transparent">
                                                        <h5 class="card-title">Order Summery (Last 12 Months)</h5>
                                                    </div>
                                                    <div class="card-body p-0">
                                                        <div class="table-responsive">
                                                            <div class="chart">
                                                                <!-- Sales Chart Canvas -->
                                                                <canvas id="orderChart" height="180" style="height: 420px;"></canvas>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="card">
                                                        <div class="card-header border-transparent">
                                                            <h3 class="card-title">Ongoing Order Summery (Assigned Or Measurement Collected)</h3>
                                                        </div>
                                                        <!-- /.card-header -->
                                                        <div class="card-body p-0">
                                                            <div class="table-responsive">
                                                                <table class="table m-0" id="ongoing_orders">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Order ID</th>
                                                                            <th>Measurement Name</th>
                                                                            <th>Order Status</th>
                                                                            <th>Request Date</th>
                                                                            <th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>




                                                                        <!--              
                                                                                                                                            <tr>
                                                                                                                                                <td><a href="pages/examples/invoice.html">OR9842</a></td>
                                                                                                                                                <td>Frock - M</td>
                                                                                                                                                <td><span class="badge badge-success">Shipped</span></td>
                                                                                                                                            </tr>
                                                                                                                                            <tr>
                                                                                                                                                <td><a href="pages/examples/invoice.html">OR1848</a></td>
                                                                                                                                                <td>Shirt -S</td>
                                                                                                                                                <td><span class="badge badge-warning">Pending</span></td>
                                                                                                                                            </tr>
                                                                                                                                            <tr>
                                                                                                                                                <td><a href="pages/examples/invoice.html">OR7429</a></td>
                                                                                                                                                <td>Shirt - M</td>
                                                                                                                                                <td><span class="badge badge-danger">Delivered</span></td>
                                                                                                                                            </tr>
                                                                                                                                            <tr>
                                                                                                                                                <td><a href="pages/examples/invoice.html">OR7429</a></td>
                                                                                                                                                <td>Curtain - Green Lace</td>
                                                                                                                                                <td><span class="badge badge-info">Processing</span></td>
                                                                                                                                            </tr>
                                                                                                                                            <tr>
                                                                                                                                                <td><a href="pages/examples/invoice.html">OR1848</a></td>
                                                                                                                                                <td>Frock - S</td>
                                                                                                                                                <td><span class="badge badge-warning">Pending</span></td>
                                                                                                                                            </tr>
                                                                                                                                            <tr>
                                                                                                                                                <td><a href="pages/examples/invoice.html">OR7429</a></td>
                                                                                                                                                <td>Skirt - M</td>
                                                                                                                                                <td><span class="badge badge-danger">Delivered</span></td>
                                                                                                                                            </tr>
                                                                                                                                            <tr>
                                                                                                                                                <td><a href="pages/examples/invoice.html">OR9842</a></td>
                                                                                                                                                <td>Skirt - S</td>
                                                                                                                                                <td><span class="badge badge-success">Shipped</span></td>
                                                                                                                                            </tr>
                                                                        -->

                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <!-- /.table-responsive -->
                                                        </div>
                                                        <!-- /.card-body -->
                                                        <div class="card-footer clearfix">
                                                            <a href="./?location=new_order" class="btn btn-sm btn-info float-left">Place New Order</a>
                                                            <a href="./?report=order_management_summery" class="btn btn-sm btn-secondary float-right">View All Orders</a>
                                                        </div>
                                                        <!-- /.card-footer -->
                                                    </div>
                                                </div>
                                                <!-- /.col -->
                                            </div>
                                            <!-- /.row -->
                                        </div>
                                        <!-- ./card-body -->

                                        <!-- /.card-footer -->
                                    </div>
                                    <!-- /.card -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <!-- Main row -->

                            <!-- /.row -->
                        </div>
                    <?php } else { ?>
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6 text-center">
                                <img src="./others/images/Tshop logo.jpg" style="width: 70%; margin-top: 20%;">
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                    <?php } ?>
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->

            <!-- Main Footer -->
            <?php
            require_once './others/sub_pages/footer.php';
            ?>
        </div>
        <!-- ./wrapper -->

        <!-- REQUIRED SCRIPTS -->
        <?php
        require_once './others/sub_pages/all_js.php';
        ?>
        <script type="text/javascript" src="./controller/dashboad_controller.js"></script>

        <?php
        $month = "";
        $value = "";
        $query = "SELECT
                  COUNT(order_summery.order_id) AS order_count,
                  DATE_FORMAT(order_added_date,'%Y-%M') AS order_month
                  FROM `order_summery`
                  GROUP BY
                  DATE_FORMAT(order_added_date,'%Y-%m')
                  ORDER BY
                  DATE_FORMAT(order_added_date,'%Y-%m') ASC 
                  LIMIT 12";
        $data = $app->basic_Select_Query($query);
        foreach ($data AS $x) {
            $month .= "'" . $x['order_month'] . "', ";
            $value .= $x['order_count'] . ", ";
        }
        ?>

        <script type="text/javascript">
                                        var areaChartCanvas = $('#orderChart').get(0).getContext('2d')

                                        var areaChartData = {
                                            labels: [<?php echo $month; ?>],
                                            datasets: [
                                                {
                                                    label: 'Digital Goods',
                                                    backgroundColor: 'rgba(60,141,188,0.9)',
                                                    borderColor: 'rgba(60,141,188,0.8)',
                                                    pointRadius: false,
                                                    pointColor: '#3b8bba',
                                                    pointStrokeColor: 'rgba(60,141,188,1)',
                                                    pointHighlightFill: '#fff',
                                                    pointHighlightStroke: 'rgba(60,141,188,1)',
                                                    data: [<?php echo $value; ?>]
                                                }
                                            ]
                                        }

                                        var areaChartOptions = {
                                            maintainAspectRatio: false,
                                            responsive: true,
                                            legend: {
                                                display: false
                                            },
                                            scales: {
                                                xAxes: [{
                                                        gridLines: {
                                                            display: false,
                                                        }
                                                    }],
                                                yAxes: [{
                                                        gridLines: {
                                                            display: false,
                                                        }
                                                    }]
                                            }
                                        }

                                        // This will get the first returned node in the jQuery collection.
                                        new Chart(areaChartCanvas, {
                                            type: 'line',
                                            data: areaChartData,
                                            options: areaChartOptions
                                        });
        </script>

    </body>
</html>
