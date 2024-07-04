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
	<title>Hescom | Dashboard</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
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
	<link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
	<link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
	<link rel="stylesheet" href="bootstrap/css/counter.css">

	<style>
		#datepicker1 {
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
	</style>
</head>

<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">
		<?php include('header.php');?>
		<?php include('sidebar.php');?> 
		<div class="content-wrapper">
			<section class="content">
				<div class="row">
					<section class="col-lg-12 connectedSortable">
					<?php 
						if ($login_query_result['UTNO'] == 1) {
							include('supervisor_index.php');
						}elseif ($login_query_result['UTNO'] == 2) {
							include('section_officer_index.php');
						}elseif ($login_query_result['UTNO'] == 3) {
							include('ug_cable_index.php');
						} elseif ($login_query_result['UTNO'] == 4) {
							include('admin_index.php');
						}
					?>
					</section>
				</div>
			</section>
			<?php mysqli_close($con); ?>
		</div>
		<?php include('footer.php');?>
	</div>
	<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
	<script type="text/javascript" src="plugins/table2excel/dist/jquery.table2excel.min.js"></script>
	<script>
		$(document).ready(function () {
			setInterval('updateClock()', 1000);
			$(document).on('click', '#optionsRadios2', function (e) {
				e.preventDefault();
				var raddio_button_val = $(this).val();
				if (raddio_button_val == 1) {
					$('.upload_image').removeClass('hidden');
					$('.type_text').addClass('hidden');
				} else {
					$('.type_text').removeClass('hidden');
					$('.upload_image').addClass('hidden');
				}
			});
			$(document).on('submit', '#fault_add', function (e) {
				e.preventDefault();
				$.ajax({
					url: 'ajax/save_resolution_data.ajax.php',
					type: 'POST',
					data: new FormData(this),
					processData: false,
					contentType: false,
					success: function (data) {
						$('.resolution_added_notification').html(data);
						setTimeout(function () {
							window.location.reload();
						}, 2000);
					}
				});
			});
			$(document).on('click', '#comp_generate', function (e) {
				e.preventDefault();
				var res_date_val = $('.resolution_date').val();
				var comp_generate_url = 'ajax/compliance_generate.ajax.php';
				if (res_date_val == '') {
					alert('Date Not set');
				} else {
					$("div #loading_image").removeAttr("style");
					$.post(
						comp_generate_url, {
						p1: res_date_val
					},
						function (data, status) {
							$('.compliance-report-content').html(data);
						});
				}
			});

			$(document).on('click', '#export_btn', function (e) {
				var compliance_date = $(this).prev().val();

				$(".compliance_report_table").table2excel({
					name: "Report",
					filename: "ComplianceReport_" + compliance_date,
					fileext: ".xls" 
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
			$('#datepicker1').datepicker({
				autoclose: true,
				setDate: new Date()
			});
			$('#datepicker').datepicker({
				autoclose: true,
				defaultDate: new Date()
			});
			$(".timepicker").timepicker({
				showInputs: false
			});
		});
	</script>

	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
	<script src="plugins/fullcalendar/fullcalendar.min.js"></script>

	<script src="plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
	<script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>

	<script src="plugins/select2/select2.full.min.js"></script>
	<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>

	<script src="plugins/knob/jquery.knob.js"></script>
	<script>
		document.addEventListener("DOMContentLoaded", function () {
			let selectedPFID = null; 
			let selectedCID = null; 
			fetch('getFaults.php')
				.then(response => response.json())
				.then(jsonData => {

					const primaryDropdown = document.getElementById("primary");
					jsonData.primary_fault_category.forEach(primary => {
						const option = document.createElement("option");
						option.value = primary.PFID;
						option.textContent = primary.PFNAME;
						primaryDropdown.appendChild(option);
					});

					window.populateSecondary = function () {
						const primaryID = primaryDropdown.value;
						selectedPFID = primaryID; 
						const secondaryDropdown = document.getElementById("secondary");

						secondaryDropdown.innerHTML = '<option value="">Sub-Category</option>';

						if (primaryID) {
							jsonData.secondary_fault_category
								.filter(secondary => secondary.PFID == primaryID)
								.forEach(secondary => {
									const option = document.createElement("option");
									option.value = secondary.CID;
									option.textContent = secondary.FNAME;
									secondaryDropdown.appendChild(option);
								});
						}

						const additionalFieldsContainer = document.getElementById("additionalFields");
						additionalFieldsContainer.innerHTML = ''; 

						if (selectedPFID) {
							if (selectedPFID == 1) {

								addFormField(additionalFieldsContainer, "Feeder name:", "feeder_name", "text");
								addFormField(additionalFieldsContainer, "From (Location):", "from", "text");
								addFormField(additionalFieldsContainer, "To (Location):", "to", "text");
								addFormField(additionalFieldsContainer, "Fault due to:", "reason", "text");
							} else if (selectedPFID == 2) {

								addFormField(additionalFieldsContainer, "DTC Name:", "dtc_name", "text");
								addFormField(additionalFieldsContainer, "From (Location):", "from", "text");
								addFormField(additionalFieldsContainer, "To (Location):", "to", "text");
							} else if (selectedPFID == 3) {

								addFormField(additionalFieldsContainer, "Feeder Name:", "feeder_name", "text");
								addFormField(additionalFieldsContainer, "RMU location:", "rmu_location", "text");
							}
						}
					}
					function addFormField(container, label, id, type) {
						const div = document.createElement("div");
						div.setAttribute("class", "form-group");
						const labelElem = document.createElement("label");
						labelElem.setAttribute("for", id);
						labelElem.setAttribute("class", "help-block");
						labelElem.textContent = label;
						const input = document.createElement("input");
						input.setAttribute("type", type);
						input.setAttribute("id", id);
						input.setAttribute("name", id); 
						input.setAttribute("class", "form-control");
						div.appendChild(labelElem);
						div.appendChild(input);
						container.appendChild(div);
					}

					populateSecondary();
				})
				.catch(error => console.error('Error fetching data:', error));
		});

	</script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
	<script src="plugins/morris/morris.min.js"></script>

	<script src="plugins/sparkline/jquery.sparkline.min.js"></script>

	<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
	<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

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

	<script type="text/javascript" src="pages/principal/display_dept_overall_stat.php"></script>
	<script src="plugins/chartjs/Chart.min.js"></script>
	<script type="text/javascript" src="pages/principal/display_monthwise_barchart.php"></script>
	<script type="text/javascript" src="pages/principal/display_categorywise_barchart.php"></script>

	<script src="plugins/chartjs/Chart.min.js"></script>

	<script src="dist/js/demo.js"></script>

	<script src="bootstrap/js/counter.js"></script>
</body>

</html>