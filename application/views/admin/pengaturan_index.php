<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="sec-title">
    <p>Sistem</p>
    <div class="title">Pengaturan</div>
</div>

<div class="contact-form">
    <div class="inner-box">
        <?php echo form_open('admin/pengaturan/simpan'); ?>
            <div class="sec-title" style="margin-top: 0;">
                <p>Upload</p>
                <div class="title" style="font-size: 22px;">File SOP Layanan</div>
            </div>

            <div class="admin-field">
                <label>Ukuran maksimal file SOP (MB) <span class="required">*</span></label>
                <div class="input-box">
                    <input type="number" name="sop_max_size_mb" required min="0.1" max="50" step="0.1"
                           value="<?php echo html_escape($sop_max_size_mb); ?>">
                </div>
                <p class="admin-muted">
                    Default shared hosting: 2 MB. Sesuaikan dengan batas upload PHP server
                    (<code>upload_max_filesize</code> / <code>post_max_size</code>).
                </p>
            </div>

            <div class="admin-actions">
                <button type="submit" class="btn-one">Simpan<span class="flaticon-next"></span></button>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>
