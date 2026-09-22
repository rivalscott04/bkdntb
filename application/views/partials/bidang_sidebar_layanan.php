<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
/**
 * Menu layanan: hanya item yang punya URL halaman.
 * Item SOP murni tampil di blok Dokumen SOP.
 */
$layanan_items = bidang_layanan_filter_page_nav($layanan_list ?? array());
$layanan_total = count($layanan_items);
$layanan_limit = isset($layanan_limit) ? (int) $layanan_limit : 5;
if ($layanan_limit < 1) {
	$layanan_limit = 5;
}
$layanan_preview = array_slice($layanan_items, 0, $layanan_limit);
$judul = !empty($bidang['layanan_judul'])
	? $bidang['layanan_judul']
	: ('Menu Layanan ' . ($bidang['label'] ?? ''));
?>
<?php if (!empty($layanan_preview)): ?>
<div class="single-sidebar bidang-sidebar-block">
    <div class="title">
        <h5><?php echo html_escape($judul); ?></h5>
    </div>
    <p class="bidang-sidebar-lead">Pilih layanan untuk membuka halaman detailnya.</p>
    <ul class="service-pages">
        <?php foreach ($layanan_preview as $item): ?>
            <?php
            $label = $item['judul'] ?? '';
            $overlay = !empty($item['judul_overlay']) ? $item['judul_overlay'] : $label;
            $href = bidang_layanan_href($item['url'] ?? '#');
            ?>
            <li>
                <a href="<?php echo html_escape($href); ?>">
                    <div class="title">
                        <h3 class="static"><?php echo html_escape($label); ?></h3>
                        <div class="overlay-title">
                            <h3><?php echo html_escape($overlay); ?></h3>
                        </div>
                    </div>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>
