<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="sec-title">
    <p>Agenda Kepala Badan</p>
    <div class="title"><?php echo isset($agenda) ? 'Edit Agenda' : 'Tambah Agenda'; ?></div>
</div>

<div class="contact-form">
    <div class="inner-box">
        <?php echo form_open_multipart('admin/agenda/simpan'); ?>
            <?php if (isset($agenda)): ?>
                <input type="hidden" name="id" value="<?php echo (int) $agenda['id']; ?>">
            <?php endif; ?>

            <div class="row">
                <div class="col-md-4">
                    <div class="admin-field">
                        <label>Tanggal <span class="required">*</span></label>
                        <div class="input-box">
                            <input type="date" name="tanggal" required
                                   value="<?php echo html_escape($agenda['tanggal'] ?? date('Y-m-d')); ?>">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="admin-field">
                        <label>Waktu mulai (WITA)</label>
                        <div class="input-box">
                            <input type="time" name="waktu_mulai"
                                   value="<?php echo html_escape(substr($agenda['waktu_mulai'] ?? '', 0, 5)); ?>">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="admin-field">
                        <label>Waktu selesai (WITA)</label>
                        <div class="input-box">
                            <input type="time" name="waktu_selesai"
                                   value="<?php echo html_escape(substr($agenda['waktu_selesai'] ?? '', 0, 5)); ?>">
                        </div>
                        <p class="admin-muted">Opsional. Kosongkan jika hanya jam mulai.</p>
                    </div>
                </div>
            </div>

            <div class="admin-field">
                <label>Asal Surat/Undangan</label>
                <div class="input-box">
                    <input type="text" name="asal_surat" maxlength="255"
                           value="<?php echo html_escape($agenda['asal_surat'] ?? ''); ?>"
                           placeholder="Dinas Perhubungan NTB">
                </div>
            </div>

            <div class="admin-field">
                <label>Agenda Kegiatan <span class="required">*</span></label>
                <div class="input-box">
                    <textarea name="kegiatan" rows="3" required maxlength="500"
                              placeholder="Memimpin Apel Pagi di Dinas Perhubungan Provinsi NTB"><?php echo html_escape($agenda['kegiatan'] ?? ''); ?></textarea>
                </div>
            </div>

            <div class="admin-field">
                <label>Tempat</label>
                <div class="input-box">
                    <input type="text" name="tempat" maxlength="255"
                           value="<?php echo html_escape($agenda['tempat'] ?? ''); ?>"
                           placeholder="Kantor Gubernur NTB">
                </div>
            </div>

            <div class="admin-field">
                <label>Keterangan</label>
                <div class="input-box">
                    <input type="text" name="keterangan" maxlength="500"
                           value="<?php echo html_escape($agenda['keterangan'] ?? ''); ?>"
                           placeholder="Diwakili oleh Kepala Bidang Pengembangan">
                </div>
            </div>

            <div class="admin-field">
                <label>Surat/Undangan (gambar atau PDF)</label>
                <div class="input-box">
                    <input type="file" name="surat_file" accept=".jpg,.jpeg,.png,.pdf,image/jpeg,image/png,application/pdf">
                </div>
                <p class="admin-muted">
                    JPG, PNG, atau PDF, maksimal 5 MB. Di halaman publik, tombol waktu akan membuka surat ini di tab baru.
                    <?php if (!empty($agenda['surat_file'])): ?>
                        Surat saat ini:
                        <a href="<?php echo html_escape(agenda_surat_url($agenda['surat_file'])); ?>" target="_blank" rel="noopener">lihat surat</a>.
                        Pilih file baru untuk mengganti.
                    <?php endif; ?>
                </p>
                <?php if (!empty($agenda['surat_file'])): ?>
                    <div class="input-box admin-checkbox-wrap">
                        <label class="admin-checkbox">
                            <input type="checkbox" name="hapus_surat" value="1">
                            Hapus surat saat disimpan
                        </label>
                    </div>
                <?php endif; ?>
            </div>

            <div class="admin-field">
                <label>Status</label>
                <div class="input-box admin-checkbox-wrap">
                    <label class="admin-checkbox">
                        <input type="checkbox" name="aktif" value="1"
                            <?php echo (!isset($agenda) || (int) $agenda['aktif'] === 1) ? 'checked' : ''; ?>>
                        Tampil di website
                    </label>
                </div>
            </div>

            <div class="admin-actions">
                <button type="submit" class="btn-one">Simpan<span class="flaticon-next"></span></button>
                <a href="<?php echo site_url('admin/agenda'); ?>" class="admin-btn-secondary">Batal</a>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>
