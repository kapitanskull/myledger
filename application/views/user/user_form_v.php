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
								<i>mandotary field</i>&nbsp;<font style="color:red;font-size:15px;">*</font>
								<div class="m-portlet">
									<div class="m-portlet__head">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-title">
												<span class="m-portlet__head-icon m--hide">
													<i class="la la-gear"></i>
												</span>
												<h3 class="m-portlet__head-text">
													<?php echo (isset($page_title) AND $page_title != "") ?  ucwords(strtolower($page_title)) : ""?>
												</h3>
											</div>
										</div>
									</div>
									<!--begin::Form-->
									<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" action="<?php echo base_url() ?>index.php/user/add" method='post'>
										<div class="m-portlet__body">
											<div class="form-group m-form__group row">
												<label class="col-md-2 col-form-label">
													<font style="color:red;font-size:15px;">*</font>First Name:
												</label>
												<div class="col-md-3">
													<input type="text" name="first_name" class="form-control m-input" value="<?php echo (isset($row) AND $row !== false  AND isset($row->first_name) AND $row->first_name != "") ? $row->first_name : '' ?>">
													<input type="hidden" name="id" class="form-control m-input" value="<?php echo (isset($row) AND $row !== false  AND isset($row->id) AND $row->id != "") ? $row->id : '' ?>">
												</div>
												<label class="col-md-2 col-form-label">
													<font style="color:red;font-size:15px;">*</font>Last Name:
												</label>
												<div class="col-md-3">
													<input type="text" name="last_name" class="form-control m-input" value="<?php echo (isset($row) AND $row !== false  AND isset($row->last_name) AND $row->last_name != "") ? $row->last_name : '' ?>">
												</div>
											</div>
											<div class="form-group m-form__group row">
												<label class="col-md-2 col-form-label">
													<font style="color:red;font-size:15px;">*</font>Username:
												</label>
												<div class="col-md-3">
													<input type="text" name="username" class="form-control m-input" value="<?php echo (isset($row) AND $row !== false  AND isset($row->username) AND $row->username != "") ? $row->username : '' ?>">
													<span class="m-form__help">
														username will be used to login
													</span>
												</div>
											</div>
											<div class="form-group m-form__group row">
												<label class="col-md-2 col-form-label">
													<font style="color:red;font-size:15px;">*</font>Password:
												</label>
												<div class="col-md-3">
													<input type="password" name="password" class="form-control m-input" value="<?php echo (isset($row) AND $row !== false  AND isset($row->id) AND $row->id > 0 AND isset($row->password) AND $row->password != '') ? $row->password : '' ?>">
													<input type="hidden" name="ori_password" class="form-control m-input" value="<?php echo (isset($row) AND $row !== false  AND isset($row->id) AND $row->id > 0 AND isset($row->password) AND $row->password != '') ? $row->password : '' ?>">
													<span class="m-form__help">
														Alphanumeric and minimum 6 character
													</span>
												</div>
												<label class="col-md-2 col-form-label">
													<font style="color:red;font-size:15px;">*</font>Confirm Password:
												</label>
												<div class="col-md-3">
													<input type="password" name="confirm_password" class="form-control m-input" value="<?php echo (isset($row) AND $row !== false  AND isset($row->id) AND $row->id > 0 AND isset($row->password) AND $row->password != '') ? $row->password : '' ?>">
												</div>
											</div>
											<div class="form-group m-form__group row">
												<label class="col-lg-2 col-form-label">
													<font style="color:red;font-size:15px;">*</font>Status:
												</label>
												<div class="col-lg-3">
													<div class="m-radio-inline">
														<?php 
															$value = 1;
															if(isset($row) AND $row !== false  AND isset($row->status) AND $row->status != '')
															{
																$value = $row->status;
															}
														?>
														<label class="m-radio m-radio--solid">
															<input type="radio" name="status" <?php echo (isset($value) AND $value == "1") ? 'checked' : '' ?> value="1">
															Active
															<span></span>
														</label>
														<label class="m-radio m-radio--solid">
															<input type="radio" name="status" <?php echo (isset($value) AND $value == "0") ? 'checked' : '' ?> value="0">
															Incative
															<span></span>
														</label>
													</div>
												</div>
											</div>
										</div>
										<div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
											<div class="m-form__actions m-form__actions--solid">
												<div class="row">
													<div class="col-lg-2"></div>
													<div class="col-lg-10">
														<button type="submit" class="btn btn-success">
															Submit
														</button>
														<button type="reset" class="btn btn-secondary">
															Cancel
														</button>
													</div>
												</div>
											</div>
										</div>
									</form>
									<!--end::Form-->
								</div>
								<!--end::Portlet-->
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
