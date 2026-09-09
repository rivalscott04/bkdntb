<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $sop_max_mb = $sop_max_mb ?? 2; ?>
<div class="admin-header-row">
    <div class="sec-title">
        <p>Kelola Bidang</p>
        <div class="title">Layanan: <?php echo html_escape($bidang['label']); ?></div>
    </div>
    <a class="btn-one" href="<?php echo site_url('admin/bidang/layanan_tambah/' . (int) $bidang['id']); ?>">
        Tambah Layanan<span class="flaticon-next"></span>
    </a>
</div>

<p class="admin-muted" style="margin-bottom: 1.5rem;">
    Item ini tampil di sidebar halaman bidang
    (<a href="<?php echo site_url($bidang['url_slug']); ?>" target="_blank">/<?php echo html_escape($bidang['url_slug']); ?></a>).
    Judul blok sidebar diatur di Edit Bidang (Judul Layanan).
    Upload SOP PDF maksimal <?php echo html_escape($sop_max_mb); ?> MB
    (<a href="<?php echo site_url('admin/pengaturan'); ?>">ubah di Pengaturan</a>).
</p>

<div class="admin-actions" style="margin-bottom: 1rem;">
    <a href="<?php echo site_url('admin/bidang'); ?>" class="admin-btn-secondary">Kembali ke Daftar Bidang</a>
    <a href="<?php echo site_url('admin/bidang/edit/' . (int) $bidang['id']); ?>" class="admin-btn-secondary">Edit Bidang</a>
</div>

<div class="admin-table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Urutan</th>
                <th>Judul</th>
                <th>URL</th>
                <th>SOP</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($layanan_list)): ?>
                <tr>
                    <td colspan="6" class="text-center">Belum ada layanan untuk bidang ini.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($layanan_list as $item): ?>
                    <tr>
                        <td><?php echo (int) $item['urutan']; ?></td>
                        <td><?php echo html_escape($item['judul']); ?></td>
                        <td><code><?php echo html_escape($item['url']); ?></code></td>
                        <td>
                            <?php if (!empty($item['sop_file'])): ?>
                                <a href="<?php echo html_escape(bidang_layanan_sop_url($item['sop_file'])); ?>" target="_blank" rel="noopener">PDF</a>
                            <?php else: ?>
                                <span class="admin-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ((int) $item['aktif'] === 1): ?>
                                <span class="admin-badge admin-badge-published">Aktif</span>
                            <?php else: ?>
                                <span class="admin-badge admin-badge-draft">Nonaktif</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="admin-action-group">
                                <a href="<?php echo site_url('admin/bidang/layanan_edit/' . $item['id']); ?>" class="btn-one">Edit</a>
                                <?php echo form_open('admin/bidang/layanan_hapus', array(
                                    'class' => 'admin-inline-form',
                                    'onsubmit' => "return confirm('Hapus layanan ini?');",
                                )); ?>
                                    <input type="hidden" name="id" value="<?php echo (int) $item['id']; ?>">
                                    <button type="submit" class="btn-one danger">Hapus</button>
                                <?php echo form_close(); ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
