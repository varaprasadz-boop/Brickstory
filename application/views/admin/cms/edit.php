<div class="row">
	<div class="col-sm-12">
		<div class="element-wrapper">
			<div class="element-box">
				<form id="formValidate" method="post" action="">
					<h5 class="form-header">
						Create a new cms
					</h5>
					<div class="form-desc">Fill up the below form to create a new cms.</div>

					<fieldset class="form-group">
						<legend><span>CMS Details</span></legend>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label for="title"> Title</label>
									<input autocomplete="off" id="title" name="title" value="<?php echo $cmsinfo['title'] ?>" class="form-control" data-error="Please input title" placeholder="Title" required="required" type="text">
									<div class="help-block form-text with-errors form-control-feedback"></div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label for="slug_url">Slug Url</label>
									<input autocomplete="off" id="slug_url" name="slug_url" value="<?php echo $cmsinfo['slug_url'] ?>" class="form-control" data-error="Please input slug url" placeholder="Slug url" required="required" type="text">
									<div class="help-block form-text with-errors form-control-feedback"></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="ckeditor1"> Description</label>
									<textarea name="description" id="ckeditor1"><?php echo $cmsinfo['description'] ?></textarea>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								</div>
							</div>
						</div>

					</fieldset>
					<fieldset class="form-group">
						<legend><span>Meta Fields</span></legend>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="meta_title">Title</label>
									<input autocomplete="off" id="meta_title" name="meta_title" value="<?php echo $cms_meta['meta_title'] ?>" class="form-control" data-error="Please input meta title" placeholder="Meta Title" required="required" type="text">
									<div class="help-block form-text with-errors form-control-feedback"></div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="meta_keywords">Meta Keywords</label>
									<input autocomplete="off" id="meta_keywords" name="meta_keywords" value="<?php echo $cms_meta['meta_keywords'] ?>" class="form-control" data-error="Please input meta keywords" placeholder="Meta Keywords" required="required" type="text">
									<div class="help-block form-text with-errors form-control-feedback"></div>
								</div>
							</div>
						</div>
						<div class="row">

							<div class="col-md-6">
								<div class="form-group">
									<label for="meta_description">Meta Description</label>
									<textarea id="meta_description" placeholder="Meta Description" name="meta_description" class="form-control meta_description"><?php echo $cms_meta['meta_description'] ?></textarea>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								</div>
							</div>
							<div class="col-md-6">
								<label for="status">Status</label>
								<select id="status" class="form-control" name="status">
									<option <?php echo ($cmsinfo['status'] == 1)?(' selected="selected"'):(''); ?> value="1">Active</option>
									<option <?php echo ($cmsinfo['status'] == 0)?(' selected="selected"'):(''); ?> value="0">Inactive</option>
								</select>
							</div>
						</div>

					</fieldset>
					<div class="form-buttons-w">
						<button class="btn btn-primary" type="submit"> Submit</button>
						<a href="<?php echo ADMIN_URL.'cms'; ?>" class="btn btn-danger">Cancel</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
