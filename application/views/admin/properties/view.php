<div class="element-wrapper">
	<?php
	$propertyPhoto = ASSETS . 'uploads/brickstory_images/crop/story.jpg';
	if (!empty($property['home_profile_photo']) && is_file('./assets/uploads/brickstory_images/' . $property['home_profile_photo'])) {
		$propertyPhoto = ASSETS . 'uploads/brickstory_images/' . $property['home_profile_photo'];
	} elseif (!empty($property['home_profile_photo']) && is_file('./assets/uploads/brickstory_images/crop/' . $property['home_profile_photo'])) {
		$propertyPhoto = ASSETS . 'uploads/brickstory_images/crop/' . $property['home_profile_photo'];
	}
	?>
	<h6 class="element-header">
		Property Details #<?php echo (int) $property['id']; ?>
		<a href="<?php echo admin_url('properties'); ?>" style="float: right" class="btn btn-secondary btn-sm">Back to Listing</a>
	</h6>
	<div class="element-box">
		<div class="row">
			<div class="col-md-6">
				<table class="table table-lightborder">
					<tbody>
					<tr><th>Address</th><td><?php echo htmlspecialchars($property['address1']); ?></td></tr>
					<tr><th>Address 2</th><td><?php echo htmlspecialchars($property['address2']); ?></td></tr>
					<tr><th>City</th><td><?php echo htmlspecialchars($property['city']); ?></td></tr>
					<tr><th>State</th><td><?php echo htmlspecialchars($property['state']); ?></td></tr>
					<tr><th>ZIP</th><td><?php echo htmlspecialchars($property['zip']); ?></td></tr>
					<tr><th>Year Built</th><td><?php echo htmlspecialchars($property['year_built']); ?></td></tr>
					<tr><th>Square Feet</th><td><?php echo htmlspecialchars($property['square_feet']); ?></td></tr>
					<tr><th>Owner Name</th><td><?php echo htmlspecialchars($property['owner_name']); ?></td></tr>
					</tbody>
				</table>
			</div>
			<div class="col-md-6">
				<table class="table table-lightborder">
					<tbody>
					<tr><th>Submitted By</th><td><?php echo htmlspecialchars(trim($property['user_name'])); ?></td></tr>
					<tr><th>User Email</th><td><?php echo htmlspecialchars($property['user_email']); ?></td></tr>
					<tr><th>Status</th><td><?php echo ((int) $property['status'] === 1) ? 'Approved' : 'Pending'; ?></td></tr>
					<tr><th>Monitor Home</th><td><?php echo ((int) $property['monitor_home'] === 1) ? 'On' : 'Off'; ?></td></tr>
					<tr><th>Monitor Phone</th><td><?php echo htmlspecialchars((string) $property['monitor_phone']); ?></td></tr>
					<tr><th>Latitude</th><td><?php echo htmlspecialchars((string) $property['lat']); ?></td></tr>
					<tr><th>Longitude</th><td><?php echo htmlspecialchars((string) $property['lng']); ?></td></tr>
					<tr>
						<th>Profile Photo</th>
						<td>
							<img src="<?php echo $propertyPhoto; ?>" alt="Property Photo" style="width:120px;height:90px;object-fit:cover;border-radius:4px;">
						</td>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-6">
		<div class="element-wrapper">
			<h6 class="element-header">Recent Stories</h6>
			<div class="element-box">
				<div class="table-responsive">
					<table class="table table-lightborder">
						<thead>
						<tr>
							<th>ID</th>
							<th>Photo</th>
							<th>Description</th>
							<th>Approx Date</th>
						</tr>
						</thead>
						<tbody>
						<?php if (!empty($stories)) { foreach ($stories as $story) { ?>
							<?php
							$storyPhoto = ASSETS . 'uploads/brickstory_images/crop/story.jpg';
							if (!empty($story['story_photo']) && is_file('./assets/uploads/sub_brickstory_images/' . $story['story_photo'])) {
								$storyPhoto = ASSETS . 'uploads/sub_brickstory_images/' . $story['story_photo'];
							} elseif (!empty($story['story_photo']) && is_file('./assets/uploads/sub_brickstory_images/crop/' . $story['story_photo'])) {
								$storyPhoto = ASSETS . 'uploads/sub_brickstory_images/crop/' . $story['story_photo'];
							}
							?>
							<tr>
								<td><?php echo (int) $story['id']; ?></td>
								<td><img src="<?php echo $storyPhoto; ?>" alt="Story Photo" style="width:64px;height:48px;object-fit:cover;border-radius:4px;"></td>
								<td><?php echo htmlspecialchars(substr((string) $story['story_description'], 0, 120)); ?></td>
								<td><?php echo htmlspecialchars((string) $story['approximate_date']); ?></td>
							</tr>
						<?php } } else { ?>
							<tr><td colspan="4" class="text-center">No stories found.</td></tr>
						<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<div class="col-sm-6">
		<div class="element-wrapper">
			<h6 class="element-header">Recent People</h6>
			<div class="element-box">
				<div class="table-responsive">
					<table class="table table-lightborder">
						<thead>
						<tr>
							<th>ID</th>
							<th>Photo</th>
							<th>Name</th>
							<th>Relation ID</th>
						</tr>
						</thead>
						<tbody>
						<?php if (!empty($people)) { foreach ($people as $person) { ?>
							<?php
							$personPhoto = ASSETS . 'uploads/brickstory_images/crop/story.jpg';
							if (!empty($person['person_photo']) && is_file('./assets/uploads/peoples/' . $person['person_photo'])) {
								$personPhoto = ASSETS . 'uploads/peoples/' . $person['person_photo'];
							}
							?>
							<tr>
								<td><?php echo (int) $person['id']; ?></td>
								<td><img src="<?php echo $personPhoto; ?>" alt="Person Photo" style="width:48px;height:48px;object-fit:cover;border-radius:50%;"></td>
								<td><?php echo htmlspecialchars(trim(($person['frist_name'] ?? '') . ' ' . ($person['last_name'] ?? ''))); ?></td>
								<td><?php echo htmlspecialchars((string) $person['relation_id']); ?></td>
							</tr>
						<?php } } else { ?>
							<tr><td colspan="4" class="text-center">No people found.</td></tr>
						<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
