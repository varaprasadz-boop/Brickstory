<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

	public function index()
	{
		$this->load->model('Admin_dashboard_model', 'dashboard_model');
		$summary = $this->dashboard_model->get_summary_stats();

		$userSeries = $this->dashboard_model->get_monthly_user_registrations(12);
		$storySeries = $this->dashboard_model->get_monthly_story_activity(12);
		$chart = $this->buildCombinedMonthlySeries($userSeries, $storySeries);

		$data['summary'] = $summary;
		$data['recent_users'] = $this->dashboard_model->get_recent_users(8);
		$data['recent_homes'] = $this->dashboard_model->get_recent_homes(8);
		$data['recent_activity'] = $this->dashboard_model->get_recent_activity(10);
		$data['top_products'] = $this->dashboard_model->get_top_products(5);
		$data['chart_labels'] = $chart['labels'];
		$data['chart_users'] = $chart['users'];
		$data['chart_stories'] = $chart['stories'];

		$data['title'] = "Dashboard";
		$data['filename'] = "dashboard";
		$this->load->view('admin/layout',$data);
	}

	private function buildCombinedMonthlySeries($users, $stories)
	{
		$map = array();
		foreach ($users as $row) {
			$map[$row['bucket']] = array(
				'users' => (int) $row['total'],
				'stories' => 0,
			);
		}
		foreach ($stories as $row) {
			if (!isset($map[$row['bucket']])) {
				$map[$row['bucket']] = array('users' => 0, 'stories' => 0);
			}
			$map[$row['bucket']]['stories'] = (int) $row['total'];
		}
		ksort($map);

		$labels = array();
		$userData = array();
		$storyData = array();
		foreach ($map as $bucket => $vals) {
			$labels[] = date('M Y', strtotime($bucket.'-01'));
			$userData[] = $vals['users'];
			$storyData[] = $vals['stories'];
		}
		return array(
			'labels' => $labels,
			'users' => $userData,
			'stories' => $storyData,
		);
	}
}
