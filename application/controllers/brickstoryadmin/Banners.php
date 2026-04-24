<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banners extends Admin_Controller {

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

		$data['advertisement'] = $this->sqlmodel->getRecords('*','advertisement'.$external_join, $sortby, $orderby, $where, $data['limit'], $start);
		$data['count'] = $this->sqlmodel->countRecords('advertisement',$where);
		$data['total_pages'] = ceil($data['count']/$data['limit']);

		$data['title'] = "Banners";
		$data['filename'] = "banners/list";
		$this->load->view('admin/layout',$data);
	}

	public function add()
	{
		fv('section_id','section','required|trim');
		fv('title','title','trim');
		fv('description','description','trim');
		fv('status','status','required|trim');
		if($this->form_validation->run() == false) {

			$data['title'] = "Add Banner";
			$data['filename'] = "banners/add";
			$this->load->view('admin/layout', $data);
		}else{
			$banner_name = '';
			$image = do_upload('image','./assets/uploads/banner_ad_images/');
			if(!$image['upload_data']['file_name']){
				set_msg('error','Unable to upload the banner, please try again.');
				redirect(ADMIN_URL.'banners/add');
			}else{
				$banner_name = $image['upload_data']['file_name'];

			}
			$info = array(
				'section_id' => post('section_id'),
				'title' => post('title'),
				'description' => post('description'),
				'status' => post('status'),
				'order' => post('order'),
				'created_on' => date("Y-m-d h:i:s"),
				'created_by' => 1,
				'lang_id' => 1,
				'image_url' => $banner_name
			);
			$user_info = $this->sqlmodel->insertRecord('advertisement',$info);
			if($user_info){
				set_msg('success','Banner added successfully.');
			}else{
				set_msg('error','Something went wrong');
			}
			redirect(ADMIN_URL.'banners');
		}
	}
	public function edit($banner_id='')
	{
		$banner_info = $this->sqlmodel->getSingleRecord("advertisement",array("id" => $banner_id));
		if(!$banner_info){
			redirect(ADMIN_URL.'banners');
		}
		fv('section_id','section','required|trim');
		fv('title','title','trim');
		fv('description','description','trim');
		fv('status','status','required|trim');
		if($this->form_validation->run() == false) {
			$data['banner'] = $banner_info;
			$data['title'] = "Update Banner";
			$data['filename'] = "banners/edit";
			$this->load->view('admin/layout', $data);
		}else{
			$banner_name = '';
			if(isset($_FILES['image']) && $_FILES['image']['tmp_name'] != ""){
				$image = do_upload('image', './assets/uploads/banner_ad_images/');
				if ($image['upload_data']['file_name']) {
					$banner_name = $image['upload_data']['file_name'];
				}
			}
			$info = array(
				'section_id' => post('section_id'),
				'title' => post('title'),
				'description' => post('description'),
				'status' => post('status'),
				'order' => post('order'),
				'created_on' => date("Y-m-d h:i:s"),
				'created_by' => 1,
				'lang_id' => 1
			);
			if($banner_name != ""){
				$info['image_url'] = $banner_name;
			}
			$user_info = $this->sqlmodel->updateRecord('advertisement',$info,array("id" => $banner_id));
			if($user_info){
				set_msg('success','Banner updated successfully.');
			}else{
				set_msg('error','Something went wrong');
			}
			redirect(ADMIN_URL.'banners');
		}
	}

	public function delete($id = ''){
		if($id == ''){
			set_msg('error','Invalid banner id');
			redirect(ADMIN_URL.'users');
		}
		$userinfo = $this->sqlmodel->getSingleRecord("advertisement",array("id" => $id));
		if(!$userinfo){
			set_msg('error','Something went wrong');
			redirect(ADMIN_URL.'banners');
		}else{
			$this->sqlmodel->deleteRecord('advertisement',array("id" => $id));
			set_msg('success','Record has been deleted successfully.');
			redirect(ADMIN_URL.'banners');
		}
	}
}
