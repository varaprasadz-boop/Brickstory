<div class="container-fluid ">
	<div class="row ">
		<div class="col-lg-6   loginhero2 pt100 pb100  ">

		</div>
		<div class="col-lg-6 loginhero">
			<div class="text-center mt30">
				<h1>Reset Password</h1>
			</div>
			<form method="post" id="myform" action="">
				<div class="row pt50 pb100">
					<div class="col-md-8 offset-md-2">
						<?php if(validation_errors()){
							echo '<div class="alert alert-danger" role="alert">';
							echo validation_errors();
							echo '</div>';
						} ?>
						<label>Password</label>
						<div class="form-group">
							<input type="password" name="password" placeholder="Enter your password" class="form-control" required="required">
						</div>
					</div>
					<div class="col-md-8 offset-md-2">
						<label>Confirm Password</label>
						<div class="form-group">
							<input type="password" name="confirm_password" placeholder="Re-enter your password" class="form-control" required="required">
						</div>
					</div>
					<div class="col-md-12 ">

						<div class="p10 pull-right"><button type="submit" class="btn hmbtn">Reset Password</button></div>
					</div>
				</div>

			</form>
		</div>
	</div>
</div>
