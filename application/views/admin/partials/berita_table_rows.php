<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if (empty($berita_list)): ?>
    <tr><td colspan="6" class="text-center admin-muted" style="padding: 40px;">Tidak ada berita ditemukan.</td></tr>
<?php else: foreach ($berita_list as $item): ?>
    <tr>
        <td>
            <?php if (!empty($item['gambar_berita'])): ?>
                <img src="<?php echo url_gambar_berita_featured($item['gambar_berita']); ?>" class="admin-thumb" alt="">
            <?php endif; ?>
        </td>
        <td><?php echo html_escape($item['judul_berita']); ?></td>
        <td><?php echo html_escape(label_bidang($item['bidang'])); ?></td>
        <td><?php echo format_tanggal_berita($item['tanggal']); ?></td>
        <td>
            <span class="admin-badge admin-badge-<?php echo $item['status'] === 'published' ? 'published' : 'draft'; ?>">
                <?php echo $item['status']; ?>
            </span>
        </td>
        <td>
            <div class="admin-action-group">
                <a href="<?php echo site_url('admin/berita/edit/' . $item['id']); ?>" class="btn-one">Edit</a>
                <?php echo form_open('admin/berita/hapus', array(
                    'class' => 'admin-inline-form',
                    'onsubmit' => "return confirm('Hapus berita ini?')",
                )); ?>
                    <input type="hidden" name="id" value="<?php echo (int) $item['id']; ?>">
                    <button type="submit" class="btn-one danger">Hapus</button>
                <?php echo form_close(); ?>
            </div>
        </td>
    </tr>
<?php endforeach; endif; ?>
