<div class="element-wrapper">
	<h6 class="element-header">
		Settings
		<a href="<?php echo ADMIN_URL.'settings/add'; ?>" style="float: right" class="btn btn-primary">Add Setting</a>
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
					<form class="form-inline justify-content-sm-end" method="get" action="">

						<input class="form-control form-control-sm rounded bright" value="<?php echo get('search'); ?>" name="search" placeholder="Search" type="text">
						<?php if(get('search')){ ?>
							<a href="<?php echo admin_url('settings/advanced/1'); ?>" class="btn btn-primary btn-sm">Clear</a>
						<?php } ?>
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
					<th>Sr. No.</th>
					<th>Setting Title</th>
					<th>Settings Label</th>
					<th>Setting Value</th>
					<th>Comment</th>
					<th style="width: 250px;">Actions</th>
				</tr>
				</thead>
				<tbody>
					<?php if($settings){
							foreach($settings as $key => $val){?>
					<tr>
					<td><?php echo $val->id;  ?></td>
					<td><?php echo $val->setting_label; ?></td>
					<td><?php echo $val->setting_title; ?></td>
					<td><?php echo $val->setting_value; ?></td>
					<td><?php echo $val->comment; ?></td>
					<td class="text-right">
						<a href="<?php echo ADMIN_URL."settings/edit/".$val->id ?>" class="btn btn-primary btn-sm">
							<i class="os-icon os-icon-pencil-2"></i>
						</a>
						<a class="btn btn-danger btn-sm" data-href="<?php echo ADMIN_URL.'settings/delete/'.$val->id; ?>" data-target="#confirm-delete" data-toggle="modal">
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
									$url = admin_url('settings/advanced/'.$real_page);
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
									<li class="page-item <?php echo $active; ?>"><a class="page-link" href="<?php echo admin_url('settings/advanced/'.$i); ?>"><?php echo $i; ?></a></li>
								<?php }
								$url = '#';
								$class2 = '';
								if($real_page == $total_pages) {
									$class2 = 'disabled';
								}
								if($total_pages > $real_page){
									$real_page = $real_page+2;

									$url = admin_url('settings/advanced/'.$real_page);
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
