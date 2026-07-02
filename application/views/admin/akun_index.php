<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="sec-title">
    <p>Pengaturan</p>
    <div class="title">Ubah Username & Password</div>
</div>

<div class="contact-form">
    <div class="inner-box">
        <?php echo form_open('admin/akun/simpan'); ?>
            <div class="admin-field">
                <label>Nama <span class="required">*</span></label>
                <div class="input-box">
                    <input type="text" name="nama" required maxlength="100"
                           value="<?php echo html_escape($user['nama']); ?>">
                </div>
            </div>

            <div class="admin-field">
                <label>Username <span class="required">*</span></label>
                <div class="input-box">
                    <input type="text" name="username" required maxlength="50" autocomplete="username"
                           value="<?php echo html_escape($user['username']); ?>">
                </div>
                <p class="admin-muted">Huruf, angka, titik, strip, dan underscore.</p>
            </div>

            <div class="admin-field">
                <label>Password Lama <span class="required">*</span></label>
                <div class="input-box">
                    <input type="password" name="password_lama" required autocomplete="current-password">
                </div>
                <p class="admin-muted">Wajib diisi untuk menyimpan perubahan.</p>
            </div>

            <div class="admin-field">
                <label>Password Baru</label>
                <div class="input-box">
                    <input type="password" name="password_baru" minlength="6" autocomplete="new-password">
                </div>
                <p class="admin-muted">Kosongkan jika tidak ingin mengganti. Minimal 6 karakter, wajib ada huruf, angka, dan karakter khusus (mis. !@#$).</p>
            </div>

            <div class="admin-field">
                <label>Konfirmasi Password Baru</label>
                <div class="input-box">
                    <input type="password" name="password_konfirmasi" minlength="6" autocomplete="new-password">
                </div>
            </div>

            <div class="admin-actions">
                <button type="submit" class="btn-one">Simpan Perubahan<span class="flaticon-next"></span></button>
                <a href="<?php echo site_url('admin/berita'); ?>" class="admin-btn-secondary">Batal</a>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>
