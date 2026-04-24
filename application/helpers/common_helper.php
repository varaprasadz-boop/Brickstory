<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 2/8/2020
 * Time: 2:17 AM
 */

function generateRandomString($length = 10) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}
function pre($data,$die=1){
	echo '<pre>';
	print_r($data);
	echo '</pre>';

	if($die == 1){
		die();
	}
}
function json($status,$message,$data){
	$info['status'] = $status;
	$info['message'] = $message;
	$info['data'] = $data;
	die(json_encode($info));
}

 function saveBase64Image($base64String, $uploadPath) {
	// Check if base64 string contains the correct data prefix
	if (preg_match('/^data:image\/(\w+);base64,/', $base64String, $type)) {
		// Remove the base64 prefix
		$base64String = substr($base64String, strpos($base64String, ',') + 1);
		// Get the file extension
		$extension = strtolower($type[1]); // jpg, png, gif, etc.

		// Decode the base64 string
		$data = base64_decode($base64String);

		// Check if decoding was successful
		if ($data === false) {
			throw new Exception('Base64 decode failed.');
		}

		// Generate a unique file name
		$uniqueName = uniqid('img_', true) . '.' . $extension;

		// Ensure the upload path exists
		if (!is_dir($uploadPath)) {
			mkdir($uploadPath, 0755, true);
		}

		// Create the full file path
		$filePath = $uploadPath . '/' . $uniqueName;
		// $filePath =  $uniqueName;

		// Save the binary data to a file
		if (file_put_contents($filePath, $data) === false) {
			throw new Exception('Failed to write image file.');
		}

		return $uniqueName;
	} else {
		throw new Exception('Invalid data URL.');
	}
}

function dd($data,$die=1){

	echo '<pre>';
	print_r($data);
	echo '</pre>';
	if($die == 1){
		die();
	}
}

function read_set_json_data(){
	  // Read the raw POST data
	  $ci =& get_instance();

	  $json = file_get_contents('php://input');

	  // Decode the JSON data into a PHP array
	  $data = json_decode($json, true);

	  if (json_last_error() !== JSON_ERROR_NONE) {
		  // Handle JSON decode error
		  $response = array('status' => 'error', 'message' => 'Invalid JSON format.');
		  $ci->output
			  ->set_content_type('application/json')
			  ->set_output(json_encode($response));
		  return;
	  }

	  // Set validation rules
	  $ci->form_validation->set_data($data);
	  return $data;
}

function post($name=''){
	$ci =& get_instance();
	if($name == '') {
		return $ci->input->post();
	}else{
		return trim(strip_tags($ci->input->post($name)));
	}
}
function get($name=''){
	$ci =& get_instance();
	if($name == '') {
		return $ci->input->get();
	}else{
		return trim(strip_tags($ci->input->get($name)));
	}
}
function fv($name='',$label='',$rules=''){
	$ci =& get_instance();
	return $ci->form_validation->set_rules($name,$label,$rules);
}
function query($die=1,$return=0){
	$ci =& get_instance();
	if($return == 1){
		return $ci->db->last_query();
	}else{
		echo $ci->db->last_query();
	}
	if($die == 1){
		die();
	}
}
if(!function_exists('csrf')){
	function csrf(){
		$ci =& get_instance();
		echo '<input type="hidden" name="'.$ci->security->get_csrf_token_name().'" value="'.$ci->security->get_csrf_hash().'">';
	}
}
if(!function_exists('ng_csrf')){
	function ng_csrf(){
		$ci =& get_instance();
		echo '<input type="hidden" ng-model="formModel.'.$ci->security->get_csrf_token_name().'" name="'.$ci->security->get_csrf_token_name().'" value="'.$ci->security->get_csrf_hash().'">';
	}
}
if(!function_exists('ajax_csrf')){
	function ajax_csrf(){
		$ci =& get_instance();
		echo "'".$ci->security->get_csrf_token_name()."':'".$ci->security->get_csrf_hash()."'";
	}
}
if(!function_exists('js_msg')) {
	function js_msg()
	{
		$ci =& get_instance();
		if($ci->session->flashdata("success")){
			echo 'msg("success","'.$ci->session->flashdata("success").'")';
		}
		if($ci->session->flashdata("error")){
			echo 'msg("error","'.$ci->session->flashdata("error").'")';
		}
		if($ci->session->flashdata("error-popup")){
			echo 'msg("error-popup","'.$ci->session->flashdata("error-popup").'")';
		}
		if($ci->session->flashdata("warning")){
			echo 'msg("warning","'.$ci->session->flashdata("warning").'")';
		}
		// Clear all flashdata
		$flashdata = @$ci->session->flashdata();
		if ($flashdata) {
			foreach ($flashdata as $key => $value) {
				// if (strpos($key, 'flash') !== false) {
					$ci->session->unset_userdata($key);
				// }
			}
		}
	}
}
if(!function_exists('show_msg')) {
	function show_msg()
	{
		$ci =& get_instance();
		if($ci->session->flashdata("success")){
			echo '<div class="alert alert-success" style="position: fixed;top: 5px;z-index: 9999;right: 5px;" role="alert">
              '.$ci->session->flashdata("success").'
            </div>';
		}
		if($ci->session->flashdata("error")){
			echo '<div class="alert alert-danger" style="position: fixed;top: 5px;z-index: 9999;right: 5px;" role="alert">
              '.$ci->session->flashdata("error").'
            </div>';
		}
		if($ci->session->flashdata("warning")){
			echo '<div class="alert alert-primary" style="position: fixed;top: 5px;z-index: 9999;right: 5px;" role="alert">
              '.$ci->session->flashdata("warning").'
            </div>';
		}

	}
}

