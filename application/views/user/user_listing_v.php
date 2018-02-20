<?php $this->load->view('header_v') ;?>		
	<!-- begin::Body -->
		<div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor-desktop m-grid--desktop m-body">
			<div class="m-grid__item m-grid__item--fluid  m-grid m-grid--ver	m-container m-container--responsive m-container--xxl m-page__container">
				<div class="m-grid__item m-grid__item--fluid m-wrapper">
					<!-- BEGIN: Subheader -->
					<div class="m-subheader ">
						<div class="d-flex align-items-center">
							<?php $this->load->view('subheader_v') ?>
						</div>
					</div>
					<!-- END: Subheader -->
					<div class="m-content">
						<!--Begin::Section-->
						<div class="row">
							<div class="col-md-12">
								<?php get_message(); ?>
								<!--begin::Portlet-->
								<div class="m-portlet">
									<div class="m-portlet__head">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-title">
												<h3 class="m-portlet__head-text">
													<?php echo (isset($page_title) AND $page_title != "") ?  ucwords(strtolower($page_title)) : ""?>
												</h3>
											</div>
										</div>
									</div>
									<div class="m-portlet__body">
										<!--begin::Section-->
										<div class="m-section">
											<div class="m-section__content">
												<div class="table-responsive">
													<table class="table table-bordered">
														<thead>
															<tr>
																<th>
																	#
																</th>
																<th>
																	First Name
																</th>
																<th>
																	Last Name
																</th>
																<th>
																	Status
																</th>
																<th>
																	Action
																</th>
															</tr>
														</thead>
														<tbody>
														<?php 
															if(isset($arr_data) AND isset($arr_data['query']) AND $arr_data['query'] !== false AND
																$arr_data['query']->num_rows() > 0
															)
															{
																$count = 0;
																if($this->uri->segment(3) != '' AND is_numeric($this->uri->segment(3)) AND $this->uri->segment(3) > 0)
																{
																 	$count = $this->uri->segment(3);
																}
																foreach($arr_data['query']->result() as $rowuser)
																{
																	$count++;
														?>
																<tr>
																	<td>
																		<?php echo $count?>
																	</td><td>
																		<?php echo (isset($rowuser->first_name) AND $rowuser->first_name != '') ? ucwords(strtolower($rowuser->first_name)) : '' ;?>
																	</td>
																	<td>
																		<?php echo (isset($rowuser->last_name) AND $rowuser->last_name != '') ? ucwords(strtolower($rowuser->last_name)) : '' ;?>
																	</td>
																	<td>
																		<?php echo (isset($rowuser->status) AND $rowuser->status == '1') ? ucwords(strtolower('active')) : 'inactive' ;?>
																	</td>
																	<td>
																		<a href="<?php echo base_url() ?>index.php/user/edit/<?php echo (isset($rowuser->id) AND $rowuser->id > 0) ? $rowuser->id : ''  ?>" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only  m-btn--pill">
																			<i class="fa fa-edit"></i>
																		</a>
																	</td>
																</tr>
														<?php
																}
															}
															else
															{
														?>
															<tr>
																<td colspan="4">
																	<center>No data to display</center>
																</td>
															</tr>
														<?php
															}
														?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
										<!--end::Section-->
									</div>
								</div>
							</div>
						</div>
						<!--End::Section-->
					</div>
				</div>
			</div>
		</div>
		<!-- end::Body -->
		<?php $this->load->view('footer_v') ;?>
	</body>
	<!-- end::Body -->
</html>
