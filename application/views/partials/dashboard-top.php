<div class="psinfohero container-fluid pt100 pb10">
	<div class="container text-center">
		<div class="row">
			<div class="col-sm-8">
				<div class="row">
					<div class="col-sm-3 ">
						<div class="pibox">
						</div>
					</div>
					<div class="ffa col-sm-6 text-left mt30 colorfff">
						<h3><b><?php echo $user['firstname'].' '.$user['lastname'] ?></b></h3>
<!--						<h5 class="">Professional Designation</h5>-->
<!--						<h5 class="">Last Login : 3 min ago</h5>-->
					</div>
				</div>
			</div>
			<div class="col-sm-4 mt50">
				<div class="row">
<!--					<div class="col-sm-4 pilink">-->
<!--						<a class="  ffa color000" href="#"><i class="fa fa-envelope mr10" aria-hidden="true"></i>Messages</a>-->
<!--					</div>-->
					<div class="col-sm-4 pilink">
						<a class="ffa color000" href="<?php echo base_url('dashboard/myprofile'); ?>"><i class="fa fa-pencil-square-o mr10" aria-hidden="true"></i></i>Edit Profile</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
