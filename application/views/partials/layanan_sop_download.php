<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
$this->load->helper('berita');
$layanan = $layanan ?? bidang_layanan_for_page();
$sop_file = $layanan['sop_file'] ?? '';
$sop_url = $sop_file !== '' ? bidang_layanan_sop_url($sop_file) : '';
$label = $download_label ?? 'Unduh SOP Pelayanan';
?>
<div class="single-sidebar">
    <ul class="service-pack-download">
        <li class="clearfix">
            <div class="title-holder">
                <?php if ($sop_url !== ''): ?>
                    <a href="<?php echo html_escape($sop_url); ?>" target="_blank" rel="noopener">
                        <?php echo html_escape($label); ?> <span>(PDF)</span>
                    </a>
                <?php else: ?>
                    <a href="#"><?php echo html_escape($label); ?> <span>(PDF)</span></a>
                <?php endif; ?>
            </div>
            <div class="icon-holder">
                <i class="fa fa-download" aria-hidden="true"></i>
            </div>
        </li>
    </ul>
</div>
