<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengunjung_model extends CI_Model {

	const TABLE = 'pengunjung_online';
	const ONLINE_DETIK = 300;

	public function table_ready()
	{
		return $this->db->table_exists(self::TABLE);
	}

	public function sentuh($vid)
	{
		if (!$this->table_ready() || !preg_match('/\A[a-f0-9]{16}\z/', (string) $vid)) {
			return;
		}
		$now = time();
		$this->db->query(
			'INSERT INTO pengunjung_online (vid, terakhir) VALUES (?, ?)
			 ON DUPLICATE KEY UPDATE terakhir = VALUES(terakhir)',
			array($vid, $now)
		);
		$this->db->query(
			'DELETE FROM pengunjung_online WHERE terakhir < ?',
			array($now - self::ONLINE_DETIK)
		);
	}

	public function jumlah()
	{
		if (!$this->table_ready()) {
			return 0;
		}
		$row = $this->db->query(
			'SELECT COUNT(*) AS n FROM pengunjung_online WHERE terakhir >= ?',
			array(time() - self::ONLINE_DETIK)
		)->row_array();
		return (int) ($row['n'] ?? 0);
	}
}
