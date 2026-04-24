<?php

class Myhomes_model extends CI_Model {

    protected $_tbl_brickstory = "brickstory_profile";
    protected $_tbl_brickstory_style = "brickstory_style";
    protected $_tbl_brickstory_dropdown_value = "brickstory_dropdown_value";
    protected $_tbl_brickstory_substories = "brickstory_substories";
    protected $_tbl_brickstory_person = "brickstory_person";
    public $search_term = "";
    public $sort_by = "";
    public $sort_order = "";
    public $street = "";
    public $city = "";
    public $state = "";
    public $zip = "";
    public $house_style_id = "";
    public $architect = "";
    public $owner_name = "";
    public $bedroom_id = "";
    public $material_id = "";
    public $roof_id = "";
    public $foundation_id = "";
    public $min_year = "";
    public $max_year = "";
    public $min_square_feet = "";
    public $max_square_feet = "";

    function __construct() {
        parent::__construct();
        $this->min_year = "1620";
        $this->max_year = date("Y");
        $this->min_square_feet = 0;
        $this->max_square_feet = 10000;
        $this->sort_order = "asc";
    }

    /**
     * Function get_role_listing to fetch all records of roles
     */
    function get_record_listing() {
        if (isset($this->search_term) && $this->search_term != "") {
            $this->db->like("LOWER(R.address1)", strtolower($this->search_term));
        }
        if (isset($this->sort_by) && $this->sort_by != "" && $this->sort_order != "") {
            $this->db->order_by('R.' . $this->sort_by, $this->sort_order);
        }
        if (isset($this->record_per_page) && isset($this->offset) && !isset($this->_record_count) && $this->_record_count != true) {
            $this->db->limit((int)$this->record_per_page, (int)$this->offset);
        }
        $ci = & get_instance();
        if (isset($ci->session->userdata['front']['user_id'])) {
            $user_id = $ci->session->userdata['front']['user_id'];
        }
        $this->db->select('R.*,COUNT(P1.master_story_id) as substory_count , D1.value as house_style_value,D2.value as material_value,D3.value as roof_value,D4.value as foundation_value');
        $this->db->group_by('R.id');
        $this->db->from($this->_tbl_brickstory . ' AS R');
        $this->db->join($this->_tbl_brickstory_dropdown_value . ' as D1', 'R.house_style_id = D1.id', 'left');
        $this->db->join($this->_tbl_brickstory_dropdown_value . ' as D2', 'R.material_id = D2.id', 'left');
        $this->db->join($this->_tbl_brickstory_dropdown_value . ' as D3', 'R.roof_id = D3.id', 'left');
        $this->db->join($this->_tbl_brickstory_dropdown_value . ' as D4', 'R.foundation_id = D4.id', 'left');        
        $this->db->join($this->_tbl_brickstory_substories . ' as P1', 'R.id = P1.master_story_id', 'left');
        $this->db->where('R.user_id', $user_id);
        $query = $this->db->get();
        $str = $this->db->last_query();
        if (isset($this->_record_count) && $this->_record_count == true) {
            return count($this->db->result_array($query));
        } else {
            return $this->db->result_array($query);
        }
        return $result;
    }
    /**
     * Function get_record_by_id to fetch records by id
     * @param int $id default = 0
     */
    function get_record_by_id($id = 0) {
        //Type Casting 
        $id = intval($id);
        $this->db->select('R.*, D1.value as house_style_value,D2.value as material_value,D3.value as roof_value,D4.value as foundation_value');
        $this->db->from($this->_tbl_brickstory . ' as R');
        $this->db->join($this->_tbl_brickstory_dropdown_value . ' as D1', 'R.house_style_id = D1.id', 'left');
        $this->db->join($this->_tbl_brickstory_dropdown_value . ' as D2', 'R.material_id = D2.id', 'left');
        $this->db->join($this->_tbl_brickstory_dropdown_value . ' as D3', 'R.roof_id = D3.id', 'left');
        $this->db->join($this->_tbl_brickstory_dropdown_value . ' as D4', 'R.foundation_id = D4.id', 'left');        
        $this->db->where('R.id', $id);
        $result = $this->db->get();
        return $result->row_array();
    }
    function get_sub_records($id = 0)
    {
        $id = intval($id);
        $this->db->select('S.*, D1.value as season_value,D2.value as event_value, D3.value as side_of_house_value, D4.value as room_value');
        $this->db->from($this->_tbl_brickstory_substories . ' as S');
        $this->db->join($this->_tbl_brickstory_dropdown_value . ' as D1', 'S.season_id = D1.id', 'left');
        $this->db->join($this->_tbl_brickstory_dropdown_value . ' as D2', 'S.event_id = D2.id', 'left');
        $this->db->join($this->_tbl_brickstory_dropdown_value . ' as D3', 'S.side_of_house_id = D3.id', 'left');
        $this->db->join($this->_tbl_brickstory_dropdown_value . ' as D4', 'S.room_id = D4.id', 'left');
        $this->db->where('S.master_story_id', $id);
        $this->db->order_by('id', 'asc');
        $result = $this->db->get();
        //var_dump($this->db);exit;
        //return $result->row_array();
        return $result->result_array();
    }
    function update_new_sub_person_image($data) {
        $sub_person_id = $data['id'];
        $file_name = $data['file_name'];
        $data = array('person_photo' => $file_name);
        $this->db->where('id', $sub_person_id);
        $this->db->set($data);
        $updated_result = $this->db->update($this->_tbl_brickstory_person);
        //var_dump($this->db);
        //exit;
    }
    function update_new_sub_person_relation_id($data)
    {
        $sub_person_id = $data['person_id'];
        $relation_id = $data['relation_id'];
        
        $data = array('relation_id' => $relation_id);
        $this->db->where('id', $sub_person_id);
        $this->db->set($data);
        $updated_result = $this->db->update($this->_tbl_brickstory_person);
    }
    function update_persons($data)
    {
        $sub_person_id = $data['person_id'];
        if($data['frist_name']!= '' && $sub_person_id != 0)
        {
            $data = array('frist_name' => $data['frist_name']);    
        }
        if($data['last_name']!= '' && $sub_person_id != 0)
        {
            $data = array('last_name' => $data['last_name']);    
        }
        if($data['from_date']!= '' && $sub_person_id != 0)
        {
            $data = array('from_date' => $data['from_date']);    
        }
        if($data['to_date']!= '' && $sub_person_id != 0)
        {
            $data = array('to_date' => $data['to_date']);    
        }
        if($data['born_date']!= '' && $sub_person_id != 0)
        {
            $data = array('born_date' => $data['born_date']);    
        }
        if($data['died_date']!= '' && $sub_person_id != 0)
        {
            $data = array('died_date' => $data['died_date']);    
        }
        $this->db->where('id', $sub_person_id);
        $this->db->set($data);
        $updated_result = $this->db->update($this->_tbl_brickstory_person);
    }
    
