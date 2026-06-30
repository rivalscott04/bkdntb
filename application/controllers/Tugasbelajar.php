<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Tugasbelajar extends CI_Controller {
	public function __construct(){
		parent:: __construct();
		

	}
	public function index()
	{
		
		$this->load->view('header');
		$this->load->view('tugasbelajar');
		$this->load->view('footer-bidang');
	}
}
