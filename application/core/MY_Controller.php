<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {}

class Admin_Controller extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->model('Auth_model');

		if (!$this->session->userdata('admin_logged_in')) {
			redirect('admin/login');
		}

		$admin_id = $this->session->userdata('admin_id');
		if (!$admin_id || !$this->Auth_model->user_exists($admin_id)) {
			$this->session->sess_destroy();
			redirect('admin/login');
		}
	}

	protected function require_post()
	{
		if ($this->input->method(TRUE) !== 'POST') {
			show_error('Method Not Allowed', 405);
		}
	}

	protected function render($view, $data = array())
	{
		ob_start();
		$this->load->view($view, $data);
		$data['content'] = ob_get_clean();
		$data['page_title'] = $data['title'] ?? 'Admin';
		$data['head_extra'] = $this->_admin_head_extra($data);
		$this->load->view('admin/shell_head', $data);
		$this->load->view('admin/layout', $data);
		$this->load->view('admin/shell_footer', $data);
	}

	protected function _admin_head_extra($data = array())
	{
		$extra = $data['head_extra'] ?? '';
		if (!empty($data['use_editor'])) {
			$extra .= '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs4.min.css">';
		}
		if (!empty($data['use_list_ajax'])) {
			$extra .= '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css">';
		}
		return $extra;
	}
}

class Bidang_Controller extends CI_Controller {

	protected $bidang_key = '';
	protected $view_name = '';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Berita_model');
		$this->load->helper('berita');
	}

	public function index()
	{
		$data = array(
			'berita_list' => $this->Berita_model->get_by_bidang($this->bidang_key),
			'bidang_key'  => $this->bidang_key,
		);
		$this->load->view('header');
		$this->load->view($this->view_name, $data);
		$this->load->view('footer-bidang');
	}
}
