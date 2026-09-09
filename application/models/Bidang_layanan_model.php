<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bidang_layanan_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function table_ready()
	{
		return $this->db->table_exists('bidang_layanan');
	}

	public function get_by_bidang_id($bidang_id, $active_only = FALSE)
	{
		if (!$this->table_ready()) {
			return array();
		}
		$this->db->reset_query();
		$this->db->from('bidang_layanan');
		$this->db->where('bidang_id', (int) $bidang_id);
		if ($active_only) {
			$this->db->where('aktif', 1);
		}
		$this->db->order_by('urutan', 'ASC');
		$this->db->order_by('id', 'ASC');
		return $this->db->get()->result_array();
	}

	public function get_by_id($id)
	{
		if (!$this->table_ready()) {
			return null;
		}
		$this->db->reset_query();
		return $this->db->get_where('bidang_layanan', array('id' => (int) $id))->row_array();
	}

	public function get_by_page_url($page)
	{
		if (!$this->table_ready()) {
			return null;
		}
		$page = trim((string) $page, " \t\n\r\0\x0B/");
		if ($page === '') {
			return null;
		}

		$candidates = array(
			$page,
			'/' . $page,
			site_url($page),
		);

		$this->db->reset_query();
		$this->db->from('bidang_layanan');
		$this->db->where('aktif', 1);
		$this->db->group_start();
		foreach ($candidates as $i => $candidate) {
			if ($i === 0) {
				$this->db->where('url', $candidate);
			} else {
				$this->db->or_where('url', $candidate);
			}
		}
		$this->db->group_end();
		$this->db->order_by('urutan', 'ASC');
		$this->db->order_by('id', 'ASC');
		$this->db->limit(1);
		$row = $this->db->get()->row_array();
		return $row ?: null;
	}

	public function insert($data)
	{
		if (!$this->table_ready()) {
			return false;
		}
		$this->db->reset_query();
		$this->db->insert('bidang_layanan', $data);
		return $this->db->insert_id();
	}

	public function update($id, $data)
	{
		if (!$this->table_ready()) {
			return false;
		}
		$this->db->reset_query();
		$this->db->where('id', (int) $id);
		return $this->db->update('bidang_layanan', $data);
	}

	public function delete($id)
	{
		if (!$this->table_ready()) {
			return false;
		}
		$this->db->reset_query();
		$this->db->where('id', (int) $id);
		return $this->db->delete('bidang_layanan');
	}

	public function delete_by_bidang_id($bidang_id)
	{
		if (!$this->table_ready()) {
			return false;
		}
		$this->db->reset_query();
		$this->db->where('bidang_id', (int) $bidang_id);
		return $this->db->delete('bidang_layanan');
	}

	public function count_by_bidang_id($bidang_id)
	{
		if (!$this->table_ready()) {
			return 0;
		}
		$this->db->reset_query();
		$this->db->from('bidang_layanan');
		$this->db->where('bidang_id', (int) $bidang_id);
		return $this->db->count_all_results();
	}
}
