<?php
/**
 * Cek environment server setelah deploy.
 * Usage: php scripts/check_env.php
 */
require_once __DIR__ . '/lib/db_config.php';

$ok = true;

function line($status, $message)
{
	global $ok;
	$icon = $status ? '[OK]' : '[FAIL]';
	if (!$status) {
		$ok = false;
	}
	echo $icon . ' ' . $message . PHP_EOL;
}

echo "=== BKD CMS Environment Check ===" . PHP_EOL . PHP_EOL;

line(version_compare(PHP_VERSION, '7.4', '>='), 'PHP ' . PHP_VERSION . ' (min 7.4)');
line(extension_loaded('mysqli'), 'Ekstensi mysqli');
line(extension_loaded('mbstring'), 'Ekstensi mbstring');
line(extension_loaded('dom'), 'Ekstensi dom');

$configFile = db_project_root() . '/application/config/database.php';
line(is_file($configFile), 'File application/config/database.php ada');

if (is_file($configFile)) {
	try {
		$config = db_load_config();
		line(!empty($config['database']), 'Nama database terisi: ' . ($config['database'] ?? '(kosong)'));
		$mysqli = db_connect($config, true);
		line(true, 'Koneksi database berhasil ke `' . $config['database'] . '`');
		$tables = array('berita', 'user', '_migrations');
		foreach ($tables as $table) {
			$res = $mysqli->query("SHOW TABLES LIKE '" . $mysqli->real_escape_string($table) . "'");
			line($res && $res->num_rows > 0, "Tabel `{$table}` ada");
			if ($res) {
				$res->free();
			}
		}
		$mysqli->close();
	} catch (Throwable $e) {
		line(false, 'Koneksi database gagal: ' . $e->getMessage());
	}
} else {
	line(false, 'Salin dulu: cp application/config/database.php.example application/config/database.php');
}

$cacheDir = db_project_root() . '/application/cache';
$logsDir = db_project_root() . '/application/logs';
line(is_dir($cacheDir) && is_writable($cacheDir), 'Folder application/cache writable');
line(is_dir($logsDir) && is_writable($logsDir), 'Folder application/logs writable');

$uploadDir = db_project_root() . '/assets/images/blog';
line(is_dir($uploadDir) && is_writable($uploadDir), 'Folder assets/images/blog writable');

echo PHP_EOL;
if ($ok) {
	echo "Semua cek lulus. Kalau masih 500, cek Apache error_log." . PHP_EOL;
	exit(0);
}

echo "Ada masalah di atas. Perbaiki dulu, lalu reload halaman." . PHP_EOL;
exit(1);
