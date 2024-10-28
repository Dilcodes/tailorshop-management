<?php
require_once './others/class/comm_functions.php';
$app = new setting();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require_once './others/sub_pages/all_css.php'; ?>
    </head>
    <body class="hold-transition sidebar-mini" style="background-image: linear-gradient(90deg, rgba(207,203,203,1) 0%, rgba(255,255,255,1) 100%);">
        <!-- Site wrapper -->
        <div class="wrapper">
            <!-- Navbar -->
            <?php require_once './others/sub_pages/head.php'; ?>
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-maroon elevation-4">

                <!-- Sidebar -->
                <?php require_once './others/sub_pages/side_bar.php'; ?>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <!-- Main content -->
                <section class="content">

                    <!-- Default box -->
                    <div class="card" style="background-image: linear-gradient(90deg, rgba(207,203,203,1) 0%, rgba(255,255,255,1) 100%);">
                        <div class="card-header">
                            <h3 class="card-title">System Data Backup</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <form method="POST" action="" class="form-horizontal">
                                        <div class="card-body text-center">

                                            <h3><font size="+1" > Click the button below to run the daily data backup process. </h3>
                                            <p> 
                                                After successful completion of the backup file, we advise you to copy the file to your secure data storage location.
                                                In case of an emergency breakdown, you can provide us the backup file to restore your system to the previous state where the backup was taken.
                                            </p>
                                            <p>Example backup file name : <?php echo "OMS_" . date('Y-m-d'); ?>.zip</p>
                                            <p>&nbsp;</p>
                                            <?php
                                            error_reporting(0);
                                            //set the default file name
                                            $bname = "OMS_" . date("Y-m-d");

                                            //include [require] mysql dump engine
                                            require_once('./others/class/MySQLDump.class.php');
                                            $starttime = time();

                                            //mysql info
                                            $dbhost = DB_HOST; //db host
                                            $dbuser = DB_USER; //db user name
                                            $dbpass = DB_PASS; //db password
                                            $dbname = DB_NAME; //db to work with

                                            $drop_table_if_exists = true; //should we drop table if exist?

                                            $somecontent = "/*\n
                                                    +--------------------------------------------------------------+\n
                                                    +--------------------------OMS Database Bakups-----------------+\n
                                                    +--------------------------------------------------------------+\n
                                                    +--------------------------------------------------------------+\n
                                                    */\n\n";

                                            // no need for editing further
                                            $backup = new MySQLDump(); //create new instance of MySQLDump

                                            $backup->droptableifexists = $drop_table_if_exists; //set drop table if exists
                                            $backup->connect($dbhost, $dbuser, $dbpass, $dbname); //connect
                                            if (!$backup->connected) {
                                                die('Error: ' . $backup->mysql_error);
                                            } //if not connected, display error
                                            $backup->list_tables(); //list all tables

                                            $broj = count($backup->tables); //count all tables, $backup->tables will be array of table names
                                            //echo "<pre>\n"; //start preformatted output
                                            $somecontent .= "-- Dumping tables for database: `$dbname`\n"; //write "intro" ;)
                                            $somecontent .= "\n\nSET FOREIGN_KEY_CHECKS=0; \n"; //write "intro" ;)
                                            //dump all tables:
                                            for ($i = 0; $i < $broj; $i++) {
                                                $table_name = $backup->tables[$i]; //get table name
                                                $backup->dump_table($table_name); //dump it to output (buffer)
                                                $somecontent .= $backup->output; //write output
                                            }

                                            $somecontent .= "\n\nSET FOREIGN_KEY_CHECKS=1; \n\n"; //write "intro" ;)
                                            //create the zip archive
                                            $zip = new ZipArchive;
                                            $zipfilename = "./backups/" . $bname . "-" . $starttime . ".zip";
                                            $res = $zip->open($zipfilename, ZipArchive::CREATE);
                                            if ($res === TRUE) {
                                                $zip->addFromString(($bname . '.sql'), $somecontent);
                                                $zip->close();
                                                echo '&nbsp&nbsp<a href="' . $zipfilename . '"><button name="backup" type="button" class="btn btn-large" style="background-color:rgb(216,27,96); color:#FFFFFF"> <b>Click Here to Download System Backup</b></button></a></br>';
                                            } else {
                                                echo 'Backup file creating failed due to some reason.<br/>Please contact developers for assistance.';
                                            }
                                            ?>



                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-footer-->
            </div>
            <?php require_once './others/sub_pages/footer.php'; ?>
        </div>
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
        <!-- ./wrapper -->
        <?php require_once './others/sub_pages/all_js.php'; ?>
    </body>
</html>

