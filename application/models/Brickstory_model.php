<?php

class Brickstory_model extends CI_Model {

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
    public $lng = "";
    public $lat = "";
    public $lng_id = "";
    public $lat_id = "";
    public $zip = "";
    public $house_style_id = "";
    public $architect = "";
    public $owner_name = "";
    public $bedroom_id = "";
    public $material_id = "";
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
            $this->db->limit($this->record_per_page, $this->offset);
        }
        $ci = & get_instance();
        if (isset($ci->session->userdata['front']['user_id'])) {
            $user_id = $ci->session->userdata['front']['user_id'];
        }
        $this->db->select('R.*,COUNT(P1.master_story_id) as substory_count');
        $this->db->group_by('R.id');
        $this->db->from($this->_tbl_brickstory . ' AS R');
        $this->db->join($this->_tbl_brickstory_substories . ' as P1', 'R.id = P1.master_story_id', 'left');
        $this->db->where('R.user_id', $user_id);
        $query = $this->db->get();
        $str = $this->db->last_query();

        if (isset($this->_record_count) && $this->_record_count == true) {
            return count($this->db->custom_result($query));
        } else {
            return $this->db->custom_result($query);
        }

        return $result;
    }

    function search_result() {
        // echo "hi";exit;

        if (isset($this->street) && $this->street != "") {
            $this->db->like("LOWER(R.address1)", strtolower($this->street));
        }
        if (isset($this->street) && $this->street != "") {
            $this->db->or_like("LOWER(R.address2)", strtolower($this->street));
        }
        if (isset($this->city) && $this->city != "") {
            $this->db->like('R.city', $this->city);
        }
        if (isset($this->state) && $this->state != '0' && !empty($this->state)) {
            $this->db->where('R.state', $this->state);
        }
        if (isset($this->zip) && $this->zip != "") {
            $this->db->where('R.zip', $this->zip);
        }

        if (isset($this->house_style_id) && $this->house_style_id != 0) {
            $this->db->where('R.house_style_id', $this->house_style_id);
        }
        if (isset($this->architect) && $this->architect != "") {
            $this->db->like('R.architech', $this->architect);
        }
        if (isset($this->owner_name) && $this->owner_name != "") {
            $this->db->like('R.owner_name', $this->owner_name);
        }
        if (isset($this->bedroom_id) && $this->bedroom_id != 0) {
            $this->db->where('R.bedroom_id', $this->bedroom_id);
        }
        if (isset($this->material_id) && $this->material_id != 0) {
            $this->db->where('R.material_id', $this->material_id);
        }
        if (isset($this->sort_by) && $this->sort_by == "distance")
        {
            $this->db->where('R.lat !=', '');
            $this->db->where('R.lng !=', '');
        }
//        if (isset($this->record_per_page) && isset($this->offset) && !isset($this->_record_count) && $this->_record_count != true) {
//            $this->db->limit($this->record_per_page, $this->offset);
//        }
        if (isset($this->min_year)) {
            $this->db->where('year_built >= ', $this->min_year);
        }
        if (isset($this->max_year)) {
            $this->db->where('year_built <= ', $this->max_year);
        }
        if (isset($this->min_square_feet) && $this->min_square_feet != 0) {
            $this->db->where('square_feet  >=', $this->min_square_feet);
        }
        
        if (isset($this->max_square_feet)) {
            if ($this->max_square_feet != 10001) {
                $this->db->where('square_feet  <=', $this->max_square_feet);
            }
        }
        if (isset($this->sort_by) && $this->sort_by != "" && $this->sort_by != "distance" /* && $this->sort_order != "" */) {
            $this->db->order_by('R.' . $this->sort_by, $this->sort_order);
        }
        
        if (isset($this->sort_by) && $this->sort_by == "distance" )
        {
            $this->db->order_by("distance","asc");
        }
        if (isset($this->sort_by) && $this->sort_by == 0 )
        {
            $this->db->order_by('R.id' ,'desc');
        }
        //For pagination
        if (isset($this->record_per_page) && isset($this->offset) && !isset($this->_record_count) && $this->_record_count != true) {
            $this->db->limit($this->record_per_page, $this->offset);
        }
        
        if (isset($this->sort_by) && $this->sort_by == "distance")
        {
                if($this->state != '0' || $this->city != ''|| $this->street != '' || $this->zip != '')
                {
                    $addresshh = strtolower($this->street).",".$this->city.",".$this->state.",".$this->zip;
                    $addresshh = str_replace(" ", "+", $addresshh); 
                    $url = "https://maps.google.com/maps/api/geocode/json?key=AIzaSyD-juU87aeSRIF0CmfDZujorYxy_9kKfyc&address=$addresshh";
                    $response = file_get_contents($url);
                    $json = json_decode($response,TRUE); 
                    $this->lat = $json['results'][0]['geometry']['location']['lat'];
                    $this->lng = $json['results'][0]['geometry']['location']['lng'];
                    //print $url.'hai';
                }
                else
                {
                    //if($this->lng == '' && $this->lat == '' )
                    //{
                    	if (isset($this->lng_id) && $this->lng_id != "")
                    	{
                       		$this->lng = $this->lng_id;
                    	}
                    	if (isset($this->lat_id) && $this->lat_id != "")
                    	{
                       		$this->lat = $this->lat_id;
                    	}
                    //}
                }
                
        }
        if (isset($this->sort_by) && $this->sort_by == "distance")
        {
            $lat = $this->lat;
            $lng = $this->lng;
            
             $this->db->select('R.*,COUNT(P1.master_story_id) as substory_count, D1.value as house_style_value,D2.value as material_value ,( 3961 * acos( cos( radians('.$lat.') ) * cos( radians( R.lat ) ) * cos( radians( R.lng ) - radians('.$lng.') ) + sin( radians('.$lat.') ) * sin( radians( R.lat ) ) ) )  AS distance');
             
             //$this->db->select('R.*,COUNT(P1.master_story_id) as substory_count, D1.value as house_style_value,D2.value as material_value ,( 3961 * acos( cos( radians('.$lat.') ) * cos( radians( R.lat ) ) * cos( radians( R.lng ) - radians('.$lng.') ) + sin( radians('.$lat.') ) * sin( radians( R.lat ) ) ) ) AS distance');
             
             //$this->db->select("R.*,COUNT(P1.master_story_id) as substory_count, D1.value as house_style_value,D2.value as material_value ,( 3961 * acos( cos( radians(78.4426551) ) * cos( radians( R.lat ) ) * cos( radians( R.lng ) - radians(17.4082321) ) + sin( radians(78.4426551) ) * sin( radians( R.lat ) ) ) ) AS distance");
            
        }
        if (isset($this->sort_by) && $this->sort_by != "distance")
        {
            $this->db->select('R.*,COUNT(P1.master_story_id) as substory_count, D1.value as house_style_value,D2.value as material_value');
        }
        $this->db->group_by('R.id');
        $this->db->from($this->_tbl_brickstory . ' AS R');
        $this->db->join($this->_tbl_brickstory_substories . ' as P1', 'R.id = P1.master_story_id', 'left');
        //added latest
        $this->db->join($this->_tbl_brickstory_dropdown_value . ' as D1', 'R.house_style_id = D1.id', 'left');
        $this->db->join($this->_tbl_brickstory_dropdown_value . ' as D2', 'R.material_id = D2.id', 'left');
        //latest add end here
        $query = $this->db->get();
        $num_rows=count($query);
        //print $this->db->last_query();
        // $num_rows = count($query);
        //var_dump($this->db);
        //var_dump($this->db);exit;
        // echo "<pre>";print_r($query);exit;
        // echo $num_rows;exit;

        if ($num_rows != 0) {
            if (isset($this->_record_count) && $this->_record_count == true) {
//            //var_dump($this->db);exit;
                return count($this->db->custom_result($query));
            } else {

                return $this->db->custom_result($query);
            }
        } else {
            return array();
            // echo "hi";exit;
            return $this->db->custom_result($query);
        }
    }

    /**
     * Function get_record_by_id to fetch records by id
     * @param int $id default = 0
     */
    function get_record_by_id($id = 0) {
        //Type Casting 
        $id = intval($id);

        $this->db->select('R.*, D1.value as house_style_value,D2.value as material_value');
        $this->db->from($this->_tbl_brickstory . ' as R');
        $this->db->join($this->_tbl_brickstory_dropdown_value . ' as D1', 'R.house_style_id = D1.id', 'left');
        $this->db->join($this->_tbl_brickstory_dropdown_value . ' as D2', 'R.material_id = D2.id', 'left');
        $this->db->where('R.id', $id);
        $result = $this->db->get();
        return $result->row_array();
    }
    function get_sub_records($id = 0)
    {
        $id = intval($id);
        $this->db->select('S.*');
        $this->db->from($this->_tbl_brickstory_substories . ' as S');
        $this->db->where('S.master_story_id', $id);
        $result = $this->db->get();
        //return $result->row_array();
        return $this->db->custom_result($result);
    }

    /**
     * Function save_record to add/update record 
     * @param array $data 
     */
    public function save_record($data) {

        //Type Casting
        $id = intval($data['id']);
        $data['house_style_id'] = intval($data['house_style_id']);
        $data['bedroom_id'] = $data['bedroom_id'];
        $data['material_id'] = intval($data['material_id']);
        $data['from_date'] = date('Y-m-d', strtotime($data['from_date']));
        $data['to_date'] = date('Y-m-d', strtotime($data['to_date']));

        if ($id != 0 && $id != "") {
            $this->db->where('id', $id);
            $this->db->update($this->_tbl_brickstory, $data);
            $id = $id;
        } else {
            $this->db->insert($this->_tbl_brickstory, $data);
            //var_dump($this->db);exit;
            $id = $this->db->insert_id();
        }
        return $id;
    }
    public function update_home_image($datat) {
        $id = intval($datat['id']);
        $data['home_profile_photo'] = $datat['home_profile_photo'];
        if ($id != 0 && $id != "")
        {
            $this->db->where('id', $id);
            $this->db->update($this->_tbl_brickstory, $data);
            //var_dump($this->db);exit;
        }
        return $id;
    }
    /**
     * Function delete_record to delete record 
     * @param int $id 
     */
    public function delete_record($id) {
        //Type Casting 
        $id = intval($id);

        $this->db->where('id', $id);
        return $this->db->delete($this->_tbl_brickstory);
    }

    /**
     * Function save_record to add/update sub stories
     * @param array $data 
     */
    public function save_substory_record($data) {

        $this->_tbl_brickstory = "brickstory_substories";
//        $id = intval($data1['id']);

        $this->db->insert($this->_tbl_brickstory, $data);
        $id = $this->db->insert_id();

        $this->_tbl_brickstory = "brickstory_profile";
        return $id;
    }
    public function save_substory_person($data) {

        $this->_tbl_brickstory = "brickstory_person";
//        $id = intval($data1['id']);

        $this->db->insert($this->_tbl_brickstory, $data);
        $id = $this->db->insert_id();

        $this->_tbl_brickstory = "brickstory_profile";
        return $id;
    }

    /*
     * get dropdown value
     */

    public function get_dropdown_value($type) {

        $this->db->select('id,value');
        $this->db->from($this->_tbl_brickstory_dropdown_value);
        $this->db->where('type', $type);
        $this->db->order_by("value", "asc");
        $query = $this->db->get();

        $array = array();
        foreach ($query->result() as $key => $value) {
            $array[$value->id] = $value->value;
        }

        return $array;
    }

}

?>
