<!DOCTYPE html>
<html lang="en">
    <head>

        <?php require_once './others/sub_pages/all_css.php'; ?>

        <style type="text/css">



            body{
                background:
                    /* top, transparent black, faked with gradient */
                    linear-gradient(
                    rgba(0, 0, 0, 0.2),
                    rgba(0, 0, 0, 0.2)
                    ),
                    url('others/images/LogP55.JPG');
                width: 100%;
                /*background:url('others/images/LogP5.JPG');*/
                background-position: center top;
                /*background-size: cover;*/
                height: 100%;
                color: white;
                background-repeat:no-repeat;
            }


            .card {
                background-color: darkslategray;
                border-radius: 10px;
                box-shadow: inset 2px 2px 10px rgba(255, 255, 255, 0.5),
                    inset -2px -2px 10px rgba(0, 0, 0, 0.7),
                    5px 5px 15px rgba(0, 0, 0, 0.3);
                transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            }

            .card:hover {
                transform: translateY(-10px);
                box-shadow: inset 2px 2px 15px rgba(255, 255, 255, 0.6),
                    inset -2px -2px 15px rgba(0, 0, 0, 0.8),
                    8px 8px 20px rgba(0, 0, 0, 0.4);
            }



        </style>

    </head>    
    <marquee behavior="alternate" direction="down"><h2>.</h2></marquee> 
    <body class="hold-transition login-page">
        <div class="login-box">
            <!-- /.login-logo -->
            <div class="card" style="background-color: snow" height="50%" width="50%"> 
                <div class="login-logo">
                    <img src="./others/images/Tshop_logo-removebg-preview.png" width="200" style="margin-top: 20px">     
                    <hr>
                    <a href="../../index2.html" style="color: black"><h2><b>System</b> Login</h2></a>
                </div>
                <!--    <div class="card-body login-card-body" style="background-color: darkgrey"> -->
                <div class="card login-card-body" style="background-color: darkgrey">
                    <form action="../../index3.html" method="post">
                        <div class="input-group mb-3">
                            <select class="form-control" id="logType">
                                <option value="0">Select Login Type</option>
                                <option value="1">Login As System User</option>
                                <option value="2">Login As Tailor</option>
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Username" id="uname">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user-circle"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" placeholder="Password" id="pass">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- /.col -->
                            <div class="col-12">
                                <button type="button" class="btn btn-primary btn-block" id="login">Login</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>
                </div>
                <!-- /.login-card-body -->
            </div>
        </div>
        <!-- /.login-box -->

        <?php require_once './others/sub_pages/all_js.php'; ?>
        <script type="text/javascript" src="./controller/login_controller.js"></script>

    </body>
</html>
