<?php $checked = ((string) $row['setting_value'] === '1') ? 'checked' : ''; ?>
<div class="form-check">
	<input type="hidden" name="<?php echo $row['setting_label']; ?>" value="0">
	<input class="form-check-input" type="checkbox" id="<?php echo $row['setting_label']; ?>" name="<?php echo $row['setting_label']; ?>" value="1" <?php echo $checked; ?>>
	<label class="form-check-label" for="<?php echo $row['setting_label']; ?>">Enabled</label>
</div>
