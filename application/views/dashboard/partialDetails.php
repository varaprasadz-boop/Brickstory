<div class="col-md-4 mt20">
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
	<style>
		.file {
			visibility: hidden;
			position: absolute;
		}
		.it .btn-orange
{
  background-color: blue;
  border-color: #777!important;
  color: #777;
  text-align: left;
  width:100%;
}
.it input.form-control
{
  
  border:none;
  margin-bottom:0px;
  border-radius: 0px;
  border-bottom: 1px solid #ddd;
  box-shadow: none;
}
.it .form-control:focus
{
  border-color: #ff4d0d;
  box-shadow: none;
  outline: none;
}
.fileUpload {
    position: relative;
    overflow: hidden;
}
.fileUpload input.upload {
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    padding: 0;
    font-size: 20px;
    cursor: pointer;
    opacity: 0;
    filter: alpha(opacity=0);
}

	</style>
	<div class="col-sm-12">
		<form method="post" id="image-form" enctype="multipart/form-data" onSubmit="return false;">
			<div class="row" >
				<div class="col-sm-12" style="padding-left: 0px;">
					<div class="form-group">
						<img src="<?php echo ASSETS."images/home-icon.png"; ?>" rel="nofollow" id="preview" class="img-thumbnail">
					</div>
				</div>
				<div class="col-sm-6 col-xs-6" style="padding-left: 0px;">
					<div class="form-group">
						<div class="input-group">
							<input style="display: none;" type="text" class="form-control" readonly>
							<div class="input-group-btn">
								<span class="fileUpload btn btn-success">
									<span class="upl" id="upload">Choose File</span>
									<input type="file" name="file" class="upload up" id="up" onchange="readURL(this);" />
								</span><!-- btn-orange -->
							</div><!-- btn -->
						</div><!-- group -->
					</div><!-- form-group -->
				</div>
				<div class="col-sm-6 col-xs-6">
					<div class="form-group">
				<input type="submit" name="submit" value="Upload" class="btn btn-primary btn-block">
			</div>
				</div>

			</div>

			
		</form>
	</div>
	<a data-fancybox="gallery" href="<?php echo $largeUrl; ?>">
		<img src="<?php echo $url; ?>" class="img-fluid">
	</a>
	<div class="row mt30">
		<div class="col-md-4">
			<p class="fs15"><b>Address:</b></p>
		</div>
		<div class="col-md-7">
			<p class="m0 fs16">
				<a href="javascript:void(0);" class="editable" id="address1" data-type="textarea"data-pk="<?php echo $home['id']; ?>"  data-title="Update Street Address 1"><?php echo $home['address1']; ?></a>
<!--				<a href="javascript:void(0);" class="editable" id="address2" data-type="textarea"data-pk="--><?php //echo $home['id']; ?><!--"  data-title="Update Street Address 2">--><?php //echo $home['address2']; ?><!--</a>-->
			</p>
			<p class="m0 fs16">
				<a href="javascript:void(0);" class="editable" id="city" data-type="text"data-pk="<?php echo $home['id']; ?>"  data-title="Update City"><?php echo $home['city']; ?></a>,
				<a href="javascript:void(0);" class="editable" id="state" data-type="select" data-source="<?php echo base_url('dashboard/getStats?state=1'); ?>" data-pk="<?php echo $home['id']; ?>"  data-title="Update State" data-value="<?php echo $home['state']; ?>"><?php echo $home['state']; ?></a>
				<a href="javascript:void(0);" class="editable" id="zip" data-type="text"data-pk="<?php echo $home['id']; ?>"  data-title="Update ZipCode"><?php echo $home['zip']; ?></a>

			</p>
		</div>
	</div>
