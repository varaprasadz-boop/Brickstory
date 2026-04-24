<?php //$this->load->view('partials/dashboard-top'); ?>
<div class="llsection container-fluid pt60 pb100">
	<div class="container">
		<div class="row ">
			<?php $this->load->view('partials/dashboard-left'); ?>

			<div class="col-md-12 col-lg-9">
				<div class="row pidetails">
					<div class="col-md-12 text-center">
						<h4 class="tcgrey">EDIT PROFILE</h4>
					</div>
					<div class="col-md-4">
						<?php
						$url =  ASSETS."images/profile.png";

						if(is_file('./assets/uploads/user_images/'.$user['profile_photo'])){
							$url = ASSETS.'uploads/user_images/'.$user['profile_photo'];
						}?>
						<img src="<?php echo $url; ?>" class="img-fluid showImagePreview profile_image_preview"></div>
					<div class="col-md-8 ">
						<form method="post" id="submitform" action="" enctype="multipart/form-data">
							<div class="row mt50">
							<div class="col-md-4">
								<label for="ProfilePhoto">  Profile Photo:</label>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<div class="custom-file">
										<input type="file" name="image" id="file" class="custom-file-input showImage form-control">
										<label class="custom-file-label" for="customFile">Choose file</label>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="FirstName"> First Name:</label>
									<input type="text" name="firstname" id="FirstName" class="form-control" required="required" value="<?php echo $user['firstname'] ?>">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="LastName"> Last Name:</label>

									<input type="text" name="lastname" id="LastName" class="form-control" required="required" value="<?php echo $user['lastname'] ?>">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="Email"> Email:</label>
									<input type="email" name="email" id="Email" class="form-control" required="required" value="<?php echo $user['email'] ?>">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="Password"> Password:</label>
									<input type="password" name="password" id="Password" class="form-control">
								</div>
							</div>

							<div class="col-md-12">
								<div class="form-group">
									<label for="Email"> Address:</label>
									<textarea class="form-control" id="Address" name="address" rows = "6"><?php echo $user['address'] ?></textarea>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="City"> City:</label>
									<input type="text" name="city" id="City" class="form-control" value="<?php echo $user['city'] ?>">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="State">State:</label>
									<input type="text" name="state" id="State" class="form-control" value="<?php echo $user['state'] ?>">
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="Zip"> Zip:</label>
									<input type="text" name="zip" id="Zip" class="form-control" value="<?php echo $user['zip'] ?>">
								</div>
							</div>
							<div class="col-md-6 offset-md-4">
								<button type="submit" class="btn sendbtn">Save</button>
								<button onclick="location.href='<?php echo base_url('dashboard'); ?>'" class="btn sendbtn">Cancel</button>
							</div>
						</div>
						</form>
					</div>

				</div>
			</div>
			<?php $this->load->view('partials/dashboard-left-bottom'); ?>
		</div>
	</div>
</div>

