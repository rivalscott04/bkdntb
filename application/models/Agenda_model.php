<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agenda_model extends CI_Model {

	const TABLE = 'agenda';

	public function table_ready()
	{
		return $this->db->table_exists(self::TABLE);
	}

	/**
	 * Agenda aktif mulai tanggal $dari (inklusif) s.d. sebelum $sampai (eksklusif, null = tanpa batas).
	 */
	public function get_range($dari, $sampai = null)
	{
		if (!$this->table_ready()) {
			return array();
		}
		$this->db->reset_query();
		$this->db->from(self::TABLE);
		$this->db->where('aktif', 1);
		$this->db->where('tanggal >=', $dari);
		if ($sampai !== null) {
			$this->db->where('tanggal <', $sampai);
		}
		$this->db->order_by('tanggal', 'ASC');
		$this->db->order_by('waktu_mulai IS NULL', '', FALSE);
		$this->db->order_by('waktu_mulai', 'ASC');
		$this->db->order_by('id', 'ASC');
		return $this->db->get()->result_array();
	}

	/**
	 * Tanggal Senin tiap minggu yang punya agenda aktif sebelum $senin_ini, terbaru dulu.
	 * Minggu tanpa agenda dilewati supaya tidak ada halaman kosong.
	 */
	public function past_week_mondays($senin_ini)
	{
		if (!$this->table_ready()) {
			return array();
		}
		$sql = 'SELECT DISTINCT DATE_SUB(tanggal, INTERVAL WEEKDAY(tanggal) DAY) AS senin
			FROM ' . self::TABLE . '
			WHERE aktif = 1 AND tanggal < ?
			ORDER BY senin DESC';
		return array_column($this->db->query($sql, array($senin_ini))->result_array(), 'senin');
	}

	public function count_all()
	{
		if (!$this->table_ready()) {
			return 0;
		}
		$this->db->reset_query();
		return $this->db->count_all(self::TABLE);
	}

	public function get_page($limit, $offset)
	{
		if (!$this->table_ready()) {
			return array();
		}
		$this->db->reset_query();
		$this->db->from(self::TABLE);
		$this->db->order_by('tanggal', 'DESC');
		$this->db->order_by('waktu_mulai', 'ASC');
		$this->db->order_by('id', 'DESC');
		$this->db->limit((int) $limit, (int) $offset);
		return $this->db->get()->result_array();
	}

	public function get_by_id($id)
	{
		$this->db->reset_query();
		return $this->db->get_where(self::TABLE, array('id' => (int) $id))->row_array();
	}

	public function insert($data)
	{
		$this->db->reset_query();
		return $this->db->insert(self::TABLE, $data);
	}

	public function update($id, $data)
	{
		$this->db->reset_query();
		$this->db->where('id', (int) $id);
		return $this->db->update(self::TABLE, $data);
	}

	public function delete($id)
	{
		$this->db->reset_query();
		$this->db->where('id', (int) $id);
		return $this->db->delete(self::TABLE);
	}
}
