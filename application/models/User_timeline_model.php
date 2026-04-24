<?php

class User_Timeline_model extends CI_Model {

    protected $_tbl_user_timeline = "brickstory_substories";
    protected $_tbl_brickstory_livedhere = "brickstory_livedhere";
    protected $_tbl_users = "users";
    protected $_tbl_brickstory_style = "brickstory_style";
    protected $_tbl_brickstory_home = "brickstory_profile";

    /**
     * Function get_record_by_id_logged_in_user for fetching the substory record 
     * of that particular logged in user with particular Home Story Id.
     * @return array
     */
    function get_record_by_id_logged_in_user($user_id) {
        $user_id = intval($user_id);
        $this->db->select('*');
        $this->db->from($this->_tbl_brickstory_home);
        $this->db->where('lived_here', 1);
        $this->db->where('user_id', $user_id);
        $this->db->order_by('from_date', 'asc');
        $result = $this->db->get();
        return $result->result();
    }

    /**
     * Function get_record_by_id_all_user for fetching the substory record of that 
     * particular Home Story Id.
     * @return array
     */
    function get_record_by_id_all_user($id,$type='') {
        $id = intval($id);
        $this->db->select('R.*,U.firstname,U.lastname,H.year_built,H.address1');
        $this->db->from($this->_tbl_user_timeline . ' AS R');
        $this->db->join($this->_tbl_users . ' as U', 'R.user_id = U.id', 'left');
        $this->db->join($this->_tbl_brickstory_home . ' as H', 'R.master_story_id = H.id', 'left');
        if($type == 'user'){
			$this->db->where('R.user_id', $id);
		}else{
			$this->db->where('R.master_story_id', $id);
		}

        $this->db->order_by('approximate_date', 'asc');
        $result = $this->db->get();
        return $result->result();
    }

    function get_lived_here_by_user($id){
        $id = intval($id);
        $this->db->select('lr.*,U.firstname,U.lastname,U.profile_photo');
        $this->db->from($this->_tbl_brickstory_livedhere . ' AS lr');
        $this->db->join($this->_tbl_users . ' as U', 'lr.user_id = U.id', 'left');
        $this->db->where('lr.master_story_id', $id);
//        $this->db->order_by('approximate_date', 'asc');
        $result = $this->db->get();
        return $result->result();
    }

    /**
     * Function insert_style for inserting the style(Like) for particular substory
     * First we have check the record of that substory and If exist update the
     * record otherwise insert the style of that particular substory.
     * @return array
     */
    public function insert_style($data) {

        $master_story_id = $data['master_story_id'];
        $sub_story_id = $data['sub_story_id'];
        $user_id = $data['user_id'];

        $this->db->select('S.master_story_id,S.sub_story_id,S.user_id, S.style');
        $this->db->from($this->_tbl_brickstory_style . ' AS S');
        $this->db->where('master_story_id', $master_story_id);
        $this->db->where('sub_story_id', $sub_story_id);
        $this->db->where('user_id', $user_id);
        $result = $this->db->get();


        $result1 = $result->num_rows();
        if ($result1 == 0) {
            $inserted_result = $this->db->insert($this->_tbl_brickstory_style, $data);
            $inserted_result = true;
            return $inserted_result;
        } else {
            $data1 = $result->result();
            if ($data1[0]->style == 1) {
                $inserted_result = false;
                return $inserted_result;
            } else {
                $this->db->where('master_story_id', $master_story_id);
                $this->db->where('sub_story_id', $sub_story_id);
                $this->db->where('user_id', $user_id);
                $this->db->set($data);
                $inserted_result = $this->db->update($this->_tbl_brickstory_style);
                return $inserted_result = true;
            }
        }
    }

