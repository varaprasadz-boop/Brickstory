<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

// header('Access-Control-Allow-Origin: *');
// header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
// header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");

$allowedOrigins = [
    'https://brickstory.com',
    'https://www.brickstory.com/',
    'https://app.yourdomain.com',
    'http://localhost:3000', // dev only
];

$origin = $_SERVER['HTTP_ORIGIN'] ?? '';

if (in_array($origin, $allowedOrigins)) {
    header("Access-Control-Allow-Origin: $origin");
    header("Access-Control-Allow-Credentials: true");
}

header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Handle preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

class HomeService extends CI_Controller {


	
    public function __construct() {
        parent::__construct();
		$this->load->library('twilio_lib');

    }

    public function get_params(){
        $data['bedroom'] = array(
            "1",
            "2",
            "3",
            "4",
            "5",
            "6",
            "7",
            "8",
            "9",
            "10+",
        );
        $data['house_style'] = get_dropdown_value('house_style');
        $data['material'] = get_dropdown_value('material');
        $data['foundation'] = get_dropdown_value('foundation');
		$data['roof'] = get_dropdown_value('roof');
        $data['events'] = get_dropdown_value('event');
		$data['season'] = get_dropdown_value('season');
		$data['states'] = state_array();
		$data['relationship'] = get_dropdown_value('relation');
		$data['settings'] = get_dropdown_value('setting');
		$data['side_of_house'] = get_dropdown_value('side_of_house');
		$data['rooms'] = get_dropdown_value('room');

        $this->output
                ->set_content_type('application/json')
                ->set_output(json("success","Add a home dropdown params",$data));
    }
	

	public function send_sms($num,$type,$address='') {
        // $to = '+1-248-417-0470'; // Recipient's phone number
		
        // $message = 'Hello, this is a test message from CodeIgniter!';

		if($type == "sub"){
			$message = "You've subscribed to BrickStory alerts for new photos or stories to one of your homes.Msg frequency varies. Msg & data rates may apply. Reply STOP to opt out to BrickStory.com notifications.";
		}

		if($type == "add"){
			$message = "BrickStory.com has a new photo or story added to your home at:
			
				\n\r
			$address
			\n\r
Please click here to see what has been added.";

		}

        $check_sms_per_day = check_sms_per_day($num);
		if($check_sms_per_day <= 3){
        	$result = $this->twilio_lib->send_sms($num, $message);
			if ($result) {
				save_sms_detail($num,$message,1);
				// echo "Message sent successfully. SID: " . $result;
			} else {
				// echo "Failed to send message.";
				save_sms_detail($num,$message,0);
			}
		}else{
			save_sms_detail($num,$message,0);
		}
    }

    public function add_home(){

		$data = read_set_json_data();

        $this->form_validation->set_rules('user_id', 'User ID', 'required|trim');
		$this->form_validation->set_rules('address1', 'Address1', 'required|trim|max_length[255]');
		$this->form_validation->set_rules('city', 'City', 'required|trim|max_length[50]');
		$this->form_validation->set_rules('owner_name', 'Owner Name', 'trim|max_length[60]');
		$this->form_validation->set_rules('architech', 'Architech', 'trim|max_length[255]');
		$this->form_validation->set_rules('square_feet', 'Square Feet', 'trim|max_length[15]');
		$this->form_validation->set_rules('address2', 'Address2', 'trim|max_length[255]');
		$this->form_validation->set_rules('state', 'State', 'required|trim|max_length[50]');
		$this->form_validation->set_rules('zip', 'Zip', 'trim|max_length[11]');
		$this->form_validation->set_rules('year_built', 'Year Built', 'required|trim|max_length[10]');
		$this->form_validation->set_rules('house_style_id', 'House Style', 'trim|max_length[11]');
		$this->form_validation->set_rules('bedroom_id', 'Bedroom', 'trim|max_length[11]');
		$this->form_validation->set_rules('material_id', 'Material', 'trim|max_length[11]');
        $this->form_validation->set_rules('from_date', 'From Date', 'required|trim');
        $this->form_validation->set_rules('to_date', 'To Date', 'required|trim');
		if($this->form_validation->run() == false){

            $this->output
            ->set_content_type('application/json')
            ->set_output(json("failure","validation errors",['error' => validation_errors('<p>','</p>')]));
            return;

		}else{
			$post = $data;

			if($post['home_profile_photo']){

				$base64String = $post['home_profile_photo'];
				// Specify the path where the image should be saved
			   $outputFile = './assets/uploads/brickstory_images/';
			   $filename = saveBase64Image($base64String, $outputFile);
			   $post['home_profile_photo'] = $filename;


			}
			if($post['from_date'] != ""){
				$post['from_date'] = date("d/m/Y",strtotime(str_replace("/","-",$post['from_date'])));
			}

			if($post['to_date'] != ""){
				$post['to_date'] = date("d/m/Y",strtotime(str_replace("/","-",$post['to_date'])));

			}
			if($post['square_feet'] == ""){
				$post['square_feet'] = 0;
			}
			$post['status'] = 0;
			$profile_id = $this->sqlmodel->insertRecord("brickstory_profile",$post);
			if($profile_id){
				$this->output
                ->set_content_type('application/json')
                ->set_output(json("success","The Brickstory is currently under review. We will review and approve it shortly",null));
                return;
			}else{
				$this->output
                ->set_content_type('application/json')
                ->set_output(json("failure","Something went wrong",null));
                return;

			}
		}
    }


	public function turnOffNotification($num){
	
		$check = $this->sqlmodel->getSingleRecord('brickstory_profile',array('id' => $num));	
		if($check){
			$this->sqlmodel->updateRec('brickstory_profile',array('monitor_home' => '0','monitor_phone' => NULL),array('id' => $check['id']));
			$this->output
            ->set_content_type('application/json')
            ->set_output(json("success","Notifications turned of successfully!",'Notifications turned of successfully!'));
            return;
		}else{
			$this->output
            ->set_content_type('application/json')
            ->set_output(json("failure","Property is not associated with you!",'Property is not associated with you!'));
            return;
		}
	}


	public function monitor_home(){
		

		$data = read_set_json_data();
		$this->form_validation->set_rules('property_id', 'property id', 'required|trim');
		$this->form_validation->set_rules('monitorPhone', 'Phone', 'required|trim');

		if($this->form_validation->run() == false){

            $this->output
            ->set_content_type('application/json')
            ->set_output(json("failure","validation errors",['error' => validation_errors('<p>','</p>')]));
            return;

		}else{
			$post = $data;
			$this->sqlmodel->updateRecord("brickstory_profile",array("monitor_home" =>1,"monitor_phone"=>$post["monitorPhone"]),array("id" => $post["property_id"]));
			
			$check = formatPhoneNumber_api($post["monitorPhone"]);
			if($check != 'error'){
	
					$this->send_sms($check ,'sub');
					
					$this->output
					->set_content_type('application/json')
					->set_output(json("success","Message has been sent successfully!",null));
					return;
			
			}else{
				$this->output
				->set_content_type('application/json')
				->set_output(json("failure","Message sending failed!",null));
				return;
			}
			
			// $this->output
			// ->set_content_type('application/json')
			// ->set_output(json("success","Information updated successfully!",null));
		}
	}

