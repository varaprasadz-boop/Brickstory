<div class="element-wrapper">
	<h6 class="element-header">Settings</h6>
	<div class="element-box">
		<ul class="nav nav-tabs">
			<?php foreach ($groups as $slug => $label) { ?>
				<li class="nav-item">
					<a class="nav-link <?php echo $current === $slug ? 'active' : ''; ?>" href="<?php echo admin_url('settings/group/'.$slug); ?>">
						<?php echo $label; ?>
					</a>
				</li>
			<?php } ?>
			<li class="nav-item">
				<a class="nav-link" href="<?php echo admin_url('settings/advanced/1'); ?>">Advanced</a>
			</li>
		</ul>

		<div class="mt-4">
			<form method="post" action="<?php echo admin_url('settings/save/'.$current); ?>" enctype="multipart/form-data">
				<?php if (!empty($rows)) { foreach ($rows as $rowObj) { $row = (array) $rowObj; ?>
					<div class="form-group">
						<label><?php echo $row['setting_title']; ?></label>
						<?php
						$inputView = 'admin/settings/_inputs/'.$row['setting_type'];
						if (!file_exists(APPPATH.'views/'.$inputView.'.php')) {
							$inputView = 'admin/settings/_inputs/text';
						}
						$this->load->view($inputView, array('row' => $row));
						?>
						<?php if (!empty($row['comment'])) { ?>
							<small class="form-text text-muted"><?php echo $row['comment']; ?></small>
						<?php } ?>
					</div>
				<?php } } else { ?>
					<p>No settings configured for this group.</p>
				<?php } ?>

				<div class="mt-3">
					<button type="submit" class="btn btn-primary">Save Settings</button>
					<?php if ($current === 'mail') { ?>
						<button type="button" class="btn btn-outline-secondary js-setting-test" data-endpoint="<?php echo admin_url('settings/test_smtp'); ?>">Test SMTP</button>
					<?php } ?>
					<?php if ($current === 'sms') { ?>
						<button type="button" class="btn btn-outline-secondary js-setting-test" data-endpoint="<?php echo admin_url('settings/test_twilio'); ?>">Test Twilio</button>
					<?php } ?>
					<?php if ($current === 'maps') { ?>
						<button type="button" class="btn btn-outline-secondary js-setting-test" data-endpoint="<?php echo admin_url('settings/test_maps'); ?>">Test Maps</button>
					<?php } ?>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
$(function () {
	$('.js-setting-test').on('click', function () {
		var endpoint = $(this).data('endpoint');
		$.post(endpoint, {}, function (res) {
			if (typeof res === 'string') {
				try { res = JSON.parse(res); } catch (e) {}
			}
			alert((res.message || 'Request complete') + (res.data && typeof res.data === 'string' ? ("\n" + res.data) : ''));
		});
	});
});
</script>
