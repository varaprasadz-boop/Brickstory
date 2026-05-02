<!--   --footer start-- -->
<div class="container-fluid footer">
	<div class="container">
		<div class="d-flex justify-content-center justify-content-sm-between  flex-wrap flax-sm-nowrap">
			<a class="nav-item nav-link head-item"><img src="<?php echo htmlspecialchars(site_logo()); ?>" class="logoimg"></a>
			<div class="nav-item nav-link pt50">
				<div class="d-flex footermenu justify-content-between justify-content-sm-between flex-wrap align-content-center">
					<a class="nav-item nav-link " href="javascript:void(0);" onClick="$('.nearmeform').submit();">Near Me</a>
					<a class="nav-item nav-link" href="<?php echo base_url('houseshistory'); ?>">Houses</a>
					<a class="nav-item nav-link " href="<?php echo base_url('photosnhistory'); ?>">Photos & Stories</a>
					<a class="nav-item nav-link " href="<?php echo base_url('peoples'); ?>">People</a>
					<a class="nav-item nav-link " href="<?php echo base_url('pages/architect'); ?>">Architects</a>
					<a class="nav-item  nav-link d-block d-sm-none " href="<?php echo base_url('dashboard/addHome'); ?>">Add a Home</a>
					<a class="nav-item  nav-link d-block d-sm-none" href="<?php echo base_url('aboutus'); ?>">About Us</a>
					<a class="nav-item  nav-link d-block d-sm-none" href="<?php echo base_url('pages/howitworks'); ?>">How it Works</a>
					<a class="nav-item nav-link d-block d-sm-none" href="<?php echo base_url('contactus'); ?>">Contact Us</a>







					<a class="nav-item nav-link " href="<?php echo base_url('pages/termandconditions'); ?>">Terms and Conditions</a>
   					<a class="nav-item nav-link " href="<?php echo base_url('pages/privacy-policy'); ?>">Privacy Policy</a>
				</div>
			</div>

		</div>
	</div>
</div>
<div class="modal" id="message" tabindex="-1" role="dialog">
	<div class="modal-dialog" style="left:auto !important;" role="document">
		<div class="modal-content">
			<div class="modal-body text-center">
			<i style="color:#00b900;" class="fa fa-check-circle text-center fa-5x"></i>
			<p class="text-center message-title"></p>
			<input type="button" class="btn btn-success" style="margin:auto;" value="OK" class="close" data-dismiss="modal">
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="error-message" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content text-center">
			<img width="32" style="margin: auto" height="32" src="<?php echo ASSETS.'images/error.png'; ?>">
			<p class="text-center error-message-title"></p>
			<input type="button" class="btn btn-success" style="margin:auto;" value="OK" class="close" data-dismiss="modal">
		</div>
	</div>
