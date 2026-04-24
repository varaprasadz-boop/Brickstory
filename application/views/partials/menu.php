<?php $userInfo = loggedin_user(); ?>
<!--  ---Mobile top header--- -->

<!-- <div class="container-fluid top-mobile-header d-block d-sm-none">
   <div class="container px-0 px-sm-3">
      <div class="d-flex justify-content-center justify-content-sm-end flex-wrap flex-sm-nowrap">
         <div class="nav-item nav-link pt0">
			
				<div class="d-flex justify-content-start justify-content-sm-around fs13 flex-wrap align-content-center">
				<?php //if(check_auth_session()){ ?>
						<a class="nav-item px-2 px-sm-3 nav-link colorf2" href="<?php echo base_url('dashboard/addHome'); ?>"><i class="fa fa-plus"></i> Add a Home</a>
						<a class="nav-item px-2 px-sm-3 nav-link colorf2" href="javascript:void(0);" onClick="getLocation();"><i class="fa fa-map-marker"></i>  Near Me</a>
						<a target="_blank" style="margin-left:70px;" class="colorf2 nav-item nav-link" href="https://web.facebook.com/BrickStoryCom/"><i class="fa fa-facebook fs16" aria-hidden="true"></i></a>
						<a target="_blank" class="colorf2 nav-item nav-link" href="https://instagram.com/brickstorycom/"><i class="fa fa-instagram fs16" aria-hidden="true"></i></a>
						<a target="_blank" class="colorf2 nav-item nav-link" href="https://twitter.com/BrickStoryCom"><i class="fa fa-twitter fs16" aria-hidden="true"></i></a>
				</div>
			
         </div>
        
      </div>
   </div>
</div> -->
<!--   --top header end-- -->


<!--  ---top header--- -->

<div class="container-fluid top-header">
   <div class="container px-0 px-sm-3">
      <div class="d-flex justify-content-center justify-content-sm-end flex-wrap flex-sm-nowrap">
         <div class="nav-item nav-link pt0">
            <div class="d-flex justify-content-start justify-content-sm-around fs13 flex-wrap align-content-center">
               <?php //if(check_auth_session()){ ?>
					<a class="nav-item px-2 px-sm-3 nav-link colorf2" href="<?php echo base_url('dashboard/addHome'); ?>">Add a Home</a>
					<a class="nav-item px-2 px-sm-3 nav-link colorf2" href="<?php echo base_url('aboutus'); ?>">About Us</a>
					<a class="nav-item px-2 px-sm-3 nav-link colorf2" href="<?php echo base_url('pages/howitworks'); ?>">How it Works</a>
					<a class="nav-item px-2 px-sm-3 nav-link colorf2" href="<?php echo base_url('contactus'); ?>">Contact Us</a>

            </div>
         </div>
         <div class="nav-item nav-link pt0 mx-auto mx-sm-0">
            <div class="d-flex flex-nowrap justify-content-around flex-sm-wrap align-content-center">
<a target="_blank" class="colorf2 nav-item nav-link" href="https://web.facebook.com/BrickStoryCom/"><i class="fa fa-facebook fs16" aria-hidden="true"></i></a>
					<a target="_blank" class="colorf2 nav-item nav-link" href="https://instagram.com/brickstorycom/"><i class="fa fa-instagram fs16" aria-hidden="true"></i></a>
					<a target="_blank" class="colorf2 nav-item nav-link" href="https://twitter.com/BrickStoryCom"><i class="fa fa-twitter fs16" aria-hidden="true"></i></a>
            </div>
         </div>
      </div>
   </div>
</div>
<!--   --top header end-- -->
<!--  ---Header start--- -->
<div class="container-fluid main-header d-none d-xl-block ">
   <div class="container">
      <div class="d-flex justify-content-between header">

         <a class="nav-item nav-link head-item logoimg" href="<?php echo base_url(); ?>"><img src="<?php echo ASSETS; ?>images/logo.png" ></a>
         <div class="nav-item nav-link head-item">
           <div class="d-flex justify-content-around sub-menu flex-wrap align-content-center">
<!--					  <a class="nav-item nav-link" href="--><?php //echo base_url(); ?><!--">Home</a>-->
					<form method="get" class="nearmeform" action="<?php echo base_url('search') ?>">
						<input type="hidden" name="lat" id="lat">
						<input type="hidden" name="lng" id="lng">
					</form>

					<?php //if(check_auth_session()){ ?>
					<script>
						function searchLocation(){
							// if($("#lat").val() == ''){
							// 	getLocation();
								// alert('Please wait a second let us get your cordinates to show you best result.');
							// }else{
								$('.nearmeform').submit();
							// }
						}
					</script>
