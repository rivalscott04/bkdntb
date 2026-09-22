<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
$raw = trim((string) ($bidang['video_youtube'] ?? ''));
$embed = $raw !== '' ? youtube_embed_src($raw) : '';
?>
<?php if ($embed !== ''): ?>
<div class="single-sidebar bidang-sidebar-block bidang-sidebar-video">
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
