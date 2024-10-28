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
                        <h3 class="card-title">System User Registration Form</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="row">
                        
                        <!-- ************************************ <div> will take up 5 out of 12 columns ************************************************************************************* -->
                        <div class="col-md-5">
                            <!-- form start -->
                            <form class="form-horizontal">
                                <!-- * required mark -->
                                <div class="row">
                                    <div class="col-9 text-end"></div>                                    
                                    <div class="col-3 text-end">
                                        <span class="fw-bold">
                                            <span class="text-danger">*</span>Required
                                        </span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Full Name :<span class="text-danger"> *</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" required id="fullname">
                                            <h6 style="color: red" id="fname_msg" class="d-none">This field is required</h6>
                                        </div>
                                    </div>                                  
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-3 col-form-label">NIC : <span class="text-danger"> *</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="nic">
                                            <h6 style="color: red" id="nic_msg" class="d-none">This field is required</h6>
                                            <h6 style="color: red" id="nic_msg_check" class="d-none">Invalid NIC format</h6>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-3 col-form-label">Contact Number : <span class="text-danger"> *</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" placeholder="0719230598/ 0372230598" id="contact">
                                            <h6 style="color: red" id="contact_msg" class="d-none">This field is required</h6>
                                            <h6 style="color: red" id="contact_check" class="d-none">Invalid Contact Number format</h6>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-3 col-form-label">Email : <span class="text-danger"> (optional)</span></label>
                                        <div class="col-sm-9">
                                            <input type="email" class="form-control"  placeholder="sample78@gmail.com" id="email">
                                            <h6 style="color: red" id="email_msg_check" class="d-none">Invalid Email Format</h6>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-3 col-form-label">Address : <span class="text-danger"> (optional)</span></label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" id="address"></textarea>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Username :<span class="text-danger"> *</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" required id="username">
                                            <h6 style="color: red" id="uname_msg" class="d-none">This field is required</h6>
                                            <h6 style="color: red" id="uname_check" class="d-none">This username is  already exist</h6>
                                        </div>
                                    </div> 
                                    <div id="password_section">
                                        <div class="form-group row">
                                            <label for="inputPassword3" class="col-sm-3 col-form-label">Password : <span class="text-danger"> *</span></label>
                                            <div class="col-sm-9">
                                                <input type="password" class="form-control" id="password">
                                                <h6 style="color: red" id="password_msg" class="d-none">This field is required</h6>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputPassword3" class="col-sm-3 col-form-label">Confirm Password : <span class="text-danger"> *</span></label>
                                            <div class="col-sm-9">
                                                <input type="password" class="form-control" id="cpassword">
                                                <h6 style="color: red" id="password_check" class="d-none">Password does not match</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="button" class="btn btn-default" id="reset">Reset</button>
                                    <button type="button" class="btn btn-primary float-right" id="save">Save</button>
                                    <button type="button" class="btn btn-success float-right d-none" id="update">update</button>
                                </div>
                                <!-- /.card-footer -->
                            </form>
                        </div>
                        
                        <!-- ************************************ <div> will take up 7 out of 12 columns ************************************************************************************* -->
                        <div class="col-md-7">
                            <hr>
                            <input type="text" class="form-control text-center" style="background-color: black; color: #FAFAFA; font-size: 22px;" placeholder="S E R C H    H E R E" id="search">
                            <table class="table table-bordered table-striped table-hover" id="system_user_tbl">
                                <thead class="table-success">
                                    <tr>
                                        <th>Details</th>
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
        <script type="text/javascript" src="./controller/system_user_registration_controller.js"></script>
    </body>
</html>


