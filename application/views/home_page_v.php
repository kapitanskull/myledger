<?php $this->load->view('header_v') ;?>		
	<!-- begin::Body -->
		<div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor-desktop m-grid--desktop m-body">
			<div class="m-grid__item m-grid__item--fluid  m-grid m-grid--ver	m-container m-container--responsive m-container--xxl m-page__container">
				<div class="m-grid__item m-grid__item--fluid m-wrapper">
					<!-- BEGIN: Subheader -->
					<div class="m-subheader ">
						<div class="d-flex align-items-center">
							<?php $this->load->view('subheader_v') ?>
							<div>
								<span class="m-subheader__daterange">
									<font style="font-weight: 400;color: #aaaeb8;">Today</font> &nbsp;<font style="font-weight: 500;color: #716aca !important;"><?php echo date('d M Y')  ?></font>
								</span>
							</div>
						</div>
					</div>
					<!-- END: Subheader -->
					<div class="m-content">
						<!--begin:: Widgets/Stats-->
						<?php get_message(); ?>
						<div class="m-portlet ">
							<div class="m-portlet__body  m-portlet__body--no-padding">
								<div class="row m-row--no-padding m-row--col-separator-xl">
									<div class="col-md-4">
										<!--begin::Total Profit-->
										<div class="m-widget24">
											<div class="m-widget24__item">
												<h4 class="m-widget24__title">
													Total Income
												</h4>
												<br>
												<span class="m-widget24__desc">
													Side income
												</span>
												<span class="m-widget24__stats m--font-success">
													RM 
													<?php 
														if (isset($total_income) AND is_numeric($total_income)) 
														{
															echo number_format($total_income, 2);
														}
														else
															echo number_format(0, 2);
													?>
												</span>
											</div>
										</div>
										<!--end::Total Profit-->
									</div>
									<div class="col-md-4">
										<!--begin::New Feedbacks-->
										<div class="m-widget24">
											<div class="m-widget24__item">
												<h4 class="m-widget24__title">
													Total Expenses
												</h4>
												<br>
												<span class="m-widget24__desc">
													Buy or pay something
												</span>
												<span class="m-widget24__stats m--font-danger">
													RM
													<?php 
														if (isset($total_expenses) AND is_numeric($total_expenses)) 
														{
															echo number_format($total_expenses, 2);
														}
														else
															echo number_format(0, 2);
													?>
												</span>
											</div>
										</div>
										<!--end::New Feedbacks-->
									</div>
									<div class="col-md-4">
										<!--begin::New Orders-->
										<div class="m-widget24">
											<div class="m-widget24__item">
												<h4 class="m-widget24__title">
													Net Income
												</h4>
												<br>
												<span class="m-widget24__desc">
													Income - Expenses
												</span>
												<?php 
													if (isset($net_income) AND is_numeric($net_income)) 
													{
														if($net_income < 0)
														{
												?>
															<span class="m-widget24__stats m--font-danger">
															RM (<?php echo number_format($net_income, 2) ?>)
															</span>
												
												<?php
															
														}
														elseif($net_income >= 0)
														{
												?>
															<span class="m-widget24__stats m--font-info">
															RM <?php echo number_format($net_income, 2) ?>
															</span>
												<?php
														}
													}
													else
													{
												?>
														<span class="m-widget24__stats m--font-info">
															RM 0.00
														</span>
												<?php
													}
												?>
												
											</div>
										</div>
										<!--end::New Orders-->
									</div>
								</div>
							</div>
						</div>
						<!--end:: Widgets/Stats--> 
						
						<!--Begin::Section-->
						<div class="row">
							<div class="col-md-12">
								<!--begin:: Widgets/Finance Stats-->
								<div class="m-portlet  m-portlet--full-height ">
									<div class="m-portlet__head">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-title">
												<h3 class="m-portlet__head-text">
													Finance Stats
												</h3>
											</div>
										</div>
									</div>
									<div class="m-portlet__body">
										
									</div>
								</div>
								<!--end:: Widgets/Finance Stats-->
							</div>
						</div>
						<!--End::Section-->
						<!--Begin::Section-->
						<div class="row">
							<div class="col-xl-12">
								<!--begin::Portlet-->
								<div class="m-portlet" id="m_portlet">
									<div class="m-portlet__head">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-title">
												<span class="m-portlet__head-icon">
													<i class="flaticon-map-location"></i>
												</span>
												<h3 class="m-portlet__head-text">
													Calendar
												</h3>
											</div>
										</div>
										<div class="m-portlet__head-tools">
											<ul class="m-portlet__nav">
												<li class="m-portlet__nav-item">
													<a href="#" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air">
														<span>
															<i class="la la-plus"></i>
															<span>
																Add Event
															</span>
														</span>
													</a>
												</li>
											</ul>
										</div>
									</div>
									<div class="m-portlet__body">
										<div id="m_calendar"></div>
									</div>
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
