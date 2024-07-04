<?php
ini_set('max_execution_time', -1);
$dbhost = 'localhost';
$dbuser = 'hescomUser';
$dbpass = 'Hescom@123';
$database = 'newHescom';
$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	 if(!$con )
	  {
	  echo "Failed to connect to MySQL: ";
	  }
?>