</div>
<div class="col-md-8 mt20">
	<div class="row tcgrey">
		<div class="col-4 offset-md-1"><b>Year Built:</b></div>

		<div class="col-7">
			<p class="fs16">
				<a href="javascript:void(0);" class="editable" id="year_built" data-type="text" data-pk="<?php echo $home['id']; ?>" data-title="Update Year Built"><?php echo $home['year_built']; ?></a>
			</p>
		</div>
		<div class="col-4 offset-md-1"><b>House Style:</b></div>
		<div class="col-7"><p class="fs16">
				<a href="javascript:void(0);" class="editable" id="house_style_id" data-type="select" data-source="<?php echo base_url('dashboard/getStats?house_style=1'); ?>"
				   data-pk="<?php echo $home['id']; ?>" data-value="<?php echo $home['house_style_id']; ?>" data-title="Update House Style">
					<?php echo $home['house_style_value']; ?></a>
			</p>
		</div>

		<div class="col-4 offset-md-1"><b>Orginal Owner:</b></div>
		<div class="col-7"><p class="fs16">
				<a href="javascript:void(0);" class="editable" id="owner_name" data-type="text" data-pk="<?php echo $home['id']; ?>"  data-title="Update Owner Name"><?php echo $home['owner_name']; ?></a>
			</p></div>

		<div class="col-4 offset-md-1"><b>Architect:</b></div>
		<div class="col-7"><p class="fs16">
				<a href="javascript:void(0);" class="editable" id="architech" data-type="text" data-pk="<?php echo $home['id']; ?>"  data-title="Update Architect"><?php echo $home['architech']; ?></a>
			</p></div>

		<div class="col-4 offset-md-1"><b>Square Feet:</b></div>
		<div class="col-7"><p class="fs16">
				<a href="javascript:void(0);" class="editable" id="square_feet" data-type="text" data-pk="<?php echo $home['id']; ?>"  data-title="Update Square Feet"><?php echo $home['square_feet']; ?></a>
			</p></div>

		<div class="col-4 offset-md-1"><b>Bedrooms:</b></div>
		<div class="col-7"><p class="fs16">
				<a href="javascript:void(0);" class="editable" id="bedroom_id" data-type="select" data-value="<?php echo $home['bedroom_id']; ?>" data-source="<?php echo base_url('dashboard/getStats?bedroom=1'); ?>" data-pk="<?php echo $home['id']; ?>"  data-title="Update Bedroom"><?php echo $home['bedroom_id']; ?></a>
			</p></div>

		<div class="col-4 offset-md-1"><b>Building Material:</b></div>
		<div class="col-7">
			<p class="fs16">
				<a href="javascript:void(0);" class="editable" id="material_id" data-type="select" data-source="<?php echo base_url('dashboard/getStats?material=1'); ?>" data-pk="<?php echo $home['id']; ?>" data-value="<?php echo $home['material_id']; ?>" data-title="Update Building Material"><?php echo $home['material_value']; ?></a>
			</p>
		</div>

		<div class="col-4 offset-md-1"><b>Foundation Type:</b></div>
		<div class="col-7"><p class="fs16">
				<a href="javascript:void(0);" class="editable" id="foundation_id" data-type="select" data-source="<?php echo base_url('dashboard/getStats?foundation=1'); ?>" data-pk="<?php echo $home['id']; ?>"  data-value="<?php echo $home['foundation_id']; ?>" data-title="Update Foundation Type"><?php echo $home['foundation_value']; ?></a>

			</p></div>

		<div class="col-4 offset-md-1"><b>Roof Type:</b></div>
		<div class="col-7"><p class="fs16">
				<a href="javascript:void(0);" class="editable" id="roof_id" data-type="select" data-source="<?php echo base_url('dashboard/getStats?roof=1'); ?>" data-pk="<?php echo $home['id']; ?>" data-value="<?php echo $home['roof_id']; ?>"  data-title="Update Roof Type"><?php echo $home['roof_value']; ?></a>

			</p></div>

		<div class="col-4 offset-md-1"><b>Acres:</b></div>
		<div class="col-7"><p class="fs16">
				<a href="javascript:void(0);" class="editable" id="Acres" data-type="text" data-pk="<?php echo $home['id']; ?>"  data-title="Update Acres"><?php echo $home['Acres']; ?></a>

			</p>
		</div>
		<?php

		$address1 = '';
