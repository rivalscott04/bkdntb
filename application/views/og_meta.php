<?php
/*
 * Open Graph / Twitter meta tags for link previews (WhatsApp, Facebook, Telegram, X).
 * Override per page by passing $og_title, $og_description, $og_image (absolute URL)
 * to the header view.
 */
$og_site = 'BKD Provinsi NTB';
$og_title = !empty($og_title) ? $og_title
	: (!empty($page_title) ? $page_title . ' - ' . $og_site : 'Badan Kepegawaian Daerah Provinsi Nusa Tenggara Barat');
$og_description = !empty($og_description) ? $og_description
	: 'Situs resmi Badan Kepegawaian Daerah (BKD) Provinsi NTB. Informasi layanan kepegawaian ASN, berita, pengumuman, mutasi, kenaikan pangkat, pensiun, dan seleksi jabatan.';
$og_image = !empty($og_image) ? $og_image : base_url('assets/images/og-image.jpg');
$og_url = current_url();
?>
    <meta name="description" content="<?php echo html_escape($og_description); ?>">
    <meta property="og:type" content="<?php echo !empty($og_type) ? html_escape($og_type) : 'website'; ?>">
    <meta property="og:site_name" content="<?php echo html_escape($og_site); ?>">
    <meta property="og:locale" content="id_ID">
    <meta property="og:url" content="<?php echo html_escape($og_url); ?>">
    <meta property="og:title" content="<?php echo html_escape($og_title); ?>">
    <meta property="og:description" content="<?php echo html_escape($og_description); ?>">
    <meta property="og:image" content="<?php echo html_escape($og_image); ?>">
    <meta property="og:image:alt" content="<?php echo html_escape($og_title); ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo html_escape($og_title); ?>">
    <meta name="twitter:description" content="<?php echo html_escape($og_description); ?>">
    <meta name="twitter:image" content="<?php echo html_escape($og_image); ?>">
