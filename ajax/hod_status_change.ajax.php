<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
$FID = $_POST['c1'];
$CID = $_POST['c2'];
$FSID = $_POST['c3'];
//$status_remark = $_POST['c4'];

// if($status_remark==""){
// 	$remark="NULL";
// }else{
// 	$remark=$status_remark;
// }
date_default_timezone_set('Asia/Kolkata');
$MDATE = date('Y-m-d');
$status = 1;

//$remark = '';
//echo $RID.'-'.$CID.'-'.$SID;
$res_status_table_no = 7;
$res_status_table_name = "fault_status";
$res_status_insert_values = 'NULL,' . $FID . ',' . $CID . ',' . $FSID . ',"' . $MDATE . '","' . $status . '"';

$status_change_result = db_insert($res_status_table_no, $res_status_table_name, $res_status_insert_values);

if ($FSID == 8) {
	$update_table_name = 'fault_records';
	$update_table_SET = "STATUS = 0";
	$update_table_WHERE = "FID=" . $FID;
	$update_result = db_update($update_table_name, $update_table_SET, $update_table_WHERE);
}

if ($status_change_result == 1) {

	?>
	<div class="callout callout-success">
		<h4>Successful</h4>
		<?php //echo "The file ". htmlspecialchars( basename($res_doc)). " has been uploaded."; ?>
		<p>Resolution Status Modified.</p>
	</div>
<?php } else { ?>
	<div class="callout callout-danger">
		<h4>Unable to Modify resolution</h4>

		<p>Check Out.</p>
	</div>
<?php } ?>