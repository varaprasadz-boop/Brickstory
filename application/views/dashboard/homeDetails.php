<?php //$this->load->view('partials/dashboard-top'); ?>
<div class="vwstryhero container-fluid pb100">
	<div class="container">
	</div>
</div>
<div class="llsection container-fluid pb50">

	<div class="container">
		<div id="msg"></div>

		<div class="row ">
			<?php $this->load->view('partials/dashboard-left'); ?>

			<div class="col-md-12 col-lg-9">
				<div class="row pidetails">
					<div class="col-md-12 col-sm-12">
						<div class="bcca-breadcrumb ffa">
							<div class="bcca-breadcrumb-item">
								<a href="<?php echo base_url('dashboard/viewTimeLine/'.$homeId) ?>" class="colorfff">Timeline</a>
							</div>
							<div class="bcca-breadcrumb-item">
								<a href="<?php echo base_url('dashboard/viewPeople/'.$homeId) ?>" class="colorfff">People</a></div>
<!--							<div class="bcca-breadcrumb-item">-->
<!--								<a href="--><?php //echo base_url('dashboard/viewStory/'.$homeId) ?><!--" class="colorfff">Photo and Story</a></div>-->
							<div class="bcca-breadcrumb-item bcca-breadcrumb-item-active">
								<a href="<?php echo base_url('dashboard/homeDetails/'.$homeId) ?>" class="colorfff">Photos and Stories</a> </div>
						</div>
					</div>
					
				<div class="col-md-12 ">
					<h4 class="tcgrey">HOME VIEW</h4>

				</div>
					<?php $this->load->view("dashboard/partialDetails"); ?>
					<div class="col-md-12 ">
						<?php  if($sub_stories){ ?>
								<h4 class="tcgrey">PHOTOS AND STORIES</h4>
						<?php } ?>
				</div>
					<style>
			
					</style>
					<?php  if($sub_stories){
						foreach($sub_stories as $key => $val){
							$data = $val; ?>
							<div class="col-lg-4 imageh">
								<a href="<?php echo base_url('dashboard/viewTimeLine/'.$homeId.'#timeline'.$data['id']); ?>">
									<div class="grid-block slide">
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
													if (isset($data['season_id']))
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
													if (isset($data['event_id']))
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
														echo 'Not Available';
													}
													?>
												</td>
											</tr>
											<tr>
												<td class="right">Room:</td>
												<td class="left">
													<?php
													if (isset($data['room_id']) && $data['room_id'] != 0)
													{
														print $data['room_value'];
													}else{
														echo "Not Available";
													}
													?>
												</td>
											</tr>
										</table>
									</div>
									<?php
									if(is_file('./assets/uploads/sub_brickstory_images/crop/'.$val['story_photo'])){
										$url = "uploads/sub_brickstory_images/crop/".$val['story_photo'];
									}else if(is_file('./assets/uploads/sub_brickstory_images/'.$val['story_photo'])){
										$url = "uploads/sub_brickstory_images/".$val['story_photo'];
									}else{
										$url = "uploads/brickstory_images/crop/story.jpg";
									}
									?>
									<img src="<?php echo ASSETS.$url; ?>" alt="Snow" class="img-fluid">
								</div>
								</a>
							</div>
						<?php } ?>
					<?php } ?>
					<div class="col-md-12 text-center mt-3">
						<a href="<?php echo base_url("dashboard/addPhotoStory/".$home['id']); ?>" class="btn btn-primary" style="background-color: #516466;">Add a Photo and Story</a>
						<a href="<?php echo base_url("dashboard/addPeople/".$home['id']); ?>" class="btn btn-primary" style="background-color: #516466;">Add a Person</a>
					</div>
				</div>

			</div>
			
		</div>

	</div>
</div>
<?php $this->load->view('partials/dashboard-left-bottom'); ?>

<script>
	$(document).on("click", ".browse", function() {
		var file = $(this)
				.parent()
				.parent()
				.parent()
				.find(".file");
		file.trigger("click");
	});
	$('input[type="file"]').change(function(e) {
		var fileName = e.target.files[0].name;
		$("#file").val(fileName);

		var reader = new FileReader();
		reader.onload = function(e) {
			// get loaded data and render thumbnail.
			document.getElementById("preview").src = e.target.result;
		};
		// read the image file as a data URL.
		reader.readAsDataURL(this.files[0]);
	});

	$(document).ready(function(e) {
		$("#image-form").on("submit", function() {
			$("#msg").html('<div class="alert alert-info"><i class="fa fa-spin fa-spinner"></i> Please wait...!</div>');
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('dashboard/uploadPropertyImage/'.$homeId); ?>",
				data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
				contentType: false, // The content type used when sending data to the server.
				cache: false, // To unable request pages to be cached
				processData: false, // To send DOMDocument or non processed data file it is set to false
				success: function(data) {
					if (data == 1 || parseInt(data) == 1) {
						$("#msg").html(
								'<div class="alert alert-success"><i class="fa fa-thumbs-up"></i> Data updated successfully.</div>'
						);
						location.reload();
					} else {
						$("#msg").html(
								'<div class="alert alert-info"><i class="fa fa-exclamation-triangle"></i> Extension not good only try with <strong>GIF, JPG, PNG, JPEG</strong>.</div>'
						);
					}
				},
				error: function(data) {
					$("#msg").html(
							'<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> There is some thing wrong.</div>'
					);
				}
			});
		});
	});
</script>
