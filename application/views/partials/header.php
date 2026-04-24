<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

	<title><?php echo isset($title)?($title):(get_settings('SITE_NAME')) ?></title>

	<meta name="description" content="<?php echo $description??'' ?>">
    <meta name="keywords" content="">
    <meta name="author" content="Brickstory">

    <meta property="og:title" content="<?php echo isset($title)?($title):(get_settings('SITE_NAME')) ?>">
    <meta property="og:description" content="<?php echo $description??'' ?>">
    <meta property="og:image" content="<?php echo ASSETS; ?>images/logo.png">
    <meta property="og:url" content="https://brickstory.com">
    <meta property="og:type" content="website">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo isset($title)?($title):(get_settings('SITE_NAME')) ?>">
    <meta name="twitter:description" content="<?php echo $description??'' ?>">
    <meta name="twitter:image" content="<?php echo ASSETS; ?>images/logo.png">

	<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no"> -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link rel="icon" href="https://brickstory.com/favicon.ico" type="image/x-icon">

	<link rel="stylesheet" type="text/css" href="<?php echo ASSETS; ?>css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo ASSETS; ?>css/style.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link type="text/css" href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css" rel="stylesheet">

	<link rel="stylesheet" href="<?php echo ASSETS; ?>css/jquery-ui.css">

	<!--	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>-->
<style>
	select.form-control{
		height: 34px !important;
	}
</style>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css"/>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style type="text/css">

   
</style>

<!-- Google tag (gtag.js) --> <script async src="https://www.googletagmanager.com/gtag/js?id=G-VWLVQMH8NN"></script> <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'G-VWLVQMH8NN'); </script>
</head>
<body>
