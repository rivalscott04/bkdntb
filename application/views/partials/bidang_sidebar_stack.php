<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
/**
 * Stack sidebar halaman bidang (hierarki jelas, tanpa dobel):
 * kepala → video layanan → menu layanan → dokumen SOP → dokumen pendukung.
 */
$show_pergub = isset($show_pergub) ? (bool) $show_pergub : TRUE;
?>
<?php $this->load->view('partials/bidang_sidebar_kepala', array('bidang' => $bidang ?? array())); ?>

<?php $this->load->view('partials/bidang_sidebar_video', array(
	'bidang' => $bidang ?? array(),
)); ?>

<?php $this->load->view('partials/bidang_sidebar_layanan', array(
	'bidang' => $bidang ?? array(),
	'layanan_list' => $layanan_list ?? array(),
	'layanan_limit' => $layanan_limit ?? 5,
)); ?>

<?php $this->load->view('partials/bidang_sidebar_sop', array(
	'bidang' => $bidang ?? array(),
	'sop_list' => $sop_list ?? array(),
	'sop_total' => $sop_total ?? 0,
	'sop_limit' => $sop_limit ?? 5,
)); ?>

<?php if ($show_pergub): ?>
<div class="single-sidebar bidang-sidebar-block">
    <div class="title">
        <h5>Dokumen Pendukung</h5>
    </div>
    <p class="bidang-sidebar-lead">Referensi tupoksi bidang.</p>
    <ul class="service-pack-download">
        <li class="clearfix">
            <div class="title-holder">
                <a href="<?php echo base_url('assets/download/Pergub 42 Tahun 2017.pdf'); ?>">
                    Tugas Pokok &amp; Fungsi <span>(307 kb)</span>
                </a>
            </div>
            <div class="icon-holder">
                <i class="fa fa-download" aria-hidden="true"></i>
            </div>
        </li>
    </ul>
</div>
<?php endif; ?>
