<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
$judul_bidang = !empty($bidang['judul_halaman'])
	? $bidang['judul_halaman']
	: ($bidang['label'] ?? 'Bidang');
$sop_groups = $sop_groups ?? array();
$active_bidang_id = !empty($bidang['id']) ? (int) $bidang['id'] : 0;
$back_url = !empty($bidang['url_slug']) ? site_url($bidang['url_slug']) : site_url();

if ($active_bidang_id > 0) {
	$has_active = FALSE;
	foreach ($sop_groups as $group) {
		if ((int) ($group['bidang']['id'] ?? 0) === $active_bidang_id) {
			$has_active = TRUE;
			break;
		}
	}
	if (!$has_active && !empty($sop_groups)) {
		$active_bidang_id = (int) ($sop_groups[0]['bidang']['id'] ?? 0);
	}
} elseif (!empty($sop_groups)) {
	$active_bidang_id = (int) ($sop_groups[0]['bidang']['id'] ?? 0);
}
?>
<?php $this->load->view('partials/bidang_breadcrumb', array(
	'bidang' => array_merge($bidang ?? array(), array(
		'judul_halaman' => 'File SOP',
		'subjudul' => $judul_bidang,
	)),
)); ?>

<section id="blog-area" class="blog-large-area">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
                <div class="blog-post">
                    <div class="single-blog-post">
                        <div class="text-holder">
                            <h3>Daftar File SOP</h3>
                            <p>
                                Pilih tab bidang untuk melihat file SOP.
                                <a href="<?php echo html_escape($back_url); ?>">Kembali ke halaman bidang</a>
                            </p>
                        </div>
                    </div>

                    <?php if (empty($sop_groups)): ?>
                        <p style="margin-top: 1.5rem;">Belum ada file SOP yang diunggah.</p>
                    <?php else: ?>
                        <div class="product-tab-box tabs-box sop-file-tabs" style="margin-top: 1.5rem;">
                            <div class="tab-btns tab-buttons clearfix">
                                <?php foreach ($sop_groups as $group): ?>
                                    <?php
                                    $gid = (int) ($group['bidang']['id'] ?? 0);
                                    $glabel = $group['bidang']['label'] ?? ('Bidang ' . $gid);
                                    $is_active = ($gid === $active_bidang_id);
                                    ?>
                                    <div class="tab-btn<?php echo $is_active ? ' active-btn' : ''; ?>"
                                         data-tab="#sop-bidang-<?php echo $gid; ?>">
                                        <span><?php echo html_escape($glabel); ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <div class="tabs-content">
                                <?php foreach ($sop_groups as $group): ?>
                                    <?php
                                    $gid = (int) ($group['bidang']['id'] ?? 0);
                                    $items = $group['items'] ?? array();
                                    $is_active = ($gid === $active_bidang_id);
                                    ?>
                                    <div class="tab<?php echo $is_active ? ' active-tab' : ''; ?>"
                                         id="sop-bidang-<?php echo $gid; ?>"
                                         <?php echo $is_active ? '' : 'style="display:none;"'; ?>>
                                        <?php if (empty($items)): ?>
                                            <p>Belum ada file SOP pada bidang ini.</p>
                                        <?php else: ?>
                                            <ul class="service-pack-download">
                                                <?php foreach ($items as $item): ?>
                                                    <?php
                                                    $href = !empty($item['sop_file'])
                                                        ? bidang_layanan_sop_url($item['sop_file'])
                                                        : '#';
                                                    $size = !empty($item['sop_file'])
                                                        ? bidang_layanan_sop_size_label($item['sop_file'])
                                                        : '';
                                                    $label = $item['judul'] ?? '';
                                                    ?>
                                                    <li class="clearfix">
                                                        <div class="title-holder">
                                                            <a href="<?php echo html_escape($href); ?>"
                                                               target="_blank"
                                                               rel="noopener">
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
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-xl-4 col-lg-5 col-md-12 col-sm-12">
                <div class="single-service-sidebar">
                    <?php $this->load->view('partials/bidang_sidebar_kepala', array('bidang' => $bidang ?? array())); ?>
                    <?php $this->load->view('partials/bidang_sidebar_layanan', array(
                        'bidang' => $bidang ?? array(),
                        'layanan_list' => $layanan_list ?? array(),
                    )); ?>
                </div>
            </div>
        </div>
    </div>
</section>
