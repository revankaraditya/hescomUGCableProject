<div class="col-lg-3 col-xs-6 col-md-4">
								<!-- small box -->
								<div class="small-box bg-aqua">
									<div class="inner">
										<?php $fault_count_query = "SELECT count(*) AS fault_count FROM fault_records WHERE UID=" . $uid . ";";
										$fault_count = db_one($fault_count_query);
										?>
										<h3><?php echo ($fault_count['fault_count']); ?></h3>
										<p>Faults</p>
									</div>
									<div class="icon">
										<i class="fa fa-pencil"></i>
									</div>
									<button type="button" class="small-box-footer form-control" id="add_res"
										data-toggle="modal" data-target="#add_res_modal">Add<i
											class="fa fa-plus"></i></button>

									<div class="modal fade" id="add_res_modal" role="dialog">
										<div class="modal-dialog modal-lg">
											<div class="modal-content">
												<div class="modal-header bg-primary">
													<button type="button" class="close" data-dismiss="modal"
														aria-label="Close">
														<span aria-hidden="true">&times;</span></button>
													<h4 class="modal-title"> <i class="fa fa-plus"></i> Add Faults</h4>
												</div>
												<span class="help-block">
													<div class="resolution_added_notification">
														<div id="loading_image" style="display:none;"></div>
														<form method="post" id="fault_add" enctype="multipart/form-data"
															role="form">
															<div class="modal-body">
																<div class="form-group">
																	<label class="help-block">Fault Title : <span
																			class="text-danger">*</span></label>
																	<input type="text" id="fault_title" required
																		name="fault_title" class="form-control"
																		placeholder="Enter a title for fault" />
																</div>
																<div class="form-group">
																	<label for="primary" class="help-block">Fault
																		Category:</label>
																	<select id="primary" name="primary_category"
																		onchange="populateSecondary()"
																		class="form-control fault_cat">
																		<option value="" class="help-block">Main Category
																		</option>
																	</select>
																	<br>
																	<select id="secondary" name="secondary_category"
																		class="form-control fault_cat">
																		<option value="" class="help-block">Sub-Category
																		</option>
																	</select>
																</div>
																<div id="additionalFields"></div>
															</div>
															<div class="modal-footer">
																<button type="button"
																	class="btn btn-default pull-left btn-flat"
																	data-dismiss="modal">Close</button>
																<button type="reset" class="btn btn-default btn-flat"></i>
																	Reset</button>
																<button type="submit" class="btn btn-primary btn-flat"
																	id="add_resolution"><i class="fa fa-plus"></i>
																	ADD</button>
															</div>
														</form>
													</div>
												</span><!--end of help block-->
											</div>
											<!-- /.modal-content -->
										</div>
										<!-- /.modal-dialog -->
									</div>
									<!-- /.modal -->
								</div>
							</div>
							<div class="col-lg-8 col-xs-12 col-md-8">
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
									<div class="box-body" style="overflow:auto">
										<?php
										$fault_total_count_query = "SELECT COUNT(*) AS fault_count FROM fault_records WHERE UID=" . $uid . ";";
										$fault_total_count = db_one($fault_total_count_query);

										$fault_on_going_count_query = "SELECT COUNT(*) AS fault_count FROM fault_records WHERE UID=" . $uid . " AND STATUS=1";
										$fault_ongoing_count = db_one($fault_on_going_count_query);

										$fault_Completed_count_query = "SELECT COUNT(*) AS fault_count FROM fault_records WHERE UID=" . $uid . " AND STATUS=0";
										$fault_completed_count = db_one($fault_Completed_count_query);
										?>
										<div class="container">
											<div class="row flex-container">
												<div class="col-md-3  col-sm-6 flex-item">
													<div class="counter blue">
														<div class="counter-icon">
															<i class="fa fa-solid fa-file"></i>
														</div>
														<h3>Total Faults</h3>
														<span
															class="counter-value"><?php echo $fault_total_count['fault_count'] ?></span>
													</div>
												</div>
												<div class="col-md-3 col-sm-6 flex-item">
													<div class="counter orange">
														<div class="counter-icon">
															<i class="fa fa-light fa-file"></i>
														</div>
														<h3>On-Going Faults</h3>
														<span
															class="counter-value"><?php echo $fault_ongoing_count['fault_count'] ?></span>
													</div>
												</div>
												<div class="col-md-3 col-sm-6 flex-item">
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
									</div>
								</div>
							</div>
							<div class="clearfix"></div>
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

						