<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Pppk_cpns extends CI_Controller {
	public function __construct(){
		parent:: __construct();
		

	}
	public function index()
	{
		
		$this->load->view('header');
		$this->load->view('pppk_cpns');
		$this->load->view('footer');
	}
}
