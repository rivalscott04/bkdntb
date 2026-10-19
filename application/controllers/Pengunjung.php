<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengunjung extends CI_Controller {

	public function catat()
	{
		if (!$this->_boleh() || get_cookie('bkd_pengunjung') !== 'baru' || !$this->session->userdata('pengunjung_tunggu')) {
			$this->_kosong();
			return;
		}
		if (!pengunjung_asal_valid(
			$this->input->server('HTTP_SEC_FETCH_SITE'),
			(string) $this->input->server('HTTP_REFERER'),
			parse_url(base_url(), PHP_URL_HOST)
		)) {
			$this->_kosong();
			return;
		}

		$this->load->model('Setting_model');
		$p = pengunjung_periode();
		$vid = bin2hex(random_bytes(8));
		if (!pengunjung_naik(array(
			Setting_model::PENGUNJUNG,
			'ph:' . $p['hari'],
			'pm:' . $p['minggu'],
			'pb:' . $p['bulan'],
		))) {
			$this->_kosong();
			return;
		}
		$this->session->unset_userdata('pengunjung_tunggu');
		pengunjung_simpan_cookie(pengunjung_tanda($vid, $p['hari'], $p['minggu'], $p['bulan'], pengunjung_rahasia()));
		$this->load->model('Pengunjung_model');
		$this->Pengunjung_model->sentuh($vid);
		$this->_json(pengunjung_rekap());
	}

	public function online()
	{
		$this->load->helper('cookie');
		$data = pengunjung_baca((string) get_cookie('bkd_pengunjung'), pengunjung_rahasia());
		if (!$this->_boleh() || !$data || !pengunjung_asal_valid(
			$this->input->server('HTTP_SEC_FETCH_SITE'),
			(string) $this->input->server('HTTP_REFERER'),
			parse_url(base_url(), PHP_URL_HOST)
		)) {
			$this->_kosong();
			return;
		}
		$this->load->model('Pengunjung_model');
		$this->Pengunjung_model->sentuh($data['vid']);
		$this->_json(array('online' => $this->Pengunjung_model->jumlah()));
	}

	private function _boleh()
	{
		$this->output->set_header('Cache-Control: no-store');
		$this->load->helper('cookie');
		return $this->input->method(TRUE) === 'POST' && $this->input->is_ajax_request() && !pengunjung_bot();
	}

	private function _kosong()
	{
		$this->output->set_status_header(204);
	}

	private function _json(array $data)
	{
		$data['csrf'] = $this->security->get_csrf_hash();
		$this->output->set_status_header(200);
		$this->output->set_content_type('application/json', 'UTF-8');
		$this->output->set_output(json_encode($data));
	}
}
