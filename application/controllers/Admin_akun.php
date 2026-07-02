<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_akun extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form'));
	}

	public function index()
	{
		$user = $this->Auth_model->get_by_id($this->session->userdata('admin_id'));
		if (!$user) {
			show_404();
		}

		$this->render('admin/akun_index', array(
			'title'       => 'Ubah Akun',
			'active_menu' => 'akun',
			'user'        => $user,
		));
	}

	public function simpan()
	{
		$this->require_post();

		$id = (int) $this->session->userdata('admin_id');
		$user = $this->Auth_model->get_by_id($id);
		if (!$user) {
			show_404();
		}

		$password_lama = $this->input->post('password_lama');
		$username = trim($this->input->post('username', TRUE));
		$nama = trim($this->input->post('nama', TRUE));
		$password_baru = $this->input->post('password_baru');
		$password_konfirmasi = $this->input->post('password_konfirmasi');

		if (!$this->Auth_model->verify_password($password_lama, $user['password'])) {
			$this->session->set_flashdata('error', 'Password lama tidak sesuai.');
			redirect('admin/akun');
		}

		if ($username === '' || $nama === '') {
			$this->session->set_flashdata('error', 'Username dan nama wajib diisi.');
			redirect('admin/akun');
		}
		if (mb_strlen($username) > 50 || mb_strlen($nama) > 100) {
			$this->session->set_flashdata('error', 'Username maksimal 50 karakter, nama maksimal 100 karakter.');
			redirect('admin/akun');
		}
		if (!preg_match('/^[a-zA-Z0-9._-]+$/', $username)) {
			$this->session->set_flashdata('error', 'Username hanya boleh huruf, angka, titik, strip, dan underscore.');
			redirect('admin/akun');
		}
		if ($this->Auth_model->username_exists($username, $id)) {
			$this->session->set_flashdata('error', 'Username sudah dipakai akun lain.');
			redirect('admin/akun');
		}

		$data = array(
			'username' => $username,
			'nama'     => $nama,
		);

		$ubah_password = trim($password_baru) !== '';
		if ($ubah_password) {
			$password_error = $this->Auth_model->validate_password_strength($password_baru);
			if ($password_error !== null) {
				$this->session->set_flashdata('error', $password_error);
				redirect('admin/akun');
			}
			if ($password_baru !== $password_konfirmasi) {
				$this->session->set_flashdata('error', 'Konfirmasi password baru tidak sama.');
				redirect('admin/akun');
			}
			$data['password'] = password_hash($password_baru, PASSWORD_DEFAULT);
		}

		if (!$this->Auth_model->update_account($id, $data)) {
			$this->session->set_flashdata('error', 'Gagal menyimpan perubahan akun.');
			redirect('admin/akun');
		}

		$this->session->set_userdata(array(
			'admin_username' => $username,
			'admin_nama'     => $nama,
		));

		$message = $ubah_password
			? 'Akun dan password berhasil diperbarui.'
			: 'Data akun berhasil diperbarui.';
		$this->session->set_flashdata('success', $message);
		redirect('admin/akun');
	}
}
