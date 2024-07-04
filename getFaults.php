<?php ini_set('display_errors', 1);

if (session_id() == '') {
	session_start();
	$uid = $_SESSION['uid'];
	$usertype = $_SESSION['usertype'];
}

if (!isset($_SESSION['logged_in'])) {
	header("Location: login.php");
}
include ('pages/required/db_connection.php');
include ('pages/required/functions.php');
include ('pages/required/tables.php');

$sqlPrimary = "SELECT PFID, PFNAME FROM primary_fault_category";
$resultPrimary = $con->query($sqlPrimary);

$primaryFaultCategories = array();

if ($resultPrimary->num_rows > 0) {
    while($row = $resultPrimary->fetch_assoc()) {
        $primaryFaultCategories[] = $row;
    }
}

$sqlSecondary = "SELECT CID, FNAME, PFID FROM secondary_fault_category";
$resultSecondary = $con->query($sqlSecondary);

$secondaryFaultCategories = array();

if ($resultSecondary->num_rows > 0) {
    while($row = $resultSecondary->fetch_assoc()) {
        $secondaryFaultCategories[] = $row;
    }
}
$response = array(
    "primary_fault_category" => $primaryFaultCategories,
    "secondary_fault_category" => $secondaryFaultCategories
);

echo json_encode($response);

mysqli_close($con);
