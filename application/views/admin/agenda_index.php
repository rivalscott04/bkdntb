<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="admin-header-row">
    <div class="sec-title">
        <p>Kepala Badan</p>
        <div class="title">Agenda Kegiatan</div>
    </div>
    <a class="btn-one" href="<?php echo site_url('admin/agenda/tambah'); ?>">Tambah Agenda<span class="flaticon-next"></span></a>
</div>

<p class="admin-muted" style="margin-bottom: 1.5rem;">
    Agenda aktif tampil di <a href="<?php echo site_url('agenda'); ?>" target="_blank">/agenda</a>.
    Halaman pertama berisi minggu ini dan agenda mendatang, halaman berikutnya berisi minggu sebelumnya.
</p>

<div class="admin-table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Hari/Tanggal</th>
                <th>Waktu</th>
                <th>Asal Surat</th>
                <th>Agenda Kegiatan</th>
                <th>Tempat</th>
                <th>Keterangan</th>
                <th>Surat</th>
                <th>Foto</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($agenda_list)): ?>
                <tr>
                    <td colspan="10" class="text-center">Belum ada agenda.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($agenda_list as $item): ?>
                    <tr>
                        <td style="white-space: nowrap;"><?php echo html_escape(agenda_hari_tanggal($item['tanggal'])); ?></td>
                        <td style="white-space: nowrap;"><?php echo html_escape(agenda_waktu($item)) ?: '<span class="admin-muted">-</span>'; ?></td>
                        <td><?php echo html_escape($item['asal_surat'] ?? ''); ?></td>
                        <td><?php echo html_escape($item['kegiatan']); ?></td>
                        <td><?php echo html_escape($item['tempat'] ?? ''); ?></td>
                        <td><?php echo html_escape($item['keterangan'] ?? ''); ?></td>
                        <td>
                            <?php if (!empty($item['surat_file'])): ?>
                                <a href="<?php echo html_escape(agenda_surat_url($item['surat_file'])); ?>" target="_blank" rel="noopener">Lihat</a>
                            <?php else: ?>
                                <span class="admin-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($item['foto_file'])): ?>
                                <a href="<?php echo html_escape(agenda_surat_url($item['foto_file'])); ?>" target="_blank" rel="noopener">Lihat</a>
                            <?php else: ?>
                                <span class="admin-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ((int) $item['aktif'] === 1): ?>
                                <span class="admin-badge admin-badge-published">Tampil</span>
                            <?php else: ?>
                                <span class="admin-badge admin-badge-draft">Disembunyikan</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="admin-action-group">
                                <a href="<?php echo site_url('admin/agenda/edit/' . (int) $item['id']); ?>" class="btn-one">Edit</a>
                                <?php echo form_open('admin/agenda/hapus', array(
                                    'class' => 'admin-inline-form',
                                    'onsubmit' => "return confirm('Hapus agenda ini?');",
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

<?php if ($pagination): ?>
    <nav style="margin-top: 1.5rem;"><?php echo $pagination; ?></nav>
<?php endif; ?>
