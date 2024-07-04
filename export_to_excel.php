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

include('pages/required/db_connection.php');
include('pages/required/functions.php');
include('pages/required/tables.php');

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
    <title>Fault Records</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
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

    <style>
        body {
            background-color: #f8f9fa;
        }

        .table-container {
            margin-top: 0px;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .btn-custom {
            margin-bottom: 20px;
        }
    </style>
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php include('header.php'); ?>
        <?php include('sidebar.php'); ?>
        <div class="content-wrapper">
            <div class="container table-container">
                <h2 class="mb-4">Fault Records</h2>
                <button class="btn btn-success btn-custom float-right" id="export_btn_normal">
                    <i class="fa fa-download"></i> Export to Excel
                </button>
                <div class="table-responsive">
                    <table class="table table-bordered print_report_table">
                        <thead class="thead-dark">
                            <tr>
                                <th>FID</th>
                                <th>CID</th>
                                <th>CATEGORY</th>
                                <th>UID</th>
                                <th>FAULT_CODE</th>
                                <th>FAULT_TITLE</th>
                                <th>FEEDER_NAME</th>
                                <th>FROM</th>
                                <th>TO</th>
                                <th>REASON</th>
                                <th>DTC_NAME</th>
                                <th>RMU_LOCATION</th>
                                <th>CRDATE</th>
                                <th>STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT * FROM fault_records fr
                                      INNER JOIN secondary_fault_category sfc ON fr.cid = sfc.cid
                                      INNER JOIN users u ON fr.uid = u.uid";
                            if ($usertype == 2) {
                                $query .= " WHERE fr.uid = " . intval($uid); // Use intval() to prevent SQL injection
                            }
                            $result = db_all($query);
                            if ($result != null) {
                                foreach ($result as $row) {
                                    $status = ($row["STATUS"] == 0) ? "Completed" : "Pending";
                                    echo "<tr>
                                        <td>{$row["FID"]}</td>
                                        <td>{$row["CID"]}</td>
                                        <td>{$row["FNAME"]}</td>
                                        <td>{$row["NAME"]}</td>
                                        <td>{$row["FAULT_CODE"]}</td>
                                        <td>{$row["FAULT_TITLE"]}</td>
                                        <td>{$row["FEEDER_NAME"]}</td>
                                        <td>{$row["FROM"]}</td>
                                        <td>{$row["TO"]}</td>
                                        <td>{$row["REASON"]}</td>
                                        <td>{$row["DTC_NAME"]}</td>
                                        <td>{$row["RMU_LOCATION"]}</td>
                                        <td>{$row["CRDATE"]}</td>
                                        <td>{$status}</td>
                                    </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='14'>No records found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php include('footer.php'); ?>
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
    <script>
        $(document).ready(function () {
            $('#export_btn_normal').click(function () {
                $(".print_report_table").table2excel({
                    name: "Report",
                    filename: "Report",
                    fileext: ".xls"
                });
            });
        });
    </script>
</body>

</html>
