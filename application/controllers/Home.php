<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->library('twilio_lib');
    }

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	// public function send_sms() {
    //     $to = '+1-248-417-0470'; // Recipient's phone number
    //     $message = 'Hello, this is a test message from CodeIgniter!';

    //     $result = $this->twilio_lib->send_sms($to, $message);
    //     if ($result) {
    //         echo "Message sent successfully. SID: " . $result;
    //     } else {
    //         echo "Failed to send message.";
    //     }
    // }

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
			return redirect($_SERVER['HTTP_REFERER']);
		}
	}

	public function send_sms($num,$type,$address='') {
		if (get_settings('BIZ_NOTIFY_SMS_ENABLED', '1') !== '1') {
			return;
		}
        // $to = '+1-248-417-0470'; // Recipient's phone number
		$num = $this->formatPhoneNumber($num);
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
		$dailyLimit = (int) get_settings('SMS_DAILY_LIMIT_PER_PHONE', '5');
		if($check_sms_per_day <= $dailyLimit){
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


	public function index($filename='home')
	{
		// $data['title'] = get_settings('SITE_NAME');
		$data['title'] = "Discover and Share the Stories of American Homes | BrickStory.com";
		$data['description'] = "Explore the rich history of American homes on BrickStory.com. Search, document, and share photos and stories of residences across the US. Join our community of preservationists and storytellers today!";
		$data['filename'] = $filename;
		if($filename == "home"){
			$data['recentListing'] = $this->sqlmodel->getRecords('*','brickstory_profile','id','desc','',10,0);
			$data['featureStory'] = $this->sqlmodel->getRecords('brickstory_profile.id,brickstory_substories.story_photo,brickstory_profile.state,brickstory_profile.year_built,brickstory_profile.zip,brickstory_profile.city','brickstory_substories join brickstory_profile on (brickstory_substories.master_story_id = brickstory_profile.id)','id','desc','',5,0);
			$data['storiesCount'] = $this->sqlmodel->countRecords('brickstory_substories');
			$data['peoplesCount'] = $this->sqlmodel->countRecords('brickstory_person');
			$data['housesCount'] = $this->sqlmodel->countRecords('brickstory_profile');
			$sql = "SELECT COUNT(DISTINCT(city)) as total FROM `brickstory_profile`";
			$data['citiesCount'] = $this->sqlmodel->runQuery($sql,1);
		}else if($filename == "architect"){
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
		$this->load->view('layout',$data);
	}

	public function contactus()
	{
		$data['title'] = "Contact Us";
		$data['filename'] = "contact";
		fv("name","name","required|trim");
		fv("email","email","required|trim|valid_email");
		if($this->form_validation->run() == false){
			$this->load->view('layout', $data);
		}else{
			$post = post();
			$post['emailContent'] = $this->sqlmodel->getSingleRecord("email_template",array("template_name" => "contact_us"));
			$post['template_path'] = "email_templates/contactus_email";
			$post['subject'] = $post['emailContent']['template_subject'];
			$post['contactus'] = true;

			send_email($post);
			set_msg('success', 'Thank you so much for contacting us.');
			redirect(base_url('contactus'));
		}
	}

	public function nearme($page=1)
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
		if($lat != "" && $lng != "") {
			$sql = "SELECT *, 3956 * 2 * ASIN(SQRT(
POWER(SIN(($lat - abs(dest.lat)) * pi()/180 / 2), 2) +  COS($lat * pi()/180 ) * COS(abs(dest.lat) * pi()/180) *  POWER(SIN(($lng - dest.lng) * pi()/180 / 2), 2) )) as  distance
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
			$sql = "SELECT * FROM brickstory_profile ".$where;

//			$sql .=" order by id desc limit 100";
			$sql .= " ORDER BY id desc limit $start,".$data['limit'];
			$data['properties'] = $this->sqlmodel->runQuery($sql);

//			$data['properties'] = array();
		}
		$data['title'] = "Search";
		if(get('type') == "map"){
			$data['filename'] = 'nearmemap';
		}else {
			$data['filename'] = 'nearme';
		}
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
		//pre($data['properties']);
		$this->load->view('layout',$data);
	}
	public function houses($page=1)
	{
		$get = get();
		$data['get']= $get;

//		$sql = "SELECT R.*,COUNT(P1.master_story_id) as substory_count , D1.value as house_style_value,D2.value as material_value,D3.value as roof_value,D4.value as foundation_value
//FROM brickstory_profile AS R
//LEFT JOIN `brickstory_dropdown_value` as `D1` ON `R`.`house_style_id` = `D1`.`id`
//LEFT JOIN `brickstory_dropdown_value` as `D2` ON `R`.`material_id` = `D2`.`id`
//LEFT JOIN `brickstory_dropdown_value` as `D3` ON `R`.`roof_id` = `D3`.`id`
//LEFT JOIN `brickstory_dropdown_value` as `D4` ON `R`.`foundation_id` = `D4`.`id`
//LEFT JOIN `brickstory_substories` as `P1` ON `R`.`id` = `P1`.`master_story_id`
//WHERE 1 = 1 ";
		$sql = "SELECT R.* FROM brickstory_profile AS R WHERE 1 = 1 ";

		$countSql = $sql;
		$data['pagelink'] = $page;

		$page = ($page >=0)?($page - 1):($page);
		$start = ($page * get_settings('BIZ_RECORDS_PER_PAGE', get_settings('RECORD_PER_PAGE', 12)));
		$data['limit'] = get_settings('BIZ_RECORDS_PER_PAGE', get_settings('RECORD_PER_PAGE', 12));
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
			$sql .= " AND (square_feet between ".$get['minRangeSquareFeet']." AND ".$get['maxRangeSquareFeet'].") ";
			$countSql .= " AND (square_feet between ".$get['minRangeSquareFeet']." AND ".$get['maxRangeSquareFeet'].") ";
		}elseif(isset($get['minRangeSquareFeet']) && $get['minRangeSquareFeet'] != "1" && $get['maxRangeSquareFeet'] == "10000+"){
			$sql .= " AND (square_feet >=".$get['minRangeSquareFeet']." ) ";
			$countSql .= " AND (square_feet >=".$get['minRangeSquareFeet']." ) ";
		}elseif(isset($get['minRangeSquareFeet']) && $get['minRangeSquareFeet'] == "1" && $get['maxRangeSquareFeet'] <= "10000"){
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

		if(isset($get['house_style_id']) && $get['house_style_id'] != "0"){
			$sql .= " AND (house_style_id =".$get['house_style_id'].") ";
			$countSql .= " AND (house_style_id =".$get['house_style_id'].") ";
		}

		if(isset($get['bedroom_id']) && $get['bedroom_id'] != "0"){
			$sql .= " AND (bedroom_id =".$get['bedroom_id'].") ";
			$countSql .= " AND (bedroom_id =".$get['bedroom_id'].") ";
		}

		if(isset($get['roof_id']) && $get['roof_id'] != "0"){
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

		if(isset($get['material_id']) && $get['material_id'] != "0"){
			$sql .= " AND (material_id =".$get['material_id'].") ";
			$countSql .= " AND (material_id =".$get['material_id'].") ";
		}

		if(isset($get['foundation_id']) && $get['foundation_id'] != "0"){
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
//		pre($data['count']);
		$data['total_pages'] = ceil($data['count']/$data['limit']);



//		$this->db->select('R.*,COUNT(P1.master_story_id) as substory_count , D1.value as house_style_value,D2.value as material_value,D3.value as roof_value,D4.value as foundation_value');
//		$this->db->group_by('R.id');
//		$this->db->order_by('R.id','desc');
//		$this->db->from('brickstory_profile AS R');
//		$this->db->join('brickstory_dropdown_value  as D1', 'R.house_style_id = D1.id', 'left');
//		$this->db->join('brickstory_dropdown_value  as D2', 'R.material_id = D2.id', 'left');
//		$this->db->join('brickstory_dropdown_value as D3', 'R.roof_id = D3.id', 'left');
//		$this->db->join('brickstory_dropdown_value  as D4', 'R.foundation_id = D4.id', 'left');
//		$this->db->join('brickstory_substories  as P1', 'R.id = P1.master_story_id', 'left');
//		$this->db->where($where);
//		if(!empty($or_where)){
//			$this->db->or_where($or_where);
//		}
//		$this->db->limit(15,15);
//		$query = $this->db->get();
//		query();
		$data['title'] = "Houses";
//		$data['filename'] = 'houseshistory';
		if(get('type') == "map"){
			$data['filename'] = 'housesmap';
		}else {
			$data['filename'] = 'houseshistory';
		}
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
		$data['season'] = get_dropdown_value('season');
		$data['house_style'] = get_dropdown_value('house_style');
		$data['material'] = get_dropdown_value('material');
		$data['events'] = get_dropdown_value('event');
		$data['foundation'] = get_dropdown_value('foundation');
		$data['roof'] = get_dropdown_value('roof');

		$this->load->view('layout',$data);
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
		$start = ($page * get_settings('BIZ_RECORDS_PER_PAGE', get_settings('RECORD_PER_PAGE', 12)));
		$data['limit'] = get_settings('BIZ_RECORDS_PER_PAGE', get_settings('RECORD_PER_PAGE', 12));
		$data['page'] = $page;
		$data['real_page']=$page;

		//---------------
		$data['result'] = $this->sqlmodel->getRecords(
			'S.*,bp.city,bp.state, D1.value as season_value,D2.value as event_value, D3.value as side_of_house_value, D4.value as room_value,D5.value as setting_value',
			'brickstory_substories  as S 
			LEFT JOIN brickstory_dropdown_value as D1 on (S.season_id = D1.id)
			LEFT JOIN brickstory_dropdown_value as D2 on (S.event_id = D2.id )
			LEFT JOIN brickstory_dropdown_value as D3 on (S.side_of_house_id = D3.id )
			LEFT JOIN brickstory_dropdown_value as D4 on (S.room_id = D4.id )
			LEFT JOIN brickstory_dropdown_value as D5 on (S.setting_id = D5.id )
			LEFT JOIN brickstory_profile bp on (bp.id = S.master_story_id)
			',$sortby,$orderby,$where,$data['limit'],$start);
		//pre($data['result']);


		$data['count'] = $this->sqlmodel->countRecords('brickstory_substories '.$join,$where);
		$data['total_pages'] = ceil($data['count']/$data['limit']);


		$data['title'] = "Photos and stories";
		$data['filename'] = 'photosnhistory';

		$data['season'] = get_dropdown_value('season');
		$data['house_style'] = get_dropdown_value('house_style');
		$data['material'] = get_dropdown_value('material');
		$data['events'] = get_dropdown_value('event');
		$data['settings'] = get_dropdown_value('setting');
		$data['side_of_house'] = get_dropdown_value('side_of_house');
//		pre($data['result']);
		$this->load->view('layout',$data);
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
		$start = ($page * get_settings('BIZ_RECORDS_PER_PAGE', get_settings('RECORD_PER_PAGE', 12)));
		$data['limit'] = get_settings('BIZ_RECORDS_PER_PAGE', get_settings('RECORD_PER_PAGE', 12));
		$data['page'] = $page;
		$data['real_page']=$page;

		$data['peoples'] = $this->sqlmodel->getRecords('brickstory_person.*','brickstory_person'.$join,$sortby,$orderby,$where,$data['limit'],$start);
		$data['count'] = $this->sqlmodel->countRecords('brickstory_person '.$join,$where);
		$data['total_pages'] = ceil($data['count']/$data['limit']);
		$data['title'] = "People";
		$data['filename'] = 'peoples';
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
		$data['relationship'] = get_dropdown_value('relation');
		$this->load->view('layout',$data);
	}
	public function details($id='')
	{
		$tab = $this->uri->segment(2);
		$data['title'] = "View Brickstory";
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

				// $check = $this->sqlmodel->getSingleRecord("brickstory_profile",array('id'=>$id));
				
				// $this->send_sms($check['monitor_phone'],'add',$check['address1']);

				set_msg('success','Information updated successfully!');
				redirect(base_url('details/view/'.$id));
			}
			$data['filename'] = "property/home_details";
		}
		else if($tab == "story"){
			$data['filename'] = "property/story";
		}
		else if($tab == "people"){
			$this->db->select('S.*, R1.value as relation_value');
			$this->db->from('brickstory_person as S');
			$this->db->join('brickstory_dropdown_value as R1', 'S.relation_id = R1.id', 'left');
			$this->db->where('S.master_story_id', $id);
			$this->db->order_by('id', 'asc');
			$data['result'] = $this->db->get();

			$data['filename'] = "property/people";
		}
		else if($tab == "timeline"){

			$this->load->model("user_timeline_model");
			$this->load->model("myhomes_model");
			// ------- Timeline Code started from here ---------

			$state_array = state_array();
			$sub_timeline = $this->user_timeline_model->get_record_by_id_all_user($id);
			$livedhere = $this->user_timeline_model->get_lived_here_by_user($id);
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
			$room = $this->myhomes_model->get_dropdown_value('room');
			$room = array(0 => "Please Select") + $room;
			$scroll = 0;

//			pre($livedhere);

			$data = array(
				'sub_timeline' => $sub_timeline,
				'livedhere' => $livedhere,
				'ency_id' => $id,
				'records'=>$records,
				'sub_persons' => $sub_persons,
				'setting' => $setting,
				'season' => $season,
				'states' =>  state_array(),
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

			$data['filename'] = "property/timeline";
		}
		$data['user'] = loggedin_user();
		$data['homeId'] = $id;
		$data['home'] = getHomeDetails($id);
		if(!$data['home']){
			set_msg('error','Something went wrong.');
			redirect(base_url('dashboard'));
		}

		// ------------- get Sub Records ----------
		$id = intval($id);
		$this->db->select('S.*, D1.value as season_value,D2.value as event_value, D3.value as side_of_house_value, D4.value as room_value');
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
		//pre($data['sub_stories']);
		$data['states'] = state_array();
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
	public function getPopupData($id){
				$sql = "SELECT R.*,COUNT(P1.master_story_id) as substory_count , D1.value as house_style_value,D2.value as material_value,D3.value as roof_value,D4.value as foundation_value
FROM brickstory_profile AS R
LEFT JOIN `brickstory_dropdown_value` as `D1` ON `R`.`house_style_id` = `D1`.`id`
LEFT JOIN `brickstory_dropdown_value` as `D2` ON `R`.`material_id` = `D2`.`id`
LEFT JOIN `brickstory_dropdown_value` as `D3` ON `R`.`roof_id` = `D3`.`id`
LEFT JOIN `brickstory_dropdown_value` as `D4` ON `R`.`foundation_id` = `D4`.`id`
LEFT JOIN `brickstory_substories` as `P1` ON `R`.`id` = `P1`.`master_story_id`
WHERE R.id = ".$id;
				$data = $this->sqlmodel->runQuery($sql,1);

				echo ' <table cellpadding="2" cellspacing="2">
                                                        <tr>
                                                            <td class="right">House Style:</td>
                                                            <td class="left">';
				echo (empty($data['house_style_value']) ? "Not Available" : $data['house_style_value']);
				echo '</td>
                                                        </tr>
                                                         <tr>
                                                            <td class="right">Square Feet:</td>
                                                            <td class="left">';
				echo ($data['square_feet'] != 0) ? $data['square_feet'] : 'Not Available';
				echo '</td>
                                                        </tr>
                                                         <tr>
                                                            <td class="right">Original Material:</td>
                                                            <td class="left">';
				echo (empty($data['material_value']) ? "Not Available" : $data['material_value']);
				echo '</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="right">Roof Type:</td>
                                                            <td class="left">';
				echo (empty($data['roof_value']) ? "Not Available" : $data['roof_value']);
				echo '</td>
                                                        </tr> 
                                                        <tr>
                                                            <td class="right">Foundation Type:</td>
                                                            <td class="left">';
				echo (empty($data['foundation_value']) ? "Not Available" : $data['foundation_value']);
				echo '</td>
                                                        </tr> 
                                                       </table>';
	}
}
