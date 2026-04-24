
<div class="contacthero container-fluid pt100 pb100">
	<div class="container">

		<div class="row ">
			<div class="col-lg-8 offset-lg-2">
				<div class="cnctfrm">
					<div class="col-md-12 p0">
						<h3>Contact BrickStory</h3>
						<p class="mt10 fs13">
							<strong>Please contact us about:</strong>
							<ul>
								<li>Preserving your Community</li>
								<li>Partnership Inquiries</li>
								<li>Inquiries about our Docuseries: “BrickStory – American Neighborhoods”</li>
								<li>How we can Improve our Platform to Better Serve You!</li>
							</ul>

						</p>
					</div>
					<!-- <form method="post" action="" id="myform2"> -->
					<?php echo form_open('',array("id" => "myform2")); ?>

						<div class="row tcgrey">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Your Name</label>
								<input type="text" name="name" class="form-control" required="required">
								<?php echo form_error("name"); ?>
							</div>
							<div class="form-group">
								<label>Email</label>
								<input type="email" name="email" class="form-control" required="required">
								<?php echo form_error("email"); ?>
							</div>
							<div class="form-group">
								<label>Phone</label>
								<input type="number" name="phone" class="form-control">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label >Message</label>

								<textarea name="message" rows="4" cols="25" class="form-control">

</textarea>
							</div>
							<div class="pull-right"><button class="btn sendbtn" type="submit">Send</button></div>
						</div>
					<!-- </form> -->
					<?php echo form_close(); ?>

				</div>
				</div>

			</div>
		</div>


	</div>

</div>
