<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Serve static files under /assets via PHP.
 * Workaround for shared-hosting nginx resetting parallel /assets/* connections.
 */
class Media extends CI_Controller {

	private $allowed_ext = array(
		'css' => 'text/css; charset=UTF-8',
		'js' => 'application/javascript; charset=UTF-8',
		'map' => 'application/json',
		'png' => 'image/png',
		'jpg' => 'image/jpeg',
		'jpeg' => 'image/jpeg',
		'gif' => 'image/gif',
		'webp' => 'image/webp',
		'svg' => 'image/svg+xml',
		'ico' => 'image/x-icon',
		'woff' => 'font/woff',
		'woff2' => 'font/woff2',
		'ttf' => 'font/ttf',
		'eot' => 'application/vnd.ms-fontobject',
		'otf' => 'font/otf',
		'pdf' => 'application/pdf',
		'mp4' => 'video/mp4',
		'webm' => 'video/webm',
	);

	public function _remap($method, $params = array())
	{
		$uri = trim($this->uri->uri_string(), '/');
		$rel = $uri;
		if (strpos($rel, 'media/') === 0) {
			$rel = substr($rel, strlen('media/'));
		}
		if (strpos($rel, 'file/') === 0) {
			$rel = substr($rel, strlen('file/'));
		}
		$rel = rawurldecode($rel);
		$rel = str_replace('\\', '/', $rel);
		$rel = ltrim($rel, '/');

		if ($rel === '' || strpos($rel, '..') !== FALSE) {
			show_404();
		}

		$this->_serve($rel);
	}

	private function _serve($rel)
	{
		$ext = strtolower(pathinfo($rel, PATHINFO_EXTENSION));
		if ($ext === '' || !isset($this->allowed_ext[$ext])) {
			show_404();
		}

		$base = realpath(FCPATH . 'assets');
		$full = realpath(FCPATH . 'assets/' . $rel);
		if ($base === FALSE || $full === FALSE || strpos($full, $base) !== 0 || !is_file($full)) {
			show_404();
		}

		$mtime = filemtime($full);
		$etag = '"' . md5($full . '|' . $mtime . '|' . filesize($full)) . '"';
		$client_etag = isset($_SERVER['HTTP_IF_NONE_MATCH']) ? trim($_SERVER['HTTP_IF_NONE_MATCH']) : '';
		if ($client_etag === $etag) {
			$this->output->set_status_header(304);
			$this->output->_display();
			return;
		}

		$this->output
			->set_header('Content-Type: ' . $this->allowed_ext[$ext])
			->set_header('Content-Length: ' . filesize($full))
			->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $mtime) . ' GMT')
			->set_header('ETag: ' . $etag)
			->set_header('Cache-Control: public, max-age=86400')
			->set_header('X-Content-Type-Options: nosniff')
			->set_output(file_get_contents($full));
	}
}
