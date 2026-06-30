<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function login($username, $password)
	{
		$this->db->from('user');
		$this->db->where('username', $username);
		$query = $this->db->get();
		if ($query->num_rows() !== 1) {
			return false;
		}

		$user = $query->row_array();
		if (!$this->verify_password($password, $user['password'])) {
			return false;
		}

		if ($this->password_needs_upgrade($user['password'])) {
			$this->upgrade_password($user['id'], $password);
		}

		return $user;
	}

	public function user_exists($id)
	{
		$this->db->from('user');
		$this->db->where('id', (int) $id);
		return $this->db->count_all_results() > 0;
	}

	public function verify_password($password, $stored_hash)
	{
		if ($this->is_bcrypt_hash($stored_hash)) {
			return password_verify($password, $stored_hash);
		}

		return hash_equals($stored_hash, md5($password));
	}

	public function password_needs_upgrade($stored_hash)
	{
		if (!$this->is_bcrypt_hash($stored_hash)) {
			return true;
		}

		return password_needs_rehash($stored_hash, PASSWORD_DEFAULT);
	}

	public function upgrade_password($id, $password)
	{
		$this->db->where('id', (int) $id);
		return $this->db->update('user', array(
			'password' => password_hash($password, PASSWORD_DEFAULT),
		));
	}

	private function is_bcrypt_hash($hash)
	{
		return is_string($hash) && preg_match('/^\$2[aby]\$/', $hash);
	}
}
