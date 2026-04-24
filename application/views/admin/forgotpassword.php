<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title; ?></title>
	<meta charset="utf-8">
	<meta content="ie=edge" http-equiv="x-ua-compatible">
	<meta content="template language" name="keywords">
	<meta content="Tamerlan Soziev" name="author">
	<meta content="Admin dashboard html template" name="description">
	<meta content="width=device-width, initial-scale=1" name="viewport">
	<link href="favicon.png" rel="shortcut icon">
	<link href="apple-touch-icon.png" rel="apple-touch-icon">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500" rel="stylesheet" type="text/css">
	<link href="<?php echo ADMIN_ASSETS; ?>bower_components/select2/dist/css/select2.min.css" rel="stylesheet">
	<link href="<?php echo ADMIN_ASSETS; ?>bower_components/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
	<link href="<?php echo ADMIN_ASSETS; ?>bower_components/dropzone/dist/dropzone.css" rel="stylesheet">
	<link href="<?php echo ADMIN_ASSETS; ?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo ADMIN_ASSETS; ?>bower_components/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet">
	<link href="<?php echo ADMIN_ASSETS; ?>bower_components/perfect-scrollbar/css/perfect-scrollbar.min.css" rel="stylesheet">
	<link href="<?php echo ADMIN_ASSETS; ?>bower_components/slick-carousel/slick/slick.css" rel="stylesheet">
	<link href="<?php echo ADMIN_ASSETS; ?>css/main.css?version=4.4.0" rel="stylesheet">
</head>
<body class="auth-wrapper">
<div class="all-wrapper menu-side with-pattern">
	<div class="auth-box-w">
		<div class="logo-w" style="padding:10%;">
			<a href="#">
					<img src="<?php echo ASSETS; ?>images/logo.png"  style="height:100px;" class="logoimg">
			</a>
		</div>
		<h4 class="auth-header">
			Forgot Password.
		</h4>
		<form action="" method="post">
			<div class="form-group">
				<label for="">Email</label>
				<input class="form-control" autocomplete="false" name="email" placeholder="Enter your email" type="email">
				<div class="pre-icon os-icon os-icon-user-male-circle"></div>
			</div>

			<div class="buttons-w">
				<button class="btn btn-default" type="button">Cancel</button>
				<button class="btn btn-primary" type="submit">Forgot</button>

			</div>
		</form>
	</div>
</div>
<style>
	.errorAlert{
		position: absolute;
		top: 0;
		right: 0;
	}
</style>
<script>
	function msg(type,msg){
		var html = '';
		if(type == "success"){
			html +=  '<div class="alert alert-success errorAlert" role="alert">'+msg+'<button type="button" style="margin-left: 20px;\n    margin-top: -3px;" class="close" data-dismiss="alert" aria-label="Close">\n    <span aria-hidden="true">&times;</span>\n  </button></div>';
			//$(".message-title").text(msg);
			//$("#message").modal('show');
			return false;
		}else if(type == "error-popup") {
			//$(".error-message-title").text(msg);
			//$("#error-message").modal('show');
			return false;
		}else{
			if (type == "error") {
				html += '<div class="alert alert-danger errorAlert"  role="alert">' + msg + '<button type="button" style="margin-left: 20px;margin-top: -3px;" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
			}
			if (type == "warning") {
				html += '<div class="alert alert-primary errorAlert" role="alert">' + msg + '<button type="button" style="margin-left: 20px;\n    margin-top: -3px;" class="close" data-dismiss="alert" aria-label="Close">\n    <span aria-hidden="true">&times;</span>\n  </button></div>';
			}
			$('body').append(html);
			// $('.alert').show('slide', {
			//     direction : 'right'
			// }, 500);
			setTimeout(function () {
				$('.alert').hide();
			}, 5000);
		}
	}
	<?php js_msg(); ?>
</script>
</body>
</html>
