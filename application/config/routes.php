<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Admin CMS Berita
$route['admin'] = 'admin_login';
$route['admin/login'] = 'admin_login';
$route['admin/login/authenticate'] = 'admin_login/authenticate';
$route['admin/login/logout'] = 'admin_login/logout';
$route['admin/berita'] = 'admin_berita';
$route['admin/berita/tambah'] = 'admin_berita/tambah';
$route['admin/berita/cari'] = 'admin_berita/cari';
$route['admin/berita/simpan'] = 'admin_berita/simpan';
$route['admin/berita/hapus'] = 'admin_berita/hapus';
$route['admin/berita/upload_gambar'] = 'admin_berita/upload_gambar';
$route['admin/berita/edit/(:num)'] = 'admin_berita/edit/$1';
$route['admin/akun'] = 'admin_akun';
$route['admin/akun/simpan'] = 'admin_akun/simpan';
$route['admin_login'] = 'admin_login';
$route['admin_login/authenticate'] = 'admin_login/authenticate';
$route['admin_login/logout'] = 'admin_login/logout';
$route['admin_berita'] = 'admin_berita';
$route['admin_berita/tambah'] = 'admin_berita/tambah';
$route['admin_berita/cari'] = 'admin_berita/cari';
$route['admin_berita/simpan'] = 'admin_berita/simpan';
$route['admin_berita/hapus'] = 'admin_berita/hapus';
$route['admin_berita/upload_gambar'] = 'admin_berita/upload_gambar';
$route['admin_berita/edit/(:num)'] = 'admin_berita/edit/$1';
$route['admin_akun'] = 'admin_akun';
$route['admin_akun/simpan'] = 'admin_akun/simpan';
$route['kds'] = 'kadis';
$route['berita/(:any)'] = 'berita/detail/$1';
