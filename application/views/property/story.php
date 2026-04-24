<?php //$this->load->view('partials/dashboard-top'); ?>
<div class="vwstryhero container-fluid">
	

</div>
<div class="llsection container-fluid pb100">
	<div class="container">

		<div class="row ">
			<?php if(check_auth_session()){ ?>
				<?php $this->load->view('partials/dashboard-left'); ?>
			<?php } ?>
			<div class="col-md-12 <?php if(check_auth_session()){ ?>col-lg-9 <?php }else{ ?> col-lg-12 <?php } ?>">

			<div class="row pidetails">
					<div class="col-md-12 col-sm-12">
						<div class="bcca-breadcrumb ffa">
							<div class="bcca-breadcrumb-item">
								<a href="<?php echo base_url('details/timeline/'.$homeId) ?>" class="colorfff">Timeline</a>
							</div>
							<div class="bcca-breadcrumb-item">
								<a href="<?php echo base_url('details/people/'.$homeId) ?>" class="colorfff">People</a></div>
<!--							<div class="bcca-breadcrumb-item">-->
<!--								<a href="--><?php //echo base_url('details/story/'.$homeId) ?><!--" class="colorfff">Photo and Story</a></div>-->
							<div class="bcca-breadcrumb-item">
								<a href="<?php echo base_url('details/view/'.$homeId) ?>" class="colorfff">Photos and Stories</a> </div>
						</div>
					</div>

					<div class="col-lg-4 ">
						<div class="peopleimg">
							<div class="img-people">
								<img class="img-fluid" src="<?php echo ASSETS; ?>images/Heartwarming-Vintage-Pictures-Of-People-With-their-Dogs-12.jpg">
							</div>
							<div class="Img_frame">
								<img src="<?php echo ASSETS; ?>images/NicePng_polaroid-frame-png_85740.png">
							</div>
						</div>
					</div>
					<div class="col-lg-4 ">
						<div class="peopleimg">
							<div class="img-people">
								<img class="img-fluid" src="<?php echo ASSETS; ?>images/Heartwarming-Vintage-Pictures-Of-People-With-their-Dogs-12.jpg">
							</div>
							<div class="Img_frame">
								<img src="<?php echo ASSETS; ?>images/NicePng_polaroid-frame-png_85740.png">
							</div>
						</div>
					</div>
					<div class="col-lg-4 ">
						<div class="peopleimg">
							<div class="img-people">
								<img class="img-fluid" src="<?php echo ASSETS; ?>images/Heartwarming-Vintage-Pictures-Of-People-With-their-Dogs-12.jpg">
							</div>
							<div class="Img_frame">
								<img src="<?php echo ASSETS; ?>images/NicePng_polaroid-frame-png_85740.png">
							</div>
						</div>
					</div>
					<div class="col-lg-4 ">
						<div class="peopleimg">
							<div class="img-people">
								<img class="img-fluid" src="<?php echo ASSETS; ?>images/Heartwarming-Vintage-Pictures-Of-People-With-their-Dogs-12.jpg">
							</div>
							<div class="Img_frame">
								<img src="<?php echo ASSETS; ?>images/NicePng_polaroid-frame-png_85740.png">
							</div>
						</div>
					</div>
					<div class="col-lg-4 ">
						<div class="peopleimg">
							<div class="img-people">
								<img class="img-fluid" src="<?php echo ASSETS; ?>images/Heartwarming-Vintage-Pictures-Of-People-With-their-Dogs-12.jpg">
							</div>
							<div class="Img_frame">
								<img src="<?php echo ASSETS; ?>images/NicePng_polaroid-frame-png_85740.png">
							</div>
						</div>
					</div>
					<div class="col-lg-4 ">
						<div class="peopleimg">
							<div class="img-people">
								<img class="img-fluid" src="<?php echo ASSETS; ?>images/Heartwarming-Vintage-Pictures-Of-People-With-their-Dogs-12.jpg">
							</div>
							<div class="Img_frame">
								<img src="<?php echo ASSETS; ?>images/NicePng_polaroid-frame-png_85740.png">
							</div>
						</div>
					</div>

				</div>
			</div>

			<?php if(check_auth_session()){ ?>
				<?php $this->load->view('partials/dashboard-left-bottom'); ?>
			<?php } ?>
		</div>

	</div>
</div>