    function get_persons($id)
    {
        $id = intval($id);
        $this->db->select('S.*, R1.value as relation_value');
        $this->db->from($this->_tbl_brickstory_person . ' as S');
        $this->db->join($this->_tbl_brickstory_dropdown_value . ' as R1', 'S.relation_id = R1.id', 'left');
        $this->db->where('S.master_story_id', $id);
        $this->db->order_by('id', 'asc');
        $result = $this->db->get();
        //var_dump($this->db);
        //return $result->row_array();
        return $result->result_array();
    }
    public function get_persons_time($id, $approxmate_date1,$approxmate_date2,$type='')
    {
        $id = intval($id);
        $ap_date1 = date('Y-m-d', strtotime($approxmate_date1));
        $ap_date2 = date('Y-m-d', strtotime($approxmate_date2));
        $query2 = "SELECT `P`.*, `P`.person_photo,`P`.frist_name, `P`.last_name,`P`.from_date, 'F' as Indicator FROM (`".$this->_tbl_brickstory_person."` as P) WHERE ";
        if($type == 'user'){
			$query2 .= "`P`.`user_id` = '".$id."' ";
		}else{
			$query2 .= "`P`.`master_story_id` = '".$id."' ";
		}
        $query2 .= "AND `from_date` BETWEEN '".$ap_date1."' and '".$ap_date2."' UNION ALL ";
        $query2 .="SELECT `P`.*, `P`.person_photo,`P`.frist_name, `P`.last_name,`P`.to_date, 'T' as Indicator FROM (`".$this->_tbl_brickstory_person."` as P) WHERE ";
		if($type == 'user'){
			$query2 .= "`P`.`user_id` = '".$id."' ";
		}else{
			$query2 .= "`P`.`master_story_id` = '".$id."' ";
		}
        $query2 .="AND `to_date` BETWEEN '".$ap_date1."' and '".$ap_date2."' order by id asc";
        
        $result1 = $this->db->query($query2);

            $array_per = array();
            foreach ($result1->result_array() as $key => $value)
            {
                $array_per[] = $value;
            }
            
            //print_r($array_per);
            return $array_per;
    }

