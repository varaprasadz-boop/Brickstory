<div class="col-md-12 col-sm-12 col-lg-12">
	<?php

	if($this->uri->segment(1) != "houseshistory"){
		$searchRul = @base_url('search?lat='.$_GET['lat'].'&lng='.$_GET['lng']);
	}else{
		$searchRul = base_url('houseshistory');
	} ?>
	
	<form method="get" class="searchForm" action="<?php echo $searchRul; ?>">
		<div class="searchbox lessHeight mb-4">
	<!--		<h5>Filters</h5>-->
			<div class="container">
				<h3 class="mt-0"><i class="fa fa-filter"></i> Filter</h3>
			<div class="row">
				<div style="padding-right:0px;" class="col-md-1 mb-4">
					<a href="<?php echo base_url('search/'.$pagelink.'?'.str_replace("&type=map","",$_SERVER['QUERY_STRING'])); ?>"class="btn btn-primary btn-sm"><i class="fa fa-list-ol"></i> </a>
					<a href="<?php echo base_url('search/'.$pagelink.'?'.$_SERVER['QUERY_STRING']); ?>&type=map" class="btn btn-primary btn-sm "><i class="fa fa-map-marker"></i> </a>
					<a href="javascript:void(0);" class="showFilter d-lg-none d-xs-block btn btn-primary btn-sm pull-right" onClick="showFilter()">More <i class="fa fa-arrow-down"></i></a>
					<!-- <?php if(isset($_GET['owner_name'])){ ?>
						<a href="<?php echo $searchRul; ?>" class="showFilter d-lg-none d-xs-block btn btn-primary btn-sm">Clear<i class="fa fa-close"></i></a>
					<?php } ?> -->
					<?php if(isset($_GET['owner_name'])){ ?>

						<a href="<?php echo $searchRul; ?>" class="btn btn-primary btn-sm d-none d-xs-block">Clear <i class="fa fa-close"></i></a>
					<?php } ?>

				</div>
				<div class="col-md-2">
					<div class="form-group">
						<select name="state" class="form-control" id="states" data-bv-field="states">
							<option value="">State</option>
							<?php $get_states = state_array();
							foreach($get_states as $key => $val){
								$selected = '';
								if(isset($get['state']) && $get['state'] != ""){
									if($key == $get['state']){
										$selected = ' selected="selected"';
									}
								}
								?>
								<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $val; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<select name="house_style_id" id="house_style_id" class="form-control">
							<option value="0" selected="selected">House Style</option>
							<?php if($house_style){
								foreach($house_style as $k => $v){
									$selected = '';
									if(isset($get['house_style_id']) && $get['house_style_id'] != ""){
										if($k == $get['house_style_id']){
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
							<option value="0" selected="selected">Bedroom</option>
							<?php if($bedroom){
								foreach($bedroom as $k => $v){
									$selected = '';
									if(isset($get['bedroom_id']) && $get['bedroom_id'] != ""){
										if($k == $get['bedroom_id']){
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
				<div class="col-md-1">
					<p class="fs12 ffa tcgrey"><b>Year Built</b></p>
				</div>

					<div class="col-md-3">
						<div class="col-sm-12">
							<div id="slider-range1"></div>
						</div>
						<div class="col-sm-12 ">
							<div class="row slider-labels">
								<div class="col-sm-4 col-xs-4">
									<strong></strong> <span id="slider-range-value11"></span>
									<input type="hidden" name="minRangeYearBuilt" id="minRangeYearBuilt">
								</div>
								<div class="col-sm-4 col-xs-4 text-center">
									To
								</div>
								<div class="col-sm-4 col-xs-4 text-right">
									<strong class="text-right"></strong> <span id="slider-range-value22"></span>
									<input type="hidden" name="maxRangeYearBuilt" id="maxRangeYearBuilt">
								</div>
							</div>
						</div>
					</div>
				
				<div class="col-md-1" style="padding-right:0px;">
					<a href="javascript:void(0);" class="showFilter btn btn-primary btn-xs"  style="margin-top: -20px; margin-left: 21px"onClick="showFilter()">More <i class="fa fa-arrow-down"></i></a>
					<?php if(isset($_GET['owner_name'])){ ?>

						<a href="<?php echo $searchRul; ?>" class="btn btn-primary btn-xs d-none d-xl-block" style="width: 54.14px; margin-left: 21px;">Clear <i class="fa fa-close"></i></a>
					<?php } ?>
				</div>
			</div>
		
			<div class="row">
				<div class="col-md-1"></div>
				<div class="col-md-2">
					<div class="form-group">
						<select name="material_id" id="material_id" class="form-control">
							<option value="0" selected="selected">Material</option>
							<?php if($material){
								foreach($material as $k => $v){
									$selected = '';
									if(isset($get['material_id']) && $get['material_id'] != ""){
										if($k == $get['material_id']){
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
						<select name="foundation_id" id="foundation_id" class="form-control">
							<option value="0" selected="selected">Foundation</option>
							<?php if($foundation){
								foreach($foundation as $k => $v){
									$selected = '';
									if(isset($get['foundation_id']) && $get['foundation_id'] != ""){
										if($k == $get['foundation_id']){
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
						<select name="roof_id" id="roof_id" class="form-control">
							<option value="0" selected="selected">Roof Type</option>
							<?php if($roof){
								foreach($roof as $k => $v){
									$selected = '';
									if(isset($get['roof_id']) && $get['roof_id'] != ""){
										if($k == $get['roof_id']){
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
				<div class="col-md-1">
					<!--- Square Feet---->
					<p class="fs12 ffa tcgrey"><b>Sq Ft</b></p>
</div>
					<div class="col-md-3">
						<div class="col-sm-12">
							<div id="slider-range13"></div>
						</div>
						<div class="col-sm-12">
							<div class="row slider-labels">
								<div class="col-sm-4 col-xs-4">
									<strong></strong> <span id="slider-range-value13"></span>
									<input type="hidden" name="minRangeSquareFeet" id="minRangeSquareFeet">
								</div>
								<div class="col-sm-4 col-xs-4 text-center">
									To
								</div>
								<div class="col-sm-4 col-xs-4 text-right">
									<strong class="text-right"></strong> <span id="slider-range-value23"></span>
									<input type="hidden" name="maxRangeSquareFeet" id="maxRangeSquareFeet">
								</div>
							</div>
						</div>
					</div>

				</div>
				
			<div class="row">
				<div class="col-md-1"></div>
				<div class="col-md-2">
					<div class="form-group">
						<input type="text" name="street" value="<?php echo isset($get['street'])?($get['street']):(''); ?>" id="street" placeholder="Street" class="form-control">
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<input type="text" name="city" placeholder="City" value="<?php echo isset($get['city'])?($get['city']):(''); ?>" id="city" class="form-control">
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<input type="text" name="county" placeholder="County" id="county" value="<?php echo isset($get['county'])?($get['county']):(''); ?>" class="form-control">
					</div>
				</div>
				<div class="col-md-1">
					<?php if($this->uri->segment(1) != "houseshistory"){?>
						<p class="fs12 ffa tcgrey "><b>Near Me</b></p>
							<?php } ?>
					</div>
						<div class="col-md-3">
							<?php if($this->uri->segment(1) != "houseshistory"){?>
							<div class="col-sm-12">
								<div id="slider-range"></div>
							</div>
							<div class="col-sm-12">
								<div class="row slider-labels">
									<div class="col-sm-5 col-xs-5">
										<strong>Min:</strong> <span id="slider-range-value1"></span>
										<input type="hidden" name="minRange" id="minRange">
									</div>
									<div class="col-sm-1 col-xs-2 text-center">
										To
									</div>
									<div class="col-sm-5 col-xs-5 text-right">
										<strong class="text-right">Max:</strong> <span id="slider-range-value2"></span>
										<input type="hidden" name="maxRange" id="maxRange">
									</div>
								</div>
							</div>
							<?php } ?>
						</div>
						<input type="hidden" name="lat" value="<?php echo @$get['lat']; ?>">
						<input type="hidden" name="lng" value="<?php echo @$get['lng']; ?>">
						<input type="hidden" name="type" value="<?php echo isset($get['type'])?($get['type']):(''); ?>">
						<!--- Year Built----><br>
				
				</div>
			
			<div class="row ">
				<div class="col-md-1"></div>
				<div class="col-md-2">
					<div class="form-group">
						<input type="text" placeholder="Zip Code" value="<?php echo isset($get['zip'])?($get['zip']):(''); ?>" name="zip" id="zip" class="form-control">
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<input placeholder="Original Owner Name" value="<?php echo isset($get['owner_name'])?($get['owner_name']):(''); ?>"  type="text" name="owner_name" class="form-control">
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label><input type="checkbox" class="checkboxInput" <?php echo isset($get['nrhp'])?('checked="checked"'):(''); ?> name="nrhp"> NRHP Property</label>
					</div>
					<?php

					if(isset($_GET) && !empty($_GET)){ ?>
						<a href="<?php echo $searchRul; ?>" class="showFilter btn btn-primary btn-xs">Clear <i class="fa fa-close"></i></a>
					<?php } ?>
				</div>
				<div class="col-md-4">
					<input type="submit" name="filter" value="Search" class="btn btn-primary">
				</div>
				<div class="col-md-1" style="padding-right:0px;">
					<a class="btn btn-primary btn-xs pull-right mt-1"  href="javascript:void(0);" onClick="showFilter()">Less <i class="fa fa-arrow-up"></i></a>
					<?php if(isset($_GET['owner_name'])){ ?>

						<a href="<?php echo $searchRul; ?>" class="btn btn-primary btn-xs pull-right mt-1 mr-1">Clear <i class="fa fa-close"></i></a>
					<?php } ?>
<!--					<a class="btn btn-primary btn-xs"  href="javascript:void(0);">Hide <i class="fa fa-close"></i></a>-->
				</div>
			</div>
		</div>
		</div>
	</form>
</div>
</div>

<script>
	function searchForm(){
		$('.searchForm').submit();
	}
	$(function(){
		$(".searchForm").find("select").on("change",function(){
			searchForm();
		});
		$(".searchForm").find(".checkboxInput").on("change",function(){
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
			if (searchbox == '' || searchbox.length >= 3) {
				delay(function() {
					searchForm();
				}, 2000);
			}
			return false;
		});
	});
</script>
