<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->helper('berita'); ?>
<?php foreach (bidang_rows_all() as $item):
    if (empty($item['kepala_nama']) || $item['kode'] === 'Sekretariat') {
        continue;
    }
    $jabatan = !empty($item['kepala_judul']) ? $item['kepala_judul'] : $item['label'];
?>
<tr>
    <td><?php echo (int) ($lhkpn_no ?? 1); ?>.</td>
    <td><?php echo html_escape($item['kepala_nama']); ?></td>
    <td><?php echo html_escape($jabatan); ?></td>
    <td><a href="#" class="btn-three" target="_blank">Lihat LHKPN</a></td>
</tr>
<?php $lhkpn_no = ($lhkpn_no ?? 1) + 1; endforeach; ?>
