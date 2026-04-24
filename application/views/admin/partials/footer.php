			</div>
		</div>
	<div class="display-type"></div>
</div>
			<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header" style="border-bottom: solid 1px;background-color: #eaeaea;">
							Confirm Action
						</div>
						<div class="modal-body">
							Would you like to perform this action ?
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
							<a class="btn btn-danger btn-ok">Confirm</a>
						</div>
					</div>
				</div>
			</div>
<script src="<?php echo ADMIN_ASSETS; ?>bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?php echo ADMIN_ASSETS; ?>bower_components/popper.js/dist/umd/popper.min.js"></script>
<script src="<?php echo ADMIN_ASSETS; ?>bower_components/moment/moment.js"></script>
<script src="<?php echo ADMIN_ASSETS; ?>bower_components/chart.js/dist/Chart.min.js"></script>
<script src="<?php echo ADMIN_ASSETS; ?>bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="<?php echo ADMIN_ASSETS; ?>bower_components/jquery-bar-rating/dist/jquery.barrating.min.js"></script>
<script src="<?php echo ADMIN_ASSETS; ?>bower_components/ckeditor/ckeditor.js"></script>
<script src="<?php echo ADMIN_ASSETS; ?>bower_components/bootstrap-validator/dist/validator.min.js"></script>
<script src="<?php echo ADMIN_ASSETS; ?>bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?php echo ADMIN_ASSETS; ?>bower_components/ion.rangeSlider/js/ion.rangeSlider.min.js"></script>
<script src="<?php echo ADMIN_ASSETS; ?>bower_components/dropzone/dist/dropzone.js"></script>
<script src="<?php echo ADMIN_ASSETS; ?>bower_components/editable-table/mindmup-editabletable.js"></script>
<script src="<?php echo ADMIN_ASSETS; ?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo ADMIN_ASSETS; ?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo ADMIN_ASSETS; ?>bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
<script src="<?php echo ADMIN_ASSETS; ?>bower_components/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js"></script>
<script src="<?php echo ADMIN_ASSETS; ?>bower_components/tether/dist/js/tether.min.js"></script>
<script src="<?php echo ADMIN_ASSETS; ?>bower_components/slick-carousel/slick/slick.min.js"></script>
<script src="<?php echo ADMIN_ASSETS; ?>bower_components/bootstrap/js/dist/util.js"></script>
<script src="<?php echo ADMIN_ASSETS; ?>bower_components/bootstrap/js/dist/alert.js"></script>
<script src="<?php echo ADMIN_ASSETS; ?>bower_components/bootstrap/js/dist/button.js"></script>
<script src="<?php echo ADMIN_ASSETS; ?>bower_components/bootstrap/js/dist/carousel.js"></script>
<script src="<?php echo ADMIN_ASSETS; ?>bower_components/bootstrap/js/dist/collapse.js"></script>
<script src="<?php echo ADMIN_ASSETS; ?>bower_components/bootstrap/js/dist/dropdown.js"></script>
<script src="<?php echo ADMIN_ASSETS; ?>bower_components/bootstrap/js/dist/modal.js"></script>
<script src="<?php echo ADMIN_ASSETS; ?>bower_components/bootstrap/js/dist/tab.js"></script>
<script src="<?php echo ADMIN_ASSETS; ?>bower_components/bootstrap/js/dist/tooltip.js"></script>
<script src="<?php echo ADMIN_ASSETS; ?>bower_components/bootstrap/js/dist/popover.js"></script>
<script src="<?php echo ADMIN_ASSETS; ?>js/demo_customizer.js?version=4.4.0"></script>
<script src="<?php echo ADMIN_ASSETS; ?>js/main.js?version=4.4.0"></script>
<style>
	.customalert{
		top: 0px;
		position: absolute;
		width: 50% !important;
	}
</style>
			<script>
				$('#confirm-delete').on('show.bs.modal', function(e) {
					$(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
				});

	function msg(type,msg){
		var html = '';

			if (type == "success") {
				html += '<div class="alert alert-success customalert" role="alert">' + msg + '<button type="button" style="margin-left: 20px;margin-top: -3px;" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
			}
			if (type == "error") {
				html += '<div class="alert alert-danger customalert"  role="alert">' + msg + '<button type="button" style="margin-left: 20px;margin-top: -3px;" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
			}
			if (type == "warning") {
				html += '<div class="alert alert-primary customalert" role="alert">' + msg + '<button type="button" style="margin-left: 20px;\n    margin-top: -3px;" class="close" data-dismiss="alert" aria-label="Close">\n    <span aria-hidden="true">&times;</span>\n  </button></div>';
			}
			$('.top-menu-controls').append(html);
			// $('.alert').show('slide', {
			//     direction : 'right'
			// }, 500);
			setTimeout(function () {
				$('.alert').hide();
			}, 5000);

	}
	<?php js_msg(); ?>
</script>
</body>
</html>
