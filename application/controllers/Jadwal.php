<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Jadwal extends CI_Controller {
	public function __construct(){
		parent:: __construct();
		

	}
	public function index()
	{
		
		$this->load->view('header');
		$this->load->view('jadwal');
		$this->load->view('footer');
	}
}
