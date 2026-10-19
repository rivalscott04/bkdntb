<?php
define('BASEPATH', dirname(__DIR__) . '/system/');
require dirname(__DIR__) . '/application/helpers/pengunjung_helper.php';

function cek($label, $ok)
{
	if ($ok) {
		return;
	}
	fwrite(STDERR, "gagal: $label\n");
	exit(1);
}

$chrome = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36';
cek('ua kosong', pengunjung_ua_bot('', true, false) === true);
cek('bukan browser', pengunjung_ua_bot('curl/8.0', false, false) === true);
cek('robot', pengunjung_ua_bot('Mozilla/5.0 (compatible; Googlebot/2.1)', true, true) === true);
cek('headless', pengunjung_ua_bot('Mozilla/5.0 HeadlessChrome/120.0.0.0 Safari/537.36', true, false) === true);
cek('chrome', pengunjung_ua_bot($chrome, true, false) === false);
cek('same-origin', pengunjung_asal_valid('same-origin', '', 'bkd.ntbprov.go.id') === true);
cek('cross-site', pengunjung_asal_valid('cross-site', 'https://bkd.ntbprov.go.id/', 'bkd.ntbprov.go.id') === false);
cek('referer situs', pengunjung_asal_valid('', 'https://bkd.ntbprov.go.id/agenda', 'bkd.ntbprov.go.id') === true);
cek('referer asing', pengunjung_asal_valid('', 'https://evil.test/', 'bkd.ntbprov.go.id') === false);
cek('tanpa asal', pengunjung_asal_valid('', '', 'bkd.ntbprov.go.id') === false);

echo "ok\n";
