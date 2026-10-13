<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_agenda extends Admin_Controller {

	private $per_page = 20;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Agenda_model');
		$this->load->helper(array('url', 'form', 'berita'));
		$this->load->library('pagination');
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

		if ($id) {
			if (!$this->Agenda_model->get_by_id($id)) {
				show_404();
			}
			$this->Agenda_model->update($id, $data);
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

		if (!$this->Agenda_model->delete((int) $this->input->post('id'))) {
			$this->session->set_flashdata('error', 'Gagal menghapus agenda.');
			redirect('admin/agenda');
		}

		$this->session->set_flashdata('success', 'Agenda berhasil dihapus.');
		redirect('admin/agenda');
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
