<div class="row">
	<div class="col-sm-12">
		<div class="element-wrapper">
			<div class="element-box">
				<form id="formValidate" method="post" action="" enctype="multipart/form-data">
					<h5 class="form-header">
						Edit Banner
					</h5>
					<div class="form-desc">Change/Modify the below form to update banner.</div>

					<fieldset class="form-group">
						<legend><span>Banner Details</span></legend>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label for="section_id">Section</label>
									<select class="form-control" name="section_id" id="section_id">
										<option value="1" <?php echo ($banner['section_id'] == 1)?(' selected="selected"'):(''); ?>>Home Banner</option>
										<option value="4" <?php echo ($banner['section_id'] == 4)?(' selected="selected"'):(''); ?>>Home Video</option>
										<option value="3" <?php echo ($banner['section_id'] == 3)?(' selected="selected"'):(''); ?>>Login Banner</option>
									</select>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								</div>
							</div>

						<div class="col-sm-6">
							<div class="form-group">
								<label for="title"> Title</label>
								<input autocomplete="off" name="title" value="<?php echo $banner['title']; ?>" class="form-control" data-error="Please input banner title" placeholder="Banner Title" type="text">
								<div class="help-block form-text with-errors form-control-feedback"></div>
							</div>
						</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label for="description"> Description</label>
									<input autocomplete="off" name="description" value="<?php echo $banner['description'] ?>"  class="form-control" data-error="Please input banner description" placeholder="Description" type="text">
									<div class="help-block form-text text-muted form-control-feedback"></div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label for="image">Image</label>
									<input name="image" class="form-control"  placeholder="Select Banner File" type="file">
									<div class="help-block form-text with-errors form-control-feedback"></div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label for="order"> Order</label>
									<input autocomplete="off" name="order" value="<?php echo $banner['order'] ?>"  class="form-control" data-error="Please input banner order" placeholder="Order" required="required" type="text">
									<div class="help-block form-text text-muted form-control-feedback"></div>
								</div>
							</div>
							<div class="col-sm-6">
								<label for="order"> Status</label>
									<select class="form-control" name="status">
										<option value="1" <?php echo ($banner['status'] == 1)?(' selected="selected"'):(''); ?>>Active</option>
										<option value="0" <?php echo ($banner['status'] == 0)?(' selected="selected"'):(''); ?>>Inactive</option>
									</select>
							</div>
						</div>
					</fieldset>

					<div class="form-buttons-w">
						<button class="btn btn-primary" type="submit"> Submit</button>
						<a href="<?php echo ADMIN_URL.'banners'; ?>" class="btn btn-danger">Cancel</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
