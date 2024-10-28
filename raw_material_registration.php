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
                        <h3 class="card-title">Raw Material Registration Form</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="row">
                        <div class="col-md-5">
                            <!-- form start -->
                            <form class="form-horizontal">


                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Select Type: <span class="text-danger"> *</span></label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="type">
                                                <option value="0">select type</option>
                                                <option value="1">Raw Materials</option>
                                                <option value="2">Tools</option>
                                            </select>    
                                            <h6 style="color: red" id="type_msg" class="d-none">Please select a type first.</h6>
                                            <h6 style="color: red" id="type_msg" class="d-none">This field is required</h6>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-3 col-form-label">Category: <span class="text-danger"> *</span> </label>
                                        <div class="col-sm-7">
                                            <select class="form-control" id="category"></select>
                                            <h6 style="color: red" id="category_msg" class="d-none">This field is required</h6>
                                        </div>
                                        <div class="col-sm-2">
                                            <button type="button" class="btn btn-dark float-right" id="additem" data-toggle="modal" data-target="#category_model" disabled>Add</button>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-3 col-form-label">Name: <span class="text-danger"> *</span> </label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="name">
                                            <h6 style="color: red" id="name_msg" class="d-none">This field is required</h6>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-3 col-form-label">Material Code: </label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="material_code">
                                            <h6 style="color: red" id="material_code_msg" class="d-none">This field is required</h6>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-3 col-form-label">Description: </label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" id="description"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-3 col-form-label">Measurement Unit/ Item Count: <span class="text-danger"> *</span> </label>
                                        <div class="col-sm-7">
                                            <select class="form-control" id="unit_type"></select>
                                            <h6 style="color: red" id="measure_unit_msg" class="d-none">This field is required</h6>
                                        </div>
                                        <div class="col-sm-2">
                                            <button type="button" class="btn btn-dark float-right" id="addunit" data-toggle="modal" data-target="#measurement_model" disabled>Add</button>
                                        </div>
                                    </div>
                                    <div class="form-group row" id="reorder_level_area" >
                                        <label for="inputPassword3" class="col-sm-3 col-form-label">Reorder Level: </label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="reorder_level">
                                            <small class="form-text text-muted">Enter the minimum quantity at which you want to reorder this item.</small>
                                            <!--    <h6 style="color: red" id="reorder_level_msg" class="d-none">This field is required</h6> -->
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <!-- * required mark -->
                                    <span class="text-danger">* </span><b>Required</b><br><hr>
                                    <button type="button" class="btn btn-default" id="reset">Reset</button>
                                    <button type="button" class="btn btn-primary float-right" id="save">Save</button>
                                    <button type="button" class="btn btn-success float-right d-none" id="update">Update</button>
                                </div>
                                <!-- /.card-footer -->
                            </form>
                        </div>
                        <div class="col-md-7">
                            <hr>
                            <input type="text" class="form-control text-center" style="background-color: black; color: #FAFAFA; font-size: 22px;" placeholder="S E  A R C H    H E R E" id="search">
                            <table class="table table-bordered table-striped table-hover" id="raw_material_tbl">
                                <thead class="table-success">
                                    <tr>
                                        <th>Details</th>
                                        <th>Measurement Unit</th>
                                        <th>Reorder Level </th>
                                        <th>Action </th>
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

        <!--=====================================================================================================================--> 
        <!-- category Add Modal -->
        <div class="modal fade" id="category_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Add New Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-3 col-form-label">Category: </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="new_category">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="save_category">Save Category</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Measurement Add Modal -->
        <div class="modal fade" id="measurement_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Add Measurement Units</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-3 col-form-label">Units: </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="unit">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="save_unit">Save Unit</button>
                    </div>
                </div>
            </div>
        </div>
        <!--=====================================================================================================================-->        

        <?php
        require_once './others/sub_pages/all_js.php';
        ?>

        <script type="text/javascript" src="./controller/raw_material_registration_controller.js"></script>
    </body>
</html>
