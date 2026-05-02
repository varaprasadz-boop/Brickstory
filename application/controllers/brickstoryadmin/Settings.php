<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends Admin_Controller {

	private $groups = array(
		'mail' => 'Email (SMTP)',
		'sms' => 'SMS (Twilio)',
		'maps' => 'Google Maps',
		'branding' => 'Branding',
		'contact' => 'Contact & Social',
		'business' => 'Business Rules',
		'uploads' => 'Uploads',
		'seo' => 'SEO & Analytics',
		'system' => 'System',
	);

	private function hasGroupedSettingsSchema() {
		$q = $this->db->query("SHOW COLUMNS FROM settings LIKE 'setting_group'");
		return ($q && $q->num_rows() > 0);
	}

	public function index($page=1)
	{
		redirect(admin_url('settings/group/mail'));
	}

	public function advanced($page=1)
	{
		$data['real_page'] = $page;
		$sortby = 'id';
		$orderby = 'desc';
		$page = ($page >=0)?($page - 1):($page);
		$start = ($page * get_settings('BIZ_RECORDS_PER_PAGE', get_settings('RECORD_PER_PAGE', 12)));
		$data['limit'] = get_settings('BIZ_RECORDS_PER_PAGE', get_settings('RECORD_PER_PAGE', 12));
		$data['page'] = $page;
		$get = get();
		$search = isset($get['search'])?($get['search']):(false);
		$where = array();
		if($search){
			$where['LOWER(setting_title) like '] = "%".strtolower($search)."%";
		}
		$data['settings'] = $this->sqlmodel->getRecords('*','settings', $sortby, $orderby, $where, $data['limit'], $start);
		$data['count'] = $this->sqlmodel->countRecords('settings',$where);
		$data['total_pages'] = ceil($data['count']/$data['limit']);
		$data['title'] = "Settings";
		$data['filename'] = "settings/list";
		$this->load->view('admin/layout',$data);
	}

	public function group($group = 'mail') {
		if (!$this->hasGroupedSettingsSchema()) {
			set_msg('warning', 'Settings schema is not migrated yet. Please run SQL migration 001 first.');
			redirect(admin_url('settings/advanced/1'));
		}
		if (!isset($this->groups[$group])) {
			show_404();
		}
		$data['groups'] = $this->groups;
		$data['current'] = $group;
		$data['rows'] = $this->sqlmodel->getRecords('*','settings','sort_order','asc',array('setting_group' => $group),9999,0);
		$data['title'] = 'Settings - '.$this->groups[$group];
		$data['filename'] = 'settings/groups';
		$this->load->view('admin/layout', $data);
	}

	public function save($group = 'mail') {
		if (!$this->hasGroupedSettingsSchema()) {
			set_msg('error', 'Cannot save grouped settings until migration 001 is applied.');
			redirect(admin_url('settings/advanced/1'));
		}
		if (!isset($this->groups[$group])) {
			show_404();
		}

		$rows = $this->sqlmodel->getRecords('*','settings','sort_order','asc',array('setting_group' => $group),9999,0);
		$this->db->trans_start();
		if ($rows) {
			foreach ($rows as $rowObj) {
				$row = (array) $rowObj;
				$val = $this->input->post($row['setting_label']);

				if ($row['setting_type'] === 'boolean') {
					$val = $val ? '1' : '0';
				} elseif ($row['setting_type'] === 'image' && !empty($_FILES[$row['setting_label']]['name'])) {
					$upload = do_upload($row['setting_label'], './assets/uploads/settings/');
					if ($upload !== 'error') {
						$val = base_url('assets/uploads/settings/' . $upload['upload_data']['file_name']);
					} else {
						continue;
					}
				} elseif ((int) $row['is_secret'] === 1 && ($val === null || $val === '')) {
					continue;
				}

				$this->sqlmodel->updateRecord('settings', array('setting_value' => $val), array('id' => $row['id']));
			}
		}
		$this->db->trans_complete();
		set_msg('success', 'Settings saved.');
		redirect(admin_url('settings/group/'.$group));
	}

	public function test_smtp() {
		$to = $this->input->post('to') ?: get_settings('MAIL_FROM_EMAIL', site_email());
		$this->load->library('email');
		$this->email->initialize(array(
			'protocol'    => get_settings('MAIL_PROTOCOL', 'smtp'),
			'smtp_host'   => get_settings('MAIL_SMTP_HOST', ''),
			'smtp_port'   => (int) get_settings('MAIL_SMTP_PORT', '465'),
			'smtp_user'   => get_settings('MAIL_SMTP_USER', ''),
			'smtp_pass'   => get_secret_settings('MAIL_SMTP_PASS', ''),
			'smtp_crypto' => get_settings('MAIL_SMTP_CRYPTO', 'ssl'),
			'mailtype' => 'html', 'charset' => 'iso-8859-1', 'wordwrap' => TRUE,
			'newline' => "\r\n", 'crlf' => "\r\n",
		));
		$this->email->from(site_email(), get_settings('MAIL_FROM_NAME', site_name()));
		$this->email->to($to);
		$this->email->subject('Brickstory SMTP test');
		$this->email->message('If you received this, SMTP is configured correctly.');
		$ok = $this->email->send();
		$this->output->set_content_type('application/json')
			->set_output(json_encode(array(
				'status' => $ok ? 'success' : 'failure',
				'message' => $ok ? 'Email sent.' : 'Send failed',
				'data' => $ok ? null : $this->email->print_debugger(),
			)));
	}

	public function test_twilio() {
		$to = $this->input->post('to');
		if (!$to) {
			$this->output->set_content_type('application/json')
				->set_output(json_encode(array('status' => 'failure', 'message' => 'Recipient phone is required.')));
			return;
		}
		$this->load->library('twilio_lib');
		$result = $this->twilio_lib->send_sms($to, 'Brickstory SMS test.');
		$ok = !empty($result) && stripos($result, 'error') === false && stripos($result, 'missing') === false;
		$this->output->set_content_type('application/json')
			->set_output(json_encode(array(
				'status' => $ok ? 'success' : 'failure',
				'message' => $ok ? 'SMS sent.' : $result,
				'data' => $result,
			)));
	}

	public function test_maps() {
		$key = get_secret_settings('MAPS_BACKEND_KEY', '');
		$url = 'https://maps.googleapis.com/maps/api/geocode/json?address=Mountain+View,+CA&key=' . urlencode($key);
		$response = @file_get_contents($url);
		$json = $response ? json_decode($response, true) : array();
		$status = isset($json['status']) ? $json['status'] : 'REQUEST_FAILED';
		$ok = in_array($status, array('OK', 'ZERO_RESULTS'));
		$this->output->set_content_type('application/json')
			->set_output(json_encode(array(
				'status' => $ok ? 'success' : 'failure',
				'message' => $ok ? 'Maps key is valid.' : 'Maps key test failed.',
				'data' => array(
					'frontend_url' => 'https://maps.googleapis.com/maps/api/js?key=' . urlencode(get_settings('MAPS_FRONTEND_KEY', '')),
					'backend_status' => $status,
				),
			)));
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
			redirect(admin_url('settings/advanced/1'));
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
			redirect(admin_url('settings/advanced/1'));
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
			redirect(admin_url('settings/advanced/1'));
		}
	}


	public function delete($id = ''){
		if($id == ''){
			set_msg('error','Something went wrong');
			redirect(admin_url('settings/advanced/1'));
		}
		$userinfo = $this->sqlmodel->getSingleRecord("settings",array("id" => $id));
		if(!$userinfo){
			set_msg('error','Something went wrong');
			redirect(admin_url('settings/advanced/1'));
		}else{
			$this->sqlmodel->deleteRecord('settings',array("id" => $id));
			set_msg('success','Record has been deleted successfully.');
			redirect(admin_url('settings/advanced/1'));
		}
	}
}