if(!function_exists('show_msg1')) {
	function show_msg1()
	{
		$ci =& get_instance();
		if($ci->session->flashdata("success")){
			echo '<div class="alert alert-success" style="" role="alert">
              '.$ci->session->flashdata("success").'
            </div>';
		}
		if($ci->session->flashdata("error")){
			echo '<div class="alert alert-danger" style="" role="alert">
              '.$ci->session->flashdata("error").'
            </div>';
		}
		if($ci->session->flashdata("warning")){
			echo '<div class="alert alert-primary" style="" role="alert">
              '.$ci->session->flashdata("warning").'
            </div>';
		}

	}
}
if(!function_exists('set_msg')) {
	function set_msg($type,$msg)
	{
		$ci =& get_instance();
		$ci->session->set_flashdata($type,$msg);
	}
}
if(!function_exists('loggedin_user')){
	function loggedin_user($user_id=''){
		$ci =& get_instance();
		if($user_id == '') {
			$user_id = $ci->session->userdata('user_id');
		}
		$result = $ci->sqlmodel->getSingleRecord('users',array('id' => $user_id));

		return $result;
	}
}
if(!function_exists('admin_loggedin_user')){
	function admin_loggedin_user(){
		$ci =& get_instance();
		$user_id = $ci->session->userdata('admin_user_id');
		$result = $ci->sqlmodel->getSingleRecord('users',array('id' => $user_id));

		return $result;
	}
}
if(!function_exists('check_auth')){
	function check_auth(){
		$ci =& get_instance();
		if($ci->session->userdata('user_id') == false){
			$ci->session->set_userdata("returnUrl",base_url($ci->uri->uri_string));
			redirect('/account/login');
		}
	}
}
if(!function_exists('check_auth_session')){
	function check_auth_session(){
		$ci =& get_instance();
		return $ci->session->userdata('user_id');
	}
}
if(!function_exists('check_admin_auth')){
	function check_admin_auth(){
		$ci =& get_instance();

		if($ci->session->userdata('admin_user_id') == false){
			redirect(ADMIN_URL.'/login');
		}
	}
}
if(!function_exists('is_admin')){
	function is_admin(){
		$ci =& get_instance();
		return $ci->session->userdata('admin_user_id');
	}
}
// show messages
if(!function_exists('msg')) {
	function msg()
	{
		$ci =& get_instance();
		if($ci->session->flashdata("success")){
			echo '<div class="alert alert-success" style="position: fixed;top: 5px;z-index: 9999;right: 5px;" role="alert">
              '.$ci->session->flashdata("success").'
            </div>';
		}
		if($ci->session->flashdata("error")){
			echo '<div class="alert alert-danger" style="position: fixed;top: 5px;z-index: 9999;right: 5px;" role="alert">
              '.$ci->session->flashdata("error").'
            </div>';
		}
		if($ci->session->flashdata("warning")){
			echo '<div class="alert alert-primary" style="position: fixed;top: 5px;z-index: 9999;right: 5px;" role="alert">
              '.$ci->session->flashdata("warning").'
            </div>';
		}

	}
}
 function resize($image,$path)
{
	$ci =& get_instance();

	$config['image_library'] = 'gd2';
	$config['source_image'] = $image;
	$config['new_image'] = $path;
	$config['create_thumb'] = FALSE;
	$config['maintain_ratio'] = TRUE;
//	$config['thumb_marker'] = '_thumb';
	$config['width'] = 230;
	$config['height'] = 155;
	$config['quality'] = 100;
	$config['master_dim'] = 'width';
	$ci->load->library('image_lib', $config);
	$ci->image_lib->resize();
}
if(!function_exists('do_upload')){
	function do_upload($name='img',$path = '',$multiple=false)
	{
		$ci =& get_instance();
		if($path == ''){
			$config['upload_path'] = './assets/uploads/';
		}else{
			$config['upload_path'] = $path;
		}
		$config['allowed_types'] = 'gif|jpg|PNG|jpeg|png|webp';
//        $config['max_size'] = '100';
//        $config['max_width'] = '1024';
//        $config['max_height'] = '768';
		$config['overwrite'] = FALSE;
		$config['encrypt_name'] = TRUE;
		$config['remove_spaces'] = TRUE;
		if (!is_dir($config['upload_path'])) die("THE UPLOAD DIRECTORY DOES NOT EXIST");
		$ci->load->library('upload', $config);
		if ($multiple != true) {
			if(!$ci->upload->do_upload($name)) {
//            pre($ci->upload->error_msg);
				return 'error';
			}else{
				$filename = $_FILES[$name]['name'];
				// Valid extension
				$valid_ext = array('png', 'jpeg', 'jpg','PNG');
				// Location
				$location = $path.'/crop/' . $ci->upload->data()['file_name'];
				// file extension
				$file_extension = pathinfo($location, PATHINFO_EXTENSION);
				$file_extension = strtolower($file_extension);
				// Check extension
				if (in_array($file_extension, $valid_ext)) {
					// Compress Image
					compressImage($config['upload_path'] . $ci->upload->data()['file_name'], $location, 60);
					resize($config['upload_path'] . $ci->upload->data()['file_name'],$location);

				}
				return array('upload_data' => $ci->upload->data());
			}
		} else {

			if($multiple == true){
				// Getting file name
				$filename = $_FILES[$name]['name'];
				// Valid extension
				$valid_ext = array('png', 'jpeg', 'jpg');
				// Location
				$cpt = count($_FILES[$name]['name']);
				$files = $_FILES;

				for($i=0; $i<$cpt; $i++)
				{
					$_FILES['userfile']['name']= $files[$name]['name'][$i];
					$_FILES['userfile']['type']= $files[$name]['type'][$i];
					$_FILES['userfile']['tmp_name']= $files[$name]['tmp_name'][$i];
					$_FILES['userfile']['error']= $files[$name]['error'][$i];
					$_FILES['userfile']['size']= $files[$name]['size'][$i];
					$ci->upload->do_upload();

					$location = './assets/uploads/compressed/' . $ci->upload->data()['file_name'];
					// file extension
					$file_extension = pathinfo($location, PATHINFO_EXTENSION);
					$file_extension = strtolower($file_extension);
					// Check extension
					if (in_array($file_extension, $valid_ext)) {
						// Compress Image
						compressImage($config['upload_path'] . $ci->upload->data()['file_name'], $location, 60);
					} else {
						return "error";
					}

					$dataInfo[] = $ci->upload->data();
				}
				return $dataInfo;
			}else {
				// Getting file name
				$filename = $_FILES[$name]['name'];
				// Valid extension
				$valid_ext = array('png', 'jpeg', 'jpg');
				// Location
				$location = './assets/uploads/compressed/' . $ci->upload->data()['file_name'];
				// file extension
				$file_extension = pathinfo($location, PATHINFO_EXTENSION);
				$file_extension = strtolower($file_extension);
				// Check extension
				if (in_array($file_extension, $valid_ext)) {

					// Compress Image

					compressImage($config['upload_path'] . $ci->upload->data()['file_name'], $location, 60);

				} else {
					return "error";
				}
				return array('upload_data' => $ci->upload->data());
			}
		}
	}
}
// Compress image
function compressImage($source, $destination, $quality) {
	$info = getimagesize($source);

	if ($info['mime'] == 'image/jpeg')
		$image = imagecreatefromjpeg($source);

	elseif ($info['mime'] == 'image/gif')
		$image = imagecreatefromgif($source);

	elseif ($info['mime'] == 'image/png')
		$image = imagecreatefrompng($source);

	imagejpeg($image, $destination, $quality);

}
if(!function_exists('add_settings')){
	function add_settings($key,$value){
		$ci =& get_instance();
		return $ci->sqlmodel->insertRec('settings',array('key' => $key,'value' => $value));
	}
}
if(!function_exists('update_settings')){
	function update_settings($key,$value){
		$ci =& get_instance();
		return $ci->sqlmodel->updateRec('settings',array('value' => $value),array('key' => $key));
	}
}
if(!function_exists('get_banner')){
	function get_banner($section_id,$title){
		$ci =& get_instance();
		$result = $ci->sqlmodel->getSingleRecord('advertisement',array('section_id' => $section_id,'status' =>1));
		if($result){
			return $result['image_url'];
		}else{
			return '';
		}
	}
}

