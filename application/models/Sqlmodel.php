<?php

class Sqlmodel extends CI_Model {

	private $table;

	public function __construct(){
		// Call the Model constructor
		parent::__construct();

	}


	/****************************** Start General Functions ***********************/

	//insert function
	function insertRecord($table , $colums)
	{

		if($this->db->insert($table , $colums))
			return $this->db->insert_id();
		else
			return false;
	}

	//update function
	function updateRecord($table , $colums , $condition)
	{
		if($this->db->update($table , $colums , $condition))
			return true;
		else
			return false;
	}

	// delete function
	function deleteRecord($table , $condition)
	{
		if($this->db->delete($table , $condition))
		{
			//echo $this->db->last_query();
			return true;
		}
		else
		{
			return false;
		}
	}

	function runQuery($sql, $flag='')
	{
		$this->result = $this->db->query($sql);
		if($this->result->num_rows() >0){
			if($flag)
				return  $this->result->row_array();
			else
				return $this->result->result_array();
		}else{
			return false;
		}
	}

	public function insertRec($table, $data)
	{

		$q = $this->db->insert($table, $data);
		if (!$q) {
			// if query returns null
			$msg = $this->db->_error_message();
			$num = $this->db->_error_number();
			return false;
		}
		else{
			return $this->db->insert_id();
		}
	}

	public function updateRec($table, $data, $where)
	{
		$this->db->where($where);
		$q = $this->db->update($table, $data);
		if (!$q) {
			// if query returns null
			$msg = $this->db->_error_message();
			$num = $this->db->_error_number();
			return "false";
		}
		return "true";
	}

	public function getSingleRecord($table, $where)
	{

		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($where);
		$count = $this->db->count_all_results();
		if($count=="1")
		{
			$query = $this->db->get_where($table, $where);
			$data=$query->row_array();
			return $data;
		}else if($count > "1"){
			$query = $this->db->get_where($table, $where);
			$data=$query->row_array();
			return $data;
		}
		else{
			return false;
		}
	}

	public function getSingleField($col, $table, $where)
	{
		$this->db->select($col);
		$this->db->from($table);
		$this->db->where($where);
		$query = $this->db->get();
		$data = $query->row_array();
		if(isset($data[$col]))
		{
			return $data[$col];
		}
		else{
			return null;
		}
	}

	public function object_getSingleField($col, $table, $where)
	{
		$this->db->select($col);
		$this->db->from($table);
		$this->db->where($where);
		$query = $this->db->get();
		$data = $query->row();
		if(isset($data->$col))
		{
			return $data->$col;
		}
		else{
			return null;
		}
	}

	public function getRecords($fields, $table, $sortby="", $order="", $where="", $limit="0", $start="",$where_in="",$or_where=array())
	{
		$this->db->select($fields);
		$this->db->from($table);
		if(!empty($where))
		{
			$this->db->where($where);
		}
		if(!empty($or_where))
		{
			$i = 0;
			foreach($or_where as $key => $v) {
				foreach($v as $k => $val) {
					if($i == 0){
						$this->db->where($key, $val);
					}else{
						$this->db->or_where($key, $val);
					}
					$i++;
				}
			}
		}
		if(!empty($where_in)){
			$this->db->where_in($where_in[0],$where_in[1]);
		}
		if($sortby!="" && $order!="")
		{
			$this->db->order_by($sortby,$order);
		}

		if($limit!=0)
		{
			$this->db->limit($limit, $start);

		}
		$query = $this->db->get();
		$data=$query->result();

		return $data;
	}


	public function countRecords($table, $where=array())
	{
		$this->db->select('*');
		$this->db->from($table);
		if(!empty($where))
		{
			$this->db->where($where);
		}
		$records = $this->db->count_all_results();
		return $records;
	}


	public function truncate($table="")
	{
		if($table=="")
		{
			return;
		}
		if($this->db->truncate($table))
		{
			return true;
		}
		else{
			return false;
		}
	}

	public function seourl($rstring="")
	{
		$string = preg_replace('/\%/',' percentage',$rstring);
		$string = preg_replace('/\@/',' at ',$string);
		$string = preg_replace('/\&/',' and ',$string);
		$string = preg_replace("/\'/","",$string);
		$string = str_replace("\\","",$string);
		$string = preg_replace('/\s[\s]+/','-',$string);    // Strip off multiple spaces
		$string = preg_replace('/[\s\W]+/','-',$string);    // Strip off spaces and non-alpha-numeric
		$string = preg_replace('/^[\-]+/','',$string); // Strip off the starting hyphens
		$string = preg_replace('/[\-]+$/','',$string); // // Strip off the ending hyphens
		$string = strtolower($string);
		$string = str_replace(" ","-",$string);
		return $string;
	}

	/****************************** End General Functions ***********************/
}

?>
