<?php //$this->load->view('partials/dashboard-top'); ?>
<style>
	.imagecrop{
		margin-bottom:10px;
	}
</style>
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
							<div class="bcca-breadcrumb-item">My Homes</div>
						</div>

					</div>
				<div class="container">
					<?php //show_msg1(); ?>
					<form method="get" action="">
					<div class="row">
						<!-- <div class="row"> -->
							<div class="col-md-4">
								<div class="form-group">
									<input placeholder="Original Owner Name" value="<?php echo isset($get['owner_name'])?($get['owner_name']):(''); ?>"  type="text" name="owner_name" class="form-control">
								</div>
							</div>
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
									<input type="text" placeholder="Zip Code" value="<?php echo isset($get['zip'])?($get['zip']):(''); ?>" name="zip" id="zip" class="form-control">
								</div>
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
							
						
						</div>
					<div class="row">
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
						<div class="col-md-2">
								<input type="submit" value="Search" class="btn btn-primary">
								<?php if(isset($_GET['owner_name'])){ ?>
									<a href="<?php echo base_url('dashboard/myhomes/1'); ?>" class="btn btn-primary btn-xs pull-right mt-1 mr-1"> <i class="fa fa-close"></i></a>
								<?php } ?>
							</div>
							
					</div>
						</form>

					<!-- </div> -->
					<div class="row">
					<?php if($houses){
							foreach($houses as $house){
								$house['cls'] = 'col-lg-4 col-sm-4 col-md-4 mb-4';
								$this->load->view('partials/home-thumb.php',array('val' => $house)); 
	
					 } ?>
					</div>
				</div>
					<div class="col-md-12">
					<span class="pull-left text-secondary"><?php echo $count; ?> records found</span>

						<?php if($total_pages > 0){ ?>
							<nav aria-label="Page navigation example" style="float: right; margin-right: 10%;">
								<ul class="pagination pull-right">
									<?php $url = '#';
									$class = 'disabled';
									$queryString = '';
									if($_SERVER['QUERY_STRING']){
										$queryString = "?".$_SERVER['QUERY_STRING'];
									}
									if($real_page >= 1){
										$real_page = $real_page;
										$class = '';
										$url = base_url('dashboard/myhomes/'.$real_page.$queryString);
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
										<li class="page-item <?php echo $active; ?>"><a class="page-link" href="<?php echo base_url('dashboard/myhomes/'.$i.$queryString); ?>"><?php echo $i; ?></a></li>
									<?php }
									$url = '#';
									$class2 = '';
									if($real_page+1 == $total_pages) {
										$class2 = 'disabled';
									}
									if($real_page <= $total_pages){
										$real_page = $real_page+2;

										$url = base_url('dashboard/myhomes/'.$real_page.$queryString);

									}
									//echo $total_pages.' | '.$real_page;
									?>
									<li class="page-item <?php echo $class2; ?>"><a class="page-link" href="<?php echo $url; ?>">Next</a></li>
								</ul>
							</nav>
						<?php } ?>
					</div>
					<?php }else{ ?>
						<div class="col-md-12">
							<p class="text-center">
								You do not have any records with us yet – lets add your first home!”
							</p>
						</div>
					<?php } ?>
				</div>

				</div>
			</div>
			
	

		</div>
<?php $this->load->view('partials/dashboard-left-bottom'); ?>
	</div>
	

	

</div>

<!-- The Modal -->
<div class="modal" id="monitorMyhome" style="z-index:999999;">
	<div class="modal-dialog modal-lg" style="left:0%;">
		<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Monitor my Home</h4>

			</div>

			<!-- Modal body -->
			<div class="modal-body" style="background-color:#516466;">
				
				<p style="padding:20px;background-color:#fff;">
				Brickstory will monitor your home at the address below:<br /><br />
					<span class="monitor_address">-</span>
					<br /><br />
					By clicking the "Submit" button you agree to have text messages sent to the number you provided below whenever a new Photo or Story is added to your home on Brickstory.com.
					<p>Standard text messaging and data rates shall apply.</p>
				</p>
				<form id="phoneForm" method="post">
					<?php csrf();  ?>
					<input type="hidden" name="id" class="monitor_id">
					<input type="text" class="form-control" id="mobitorPhone" name="mobitorPhone" placeholder="(XXX) XXX-XXXX">
					<div id="errorMessage" style="color:red;"></div>
					<button type="submit" style="background-color: #dfc5a0;color:#000;" class="btn btn-secondary btn-sm mt-4">Submit</button>

				</form>

			</div>

			<!-- Modal footer -->


		</div>
	</div>
</div>


<script>
	document.getElementById('mobitorPhone').addEventListener('input', function (e) {
    let input = e.target.value.replace(/\D/g, ''); // Remove non-digit characters
    if (input.length > 10) input = input.slice(0, 10); // Limit input to 10 digits

    let formattedPhoneNumber = '';

    if (input.length > 0) formattedPhoneNumber += '(' + input.substring(0, 3);
    if (input.length >= 4) formattedPhoneNumber += ') ' + input.substring(3, 6);
    if (input.length >= 7) formattedPhoneNumber += '-' + input.substring(6, 10);

    e.target.value = formattedPhoneNumber;
});

document.getElementById('phoneForm').addEventListener('submit', function (e) {
    e.preventDefault();
    
    const phoneInput = document.getElementById('mobitorPhone').value;
    const cleanedInput = phoneInput.replace(/\D/g, ''); // Remove all non-digit characters
    
    if (cleanedInput.length !== 10) {
        document.getElementById('errorMessage').innerText = 'Phone number must be 10 digits.';
    } else {
        document.getElementById('errorMessage').innerText = '';
        alert('Phone number is valid: ' + phoneInput);
        // Here you can handle form submission
		$("#phoneForm").submit();
    }
});

</script>