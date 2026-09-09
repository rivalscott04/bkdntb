<?php defined('BASEPATH') OR exit('No direct script access allowed');
$delay = isset($delay) ? $delay : 200;
$tgl = format_tanggal_kartu($item['tanggal']);
$img = url_gambar_berita_featured($item['gambar_berita'] ?? '');
?>
<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
    <div class="single-blog-colum-style1">
        <div class="single-blog-post style3 wow fadeInLeft" data-wow-delay="<?php echo $delay; ?>ms" data-wow-duration="1500ms">
            <div class="img-holder">
                <img src="<?php echo $img; ?>" alt="<?php echo html_escape($item['judul_berita']); ?>">
                <div class="overlay-style-two"></div>
                <div class="overlay">
                    <div class="box">
                        <div class="post-date">
                            <h3><?php echo $tgl['bulan']; ?><br><span><?php echo $tgl['hari']; ?></span></h3>
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
                        <li><?php echo html_escape($item['penulis']); ?></li>
                        <li>Bidang <a href="<?php echo url_bidang($item['bidang']); ?>"><?php echo html_escape(label_bidang($item['bidang'])); ?></a></li>
                    </ul>
                </div>
                <div class="text">
                    <p><?php echo html_escape(ringkas_teks($item['isi_berita'], 120)); ?></p>
                    <a class="btn-three" href="<?php echo site_url('berita/' . $item['slug']); ?>">Selengkapnya<span class="flaticon-next"></span></a>
                </div>
            </div>
        </div>
    </div>
</div>
