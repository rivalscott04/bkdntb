<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model('Auth_model');
		$this->load->helper(array('url', 'form'));
	}

	public function index()
	{
		if ($this->session->userdata('admin_logged_in')) {
			redirect('admin/berita');
		}
		$this->load->view('admin/shell_head', array('page_title' => 'Login Admin'));
		$this->load->view('admin/login');
		$this->load->view('admin/shell_footer');
	}

	public function authenticate()
	{
		$this->require_post();

		$username = $this->input->post('username', TRUE);
		$password = $this->input->post('password');

		if (empty($username) || empty($password)) {
			$this->session->set_flashdata('error', 'Username dan password wajib diisi.');
			redirect('admin/login');
		}

		$user = $this->Auth_model->login($username, $password);
		if ($user) {
			$this->session->sess_regenerate(TRUE);
			$this->session->set_userdata(array(
				'admin_logged_in' => TRUE,
				'admin_id'        => $user['id'],
				'admin_nama'      => $user['nama'],
				'admin_username'  => $user['username'],
			));
			redirect('admin/berita');
		}

		$this->session->set_flashdata('error', 'Username atau password salah.');
		redirect('admin/login');
	}

	public function logout()
	{
		$this->require_post();

		$this->session->unset_userdata(array(
			'admin_logged_in',
			'admin_id',
			'admin_nama',
			'admin_username',
		));
		$this->session->sess_destroy();
		redirect('admin/login');
	}

	private function require_post()
	{
		if ($this->input->method(TRUE) !== 'POST') {
			show_error('Method Not Allowed', 405);
		}
	}
}
