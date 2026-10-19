<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengunjung extends CI_Controller {

	public function catat()
	{
		$this->output->set_header('Cache-Control: no-store');
		if ($this->input->method(TRUE) !== 'POST' || !$this->input->is_ajax_request() || pengunjung_bot()) {
			$this->output->set_status_header(204);
			return;
		}
		$this->load->helper('cookie');
		if (get_cookie('bkd_pengunjung') !== 'baru' || !$this->session->userdata('pengunjung_tunggu')) {
			$this->output->set_status_header(204);
			return;
		}
		if (!pengunjung_asal_valid(
			$this->input->server('HTTP_SEC_FETCH_SITE'),
			(string) $this->input->server('HTTP_REFERER'),
			parse_url(base_url(), PHP_URL_HOST)
		)) {
			$this->output->set_status_header(204);
			return;
		}

		$this->load->model('Setting_model');
		if (!$this->Setting_model->increment(Setting_model::PENGUNJUNG)) {
			$this->output->set_status_header(204);
			return;
		}
		$this->session->unset_userdata('pengunjung_tunggu');
		set_cookie('bkd_pengunjung', '1', 365 * 86400, '', '/', '', NULL, FALSE);
		$this->output->set_status_header(200);
		$this->output->set_content_type('text/plain', 'UTF-8');
		$this->output->set_output((string) pengunjung_total());
	}
}
