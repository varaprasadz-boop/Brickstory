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

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }


    public function login() {

       
        $data = read_set_json_data();
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json("failure","validation errors",['error' => validation_errors('<p>','</p>')]));
            return;
        }
        
        $user = $this->sqlmodel->getSingleRecord('users',array('email' => $data['email'],'password' => encriptsha1(($data['password']))));
        $user['profile_photo'] = base_url("assets/uploads/user_images/".$user['profile_photo']); 
   
        if(isset($user['email'])){        
            $this->output
                ->set_content_type('application/json')
                ->set_output(json("success","Login successful",$user));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json("failure","login failure",['error' => 'Invalid email or password']));
        }
    }


    public function register(){

        $data = read_set_json_data();
		fv('firstname','first name','required|trim');
		fv('lastname','last name','required|trim');
		// fv('email','email','required|trim|is_unique[users.email]');
		$this->form_validation->set_rules('email', 'email', 'required|valid_email|is_unique[users.email]', [
            'required' => 'The email field is required.',
            'valid_email' => 'Please provide a valid email address.',
            'is_unique' => 'The email address is already exist.'
        ]);
		fv('password', 'Password', 'required|trim');
        // fv('confirm_password', 'Password', 'required|matches[password]');

		if($this->form_validation->run() == false){
            $this->output
            ->set_content_type('application/json')
            ->set_output(json("failure","validation errors",['error' => validation_errors('<p>','</p>')]));
        return;
		}else{
			$post = $data;
            if(isset($post['confirm_password'])){
                unset($post['confirm_password']);
            }

			$post['status'] = 0;
			$post['password'] = encriptsha1($post['password']);
			$post['role_id'] = (int) get_settings('BIZ_DEFAULT_USER_ROLE_ID', '2');
			$post['activation_code'] = get_random_string();
			$hours = (int) get_settings('BIZ_ACTIVATION_EXPIRY_HOURS', '24');
			$post['activation_expiry'] = date('Y-m-d H:i:s', strtotime("+{$hours} hours", now()));
			$user_id = $this->sqlmodel->insertRecord("users",$post);

			$post['emailContent'] = $this->sqlmodel->getSingleRecord("email_template",array("template_name" => "registration_template"));


			$post['template_path'] = "email_templates/email_signup";
			$post['subject'] = $post['emailContent']['template_subject'];
			$post['activation_url'] = base_url('account/verify_account/'.md5($user_id));

			send_email($post);

            $this->output
            ->set_content_type('application/json')
            ->set_output(json("success","Registration completed successfully.",null));
        return;
		}
	}

    public function profile()
	{

        $data = read_set_json_data();
    
		fv("user_id",'user id','required|trim');
        fv("firstname",'first name','required|trim');
		fv("lastname",'first name','required|trim');
		fv("email",'first name','required|trim|valid_email');
        fv("address",'address','required|trim');
        fv("city",'city','required|trim');
        fv("state",'state','required|trim');
        fv("zip",'zipcode','required|trim');
        fv("password",'password','trim');
		if($this->form_validation->run() == false){
            $this->output
            ->set_content_type('application/json')
            ->set_output(json("failure","validation errors",['error' => validation_errors('<p>','</p>')]));
            return;
		}else{
			$post = $data;
            $user_id = $post['user_id'];
            unset($post['user_id']);
			if(isset($post['password']) && $post['password'] != ""){
				$post['password'] = encriptsha1($post['password']);
			}
			unset($post['password']);
			if(isset($post['image'])){
				//$file_name = do_upload('image','./assets/uploads/user_images/');
                $base64String = $post['image'];
                 // Specify the path where the image should be saved
                $outputFile = './assets/uploads/user_images/';
                $filename = saveBase64Image($base64String, $outputFile);
                // echo "Image saved successfully to: " . $outputFile;

				// if(isset($file_name['upload_data']['file_name'])) {
					$post['profile_photo'] = $filename;
				// }
			}
			$update = $this->sqlmodel->updateRecord("users",$post,array("id" => $user_id));
            $user = $this->sqlmodel->getSingleRecord("users",array("id" => $user_id));
			if($update){
                $this->output
                ->set_content_type('application/json')
                ->set_output(json("success","information updated successfully!",$user));
                return;
			}else{
                $this->output
                ->set_content_type('application/json')
                ->set_output(json("failure","something went wrong",['error' => 'something went wrong!']));
                return;	
			}
		}
	}

    public function forgot_password()
	{
        $data = read_set_json_data();
		fv('email','email','required|trim|valid_email');
        
		if($this->form_validation->run() == false){
            $this->output
            ->set_content_type('application/json')
            ->set_output(json("failure","validation errors",['error' => validation_errors('<p>','</p>')]));
            return;
		}else{

			$user = $this->sqlmodel->getSingleRecord('users',array('email' => $data['email']));
			if(isset($user['email'])){
				$post = $user;

				$post['emailContent'] = $this->sqlmodel->getSingleRecord("email_template",array("template_name" => "forgot_password_email_template"));

				$post['template_path'] = "email_templates/email_forgotPassword";
				$post['subject'] = $post['emailContent']['template_subject'];
				$post['company_name'] = $user['firstname'].' '.$user['lastname'];
				//$this->sqlmodel->updateRecord("users", array("reset_pass_expire" => time() + 3600), array("id" => $user['id']));
				$token = bin2hex(random_bytes(32));
				$minutes = (int) get_settings('BIZ_RESET_TOKEN_EXPIRY_MINUTES', '60');
				$this->sqlmodel->updateRecord(
					'users',
					array(
						'reset_token' => $token,
						'reset_token_expiry' => date('Y-m-d H:i:s', strtotime("+{$minutes} minutes")),
					),
					array('id' => $user['id'])
				);
				$post['link'] = base_url('account/reset_password/' . $token);
				send_email($post);
				
                $this->output
                ->set_content_type('application/json')
                ->set_output(json("success","password reset email has been sent successfully!",null));
                return;

			} else {
                $this->output
                ->set_content_type('application/json')
                ->set_output(json("failure","Invalid email address",null));
                return;
			}
		
		}
	}

    public function my_homes($user_id=0,$page=1)
	{
		$get = get();
		$lat = isset($get['lat'])?($get['lat']):('');
		$lng = isset($get['lng'])?($get['lng']):('');
		$data['get'] = get();
		$dis = (int) get_settings('BIZ_DEFAULT_SEARCH_RADIUS_MILES', '10000');
		$data['pagelink'] = $page;
		$page = ($page >=0)?($page - 1):($page);
		$start = ($page * get_settings('BIZ_RECORDS_PER_PAGE', get_settings('RECORD_PER_PAGE', 12)));
		$data['limit'] = get_settings('BIZ_RECORDS_PER_PAGE', get_settings('RECORD_PER_PAGE', 12));
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
        $where .= " AND (user_id='".$user_id."')";
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
                ->set_output(json("success","My homes listing",$data));
                return;

	}

    public function my_timeline($user_id=0){
		$timeline= array();
		$this->load->model("user_timeline_model");
		$this->load->model("myhomes_model");
		// ------- Timeline Code started from here ---------

	
		$apprx_1 = '1900-01-01';
		// $apprx_1 = '1000-01-01';
		// echo'im from here';
		$start = $month = @strtotime('1900-01-01');
		$end = strtotime(date("Y-m-d"));
		$end = strtotime("+1 days", $end);
		$apprx_2 = date("Y-m-d");  
			while($month < $end)
			{

					if($apprx_1 != '' && $apprx_2 != '')
					{

						$ci =& get_instance();
						//$ci->load->model('myhomes_model');
						$dfg = $ci->myhomes_model->getLivedInTimeline($user_id,$apprx_1,$apprx_2,'user');
						$er=100;
						foreach ($dfg as $khr => $timelinepersons)
						{
							if(date('Y',$month) == date('Y',strtotime($timelinepersons['from_date'])) && date('M',$month) == date('M',strtotime($timelinepersons['from_date']))){
								$timelinepersons['action'] = "Moved In";
								if($timelinepersons['lived_here'] == 1) {
									$timelinepersons['action_2'] =  'Currently Living Here';
								}else{
									$timelinepersons['action_2'] =  'Moved Out';
								}
								$timelinepersons['home_profile_photo'] = "https://brickstory.com/assets/uploads/brickstory_images/".$timelinepersons['home_profile_photo'];
 								$timeline[] = $timelinepersons;
								
							}
						}

					}

				$month = strtotime("+1 month", $month);
			} // while end


			

        $this->output
        ->set_content_type('application/json')
        ->set_output(json("success","My brickstory timeline",$timeline));
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

    public function update_profile_image(){

        $data = read_set_json_data();
		fv('user_id','first name','required|trim');
		fv('profile_image','last name','required|trim');

		if($this->form_validation->run() == false){
            $this->output
            ->set_content_type('application/json')
            ->set_output(json("failure","validation errors",['error' => validation_errors('<p>','</p>')]));
            return;
		}else{

            $post = $data;

			if($post['profile_image']){

				$base64String = $post['profile_image'];
				// Specify the path where the image should be saved
			   $outputFile = './assets/uploads/user_images/';
			   $filename = saveBase64Image($base64String, $outputFile);
			   $post['profile_photo'] = $filename;

			}


            $this->sqlmodel->updateRecord("users", array("profile_photo"=>$post['profile_photo']),array("id" => $post['user_id']));
			$user = $this->sqlmodel->getSingleRecord("users",array("id" => $post['user_id']));

			$user['profile_photo'] = base_url("/assets/uploads/user_images/".$user['profile_photo']);
            $this->output
            ->set_content_type('application/json')
            ->set_output(json("success","Profile Image updated successfully.",$user));
            return;

        }

    }

}


?>