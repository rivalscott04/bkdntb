<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Pengunjung unik per browser (cookie 1 tahun).
 * Hari, minggu, dan bulan naik sekali per browser pada periode itu.
 * ponytail: bot headless yang menjalankan JS dan menyimpan cookie tetap terhitung sekali.
 * Dua tab di pergantian hari bisa naik dua kali. Naikkan ke sidik jari server
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

if (!function_exists('pengunjung_rahasia')) {
	function pengunjung_rahasia()
	{
		return hash('sha256', 'bkd-pengunjung|' . (string) config_item('encryption_key'));
	}
}

if (!function_exists('pengunjung_tanda')) {
	function pengunjung_tanda($vid, $hari, $minggu, $bulan, $rahasia)
	{
		$body = $vid . '.' . $hari . '.' . $minggu . '.' . $bulan;
		return $body . '.' . substr(hash_hmac('sha256', $body, $rahasia), 0, 16);
	}
}

if (!function_exists('pengunjung_baca')) {
	/** Array vid/hari/minggu/bulan, atau null bila cookie palsu. */
	function pengunjung_baca($raw, $rahasia)
	{
		if (!preg_match('/\A([a-f0-9]{16})\.(\d{4}-\d{2}-\d{2})\.(\d{4}-W\d{2})\.(\d{4}-\d{2})\.([a-f0-9]{16})\z/', (string) $raw, $m)) {
			return null;
		}
		$body = $m[1] . '.' . $m[2] . '.' . $m[3] . '.' . $m[4];
		$sig = substr(hash_hmac('sha256', $body, $rahasia), 0, 16);
		if (!hash_equals($sig, $m[5])) {
			return null;
		}
		return array(
			'vid'    => $m[1],
			'hari'   => $m[2],
			'minggu' => $m[3],
			'bulan'  => $m[4],
		);
	}
}

if (!function_exists('pengunjung_periode')) {
	function pengunjung_periode()
	{
		$now = new DateTime('now', new DateTimeZone('Asia/Makassar'));
		return array(
			'hari'   => $now->format('Y-m-d'),
			'minggu' => $now->format('o-\WW'),
			'bulan'  => $now->format('Y-m'),
		);
	}
}

if (!function_exists('pengunjung_naik')) {
	function pengunjung_naik(array $kunci_list)
	{
		$CI =& get_instance();
		$CI->load->model('Setting_model');
		foreach ($kunci_list as $kunci) {
			if (!$CI->Setting_model->increment($kunci)) {
				return false;
			}
		}
		return true;
	}
}

if (!function_exists('pengunjung_simpan_cookie')) {
	function pengunjung_simpan_cookie($nilai)
	{
		$CI =& get_instance();
		$CI->load->helper('cookie');
		set_cookie('bkd_pengunjung', $nilai, 365 * 86400, '', '/', '', NULL, FALSE);
	}
}

if (!function_exists('pengunjung_perbarui')) {
	/** Pengunjung yang sudah terbukti browser: naikkan periode yang belum, segarkan online. */
	function pengunjung_perbarui($raw)
	{
		$rahasia = pengunjung_rahasia();
		$data = $raw === '1' ? null : pengunjung_baca($raw, $rahasia);
		if ($raw !== '1' && !$data) {
			return false;
		}
		$p = pengunjung_periode();
		$vid = $data['vid'] ?? bin2hex(random_bytes(8));
		$naik = array();
		if (!$data || $data['hari'] !== $p['hari']) {
			$naik[] = 'ph:' . $p['hari'];
		}
		if (!$data || $data['minggu'] !== $p['minggu']) {
			$naik[] = 'pm:' . $p['minggu'];
		}
		if (!$data || $data['bulan'] !== $p['bulan']) {
			$naik[] = 'pb:' . $p['bulan'];
		}
		if ($naik && !pengunjung_naik($naik)) {
			return false;
		}
		if ($naik || $raw === '1') {
			pengunjung_simpan_cookie(pengunjung_tanda($vid, $p['hari'], $p['minggu'], $p['bulan'], $rahasia));
		}
		$CI =& get_instance();
		$CI->load->model('Pengunjung_model');
		$CI->Pengunjung_model->sentuh($vid);
		return $vid;
	}
}

if (!function_exists('pengunjung_siapkan')) {
	/** Halaman HTML menandai browser baru. Angka pertama naik di Pengunjung::catat(). */
	function pengunjung_siapkan()
	{
		if (pengunjung_lewati() || pengunjung_bot()) {
			return;
		}
		$CI =& get_instance();
		$CI->load->helper('cookie');
		$raw = (string) get_cookie('bkd_pengunjung');
		if ($raw === '1' || pengunjung_baca($raw, pengunjung_rahasia())) {
			pengunjung_perbarui($raw);
			return;
		}
		$CI->session->set_userdata('pengunjung_tunggu', 1);
		if ($raw !== 'baru') {
			pengunjung_simpan_cookie('baru');
		}
	}
}

if (!function_exists('pengunjung_angka')) {
	function pengunjung_angka($n)
	{
		return number_format((int) $n, 0, ',', '.');
	}
}

if (!function_exists('pengunjung_rekap')) {
	function pengunjung_rekap()
	{
		$CI =& get_instance();
		$CI->load->model(array('Setting_model', 'Pengunjung_model'));
		$p = pengunjung_periode();
		$kunci = array(
			'total'  => Setting_model::PENGUNJUNG,
			'hari'   => 'ph:' . $p['hari'],
			'minggu' => 'pm:' . $p['minggu'],
			'bulan'  => 'pb:' . $p['bulan'],
		);
		$map = $CI->Setting_model->get_many(array_values($kunci));
		$out = array();
		foreach ($kunci as $nama => $id) {
			$out[$nama] = (int) ($map[$id] ?? 0);
		}
		$out['online'] = $CI->Pengunjung_model->jumlah();
		return $out;
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
