<!-- begin::Footer -->
		<footer class="m-grid__item m-footer ">
			<div class="m-container m-container--responsive m-container--xxl m-container--full-height m-page__container">
				<div class="m-footer__wrapper">
					<div class="m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop">
						<div class="m-stack__item m-stack__item--left m-stack__item--middle m-stack__item--last">
							<span class="m-footer__copyright">
								<?php echo "2007 - " . date('Y') ?> &copy; personal ledger by
								<a href="#" class="m-link">
									thekapitan
								</a>
							</span>
						</div>
						<div class="m-stack__item m-stack__item--right m-stack__item--middle m-stack__item--first">
							<ul class="m-footer__nav m-nav m-nav--inline m--pull-right">
								<li class="m-nav__item">
									<a href="#" class="m-nav__link">
										<span class="m-nav__link-text">
											Page rendered in: {elapsed_time}s
										</span>
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</footer>
		<!-- end::Footer -->
	</div>
	   
	<!-- begin::Scroll Top -->
	<div class="m-scroll-top m-scroll-top--skin-top" data-toggle="m-scroll-top" data-scroll-offset="500" data-scroll-speed="300">
		<i class="la la-arrow-up"></i>
	</div>
	<!-- end::Scroll Top -->			
	<script>var base_url = '<?php echo site_url()?>'</script>
	<!--begin::Base Scripts -->
	<script src="<?php echo base_url() ?>assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>
	<script src="<?php echo base_url() ?>assets/demo/demo2/base/scripts.bundle.js" type="text/javascript"></script>
	<!--end::Base Scripts -->   
	<!--begin::Page Vendors -->
	<script src="<?php echo base_url() ?>assets/vendors/custom/fullcalendar/fullcalendar.bundle.js" type="text/javascript"></script>
	<!--end::Page Vendors -->  
	<!--begin::Page Snippets -->
	<script src="<?php echo base_url() ?>assets/app/js/dashboard.js?v=<?php echo time(); ?>" type="text/javascript"></script>
	<!--end::Page Snippets -->
	<script type="text/javascript">
		var error_toast = function()
		{
			toastr.options = {
			  "closeButton": true,
			  "debug": false,
			  "newestOnTop": false,
			  "progressBar": false,
			  "positionClass": "toast-top-right",
			  "preventDuplicates": true,
			  "onclick": null,
			  "showDuration": "0",
			  "hideDuration": "0",
			  "timeOut": "0",
			  "extendedTimeOut": "0",
			  "showEasing": "swing",
			  "hideEasing": "linear",
			  "showMethod": "fadeIn",
			  "hideMethod": "fadeOut"
			};

			toastr.error("An error occur in server side.", "Error");
		}
	</script>