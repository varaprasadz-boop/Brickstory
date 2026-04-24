<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends Admin_Controller {

	public function index($page=1)
	{

		$data['real_page'] = $page;
		$sortby = 'id';
		$orderby = 'desc';
		$page = ($page >=0)?($page - 1):($page);
		$start = ($page * get_settings('RECORD_PER_PAGE'));
		$data['limit'] = get_settings('RECORD_PER_PAGE');
		$data['page'] = $page;
		//--------------
		$get = get();
		$search = isset($get['search'])?($get['search']):(false);

		$external_join = '';
		$where = array();
		//$external_join .= ' LEFT JOIN roles r on (u.role_id = r.id)';

		if($search){
			$where['LOWER(setting_title) like '] = "%".strtolower($search)."%";
		}

		$data['settings'] = $this->sqlmodel->getRecords('*','settings'.$external_join, $sortby, $orderby, $where, $data['limit'], $start);
		$data['count'] = $this->sqlmodel->countRecords('settings',$where);
		$data['total_pages'] = ceil($data['count']/$data['limit']);

		$data['title'] = "Settings";
		$data['filename'] = "settings/list";
		$this->load->view('admin/layout',$data);
	}

	public function add()
	{
		fv('setting_title','setting title','required|trim');
		fv('setting_label',' setting label','trim|required');
		fv('setting_value','setting value','required|trim');
		if($this->form_validation->run() == false) {
			$data['title'] = "Add Setting";
			$data['filename'] = "settings/add";
			$this->load->view('admin/layout', $data);
		}else{
			$info = array(
				'setting_title' => post('setting_title'),
				'setting_label' => post('setting_label'),
				'setting_value' => post('setting_value'),
				'comment' => post('comment'),
			);
			$settings_info = $this->sqlmodel->insertRecord('settings',$info);
			if($settings_info){
				set_msg('success','Setting added successfully.');
			}else{
				set_msg('error','Something went wrong');
			}
			redirect(ADMIN_URL.'settings');
		}
	}

	public function edit($setting_id='')
	{
		fv('setting_title','setting title','required|trim');
		fv('setting_label',' setting label','trim|required');
		fv('setting_value','setting value','required|trim');
		$setting = array();
		if($setting_id != ""){
			$setting = $this->sqlmodel->getSingleRecord('settings',array("id" => $setting_id));
		}
		if(empty($setting)){
			redirect(ADMIN_URL.'settings');
		}
		$data['setting'] = $setting;

		if($this->form_validation->run() == false) {

			$data['title'] = "Update Setting";
			$data['filename'] = "settings/edit";
			$this->load->view('admin/layout', $data);
		}else{
			$info = array(
				'setting_title' => post('setting_title'),
				'setting_label' => post('setting_label'),
				'setting_value' => post('setting_value'),
				'comment' => post('comment'),
			);
			$settings_info = $this->sqlmodel->updateRecord('settings',$info,array("id" => $setting_id));
			if($settings_info){
				set_msg('success','Setting updated successfully.');
			}else{
				set_msg('error','Something went wrong');
			}
			redirect(ADMIN_URL.'settings');
		}
	}


	public function delete($id = ''){
		if($id == ''){
			set_msg('error','Something went wrong');
			redirect(ADMIN_URL.'settings');
		}
		$userinfo = $this->sqlmodel->getSingleRecord("settings",array("id" => $id));
		if(!$userinfo){
			set_msg('error','Something went wrong');
			redirect(ADMIN_URL.'settings');
		}else{
			$this->sqlmodel->deleteRecord('settings',array("id" => $id));
			set_msg('success','Record has been deleted successfully.');
			redirect(ADMIN_URL.'settings');
		}
	}
}
