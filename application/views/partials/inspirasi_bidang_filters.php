<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->helper('berita'); ?>
<li data-filter=".filter-item" class="active"><span class="filter-text">Semua Bidang</span></li>
<?php foreach (bidang_rows_all() as $item):
    if (empty($item['filter_class'])) {
        continue;
    }
    $filter_label = !empty($item['judul_halaman']) ? $item['judul_halaman'] : $item['label'];
?>
<li data-filter=".<?php echo html_escape($item['filter_class']); ?>"><span class="filter-text"><?php echo html_escape($filter_label); ?></span></li>
<?php endforeach; ?>
