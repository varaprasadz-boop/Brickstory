<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cms extends Admin_Controller {

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

		if($category){
			$where['design_code like '] = "%".$category."%";
		}
		$where['lang_id'] = 1;

		$data['cms'] = $this->sqlmodel->getRecords('*','cms '.$external_join, $sortby, $orderby, $where, $data['limit'], $start);
		$data['count'] = $this->sqlmodel->countRecords('cms',$where);
		$data['total_pages'] = ceil($data['count']/$data['limit']);

		$data['title'] = "CMS List";
		$data['filename'] = "cms/list";
		$this->load->view('admin/layout',$data);
	}

	public function add()
	{
		fv('title','title','required|trim');
		fv('slug_url','slug url','trim|required');
		fv('description','description','required|trim');
		fv('meta_title','meta title','required|trim');
		fv('meta_keywords','meta keywords','required|trim');
		fv('meta_description','meta description','required|trim');
		if($this->form_validation->run() == false) {
			$data['title'] = "Add CMS";
			$data['filename'] = "cms/add";
			$this->load->view('admin/layout', $data);
		}else{
			$title = trim(strip_tags(post('title')));
			$slug_url = trim(strip_tags(post('slug_url')));
			$description = trim($this->input->post('description'));
			$status = trim(strip_tags(post('status')));
			$meta_title = trim(strip_tags(post('meta_title')));
			$meta_keywords = trim(strip_tags(post('meta_keywords')));
			$meta_description = trim(strip_tags(post('meta_description')));
			$info = array(
				'title' => $title,
				'slug_url' => $slug_url,
				'description' => $description,
				'status' => $status
			);
			$meta_cms = array(
				'meta_title' => $meta_title,
				'meta_keywords' => $meta_keywords,
				'meta_description' => $meta_description
			);


			$user_info = $this->sqlmodel->updateRecord('cms',$info,array("cms_id" => $cmsinfo['cms_id']));
			$user_info = $this->sqlmodel->updateRecord('cms_meta',$meta_cms,array("cms_id" => $cmsinfo['cms_id']));
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
		$cmsinfo = $this->sqlmodel->getSingleRecord("cms",array("id" => $id));
		if(!$cmsinfo){
			set_msg('error','Something went wrong');
			redirect(ADMIN_URL.'users');
		}
		fv('title','title','required|trim');
		fv('slug_url','slug url','trim|required');
		fv('description','description','required|trim');
		fv('meta_title','meta title','required|trim');
		fv('meta_keywords','meta keywords','required|trim');
		fv('meta_description','meta description','required|trim');
		if($this->form_validation->run() == false) {
			$data['cms_meta'] = $this->sqlmodel->getSingleRecord("cms_meta",array("cms_id" => $cmsinfo['cms_id']));
			// dd($data['cms_meta']);
			$data['title'] = "Edit CMS Page";
			$data['filename'] = "cms/edit";
			$data['cmsinfo'] = $cmsinfo;
			$this->load->view('admin/layout', $data);
		}else{
			$title = trim(strip_tags(post('title')));
			$slug_url = trim(strip_tags(post('slug_url')));
			$description = trim($this->input->post('description'));
			$status = trim(strip_tags(post('status')));
			$meta_title = trim(strip_tags(post('meta_title')));
			$meta_keywords = trim(strip_tags(post('meta_keywords')));
			$meta_description = trim(strip_tags(post('meta_description')));
			$info = array(
				'title' => $title,
				'slug_url' => $slug_url,
				'description' => $description,
				'status' => $status
			);
			$meta_cms = array(
				'meta_title' => $meta_title,
				'meta_keywords' => $meta_keywords,
				'meta_description' => $meta_description
			);


			$user_info = $this->sqlmodel->updateRecord('cms',$info,array("cms_id" => $cmsinfo['cms_id']));
			$user_info = $this->sqlmodel->updateRecord('cms_meta',$meta_cms,array("cms_id" => $cmsinfo['cms_id']));
			if($user_info){
				set_msg('success','CMS information updated successfully.');
			}else{
				set_msg('error','Something went wrong');
			}
			redirect(ADMIN_URL.'cms');
		}
	}

	public function delete($id = ''){
		if($id == ''){
			set_msg('error','Something went wrong');
			redirect(ADMIN_URL.'cms');
		}
		$userinfo = $this->sqlmodel->getSingleRecord("cms",array("id" => $id));
		if(!$userinfo){
			set_msg('error','Something went wrong');
			redirect(ADMIN_URL.'cms');
		}else{
			$this->sqlmodel->deleteRecord('cms',array("id" => $id));
			set_msg('success','Record has been deleted successfully.');
			redirect(ADMIN_URL.'cms');
		}
	}
}