    /**
     * Function insert_soul for inserting the soul(Like) for particular substory
     * First we have check the record of that substory and If exist update the
     * record otherwise insert the soul of that particular substory.
     * @return array
     */
    public function insert_soul($data) {

        $master_story_id = $data['master_story_id'];
        $sub_story_id = $data['sub_story_id'];
        $user_id = $data['user_id'];

        $this->db->select('S.master_story_id,S.sub_story_id,S.user_id, S.soul');
        $this->db->from($this->_tbl_brickstory_style . ' AS S');
        $this->db->where('master_story_id', $master_story_id);
        $this->db->where('sub_story_id', $sub_story_id);
        $this->db->where('user_id', $user_id);
        $result = $this->db->get();
        $result1 = $result->num_rows();
        if ($result1 == 0) {
            $inserted_result = $this->db->insert($this->_tbl_brickstory_style, $data);
            return $inserted_result = true;
        } else {
            $data1 = $result->result();
            if ($data1[0]->soul == 1) {
                return $inserted_result = false;
            } else {
                $this->db->where('master_story_id', $master_story_id);
                $this->db->where('sub_story_id', $sub_story_id);
                $this->db->where('user_id', $user_id);
                $this->db->set($data);
                $inserted_result = $this->db->update($this->_tbl_brickstory_style);
                return $inserted_result = true;
            }
        }
    }

    /**
     * Function get_count_style for fetching the style(Like) count for particular
     * substory
     * @return array
     */
    function get_count_style($sub_story_id) {
        $this->db->select('S.style');
        $this->db->from($this->_tbl_user_timeline . ' AS S');
        $this->db->where('id', $sub_story_id);
        $result = $this->db->get();
        return $result->result();
    }

    /**
     * Function get_count_soul for fetching the soul(Like) count for particular
     * substory
     * @return array
     */
    function get_count_soul($sub_story_id) {
        $this->db->select('S.soul');
        $this->db->from($this->_tbl_user_timeline . ' AS S');
        $this->db->where('id', $sub_story_id);
        $result = $this->db->get();
        return $result->result();
    }

    /**
     * Function update_new_sub_story_description for updating the substory 
     * description
     * We have pass substory id for updating the record. 
     * @return array
     */
    function update_new_sub_story_description($data) {
        $sub_story_id = $data['sub_story_id'];
        $new_sub_story_description = $data['new_sub_story_description'];

        $data = array('story_description' => $new_sub_story_description);
        $this->db->where('id', $sub_story_id);
        $this->db->set($data);
        $updated_result = $this->db->update($this->_tbl_user_timeline);
    }

    /**
     * Function update_new_sub_story_image for updating the substory 
     * Image
     * We have pass substory id for updating the record. 
     * @return array
     */
    function update_new_sub_story_image($data) {
        $sub_story_id = $data['sub_story_id'];
        $file_name = $data['file_name'];
        $data = array('story_photo' => $file_name);
        $this->db->where('id', $sub_story_id);
        $this->db->set($data);
        $updated_result = $this->db->update($this->_tbl_user_timeline);
    }

    function update_new_sub_story_setting_id($data) {
        $sub_story_id = $data['sub_story_id'];
        $setting_id = $data['setting_id'];

        $data = array('setting_id' => $setting_id);
        $this->db->where('id', $sub_story_id);
        $this->db->set($data);
        $updated_result = $this->db->update($this->_tbl_user_timeline);
    }
    function update_new_sub_story_season_id($data) {
        $sub_story_id = $data['sub_story_id'];
        $season_id = $data['season_id'];
        $data = array('season_id' => $season_id);
        $this->db->where('id', $sub_story_id);
        $this->db->set($data);
        $updated_result = $this->db->update($this->_tbl_user_timeline);
    }
    function update_new_sub_story_event_id($data) {
        $sub_story_id = $data['sub_story_id'];
        $event_id = $data['event_id'];

        $data = array('event_id' => $event_id);
        $this->db->where('id', $sub_story_id);
        $this->db->set($data);
        $updated_result = $this->db->update($this->_tbl_user_timeline);
    }
    function update_new_sub_story_side_of_house_id($data) {
        $sub_story_id = $data['sub_story_id'];
        $side_of_house_id = $data['side_of_house_id'];

        $data = array('side_of_house_id' => $side_of_house_id);
        $this->db->where('id', $sub_story_id);
        $this->db->set($data);
        $updated_result = $this->db->update($this->_tbl_user_timeline);
    }
    function update_new_sub_story_room_id($data) {
        $sub_story_id = $data['sub_story_id'];
        $room_id = $data['room_id'];

        $data = array('room_id' => $room_id);
        $this->db->where('id', $sub_story_id);
        $this->db->set($data);
        $updated_result = $this->db->update($this->_tbl_user_timeline);
    }

}

?>
