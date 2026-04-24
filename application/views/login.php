<div class="container-fluid ">
	<div class="row ">
		<div class="col-lg-6   loginhero2 pt100 pb100  ">

		</div>
		<div class="col-lg-6 loginhero">
			<div class="text-center mt30">
				<h1>Login</h1>
			</div>
			<?php echo form_open('',array("id" => "myform")); ?>
				<div class="row pt100 pb100">
					<div class="col-md-8 offset-md-2">
							<label> Email Address</label>
							<div class="form-group">
								<input type="email" name="email" placeholder="Email Address " class="form-control" required="required">
							</div>
							<label> Password</label>
							<div class="form-group input-container">
								<input type="Password" name="password" placeholder="Password" class="form-control input-field" id="pass_log_id" required="required">
								<span toggle="#password-field" onclick="myFunction();" class="fa fa-fw fa-eye field_icon toggle-password icon"></span>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<input type="checkbox" id="" name="" value="Car">
									<label for="">Remember me</label>
								</div>
								<div class="col-md-6">
									<a class="pull-right" href="<?php echo base_url('account/forgot_password'); ?>"> Forget Password?</a>
								</div>
								<div class="col-md-12 ">
									<div class="p10 pull-right"><button type="submit" class="btn hmbtn">Login</button></div>
								</div>
							</div>
						</div>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<script>
	function myFunction() {
		var x = document.getElementById("pass_log_id");
		if (x.type === "password") {
			x.type = "text";
		} else {
			x.type = "password";
		}
	}
</script>
<style>
	.toggle-password:hover{
		cursor: pointer;
	}
	.alert.alert-danger{
  background-color: #650909!important;
  color: #fff!important;
  border-radius: 0!important;
  margin-bottom: 0!important;
  border:none!important;
  text-align: center;
}
</style>