</div>
<div class="container-fluid footercr ">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-lg-4  fs13  ">
				<p>&copy; <?php echo date("Y",time()); ?> <?php echo htmlspecialchars(site_name()); ?>, LLC | All rights reserved <br />D-U-N-S Number is: 119298684</p>
			</div>

			<div class="col-lg-4 text-center" href="#">
				<div class="d-flex justify-content-center">
					<?php if ($facebook = get_settings('SOCIAL_FACEBOOK', '')) { ?><a target="_blank" class="colorf2 nav-item nav-link" href="<?php echo htmlspecialchars($facebook); ?>"><i class="fa fa-facebook fs16" aria-hidden="true"></i></a><?php } ?>
					<?php if ($instagram = get_settings('SOCIAL_INSTAGRAM', '')) { ?><a target="_blank" class="colorf2 nav-item nav-link" href="<?php echo htmlspecialchars($instagram); ?>"><i class="fa fa-instagram fs16" aria-hidden="true"></i></a><?php } ?>
					<?php if ($twitter = get_settings('SOCIAL_TWITTER', '')) { ?><a target="_blank" class="colorf2 nav-item nav-link" href="<?php echo htmlspecialchars($twitter); ?>"><i class="fa fa-twitter fs16" aria-hidden="true"></i></a><?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<!-- <script type="text/javascript" src="<?php echo ASSETS; ?>js/jquery.validate.min.js"></script> -->
<!-- Load jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<!--<script src="--><?php //echo ASSETS; ?><!--js/bootstrap.min.js"></script>-->
<script src="<?php echo ASSETS; ?>js/main.js"></script>
<script type="text/javascript" src="<?php echo ASSETS; ?>js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo ASSETS; ?>js/dropkick.min.js"></script>

<script>
	function showFilter(){
		$('.searchbox').toggleClass('lessHeight');
		$('.showFilter').toggleClass('hide');
	}


$("#myform").validate({
		submitHandler: function(form,e) {
			let loader = '<img class="loaderimage" src="<?php echo ASSETS; ?>/images/loader.gif" style="position: absolute;top: 32px;margin-left: 17px;">';
			$("#myform").find('button[type="submit"]').append(loader);
			e.preventDefault(); // avoid to execute the actual submit of the form.
			e.stopPropagation();
			// some other code
			// maybe disabling submit button
			// then:
			$.ajax({
				url:"<?php echo base_url('account/register'); ?>",
				type:"post",
				data:$(form).serialize(),
				success:function(data){
					var result = JSON.parse(data);
					$(".loaderimage").remove();
					if(result.status == "success"){
						location.reload();
					}else{
						alert(result.data);
					}
				}
			});
		}
	});
	$("#myform2").validate({
		submitHandler: function(form,e) {
			let loader = '<img class="loaderimage" src="<?php echo ASSETS; ?>/images/loader.gif" style="position: absolute;top: 32px;margin-left: 17px;">';
			$("#myform2").find('button[type="submit"]').append(loader);

			e.preventDefault(); // avoid to execute the actual submit of the form.
			e.stopPropagation();
			form.submit();
		}
	});
	$("#myform3").validate({
		submitHandler: function(form,e) {
			let loader = '<img class="loaderimage" src="<?php echo ASSETS; ?>/images/loader.gif" style="position: absolute;top: 32px;margin-left: 17px;">';
			$("#myform3").find('button[type="submit"]').append(loader);

			e.preventDefault(); // avoid to execute the actual submit of the form.
			e.stopPropagation();
			// some other code
			// maybe disabling submit button
			// then:
			$.ajax({
				url:"<?php echo base_url('account/register'); ?>",
				type:"post",
				data:$(form).serialize(),
				success:function(data){
					var result = JSON.parse(data);
					$(".loaderimage").remove();
					if(result.status == "success"){
						location.reload();
					}else{
						alert(result.data);
					}
				}
			});
		}
	});
	$("#submitform").validate({
		submitHandler: function(form,e) {
			e.preventDefault(); // avoid to execute the actual submit of the form.
			e.stopPropagation();
			form.submit();
		}
	});


</script>


<!-- Your custom JavaScript -->
<script>
$(document).ready(function() {
    // Custom validation method for either "To Date" or "I Still Live Here" checkbox
    $.validator.addMethod("dateOrLiveHere", function(value, element) {
        var toDate = $('#to_Date').val();
        var liveHereChecked = $('#user_lived_here').is(':checked');
        console.log("To Date: ", toDate, " | Live Here Checked: ", liveHereChecked); // Debugging
        return toDate !== '' || liveHereChecked;
    }, 'Please either select a "To Date" or check "I Still Live Here".');

    // Initialize jQuery Validation
    $("#myformLIvedHEre").validate({
        rules: {
            from_date: {
                required: true
            },
            to_date: {
                dateOrLiveHere: true // Applying the custom validation rule
            }
        },
        messages: {
            from_date: {
                required: "From Date is required."
            },
            to_date: {
                dateOrLiveHere: "Please either select a 'To Date' or check 'I Still Live Here'."
            }
        },
        submitHandler: function(form) {
            form.submit(); // Form is valid, submit it
        }
    });
});
</script>
<!-- <script src="https://code.jquery.com/jquery-3.5.0.min.js"></script> -->
<script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>

<!-- bootstrap 3 -->
<link  href="<?php echo ASSETS.'css/x-editable' ?>/bootstrap.css" rel="stylesheet">
<script src="<?php echo ASSETS.'js/x-editable' ?>/bootstrap.js"></script>

<!-- bootstrap-datetimepicker -->
<link href="<?php echo ASSETS.'css/x-editable' ?>/datetimepicker.css" rel="stylesheet">
<script src="<?php echo ASSETS.'js/x-editable' ?>/bootstrap-datetimepicker.js"></script>

<!-- x-editable (bootstrap 3) -->
<link  href="<?php echo ASSETS.'css/x-editable' ?>/bootstrap-editable.css" rel="stylesheet">
<script src="<?php echo ASSETS.'js/x-editable' ?>/bootstrap-editable.js"></script>
<script src="<?php echo ASSETS.'js/x-editable' ?>/demo.js"></script>
<!-- Lightbox Images-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
<script src="<?php echo ASSETS ?>js/jquery.fancybox.min.js"></script>
<!--  -->
<!-- momentjs -->
<script src="https://vitalets.github.io/x-editable/assets/momentjs/moment.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


<?php if ($ga = get_settings('SEO_GOOGLE_ANALYTICS_ID', '')) { ?>
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo htmlspecialchars($ga); ?>"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','<?php echo htmlspecialchars($ga); ?>');</script>
<?php } ?>

<script>
	$('.editablePerson').editable({
		url: '<?php echo base_url('dashboard/updatePerson') ?>',
		validate: function(value) {
			let id = $(this)[0].id;
			if($.trim(value) == '') return 'This field is required';
			console.log(id , value.length);
			if(id == "year_built"){
				if(value.length != 4){
					return 'The year built must be 4 characters.';
				}
				if(parseInt(value) < 1620 || parseInt(value) > <?php echo date("Y",time()) ?>)
				{
					return 'The Year Built must be between 1620 and <?php echo date("Y",time()) ?>>';
				}
			}
			if(id == "zip") {
				if (value.length != 5) {
					return 'This is not valid zipcode.';
				}
				if(!$. isNumeric(value)){
					return 'The zipcode must be numeric.';
				}
			}
		},
		// display: function(value) {
		// 	$(this).text(value + '$');
		// }
	});
	

	$('.editable').editable({
		url: '<?php echo base_url('dashboard/updateInfo') ?>',
		validate: function(value) {
			let id = $(this)[0].id;
			if($.trim(value) == '') return 'This field is required';
			console.log(id +": "+ value.length);
			if(id == "year_built"){
				if(value.length != 4){
					return 'The year built must be 4 characters.';
				}
				if(parseInt(value) < 1620 || parseInt(value) > <?php echo date("Y",time()) ?>)
				{
					return 'The Year Built must be between 1620 and <?php echo date("Y",time()) ?>>';
				}
			}
			if(id == "zip") {
				if (value.length != 5) {
					return 'This is not valid zipcode.';
				}
				if(!$. isNumeric(value)){
					return 'The zipcode must be numeric.';
				}
			}
		},
	});
	$('.editableTimeLine').editable({
		url: '<?php echo base_url('dashboard/updateTimeLineInfo') ?>',
		validate: function(value) {
			let id = $(this)[0].id;
			if($.trim(value) == '') return 'This field is required';
			console.log(id , value.length);
			if(id == "year_built"){
				if(value.length != 4){
					return 'The year built must be 4 characters.';
				}
				if(parseInt(value) < 1620 || parseInt(value) > <?php echo date("Y",time()) ?>)
				{
					return 'The Year Built must be between 1620 and <?php echo date("Y",time()) ?>>';
				}
			}
			if(id == "zip") {
				if (value.length != 5) {
					return 'This is not valid zipcode.';
				}
				if(!$. isNumeric(value)){
					return 'The zipcode must be numeric.';
				}
			}
		},
	});
	$('.editable').on("click",function(){
		let id = $(this)[0].id;

		//if(id == "build_year") {
			$(this).next().find(".editable-input input").addClass(id);
			$(this).next().find(".editable-input select").addClass(id);
		//}
	});


	//----------- Check user locations for near me --------
	function getLocation() {
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(showPosition,showError);

		} else {
			alert("Geolocation is not supported by this browser.");
		}
	}
	function showPosition(position) {
		$("#lat").val(position.coords.latitude);
		$("#lng").val(position.coords.longitude);
		//$('.nearmeform').submit();
		searchLocation();
	}
	function showError(error) {
		switch(error.code) {
			case error.PERMISSION_DENIED:
				alert("Wants to know your location.");
				break;
			case error.POSITION_UNAVAILABLE:
				alert("Location information is unavailable.");
				break;
			case error.TIMEOUT:
				alert("The request to get user location timed out.");
				break;
			case error.UNKNOWN_ERROR:
				alert("An unknown error occurred.");
				break;
		}
	}
	// getLocation();
	function msg(type,msg){
		var html = '';
		if(type == "success"){
			//html +=  '<div class="alert alert-success"  role="alert">'+msg+'<button type="button" style="margin-left: 20px;\n    margin-top: -3px;" class="close" data-dismiss="alert" aria-label="Close">\n    <span aria-hidden="true">&times;</span>\n  </button></div>';
			$(".message-title").text(msg);
			$("#message").modal('show');
			return false;
		}else if(type == "error-popup") {
			$(".error-message-title").text(msg);
			$("#error-message").modal('show');
			return false;
		}else{
			if (type == "error") {
				html += '<div class="alert alert-danger"  role="alert">' + msg + '<button type="button" style="margin-left: 20px;margin-top: -3px;" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
			}
			if (type == "warning") {
				html += '<div class="alert alert-primary" role="alert">' + msg + '<button type="button" style="margin-left: 20px;\n    margin-top: -3px;" class="close" data-dismiss="alert" aria-label="Close">\n    <span aria-hidden="true">&times;</span>\n  </button></div>';
			}
			$('body').before(html);
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
<script>
	jQuery(document).ready(function(){
		jQuery('[data-toggle="tooltip"]').tooltip();
	});
	jQuery(document).ready(function() {
		jQuery('.standard').hover(
				function(){
					jQuery(this).find('.caption').show();
				},
				function(){
					jQuery(this).find('.caption').hide();
				}
		);
		jQuery('.fade').hover(
				function(){
					jQuery(this).find('.caption').fadeIn(250);
				},
				function(){
					jQuery(this).find('.caption').fadeOut(250);
				}
		);
		jQuery('.slide').hover(
				function(){
					jQuery(this).find('.caption').fadeIn(250);
				},
				function(){
					jQuery(this).find('.caption').fadeOut(250);
				}
		);
	});

	$(document).ready(function() {
		window.fbAsyncInit = function() {
			FB.init({
				appId: '720009978624005',
				xfbml: true,
				version: 'v2.4'
			});
		};
		(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) {
				return;
			}
			js = d.createElement(s);
			js.id = id;
			js.src = "//connect.facebook.net/en_US/sdk.js";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
		$('.facebook-share').click(function(e) {
			e.preventDefault();
			url = $(this).attr('url');
			title = $(this).attr('title1');
			picture = $(this).attr('picture');
			caption = $(this).attr('caption');
			desc = $(this).attr('desc');
			msg = $(this).attr('msg');
			FB.ui({
				method: 'feed',
				name: title,
				url: url,
				link: url,
				picture: picture,
				caption: caption,
				description: desc,
				message: msg
			});
		});
		$('.twitter-share').click(function(e) {
			e.preventDefault();
			var url = $(this).attr('data-url');
			window.open("https://twitter.com/share?url=" + url, "_blank");
		});
	});


	<?php if($filename == "nearme" || $filename == "nearmemap" || $filename == "houseshistory"){ ?>
	// Initialize slider:
	$(document).ready(function() {
		$('.noUi-handle').on('click', function() {
			$(this).width(50);
		});
		var rangeSlider = document.getElementById('slider-range');
		if(rangeSlider != null) {
			var moneyFormat = wNumb({
				decimals: 0,
				thousand: ',',
				postfix: 'mi'
			});
			noUiSlider.create(rangeSlider, {
				start: [<?php echo isset($get['minRange'])?(str_replace("mi","",$get['minRange'])):(0); ?>, <?php echo isset($get['maxRange'])?(str_replace("mi","",$get['maxRange'])):(50); ?>],
				step: 1,
				range: {
					'min': [0],
					'max': [50]
				},
				format: moneyFormat,
				connect: true
			});

			// Set visual min and max values and also update value hidden form inputs
			rangeSlider.noUiSlider.on('update', function (values, handle) {
				document.getElementById('slider-range-value1').innerHTML = values[0];
				document.getElementById('slider-range-value2').innerHTML = values[1];

				document.getElementById('minRange').value = values[0];
				document.getElementById('maxRange').value = values[1];

				document.getElementsByName('min-value').value = moneyFormat.from(
						values[0]);
				document.getElementsByName('max-value').value = moneyFormat.from(
						values[1]);
			});
			rangeSlider.noUiSlider.on('change', function(values, handle) {
				searchForm();
			});
		}
	});

	/*---slide 2---*/
	// Requires jQuery

	// Initialize slider:
	$(document).ready(function() {
		$('.noUi1-handle').on('click', function() {
			$(this).width(50);
		});
		var rangeSlider1 = document.getElementById('slider-range1');
		if(rangeSlider1){
			var moneyFormat = wNumb({
				decimals: 0,
			});
			noUi1Slider.create(rangeSlider1, {
				start: [<?php echo isset($get['minRangeYearBuilt'])?($get['minRangeYearBuilt']):(1600); ?>, <?php echo isset($get['maxRangeYearBuilt'])?($get['maxRangeYearBuilt']):(date("Y",time())); ?>],
				step: 1,
				range: {
					'min': [1600],
					'max': [<?php echo date("Y",time()); ?>]
				},
				format: moneyFormat,
				connect: true
			});
			// rangeSlider1.noUiSlider.on("change", searchForm());

			// Set visual min and max values and also update value hidden form inputs
			rangeSlider1.noUi1Slider.on('update', function(values, handle) {
				document.getElementById('slider-range-value11').innerHTML = values[0];
				document.getElementById('slider-range-value22').innerHTML = values[1];
				document.getElementById('minRangeYearBuilt').value = moneyFormat.from(values[0]);
				document.getElementById('maxRangeYearBuilt').value = moneyFormat.from(values[1]);
				// searchForm();
			});
			rangeSlider1.noUi1Slider.on('change', function(values, handle) {
				searchForm();
			});
		}
	});


	// ---- initialize slider for square feet
	// Initialize slider:
	$(document).ready(function() {
		$('.noUi1-handle').on('click', function() {
			//$(this).width(50);
		});
		var rangeSlider1 = document.getElementById('slider-range13');
		if(rangeSlider1){
			var moneyFormat = wNumb({
				decimals: 0,
			});
			noUi1Slider.create(rangeSlider1, {
				start: [<?php echo isset($get['minRangeSquareFeet'])?($get['minRangeSquareFeet']):(1); ?>, <?php echo isset($get['maxRangeSquareFeet'])?(str_replace("+","",$get['maxRangeSquareFeet'])):(10000); ?>],
				step: 1,
				range: {
					'min': [1],
					'max': [10000]
				},
				format: moneyFormat,
				connect: true
			});

			// Set visual min and max values and also update value hidden form inputs
			rangeSlider1.noUi1Slider.on('update', function (values, handle) {
				document.getElementById('slider-range-value13').innerHTML = values[0];
				if(values[1] == 10000) {
					document.getElementById('slider-range-value23').innerHTML = values[1] + "+";
				}else{
					document.getElementById('slider-range-value23').innerHTML = values[1];
				}
				document.getElementById('minRangeSquareFeet').value = moneyFormat.from(
						values[0]);
				if(values[1] == 10000){
					document.getElementById('maxRangeSquareFeet').value = moneyFormat.from(
							values[1]) + "+";
				}else{
					document.getElementById('maxRangeSquareFeet').value = moneyFormat.from(
							values[1]);
				}
			});

			rangeSlider1.noUi1Slider.on('change', function(values, handle) {
				searchForm();
			});
		}
	});
	//------------- end square feet slider
	<?php } ?>
	$( function() {
		var currentTime = new Date()
		var year = currentTime.getFullYear()
		// $( "#datepicker" ).datepicker(
		// 		{
		// 			showAnim: false,
		// 			changeMonth: true,
		// 			changeYear: true,
		// 			yearRange: "1620:" + year
		// 		}
		// );
		// $( "#datepicker2" ).datepicker(
		// 		{
		// 			showAnim: false,
		// 			changeMonth: true,
		// 			changeYear: true,
		// 			yearRange: "1620:" + year
		// 		}
		// );
		// $("#from_Date").datepicker(
		// 		{
		// 			showAnim: false,
		// 			changeMonth: true,
		// 			changeYear: true,
		// 			yearRange: "1620:" + year,
		// 			onClose: function( selectedDate )
		// 			{
		// 				$( "#to_Date" ).datepicker( "option", "minDate", selectedDate );
		// 			}
		// 		}
		// );
		// $("#to_Date").datepicker(
		// 		{
		// 			showAnim: false,
		// 			changeMonth: true,
		// 			changeYear: true,
		// 			yearRange: "1620:" + year,
		// 			onClose: function( selectedDate )
		// 			{
		// 				$( "#from_Date" ).datepicker( "option", "maxDate", selectedDate );
		// 			}
		// 		}
		// );


		$(document).ready(function() {
			var startDateTextBox = $('#datepicker');
			var endDateTextBox = $('#datepicker2');

			startDateTextBox.datepicker({
				dateFormat: 'dd/mm/yy',
				showAnim: false,
				changeMonth: true,
				changeYear: true,
				yearRange: "1620:" + year,
				onSelect: function(selectedDate) {
					var minDate = $(this).datepicker('getDate'); // Get selected start date
					endDateTextBox.datepicker('option', 'minDate', minDate); // Set it as min date for end date
				}
			});

			endDateTextBox.datepicker({
				dateFormat: 'dd/mm/yy',
				showAnim: false,
				changeMonth: true,
				changeYear: true,
				yearRange: "1620:" + year,
				onSelect: function(selectedDate) {
					var maxDate = $(this).datepicker('getDate'); // Optionally, you can handle any maxDate logic here
				}
			});
		});

		$(document).ready(function() {
			var startDateTextBox = $('#datepicker3');
			var endDateTextBox = $('#datepicker4');

			startDateTextBox.datepicker({
				dateFormat: 'dd/mm/yy',
				showAnim: false,
				changeMonth: true,
				changeYear: true,
				yearRange: "1620:" + year,
				onSelect: function(selectedDate) {
					var minDate = $(this).datepicker('getDate'); // Get selected start date
					endDateTextBox.datepicker('option', 'minDate', minDate); // Set it as min date for end date
				}
			});

			endDateTextBox.datepicker({
				dateFormat: 'dd/mm/yy',
				showAnim: false,
				changeMonth: true,
				changeYear: true,
				yearRange: "1620:" + year,
				onSelect: function(selectedDate) {
					var maxDate = $(this).datepicker('getDate'); // Optionally, you can handle any maxDate logic here
				}
			});
		});

		$(document).ready(function() {
			var startDateTextBox = $('#from_Date');
			var endDateTextBox = $('#to_Date');

			startDateTextBox.datepicker({
				dateFormat: 'dd/mm/yy',
				showAnim: false,
				changeMonth: true,
				changeYear: true,
				yearRange: "1620:" + year,
				onSelect: function(selectedDate) {
					var minDate = $(this).datepicker('getDate'); // Get selected start date
					endDateTextBox.datepicker('option', 'minDate', minDate); // Set it as min date for end date
				}
			});

			endDateTextBox.datepicker({
				dateFormat: 'dd/mm/yy',
				showAnim: false,
				changeMonth: true,
				changeYear: true,
				yearRange: "1620:" + year,
				onSelect: function(selectedDate) {
					var maxDate = $(this).datepicker('getDate'); // Optionally, you can handle any maxDate logic here
				}
			});
		});

		// $( "#datepicker3" ).datepicker(
		// 		{
		// 			showAnim: false,
		// 			changeMonth: true,
		// 			changeYear: true,
		// 			yearRange: "1620:" + year
		// 		}
		// );
		// $( "#datepicker4" ).datepicker(
		// 		{
		// 			showAnim: false,
		// 			changeMonth: true,
		// 			changeYear: true,
		// 			yearRange: "1620:" + year
		// 		}
		// );

		$("input[name='lived_here']").on("click",function(){
			if($(this).val() == 1){
				$("#showDates").removeClass("hide");
				$("#datepicker").val("");
				$("#datepicker2").val("");
			}else{
				$("#datepicker").val("");
				$("#datepicker2").val("");
				$("#showDates").addClass("hide");
			}
		});

		$("input[name='user_lived_here']").on("click",function(){
			if($(this).val() == 1){
				$("#showDates").removeClass("hide");
				$("#datepicker2").val("");
			}else{
				$("#datepicker2").val("");
				$("#showDates").addClass("hide");
			}
		});
	} );

</script>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" style="left:0%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalLabel">Laravel Cropper Js - Crop Image Before Upload - Tutsmake.com</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="img-container">
					<div class="row">
						<div class="col-md-8">
							<img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
						</div>
						<div class="col-md-4">
							<div class="preview"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-primary" id="crop">Crop</button>
			</div>
		</div>
	</div>
</div>
<script>
	var $modal = $('#modal');
	var image = document.getElementById('image');
	var cropper;
	$("body").on("change", ".image", function(e){
		var files = e.target.files;
		var done = function (url) {
			image.src = url;
			$modal.modal('show');
		};
		var reader;
		var file;
		var url;
		if (files && files.length > 0) {
			file = files[0];
			if (URL) {
				done(URL.createObjectURL(file));
				if($(this).data('id') != undefined){
					$("#crop").attr("data-id",$(this).data('id'));
				}
			} else if (FileReader) {
				reader = new FileReader();
				reader.onload = function (e) {
					done(reader.result);
					if($(this).data('id') != undefined){
						$("#crop").attr("data-id",$(this).data('id'));
					}
				};
				reader.readAsDataURL(file);
			}
		}
	});
	$modal.on('shown.bs.modal', function () {
		cropper = new Cropper(image, {
			aspectRatio: 0,
			viewMode: 1,
			preview: '.preview'
		});
	}).on('hidden.bs.modal', function () {
		cropper.destroy();
		cropper = null;
	});
	$("#crop").click(function(){
		canvas = cropper.getCroppedCanvas({
			width: 250,
			height: 250,
		});
		canvas.toBlob(function(blob) {
			url = URL.createObjectURL(blob);

			//let dataId = (this.id )?():();
			var reader = new FileReader();
			reader.readAsDataURL(blob);
			reader.onloadend = function() {
				var base64data = reader.result;
				var dataID = '';

				if($("#crop").attr('data-id') != undefined){
					dataID = $("#crop").attr('data-id');
				}
				console.log("dataID: ",dataID);

				<?php if($filename == "dashboard/viewPeople"){
					$url = 	base_url('dashboard/upload_person_image');
				}else{
					$url = 	base_url('dashboard/upload_image');

				} ?>
				$.ajax({
					type: "POST",
					dataType: "json",
					url: "<?php echo $url; ?>?dataid="+dataID,
					data: {'image': base64data},
					success: function(data){
						console.log(data);
						//var result = JSON.parse(data);
						$modal.modal('hide');
						alert("image successfully uploaded");
						if(data.uploadPath != undefined){
							$(".home_profile_photo").val(data.uploadPath);
						}
						$(".thumbnail"+dataID).attr("src",data.profile_photo);
						// $(".profile_image_preview").attr("src",data.profile_photo);
					}
				});
			}
		});
	});
	$(document).on("click",".editablePersondcdcdc",function(){
		return false;
	});
</script>
<script>
	jQuery('.houseslide').hover(
			function(){
				if(jQuery(this).find('.caption').html() == ""){
					jQuery(this).find('.caption').html('<img src="<?php echo ASSETS; ?>images/loader.gif" width="16" height="16" style="margin:auto; width:16px;height:16px;">');
					var id = jQuery(this).find('.caption').data("id");
					var selector = jQuery(this).find('.caption');
					var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
   					var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

					jQuery.ajax({
						url:"<?php echo base_url('home/getPopupData/'); ?>"+id,
						type:"post",
						data:{
							[csrfName]: csrfHash

						},
						dataType: "html",
						success:function(data){
							selector.html(data);
						}
					});
					jQuery(this).find('.caption').fadeIn(250);
				}else{
					jQuery(this).find('.caption').fadeIn(250);
				}
			},
			function(){
				jQuery(this).find('.caption').fadeOut(250);
			}
	);
	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				$('.showImagePreview').attr('src', e.target.result);
				$(".showImagePreview").removeClass('hide');
			}

			reader.readAsDataURL(input.files[0]);
		}
	}

	$(".showImage").change(function(){
		readURL(this);
	});

