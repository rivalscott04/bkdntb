<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Info extends CI_Controller {
	public function __construct(){
		parent:: __construct();
		$this->load->model('BerandaModel');

	}
	public function index()
	{
		$data["data_news"] = $this->BerandaModel->ambildataberita();
		$data["data_visi"] = null;
		$data["data_misi"] = null;
		$data["data_sejarah"] = null;
		$data["data_kata"] = null;
		$this->load->view('header');
		$this->load->view('infodgg',$data);
		$this->load->view('footer');
	}
}
