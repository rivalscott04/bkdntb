<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="sec-title">
    <p>Manajemen Konten</p>
    <div class="title"><?php echo isset($berita) ? 'Edit Berita' : 'Tambah Berita'; ?></div>
</div>

<div class="contact-form">
    <div class="inner-box">
        <?php echo form_open_multipart('admin/berita/simpan'); ?>
            <?php if (isset($berita)): ?>
                <input type="hidden" name="id" value="<?php echo (int) $berita['id']; ?>">
            <?php endif; ?>

            <div class="admin-field">
                <label>Judul Berita <span class="required">*</span></label>
                <div class="input-box">
                    <input type="text" name="judul_berita" required maxlength="255"
                           value="<?php echo html_escape($berita['judul_berita'] ?? ''); ?>">
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="admin-field">
                        <label>Bidang <span class="required">*</span></label>
                        <div class="input-box">
                            <select name="bidang" required>
                                <option value="">-- Pilih Bidang --</option>
                                <?php $selected_bidang = isset($berita) ? resolve_bidang_kode($berita['bidang']) : ''; ?>
                                <?php foreach ($bidang_list as $key => $val): ?>
                                    <option value="<?php echo html_escape($key); ?>"
                                        <?php echo ($selected_bidang === $key) ? 'selected' : ''; ?>>
                                        <?php echo html_escape($val['label']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="admin-field">
                        <label>Tanggal <span class="required">*</span></label>
                        <div class="input-box">
                            <input type="date" name="tanggal" required
                                   value="<?php echo isset($berita) ? date('Y-m-d', strtotime($berita['tanggal'])) : date('Y-m-d'); ?>">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="admin-field">
                        <label>Status</label>
                        <div class="input-box">
                            <select name="status">
                                <option value="published" <?php echo (isset($berita) && $berita['status'] === 'published') ? 'selected' : ''; ?>>Published</option>
                                <option value="draft" <?php echo (isset($berita) && $berita['status'] === 'draft') ? 'selected' : ''; ?>>Draft</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="admin-field">
                <label>Penulis</label>
                <div class="input-box">
                    <input type="text" name="penulis" maxlength="100"
                           value="<?php echo html_escape($berita['penulis'] ?? 'Admin'); ?>">
                </div>
            </div>

            <div class="admin-field">
                <label>Gambar <?php echo isset($berita) ? '' : '<span class="required">*</span>'; ?></label>
                <?php if (!empty($berita['gambar_berita'])): ?>
                    <div class="mb-2">
                        <img src="<?php echo url_gambar_berita_featured($berita['gambar_berita']); ?>" class="admin-thumb" alt="">
                        <p class="admin-muted">Upload baru untuk mengganti gambar</p>
                    </div>
                <?php endif; ?>
                <div class="input-box">
                    <input type="file" name="gambar_berita" accept="image/*"
                           <?php echo isset($berita) ? '' : 'required'; ?>>
                </div>
            </div>

            <div class="admin-field">
                <label>Narasi / Isi Berita <span class="required">*</span></label>
                <textarea name="isi_berita" class="summernote"><?php echo isset($berita['isi_berita']) ? htmlspecialchars(prepare_isi_berita_for_editor($berita['isi_berita']), ENT_QUOTES, 'UTF-8') : ''; ?></textarea>
            </div>

            <div class="admin-actions">
                <button type="submit" class="btn-one" id="berita-submit-btn">Simpan<span class="flaticon-next"></span></button>
                <a href="<?php echo site_url('admin/berita'); ?>" class="admin-btn-secondary">Batal</a>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>
