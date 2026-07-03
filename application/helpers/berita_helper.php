<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('buat_slug')) {
	function buat_slug($text, $id = null)
	{
		$text = strtolower(trim($text));
		$text = preg_replace('/[^a-z0-9\s-]/', '', $text);
		$text = preg_replace('/[\s-]+/', '-', $text);
		$text = trim($text, '-');
		if ($text === '') {
			$text = 'berita';
		}
		if ($id !== null) {
			$text .= '-' . $id;
		}
		return $text;
	}
}

if (!function_exists('ringkas_teks')) {
	function ringkas_teks($text, $length = 150)
	{
		$text = strip_tags($text);
		$text = preg_replace('/\s+/', ' ', $text);
		$text = trim($text);
		if (strlen($text) <= $length) {
			return $text;
		}
		return substr($text, 0, $length) . '...';
	}
}

if (!function_exists('format_tanggal_berita')) {
	function format_tanggal_berita($tanggal)
	{
		$bulan = array(
			1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
			5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
			9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
		);
		$ts = strtotime($tanggal);
		return date('j', $ts) . ' ' . $bulan[(int) date('n', $ts)] . ' ' . date('Y', $ts);
	}
}

if (!function_exists('format_tanggal_kartu')) {
	function format_tanggal_kartu($tanggal)
	{
		$bulan = array(
			1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
			5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
			9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des',
		);
		$ts = strtotime($tanggal);
		return array(
			'bulan' => $bulan[(int) date('n', $ts)],
			'hari'  => date('d', $ts),
		);
	}
}

if (!function_exists('berita_bidang_list')) {
	function berita_bidang_list($active_only = FALSE)
	{
		static $cache = array();
		static $loaded_version = -1;
		$version = $GLOBALS['_berita_bidang_list_version'] ?? 0;
		if ($loaded_version !== $version) {
			$cache = array();
			$loaded_version = $version;
		}

		$key = $active_only ? 'active' : 'all';
		if (isset($cache[$key])) {
			return $cache[$key];
		}

		$CI =& get_instance();
		$list = array();

		if ($CI->db->table_exists('bidang')) {
			$CI->load->model('Bidang_model');
			$list = $CI->Bidang_model->get_list_map($active_only);
		}

		if (empty($list)) {
			$CI->config->load('bidang', TRUE);
			$list = $CI->config->item('bidang_list', 'bidang');
			if (!is_array($list)) {
				$list = array();
			}
			if ($active_only) {
				$list = array_filter($list, function ($item) {
					return !isset($item['aktif']) || (int) $item['aktif'] === 1;
				});
			}
		}

		$cache[$key] = $list;
		return $list;
	}
}

if (!function_exists('berita_bidang_list_reset')) {
	function berita_bidang_list_reset()
	{
		$GLOBALS['_berita_bidang_list_version'] = ($GLOBALS['_berita_bidang_list_version'] ?? 0) + 1;
	}
}

if (!function_exists('bidang_rows_all')) {
	function bidang_rows_all($active_only = FALSE)
	{
		static $cache = array();
		static $loaded_version = -1;
		$version = $GLOBALS['_berita_bidang_list_version'] ?? 0;
		if ($loaded_version !== $version) {
			$cache = array();
			$loaded_version = $version;
		}

		$key = $active_only ? 'active' : 'all';
		if (isset($cache[$key])) {
			return $cache[$key];
		}

		$CI =& get_instance();
		$rows = array();
		if ($CI->db->table_exists('bidang')) {
			$CI->load->model('Bidang_model');
			$rows = $CI->Bidang_model->get_all(!$active_only);
		}
		$cache[$key] = $rows;
		return $rows;
	}
}

if (!function_exists('bidang_row')) {
	function bidang_row($kode)
	{
		$kode = resolve_bidang_kode($kode);
		if ($kode === '') {
			return null;
		}
		foreach (bidang_rows_all() as $row) {
			if ($row['kode'] === $kode) {
				return $row;
			}
		}
		return null;
	}
}

if (!function_exists('bidang_judul_display')) {
	function bidang_judul_display($kode)
	{
		$row = bidang_row($kode);
		if ($row && !empty($row['judul_halaman'])) {
			return $row['judul_halaman'];
		}
		return label_bidang($kode);
	}
}

if (!function_exists('bidang_field')) {
	function bidang_field($kode, $field, $default = '')
	{
		$row = bidang_row($kode);
		if (!$row || !isset($row[$field]) || $row[$field] === '') {
			return $default;
		}
		return $row[$field];
	}
}

if (!function_exists('layanan_bidang_kode_for_page')) {
	function layanan_bidang_kode_for_page($page = null)
	{
		static $map = null;
		if ($map === null) {
			$CI =& get_instance();
			$CI->config->load('layanan_bidang', TRUE);
			$map = $CI->config->item('layanan_bidang_map', 'layanan_bidang');
			if (!is_array($map)) {
				$map = array();
			}
		}
		if ($page === null) {
			$CI =& get_instance();
			$page = $CI->uri->segment(1);
		}
		return $map[$page] ?? null;
	}
}

