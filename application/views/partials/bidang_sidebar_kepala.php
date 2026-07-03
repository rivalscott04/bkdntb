<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if (!empty($bidang['kepala_nama'])): ?>
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
