<div class="nearmehero container-fluid pt30 pb-3">
	<div class="container text-center">
<!--		<h3 class="colorfff">-->
<!--			Search Result Map View-->
<!--		</h3>-->
	</div>
</div>

<div class="llsection container-fluid pt10 pb50">
	<div class="container">

		<div class="row">
			<?php $this->load->view('nearmeleft'); ?>
			<div class="col-md-12 col-lg-12">

				<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<!--				<script src="https://unpkg.com/@google/markerclustererplus@4.0.1/dist/markerclustererplus.min.js"></script>-->
				<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo urlencode(get_settings('MAPS_FRONTEND_KEY', '')); ?>&callback=initMap&libraries=&v=weekly"  defer></script>
				<script>

					var map;
					function initMap() {
						const map = new google.maps.Map(document.getElementById("map"), {
							zoom: 5,
						<?php if($properties){?><?php $counter = 1; foreach($properties as $k => $v){
						if($v['lat'] != "" && $v['lng'] != ""){
							if($counter == 1){
							?>
							center: { lat:<?php echo $v['lat'] ?>,lng:<?php echo $v['lng'] ?> },
						<?php $counter++; } } } }else{ ?>
							center: { lat: 38.9072, lng: 77.0369 },
						<?php }?>
							mapId:'2e141781fd30cba7'
						});
						// Create an array of alphabetical characters used to label the markers.
						const labels = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
						// Add some markers to the map.
						// Note: The code uses the JavaScript Array.prototype.map() method to
						// create an array of markers based on a given "locations" array.
						// The map() method here has nothing to do with the Google Maps API.
						const markers = locations.map((location, i) => {

							const marker = new google.maps.Marker({
								position: location,
								map: map,
							});
							attachSecretMessage(marker, secretMessages[i]);

						});
						// Add a marker clusterer to manage the markers.
						// new MarkerClusterer(map, markers, {
						// 	imagePath:
						// 			"https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m",
						// });


						//--------------------

						// Attaches an info window to a marker with the provided message. When the
// marker is clicked, the info window will open with the secret message.
						function attachSecretMessage(marker, secretMessage) {
							const infowindow = new google.maps.InfoWindow({
								content: secretMessage,
							});
							marker.addListener("click", () => {
								infowindow.open(marker.get("map"), marker);
							});
						}


					}
					const locations = [<?php if($properties){?><?php  foreach($properties as $k => $v){
									if($v['lat'] != "" && $v['lng'] != ""){ ?>
									{ lat:<?php echo $v['lat'] ?>,lng:<?php echo $v['lng'] ?> },
								<?php } } ?><?php } ?>];
					const secretMessages = [
						<?php if($properties){?>
						<?php  foreach($properties as $k => $v){?>
							"<a href='<?php echo base_url('details/view/'.$v['id']); ?>'><?php echo $v['address1'].' '.$v['city'].', '.$v['state'] ?></a>",
						<?php } ?>
						<?php } ?>
					];
				</script>
				<style>
					#map {
						width: 100% !important;
						padding:10px;
						height: 400px !important;
					}
				</style>
				<div id="map"></div>
			</div>

		</div>

	</div>
</div>


