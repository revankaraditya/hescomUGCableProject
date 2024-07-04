<div class="tab-pane active" id="on-going">
    <div class="col-xs-12 col-lg-12 col-md-12 ">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">On-going Faults List for
                    <?php if (isset($_SESSION['name'])) {
                        echo $_SESSION['name'];
                    } ?>
                </h3>
            </div>
            <div class="box-body" style="overflow:scroll;">
                <table id="example1" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>FID</th>
                            <th>Fault Title</th>
                            <th>Category</th>
                            <th>Fault-Code</th>
                            <th>Fault Date</th>
                            <th>Section Officer</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($login_query_result['UTNO'] == 2) {
                            $query_ug = "select fr.*,c.fname,u.name from fault_records fr inner join secondary_fault_category c on fr.cid=c.cid inner join users u on fr.uid=u.uid where fr.status=1 and fr.uid=" . $uid . "";
                        } else {
                            $query_ug = "select fr.*,c.fname,u.name from fault_records fr inner join secondary_fault_category c on fr.cid=c.cid inner join users u on fr.uid=u.uid where fr.status=1;";
                        }
                        $query_result_ug = db_all($query_ug);
                        $fault_str = "";
                        $i = 1;
                        $dot_color_array = array('b-primary', 'b-warning', 'b-danger', 'b-success');
                        foreach ($query_result_ug as $row) {
                            $fault_str .= "
														<tr>
														  <td>" . $row['FID'] . "</td>
														  <td>" . $row['FAULT_TITLE'] . "</td>
														  <td>" . $row['fname'] . "</td>
														  <td>" . $row['FAULT_CODE'] . "</td>
														  <td>" . $row['CRDATE'] . "</td>
														  <td>" . $row['name'] . "
														  </td>
														  <td>
														  <button type='button' class='btn btn-primary hod_view_res' data-toggle='modal' data-target='#view_resolution" . $row['FID'] . "'> <i class='fa fa-eye'></i></button>
																	<div class='modal fade' id='view_resolution" . $row['FID'] . "' role='dialog'>
																	  <div class='modal-dialog modal-lg'>
																		<div class='modal-content'>
																			<div class='modal-header bg-primary'>
																				<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
																				  <span aria-hidden='true'>&times;</span></button>
																				<h4 class='modal-title'>View Faults</h4>
																			</div>
																			<div class='modal-body'>
																			<div class='modal-body'>
                                                                            </div>
																					<div class='clearfix'></div>
																					<h3>Fault Status</h3>
																							<!--Timeline Starts Here-->
																							<div class='padding'>";
                            $fault_status_added_query = "SELECT 
																										*
																										,DATE_FORMAT(fs.MDATE,'%d-%M-%Y') AS fault_mod_date
																									   FROM 
																										fault_status fs
																										INNER JOIN fault_resolution_steps frs ON fs.CID = frs.CID  
																									   WHERE fs.STATUS = 1
																									   AND FID=" . $row['FID'] . "
																									   AND fs.FSID=frs.FSID;";
                            $fault_status_added = db_all($fault_status_added_query);

                            $fault_status_remaining_query = "SELECT 
																									frs.FSID,frs.NAME
																								FROM 
																									fault_resolution_steps frs
																								WHERE 
																									1=1
																									AND frs.CID=" . $row['CID'] . "
																									AND frs.FSID NOT IN (SELECT FSID FROM fault_status WHERE 1=1 AND FID=" . $row['FID'] . ")";
                            $fault_status_remaining = db_all($fault_status_remaining_query);

                            $fault_status_last_added_query = "SELECT 
																										*
																										,DATE_FORMAT(fs.MDATE,'%d-%M-%Y') AS fault_mod_date
																									   FROM 
																										fault_status fs
																										INNER JOIN fault_resolution_steps frs ON fs.CID = frs.CID 
																									   WHERE 1=1 
																									   AND fs.STATUS = 1
																											AND fs.FID=" . $row['FID'] . "
																										ORDER BY fs.FSID desc
																										LIMIT 1;";
                            $fault_status_last_added = db_all($fault_status_last_added_query);

                            $fault_str .= "<div class='row'>
																										<div class='col-md-12'>
																											<div class='timeline p-4 block mb-4'>";
                            $j = 1;
                            foreach ($fault_status_added as $added_row) {
                                $j++;
                                $fault_str .= "<div class='tl-item " . ($fault_status_last_added[0]['FSID'] == $j ? 'active' : '') . "'>
																															<div class='tl-dot " . ($fault_status_last_added[0]['FSID'] != $j ? 'b-success' : 'b-warning') . " '></div>
																															<div class='tl-content'>
																																<div class=''><h4>" . $added_row['NAME'] . "</h4></div>
																																<div class='tl-date text-muted mt-1'><h5>" . $added_row['fault_mod_date'] . "</h5></div>
																															</div>
																														</div>";
                            }
                            foreach ($fault_status_remaining as $rem_row) {
                                $fault_str .= "<div class='tl-item'>
																														<div class='tl-dot b-warning'></div>
																														<div class='tl-content'>
																															<div class=''><h4>" . $rem_row['NAME'] . "</h4></div>
																															<div class='tl-date text-muted mt-1'><h6>about to happen</h6></div>
																														</div>
																													</div>";
                            }
                            $fault_str .= "</div>
																										</div>
																									</div>
																									<div class='clearfix'></div>
																								</div>
																							<!--Timeline Ends here-->";
                            $fault_str .= "<div class='clearfix'></div>
																			</div>
																			<div class='modal-footer'>
																				<button type='button' class='btn btn-default btn-flat pull-left' data-dismiss='modal'>Close</button>
																				
																			</div>
																	</div>
																	<!-- /.modal-content -->
																  </div>
																  <!-- /.modal-dialog -->
																</div>
																<!-- /.modal -->
																<!-- Edit modal -->";
                            $fault_str .= "<button type='button' class='btn btn-warning' id='ch_status' data-toggle='modal' data-target='#ch_status" . $row['FID'] . "'> <i class='fa fa-edit'></i></button>
																	<div class='modal fade' id='ch_status" . $row['FID'] . "' role='dialog'>
																	  <div class='modal-dialog modal-lg'>
																		<div class='modal-content'>
																			<div class='modal-header bg-primary'>
																				<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
																				  <span aria-hidden='true'>&times;</span></button>
																				<h4 class='modal-title'> <i class='fa fa-exchange'></i> Change Status</h4>
																			</div>
																			<span class='help-block'>
																				<div class='status_change_notification'>
																					<div id='loading_image' style='display:none;'></div>
																				</div>
																			</span>
																			<div class='modal-body'>
																				<div class='form-group col-md-12'>";
                            $fault_str .= "</div>
																				<div class='form-group col-md-6'>
																					<label class='help-block'>Fault Code</label>
																						<h4>" . $row['FAULT_CODE'] . "</h4>
																				</div>
																				<div class='form-group col-md-6'>
																					<label class='help-block'> Fault Title </label>
																						<h4>" . $row['FAULT_TITLE'] . "</h4>
																				</div>
																				<div class='form-group col-md-6'>
																					<label class='help-block'> Fault Category </label>
																						<h4>" . $row['fname'] . "</h4>
																				</div>";

                            if ($row['FEEDER_NAME'] != null) {
                                $fault_str .= "<div class='form-group col-md-6'>
																			<label class='help-block'> Feeder Name </label>
																				<h4>" . $row['FEEDER_NAME'] . "</h4>
																			</div>";
                            }
                            if ($row['DTC_NAME'] != null) {
                                $fault_str .= "<div class='form-group col-md-6'>
																			<label class='help-block'> DTC Name </label>
																				<h4>" . $row['DTC_NAME'] . "</h4>
																			</div>";
                            }
                            if ($row['FROM'] != null) {
                                $fault_str .= "<div class='form-group col-md-6'>
																			<label class='help-block'> From Location </label>
																				<h4>" . $row['FROM'] . "</h4>
																			</div>";
                            }
                            if ($row['TO'] != null) {
                                $fault_str .= "<div class='form-group col-md-6'>
																			<label class='help-block'> To Location </label>
																				<h4>" . $row['TO'] . "</h4>
																			</div>";
                            }
                            if ($row['REASON'] != null) {
                                $fault_str .= "<div class='form-group col-md-6'>
																			<label class='help-block'>Fault Due To</label>
																				<h4>" . $row['REASON'] . "</h4>
																			</div>";
                            }
                            if ($row['RMU_LOCATION'] != null) {
                                $fault_str .= "<div class='form-group col-md-6'>
																			<label class='help-block'> RMU Location </label>
																				<h4>" . $row['RMU_LOCATION'] . "</h4>
																			</div>";
                            }
                            if ($login_query_result['UTNO'] != 1) {
                                $current_status_query = "SELECT * FROM fault_status fs INNER JOIN fault_resolution_steps frs ON fs.CID = frs.CID AND fs.FSID=frs.FSID WHERE fs.FID=" . $row['FID'] . " ORDER BY fs.SLNO DESC LIMIT 1;";
                                $current_status_result = db_one($current_status_query);
                                $fault_str .= "<div class='form-group col-md-6'>
																								<label class='help-block'> Current Status </label>
																									<h4>" . $current_status_result['NAME'] . "</h4>
																							</div>";
                                $availabl_list_query = "SELECT * FROM fault_status fs INNER JOIN fault_resolution_steps frs ON frs.CID = fs.CID WHERE fs.CID=" . $row['CID'] . " AND fs.FID=" . $row['FID'] . " AND frs.FSID=fs.FSID;";
                                $availabl_list_result = db_all($availabl_list_query);
                                $remaining_status_query = "SELECT * FROM `fault_resolution_steps` WHERE 1=1 AND CID=" . $row['CID'] . " AND FSID NOT IN (SELECT FSID FROM fault_status WHERE 1=1 AND CID=" . $row['CID'] . " AND FID=" . $row['FID'] . ");";
                                $remaining_status_result = db_all($remaining_status_query);
                                $fault_str .= "<div class='form-group col-md-6'>
																								<label class='help-block'>Change Fault Status : <span class='text-danger'>*</span></label>";
                                if (empty($remaining_status_result)) {
                                    $fault_str .= "<h3 class='text-success'>The Fault Cycle is completed.</h3>";
                                } else {
                                    $status_str = "<select class='form-control fault_status_id'>
																										<option value='0'>Choose One</option>";
                                    if ($login_query_result['UTNO'] == 3) {
                                        foreach ($availabl_list_result as $alr) {
                                            $status_str .= "<option value='" . $alr['FSID'] . "' style='color:red;' disabled>" . $alr['NAME'] . "</option>";
                                        }
                                        foreach ($remaining_status_result as $rsr) {
                                            if ($login_query_result['UTNO'] == 3 && $rsr['FSID'] == 8) {
                                                $status_str .= "<option value='" . $rsr['FSID'] . "' style='color:red;' disabled>" . $rsr['NAME'] . "</option>";
                                            } else {
                                                $status_str .= "<option value='" . $rsr['FSID'] . "' " . ($rsr['FSID'] == $row['STATUS'] ? 'selected' : '') . ">" . $rsr['NAME'] . "</option>";
                                            }
                                        }
                                    } else {
                                        $status_str .= "<option value=8>Line Charged OK</option>";
                                    }
                                    $fault_str .= $status_str;
                                    $fault_str .= "</select>";
                                }
                            } else {
                                $fault_str .= "<div>";
                            }
                            $fault_str .= "
																				</div>
																		<!-- end of div-->
																		<div class='clearfix'></div>
																			</div>
																			<div class='modal-footer'>
																				<input type='hidden' class='cid' value='" . $row['CID'] . "'>
																				<input type='hidden' class='fid' value='" . $row['FID'] . "'>
																				<button type='button' class='btn btn-default btn-flat pull-left' data-dismiss='modal'>Close</button>
																				<button type='button' class='btn btn-default btn-flat pull-left' onclick='printModalContent(" . $row['FID'] . ")'>Print</button>";
                            if ($login_query_result['UTNO'] != 1) {
                                $fault_str .= "<button type='button' id='hod_status_change_btn' " . ((empty($remaining_status_result)) ? 'disabled' : '') . " class='btn btn-primary btn-flat pull-right '><i class='fa fa-exchange'></i> Change</button>";
                            }
                            $fault_str .= "<div class='clearfix'></div>
																				</div>
																			<div class='clearfix'></div>
																	</div>
																	<!-- /.modal-content -->
																  </div>
																  <!-- /.modal-dialog -->
																</div>
																<!-- /.modal -->
																<!--button class='btn btn-primary' type='button' data-toggle='collapse' data-target='#collapse" . $row['FID'] . "' aria-expanded='false' aria-controls='collapseExample'>
																<i class='fa fa-search'></i>
															  </button-->
														  </td>
														 </tr>";
                            $i++;
                        }
                        echo $fault_str;

                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>