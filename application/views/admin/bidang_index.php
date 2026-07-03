<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="admin-header-row">
    <div class="sec-title">
        <p>Pengaturan</p>
        <div class="title">Daftar Bidang</div>
    </div>
    <a class="btn-one" href="<?php echo site_url('admin/bidang/tambah'); ?>">Tambah Bidang<span class="flaticon-next"></span></a>
</div>

<p class="admin-muted" style="margin-bottom: 1.5rem;">
    Nama bidang yang ditampilkan di menu website dan dropdown berita dikelola di sini.
</p>

<div class="admin-table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Urutan</th>
                <th>Kode</th>
                <th>Nama Tampilan</th>
                <th>URL</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($bidang_list)): ?>
                <tr>
                    <td colspan="6" class="text-center">Belum ada data bidang.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($bidang_list as $item): ?>
                    <tr>
                        <td><?php echo (int) $item['urutan']; ?></td>
                        <td><code><?php echo html_escape($item['kode']); ?></code></td>
                        <td><?php echo html_escape($item['label']); ?></td>
                        <td>/<?php echo html_escape($item['url_slug']); ?></td>
                        <td>
                            <?php if ((int) $item['aktif'] === 1): ?>
                                <span class="admin-badge admin-badge-published">Aktif</span>
                            <?php else: ?>
                                <span class="admin-badge admin-badge-draft">Nonaktif</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="admin-action-group">
                                <a href="<?php echo site_url('admin/bidang/edit/' . $item['id']); ?>" class="btn-one">Edit</a>
                                <?php echo form_open('admin/bidang/hapus', array(
                                    'class' => 'admin-inline-form',
                                    'onsubmit' => "return confirm('Hapus bidang ini?');",
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
