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
							<div class="bcca-breadcrumb-item bcca-breadcrumb-item-active">
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
				<?php if(check_auth_session() && check_auth_session() == $home['user_id']){ ?>
					<?php $this->load->view("dashboard/partialDetails"); ?>
				<?php }else{ ?>
					<?php $this->load->view("property/partialDetails"); ?>
				<?php } ?>
				<div class="col-md-12">
						<h3 class="tcgrey"><strong>Timeline</strong></h3>
					</div>
				<style>
					@import url(https://fonts.googleapis.com/css?family=Raleway:400,900);
					
				</style>
					<?php
					// $apprx_1 = $records['year_built'].'-01-01';
					$apprx_1 = date("Y-m-d");
					// $apprx_1 = '1000-01-01';
					// echo'im from here';
					// $start = $month = strtotime($records['year_built'].'-01-01');
					$start = $month = time();
					$end = strtotime($records['year_built'].'-01-01');
					
					$end = strtotime("+1 days", $end);

					// $apprx_2 = date("Y-m-d");
					$apprx_2 = $records['year_built'].'-01-01'
					?>
				<ul class="timeline">
					<!-- Item 1 -->


					<?php
					$user_id = $this->session->userdata("user_id");
					while($end < $month)
					{
							if($apprx_1 != '' && $apprx_2 != '')
							{
								$idg = $records['id'];
								$ci =& get_instance();
								$dfg1 = $ci->myhomes_model->get_persons_time($idg,$apprx_1,$apprx_2);

								$dfg=array_filter($dfg1);
								$len = count($dfg);
								foreach ($dfg as $khr => $timelinepersons)
								{
									// echo 'im from new';
									if(date('Y',$month) == date('Y',strtotime($timelinepersons['from_date'])) && date('M',$month) == date('M',strtotime($timelinepersons['from_date']))){
										// echo 'im from new';
										// echo '<pre>';
										// print_r($sub_timeline);
										?>

										<li class="timeline-inverted" id="timeline" <?php echo $idg.'---'.$start.'=='; ?>>
											<div class="direction-l" style="text-align: right;">
												<div class="flag-wrapper">
													<span class="hexa"></span>
													<div class="timeLineUserName">
														<?php echo $timelinepersons['frist_name'].' '.$timelinepersons['last_name'] ?>
													</div>
													<span class="flag">
																<?php

																if($timelinepersons['Indicator'] == 'F')
																{
																	echo '<span>Moved In </span>';
																}
																if($timelinepersons['Indicator'] == 'T')
																{
																	echo '<span>Moved Out </span>';
																}
																?>
															</span>
													<span class="time-wrapper"><span class="time">
																	<?php
																	if (date("Y", strtotime($timelinepersons['from_date'])) != 0000)
																	{
																		echo date("M", strtotime($timelinepersons['from_date']));
																		?> <span><?php echo date("Y", strtotime($timelinepersons['from_date'])); ?></span>
																		<?php
																	}
																	else
																	{
																		echo date("M", strtotime($timelinepersons['to_date']));
																		?> <span><?php echo date("Y", strtotime($timelinepersons['to_date'])); ?></span>
																		<?php
																	}
																	?>
																</span></span>
												</div>
												<!--													<div class="desc">-->
												<div class="edit-story-block edit-story-block1 clearfix">
													<p style="text-align:center;background:#d1d1d154;padding-bottom:6px;">
																	  <span>
																	  <?php
																	  if (!empty($timelinepersons['frist_name']))
																	  {
																		  //echo $timelinepersons['frist_name'];
																	  }
																	  ?>
																		  &nbsp;
																		  <?php
																		  if (!empty($timelinepersons['last_name']))
																		  {
																			//  echo $timelinepersons['last_name'];
																		  }
																		  ?>
																		  </span>
													</p>
												</div>
												<!--													</div>-->
											</div>
											<div class="direction-r">
												<div class="story-img-old">
													<?php
													if(is_file('./assets/uploads/peoples/'.$timelinepersons['person_photo'])){
														$url = ASSETS.'uploads/peoples/'.$timelinepersons['person_photo'];
													}elseif(is_file('./assets/uploads/peoples/'.$timelinepersons['person_photo'])){
														$url = ASSETS.'uploads/peoples/'.$timelinepersons['person_photo'];
													}else{
														$url = ASSETS.'uploads/peoples/crop/story.jpg';
													}
													if(is_file('./assets/uploads/peoples/'.$timelinepersons['person_photo'])){
														$largeUrl = ASSETS.'uploads/peoples/'.$timelinepersons['person_photo'];
													}elseif(is_file('./assets/uploads/peoples/crop/'.$timelinepersons['person_photo'])){
														$largeUrl = ASSETS.'uploads/peoples/crop/'.$timelinepersons['person_photo'];
													}else{
														$largeUrl = ASSETS.'uploads/peoples/story.jpg';
													}
													?>
													<a data-fancybox="gallery" href="<?php echo $largeUrl;?>">
														<img src="<?php echo $url;?>" class="img-responsive images3"  />
													</a>
												</div>
											</div>

										</li>
										<?php
									}
								}
								foreach ($livedhere as $khr => $timelinepersons)
								{
									$timelinepersons = (array)$timelinepersons;
//									pre($timelinepersons);
									// echo 'im from new';
									if(date('Y',$month) == date('Y',strtotime($timelinepersons['from_date'])) && date('M',$month) == date('M',strtotime($timelinepersons['from_date']))){
										// echo 'im from new';
										// echo '<pre>';
										// print_r($sub_timeline);
										?>

										<li class="timeline-inverted" id="timeline" <?php echo $idg.'---'.$start.'=='; ?>>
											<div class="direction-r">
												<div class="flag-wrapper text-left ominline">
													<span class="hexa"></span>
														<div class="edit-story-block edit-story-block1 clearfix">
													<div class="timeLineUserName">
																	  <span>
																	  <?php
																	  if (!empty($timelinepersons['firstname']))
																	  {
																		  echo $timelinepersons['firstname'];
																	  }
																	  ?>
																		  &nbsp;
																		  <?php
																		  if (!empty($timelinepersons['lastname']))
																		  {
																			    echo $timelinepersons['lastname'];
																		  }
																		  ?>
																		  </span>
													</div>
												</div>
													<span class="flag p-0">
																<?php

																	echo '<span>Lived Here </span>';

																?>
															</span>
													<span class="time-wrapper"><span class="time">
																	<?php
																	if (date("Y", strtotime($timelinepersons['from_date'])) != 0000)
																	{
																		echo date("M", strtotime($timelinepersons['from_date']));
																		?> <span><?php echo date("Y", strtotime($timelinepersons['from_date'])); ?></span>
																		<?php
																	}
																	else
																	{
																		echo date("M", strtotime($timelinepersons['to_date']));
																		?> <span><?php echo date("Y", strtotime($timelinepersons['to_date'])); ?></span>
																		<?php
																	}
																	?>
																</span></span>
												</div>
												<!--													<div class="desc">-->
											
												<!--													</div>-->
											</div>
											<div class="direction-l" style="text-align: right;">
												<!--													<div class="desc">-->
												<div class="story-img-old">


													<?php if (!empty($timelinepersons['profile_photo']) && is_file("./assets/uploads/user_images/" . $timelinepersons['profile_photo'])) { ?>
														<a data-fancybox="gallery" href="<?php echo base_url() . "assets/uploads/user_images/" . $timelinepersons['profile_photo'];?>">
															<img src="<?php echo base_url(). "assets/uploads/user_images/".$timelinepersons['profile_photo'];?>" class=" test img-responsive " />
														</a>
													<?php } else { ?>
														<a data-fancybox="gallery" href="<?php echo base_url() . "assets/uploads/peoples/crop/brickstory.jpg";?>">

															<img src="<?php echo base_url() . "assets/uploads/peoples/crop/brickstory.jpg"; ?>" class="test img-responsive" >
														</a>
													<?php } ?>
												</div>
												<!--													</div>-->
											</div>

										</li>
										<?php
									}
								}
								foreach ($sub_timeline as $key => $timelinep){
									if(date('Y',$month) == date('Y',strtotime($timelinep->approximate_date)) && date('M',$month) == date('M',strtotime($timelinep->approximate_date))){
										// echo 'im from new';
										?>

										<li>
											<div class="direction-l" style="text-align: right;" id="timeline<?php echo $timelinep->id; ?>">

												<!--													<div class="desc">-->
												<div class="story-img-old">
													<?php if (!empty($timelinep->story_photo)) {

														if(is_file('./assets/uploads/sub_brickstory_images/crop/'.$timelinep->story_photo)){
															$url = ASSETS."uploads/sub_brickstory_images/crop/".$timelinep->story_photo;
														}else if(is_file('./assets/uploads/sub_brickstory_images/'.$timelinep->story_photo)){
															$url = ASSETS."uploads/sub_brickstory_images/".$timelinep->story_photo;
														}else{
															$url = ASSETS."uploads/brickstory_images/crop/story.jpg";
														}

														?>
														<a href="<?php echo $url; ?>" title="" data-fancybox="gallery">
															<img src="<?php echo $url; ?>" class="test2 img-responsive " >
														</a>
													<?php } else { ?>
														<a data-fancybox="gallery" href="<?php echo base_url() . "assets/uploads/peoples/crop/brickstory.jpg";?>">
								<img src="<?php echo base_url() . "assets/uploads/sub_brickstory_images/crop/brickstory.jpg"; ?>" class="test2 img-responsive">
														</a>
													<?php } ?>

												</div>
												<!--													</div>-->
											</div>
											<div class="direction-r">
												<div class="flag-wrapper">
													<span class="hexa"></span>
<!--													<span class="flag">--><?php //echo $records['owner_name']; ?><!--</span>-->
													<span class="time-wrapper"><span class="time">
																	<?php
																	if (date("Y", strtotime($timelinep->approximate_date)) != 0000) {
																		echo date("M", strtotime($timelinep->approximate_date));
																		?> <span><?php echo date("Y", strtotime($timelinep->approximate_date)); ?></span>
																		<?php
																	} else {
																		echo "&nbsp";
																	}
																	?>
																</span></span>
												</div>
												<!--													<div class="desc">-->
<!--												<div class="row">-->
													<div class="col-sm-12 right-col">
														<div class="col-12 pull-right">
															<div class="user-detail editv" style="text-align:left;">
																<?php
																$created_date = date('M Y', strtotime($timelinep->created_on));
																?>
																<span class="name"><?php //echo $timelinep->firstname . " " . substr($timelinep->lastname, 0, 1); ?></span>
																<span><?php //echo $created_date; ?></span>
																<!--<p>Setting:<span>Outdoor<a href="#" title="edit"><i class="fa fa-pencil"></i></a><span></p>-->
																<p class="editpo row">
																	<label class="col-sm-5 col-xs-5 col-sm-offset-1 text-right">Setting:</label>
																	<span id="<?php echo 'setting-' . $timelinep->id; ?>" class="col-sm-5 col-xs-5 edit_setting text-left" data-type="select" data-pk="1" data-url="<?php echo base_url(); ?>user_timeline/edit_setting" data-title="Enter Setting">
																		<?php echo ($timelinep->setting_id != 0) ? $setting[$timelinep->setting_id] : 'Not Available'; ?>
																	</span>
																</p>
																<p class="editpo row">
																	<label  class="col-sm-5 col-xs-5 col-sm-offset-1 text-right">Season:</label>
																	<span id="<?php echo 'season-' . $timelinep->id; ?>" class="col-sm-5 col-xs-5 edit_season text-left" data-type="select" data-pk="1" data-url="<?php echo base_url(); ?>user_timeline/edit_season" data-title="Enter Season">
																		<?php echo ($timelinep->season_id != 0) ? $season[$timelinep->season_id] : 'Not Available'; ?>
																	</span>

																</p>
																<p class="editpo row">
																	<label  class="col-sm-5 col-xs-5 col-sm-offset-1 text-right">Event:</label>
																	<span id="<?php echo 'event-' . $timelinep->id; ?>" class="col-sm-5 col-xs-5 edit_event text-left" data-type="select" data-pk="1" data-url="<?php echo base_url(); ?>user_timeline/edit_event" data-title="Enter Event">
																		<?php echo ($timelinep->event_id != 0) ? $event[$timelinep->event_id] : 'Not Available'; ?>
																	</span>
																</p>
																<?php  //if ($timelinep->setting_id != 13) { ?>
																<p class="editpo row">
																	<label  class="col-sm-5 col-xs-5 col-sm-offset-1 text-right">Side Of House:</label>
																	<span id="<?php echo 'side_of_house-' . $timelinep->id; ?>" class="col-sm-5 col-xs-5 edit_side_of_house text-left" data-type="select" data-pk="1" data-url="<?php echo base_url(); ?>user_timeline/edit_side_of_house" data-title="Enter Side Of House">
																		<?php echo ($timelinep->side_of_house_id != 0) ? $side_of_house[$timelinep->side_of_house_id] : 'Not Available'; ?>
																	</span>

																</p>
																<?php
																//}
																//if ($timelinep->setting_id != 14) {
																?>
																<p class="editpo row">
																	<label  class="col-sm-5  col-xs-5 col-sm-offset-1 text-right">Room:</label>
																	<span id="<?php echo 'room-' . $timelinep->id; ?>" class="edit_room text-left col-sm-5 col-xs-5" data-type="select" data-pk="1" data-url="<?php echo base_url(); ?>user_timeline/edit_room" data-title="Enter Room">
																		<?php echo ($timelinep->room_id != 0) ? $room[$timelinep->room_id] : 'Not Available'; ?>
																	</span>

																</p>
																<p class="editpo row">

																	<label class="col-sm-5 col-xs-5 col-sm-offset-1 text-right">Description:</label>

																	<span id="<?php echo $timelinep->id; ?>" class="edit_description col-sm-5 col-xs-5" data-type="textarea" data-pk="1" data-url="<?php echo base_url(); ?>user_timeline/edit_story" data-title="Enter Description">
																		<?php
																		if (!empty($timelinep->story_description)) {
																			echo $timelinep->story_description;
																		}else{
																			echo 'Not Available';
																		} ?>
																	</span>
																</p>
																<ul class="social-icons text-center main-conetnt-share visible-sm visible-xs">
																	<li>
																		<a href="javascript:void(0)"
																		   target="_blank"
																		   class="btn btn-primary facebook facebook-share"
																		   url="<?php echo base_url() . 'details/timeline/' . @$homeId . '#timeline'. $timelinep->id ?>"
																		   title="Share on Facebook"
																		   title1="<?php echo $records['address1'] ?>"
																		   picture="<?php echo base_url() . 'assets/uploads/sub_brickstory_images/crop/' . ((!empty($timelinep->story_photo))?$timelinep->story_photo:'brickstory.jpg'); ?>"
																		   caption="<?php echo @$address1; ?>"
																		   desc="<?php echo 'Room: ' . ($records['bedroom_id'] == 0 ? "Not Available" : $records['bedroom_id']) . ', Approximate date:' . ($timelinep->approximate_date != '01/01/1970' ?  date('F d, Y',strtotime($timelinep->approximate_date)):'Not available'); ?>"
																		   msg="message1">
																			<i class="fa fa-facebook"></i>
																		</a>
																	</li>
																	<li>
																		<a href="javascript:void(0)" target="_blank" title="Share on Twitter" class="twitter btn btn-primary twitter-share" data-url="<?php echo base_url() . 'user_timeline/edit/' . $homeId . '#main-content'. $key ?>">
																			<i class="fa fa-twitter"></i>
																		</a>
																	</li>
																</ul>
																<?php //} ?>
																<ul class="social-icons text-center main-conetnt-share hidden-sm hidden-xs">
																	<li>
																		<a href="javascript:void(0)"
																		   target="_blank"
																		   class="btn btn-primary facebook facebook-share"
																		   url="<?php echo base_url() . 'details/timeline/' . @$homeId . '#timeline'. $timelinep->id ?>"
																		   title="Share on Facebook"
																		   title1="<?php echo isset($records['address1'])?($records['address1']):('') ?>"
																		   picture="<?php echo base_url() . 'assets/uploads/sub_brickstory_images/crop/' . ((!empty($timelinep->story_photo))?$timelinep->story_photo:'brickstory.jpg'); ?>"
																		   caption="<?php echo isset($records['address1'])?($records['address1']):(''); ?>"
																		   desc="<?php echo 'Room: ' . ($records['bedroom_id'] == 0 ? "Not Available" : $records['bedroom_id']) . ', Approximate date:' . ($timelinep->approximate_date != '01/01/1970' ?  date('F d, Y',strtotime($timelinep->approximate_date)):'Not available'); ?>"
																		   msg="message1">
																			<i class="fa fa-facebook"></i>
																		</a>
																	</li>
																	<li>
																		<a href="javascript:void(0)" target="_blank" title="Share on Twitter" class="btn btn-primary twitter twitter-share" data-url="<?php echo base_url() . 'user_timeline/edit/' . @$homeId . '#main-content'. $key ?>">
																			<i class="fa fa-twitter"></i>
																		</a>
																	</li>
																</ul>
															</div>
														</div>

													</div>
<!--												</div>-->
												<!--													</div>-->
											</div>
										</li>
										<?php
									}

								}
							}
						$month = strtotime("-1 month", $month);
					} // while end


					?>
										<li>
						<div class="direction-r">
							<div class="flag-wrapper">
								<span class="hexa"></span>
<!--								<span class="flag">--><?php //echo $records['owner_name']; ?><!--</span>-->
								<span class="time-wrapper">
									<span class="time"><?php echo $records['year_built']; ?></span>
									<span style="color:#585b5b;margin:10px;"><?php echo $records['address1'] . ' was built'; ?></span>
									
								</span>
							</div>
							<!-- <div class="desc"><?php echo $records['address1'] . ' was built'; ?></div> -->
						</div>
					</li>
				</ul>

					
				</div>

			</div>
			<?php if(check_auth_session()){ ?>
				<?php $this->load->view('partials/dashboard-left-bottom'); ?>
			<?php } ?>
		</div>

	</div>
</div>


