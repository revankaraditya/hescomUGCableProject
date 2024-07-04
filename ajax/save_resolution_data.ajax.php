<?php
ini_set('display_errors', 1);
?>
<?php
if (session_id() == '') {
    session_start();
    $uid = $_SESSION['uid'];
    $usertype = $_SESSION['usertype'];
}

if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
}
include ('../pages/required/db_connection.php');
include ('../pages/required/tables.php');
require ('../pages/required/functions.php');

//data retrieval
$fault_title = $_POST['fault_title'];
$cid = $_POST['secondary_category'];
$status = 1;

$feeder_name = isset($_POST['feeder_name']) ? $_POST['feeder_name'] : null;
$from = isset($_POST['from']) ? $_POST['from'] : null;
$to = isset($_POST['to']) ? $_POST['to'] : null;
$reason = isset($_POST['reason']) ? $_POST['reason'] : null;
$dtc_name = isset($_POST['dtc_name']) ? $_POST['dtc_name'] : null;
$rmu_location = isset($_POST['rmu_location']) ? $_POST['rmu_location'] : null;

if ($uid == 0 || $cid == 0 || empty($fault_title)) {
    ?>
    <div class="callout callout-warning">
        <h4>Fill the details completely</h4>
        <p>Check Out.</p>
    </div>
    <?php
} else {
    date_default_timezone_set('Asia/Kolkata');
    $q = 'SELECT * FROM stored_month WHERE slno=1;';
    $result = db_one($q);

    $stored_month = $result['month'];
    $counter = $result['count'];

    $current_date = date('Y-m-d');
    $current_month = date('m');

    if ($current_month != $stored_month) {
        $counter = 1;
        $stored_month = $current_month;

        $update_table_name = 'stored_month';
        $update_table_SET = "month=".$current_month;
        $update_table_WHERE = "slno=1";
        $update_result = db_update($update_table_name, $update_table_SET, $update_table_WHERE);

        $update_table_name = 'stored_month';
        $update_table_SET = "count=" . $counter;
        $update_table_WHERE = "slno=1";
        $update_result = db_update($update_table_name, $update_table_SET, $update_table_WHERE);
    } else{
        $counter += 1;
        $update_table_name = 'stored_month';
        $update_table_SET = "count=" . $counter;
        $update_table_WHERE = "slno=1";
        $update_result = db_update($update_table_name, $update_table_SET, $update_table_WHERE);
    }
    $fault_code = date('Ymd') . sprintf('%03d', $counter);
    $fault_records_table_no = 6;
    $fault_records_table_name = "fault_records";
    $fault_status_table_no = 7;
    $fault_status_table_name = "fault_status";
    $fid = 'NULL';
    $slno = 'NULL';

    $insert_values = $fid . "," . $cid . "," . $uid . ",'" . $fault_code . "','" . $fault_title . "','" . $feeder_name . "','" . $from . "','" . $to . "','" . $reason . "','" . $dtc_name . "','" . $rmu_location . "','" . date('Y-m-d') . "'," . $status;
    $Insert_result = db_insert($fault_records_table_no, $fault_records_table_name, $insert_values);
    // echo $Insert_result;
    // echo "<br>";
    $initial_status = 1;
    $fault_status_insert_values = $slno . "," . $Insert_result . ',' . $cid . ',' . $initial_status . ',"' . date('Y-m-d') . '",' . $status;
    $total_insert_result = db_insert($fault_status_table_no, $fault_status_table_name, $fault_status_insert_values);
}

if ($total_insert_result == 1) {
    ?>
    <div class="callout callout-success">
        <h4>Successful</h4>
        <p>Resolution Added.</p>
    </div>
    <?php
} else {
    ?>
    <div class="callout callout-danger">
        <h4>Unable to add resolution</h4>
        <p>Check Out.</p>
    </div>
    <?php
}
?>