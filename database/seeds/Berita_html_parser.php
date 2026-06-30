<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Berita_html_parser {

	private static $bulan = array(
		'januari' => '01', 'februari' => '02', 'maret' => '03', 'april' => '04',
		'mei' => '05', 'juni' => '06', 'juli' => '07', 'agustus' => '08',
		'september' => '09', 'oktober' => '10', 'november' => '11', 'desember' => '12',
		'january' => '01', 'february' => '02', 'march' => '03', 'april' => '04',
		'may' => '05', 'june' => '06', 'july' => '07', 'august' => '08',
		'october' => '10', 'december' => '12',
	);

	public static function parse_file($path, $default_bidang = null)
	{
		if (!is_file($path)) {
			return array();
		}
		return self::parse_html(file_get_contents($path), $default_bidang);
	}

	public static function parse_view_file($path, $default_bidang = null)
	{
		if (!is_file($path)) {
			return array();
		}
		$content = file_get_contents($path);
		if (!preg_match('/<div class="blog-post">(.*?)<\/div>\s*(?:<div class="row">|<\/div>\s*<div class="col-xl)/s', $content, $m)) {
			return array();
		}
		return self::parse_html($m[1], $default_bidang);
	}

	public static function parse_html($html, $default_bidang = null)
	{
		$items = array();
		if (!preg_match_all('/<div class="single-blog-post[^"]*".*?(?=<div class="single-blog-post|$)/s', $html, $blocks)) {
			return $items;
		}

		foreach ($blocks[0] as $block) {
			$item = self::parse_block($block, $default_bidang);
			if ($item) {
				$items[] = $item;
			}
		}
		return $items;
	}

	private static function parse_block($block, $default_bidang)
	{
		if (!preg_match('/<h3 class="blog-title"[^>]*>\s*(?:<a[^>]*>)?(.*?)(?:<\/a>)?\s*<\/h3>/s', $block, $m)) {
			return null;
		}
		$judul = trim(html_entity_decode(strip_tags($m[1]), ENT_QUOTES, 'UTF-8'));
		if ($judul === '') {
			return null;
		}

		$gambar = 'pelantikankadis.jpg';
		if (preg_match('/images\/blog\/([^"\']+)/', $block, $m)) {
			$gambar = $m[1];
		}

		$isi = '';
		if (preg_match('/<div class="text">\s*(.*?)\s*<\/div>\s*<div class="button">/s', $block, $m)
			|| preg_match('/<div class="text">\s*(.*?)\s*<\/div>/s', $block, $m)) {
			$isi = trim($m[1]);
		}
		if ($isi === '') {
			$isi = '<p>' . html_escape($judul) . '</p>';
		}

		$tanggal = date('Y-m-d H:i:s');
		if (preg_match('/<li><a[^>]*>\s*(\d{1,2}\s+\w+\s+\d{4})\s*<\/a><\/li>/', $block, $m)
			|| preg_match('/<li><a[^>]*>\s*(\d{1,2}\s+\w+\s+\d{4})\s*<\/a>/', $block, $m)) {
			$tanggal = self::parse_tanggal($m[1]);
		}

		$bidang = $default_bidang;
		if (preg_match('/Bidang\s*<a[^>]*>([^<]+)<\/a>/', $block, $m)) {
			$bidang = trim($m[1]);
		} elseif (preg_match('/UPTB\s*<a[^>]*>UPPK<\/a>/', $block)) {
			$bidang = 'UPTB UPPK';
		}

		$bidang = self::normalize_bidang($bidang);

		return array(
			'judul_berita'  => $judul,
			'isi_berita'    => $isi,
			'penulis'       => 'Admin',
			'tanggal'       => $tanggal,
			'gambar_berita' => $gambar,
			'bidang'        => $bidang,
			'status'        => 'published',
		);
	}

	private static function parse_tanggal($text)
	{
		$text = strtolower(trim(preg_replace('/\s+/', ' ', $text)));
		if (preg_match('/(\d{1,2})\s+(\w+)\s+(\d{4})/', $text, $m)) {
			$bulan = self::$bulan[$m[2]] ?? '01';
			return sprintf('%04d-%s-%02d 08:00:00', $m[3], $bulan, $m[1]);
		}
		return date('Y-m-d H:i:s');
	}

	private static function normalize_bidang($bidang)
	{
		$map = array(
			'Sekretariat' => 'Sekretariat',
			'PPI' => 'PPI',
			'Pengadaan, Pemberhentian & Informasi (PPI)' => 'PPI',
			'Mutasi' => 'Mutasi & Promosi',
			'Mutasi & Promosi' => 'Mutasi & Promosi',
			'Pengembangan Aparatur' => 'Pengembangan Aparatur',
			'Penilaian Kinerja Aparatur & Penghargaan' => 'Penilaian Kinerja Aparatur & Penghargaan',
			'UPTB UPPK' => 'UPTB UPPK',
			'UPPK' => 'UPTB UPPK',
		);
		$bidang = trim($bidang);
		return $map[$bidang] ?? $bidang;
	}
}
