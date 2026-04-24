<a href="#"><div class="nearmehero container-fluid pt30 pb-3">
	<div class="container text-center">
		<h1 class="colorfff heroheading">
			Near Me
		</h1>
	</div>
</div>
</a>
<div class="llsection container-fluid pt10 pb50">
	<div class="container">
		<div class="row">
			<?php $this->load->view('nearmeleft'); ?>
			<div class="">
				<div class="row">					
					<?php if($properties){
						 foreach($properties as $key => $val){
							$val['cls'] = 'col-lg-3 col-sm-3 col-md-3';
							$this->load->view('partials/home-thumb.php',array('val' => $val));
							
							} ?>
					<?php }else{ ?>
							<div class="col-md-12 text-center">
								<h3>No record found or kindly make sure your location is enable.</h3>
							</div>
					<?php } ?>
					<div class="col-md-12">
						<?php if(isset($total_pages) && $total_pages > 0){ ?>
							<nav aria-label="Page navigation example" style="float: right; margin-right: 10%;">
								<ul class="pagination pull-right">
									<?php $url = '#';
									$class = 'disabled';
									$queryString = '';
									if($_SERVER['QUERY_STRING']){
										$queryString = "?".$_SERVER['QUERY_STRING'];
									}
									if($real_page >= 1){
										$real_page = $real_page;
										$class = '';
										$url = base_url('search/'.$real_page.$queryString);
									}
									?>
									<li class="page-item <?php echo $class; ?>"><a class="page-link" href="<?php echo $url; ?>">Previous</a></li>
									<?php
									for($i = max(1, $page - 3); $i <= min($page + 3, $total_pages); $i++){
										//                        for($i =1; $i <= $total_pages; $i++){
										$active = '';
										if($page+1 == $i){
											$active = 'active';
										}
										?>
										<li class="page-item <?php echo $active; ?>"><a class="page-link" href="<?php echo base_url('search/'.$i.$queryString); ?>"><?php echo $i; ?></a></li>
									<?php }
									$url = '#';
									$class2 = '';
									if($real_page+1 == $total_pages) {
										$class2 = 'disabled';
									}
									if($real_page <= $total_pages){
										$real_page = $real_page+2;

										$url = base_url('search/'.$real_page.$queryString);

									}
									//echo $total_pages.' | '.$real_page;
									?>
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


