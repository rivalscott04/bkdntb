<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $sop_max_mb = $sop_max_mb ?? 2; ?>
<div class="sec-title">
    <p>Layanan Bidang: <?php echo html_escape($bidang['label']); ?></p>
    <div class="title"><?php echo isset($layanan) ? 'Edit Layanan' : 'Tambah Layanan'; ?></div>
</div>

<div class="contact-form">
    <div class="inner-box">
        <?php echo form_open_multipart('admin/bidang/layanan_simpan'); ?>
            <input type="hidden" name="bidang_id" value="<?php echo (int) $bidang['id']; ?>">
            <?php if (isset($layanan)): ?>
                <input type="hidden" name="id" value="<?php echo (int) $layanan['id']; ?>">
            <?php endif; ?>

            <div class="admin-field">
                <label>Judul <span class="required">*</span></label>
                <div class="input-box">
                    <input type="text" name="judul" required maxlength="255"
                           value="<?php echo html_escape($layanan['judul'] ?? ''); ?>"
                           placeholder="Kenaikan Pangkat">
                </div>
            </div>

            <div class="admin-field">
                <label>Judul Overlay (hover)</label>
                <div class="input-box">
                    <input type="text" name="judul_overlay" maxlength="255"
                           value="<?php echo html_escape($layanan['judul_overlay'] ?? ''); ?>"
                           placeholder="Opsional, teks singkat saat hover">
                </div>
                <p class="admin-muted">Kosongkan jika sama dengan judul.</p>
            </div>

            <div class="admin-field">
                <label>URL halaman layanan</label>
                <div class="input-box">
                    <input type="text" name="url" maxlength="500"
                           value="<?php echo html_escape($layanan['url'] ?? '#'); ?>"
                           placeholder="/kenaikanpangkat atau https://...">
                </div>
                <p class="admin-muted">
                    Path lokal diawali slash (mis. <code>/kenaikanpangkat</code>),
                    tautan eksternal lengkap (<code>https://...</code>),
                    atau <code>#</code> jika belum ada halaman.
                </p>
            </div>

            <div class="admin-field">
                <label>File SOP (PDF)</label>
                <div class="input-box">
                    <input type="file" name="sop_file" accept=".pdf,application/pdf">
                </div>
                <p class="admin-muted">
                    Maksimal <?php echo html_escape($sop_max_mb); ?> MB (atur di
                    <a href="<?php echo site_url('admin/pengaturan'); ?>">Pengaturan</a>).
                    <?php if (!empty($layanan['sop_file'])): ?>
                        File saat ini:
                        <a href="<?php echo html_escape(bidang_layanan_sop_url($layanan['sop_file'])); ?>" target="_blank" rel="noopener">
                            <?php echo html_escape(basename($layanan['sop_file'])); ?>
                        </a>
                    <?php endif; ?>
                </p>
                <?php if (!empty($layanan['sop_file'])): ?>
                    <div class="input-box admin-checkbox-wrap" style="margin-top: 0.75rem;">
                        <label class="admin-checkbox">
                            <input type="checkbox" name="hapus_sop" value="1">
                            Hapus file SOP saat disimpan
                        </label>
                    </div>
                <?php endif; ?>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="admin-field">
                        <label>Urutan</label>
                        <div class="input-box">
                            <input type="number" name="urutan" min="0" step="1"
                                   value="<?php echo (int) ($layanan['urutan'] ?? 0); ?>">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="admin-field">
                        <label>Status</label>
                        <div class="input-box admin-checkbox-wrap">
                            <label class="admin-checkbox">
                                <input type="checkbox" name="aktif" value="1"
                                    <?php echo (!isset($layanan) || (int) $layanan['aktif'] === 1) ? 'checked' : ''; ?>>
                                Tampil di website
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="admin-actions">
                <button type="submit" class="btn-one">Simpan<span class="flaticon-next"></span></button>
                <a href="<?php echo site_url('admin/bidang/layanan/' . (int) $bidang['id']); ?>" class="admin-btn-secondary">Batal</a>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>
