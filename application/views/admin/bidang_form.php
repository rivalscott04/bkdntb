<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="sec-title">
    <p>Pengaturan</p>
    <div class="title"><?php echo isset($bidang) ? 'Edit Bidang' : 'Tambah Bidang'; ?></div>
</div>

<div class="contact-form">
    <div class="inner-box">
        <?php echo form_open('admin/bidang/simpan'); ?>
            <?php if (isset($bidang)): ?>
                <input type="hidden" name="id" value="<?php echo (int) $bidang['id']; ?>">
            <?php endif; ?>

            <div class="admin-field">
                <label>Kode Bidang <span class="required">*</span></label>
                <div class="input-box">
                    <input type="text" name="kode" required maxlength="100"
                           value="<?php echo html_escape($bidang['kode'] ?? ''); ?>">
                </div>
                <p class="admin-muted">
                    Identifier internal. Berita terhubung lewat ID bidang, jadi kode/nama tampilan bisa diubah tanpa kehilangan berita.
                    <?php if (!empty($berita_count)): ?>
                        Bidang ini memiliki <?php echo (int) $berita_count; ?> berita.
                    <?php endif; ?>
                </p>
            </div>

            <div class="admin-field">
                <label>Nama Tampilan <span class="required">*</span></label>
                <div class="input-box">
                    <input type="text" name="label" required maxlength="255"
                           value="<?php echo html_escape($bidang['label'] ?? ''); ?>"
                           placeholder="Contoh: Pengadaan, Pemberhentian & Informasi (PPI)">
                </div>
                <p class="admin-muted">Nama yang tampil di menu website dan label berita.</p>
            </div>

            <div class="admin-field">
                <label>Alias / Kode Lama</label>
                <div class="input-box">
                    <input type="text" name="aliases" maxlength="500"
                           value="<?php echo html_escape($bidang['aliases'] ?? ''); ?>"
                           placeholder="PKAP, Penilaian Kinerja Aparatur dan Penghargaan">
                </div>
                <p class="admin-muted">Kode bidang lama di data berita, pisahkan dengan koma. Dipakai agar berita lama tetap muncul di halaman bidang.</p>
            </div>

            <div class="sec-title" style="margin-top: 2rem;">
                <p>Halaman Website</p>
                <div class="title" style="font-size: 22px;">Konten Halaman Bidang</div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="admin-field">
                        <label>Judul Halaman (H1)</label>
                        <div class="input-box">
                            <input type="text" name="judul_halaman" maxlength="255"
                                   value="<?php echo html_escape($bidang['judul_halaman'] ?? ''); ?>"
                                   placeholder="Bidang PPI">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="admin-field">
                        <label>Subjudul</label>
                        <div class="input-box">
                            <input type="text" name="subjudul" maxlength="255"
                                   value="<?php echo html_escape($bidang['subjudul'] ?? ''); ?>"
                                   placeholder="(Pengadaan, Pemberhentian & Informasi)">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="admin-field">
                        <label>Judul Kepala Bidang</label>
                        <div class="input-box">
                            <input type="text" name="kepala_judul" maxlength="255"
                                   value="<?php echo html_escape($bidang['kepala_judul'] ?? ''); ?>"
                                   placeholder="Kepala Bidang PPI">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="admin-field">
                        <label>Judul Layanan (sidebar)</label>
                        <div class="input-box">
                            <input type="text" name="layanan_judul" maxlength="255"
                                   value="<?php echo html_escape($bidang['layanan_judul'] ?? ''); ?>"
                                   placeholder="Layanan Bidang PPI">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="admin-field">
                        <label>Nama Kepala</label>
                        <div class="input-box">
                            <input type="text" name="kepala_nama" maxlength="255"
                                   value="<?php echo html_escape($bidang['kepala_nama'] ?? ''); ?>">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="admin-field">
                        <label>NIP Kepala</label>
                        <div class="input-box">
                            <input type="text" name="kepala_nip" maxlength="50"
                                   value="<?php echo html_escape($bidang['kepala_nip'] ?? ''); ?>">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="admin-field">
                        <label>Foto Kepala</label>
                        <div class="input-box">
                            <input type="text" name="kepala_foto" maxlength="255"
                                   value="<?php echo html_escape($bidang['kepala_foto'] ?? ''); ?>"
                                   placeholder="images/team/ppi.png">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="admin-field">
                        <label>Judul Tupoksi (opsional)</label>
                        <div class="input-box">
                            <input type="text" name="ringkasan_tugas_judul" maxlength="255"
                                   value="<?php echo html_escape($bidang['ringkasan_tugas_judul'] ?? ''); ?>"
                                   placeholder="Ringkasan Tugas - Kepala Bidang PPI">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="admin-field">
                        <label>Filter Inspirasi (class CSS)</label>
                        <div class="input-box">
                            <input type="text" name="filter_class" maxlength="50"
                                   value="<?php echo html_escape($bidang['filter_class'] ?? ''); ?>"
                                   placeholder="ppi">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="admin-field">
                        <label>URL Halaman <span class="required">*</span></label>
                        <div class="input-box">
                            <input type="text" name="url_slug" required maxlength="100"
                                   value="<?php echo html_escape($bidang['url_slug'] ?? ''); ?>"
                                   placeholder="ppi">
                        </div>
                        <p class="admin-muted">Path URL tanpa slash, mis. <code>ppi</code> → /ppi</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="admin-field">
                        <label>Urutan Menu</label>
                        <div class="input-box">
                            <input type="number" name="urutan" min="0" step="1"
                                   value="<?php echo (int) ($bidang['urutan'] ?? 0); ?>">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="admin-field">
                        <label>Status</label>
                        <div class="input-box admin-checkbox-wrap">
                            <label class="admin-checkbox">
                                <input type="checkbox" name="aktif" value="1"
                                    <?php echo (!isset($bidang) || (int) $bidang['aktif'] === 1) ? 'checked' : ''; ?>>
                                Aktif di menu
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="admin-actions">
                <button type="submit" class="btn-one">Simpan<span class="flaticon-next"></span></button>
                <a href="<?php echo site_url('admin/bidang'); ?>" class="admin-btn-secondary">Batal</a>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>
