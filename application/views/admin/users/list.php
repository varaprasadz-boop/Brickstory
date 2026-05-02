<div class="element-wrapper">
	<h6 class="element-header">
		Users List
		<a href="<?php echo ADMIN_URL.'users/add'; ?>" style="float: right" class="btn btn-primary">Add User</a>
	</h6>
	<div class="element-box">
		<form method="post" action="<?php echo ADMIN_URL.'users/bulk_delete'; ?>" onsubmit="return confirm('Are you sure you want to delete selected users?');">

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
			<table class="table table-lightborder">
				<thead>
				<tr>
					<th><input type="checkbox" id="select-all-users"></th>
					<th>#</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th class="text-center">Email</th>
					<th class="text-center">Role</th>
					<th class="text-center">Properties</th>
					<th class="text-right">Status</th>
					<th class="text-right">Registered On</th>
					<th class="text-right">Actions</th>
				</tr>
				</thead>
				<tbody>
					<?php if($users){
						$status = array(
								'-1' => 'Deleted',
								'0' => 'Inactive',
								'1' => 'Active',
								'2' => 'Suspended',
								'3' => 'Restricted',
						);
							foreach($users as $key => $val){?>
					<tr>
					<td><input type="checkbox" class="user-checkbox" name="user_ids[]" value="<?php echo (int) $val->id; ?>"></td>
					<td><?php echo $val->id;  ?></td>
					<td><?php echo $val->firstname; ?></td>
					<td><?php echo $val->lastname; ?></td>
					<td><?php echo $val->email; ?></td>
					<td><?php echo $val->role_name; ?></td>
					<td class="text-center"><?php echo (int) $val->properties_count; ?></td>
					<td class="text-center">
						<span class="badge badge-<?php echo ($val->status == '-1')?('danger'):(
								($val->status == 0)?('warning'):(
									($val->status == 1)?('success'):('info')
								)
							) ?>">		
							<?php echo $status[$val->status]; ?>
						</span>
					</td>
					<td class="text-right"><?php echo !empty($val->created) ? date("M d, Y h:i A", strtotime($val->created)) : "-"; ?></td>
					<td class="text-right">
						<a href="<?php echo ADMIN_URL."users/edit/".$val->id ?>" class="btn btn-primary btn-sm">
							<i class="os-icon os-icon-pencil-2"></i>
						</a>
						<a class="btn btn-danger btn-sm" data-href="<?php echo ADMIN_URL.'users/delete/'.$val->id; ?>" data-target="#confirm-delete" data-toggle="modal">
							<i class="os-icon os-icon-ui-15"></i>
						</a>
					</td>
				</tr>
				<?php
							}
					}else{ ?>

				<?php } ?>
				</tbody>
			</table>

			<!--------------------
			END - Basic Table
			-------------------->
		</div>
		<div class="mb-3">
			<button type="submit" class="btn btn-danger btn-sm">Bulk Delete Selected</button>
		</div>
	<div class="row">
		<div class="col-md-12">

			<div class="row mtop20">
				<div class="col-md-12">
					Showing from <?php echo $page*$limit; ?> to <?php
					if($real_page != $total_pages) {
						echo $page * $limit + $limit;
					}else{
						echo $count;
					} ?> of <?php echo $count; ?>
					<?php if($total_pages > 0){ ?>
						<nav aria-label="Page navigation example" style="float: right; margin-right: 10%;">
							<ul class="pagination pull-right">
								<?php $url = '#';
								$class = 'disabled';
								if($real_page > 1){
									$real_page = $real_page-1;
									$class = '';
									$url = ADMIN_URL.'/users/index/'.$real_page;
								}
								?>
								<li class="page-item <?php echo $class; ?>"><a class="page-link" href="<?php echo $url; ?>">Previous</a></li>
								<?php
								for($i = max(1, $page - 3); $i <= min($page + 3, $total_pages); $i++){

									$active = '';
									if($page+1 == $i){
										$active = 'active';
									}
									?>
									<li class="page-item <?php echo $active; ?>"><a class="page-link" href="<?php echo ADMIN_URL.'users/index/'.$i; ?>"><?php echo $i; ?></a></li>
								<?php }
								$url = '#';
								$class2 = '';
								if($real_page == $total_pages) {
									$class2 = 'disabled';
								}
								if($total_pages > $real_page){
									$real_page = $real_page+2;

									$url = ADMIN_URL.'users/index/'.$real_page;
								} ?>
								<li class="page-item <?php echo $class2; ?>"><a class="page-link" href="<?php echo $url; ?>">Next</a></li>
							</ul>
						</nav>
					<?php } ?>
				</div>
			</div>

		</div>
	</div>
		</form>
	</div>
</div>
<script>
	document.getElementById('select-all-users').addEventListener('change', function () {
		var checked = this.checked;
		document.querySelectorAll('.user-checkbox').forEach(function (el) {
			el.checked = checked;
		});
	});
</script>
