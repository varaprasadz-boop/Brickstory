<?php //$this->load->view('partials/dashboard-top'); ?>
<div class="vwstryhero container-fluid pb100">
	<div class="container">
	</div>
</div>
<style>
	.story-img-old{
		text-align:center;
	}
	.story-img-old > a > img{
		margin:auto;
	}
</style>
<div class="llsection container-fluid pb100">
	<div class="container">

		<div class="row ">
			<?php $this->load->view('partials/dashboard-left'); ?>

			<div class="col-md-12 col-lg-9">

				<div class="row pidetails">

			
					<?php
					$apprx_1 = '1900-01-01';
					// $apprx_1 = '1000-01-01';
					// echo'im from here';
					$start = $month = @strtotime('1900-01-01');
					$end = strtotime(date("Y-m-d"));
					$end = strtotime("+1 days", $end);
					$apprx_2 = date("Y-m-d"); ?>
<!--					--><?php //$this->load->view("dashboard/partialDetails"); ?>

					<div class="col-md-12">
						<h3 class="tcgrey">My Timeline</h3>
					</div>
					<ul class="timeline">


						<?php
						$user_id = $this->session->userdata("user_id");
						while($month < $end)
						{

								if($apprx_1 != '' && $apprx_2 != '')
								{
									//echo 'im login user : ';

									// $idg = $sub_timeline[0]->master_story_id;
//									$idg = @$records['id'];
									$ci =& get_instance();
									//$ci->load->model('myhomes_model');
									$dfg = $ci->myhomes_model->getLivedInTimeline($this->session->userdata('user_id'),$apprx_1,$apprx_2,'user');
//									query();
//									echo '<br />';
//									pre($dfg);
									//var_dump($dfg);
									$er=100;
									foreach ($dfg as $khr => $timelinepersons)
									{
										if(date('Y',$month) == date('Y',strtotime($timelinepersons['from_date'])) && date('M',$month) == date('M',strtotime($timelinepersons['from_date']))){
											?>
											<li>
<!--												Moved In -->
												<div class="direction-r movedInSection">
													<div class="flag-wrapper">
														<span class="hexa"></span>
														<div class="time-wrapper">
															<span class="time">
																	<?php
																	if (date("Y", strtotime($timelinepersons['from_date'])) != 0000)
																	{

																			echo date("M", strtotime($timelinepersons['from_date'])); ?>
																			<span> <?php echo date("Y", strtotime($timelinepersons['from_date'])); ?></span>
																	<?php } ?>
																</span>
														</div>
														<div class="flag">
																<?php

																	echo 'Moved In ';

																?>
															</div>
														
													</div>

												</div>
<!--												Property Information-->
												<div class="direction-l">
<!--													<div class="desc">-->
														<div class="story-img-old">
															<?php
//															pre($timelinepersons);
															if(is_file('./assets/uploads/brickstory_images/'.$timelinepersons['home_profile_photo'])){
																$url = ASSETS.'uploads/brickstory_images/'.$timelinepersons['home_profile_photo'];
															}elseif(is_file('./assets/uploads/brickstory_images/'.$timelinepersons['home_profile_photo'])){
																$largeUrl = ASSETS.'uploads/brickstory_images/'.$timelinepersons['home_profile_photo'];
															}else{
																$url = ASSETS.'uploads/brickstory_images/story.jpg';
															}
															if(is_file('./assets/uploads/brickstory_images/'.$timelinepersons['home_profile_photo'])){
																$largeUrl = ASSETS.'uploads/brickstory_images/'.$timelinepersons['home_profile_photo'];
															}elseif(is_file('./assets/uploads/brickstory_images/'.$timelinepersons['home_profile_photo'])){
																$largeUrl = ASSETS.'uploads/brickstory_images/'.$timelinepersons['home_profile_photo'];
															}else{
																$largeUrl = ASSETS.'uploads/brickstory_images/story.jpg';
															}
															?>
															<a data-fancybox="gallery" href="<?php echo $largeUrl;?>">
																	<img src="<?php echo $url;?>" class="img-responsive images3"  />
																</a>

															<?php echo $timelinepersons['address1']; ?><br />
															<?php echo $timelinepersons['city']; ?>, <?php echo $timelinepersons['state']; ?> <?php echo $timelinepersons['zip']; ?>
														</div>
<!--													</div>-->
												</div>
												<!-- Moved Out --->
												<div class="direction-r movedOutSection">
													<div class="flag-wrapper">
														<span class="hexa"></span>
														<?php
																	if (date("Y", strtotime($timelinepersons['to_date'])) != 0000)
																	{
																		if($timelinepersons['lived_here'] != 1){ ?>
																			<?php if($timelinepersons['to_date'] != "01/01/1970"){ ?>
																			<div class="time-wrapper">
																				<span class="time">
																					<?php echo date("M", strtotime($timelinepersons['to_date'])); ?>
																					<span> <?php echo date("Y", strtotime($timelinepersons['to_date'])); ?></span>

																				</span>
																			</div>
																			<?php } ?>
														<?php	}
														}
														?>
														<div class="flag">
															<?php

															if($timelinepersons['lived_here'] == 1) {
																echo 'Currently Living Here';
															}else{
																if($timelinepersons['to_date'] != "01/01/1970"){
																	echo 'Moved Out';
																}
															}
															?>
														</div>

													</div>

												</div>
											</li>
											<?php
										}
									}

								}

							$month = strtotime("+1 month", $month);
						} // while end


						?>
					</ul>

				</div>

			</div>
			<?php $this->load->view('partials/dashboard-left-bottom'); ?>
		</div>

	</div>
</div>


<!-- Modal -->
<div class="modal fade"  id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="left:0%;" role="document">
		<div class="modal-content">
			<form method="post" action="<?php echo base_url('dashboard/updateTimelineImage'); ?>" enctype="multipart/form-data">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Update Story Image</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Select Image</label>
						<input required="required" type="file" class="form-control" name="image">
						<input type="hidden" name="story_id" class="popup_story_id" id="popup_story_id">
					</div>
				</div>
				<div class="col-md-12 mt20 mb50 text-center">
					<button type="submit" class="btn">Update Image</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>
