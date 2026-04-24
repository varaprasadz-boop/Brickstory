<?php //$this->load->view('partials/dashboard-top'); ?>
<div class="vwstryhero container-fluid ">
	<div class="container">


	</div>

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
							<?php if($home['year_built'] <= 1940){ ?>
								<div class="bcca-breadcrumb-item">
<!--									<a href="--><?php //echo base_url('details/research/'.$homeId) ?><!--" class="colorfff">Research</a>-->
									<a class="colorfff" href="#">Research</a>
								</div>
							<?php } ?>
							<div class="bcca-breadcrumb-item">
								<a href="<?php echo base_url('details/timeline/'.$homeId) ?>" class="colorfff">Timeline</a>
							</div>
							<div class="bcca-breadcrumb-item">
								<a href="<?php echo base_url('details/people/'.$homeId) ?>" class="colorfff">People</a></div>
<!--							<div class="bcca-breadcrumb-item">-->
<!--								<a href="--><?php //echo base_url('details/story/'.$homeId) ?><!--" class="colorfff">Photo and Story</a></div>-->
							<div class="bcca-breadcrumb-item firstItem bcca-breadcrumb-item-active">
								<a href="<?php echo base_url('details/view/'.$homeId) ?>" class="colorfff">Photos and Stories</a> </div>
						</div>
					</div>
					
				<div class="col-md-12 ">
					<h4 class="tcgrey">HOME VIEW</h4>

				</div>
					<?php if(check_auth_session() && check_auth_session() == $home['user_id']){ ?>
						<?php $this->load->view("dashboard/partialDetails"); ?>
					<?php }else{ ?>
						<?php $this->load->view("property/partialDetails"); ?>
					<?php } ?>
					<div class="col-md-12 ">
					<h4 class="tcgrey">PHOTOS AND STORIES</h4>

				</div>
					<style>
						.imagecrop{
							margin-bottom: 7px;
							text-align: center;
						}
						.grid-block {position: relative;float: left;cursor:pointer;}
						.grid-block h4 {font-size: .9em;color: #333;background: #f5f5f5;margin: 0;padding: 10px;border: 1px solid #ddd;}
						.caption {display: none;position: absolute;top: 0;left: 0;background: url(<?php echo ASSETS ; ?>uploads/sub_brickstory_images/trans-black-50.png);width:100%;
							height: 100%;z-index: 9999;}
						.caption h3, .caption p {color: #fff;margin: 20px;}
						.caption h3 {margin: 20px 20px 10px;}
						.caption table {margin: 36px 20px 15px;font-weight:bold;background:none;color:#FFF;}
						.caption p, .caption td {font-size: .75em;margin: 0 20px 15px;line-height:2.2em;padding:1px 13px 1px 0px;}
						.caption a.learn-more {padding: 5px 10px;background: #08c;color: #fff;border-radius: 2px;-moz-border-radius: 2px;font-weight: bold;text-decoration: none;}
						.caption a.learn-more:hover {background: #fff;color: #08c;}
					</style>
					<?php if($sub_stories){
							foreach($sub_stories as $key => $val){
								$data = $val;
								?>
								<div class="col-lg-4 col-md-4 col-sm-4 imagecrop">
									<a href="<?php echo base_url('details/timeline/'.$homeId.'#timeline'.$data['id']); ?>">
										<div class="grid-block slide">
											<div class="caption toppad">
											<table cellpadding="2" cellspacing="2">
												<tr>
													<td>Date:</td>
													<td>
														<?php
														if (isset($data['approximate_date']) && $data['approximate_date'] != 0)
														{
															$created_date = date('M  Y', strtotime($data['approximate_date']));
															//print $data['approximate_date'];
															print $created_date;
														}
														else
														{
															echo '-';
														}
														?>
													</td>
												</tr>
												<tr>
													<td>Season:</td>
													<td>
														<?php
														if (isset($data['season_id']) && $data['season_id'] != 0)
														{
															print $data['season_value'];
														}
														else
														{
															echo '-';
														}
														?>
													</td>
												</tr>
												<tr>
													<td>Event:</td>
													<td>
														<?php
														if (isset($data['event_id']) && $data['event_id'] != 0)
														{
															print $data['event_value'];
														}
														else
														{
															echo '-';
														}
														?>
													</td>
												</tr>
												<tr>
													<td>Side of House:</td>
													<td>
														<?php
														if (isset($data['side_of_house_id']) && $data['side_of_house_id'] != 0)
														{
															print $data['side_of_house_value'];
														}
														else
														{
															echo '-';
														}
														?>
													</td>
												</tr>
												<tr>
													<td>Room:</td>
													<td>
														<?php
														if (isset($data['room_id']) && $data['room_id'] != 0)
														{
															print $data['room_value'];
														}else{
															echo '-';
														}
														?>
													</td>
												</tr>
											</table>
										</div>
											<?php
												if(is_file('./assets/uploads/sub_brickstory_images/'.$val['story_photo'])){
													$url = "uploads/sub_brickstory_images/".$val['story_photo'];
												}else{
													$url = "uploads/brickstory_images/crop/story.jpg";
												}
											?>
											<img src="<?php echo ASSETS.$url; ?>" alt="Snow" class="img-fluid">
										</div>
									</a>
								</div>
							<?php } ?>
					<?php } ?>
					<div class="col-md-12 text-center mt-3">
						<a href="<?php echo base_url("dashboard/addPhotoStory/".$home['id']); ?>" class="btn btn-primary" style="background-color: #516466;">Add a Photo and Story</a>
						<a href="<?php echo base_url("dashboard/addPeople/".$home['id']); ?>" class="btn btn-primary" style="background-color: #516466;">Add a Person</a>
					</div>
				</div>

			</div>
			<?php if(check_auth_session()){ ?>
				<?php $this->load->view('partials/dashboard-left-bottom'); ?>
			<?php } ?>
		</div>

	</div>
</div>


