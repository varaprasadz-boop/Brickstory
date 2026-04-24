<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

	public function login()
	{
		fv('email','email','required|valid_email|trim');
		fv('password','password','required|trim');
		if($this->form_validation->run() == false){
			$data['title'] = "Administration Login";
			$this->load->view('admin/login', $data);
		}else{
			$post = post();
			$post_data['password'] = encriptsha1($post['password']);
			$post_data['role_id'] = 1;
			$post_data['email'] = $post['email'];
			$user = $this->sqlmodel->getSingleRecord('users',$post_data);
			if(isset($user['status']) && $user['status'] == 1){
				$this->session->set_userdata(array("admin_user_id" => $user['id']));
				$this->session->set_userdata(array("fullname" => $user['firstname'].' '.$user['lastname']));
				redirect(ADMIN_URL.'dashboard');
			}else{
				set_msg('error','Wrong username/password');
				redirect(ADMIN_URL.'login');
			}
		}
	}

	public function forgotpassword()
	{
		fv('email','email','required|valid_email|trim');
		if($this->form_validation->run() == false){
			$data['title'] = "Administration Login";
			$this->load->view('admin/forgotpassword', $data);
		}else{
			$post = post();
			//$post['password'] = encriptsha1($post['password']);
			$post['role_id'] = 1;
			$user = $this->sqlmodel->getSingleRecord('users',$post);
//			pre($user);
			if(isset($user['status']) && $user['status'] == 1){
//				$this->session->set_userdata(array("admin_user_id" => $user['id']));
//				$this->session->set_userdata(array("fullname" => $user['firstname'].' '.$user['lastname']));
				//$post['emailContent'] = $this->sqlmodel->getSingleRecord("email_template",array("template_name" => "registration_template"));


				$post['template_path'] = "email_templates/email_adminForgotPassword";
//				pre($post);
				$post['name'] = $user['firstname'].' '.$user['lastname'];
				$post['emailContent'] = '';
				$post['subject'] = "Reset BrickStory Administrator Password";
				$post['URL'] = ADMIN_URL.'account/resetPassword/'.md5($user['id']);
				$this->sqlmodel->updateRecord("users",array("validate_expire_link" => time()+86400),array("id" => $user['id']));
				send_email($post);
				set_msg('error','Password reset link sent to your email address.');
				redirect(ADMIN_URL.'login');
			}else{
				set_msg('error','Invalid email address');
				redirect(ADMIN_URL.'login');
			}
		}
	}
	public function resetPassword($user_id='')
	{
		fv('password','password','required|trim');
		fv('confirm_password','email','required|trim');
		if($this->form_validation->run() == false){
			$data['title'] = "Administration Login";
			$this->load->view('admin/resetPassword', $data);
		}else{
			$post = post();
			$post['password'] = encriptsha1($post['password']);
			$post['role_id'] = 1;
			$user = $this->sqlmodel->getSingleRecord('users',$post);
			if(isset($user['status']) && $user['status'] == 1){

				$post['template_path'] = "email_templates/email_adminForgotPassword";
				$post['name'] = $user['firstname'].' '.$user['lastname'];
				$post['emailContent'] = '';
				$post['subject'] = "Reset BrickStory Administrator Password";
				$post['URL'] = ADMIN_URL.'account/resetPassword/'.md5($user['id']);
				$this->sqlmodel->updateRecord("users",array("validate_expire_link" => time()+86400),array("id" => $user['id']));
				send_email($post);
				set_msg('error','Password reset link sent to your email address.');
				redirect(ADMIN_URL.'login');
			}else{
				set_msg('error','Invalid email address');
				redirect(ADMIN_URL.'login');
			}
		}
	}

	public function logout(){
//		$this->session->userdata(array("admin_user_id" => false));
//		$this->session->unset_userdata("admin_user_id");
		$this->session->userdata = array();
		$this->session->sess_destroy();
		redirect(ADMIN_URL.'login');
	}
}
