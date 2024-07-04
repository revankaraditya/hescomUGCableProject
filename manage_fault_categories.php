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

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['s_submit'])) {
        handleSecondaryFaultCategoryForm();
    } elseif (isset($_POST['p_submit'])) {
        handlePrimaryFaultCategoryForm();
    } elseif (isset($_POST['secondary_delete'])) {
        handleSecondaryFaultCategoryDelete();
    } elseif (isset($_POST['primary_delete'])) {
        handlePrimaryFaultCategoryDelete();
    }
}

function handleSecondaryFaultCategoryForm()
{
    $fname = $_POST["sfname"];
    $pfid = $_POST["spf_id"];
    $cid = $_POST["scid"];
    $form_action = $_POST["sform_action"];

    if ($form_action == "update" && !empty($cid)) {
        $sql = "UPDATE secondary_fault_category SET FNAME='$fname', PFID='$pfid' WHERE CID='$cid'";
    } else {
        $sql = "INSERT INTO secondary_fault_category (FNAME, PFID) VALUES ('$fname', '$pfid')";
    }

    $res = db_execute($sql);

    if ($res !== FALSE) {
        $_SESSION['message'] = "Operation successful. Affected rows: " . $res;
    } else {
        $_SESSION['message'] = "Error executing query: ";
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

function handlePrimaryFaultCategoryForm()
{
    $pfname = $_POST["pfname"];
    $pfid = $_POST["pfid"];
    $form_action = $_POST["pform_action"];

    if ($form_action == "update" && !empty($pfid)) {
        $sql = "UPDATE primary_fault_category SET PFNAME='$pfname' WHERE PFID='$pfid'";
    } else {
        $sql = "INSERT INTO primary_fault_category (PFNAME) VALUES ('$pfname')";
    }

    $res = db_execute($sql);

    if ($res !== FALSE) {
        $_SESSION['message'] = "Operation successful. Affected rows: " . $res;
    } else {
        $_SESSION['message'] = "Error executing query: ";
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

function handleSecondaryFaultCategoryDelete()
{
    $cid = $_POST["secondary_delete_id"];
    $sql = "DELETE FROM secondary_fault_category WHERE CID='$cid'";
    $res = db_execute($sql);

    if ($res !== FALSE) {
        $_SESSION['message'] = "Record with CID = $cid successfully removed!";
    } else {
        $_SESSION['message'] = "Error deleting record: ";
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

function handlePrimaryFaultCategoryDelete()
{
    $pfid = $_POST["primary_delete_id"];
    $sql = "DELETE FROM primary_fault_category WHERE PFID='$pfid'";
    $res = db_execute($sql);

    if ($res !== FALSE) {
        $_SESSION['message'] = "Record with PFID = $pfid successfully removed!";
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
    <title>Manage Fault Categories</title>
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
        function editSecondaryRecord(cid, fname, pfid) {
            document.getElementById("scid").value = cid;
            document.getElementById("sfname").value = fname;
            document.getElementById("spf_id").value = pfid;
            document.getElementById("sform_action").value = "update";
        }

        function editPrimaryRecord(pfid, pfname) {
            document.getElementById("pfid").value = pfid;
            document.getElementById("pfname").value = pfname;
            document.getElementById("pform_action").value = "update";
        }

        function resetForm() {
            location.reload(); // Refresh the page
        }

        function confirmInsert(type) {
            var name, id;
            if (type === 'secondary') {
                name = document.getElementById("sfname").value;
                id = document.getElementById("spf_id").value;
                var message = "Are you sure you want to insert the following record?\n\n";
                message += "Fault Name: " + name + "\n";
                message += "Primary Fault ID: " + id;
            } else {
                name = document.getElementById("pfname").value;
                var message = "Are you sure you want to insert the following record?\n\n";
                message += "Primary Fault Name: " + name;
            }

            return confirm(message);
        }

        function confirmUpdate(type) {
            var name, id;
            if (type === 'secondary') {
                name = document.getElementById("sfname").value;
                id = document.getElementById("spf_id").value;
                var cid = document.getElementById("scid").value;
                var message = "Are you sure you want to update the following record?\n\n";
                message += "CID: " + cid + "\n";
                message += "Fault Name: " + name + "\n";
                message += "Primary Fault ID: " + id;
            } else {
                name = document.getElementById("pfname").value;
                id = document.getElementById("pfid").value;
                var message = "Are you sure you want to update the following record?\n\n";
                message += "PFID: " + id + "\n";
                message += "Primary Fault Name: " + name;
            }

            return confirm(message);
        }

        function confirmRemove(type, id) {
            var message = "Are you sure you want to remove the record with " + (type === 'secondary' ? "CID: " : "PFID: ") + id + "?";
            if (confirm(message)) {
                document.getElementById(type + '_delete_id').value = id;
                document.getElementById(type + '_delete_form').submit();
                return true;
            }
            return false;
        }

        function handleSubmit(type) {
            var formAction = document.getElementById(type === 'secondary' ? "sform_action" : "pform_action").value;
            if (formAction == "update") {
                return confirmUpdate(type);
            } else {
                return confirmInsert(type);
            }
        }
    </script>
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
                ?>

                <h2 class="mb-4">Insert/Update Primary Fault Category</h2>
                <form action="" method="POST" onsubmit="return handleSubmit('primary')" class="mb-4">
                    <div class="form-group">
                        <label for="pfname">Primary Fault Name:</label>
                        <input type="text" class="form-control" id="pfname" name="pfname" required>
                    </div>
                    <input type="hidden" id="pfid" name="pfid">
                    <input type="hidden" id="pform_action" name="pform_action" value="insert">
                    <button type="button" class="btn btn-secondary" onclick="resetForm()">Reset</button>
                    <button type="submit" class="btn btn-primary" name="p_submit">Submit</button>
                </form>

                <?php
                echo "<h2 class='mb-4'>Existing Primary Fault Records</h2>";
                $sql = "SELECT * FROM primary_fault_category;";
                $result = db_all($sql);

                if ($result != null) {
                    echo "<table class='table table-bordered'><thead class='thead-dark'><tr><th>PFID</th><th>Primary Fault Name</th><th>Actions</th></tr></thead><tbody>";
                    foreach ($result as $row) {
                        echo "<tr>";
                        echo "<td>" . $row["PFID"] . "</td>";
                        echo "<td>" . $row["PFNAME"] . "</td>";
                        echo "<td>
                    <button class='btn btn-warning btn-sm' onclick='editPrimaryRecord(" . $row["PFID"] . ", \"" . addslashes($row["PFNAME"]) . "\")'>Edit</button>
                    <button class='btn btn-danger btn-sm' onclick='confirmRemove(\"primary\", " . $row["PFID"] . ")'>Remove</button>
                </td>";
                        echo "</tr>";
                    }
                    echo "</tbody></table>";
                } else {
                    echo "<div class='alert alert-warning'>No primary fault records found.</div>";
                } ?>
                <form id="primary_delete_form" method="POST" action="" style="display:none;">
                    <input type="hidden" name="primary_delete_id" id="primary_delete_id">
                    <input type="hidden" name="primary_delete" value="1">
                </form>

                <h2 class="mb-4">Insert/Update Secondary Fault Category</h2>
                <form action="" method="POST" onsubmit="return handleSubmit('secondary')" class="mb-4">
                    <div class="form-group">
                        <label for="sfname">Fault Name:</label>
                        <input type="text" class="form-control" id="sfname" name="sfname" required>
                    </div>
                    <div class="form-group">
                        <label for="spf_id">Primary Fault ID:</label>
                        <?php
                        $sql = "SELECT * FROM primary_fault_category;";
                        $res = db_all($sql);
                        $options = "<select class='form-control' id='spf_id' name='spf_id' required>";
                        foreach ($res as $row) {
                            $options .= "<option value='" . $row["PFID"] . "'>" . $row["PFID"] . " : " . $row["PFNAME"] . "</option>";
                        }
                        $options .= "</select>";
                        echo $options;
                        ?>
                    </div>
                    <input type="hidden" id="scid" name="scid">
                    <input type="hidden" id="sform_action" name="sform_action" value="insert">
                    <button type="button" class="btn btn-secondary" onclick="resetForm()">Reset</button>
                    <button type="submit" class="btn btn-primary" name="s_submit">Submit</button>
                </form>
                <h2 class="mb-4">Existing Secondary Fault Records</h2>
                <?php
                $sql = "SELECT sf.*, pf.PFNAME FROM secondary_fault_category sf INNER JOIN primary_fault_category pf on sf.PFID = pf.PFID;";
                $result = db_all($sql);

                if ($result != null) {
                    echo "<table class='table table-bordered'><thead class='thead-dark'><tr><th>CID</th><th>Fault Name</th><th>Primary Fault ID</th><th>Primary Fault Name</th><th>Actions</th></tr></thead><tbody>";
                    foreach ($result as $row) {
                        echo "<tr>";
                        echo "<td>" . $row["CID"] . "</td>";
                        echo "<td>" . $row["FNAME"] . "</td>";
                        echo "<td>" . $row["PFID"] . "</td>";
                        echo "<td>" . $row["PFNAME"] . "</td>";
                        echo "<td>
                    <button class='btn btn-warning btn-sm' onclick='editSecondaryRecord(" . $row["CID"] . ", \"" . addslashes($row["FNAME"]) . "\", " . $row["PFID"] . ")'>Edit</button>
                    <button class='btn btn-danger btn-sm' onclick='confirmRemove(\"secondary\", " . $row["CID"] . ")'>Remove</button>
                </td>";
                        echo "</tr>";
                    }
                    echo "</tbody></table>";
                } else {
                    echo "<div class='alert alert-warning'>No secondary fault records found.</div>";
                }
                ?>

                <form id="secondary_delete_form" method="POST" action="" style="display:none;">
                    <input type="hidden" name="secondary_delete_id" id="secondary_delete_id">
                    <input type="hidden" name="secondary_delete" value="1">
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