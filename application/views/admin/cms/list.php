<div class="element-wrapper">
	<h6 class="element-header">
		CMS List
		<a href="<?php echo ADMIN_URL.'cms/add'; ?>" style="float: right" class="btn btn-primary">Add CMS</a>
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
			<table class="table table-lightborder">
				<thead>
				<tr>
					<th>#</th>
					<th>Title</th>
					<th>Slug Url</th>
					<th class="text-right">Status</th>
					<th class="text-center">Last Modified</th>
					<th class="text-right">Actions</th>
				</tr>
				</thead>
				<tbody>
					<?php if($cms){
							foreach($cms as $key => $val){?>
					<tr>
					<td><?php echo $val->id;  ?></td>
					<td><?php echo $val->title; ?></td>
					<td><?php echo $val->slug_url; ?></td>
					<td><?php echo ($val->status == 1)?('Active'):('Inactive'); ?></td>
					<td><?php echo $val->modified; ?></td>
					</td>
					<td class="text-right">
						<a href="<?php echo ADMIN_URL."cms/edit/".$val->id; ?>" class="btn btn-primary btn-sm">
							<i class="os-icon os-icon-pencil-2"></i>
						</a>
						<a class="btn btn-danger btn-sm" data-href="<?php echo ADMIN_URL.'cms/delete/'.$val->id; ?>" data-target="#confirm-delete" data-toggle="modal">
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
									$url = ADMIN_URL.'cms/index/'.$real_page;
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
									<li class="page-item <?php echo $active; ?>"><a class="page-link" href="<?php echo ADMIN_URL.'cms/index/'.$i; ?>"><?php echo $i; ?></a></li>
								<?php }
								$url = '#';
								$class2 = '';
								if($real_page == $total_pages) {
									$class2 = 'disabled';
								}
								if($total_pages > $real_page){
									$real_page = $real_page+2;

									$url = ADMIN_URL.'cms/index/'.$real_page;
								} ?>
								<li class="page-item <?php echo $class2; ?>"><a class="page-link" href="<?php echo $url; ?>">Next</a></li>
							</ul>
						</nav>
					<?php } ?>
				</div>
			</div>

		</div>
	</div>
	</div>
</div>
