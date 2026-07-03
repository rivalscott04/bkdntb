<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Berita_model extends CI_Model {

	private static $list_excerpt_length = 500;

	public function __construct()
	{
		parent::__construct();
	}

	public function get_all($limit = null, $offset = 0, $status = 'published')
	{
		$this->db->reset_query();
		$this->_select_list_columns();
		$this->db->from('berita');
		$this->_apply_status_filter($status);
		$this->db->order_by('tanggal', 'DESC');
		if ($limit !== null) {
			$this->db->limit($limit, $offset);
		}
		return $this->db->get()->result_array();
	}

	public function get_by_bidang($bidang, $limit = null, $offset = 0, $status = 'published')
	{
		$this->load->helper('berita');
		$match_values = bidang_match_values($bidang);
		$this->db->reset_query();
		$this->_select_list_columns();
		$this->db->from('berita');
		$this->db->where_in('bidang', $match_values);
		$this->_apply_status_filter($status);
		$this->db->order_by('tanggal', 'DESC');
		if ($limit !== null) {
			$this->db->limit($limit, $offset);
		}
		return $this->db->get()->result_array();
	}

	public function get_by_id($id)
	{
		$this->db->reset_query();
		return $this->db->get_where('berita', array('id' => $id))->row_array();
	}

	public function get_by_slug($slug, $status = 'published')
	{
		$this->db->reset_query();
		$this->db->from('berita');
		$this->db->where('slug', $slug);
		$this->_apply_status_filter($status);
		return $this->db->get()->row_array();
	}

	public function count_all($status = 'published')
	{
		$this->db->reset_query();
		$this->db->from('berita');
		$this->_apply_status_filter($status);
		return $this->db->count_all_results();
	}

	public function count_by_bidang($bidang, $status = 'published')
	{
		$this->load->helper('berita');
		$match_values = bidang_match_values($bidang);
		$this->db->reset_query();
		$this->db->from('berita');
		$this->db->where_in('bidang', $match_values);
		$this->_apply_status_filter($status);
		return $this->db->count_all_results();
	}

	public function search_admin($filters = array(), $limit = 10, $offset = 0)
	{
		$bidang_values = $this->_resolve_bidang_filter_values($filters);
		$this->db->reset_query();
		$this->_select_list_columns();
		$this->db->from('berita');
		$this->_apply_admin_filters($filters, $bidang_values);
		$this->db->order_by('tanggal', 'DESC');
		$this->db->limit($limit, $offset);
		return $this->db->get()->result_array();
	}

	public function count_search_admin($filters = array())
	{
		$bidang_values = $this->_resolve_bidang_filter_values($filters);
		$this->db->reset_query();
		$this->db->from('berita');
		$this->_apply_admin_filters($filters, $bidang_values);
		return $this->db->count_all_results();
	}

	public function slug_exists($slug, $exclude_id = null)
	{
		$this->db->reset_query();
		$this->db->from('berita');
		$this->db->where('slug', $slug);
		if ($exclude_id !== null) {
			$this->db->where('id !=', (int) $exclude_id);
		}
		return $this->db->count_all_results() > 0;
	}

	public function get_conflicting_slugs($base_slug, $exclude_id = null)
	{
		$this->db->reset_query();
		$this->db->select('slug');
		$this->db->from('berita');
		$this->db->group_start();
		$this->db->where('slug', $base_slug);
		$this->db->or_like('slug', $base_slug . '-', 'after');
		$this->db->group_end();
		if ($exclude_id !== null) {
			$this->db->where('id !=', (int) $exclude_id);
		}
		$rows = $this->db->get()->result_array();
		return array_column($rows, 'slug');
	}

	public function generate_unique_slug($judul, $exclude_id = null)
	{
		$this->load->helper('berita');
		$base = buat_slug($judul);
		$existing = $this->get_conflicting_slugs($base, $exclude_id);
		if (empty($existing)) {
			return $base;
		}

		$has_base = in_array($base, $existing, TRUE);
		$max_suffix = 0;
		$prefix = $base . '-';
		foreach ($existing as $slug) {
			if (strpos($slug, $prefix) !== 0) {
				continue;
			}
			$suffix = substr($slug, strlen($prefix));
			if (ctype_digit($suffix)) {
				$max_suffix = max($max_suffix, (int) $suffix);
			}
		}

		if (!$has_base) {
			return $base;
		}

		return $base . '-' . ($max_suffix + 1);
	}

	private function _select_list_columns()
	{
		$len = (int) self::$list_excerpt_length;
		$this->db->select('id, judul_berita, slug, penulis, tanggal, gambar_berita, bidang, status');
		$this->db->select('SUBSTRING(isi_berita, 1, ' . $len . ') AS isi_berita', FALSE);
	}

	private function _apply_status_filter($status)
	{
		if ($status !== null) {
			$this->db->where('status', $status);
		}
	}

	private function _resolve_bidang_filter_values($filters)
	{
		if (empty($filters['bidang'])) {
			return null;
		}
		$this->load->helper('berita');
		return bidang_match_values($filters['bidang']);
	}

	private function _apply_admin_filters($filters, $bidang_values = null)
	{
		$q = trim($filters['q'] ?? '');
		if ($q !== '') {
			$this->db->group_start();
			$this->db->like('judul_berita', $q);
			$this->db->or_like('penulis', $q);
			$this->db->group_end();
		}
		if ($bidang_values !== null) {
			$this->db->where_in('bidang', $bidang_values);
		}
		if (!empty($filters['status']) && in_array($filters['status'], array('published', 'draft'), TRUE)) {
			$this->db->where('status', $filters['status']);
		}
		if (!empty($filters['tanggal_dari'])) {
			$this->db->where('tanggal >=', $filters['tanggal_dari'] . ' 00:00:00');
		}
		if (!empty($filters['tanggal_sampai'])) {
			$this->db->where('tanggal <=', $filters['tanggal_sampai'] . ' 23:59:59');
		}
	}

	public function insert($data)
	{
		$this->db->insert('berita', $data);
		return $this->db->insert_id();
	}

	public function update($id, $data)
	{
		$this->db->where('id', $id);
		return $this->db->update('berita', $data);
	}

	public function delete($id)
	{
		$row = $this->get_by_id($id);
		if (!$row) {
			return false;
		}
		$this->db->where('id', $id);
		$deleted = $this->db->delete('berita');
		if ($deleted && !empty($row['gambar_berita'])) {
			$path = fcpath_gambar_berita($row['gambar_berita']);
			if (is_file($path)) {
				@unlink($path);
			}
		}
		return $deleted;
	}
}
