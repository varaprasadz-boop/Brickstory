
<!--  <img class="img-responsive img-object-fit" id="image" width="100%"> -->
<div id="overlay"></div>
<?php
$get_banner = get_banner(4,'Home Video');
?>
<div class="d-none d-xl-block ">
   <video id="videobcg" src="<?php echo ASSETS; ?>uploads/banner_ad_images/<?php echo $get_banner; ?>" loop muted autoplay class="videobg">
</video>

   <div class="wrap-rel">
      <div class="hero-text container">
         <div class="row mt30">
            <div class="col-md-8">
               <!-- <h1 class="herotitle">  Find Your <br> Dream Home</h1>
               <p class="p10">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco labor is nisi ut aliquip ex ea commodo consequat.</p>
               <div class="p10"><button class="btn  hmbtn">Find home</button></div> -->
            </div>
            <div class="col-md-4">
				<div  class="formmain container" style="padding: 0px 14px;">
					<?php echo form_open(base_url('account/register'),array("id" => "myform3","enctype" => "multipart/form-data")); ?>

						<div class="row bordergrey">
						<h4 class="text-center tcgrey col-md-12">Register</h4>
						<div class="col-md-12 text-center">
							<img src="<?php echo ASSETS; ?>images/arrow-title-1.png" class="mauto"></div>
						<div class="col-md-6 mt20 form-group mb0">
							<label class="tcgrey">First Name</label>
							<input type="text" name="firstname" class="form-control fs12" placeholder="First Name" required="required">
						</div>
						<div class="col-md-6  mt20 form-group mb0">
							<label class="tcgrey">Last Name</label>
							<input type="text" name="lastname" class="form-control fs12" placeholder="Last Name" required="required">
						</div>

						<div class="col-md-6 mt20">
							<label class="tcgrey">Password</label>
							<input type="password" name="password" class="form-control fs12" placeholder="Phone Number" required="required">
						</div>
							<div class="col-md-6 mt20">
								<label class="tcgrey">Confirm Password</label>
								<input type="password" name="confirm_password" class="form-control fs12" placeholder="Confirm Password" required="required">
							</div>
							<div class="col-md-12 mt20 form-group mb0">
								<label class="tcgrey">Email Address</label>
								<input type="text" name="email" class="form-control fs12" placeholder="Email Address" required="required">
							</div>
						<div class="col-md-12 mb20  text-center">
							<button class="btn registerbtn" type="submit">Register </button>
						</div>
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
         </div>
      </div>
   </div>
</div>
<div class="d-block d-xl-none ">
	 <video style="width: 100%;" src="<?php echo ASSETS; ?>uploads/banner_ad_images/<?php echo $get_banner; ?>" loop muted autoplay class="videobg">

</video>
<!-- <div class="row"> -->

<!-- </div> -->
  
</div>


</div>
 <div class="modal" id="playvideo">
    <div class="modal-dialog modal-lg">
      <div class="">
      
       
        <!-- Modal body -->
        <div class="embed-responsive embed-responsive-16by9">
           <video id="" src="<?php echo ASSETS; ?>uploads/banner_ad_images/<?php echo $get_banner; ?>" loop muted autoplay class="">
</video>
        </div>
       
        
      </div>
    </div>
  </div>
 <!-- The Modal -->
  <div class="modal" id="mobilereg">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <div  class="formmain container" style="padding: 0px 14px;">
					<form method="post" action="<?php echo base_url('account/register'); ?>" id="myform3">
						<div class="row bordergrey">
						<h4 class="text-center tcgrey col-md-12">Register</h4>
						<div class="col-md-12 text-center">
							<img src="<?php echo ASSETS; ?>images/arrow-title-1.png" class="mauto"></div>
						<div class="col-md-6 mt20 form-group mb0">
							<label class="tcgrey">First Name</label>
							<input type="text" name="firstname" class="form-control fs12" placeholder="First Name" required="required">
						</div>
						<div class="col-md-6  mt20 form-group mb0">
							<label class="tcgrey">Last Name</label>
							<input type="text" name="lastname" class="form-control fs12" placeholder="Last Name" required="required">
						</div>

						<div class="col-md-6 mt20">
							<label class="tcgrey">Password</label>
							<input type="password" name="password" class="form-control fs12" placeholder="Phone Number" required="required">
						</div>
							<div class="col-md-6 mt20">
								<label class="tcgrey">Confirm Password</label>
								<input type="password" name="confirm_password" class="form-control fs12" placeholder="Confirm Password" required="required">
							</div>
							<div class="col-md-12 mt20 form-group mb0">
								<label class="tcgrey">Email Address</label>
								<input type="text" name="email" class="form-control fs12" placeholder="Email Address" required="required">
							</div>
						<div class="col-md-12 mb20  text-center">
							<button class="btn registerbtn" type="submit">Register </button>
						</div>
					</div>
					</form>
				</div>        </div>
        
       
        
      </div>
    </div>
  </div>
  

