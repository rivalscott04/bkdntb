<?php
/**
 * Router for PHP built-in server: serve static files, route the rest to CodeIgniter.
 *
 * Usage: php -S 127.0.0.1:8765 router.php
 */
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

if ($uri !== '/' && is_file(__DIR__ . $uri)) {
	return false;
}

require __DIR__ . '/index.php';
