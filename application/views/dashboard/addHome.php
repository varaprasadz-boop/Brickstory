<?php //$this->load->view('partials/dashboard-top'); ?>

<div class="llsection container-fluid pt60 pb100">
	<div class="container">
		<div class="row ">
			<?php $this->load->view('partials/dashboard-left'); ?>
			<div class="col-md-12 col-lg-9">
				<?php echo form_open('',array("id" => "submitform","enctype" => "multipart/form-data")); ?>

					<div class="row pidetails">
						<div class="col-md-12 col-sm-12">
							<div class="bcca-breadcrumb ffa">
								<div class="bcca-breadcrumb-item">Add a Home</div>
							</div>
						</div>
						<div class="col-md-6 mt20">
							<div class="col-md-6">
								<div class="">
									<label for="address1">Address1</label>
									<div class="form-group">
										<div class="input-group">
											<input type="text" required="required" autocomplete="off" onFocus="geolocate();" name="address1" id="address1" class="form-control" placeholder="Enter A LOCATION" >
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="">

									<div class="form-group">
										<label for="address2">Address2</label>
										<input type="text" name="address2" id="address2" class="form-control" placeholder="">
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="">
									<label for="city">City</label>
									<div class="form-group">
										<input type="text" name="city" id="city" required="required" class="form-control">
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="">
									<label for="state">State</label>
									<div class="form-group">
										<select name="state" class="form-control" id="states" data-bv-field="state">
											<?php $get_states = state_array();
											 foreach($get_states as $key => $val){ ?>
												<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="">
									<label for="zip">Zip</label>
									<div class="form-group">
										<input type="text" name="zip" class="form-control" id="zip" >
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="">
									<label for="year_built">Year Built</label>
									<div class="form-group">
										<input type="number" required="required" min="1620" max="<?php echo date("Y",time()); ?>" name="year_built" id="year_built" class="form-control">
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="">
									<label for="house_style_id">House Style</label>
									<div class="form-group">
										<select name="house_style_id" id="house_style_id" class="form-control">
											<option value="0" selected="selected">Please Select</option>
											<?php if($house_style){
													foreach($house_style as $k => $v){ ?>
														<option value="<?php echo $k; ?>"><?php echo $v; ?></option>
													<?php } ?>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-6">
									<label for="Photo">Home Profile Photo</label>
									<div class="form-group">
										<div class="custom-file">
											<input type="file" name="image"  accept="image/*"  id="file" class="custom-file-input showImage form-control" data-id="addProperty">
											<label class="custom-file-label" for="customFile">Choose file</label>
										</div>
										<?php
										$url =  ASSETS."images/home-icon.png"; ?>
										<div class="row">
											<div class="col-md-6">
<!--												<input type="hidden" required="required" name="home_profile_photo" class="home_profile_photo" id="home_profile_photo">-->
												<img src="<?php echo $url; ?>" class="img-fluid profile_image_preview showImagePreview">
											</div>
											<div class="col-md-8"></div>
										</div>
									</div>
								<input type="hidden" name="lng" value="" id="lng_id" class="lng_id"/>
								<input type="hidden" name="lat" value="" id="lat_id" class="lat_id"/>
							</div>

						</div>
						<div class="col-md-6 mt20">
							<div class="col-md-6">
								<div class="">
									<label for="square_feet">  Square Feet</label>
									<div class="form-group">
										<input type="number" name="square_feet" id="square_feet" class="form-control">
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="">
									<label for="architech">Architect</label>
									<div class="form-group">
										<input type="text" name="architech" id="architech" class="form-control
								  ">
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="">
									<label for="owner_name">Original Owner</label>
									<div class="form-group">
										<input type="text" name="owner_name" id="owner_name" class="form-control">
									</div>

								</div>
							</div>
							<div class="col-md-6">
								<div class="">
									<label for="bedroom_id">  Original Bedrooms</label>
									<div class="form-group">
										<select name="bedroom_id" id="bedroom_id" class="form-control">
											<?php if($bedroom){
													foreach($bedroom as $k => $v){?>
														<option value="<?php echo $k; ?>"><?php echo $v; ?></option>
													<?php } ?>
											<?php } ?>
										</select>
									</div>

								</div>
							</div>
							<div class="col-md-6">
								<div class="">
									<label for="material_id"> Original Material</label>
									<div class="form-group">
										<select name="material_id" id="material_id" class="form-control">
											<option value="0" selected="selected">Please Select</option>
											<?php if($material){
												foreach($material as $k => $v){?>
													<option value="<?php echo $k; ?>"><?php echo $v; ?></option>
												<?php } ?>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-12">
										<label for="livestatus">Did You Live Here?</label>
										<div class="form-group">
											<div class="form-check form-check-inline">
												<label class="form-check-label" for="livestatusy">
													<input type="radio" class="form-check-input" name="lived_here" id="livestatusy" value="1">
													Yes</label>
											</div>
											<div class="form-check form-check-inline">
												<label class="form-check-label" for="livestatusn">
													<input type="radio" class="form-check-input" name="lived_here" id="livestatusn" value="0">
													No</label>
											</div>
										</div>
									</div>
								</div>
								<div class="row hide" id="showDates">
									<div class="form-group">
										<label for="livestatus">From</label>
										<input type="text" autocomplete="off" class="form-control" name="from_date" id="datepicker">
									</div>
									<div class="form-group">
										<label for="livestatus">To</label>
										<input type="text" autocomplete="off" class="form-control" name="to_date" id="datepicker2">
									</div>
								</div>
							</div>

						</div>
						<div class="col-md-12 text-center mt20 pb50">
							<button class="btn sendbtn" type="submit">Save & Continue</button>
							<a href="<?php echo base_url('dashboard'); ?>" class="btn sendbtn">Cancel</a>
						</div>
					</div>
				<?php echo form_close(); ?>
			
			
		</div>
		</div>
	</div>
</div>

<?php $this->load->view('partials/dashboard-left-bottom'); ?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCn0PNuds8JTnyrfIMcKBeskbUuWM4Z-9I&libraries=places&callback=initAutocomplete"async defer></script>
<script type="text/javascript">
	// start address code
	var placeSearch, autocomplete;
	var componentForm = {
		street_number: 'short_name',
		route: 'long_name',
		locality: 'long_name',
		administrative_area_level_1: 'short_name',
		country: 'long_name',
		postal_code: 'short_name'
	};

	function initAutocomplete() {
		// Create the autocomplete object, restricting the search to geographical
		// location types.
		autocomplete = new google.maps.places.Autocomplete(
				/** @type {!HTMLInputElement} */(document.getElementById('address1')),
				{types: ['geocode'],componentRestrictions: {country: 'us'}});

		// When the user selects an address from the dropdown, populate the address
		// fields in the form.
		autocomplete.addListener('place_changed', fillInAddress);
	}

	function fillInAddress() {
		// Get the place details from the autocomplete object.
		var place = autocomplete.getPlace();
		/*
		  for (var component in componentForm) {
			document.getElementById(component).value = '';
			document.getElementById(component).disabled = false;
		  }
		*/
		// Get each component of the address from the place details
		// and fill the corresponding field on the form.
		var lat = place.geometry.location.lat(),
				lng = place.geometry.location.lng();
		for (var i = 0; i < place.address_components.length; i++) {
			var addressType = place.address_components[i].types[0];
			if (componentForm[addressType]) {
				var val = place.address_components[i][componentForm[addressType]];
				//alert(val);
				//document.getElementById(addressType).value = val;
				//alert(addressType);
				console.log(addressType);
				if (addressType == 'locality')
				{
					document.getElementById('city').value = val;

				}
				if (addressType == 'street_number')
				{
					var a0 =  val;
					//document.getElementById('address2').value = val;
				}
				if (addressType == 'route')
				{
					var a1 = val;
					//document.getElementById('address1').value = val;
				}
				if (addressType == 'postal_code')
				{
					document.getElementById('zip').value = val;

				}
				if (addressType == 'administrative_area_level_1')
				{
					var el = document.getElementById('states');
					var selectft = $("#states");
					for(var j=0; j<el.options.length; j++) {
						var stat_val = val.trim();
						if (el.options[j].value == stat_val)
						{
							//alert(el.options[i].value);
							el.selectedIndex = j;
							$('#states option').removeAttr('selected');
							$('#states option[value="'+stat_val+'"]').attr('selected',true);
							$("#states").val(stat_val);
							$('#states option[value="'+stat_val+'"]').change();
							//$("#states").dropkick("select", stat_val);
							break;
						}
					}
				}
				document.getElementById('lng_id').value = lng;
				document.getElementById('lat_id').value = lat;
			}
		}
		document.getElementById('address1').value = '';
		//document.getElementById('address1').value = a0;
		console.log("a0: "+a0+' '+a1);
		if(a0 != undefined && a1 != undefined) {
			document.getElementById('address1').value = a0 + '  ' + a1;
		}
	}

	// Bias the autocomplete object to the user's geographical location,
	// as supplied by the browser's 'navigator.geolocation' object.
	function geolocate() {
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(function(position) {
				var geolocation = {
					lat: position.coords.latitude,
					lng: position.coords.longitude
				};
				var circle = new google.maps.Circle({
					center: geolocation,
					radius: position.coords.accuracy
				});
				autocomplete.setBounds(circle.getBounds());
			});
		}
	}
	//ends here
</script>
