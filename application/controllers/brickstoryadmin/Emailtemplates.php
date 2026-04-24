<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emailtemplates extends Admin_Controller {

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
		$external_join .= '';

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

		$data['email_templates'] = $this->sqlmodel->getRecords('*','email_template'.$external_join, $sortby, $orderby, $where, $data['limit'], $start);
		$data['count'] = $this->sqlmodel->countRecords('email_template',$where);
		$data['total_pages'] = ceil($data['count']/$data['limit']);

		$data['title'] = "Email Templates";
		$data['filename'] = "emailtemplates/list";
		$this->load->view('admin/layout',$data);
	}

	public function add()
	{
		fv('template_name','template name','required|trim');
		fv('template_subject',' template subject','trim|required');
		fv('template_body','template body','required|trim');
		fv('status','status','required|trim');
		if($this->form_validation->run() == false) {
			$data['title'] = "Add Email Template";
			$data['filename'] = "emailtemplates/add";
			$this->load->view('admin/layout', $data);
		}else{
			$info = array(
				'template_name' => post('template_name'),
				'template_subject' => post('template_subject'),
				'template_body' => post('template_body'),
				'status' => post('status'),
				'lang_id' => 1,
				'created_by' => 1,
				'modified_by' => 1,
				'created' => date("Y-m-d h:i:s")
			);
			$user_info = $this->sqlmodel->insertRecord(' email_template',$info);
			if($user_info){
				set_msg('success','Email template added successfully.');
			}else{
				set_msg('error','Something went wrong');
			}
			redirect(ADMIN_URL.'emailtemplates');
		}
	}
	public function edit($template_id='')
	{
		$template = $this->sqlmodel->getSingleRecord("email_template",array("id" => $template_id));
		if(!$template){
			redirect(ADMIN_URL.'emailtemplates');
		}
		fv('template_name','template name','required|trim');
		fv('template_subject',' template subject','trim|required');
		fv('template_body','template body','required');
		fv('status','status','required|trim');
		if($this->form_validation->run() == false) {
			$data['title'] = "Update Email Template";
			$data['filename'] = "emailtemplates/edit";
			$data['template'] = $template;
			$this->load->view('admin/layout', $data);
		}else{
			$info = array(
				'template_name' => post('template_name'),
				'template_subject' => post('template_subject'),
				'template_body' => $this->input->post('template_body'),
				'status' => post('status'),
				'lang_id' => 1,
				'created_by' => 1,
				'modified_by' => 1,
			);
			$user_info = $this->sqlmodel->updateRecord(' email_template',$info,array("id" => $template_id));
			if($user_info){
				set_msg('success','Email template updated successfully.');
			}else{
				set_msg('error','Something went wrong');
			}
			redirect(ADMIN_URL.'emailtemplates');
		}
	}


	public function delete($id = ''){
		if($id == ''){
			set_msg('error','Something went wrong');
			redirect(ADMIN_URL.'emailtemplates');
		}
		$userinfo = $this->sqlmodel->getSingleRecord("email_template",array("id" => $id));
		if(!$userinfo){
			set_msg('error','Something went wrong');
			redirect(ADMIN_URL.'emailtemplates');
		}else{
			$this->sqlmodel->deleteRecord('email_template',array("id" => $id));
			set_msg('success','Record has been deleted successfully.');
			redirect(ADMIN_URL.'emailtemplates');
		}
	}
}
