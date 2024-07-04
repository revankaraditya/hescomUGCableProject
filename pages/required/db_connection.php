<?php
ini_set('max_execution_time', -1);
$dbhost = 'localhost';
$dbuser = 'root1';
$dbpass = 'root1';
$database = 'newhescom';
$con = mysqli_connect($dbhost, $dbuser, $dbpass, $database);
if (!$con) {
	echo "Failed to connect to MySQL: ";
}
?>