</div>
<!-- --header end-- -->
<!-- --hero section end--- -->
<!-- journey section start -->

<!--  journey section end -->

<!--  latest listing start -->
<div class="llsection container-fluid pt50 pb100 mobile-margin-top">
	<div class="container">
	<div class="text-center d-sm-none">
	<a type="button" class="btn btn-primary d-sm-none" style="color: #fff;font-weight: bold;" data-toggle="modal" data-target="#mobilereg">
		Register 
	</a>
	<a href="javascriot:void(0);" onClick="getLocation();" class="btn btn-primary pt50 text-center d-sm-none" style="
	/* background: transparent; */
    /* color: #516466; */
    font-weight: bold;
    border: solid 2px #516466;">Near Me</a>
	<a href="<?php echo base_url('dashboard/addHome'); ?>" style="font-weight: bold;" class="btn btn-primary pt50 text-center d-sm-none">Add a Home</a>
	</div>

		<div class="row">
			<div class="col-lg-8 col-md-12">
				<div class="text-center">
					<h1 class="tcgrey decorated"><span>Latest</span></h1>
					<div style="width:300px; overflow: hidden; margin: 0 auto;">
					<img src="<?php echo ASSETS; ?>images/arrow-title-1.png" class="mauto ">
				</div>
				</div>
				<?php if($recentListing){ ?>
					<div class="row pt50">
					<?php	foreach($recentListing as $key => $val){
						$val->cls = 'col-lg-6 col-sm-6 col-md-6';
						$this->load->view('partials/home-thumb.php',array('val' => (array)$val)); 
					
					} ?>
					</div>

				<?php } ?>
			</div>
			<div class="col-lg-4 col-md-12">

					<h1 class="tcgrey decorated">
						Featured Stories
					</h1>
					<img src="<?php echo ASSETS; ?>images/arrow-title-1.png" class="mauto mt5">
					<div class="row pt50" style="border-left:solid 1px #999;">
						<?php if($featureStory){
								foreach($featureStory as $k => $v){
									$val->cls = 'col-lg-12 col-md-6';
									$this->load->view('partials/home-thumb.php',array('val' => (array)$val)); 
							 } ?>
						<?php } ?>
					</div>

			</div>
		</div>

	</div>
</div>
<!--  latest listing end -->

<!-- About sec start -->
<div class="Aboutsec container-fluid pt100 pb100">
	<div class="container">
		<div class="row ">
			<div class="col-md-12 col-lg-8 p0 abtbs ">
				<img src="<?php echo ASSETS; ?>images/banner-Login_Page_Banner-20171212-233216.png" class=" img-fluid">

			</div>
			<div class="col-md-12 col-lg-4 abtbs text-center" >
				<h3 class="mt20">About BrickStory</h3>
				<img src="<?php echo ASSETS; ?>images/arrow-title-1.png" class="mauto mt20">
				<p class="mt20">
					We are preservationists by trade and storytellers heart.Our Reason for existing is to prepare and share the images.stories and ancestral history of the american home.
				<p>Every home has a story to tell- BrickStory.com is the place to find those stories.
				</p>
				<a class="btn hmbtn mt20 mb20" href="<?php echo base_url('aboutus'); ?>">Know More</a>
			</div>
		</div>
	</div>
</div>
<!-- About section end -->
