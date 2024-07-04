<div class="col-lg-12 col-xs-12 col-md-12">
								<div class="box box-primary">
									<div class="box-header with-border">
										<h3 class="box-title">Fault - Statistics </h3>

										<div class="box-tools pull-right">
											<button type="button" class="btn btn-box-tool" data-widget="collapse"><i
													class="fa fa-minus"></i>
											</button>
											<!--button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button-->
										</div>
									</div>
									<div class="box-body">
										<?php
										$fault_total_count_query = "SELECT COUNT(*) AS fault_count FROM fault_records WHERE 1=1";
										$fault_total_count = db_one($fault_total_count_query);

										$fault_on_going_count_query = "SELECT COUNT(*) AS fault_count FROM fault_records WHERE 1=1 AND STATUS=1";
										$fault_ongoing_count = db_one($fault_on_going_count_query);

										$fault_Completed_count_query = "SELECT COUNT(*) AS fault_count FROM fault_records WHERE 1=1 AND STATUS=0";
										$fault_completed_count = db_one($fault_Completed_count_query);
										?>
										<!--div class="col-xs-4 col-md-4 col-lg-6 text-center" style="border-right: 1px solid #3A00FF">
									  <input type="text" class="knob" data-readonly="true" value="" data-width="100" data-height="100" data-fgColor="#3A00FF">

										  <div class="knob-label">Total Number of Resolution</div>
										</div-->
										<!--Counter Starts -->
										<div class="container">
											<div class="row">
												<div class="col-md-3 col-sm-6">
													<div class="counter blue">
														<div class="counter-icon">
															<i class="fa fa-solid fa-file"></i>
														</div>
														<h3>Total Faults</h3>
														<span
															class="counter-value"><?php echo $fault_total_count['fault_count'] ?></span>
													</div>
												</div>
												<div class="col-md-3 col-sm-6">
													<div class="counter orange">
														<div class="counter-icon">
															<i class="fa fa-light fa-file"></i>
														</div>
														<h3>On-Going Faults</h3>
														<span
															class="counter-value"><?php echo $fault_ongoing_count['fault_count'] ?></span>
													</div>
												</div>
												<div class="col-md-3 col-sm-6">
													<div class="counter green">
														<div class="counter-icon">
															<i class="fa fa-duotone fa-file"></i>
														</div>
														<h3>Completed Faults</h3>
														<span
															class="counter-value"><?php echo $fault_completed_count['fault_count'] ?></span>
													</div>
												</div>
											</div>
										</div>
										<!--Counter ENds-->
									</div>
								</div>
							</div>
							<div class="col-lg-12 col-xs-12 col-md-12">
								<div class="box box-warning">
									<div class="box-header with-border">
										<h3 class="box-title">Faults - History </h3>
										<div class="box-tools pull-right">
											<button type="button" class="btn btn-box-tool" data-widget="collapse"><i
													class="fa fa-minus"></i>
											</button>
										</div>
									</div>
									<div class="box-body">
										<form>
											<div class="form-group col-md-4">
												<div class="input-group date">
													<div class="input-group-addon">
														<i class="fa fa-calendar"></i>
													</div>
													<input type="text" required
														class="form-control pull-right resolution_date" name=""
														placeholder="Fault Date" id="datepicker">
												</div>
											</div>
											<div class="form-group col-md-4">
												<button type="button" class="btn btn-primary" id="comp_generate"><i
														class="fa fa-search"></i> Search</button>
											</div>
										</form>
										<div class="compliance-report-content">
											<div id="loading_image" style="display:none;"></div>
										</div>

									</div>
								</div>
							</div>