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
																	Date
																</th>
																<th>
																	Description
																</th>
																<th>
																	Income
																</th>
																<th>
																	Expenses
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
																$total_income = 0;
																$total_expense = 0;
																$net_income = 0;
																
																if($this->uri->segment(3) != '' AND is_numeric($this->uri->segment(3)) AND $this->uri->segment(3) > 0)
																{
																 	$count = $this->uri->segment(3);
																}
																foreach($arr_data['query']->result() as $rowtrans)
																{
																	$count++;
														?>
																<tr>
																	<td>
																		<?php echo $count?>
																	</td>
																	<td>
																		<?php echo (isset($rowtrans->date) AND $rowtrans->date != '') ? date('d/m/Y', strtotime($rowtrans->date)) : '' ;?>
																	</td>
																	<td>
																		<?php echo (isset($rowtrans->description) AND $rowtrans->description != '') ? $rowtrans->description : '' ;?>
																	</td>
																	<td>
																		<?php 
																			if(isset($rowtrans->amount_type) AND $rowtrans->amount_type == 'income' AND isset($rowtrans->amount) AND $rowtrans->amount != "" AND is_numeric($rowtrans->amount))
																			{
																				$total_income += $rowtrans->amount;
																				echo "RM " . number_format($rowtrans->amount, 2);
																			}
																		?>
																	</td>
																	<td>
																		<?php 
																			if(isset($rowtrans->amount_type) AND $rowtrans->amount_type == 'expenses' AND isset($rowtrans->amount) AND $rowtrans->amount != "" AND is_numeric($rowtrans->amount))
																			{
																				$total_expense += $rowtrans->amount;
																				echo "RM " . number_format($rowtrans->amount, 2);
																			}
																		?>
																	</td>
																	<td>
																		<a href="<?php echo base_url() ?>index.php/ledger/edit/<?php echo (isset($rowtrans->id) AND $rowtrans->id > 0) ? $rowtrans->id : ''  ?>" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only  m-btn--pill">
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
																<td colspan="6">
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
														if (isset($total_expense) AND is_numeric($total_expense)) 
														{
															echo number_format($total_expense, 2);
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
													if (isset($total_expense) AND is_numeric($total_expense) AND isset($total_income) AND is_numeric($total_income)) 
													{
														$net_income = $total_income - $total_expense;
														
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
