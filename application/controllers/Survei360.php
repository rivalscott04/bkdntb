<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Survei360 extends CI_Controller {
	public function __construct(){
		parent:: __construct();
		

	}
	public function index()
	{
		
		$this->load->view('header');
		$this->load->view('survei360');
		$this->load->view('footer-bidang');
	}
}