	public function get_persons_mytimeline($id, $approxmate_date1,$approxmate_date2,$type='')
	{
		$id = intval($id);
		$ap_date1 = date('Y-m-d', strtotime($approxmate_date1));
		$ap_date2 = date('Y-m-d', strtotime($approxmate_date2));
		$query2 = "SELECT `P`.person_photo,`P`.frist_name, `P`.last_name,`P`.from_date, 'F' as Indicator, bp.address1, bp.city,bp.state,bp.zip,bp.home_profile_photo	 FROM (`".$this->_tbl_brickstory_person."` as P) join brickstory_profile as bp on (bp.id = P.master_story_id) WHERE ";
		if($type == 'user'){
			$query2 .= "`P`.`user_id` = '".$id."' ";
		}else{
			$query2 .= "`P`.`master_story_id` = '".$id."' ";
		}
		$query2 .= "AND `P`.`from_date` BETWEEN '".$ap_date1."' and '".$ap_date2."' UNION ALL ";
		$query2 .="SELECT `P`.person_photo,`P`.frist_name, `P`.last_name,`P`.to_date, 'T' as Indicator, bp.address1, bp.city,bp.state,bp.zip,bp.home_profile_photo	 FROM (`".$this->_tbl_brickstory_person."` as P) join brickstory_profile as bp on (bp.id = P.master_story_id) WHERE ";
		if($type == 'user'){
			$query2 .= "`P`.`user_id` = '".$id."' ";
		}else{
			$query2 .= "`P`.`master_story_id` = '".$id."' ";
		}
		$query2 .="AND P.to_date BETWEEN '".$ap_date1."' and '".$ap_date2."' order by from_date asc";

		$result1 = $this->db->query($query2);

		$array_per = array();
		foreach ($result1->result_array() as $key => $value)
		{
			$array_per[] = $value;
		}

		//print_r($array_per);
		return $array_per;
	}

	public function getLivedInTimeline($id, $approxmate_date1,$approxmate_date2,$type='')
	{
		$id = intval($id);
		$ap_date1 = date('Y-m-d', strtotime($approxmate_date1));
		$ap_date2 = date('Y-m-d', strtotime($approxmate_date2));
		$query2 = "SELECT `BL`.from_date,`BL`.to_date,`BL`.lived_here, 'F' as Indicator, bp.address1, bp.city,bp.state,bp.zip,bp.home_profile_photo FROM (`brickstory_livedhere` as BL) LEFT join brickstory_profile as bp on (bp.id = BL.master_story_id) LEFT JOIN `".$this->_tbl_brickstory_person."` as P on (P.id = BL.user_id)  WHERE ";
		if($type == 'user'){
			$query2 .= "`BL`.`user_id` = '".$id."' ";
		}else{
			$query2 .= "`P`.`master_story_id` = '".$id."' ";
		}
		$query2 .= "AND `BL`.`from_date` BETWEEN '".$ap_date1."' and '".$ap_date2."'";


		$result1 = $this->db->query($query2);

		$array_per = array();
		foreach ($result1->result_array() as $key => $value)
		{
			$array_per[] = $value;
		}

		//print_r($array_per);
		return $array_per;
	}

    function get_persons1($id,$type='')
    {
        $id = intval($id);
        $this->db->select('P.*');
        $this->db->from($this->_tbl_brickstory_person. ' as P');
        if($type == 'user'){
			$this->db->where('P.user_id', $id);
		}else{
			$this->db->where('P.master_story_id', $id);
		}
        $this->db->order_by('id', 'asc');
        $result = $this->db->get();
        //var_dump($this->db);
        //exit;
        //return $result->row_array();
        return $result->result_array();
    }

    function get_persons2($id,$type='')
    {
        $id = intval($id);
        $this->db->select('P.*,CONCAT("'.base_url().'assets/uploads/peoples/","/",P.person_photo) as person_photo,brickstory_dropdown_value.value as relationship_value ');
        $this->db->from($this->_tbl_brickstory_person. ' as P');
        $this->db->join("brickstory_dropdown_value","P.relation_id = brickstory_dropdown_value.id","left");
        
        if($type == 'user'){
			$this->db->where('P.user_id', $id);
		}else{
			$this->db->where('P.master_story_id', $id);
		}
        $this->db->order_by('id', 'asc');
        $result = $this->db->get();
        //var_dump($this->db);
        //exit;
        //return $result->row_array();
        return $result->result_array();
    }
    public function get_dropdown_value($type) {

        $this->db->select('id,value');
        $this->db->from($this->_tbl_brickstory_dropdown_value);
        $this->db->where('type', $type);
        $this->db->order_by('value', 'asc');
        $query = $this->db->get();

        $array = array();
        foreach ($query->result() as $key => $value) {
            $array[$value->id] = $value->value;
        }

        return $array;
    }
}
?>
