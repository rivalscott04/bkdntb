<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_berita extends Admin_Controller {

	private $per_page = 10;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Berita_model');
		$this->load->helper(array('url', 'form', 'berita'));
		$this->load->library('pagination');
		$this->load->library('upload');
	}

	private function _pagination_config($base_url, $total)
	{
		return array(
			'base_url'             => $base_url,
			'total_rows'           => $total,
			'per_page'             => $this->per_page,
			'use_page_numbers'     => TRUE,
			'page_query_string'    => TRUE,
			'query_string_segment' => 'page',
			'reuse_query_string'   => TRUE,
			'full_tag_open'        => '<ul class="pagination justify-content-center">',
			'full_tag_close'       => '</ul>',
			'first_tag_open'       => '<li class="page-item">',
			'first_tag_close'      => '</li>',
			'last_tag_open'        => '<li class="page-item">',
			'last_tag_close'       => '</li>',
			'next_tag_open'        => '<li class="page-item">',
			'next_tag_close'       => '</li>',
			'prev_tag_open'        => '<li class="page-item">',
			'prev_tag_close'       => '</li>',
			'cur_tag_open'         => '<li class="page-item active"><span class="page-link">',
			'cur_tag_close'        => '</span></li>',
			'num_tag_open'         => '<li class="page-item">',
			'num_tag_close'        => '</li>',
			'attributes'           => array('class' => 'page-link'),
		);
	}

	private function _admin_filters_from_input()
	{
		$bidang_list = berita_bidang_list();
		$bidang = $this->input->get('bidang', TRUE);
		$status = $this->input->get('status', TRUE);
		$tanggal_dari = $this->_parse_filter_date($this->input->get('tanggal_dari', TRUE));
		$tanggal_sampai = $this->_parse_filter_date($this->input->get('tanggal_sampai', TRUE));

		if ($tanggal_dari !== '' && $tanggal_sampai !== '' && $tanggal_dari > $tanggal_sampai) {
			$tmp = $tanggal_dari;
			$tanggal_dari = $tanggal_sampai;
			$tanggal_sampai = $tmp;
		}

		return array(
			'q'              => trim($this->input->get('q', TRUE)),
			'bidang'         => isset($bidang_list[$bidang]) ? $bidang : '',
			'status'         => in_array($status, array('published', 'draft'), TRUE) ? $status : '',
			'tanggal_dari'   => $tanggal_dari,
			'tanggal_sampai' => $tanggal_sampai,
		);
	}

	private function _parse_filter_date($value)
	{
		$value = trim($value);
		if ($value === '') {
			return '';
		}
		$dt = DateTime::createFromFormat('Y-m-d', $value);
		if (!$dt || $dt->format('Y-m-d') !== $value) {
			return '';
		}
		return $value;
	}

	private function _berita_list_data($filters, $page = 1)
	{
		$page = max(1, (int) $page);
		$offset = ($page - 1) * $this->per_page;
		$total = $this->Berita_model->count_search_admin($filters);

		$this->pagination->initialize($this->_pagination_config(site_url('admin/berita/cari'), $total));

		return array(
			'berita_list' => $this->Berita_model->search_admin($filters, $this->per_page, $offset),
			'pagination'  => $total > $this->per_page ? $this->pagination->create_links() : '',
			'total'       => $total,
			'page'        => $page,
		);
	}

	public function index()
	{
		$filters = $this->_admin_filters_from_input();
		$page = max(1, (int) $this->input->get('page'));
		$list = $this->_berita_list_data($filters, $page);

		$this->render('admin/berita_index', array(
			'title'         => 'Kelola Berita',
			'active_menu'   => 'berita',
			'use_list_ajax' => TRUE,
			'bidang_list'   => berita_bidang_list(),
			'filters'       => $filters,
			'berita_list'   => $list['berita_list'],
			'pagination'    => $list['pagination'],
			'total'         => $list['total'],
			'page'          => $list['page'],
		));
	}

	public function cari()
	{
		$filters = $this->_admin_filters_from_input();
		$page = max(1, (int) $this->input->get('page'));
		$list = $this->_berita_list_data($filters, $page);

		$rows_html = $this->load->view('admin/partials/berita_table_rows', array(
			'berita_list' => $list['berita_list'],
		), TRUE);

		return $this->output
			->set_content_type('application/json')
			->set_output(json_encode(array(
				'html'       => $rows_html,
				'pagination' => $list['pagination'],
				'total'      => $list['total'],
				'shown'      => count($list['berita_list']),
				'page'       => $list['page'],
				'filters'    => $filters,
			)));
	}

	public function tambah()
	{
		$this->render('admin/berita_form', array(
			'title'       => 'Tambah Berita',
			'active_menu' => 'berita',
			'use_editor'  => TRUE,
			'bidang_list' => berita_bidang_list(),
		));
	}

	public function edit($id)
	{
		$berita = $this->Berita_model->get_by_id($id);
		if (!$berita) {
			show_404();
		}
		$this->render('admin/berita_form', array(
			'title'       => 'Edit Berita',
			'active_menu' => 'berita',
			'use_editor'  => TRUE,
			'berita'      => $berita,
			'bidang_list' => berita_bidang_list(),
		));
	}

	public function simpan()
	{
		$this->require_post();

		$id = (int) $this->input->post('id');
		$judul = trim($this->input->post('judul_berita', TRUE));
		$bidang = $this->input->post('bidang', TRUE);
		$tanggal = $this->input->post('tanggal', TRUE);
		$penulis = trim($this->input->post('penulis', TRUE)) ?: 'Admin';
		$isi = normalize_berita_html_images_for_storage(sanitize_html_berita($this->input->post('isi_berita')));
		$status = $this->input->post('status', TRUE) === 'draft' ? 'draft' : 'published';
		$redirect_form = $id ? 'admin/berita/edit/' . $id : 'admin/berita/tambah';

		$bidang_list = berita_bidang_list();

		if ($judul === '' || $bidang === '' || $tanggal === '' || trim(strip_tags($isi)) === '') {
			$this->session->set_flashdata('error', 'Judul, bidang, tanggal, dan narasi wajib diisi.');
			redirect($redirect_form);
		}
		if (mb_strlen($judul) > 255) {
			$this->session->set_flashdata('error', 'Judul maksimal 255 karakter.');
			redirect($redirect_form);
		}
		if (mb_strlen($penulis) > 100) {
			$this->session->set_flashdata('error', 'Nama penulis maksimal 100 karakter.');
			redirect($redirect_form);
		}
		if (!isset($bidang_list[$bidang])) {
			$this->session->set_flashdata('error', 'Bidang tidak valid.');
			redirect($redirect_form);
		}
		$tanggal_ts = strtotime($tanggal . ' 00:00:00');
		if ($tanggal_ts === FALSE) {
			$this->session->set_flashdata('error', 'Format tanggal tidak valid.');
			redirect($redirect_form);
		}

		$gambar = null;
		if (!empty($_FILES['gambar_berita']['name'])) {
			$gambar = $this->_upload_gambar();
			if ($gambar === false) {
				redirect($redirect_form);
			}
		}

		$data = array(
			'judul_berita' => $judul,
			'isi_berita'   => $isi,
			'penulis'      => $penulis,
			'tanggal'      => date('Y-m-d 00:00:00', $tanggal_ts),
			'status'       => $status,
		);
		$data = array_merge($data, $this->Berita_model->prepare_bidang_data($bidang));

		if ($id) {
			$existing = $this->Berita_model->get_by_id($id);
			if (!$existing) {
				show_404();
			}
			$data['slug'] = $this->Berita_model->generate_unique_slug($judul, $id);
			if ($gambar) {
				if (!empty($existing['gambar_berita'])) {
					$old = fcpath_gambar_berita($existing['gambar_berita']);
					if (is_file($old)) {
						@unlink($old);
					}
				}
				$data['gambar_berita'] = $gambar;
			}
			$this->Berita_model->update($id, $data);
			$this->session->set_flashdata('success', 'Berita berhasil diperbarui.');
		} else {
			if (!$gambar) {
				$this->session->set_flashdata('error', 'Gambar wajib diupload.');
				redirect('admin/berita/tambah');
			}
			$data['slug'] = $this->Berita_model->generate_unique_slug($judul);
			$data['gambar_berita'] = $gambar;
			$this->Berita_model->insert($data);
			$this->session->set_flashdata('success', 'Berita berhasil ditambahkan.');
		}

		redirect('admin/berita');
	}

	public function hapus()
	{
		$this->require_post();

		$id = (int) $this->input->post('id');
		if ($id < 1) {
			show_404();
		}

		$berita = $this->Berita_model->get_by_id($id);
		if (!$berita) {
			show_404();
		}
		$this->Berita_model->delete($id);
		$this->session->set_flashdata('success', 'Berita berhasil dihapus.');
		redirect('admin/berita');
	}

	public function upload_gambar()
	{
		$this->require_post();

		if (empty($_FILES['file']['name'])) {
			return $this->_json_upload_error('File tidak ditemukan.', 400);
		}

		$path = fcpath_gambar_berita('', TRUE);
		if (!is_dir($path)) {
			mkdir($path, 0755, TRUE);
		}

		$config = array(
			'upload_path'   => $path,
			'allowed_types' => 'jpg|jpeg|png|webp|gif',
			'max_size'      => 2048,
			'encrypt_name'  => TRUE,
		);
		$this->upload->initialize($config);
		if (!$this->upload->do_upload('file')) {
			return $this->_json_upload_error(strip_tags($this->upload->display_errors('', '')), 400);
		}

		$file = $this->upload->data('file_name');
		return $this->output
			->set_content_type('application/json')
			->set_output(json_encode(array(
				'path'       => berita_gambar_relpath($file, TRUE),
				'csrf_name'  => $this->security->get_csrf_token_name(),
				'csrf_token' => $this->security->get_csrf_hash(),
			)));
	}

	private function _json_upload_error($message, $status = 400)
	{
		return $this->output
			->set_content_type('application/json')
			->set_status_header($status)
			->set_output(json_encode(array('error' => $message)));
	}

	private function _upload_gambar()
	{
		$config = array(
			'upload_path'   => fcpath_gambar_berita(),
			'allowed_types' => 'jpg|jpeg|png|webp|gif',
			'max_size'      => 4096,
			'encrypt_name'  => TRUE,
		);
		$this->upload->initialize($config);
		if (!$this->upload->do_upload('gambar_berita')) {
			$this->session->set_flashdata('error', $this->upload->display_errors('', ''));
			return false;
		}
		return $this->upload->data('file_name');
	}
}
