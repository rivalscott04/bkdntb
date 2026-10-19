<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Pengunjung unik per browser (cookie 1 tahun).
 * ponytail: bot headless yang menjalankan JS, menyimpan cookie, dan mengirim
 * CSRF dari halaman tetap terhitung sekali. Naikkan ke sidik jari server
 * kalau angka itu mulai kelihatan tidak masuk akal.
 */

if (!function_exists('pengunjung_ua_bot')) {
	function pengunjung_ua_bot($ua, $is_browser, $is_robot)
	{
		$ua = trim((string) $ua);
		if ($ua === '' || !$is_browser || $is_robot) {
			return true;
		}
		return (bool) preg_match(
			'/(?:^|[^a-z])bot(?:[^a-z]|$)|crawler|spider|wget|curl\/|python-|scrapy|headless|semrush|ahrefs|petalbot|bytespider|gptbot|claudebot|facebookexternal|whatsapp|preview/i',
			$ua
		);
	}
}

if (!function_exists('pengunjung_asal_valid')) {
	/** Beacon hanya dari halaman situs ini. */
	function pengunjung_asal_valid($sec_fetch_site, $referer, $site_host)
	{
		$sec_fetch_site = strtolower(trim((string) $sec_fetch_site));
		if ($sec_fetch_site !== '') {
			return $sec_fetch_site === 'same-origin';
		}
		$ref_host = parse_url((string) $referer, PHP_URL_HOST);
		$site_host = (string) $site_host;
		if ($ref_host === null || $ref_host === '' || $site_host === '') {
			return false;
		}
		return strcasecmp($ref_host, $site_host) === 0;
	}
}

if (!function_exists('pengunjung_bot')) {
	function pengunjung_bot()
	{
		$CI =& get_instance();
		$CI->load->library('user_agent');
		return pengunjung_ua_bot(
			(string) $CI->input->user_agent(),
			(bool) $CI->agent->is_browser(),
			(bool) $CI->agent->is_robot()
		);
	}
}

if (!function_exists('pengunjung_lewati')) {
	function pengunjung_lewati()
	{
		if (is_cli()) {
			return true;
		}
		$CI =& get_instance();
		$class = strtolower((string) $CI->router->class);
		if ($class === 'pengunjung' || $class === 'media' || strpos($class, 'admin') === 0) {
			return true;
		}
		return strpos((string) $CI->uri->uri_string(), 'admin') === 0;
	}
}

if (!function_exists('pengunjung_siapkan')) {
	/** Halaman HTML menandai browser. Angka baru naik di Pengunjung::catat(). */
	function pengunjung_siapkan()
	{
		if (pengunjung_lewati() || pengunjung_bot()) {
			return;
		}
		$CI =& get_instance();
		$CI->load->helper('cookie');
		if (get_cookie('bkd_pengunjung') === '1') {
			return;
		}
		$CI->session->set_userdata('pengunjung_tunggu', 1);
		if (get_cookie('bkd_pengunjung') !== 'baru') {
			set_cookie('bkd_pengunjung', 'baru', 365 * 86400, '', '/', '', NULL, FALSE);
		}
	}
}

if (!function_exists('pengunjung_total')) {
	function pengunjung_total()
	{
		$CI =& get_instance();
		$CI->load->model('Setting_model');
		return (int) $CI->Setting_model->get(Setting_model::PENGUNJUNG, 0);
	}
}
