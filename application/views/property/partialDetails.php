<div class="col-md-4 mt20">
	<?php $url = '';
	if(is_file('./assets/uploads/brickstory_images/'.$home['home_profile_photo'])){
		$url = ASSETS.'uploads/brickstory_images/'.$home['home_profile_photo'];
	}else{
		$url = ASSETS.'uploads/brickstory_images/crop/story.jpg';
	}

	if(is_file('./assets/uploads/brickstory_images/crop/'.$home['home_profile_photo'])){

		$largeUrl = ASSETS.'uploads/brickstory_images/'.$home['home_profile_photo'];
	}else{
		$largeUrl = ASSETS.'uploads/brickstory_images/crop/story.jpg';
	}

	?>
	<a data-fancybox="gallery" href="<?php echo $largeUrl; ?>">
		<img src="<?php echo $url; ?>" class="img-fluid">
	</a>
	<div class="row mt30">
		<div class="col-md-3">
			<p class="fs15"><b>Address:</b></p>
		</div>
		<div class="col-md-9">
			<p class="fs16 m0"><?php echo $home['address1']; ?> <?php echo ($home['address2'] != "")?(", ".$home['address2']):(''); ?></p>
			<p class="m0 fs16"><?php echo $home['city']; ?>, <?php echo $home['state']; ?> <?php echo $home['zip']; ?></p>
		</div>
	</div>
</div>
<div class="col-md-8 mt20">
	<div class="row tcgrey " >
		<div class="col-5 offset-md-1"><b>Year Bulit:</b></div>
		<div class="col-6"><p class="fs16"><?php echo $home['year_built']; ?> </p>
		</div>
		<div class="col-5 offset-md-1"><b>House Style:</b></div>
		<div class="col-6"><p class="fs16"><?php echo ($home['house_style_value'] != "")?($home['house_style_value']):('Not Available'); ?> </p></div>

		<div class="col-5 offset-md-1"><b>Orginal Owner:</b></div>
		<div class="col-6"><p class="fs16"><?php echo ($home['owner_name'] != "")?($home['owner_name']):('Not Available'); ?> </p></div>

		<div class="col-5 offset-md-1" style="height: 28px;"><b>Architect:</b></div>
		<div class="col-6"><p class="fs16"><?php echo ($home['architech'] != "")?($home['architech']):('-'); ?> </p></div>

		<div class="col-5 offset-md-1"><b>Square Feet:</b></div>
		<div class="col-6"><p class="fs16"><?php echo ($home['square_feet'] != "")?($home['square_feet']):('Not Available'); ?> </p></div>

		<div class="col-5 offset-md-1"><b>Bedrooms:</b></div>
		<div class="col-6"><p class="fs16"><?php echo $home['bedroom_id']; ?> </p></div>

		<div class="col-5 offset-md-1"><b>Building Material:</b></div>
		<div class="col-6"><p class="fs16"><?php echo ($home['material_value'] != "")?($home['material_value']):('Not Available'); ?> </p></div>

		<div class="col-5 offset-md-1"><b>Foundation Type:</b></div>
		<div class="col-6"><p class="fs16"><?php echo ($home['foundation_value'] != "")?($home['foundation_value']):('Not Available'); ?> </p></div>

		<div class="col-5 offset-md-1"><b>Roof Type:</b></div>
		<div class="col-6"><p class="fs16"><?php echo ($home['roof_value'] != "")?($home['roof_value']):('Not Available'); ?> </p></div>

		<div class="col-5 offset-md-1"><b>Acres:</b></div>
		<div class="col-6"><p class="fs16"><?php echo ($home['Acres'] != "")?($home['Acres']):('Not Available'); ?> </p></div>
		<?php

		$address1 = '';