<!--						<a class="nav-item nav-link " href="--><?php //echo base_url('search')?><!--">Search</a>-->
						<a class="nav-item nav-link " href="javascript:void(0);" onClick="getLocation();">Near Me</a>
						<a class="nav-item nav-link" href="<?php echo base_url('houseshistory'); ?>">Houses</a>
						<a class="nav-item nav-link " href="<?php echo base_url('photosnhistory'); ?>">Photos & Stories</a>
						<a class="nav-item nav-link" href="<?php echo base_url('peoples'); ?>">People</a>
						<a class="nav-item nav-link " href="<?php echo base_url('pages/architect'); ?>">Architects</a>
					<?php //} ?>
				</div>
         </div>

         <style>
				.dropdown-item:hover{
					color:#516466 !important;
				}
			</style>
			<div class="nav-item nav-link">
				<div class="d-flex flex-column  flex-wrap align-content-center">
					<?php
					//pre(check_auth_session());
					if(check_auth_session()){ ?>
						<div class="dropdown">
							<a class="btn btn-secondary dropdown-toggle" style="background:#516466; " href="#" role="button" id="dropdownMenuLink" data-disabled="true" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<?php echo @$userInfo['firstname'].' '.$userInfo['lastname']; ?>
							</a>

							<div class="dropdown-menu" style="background: #516466;" id="dropdownMenuLink" aria-labelledby="dropdownMenuLink">
								<a class="dropdown-item" href="<?php echo base_url('dashboard/myhomes'); ?>">My Homes</a>
								<a class="dropdown-item" href="<?php echo base_url('dashboard/myTimeLine'); ?>">My Timeline</a>
								<a class="dropdown-item" href="<?php echo base_url('dashboard/addHome'); ?>">Add a Home</a>
								<a class="dropdown-item" href="<?php echo base_url('dashboard/myprofile'); ?>">Edit Profile</a>
								<a class="dropdown-item" href="<?php echo base_url('account/logout'); ?>">Logout</a>
							</div>
						</div>
					<div class="samsungultra">
						<ul>
							<li><a class="nav-item nav-link " href="javascript:void(0);" onClick="getLocation();">Near Me</a></li>
							<li></li>
						</ul>
					</div>

<!--						<a class="loginbtn" href="--><?php //echo base_url('account/logout'); ?><!--">Logout</a>-->
					<?php }else{ ?>
						<a class="loginbtn" href="<?php echo base_url('account/login'); ?>">Login</a>
						<a class="colorf2 fs13" data-toggle="modal" href="javascript:void(0);" data-target="#Register">Not Yet Registred?</a>
					<?php } ?>
				</div>
			</div>
      </div>
   </div>
</div>
<div class="container-fluid main-header  d-block d-xl-none ">
   <div class="">
      <nav class="navbar mbheader ">
         <a class="navbar-brand" href="<?php echo base_url(); ?>">
			 <img src="<?php echo ASSETS; ?>images/logo.png" class="logomb">
		 </a>
		  <span style="color:#ffffff"><?php if(check_auth_session()){ ?>Welcome <?php echo @$userInfo['firstname']; ?><?php } ?></span>
         <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
         <span class="navbar-toggler-icon"><i class="fa fa-bars toggleicon" aria-hidden="true"></i></span>
         </button>
         <div class="collapse navbar-collapse " id="collapsibleNavbar">
            <ul class="navbar-nav mbnav">
			<li class="nav-item">
						<a class="nav-link" href="<?php echo base_url('dashboard/addHome'); ?>">Add a Home</a>
					</li>
               <li class="nav-item">
                  <a class="nav-link" href="javascript:void(0);" onClick="getLocation();" >Near Me</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url('houseshistory'); ?>">Houses</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link"  href="<?php echo base_url('photosnhistory'); ?>">Photos & Stories</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link"href="<?php echo base_url('peoples'); ?>">People</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url('pages/architect'); ?>">Architect</a>
               </li>
				<?php if(check_auth_session()){ ?>
<!--					<li class="nav-item">-->
<!--						Welcome --><?php //echo @$userInfo['firstname'].' '.$userInfo['lastname']; ?>
<!--					</li>-->
					<li class="nav-item">
					<a class="nav-link" href="<?php echo base_url('dashboard/myhomes'); ?>">My Homes</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?php echo base_url('dashboard/myTimeLine'); ?>">My Timeline</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?php echo base_url('dashboard/myprofile'); ?>">Edit Profile</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?php echo base_url('account/logout'); ?>">Logout</a>
					</li>
				<?php }else{ ?>
				   <li class="nav-item">
					  <a class="nav-link" href="<?php echo base_url('account/login'); ?>">Login</a>
					  <a class=" fs13" href="javascript:void(0);" data-toggle="modal" data-target="#Register">Not Yet Registred?</a>
				   </li>
				<?php } ?>
            </ul>
         </div>
      </nav>
   </div>
</div>

<!-- The Modal -->
<div class="modal" id="Register">
	<div class="modal-dialog modal-lg" style="left:0%;">
		<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Sign Up For BrickStory Facts, Stories</h4>

			</div>

			<!-- Modal body -->
			<div class="modal-body">
				Submit the below form to register.
				<form method="post" action="<?php echo base_url('account/register'); ?>" id="myform">

				<div class="row">
						<div class="col-md-6 mt20 form-group mb0">
							<label class="tcgrey">First Name</label>
							<input type="text" name="firstname" class="form-control fs12" placeholder="First Name" required="required">
						</div>
						<div class="col-md-6  mt20 form-group mb0">
							<label class="tcgrey">Last Name</label>
							<input type="text" name="lastname" class="form-control fs12" placeholder="Last Name" required="required">
						</div>
						<div class="col-md-6 mt20 form-group mb0">
							<label class="tcgrey">Email Address</label>
							<input type="text" name="email" class="form-control fs12" placeholder="Email Address" required="required">
						</div>
						<div class="col-md-6 mt20">
							<label class="tcgrey">Password</label>
							<input type="password" name="password" class="form-control fs12" placeholder="Password" required="required">
						</div>
						<div class="col-md-6 mt20">
							<label class="tcgrey">Confirm Password</label>
							<input type="password" name="confirm_password" class="form-control fs12" placeholder="Confirm Password" required="required">
						</div>
						<div class="col-md-12 mt20 mb50  text-center">
							<button type="submit" class="btn registerbtn">Register</button>
							<button type="button" class="btn btn-default mt10" data-dismiss="modal">Close</button>
						</div>
				</div>
				</form>

			</div>

			<!-- Modal footer -->


		</div>
	</div>
</div>

