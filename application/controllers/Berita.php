<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Berita extends CI_Controller {

	private $per_page = 9;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Berita_model');
		$this->load->helper('berita');
		$this->load->library('pagination');
	}

	public function index()
	{
		$page = max(1, (int) $this->input->get('page'));
		$offset = ($page - 1) * $this->per_page;
		$total = $this->Berita_model->count_all('published');

		$config['base_url'] = site_url('berita');
		$config['total_rows'] = $total;
		$config['per_page'] = $this->per_page;
		$config['use_page_numbers'] = TRUE;
		$config['page_query_string'] = TRUE;
		$config['query_string_segment'] = 'page';
		$config['full_tag_open'] = '<ul class="pagination justify-content-center">';
		$config['full_tag_close'] = '</ul>';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li class="page-item">';
		$config['last_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li class="page-item">';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close'] = '</span></li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['attributes'] = array('class' => 'page-link');
		$this->pagination->initialize($config);

		$data = array(
			'berita_list' => $this->Berita_model->get_all($this->per_page, $offset, 'published'),
			'pagination'  => $this->pagination->create_links(),
		);

		$this->load->view('header');
		$this->load->view('berita', $data);
		$this->load->view('footer');
	}

	public function detail($slug = null)
	{
		if (empty($slug)) {
			show_404();
		}
		$berita = $this->Berita_model->get_by_slug($slug, 'published');
		if (!$berita) {
			show_404();
		}
		$this->load->view('header');
		$this->load->view('berita_detail', array('berita' => $berita));
		$this->load->view('footer');
	}
}
