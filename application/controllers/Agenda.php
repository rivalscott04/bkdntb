<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agenda extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Agenda_model');
		$this->load->helper('berita');
		$this->load->library('pagination');
	}

	/**
	 * Halaman 1 = minggu ini + agenda mendatang; halaman 2 dst = minggu sebelumnya (satu minggu per halaman).
	 */
	public function index()
	{
		$tz = new DateTimeZone('Asia/Makassar');
		$senin_ini = (new DateTime('monday this week', $tz))->format('Y-m-d');
		$past = $this->Agenda_model->past_week_mondays($senin_ini);
		$page = max(1, (int) $this->input->get('page'));

		if ($page > count($past) + 1) {
			show_404();
		}

		if ($page === 1) {
			$senin = $senin_ini;
			$list = $this->Agenda_model->get_range($senin);
		} else {
			$senin = $past[$page - 2];
			$list = $this->Agenda_model->get_range($senin, date('Y-m-d', strtotime($senin . ' +7 days')));
		}

		$pagination = '';
		if ($past) {
			$this->pagination->initialize(bidang_berita_pagination_config(site_url('agenda'), count($past) + 1, 1));
			$pagination = $this->pagination->create_links();
		}

		$this->load->view('header');
		$this->load->view('agenda', array(
			'agenda_list' => $list,
			'page'        => $page,
			'senin'       => $senin,
			// halaman 1 ikut memuat agenda mendatang, jadi rentangnya sampai agenda terakhir
			'minggu'      => max(date('Y-m-d', strtotime($senin . ' +6 days')), $list ? end($list)['tanggal'] : ''),
			'hari_ini'    => (new DateTime('now', $tz))->format('Y-m-d'),
			'pagination'  => $pagination,
		));
		$this->load->view('footer');
	}
}
