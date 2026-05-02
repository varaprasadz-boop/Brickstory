<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function maintenance_mode_check() {
	$ci =& get_instance();
	if (is_cli()) {
		return;
	}
	$uri = trim($ci->uri->uri_string(), '/');
	$adminSegment = trim(get_settings('SYSTEM_ADMIN_URL_SEGMENT', 'brickstoryadmin'), '/');
	if ($adminSegment !== '' && strpos($uri, $adminSegment) === 0) {
		return;
	}
	if (get_settings('SYSTEM_MAINTENANCE_MODE', '0') === '1') {
		$ci->load->view('errors/maintenance', array(
			'message' => get_settings('SYSTEM_MAINTENANCE_MESSAGE', 'We are performing scheduled maintenance. Please check back shortly.')
		));
		exit;
	}
}
