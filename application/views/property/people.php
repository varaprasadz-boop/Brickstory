<?php //$this->load->view('partials/dashboard-top'); ?>
<div class="vwstryhero container-fluid pt30 pb100">
	<div class="container">


	</div>

</div>
<div class="llsection container-fluid pb100">
	<div class="container">

		<div class="row">
			<?php if(check_auth_session()){ ?>
				<?php $this->load->view('partials/dashboard-left'); ?>
			<?php } ?>
			<div class="col-md-12 <?php if(check_auth_session()){ ?>col-lg-9 <?php }else{ ?> col-lg-12 <?php } ?>">
				<div class="row pidetails">
					<div class="col-md-12 col-sm-12">
						<div class="bcca-breadcrumb ffa">
							<div class="bcca-breadcrumb-item">
								<a href="<?php echo base_url('details/timeline/'.$homeId) ?>" class="colorfff">Timeline</a>
							</div>
							<div class="bcca-breadcrumb-item bcca-breadcrumb-item-active">
								<a href="<?php echo base_url('details/people/'.$homeId) ?>" class="colorfff">People</a></div>
<!--							<div class="bcca-breadcrumb-item">-->
<!--								<a href="--><?php //echo base_url('details/story/'.$homeId) ?><!--" class="colorfff">Photo and Story</a></div>-->
							<div class="bcca-breadcrumb-item">
								<a href="<?php echo base_url('details/view/'.$homeId) ?>" class="colorfff">Photos and Stories</a> </div>
						</div>
					</div>

				<?php if(check_auth_session() && check_auth_session() == $home['user_id']){ ?>
					<?php $this->load->view("dashboard/partialDetails"); ?>
				<?php }else{ ?>
					<?php $this->load->view("property/partialDetails"); ?>
				<?php } ?>
				<div class="col-md-12">
				<h3 class="tcgrey"><strong>People</strong></h3>
				<style>
							.clrGreen{
								color: #516466 !important;
							}
						</style>
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
									<?php if($res->user_id == $this->session->userdata("user_id")){ ?>
										<a href="javascript:void(0);" class="btn btn-primary btn-xs" style="position: absolute;top: 0px;right: 0px;z-index: 999;" onclick="document.querySelector('.image<?php echo $res->id; ?>')?.click();">
											<i class="fa fa-pencil"></i> Edit Image
										</a>
										<input type="file" id="file" data-id="<?php echo $res->id; ?>"  accept="image/*" class="person_image image<?php echo $res->id; ?> form-control hide" id="customFile">
									<?php } ?>
									<div class="img-people">
										<img class="img-fluid <?php echo $class2; ?>" src="<?php echo ASSETS; ?>uploads/peoples/<?php echo $res->person_photo; ?>">
									</div>
									<a data-fancybox="gallery" href="<?php echo ASSETS; ?>uploads/peoples/<?php echo $res->person_photo; ?>">
										<div class="Img_frame">
											<img src="<?php echo ASSETS; ?>uploads/peoples/<?php echo $res->person_photo; ?>">
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
										<a href="#" class="editablePerson<?php echo $class; ?>" id="to_date" data-type="date" data-pk="<?php echo $res->id; ?>" data-viewformat="mm-dd-yyyy" data-value="<?php echo date("m-d-Y",strtotime($res->to_date)); ?>" data-title="Enter To Date"><?php echo date("m-d-Y",strtotime($res->to_date)); ?></a>
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
										<a href="#" class="editablePerson<?php echo $class; ?>" id="died_date" data-type="date" data-pk="<?php echo $res->id; ?>" data-viewformat="mm-dd-yyyy" data-value="<?php echo date("m-d-Y",strtotime($res->died_date)); ?>" data-title="Enter Died Date"><?php echo date("m-d-Y",strtotime($res->died_date)); ?></a>
									</div>
								</div>
							</div>
						<?php } ?>
					<?php } ?>
						
				</div>
				<div class="col-md-12 text-center">
							<button class="btn registerbtn1 ffa" onclick="location.href='<?php echo base_url('dashboard/addPeople/'.$homeId); ?>'">Add a Person </button>
						</div>
			</div>
			</div>
			<?php if(check_auth_session()){ ?>
				<?php $this->load->view('partials/dashboard-left-bottom'); ?>
			<?php } ?>

	</div>
</div>
</div>

<script>
document.querySelectorAll('.person_image').forEach(function(input) {
    input.addEventListener('change', function(event) {
        const file = event.target.files[0];
        const dataId = event.target.getAttribute('data-id');  // Get the data-id attribute
        
        if (file) {
            const formData = new FormData();
            formData.append('image', file);
            formData.append('data_id', dataId);  // Append the data-id to the form
            formData.append('<?php echo $this->security->get_csrf_token_name(); ?>', '<?php echo $this->security->get_csrf_hash(); ?>');

            // Send the form data to the server
            fetch('/dashboard/update_people_image', {
                method: 'POST',
                body: formData
            })
            // .then(response => response.json())
            .then(data => {
                console.log('Success:', data);
                location.reload(true);
            })
            .catch(error => {
                console.error('Error:', error);
            });
        } else {
            alert('file not found');
        }
    });
});



</script>
