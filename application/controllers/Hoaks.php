<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Hoaks extends CI_Controller {
	public function __construct(){
		parent:: __construct();
		

	}
	public function index()
	{
		
		$this->load->view('header');
		$this->load->view('hoaks');
		$this->load->view('footer');
	}
}