if(!function_exists('get_banners')){
	function get_banners($section_id,$title){
		$ci =& get_instance();
		$result = $ci->sqlmodel->getRecords('*, CONCAT("'.base_url('assets/uploads/banner_ad_images/crop/').'",image_url) as image_url','advertisement','','',array('section_id' => $section_id,'status' =>1));
		if($result){
			return $result;
		}else{
			return '';
		}
	}
}
if(!function_exists('get_settings')){
	function get_settings($key){
		$ci =& get_instance();
		$result = $ci->sqlmodel->getSingleRecord('settings',array('setting_label' => $key));
		if($result){
			return $result['setting_value'];
		}else{
			return '';
		}
	}
}
if(!function_exists('get_categories')){
	function get_categories(){
		$ci =& get_instance();
		$categories = $ci->sqlmodel->runQuery('select * from category where status = 1');
		if($categories){
			return $categories;
		}else{
			return false;
		}
	}
}

if(!function_exists('get_vendors')){
	function get_vendors(){
		$ci =& get_instance();
		$vendors = $ci->sqlmodel->runQuery('select id,org_name,vendor_code from users where status=1 and org_type!="Admin" and sub_type != "employee"');
		if($vendors){
			return $vendors;
		}else{
			return false;
		}
	}
}
if(!function_exists('catalogue_images')){
	function catalogue_images($catalogue_id,$api=false){
		$ci =& get_instance();
		$query = 'select *';
		if($api == true) {
			$query .= ', CONCAT("' . ASSETS . 'uploads/compressed/",image) as image ';
		}
		$query .= ' from catalogue_images where catalogue_id='.$catalogue_id;
		$catalogue_images = $ci->sqlmodel->runQuery($query);
		if($catalogue_images){
			return $catalogue_images;
		}else{
			return false;
		}
	}
}
if(!function_exists('catalogue_options')){
	function catalogue_options($catalogue_id,$api = false){
		$ci =& get_instance();
		$query = 'select * ';
		if($api == true) {
			$query .= ', CONCAT("' . ASSETS . 'uploads/compressed/",image) as image ';
		}else{
			$query .= '';
		}
		$query .=' from catalogue_options where catalogue_id='.$catalogue_id;
		$catalogue_options = $ci->sqlmodel->runQuery($query);
		if($catalogue_options){
			return $catalogue_options;
		}else{
			return false;
		}
	}
}
if(!function_exists('get_catalogue')){
	function get_catalogue($catalogue_id,$api=false){
		$ci =& get_instance();
		$query = 'select size_ratio,set_by_color,user_id,design_code,price,discounted_price,';
		if($api == true) {
			$query .= '(select CONCAT("' . ASSETS . 'uploads/compressed/",image) as image';
		}else{
			$query .= '(select image ';
		}
		$query .=' from catalogue_images where catalogue_id =catalogue.id limit 1 ) as image from catalogue where id='.$catalogue_id;
		$catalogue = $ci->sqlmodel->runQuery($query,1);
		if($catalogue){
			return $catalogue;
		}else{
			return false;
		}
	}
}
if(!function_exists('write_logs')){
	function write_logs($array){
		//Encode the array into a JSON string.
		foreach($array as $key => $val){

			if(is_array($val)){
				foreach($val as $k => $v){
					if(is_array($v)){

						foreach($v as $k1 => $v1){
							if(is_array($v1)){
								foreach($v1 as $k2 => $v2){
									file_put_contents('json_array.txt', $k2.": ".serialize($v2)."\n\r",FILE_APPEND);
								}
							}else{
								file_put_contents('json_array.txt', $key.': '.$k.': '.$k1.": ".$v1."\n\r",FILE_APPEND);

							}
						}

					}else{
						file_put_contents('json_array.txt', $key.': '.$k.": ".$v."\n\r",FILE_APPEND);

					}
				}
			}else{
				file_put_contents('json_array.txt', $key.": ".$val."\n\r",FILE_APPEND);
			}
		}

//Save the JSON string to a text file.


	}


	if(!function_exists('do_upload_base64')){
		function do_upload_base64($name='image'){

			// Extract base64 file for standard data
			$exp = explode(";base64",$name);

			$fileBin = file_get_contents($name);
			// $mimeType = mime_content_type($val);
			$name = time().generateRandomString(10);
			$ext = '';
			// Check allowed mime type
			if ('data:image/png'==$exp[0]) {
				$ext = '.png';
				file_put_contents('./assets/uploads/'.$name.'.png', $fileBin);
			}
			if ('data:image/jpg'==$exp[0]) {
				$ext = '.jpg';
				file_put_contents('./assets/uploads/'.$name.'.jpg', $fileBin);
			}
			if ('data:image/jpeg'==$exp[0]) {
				$ext = '.jpeg';
				file_put_contents('./assets/uploads/'.$name.'.jpeg', $fileBin);
			}
			//------------------------------
			$location = './assets/uploads/compressed/'.$name.$ext;
			compressImage('./assets/uploads/'.$name.$ext, $location, 60);

			return $name.$ext;

		}
	}
}


