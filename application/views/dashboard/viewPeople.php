<?php //$this->load->view('partials/dashboard-top'); ?>
<div class="vwstryhero container-fluid pb100">
	<div class="container">
	</div>
</div>
<div class="llsection container-fluid pb100">
	<div class="container">

		<div class="row ">
			<?php $this->load->view('partials/dashboard-left'); ?>

			<div class="col-md-12 col-lg-9">

				<div class="row pidetails">
					<div class="col-md-12 col-sm-12">
						<div class="bcca-breadcrumb ffa">
							<div class="bcca-breadcrumb-item">
								<a href="<?php echo base_url('dashboard/viewTimeLine/'.$homeId) ?>" class="colorfff">Timeline</a>
							</div>
							<div class="bcca-breadcrumb-item bcca-breadcrumb-item-active">
								<a href="<?php echo base_url('dashboard/viewPeople/'.$homeId) ?>" class="colorfff">People</a></div>
<!--							<div class="bcca-breadcrumb-item">-->
<!--								<a href="--><?php //echo base_url('dashboard/viewStory/'.$homeId) ?><!--" class="colorfff">Photo and Story</a></div>-->
							<div class="bcca-breadcrumb-item">
								<a href="<?php echo base_url('dashboard/homeDetails/'.$homeId) ?>" class="colorfff">Photos and Stories</a> </div>
						</div>
					</div>
					<?php $this->load->view("dashboard/partialDetails"); ?>

					<div class="col-md-12">
						<h3 class="tcgrey"><strong>People</strong></h3>
					</div>
					<?php if($result->num_rows() > 0){
							foreach($result->result() as $res){
								$class='';
								$class2='profile_image_preview';
								if($res->user_id != $this->session->userdata("user_id")){
									$class =  "dcdcdc";
									$class2 = "";
								}

								?>
							<div class="col-lg-4">
								<div class="peopleimg">
									<?php if($this->session->userdata("user_id") == 1 || $res->user_id == $this->session->userdata("user_id")){ ?>
										<a href="javascript:void(0);" class="btn btn-primary btn-xs" style="position: absolute;top: 0px;right: 0px;z-index: 999;" onclick="$(this).parent().find('.image').trigger('click');">
											<i class="fa fa-pencil"></i> Edit Image
										</a>
										<input type="file" id="file" data-id="<?php echo $res->id; ?>" class="image form-control hide" id="customFile">
									<?php } ?>
									<?php $url = '';
									if(is_file('./assets/uploads/peoples/'.$res->person_photo)){
										$url = ASSETS.'uploads/peoples/'.$res->person_photo;
									}else{
										$url = ASSETS.'uploads/story.jpg';
									}
									?>
									<a data-fancybox="gallery" href="<?php echo $url; ?>">
<!--										<div class="Img_frame">-->
<!--											<img src="--><?php //echo ASSETS; ?><!--images/NicePng_polaroid-frame-png_85740.png">-->
<!--										</div>-->
										<div class="img-people">
											<img class="img-fluid thumbnail<?php echo $res->id; ?> <?php echo $class2; ?>" src="<?php echo $url; ?>">
										</div>
									</a>
								</div>
								<div class="row">
									<div class="col-6">
										<label>First Name</label>:
									</div>
									<div class="col-6">
										<a href="#" class="editablePerson<?php echo $class; ?>" id="first_name" data-type="text" data-pk="<?php echo $res->id; ?>"  data-title="Update First Name"><?php echo $res->frist_name; ?></a>
									</div>
								</div>
								<div class="row">
									<div class="col-6">
										<label>Last Name</label>:
									</div>
									<div class="col-6">
										<a href="#" class="editablePerson<?php echo $class; ?>" id="last_name" data-type="text" data-pk="<?php echo $res->id; ?>"  data-title="Update Last Name"><?php echo $res->last_name; ?></a>
									</div>
								</div>
								<div class="row">
									<div class="col-6">
										<label>Relationship</label>:
									</div>
									<div class="col-6">
										<a href="#" class="editablePerson<?php echo $class; ?>" id="relation_id" data-type="select" data-source="<?php echo base_url('dashboard/getStats?relation=1'); ?>" data-placement="right" data-pk="<?php echo $res->id; ?>" data-value="<?php echo $res->relation_id; ?>" data-title="Update Relationship"><?php echo $res->relation_value; ?></a>
									</div>
								</div>
								<div class="row">
									<div class="col-6">
										<label>From</label>:
									</div>
									<div class="col-6">
										<a href="#" class="editablePerson<?php echo $class; ?>" id="from_date" data-type="date" data-pk="<?php echo $res->id; ?>" data-viewformat="mm-dd-yyyy" data-value="<?php echo date("m-d-Y",strtotime($res->from_date)); ?>" data-title="Enter From Date"><?php echo date("m-d-Y",strtotime($res->from_date)); ?></a>
									</div>
								</div>
								<div class="row">
									<div class="col-6">
										<label>To</label>:
									</div>
									<div class="col-6">
										<a href="#" class="editablePerson<?php echo $class; ?>" id="to_date" data-type="date" data-pk="<?php echo $res->id; ?>" data-viewformat="mm-dd-yyyy" data-value="<?php echo date("m-d-Y",strtotime($res->to_date)); ?>" data-title="Enter To Date">
											
											<?php echo (date("m-d-Y",strtotime($res->to_date)) == "01-01-1970")?(
												($res->living == 1)?('Currenty Living'):('-')
											):(date("m-d-Y",strtotime($res->to_date))); ?>
										</a>
									</div>
								</div>
								<div class="row">
									<div class="col-6">
										<label>Born</label>:
									</div>
									<div class="col-6">
										<a href="#" class="editablePerson<?php echo $class; ?>" id="born_date" data-type="date" data-pk="<?php echo $res->id; ?>" data-viewformat="mm-dd-yyyy" data-value="<?php echo date("m-d-Y",strtotime($res->born_date)); ?>" data-title="Enter Born Date"><?php echo date("m-d-Y",strtotime($res->born_date)); ?></a>
									</div>
								</div>
								<div class="row mb-4 mb-lg-0">
									<div class="col-6">
										<label>Death</label>:
									</div>
									<div class="col-6">
										<a href="#" class="editablePerson<?php echo $class; ?>" id="died_date" data-type="date" data-pk="<?php echo $res->id; ?>" data-viewformat="mm-dd-yyyy" data-value="<?php echo date("m-d-Y",strtotime($res->died_date)); ?>" data-title="Enter Died Date">
											<?php echo (date("m-d-Y",strtotime($res->died_date)) != "01-01-1970")?(''):('No'); ?>
										</a>
									</div>
								</div>
							</div>
						<?php } ?>
					<?php } ?>
					<div class="col-md-12 text-center">
						<button class="btn registerbtn1 ffa" onclick="location.href='<?php echo base_url('dashboard/addPeople/'.$homeId); ?>'">Add a Person </button>
					</div>
				</div>
			</div>
			<?php $this->load->view('partials/dashboard-left-bottom'); ?>
		</div>

	</div>
</div>


