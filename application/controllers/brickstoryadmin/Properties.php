<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Properties extends Admin_Controller {

	public function index($page = 1)
	{
		$data['real_page'] = (int) $page;
		$page = max(1, (int) $page);
		$pageIndex = $page - 1;
		$data['limit'] = (int) get_settings('BIZ_RECORDS_PER_PAGE', get_settings('RECORD_PER_PAGE', 12));
		$data['page'] = $pageIndex;
		$start = $pageIndex * $data['limit'];

		$filters = array(
			'search' => trim((string) $this->input->get('search')),
			'status' => (string) $this->input->get('status'),
			'state' => trim((string) $this->input->get('state')),
			'monitor_home' => (string) $this->input->get('monitor_home'),
			'user_id' => (string) $this->input->get('user_id'),
		);
		$data['filters'] = $filters;
		$data['property_users'] = $this->db
			->select("u.id, CONCAT(COALESCE(u.firstname,''), ' ', COALESCE(u.lastname,''), ' (', u.email, ')') AS name", false)
			->from('users u')
			->join('brickstory_profile bp', 'bp.user_id = u.id', 'inner')
			->group_by('u.id')
			->order_by('u.firstname', 'ASC')
			->get()
			->result_array();

		$countQuery = $this->db->from('brickstory_profile bp');
		$this->applyFilters($filters);
		$data['count'] = (int) $countQuery->count_all_results();
		$data['total_pages'] = max(1, (int) ceil($data['count'] / max(1, $data['limit'])));

		$listQuery = $this->db
			->select("
				bp.*,
				CONCAT(COALESCE(u.firstname,''), ' ', COALESCE(u.lastname,'')) AS user_name,
				u.email AS user_email,
				(SELECT COUNT(*) FROM brickstory_substories s WHERE s.master_story_id = bp.id) AS stories_count,
				(SELECT COUNT(*) FROM brickstory_person p WHERE p.master_story_id = bp.id) AS people_count
			", false)
			->from('brickstory_profile bp')
			->join('users u', 'u.id = bp.user_id', 'left');
		$this->applyFilters($filters);
		$data['properties'] = $listQuery
			->order_by('bp.id', 'DESC')
			->limit($data['limit'], $start)
			->get()
			->result();

		$data['title'] = 'Properties';
		$data['filename'] = 'properties/list';
		$this->load->view('admin/layout', $data);
	}

	public function view($id = 0)
	{
		$id = (int) $id;
		if ($id <= 0) {
			set_msg('error', 'Invalid property id.');
			redirect(admin_url('properties'));
		}

		$property = $this->db
			->select("bp.*, CONCAT(COALESCE(u.firstname,''), ' ', COALESCE(u.lastname,'')) AS user_name, u.email AS user_email", false)
			->from('brickstory_profile bp')
			->join('users u', 'u.id = bp.user_id', 'left')
			->where('bp.id', $id)
			->get()
			->row_array();

		if (!$property) {
			set_msg('error', 'Property not found.');
			redirect(admin_url('properties'));
		}

		$data['property'] = $property;
		$data['stories'] = $this->db
			->select('id, story_description, story_photo, approximate_date, created_on')
			->from('brickstory_substories')
			->where('master_story_id', $id)
			->order_by('id', 'DESC')
			->limit(20)
			->get()
			->result_array();

		$data['people'] = $this->db
			->select('id, frist_name, last_name, person_photo, relation_id')
			->from('brickstory_person')
			->where('master_story_id', $id)
			->order_by('id', 'DESC')
			->limit(20)
			->get()
			->result_array();

		$data['title'] = 'Property Details';
		$data['filename'] = 'properties/view';
		$this->load->view('admin/layout', $data);
	}

	private function applyFilters($filters)
	{
		if ($filters['search'] !== '') {
			$this->db->group_start()
				->like('bp.address1', $filters['search'])
				->or_like('bp.address2', $filters['search'])
				->or_like('bp.city', $filters['search'])
				->or_like('bp.state', $filters['search'])
				->or_like('bp.zip', $filters['search'])
				->or_like('bp.owner_name', $filters['search'])
				->group_end();
		}
		if ($filters['status'] !== '' && in_array($filters['status'], array('0', '1'), true)) {
			$this->db->where('bp.status', (int) $filters['status']);
		}
		if ($filters['state'] !== '') {
			$this->db->where('bp.state', $filters['state']);
		}
		if ($filters['monitor_home'] !== '' && in_array($filters['monitor_home'], array('0', '1'), true)) {
			$this->db->where('bp.monitor_home', (int) $filters['monitor_home']);
		}
		if ($filters['user_id'] !== '' && ctype_digit($filters['user_id'])) {
			$this->db->where('bp.user_id', (int) $filters['user_id']);
		}
	}
}

