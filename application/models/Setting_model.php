<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting_model extends CI_Model {

	const SOP_MAX_SIZE_KB = 'sop_max_size_kb';
	const SOP_MAX_SIZE_KB_DEFAULT = 2048;

	public function table_ready()
	{
		return $this->db->table_exists('cms_setting');
	}

	public function get($kunci, $default = null)
	{
		if (!$this->table_ready()) {
			return $default;
		}
		$this->db->reset_query();
		$row = $this->db->get_where('cms_setting', array('kunci' => $kunci))->row_array();
		if (!$row || !array_key_exists('nilai', $row) || $row['nilai'] === null) {
			return $default;
		}
		return $row['nilai'];
	}

	public function set($kunci, $nilai)
	{
		if (!$this->table_ready()) {
			return false;
		}
		$this->db->reset_query();
		$existing = $this->db->get_where('cms_setting', array('kunci' => $kunci))->row_array();
		if ($existing) {
			$this->db->reset_query();
			$this->db->where('kunci', $kunci);
			return $this->db->update('cms_setting', array('nilai' => (string) $nilai));
		}
		$this->db->reset_query();
		return $this->db->insert('cms_setting', array(
			'kunci' => $kunci,
			'nilai' => (string) $nilai,
		));
	}

	public function sop_max_size_kb()
	{
		$raw = $this->get(self::SOP_MAX_SIZE_KB, self::SOP_MAX_SIZE_KB_DEFAULT);
		$kb = (int) $raw;
		if ($kb < 1) {
			return self::SOP_MAX_SIZE_KB_DEFAULT;
		}
		return min($kb, 51200);
	}

	public function sop_max_size_mb()
	{
		return round($this->sop_max_size_kb() / 1024, 2);
	}
}
