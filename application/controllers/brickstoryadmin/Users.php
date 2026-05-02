<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends Admin_Controller {

	public function index($page=1)
	{

		$data['real_page']=$page;
		$sortby = 'id';
		$orderby = 'desc';
		$page = ($page >=0)?($page - 1):($page);
		$start = ($page * get_settings('RECORD_PER_PAGE'));
		$data['limit'] = get_settings('RECORD_PER_PAGE');
		$data['page'] = $page;
		//--------------
		$get = get();
		$category = isset($get['design_code'])?($get['design_code']):(false);
		$start_date = isset($get['start_date'])?($get['start_date']):(false);
		$end_date = isset($get['end_date'])?($get['end_date']):(false);
		$external_join = '';
		$where = array();
		$external_join .= ' LEFT JOIN roles r on (u.role_id = r.id)';

		if($category){
			$where['design_code like '] = "%".$category."%";
		}
		
		//}
		if($start_date){
			$where['DATE(date_added) >= '] = date("Y-m-d",strtotime($start_date));
		}
		if($end_date){
			$where['DATE(date_added) <= '] = date("Y-m-d",strtotime($end_date));
		}

		$data['users'] = $this->sqlmodel->getRecords("u.*,r.role_name,
			(SELECT COUNT(*) FROM brickstory_profile bp WHERE bp.user_id = u.id) AS properties_count",
			'users u '.$external_join, $sortby, $orderby, $where, $data['limit'], $start);
		$data['count'] = $this->sqlmodel->countRecords('users',$where);
		$data['total_pages'] = ceil($data['count']/$data['limit']);

		$data['title'] = "Users";
		$data['filename'] = "users/list";
		$this->load->view('admin/layout',$data);
	}

	public function add()
	{
		fv('email','email','required|trim|valid_email|is_unique[users.email]');
		fv('password','password','required|trim');
		fv('cpassword',' confirm password','trim|required');
		fv('firstname','first name','required|trim');
		fv('lastname','last name','required|trim');
		if($this->form_validation->run() == false) {

			$data['title'] = "Add User";
			$data['filename'] = "users/add";
			$this->load->view('admin/layout', $data);
		}else{
			$info = array(
				'firstname' => post('firstname'),
				'lastname' => post('lastname'),
				'email' => post('email'),
				'password' => encriptsha1(post('password')),
				'role_id' => post('role_id'),
				'status' => post('status'),
				'created' => date("Y-m-d h:i:s")
			);
			$user_info = $this->sqlmodel->insertRecord('users',$info);
			if($user_info){
				set_msg('success','User added successfully.');
			}else{
				set_msg('error','Something went wrong');
			}
			redirect(ADMIN_URL.'users');
		}
	}
	public function edit($id = '')
	{
		if($id == ''){
			set_msg('error','Something went wrong');
			redirect(ADMIN_URL.'users');
		}
		$userinfo = $this->sqlmodel->getSingleRecord("users",array("id" => $id));
		if(!$userinfo){
			set_msg('error','Something went wrong');
			redirect(ADMIN_URL.'users');
		}
		fv('email','email','required|trim|valid_email');
		fv('firstname','first name','required|trim');
		fv('lastname','last name','required|trim');
		if($this->form_validation->run() == false) {
			$data['title'] = "Edit User";
			$data['filename'] = "users/edit";
			$data['user'] = $userinfo;
			$this->load->view('admin/layout', $data);
		}else{
			$info = array(
				'firstname' => post('firstname'),
				'lastname' => post('lastname'),
				'email' => post('email'),
				'role_id' => post('role_id'),
				'status' => post('status')
			);
			if(post('password') && post('password') != ""){
				$info['password'] = encriptsha1(post('password'));
			}
			$user_info = $this->sqlmodel->updateRecord('users',$info,array("id" => $id));
			if($user_info){
				set_msg('success','User information updated successfully.');
			}else{
				set_msg('error','Something went wrong');
			}
			redirect(ADMIN_URL.'users');
		}
	}

	public function delete($id = ''){
		if($id == ''){
			set_msg('error','Something went wrong');
			redirect(ADMIN_URL.'users');
		}
		$userinfo = $this->sqlmodel->getSingleRecord("users",array("id" => $id));
		if(!$userinfo){
			set_msg('error','Something went wrong');
			redirect(ADMIN_URL.'users');
		}else{
			$this->sqlmodel->updateRecord('users',array("status" => -1),array("id" => $id));
			set_msg('success','Record has been deleted successfully.');
			redirect(ADMIN_URL.'users');
		}
	}

	public function bulk_delete()
	{
		$userIds = $this->input->post('user_ids');
		if (empty($userIds) || !is_array($userIds)) {
			set_msg('warning', 'Please select at least one user.');
			redirect(ADMIN_URL.'users');
		}

		$validIds = array();
		foreach ($userIds as $id) {
			$id = (int) $id;
			if ($id > 0) {
				$validIds[] = $id;
			}
		}

		if (empty($validIds)) {
			set_msg('warning', 'No valid users selected.');
			redirect(ADMIN_URL.'users');
		}

		$this->db->where_in('id', $validIds);
		$this->db->update('users', array('status' => -1));
		set_msg('success', count($validIds) . ' user(s) deleted successfully.');
		redirect(ADMIN_URL.'users');
	}
}
