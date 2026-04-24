<div class="element-wrapper">
	<h6 class="element-header">
		Slider List
		<a href="<?php echo ADMIN_URL.'slider/add'; ?>" style="float: right" class="btn btn-primary">Add User</a>
	</h6>
	<div class="element-box">

		<!--------------------
		START - Controls Above Table
		-------------------->
		<div class="controls-above-table">
			<div class="row">
				<div class="col-sm-6">
				</div>
				<div class="col-sm-6">
					<form class="form-inline justify-content-sm-end">
						<input class="form-control form-control-sm rounded bright" placeholder="Search" type="text"><select class="form-control form-control-sm rounded bright">
							<option selected="selected" value="">
								Select Status
							</option>
							<option value="Pending">
								Pending
							</option>
							<option value="Active">
								Active
							</option>
							<option value="Cancelled">
								Cancelled
							</option>
						</select>
					</form>
				</div>
			</div>
		</div>
		<!--------------------
		END - Controls Above Table
		-------------------->
		<div class="table-responsive">
			<!--------------------
			START - Basic Table
			-------------------->
			<?php if (!empty($sliders)): ?>
    <ul>
        <?php foreach ($sliders as $slider): ?>
            <li>
                <img src="<?= base_url('uploads/sliders/' . $slider['image']) ?>" alt="<?= $slider['title'] ?>" width="100">
                <h3><?= $slider['title'] ?></h3>
                <p><?= $slider['description'] ?></p>
                <a href="<?= base_url('slider/edit/' . $slider['id']) ?>">Edit</a> |
                <a href="<?= base_url('slider/delete/' . $slider['id']) ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No sliders found.</p>
<?php endif; ?>

			<!--------------------
			END - Basic Table
			-------------------->
		</div>
	<div class="row">
		<div class="col-md-12">

			

		</div>
	</div>
	</div>
</div>