if (!function_exists('resolve_bidang_kode')) {
	function resolve_bidang_kode($bidang)
	{
		$bidang = trim($bidang);
		if ($bidang === '') {
			return '';
		}

		$list = berita_bidang_list();
		if (isset($list[$bidang])) {
			return $bidang;
		}
		foreach ($list as $kode => $item) {
			$aliases = $item['aliases'] ?? array();
			if (in_array($bidang, $aliases, TRUE)) {
				return $kode;
			}
		}

		$CI =& get_instance();
		if ($CI->db->table_exists('bidang')) {
			$CI->load->model('Bidang_model');
			return $CI->Bidang_model->resolve_kode($bidang);
		}

		return $bidang;
	}
}

if (!function_exists('bidang_match_values')) {
	function bidang_match_values($kode)
	{
		$kode = resolve_bidang_kode($kode);
		if ($kode === '') {
			return array();
		}

		$CI =& get_instance();
		if ($CI->db->table_exists('bidang')) {
			$CI->load->model('Bidang_model');
			return $CI->Bidang_model->get_match_values($kode);
		}

		return array($kode);
	}
}

if (!function_exists('url_bidang')) {
	function url_bidang($bidang)
	{
		$list = berita_bidang_list();
		$kode = resolve_bidang_kode($bidang);
		if (isset($list[$kode]['url'])) {
			return site_url($list[$kode]['url']);
		}
		return '#';
	}
}

if (!function_exists('label_bidang')) {
	function label_bidang($bidang)
	{
		$list = berita_bidang_list();
		$kode = resolve_bidang_kode($bidang);
		if (isset($list[$kode]['label'])) {
			return $list[$kode]['label'];
		}
		return $bidang;
	}
}

if (!function_exists('_berita_url_allowed')) {
	function _berita_url_allowed($url)
	{
		$url = trim($url);
		if ($url === '' || $url === '#') {
			return TRUE;
		}
		if (preg_match('/^\s*(javascript|data|vbscript):/i', $url)) {
			return FALSE;
		}
		if (preg_match('#^(https?:)?//#i', $url) || preg_match('#^/#', $url)) {
			return TRUE;
		}
		return !preg_match('/[\'\"<>]/', $url);
	}
}

if (!function_exists('_sanitize_berita_unwrap_node')) {
	function _sanitize_berita_unwrap_node(DOMNode $node)
	{
		$parent = $node->parentNode;
		if (!$parent) {
			return;
		}
		while ($node->firstChild) {
			$parent->insertBefore($node->firstChild, $node);
		}
		$parent->removeChild($node);
	}
}

if (!function_exists('_sanitize_berita_walk')) {
	function _sanitize_berita_walk(DOMNode $node, array $allowed)
	{
		if ($node->nodeType === XML_ELEMENT_NODE) {
			$tag = strtolower($node->nodeName);
			if (!isset($allowed[$tag])) {
				_sanitize_berita_unwrap_node($node);
				return;
			}

			if ($node->hasAttributes()) {
				$to_remove = array();
				foreach ($node->attributes as $attr) {
					$name = strtolower($attr->name);
					$tag_allow = $allowed[$tag];
					if (!in_array($name, $tag_allow, TRUE)) {
						$to_remove[] = $name;
						continue;
					}
					if (($name === 'href' || $name === 'src') && !_berita_url_allowed($attr->value)) {
						$to_remove[] = $name;
					}
					if ($name === 'target' && $attr->value !== '_blank') {
						$to_remove[] = $name;
					}
				}
				foreach ($to_remove as $name) {
					$node->removeAttribute($name);
				}
				if ($tag === 'a' && $node->hasAttribute('target') && $node->getAttribute('target') === '_blank') {
					$node->setAttribute('rel', 'noopener noreferrer');
				}
			}
		}

		if (!$node->hasChildNodes()) {
			return;
		}

		$children = array();
		foreach ($node->childNodes as $child) {
			$children[] = $child;
		}
		foreach ($children as $child) {
			_sanitize_berita_walk($child, $allowed);
		}
	}
}