	public function update_home(){

		$data = read_set_json_data();

        $this->form_validation->set_rules('home_id', 'Home ID', 'required|trim');
		$this->form_validation->set_rules('user_id', 'User ID', 'required|trim');
		$this->form_validation->set_rules('address1', 'Address1', 'required|trim|max_length[255]');
		$this->form_validation->set_rules('city', 'City', 'required|trim|max_length[50]');
		$this->form_validation->set_rules('owner_name', 'Owner Name', 'trim|max_length[60]');
		$this->form_validation->set_rules('architech', 'Architech', 'trim|max_length[255]');
		$this->form_validation->set_rules('square_feet', 'Square Feet', 'trim|max_length[15]');
		$this->form_validation->set_rules('address2', 'Address2', 'trim|max_length[255]');
		$this->form_validation->set_rules('state', 'State', 'required|trim|max_length[50]');
		$this->form_validation->set_rules('zip', 'Zip', 'trim|max_length[11]');
		$this->form_validation->set_rules('year_built', 'Year Built', 'required|trim|max_length[10]');
		$this->form_validation->set_rules('house_style_id', 'House Style', 'trim|max_length[11]');
		$this->form_validation->set_rules('bedroom_id', 'Bedroom', 'trim|max_length[11]');
		$this->form_validation->set_rules('material_id', 'Material', 'trim|max_length[11]');
        $this->form_validation->set_rules('from_date', 'From Date', 'required|trim');
        $this->form_validation->set_rules('to_date', 'To Date', 'required|trim');
		if($this->form_validation->run() == false){

            $this->output
            ->set_content_type('application/json')
            ->set_output(json("failure","validation errors",['error' => validation_errors('<p>','</p>')]));
            return;

		}else{
			$post = $data;
			$home_id = $post['home_id'];

			unset($post['home_id']);

			if (!empty($post['home_profile_photo']) && strpos($post['home_profile_photo'], "http") === false && strpos($post['home_profile_photo'], "https") === false) {

				$base64String = $post['home_profile_photo'];
				// Specify the path where the image should be saved
			   $outputFile = './assets/uploads/brickstory_images/';
			   $filename = saveBase64Image($base64String, $outputFile);
			   $post['home_profile_photo'] = $filename;


			}else{
				// if(isset($post['home_profile_photo']) && $post['home_profile_photo'] == ""){
					unset($post['home_profile_photo']);
				// }
			}
			if($post['from_date'] != ""){
				$post['from_date'] = date("d/m/Y",strtotime(str_replace("/","-",$post['from_date'])));
			}

			if($post['to_date'] != ""){
				$post['to_date'] = date("d/m/Y",strtotime(str_replace("/","-",$post['to_date'])));

			}
	
			$profile_id = $this->sqlmodel->updateRecord("brickstory_profile",$post,array("id" => $home_id));
			if($profile_id){
				$this->output
                ->set_content_type('application/json')
                ->set_output(json("success","Brickstory updated successfully",null));
                return;
			}else{
				$this->output
                ->set_content_type('application/json')
                ->set_output(json("failure","Something went wrong",null));
                return;

			}
		}
    }

	public function edit_home(){

		$data = read_set_json_data();

        $this->form_validation->set_rules('id', 'Property ID', 'required|trim');
		$this->form_validation->set_rules('user_id', 'User ID', 'required|trim');
		$this->form_validation->set_rules('address1', 'Address1', 'required|trim|max_length[255]');
		$this->form_validation->set_rules('city', 'City', 'required|trim|max_length[50]');
		$this->form_validation->set_rules('owner_name', 'Owner Name', 'required|trim|max_length[60]');
		$this->form_validation->set_rules('architech', 'Architech', 'required|trim|max_length[255]');
		$this->form_validation->set_rules('square_feet', 'Square Feet', 'required|trim|max_length[15]');
		$this->form_validation->set_rules('address2', 'Address2', 'required|trim|max_length[255]');
		$this->form_validation->set_rules('state', 'State', 'required|trim|max_length[50]');
		$this->form_validation->set_rules('zip', 'Zip', 'required|trim|max_length[11]');
		$this->form_validation->set_rules('year_built', 'Year Built', 'required|trim|max_length[10]');
		$this->form_validation->set_rules('house_style_id', 'House Style', 'required|trim|max_length[11]');
		$this->form_validation->set_rules('bedroom_id', 'Bedroom', 'required|trim|max_length[11]');
		$this->form_validation->set_rules('material_id', 'Material', 'required|trim|max_length[11]');
        $this->form_validation->set_rules('from_date', 'From Date', 'required|required|trim');
        $this->form_validation->set_rules('to_date', 'To Date', 'required|required|trim');
		if($this->form_validation->run() == false){

            $this->output
            ->set_content_type('application/json')
            ->set_output(json("failure","validation errors",['error' => validation_errors('<p>','</p>')]));
            return;

		}else{
			$post = $data;

			if($post['home_profile_photo']){
				$base64String = $post['home_profile_photo'];
				// Specify the path where the image should be saved
			   $outputFile = './assets/uploads/brickstory_images/';
			   $filename = saveBase64Image($base64String, $outputFile);
			   $post['home_profile_photo'] = $filename;
			}
			
			if($post['from_date'] != ""){
				$post['from_date'] = date("d/m/Y",strtotime(str_replace("/","-",$post['from_date'])));
			}

			if($post['to_date'] != ""){
				$post['to_date'] = date("d/m/Y",strtotime(str_replace("/","-",$post['to_date'])));

			}

			$id = $post['id'];

			unset($post['id']);
	
			$profile_id = $this->sqlmodel->updateRecord("brickstory_profile",$post,array("id" => $id));
			if($profile_id){
				$this->output
                ->set_content_type('application/json')
                ->set_output(json("success","Brickstory information updated successfully",null));
                return;
			}else{
				$this->output
                ->set_content_type('application/json')
                ->set_output(json("failure","Something went wrong",null));
                return;

			}
		}
    }

