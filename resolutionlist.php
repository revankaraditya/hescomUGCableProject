<?php ini_set('display_errors', 1);
ini_set('MAX_EXECUTION_TIME', '-1');
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
$loggen_in_query = "SELECT u.*,DATE_FORMAT(u.CDATE, '%b %Y') AS member_since
								FROM users u
								WHERE u.UID=" . $uid;
$login_query_result = db_one($loggen_in_query);
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Hescom | Fault List</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="bootstrap/css/timeline.css">
	<link rel="stylesheet" href="bootstrap/css/timeline-css.css">
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
	<link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
	<link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
	<link rel="stylesheet" href="bootstrap/css/image-zoom.css">
	<style>
		#datepicker {
			z-index: 1151 !important;
		}

		.notification_bg_color {
			background: #C9C5C5
		}

		#loading_image {
			position: fixed;
			top: 0px;
			right: 0px;
			width: 100%;
			height: 100%;
			background-color: #c1bdbb;
			background-image: url('images/loading_processmaker.gif');
			background-repeat: no-repeat;
			background-position: center;
			z-index: 10000000;
			opacity: 0.4;
		}

		.hiddenRow {
			padding: 0 !important;
		}
	</style>
</head>

<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">
		<?php include ('header.php'); ?>
		<?php include ('sidebar.php'); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					Faults List
				</h1>
			</section>
			<section class="content">
				<div class="row">
				</div>
				<div class="row">
					<section class="col-lg-12 connectedSortable">
							<div class="col-md-12 col-lg-12 col-sm-4">
								<div class="nav-tabs-custom">
									<ul class="nav nav-tabs">
										<li class="active"><a href="#on-going" data-toggle="tab"> On-going</a></li>
										<li><a href="#completed" data-toggle="tab">Completed</a></li>
									</ul>
									<div class="tab-content">
										<?php include ('ongoing_faults.php'); ?>
										<?php include ('completed_faults.php'); ?>
									</div>
								</div>
							</div>
						<div class="clearfix"></div>
					</section>
				</div>
			</section>
			<?php mysqli_close($con); ?>
		</div>
		<?php include ('footer.php'); ?>
	</div>
	<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
	<script>
		$(document).ready(function () {
			setInterval('updateClock()', 1000);
			$(document).on('click', '.hod_view_res, #ch_status', function () {
				if ($(this).parent().parent().hasClass("danger")) {
					$(this).parent().parent().removeClass("danger");
				} else {
					$(this).parent().parent().addClass("danger");
				}
			});

			$(document).on('click', '#hod_status_change_btn', function (e) {
				e.preventDefault();
				var FID = $(this).parent().find('.fid').val();
				var CID = $(this).parent().find('.cid').val();
				var FSID = $(this).parent().prev().find('.fault_status_id').val();
				var change_status_url = 'ajax/hod_status_change.ajax.php';
				if (FSID == 0) {
					alert('Please Select the appropriate STATUS for resolution');
				} else {
					$("div #loading_image").removeAttr("style");
					$.post(
						change_status_url, {
						c1: FID, c2: CID, c3: FSID
					},
						function (data, status) {
							$('.status_change_notification').html(data);
							setTimeout(function () {
								window.location.reload();
							}, 2000);
						});
				}
			});

			$(document).on('submit', '#res_update', function (e) {
				e.preventDefault();
				$("div #loading_image").removeAttr("style");
				$.ajax({
					url: 'ajax/update_resolution_data.ajax.php',
					type: 'POST',
					data: new FormData(this),
					processData: false,
					contentType: false,
					success: function (data) {
						$('.resolution_updated_notification').html(data);
						setTimeout(function () {
							window.location.reload();
						}, 2000);
					}
				});
			});


			$(document).on('click', '.inpu_box_button', function (e) {
				e.preventDefault();
				var content = '<label class="help-block"><span class="text-info"> Your Custom Status</span></label><div class="input-group form-group col-md-12"><input type="text" class="form-control custom_status"/><div class="input-group-btn"><button class="btn btn-danger btn-flat remove_input_box"><i class="fa fa-times"></button></div></div>';
				$('.custom_status_container').html(content);

			});


			$(document).on('click', '.remove_input_box', function (e) {
				e.preventDefault();
				$('.custom_status_container').empty();
			});

			$(document).on('click', '#hod_status_additiopn', function (e) {
				e.preventDefault();
				var RID = $(this).parent().find('.Res_id').val();
				var CID = $(this).parent().find('.cat_id').val();

				var custom_status = $(this).parent().prev().find('.custom_status').val();
				var change_status_url = 'ajax/hod_status_addition.ajax.php';
				if (custom_status == undefined || custom_status == "") {
					alert('Please Select the appropriate STATUS for resolution');
				} else {
					$("div #loading_image").removeAttr("style");
					$.post(
						change_status_url, {
						c1: RID, c2: CID, c3: custom_status
					},
						function (data, status) {
							$('.status_change_notification').html(data);
							setTimeout(function () {
								window.location.reload();
							}, 2000);
							$(this).addAttr('disabled');
						});
				}
			});


			$(document).on('click', '.res_complete_btn', function (e) {
				e.preventDefault();
				var Complete_res_url = 'ajax/hod_resolution_complete.ajax.php';
				var Res_Id = $(this).parents().find('.res_row_pkey').val();
				$("div #loading_image").removeAttr("style");
				$.post(
					Complete_res_url, {
					R1: Res_Id
				},
					function (data, status) {
						$('.res_complete_notification').html(data);
						setTimeout(function () {
							window.location.reload();
						}, 2000);

					});
			});
			$(document).ajaxSend(function (event, request, settings) {
				$('#loading_image').show();
			});

			$(document).ajaxComplete(function (event, request, settings) {
				$('#loading_image').hide();
			});
		});
	</script>
	<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
	<script>
		$.widget.bridge('uibutton', $.ui.button);
	</script>
	<script>
		$(function () {
			$('#datepicker').datepicker({
				autoclose: true
			});
			$(".timepicker").timepicker({
				showInputs: false
			});
		});

		function printModalContent(fault_id) {
			var ele_id = 'ch_status' + fault_id;
			var printContents = document.getElementById(ele_id).innerHTML;
			var originalContents = document.body.innerHTML;
			document.body.innerHTML = printContents;
			window.print();
			document.body.innerHTML = originalContents;
			window.location.reload(); 
		}

	</script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
	<script src="plugins/fullcalendar/fullcalendar.min.js"></script>
	<script src="plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
	<script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
	<script src="plugins/select2/select2.full.min.js"></script>
	<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
	<script src="plugins/morris/morris.min.js"></script>
	<script src="plugins/sparkline/jquery.sparkline.min.js"></script>
	<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
	<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
	<script src="plugins/knob/jquery.knob.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
	<script src="plugins/daterangepicker/daterangepicker.js"></script>
	<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
	<script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
	<script src="plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
	<script src="plugins/date_time/date_time.js"></script>
	<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
	<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
	<script src="plugins/fastclick/fastclick.js"></script>
	<script src="dist/js/app.min.js"></script>
	<script src="plugins/chartjs/Chart.min.js"></script>
	<script src="dist/js/demo.js"></script>
	<script>
		$(function () {
			$("#example1").DataTable({
				"paging": true,
				"lengthChange": true,
				"searching": false,
				"ordering": true,
				"info": true,
				"autoWidth": true
			});
			$('#example2').DataTable({
				"paging": true,
				"lengthChange": true,
				"searching": false,
				"ordering": true,
				"info": true,
				"autoWidth": true
			});
		});
	</script>
</body>

</html>