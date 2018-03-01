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
													<a href="<?php echo site_url() ?>/event/add" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air">
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
									<div class="m-portlet__body calender_body">
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
		<script type="text/javascript">
		var calendarInit = function() {
			if ($('#m_calendar').length === 0) {
				return;
			}
			
			var todayDate = moment().startOf('day');
			var YM = todayDate.format('YYYY-MM');
			console.log(YM + "today");
			var YESTERDAY = todayDate.clone().subtract(1, 'day').format('YYYY-MM-DD');
			var TODAY = todayDate.format('YYYY-MM-DD');
			var TOMORROW = todayDate.clone().add(1, 'day').format('YYYY-MM-DD');

			$('#m_calendar').fullCalendar({
				header: {
					left: 'prev,next today',
					center: 'title',
					right: 'month,agendaWeek,agendaDay,listWeek'
				},
				
				eventLimit: true, // allow "more" link when too many events
				navLinks: true,
				defaultDate: moment('<?php echo date('Y-m-d') ?>'),
				googleCalendarApiKey: 'AIzaSyBbh8fohxsGJ8I2fkSZr-w5_RlPZ5k0IqI',
				events:[
						<?php 
						if(isset($event_query) AND $event_query !== false AND $event_query->num_rows() > 0)
						{
							foreach($event_query->result() as $revent)
							{
						?>
								{
									title: '<?php echo ucwords(strtolower($revent->event_title)) ?>',
									start: moment('<?php echo date('Y-m-d', strtotime($revent->event_start_datetime)) ?>'),
									allDay:<?php echo ($revent->all_day == 1) ? "true" : "false"; ?>,
									description: '<?php echo ucwords(strtolower($revent->event_description)) ?>',
									className: "m-fc-event--light m-fc-event--solid-warning",
									editable: true,
								},
						<?php
							}						
						}
						?>
					
				],

				eventRender: function(event, element) {
					element.on('click', function (e) {
						console.log(element);
						if(element.hasClass('m-fc-event-kapitan'))
						{
							alert("window.location = will redirect cetain place means this event has class name = m-fc-event-kapitan");
						}
						// if (element.closest('.fc-day-grid-event').length > 0) {
							// e.preventDefault();
						// }
					});
					
					if (element.hasClass('fc-day-grid-event')) {
						element.data('content', event.description);
						element.data('placement', 'top');
						mApp.initPopover(element);
					} else if (element.hasClass('fc-time-grid-event')) {
						element.find('.fc-title').append('<div class="fc-description">' + event.description + '</div>');
					} else if (element.find('.fc-list-item-title').lenght !== 0) {
						element.find('.fc-list-item-title').append('<div class="fc-description">' + event.description + '</div>');
					}
				},
				
				eventDrop: function(event, delta, revertFunc) {
					console.log(event);
					if(event.end != null)
					{
						alert("event all day =" + event.allDay+ event.id  + "===" + event.title + " was dropped on start " + event.start.format() + " AND end on " + event.end.format());
					}
					else
					{
						alert("event all day =" + event.allDay  + event.id + "===" + event.title + " was dropped on start " + event.start.format());
					}

					if (!confirm("Are you sure about this change?")) {
						revertFunc();
					}
				},
				
				eventClick: function(event) {
                    // opens events in a popup window
                    // window.open(event.url, 'gcalevent', 'width=700,height=600');
					if (event.url) {
						return false;
					}
                },
			});
		}
		
		$(function(){
			calendarInit();
			$('#m_calendar').fullCalendar('addEventSource', 'en.malaysia#holiday@group.v.calendar.google.com');	 
		});
	
	</script>
		
		</body>
	<!-- end::Body -->
</html>
