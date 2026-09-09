<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_bidang extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('Bidang_model', 'Bidang_layanan_model', 'Setting_model'));
		$this->load->helper(array('url', 'form', 'berita'));
		$this->load->library('upload');
	}

	public function index()
	{
		$this->render('admin/bidang_index', array(
			'title'       => 'Kelola Bidang',
			'active_menu' => 'bidang',
			'bidang_list' => $this->Bidang_model->get_all(),
		));
	}

	public function tambah()
	{
		$this->render('admin/bidang_form', array(
			'title'       => 'Tambah Bidang',
			'active_menu' => 'bidang',
		));
	}

	public function edit($id)
	{
		$bidang = $this->Bidang_model->get_by_id($id);
		if (!$bidang) {
			show_404();
		}
		$this->render('admin/bidang_form', array(
			'title'       => 'Edit Bidang',
			'active_menu' => 'bidang',
			'bidang'      => $bidang,
			'berita_count' => $this->Bidang_model->count_berita($bidang['kode']),
		));
	}

	public function simpan()
	{
		$this->require_post();

		$id = (int) $this->input->post('id');
		$kode = trim($this->input->post('kode', TRUE));
		$label = trim($this->input->post('label', TRUE));
		$url_slug = strtolower(trim($this->input->post('url_slug', TRUE)));
		$aliases = trim($this->input->post('aliases', TRUE));
		$judul_halaman = trim($this->input->post('judul_halaman', TRUE));
		$subjudul = trim($this->input->post('subjudul', TRUE));
		$kepala_judul = trim($this->input->post('kepala_judul', TRUE));
		$kepala_nama = trim($this->input->post('kepala_nama', TRUE));
		$kepala_nip = trim($this->input->post('kepala_nip', TRUE));
		$kepala_foto = trim($this->input->post('kepala_foto', TRUE));
		$layanan_judul = trim($this->input->post('layanan_judul', TRUE));
		$ringkasan_tugas_judul = trim($this->input->post('ringkasan_tugas_judul', TRUE));
		$filter_class = trim($this->input->post('filter_class', TRUE));
		$urutan = (int) $this->input->post('urutan');
		$aktif = $this->input->post('aktif') ? 1 : 0;
		$redirect_form = $id ? 'admin/bidang/edit/' . $id : 'admin/bidang/tambah';

		if ($kode === '' || $label === '' || $url_slug === '') {
			$this->session->set_flashdata('error', 'Kode, nama tampilan, dan URL wajib diisi.');
			redirect($redirect_form);
		}
		if (mb_strlen($kode) > 100 || mb_strlen($label) > 255 || mb_strlen($url_slug) > 100) {
			$this->session->set_flashdata('error', 'Panjang kode/label/URL melebihi batas.');
			redirect($redirect_form);
		}
		if (!preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $url_slug)) {
			$this->session->set_flashdata('error', 'URL hanya boleh huruf kecil, angka, dan strip.');
			redirect($redirect_form);
		}
		if ($this->Bidang_model->kode_exists($kode, $id ?: null)) {
			$this->session->set_flashdata('error', 'Kode bidang sudah dipakai.');
			redirect($redirect_form);
		}
		if ($this->Bidang_model->url_slug_exists($url_slug, $id ?: null)) {
			$this->session->set_flashdata('error', 'URL slug sudah dipakai bidang lain.');
			redirect($redirect_form);
		}

		$data = array(
			'kode'                  => $kode,
			'label'                 => $label,
			'url_slug'              => $url_slug,
			'aliases'               => $aliases !== '' ? $aliases : null,
			'judul_halaman'         => $judul_halaman !== '' ? $judul_halaman : null,
			'subjudul'              => $subjudul !== '' ? $subjudul : null,
			'kepala_judul'          => $kepala_judul !== '' ? $kepala_judul : null,
			'kepala_nama'           => $kepala_nama !== '' ? $kepala_nama : null,
			'kepala_nip'            => $kepala_nip !== '' ? $kepala_nip : null,
			'kepala_foto'           => $kepala_foto !== '' ? $kepala_foto : null,
			'layanan_judul'         => $layanan_judul !== '' ? $layanan_judul : null,
			'ringkasan_tugas_judul' => $ringkasan_tugas_judul !== '' ? $ringkasan_tugas_judul : null,
			'filter_class'          => $filter_class !== '' ? $filter_class : null,
			'urutan'                => max(0, $urutan),
			'aktif'                 => $aktif,
		);

		if ($id) {
			$existing = $this->Bidang_model->get_by_id($id);
			if (!$existing) {
				show_404();
			}
			if ($existing['kode'] !== $kode) {
				$alias_list = Bidang_model::parse_aliases($aliases);
				if (!in_array($existing['kode'], $alias_list, TRUE)) {
					array_unshift($alias_list, $existing['kode']);
					$data['aliases'] = implode(', ', $alias_list);
				}
			}
			$this->Bidang_model->update($id, $data);
			$this->load->model('Berita_model');
			$match_values = array_unique(array_merge(
				array($existing['kode'], $kode),
				Bidang_model::parse_aliases($existing['aliases'] ?? ''),
				Bidang_model::parse_aliases($data['aliases'] ?? '')
			));
			$this->Berita_model->relink_bidang_berita($id, $match_values, $kode);
			$this->Berita_model->sync_bidang_kode($id, $kode);
			$this->session->set_flashdata('success', 'Bidang berhasil diperbarui.');
		} else {
			$this->Bidang_model->insert($data);
			$this->session->set_flashdata('success', 'Bidang berhasil ditambahkan.');
		}

		berita_bidang_list_reset();
		redirect('admin/bidang');
	}

	public function hapus()
	{
		$this->require_post();

		$id = (int) $this->input->post('id');
		if ($id < 1) {
			show_404();
		}

		$bidang = $this->Bidang_model->get_by_id($id);
		if (!$bidang) {
			show_404();
		}
		if ($this->Bidang_model->count_berita($bidang['kode']) > 0) {
			$this->session->set_flashdata('error', 'Bidang tidak dapat dihapus karena masih dipakai berita.');
			redirect('admin/bidang');
		}
		if (!$this->Bidang_model->delete($id)) {
			$this->session->set_flashdata('error', 'Gagal menghapus bidang.');
			redirect('admin/bidang');
		}

		berita_bidang_list_reset();
		$this->session->set_flashdata('success', 'Bidang berhasil dihapus.');
		redirect('admin/bidang');
	}

	public function layanan($bidang_id)
	{
		$bidang = $this->Bidang_model->get_by_id($bidang_id);
		if (!$bidang) {
			show_404();
		}
		if (!$this->Bidang_layanan_model->table_ready()) {
			$this->session->set_flashdata('error', 'Tabel layanan bidang belum tersedia. Jalankan migrasi database terlebih dahulu.');
			redirect('admin/bidang');
		}

		$this->render('admin/bidang_layanan_index', array(
			'title'        => 'Layanan Bidang',
			'active_menu'  => 'bidang',
			'bidang'       => $bidang,
			'layanan_list' => $this->Bidang_layanan_model->get_by_bidang_id($bidang['id']),
			'sop_max_mb'   => $this->Setting_model->sop_max_size_mb(),
		));
	}

	public function layanan_tambah($bidang_id)
	{
		$bidang = $this->Bidang_model->get_by_id($bidang_id);
		if (!$bidang) {
			show_404();
		}
		if (!$this->Bidang_layanan_model->table_ready()) {
			$this->session->set_flashdata('error', 'Tabel layanan bidang belum tersedia. Jalankan migrasi database terlebih dahulu.');
			redirect('admin/bidang');
		}

		$this->render('admin/bidang_layanan_form', array(
			'title'       => 'Tambah Layanan',
			'active_menu' => 'bidang',
			'bidang'      => $bidang,
			'sop_max_mb'  => $this->Setting_model->sop_max_size_mb(),
		));
	}

	public function layanan_edit($id)
	{
		$layanan = $this->Bidang_layanan_model->get_by_id($id);
		if (!$layanan) {
			show_404();
		}
		$bidang = $this->Bidang_model->get_by_id($layanan['bidang_id']);
		if (!$bidang) {
			show_404();
		}

		$this->render('admin/bidang_layanan_form', array(
			'title'       => 'Edit Layanan',
			'active_menu' => 'bidang',
			'bidang'      => $bidang,
			'layanan'     => $layanan,
			'sop_max_mb'  => $this->Setting_model->sop_max_size_mb(),
		));
	}

	public function layanan_simpan()
	{
		$this->require_post();

		$id = (int) $this->input->post('id');
		$bidang_id = (int) $this->input->post('bidang_id');
		$judul = trim($this->input->post('judul', TRUE));
		$judul_overlay = trim($this->input->post('judul_overlay', TRUE));
		$url = trim($this->input->post('url', TRUE));
		$urutan = (int) $this->input->post('urutan');
		$aktif = $this->input->post('aktif') ? 1 : 0;
		$hapus_sop = $this->input->post('hapus_sop') ? 1 : 0;

		$bidang = $this->Bidang_model->get_by_id($bidang_id);
		if (!$bidang) {
			show_404();
		}

		$redirect_form = $id
			? 'admin/bidang/layanan_edit/' . $id
			: 'admin/bidang/layanan_tambah/' . $bidang_id;

		if ($judul === '') {
			$this->session->set_flashdata('error', 'Judul layanan wajib diisi.');
			redirect($redirect_form);
		}
		if (mb_strlen($judul) > 255 || mb_strlen($judul_overlay) > 255 || mb_strlen($url) > 500) {
			$this->session->set_flashdata('error', 'Panjang judul/URL melebihi batas.');
			redirect($redirect_form);
		}
		if ($url === '') {
			$url = '#';
		}

		$existing = null;
		if ($id) {
			$existing = $this->Bidang_layanan_model->get_by_id($id);
			if (!$existing || (int) $existing['bidang_id'] !== $bidang_id) {
				show_404();
			}
		}

		$data = array(
			'bidang_id'     => $bidang_id,
			'judul'         => $judul,
			'judul_overlay' => $judul_overlay !== '' ? $judul_overlay : null,
			'url'           => $url,
			'urutan'        => max(0, $urutan),
			'aktif'         => $aktif,
		);

		$sop_uploaded = null;
		if (!empty($_FILES['sop_file']['name'])) {
			$sop_uploaded = $this->_upload_sop();
			if ($sop_uploaded === false) {
				redirect($redirect_form);
			}
			$data['sop_file'] = $sop_uploaded;
		} elseif ($hapus_sop && $existing) {
			$data['sop_file'] = null;
		}

		if ($id) {
			$this->Bidang_layanan_model->update($id, $data);
			if (!empty($existing['sop_file']) && (
				($sop_uploaded !== null && $sop_uploaded !== $existing['sop_file'])
				|| ($hapus_sop && empty($sop_uploaded))
			)) {
				$this->_unlink_sop_owned($existing['sop_file']);
			}
			$this->session->set_flashdata('success', 'Layanan berhasil diperbarui.');
		} else {
			$this->Bidang_layanan_model->insert($data);
			$this->session->set_flashdata('success', 'Layanan berhasil ditambahkan.');
		}

		redirect('admin/bidang/layanan/' . $bidang_id);
	}

	public function layanan_hapus()
	{
		$this->require_post();

		$id = (int) $this->input->post('id');
		if ($id < 1) {
			show_404();
		}

		$layanan = $this->Bidang_layanan_model->get_by_id($id);
		if (!$layanan) {
			show_404();
		}

		$bidang_id = (int) $layanan['bidang_id'];
		if (!$this->Bidang_layanan_model->delete($id)) {
			$this->session->set_flashdata('error', 'Gagal menghapus layanan.');
			redirect('admin/bidang/layanan/' . $bidang_id);
		}

		if (!empty($layanan['sop_file'])) {
			$this->_unlink_sop_owned($layanan['sop_file']);
		}

		$this->session->set_flashdata('success', 'Layanan berhasil dihapus.');
		redirect('admin/bidang/layanan/' . $bidang_id);
	}

	private function _upload_sop()
	{
		$path = fcpath_bidang_layanan_sop();
		if (!is_dir($path)) {
			mkdir($path, 0755, TRUE);
		}

		$max_kb = $this->Setting_model->sop_max_size_kb();
		$config = array(
			'upload_path'   => $path,
			'allowed_types' => 'pdf',
			'max_size'      => $max_kb,
			'encrypt_name'  => TRUE,
		);
		$this->upload->initialize($config);
		if (!$this->upload->do_upload('sop_file')) {
			$this->session->set_flashdata('error', strip_tags($this->upload->display_errors('', '')));
			return false;
		}

		return 'download/layanan/' . $this->upload->data('file_name');
	}

	private function _unlink_sop_owned($sop_file)
	{
		$sop_file = ltrim((string) $sop_file, '/');
		if (strpos($sop_file, 'download/layanan/') !== 0) {
			return;
		}
		$full = bidang_layanan_sop_fcpath($sop_file);
		if ($full !== '' && is_file($full)) {
			@unlink($full);
		}
	}
}