if (!function_exists('sanitize_html_berita')) {
	function sanitize_html_berita($html)
	{
		if ($html === null) {
			return '';
		}
		$html = trim($html);
		if ($html === '') {
			return '';
		}

		$allowed = array(
			'p' => array('class'),
			'br' => array(),
			'strong' => array(), 'b' => array(), 'em' => array(), 'i' => array(),
			'u' => array(), 's' => array(), 'strike' => array(),
			'ul' => array('class'), 'ol' => array('class'), 'li' => array('class'),
			'a' => array('href', 'title', 'target', 'rel', 'class'),
			'h1' => array('class'), 'h2' => array('class'), 'h3' => array('class'), 'h4' => array('class'),
			'blockquote' => array('class'),
			'img' => array('src', 'alt', 'title', 'width', 'height', 'class'),
			'table' => array('class'), 'thead' => array('class'), 'tbody' => array('class'),
			'tr' => array('class'), 'th' => array('colspan', 'rowspan', 'class'),
			'td' => array('colspan', 'rowspan', 'class'),
			'hr' => array(), 'span' => array('class'), 'div' => array('class'),
			'sub' => array(), 'sup' => array(),
		);

		$doc = new DOMDocument('1.0', 'UTF-8');
		libxml_use_internal_errors(TRUE);
		$loaded = $doc->loadHTML(
			'<?xml encoding="utf-8" ?><div id="berita-root">' . $html . '</div>',
			LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
		);
		libxml_clear_errors();

		if (!$loaded) {
			return htmlspecialchars(strip_tags($html), ENT_QUOTES, 'UTF-8');
		}

		$root = $doc->getElementById('berita-root');
		if (!$root) {
			return htmlspecialchars(strip_tags($html), ENT_QUOTES, 'UTF-8');
		}

		_sanitize_berita_walk($root, $allowed);

		$out = '';
		foreach ($root->childNodes as $child) {
			$out .= $doc->saveHTML($child);
		}
		return $out;
	}
}

if (!function_exists('berita_gambar_relpath')) {
	function berita_gambar_relpath($filename = '', $content = FALSE)
	{
		$path = 'assets/images/blog/';
		if ($content) {
			$path .= 'content/';
		}
		if ($filename !== '') {
			$path .= ltrim($filename, '/');
		}
		return $path;
	}
}

if (!function_exists('fcpath_gambar_berita')) {
	function fcpath_gambar_berita($filename = '', $content = FALSE)
	{
		return FCPATH . berita_gambar_relpath($filename, $content);
	}
}

if (!function_exists('url_gambar_berita')) {
	function url_gambar_berita($filename, $content = FALSE)
	{
		return base_url(berita_gambar_relpath($filename, $content));
	}
}

if (!function_exists('url_gambar_berita_featured')) {
	function url_gambar_berita_featured($filename)
	{
		if (!empty($filename) && is_file(fcpath_gambar_berita($filename))) {
			return url_gambar_berita($filename);
		}
		return url_gambar_berita('pelantikankadis.jpg');
	}
}

if (!function_exists('_berita_extract_gambar_relpath')) {
	function _berita_extract_gambar_relpath($src)
	{
		if (preg_match('~(assets/images/blog/(?:content/)?[^?\s#"\'>]+)~i', $src, $m)) {
			return $m[1];
		}
		return null;
	}
}

if (!function_exists('_berita_resolve_img_src')) {
	function _berita_resolve_img_src($src, $for_storage)
	{
		$src = trim($src);
		if ($src === '') {
			return $src;
		}

		$relpath = _berita_extract_gambar_relpath($src);
		if ($relpath === null) {
			return $src;
		}

		return $for_storage ? $relpath : base_url($relpath);
	}
}

if (!function_exists('_normalize_berita_html_images')) {
	function _normalize_berita_html_images($html, $for_storage)
	{
		if ($html === null) {
			return '';
		}
		$html = trim($html);
		if ($html === '') {
			return '';
		}

		$doc = new DOMDocument('1.0', 'UTF-8');
		libxml_use_internal_errors(TRUE);
		$loaded = $doc->loadHTML(
			'<?xml encoding="utf-8" ?><div id="berita-root">' . $html . '</div>',
			LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
		);
		libxml_clear_errors();

		if (!$loaded) {
			return $html;
		}

		$root = $doc->getElementById('berita-root');
		if (!$root) {
			return $html;
		}

		$images = $root->getElementsByTagName('img');
		for ($i = $images->length - 1; $i >= 0; $i--) {
			$img = $images->item($i);
			if (!$img->hasAttribute('src')) {
				continue;
			}
			$resolved = _berita_resolve_img_src($img->getAttribute('src'), $for_storage);
			$img->setAttribute('src', $resolved);
		}

		$out = '';
		foreach ($root->childNodes as $child) {
			$out .= $doc->saveHTML($child);
		}
		return $out;
	}
}

if (!function_exists('normalize_berita_html_images_for_storage')) {
	function normalize_berita_html_images_for_storage($html)
	{
		return _normalize_berita_html_images($html, TRUE);
	}
}

if (!function_exists('normalize_berita_html_images_for_display')) {
	function normalize_berita_html_images_for_display($html)
	{
		return _normalize_berita_html_images($html, FALSE);
	}
}

if (!function_exists('prepare_isi_berita_for_editor')) {
	function prepare_isi_berita_for_editor($html)
	{
		return normalize_berita_html_images_for_display($html);
	}
}

if (!function_exists('render_isi_berita')) {
	function render_isi_berita($html)
	{
		return normalize_berita_html_images_for_display(sanitize_html_berita($html));
	}
}
