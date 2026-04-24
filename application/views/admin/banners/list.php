<div class="element-wrapper">
	<h6 class="element-header">
		Banners List
		<a href="<?php echo ADMIN_URL.'banners/add'; ?>" style="float: right" class="btn btn-primary">Add Banner</a>
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
					<th>Sr.No</th>
					<th>Image</th>
					<th>Title</th>
					<th>Section</th>
					<th>Status</th>
					<th>Actions</th>
				</tr>
				</thead>
				<tbody>
					<?php if($advertisement){
						$section = array(
							1 =>'Home Banner',
							3 =>'Login Banner',
							4 =>'Home Video' 
						);
						$status = array(
								'-1' => 'Deleted',
								'0' => 'Inactive',
								'1' => 'Active',
								'2' => 'Suspended',
								'3' => 'Restricted',
						);
							foreach($advertisement as $key => $val){?>
					<tr>
					<td><?php echo $val->id;  ?></td>
					<td>
						<img src="<?php echo base_url('/assets/uploads/banner_ad_images/'.$val->image_url); ?>" onerror="this.src='<?php echo base_url('/assets/uploads/banner_ad_images/crop/'.$val->image_url); ?>'" width="100">
					</td>
					<td><?php echo $val->title; ?></td>
					<td><?php echo $section[$val->section_id]??"-"; ?></td>
					<td class="text-center">
							<span class="badge badge-<?php echo ($val->status == '-1')?('danger'):(
								($val->status == 0)?('warning'):(
									($val->status == 1)?('success'):('info')
								)
							) ?>">	
								<?php echo $status[$val->status]; ?>
							</span>
					</td>
					<td class="text-right">
						<a href="<?php echo ADMIN_URL."banners/edit/".$val->id ?>" class="btn btn-primary btn-sm">
							<i class="os-icon os-icon-pencil-2"></i>
						</a>
						<a class="btn btn-danger btn-sm" data-href="<?php echo ADMIN_URL.'banners/delete/'.$val->id; ?>" data-target="#confirm-delete" data-toggle="modal">
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
									$url = ADMIN_URL.'banners/index/'.$real_page;
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
									<li class="page-item <?php echo $active; ?>"><a class="page-link" href="<?php echo ADMIN_URL.'banners/index/'.$i; ?>"><?php echo $i; ?></a></li>
								<?php }
								$url = '#';
								$class2 = '';
								if($real_page == $total_pages) {
									$class2 = 'disabled';
								}
								if($total_pages > $real_page){
									$real_page = $real_page+2;

									$url = ADMIN_URL.'banners/index/'.$real_page;
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
