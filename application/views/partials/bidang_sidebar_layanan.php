<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
$layanan_items = $layanan_list ?? array();
$judul = !empty($bidang['layanan_judul'])
	? $bidang['layanan_judul']
	: ('Layanan ' . ($bidang['label'] ?? ''));
?>
<?php if (!empty($layanan_items)): ?>
<div class="single-sidebar">
    <div class="title">
        <h5><?php echo html_escape($judul); ?></h5>
    </div><br>
    <ul class="service-pages">
        <?php foreach ($layanan_items as $item): ?>
            <?php
            $label = $item['judul'] ?? '';
            $overlay = !empty($item['judul_overlay']) ? $item['judul_overlay'] : $label;
            $href = bidang_layanan_href($item['url'] ?? '#');
            if (($href === '#' || $href === '') && !empty($item['sop_file'])) {
                $href = bidang_layanan_sop_url($item['sop_file']);
            }
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
