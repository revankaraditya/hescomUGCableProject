<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit();
}
$uid = $_SESSION['uid'];
$usertype = $_SESSION['usertype'];

include ('pages/required/db_connection.php');
include ('pages/required/functions.php');
include ('pages/required/tables.php');

$loggen_in_query = "SELECT u.*,DATE_FORMAT(u.CDATE, '%b %Y') AS member_since
								FROM users u
								WHERE u.UID=" . $uid;
$login_query_result = db_one($loggen_in_query);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit'])) {
        handleFaultRecordForm();
    } elseif (isset($_POST['delete'])) {
        handleFaultRecordDelete();
    } elseif (isset($_POST['fetch_record'])) {
        handleFetchRecord();
    }
}

function handleFetchRecord()
{
    if (isset($_POST['fid'])) {
        $fid = $_POST['fid'];
        $sql = "SELECT * FROM fault_records WHERE FID='$fid'";
        $result = db_one($sql);

        if ($result != null) {
            $_SESSION['fault_record'] = $result;
        } else {
            $_SESSION['message'] = "No record found with FID = $fid.";
        }
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

function handleFaultRecordForm()
{
    // Handle form submission for update or insert
    $cid = $_POST["cid"];
    $uid = $_POST["uid"];
    $fault_code = $_POST["fault_code"];
    $fault_title = $_POST["fault_title"];
    $feeder_name = $_POST["feeder_name"];
    $from = $_POST["from"];
    $to = $_POST["to"];
    $reason = $_POST["reason"];
    $dtc_name = $_POST["dtc_name"];
    $rmu_location = $_POST["rmu_location"];
    $crdate = $_POST["crdate"];
    $status = $_POST["status"];
    $fid = $_POST["fid"];
    $form_action = $_POST["form_action"];

    if ($form_action == "update" && !empty($fid)) {
        $sql = "UPDATE fault_records SET CID='$cid', UID='$uid', FAULT_CODE='$fault_code', FAULT_TITLE='$fault_title', FEEDER_NAME='$feeder_name', `FROM`='$from', `TO`='$to', REASON='$reason', DTC_NAME='$dtc_name', RMU_LOCATION='$rmu_location', CRDATE='$crdate', STATUS='$status' WHERE FID='$fid'";
    } else {
        $sql = "INSERT INTO fault_records (CID, UID, FAULT_CODE, FAULT_TITLE, FEEDER_NAME, `FROM`, `TO`, REASON, DTC_NAME, RMU_LOCATION, CRDATE, STATUS) VALUES ('$cid', '$uid', '$fault_code', '$fault_title', '$feeder_name', '$from', '$to', '$reason', '$dtc_name', '$rmu_location', '$crdate', '$status')";
    }

    $res = db_execute($sql);

    if ($res != FALSE) {
        $_SESSION['message'] = "Operation successful.";
    } else {
        $_SESSION['message'] = "Error executing query: ";
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

function handleFaultRecordDelete()
{
    // Handle record deletion
    $fid = $_POST["delete_fid"];

    $status_table_query = "DELETE FROM fault_status WHERE FID=" . $fid . ";";
    $rr = db_execute($status_table_query);
    if ($rr != FALSE) {
        $_SESSION['message'] = "Status Record with FID = $fid successfully removed!";
    } else {
        $_SESSION['message'] = "Error deleting status";
    }

    $sql = "DELETE FROM fault_records WHERE FID=" . $fid . ";";
    $res = db_execute($sql);

    if ($res != FALSE) {
        $_SESSION['message'] = "Record with FID = $fid successfully removed!";
    } else {
        $_SESSION['message'] = "Error deleting record: ";
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Manage Fault Records</title>
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
            <div class="container mt-5">
                <?php
                if (isset($_SESSION['message'])) {
                    echo "<div class='alert alert-info'>" . $_SESSION['message'] . "</div>";
                    unset($_SESSION['message']);
                }

                if (isset($_SESSION['fault_record'])) {
                    $fault_record = $_SESSION['fault_record'];
                    unset($_SESSION['fault_record']); // Clear session variable
                } else {
                    $fault_record = null;
                }
                ?>

                <h2>Fetch and Manage Fault Record</h2>
                <form action="" method="POST" id="fetch_record_form" class="mb-3">
                    <div class="form-group">
                        <label for="fid">Enter FID:</label>
                        <input type="text" class="form-control" id="fid" name="fid" required>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="fetchRecord()">Fetch Record</button>
                    <input type="hidden" name="fetch_record" value="1">
                </form>

                <?php if ($fault_record): ?>
                    <h2>Manage Fault Record (FID: <?php echo $fault_record['FID']; ?>)</h2>
                    <form action="" method="POST" onsubmit="return handleSubmit()" class="mb-3">
                        <input type="hidden" id="fid" name="fid" value="<?php echo $fault_record['FID']; ?>">
                        <div class="form-group">
                            <label for="cid">CID:</label>
                            <input type="text" class="form-control" id="cid" name="cid"
                                value="<?php echo $fault_record['CID']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="uid">UID:</label>
                            <input type="text" class="form-control" id="uid" name="uid"
                                value="<?php echo $fault_record['UID']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="fault_code">Fault Code:</label>
                            <input type="text" class="form-control" id="fault_code" name="fault_code"
                                value="<?php echo $fault_record['FAULT_CODE']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="fault_title">Fault Title:</label>
                            <input type="text" class="form-control" id="fault_title" name="fault_title"
                                value="<?php echo $fault_record['FAULT_TITLE']; ?>" required>
                        </div>

                        <?php if (!empty($fault_record['FEEDER_NAME'])): ?>
                            <div class="form-group">
                                <label for="feeder_name">Feeder Name:</label>
                                <input type="text" class="form-control" id="feeder_name" name="feeder_name"
                                    value="<?php echo $fault_record['FEEDER_NAME']; ?>">
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($fault_record['FROM'])): ?>
                            <div class="form-group">
                                <label for="from">From:</label>
                                <input type="text" class="form-control" id="from" name="from"
                                    value="<?php echo $fault_record['FROM']; ?>">
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($fault_record['TO'])): ?>
                            <div class="form-group">
                                <label for="to">To:</label>
                                <input type="text" class="form-control" id="to" name="to"
                                    value="<?php echo $fault_record['TO']; ?>">
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($fault_record['REASON'])): ?>
                            <div class="form-group">
                                <label for="reason">Reason:</label>
                                <textarea class="form-control" id="reason" name="reason"
                                    rows="4"><?php echo $fault_record['REASON']; ?></textarea>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($fault_record['DTC_NAME'])): ?>
                            <div class="form-group">
                                <label for="dtc_name">DTC Name:</label>
                                <input type="text" class="form-control" id="dtc_name" name="dtc_name"
                                    value="<?php echo $fault_record['DTC_NAME']; ?>">
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($fault_record['RMU_LOCATION'])): ?>
                            <div class="form-group">
                                <label for="rmu_location">RMU Location:</label>
                                <input type="text" class="form-control" id="rmu_location" name="rmu_location"
                                    value="<?php echo $fault_record['RMU_LOCATION']; ?>">
                            </div>
                        <?php endif; ?>

                        <div class="form-group">
                            <label for="crdate">Creation Date:</label>
                            <input type="date" class="form-control" id="crdate" name="crdate"
                                value="<?php echo $fault_record['CRDATE']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="status">Status:</label>
                            <input type="text" class="form-control" id="status" name="status"
                                value="<?php echo $fault_record['STATUS']; ?>" required>
                        </div>

                        <input type="hidden" id="form_action" name="form_action" value="update">
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">Reset</button>
                        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                    </form>

                    <form action="" method="POST" id="delete_form">
                        <input type="hidden" id="delete_fid" name="delete_fid" value="<?php echo $fault_record['FID']; ?>">
                        <button type="submit" class="btn btn-danger" name="delete"
                            onclick="return confirmRemove(<?php echo $fault_record['FID']; ?>)">Remove</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
        <?php include ('footer.php'); ?>
    </div>

    <script>
        function resetForm() {
            location.reload(); // Refresh the page
        }

        function confirmInsert() {
            var message = "Are you sure you want to insert this record?";
            return confirm(message);
        }

        function confirmUpdate() {
            var message = "Are you sure you want to update this record?";
            return confirm(message);
        }

        function confirmRemove(fid) {
            var message = "Are you sure you want to remove the record with FID: " + fid + "?";
            if (confirm(message)) {
                document.getElementById('delete_fid').value = fid;
                document.getElementById('delete_form').submit();
                return true;
            }
            return false;
        }

        function fetchRecord() {
            var fid = document.getElementById("fid").value.trim();
            if (fid === "") {
                alert("Please enter a valid FID.");
                return;
            }
            document.getElementById("fetch_record_form").submit();
        }

        function handleSubmit() {
            var formAction = document.getElementById("form_action").value;
            if (formAction == "update") {
                return confirmUpdate();
            } else {
                return confirmInsert();
            }
        }
    </script>
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