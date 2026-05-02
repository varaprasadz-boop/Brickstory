<div class="row pt-4">
	<div class="col-sm-12">
		<div class="element-wrapper">
			<h6 class="element-header">Platform Dashboard</h6>
			<div class="element-content">
				<div class="tablo-with-chart">
					<div class="row">
						<div class="col-sm-12 col-xxl-12">
							<div class="tablos">
								<div class="row">
									<div class="col-sm-3">
										<div class="element-box el-tablo centered padded bold-label">
											<div class="value"><?php echo (int) ($summary['total_users'] ?? 0); ?></div>
											<div class="label">Total Users</div>
											<div class="trending trending-up-basic"><span><?php echo (int) ($summary['active_users'] ?? 0); ?> active</span></div>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="element-box el-tablo centered padded bold-label">
											<div class="value"><?php echo (int) ($summary['total_homes'] ?? 0); ?></div>
											<div class="label">Total Homes</div>
											<div class="trending trending-up-basic"><span><?php echo (int) ($summary['approved_homes'] ?? 0); ?> approved</span></div>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="element-box el-tablo centered padded bold-label">
											<div class="value"><?php echo (int) ($summary['total_stories'] ?? 0); ?></div>
											<div class="label">Total Stories</div>
											<div class="trending trending-up-basic"><span><?php echo (int) ($summary['stories_today'] ?? 0); ?> today</span></div>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="element-box el-tablo centered padded bold-label">
											<div class="value"><?php echo (int) ($summary['total_products'] ?? 0); ?></div>
											<div class="label">Products</div>
											<div class="trending trending-up-basic"><span><?php echo (int) ($summary['active_products'] ?? 0); ?> active</span></div>
										</div>
									</div>
								</div>
								<div class="row mt-3">
									<div class="col-sm-4">
										<div class="element-box el-tablo centered padded bold-label">
											<div class="value"><?php echo (int) ($summary['monitored_homes'] ?? 0); ?></div>
											<div class="label">Monitored Homes</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="element-box el-tablo centered padded bold-label">
											<div class="value"><?php echo (int) ($summary['total_people'] ?? 0); ?></div>
											<div class="label">People Profiles</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="element-box el-tablo centered padded bold-label">
											<div class="value"><?php echo number_format((float) (($summary['active_products'] ?? 0) > 0 ? (($summary['total_users'] ?? 0) / max(1, ($summary['active_products'] ?? 0))) : 0), 1); ?></div>
											<div class="label">Users / Active Product</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-12 col-xxl-12">
		<div class="element-wrapper">
			<h6 class="element-header">Monthly Users vs Stories</h6>
			<div class="element-box">
				<canvas id="monthlyDashboardChart" height="90"></canvas>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-6 col-xxl-6">
		<div class="element-wrapper">
			<h6 class="element-header">Recent Users</h6>
			<div class="element-box">
				<div class="table-responsive">
					<table class="table table-lightborder">
						<thead>
						<tr>
							<th>Name</th>
							<th>Email</th>
							<th>Status</th>
							<th class="text-right">Created</th>
						</tr>
						</thead>
						<tbody>
						<?php if (!empty($recent_users)) { foreach ($recent_users as $user) { ?>
							<tr>
								<td><?php echo htmlspecialchars(trim($user['firstname'].' '.$user['lastname'])); ?></td>
								<td><?php echo htmlspecialchars($user['email']); ?></td>
								<td class="text-center">
									<div class="status-pill <?php echo ((int) $user['status'] === 1) ? 'green' : 'red'; ?>" data-toggle="tooltip"></div>
								</td>
								<td class="text-right"><?php echo !empty($user['created']) ? date('M d, Y h:i A', strtotime($user['created'])) : '-'; ?></td>
							</tr>
						<?php } } else { ?>
							<tr><td colspan="4" class="text-center">No users found.</td></tr>
						<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<div class="col-sm-6 col-xxl-6">
		<div class="element-wrapper">
			<h6 class="element-header">Recent Homes</h6>
			<div class="element-box">
				<div class="table-responsive">
					<table class="table table-lightborder">
						<thead>
						<tr>
							<th>Address</th>
							<th>City/State</th>
							<th>Status</th>
							<th class="text-right">Monitor</th>
						</tr>
						</thead>
						<tbody>
						<?php if (!empty($recent_homes)) { foreach ($recent_homes as $home) { ?>
							<tr>
								<td><?php echo htmlspecialchars($home['address1']); ?></td>
								<td><?php echo htmlspecialchars($home['city'].', '.$home['state']); ?></td>
								<td class="text-center">
									<div class="status-pill <?php echo ((int) $home['status'] === 1) ? 'green' : 'red'; ?>" data-toggle="tooltip"></div>
								</td>
								<td class="text-right"><?php echo ((int) $home['monitor_home'] === 1) ? 'On' : 'Off'; ?></td>
							</tr>
						<?php } } else { ?>
							<tr><td colspan="4" class="text-center">No homes found.</td></tr>
						<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-6 col-xxl-6">
		<div class="element-wrapper">
			<h6 class="element-header">Top Products</h6>
			<div class="element-box">
				<div class="table-responsive">
					<table class="table table-lightborder">
						<thead>
						<tr>
							<th>Product</th>
							<th>Price</th>
							<th>Assets</th>
							<th class="text-right">Status</th>
						</tr>
						</thead>
						<tbody>
						<?php if (!empty($top_products)) { foreach ($top_products as $product) { ?>
							<tr>
								<td><?php echo htmlspecialchars($product['name']); ?></td>
								<td><?php echo number_format((float) $product['price'], 2); ?></td>
								<td class="text-center"><?php echo (int) $product['image_count']; ?></td>
								<td class="text-right"><?php echo ((int) $product['status'] === 1) ? 'Active' : 'Inactive'; ?></td>
							</tr>
						<?php } } else { ?>
							<tr><td colspan="4" class="text-center">No products found.</td></tr>
						<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<div class="col-sm-6 col-xxl-6">
		<div class="element-wrapper">
			<h6 class="element-header">Recent Activity Log</h6>
			<div class="element-box">
				<div class="table-responsive">
					<table class="table table-lightborder">
						<thead>
						<tr>
							<th>User</th>
							<th>URL</th>
							<th>IP</th>
							<th class="text-right">Time</th>
						</tr>
						</thead>
						<tbody>
						<?php if (!empty($recent_activity)) { foreach ($recent_activity as $activity) { ?>
							<tr>
								<td><?php echo htmlspecialchars(trim(($activity['firstname'] ?? '').' '.($activity['lastname'] ?? '')) ?: ($activity['email'] ?? 'Guest')); ?></td>
								<td style="max-width: 220px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?php echo htmlspecialchars($activity['url']); ?></td>
								<td><?php echo htmlspecialchars($activity['ip_address']); ?></td>
								<td class="text-right"><?php echo !empty($activity['created']) ? date('M d, Y h:i A', strtotime($activity['created'])) : '-'; ?></td>
							</tr>
						<?php } } else { ?>
							<tr><td colspan="4" class="text-center">No activity available.</td></tr>
						<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
(function () {
	var ctx = document.getElementById('monthlyDashboardChart');
	if (!ctx) return;
	new Chart(ctx.getContext('2d'), {
		type: 'line',
		data: {
			labels: <?php echo json_encode($chart_labels); ?>,
			datasets: [
				{
					label: 'Users',
					data: <?php echo json_encode($chart_users); ?>,
					borderColor: '#2f7ed8',
					backgroundColor: 'rgba(47,126,216,0.15)',
					fill: true,
					lineTension: 0.3
				},
				{
					label: 'Stories',
					data: <?php echo json_encode($chart_stories); ?>,
					borderColor: '#0dbb8a',
					backgroundColor: 'rgba(13,187,138,0.15)',
					fill: true,
					lineTension: 0.3
				}
			]
		},
		options: {
			responsive: true,
			maintainAspectRatio: false,
			legend: { display: true },
			scales: {
				yAxes: [{ ticks: { beginAtZero: true, precision: 0 } }]
			}
		}
	});
})();
</script>

