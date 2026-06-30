<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="admin-header-row">
    <div class="sec-title">
        <p>Manajemen Konten</p>
        <div class="title">Daftar Berita</div>
    </div>
    <a class="btn-one" href="<?php echo site_url('admin/berita/tambah'); ?>">Tambah Berita<span class="flaticon-next"></span></a>
</div>

<div class="admin-filter-bar contact-form">
    <div class="inner-box">
        <form id="admin-berita-filter" class="admin-filter-form" autocomplete="off">
            <div class="row">
                <div class="col-md-3">
                    <div class="admin-field">
                        <label for="filter-q">Cari</label>
                        <div class="input-box">
                            <input type="search" id="filter-q" name="q"
                                   value="<?php echo html_escape($filters['q'] ?? ''); ?>"
                                   placeholder="Cari judul atau penulis...">
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="admin-field">
                        <label for="filter-bidang">Bidang</label>
                        <div class="input-box">
                            <select id="filter-bidang" name="bidang">
                                <option value="">Semua Bidang</option>
                                <?php foreach ($bidang_list as $key => $val): ?>
                                    <option value="<?php echo html_escape($key); ?>"
                                        <?php echo (($filters['bidang'] ?? '') === $key) ? 'selected' : ''; ?>>
                                        <?php echo html_escape($val['label']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="admin-field">
                        <label for="filter-status">Status</label>
                        <div class="input-box">
                            <select id="filter-status" name="status">
                                <option value="">Semua Status</option>
                                <option value="published" <?php echo (($filters['status'] ?? '') === 'published') ? 'selected' : ''; ?>>Published</option>
                                <option value="draft" <?php echo (($filters['status'] ?? '') === 'draft') ? 'selected' : ''; ?>>Draft</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="admin-field">
                        <label for="filter-tanggal-range">Rentang Tanggal</label>
                        <div class="input-box admin-date-range-wrap">
                            <input type="text" id="filter-tanggal-range" name="tanggal_range" readonly
                                   placeholder="Klik & drag untuk pilih rentang"
                                   data-start="<?php echo html_escape($filters['tanggal_dari'] ?? ''); ?>"
                                   data-end="<?php echo html_escape($filters['tanggal_sampai'] ?? ''); ?>">
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="admin-field">
                        <label>&nbsp;</label>
                        <button type="button" id="filter-reset" class="admin-btn-reset">Reset</button>
                    </div>
                </div>
            </div>
        </form>
        <p class="admin-list-meta" id="admin-berita-meta">
            Menampilkan <?php echo count($berita_list); ?> dari <?php echo (int) $total; ?> berita
        </p>
    </div>
</div>

<div class="contact-form admin-list-panel" id="admin-berita-panel">
    <div class="inner-box">
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Judul</th>
                        <th>Bidang</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>
                <tbody id="admin-berita-tbody">
                    <?php $this->load->view('admin/partials/berita_table_rows', array('berita_list' => $berita_list)); ?>
                </tbody>
            </table>
        </div>
        <div class="admin-list-loading" id="admin-berita-loading" hidden>
            <span class="admin-spinner"></span> Memuat data...
        </div>
    </div>
</div>

<div id="admin-berita-pagination">
    <?php if (!empty($pagination)): ?>
        <?php echo $pagination; ?>
    <?php endif; ?>
</div>
