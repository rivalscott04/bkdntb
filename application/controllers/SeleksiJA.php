<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Seleksija extends CI_Controller {
	public function __construct(){
		parent:: __construct();
		

	}
	public function index()
	{
		
		$this->load->view('header');
		$this->load->view('seleksija');
		$this->load->view('footer');
	}
}
