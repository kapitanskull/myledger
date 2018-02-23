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
									<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" action="<?php echo base_url() ?>index.php/ledger/add" method='post'>
										<div class="m-portlet__body">
											<div class="form-group m-form__group row">
												<label class="col-md-2 col-form-label">
												<font style="color:red;font-size:15px;">*</font>Date:
												</label>
												<?php #this one is boostrap-date picker so synxtax to change format different(http://bootstrap-datepicker.readthedocs.io/en/latest/) ?>
												<div class="col-md-3">
													<div class="input-group date" >
														<input type="text" class="form-control m-input date_kapitan" readonly name="date"  value="<?php echo (isset($row) AND $row !== false  AND isset($row->date) AND $row->date != "") ? $row->date : date('d/m/Y') ?>"/>
														<div class="input-group-append">
															<span class="input-group-text">
																<i class="la la-calendar"></i>
															</span>
														</div>
													</div>
												</div>
											</div>
											<div class="form-group m-form__group row">
												<label class="col-md-2 col-form-label">
													<font style="color:red;font-size:15px;">*</font>Description:
												</label>
												<div class="col-md-8">
													<textarea class="form-control m-input" rows="5" name="description"><?php echo (isset($row) AND $row !== false  AND isset($row->description) AND $row->description != "") ? $row->description : '' ?></textarea>
												</div>
											</div>
											<div class="form-group m-form__group row">
												<label class="col-md-2 col-form-label">
												<font style="color:red;font-size:15px;">*</font> Transaction Type:
												</label>
												<div class="col-md-3">
													<select class="form-control m-input m-input--square" name="amount_type" >
														<option value="">Please Select</option>
														<option value="income" <?php echo (isset($row) AND $row !== false  AND isset($row->amount_type) AND $row->amount_type == 'income') ? 'selected' : '' ?>>Income</option>
														<option value="expenses" <?php echo (isset($row) AND $row !== false  AND isset($row->amount_type) AND $row->amount_type == 'expenses') ? 'selected' : '' ?>>Expenses</option>
													</select>
												</div>
											</div>
											<div class="form-group m-form__group row">
												<label class="col-md-2 col-form-label">
												<font style="color:red;font-size:15px;">*</font>Amount : RM
												</label>
												<div class="col-md-3">
												<?php 
													if(isset($row) AND $row !== false)
													{
														if(isset($row->amount) AND is_numeric($row->amount))
														{
															$nilai = $row->amount;
														}
														elseif(isset($row->amount_type) AND $row->amount_type == 'income' AND isset($row->income) AND is_numeric($row->income) AND $row->income > 0)
														{
															$nilai = $row->income;
														}
														elseif(isset($row->amount_type) AND $row->amount_type == 'expenses' AND isset($row->expenses) AND is_numeric($row->expenses) AND $row->expenses > 0)
														{
															$nilai = $row->expenses;
														}
													}
												?>
													<input type="text" name="amount" class="form-control m-input" value="<?php echo (isset($nilai) && is_numeric($nilai)) ? number_format($nilai, '2', ".", "") : '' ?>">
													<input type="hidden" name="id" class="form-control m-input" value="<?php echo (isset($row) AND $row !== false  AND isset($row->id) AND $row->id > 0) ? $row->id : '' ?>">
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
			$('.date_kapitan').datepicker({
				format: 'dd/mm/yyyy',
				todayBtn: "linked",
				clearBtn: true,
				todayHighlight: true,
				orientation: "bottom left",
				templates: {
					leftArrow: '<i class="la la-angle-left"></i>',
					rightArrow: '<i class="la la-angle-right"></i>'
				}
			});
		</script>
	</body>
	<!-- end::Body -->
</html>
