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
								<i>mandotary field</i>&nbsp;<font style="color:red;font-size:15px;">*</font> &nbsp; <?php echo (isset($controller) AND strtolower($controller) == 'ledger' AND isset($function) AND $function == 'edit') ? "<a href='" . site_url() . "/ledger/add'> Add New Transaction</a>" : "" ?>
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
									<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" action="<?php echo site_url() ?>/event/add" method='post'>
										<div class="m-portlet__body">
											<div class="form-group m-form__group row">
												<label class="col-md-2 col-form-label">
												<font style="color:red;font-size:15px;">*</font>Event Title
												</label>
												<div class="col-md-3">
													<input type="text" name="event_title" class="form-control m-input" value="<?php echo (isset($row) AND $row !== false  AND isset($row->event_title) AND $row->event_title != '') ? $row->event_title : '' ?>">
													<input type="hidden" name="id" class="form-control m-input" value="<?php echo (isset($row) AND $row !== false  AND isset($row->id) AND $row->id > 0) ? $row->id : '' ?>">
												</div>
											</div>
											<div class="form-group m-form__group row">
												<label class="col-md-2 col-form-label">
													Description:
												</label>
												<div class="col-md-8">
													<textarea class="form-control m-input" rows="5" name="event_description"><?php echo (isset($row) AND $row !== false  AND isset($row->event_description) AND $row->event_description != "") ? $row->event_description : '' ?></textarea>
												</div>
											</div>
											<div class="form-group m-form__group row">
												<label class="col-md-2 col-form-label">
												<font style="color:red;font-size:15px;">*</font> Start date:
												</label>
												<?php #this one is boostrap-date picker so synxtax to change format different(http://bootstrap-datepicker.readthedocs.io/en/latest/) ?>
												<div class="col-md-3 ">
													<div class="input-group date">
														<input type="text" name="event_start_datetime" class="form-control m-input date_start_kapitan" readonly="" value="<?php echo (isset($row) AND $row !== false  AND isset($row->event_start_datetime) AND $row->event_start_datetime != "") ? $row->event_start_datetime : '' ?>" >
														<div class="input-group-append">
															<span class="input-group-text">
																<i class="la la-calendar glyphicon-th"></i>
															</span>
														</div>
													</div>
												</div>
												<label class="col-md-2 col-form-label">
												End date:
												</label>
												<?php #this one is boostrap-date picker so synxtax to change format different(http://bootstrap-datepicker.readthedocs.io/en/latest/) ?>
												<div class="col-md-3 ">
													<div class="input-group date">
														<input type="text" name="event_end_datetime" class="form-control m-input date_end_kapitan" readonly="" value="<?php echo (isset($row) AND $row !== false  AND isset($row->event_end_datetime) AND $row->event_end_datetime != "") ? $row->event_end_datetime : '' ?>" >
														<div class="input-group-append">
															<span class="input-group-text">
																<i class="la la-calendar glyphicon-th"></i>
															</span>
														</div>
													</div>
													<span class="m-form__help">
														<p>End date time must more than <strong> start date time</strong></p>
														<p>If empty our system will set <strong> date same with start date and time will be "23:59:59" so it referring to end of day that date</strong></p>
														
													</span>
												</div>
											</div>
											<div class="form-group m-form__group row">
												<label class="col-md-2 col-form-label">
													All Days ?:
												</label>
												<div class="col-md-8">
													<div class="m-checkbox-inline">
														<label class="m-checkbox">
															<input type="checkbox" name="all_day" <?php echo (isset($row) AND $row !== false  AND isset($row->all_day) AND $row->all_day == "1") ? 'checked' : '' ?> value='1'>
															Yes
															<span></span>
														</label>
													</div>
													<span class="m-form__help">
														Tick if this event all day. So in calender view this event only display date.
													</span>
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
		<script type="text/javascript">
		$('.date_start_kapitan').datetimepicker({
            todayHighlight: true,
            autoclose: true,
            pickerPosition: 'bottom-left',
            todayBtn: true,
            format: 'dd/mm/yyyy hh:ii',
			defaultDate:'<?php  echo date('d/m/Y H:i')?>'
        });
		
		$('.date_end_kapitan').datetimepicker({
            todayHighlight: true,
            autoclose: true,
            pickerPosition: 'bottom-left',
            todayBtn: true,
            format: 'dd/mm/yyyy hh:ii',
			defaultDate:'<?php  echo date('d/m/Y H:i')?>'
        });
		
		$(function(){
			
		});
		
			
		</script>
	</body>
	<!-- end::Body -->
</html>