    public function home_page_listing($page=1){

		$page = ($page >=0)?($page - 1):($page);
		$start = ($page * get_settings('RECORD_PER_PAGE'));
		$data['limit'] = get_settings('RECORD_PER_PAGE');
		$data['page'] = $page;
		$data['real_page']=$page;

        $data['recentListing'] = $this->sqlmodel->getRecords("*,CONCAT('".base_url()."assets/uploads/brickstory_images','/',brickstory_profile.home_profile_photo) as home_profile_photo",'brickstory_profile','id','desc','',$data['limit'],$start);
        $data['featureStory'] = $this->sqlmodel->getRecords('brickstory_profile.id,CONCAT("'.base_url().'assets/uploads/sub_brickstory_images","/",brickstory_substories.story_photo) as story_photo ,brickstory_profile.state,brickstory_profile.year_built,brickstory_profile.zip,brickstory_profile.city','brickstory_substories join brickstory_profile on (brickstory_substories.master_story_id = brickstory_profile.id)','id','desc','',5,0);
        $data['storiesCount'] = $this->sqlmodel->countRecords('brickstory_substories');
        $data['peoplesCount'] = $this->sqlmodel->countRecords('brickstory_person');
        $data['housesCount'] = $this->sqlmodel->countRecords('brickstory_profile');
        $sql = "SELECT COUNT(DISTINCT(city)) as total FROM `brickstory_profile`";
        $data['citiesCount'] = $this->sqlmodel->runQuery($sql,1);

        $this->output
                ->set_content_type('application/json')
                ->set_output(json("success","Brickstory home listings",$data));
                return;

    }

    public function contactus()
	{
	
		$data = read_set_json_data();
		fv("name","name","trim");
        fv("message","message","trim");
        fv("email","email","required|trim|valid_email");
        fv("phone","phone","trim");

		if($this->form_validation->run() == false){
            $this->output
            ->set_content_type('application/json')
            ->set_output(json("failure","validation errors",['error' => validation_errors('<p>','</p>')]));
            return;

		}else{
			$post = $data;
			$post['emailContent'] = $this->sqlmodel->getSingleRecord("email_template",array("template_name" => "contact_us"));
			$post['template_path'] = "email_templates/contactus_email";
			$post['subject'] = $post['emailContent']['template_subject'];
			// $post['contactus'] = true;

			send_email($post);
			 $this->output
            ->set_content_type('application/json')
            ->set_output(json("success","validation errors",'Thankyou so much for contactting with us.'));
            return;
		}
	}

	public function nearme($page=1)
	{
		$get = get();
		$lat = isset($get['lat'])?($get['lat']):('');
		$lng = isset($get['lng'])?($get['lng']):('');
		$data['get'] = get();
		$dis = 10000;
		$data['pagelink'] = $page;
		$page = ($page >=0)?($page - 1):($page);
		$start = ($page * get_settings('RECORD_PER_PAGE'));
		$data['limit'] = get_settings('RECORD_PER_PAGE');
		$data['page'] = $page;

		$data['real_page']=$page;

		$where = " where 1 ";
		if(isset($get['street']) && $get['street'] != ""){
			$where .= " AND (address1 like '%".$get['street']."%' OR address2 like '%".$get['street']."%') ";
		}
		if(isset($get['minRangeYearBuilt']) && $get['minRangeYearBuilt'] != ""){
			$where .= " AND (year_built between ".$get['minRangeYearBuilt']." AND ".$get['maxRangeYearBuilt'].") ";
		}
		if(isset($get['minRangeSquareFeet']) && ($get['minRangeSquareFeet'] != "" && $get['maxRangeSquareFeet'] != "") && ($get['minRangeSquareFeet'] != "1" && $get['maxRangeSquareFeet'] != "10000+")){
			$where .= " AND (square_feet between ".$get['minRangeSquareFeet']." AND ".$get['maxRangeSquareFeet'].") ";
		}elseif(isset($get['minRangeSquareFeet']) && $get['minRangeSquareFeet'] != "1" && $get['maxRangeSquareFeet'] == "10000+"){
			$where .= " AND (square_feet >=".$get['minRangeSquareFeet']." ) ";
		}elseif(isset($get['minRangeSquareFeet']) && $get['minRangeSquareFeet'] == "1" && $get['maxRangeSquareFeet'] <= "10000"){
			$where .= " AND (square_feet <=".$get['maxRangeSquareFeet']." ) ";
		}
//echo $where;
//		if(isset($get['maxRange']) && $get['maxRange'] != ""){
//			$distance = " having distance > ".str_replace("mi","",$get['minRange'])." AND distance < ".str_replace("mi","",$get['maxRange']);
//		}else{
//			$distance = " having distance < $dis ";
//		}
		$distance = '';
		if(isset($get['city']) && $get['city'] != ""){
			$where .= " AND (city like '%".$get['city']."%') ";
		}
		if(isset($get['county']) && $get['county'] != ""){
			$where .= " AND (county like '%".$get['county']."%') ";
		}

		if(isset($get['nrhp']) && $get['nrhp'] != ""){
			$where .= " AND (NRHP = '1') ";
		}

		if(isset($get['state']) && $get['state'] != ""){
			$where .= " AND (state='".$get['state']."') ";
		}

		if(isset($get['zip']) && $get['zip'] != ""){
			$where .= " AND (zip= ".$get['zip'].") ";
		}
		if(isset($get['house_style_id']) && $get['house_style_id'] != "0" && $get['house_style_id'] != ""){
			$where .= " AND (house_style_id='".$get['house_style_id']."') ";
		}
		if(isset($get['bedroom_id']) && $get['bedroom_id'] != "0" && $get['bedroom_id'] != ""){
			$where .= " AND (bedroom_id='".$get['bedroom_id']."') ";
		}
		
		if(isset($get['roof_id']) && $get['roof_id'] != "0" && $get['roof_id'] != ""){
			$where .= " AND (roof_id='".$get['roof_id']."') ";
		}
		if(isset($get['architect']) && $get['architect'] != ""){
			$where .= " AND (architech like '%".$get['architect']."%') ";
		}
		if(isset($get['owner_name']) && $get['owner_name'] != ""){
			$where .= " AND (owner_name like '%".$get['owner_name']."%') ";
		}
		if(isset($get['material_id']) && $get['material_id'] != "0" && $get['material_id']!= ""){
			$where .= " AND (material_id='".$get['material_id']."') ";
		}
		if(isset($get['foundation_id']) && $get['foundation_id'] != "0" && $get['foundation_id'] != ""){
			$where .= " AND (foundation_id='".$get['foundation_id']."') ";
		}
		if($lat != "" && $lng != "") {
			$sql = "SELECT *,
			CONCAT('".base_url()."assets/uploads/brickstory_images','/',dest.home_profile_photo) as home_profile_photo, 
			3956 * 2 * ASIN(SQRT( POWER(SIN(($lat - abs(dest.lat)) * pi()/180 / 2), 2) +  COS($lat * pi()/180 ) * COS(abs(dest.lat) * pi()/180) *  POWER(SIN(($lng - dest.lng) * pi()/180 / 2), 2) )) as  distance
			FROM brickstory_profile dest ".$where;

			$sql .= $distance;
			$countSql = $sql;
			$sql .= " ORDER BY distance limit $start,".$data['limit'];
			$countSql .= " ORDER BY distance";

			$data['properties'] = $this->sqlmodel->runQuery($sql);

			$countResult = $this->sqlmodel->runQuery($countSql);
			if($countResult){
				$data['count'] = count($countResult);
			}else{
				$data['count'] = 0;
			}
			$data['total_pages'] = ceil($data['count']/$data['limit']);

		}else{
			$sql = "SELECT *,CONCAT('".base_url()."assets/uploads/brickstory_images','/',brickstory_profile.home_profile_photo) as home_profile_photo FROM brickstory_profile ".$where;

			$sql .= " ORDER BY id desc limit $start,".$data['limit'];
			$data['properties'] = $this->sqlmodel->runQuery($sql);
            if($data['properties']){
				$data['count'] = count($data['properties']);
			}else{
                $data['count'] = 0;
            }
			$data['total_pages'] = ceil($data['count']/$data['limit']);

		}
	
		

        $this->output
                ->set_content_type('application/json')
                ->set_output(json("success","Brickstory near me listings",$data));
                return;

	}
 
