<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if (empty($berita_list)): ?>
    <div class="single-blog-post style4">
        <div class="text-holder">
            <p class="text-muted">Belum ada berita untuk bidang ini.</p>
        </div>
    </div>
<?php else: foreach ($berita_list as $item):
    $img = url_gambar_berita_featured($item['gambar_berita'] ?? '');
?>
    <div class="single-blog-post style4 wow fadeInUp" data-wow-delay="0ms" data-wow-duration="1500ms">
        <div class="img-holder">
            <img src="<?php echo $img; ?>" alt="<?php echo html_escape($item['judul_berita']); ?>">
            <div class="overlay-style-two"></div>
            <div class="overlay">
                <div class="box">
                    <div class="link-icon">
                        <a href="<?php echo site_url('berita/' . $item['slug']); ?>"><span class="icon-link1"></span></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-holder">
            <h3 class="blog-title">
                <a href="<?php echo site_url('berita/' . $item['slug']); ?>"><?php echo html_escape($item['judul_berita']); ?></a>
            </h3>
            <div class="meta-box">
                <ul class="meta-info">
                    <li>Oleh <?php echo html_escape($item['penulis']); ?></li>
                    <li><?php echo format_tanggal_berita($item['tanggal']); ?></li>
                    <li>Bidang <a href="<?php echo url_bidang($item['bidang']); ?>"><?php echo html_escape(label_bidang($item['bidang'])); ?></a></li>
                </ul>
            </div>
            <div class="text">
                <p align="justify"><?php echo html_escape(ringkas_teks($item['isi_berita'], 400)); ?></p>
            </div>
            <div class="button">
                <a class="btn-one" href="<?php echo site_url('berita/' . $item['slug']); ?>">Selengkapnya<span class="flaticon-next"></span></a>
            </div>
        </div>
    </div>
<?php endforeach; endif; ?>
