<?php if ((int) $row['is_secret'] === 1) { ?>
	<input type="password" class="form-control" name="<?php echo $row['setting_label']; ?>" value="" placeholder="••••••• (leave blank to keep existing)">
<?php } else { ?>
	<input type="password" class="form-control" name="<?php echo $row['setting_label']; ?>" value="<?php echo htmlspecialchars($row['setting_value']); ?>">
<?php } ?>