    public function houses($page=1,$house_id=0)
	{
		$get = get();
		$data['get']= $get;
		$sql = "SELECT R.*,
					CONCAT('".base_url()."assets/uploads/brickstory_images','/',R.home_profile_photo) as home_profile_photo 
					 FROM brickstory_profile AS R WHERE 1 = 1 ";

		$countSql = $sql;
		$data['pagelink'] = $page;

		$page = ($page >=0)?($page - 1):($page);
		$start = ($page * get_settings('RECORD_PER_PAGE'));
		$data['limit'] = get_settings('RECORD_PER_PAGE');
		$data['page'] = $page;
		$data['real_page']=$page;
		$where = '';
		if(isset($get['street']) && $get['street'] != ""){
			$sql .= " AND ( address1 like '%".$get['street']."%' OR address2 like '%".$get['street']."%' ) ";
			$countSql .= " AND ( address1 like '%".$get['street']."%' OR address2 like '%".$get['street']."%' ) ";

		}

		if(isset($get['minRangeYearBuilt']) && $get['minRangeYearBuilt'] != ""){
			$sql .= " AND (year_built >= ".$get['minRangeYearBuilt']." AND year_built <= ".$get['maxRangeYearBuilt'].")";
			$countSql .= " AND (year_built >= ".$get['minRangeYearBuilt']." AND year_built <= ".$get['maxRangeYearBuilt'].")";
		}

		if(isset($get['minRangeSquareFeet']) && $get['minRangeSquareFeet'] != "1" && $get['maxRangeSquareFeet'] != "10000+"){

			// $sql .= " AND (square_feet between ".$get['minRangeSquareFeet']." AND ".$get['maxRangeSquareFeet'].") ";
			// $countSql .= " AND (square_feet between ".$get['minRangeSquareFeet']." AND ".$get['maxRangeSquareFeet'].") ";

		}elseif(isset($get['minRangeSquareFeet']) && $get['minRangeSquareFeet'] == "1" && $get['maxRangeSquareFeet'] == "10000+"){
			
			$sql .= " AND (square_feet >=".$get['minRangeSquareFeet']." ) ";
			$countSql .= " AND (square_feet >=".$get['minRangeSquareFeet']." ) ";
		
		}elseif(isset($get['minRangeSquareFeet']) && $get['minRangeSquareFeet'] >= 1 && $get['maxRangeSquareFeet'] <= 10000){

			$sql .= " AND (square_feet <=".$get['maxRangeSquareFeet']." ) ";
			$countSql .= " AND (square_feet <=".$get['maxRangeSquareFeet']." ) ";
		}

		if(isset($get['city']) && $get['city'] != ""){
			$sql .= " AND (city like '%".$get['city']."%') ";
			$countSql .= " AND (city like '%".$get['city']."%') ";
		}

		if(isset($get['nrhp']) && $get['nrhp'] != ""){
			$sql .= " AND (NRHP = '1') ";
			$countSql .= " AND (NRHP = '1') ";
		}

		if(isset($get['county']) && $get['county'] != ""){
			$sql .= " AND (county like '%".$get['county']."%') ";
			$countSql .= " AND (county like '%".$get['county']."%') ";
		}

		if(isset($get['state']) && $get['state'] != ""){
			$sql .= " AND (state ='".$get['state']."') ";
			$countSql .= " AND (state ='".$get['state']."') ";
		}

		if(isset($get['zip']) && $get['zip'] != ""){
			$sql .= " AND (zip ='".$get['zip']."') ";
			$countSql .= " AND (zip ='".$get['zip']."') ";
		}

		if(isset($get['house_style_id']) && $get['house_style_id'] != "0" && $get['house_style_id'] != ""){
			$sql .= " AND (house_style_id =".$get['house_style_id'].") ";
			$countSql .= " AND (house_style_id =".$get['house_style_id'].") ";
		}

		if(isset($get['bedroom_id']) && $get['bedroom_id'] != "0" && $get['bedroom_id'] != ""){
			$sql .= " AND (bedroom_id =".$get['bedroom_id'].") ";
			$countSql .= " AND (bedroom_id =".$get['bedroom_id'].") ";
		}

		if(isset($get['roof_id']) && $get['roof_id'] != "0" && $get['roof_id'] != ""){
			$sql .= " AND (roof_id =".$get['roof_id'].") ";
			$countSql .= " AND (roof_id =".$get['roof_id'].") ";
		}

		if(isset($get['architect']) && $get['architect'] != ""){
			$sql .= " AND (architech like '%".$get['architect']."%') ";
			$countSql .= " AND (architech like '%".$get['architect']."%') ";
		}

		if(isset($get['owner_name']) && $get['owner_name'] != ""){
			$sql .= " AND (owner_name like '%".$get['owner_name']."%') ";
			$countSql .= " AND (owner_name like '%".$get['owner_name']."%') ";
		}

		if(isset($get['material_id']) && $get['material_id'] != "0" && $get['material_id'] != ""){
			$sql .= " AND (material_id =".$get['material_id'].") ";
			$countSql .= " AND (material_id =".$get['material_id'].") ";
		}

		if(isset($get['foundation_id']) && $get['foundation_id'] != "0" && $get['foundation_id'] != ""){
			$sql .= " AND (foundation_id =".$get['foundation_id'].") ";
			$countSql .= " AND (foundation_id =".$get['foundation_id'].") ";
		}

		$sql .= " group by R.id order by R.id desc limit $start,".$data['limit'];
		$countSql .= " group by R.id order by R.id desc";

		$data['properties'] = $this->sqlmodel->runQuery($sql);

		$countResult = $this->sqlmodel->runQuery($countSql);
		if($countResult){
			$data['count'] = count($countResult);
		}else{
			$data['count'] = 0;
		}
		$data['total_pages'] = ceil($data['count']/$data['limit']);
        $this->output
        ->set_content_type('application/json')
        ->set_output(json("success","Brickstory houses",$data));
        return;
		
	}
    
