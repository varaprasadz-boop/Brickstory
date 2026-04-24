<a href=""><div class="nearmehero container-fluid pt30 pb-3">
	<div class="container text-center">
		<h1 class="colorfff heroheading">
		Photos and stories
		</h1>
	</div>
</div>
</a>

<div class="llsection container-fluid pt10 pb50">
	<div class="container">
		<div class="row">
			
				<div class="col-md-12 col-sm-12 col-lg-12">
					<form method="get" class="searchForm" action="">
						
						<div class="searchbox lessHeight moiblesearch mb-4" >
						<h3 class="mt-0"><i class="fa fa-filter"></i> Filter</h3>

					<!--					<h5>Filters-->
					<!--						--><?php //if(isset($get['search'])){ ?>
					<!--							<a href="--><?php //echo base_url('photosnhistory'); ?><!--"style="padding:0px 10px;" class="btn btn-primary pull-right btn-sm">clear <i class="fa fa-close"></i> </a>-->
					<!--						--><?php //} ?>
					<!--					</h5>-->
					<div class="col-md-2">
						<div class="form-group">
							<select name="setting_id" id="setting_id" class="form-control">
								<option value="">Setting</option>
								<?php if($settings){
									foreach($settings as $k => $v){
										$selected = '';
										if(isset($get['setting_id'])){
											if($get['setting_id'] == $k){
												$selected = ' selected="selected"';
											}
										}
										?>
										<option value="<?php echo $k; ?>" <?php echo $selected; ?>><?php echo $v; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<select name="season_id" id="season_id" class="form-control">
								<option value="0" selected="selected">Season</option>
								<?php if($season){
									foreach($season as $k => $v){
										$selected = '';
										if(isset($get['season_id'])){
											if($get['season_id'] == $k){
												$selected = ' selected="selected"';
											}
										}
										?>
										<option value="<?php echo $k; ?>" <?php echo $selected; ?>><?php echo $v; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<select name="event_id" id="event_id" class="form-control">
								<option value="0" selected="selected">Event</option>
								<?php if($events){
									foreach($events as $k => $v){
										$selected = '';
										if(isset($get['event_id'])){
											if($get['event_id'] == $k){
												$selected = ' selected="selected"';
											}
										}
										?>
										<option value="<?php echo $k; ?>" <?php echo $selected; ?>><?php echo $v; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<select name="side_of_house_id" id="side_of_house_id" class="form-control">
								<option value="">Side of House</option>
								<?php if($side_of_house){
									foreach($side_of_house as $k => $v){
										$selected = '';
										if(isset($get['side_of_house_id'])){
											if($get['side_of_house_id'] == $k){
												$selected = ' selected="selected"';
											}
										}
										?>
										<option value="<?php echo $k; ?>" <?php echo $selected; ?>><?php echo $v; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<select name="bedroom_id" id="bedroom_id" class="form-control">
								<option value="">Room</option>
								<?php
								$bedroom = get_dropdown_value('room');
								if($bedroom){
									foreach($bedroom as $k => $v){
										$selected = '';
										if(isset($get['bedroom_id'])){
											if($get['bedroom_id'] == $k){
												$selected = ' selected="selected"';
											}
										}
										?>
										<option value="<?php echo $k; ?>" <?php echo $selected; ?>><?php echo $v; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label class="m-0"><input type="checkbox" class="checkboxInput" <?php echo isset($get['nrhp'])?('checked="checked"'):(''); ?> name="nrhp"> NRHP Property</label>
							<?php if($searchSubmit){ ?>
									<a class="btn btn-primary btn-xs" href="<?php echo base_url('photosnhistory'); ?>"><i class="fa fa-close"></i> Clear</a>
								<?php } ?>
						</div>
						
					</div>
					
				</div>
			</div>
		</form>
</div>				
				<div class="row">
					<?php if($result){
						 foreach($result as $key => $val){
//						 	pre($val);
							 if(is_file('./assets/uploads/brickstory_images/'.$val->story_photo)){
								 $url = ASSETS.'uploads/brickstory_images/'.$val->story_photo;
							 }else{
								//  $url = '';
								 $url = ASSETS.'uploads/story.jpg';
							 }
							 $val = (array)$val;
							 $data = $val;
							 ?>
							 <div class="col-lg-3 col-sm-3 col-md-3 imagecrop">
								 	<div class="grid-block">
									 <div class="caption">
										 <table cellpadding="2" cellspacing="2">
											 <tr>
												 <td class="right">Date:</td>
												 <td class="left">
													 <?php
													 if (isset($data['approximate_date']))
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
												 <td class="right">Season:</td>
												 <td class="left">
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
												 <td class="right">Event:</td>
												 <td class="left">
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
												 <td class="right">Side of House:</td>
												 <td class="left">
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
												 <td class="right">Room:</td>
												 <td class="left">
													 <?php
													 if (isset($data['room_id']) & $data['room_id'] != 0)
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
									 if(is_file('./assets/uploads/sub_brickstory_images/crop/'.$val['story_photo'])){
										 $url = "uploads/sub_brickstory_images/crop/".$val['story_photo'];
									 }else{
										 $url = "";
//										 $url = "uploads/brickstory_images/crop/story.jpg";
//										$largeImage = ASSETS.'uploads/brickstory_images/crop/story.jpg';
										$url = 'uploads/story.jpg';
									 }
									 ?>
										<div class="top-left top0"><?php echo date("Y",strtotime($data['approximate_date'])); ?></div>

										<div class="img200">
										  <?php if($url == ''){
										  	echo '<h5>'.$val['story_description'].'</h5>';
										  }else{ ?>
									 		<img src="<?php echo ASSETS.$url; ?>" alt="Snow" class="lazy portrait" >
										  <?php } ?>
									  </div>
									 <div class="detailshome col-md-12"> <!--- comment this boxcontainer class -->
											<div class="row">
												<div class="col-md-12 col-lg-12">
													<p class="fs14 text-left" style="margin-bottom:0px;overflow: hidden;height: 22px;"><?php echo $data['city'].', '.$data['state']; ?></p>
<!--													<p class="fs14 text-left" style="margin-bottom: 20px;">--><?php //echo date("Y",strtotime($data['approximate_date'])); ?><!--</p>-->
													<div class="row">
														<div class="col-md-4"></div>
														<div class="col-md-8 text-right">
															<?php if(check_auth_session() && check_auth_session() == 1){ ?>
																<a class="btn vwdbtn btn-sm" href="<?php echo base_url('dashboard/homeDetails/'.$data['master_story_id'].'#timeline'.$data['id']); ?>">View Details</a>
															<?php }else{ ?>
																<a class="btn vwdbtn btn-sm" href="<?php echo base_url('details/view/'.$data['master_story_id'].'#timeline'.$data['id']); ?>">View Details</a>
															<?php } ?>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
							 </div>
						<?php } ?>
					<?php }else{ ?>
							<h2 class="text-center" style="width: 100%;display: block;">No record found.</h2>
					<?php } ?>
				</div>
				<div class="col-md-12">
					<?php if($total_pages > 0){ ?>
						<nav aria-label="Page navigation example" style="float: right; margin-right: 10%;">
							<ul class="pagination pull-right">
								<?php $url = '#';
								$class = 'disabled';
								$query_string = '';
								if($_SERVER['QUERY_STRING']){
									$query_string = "?".$_SERVER['QUERY_STRING'];
								}
								if($real_page >= 1){
									$real_page = $real_page;
									$class = '';
									$url = base_url('photosnhistory/'.$real_page.$query_string);
								}
								?>
								<li class="page-item <?php echo $class; ?>"><a class="page-link" href="<?php echo $url; ?>">Previous</a></li>
								<?php
								for($i = max(1, $page - 3); $i <= min($page + 3, $total_pages); $i++){
									//                        for($i =1; $i <= $total_pages; $i++){
									$active = '';
									if($page+1 == $i){
										$active = 'active';
									}
									?>
									<li class="page-item <?php echo $active; ?>"><a class="page-link" href="<?php echo base_url('photosnhistory/'.$i.$query_string); ?>"><?php echo $i; ?></a></li>
								<?php }
								$url = '#';
								$class2 = '';
								if($real_page+1 == $total_pages) {
									$class2 = 'disabled';
								}
								if($total_pages >= $real_page){
									$real_page = $real_page+2;

									$url = base_url('photosnhistory/'.$real_page.$query_string);
								}

								?>
								<li class="page-item <?php echo $class2; ?>"><a class="page-link" href="<?php echo $url; ?>">Next</a></li>
							</ul>
						</nav>
					<?php } ?>
				</div>


		</div>

	</div>
</div>

<script>
	function searchForm(){
		$('.searchForm').submit();
	}

	$(function() {
		$(".searchForm").find("select").on("change", function () {
			searchForm();
		});
		$(".searchForm").find(".checkboxInput").on("change",function(){
			searchForm();
		});
	});
</script>
