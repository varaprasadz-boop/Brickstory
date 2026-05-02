<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_dashboard_model extends CI_Model
{
	private $tableExistsCache = array();

	private function table_exists_cached($table)
	{
		if (!array_key_exists($table, $this->tableExistsCache)) {
			$this->tableExistsCache[$table] = $this->db->table_exists($table);
		}
		return $this->tableExistsCache[$table];
	}

	public function get_summary_stats()
	{
		$sql = "SELECT
			(SELECT COUNT(*) FROM users) AS total_users,
			(SELECT COUNT(*) FROM users WHERE status = 1) AS active_users,
			(SELECT COUNT(*) FROM brickstory_profile) AS total_homes,
			(SELECT COUNT(*) FROM brickstory_profile WHERE status = 1) AS approved_homes,
			(SELECT COUNT(*) FROM brickstory_profile WHERE monitor_home = 1) AS monitored_homes,
			(SELECT COUNT(*) FROM brickstory_substories) AS total_stories,
			(SELECT COUNT(*) FROM brickstory_substories WHERE DATE(created_on) = CURDATE()) AS stories_today,
			(SELECT COUNT(*) FROM brickstory_person) AS total_people,
			(SELECT COUNT(*) FROM products) AS total_products,
			(SELECT COUNT(*) FROM products WHERE status = 1) AS active_products";
		return $this->db->query($sql)->row_array();
	}

	public function get_recent_users($limit = 8)
	{
		$limit = (int) $limit;
		return $this->db
			->select('id, firstname, lastname, email, status, created')
			->from('users')
			->order_by('created', 'DESC')
			->limit($limit)
			->get()
			->result_array();
	}

	public function get_recent_homes($limit = 8)
	{
		$limit = (int) $limit;
		return $this->db
			->select('id, address1, city, state, zip, year_built, status, monitor_home')
			->from('brickstory_profile')
			->order_by('id', 'DESC')
			->limit($limit)
			->get()
			->result_array();
	}

	public function get_recent_activity($limit = 10)
	{
		$limit = (int) $limit;
		if (!$this->table_exists_cached('activity_log')) {
			return array();
		}

		return $this->db
			->select('a.id, a.user_id, a.url, a.ip_address, a.created, u.firstname, u.lastname, u.email')
			->from('activity_log a')
			->join('users u', 'u.id = a.user_id', 'left')
			->order_by('a.id', 'DESC')
			->limit($limit)
			->get()
			->result_array();
	}

	public function get_top_products($limit = 5)
	{
		$limit = (int) $limit;
		if (!$this->table_exists_cached('products')) {
			return array();
		}

		$query = $this->db->query(
			"SELECT p.product_id, p.name, p.price, p.status, p.created_on,
			        COUNT(pi.id) AS image_count
			 FROM products p
			 LEFT JOIN product_images pi ON pi.product_id = p.product_id
			 GROUP BY p.product_id, p.name, p.price, p.status, p.created_on
			 ORDER BY image_count DESC, p.product_id DESC
			 LIMIT ?",
			array($limit)
		);
		return $query->result_array();
	}

	public function get_monthly_user_registrations($months = 12)
	{
		$months = (int) $months;
		$query = $this->db->query(
			"SELECT DATE_FORMAT(created, '%Y-%m') AS bucket, COUNT(*) AS total
			 FROM users
			 WHERE created >= DATE_SUB(CURDATE(), INTERVAL ? MONTH)
			 GROUP BY DATE_FORMAT(created, '%Y-%m')
			 ORDER BY bucket ASC",
			array($months)
		);
		return $query->result_array();
	}

	public function get_monthly_story_activity($months = 12)
	{
		$months = (int) $months;
		$query = $this->db->query(
			"SELECT DATE_FORMAT(created_on, '%Y-%m') AS bucket, COUNT(*) AS total
			 FROM brickstory_substories
			 WHERE created_on >= DATE_SUB(CURDATE(), INTERVAL ? MONTH)
			 GROUP BY DATE_FORMAT(created_on, '%Y-%m')
			 ORDER BY bucket ASC",
			array($months)
		);
		return $query->result_array();
	}
}

