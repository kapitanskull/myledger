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
											<div class="m-section__content table_list_content">
												<?php
												# when user click sorting button, or pagination button or change number per page this content will generate by ajax;
												?>
												<div class="row">
													<form id="remove_form" name="remove_form" action="<?php echo site_url()?>/ledger/del_data" method="post">
														<input type="hidden" name="remove_data_id" id="remove_data_id" value="" />
													</form>
													
													<div class="col-md-4">
														<div class="form-group m-form__group row" style="border-bottom:unset;">
															<label class="col-md-5 col-form-label">
																number of records:
															</label>
															<div class="col-md-4">
																<select class="form-control m-input numperpage" name="num_per_page">
																		<option value="10" <?php echo (isset($arr_data['num_per_page'])&&$arr_data['num_per_page'] == "10") ? "selected" : "" ?>>10</option>
																		<option value="25"	<?php echo (isset($arr_data['num_per_page']) && $arr_data['num_per_page'] == "25") ? "selected" : ""?>>25</option>
																		<option value="50" <?php echo (isset($arr_data['num_per_page'])&& $arr_data['num_per_page'] == "50") ? "selected" : "" ?>>50</option>
																		<option value="100" <?php echo (isset($arr_data['num_per_page'])&& $arr_data['num_per_page'] == "100") ? "selected" : "" ?>>100</option>
																		<option value="500" <?php echo (isset($arr_data['num_per_page'])&& $arr_data['num_per_page'] == "500") ? "selected" : "" ?>>500</option>
																</select>
															</div>
														</div>
													</div>
													<div class="col-md-8">
														<form id="search_sorting_form" action="<?php echo site_url() ?>/ledger/search" method="post">
															<div class="form-group m-form__group row">
																<div class="col-md-4">
																	<div class='input-group transaction_date_range'>
																		<input type='text' name="transaction_date_range" class="form-control m-input transaction-date" readonly  placeholder="Select date range" value="<?php echo (isset($arr_data)&& is_array($arr_data) && isset($arr_data['transaction_date_range']) && $arr_data['transaction_date_range'] != "") ? $arr_data['transaction_date_range'] : "" ?>"/>
																		<div class="input-group-append">
																			<span class="input-group-text">
																				<i class="la la-calendar-check-o"></i>
																			</span>
																		</div>
																	</div>
																</div>
																<div class="col-md-6 ml-auto">
																	<div class="form-group m-form__group">
																		<div class="input-group">
																			<input type="text" name="keyword_search" class="form-control" placeholder="Search" value="<?php echo (isset($arr_data)&& is_array($arr_data) && isset($arr_data['keyword_search']) && $arr_data['keyword_search'] != "") ? $arr_data['keyword_search'] : "" ?>" >
																			<div class="input-group-append">
																				<button class="btn btn-primary" type="submit">
																					Search
																				</button>
																			</div>
																		</div>
																	</div>
																	<input type="hidden" class="form-control column_name" name="column_name"  value="<?php echo (isset($arr_data)&& is_array($arr_data) && isset($arr_data['column_name']) && $arr_data['column_name'] != "") ? $arr_data['column_name'] : "" ?>">
																	<input type="hidden" class="form-control sortType" name="sort_type"  value="<?php echo (isset($arr_data)&& is_array($arr_data) && isset($arr_data['sort_type']) && $arr_data['sort_type'] != "") ? $arr_data['sort_type'] : "" ?>">
																	<input type="hidden" class="form-control num-perpage" name="num_per_page"  value="<?php echo (isset($arr_data)&& is_array($arr_data) && isset($arr_data['num_per_page']) && $arr_data['num_per_page'] != "") ? $arr_data['num_per_page'] : "" ?>">
																</div>
																<div class="col-md-2 ml-auto">
																	<div class="form-group m-form__group">
																		<button type="reset" class="btn btn-danger btnreset">
																			Reset
																		</button>
																	</div>
																</div>
															</div>
														</form>
													</div>
												</div>
												<div class="row">
													<div class="table-responsive">
														<table class="table table-bordered">
															<thead>
																<tr>
																	<th>
																		#
																	</th>
																	<th>
																		<a class="sort_by" href="javascript:;" 
																			data-orderbytable="" 
																			data-orderbycolum="date"
																			data-sortingby="<?php echo (isset($arr_data)&& is_array($arr_data) && isset($arr_data['sort_type']) && $arr_data['sort_type'] == "asc") ? "desc" : "asc" ?>">
																			Date &nbsp;
																			<i class="fa fa-sort<?php echo isset($arr_data)&& is_array($arr_data) && isset($arr_data['column_name']) && $arr_data['column_name'] == "date" && isset($arr_data['sort_type']) && $arr_data['sort_type'] != "" ? "-" . $arr_data['sort_type'] : "" ?>" style="font-size:15px;"></i>
																		</a> 
																	</th>
																	<th>
																		<a class="sort_by" href="javascript:;" 
																			data-orderbytable="" 
																			data-orderbycolum="description" 
																			data-sortingby="<?php echo (isset($arr_data)&& is_array($arr_data) && isset($arr_data['sort_type']) && $arr_data['sort_type'] == "asc") ? "desc" : "asc" ?>">
																			Description &nbsp;
																			<i class="fa fa-sort<?php echo isset($arr_data)&& is_array($arr_data) && isset($arr_data['column_name']) && $arr_data['column_name'] == "description" && isset($arr_data['sort_type']) && $arr_data['sort_type'] != "" ? "-" . $arr_data['sort_type'] : "" ?>" style="font-size:15px;"></i>
																		</a> 
																	</th>
																	<th>
																		
																		<a class="sort_by" href="javascript:;" 
																			data-orderbytable="" 
																			data-orderbycolum="income" 
																			data-sortingby="<?php echo (isset($arr_data)&& is_array($arr_data) && isset($arr_data['sort_type']) && $arr_data['sort_type'] == "asc") ? "desc" : "asc" ?>">
																			Income &nbsp;
																			<i class="fa fa-sort<?php echo isset($arr_data)&& is_array($arr_data) && isset($arr_data['column_name']) && $arr_data['column_name'] == "income" && isset($arr_data['sort_type']) && $arr_data['sort_type'] != "" ? "-" . $arr_data['sort_type'] : "" ?>" style="font-size:15px;"></i>
																		</a> 
																		
																		
																	</th>
																	<th>
																		
																		<a class="sort_by" href="javascript:;" 
																			data-orderbytable="" 
																			data-orderbycolum="expenses" 
																			data-sortingby="<?php echo (isset($arr_data)&& is_array($arr_data) && isset($arr_data['sort_type']) && $arr_data['sort_type'] == "asc") ? "desc" : "asc" ?>">
																			Expenses &nbsp;
																			<i class="fa fa-sort<?php echo isset($arr_data)&& is_array($arr_data) && isset($arr_data['column_name']) && $arr_data['column_name'] == "expenses" && isset($arr_data['sort_type']) && $arr_data['sort_type'] != "" ? "-" . $arr_data['sort_type'] : "" ?>" style="font-size:15px;"></i>
																		</a> 
																		
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
																	
																	if($this->uri->segment(4) != '' AND is_numeric($this->uri->segment(4)) AND $this->uri->segment(4) > 0)
																	{
																		$count = $this->uri->segment(4);
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
																				if(isset($rowtrans->amount_type) AND $rowtrans->amount_type == 'income' AND isset($rowtrans->income) AND $rowtrans->income != "" AND is_numeric($rowtrans->income))
																				{
																					echo "RM " . number_format($rowtrans->income, 2);
																				}
																			?>
																		</td>
																		<td>
																			<?php 
																				if(isset($rowtrans->amount_type) AND $rowtrans->amount_type == 'expenses' AND isset($rowtrans->expenses) AND $rowtrans->expenses != "" AND is_numeric($rowtrans->expenses))
																				{
																					echo "RM " . number_format($rowtrans->expenses, 2);
																				}
																			?>
																		</td>
																		<td>
																			<a href="<?php echo site_url() ?>/ledger/edit/<?php echo (isset($rowtrans->id) AND $rowtrans->id > 0) ? $rowtrans->id : ''  ?>" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only  m-btn--pill">
																				<i class="fa fa-edit"></i>
																			</a>
																			<a href="#" title="Delete this file" onclick="delete_record('<?php echo $rowtrans->id?>')" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill">
																				<i class="fa fa-trash-o"></i>
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
													
													<?php echo isset($arr_data['pagination']) ? $arr_data['pagination'] : ""; ?>
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
																if (isset($arr_data['total_income']) AND is_numeric($arr_data['total_income'])) 
																{
																	echo number_format($arr_data['total_income'], 2);
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
																if (isset($arr_data['total_expenses']) AND is_numeric($arr_data['total_expenses'])) 
																{
																	echo number_format($arr_data['total_expenses'], 2);
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
															if (isset($arr_data['net_income']) AND is_numeric($arr_data['net_income'])) 
															{
																if($arr_data['net_income'] < 0)
																{
														?>
																	<span class="m-widget24__stats m--font-danger">
																	RM (<?php echo number_format($arr_data['net_income'], 2) ?>)
																	</span>
														
														<?php
																	
																}
																elseif($arr_data['net_income'] >= 0)
																{
														?>
																	<span class="m-widget24__stats m--font-info">
																	RM <?php echo number_format($arr_data['net_income'], 2) ?>
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
		<script type="text/javascript">
		
			function delete_record(data_id) {
				var respond = confirm("Are you sure to delete this record?");
				
				if(respond == true) {
					$('#remove_data_id').val(data_id);
					$('#remove_form').submit();	
				}
			}
			
			function ajax_list_table(dataform){
				mApp.block('.table_list_content', {
					overlayColor: '#000000',
					type: 'loader',
					state: 'info',
					size: 'lg',
					message: 'Processing...'
				});
				
				$.ajax({
					url: base_url+"/ledger/ajax_sorting/",
					method: "POST",
					async:false,
					data:dataform,
					success: function(result){
						$('.table_list_content').html(result);
					},
					error: function () {
						error_toast();
						mApp.unblock('.table_list_content');
					}
				})
			}
			
			function date_range()
			{
				$('.transaction_date_range').daterangepicker({
					buttonClasses: 'm-btn btn',
					applyClass: 'btn-primary',
					cancelClass: 'btn-secondary',
					startDate: "<?php echo (isset($arr_data['forjquery_startdate']) AND $arr_data['forjquery_startdate'] != '') ? $arr_data['forjquery_startdate'] : date('d/m/Y')?>",
					endDate: "<?php echo (isset($arr_data['forjquery_enddate']) AND $arr_data['forjquery_enddate'] != '') ? $arr_data['forjquery_enddate'] : date('d/m/Y') ?>",
					locale: {
						format: 'DD/MM/YYYY'
					}
				}, 
				function(start, end, label) {
					console.log("new range");
					$('.transaction_date_range .form-control').val( start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
				});
			}
			
			$(function(){
				
				$('body').on("focus", ".transaction_date_range", function(){
					date_range();
				});
				
				$('body').on("click", ".sort_by", function(){
					var column_name = $(this).data('orderbycolum');
					var sort_type = $(this).data('sortingby');
					var table_name = $(this).data('orderbytable');
					
					$('.column_name').val(column_name);
					$('.sortType').val(sort_type);
					$('.table_name').val(table_name);
					
					var dataform = $('#search_sorting_form').serialize();
					ajax_list_table(dataform);
				});
			
				$('body').on("change", '.numperpage', function(){
					var num_page = $(this).val();
					$('.num-perpage').val(num_page);
					var dataform = $('#search_sorting_form').serialize();
					ajax_list_table(dataform);
				});
				
				$('body').on("click", '.btnreset', function(){
					window.location = base_url + "/ledger/listing"
				});
				
			});
			
		</script>
	</body>
	<!-- end::Body -->
</html>
