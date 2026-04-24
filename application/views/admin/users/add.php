<div class="row">
	<div class="col-sm-12">
		<div class="element-wrapper">
			<div class="element-box">
				<form id="formValidate" method="post" action="">
					<h5 class="form-header">
						Create a new user
					</h5>
					<div class="form-desc">Fill up the below form to create a new user account.</div>

					<fieldset class="form-group">
						<legend><span>Personal Details</span></legend>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label for=""> First Name</label>
									<input autocomplete="off" name="firstname" value="<?php echo set_value('firstname') ?>" class="form-control" data-error="Please input your First Name" placeholder="First Name" required="required" type="text">
									<div class="help-block form-text with-errors form-control-feedback"></div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label for="">Last Name</label>
									<input autocomplete="off" name="lastname" value="<?php echo set_value('lastname') ?>" class="form-control" data-error="Please input your Last Name" placeholder="Last Name" required="required" type="text">
									<div class="help-block form-text with-errors form-control-feedback"></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for=""> Email address</label>
									<input autocomplete="off" value="<?php echo set_value('email') ?>" class="form-control" name="email" data-error="Your email address is invalid" placeholder="Enter email" required="required" type="email">
									<div class="help-block form-text with-errors form-control-feedback"></div>
									<?php echo form_error('email','<div class="help-block form-text with-errors form-control-feedback">','</div>') ?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label for=""> Password</label>
									<input autocomplete="off" name="password" class="form-control" minlength="6" data-minlength="6" placeholder="Password" required="required" type="password">
									<div class="help-block form-text text-muted form-control-feedback">
										Minimum of 6 characters
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label for="">Confirm Password</label>
									<input autocomplete="off" name="cpassword" class="form-control" data-match-error="Passwords don&#39;t match" placeholder="Confirm Password" minlength="6" required="required" type="password">
									<div class="help-block form-text with-errors form-control-feedback"></div>
								</div>
							</div>
						</div>
					</fieldset>
					<fieldset class="form-group">
						<legend><span>System Details</span></legend>
						<div class="row">
							<div class="col-md-6">
								<select class="form-control" name="role_id">
									<?php $role_list = role_list();
									if($role_list){
										foreach($role_list as $key => $val){ ?>
											<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
											<?php } ?>
									<?php } ?>
								</select>
							</div>
							<div class="col-md-6">
								<select class="form-control" name="status">
									<option value="1">Active</option>
									<option value="0">Inactive</option>
								</select>
							</div>
						</div>

					</fieldset>
					<div class="form-buttons-w">
						<button class="btn btn-primary" type="submit"> Submit</button>
						<a href="<?php echo ADMIN_URL.'users'; ?>" class="btn btn-danger">Cancel</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
