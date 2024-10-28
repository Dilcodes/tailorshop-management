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
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">User Privilege</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6" style="background-color: lightsteelblue">
                            <hr>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label"><h5><b>Choose a User :</b></h5></label>
                                <div class="col-sm-9">
                                    <select type="text" class="form-control" id="users" style="width: 70%"></select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6 text-center">
                            <h5><b>ADD Privileges</b></h5>
                            <hr> 
                            <select type="text" class="form-control" id="aval_pri" multiple="" style="height: 350px; background-color:lightgoldenrodyellow"></select>
                        </div>
                        <div class="col-md-6 text-center">
                            <h5><b>Remove Privileges</b></h5>
                            <hr>
                            <select type="text" class="form-control" id="assign_pri" multiple="" style="height: 350px; background-color: lightgreen"></select>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-2" style="padding-left: 20px">
                            <button type="button" class="btn btn-success col-md-10; d-none" id="all_add" > <i class="fas fa-plus"></i> &nbsp; All Add</button><br>&nbsp;
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-info col-md-10" id="custom_add">  <i class="fas fa-plus-circle"></i> &nbsp; One By One Add</button> 
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-warning mb-10" id="custom_remove"><i class="fas fa-minus-circle"></i> &nbsp; One By One Remove</button> &nbsp;
                        </div>
                        <div class="col-md-2" style="padding-right: 20px">
                            <button type="button" class="btn btn-danger col-md-10; d-none" id="all_remove"><i class="fas fa-minus"></i> &nbsp; All Remove </button>
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

<script type="text/javascript" src="./controller/user_privilege_controller.js"></script>
