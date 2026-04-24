<a href="#">
<div class="peoplehero container-fluid pt30 pb-3">
	<div class="container text-center">
		<h1 class="colorfff heroheading">
			<span>Peoples</span>
		</h1>

		<div class="row h-100 pull-right">
			<div class="col-sm-12  h-100  d-table">
				<div class=" d-table-cell align-bottom">
				</div>
			</div>
		</div>
	</div>
</div>
</a>
<style>
	.imagecrop {
		margin-bottom: 10px;
	}
</style>
<!--  latest listing start -->
<div class="llsection container-fluid pt10 pb50">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class=" searchbox lessHeight moiblesearch mb-4">
				<h3 class="mt-0"><i class="fa fa-filter"></i> Filter</h3>

					<form method="get" class="searchForm" action="">
						
							<div class="col-md-3">
								<div class="form-group">
									<input type="text" placeholder="First Name" value="<?php echo isset($get['first_name'])?($get['first_name']):('') ?>" name="first_name" class="form-control">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<input type="text" placeholder="Last Name" value="<?php echo isset($get['last_name'])?($get['last_name']):('') ?>" name="last_name" class="form-control" >
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<select name="relation_id" id="relation_id" class="form-control">
										<option value="0" selected="selected">-Relationship</option>
										<?php if($relationship){
											foreach($relationship as $k => $v){
												$selected = '';
												if(isset($get['relation_id'])){
													if($k == $get['relation_id']){
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
									<label><input type="checkbox" class="checkboxInput" <?php echo isset($get['nrhp'])?('checked="checked"'):(''); ?> name="nrhp"> NRHP Property</label>
								</div>
							</div>
							<div class="col-md-2">
								<div class="text-center">
										<?php if($searchSubmit){ ?>
											<a class="btn btn-primary btn-xs" href="<?php echo base_url('peoples'); ?>"><i class="fa fa-close"></i> Clear</a>
										<?php } ?>
									</div>
								</div>
						</div>

					</form>
			</div>
	
		
<div class="container">
<div class="row ">
					<?php if($peoples){
							foreach($peoples as $people){ ?>

								<?php $url = '';
								$largeImage = '';
								$cls = '';
								if(is_file('./assets/uploads/peoples/'.$people->person_photo)){
									$url = ASSETS.'uploads/peoples/'.$people->person_photo;
								}else{
									$url = ASSETS."uploads/peoples/crop/brickstory.jpg";
									$cls = 'height:250px;';
								}
								
								?>

								<div class="col-lg-3 col-sm-3 col-md-3 mb-5">
									<div class="grid-block">
										<a href="<?php if(check_auth_session() && check_auth_session() == 1){ echo base_url('dashboard/viewPeople/'.$people->master_story_id); }else{ echo base_url('details/people/'.$people->master_story_id); } ?>">
<!--											 <div class="img200">-->
											<img src="<?php echo $url; ?>" alt="Snow" style="width: 263px;<?php echo ($cls != "")?($cls):('height:250px;'); ?>" class="portrait">
<!--											</div>-->
										</a>


										<div class="detailshome boxcontainer col-md-12">
											<div class="row">
												<div class="col-md-12 col-lg-12 pt10">
													<div class="row">
														<div class="col-md-12 text-center">
															<h5><?php echo $people->frist_name.' '.$people->last_name; ?></h5>

														</div>
														<div class="col-md-12 text-center">
															<?php if(check_auth_session() && check_auth_session() == 1){ ?>
																<a class="btn vwdbtn btn-sm" href="<?php echo base_url('dashboard/viewPeople/'.$people->master_story_id); ?>">View Details</a>
															<?php }else{ ?>
																<a class="btn btn-block vwdbtn btn-sm" href="<?php echo base_url('details/people/'.$people->master_story_id); ?>">View</a>
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

					<?php } ?>
</div>

<!--			</div>-->

			<div class="col-md-12">
				<?php if($total_pages > 0){ ?>
					<nav aria-label="Page navigation example" style="float: right; margin-right: 10%;">
						<ul class="pagination pull-right">
							<?php $url = '#';
							$class = 'disabled';
							if($real_page >= 1){
								$real_page = $real_page;
								$class = '';
								$url = base_url('peoples/'.$real_page);
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
								<li class="page-item <?php echo $active; ?>"><a class="page-link" href="<?php echo base_url('peoples/'.$i); ?>"><?php echo $i; ?></a></li>
							<?php }
							$url = '#';
							$class2 = '';
							if($real_page+1 == $total_pages) {
								$class2 = 'disabled';
							}
							if($total_pages <= $real_page){
								$real_page = $real_page+2;

								$url = base_url('peoples/'.$real_page);
							} ?>
							<li class="page-item <?php echo $class2; ?>"><a class="page-link" href="<?php echo $url; ?>">Next</a></li>
						</ul>
					</nav>
				<?php } ?>
			</div>

		</div>

	</div>
</div>
<!--  latest listing end -->
<script>
	function searchForm(){
		$('.searchForm').submit();
	}
	$(function(){
		$(".searchForm").find(".checkboxInput").on("change",function(){
			searchForm();
		});

		$(".searchForm").find("select").on("change",function(){
			searchForm();
		});
		var delay = (function() {
			var timer = 0;
			return function(callback, ms) {
				clearTimeout(timer);
				timer = setTimeout(callback, ms);
			};
		})();
		$(".searchForm").find('input').keyup(function() {
			var searchbox = $(this).val();
			if (searchbox == '' || searchbox.length >= 4) {
				delay(function() {
					searchForm();
				}, 500);
			}
			return false;
		});
	});
</script>
