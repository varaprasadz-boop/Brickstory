<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

	<title><?php echo isset($title) ? htmlspecialchars($title.' | '.site_name()) : htmlspecialchars(get_settings('SEO_META_TITLE', site_name())); ?></title>

	<meta name="description" content="<?php echo htmlspecialchars($description ?? get_settings('SEO_META_DESCRIPTION', '')); ?>">
    <meta name="keywords" content="">
    <meta name="author" content="Brickstory">

    <meta property="og:title" content="<?php echo isset($title) ? htmlspecialchars($title.' | '.site_name()) : htmlspecialchars(get_settings('SEO_META_TITLE', site_name())); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($description ?? get_settings('SEO_META_DESCRIPTION', '')); ?>">
    <meta property="og:image" content="<?php echo htmlspecialchars(get_settings('SEO_OG_IMAGE', site_logo())); ?>">
    <meta property="og:url" content="https://brickstory.com">
    <meta property="og:type" content="website">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo isset($title) ? htmlspecialchars($title.' | '.site_name()) : htmlspecialchars(get_settings('SEO_META_TITLE', site_name())); ?>">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($description ?? get_settings('SEO_META_DESCRIPTION', '')); ?>">
    <meta name="twitter:image" content="<?php echo htmlspecialchars(get_settings('SEO_OG_IMAGE', site_logo())); ?>">

	<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no"> -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link rel="icon" href="<?php echo htmlspecialchars(get_settings('BRAND_FAVICON_URL', 'https://brickstory.com/favicon.ico')); ?>" type="image/x-icon">

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

<?php if ($ga = get_settings('SEO_GOOGLE_ANALYTICS_ID', '')) { ?>
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo htmlspecialchars($ga); ?>"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','<?php echo htmlspecialchars($ga); ?>');</script>
<?php } ?>
</head>
<body>
