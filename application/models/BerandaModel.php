<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class BerandaModel extends CI_Model {
	public function __construct(){
		parent:: __construct();

	}
	public function ambildataberita()
	{
		$this->db->select('*');
		$this->db->from('berita');
		$this->db->order_by("id",'desc');
		$this->db->limit(4);
		$data = $this->db->get()->result_array();
		return $data;
	}
}
