<!DOCTYPE html>
<?php 
	/* 
		most of file that relate to css, jquery i user base_url() and link i use site_url(). 
		because sometime we cannot overide .htacccess file(which is normally we used to setting for remove index.php from url)
		in shared hosting server. so that why i maintain the index.php in this project 
		base_url(); // http://example.com/website
		site_url(); // http://example.com/website/index.php
	
	*/
?>

<html lang="en" >
	<!-- begin::Head -->
	<head>
		<meta charset="utf-8" />
		<title>
			Myledger <?php echo (isset($meta_title) AND $meta_title != "") ? " | " . $meta_title  : ""?>
		</title>
		<meta name="description" content="<?php echo (isset($meta_description) AND $meta_description != "") ? $meta_description : ""; ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="robots" content="index, follow">
		<!--begin::Web font -->
		<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
		<script>
          WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
          });
		</script>
		<!--end::Web font -->
        <!--begin::Base Styles -->
		<link href="<?php echo base_url() ?>assets/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url() ?>assets/demo/demo2/base/style.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Base Styles -->
		
		<!--begin::Page Vendors -->
		<link href="<?php echo base_url() ?>assets/vendors/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Page Vendors -->
		<link rel="shortcut icon" href="<?php echo base_url() ?>assets/demo/demo2/media/img/logo/favicon.ico" />
		<style>
			.sort_by{
				text-decoration: none !important;
				color:#2d2e3e !important;
			}
		</style>
	</head>
	<!-- end::Head -->
	<body class="m-page--wide m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
		<!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page">
			<!-- begin::Header -->
			<header class="m-grid__item		m-header "  data-minimize="minimize" data-minimize-offset="200" data-minimize-mobile-offset="200" >
				<div class="m-header__top">
					<div class="m-container m-container--responsive m-container--xxl m-container--full-height m-page__container">
						<div class="m-stack m-stack--ver m-stack--desktop">
							<!-- begin::Brand -->
							<div class="m-stack__item m-brand">
								<div class="m-stack m-stack--ver m-stack--general m-stack--inline">
									<div class="m-stack__item m-stack__item--middle m-brand__logo">
										<a href="index.html" class="m-brand__logo-wrapper">
											<img alt="" src="<?php echo base_url() ?>assets/demo/demo2/media/img/logo/logo.png"/>
										</a>
									</div>
									<div class="m-stack__item m-stack__item--middle m-brand__tools">
										<div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-left m-dropdown--align-push" data-dropdown-toggle="click" aria-expanded="true">
											<div class="m-dropdown__wrapper">
												<span class="m-dropdown__arrow m-dropdown__arrow--left m-dropdown__arrow--adjust"></span>
												<div class="m-dropdown__inner">
													<div class="m-dropdown__body">
														<div class="m-dropdown__content">
															<ul class="m-nav">
																<li class="m-nav__section m-nav__section--first m--hide">
																	<span class="m-nav__section-text">
																		Quick Menu
																	</span>
																</li>
																<li class="m-nav__item">
																	<a href="" class="m-nav__link">
																		<i class="m-nav__link-icon flaticon-share"></i>
																		<span class="m-nav__link-text">
																			Human Resources
																		</span>
																	</a>
																</li>
																<li class="m-nav__item">
																	<a href="" class="m-nav__link">
																		<i class="m-nav__link-icon flaticon-chat-1"></i>
																		<span class="m-nav__link-text">
																			Customer Relationship
																		</span>
																	</a>
																</li>
																<li class="m-nav__item">
																	<a href="" class="m-nav__link">
																		<i class="m-nav__link-icon flaticon-info"></i>
																		<span class="m-nav__link-text">
																			Order Processing
																		</span>
																	</a>
																</li>
																<li class="m-nav__item">
																	<a href="" class="m-nav__link">
																		<i class="m-nav__link-icon flaticon-lifebuoy"></i>
																		<span class="m-nav__link-text">
																			Accounting
																		</span>
																	</a>
																</li>
																<li class="m-nav__separator m-nav__separator--fit"></li>
																<li class="m-nav__item">
																	<a href="" class="m-nav__link">
																		<i class="m-nav__link-icon flaticon-chat-1"></i>
																		<span class="m-nav__link-text">
																			Customer Relationship
																		</span>
																	</a>
																</li>
																<li class="m-nav__item">
																	<a href="" class="m-nav__link">
																		<i class="m-nav__link-icon flaticon-info"></i>
																		<span class="m-nav__link-text">
																			Order Processing
																		</span>
																	</a>
																</li>
															</ul>
														</div>
													</div>
												</div>
											</div>
										</div>
										<!-- BEGIN: Responsive Aside Left Menu Toggler -->
										<a href="javascript:;" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
											<span></span>
										</a>
										<!-- END -->
						<!-- begin::Responsive Header Menu Toggler-->
										<a id="m_aside_header_menu_mobile_toggle" href="javascript:;" class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block">
											<span></span>
										</a>
										<!-- end::Responsive Header Menu Toggler-->
			<!-- begin::Topbar Toggler-->
										<a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
											<i class="flaticon-more"></i>
										</a>
										<!--end::Topbar Toggler-->
									</div>
								</div>
							</div>
							<!-- end::Brand -->		
				<!-- begin::Topbar -->
							<div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">
								<div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
									<div class="m-stack__item m-topbar__nav-wrapper">
										<ul class="m-topbar__nav m-nav m-nav--inline">
											<li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" data-dropdown-toggle="click">
												<a href="#" class="m-nav__link m-dropdown__toggle">
													<span class="m-topbar__userpic m--hide">
														<img src="<?php echo base_url() ?>assets/app/media/img/users/user4.jpg" class="m--img-rounded m--marginless m--img-centered" alt=""/>
													</span>
													<span class="m-topbar__welcome">
														Hello,&nbsp;
													</span>
													<span class="m-topbar__username">
														<?php echo ($this->session->has_userdata('username') AND $this->session->userdata('username') != "") ? ucwords(strtolower($this->session->userdata('username'))): "Anonymous" ?>
													</span>
												</a>
												<div class="m-dropdown__wrapper">
													<span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
													<div class="m-dropdown__inner">
														<div class="m-dropdown__header m--align-center" style="background: url(<?php echo base_url() ?>assets/app/media/img/misc/user_profile_bg.jpg); background-size: cover;">
															<div class="m-card-user m-card-user--skin-dark">
																<div class="m-card-user__pic">
																	<img src="<?php echo base_url() ?>assets/app/media/img/users/avatar.png" class="m--img-rounded m--marginless" alt=""/>
																</div>
																<div class="m-card-user__details">
																	<span class="m-card-user__name m--font-weight-500">
																	<?php echo ($this->session->has_userdata('first_name') AND $this->session->userdata('first_name') != "" AND $this->session->has_userdata('last_name') AND $this->session->userdata('last_name')) ? ucwords(strtolower($this->session->userdata('first_name'))) . " " . ucwords(strtolower($this->session->userdata('last_name'))) : "Anonymous" ?>
																	</span>
																</div>
															</div>
														</div>
														<div class="m-dropdown__body">
															<div class="m-dropdown__content">
																<ul class="m-nav m-nav--skin-light">
																	<li class="m-nav__section m--hide">
																		<span class="m-nav__section-text">
																			Section
																		</span>
																	</li>
																	<li class="m-nav__item">
																		<a href="profile.html" class="m-nav__link">
																			<i class="m-nav__link-icon flaticon-profile-1"></i>
																			<span class="m-nav__link-title">
																				<span class="m-nav__link-wrap">
																					<span class="m-nav__link-text">
																						My Profile
																					</span>
																					<span class="m-nav__link-badge">
																						<span class="m-badge m-badge--success">
																							2
																						</span>
																					</span>
																				</span>
																			</span>
																		</a>
																	</li>
																	<li class="m-nav__separator m-nav__separator--fit"></li>
																	<li class="m-nav__item">
																		<a href="<?php echo site_url() ?>/login/sayonara" class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">
																			Logout
																		</a>
																	</li>
																</ul>
															</div>
														</div>
													</div>
												</div>
											</li>
											<li class="m-nav__item m-topbar__quick-actions m-topbar__quick-actions--img m-dropdown m-dropdown--large m-dropdown--header-bg-fill m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push m-dropdown--mobile-full-width m-dropdown--skin-light"  data-dropdown-toggle="click">
												<a href="<?php echo base_url() ?>index.php/login/sayonara" class="m-nav__link">
													<span class="m-nav__link-badge m-badge m-badge--dot m-badge--info m--hide"></span>
													<span class="m-nav__link-icon">
														<span class="m-nav__link-icon-wrapper">
															<i class="flaticon-logout"></i>
														</span>
													</span>
												</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
							<!-- end::Topbar -->
						</div>
					</div>
				</div>
				<div class="m-header__bottom">
					<div class="m-container m-container--responsive m-container--xxl m-container--full-height m-page__container">
						<div class="m-stack m-stack--ver m-stack--desktop">
							<!-- begin::Horizontal Menu -->
							<div class="m-stack__item m-stack__item--middle m-stack__item--fluid">
								<button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-light " id="m_aside_header_menu_mobile_close_btn">
									<i class="la la-close"></i>
								</button>
								<div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-dark m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-light m-aside-header-menu-mobile--submenu-skin-light "  >
									<ul class="m-menu__nav  m-menu__nav--submenu-arrow ">
										<li class="m-menu__item <?php echo (isset($controller) AND strtolower($controller) == 'dashboard' AND isset($function) AND $function == 'home') ? 'm-menu__item--active' : ''  ?>"  aria-haspopup="true">
											<a  href="<?php echo site_url() ?>/dashboard" class="m-menu__link ">
												<span class="m-menu__item-here"></span>
												<span class="m-menu__link-text">
													Dashboard
												</span>
											</a>
										</li>
										<li class="m-menu__item m-menu__item--submenu m-menu__item--rel <?php echo (isset($controller) AND strtolower($controller) == 'ledger' AND ((isset($function) AND $function == 'add') OR (isset($function) AND $function == 'edit') )) ? 'm-menu__item--active' : ''  ?>"  data-menu-submenu-toggle="click" aria-haspopup="true">
											<a  href="<?php echo site_url() ?>/ledger/add" class="m-menu__link">
												<span class="m-menu__item-here"></span>
												<span class="m-menu__link-text">
													<?php echo (isset($menu_name) AND $menu_name != "") ? $menu_name : "Add Transaction" ?>
												</span>
											</a>
										</li>
										<li class="m-menu__item m-menu__item--submenu m-menu__item--rel <?php echo (isset($controller) AND strtolower($controller) == 'ledger' AND isset($function) AND $function == 'listing') ? 'm-menu__item--active' : ''  ?>"  data-menu-submenu-toggle="click" aria-haspopup="true">
											<a  href="<?php echo site_url() ?>/ledger/listing" class="m-menu__link">
												<span class="m-menu__item-here"></span>
												<span class="m-menu__link-text">
													Transaction Listing
												</span>
											</a>
										</li>
										<?php 
											if($this->session->has_userdata('user_type') AND $this->session->userdata('user_type') == 'admin' AND $this->session->has_userdata('logged_in') AND $this->session->userdata('logged_in') == true)
											{	
										?>
												<li class="m-menu__item m-menu__item--submenu m-menu__item--rel <?php echo (isset($controller) AND strtolower($controller) == 'user') ? 'm-menu__item--active' : ''  ?>"  data-menu-submenu-toggle="click" aria-haspopup="true">
													<a  href="#" class="m-menu__link m-menu__toggle">
														<span class="m-menu__item-here"></span>
														<span class="m-menu__link-text">
															User
														</span>
														<i class="m-menu__hor-arrow la la-angle-down"></i>
														<i class="m-menu__ver-arrow la la-angle-right"></i>
													</a>
													<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left">
														<span class="m-menu__arrow m-menu__arrow--adjust"></span>
														<ul class="m-menu__subnav">
															<?php 
															/* <li class="m-menu__item  "  aria-haspopup="true">
																<a  href="<?php echo base_url() ?>index.php/user/add" class="m-menu__link ">
																	<i class="m-menu__link-icon flaticon-diagram"></i>
																	<span class="m-menu__link-title">
																		<span class="m-menu__link-wrap">
																			<span class="m-menu__link-text">
																				Add New User
																			</span>
																			
																			<span class="m-menu__link-badge">
																				<span class="m-badge m-badge--success">
																					2
																				</span>
																			</span>
																		</span>
																	</span>
																</a>
															</li> */
															?>
															<li class="m-menu__item <?php echo (isset($controller) AND strtolower($controller) == 'user' AND isset($function) AND $function == 'listing') ? 'm-menu__item--active' : ''  ?>" data-redirect="true" aria-haspopup="true">
																<a href="<?php echo site_url() ?>/user/listing" class="m-menu__link ">
																	<i class="m-menu__link-icon flaticon-list-1"></i>
																	<span class="m-menu__link-text">User List</span>
																</a>
															</li>
															<li class="m-menu__item <?php echo (isset($controller) AND strtolower($controller) == 'user' AND isset($function) AND $function == 'add') ? 'm-menu__item--active' : ''  ?>" data-redirect="true" aria-haspopup="true">
																<a href="<?php echo site_url() ?>/user/add" class="m-menu__link ">
																	<i class="m-menu__link-icon flaticon-users"></i>
																	<span class="m-menu__link-text">Add New User</span>
																</a>
															</li>
															<!--<li class="m-menu__item  m-menu__item--submenu"  data-menu-submenu-toggle="hover" data-redirect="true" aria-haspopup="true">
																<a  href="#" class="m-menu__link m-menu__toggle">
																	<i class="m-menu__link-icon flaticon-business"></i>
																	<span class="m-menu__link-text">
																		Manage Orders
																	</span>
																	<i class="m-menu__hor-arrow la la-angle-right"></i>
																	<i class="m-menu__ver-arrow la la-angle-right"></i>
																</a>
																<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
																	<span class="m-menu__arrow "></span>
																	<ul class="m-menu__subnav">
																		<li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Latest Orders
																				</span>
																			</a>
																		</li>
																		<li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Pending Orders
																				</span>
																			</a>
																		</li>
																		<li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Processed Orders
																				</span>
																			</a>
																		</li>
																		<li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Delivery Reports
																				</span>
																			</a>
																		</li>
																		<li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Payments
																				</span>
																			</a>
																		</li>
																		<li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Customers
																				</span>
																			</a>
																		</li>
																	</ul>
																</div>
															</li>-->
														</ul>
													</div>
												</li>
										<?php 
											}
										?>
									</ul>
								</div>
							</div>
							<!-- end::Horizontal Menu -->	
				<!--begin::Search-->
							<div class="m-stack__item m-stack__item--middle m-dropdown m-dropdown--arrow m-dropdown--large m-dropdown--mobile-full-width m-dropdown--align-right m-dropdown--skin-light m-header-search m-header-search--expandable m-header-search--skin-" id="m_quicksearch" data-search-type="default">
								<!--begin::Search Results -->
								<div class="m-dropdown__wrapper">
									<div class="m-dropdown__arrow m-dropdown__arrow--center"></div>
									<div class="m-dropdown__inner">
										<div class="m-dropdown__body">
											<div class="m-dropdown__scrollable m-scrollable" data-max-height="300" data-mobile-max-height="200">
												<div class="m-dropdown__content m-list-search m-list-search--skin-light"></div>
											</div>
										</div>
									</div>
								</div>
								<!--end::Search Results -->
							</div>
							<!--end::Search-->
						</div>
					</div>
				</div>
			</header>
			<!-- end::Header -->