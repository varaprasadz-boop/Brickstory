<?php //$this->load->view('partials/dashboard-top'); ?>
<div class="vwstryhero container-fluid pb100">
	<div class="container">
	</div>
</div>
<div class="llsection container-fluid pb100">
	<div class="container">

		<div class="row ">
			<?php $this->load->view('partials/dashboard-left'); ?>

			<div class="col-md-12 col-lg-9">

				<div class="row pidetails">
					<div class="col-md-12 col-sm-12">
						<div class="bcca-breadcrumb ffa">
							<div class="bcca-breadcrumb-item">
								<a href="<?php echo base_url('dashboard/viewTimeLine/'.$homeId) ?>" class="colorfff">Timeline</a>
							</div>
							<div class="bcca-breadcrumb-item">
								<a href="<?php echo base_url('dashboard/viewPeople/'.$homeId) ?>" class="colorfff">People</a></div>
<!--							<div class="bcca-breadcrumb-item bcca-breadcrumb-item-active">-->
<!--								<a href="--><?php //echo base_url('dashboard/viewStory/'.$homeId) ?><!--" class="colorfff">Photo and Story</a></div>-->
							<div class="bcca-breadcrumb-item">
								<a href="<?php echo base_url('dashboard/homeDetails/'.$homeId) ?>" class="colorfff">Photos and Stories</a> </div>
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
					
					<div class="col-md-12 text-center">
						<button class="btn registerbtn1 ffa" onclick="location.href='<?php echo base_url('dashboard/addPhotoStory/'.$homeId); ?>'">Add Another Photo or Story </button>
					</div>
				</div>
			</div>
			<?php $this->load->view('partials/dashboard-left-bottom'); ?>
		</div>

	</div>
</div>


