<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bidang_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function get_all($include_inactive = TRUE)
	{
		$this->db->reset_query();
		$this->db->select('bidang.*');
		$this->db->from('bidang');
		if (!$include_inactive) {
			$this->db->where('bidang.aktif', 1);
		}
		$this->db->order_by('bidang.urutan', 'ASC');
		$this->db->order_by('bidang.label', 'ASC');
		return $this->db->get()->result_array();
	}

	public function get_list_map($active_only = FALSE)
	{
		$rows = $this->get_all(!$active_only);
		$map = array();
		foreach ($rows as $row) {
			$map[$row['kode']] = array(
				'label'   => $row['label'],
				'url'     => $row['url_slug'],
				'aktif'   => (int) $row['aktif'],
				'aliases' => self::parse_aliases($row['aliases'] ?? ''),
			);
		}
		return $map;
	}

	public static function parse_aliases($raw)
	{
		if ($raw === null || trim($raw) === '') {
			return array();
		}
		$parts = preg_split('/\s*,\s*/', trim($raw));
		$aliases = array();
		foreach ($parts as $part) {
			$part = trim($part);
			if ($part !== '') {
				$aliases[] = $part;
			}
		}
		return $aliases;
	}

	public function get_by_url_slug($url_slug)
	{
		$this->db->reset_query();
		return $this->db->get_where('bidang', array('url_slug' => $url_slug))->row_array();
	}

	public function resolve_kode($value)
	{
		$value = trim($value);
		if ($value === '') {
			return '';
		}
		if ($this->get_by_kode($value)) {
			return $value;
		}
		foreach ($this->get_all() as $row) {
			if (in_array($value, self::parse_aliases($row['aliases'] ?? ''), TRUE)) {
				return $row['kode'];
			}
		}
		return $value;
	}

	public function get_match_values($kode)
	{
		$row = $this->get_by_kode($kode);
		if (!$row) {
			return array($kode);
		}
		$values = array($row['kode']);
		foreach (self::parse_aliases($row['aliases'] ?? '') as $alias) {
			if (!in_array($alias, $values, TRUE)) {
				$values[] = $alias;
			}
		}
		return $values;
	}

	public function get_by_id($id)
	{
		$this->db->reset_query();
		return $this->db->get_where('bidang', array('id' => (int) $id))->row_array();
	}

	public function get_by_kode($kode)
	{
		$this->db->reset_query();
		return $this->db->get_where('bidang', array('kode' => $kode))->row_array();
	}

	public function kode_exists($kode, $exclude_id = null)
	{
		$this->db->reset_query();
		$this->db->from('bidang');
		$this->db->where('kode', $kode);
		if ($exclude_id !== null) {
			$this->db->where('id !=', (int) $exclude_id);
		}
		return $this->db->count_all_results() > 0;
	}

	public function url_slug_exists($url_slug, $exclude_id = null)
	{
		$this->db->reset_query();
		$this->db->from('bidang');
		$this->db->where('url_slug', $url_slug);
		if ($exclude_id !== null) {
			$this->db->where('id !=', (int) $exclude_id);
		}
		return $this->db->count_all_results() > 0;
	}

	public function count_berita($kode)
	{
		$values = $this->get_match_values($kode);
		$this->db->reset_query();
		$this->db->from('berita');
		$this->db->where_in('bidang', $values);
		return $this->db->count_all_results();
	}

	public function insert($data)
	{
		$this->db->reset_query();
		$this->db->insert('bidang', $data);
		return $this->db->insert_id();
	}

	public function update($id, $data)
	{
		$this->db->reset_query();
		$this->db->where('id', (int) $id);
		return $this->db->update('bidang', $data);
	}

	public function delete($id)
	{
		$row = $this->get_by_id($id);
		if (!$row) {
			return false;
		}
		if ($this->count_berita($row['kode']) > 0) {
			return false;
		}
		$this->db->reset_query();
		$this->db->where('id', (int) $id);
		return $this->db->delete('bidang');
	}
}
