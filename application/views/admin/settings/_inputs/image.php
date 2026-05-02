<?php if (!empty($row['setting_value'])) { ?>
	<div class="mb-2"><img src="<?php echo $row['setting_value']; ?>" alt="" style="max-height:80px;"></div>
<?php } ?>
<input type="file" class="form-control" name="<?php echo $row['setting_label']; ?>">