function formatPhoneNumber_api($phone) {
	// Remove non-numeric characters except "+"
	$digits = preg_replace('/[^\d]/', '', $phone);

	// Check if the number has 10 digits (standard US format without country code)
	if (strlen($digits) === 10) {
		// Format to +1-XXX-XXX-XXXX
		return '+1-' . substr($digits, 0, 3) . '-' . substr($digits, 3, 3) . '-' . substr($digits, 6, 4);
	} elseif (strlen($digits) === 11 && $digits[0] === '1') {
		// If the number starts with 1, reformat it
		return '+1-' . substr($digits, 1, 3) . '-' . substr($digits, 4, 3) . '-' . substr($digits, 7, 4);
	} else {
		return 'error';
	}
}

if(!function_exists('check_sms_per_day')){
	function check_sms_per_day($phone){
		$ci =& get_instance();
		return $ci->sqlmodel->countRecords('sms_histrory',array("phone_number"=>$phone,'DATE(created_at)' => date("Y-m-d")));
	}
}

if(!function_exists('save_sms_detail')){
	function save_sms_detail($phone,$text,$status){
		$ci =& get_instance();
		$ci->sqlmodel->insertRecord('sms_histrory',
	array(
		'phone_number' => $phone,
		'msg' => $text,
		'status' => $status
	));
	}
}