	public function peoples($page=1)
	{

		$data['segment'] = $this->uri->segment(0);
		$segment = $this->uri->segment_array();
		$data['segment'] = $segment[1];
		$where = array();
		$search = '';
		if(get('relation_id')){
			$search = 1;
			$where['relation_id'] = get('relation_id');
		}
		if(get('first_name')){
			$search = 1;
			$where['frist_name like '] = "%".get('first_name')."%";
		}
		if(get('last_name')){
			$search = 1;
			$where['last_name like '] = "%".get('last_name')."%";
		}
		$join = '';
		if(get('nrhp') && get('nrhp') != ""){
			$search = 1;
			$join = ' LEFT JOIN brickstory_profile bp on (bp.id = brickstory_person.master_story_id) ';
			$where['bp.NRHP'] = 1;
		}
		$data['searchSubmit'] = $search;
		$data['get'] = get();
		$sortby = 'id';
		$orderby = 'desc';
		$page = ($page >=0)?($page - 1):($page);
		$start = ($page * get_settings('RECORD_PER_PAGE'));
		$data['limit'] = get_settings('RECORD_PER_PAGE');
		$data['page'] = $page;
		$data['real_page']=$page;

		$data['peoples'] = $this->sqlmodel->getRecords('brickstory_person.*,CONCAT("'.base_url().'assets/uploads/peoples","/",brickstory_person.person_photo) as person_photo,CONCAT("'.base_url().'assets/uploads/peoples","/",brickstory_person.person_photo) as full_person_photo','brickstory_person'.$join,$sortby,$orderby,$where,$data['limit'],$start);
		$data['count'] = $this->sqlmodel->countRecords('brickstory_person '.$join,$where);
		$data['total_pages'] = ceil($data['count']/$data['limit']);

		$this->output
        ->set_content_type('application/json')
        ->set_output(json("success","Brickstory peoples listing",$data));
        return;
	}

	public function pages($filename){
		if($filename == "architect"){
			$data['recentListing'] = $this->sqlmodel->getRecords('*','brickstory_profile','id','desc','',5,0);
		}else if($filename == "about"){
			$data['aboutus'] = $this->sqlmodel->getSingleRecord("cms",array("slug_url" => "about-brickstory","lang_id" => 1));
		}else if($filename == "howitworks"){
			$data['page'] = $this->sqlmodel->getSingleRecord("cms",array("slug_url" => "how-it-works","lang_id" => 1));
		}else if($filename == "termandconditions"){
			$data['page'] = $this->sqlmodel->getSingleRecord("cms",array("slug_url" => "terms-and-conditions","lang_id" => 1));
		}
		else if($filename == "privacy-policy"){
			$data['page'] = $this->sqlmodel->getSingleRecord("cms",array("slug_url" => "privacy-policy","lang_id" => 1));
		}

		$this->output
        ->set_content_type('application/json')
        ->set_output(json("success","page informationfound",$data));
        return;
	}

