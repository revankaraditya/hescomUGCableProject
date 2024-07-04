<?php ini_set('display_errors', 1);

if (session_id() == '') {
	session_start();
	$uid = $_SESSION['uid'];
	$usertype = $_SESSION['usertype'];
}

if (!isset($_SESSION['logged_in'])) {
	header("Location: login.php");
}
include ('../required/db_connection.php');
include ('../required/functions.php');
include ('../required/tables.php');

	
	$so1_query = "SELECT count(*) AS so1_count FROM fault_records fm WHERE UID=4";
	$so1_count = db_one($so1_query);

	$so2_query = "SELECT count(*) AS so2_count FROM fault_records fm WHERE UID=5";
	$so2_count = db_one($so2_query);

	$so3_query = "SELECT count(*) AS so3_count FROM fault_records fm WHERE UID=6";
	$so3_count = db_one($so3_query);

	$so4_query = "SELECT count(*)AS so4_count FROM fault_records fm WHERE UID=7";
	$so4_count = db_one($so4_query);

	$so5_query = "SELECT count(*) AS so5_count FROM fault_records fm WHERE UID=8";
	$so5_count = db_one($so5_query);

	$so6_query = "SELECT count(*) AS so6_count FROM fault_records fm WHERE UID=9";
	$so6_count = db_one($so6_query);

	$so7_query = "SELECT count(*) AS so7_count FROM fault_records fm WHERE UID=10";
	$so7_count = db_one($so7_query);

	$so8_query = "SELECT count(*) AS so8_count FROM fault_records fm WHERE UID=11";
	$so8_count = db_one($so8_query);

	$so9_query = "SELECT count(*) AS so9_count  FROM fault_records fm WHERE UID=12";
	$so9_count = db_one($so9_query);
	
$value = '[
    {
      value: '.($so1_count["so1_count"]==0?0:$so1_count["so1_count"]).',
      color: "#F4D03F",
      highlight: "#F4D03F",
      label: "Section Officer 1"
    },
    {
      value: '.($so2_count['so2_count']==0?0: $so2_count['so2_count']).',
      color: "#00a65a",
      highlight: "#00a65a",
      label: "Section Officer 2"
    },
    {
      value: '.($so3_count['so3_count']==0?0: $so3_count['so3_count']).',
      color: "#A1EBE8",
      highlight: "#A1EBE8",
      label: "Section Officer 3"
    },
	{
      value: '.($so4_count['so4_count']==0?0: $so4_count['so4_count']).',
      color: "#C8E224",
      highlight: "#C8E224",
      label: "Section Officer 4"
    },
	{
		value: '.($so5_count["so5_count"]==0?0:$so5_count["so5_count"]).',
		color: "#F4D03F",
		highlight: "#F4D03F",
		label: "Section Officer 5"
	  },
	  {
		value: '.($so6_count['so6_count']==0?0: $so6_count['so6_count']).',
		color: "#00a65a",
		highlight: "#00a65a",
		label: "Section Officer 6"
	  },
	  {
		value: '.($so7_count['so7_count']==0?0: $so7_count['so7_count']).',
		color: "#A1EBE8",
		highlight: "#A1EBE8",
		label: "Section Officer 7"
	  },
	  {
		value: '.($so8_count['so8_count']==0?0: $so8_count['so8_count']).',
		color: "#C8E224",
		highlight: "#C8E224",
		label: "Section Officer 8"
	  },
	  {
		value: '.($so9_count['so9_count']==0?0: $so9_count['so9_count']).',
		color: "#C8E224",
		highlight: "#C8E224",
		label: "Section Officer 9"
	  },
  ]';
  
  $data = $value;