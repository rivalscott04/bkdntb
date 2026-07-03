<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Hoaks extends CI_Controller {
	public function __construct(){
		parent:: __construct();
		

	}
	public function index()
	{
		$this->load->model('Bidang_model');
		$this->load->helper('berita');
		$bidang = $this->Bidang_model->get_by_kode('PPI');
		if (!$bidang) {
			$bidang = array('kode' => 'PPI', 'label' => 'PPI');
		}

		$this->load->view('header');
		$this->load->view('hoaks', array('bidang' => $bidang));
		$this->load->view('footer');
	}
}