	public function home_timeline($home_id=0,$user_id=0){
		$timeline= array();
		$this->load->model("user_timeline_model");
		$this->load->model("myhomes_model");
		// ------- Timeline Code started from here ---------

		$sub_timeline = $this->user_timeline_model->get_record_by_id_all_user($home_id);
		$records = $this->myhomes_model->get_record_by_id($home_id);
		$records['home_profile_photo'] = base_url()."assets/uploads/brickstory_images/".$records['home_profile_photo'];
		$apprx_1 = '1900-01-01';
		$start = $month = @strtotime('1900-01-01');
		$end = strtotime(date("Y-m-d"));
		$end = strtotime("+1 days", $end);
		$apprx_2 = date("Y-m-d");  
		$setting = $this->myhomes_model->get_dropdown_value('setting');
		$setting = array(0 => "Please Select") + $setting;
		$season = $this->myhomes_model->get_dropdown_value('season');
		$season = array(0 => "Please Select") + $season;
		$event = $this->myhomes_model->get_dropdown_value('event');
		$event = array(0 => "Please Select") + $event;
		$side_of_house = $this->myhomes_model->get_dropdown_value('side_of_house');
		$side_of_house = array(0 => "Please Select") + $side_of_house;
		$room = get_dropdown_value('room');
		$room = array(0 => "Please Select") + $room;
		$timeline_persons = array();
		$sub_timeline_data = array();
		while($month < $end)
		{
					if($apprx_1 != '' && $apprx_2 != '')
					{
						//echo 'im login user : ';
						// $idg = $sub_timeline[0]->master_story_id;
						$idg = $home_id;
						$ci =& get_instance();
						//$ci->load->model('myhomes_model');
						$dfg = $ci->myhomes_model->get_persons_time($idg,$apprx_1,$apprx_2);
						//var_dump($dfg);
						$er=100;
						foreach ($dfg as $khr => $timelinepersons)
						{
							
							if(date('Y',$month) == date('Y',strtotime($timelinepersons['from_date'])) && 
								date('M',$month) == date('M',strtotime($timelinepersons['from_date']))){
			
								if($timelinepersons['Indicator'] == 'F')
								{
									$timelinepersons['Indicator'] =  'Moved In ';
								}
								if($timelinepersons['Indicator'] == 'T') {
									$timelinepersons['Indicator'] =  'Moved Out';
								}
								$timelinepersons['person_photo'] = base_url()."/assets/uploads/peoples/".$timelinepersons['person_photo'];
								$timeline_persons[] = $timelinepersons;

							}
					} 
			
				foreach ($sub_timeline as $key => $timelinep){
					if(date('Y',$month) == date('Y',strtotime($timelinep->approximate_date))
					&& date('M',$month) == date('M',strtotime($timelinep->approximate_date))){
							if(($timelinep->user_id == $user_id) || ($user_id == '1')){  
								$timelinep->setting = (isset($setting[$timelinep->setting_id]) && $timelinep->setting_id != 0) ? $setting[$timelinep->setting_id] : 'Not Available';
								$timelinep->season = (isset($season[$timelinep->season_id]) && $timelinep->season_id != 0) ? $season[$timelinep->season_id] : 'Not Available';
								$timelinep->event = (isset($event[$timelinep->event_id]) && $timelinep->event_id != 0) ? $event[$timelinep->event_id] : 'Not Available';
								$timelinep->side_of_house = (isset($side_of_house[$timelinep->side_of_house_id]) && $timelinep->side_of_house_id != 0) ? $side_of_house[$timelinep->side_of_house_id] : 'Not Available';
								$timelinep->room = (isset($room[$timelinep->room_id]) && $timelinep->room_id != 0) ? $room[$timelinep->room_id] : 'Not Available';
								
							}else{ // user if
								$timelinep->setting = (isset($setting[$timelinep->setting_id]) && $timelinep->setting_id != 0) ? $setting[$timelinep->setting_id] : 'Not Available';
								$timelinep->season = (isset($season[$timelinep->season_id]) && $timelinep->season_id != 0) ? $season[$timelinep->season_id] : 'Not Available';
								$timelinep->event = (isset($event[$timelinep->event_id]) && $timelinep->event_id != 0) ? $event[$timelinep->event_id] : 'Not Available';
								$timelinep->side_of_house = (isset($side_of_house[$timelinep->side_of_house_id]) && $timelinep->side_of_house_id != 0) ? $side_of_house[$timelinep->side_of_house_id] : 'Not Available';
								$timelinep->room = (isset($room[$timelinep->room_id]) && $timelinep->room_id != 0) ? $room[$timelinep->room_id] : 'Not Available';

							
							}
							$timelinep->story_photo = base_url("assets/uploads/sub_brickstory_images/".$timelinep->story_photo);
							$sub_timeline_data[] = $timelinep;

					}
				}
			}
			$month = strtotime("+1 month", $month);
			}

			

        $this->output
        ->set_content_type('application/json')
        ->set_output(json("success","My brickstory timeline",['home' => $records,'timeline'=>$timeline_persons,'sub_timeline' => $sub_timeline_data]));
        return;


    }
	public function photosnhistory($page=1)
	{

		$data['segment'] = $this->uri->segment(0);
		$segment = $this->uri->segment_array();
		$data['segment'] = $segment[1];
		$where = array();
		$search = '';
		if(get('setting_id')){
			$search = 1;
			$where["setting_id"] = get('setting_id');
		}
		if(get('season_id')){
			$search = 1;
			$where['season_id'] = get('season_id');
		}
		if(get('event_id')){
			$search = 1;
			$where['event_id'] = get('event_id');
		}
		if(get('side_of_house_id')){
			$search = 1;
			$where['side_of_house_id'] = get('side_of_house_id');
		}
		if(get('bedroom_id')){
			$search = 1;
			$where['room_id'] = get('bedroom_id');
		}
		$join = '';
		if(get('nrhp') && get('nrhp') != ""){
			$search = 1;
			$join = ' LEFT JOIN brickstory_profile bp on (bp.id = brickstory_substories.master_story_id) ';
			$where['bp.NRHP'] = 1;
		}
		$data['searchSubmit'] = $search;
		$data['get'] = get();
		$sortby = 'id';
		$orderby = 'desc';
		$page = ($page >=0)?($page - 1):($page);
		$start = ($page * get_settings('RECORD_PER_PAGE'));
		$data['limit'] = get_settings('RECORD_PER_PAGE');
		$data['page'] = $page;
		$data['real_page']=$page;

		//---------------
		$data['result'] = $this->sqlmodel->getRecords(
			'S.*,
			CONCAT("'.base_url().'assets/uploads/sub_brickstory_images","/",S.story_photo) as story_photo ,
			CONCAT("'.base_url().'assets/uploads/sub_brickstory_images","/",S.story_photo) as full_story_photo ,
			bp.city,bp.state, D1.value as season_value,D2.value as event_value, D3.value as side_of_house_value, D4.value as room_value,D5.value as setting_value',
			'brickstory_substories  as S 
			LEFT JOIN brickstory_dropdown_value as D1 on (S.season_id = D1.id)
			LEFT JOIN brickstory_dropdown_value as D2 on (S.event_id = D2.id )
			LEFT JOIN brickstory_dropdown_value as D3 on (S.side_of_house_id = D3.id )
			LEFT JOIN brickstory_dropdown_value as D4 on (S.room_id = D4.id )
			LEFT JOIN brickstory_profile bp on (bp.id = S.master_story_id)
			LEFT JOIN brickstory_dropdown_value as D5 on (S.setting_id = D5.id )
			',$sortby,$orderby,$where,$data['limit'],$start);
		//pre($data['result']);


		$data['count'] = $this->sqlmodel->countRecords('brickstory_substories '.$join,$where);
		$data['total_pages'] = ceil($data['count']/$data['limit']);


		$this->output
        ->set_content_type('application/json')
        ->set_output(json("success","Brickstory photo and stories listing",$data));
        return;
	}


	public function details($id='')
	{
	
		$tab = $this->uri->segment(2);
		if($tab == "view") {
			$data['livedhere'] = $this->sqlmodel->getSingleRecord("brickstory_livedhere",array("master_story_id" => $id,"user_id" => $this->session->userdata("user_id")));
//			pre($data['livedhere']);
			if(post('from_date')){
				$lived_here = (post('user_lived_here') == 1)?(1):(0);
				$info = array(
					'from_date' => date("m/d/Y",strtotime(str_replace("/","-",post('from_date')))),
					'to_date' => date("m/d/Y",strtotime(str_replace("/","-",post('to_date')))),
					'lived_here' => $lived_here,
					'master_story_id' => $id,
					'user_id' => $this->session->userdata("user_id"),
				);
				if(post('id')){
					$this->sqlmodel->updateRecord("brickstory_livedhere", $info,array("id" => post('id')));
				}else{
					$this->sqlmodel->insertRecord("brickstory_livedhere", $info);
				}

				set_msg('success','Information updated successfully!');
				
			}
			$data['filename'] = "property/home_details";
		}
		
		

// 			$this->load->model("user_timeline_model");
// 			$this->load->model("myhomes_model");
// 			// ------- Timeline Code started from here ---------

// 			$state_array = state_array();
// 			$sub_timeline = $this->user_timeline_model->get_record_by_id_all_user($id);
// 			$livedhere = $this->user_timeline_model->get_lived_here_by_user($id);
// 			$records = $this->myhomes_model->get_record_by_id($id);
// 			$sub_persons = $this->myhomes_model->get_persons1($id);

// //			pre($livedhere);

// 			$data = array(
// 				'sub_timeline' => $sub_timeline,
// 				'livedhere' => $livedhere,
// 				'ency_id' => $id,
// 				'records'=>$records,
// 				'sub_persons' => $sub_persons,
// 			);
// 			dd($data);
		
	

		$data['home'] = getHomeDetails($id);
		
		$data['home']['home_profile_photo'] = base_url("assets/uploads/brickstory_images/".$data['home']['home_profile_photo']);

		// ------------- get Sub Records ----------
		$id = intval($id);
		$this->db->select('S.*,
		CONCAT("'.base_url().'assets/uploads/sub_brickstory_images/","/",S.story_photo) as story_photo, 
		D1.value as season_value,
		D2.value as event_value, 
		D3.value as side_of_house_value, 
		D4.value as room_value,
		D5.value as setting_value');
		$this->db->from('brickstory_substories  as S');
		$this->db->join('brickstory_dropdown_value as D1', 'S.season_id = D1.id', 'left');
		$this->db->join('brickstory_dropdown_value  as D2', 'S.event_id = D2.id', 'left');
		$this->db->join('brickstory_dropdown_value as D3', 'S.side_of_house_id = D3.id', 'left');
		$this->db->join('brickstory_dropdown_value as D4', 'S.room_id = D4.id', 'left');
		$this->db->join('brickstory_dropdown_value as D5', 'S.setting_id = D5.id', 'left');
		$this->db->where('S.master_story_id', $id);
		$this->db->order_by('id', 'asc');
		$result = $this->db->get();
		//var_dump($this->db);exit;
		$data['sub_stories'] = $result->result_array();

			$this->load->model("user_timeline_model");
			$this->load->model("myhomes_model");
			// ------- Timeline Code started from here ---------

			$sub_timeline = $this->user_timeline_model->get_record_by_id_all_user($id);
			$livedhere = $this->user_timeline_model->get_lived_here_by_user($id);
			$sub_persons = $this->myhomes_model->get_persons2($id);


//			pre($livedhere);

			$data['livedhere'] = $livedhere;
			$data['sub_persons'] = $sub_persons;
		
		$this->output
        ->set_content_type('application/json')
        ->set_output(json("success","Property details found",$data));
        return;

	}

	function get_json1($param) {
		$temp = "[";
		foreach ($param as $key => $value) {
			$temp .= "{value: " . $key . ", text:'" . str_replace("'", "\'", $value). "'},";
		}
		$temp.="]";

		return $temp;
	}

	public function i_lived_here(){
		$data = read_set_json_data();
		fv('user_id','user id','required|trim');
		fv('property_id','property id','required|trim');

		if($this->form_validation->run() == false){
            $this->output
            ->set_content_type('application/json')
            ->set_output(json("failure","validation errors",['error' => validation_errors('<p>','</p>')]));
            return;
		}else{

				if($data['from_date']){
					$lived_here = ($data['user_lived_here'] == 1)?(1):(0);
					$info = array(
						'from_date' => date("m/d/Y",strtotime(str_replace("/","-",$data['from_date']))),
						'to_date' => date("m/d/Y",strtotime(str_replace("/","-",$data['to_date']))),
						'lived_here' => $lived_here,
						'master_story_id' => $data["property_id"],
						'user_id' => $data["user_id"],
					);
					$livedhere = $this->sqlmodel->getSingleRecord("brickstory_livedhere",array("master_story_id" => $data["property_id"],"user_id" => $data["user_id"]));

					if($livedhere){
						$this->sqlmodel->updateRecord("brickstory_livedhere", $info,array("master_story_id" => $data["property_id"],"user_id" => $data["user_id"]));
					}else{
						$this->sqlmodel->insertRecord("brickstory_livedhere", $info);
					}
			
				}
			}
			$livedhere = $this->sqlmodel->getSingleRecord("brickstory_livedhere",array("master_story_id" => $data["property_id"],"user_id" => $data["user_id"]));
			
			$this->output
            ->set_content_type('application/json')
            ->set_output(json("success","I lived here information updated successfully.",$livedhere));
            return;
		}


		public function add_people_to_property(){
			$data = read_set_json_data();
		fv('user_id','first name','required|trim');
		fv('property_id','property id','required|trim');
		fv('first_name','first name','required|trim');
		fv('last_name','last name','required|trim');
		fv('relation_id','relation','trim');
		fv('from_date','from date','required|trim');
		fv('to_date','to date','trim');
		fv('born_date','born date','required|trim');
		fv('died_date','died date','trim');
		fv('image','person image','required|trim');
		
		if($this->form_validation->run() == false){
            $this->output
            ->set_content_type('application/json')
            ->set_output(json("failure","validation errors",['error' => validation_errors('<p>','</p>')]));
            return;
		}else{

			$post = $data;
			// $folderPath = "./assets/uploads/peoples/";


			if($post['image']){

				$base64String = $post['image'];
				// Specify the path where the image should be saved
			   $outputFile = './assets/uploads/peoples/';
			   $filename = saveBase64Image($base64String, $outputFile);
			   $post['image'] = $filename;

			}

			$info_Array = array(
				'user_id' => $data['user_id'],
				'master_story_id' => $data['property_id'],
				'frist_name' => $post['first_name'],
				'last_name' => $post['last_name'],
				'relation_id' => $post['relation_id'],
				'living' => $post['living'],
				'from_date' => date('Y-m-d h:i:s', strtotime(str_replace("/","-",$post['from_date']))),
				'to_date' =>   $post['to_date']?date('Y-m-d h:i:s', strtotime(str_replace("/","-",$post['to_date']))):null,
				'born_date' => date('Y-m-d h:i:s', strtotime(str_replace("/","-",$post['born_date']))),
				'died_date' => $post['died_date']?date('Y-m-d h:i:s', strtotime(str_replace("/","-",$post['died_date']))):null,
				'person_photo' => $post['image']
			);
			$this->sqlmodel->insertRecord("brickstory_person",$info_Array);
			
			$this->output
            ->set_content_type('application/json')
            ->set_output(json("success","Person added successfully.",null));
            return;
		}
	}



	private function formatDate($date){
		$from_date_raw = $date ?? null;
		$dateObj = DateTime::createFromFormat('m/d/Y', $from_date_raw);

		if ($dateObj && $dateObj instanceof DateTime) {
			$from_date = $dateObj->format('Y-m-d H:i:s');
		} else {
			log_message('error', 'Invalid date format provided: ' . print_r($from_date_raw, true));
			$from_date = null; // or handle however you prefer
		}
	}
	public function update_people_to_property(){
		$data = read_set_json_data();
	fv('user_id','first name','required|trim');
	fv('property_id','property id','required|trim');
	fv('first_name','first name','required|trim');
	fv('last_name','last name','required|trim');
	fv('relation_id','relation','trim');
	fv('from_date','from date','required|trim');
	fv('to_date','to date','trim');
	fv('born_date','born date','required|trim');
	fv('died_date','died date','trim');
	fv('image','person image','required|trim');
	
	if($this->form_validation->run() == false){
		$this->output
		->set_content_type('application/json')
		->set_output(json("failure","validation errors",['error' => validation_errors('<p>','</p>')]));
		return;
	}else{

		$post = $data;
		$people_id = $post['people_id'];
		unset($post['people_id']);
		// $folderPath = "./assets/uploads/peoples/";


		

		$info_Array = array(
			'user_id' => $data['user_id'],
			'master_story_id' => $data['property_id'],
			'frist_name' => $post['first_name'],
			'last_name' => $post['last_name'],
			'relation_id' => $post['relation_id'],
			'living' => $post['living'],
			'from_date' => date('d/m/Y', strtotime(str_replace("/","-",$post['from_date']))),
			'to_date' =>   $post['to_date']?date('d/m/Y', strtotime(str_replace("/","-",$post['to_date']))):null,
			'born_date' => date('d/m/Y', strtotime(str_replace("/","-",$post['born_date']))),
			'died_date' => $post['died_date']?date('d/m/Y', strtotime(str_replace("/","-",$post['died_date']))):null,
		);

		if (!empty($post['image']) && strpos($post['image'], "http") === false && strpos($post['image'], "https") === false) {

			$base64String = $post['image'];
			// Specify the path where the image should be saved
		   $outputFile = './assets/uploads/peoples/';
		   $filename = saveBase64Image($base64String, $outputFile);
		   $info_Array['person_photo'] = $filename;

		}else{
			if(isset($post['image']) && $post['image'] == ""){
				unset($post['image']);
			}
		}
		$this->sqlmodel->updateRecord("brickstory_person",$info_Array,array("id" => $people_id));
		
		$this->output
		->set_content_type('application/json')
		->set_output(json("success","Person information updated successfully.",null));
		return;
	}
}

	public function add_photo_story_to_property(){
		$data = read_set_json_data();
		fv('user_id','first name','required|trim');
		fv('property_id','property id','required|trim');
		fv('approximate_date','approximate date','required|trim');
		fv('setting_id','home setting','required|trim');
		fv('season_id','season','trim');
		fv('event_id','event','trim');
		fv('side_of_house_id','side of house','trim');
		fv('brickstory_desc','story description','required|trim');
		fv('bedroom_id','bedroom','trim');
		fv('image','story image','trim');
		
		if($this->form_validation->run() == false){
            $this->output
            ->set_content_type('application/json')
            ->set_output(json("failure","validation errors",['error' => validation_errors('<p>','</p>')]));
            return;
		}else{
			$post = $data;

			if($post['image']){

				$base64String = $post['image'];
				// Specify the path where the image should be saved
			   $outputFile = './assets/uploads/sub_brickstory_images/';
			   $filename = saveBase64Image($base64String, $outputFile);
			   $post['image'] = $filename;

			}

			$data_array = array();
					$this->load->model("brickstory_model");
					// $folderPath = "./assets/uploads/sub_brickstory_images/";
					// $personImage = do_upload('image',$folderPath);
					$data_array = array(
						'master_story_id' => $post['property_id'],
						'from_date' => isset($post['from_date'])?(date('Y-m-d', strtotime(str_replace("/","-",$post['from_date'])))):(''),
						'to_date' => isset($post['to_date'])?
						date('Y-m-d',  strtotime(str_replace("/","-",$post['to_date'])))
						:(''),
						'approximate_date' => isset($post['approximate_date'])?(date('Y-m-d', strtotime(str_replace("/","-",$post['approximate_date'])))):(''),
						'setting_id' => $post['setting_id'],
						'season_id' => $post['season_id'],
						'event_id' => $post['event_id'],
						'story_photo' => $post['image'],
						'side_of_house_id' => $post['side_of_house_id']??0,
						'room_id' => $post['room_id']??0,
						'story_description' => $post['brickstory_desc'],
						'user_id' => $post['user_id'],
						'created_on' => GetCurrentDateTime(),
						'updated_on' => GetCurrentDateTime()
					);

					$lastId = $this->brickstory_model->save_substory_record($data_array);

					$check = $this->sqlmodel->getSingleRecord("brickstory_profile",array('id'=>$post['property_id']));
				    if($check['monitor_home'] == 1){
						$this->send_sms($check['monitor_phone'],'add',$check['address1']);
					}

					$this->output
            ->set_content_type('application/json')
            ->set_output(json("success","Photo & story added successfully.",null));
            return;
		}
	}

	public function update_photo_story_to_property(){
		$data = read_set_json_data();
		fv('story_id','photo story id','required|trim');
		fv('user_id','first name','required|trim');
		fv('property_id','property id','required|trim');
		fv('approximate_date','approximate date','required|trim');
		fv('setting_id','home setting','required|trim');
		fv('season_id','season','required|trim');
		fv('event_id','event','required|trim');
		fv('side_of_house_id','side of house','required|trim');
		fv('brickstory_desc','story description','required|trim');
		fv('bedroom_id','bedroom','trim');
		fv('image','person image','required|trim');
		
		if($this->form_validation->run() == false){
            $this->output
            ->set_content_type('application/json')
            ->set_output(json("failure","validation errors",['error' => validation_errors('<p>','</p>')]));
            return;
		}else{
			$post = $data;
			$story_id = $post['story_id'];
			unset($post['story_id']);

			$data_array = array();
					$this->load->model("brickstory_model");
					// $folderPath = "./assets/uploads/sub_brickstory_images/";
					// $personImage = do_upload('image',$folderPath);
					$data_array = array(
						'master_story_id' => $post['property_id'],
						'from_date' => isset($post['from_date'])?(date('Y-m-d', strtotime(str_replace("/","-",$post['from_date'])))):(''),
						'to_date' => isset($post['to_date'])?(date('Y-m-d', strtotime(str_replace("/","-",$post['to_date'])))):(''),
						'approximate_date' => isset($post['approximate_date'])?(date('Y-m-d', strtotime(str_replace("/","-",$post['approximate_date'])))):(''),
						'setting_id' => $post['setting_id'],
						'season_id' => $post['season_id'],
						'event_id' => $post['event_id'],
						'side_of_house_id' => $post['side_of_house_id'],
						'room_id' => $post['room_id']??0,
						'story_description' => $post['brickstory_desc'],
						'user_id' => $post['user_id'],
						'created_on' => GetCurrentDateTime(),
						'updated_on' => GetCurrentDateTime()
					);

					if (!empty($post['image']) && strpos($post['image'], "http") === false && strpos($post['image'], "https") === false) {

						$base64String = $post['image'];
						// Specify the path where the image should be saved
					   $outputFile = './assets/uploads/sub_brickstory_images/';
					   $filename = saveBase64Image($base64String, $outputFile);
					   $data_array['story_photo'] = $filename;
		
					}else{
						if(isset($post['image']) && $post['image'] == ""){
							unset($post['image']);
						}
					}
					$lastId = $this->sqlmodel->updateRecord("brickstory_substories",$data_array,array("id" => $story_id));
					// query();
					$this->output
            ->set_content_type('application/json')
            ->set_output(json("success","Photo & story updated successfully.",null));
            return;
		}
	}

	public function updateInfo(){

		$fields = array(
			'year_built','house_style_id','architech','square_feet','bedroom_id','material_id','foundation_id','roof_id','Acres','address1','city','state','zip'
		);
		$data = read_set_json_data();

		fv('property_id','property id','required|trim');
		fv('field_value','field value','required|trim');
		fv('field_name','field name','required|trim');
		if($this->form_validation->run() == false){
            $this->output
            ->set_content_type('application/json')
            ->set_output(json("failure","validation errors",['error' => validation_errors('<p>','</p>'),'fields'=>$fields]));
            return;
		}else{
			$post = $data;

		if(!in_array($post['field_name'],$fields)){
			$this->output
            ->set_content_type('application/json')
            ->set_output(json("failure","validation errors",['error' => 'invalid field name','fields'=>$fields]));
            return;
		}


		$this->sqlmodel->updateRecord("brickstory_profile",array($post['field_name']=>$post['field_value']),array("id" => $post['id']));
		$this->output
            ->set_content_type('application/json')
            ->set_output(json("success","Information updated successfully.",null));
            return;
		}
	}


	public function banners(){
		$get_banner = get_banners(1,'Home Banner');
		// $get_banner = get_banner(4,'Home Video');
		$this->output
		->set_content_type('application/json')
		->set_output(json("success","banners",$get_banner));
		return;
	}

}

?>