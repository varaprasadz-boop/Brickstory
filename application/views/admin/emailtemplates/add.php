<div class="row">
	<div class="col-sm-12">
		<div class="element-wrapper">
			<div class="element-box">
				<form id="formValidate" method="post" action="">
					<h5 class="form-header">
						Create a email template
					</h5>
					<div class="form-desc">Fill up the below form to create a new email template.</div>

					<fieldset class="form-group">
						<legend><span>Email Template Details</span></legend>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label for="template_name"> Template Name</label>
									<input autocomplete="off" id="template_name" name="template_name" value="<?php echo set_value('template_name') ?>" class="form-control" data-error="Please input template name" placeholder="Template Name" required="required" type="text">
									<div class="help-block form-text with-errors form-control-feedback"></div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label for="template_subject">Template Subject</label>
									<input autocomplete="off" id="template_subject" name="template_subject" value="<?php echo set_value('template_subject') ?>" class="form-control" data-error="Please input template subject" placeholder="Template Subject" required="required" type="text">
									<div class="help-block form-text with-errors form-control-feedback"></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="ckeditor1"> Template Body</label>
									<textarea name="template_body" id="ckeditor1"></textarea>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								</div>
							</div>
						</div>

					</fieldset>
					<fieldset class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label for="status">Status</label>
								<select id="status" class="form-control" name="status">
									<option value="1">Active</option>
									<option value="0">Inactive</option>
								</select>
							</div>
						</div>

					</fieldset>
					<div class="form-buttons-w">
						<button class="btn btn-primary" type="submit"> Submit</button>
						<a href="<?php echo ADMIN_URL.'emailtemplates'; ?>" class="btn btn-danger">Cancel</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
