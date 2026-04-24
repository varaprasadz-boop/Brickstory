<?php //$this->load->view('partials/dashboard-top'); ?>
<div class="llsection container-fluid pt60 pb100">
   <div class="container">
      <div class="row ">
         <?php $this->load->view('partials/dashboard-left'); ?>
         <div class="col-md-12 col-lg-9">
          <?php echo form_open('',array("id" => "myform2","enctype" => "multipart/form-data")); ?>

            	<div class="row pidetails">
				<div class="col-md-12 col-sm-12">
					<div class="bcca-breadcrumb ffa">
						<div class="bcca-breadcrumb-item">Add a New People</div>
					</div>
				</div>
				<?php $url = '';

				if(is_file('./assets/uploads/brickstory_images/crop/'.$home['home_profile_photo'])){
					$url = ASSETS.'uploads/brickstory_images/crop/'.$home['home_profile_photo'];
				}else{
					$url = ASSETS.'uploads/brickstory_images/crop/story.jpg';
				}
				if(is_file('./assets/uploads/brickstory_images/crop/'.$home['home_profile_photo'])){

					$largeUrl = ASSETS.'uploads/brickstory_images/'.$home['home_profile_photo'];
				}else{
					$largeUrl = ASSETS.'uploads/brickstory_images/story.jpg';
				}

				?>
               <div class="col-lg-4 imagecrop offset-md-4">
				   <a data-fancybox="gallery" href="<?php echo $largeUrl; ?>">
					   <img src="<?php echo $url; ?>" alt="Snow" class="img-fluid">
				   </a>               </div>
               <div class="col-md-6 mt20 ">
                  <div class="row">
                     <div class="col-md-4">
                        <label for="Photo">Photo</label>
                     </div>
                     <div class="col-md-8">
						 <div class="col-md-10" style="padding-left:0px;">
							 <div class="form-group">
								 <div class="custom-file">
									 <input type="file" name="image" accept="image/*"  class="custom-file-input showImage form-control" id="customFile" required="required">
									 <label class="custom-file-label" for="customFile">Choose file</label>
								 </div>
							 </div>
						 </div>
						 <div class="col-md-2" style="padding: 0px;">
							 <?php
							 $url =  ASSETS."uploads/brickstory_images/story.jpg"; ?>
							 <img src="<?php echo $url; ?>" class="img-fluid profile_image_preview showImagePreview">
						 </div>

                     </div>
                     <div class="col-md-4">
                        <label for="fsname">First Name</label>

                     </div>
                      <div class="col-md-8">
                        <div class="form-group">
                           <div class="input-group">
                              <input type="text" name="first_name" id="fsname" class="form-control" required="required" autocomplete="off">

                           </div>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <label for="lsname">Last Name</label>

                     </div>
                      <div class="col-md-8">
                        <div class="form-group">
                           <div class="input-group">
                              <input type="text" name="last_name" id="lsname" class="form-control" required="required" autocomplete="off">

                           </div>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <label for="Relationship">Relationship</label>

                     </div>
                     <div class="col-md-8">
                        <div class="form-group">
							<select id="Relationship" name="relation_id" class="form-control relation_id" required="required">
								<option value="">Please Select</option>
								<?php
								$relation = get_dropdown_value('relation');
								if($relation){
									foreach($relation as $k => $v){
										$selected = '';
										if(isset($get['relation_id']) && $get['relation_id'] != ""){
											if($k == $get['relation_id']){
												$selected = ' selected="selected"';
											}
										}
										?>
										<option value="<?php echo $k; ?>" <?php echo $selected; ?>><?php echo $v; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
							<span class="validation_error"></span>
                        </div>

                     </div>
                  </div>
               </div>
               <div class="col-md-6 mt20">
                  <div class="row">
                 <div class="col-md-4">
                        <label for="lfrom">Lived Here From</label>
                     </div>
                     <div class="col-md-8">
                        <div class="form-group">
                           <input type="text" name="from_date" id="datepicker" class="form-control" required="required" autocomplete="off">
                        </div>
                     </div><div class="col-md-4">
                        <label for="lto">Lived Here To</label>
                     </div>
                     <div class="col-md-8">
                        <div class="form-group">
                           <input type="text" name="to_date" id="datepicker2" class="form-control"  autocomplete="off">
                        </div>
                     </div><div class="col-md-4">
                        <label for="bd">Born Date</label>
                     </div>
                     <div class="col-md-8">
                        <div class="form-group">
                           <input type="text" name="born_date" id="datepicker3"class="form-control" required="required" autocomplete="off">
                        </div>
                     </div>
                     <div class="col-md-4">
                        <label for="dd">Died Date</label>
                     </div>
                     <div class="col-md-8">
                        <div class="form-group">
                           <input type="text" name="died_date" id="datepicker4" class="form-control" autocomplete="off">
                        </div>
                     </div>
                     <div class="col-md-4">
						 <label>Living</label>
                     </div>
					  <div class="col-md-8">
						 <div class="form-group">
							 <div class="radio">
								 <label for="Yes">
									 <input type="radio" name="living" id="Yes"  value="Yes">
									 Yes
								 </label><br />
								 <label for="No">
									 <input type="radio" name="living" id="No"  value="No">
									 No
								 </label>
							 </div>
						 </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-12 text-center mt20 pb50">
                  <button class="btn  sendbtn">Create Person</button>
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
	$("input[name='living']").on("click",function(){
		if($(this).val() == "Yes"){
			$("#datepicker4").val('');
		}
	});
</script>
