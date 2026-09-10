<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Rewrite /assets/... URLs in HTML to /media/... (PHP-served) so browsers
 * avoid broken/rate-limited nginx static handling on shared hosting.
 */
class Asset_url_rewrite {

	public function rewrite()
	{
		$CI =& get_instance();

		// Jangan rewrite body file static yang dilayani controller Media.
		if (isset($CI->router) && strtolower((string) $CI->router->class) === 'media') {
			$CI->output->_display();
			return;
		}

		$output = $CI->output->get_output();

		$assets = rtrim(base_url(), '/') . '/assets/';
		$media = rtrim(site_url('media'), '/') . '/';

		if ($assets !== '' && strpos($output, $assets) !== FALSE) {
			$output = str_replace($assets, $media, $output);
		}

		// Absolute paths used in some views: /assets/...
		$output = preg_replace('#([\'"])/assets/#', '$1' . $media, $output);

		$CI->output->set_output($output);
		$CI->output->_display();
	}
}
