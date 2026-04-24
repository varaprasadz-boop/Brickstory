<?php //$this->load->view('partials/dashboard-top'); ?>
<div class="llsection container-fluid pt60 pb100">
   <div class="container">
      <div class="row ">
		  <?php $this->load->view('partials/dashboard-left'); ?>
		  <?php $url = '';

		  if(is_file('./assets/uploads/brickstory_images/'.$home['home_profile_photo'])){
			  $url = ASSETS.'uploads/brickstory_images/'.$home['home_profile_photo'];
		  }else{
			  $url = ASSETS.'uploads/brickstory_images/crop/story.jpg';
		  }
		  if(is_file('./assets/uploads/brickstory_images/'.$home['home_profile_photo'])){

			  $largeUrl = ASSETS.'uploads/brickstory_images/'.$home['home_profile_photo'];
		  }else{
			  $largeUrl = ASSETS.'uploads/brickstory_images/story.jpg';
		  }

		  ?>
		  <div class="col-md-12 col-lg-9">
			  <?php echo form_open('',array("id" => "myform2","enctype" => "multipart/form-data")); ?>

					<div class="row pidetails">
						<div class="col-md-12 col-sm-12">

							<div class="bcca-breadcrumb ffa">
								<div class="bcca-breadcrumb-item">Add a Photo & Story</div>
							</div>
						</div>
					   <div class="col-lg-4 imagecrop offset-md-4">
						   <a data-fancybox="gallery" href="<?php echo $largeUrl; ?>">
								<img src="<?php echo $url; ?>" alt="Snow" class="img-fluid">
						   </a>
					   </div>
					   <div class="col-md-6 mt20 ">
						  <div class="row">
							 <div class="col-md-4">
								<label for="Photo">Photo</label>
							 </div>
							 <div class="col-md-8">
								 <div class="col-md-10" style="padding-left:0px;">
									 <div class="form-group">
										 <!--                           <div class="input-group">-->
										 <div class="custom-file">
											 <input type="file" name="image"  accept="image/*"  class="custom-file-input showImage form-control" data-id="story_photo" id="customFile">
											 <label class="custom-file-label" for="customFile">Choose file</label>
											 <input type="hidden" name="story_photo" id="home_profile_photo" class="home_profile_photo">
										 </div>
										 <!--						</div>-->
									 </div>
								 </div>
								 <div class="col-md-2" style="padding: 0px;">
									 <?php
									 $url =  ASSETS."uploads/brickstory_images/story.jpg"; ?>
									 <img src="<?php echo $url; ?>" class="img-fluid profile_image_preview showImagePreview">
								 </div>

							 </div>
							 <div class="col-md-4">
								<label for="apxdt">Approximate Date</label>
							 </div>
							 <div class="col-md-8">
								<div class="form-group">
								   <input type="text" autocomplete="off" name="approximate_date" id="datepicker" class="form-control" required="required">
								</div>
							 </div>
							 <div class="col-md-4">
								<label for="Setting">Setting</label>
							 </div>
							 <div class="col-md-8">
								<div class="form-group">
								   <select class="form-control" name="setting_id" id="Setting">
									  <option class="select" value="">Please Select</option>
									   <?php if($setting){
										   foreach($setting as $k => $v){?>
											   <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
										   <?php } ?>
									   <?php } ?>
								   </select>
								</div>
							 </div>
							 <div class="col-md-4">
								<label for="Season">Season</label>
							 </div>
							 <div class="col-md-8">
								<div class="form-group">
									<select name="season_id" id="season_id" class="form-control">
										<option value="" selected="selected">Please Select</option>
										<?php if($season){
											foreach($season as $k => $v){ ?>
												<option value="<?php echo $k; ?>"><?php echo $v; ?></option>
											<?php } ?>
										<?php } ?>
									</select>
								</div>
							 </div>
							 <div class="col-md-4">
								<label for="Event">Event</label>
							 </div>
							 <div class="col-md-8">
								<div class="form-group">
									<select name="event_id" id="event_id" class="form-control">
										<option value="" selected="selected">Please Select</option>
										<?php if($events){
											foreach($events as $k => $v){?>
												<option value="<?php echo $k; ?>"><?php echo $v; ?></option>
											<?php } ?>
										<?php } ?>
									</select>
								</div>
							 </div>
							 <div class="col-md-4">
								<label for="sideofhouse" id="sideofhouseText">Side of House</label>
							 </div>
							 <div class="col-md-8">
								<div class="form-group">
								   <select class="form-control" name="side_of_house_id" id="sideofhouse">
									  <option class="select" value="0">Please Select</option>
									   <?php if($side_of_house){
										   foreach($side_of_house as $k => $v){ ?>
											   <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
										   <?php } ?>
									   <?php } ?>
								   </select>
								</div>
							 </div>
						  </div>
					   </div>
					   <div class="col-md-6 mt20">
						  <div class="row">
							 <div class="col-md-4">
								<label for="Room" id="bedroom_idText">Room</label>
							 </div>
						  <div class="col-md-8">
								   <div class="form-group">
									   <select name="room_id" id="bedroom_id" class="form-control">
										   <option value="0">Please Select</option>
										   <?php if($room){
											   foreach($room as $k => $v){?>
												   <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
											   <?php } ?>
										   <?php } ?>
									   </select>
								</div>
								</div>
								 <div class="col-md-4">
									 <label for="Story">Story</label>
							 </div>
							 <div class="col-md-8">
								<div class = "form-group">
								<textarea class="form-control" required="required" id="Story" name="brickstory_desc" rows="6"></textarea>
				 </div>
							 </div>

						  </div>

					   </div>
					   <div class="col-md-12 text-center mt20 pb50">
						  <button type="submit" class="btn sendbtn" value="createStory">Save & Continue</button>
						   <a href="<?php echo base_url('dashboard/homeDetails/'.$homeId); ?>" class="btn sendbtn">Cancel</a>
					   </div>
					</div>
			  <?php echo form_close(); ?>
         </div>
		  <?php $this->load->view('partials/dashboard-left-bottom'); ?>
      </div>
   </div>
</div>
<script>
	$(document).on("change","#Setting",function(){
		var value = $("#Setting option:selected").text();
		$("#bedroom_id").val(0).select();
		$("#sideofhouse").val(0).select();
		if(value == "Indoors"){
			$("#bedroom_id").show();
			$("#bedroom_idText").show();
			$("#sideofhouse").hide();
			$("#sideofhouseText").hide();
		}else{
			$("#bedroom_id").hide();
			$("#bedroom_idText").hide();
			$("#sideofhouse").show();
			$("#sideofhouseText").show();
		}
	})
</script>