//		if(strlen(trim($home['zip'])) <= 5){ $pp_zip = '0'.$home['zip']; }else { $pp_zip = $home['zip']; }
		$pp_zip = $home['zip'];
		$address1 .= (isset($home['address1']) && !empty($home['address1'])) ? $home['address1'] : '';
		$address1 .= (isset($home['address2']) && !empty($home['address2'])) ? ',' . $home['address2'] : '';
		$address1 .= (isset($home['city']) && !empty($home['city'])) ? ', ' . $home['city'] : '';
		$address1 .= (isset($home['state']) && !empty($home['state'])) ? ', ' . $home['state'] : '';
		$address1 .= ($home['zip'] != 0) ? ' ' . $pp_zip : '';
		?>
		<div class="col-md-8 offset-md-1">
			<a href="javascript:void(0);" class="btn btn-primary iLivedHere">I Lived Here</a>
			<a href="javascript:void();" class="btn btn-primary facebook-share"
			   url="<?php echo base_url() . '/details/view/'.$home['id'] ?>"
			   title="Share on Facebook"
			   title1="<?php echo $home['address1'], $home['address2'] ?>"
			   picture="<?php echo base_url() . 'assets/uploads/brickstory_images/crop/' . (isset($home['home_profile_photo']) && !empty($home['home_profile_photo'])?$home['home_profile_photo']:'story.jpg'); ?>"
			   caption="<?php echo $address1; ?>"
			   desc="<?php echo 'Rooms: ' . ($home['bedroom_id'] == 0 ? "Not Available" : $home['bedroom_id']) ?>"
			   msg="message1"
			   style="
    background-color: #516466;
">
				<i class="fa fa-facebook"></i>
			</a>
			<a href="javascript:void();" data-url="<?php echo base_url() . '/details/view/'.$home['id'] ?>" class="btn btn-primary twitter-share"style="
    background-color: #516466;
" title="Share on Twitter">
				<i class="fa fa-twitter"></i>
			</a>
			<?php if($home['year_built'] <= 1940){ ?>
				<a href="javascript:void(0);" class="btn btn-primary">Research</a>
			<?php } ?>
		</div>
	</div>

</div>
<script>
	$(".iLivedHere").on("click",function(){
		<?php if($this->session->userdata('user_id')){?>
			$("#iLivedHere").modal();
		<?php }else{?>
			location.href = '<?php echo base_url('/account/login?returnUrl='.base_url($this->uri->uri_string)); ?>';
		<?php } ?>
	});
</script>

<!-- I Lived Here Modal -->
<div class="modal" id="iLivedHere">
	<div class="modal-dialog modal-lg" style="left:0%;">
		<div class="modal-content" style="background:#f7f0d6;border:solid 2px #000;">

			<!-- Modal body -->
			<div class="modal-body">
				<div class="col-md-12 text-center">
					<h3>I Lived Here</h3>
					<img src="<?php echo ASSETS; ?>images/arrow-title-1.png" class="mauto">
				</div>
				<?php echo form_open('',array("id" => "myform")); ?>

					<div class="row">
						<div class="col-md-6 mt20 form-group mb0">
							<label class="tcgrey">From Date</label>
							<input type="text" value="<?php echo isset($livedhere['from_date'])?($livedhere['from_date']):(''); ?>" name="from_date" autocomplete="off" class="form-control fs12" id="from_Date" required="required">
						</div>
						<div class="col-md-6  mt20 form-group mb0">
							<label class="tcgrey">To Date</label>
							<input type="text" value="<?php echo isset($livedhere['to_date'])?($livedhere['to_date']):(''); ?>" name="to_date" autocomplete="off" class="form-control fs12" id="to_Date">
						</div>
						<div class="col-md-6 form-group mb0 text-center">
							<button type="submit" class="btn registerbtn">Save</button>
						</div>
						<?php if(isset($livedhere['id'])){ ?>
							<input type="hidden" name="id" value="<?php echo $livedhere['id']; ?>">
						<?php } ?>
						<div class="col-md-6  mt20 form-group mb0">
							<label>I Still Live here <input type="checkbox" <?php echo (isset($livedhere['lived_here']) && $livedhere['lived_here'] == 1)?(' checked="checked"'):(''); ?> name="user_lived_here" value="1"> </label>
						</div>
					</div>
				<?php echo form_close(); ?>

			</div>

			<!-- Modal footer -->


		</div>
	</div>
</div>
<script>

	$("#datepicker2").on("blur",function(){
		$("input[name='user_lived_here']").prop("checked",false);
	});
</script>
