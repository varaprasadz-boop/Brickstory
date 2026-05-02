<div class="element-wrapper">
	<h6 class="element-header">Properties Listing</h6>
	<div class="element-box">
		<div class="controls-above-table">
			<div class="row">
				<div class="col-sm-12">
					<form class="form-inline justify-content-sm-end" method="get" action="">
						<input class="form-control form-control-sm rounded bright mr-2" name="search" value="<?php echo htmlspecialchars($filters['search']); ?>" placeholder="Search address/city/state/zip/owner" type="text">
						<input class="form-control form-control-sm rounded bright mr-2" name="state" value="<?php echo htmlspecialchars($filters['state']); ?>" placeholder="State" type="text" style="width:100px;">
						<select class="form-control form-control-sm rounded bright mr-2" name="status">
							<option value="">All Status</option>
							<option value="1" <?php echo ($filters['status'] === '1') ? 'selected' : ''; ?>>Approved</option>
							<option value="0" <?php echo ($filters['status'] === '0') ? 'selected' : ''; ?>>Pending</option>
						</select>
						<select class="form-control form-control-sm rounded bright mr-2" name="monitor_home">
							<option value="">Monitor: All</option>
							<option value="1" <?php echo ($filters['monitor_home'] === '1') ? 'selected' : ''; ?>>On</option>
							<option value="0" <?php echo ($filters['monitor_home'] === '0') ? 'selected' : ''; ?>>Off</option>
						</select>
						<select class="form-control form-control-sm rounded bright mr-2 js-submitter-select" name="user_id" style="max-width: 320px;">
							<option value="">All Submitters</option>
							<?php if (!empty($property_users)) { foreach ($property_users as $u) { ?>
								<option value="<?php echo (int) $u['id']; ?>" <?php echo ($filters['user_id'] !== '' && (int) $filters['user_id'] === (int) $u['id']) ? 'selected' : ''; ?>>
									<?php echo htmlspecialchars($u['name']); ?>
								</option>
							<?php } } ?>
						</select>
						<button class="btn btn-primary btn-sm mr-2" type="submit">Filter</button>
						<a class="btn btn-secondary btn-sm" href="<?php echo admin_url('properties'); ?>">Clear</a>
					</form>
				</div>
			</div>
		</div>

		<div class="table-responsive">
			<table class="table table-lightborder">
				<thead>
				<tr>
					<th>ID</th>
					<th>Address</th>
					<th>City/State</th>
					<th>Owner</th>
					<th class="text-center">Stories</th>
					<th class="text-center">People</th>
					<th class="text-center">Monitor</th>
					<th class="text-center">Status</th>
					<th class="text-right">Actions</th>
				</tr>
				</thead>
				<tbody>
				<?php if (!empty($properties)) { foreach ($properties as $row) { ?>
					<tr>
						<td><?php echo (int) $row->id; ?></td>
						<td><?php echo htmlspecialchars($row->address1); ?></td>
						<td><?php echo htmlspecialchars($row->city . ', ' . $row->state); ?></td>
						<td><?php echo htmlspecialchars(trim($row->user_name) ?: $row->owner_name); ?></td>
						<td class="text-center"><?php echo (int) $row->stories_count; ?></td>
						<td class="text-center"><?php echo (int) $row->people_count; ?></td>
						<td class="text-center"><?php echo ((int) $row->monitor_home === 1) ? 'On' : 'Off'; ?></td>
						<td class="text-center">
							<span class="badge badge-<?php echo ((int) $row->status === 1) ? 'success' : 'warning'; ?>">
								<?php echo ((int) $row->status === 1) ? 'Approved' : 'Pending'; ?>
							</span>
						</td>
						<td class="text-right">
							<a href="<?php echo admin_url('properties/view/' . (int) $row->id); ?>" class="btn btn-primary btn-sm">View</a>
							<a href="<?php echo base_url('details/view/' . (int) $row->id); ?>" target="_blank" class="btn btn-outline-secondary btn-sm">Public View</a>
						</td>
					</tr>
				<?php } } else { ?>
					<tr><td colspan="9" class="text-center">No properties found.</td></tr>
				<?php } ?>
				</tbody>
			</table>
		</div>

		<?php
		$query = $_GET;
		$buildUrl = function($targetPage) use ($query) {
			$qs = http_build_query($query);
			$base = admin_url('properties/index/' . (int) $targetPage);
			return $qs ? ($base . '?' . $qs) : $base;
		};
		?>
		<div class="row">
			<div class="col-md-12">
				<div class="row mtop20">
					<div class="col-md-12">
						Showing from <?php echo $page * $limit; ?> to <?php echo ($real_page != $total_pages) ? ($page * $limit + $limit) : $count; ?> of <?php echo $count; ?>
						<?php if ($total_pages > 0) { ?>
							<nav aria-label="Page navigation example" style="float: right; margin-right: 10%;">
								<ul class="pagination pull-right">
									<?php
									$prevClass = ($real_page > 1) ? '' : 'disabled';
									$prevUrl = ($real_page > 1) ? $buildUrl($real_page - 1) : '#';
									?>
									<li class="page-item <?php echo $prevClass; ?>"><a class="page-link" href="<?php echo $prevUrl; ?>">Previous</a></li>
									<?php for ($i = max(1, $page - 2); $i <= min($page + 4, $total_pages); $i++) { ?>
										<li class="page-item <?php echo ($page + 1 == $i) ? 'active' : ''; ?>"><a class="page-link" href="<?php echo $buildUrl($i); ?>"><?php echo $i; ?></a></li>
									<?php } ?>
									<?php
									$nextClass = ($real_page >= $total_pages) ? 'disabled' : '';
									$nextUrl = ($real_page < $total_pages) ? $buildUrl($real_page + 1) : '#';
									?>
									<li class="page-item <?php echo $nextClass; ?>"><a class="page-link" href="<?php echo $nextUrl; ?>">Next</a></li>
								</ul>
							</nav>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	(function initSubmitterSearchableDropdown() {
		function applySelect2() {
			if (!window.jQuery || !window.jQuery.fn || !window.jQuery.fn.select2) {
				setTimeout(applySelect2, 50);
				return;
			}
			var $el = window.jQuery('.js-submitter-select');
			if (!$el.length) {
				return;
			}
			if ($el.hasClass('select2-hidden-accessible')) {
				$el.select2('destroy');
			}
			$el.select2({
				placeholder: 'All Submitters',
				allowClear: true,
				width: '320px',
				minimumResultsForSearch: 0
			});
		}
		window.addEventListener('load', applySelect2);
	})();
</script>
