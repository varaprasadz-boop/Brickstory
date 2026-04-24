<a href="#"><div class="hero-arch container-fluid">
	<!-- <div class="container text-center">
		<h1 class="colorfff heroheading">
			Architects
		</h1>
	</div>
 -->
</div></a>

<!--  latest listing start -->
<div class="llsection container-fluid pt10 pb100">
	<div class="container">

		<div class="row">
			<div class="col-md-12 col-lg-8">
				<div class="text-center">
								<h1 class=" fs50"><span>Architects and their Story</span></h1>
					<img src="<?php echo ASSETS; ?>images/arrow-title-1.png" class="mauto mt20">
				</div>
				<div class="archdetails archsctn">
					<div class="row">
						<div class="col-md-6 col-lg-5">
							<img class="img-fluid imgarch h230"  src="<?php echo ASSETS; ?>images/albert_khan.jpg" >
						</div>
						<div class="col-md-6 col-lg-7">
							<div>
								<h3>Albert Khan</h3>
								<h4>1921- 1974</h4>
								<p class="mt20 fs18">
									The story of the American home cannot be told without recognizing the great architects that brought each one to life.  BrickStory is adding the names of these visionaries to our catalog of homes every day, all while building out a repository that can be searched, referenced and shared by everyone and anyone.  Some were well known as Albert Khan and Louis Kamper, however others have yet to have their story told – we hope to help tell those stories, very, very soon.
								</p>
							</div>
<!--							<div class="p10"><button class="btn  hmbtn">View Story &nbsp;<img src="--><?php //echo ASSETS; ?><!--images/2400580271530177267-512.png" width="35px" height="22px"></button></div>-->
						</div>
					</div>
				</div>

			</div>
			<div class="col-lg-4 mt25">

				<div class="text-center">
					<h2 class="fs30"><span>Featured Homes</h2>
					<img src="<?php echo ASSETS; ?>images/arrow-title-1.png" class="mauto mt5">
					<div class="row pt25">
					<?php if($recentListing){ ?>
						<?php	foreach($recentListing as $key => $val){
						if(is_file('./assets/uploads/brickstory_images/'.$val->home_profile_photo)){
							$url = ASSETS.'uploads/brickstory_images/'.$val->home_profile_photo;
						}else{
							$url = ASSETS.'uploads/brickstory_images/crop/story.jpg';
						}
						?>
							<div class="col-lg-12 col-md-6 ">
								<div class="top-left"><?php echo $val->year_built; ?></div>

								<div class="imgwithtext ">
										<a href="<?php echo base_url('details/view/'.$val->id); ?>">
											<img src="<?php echo $url; ?>" style="width: 100%; height: auto;" class="img-fluid">
										</a>
									</div>
									<div class="content imgwithcontent mb20 "><?php echo $val->city ?>, <?php echo $val->state; ?> | <?php echo $val->year_built ?>
									<a class="btn vwdbtn" href="<?php echo base_url('details/view/'.$val->id); ?>">View Details</a>
										
							</div>
							
							</div>
						<?php } ?>
					<?php } ?>
					
<div class="col-lg-12 col-md-6 "> <a class="btn vwmore mt-10 mb-10" href="<?php echo base_url('houseshistory'); ?>"> View More</a></div>
				</div>
			</div>
		</div>

	</div>
</div>
</div>
<!--  latest listing end -->
