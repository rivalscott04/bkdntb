$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Admin CMS Berita — controller di root (bukan folder admin/) agar kompatibel nginx/Plesk
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
$route['kds'] = 'kadis';
$route['berita/(:any)'] = 'berita/detail/$1';
