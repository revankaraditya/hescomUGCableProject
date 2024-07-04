<?php
ini_set('display_errors', 1);
error_reporting(E_ALL); // Enable all errors for debugging

session_start();
if (!isset($_SESSION['uid'], $_SESSION['usertype'], $_SESSION['logged_in'])) {
    header("Location: login.php");
    exit();
}

$uid = $_SESSION['uid'];
$usertype = $_SESSION['usertype'];

include ('pages/required/db_connection.php');
include ('pages/required/functions.php');
include ('pages/required/tables.php');

$loggen_in_query = "SELECT u.*, DATE_FORMAT(u.CDATE, '%b %Y') AS member_since
                    FROM users u
                    WHERE u.UID = " . intval($uid); // Use intval() to prevent SQL injection
$login_query_result = db_one($loggen_in_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Edit Database</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- CSS Imports -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
    <link rel="stylesheet" href="plugins/morris/morris.css">
    <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <link rel="stylesheet" href="plugins/fullcalendar/fullcalendar.min.css">
    <link rel="stylesheet" href="plugins/fullcalendar/fullcalendar.print.css" media="print">
    <link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css">
    <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="bootstrap/css/counter.css">
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php include ('header.php'); ?>
        <?php include ('sidebar.php'); ?>
        <div class="content-wrapper">
            <br>
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-lg-6 mb-4">
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <p>Faults Categories</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-edit"></i>
                            </div>
                            <button type="button" class="small-box-footer form-control" onclick="window.location.href='manage_fault_categories.php'">Edit<i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 mb-4">
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <p>Fault Records</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-edit"></i>
                            </div>
                            <button type="button" class="small-box-footer form-control" onclick="window.location.href='manage_fault_records.php'">Edit<i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 mb-4">
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <p>Fault Resolution Steps</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-edit"></i>
                            </div>
                            <button type="button" class="small-box-footer form-control" onclick="window.location.href='manage_fault_steps.php'">Edit<i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 mb-4">
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <p>User Accounts</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-edit"></i>
                            </div>
                            <button type="button" class="small-box-footer form-control" onclick="window.location.href='manage_users.php'">Edit<i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include ('footer.php'); ?>
    </div>
    

    <!-- JS Imports -->
    <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
    <script src="plugins/table2excel/dist/jquery.table2excel.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
    <script src="plugins/fullcalendar/fullcalendar.min.js"></script>
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="plugins/select2/select2.full.min.js"></script>
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <script src="plugins/knob/jquery.knob.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="plugins/morris/morris.min.js"></script>
    <script src="plugins/sparkline/jquery.sparkline.min.js"></script>
    <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <script src="plugins/datepicker/bootstrap-datepicker.js"></script>
    <script src="plugins/date_time/date_time.js"></script>
    <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="plugins/fastclick/fastclick.js"></script>
    <script src="dist/js/app.min.js"></script>
    <script src="plugins/chartjs/Chart.min.js"></script>
    <script src="dist/js/demo.js"></script>
    <script src="bootstrap/js/counter.js"></script>
</body>

</html>
