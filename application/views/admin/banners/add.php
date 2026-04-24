<div class="row">
	<div class="col-sm-12">
		<div class="element-wrapper">
			<div class="element-box">
				<form id="formValidate" method="post" action="" enctype="multipart/form-data">
					<h5 class="form-header">
						Add Banner
					</h5>
					<div class="form-desc">Fill up the below form to create a new banner.</div>

					<fieldset class="form-group">
						<legend><span>Banner Details</span></legend>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label for="section_id">Section</label>
									<select class="form-control" name="section_id" id="section_id">
										<option value="1">Home Banner</option>
										<option value="4">Home Video</option>
										<option value="3">Login Banner</option>
									</select>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								</div>
							</div>

						<div class="col-sm-6">
							<div class="form-group">
								<label for="title"> Title</label>
								<input autocomplete="off" name="title" value="<?php echo set_value('title') ?>" class="form-control" data-error="Please input banner title" placeholder="Banner Title" type="text">
								<div class="help-block form-text with-errors form-control-feedback"></div>
							</div>
						</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label for="description"> Description</label>
									<input autocomplete="off" name="description" value="<?php echo set_value('description') ?>"  class="form-control" data-error="Please input banner description" placeholder="Description" type="text">
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
									<input autocomplete="off" name="order" value="<?php echo set_value('order') ?>"  class="form-control" data-error="Please input banner order" placeholder="Order" required="required" type="text">
									<div class="help-block form-text text-muted form-control-feedback"></div>
								</div>
							</div>
							<div class="col-sm-6">
								<label for="order"> Status</label>
									<select class="form-control" name="status">
										<option value="1">Active</option>
										<option value="0">Inactive</option>
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
