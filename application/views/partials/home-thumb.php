<?php 
 if(is_file('./assets/uploads/brickstory_images/'.$val['home_profile_photo'])){
    $url = ASSETS.'uploads/brickstory_images/'.$val['home_profile_photo'];
}else{
    $url = ASSETS.'uploads/brickstory_images/crop/story.jpg';
}
?>
<div class="<?php echo $val['cls'] ?> imagecrop">
									<div class="top-left" style="z-index:999;top:0px;"><?php echo $val['year_built']; ?></div>

									<div class="grid-block houseslide">
										<div class="caption" data-id="<?php echo $val['id']; ?>"></div>
											 <div class="img200">
											<img src="<?php echo $url; ?>" alt="Snow" class="portrait">
</div>
											<div class="bottom-right">
										<ul class="list-inline">
											<li class="list-inline-item">
												<a target="_blank" href="https://maps.google.com/?q=<?php echo $val['address1']; ?>, <?php echo $val['city']; ?>, <?php echo $val['state']; ?> <?php echo ($val['zip'] != 0)?($val['zip']):(''); ?>">
													<i class="fa fa-map-marker icn" aria-hidden="true"></i>
												</a>
											</li>
										</ul>
									</div>

											<div class="detailshome boxcontainer col-md-12">
										<div class="row">
											<div class="col-md-12 col-lg-12 pt10">
												<p class="fs14 thumb-address" style="margin-bottom:0px;overflow: hidden;height: 22px;"><?php echo $val['address1']; ?><?php echo ($val['address2'] != "")?($val['address2']):(''); ?></p>
												<p class="fs14" style="margin-bottom:20px;"><?php echo $val['city']; ?>, <?php echo $val['state']; ?> <?php  echo $val['zip']; ?></p>
												<div class="row">
													<div class="col-md-6">
														<?php
														// echo $this->uri->segment(1);
														// echo $this->session->userdata('user_id') .' | '. $val['user_id'];
														if(check_auth_session() && ($this->uri->segment(2) == "myhomes" || $this->uri->segment(1) == "dashboard")){ 
																//if($this->session->userdata('user_id') == $val['user_id']){ ?>
																	<a href="javascript:void(0);"  data-toggle="modal" data-target="#monitorMyhome" onClick="$('#turnOff').attr('data-id',<?php echo $val['id']; ?>),$('.monitor_id').val('<?php echo $val['id']; ?>');$('#mobitorPhone').val('<?php echo $val['monitor_phone']; ?>');$('.monitor_address').text($(this).parent().parent().parent().find('.thumb-address').text());" class="btn vwdbtn btn-sm">Monitor my home</a>
															<?php //} ?>
														<?php } ?>
														<?php if(isset($get['lat']) && $get['lat'] != "" && isset($get['lng']) && $get['lng'] != ""){ ?>
															<?php echo number_format($val['distance'],2); ?>Mi
														<?php } ?>
													</div>
													<div class="col-md-6 text-right">
														<?php if(check_auth_session() && check_auth_session() == 1){ ?>
															<a class="btn vwdbtn btn-sm" href="<?php echo base_url('dashboard/homeDetails/'.$val['id']); ?>">View Details</a>
														<?php }else{ ?>
															<a class="btn vwdbtn btn-sm" href="<?php echo base_url('details/view/'.$val['id']); ?>">View Details</a>
														<?php } ?>
													</div>
												</div>
											</div>
										</div>
									</div>
									</div>
								</div>