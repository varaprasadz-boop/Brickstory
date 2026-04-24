<div class="row">
	<div class="col-sm-12">
		<div class="element-wrapper">
			<div class="element-box">
				<form id="formValidate" method="post" action="">
					<h5 class="form-header">
						Update setting
					</h5>
					<div class="form-desc">Modify the below form to update setting variable.</div>

					<fieldset class="form-group">
						<legend><span>Personal Details</span></legend>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label for="setting_title">Settings Title</label>
									<input autocomplete="off" name="setting_title" value="<?php echo $setting['setting_title']; ?>" class="form-control" data-error="Please input setting title" placeholder="Setting Title" required="required" type="text">
									<div class="help-block form-text with-errors form-control-feedback"></div>
								</div>
							</div>

						<div class="col-sm-6">
							<div class="form-group">
								<label for="setting_label"> Settings Label</label>
								<input autocomplete="off" name="setting_label" value="<?php echo $setting['setting_label']; ?>" class="form-control" data-error="Please input setting label" placeholder="Setting Label" required="required" type="text">
								<div class="help-block form-text with-errors form-control-feedback"></div>
							</div>
						</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label for="setting_value"> Settings Value</label>
									<input autocomplete="off" name="setting_value" value="<?php echo $setting['setting_value']; ?>"  class="form-control" data-error="Please input your setting value" placeholder="Setting Value" required="required" type="text">
									<div class="help-block form-text text-muted form-control-feedback"></div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label for="comment">Comments</label>
									<input autocomplete="off" name="comment" class="form-control" value="<?php echo $setting['comment']; ?>" data-match-error="Please input setting comment" placeholder="Setting comment" type="text">
									<div class="help-block form-text with-errors form-control-feedback"></div>
								</div>
							</div>
						</div>
					</fieldset>

					<div class="form-buttons-w">
						<button class="btn btn-primary" type="submit"> Submit</button>
						<a href="<?php echo ADMIN_URL.'settings'; ?>" class="btn btn-danger">Cancel</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
