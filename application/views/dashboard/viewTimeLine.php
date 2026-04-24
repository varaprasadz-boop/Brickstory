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
							<div class="bcca-breadcrumb-item bcca-breadcrumb-item-active">
								<a href="<?php echo base_url('dashboard/viewTimeLine/'.$homeId) ?>" class="colorfff">Timeline</a>
							</div>
							<div class="bcca-breadcrumb-item">
								<a href="<?php echo base_url('dashboard/viewPeople/'.$homeId) ?>" class="colorfff">People</a></div>
								<!--							<div class="bcca-breadcrumb-item">-->
								<!--								<a href="--><?php //echo base_url('dashboard/viewStory/'.$homeId) ?><!--" class="colorfff">Photo and Story</a></div>-->
								<div class="bcca-breadcrumb-item">
									<a href="<?php echo base_url('dashboard/homeDetails/'.$homeId) ?>" class="colorfff">Photos and Stories</a> </div>
								</div>
							</div>
							
							<?php
							// $apprx_1 = $records['year_built'].'-01-01';
							$apprx_1 = date("Y-m-d");

							// $apprx_1 = '1000-01-01';
							// echo'im from here';
							// $start = $month = strtotime($records['year_built'].'-01-01');
							$start = $month = time();
							// $end = strtotime(date("Y-m-d"));
							// $end = strtotime("+1 days", $end);
							// $apprx_2 = date("Y-m-d");
							$end = strtotime($records['year_built'].'-01-01');
					
							$end = strtotime("+1 days", $end);

							// $apprx_2 = date("Y-m-d");
							$apprx_2 = $records['year_built'].'-01-01';
							
							?>
							<?php $this->load->view("dashboard/partialDetails"); ?>
							<div class="col-md-12">
								<h3 class="tcgrey"><strong>Timeline</strong></h3>
							</div>
							<ul class="timeline">
								<!-- Item 1 -->
								
								<?php
								$user_id = $this->session->userdata("user_id");
								while($end < $month)
								{
										if($apprx_1 != '' && $apprx_2 != '')
										{
											//echo 'im login user : ';
											// $idg = $sub_timeline[0]->master_story_id;
											$idg = $records['id'];
											$ci =& get_instance();
											//$ci->load->model('myhomes_model');
											$dfg = $ci->myhomes_model->get_persons_time($idg,$apprx_1,$apprx_2);
											//var_dump($dfg);
											$er=100;
											foreach ($dfg as $khr => $timelinepersons)
											{
												//										pre($timelinepersons);
								if(date('Y',$month) == date('Y',strtotime($timelinepersons['from_date'])) && date('M',$month) == date('M',strtotime($timelinepersons['from_date']))){
								?>
								<li>
									<div class="direction-r">
										<div class="flag-wrapper text-left ominline">
											<span class="hexa"></span>
											<div class="timeLineUserName">
												<?php echo $timelinepersons['frist_name'].' '.$timelinepersons['last_name'] ?>
											</div>
											<span class="flag p-0">
												<?php
												if($timelinepersons['Indicator'] == 'F')
												{
												echo 'Moved In ';
												}
												if($timelinepersons['Indicator'] == 'T') {
													echo 'Moved Out';
												}
												?>
											</span>
											<span class="time-wrapper">
												
												<span class="time">
													<?php
													if (date("Y", strtotime($timelinepersons['from_date'])) != 0000)
													{																		
														echo date("M", strtotime($timelinepersons['from_date']));																		?> <span><?php echo date("Y", strtotime($timelinepersons['from_date'])); ?></span>						<?php
													}
													else
													{																
														echo date("M", strtotime($timelinepersons['to_date']));	?>
													<span><?php echo date("Y", strtotime($timelinepersons['to_date'])); ?></span>																		<?php
													}		?>
												</span></span>
											</div>
										</div>
										<div class="direction-l">
											<div class="story-img-old">
												<?php
													if(is_file('./assets/uploads/peoples/'.$timelinepersons['person_photo'])){
														$url = ASSETS.'uploads/peoples/'.$timelinepersons['person_photo'];
													}elseif(is_file('./assets/uploads/peoples/'.$timelinepersons['person_photo'])){
														$url = ASSETS.'uploads/peoples/'.$timelinepersons['person_photo'];
													}else{
														$url = ASSETS.'uploads/peoples/crop/story.jpg';
													}

													if(is_file('./assets/uploads/sub_brickstory_images/'.$timelinepersons['person_photo'])){
														$largeUrl = ASSETS.'uploads/sub_brickstory_images/'.$timelinepersons['person_photo'];
													}elseif(is_file('./assets/uploads/sub_brickstory_images/'.$timelinepersons['person_photo'])){
														$largeUrl = ASSETS.'uploads/sub_brickstory_images/'.$timelinepersons['person_photo'];
													}else{
														$largeUrl = ASSETS.'uploads/peoples/story.jpg';
													}
												?>
												<a data-fancybox="gallery" href="<?php echo $largeUrl;?>">
													<img src="<?php echo $url;?>" class="img-responsive  images3"/>
												</a>
											</div>
										</div>
									</li>
									<?php
									}
									}
									foreach ($sub_timeline as $key => $timelinep){
									if(date('Y',$month) == date('Y',strtotime($timelinep->approximate_date))
									&& date('M',$month) == date('M',strtotime($timelinep->approximate_date))){
									//echo 'im from new';
									if(($timelinep->user_id == $user_id) || ($user_id == '1')){ ?>
									<li class="timeline-inverted" id="timeline<?php echo $timelinep->id; ?>">
										<div class="direction-l">
											<!--														<div class="desc">-->
											<div class="story-img-old">
												<?php
												if(is_file('./assets/uploads/sub_brickstory_images/'.$timelinep->story_photo)){
													$url = ASSETS.'uploads/sub_brickstory_images/'.$timelinep->story_photo;
												}else{
													$url = ASSETS.'uploads/sub_brickstory_images/crop/story.jpg';
												}
												if(is_file('./assets/uploads/sub_brickstory_images/'.$timelinep->story_photo)){
													$largeUrl = ASSETS.'uploads/sub_brickstory_images/'.$timelinep->story_photo;
												}else{
													$largeUrl = ASSETS.'uploads/sub_brickstory_images/story.jpg';
												}
												?>
												<a href="<?php echo $largeUrl; ?>" title="" data-fancybox="gallery">
													<img class="cropsize  img-responsive images2" src="<?php echo $url; ?>">
												</a>
												<a id="sub_story_<?php echo $timelinep->id; ?>" onClick="$('#popup_story_id').val(<?php echo $timelinep->id; ?>);" data-toggle="modal" data-target="#exampleModal" href="javascript:void(0);" class="popup">
													<i class="fa fa-pencil edit-pencil"></i> Edit
												</a>
											</div>
											<!--														</div>-->
										</div>
										<div class="direction-r">
											<div class="flag-wrapper text-left ">
												<span class="hexa"></span>
												<span class="flag p-0"><?php //echo $timelinep->firstname . " " . substr($timelinep->lastname, 0, 1); ?></span>
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
											<!--														<div class="desc">-->
											<!-- sub added here-->
											<!--															<div class="row">-->
											<div class="col-sm-12 right-col">
												<div class="col-md-23 col-xs-12 pull-right">
													<div class="user-detail editv" style="text-align:left;">
														<?php
														$created_date = date('M Y', strtotime($timelinep->created_on));
														?>
														<span class="name"><?php //echo $timelinep->firstname . " " . substr($timelinep->lastname, 0, 1); ?></span>
														<span><?php //echo $created_date; ?></span>
														<!--<p>Setting:<span>Outdoor<a href="#" title="edit"><i class="fa fa-pencil"></i></a><span></p>-->
														<p class="editpo">
															<label style="margin-left:0;width:130px;font-weight:bold;margin-right:50px;" class="col-sm-6 text-right">Setting:</label>
															<a href="#" class="editableTimeLine" id="setting_id" data-type="select" data-source="<?php echo base_url('dashboard/getStats?setting=1'); ?>" data-pk="<?php echo $timelinep->id; ?>" data-value="<?php echo $timelinep->setting_id; ?>" data-title="Update Setting">
																<?php echo (isset($setting[$timelinep->setting_id]) && $timelinep->setting_id != 0) ? $setting[$timelinep->setting_id] : 'Not Available'; ?>
															</a>
														</p>
														<p class="editpo">
															<label style="margin-left:0;width:130px;font-weight:bold;margin-right:50px;" class="col-sm-6 text-right">Season:</label>
															<a href="#" class="editableTimeLine" id="season_id" data-type="select" data-source="<?php echo base_url('dashboard/getStats?season=1'); ?>" data-pk="<?php echo $timelinep->id; ?>" data-value="<?php echo $timelinep->season_id; ?>" data-title="Update Season">
																<?php echo (isset($season[$timelinep->season_id]) && $timelinep->season_id != 0) ? $season[$timelinep->season_id] : 'Not Available'; ?>
															</a>
														</p>
														<p class="editpo">
															<label style="margin-left:0;width:130px;font-weight:bold;margin-right:50px;" class="col-sm-5 text-right">Event:</label>
															<a href="#" class="editableTimeLine" id="event_id" data-type="select" data-source="<?php echo base_url('dashboard/getStats?event=1'); ?>" data-pk="<?php echo $timelinep->id; ?>" data-value="<?php echo $timelinep->event_id; ?>" data-title="Update Event">
																<?php echo (isset($event[$timelinep->event_id]) && $timelinep->event_id != 0) ? $event[$timelinep->event_id] : 'Not Available'; ?>
															</a>
														</p>
														<p class="editpo">
															<label class="sidehou" style="margin-left:0;width:130px;font-weight:bold;margin-right:50px;" class="col-sm-6 text-right">Side Of House:</label>
															<a href="#" class="editableTimeLine" id="side_of_house_id" data-type="select" data-source="<?php echo base_url('dashboard/getStats?side_of_house=1'); ?>" data-pk="<?php echo $timelinep->id; ?>" data-value="<?php echo $timelinep->side_of_house_id; ?>" data-title="Update Side of house">
																<?php echo (isset($side_of_house[$timelinep->side_of_house_id]) && $timelinep->side_of_house_id != 0) ? $side_of_house[$timelinep->side_of_house_id] : 'Not Available'; ?>
															</a>
														</p>
														<p class="editpo">
															<label style="margin-left:0;width:130px;font-weight:bold;margin-right:50px;" class="col-sm-6 text-right">Room:</label>
															<a href="#" class="editableTimeLine" id="room_id" data-type="select" data-source="<?php echo base_url('dashboard/getStats?room=1'); ?>" data-pk="<?php echo $timelinep->id; ?>" data-value="<?php echo (isset($room[$timelinep->room_id]) && $timelinep->room_id != 0) ? $room[$timelinep->room_id] : 'Not Available'; ?>" data-title="Update Room">
																<?php echo (isset($room[$timelinep->room_id]) && $timelinep->room_id != 0) ? $room[$timelinep->room_id] : 'Not Available'; ?>
															</a>
														</p>
														<div class="edit-story-block clearfix">
															<a href="#" class="editableTimeLine" style="width: 100%;display: block;border-bottom: none;" id="story_description" data-type="textarea" data-pk="<?php echo $timelinep->id; ?>"  data-title="Update Story Description">
																<?php
																if (!empty($timelinep->story_description)) {
																	echo trim($timelinep->story_description);
																}
																?>
															</a>
														</div>
														<ul  style="padding-left: 0; margin:10px 0"  class="social-icons main-conetnt-share text-center visible-sm visible-xs">
														
																<a href="javascript:void(0)"
																	target="_blank"
																	class="facebook btn btn-primary facebook-share"
																	url="<?php echo base_url() . 'details/timeline/' . $homeId . '#timeline'. $timelinep->id ?>"
																	title="Share on Facebook"
																	title1="<?php echo $records['address1'] ?>"
																	picture="<?php echo base_url() . 'assets/uploads/sub_brickstory_images/' . ((!empty($timelinep->story_photo))?$timelinep->story_photo:'brickstory.jpg'); ?>"
																	caption="<?php echo @$address1; ?>"
																	desc="<?php echo 'Room: ' . ($records['bedroom_id'] == 0 ? "Not Available" : $records['bedroom_id']) . ', Approximate date:' . ($timelinep->approximate_date != '01/01/1970' ?  date('F d, Y',strtotime($timelinep->approximate_date)):'Not available'); ?>"
																	msg="message1">
																	<i class="fa fa-facebook"></i>
																</a>
															
																<a href="javascript:void(0)" target="_blank" title="Share on Twitter" class="btn btn-primary twitter twitter-share" data-url="<?php echo base_url() . 'user_timeline/edit/' . @$final_encrypted_id . '#main-content'. $key ?>">
																	<i class="fa fa-twitter"></i>
																</a>
															
														</ul>
														<ul style="padding-left: 0; margin:20px 0" class="social-icons main-conetnt-share text-center hidden-sm hidden-xs">
															
																<a href="javascript:void(0)"
																	target="_blank"
																	class="btn btn-primary facebook facebook-share"
																	url="<?php echo base_url() . 'details/timeline/' . $homeId . '#timeline'. $timelinep->id ?>"
																	title="Share on Facebook"
																	title1="<?php echo $records['address1'] ?>"
																	picture="<?php echo base_url() . 'assets/uploads/sub_brickstory_images/crop/' . ((!empty($timelinep->story_photo))?$timelinep->story_photo:'brickstory.jpg'); ?>"
																	caption="<?php echo @$address1; ?>"
																	desc="<?php echo 'Room: ' . ($records['bedroom_id'] == 0 ? "Not Available" : $records['bedroom_id']) . ', Approximate date:' . ($timelinep->approximate_date != '01/01/1970' ?  date('F d, Y',strtotime($timelinep->approximate_date)):'Not available'); ?>"
																	msg="message1">
																	<i class="fa fa-facebook"></i>
																</a>
															
																<a href="javascript:void(0)" target="_blank" title="Share on Twitter" class="btn btn-primary twitter twitter-share" data-url="<?php echo base_url() . 'user_timeline/edit/' . @$final_encrypted_id . '#main-content'. $key ?>">
																	<i class="fa fa-twitter"></i>
																</a>
															
														</ul>
													</div>
												</div>
											</div>
											<!--															</div>-->
											<!--sub ends here-->
											<!--														</div>-->
										</div>
									</li>
									<?php
									}else{ // user if
									// echo 'im else';
									?>
									<li class="timeline-inverted" id="timeline<?php echo $timelinep->id; ?>">
										<div class="direction-l">
											<!--														<div class="desc">-->
											<div class="story-img-old">
												<?php
												if(is_file('./assets/uploads/sub_brickstory_images/'.$timelinep->story_photo)){
													$url = ASSETS.'uploads/sub_brickstory_images/crop/'.$timelinep->story_photo;
												}else{
													$url = ASSETS.'uploads/sub_brickstory_images/crop/story.jpg';
												}
												if(is_file('./assets/uploads/sub_brickstory_images/'.$timelinep->story_photo)){
													$largeUrl = ASSETS.'uploads/sub_brickstory_images/'.$timelinep->story_photo;
												}else{
													$largeUrl = ASSETS.'uploads/sub_brickstory_images/story.jpg';
												}
												?>
												<a href="<?php echo $largeUrl; ?>" title="" data-fancybox="gallery">
													<img src="<?php echo $url; ?>" class="img-responsive img-circle images1"  style="width: 215px;height: 215px;display: block;margin: auto;">
												</a>
											</div>
											<!--														</div>-->
										</div>
										<div class="direction-r">
											<div class="flag-wrapper text-left ">
												<span class="hexa"></span>
												<span class="flag p-0"></span>
												<span class="time-wrapper">
													<span class="time">
														<?php  if (date("Y", strtotime($timelinep->approximate_date)) != 0000) {
															echo date("M", strtotime($timelinep->approximate_date));
														?> <span><?php echo date("Y", strtotime($timelinep->approximate_date)); ?></span>
														<?php
														} else {
														echo "&nbsp";
														} ?>
													</span>
												</span>
											</div>
											<!--														<div class="desc">-->
											<!-- sub added here-->
											<!--															<div class="row">-->
											<div class="col-sm-12 right-col">
												<div class="col-md-12 col-xs-12 col-xs-offset-0 col-sm-offset-0 pull-right">
													<div class="user-detail editv" style="text-align:left;">
														<?php
														$created_date = date('M Y', strtotime($timelinep->created_on));
														?>
														<span class="name"><?php //echo $timelinep->firstname . " " . substr($timelinep->lastname, 0, 1); ?></span>
														<span><?php //echo $created_date; ?></span>
														<!--<p>Setting:<span>Outdoor<a href="#" title="edit"><i class="fa fa-pencil"></i></a><span></p>-->
														<p class="editpo">
															<label style="margin-left:0;width:116px;font-weight:bold;" class="col-sm-4 col-sm-offset-1 text-right">Setting:</label>
															<span id="<?php echo 'setting-' . $timelinep->id; ?>" class="edit_setting text-left" data-type="select" data-pk="1" data-url="<?php echo base_url(); ?>user_timeline/edit_setting" data-title="Enter Setting">
																<?php echo ($timelinep->setting_id != 0) ? $setting[$timelinep->setting_id] : 'Not Available'; ?>
															</span>
														</p>
														<p class="editpo">
															<label style="margin-left:0;width:116px;font-weight:bold;" class="col-sm-4 col-sm-offset-1 text-right">Season:</label>
															<span id="<?php echo 'season-' . $timelinep->id; ?>" class="edit_season text-left" data-type="select" data-pk="1" data-url="<?php echo base_url(); ?>user_timeline/edit_season" data-title="Enter Season">
																<?php echo ($timelinep->season_id != 0) ? $season[$timelinep->season_id] : 'Not Available'; ?>
															</span>
														</p>
														<p class="editpo">
															<label style="margin-left:0;width:116px;font-weight:bold;" class="col-sm-4 col-sm-offset-1 text-right">Event:</label>
															<span id="<?php echo 'event-' . $timelinep->id; ?>" class="edit_event text-left" data-type="select" data-pk="1" data-url="<?php echo base_url(); ?>user_timeline/edit_event" data-title="Enter Event">
																<?php echo ($timelinep->event_id != 0) ? $event[$timelinep->event_id] : 'Not Available'; ?>
															</span>
														</p>
														<?php  //if ($timelinep->setting_id != 13) { ?>
														<p class="editpo">
															<label class="sidehou" style="margin-left:0;width:116px;font-weight:bold;" class="col-sm-4 col-sm-offset-1 text-right">Side Of House:</label>
															<span id="<?php echo 'side_of_house-' . $timelinep->id; ?>" class="edit_side_of_house text-left" data-type="select" data-pk="1" data-url="<?php echo base_url(); ?>user_timeline/edit_side_of_house" data-title="Enter Side Of House">
																<?php echo ($timelinep->side_of_house_id != 0) ? $side_of_house[$timelinep->side_of_house_id] : 'Not Available'; ?>
															</span>
														</p>
														<?php
														//}
														//if ($timelinep->setting_id != 14) {
														?>
														<p class="editpo">
															<label style="margin-left:0;width:116px;font-weight:bold;" class="col-sm-4 col-sm-offset-1 text-right">Room:</label>
															<span id="<?php echo 'room-' . $timelinep->id; ?>" class="edit_room text-left" data-type="select" data-pk="1" data-url="<?php echo base_url(); ?>user_timeline/edit_room" data-title="Enter Room">
																<?php echo ($timelinep->room_id != 0) ? $room[$timelinep->room_id] : 'Not Available'; ?>
															</span>
														</p>
														<?php //} ?>
														<div class="edit-story-block clearfix">
															<p id="<?php echo $timelinep->id; ?>" class="edit_description" data-type="textarea" data-pk="1" data-url="<?php echo base_url(); ?>user_timeline/edit_story" data-title="Enter Description">
																<?php
																if (!empty($timelinep->story_description)) {
																	echo $timelinep->story_description;
																}
																?>
															</p>
														</div>
														<ul style="padding-left:0; margin: 10px 0" class="social-icons text-center main-conetnt-share visible-sm visible-xs">
														
														<a href="javascript:void(0)" target="_blank" class="btn facebook btn-primary facebook-share" url="<?php echo base_url() . 'details/timeline/' . $homeId . '#timeline'. $key ?>" title="Share on Facebook" title1="<?php echo $records['address1'] ?>" picture="<?php echo base_url() . 'assets/uploads/sub_brickstory_images/crop/' . ((!empty($timelinep->story_photo))?$timelinep->story_photo:'brickstory.jpg'); ?>" caption="<?php echo @$address1; ?>" desc="<?php echo 'Room: ' . ($records['bedroom_id'] == 0 ? "Not Available" : $records['bedroom_id']) . ', Approximate date:' . ($timelinep->approximate_date != '01/01/1970' ?  date('F d, Y',strtotime($timelinep->approximate_date)):'Not available'); ?>"msg="message1">
															<i class="fa fa-facebook"></i></a>
																												
														<a href="javascript:void(0)" target="_blank" title="Share on Twitter" class="btn twitter btn-primary twitter-share" data-url="<?php echo base_url() . 'user_timeline/edit/' . @$final_encrypted_id . '#main-content'. $key ?>">
																	<i class="fa fa-twitter"></i>
																</a>
															
														</ul>
														<ul class="social-icons text-center main-conetnt-share hidden-sm hidden-xs">
																<a href="javascript:void(0)" target="_blank" class="facebook btn btn-primary facebook-share" 
																	url="<?php echo base_url() . 'details/timeline/' . @$final_encrypted_id . '#main-content'. $key ?>"
																	title="Share on Facebook" title1="<?php echo $records['address1'] ?>"picture="<?php echo base_url() . 'assets/uploads/sub_brickstory_images/crop/' . ((!empty($timelinep->story_photo))?$timelinep->story_photo:'brickstory.jpg'); ?>" caption="<?php echo @$address1; ?>"
																	desc="<?php echo 'Room: ' . ($records['bedroom_id'] == 0 ? "Not Available" : $records['bedroom_id']) . ', Approximate date:' . ($timelinep->approximate_date != '01/01/1970' ?  date('F d, Y',strtotime($timelinep->approximate_date)):'Not available'); ?>"
																	msg="message1">
																	<i class="fa fa-facebook"></i>

																</a>
															
														<a href="javascript:void(0)" target="_blank" title="Share on Twitter" class="btn btn-primary twitter twitter-share" data-url="<?php echo base_url() . 'user_timeline/edit/' . @$final_encrypted_id . '#main-content'. $key ?>">
																	<i class="fa fa-twitter"></i>
																</a>
															
														</ul>
													</div>
												</div>
												<!--															</div>-->
											</div>
											<!--sub ends here-->
											<!--														</div>-->
										</div>
									</li>
									<?php
									}
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
											<span class="flag p-0"><?php //echo $records['owner_name']; ?></span>
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
