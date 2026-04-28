<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function login()
	{
		fv('email','email','required|trim|valid_email');
		fv('password','password','required|trim');
		if(get('returnUrl')){
			$this->session->set_userdata("returnUrl",validateReturnUrl(get('returnUrl')));
		}
		
		if($this->form_validation->run() == false){
			$data['title'] = "Login";
			$data['filename'] = "login";
			$this->load->view('layout', $data);
		}else{
			//$result = $this->users_model->check_front_login(post('email'), post('password'));
//			query();
			//pre($result);
			$user = $this->sqlmodel->getSingleRecord('users',array('email' => post('email'),'password' => encriptsha1((post('password')))));
			if(isset($user['email'])){
				if($user['status'] == 1){
					$user_info = array(
						'user_id' => $user['id'],
						'name' => $user['firstname'].' '.$user['lastname']
					);
					$this->session->set_userdata($user_info);
					if($this->session->userdata("returnUrl")){
						$var  = $this->session->userdata("returnUrl");
						$this->session->unset_userdata("returnUrl");
						redirect($var);
					}else{
						redirect(base_url('dashboard'));
					}
				}else{
					set_msg('error','Your account is not active.');
					redirect(base_url('account/login'));
				}
			}else{
				set_msg('error','Wrong email/password');
				redirect(base_url('account/login'));
			}
		}
	}
	public function forgot_password()
	{
		fv('email','email','required|trim|valid_email');
		if($this->form_validation->run() == false){
			$data['title'] = "Forgot Password";
			$data['filename'] = "forgot_password";
			$this->load->view('layout', $data);
		}else{

			$user = $this->sqlmodel->getSingleRecord('users',array('email' => post('email')));
			if(isset($user['email'])){
				$post = $user;

				$post['emailContent'] = $this->sqlmodel->getSingleRecord("email_template",array("template_name" => "forgot_password_email_template"));

				$post['template_path'] = "email_templates/email_forgotPassword";
				$post['subject'] = $post['emailContent']['template_subject'];
				$post['company_name'] = $user['firstname'].' '.$user['lastname'];
				//$this->sqlmodel->updateRecord("users", array("reset_pass_expire" => time() + 3600), array("id" => $user['id']));
				$post['link'] = base_url('account/reset_password/' . md5($user['id']));
				send_email($post);
				set_msg('success', 'Password reset email has been sent.');
			} else {
				set_msg('error', 'Invalid email address.');
			}
			redirect(base_url('account/login'));
		}
	}
	public function reset_password($user_id='')
	{
		$user = $this->sqlmodel->getSingleRecord('users',array('md5(id)' => $user_id));
		if(!isset($user['email'])){
			redirect(base_url());
		}
		fv('password','password','required|trim');
		fv('confirm_password','confirm password','required|trim|matches[password]');
		if($this->form_validation->run() == false){
			$data['title'] = "Reset Password";
			$data['filename'] = "reset_password";
			$this->load->view('layout', $data);
		}else{
			if(isset($user['email'])){
				$post = $user;
				$this->sqlmodel->updateRecord("users",array("password" => encriptsha1(post('password'))),array("id" => $user['id']));
				$post['emailContent'] = $this->sqlmodel->getSingleRecord("email_template",array("template_name" => "password_reset_success"));
				$post['subject'] = $post['emailContent']['template_subject'];
				$post['template_path'] = "email_templates/password_reset_success";
				$post['subject'] = "Reset Password ";
				$post['company_name'] = $user['firstname'].' '.$user['lastname'];
				//$this->sqlmodel->updateRecord("users", array("reset_pass_expire" => time() + 3600), array("id" => $user['id']));
				send_email($post);
				set_msg('success', 'Password has been updated successfully.');
			} else {
				set_msg('error', 'Something went wrong.');
			}
			redirect(base_url('account/login'));
		}
	}
	public function register(){

		fv('firstname','first name','required|trim');
		fv('lastname','last name','required|trim');
		fv('email','email','required|trim|is_unique[users.email]');
		fv('confirm_password','confirm password','required|trim');
		fv('password', 'Password', 'required|matches[confirm_password]');

		if($this->form_validation->run() == false){
			json('failure','validation error',strip_tags(validation_errors()));
		}else{
			$post = post();
			unset($post['confirm_password']);

			$post['status'] = 0;
			$post['password'] = encriptsha1($post['password']);
			$post['role_id'] = 2;
			$post['activation_code'] = get_random_string();
			$post['activation_expiry'] = date('Y:m:d H:i:s', strtotime('+1 day', now()));
			$user_id = $this->sqlmodel->insertRecord("users",$post);

			$post['emailContent'] = $this->sqlmodel->getSingleRecord("email_template",array("template_name" => "registration_template"));


			$post['template_path'] = "email_templates/email_signup";
			$post['subject'] = $post['emailContent']['template_subject'];
			$post['activation_url'] = base_url('account/verify_account/'.md5($user_id));
			send_email($post);

			set_msg('success','Registration completed successfully.');
			json('success','Registration completed successfully!',null);
		}
	}

	public function verify_account($id=''){
		if($id != ""){
			$emailContent = $this->sqlmodel->getSingleRecord("users",array("md5(id)" => $id));
			$this->sqlmodel->updateRecord('users',array('status' => 1),array("id" => $emailContent['id'] ));
			set_msg('success','Email verified successfully.');
			redirect(base_url('account/login'));
		}
	}

	public function logout(){
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('name');
		redirect(base_url());
	}
}
