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
        handleFaultResolutionForm();
    } elseif (isset($_POST['delete'])) {
        handleFaultResolutionDelete();
    } elseif (isset($_POST['fetch_record'])) {
        handleFetchResolutionRecord();
    } elseif (isset($_POST['insert'])) {
        handleInsertResolutionRecord();
    }
}

function handleFetchResolutionRecord()
{
    if (isset($_POST['cid'])) {
        $cid = $_POST['cid'];
        $sql = "SELECT * FROM fault_resolution_steps WHERE CID='$cid'";
        $results = db_all($sql); // Assuming db_query returns an array of results

        if ($results) {
            $_SESSION['resolution_records'] = $results;
        } else {
            $_SESSION['message'] = "No records found with CID = $cid.";
        }
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

function handleFaultResolutionForm()
{
    $cid = $_POST["cid"];
    $fsid = $_POST["fsid"];
    $name = $_POST["name"];
    $slno = $_POST["slno"];
    $form_action = $_POST["form_action"];

    if ($form_action == "update" && !empty($slno)) {
        $sql = "UPDATE fault_resolution_steps SET CID='$cid', FSID='$fsid', NAME='$name' WHERE SLNO='$slno'";
    } else {
        $sql = "INSERT INTO fault_resolution_steps (CID, FSID, NAME) VALUES ('$cid', '$fsid', '$name')";
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

function handleInsertResolutionRecord()
{
    $cid = $_POST["new_cid"];
    $fsid = $_POST["new_fsid"];
    $name = $_POST["new_name"];

    $sql = "INSERT INTO fault_resolution_steps (CID, FSID, NAME) VALUES ('$cid', '$fsid', '$name')";

    $res = db_execute($sql);

    if ($res != FALSE) {
        $_SESSION['message'] = "New record inserted successfully.";
    } else {
        $_SESSION['message'] = "Error inserting new record: ";
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

function handleFaultResolutionDelete()
{
    $slno = $_POST["delete_slno"];
    $sql = "DELETE FROM fault_resolution_steps WHERE SLNO='$slno'";
    $res = db_execute($sql);

    if ($res != FALSE) {
        $_SESSION['message'] = "Record with SLNO = $slno successfully removed!";
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
    <title>Manage Fault Resolution Steps</title>
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

        function confirmRemove(slno) {
            var message = "Are you sure you want to remove the record with SLNO: " + slno + "?";
            if (confirm(message)) {
                document.getElementById('delete_slno').value = slno;
                document.getElementById('delete_form').submit();
                return true;
            }
            return false;
        }

        function fetchRecord() {
            var cid = document.getElementById("cid").value.trim();
            if (cid == "") {
                alert("Please enter a valid CID.");
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
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php include ('header.php'); ?>
        <?php include ('sidebar.php'); ?>
        <div class="content-wrapper">
            <?php
            if (isset($_SESSION['message'])) {
                echo "<p>" . $_SESSION['message'] . "</p>";
                unset($_SESSION['message']);
            }

            if (isset($_SESSION['resolution_records'])) {
                $resolution_records = $_SESSION['resolution_records'];
                unset($_SESSION['resolution_records']); // Clear session variable
            } else {
                $resolution_records = null;
            }
            ?>
            <div class="container">
                <h2>Fetch and Manage Fault Resolution Steps</h2>
                <form action="" method="POST" id="fetch_record_form" class="mb-3">
                    <div class="form-group">
                        <label for="cid">Enter CID:</label>
                        <input type="text" id="cid" name="cid" class="form-control" required>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="fetchRecord()">Fetch Record</button>
                    <input type="hidden" name="fetch_record" value="1">
                </form>

                <?php if ($resolution_records): ?>
                    <?php foreach ($resolution_records as $resolution_record): ?>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Manage Fault Resolution Step (CID:
                                    <?php echo $resolution_record['CID']; ?>,
                                    FSID:
                                    <?php echo $resolution_record['FSID']; ?>)
                                </h5>
                                <form action="" method="POST" onsubmit="return handleSubmit()">
                                    <input type="hidden" id="slno" name="slno"
                                        value="<?php echo $resolution_record['SLNO']; ?>">
                                    <div class="form-group">
                                        <label for="cid">CID:</label>
                                        <input type="text" id="cid" name="cid" value="<?php echo $resolution_record['CID']; ?>"
                                            class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="fsid">FSID:</label>
                                        <input type="text" id="fsid" name="fsid"
                                            value="<?php echo $resolution_record['FSID']; ?>" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Name:</label>
                                        <input type="text" id="name" name="name"
                                            value="<?php echo $resolution_record['NAME']; ?>" class="form-control" required>
                                    </div>
                                    <input type="hidden" id="form_action" name="form_action" value="update">
                                    <button type="button" class="btn btn-secondary" onclick="resetForm()">Reset</button>
                                    <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                                </form>

                                <form action="" method="POST" id="delete_form" class="mt-2">
                                    <input type="hidden" id="delete_slno" name="delete_slno"
                                        value="<?php echo $resolution_record['SLNO']; ?>">
                                    <input type="submit" name="delete" value="Remove" class="btn btn-danger"
                                        onclick="return confirmRemove(<?php echo $resolution_record['SLNO']; ?>)">
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <h2>Insert New Fault Resolution Step</h2>
                <form action="" method="POST" class="mb-3">
                    <div class="form-group">
                        <label for="new_cid">CID:</label>
                        <input type="text" id="new_cid" name="new_cid" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="new_fsid">FSID:</label>
                        <input type="text" id="new_fsid" name="new_fsid" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="new_name">Name:</label>
                        <input type="text" id="new_name" name="new_name" class="form-control" required>
                    </div>
                    <input type="hidden" name="insert" value="1">
                    <button type="button" class="btn btn-secondary" onclick="resetForm()">Reset</button>
                    <input type="submit" name="insert" value="Insert" class="btn btn-primary"
                        onclick="return confirmInsert()">
                </form>
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