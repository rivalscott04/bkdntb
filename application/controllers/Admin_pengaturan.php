<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_pengaturan extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Setting_model');
		$this->load->helper(array('url', 'form'));
	}

	public function index()
	{
		if (!$this->Setting_model->table_ready()) {
			$this->session->set_flashdata('error', 'Tabel pengaturan belum tersedia. Jalankan migrasi database terlebih dahulu.');
		}

		$this->render('admin/pengaturan_index', array(
			'title'           => 'Pengaturan',
			'active_menu'     => 'pengaturan',
			'sop_max_size_mb' => $this->Setting_model->table_ready()
				? $this->Setting_model->sop_max_size_mb()
				: 2,
		));
	}

	public function simpan()
	{
		$this->require_post();

		if (!$this->Setting_model->table_ready()) {
			$this->session->set_flashdata('error', 'Tabel pengaturan belum tersedia. Jalankan migrasi database terlebih dahulu.');
			redirect('admin/pengaturan');
		}

		$mb = (float) str_replace(',', '.', (string) $this->input->post('sop_max_size_mb', TRUE));
		if ($mb < 0.1 || $mb > 50) {
			$this->session->set_flashdata('error', 'Ukuran maksimal SOP harus antara 0,1 MB s.d. 50 MB.');
			redirect('admin/pengaturan');
		}

		$kb = (int) round($mb * 1024);
		if ($kb < 1) {
			$kb = Setting_model::SOP_MAX_SIZE_KB_DEFAULT;
		}

		if (!$this->Setting_model->set(Setting_model::SOP_MAX_SIZE_KB, $kb)) {
			$this->session->set_flashdata('error', 'Gagal menyimpan pengaturan.');
			redirect('admin/pengaturan');
		}

		$this->session->set_flashdata('success', 'Pengaturan berhasil disimpan.');
		redirect('admin/pengaturan');
	}
}
