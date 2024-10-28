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
                        <h3 class="card-title">Expenses</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="row">
                        <div class="col-md-5">
                            <!-- form start -->
                            <form class="form-horizontal">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Category</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="category"></select>
                                            <h6 style="color: red" id="category_msg" class="d-none">This field is required</h6>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-3 col-form-label">Amount</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="amount">
                                            <h6 style="color: red" id="amount_msg" class="d-none">This field is required</h6>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-3 col-form-label">Description</label>
                                        <div class="col-sm-9">
                                            <textarea name="name" class="form-control" rows="2" id="description"></textarea>
                                            <h6 style="color: red" id="description_msg" class="d-none">This field is required</h6>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-3 col-form-label">Date</label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control" id="date">
                                            <h6 style="color: red" id="date_msg" class="d-none">This field is required</h6>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="button" class="btn btn-default" id="reset">Reset</button>
                                    <button type="button" class="btn btn-primary float-right" id="add">Add</button>
                                </div>
                                <!-- /.card-footer -->
                            </form>
                        </div>
                        
                        <div class="col-md-7">
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" value="<?php echo date('Y-m'); ?>" class="form-control text-center col-md-12" style="background-color: black; color: greenyellow; font-size: 22px;" id="month">
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control text-center col-md-12" style="background-color: black; color: greenyellow; font-size: 22px;" placeholder="S E R C H    H E R E" id="search">
                                </div>
                            </div>
                            <table class="table table-bordered table-striped table-hover" id="expense_detail_tbl">
                                <thead class="table-success">
                                    <tr>
                                        <th>Amount</th>
                                        <th>Description</th>
                                        <th>Date</th>
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
        <script type="text/javascript" src="./controller/expenses_controller.js"></script>

    </body>
</html>
