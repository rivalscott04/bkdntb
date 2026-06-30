<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('Berita_model');
		$this->load->helper('berita');
	}

	public function index()
	{
		$data = array(
			'berita_list' => $this->Berita_model->get_all(6, 0, 'published'),
		);
		$this->load->view('header');
		$this->load->view('home', $data);
		$this->load->view('footer');
	}
}
