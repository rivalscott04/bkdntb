<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
/**
 * Dokumen SOP: hasil upload admin tanpa URL halaman.
 * Dipisah dari Menu Layanan agar tidak dobel.
 */
$sop_items = $sop_list ?? array();
$sop_total = isset($sop_total) ? (int) $sop_total : count($sop_items);
$sop_limit = isset($sop_limit) ? (int) $sop_limit : 5;
if ($sop_limit < 1) {
	$sop_limit = 5;
}
$sop_preview = array_slice($sop_items, 0, $sop_limit);
$more_url = bidang_sop_list_url($bidang ?? array());
?>
<?php if (!empty($sop_preview)): ?>
<div class="single-sidebar bidang-sidebar-block">
    <div class="title">
        <h5>Dokumen SOP</h5>
    </div>
    <p class="bidang-sidebar-lead">Unduh file SOP layanan. Menampilkan 5 file terbaru.</p>
    <ul class="service-pack-download">
        <?php foreach ($sop_preview as $item): ?>
            <?php
            $label = $item['judul'] ?? '';
            $href = !empty($item['sop_file']) ? bidang_layanan_sop_url($item['sop_file']) : '#';
            $size = !empty($item['sop_file']) ? bidang_layanan_sop_size_label($item['sop_file']) : '';
            ?>
            <li class="clearfix">
                <div class="title-holder">
                    <a href="<?php echo html_escape($href); ?>" target="_blank" rel="noopener">
                        <?php echo html_escape($label); ?>
                        <?php if ($size !== ''): ?>
                            <span>(<?php echo html_escape($size); ?>)</span>
                        <?php endif; ?>
                    </a>
                </div>
                <div class="icon-holder">
                    <i class="fa fa-download" aria-hidden="true"></i>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
    <?php if ($sop_total > $sop_limit && $more_url !== ''): ?>
        <p class="bidang-sidebar-more">
            <a href="<?php echo html_escape($more_url); ?>">Lihat semua dokumen SOP</a>
        </p>
    <?php endif; ?>
</div>
<?php endif; ?>
