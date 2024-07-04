<?php ini_set('display_errors', 1);

if (session_id() == '') {
	session_start();
	$uid = $_SESSION['uid'];
	$usertype = $_SESSION['usertype'];
}

if (!isset($_SESSION['logged_in'])) {
	header("Location: login.php");
}
include ('../pages/required/db_connection.php');
include ('../pages/required/functions.php');
include ('../pages/required/tables.php');


//data retrieval
$res_date = db_date($_POST['p1']);


if($usertype!=2){
$res_query = "SELECT fr.*, sfc.FNAME, DATE_FORMAT(fr.CRDATE,'%D-%b-%Y') AS res_date
											  FROM 
													fault_records fr 
													INNER JOIN secondary_fault_category sfc ON sfc.CID=fr.CID
											   WHERE fr.CRDATE='" . $res_date . "'";
}else{
	$res_query = "SELECT fr.*, sfc.FNAME, DATE_FORMAT(fr.CRDATE,'%D-%b-%Y') AS res_date
											  FROM 
													fault_records fr 
													INNER JOIN secondary_fault_category sfc ON sfc.CID=fr.CID
											   WHERE fr.CRDATE='".$res_date."' AND UID=".$uid.";";
}
$res_rows = db_all($res_query);



?>
<div class="col-xs-12">
	<div class="box box-info">
		<div class="box-header">
			<h3 class="box-title">Faults Report for <?php echo ui_date($res_date); ?></h3>
			<input type="hidden" class="compliance_date" value="<?php echo ui_date($res_date); ?>">
			<button class="btn btn-success pull-right" id="export_btn"><i class="fa fa-download"></i> Export to
				Excel</button>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
			<?php 
			if($usertype!=2){
			$res_on_going_count_query = "SELECT COUNT(*) AS res_count FROM fault_records WHERE STATUS=1 AND CRDATE='" . $res_date . "'";
			$res_ongoing_count = db_one($res_on_going_count_query);

			$res_Completed_count_query = "SELECT COUNT(*) AS res_count FROM fault_records WHERE STATUS=0 AND CRDATE='" . $res_date . "'";
			$res_completed_count = db_one($res_Completed_count_query);
			}else{
			$res_on_going_count_query = "SELECT COUNT(*) AS res_count FROM fault_records WHERE STATUS=1 AND UID=".$uid." AND CRDATE='" . $res_date . "'";
			$res_ongoing_count = db_one($res_on_going_count_query);

			$res_Completed_count_query = "SELECT COUNT(*) AS res_count FROM fault_records WHERE STATUS=0 AND UID=".$uid." AND CRDATE='" . $res_date . "'";
			$res_completed_count = db_one($res_Completed_count_query);
			}
			?>
			<div class="col-md-12">
				<div class="col-md-3 col-sm-6">
					<div class="counter orange">
						<div class="counter-icon">
							<i class="fa fa-light fa-file"></i>
						</div>
						<h3>On-Going Faults (<?php echo ui_date($res_date); ?>)</h3>
						<span class="counter-value"><?php echo $res_ongoing_count['res_count'] ?></span>
					</div>
				</div>
				<div class="col-md-3 col-sm-6">
					<div class="counter green">
						<div class="counter-icon">
							<i class="fa fa-duotone fa-file"></i>
						</div>
						<h3>Completed Faults (<?php echo ui_date($res_date); ?>)</h3>
						<span class="counter-value"><?php echo $res_completed_count['res_count'] ?></span>
					</div>
				</div>

			</div>
			<div class="clearfix"></div>
			<table id="example1" class="table table-bordered table-hover compliance_report_table">
				<caption>Faults Report for <?php echo ui_date($res_date); ?></caption>
				<thead>
					<tr>
						<th>FID</th>
						<th>Fault Title</th>
						<th>Category</th>
						<th>Fault code</th>
						<th>Current Status</th>
						<th>Mofification Date</th>
					</tr>

				</thead>
				<tbody>
					<?php

					$res_str = "";
					$i = 1;
					if (!empty($res_rows)) {
						foreach ($res_rows as $row) {

							$current_status_query = "SELECT fs.MDATE, frs.NAME 
														FROM fault_status fs 
														INNER JOIN fault_resolution_steps frs ON frs.CID=fs.CID AND fs.FSID=frs.FSID
														WHERE fs.FID=" . $row['FID'] . " ORDER BY fs.FSID DESC LIMIT 1";
							//echo $current_status_query;
							$current_status_answer = db_one($current_status_query);
							$res_str .= "<tr class='" . ($row['STATUS'] == 0 ? 'bg-olive' : 'bg-gray') . "'>
											  <td>" . $row['FID'] . "</td>
											  <td>" . $row['FAULT_TITLE'] . "</td>
											  <td>" . $row['FNAME'] . "</td>
											  <td>" . $row['FAULT_CODE'] . "</td>
											  <td>" . $current_status_answer['NAME'] . "</td>
											  <td>" . $current_status_answer['MDATE'] . "</td>
											</tr>";
							$i++;

						}
					} else {
						$res_str .= "<tr>
											<td colspan='7'>No Faults available.</td>
										</tr>";


					}
					echo $res_str;


					?>
				</tbody>

			</table>
		</div>
		<!-- /.box-body -->
	</div>
	<!-- /.box -->

</div>