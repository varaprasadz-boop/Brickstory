<div class="container personalinfo d-block d-xl-none mt25">
<div class="row">
<div class="col-md-12 col-sm-12 col-lg-3  mt-5">
	<div class="mb50">
		<div class="text-center tcgrey ffa">
			<h5 style="font-size: 20px;">
				<b>Personal Information</b>
				<hr>
			</h5>
		</div>
		<div class="mt30 ffa tcgrey">
			<p class="fs13 m0">Name</p>
			<p class="fs18 m0"><?php echo $user['firstname'].' '.$user['lastname'] ?></p>
		</div>
		<div class="mt10 ffa tcgrey">
			<p class="fs13 m0">Email</p>
			<p class="fs18 m0"><?php echo $user['email']; ?></p>
		</div>
		<div class="mt10 ffa tcgrey">
			<p class="fs13 m0">City</p>
			<p class="fs18 m0"><?php echo $user['city']; ?></p>
		</div>
	</div>
</div>
</div>
</div>
