<?php
error_reporting(-1);
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends My_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->loggedin = loggedin_user();
		$this->load->library('twilio_lib');

		
	}

	function formatPhoneNumber($phone) {
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
			// Invalid number length
			set_msg('error','Invalid phone number.');
			return redirect(base_url('dashboard'));
		}
	}

	public function send_sms($num,$type,$address='',$id=0) {
        // $to = '+1-248-417-0470'; // Recipient's phone number
		$num = $this->formatPhoneNumber($num);
        // $message = 'Hello, this is a test message from CodeIgniter!';
		$link = '';

		if($id != 0){
			$link = base_url('details/view/'.$id);
		}
		if($type == "sub"){
			$message = "You've subscribed to BrickStory alerts for new photos or stories to one of your homes.Msg frequency varies. Msg & data rates may apply. Reply STOP to opt out to BrickStory.com notifications.";
		}

		if($type == "add"){
			$message = "BrickStory.com has a new photo or story added to your home at:
				\n\r
			$address
			\n\r
Please click here $link to see what has been added.";

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

	public function index($page=1)
	{
		$data['title'] = "My Homes";
		$data['filename'] = "dashboard/myhomes";
		$get = get();
		
		$data['get'] = get();
		$where = " where 1 ";

		if($this->input->post("mobitorPhone")){
			$this->sqlmodel->updateRecord("brickstory_profile",array("monitor_home" =>1,"monitor_phone"=>$this->input->post("mobitorPhone")),array("id" => $this->input->post("id")));
			//$check = $this->sqlmodel->getSingleRecord("brickstory_profile",array('id'=>$this->input->post("id")));

			$this->send_sms($this->input->post("mobitorPhone"),'sub');

			return redirect(base_url('dashboard/myhomes'));

		}

		if(isset($get['street']) && $get['street'] != ""){
			$where .= " AND ( address1 like '%".$get['street']."%' OR address2 like '%".$get['street']."%' ) ";

		}

//		$data['houses'] = $this->sqlmodel->getRecords('*','brickstory_profile','','',array("user_id" => $this->loggedin['id']));
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
		if(isset($get['house_style_id']) && $get['house_style_id'] != "0"){
			$where .= " AND (house_style_id='".$get['house_style_id']."') ";
		}
		if(isset($get['bedroom_id']) && $get['bedroom_id'] != "0"){
			$where .= " AND (bedroom_id='".$get['bedroom_id']."') ";
		}
		if(isset($get['roof_id']) && $get['roof_id'] != "0"){
			$where .= " AND (roof_id='".$get['roof_id']."') ";
		}
		if(isset($get['roof_id']) && $get['roof_id'] != "0"){
			$where .= " AND (roof_id='".$get['roof_id']."') ";
		}
		if(isset($get['architect']) && $get['architect'] != ""){
			$where .= " AND (architech like '%".$get['architect']."%') ";
		}
		if(isset($get['owner_name']) && $get['owner_name'] != ""){
			$where .= " AND (owner_name like '%".$get['owner_name']."%') ";
		}
		if(isset($get['material_id']) && $get['material_id'] != "0"){
			$where .= " AND (material_id='".$get['material_id']."') ";
		}
		if(isset($get['foundation_id']) && $get['foundation_id'] != "0"){
			$where .= " AND (foundation_id='".$get['foundation_id']."') ";
		}
		$RECORD_PER_PAGE = 21;

		$page = ($page >=0)?($page - 1):($page);
		$start = ($page * $RECORD_PER_PAGE);
		$data['limit'] = $RECORD_PER_PAGE;
		$data['page'] = $page;
		$data['real_page']=$page;


		if (isset($this->search_term) && $this->search_term != "") {
			$this->db->like("LOWER(R.address1)", strtolower($this->search_term));
		}
		if (isset($this->sort_by) && $this->sort_by != "" && $this->sort_order != "") {
			$this->db->order_by('R.' . $this->sort_by, $this->sort_order);
		}
		if (isset($this->record_per_page) && isset($this->offset) && !isset($this->_record_count) && $this->_record_count != true) {
			$this->db->limit((int)$this->record_per_page, (int)$this->offset);
		}
		//$ci = & get_instance();
		$user_id = false;
		
		if (isset($this->session->userdata['user_id'])) {
			$user_id = $this->session->userdata['user_id'];
		}

		// $this->db->select('R.*');
		// $this->db->order_by('R.id','desc');
		// $this->db->from('brickstory_profile AS R');
		// if($user_id && $user_id != 1){
		// 	$this->db->where('R.user_id', $user_id);
		// }
		// $this->db->limit($data['limit'],$start);
		// $query = $this->db->get();

		$sqlQuery = "select R.* from brickstory_profile AS R  ";
		$sqlQuery .= $where;

		if($user_id && $user_id != 1){
			$sqlQuery .=  " and R.user_id = ".$user_id;
		}
		$sqlQuery .= " ORDER BY R.id limit $start,".$data['limit'];
		$query = $this->sqlmodel->runQuery($sqlQuery);

		$lastQuery = query('',1);

		$data['houses'] = $query;


		$explodeQuery = explode("limit",$lastQuery);

		if(isset($explodeQuery[0])){
			$countResult = $this->sqlmodel->runQuery($explodeQuery[0]);
		}else{
			$countResult = $this->sqlmodel->runQuery($explodeQuery);
		}

		if($countResult){
			$data['count'] = count($countResult);
		}else{
			$data['count'] = 0;
		}
		$data['total_pages'] = ceil($data['count']/$data['limit']);
		$data['bedroom'] = array(
			"1" => "1",
			"2" => "2",
			"3" => "3",
			"4" => "4",
			"5" => "5",
			"6" => "6",
			"7" => "7",
			"8" => "8",
			"9" => "9",
			"10+" => "10+",
		);
		$data['house_style'] = get_dropdown_value('house_style');
		$data['material'] = get_dropdown_value('material');
		$data['foundation'] = get_dropdown_value('foundation');
		$data['roof'] = get_dropdown_value('roof');

		//$data['houses'] = array();
		$data['user'] = $this->loggedin;
		$this->load->view('layout',$data);
	}

	

	public function updatePropertyStatus(){
		$post = $this->input->post();
		$check = $this->sqlmodel->getSingleRecord("brickstory_profile",array('id'=>$post['id']));
		
		if($this->session->userdata('admin_user_id') && ($this->session->userdata('admin_user_id') == 1)){
			$this->sqlmodel->updateRecord("brickstory_profile",array("status" => $post['status']),array('id'=>$post['id']));
			json("success","Property status is updated successfully",null);
		}else{
			if($this->session->userdata('user_id') == $check['user_id']){
				$this->sqlmodel->updateRecord("brickstory_profile",array("status" => $post['status']),array('id'=>$post['id']));
				json("success","Property status is updated successfully",null);
			}else{
				json("failure","Something went wrong",null);
			}
		}

	}
	public function deleteProperty($profile_id){
		$check = $this->sqlmodel->getSingleRecord("brickstory_profile",array('id'=>$profile_id));
		if($this->session->userdata('admin_user_id') && ($this->session->userdata('admin_user_id') == 1)){
			$this->sqlmodel->deleteRecord("brickstory_profile",array('id'=>$profile_id));
			set_msg('success','Property has been deleted successfully!');
		}else{
			if($this->session->userdata('user_id') == $check['user_id']){
				$this->sqlmodel->deleteRecord("brickstory_profile",array('id'=>$profile_id));
				set_msg('success','Property has been deleted successfully!');
			}else{
				set_msg('error','Something went wrong!');
			}
		}

		redirect(base_url('dashboard/1'));

	}

	public function addHome()
	{
		$this->form_validation->set_rules('address1', 'Address1', 'required|trim|max_length[255]');
		$this->form_validation->set_rules('city', 'City', 'trim|max_length[50]');
		$this->form_validation->set_rules('owner_name', 'Owner Name', 'trim|max_length[60]');
		$this->form_validation->set_rules('architech', 'Architech', 'trim|max_length[255]');
		$this->form_validation->set_rules('square_feet', 'Square Feet', 'trim|max_length[15]');
		$this->form_validation->set_rules('address2', 'Address2', 'trim|max_length[255]');
		$this->form_validation->set_rules('state', 'State', 'trim|max_length[50]');
		$this->form_validation->set_rules('zip', 'Zip', 'trim|max_length[11]');
		$this->form_validation->set_rules('year_built', 'Year Built', 'trim|max_length[10]');
		$this->form_validation->set_rules('house_style_id', 'House Style', 'trim|max_length[11]');
		$this->form_validation->set_rules('bedroom_id', 'Bedroom', 'trim|max_length[11]');
		$this->form_validation->set_rules('material_id', 'Material', 'trim|max_length[11]');
		if($this->form_validation->run() == false){

			$data['title'] = "NEW BRICKSTORY";
			$data['filename'] = "dashboard/addHome";
			$data['user'] = $this->loggedin;
			$data['bedroom'] = array(
				"0" => "Please Select",
				"1" => "1",
				"2" => "2",
				"3" => "3",
				"4" => "4",
				"5" => "5",
				"6" => "6",
				"7" => "7",
				"8" => "8",
				"9" => "9",
				"10+" => "10+",
			);
			$data['house_style'] = get_dropdown_value('house_style');
			$data['material'] = get_dropdown_value('material');
			//$data_array['home_profile_photo'] = @$file_name;
			$this->load->view('layout', $data);
		}else{
			$post = post();

			if($_FILES['image']){
				$file_name = do_upload('image','./assets/uploads/brickstory_images/');
				if($file_name != "error"){
					$post['home_profile_photo'] = $file_name['upload_data']['file_name'];
				}else{
					$post['home_profile_photo'] = 'story.jpg';
				}

			}
			if($post['from_date'] != ""){
				$post['from_date'] = date("Y-m-d",strtotime(str_replace("/","-",$post['from_date'])));
			}

			if($post['to_date'] != ""){
				$post['to_date'] = date("Y-m-d",strtotime(str_replace("/","-",$post['to_date'])));

			}
			$post['user_id'] = $this->session->userdata("user_id");
			$profile_id = $this->sqlmodel->insertRecord("brickstory_profile",$post);
			if($profile_id){
				set_msg('success','Brickstory added successfully.');
				redirect(base_url("dashboard/addPhotoStory/".$profile_id));
			}else{
				set_msg('error','Something went wrong.');
				redirect(base_url('dashboard'));

			}
		}
	}

	public function homeDetails($id='')
	{
		$data['title'] = "View Brickstory";
		$data['filename'] = "dashboard/homeDetails";
		$data['user'] = $this->loggedin;
		$data['homeId'] = $id;
		$home = $this->sqlmodel->getSingleRecord('brickstory_profile',array('id' => $id));
		
		if(!$home){
			set_msg('error','Something went wrong.');
			redirect(base_url('dashboard'));
		}
		$data['livedhere'] = $this->sqlmodel->getSingleRecord("brickstory_livedhere",array("master_story_id" => $id,"user_id" => $this->session->userdata("user_id")));

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
			redirect(base_url('dashboard/homeDetails/'.$id));
		}

		//-------------

		$data['home'] = getHomeDetails($id);
		$data['bedroom'] = array(
			"0" => "Please Select",
			"1" => "1",
			"2" => "2",
			"3" => "3",
			"4" => "4",
			"5" => "5",
			"6" => "6",
			"7" => "7",
			"8" => "8",
			"9" => "9",
			"10+" => "10+",
		);
		// ------------- get Sub Records ----------
		$id = intval($id);
		$this->db->select('S.*, 
		D1.value as season_value,
		D2.value as event_value, 
		D3.value as side_of_house_value, 
		D4.value as room_value,
		');
		$this->db->from('brickstory_substories  as S');
		$this->db->join('brickstory_dropdown_value as D1', 'S.season_id = D1.id', 'left');
		$this->db->join('brickstory_dropdown_value  as D2', 'S.event_id = D2.id', 'left');
		$this->db->join('brickstory_dropdown_value as D3', 'S.side_of_house_id = D3.id', 'left');
		$this->db->join('brickstory_dropdown_value as D4', 'S.room_id = D4.id', 'left');
		$this->db->where('S.master_story_id', $id);
		$this->db->order_by('id', 'asc');
		$result = $this->db->get();
		//var_dump($this->db);exit;
		$data['sub_stories'] = $result->result_array();
		$data['states'] = state_array();
		$this->load->view('layout',$data);
	}

	public function addPhotoStory($id='')
	{
		fv("setting_id","setting","trim");
		fv("event_id","event","trim");
		fv("side_of_house_id","side of house","required|trim");
		fv("room_id","room","required|trim");
		fv("brickstory_desc","brickstory description","required|trim");
		fv("approximate_date","approximate date","required|trim");
		if($this->form_validation->run() == false){

			$data['title'] = "View Brickstory";
			$data['filename'] = "dashboard/addstory";
			$data['user'] = $this->loggedin;
			$data['homeId'] = $id;
			$data['home'] = $this->sqlmodel->getSingleRecord('brickstory_profile', array('id' => $id));
			$data['season'] = get_dropdown_value('season');
			$data['setting'] = get_dropdown_value('setting');
			$data['side_of_house'] = get_dropdown_value('side_of_house');
			$data['room'] = get_dropdown_value('room');
			$data['events'] = get_dropdown_value('event');
			if (!$data['home']) {
				set_msg('error', 'Something went wrong.');
				redirect(base_url('dashboard'));
			}
			$this->load->view('layout',$data);
		}else{
			$id = intval($id);
			$post = post();

					$data_array = array();
					$this->load->model("brickstory_model");
					$folderPath = "./assets/uploads/sub_brickstory_images/";
					$personImage = do_upload('image',$folderPath);
					$data_array = array(
						'master_story_id' => $id,
						'from_date' => isset($post['from_date'])?(date('Y-m-d', strtotime($post['from_date']))):(''),
						'to_date' => isset($post['to_date'])?(date('Y-m-d', strtotime($post['to_date']))):(''),
						'approximate_date' => isset($post['approximate_date'])?(date('Y-m-d', strtotime($post['approximate_date']))):(''),
						'setting_id' => $post['setting_id'],
						'season_id' => $post['season_id'],
						'event_id' => $post['event_id'],
						'story_photo' => $personImage['upload_data']['file_name'],
						'side_of_house_id' => $post['side_of_house_id'],
						'room_id' => $post['room_id'],
						'story_description' => $post['brickstory_desc'],
						'user_id' => $this->session->userdata("user_id"),
						'created_on' => GetCurrentDateTime(),
						'updated_on' => GetCurrentDateTime()
					);


					$check = $this->sqlmodel->getSingleRecord("brickstory_profile",array('id'=>$id));
					if($check['monitor_home'] == 1){
						$addressToSend = $check['address1'].'\n\r'.$check['city'].', '.$check['state'].', '.$check['zip'];
						$this->send_sms($check['monitor_phone'],'add',$addressToSend,$id);
					}
					$lastId = $this->brickstory_model->save_substory_record($data_array);
					redirect(base_url('dashboard/homeDetails/') . $id);


		}



	}

	public function addPeople($id='')
	{
		fv('first_name','first name','required|trim');
		fv('last_name','last name','required|trim');
		fv('relation_id','relation','required|trim');
		fv('from_date','from date','required|trim');
		fv('to_date','to date','trim');
		fv('born_date','born date','required|trim');
		fv('died_date','died date','trim');
		if($this->form_validation->run() == false){
			$data['title'] = "View Brickstory";
			$data['filename'] = "dashboard/addpeople";
			$data['user'] = $this->loggedin;
			$data['homeId'] = $id;
			$data['home'] = $this->sqlmodel->runQuery("select * from brickstory_profile where id=" . $id, 1);
			$this->load->view('layout', $data);
		}else{

			$post = post();
			$folderPath = "./assets/uploads/peoples/";

			$personImage = do_upload('image',$folderPath);
			$info_Array = array(
				'user_id' => $this->session->userdata('user_id'),
				'master_story_id' => $id,
				'frist_name' => $post['first_name'],
				'last_name' => $post['last_name'],
				'relation_id' => $post['relation_id'],
				'from_date' => date('Y-m-d', strtotime($post['from_date'])),
				'to_date' => date('Y-m-d', strtotime($post['to_date'])),
				'born_date' => date('Y-m-d', strtotime($post['born_date'])),
				'died_date' => date('Y-m-d', strtotime($post['died_date'])),
				'person_photo' => $personImage['upload_data']['file_name'],
				'living' => ($post['living'] == "Yes")?(1):(0)
			);
			$this->sqlmodel->insertRecord("brickstory_person",$info_Array);
			msg('success-popup','Person added successfully!');
			redirect(base_url('dashboard/viewPeople/'.$id));
		}
	}

	public function update_people_image() {
        $post = post();
		$folderPath = "./assets/uploads/peoples/";

		$personImage = do_upload('image',$folderPath);

		$info_Array = array(
			'person_photo' => $personImage['upload_data']['file_name'],
		);
		$this->sqlmodel->updateRecord("brickstory_person",$info_Array,array("id" => $post['data_id']));
    }

	public function viewPeople($id='')
	{

		$data['title'] = "View People";
		$data['filename'] = "dashboard/viewPeople";
		$data['user'] = $this->loggedin;
		$data['homeId'] = $id;
		$id = intval($id);
		$this->db->select('S.*, R1.value as relation_value');
		$this->db->from('brickstory_person as S');
		$this->db->join('brickstory_dropdown_value as R1', 'S.relation_id = R1.id', 'left');
		$this->db->where('S.master_story_id', $id);
		$this->db->order_by('id', 'asc');
		$data['result'] = $this->db->get();
		
		$data['home'] = getHomeDetails($id);
		
		if(!$data['home']){
			redirect(base_url());
		}
		$this->load->view('layout',$data);
	}

	public function viewStory($id='')
	{
		$data['title'] = "View Brickstory";
		$data['filename'] = "dashboard/viewStories";
		$data['user'] = $this->loggedin;
		$data['homeId'] = $id;
		$this->load->view('layout',$data);
	}

	public function viewTimeLine($id='')
	{

		$this->load->model("user_timeline_model");
		$this->load->model("myhomes_model");
		// ------- Timeline Code started from here ---------
		$livedhere = $this->sqlmodel->getSingleRecord("brickstory_livedhere",array("master_story_id" => $id,"user_id" => $this->session->userdata("user_id")));

	
		if(post('from_date')){
			$lived_here = (post('user_lived_here') == 1)?(1):(0);
			$info = array(
				'from_date' => date("m-d-Y",strtotime(str_replace("/","-",post('from_date')))),
				'to_date' => (post('to_date') != "")?date("Y-m-d",strtotime(str_replace("/","-",post('to_date')))):"",
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
			redirect(base_url('dashboard/viewTimeLine/'.$id));
		}


		$state_array = state_array();
		$sub_timeline = $this->user_timeline_model->get_record_by_id_all_user($id);
		$records = $this->myhomes_model->get_record_by_id($id);
		$sub_persons = $this->myhomes_model->get_persons1($id);
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
		$scroll = 0;

		$data = array(
			'sub_timeline' => $sub_timeline,
			'ency_id' => $id,
			'records'=>$records,
			'sub_persons' => $sub_persons,
			'setting' => $setting,
			'season' => $season,
			'event' => $event,
			'side_of_house' => $side_of_house,
			'room' => $room,
			'setting_json' => $this->get_json1($setting),
			'season_json' => $this->get_json1($season),
			'event_json' => $this->get_json1($event),
			'side_of_house_json' => $this->get_json1($side_of_house),
			'room_json' => $this->get_json1($room),
			'scroll' => $scroll,
		);
		$data['home'] = getHomeDetails($id);
		$data['livedhere'] = $livedhere;
		$data['title'] = "View Brickstory";
		$data['filename'] = "dashboard/viewTimeLine";
		$data['user'] = $this->loggedin;
		$data['homeId'] = $id;
		// ------ Time line code end here ------------------

		$this->load->view('layout',$data);
	}
	public function myTimeLine()
	{

		$user_id = $this->session->userdata("user_id");
		$this->load->model("user_timeline_model");
		$this->load->model("myhomes_model");
		// ------- Timeline Code started from here ---------


		$state_array = state_array();
		$sub_timeline = $this->user_timeline_model->get_record_by_id_all_user($user_id,'user');
		$records = $this->myhomes_model->get_record_by_id($user_id);
		$sub_persons = $this->myhomes_model->get_persons1($user_id,'user');
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

		$scroll = 0;

		$data = array(
			'sub_timeline' => $sub_timeline,
			'ency_id' => $user_id,
			'records'=>$records,
			'sub_persons' => $sub_persons,
			'setting' => $setting,
			'season' => $season,
			'event' => $event,
			'side_of_house' => $side_of_house,
			'room' => $room,
			'setting_json' => $this->get_json1($setting),
			'season_json' => $this->get_json1($season),
			'event_json' => $this->get_json1($event),
			'side_of_house_json' => $this->get_json1($side_of_house),
			'room_json' => $this->get_json1($room),
			'scroll' => $scroll
		);

		$data['title'] = "My Timeline";
		$data['filename'] = "dashboard/userTimeLine";
		$data['user'] = $this->loggedin;

		// ------ Time line code end here ------------------

		$this->load->view('layout',$data);
	}
	function get_json1($param) {
		$temp = "[";
		foreach ($param as $key => $value) {
			$temp .= "{value: " . $key . ", text:'" . str_replace("'", "\'", $value). "'},";
		}
		$temp.="]";

		return $temp;
	}
	public function myprofile()
	{
		fv("firstname",'first name','required|trim');
		fv("lastname",'first name','required|trim');
		fv("email",'first name','required|trim|valid_email');
		if($this->form_validation->run() == false){
			$data['title'] = "My Profile";
			$data['filename'] = "dashboard/myprofile";
			$data['user'] = $this->loggedin;
			//pre($data['user']);
			$this->load->view('layout', $data);
		}else{
			$post = post();
			if($post['password'] && $post['password'] != ""){
				$post['password'] = encriptsha1(post('password'));
			}else{
				unset($post['password']);
			}
			if($_FILES['image']){
				pre($_FILES,0);
				$file_name = do_upload('image','./assets/uploads/user_images/');
				if(isset($file_name['upload_data']['file_name'])) {
					$post['profile_photo'] = $file_name['upload_data']['file_name'];
				}
			}
			$user_id = $this->sqlmodel->updateRecord("users",$post,array("id" => $this->session->userdata('user_id')));
			if($user_id){
					set_msg('success','Information updated successfully');
				}else{
				set_msg('error','Something went wrong.');
			}
			redirect(base_url('dashboard/myprofile'));
		}
	}

	public function updateTimelineImage(){
		$post = post();
		//story_id
		$folderPath = "./assets/uploads/sub_brickstory_images/";
		$file = do_upload('image',$folderPath);
		if(isset($file['upload_data']['file_name'])){
			$this->sqlmodel->updateRecord("brickstory_substories",array('story_photo'=>$file['upload_data']['file_name']),array("id" => $post['story_id']));
			set_msg('success','Story image updated successfully.');
		}else{
			set_msg('error-popup','Something went wrong.');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	public function upload_image(){
		if(get('dataid') && get('dataid') == "addProperty"){
			$folderPath = "./assets/uploads/brickstory_images/";
		}elseif(get('dataid') == "story_photo"){
			$folderPath = "./assets/uploads/sub_brickstory_images/";
		}else{
			$folderPath = "./assets/uploads/user_images/";
		}
		$returnText = "";

		$image_parts = explode(";base64,", post('image'));
		$image_type_aux = explode("image/", $image_parts[0]);
		$image_type = $image_type_aux[1];
		$image_base64 = base64_decode($image_parts[1]);

		$imageName = uniqid() . '.png';

		$imageFullPath = $folderPath.$imageName;

		file_put_contents($imageFullPath, $image_base64);


				$returnText = base_url($folderPath);
				$dataInfo = array(
					'profile_photo' => $imageName
				);

				//------- Compress Image ------
		$filename = $imageName;
		// Valid extension
		$valid_ext = array('png', 'jpeg', 'jpg');
		// Location
		$location = $folderPath.'crop/' . $imageName;
		// file extension
		$file_extension = pathinfo($location, PATHINFO_EXTENSION);
		$file_extension = strtolower($file_extension);
		// Check extension
		if (in_array($file_extension, $valid_ext)) {
			// Compress Image
			compressImage($folderPath . $imageName, $location, 60);

		}


		$this->sqlmodel->updateRecord("users",$dataInfo,array("id" => $this->session->userdata("user_id")));

		if(get('dataid') && get('dataid') == "addProperty") {
			$data['uploadPath'] = $imageName;
		}
		if(get('dataid') && get('dataid') == "story_photo") {
			$data['uploadPath'] = $imageName;
		}
		$data['status'] = "Image Uploaded Successfully";
		$data['profile_photo'] = base_url($folderPath).$imageName;
		echo json_encode($data);
	}
	public function upload_person_image(){
		$folderPath = "./assets/uploads/peoples/crop/";
		$folderPath1 = "./assets/uploads/peoples/";
		$returnText = "";
		$this->load->model("myhomes_model");

		$image_parts = explode(";base64,", post('image'));
		$image_type_aux = explode("image/", $image_parts[0]);
		$image_type = $image_type_aux[1];
		$image_base64 = base64_decode($image_parts[1]);

		$imageName = uniqid() . '.png';

		$imageFullPath = $folderPath.$imageName;
		$imageFullPath1 = $folderPath1.$imageName;

		file_put_contents($imageFullPath, $image_base64);
		file_put_contents($imageFullPath1, $image_base64);


		$returnText = base_url($folderPath);

		$data_array = array(
			'id' => get("dataid"),
			'file_name' => $imageName
		);
		$result = $this->myhomes_model->update_new_sub_person_image($data_array);

		echo json_encode(array('success'=>'Image Uploaded Successfully','profile_photo' => ASSETS.'uploads/peoples/crop/'.$imageName));
	}
	public function updateInfo(){
		$post = post();
		$this->sqlmodel->updateRecord("brickstory_profile",array($post['name']=>$post['value']),array("id" => $post['pk']));
	}
	public function updateTimeLineInfo(){
		$post = post();
		$this->sqlmodel->updateRecord("brickstory_substories",array($post['name']=>$post['value']),array("id" => $post['pk']));
	}
	public function getStats(){
		if(get("state")){
			echo json_encode(state_array());
		}else if(get('house_style')){
			echo json_encode(get_dropdown_value('house_style'));
		}else if(get('bedroom')){
			$bedroom = array(
				0 => "Please Select",
				1 => "1",
				2 => "2",
				3 => "3",
				4 => "4",
				5 => "5",
				6 => "6",
				7 => "7",
				8 => "8",
				9 => "9",
				"10+" => "10+",
			);
			echo json_encode($bedroom);
// 			echo json_encode(get_dropdown_value('room'));

		}else if(get('material')){
			echo json_encode(get_dropdown_value('material'));
		}else if(get('relation')){
			echo json_encode(getRelations('relation'));
		}else if(get('event')){
			echo json_encode(get_dropdown_value('event'));
		}else if(get('roof')){
			echo json_encode(get_dropdown_value('roof'));
		}else if(get('foundation')){
			echo json_encode(get_dropdown_value('foundation'));
		}elseif(get('setting')){
			echo json_encode(get_dropdown_value('setting'));
		}elseif(get('season')){
			echo json_encode(get_dropdown_value('season'));
		}elseif(get('side_of_house')){
			echo json_encode(get_dropdown_value('side_of_house'));
		}elseif(get('room')){
			$room = get_dropdown_value('room');
			$room = array(0 => "Please Select") + $room;
			echo json_encode($room);
		}
	}
	public function updatePerson(){
		$this->load->model("myhomes_model");
		$data = post();
		$sub_data = $data['name'];
		$sub_person_id = $data['pk'];
		if($sub_data == 'first_name')
		{
			$frist_name = $data['value'];
			$data_array = array(
				'person_id' => $sub_person_id,
				'frist_name' => $frist_name
			);
		}
		if($sub_data == 'last_name')
		{
			$last_name = $data['value'];
			$data_array = array(
				'person_id' => $sub_person_id,
				'last_name' => $last_name
			);
		}
		if($sub_data == 'from_date')
		{
			$from_date = $data['value'];
			$from_date = date('Y-m-d', strtotime($data['value']));
			$data_array = array(
				'person_id' => $sub_person_id,
				'from_date' => $from_date
			);
		}
		if($sub_data == 'to_date')
		{
			$to_date = $data['value'];
			$to_date = date('Y-m-d', strtotime($data['value']));
			$data_array = array(
				'person_id' => $sub_person_id,
				'to_date' => $to_date
			);
		}
		if($sub_data == 'born_date')
		{
			$born_date = $data['value'];
			$born_date = date('Y-m-d', strtotime($data['value']));
			$data_array = array(
				'person_id' => $sub_person_id,
				'born_date' => $born_date
			);
		}
		if($sub_data == 'died_date')
		{
			$died_date = $data['value'];
			if(strtotime($died_date) != false)
			{
				$died_date = date('Y-m-d', strtotime($data['value']));
			}
			$data_array = array(
				'person_id' => $sub_person_id,
				'died_date' => $died_date
			);
		}
		if($sub_data == "relation_id"){
			$relation_id = $data['value'];
			$data_array = array(
				'person_id' => $sub_person_id,
				'relation_id' => $relation_id
			);
			$result = $this->myhomes_model->update_new_sub_person_relation_id($data_array);
		}else {
			$result = $this->myhomes_model->update_persons($data_array);
		}
	}
	public function uploadPropertyImage($home_id){
//		$file           =   $_FILES['file']['name'];
		//home_profile_photo
		//brickstory_profile
		$file_name = do_upload('file','./assets/uploads/brickstory_images/');

		if(isset($file_name['upload_data']['file_name'])){
			$imageName = $file_name['upload_data']['file_name'];
			$updated = $this->sqlmodel->updateRecord("brickstory_profile",array("home_profile_photo" => $imageName),array("id" => $home_id));
			if($updated){
				echo 1;
			}else{
				echo 0;
			}
		}else{
			echo 2;
		}
	}

	public function turnOffNotification($num){
	
		$check = $this->sqlmodel->getSingleRecord('brickstory_profile',array('id' => $num,'user_id'=>$this->session->userdata('user_id')));	
		if($check){
			$this->sqlmodel->updateRec('brickstory_profile',array('monitor_home' => '0','monitor_phone' => NULL),array('id' => $check['id']));
			set_msg('success','Notifications turned of successfully!');
			return redirect(base_url('dashboard'));
		}else{
			set_msg('error','Property is not associated with you!');
			return redirect(base_url('dashboard'));
		}
	}
}

