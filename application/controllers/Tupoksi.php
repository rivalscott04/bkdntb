<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Tupoksi extends CI_Controller {
	public function __construct(){
		parent:: __construct();
		

	}
	public function index()
	{
		
		$this->load->view('header');
		$this->load->view('tupoksi');
		$this->load->view('footer');
	}
}
