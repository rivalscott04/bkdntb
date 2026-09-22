<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
$layanan_items = $layanan_list ?? array();
$layanan_total = count($layanan_items);
$layanan_limit = isset($layanan_limit) ? (int) $layanan_limit : 5;
if ($layanan_limit < 1) {
	$layanan_limit = 5;
}
$layanan_preview = array_slice($layanan_items, 0, $layanan_limit);
$judul = !empty($bidang['layanan_judul'])
	? $bidang['layanan_judul']
	: ('Layanan ' . ($bidang['label'] ?? ''));
$more_url = bidang_sop_list_url($bidang ?? array());
?>
<?php if (!empty($layanan_preview)): ?>
<div class="single-sidebar">
    <div class="title">
        <h5><?php echo html_escape($judul); ?></h5>
    </div><br>
    <ul class="service-pages">
        <?php foreach ($layanan_preview as $item): ?>
            <?php
            $label = $item['judul'] ?? '';
            $overlay = !empty($item['judul_overlay']) ? $item['judul_overlay'] : $label;
            $href = bidang_layanan_href($item['url'] ?? '#');
            $is_sop_link = false;
            if (($href === '#' || $href === '') && !empty($item['sop_file'])) {
                $href = bidang_layanan_sop_url($item['sop_file']);
                $is_sop_link = true;
            }
            ?>
            <li>
                <a href="<?php echo html_escape($href); ?>"<?php echo $is_sop_link ? ' target="_blank" rel="noopener"' : ''; ?>>
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
    <?php if ($layanan_total > $layanan_limit && $more_url !== ''): ?>
        <p class="text-center" style="margin-top: 12px; margin-bottom: 0;">
            <a href="<?php echo html_escape($more_url); ?>">Lihat lebih banyak</a>
        </p>
    <?php endif; ?>
</div>
<?php endif; ?>
