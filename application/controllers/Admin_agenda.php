<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_agenda extends Admin_Controller {

	private $per_page = 20;
	private $surat_max_kb = 5120;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Agenda_model');
		$this->load->helper(array('url', 'form', 'berita'));
		$this->load->library(array('pagination', 'upload'));
	}

	public function index()
	{
		if (!$this->Agenda_model->table_ready()) {
			$this->session->set_flashdata('error', 'Tabel agenda belum tersedia. Jalankan migrasi database terlebih dahulu.');
		}

		$total = $this->Agenda_model->count_all();
		$page = max(1, (int) $this->input->get('page'));
		$pagination = '';
		if ($total > $this->per_page) {
			$this->pagination->initialize(array(
				'base_url'             => site_url('admin/agenda'),
				'total_rows'           => $total,
				'per_page'             => $this->per_page,
				'use_page_numbers'     => TRUE,
				'page_query_string'    => TRUE,
				'query_string_segment' => 'page',
				'full_tag_open'        => '<ul class="pagination justify-content-center">',
				'full_tag_close'       => '</ul>',
				'num_tag_open'         => '<li class="page-item">',
				'num_tag_close'        => '</li>',
				'cur_tag_open'         => '<li class="page-item active"><span class="page-link">',
				'cur_tag_close'        => '</span></li>',
				'next_tag_open'        => '<li class="page-item">',
				'next_tag_close'       => '</li>',
				'prev_tag_open'        => '<li class="page-item">',
				'prev_tag_close'       => '</li>',
				'first_tag_open'       => '<li class="page-item">',
				'first_tag_close'      => '</li>',
				'last_tag_open'        => '<li class="page-item">',
				'last_tag_close'       => '</li>',
				'attributes'           => array('class' => 'page-link'),
			));
			$pagination = $this->pagination->create_links();
		}

		$this->render('admin/agenda_index', array(
			'title'       => 'Agenda Kepala Badan',
			'active_menu' => 'agenda',
			'agenda_list' => $this->Agenda_model->get_page($this->per_page, ($page - 1) * $this->per_page),
			'pagination'  => $pagination,
		));
	}

	public function tambah()
	{
		$this->render('admin/agenda_form', array(
			'title'       => 'Tambah Agenda',
			'active_menu' => 'agenda',
		));
	}

	public function edit($id)
	{
		$agenda = $this->Agenda_model->get_by_id($id);
		if (!$agenda) {
			show_404();
		}
		$this->render('admin/agenda_form', array(
			'title'       => 'Edit Agenda',
			'active_menu' => 'agenda',
			'agenda'      => $agenda,
		));
	}

	public function simpan()
	{
		$this->require_post();

		$id = (int) $this->input->post('id');
		$tanggal = trim((string) $this->input->post('tanggal', TRUE));
		$mulai = trim((string) $this->input->post('waktu_mulai', TRUE));
		$selesai = trim((string) $this->input->post('waktu_selesai', TRUE));
		$kegiatan = trim((string) $this->input->post('kegiatan', TRUE));
		$asal_surat = trim((string) $this->input->post('asal_surat', TRUE));
		$tempat = trim((string) $this->input->post('tempat', TRUE));
		$keterangan = trim((string) $this->input->post('keterangan', TRUE));
		$redirect_form = $id ? 'admin/agenda/edit/' . $id : 'admin/agenda/tambah';

		if ($kegiatan === '' || !$this->_valid_date($tanggal)) {
			$this->session->set_flashdata('error', 'Tanggal dan agenda kegiatan wajib diisi.');
			redirect($redirect_form);
		}
		if (mb_strlen($kegiatan) > 500 || mb_strlen($tempat) > 255 || mb_strlen($asal_surat) > 255 || mb_strlen($keterangan) > 500) {
			$this->session->set_flashdata('error', 'Agenda dan keterangan maksimal 500 karakter. Asal surat dan tempat maksimal 255 karakter.');
			redirect($redirect_form);
		}
		if (($mulai !== '' && !$this->_valid_time($mulai)) || ($selesai !== '' && !$this->_valid_time($selesai))) {
			$this->session->set_flashdata('error', 'Format waktu tidak valid.');
			redirect($redirect_form);
		}
		$mulai = substr($mulai, 0, 5);
		$selesai = substr($selesai, 0, 5);
		if ($selesai !== '' && ($mulai === '' || $selesai <= $mulai)) {
			$this->session->set_flashdata('error', 'Waktu selesai harus diisi bersama waktu mulai dan lebih akhir dari waktu mulai.');
			redirect($redirect_form);
		}

		$existing = null;
		if ($id) {
			$existing = $this->Agenda_model->get_by_id($id);
			if (!$existing) {
				show_404();
			}
		}

		$ada_kolom_surat = $this->db->field_exists('surat_file', 'agenda');
		$surat_baru = null;
		if (!empty($_FILES['surat_file']['name'])) {
			if (!$ada_kolom_surat) {
				$this->session->set_flashdata('error', 'Kolom surat belum ada. Jalankan migrasi database terlebih dahulu.');
				redirect($redirect_form);
			}
			$surat_baru = $this->_upload_surat();
			if ($surat_baru === false) {
				redirect($redirect_form);
			}
		}

		$data = array(
			'tanggal'       => $tanggal,
			'waktu_mulai'   => $mulai !== '' ? $mulai : null,
			'waktu_selesai' => $selesai !== '' ? $selesai : null,
			'kegiatan'      => $kegiatan,
			'asal_surat'    => $asal_surat !== '' ? $asal_surat : null,
			'tempat'        => $tempat !== '' ? $tempat : null,
			'keterangan'    => $keterangan !== '' ? $keterangan : null,
			'aktif'         => $this->input->post('aktif') ? 1 : 0,
		);

		$surat_lama = $existing['surat_file'] ?? null;
		if ($surat_baru !== null) {
			$data['surat_file'] = $surat_baru;
		} elseif ($ada_kolom_surat && $this->input->post('hapus_surat')) {
			$data['surat_file'] = null;
		}

		if ($id) {
			$this->Agenda_model->update($id, $data);
			if ($surat_lama && array_key_exists('surat_file', $data)) {
				$this->_hapus_file_surat($surat_lama);
			}
			$this->session->set_flashdata('success', 'Agenda berhasil diperbarui.');
		} else {
			$this->Agenda_model->insert($data);
			$this->session->set_flashdata('success', 'Agenda berhasil ditambahkan.');
		}

		redirect('admin/agenda');
	}

	public function hapus()
	{
		$this->require_post();

		$agenda = $this->Agenda_model->get_by_id((int) $this->input->post('id'));
		if (!$agenda || !$this->Agenda_model->delete($agenda['id'])) {
			$this->session->set_flashdata('error', 'Gagal menghapus agenda.');
			redirect('admin/agenda');
		}
		$this->_hapus_file_surat($agenda['surat_file'] ?? null);

		$this->session->set_flashdata('success', 'Agenda berhasil dihapus.');
		redirect('admin/agenda');
	}

	/** Nama file tersimpan, atau false bila gagal (pesan error sudah di flashdata). */
	private function _upload_surat()
	{
		$path = FCPATH . agenda_surat_relpath();
		if (!is_dir($path)) {
			mkdir($path, 0755, TRUE);
		}
		$this->upload->initialize(array(
			'upload_path'      => $path,
			'allowed_types'    => 'jpg|jpeg|png|pdf',
			'max_size'         => $this->surat_max_kb,
			'encrypt_name'     => TRUE,
			'file_ext_tolower' => TRUE,
		));
		if (!$this->upload->do_upload('surat_file')) {
			$this->session->set_flashdata('error', 'Upload surat gagal: ' . strip_tags($this->upload->display_errors('', '')));
			return false;
		}
		return $this->upload->data('file_name');
	}

	private function _hapus_file_surat($filename)
	{
		if (!$filename) {
			return;
		}
		$full = FCPATH . agenda_surat_relpath($filename);
		if (is_file($full)) {
			@unlink($full);
		}
	}

	private function _valid_date($value)
	{
		$d = DateTime::createFromFormat('Y-m-d', $value);
		return $d && $d->format('Y-m-d') === $value;
	}

	private function _valid_time($value)
	{
		return (bool) preg_match('/^([01]\d|2[0-3]):[0-5]\d(:[0-5]\d)?$/', $value);
	}
}
