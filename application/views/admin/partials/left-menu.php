<!--------------------
	  START - Mobile Menu
	  -------------------->
<?php //pre($this->session->userdata()); ?>
<div class="menu-mobile menu-activated-on-click color-scheme-dark">
	<div class="mm-logo-buttons-w">
		<a class="mm-logo" href="<?php echo ADMIN_URL; ?>">
<!--			<div class="logo-element"></div>-->
			<span>BrickStory</span>
		</a>
		<div class="mm-buttons">
			<div class="content-panel-open">
				<div class="os-icon os-icon-grid-circles"></div>
			</div>
			<div class="mobile-menu-trigger">
				<div class="os-icon os-icon-hamburger-menu-1"></div>
			</div>
		</div>
	</div>
	<div class="menu-and-user">
		<div class="logged-user-w">
<!--			<div class="avatar-w">-->
<!--				<img alt="" src="--><?php //echo ADMIN_ASSETS ?><!--img/avatar1.jpg">-->
<!--			</div>-->
			<div class="logged-user-info-w">
				<div class="logged-user-name">
					<?php echo $this->session->userdata("fullname") ?>
				</div>
				<div class="logged-user-role">
					Administrator
				</div>
			</div>
		</div>
		<!--------------------
		START - Mobile Menu List
		-------------------->
		<ul class="main-menu">
			<li class="selected">
				<a href="<?php echo ADMIN_URL.'dashboard'; ?>">
					<div class="icon-w">
						<div class="os-icon os-icon-layout"></div>
					</div>
					<span>Dashboard</span></a>
			</li>
			<li class="">
				<a href="<?php echo ADMIN_URL.'users'; ?>">
					<div class="icon-w">
						<div class="os-icon os-icon-user"></div>
					</div>
					<span>Users</span></a>
			</li>
			<li class="sub-header">
				<span>CUSTOM - NAVIGATION</span>
			</li>
			<li class="">
				<a href="<?php echo base_url().'/dashboard/1'; ?>">
					<div class="icon-w">
						<div class="os-icon os-icon-home"></div>
					</div>
					<span>Properties</span></a>
			</li>
			<li class="">
				<a href="<?php echo ADMIN_URL.'cms' ?>">
					<div class="icon-w">
						<div class="os-icon os-icon-window-content"></div>
					</div>
					<span>CMS</span></a>
			</li>
			<li class="">
				<a href="<?php echo ADMIN_URL.'banners'; ?>">
					<div class="icon-w">
						<div class="os-icon os-icon-image"></div>
					</div>
					<span>Banners</span></a>
			</li>
			<li class="">
				<a href="<?php echo ADMIN_URL.'emailtemplates' ?>">
					<div class="icon-w">
						<div class="os-icon os-icon-file-text"></div>
					</div>
					<span>Email Templates</span></a>
			</li>
			<!--		<li class="">-->
			<!--			<a href="">-->
			<!--				<div class="icon-w">-->
			<!--					<div class="os-icon os-icon-newspaper"></div>-->
			<!--				</div>-->
			<!--				<span>Newsletter</span></a>-->
			<!--		</li>-->
			<li class="">
				<a href="<?php echo ADMIN_URL.'settings' ?>">
					<div class="icon-w">
						<div class="os-icon os-icon-settings"></div>
					</div>
					<span>Settings</span></a>
			</li>
			<li class="">
				<a href="<?php echo ADMIN_URL.'account/logout' ?>">
					<div class="icon-w">
						<div class="os-icon os-icon-log-out"></div>
					</div>
					<span>Logout</span></a>
			</li>

		</ul>

	</div>
</div>
<!--------------------
END - Mobile Menu
-------------------->
<!--------------------
        START - Main Menu
        -------------------->
<div class="menu-w color-scheme-light color-style-default menu-position-side menu-side-left menu-layout-compact sub-menu-style-flyout sub-menu-color-light selected-menu-color-light menu-activated-on-hover menu-has-selected-link">
	<div class="logo-w">
		<a class="logo" href="#">
			<div class="logo-element"></div>
			<div class="logo-label">
				Brickstory
			</div>
		</a>
	</div>
	<div class="logged-user-w avatar-inline">
		<div class="logged-user-i">
<!--			<div class="avatar-w">-->
<!--				<img alt="" src="--><?php //echo ADMIN_ASSETS ?><!--img/avatar1.jpg">-->
<!--			</div>-->
			<div class="logged-user-info-w">
				<div class="logged-user-name">
					<?php echo $this->session->userdata("fullname") ?>

				</div>
				<div class="logged-user-role">
					Administrator
				</div>
			</div>

		</div>
	</div>


	<h1 class="menu-page-header">
		Page Header
	</h1>
	<ul class="main-menu">
		<li class="sub-header">
			<span>Default Navigation</span>
		</li>
		<li class="selected">
			<a href="<?php echo ADMIN_URL.'dashboard'; ?>">
				<div class="icon-w">
					<div class="os-icon os-icon-layout"></div>
				</div>
				<span>Dashboard</span></a>
		</li>
		<li class="">
			<a href="<?php echo ADMIN_URL.'users'; ?>">
				<div class="icon-w">
					<div class="os-icon os-icon-user"></div>
				</div>
				<span>Users</span></a>
		</li>
		<li class="sub-header">
			<span>CUSTOM - NAVIGATION</span>
		</li>
		<li class="">
				<a href="<?php echo base_url().'dashboard/1'; ?>">
					<div class="icon-w">
						<div class="os-icon os-icon-home"></div>
					</div>
					<span>Properties</span></a>
			</li>
		<li class="">
			<a href="<?php echo ADMIN_URL.'cms' ?>">
				<div class="icon-w">
					<div class="os-icon os-icon-window-content"></div>
				</div>
				<span>CMS</span></a>
		</li>
		<li class="">
			<a href="<?php echo ADMIN_URL.'banners'; ?>">
				<div class="icon-w">
					<div class="os-icon os-icon-image"></div>
				</div>
				<span>Banners</span></a>
		</li>
		<li class="">
			<a href="<?php echo ADMIN_URL.'emailtemplates' ?>">
				<div class="icon-w">
					<div class="os-icon os-icon-file-text"></div>
				</div>
				<span>Email Templates</span></a>
		</li>
<!--		<li class="">-->
<!--			<a href="">-->
<!--				<div class="icon-w">-->
<!--					<div class="os-icon os-icon-newspaper"></div>-->
<!--				</div>-->
<!--				<span>Newsletter</span></a>-->
<!--		</li>-->
		<li class="">
			<a href="<?php echo ADMIN_URL.'settings' ?>">
				<div class="icon-w">
					<div class="os-icon os-icon-settings"></div>
				</div>
				<span>Settings</span></a>
		</li>
		<li class="">
			<a href="<?php echo ADMIN_URL.'account/logout' ?>">
				<div class="icon-w">
					<div class="os-icon os-icon-log-out"></div>
				</div>
				<span>Logout</span></a>
		</li>

	</ul>

</div>
<!--------------------
END - Main Menu
-------------------->