if(!function_exists('send_email')){
	function send_email($input){

		$ci =& get_instance();
		if(isset($input['contactus'])){
			$email['to'] = 'admin@brickstory.com';
		}else{
			$email['to'] = $input['email'];
		}
		$input['year'] = date("Y",time());
		$input['site_name'] = get_settings('SITE_NAME');
		$email['email_data'] = $input;

		$data = $input;
		$data['emailContent'] = $input['emailContent'];
		$template = $ci->load->view($input['template_path'],$data,true);

		$temp = $ci->parser->parse_string($template, $email['email_data']);
		$ci->load->library('email');
		// dd($ci->config->item('email'));
		// $config = array(
		// 	'protocol' => 'smtp',
		// 	'smtp_host' => 'smtp.gmail.com',
		// 	'smtp_port' => 587,
		// 	'smtp_user' => 'asifahmed715@gmail.com', // Change this to your Gmail address
		// 	'smtp_pass' => 'cxzyjhyaxqfogwlh',        // Change this to your Gmail password
		// 	'mailtype'  => 'html',
		// 	'charset'   => 'iso-8859-1',
		// 	'wordwrap'  => TRUE
		// );
		// $config = array(
        //     'protocol' => 'smtp',
        //     'smtp_host' => 'smtp.gmail.com',
        //     'smtp_port' => 587,
        //     'smtp_user' => 'asifahmed715@gmail.com', // Change this to your Gmail address
		// 	'smtp_pass' => 'cxzyjhyaxqfogwlh',
        //     'smtp_crypto' => 'tls', // or 'ssl' for port 465
        //     'mailtype'  => 'html',
        //     'charset'   => 'utf-8',
        //     'wordwrap'  => TRUE,
        //     'newline'   => "\r\n",
        //     'crlf'      => "\r\n"
        // );

		$config = array(
			'protocol' => 'smtp',
			'smtp_host' => 'mail.brickstory.com',
			'smtp_port' => 465,
			'smtp_user' => 'no-reply@brickstory.com', // Change this to your Gmail address
			'smtp_pass' => 'Brickstory@123',        // Change this to your Gmail password
			'mailtype'  => 'html',
			'charset'   => 'iso-8859-1',
			'wordwrap'  => TRUE,
			'newline'   => "\r\n",
            'crlf'      => "\r\n"
		);
		$ci->email->initialize($config);

		$config['mailtype'] = 'html';
		$ci->email->initialize($config);
		$ci->email->to($email['to']);
		$ci->email->from(CONFIG_EMAIL,'BrickStory');
//		$ci->email->from(get_settings('SITE_FROM_EMAIL'),'BrickStory');
		$ci->email->subject($input['subject']);
		$ci->email->message($temp);

		 // Send the email and check for errors
		 if ($ci->email->send()) {
            return 'Email sent successfully!';
        } else {
            return $ci->email->print_debugger();
        }
	}
}
if(!function_exists('permission')){
	function permission($permission=''){
		$ci =& get_instance();
		if($ci->session->userdata("admin_user_id")){
			$user_info = admin_loggedin_user();
		}else if($ci->session->userdata("user_id")){
			$user_info = loggedin_user();
		}

		if($user_info['user_type'] == "vendor" && $user_info['sub_type'] != "Admin"){
			if(strstr($user_info['permission'],$permission) == true){
				return true;
			}else{
				return false;
			}
		}else{
			return true;
		}
	}
}