//		if(strlen(trim($home['zip'])) < 5){
//			$pp_zip = '0'.$home['zip'];
//		}else {
//			$pp_zip = $home['zip'];
//		}
		$pp_zip = $home['zip'];

		$address1 .= (isset($home['address1']) && !empty($home['address1'])) ? $home['address1'] : '';
		$address1 .= (isset($home['address2']) && !empty($home['address2'])) ? ',' . $home['address2'] : '';
		$address1 .= (isset($home['city']) && !empty($home['city'])) ? ', ' . $home['city'] : '';
		$address1 .= (isset($home['state']) && !empty($home['state'])) ? ', ' . $home['state'] : '';
		$address1 .= ($home['zip'] != 0) ? ' ' . $pp_zip : '';
		?>
		<div class="mt-5 col-md-12 offset-md-1 mb-5">
			<?php //if(check_auth_session() == 1){ ?>
				<a href="javascript:void(0);" class="btn btn-primary iLivedHere">I Lived Here</a>
			<?php //} ?>
			<a href="javascript:void(0);" class="btn btn-primary facebook-share"
			   url="<?php echo base_url() . '/details/view/'.$home['id'] ?>"
			   title="Share on Facebook"
			   title1="<?php echo $home['address1'], $home['address2'] ?>"
			   picture="<?php echo base_url() . 'assets/uploads/brickstory_images/crop/' . (isset($home['home_profile_photo']) && !empty($home['home_profile_photo'])?$home['home_profile_photo']:'story.jpg'); ?>"
			   caption="<?php echo $address1; ?>"
			   desc="<?php echo 'Rooms: ' . ($home['bedroom_id'] == 0 ? "Not Available" : $home['bedroom_id']) ?>"
			   msg="message1"
			   style="
    background-color: #516466;
" title="Share on Facebook">
				<i class="fa fa-facebook"></i>
			</a>
			<a href="javascript:void(0);" data-url="<?php echo base_url() . '/details/view/'.$home['id'] ?>"
			   class="btn btn-primary twitter-share"style="
    background-color: #516466;
" title="Share on Twitter">
				<i class="fa fa-twitter"></i>
			</a>
			<?php if(check_auth_session() == 1){ ?>
			<?php if($home['year_built'] <= 1940){ ?>
				<a href="javascript:void(0);" class="btn btn-primary">Research</a>
			<?php } ?>
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
				<?php //echo form_open(action: '',array("id" => "myform")); ?>
				<?php echo form_open('',array("id" => "myformLIvedHEre","method" => "post")); ?>

					<div class="row">
						<div class="col-md-6 mt20 form-group mb0">
							<label class="tcgrey">From Date</label>
							<input type="text" value="<?php echo isset($livedhere['from_date'])?($livedhere['from_date']):(''); ?>" name="from_date" autocomplete="off" class="form-control fs12" id="from_Date" required="required">
						</div>
						<div class="col-md-6  mt20 form-group mb0">
							<label class="tcgrey">To Date</label>
							<input type="text" value="<?php echo (isset($livedhere['to_date']) && $livedhere['to_date'] != "101/01/1970")?($livedhere['to_date']):(''); ?>" name="to_date" autocomplete="off" class="form-control fs12" id="to_Date">
						</div>
						
						<?php if(isset($livedhere['id'])){ ?>
							<input type="hidden" name="id" value="<?php echo $livedhere['id']; ?>">
						<?php } ?>
						<div class="col-md-6  mt20 form-group mb0">
							<label>I Still Live here <input type="checkbox" <?php echo (isset($livedhere['lived_here']) && $livedhere['lived_here'] == 1)?(' checked="checked"'):(''); ?> onClick="$('#to_Date').val('');" name="user_lived_here" id="user_lived_here" value="1"> </label>
						</div>
						<div class="col-md-6 form-group mb0 text-center">
							<button type="submit" class="btn registerbtn">Save</button>
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