</script>


<script type="text/javascript">
	$(document).keydown(function(event) {
if (event.ctrlKey==true && (event.which == '61' || event.which == '107' || event.which == '173' || event.which == '109'  || event.which == '187'  || event.which == '189'  ) ) {
        event.preventDefault();
     }
    // 107 Num Key  +
    // 109 Num Key  -
    // 173 Min Key  hyphen/underscor Hey
    // 61 Plus key  +/= key
});

$(window).bind('mousewheel DOMMouseScroll', function (event) {
       if (event.ctrlKey == true) {
       event.preventDefault();
       }
});

// Delete Button



	$(document).ready(function() {
      // Corrected the selector
      $('.houseDelBtn').on('click', function() {
        // Ensure the correct attribute name
        let id = this.id;

        if (typeof id !== "undefined") {
          Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true,
            customClass: {
              confirmButton: 'btn btn-success ml-5',
              cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = "<?php echo base_url('dashboard/deleteProperty/'); ?>" + id;
            }
          });
        } else {
          console.error("ID is undefined.");
        }
      });
    });


	$(document).on("change",".updateStatus",function(){
		let id = this.id;
		let status = this.value;
		$.ajax({
			url:"<?php echo base_url('dashboard/updatePropertyStatus/'); ?>",
			type:"post",
			data:{id:id,status:status},
			success:function(res){
				response = JSON.parse(res);
				if(response.status == 'success'){
					Swal.fire({
						position: "center",
						icon: "success",
						title: response.message,
						showConfirmButton: false,
						timer: 1500
					});
				}else{
					Swal.fire({
						icon: "error",
						title: "Oops...",
						title: response.message,
						footer: '<a href="javascript:void(0)">Why do I have this issue?</a>'
					});
				}

			}
		});
	});

</script>
