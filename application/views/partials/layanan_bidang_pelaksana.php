<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
$this->load->helper('berita');
$kode = $bidang_kode ?? layanan_bidang_kode_for_page();
$nama = $kode ? bidang_judul_display($kode) : '';
?>
<li>
    <a href="#">
        <div class="title">
            <h3 class="static">Bidang Pelaksana</h3>
            <div class="overlay-title">
                <h3><?php echo html_escape($nama); ?></h3>
            </div>
        </div>
    </a>
</li>