function encriptsha1($string = "") {
	$CI = & get_instance();
//	return $CI->encryption->encrypt($string);
	return sha1($string);

//	return md5($string);
}
function decryptsha1($string = "") {
	$CI = & get_instance();
	return $CI->encryption->decrypt($string);
}

function role_list()
{
	$CI = & get_instance();

	$CI->db->select("id,role_name");
	$CI->db->from('roles');
	$CI->db->where('status', 1);
	$CI->db->where('id', 2);
	$CI->db->order_by('role_name','asc');
	$result = $CI->db->get();

	if($result->num_rows() > 0)
	{
		$result = $result->result_array();
		foreach ($result as $role)
		{
			$roles[$role['id']] = $role['role_name'];
		}
		return $roles;
	}
	else
	{
		return NULL;
	}
}

function get_dropdown_value($type) {

	$ci =& get_instance();
	$ci->db->select('id,value');
	$ci->db->from("brickstory_dropdown_value");
	$ci->db->where('type', $type);
	$ci->db->order_by("value", "asc");
	$query = $ci->db->get();

	$array = array();
	foreach ($query->result() as $key => $value) {
		$array[$value->id] = $value->value;
	}

	return $array;
}
if ( ! function_exists('state_array')) {
	function state_array() {
		$state_list = array(
			'AL' => 'Alabama',
			'AK' => 'Alaska',
			'AZ' => 'Arizona',
			'AR' => 'Arkansas',
			'CA' => 'California',
			'CO' => 'Colorado',
			'CT' => 'Connecticut',
			'DE' => 'Delaware',
			'DC' => 'District Of Columbia',
			'FL' => 'Florida',
			'GA' => 'Georgia',
			'HI' => 'Hawaii',
			'ID' => 'Idaho',
			'IL' => 'Illinois',
			'IN' => 'Indiana',
			'IA' => 'Iowa',
			'KS' => 'Kansas',
			'KY' => 'Kentucky',
			'LA' => 'Louisiana',
			'ME' => 'Maine',
			'MD' => 'Maryland',
			'MA' => 'Massachusetts',
			'MI' => 'Michigan',
			'MN' => 'Minnesota',
			'MS' => 'Mississippi',
			'MO' => 'Missouri',
			'MT' => 'Montana',
			'NE' => 'Nebraska',
			'NV' => 'Nevada',
			'NH' => 'New Hampshire',
			'NJ' => 'New Jersey',
			'NM' => 'New Mexico',
			'NY' => 'New York',
			'NC' => 'North Carolina',
			'ND' => 'North Dakota',
			'OH' => 'Ohio',
			'OK' => 'Oklahoma',
			'OR' => 'Oregon',
			'PA' => 'Pennsylvania',
			'RI' => 'Rhode Island',
			'SC' => 'South Carolina',
			'SD' => 'South Dakota',
			'TN' => 'Tennessee',
			'TX' => 'Texas',
			'UT' => 'Utah',
			'VT' => 'Vermont',
			'VA' => 'Virginia',
			'WA' => 'Washington',
			'WV' => 'West Virginia',
			'WI' => 'Wisconsin',
			'WY' => 'Wyoming'
		);

		return $state_list;
	}
}

