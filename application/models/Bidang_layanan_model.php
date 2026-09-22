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

	/**
	 * Layanan aktif yang punya file SOP (untuk sidebar / daftar unduhan).
	 *
	 * @param int      $bidang_id
	 * @param int|null $limit
	 * @return array
	 */
	public function get_sop_by_bidang_id($bidang_id, $limit = null)
	{
		if (!$this->table_ready()) {
			return array();
		}
		$this->db->reset_query();
		$this->db->from('bidang_layanan');
		$this->db->where('bidang_id', (int) $bidang_id);
		$this->db->where('aktif', 1);
		$this->db->where('sop_file IS NOT NULL', null, FALSE);
		$this->db->where("sop_file !=", '');
		$this->db->order_by('urutan', 'ASC');
		$this->db->order_by('id', 'ASC');
		if ($limit !== null && (int) $limit > 0) {
			$this->db->limit((int) $limit);
		}
		return $this->db->get()->result_array();
	}

	public function count_sop_by_bidang_id($bidang_id)
	{
		if (!$this->table_ready()) {
			return 0;
		}
		$this->db->reset_query();
		$this->db->from('bidang_layanan');
		$this->db->where('bidang_id', (int) $bidang_id);
		$this->db->where('aktif', 1);
		$this->db->where('sop_file IS NOT NULL', null, FALSE);
		$this->db->where("sop_file !=", '');
		return (int) $this->db->count_all_results();
	}

	/**
	 * SOP aktif dikelompokkan per bidang (untuk halaman tab).
	 *
	 * @return array[] tiap elemen: bidang (row), items (list SOP)
	 */
	public function get_sop_grouped_by_bidang($include_bidang_id = null)
	{
		$CI =& get_instance();
		$CI->load->model('Bidang_model');
		$bidang_rows = $CI->Bidang_model->get_all(FALSE);
		$groups = array();
		$include_bidang_id = $include_bidang_id !== null ? (int) $include_bidang_id : null;
		$seen = array();

		foreach ($bidang_rows as $row) {
			$bidang_id = (int) $row['id'];
			$items = $this->get_sop_by_bidang_id($bidang_id);
			if (empty($items) && $include_bidang_id !== $bidang_id) {
				continue;
			}
			$groups[] = array(
				'bidang' => $row,
				'items'  => $items,
			);
			$seen[$bidang_id] = TRUE;
		}

		if ($include_bidang_id && empty($seen[$include_bidang_id])) {
			$extra = $CI->Bidang_model->get_by_id($include_bidang_id);
			if ($extra) {
				$groups[] = array(
					'bidang' => $extra,
					'items'  => $this->get_sop_by_bidang_id($include_bidang_id),
				);
			}
		}

		return $groups;
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
