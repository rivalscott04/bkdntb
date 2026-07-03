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
		$filter = $this->_resolve_bidang_filter($bidang);
		$this->db->reset_query();
		$this->_select_list_columns();
		$this->db->from('berita');
		$this->_apply_resolved_bidang_filter($filter);
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
		$filter = $this->_resolve_bidang_filter($bidang);
		$this->db->reset_query();
		$this->db->from('berita');
		$this->_apply_resolved_bidang_filter($filter);
		$this->_apply_status_filter($status);
		return $this->db->count_all_results();
	}

	public function search_admin($filters = array(), $limit = 10, $offset = 0)
	{
		$bidang_filter = $this->_resolve_bidang_filter_from_filters($filters);
		$this->db->reset_query();
		$this->_select_list_columns();
		$this->db->from('berita');
		$this->_apply_admin_filters($filters, $bidang_filter);
		$this->db->order_by('tanggal', 'DESC');
		$this->db->limit($limit, $offset);
		return $this->db->get()->result_array();
	}

	public function count_search_admin($filters = array())
	{
		$bidang_filter = $this->_resolve_bidang_filter_from_filters($filters);
		$this->db->reset_query();
		$this->db->from('berita');
		$this->_apply_admin_filters($filters, $bidang_filter);
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
		$this->db->select('berita.id, berita.judul_berita, berita.slug, berita.penulis, berita.tanggal, berita.gambar_berita, berita.bidang, berita.status');
		if ($this->db->field_exists('bidang_id', 'berita')) {
			$this->db->select('berita.bidang_id');
		}
		$this->db->select('SUBSTRING(berita.isi_berita, 1, ' . $len . ') AS isi_berita', FALSE);
	}

	private function _apply_status_filter($status)
	{
		if ($status !== null) {
			$this->db->where('berita.status', $status);
		}
	}

	private function _resolve_bidang_filter_from_filters($filters)
	{
		if (empty($filters['bidang'])) {
			return null;
		}
		return $this->_resolve_bidang_filter($filters['bidang']);
	}

	private function _resolve_bidang_filter($bidang)
	{
		$this->load->helper('berita');
		$filter = array(
			'bidang_id'     => null,
			'match_values'  => array(),
		);

		$kode = resolve_bidang_kode($bidang);
		if ($kode === '') {
			return $filter;
		}

		$row = bidang_row($kode);
		if ($row) {
			if ($this->db->field_exists('bidang_id', 'berita')) {
				$filter['bidang_id'] = (int) $row['id'];
			}
			$filter['match_values'] = $this->_bidang_match_values_from_row($row);
			return $filter;
		}

		$filter['match_values'] = array($kode);
		return $filter;
	}

	private function _bidang_match_values_from_row(array $row)
	{
		$values = array($row['kode']);
		if (!empty($row['label']) && !in_array($row['label'], $values, TRUE)) {
			$values[] = $row['label'];
		}
		$this->load->model('Bidang_model');
		foreach (Bidang_model::parse_aliases($row['aliases'] ?? '') as $alias) {
			if (!in_array($alias, $values, TRUE)) {
				$values[] = $alias;
			}
		}
		return $values;
	}

	private function _apply_resolved_bidang_filter(array $filter)
	{
		if (!empty($filter['bidang_id'])) {
			$this->db->where('berita.bidang_id', $filter['bidang_id']);
			return;
		}
		if (!empty($filter['match_values'])) {
			$this->db->where_in('berita.bidang', $filter['match_values']);
		}
	}

	public function prepare_bidang_data($kode)
	{
		$kode = trim($kode);
		$data = array('bidang' => $kode);
		if ($kode === '') {
			return $data;
		}

		$this->load->model('Bidang_model');
		$row = $this->Bidang_model->get_by_kode($kode);
		if (!$row) {
			$resolved = $this->Bidang_model->resolve_kode($kode);
			$row = $resolved !== '' ? $this->Bidang_model->get_by_kode($resolved) : null;
		}
		if ($row) {
			$data['bidang'] = $row['kode'];
			if ($this->db->field_exists('bidang_id', 'berita')) {
				$data['bidang_id'] = (int) $row['id'];
			}
		}
		return $data;
	}

	public function sync_bidang_kode($bidang_id, $kode)
	{
		if (!$this->db->field_exists('bidang_id', 'berita')) {
			return FALSE;
		}
		$this->db->where('bidang_id', (int) $bidang_id);
		return $this->db->update('berita', array('bidang' => $kode));
	}

	public function relink_bidang_berita($bidang_id, array $match_values, $kode)
	{
		if (!$this->db->field_exists('bidang_id', 'berita')) {
			return FALSE;
		}
		$match_values = array_values(array_filter(array_unique($match_values), function ($value) {
			return trim($value) !== '';
		}));
		if (empty($match_values)) {
			return FALSE;
		}
		$this->db->where_in('bidang', $match_values);
		return $this->db->update('berita', array(
			'bidang_id' => (int) $bidang_id,
			'bidang'    => $kode,
		));
	}

	private function _apply_admin_filters($filters, $bidang_filter = null)
	{
		$q = trim($filters['q'] ?? '');
		if ($q !== '') {
			$this->db->group_start();
			$this->db->like('judul_berita', $q);
			$this->db->or_like('penulis', $q);
			$this->db->group_end();
		}
		if ($bidang_filter !== null) {
			$this->_apply_resolved_bidang_filter($bidang_filter);
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