function get_random_string($length = 8)
{
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$string = '';

	for ($i = 0; $i < $length; $i++)
	{
		$string .= $characters[mt_rand(0, strlen($characters) - 1)];
	}

	return $string;
}

if ( ! function_exists('now'))
{
	function now()
	{
		$CI =& get_instance();

		if (strtolower($CI->config->item('time_reference')) == 'gmt')
		{
			$now = time();
			$system_time = mktime(gmdate("H", $now), gmdate("i", $now), gmdate("s", $now), gmdate("m", $now), gmdate("d", $now), gmdate("Y", $now));

			if (strlen($system_time) < 10)
			{
				$system_time = time();
			}

			return $system_time;
		}
		else
		{
			return time();
		}
	}
}

function getRelations(){
	$ci =& get_instance();
	$ci->db->select('id,value');
	$ci->db->from("brickstory_dropdown_value");
	$ci->db->where('type', 'relation');
	$ci->db->order_by('value', 'asc');
	$query = $ci->db->get();

	$array = array();
	foreach ($query->result() as $key => $value) {
		$array[$value->id] = $value->value;
	}

	return $array;
}

function getHomeDetails($id){
	$ci =& get_instance();
	$ci->db->select('R.*,
	D1.value as house_style_value,
	D2.value as material_value,
	D3.value as roof_value,
	D4.value as foundation_value,
	D5.value as bedroom_value');
	$ci->db->from('brickstory_profile  as R');
	$ci->db->join('brickstory_dropdown_value as D1', 'R.house_style_id = D1.id', 'left');
	$ci->db->join('brickstory_dropdown_value as D2', 'R.material_id = D2.id', 'left');
	$ci->db->join('brickstory_dropdown_value  as D3', 'R.roof_id = D3.id', 'left');
	$ci->db->join('brickstory_dropdown_value as D4', 'R.foundation_id = D4.id', 'left');
	$ci->db->join('brickstory_dropdown_value as D5', 'R.bedroom_id = D5.id', 'left');
	$ci->db->where('R.id', $id);

	return $ci->db->get()->row_array();
}

function GetCurrentDateTime() {
	return date("Y-m-d H:i:s");
}
