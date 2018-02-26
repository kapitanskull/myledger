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
				events: [
					{
						title: 'Meeting',
						start: moment('2018-02-01'),
						allDay:true,
						description: 'Lorem ipsum dolor sit incid idunt ut',
						className: "m-fc-event--light m-fc-event--solid-warning",
						editable: true,
					},
					{
						title: 'Conference',                    
						description: 'try2 sajae',
						start: moment(YM + '-26T13:30:00'),
						end: moment(YM + '-26T23:59:59'),
						className: "m-fc-event--accent",
						editable: true,
					},
					{
						title: 'Dinner',
						start: moment('2017-08-30'),
						description: 'Lorem ipsum dolor sit tempor incid',
						className: "m-fc-event--light  m-fc-event--solid-danger",
						editable: true,
					},
					{
						title: 'All Day Event',
						start: moment(YM + '-01'),
						description: 'all datdfd boleh klik',
						className: "m-fc-event--danger m-fc-event--solid-focus m-fc-event-kapitan",
						editable: true,
					},
					{
						title: 'Reporting',                    
						description: 'Lorem ipsum dolor incid idunt ut labore',
						start: moment('2017-09-03T13:30:00'),
						end: moment('2017-09-04T17:30:00'),
						className: "m-fc-event--accent m-fc-event-kapitan",
						editable: true,
					},
					{
						title: 'Company Trip',
						start: moment(YM + '-05'),
						end: moment(YM + '-07'),
						description: 'Lorem ipsum dolor sit tempor incid',
						className: "m-fc-event--primary",
						editable: true,
					},
					{
						title: 'ICT Expo 2017 - Product Release',
						start: moment('2017-09-09'),
						description: 'Lorem ipsum dolor sit tempor inci',
						className: "m-fc-event--light m-fc-event--solid-primary",
						editable: true,
					},
					{
						title: 'Dinner',
						start: moment('2017-09-12'),
						description: 'Lorem ipsum dolor sit amet, conse ctetur',
						editable: true,
					},
					{
						id: 999,
						title: 'Repeating Event',
						start: moment( YM + '09-15T16:00:00'),
						description: 'Lorem ipsum dolor sit ncididunt ut labore',
						className: "m-fc-event--danger m-fc-event-kapitan",
						editable: true,
					},
					{
						id: 1000,
						title: 'Repeating Event',
						description: 'zs ipsum dolor sit amet, labore',
						start: YM +'-24T12:00:00',
						end: YM +'-26T15:00:00',
						editable: true,
					},
					{
						title: 'Conference',
						start: moment('2017-09-20T13:00:00'),
						end: moment('2017-09-21T19:00:00'),
						description: 'Lorem ipsum dolor eius mod tempor labore',
						className: "m-fc-event--accent",
						editable: true,
					},
					{
						title: 'Meeting',
						start: moment('2017-09-11'),
						description: 'Lorem ipsum dolor eiu idunt ut labore',
						editable: true,
					},
					{
						title: 'Lunch',
						start: moment('2017-09-18'),
						className: "m-fc-event--info m-fc-event--solid-accent m-fc-event-kapitan",
						description: 'Lorem ipsum dolor sit amet, ut labore',
						editable: true,
					},
					{
						title: 'Meeting',
						start: moment('2017-09-24'),
						className: "m-fc-event--warning m-fc-event-kapitan",
						description: 'Lorem ipsum conse ctetur adipi scing',
						editable: true,
					},
					{
						title: 'Happy Hour',
						start: moment('2017-09-24'),
						className: "m-fc-event--light m-fc-event--solid-focus m-fc-event-kapitan",
						description: 'Lorem ipsum dolor sit amet, conse ctetur',
						editable: true,
					},
					{
						title: 'Dinner',
						start: moment('2017-09-24'),
						className: "m-fc-event--solid-focus m-fc-event--light m-fc-event-kapitan",
						description: 'Lorem ipsum dolor sit ctetur adipi scing',
						editable: true,
					},
					{
						title: 'Birthday Party',
						start: moment('2017-09-24'),
						className: "m-fc-event--primary m-fc-event-kapitan",
						description: 'Lorem ipsum dolor sit amet, scing'
					},
					{
						title: 'Company Event',
						start: moment('2017-09-24'),
						className: "m-fc-event--danger m-fc-event-kapitan",
						description: 'Lorem ipsum dolor sit amet, scing'
					},
					{
						title: 'Click for Google',
						url: 'http://google.com/',
						start: moment('2017-09-26'),
						className: "m-fc-event--solid-info m-fc-event--light",
						description: 'Lorem ipsum dolor sit amet, labore'
					}
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
