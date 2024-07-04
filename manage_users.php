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
    if (isset($_POST['submit'])) {
        handleUserForm();
    } elseif (isset($_POST['delete'])) {
        handleUserDelete();
    }
}

function handleUserForm()
{
    $name = $_POST["name"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $phone = $_POST["phone"];
    $utno = $_POST["utno"];
    $uid = $_POST["uid"];
    $form_action = $_POST["form_action"];

    $q = "SELECT password FROM users WHERE uid='.$uid.'";
    $prev_password = db_one($q);
    if ($prev_password != $password) {
        $password = md5($password);
    }

    if ($form_action == "update" && !empty($uid)) {
        $sql = "UPDATE users SET NAME='$name', EMAIL='$email', USERNAME='$username', PASSWORD='$password', PHONE='$phone', UTNO='$utno' WHERE UID='$uid'";
    } else {
        $sql = "INSERT INTO users (NAME, EMAIL, USERNAME, PASSWORD, PHONE, UTNO) VALUES ('$name', '$email', '$username', '$password', '$phone', '$utno')";
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

function handleUserDelete()
{
    $uid = $_POST["delete_uid"];
    $sql = "DELETE FROM users WHERE UID='$uid'";
    $res = db_execute($sql);

    if ($res !== FALSE) {
        $_SESSION['message'] = "Record with UID = $uid successfully removed!";
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
    <title>Manage Users</title>
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
        function editUser(uid, name, email, username, password, phone, utno) {
            document.getElementById("uid").value = uid;
            document.getElementById("name").value = name;
            document.getElementById("email").value = email;
            document.getElementById("username").value = username;
            document.getElementById("password").value = password;
            document.getElementById("phone").value = phone;
            document.getElementById("utno").value = utno;
            document.getElementById("form_action").value = "update";
        }

        function resetForm() {
            location.reload(); // Refresh the page
        }

        function confirmInsert() {
            var name = document.getElementById("name").value;
            var email = document.getElementById("email").value;
            var username = document.getElementById("username").value;
            var password = document.getElementById("password").value;
            var phone = document.getElementById("phone").value;
            var utno = document.getElementById("utno").value;

            var message = "Are you sure you want to insert the following record?\n\n";
            message += "Name: " + name + "\n";
            message += "Email: " + email + "\n";
            message += "Username: " + username + "\n";
            message += "Password: " + password + "\n";
            message += "Phone: " + phone + "\n";
            message += "User Type No: " + utno;

            return confirm(message);
        }

        function confirmUpdate() {
            var name = document.getElementById("name").value;
            var email = document.getElementById("email").value;
            var username = document.getElementById("username").value;
            var password = document.getElementById("password").value;
            var phone = document.getElementById("phone").value;
            var utno = document.getElementById("utno").value;
            var uid = document.getElementById("uid").value;

            var message = "Are you sure you want to update the following record?\n\n";
            message += "UID: " + uid + "\n";
            message += "Name: " + name + "\n";
            message += "Email: " + email + "\n";
            message += "Username: " + username + "\n";
            message += "Password: " + password + "\n";
            message += "Phone: " + phone + "\n";
            message += "User Type No: " + utno;

            return confirm(message);
        }

        function confirmRemove(uid) {
            var message = "Are you sure you want to remove the record with UID: " + uid + "?";
            if (confirm(message)) {
                document.getElementById('delete_uid').value = uid;
                document.getElementById('delete_form').submit();
                return true;
            }
            return false;
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
            <div class="container mt-5">
                <?php
                if (isset($_SESSION['message'])) {
                    echo "<div class='alert alert-info'>" . $_SESSION['message'] . "</div>";
                    unset($_SESSION['message']);
                }
                ?>
                <h2 class="mb-4">Insert / Update User Accounts</h2>
                <form action="" method="POST" onsubmit="return handleSubmit()" class="mb-4">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="username">Username:</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="phone">Phone:</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="utno">User Type No:</label>
                            <?php
                            $sql = "SELECT * FROM usertype;";
                            $res = db_all($sql);
                            $options = "<select class='form-control' id='utno' name='utno' required>";
                            foreach ($res as $row) {
                                $options .= "<option value='" . $row["UTNO"] . "'>" . $row["UTNO"] . " : " . $row["name"] . "</option>";
                            }
                            $options .= "</select>";
                            echo $options;
                            ?>
                        </div>
                    </div>
                    <input type="hidden" id="uid" name="uid">
                    <input type="hidden" id="form_action" name="form_action" value="insert">
                    <button type="button" class="btn btn-secondary" onclick="resetForm()">Reset</button>
                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                </form>

                <h2 class="mb-4">Existing User Records</h2>
                <?php
                $sql = "SELECT u.*, ut.name AS UTNAME FROM users u INNER JOIN usertype ut on u.UTNO = ut.UTNO;";
                $result = db_all($sql);

                if ($result != null) {
                    echo "<div class='table-responsive'><table class='table table-bordered'><thead class='thead-dark'><tr><th>UID</th><th>Name</th><th>Email</th><th>Username</th><th>Password</th><th>Phone</th><th>User Type No</th><th>User Type Name</th><th>Actions</th></tr></thead><tbody>";
                    foreach ($result as $row) {
                        echo "<tr>";
                        echo "<td>" . $row["UID"] . "</td>";
                        echo "<td>" . $row["NAME"] . "</td>";
                        echo "<td>" . $row["EMAIL"] . "</td>";
                        echo "<td>" . $row["USERNAME"] . "</td>";
                        echo "<td>" . $row["PASSWORD"] . "</td>";
                        echo "<td>" . $row["PHONE"] . "</td>";
                        echo "<td>" . $row["UTNO"] . "</td>";
                        echo "<td>" . $row["UTNAME"] . "</td>";
                        echo "<td>
                    <button class='btn btn-warning btn-sm' onclick='editUser(" . $row["UID"] . ", \"" . addslashes($row["NAME"]) . "\", \"" . addslashes($row["EMAIL"]) . "\", \"" . addslashes($row["USERNAME"]) . "\", \"" . addslashes($row["PASSWORD"]) . "\", \"" . $row["PHONE"] . "\", " . $row["UTNO"] . ")'>Edit</button>
                    <button class='btn btn-danger btn-sm' onclick='confirmRemove(" . $row["UID"] . ")'>Remove</button>
                </td>";
                        echo "</tr>";
                    }
                    echo "</tbody></table></div>";
                } else {
                    echo "<div class='alert alert-warning'>No user records found.</div>";
                }
                ?>

                <form id="delete_form" method="POST" action="" style="display:none;">
                    <input type="hidden" name="delete_uid" id="delete_uid">
                    <input type="hidden" name="delete" value="1">
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