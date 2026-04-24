<?php $this->load->view('admin/partials/header'); ?>
<?php $this->load->view('admin/partials/left-menu'); ?>
<div class="content-w">
	<?php $this->load->view('admin/partials/top-menu'); ?>

	<div class="content-i">
		<div class="content-box">
			<?php  $this->load->view('admin/'.$filename); ?>
		</div>
	</div>
</div>
<?php $this->load->view('admin/partials/footer'); ?>
