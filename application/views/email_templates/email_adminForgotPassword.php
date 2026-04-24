<div style="display:block;height:auto;width:600px;margin:auto; padding:0px 0px 20px 0px; background-color:#eeeeee7a;">
	<div style="display: block;
    width: 100%;
    height: 50px;
    background-color: #556769;">
		<img height="80" style="margin-top:25px;" src="<?php echo ASSETS; ?>/images/logo.png" alt="">

	</div>
	<div  style="padding:20px;margin-top:50px;">

	<b>Dear <?php echo $name; ?></b><br /><br>
	To reset the password to your BrickStory administrator account, click the link below: <br /><br>
	<?php echo $URL; ?><br><br>
	For your information:<br><br>
	Time of request: <?php echo date("l, d M Y ",time()); ?><br >
	IP Address: <?php echo $_SERVER['REMOTE_ADDR']; ?><br ><br><br>
		Sincerely,<br>
		BrickStory Team<br >
	</div>
</div>
