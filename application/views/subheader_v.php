<div class="mr-auto">
	<h3 class="m-subheader__title m-subheader__title--separator">
		<?php echo (isset($controller) AND $controller != "") ? ucwords(strtolower($controller)) : ""; ?>
	</h3>
	<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
		<li class="m-nav__item m-nav__item--home">
			<a href="<?php echo base_url() ?>" class="m-nav__link m-nav__link--icon">
				<i class="m-nav__link-icon la la-home"></i>
			</a>
		</li>
		<?php
		$bCount = 0;
		foreach($breadcrumb as $k => $v) 
		{
		?>
			<li class="m-nav__separator">
				-
			</li>
			<li class="m-nav__item">
				<a href="<?php echo $v;?>" class="m-nav__link">
					<span class="m-nav__link-text">
						<?php echo $k;?>
					</span>
				</a>
			</li>
		<?php
		}
		?>
	</ul>
</div>
	