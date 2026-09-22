<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
$has_kepala = !empty($bidang['kepala_nama']);
$raw_video = trim((string) ($bidang['video_youtube'] ?? ''));
$embed = ($raw_video !== '' && function_exists('youtube_embed_src'))
	? youtube_embed_src($raw_video)
	: '';
?>
<?php if ($has_kepala): ?>
<div class="sidebar-contact-box text-center">
    <div class="inner-content">
        <?php if (!empty($bidang['kepala_foto'])): ?>
            <img src="<?php echo base_url('assets/' . ltrim($bidang['kepala_foto'], '/')); ?>" alt="<?php echo html_escape($bidang['kepala_judul'] ?? $bidang['label'] ?? ''); ?>">
        <?php endif; ?>
        <div class="bottom-box">
            <?php if (!empty($bidang['kepala_judul'])): ?>
                <h3><?php echo html_escape($bidang['kepala_judul']); ?></h3>
            <?php endif; ?>
            <span><?php echo html_escape($bidang['kepala_nama']); ?></span><br>
            <?php if (!empty($bidang['kepala_nip'])): ?>
                <span>NIP. <?php echo html_escape($bidang['kepala_nip']); ?></span>
            <?php endif; ?>
        </div>
        <div class="button">
            <a class="btn-one wow slideInUp" data-wow-delay="0ms" data-wow-duration="1500ms" href="<?php echo site_url('lhkpn'); ?>">Informasi LHKPN
                <span class="flaticon-next"></span>
            </a>
        </div>
    </div>
</div>
<?php endif; ?>

<?php if ($embed !== ''): ?>
<div class="single-sidebar bidang-sidebar-block bidang-sidebar-video<?php echo $has_kepala ? ' bidang-sidebar-video--after-kepala' : ''; ?>">
    <div class="title">
        <h5>Video Layanan</h5>
    </div>
    <p class="bidang-sidebar-lead">Cuplikan singkat layanan bidang ini.</p>
    <div class="bidang-sidebar-video-frame">
        <iframe
            src="<?php echo html_escape($embed); ?>"
            title="Video layanan"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            allowfullscreen
            loading="lazy"
            referrerpolicy="strict-origin-when-cross-origin"></iframe>
    </div>
</div>
<?php endif; ?>
