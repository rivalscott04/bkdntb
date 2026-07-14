<?php defined('BASEPATH') OR exit('No direct script access allowed');
$tgl = format_tanggal_kartu($berita['tanggal']);
$img = url_gambar_berita_featured($berita['gambar_berita'] ?? '');
?>
<style>
.berita-content img { max-width: 100%; height: auto; }
.berita-content table { width: 100%; border-collapse: collapse; margin: 1rem 0; }
.berita-content table th,
.berita-content table td { border: 1px solid #ddd; padding: 8px; }
.berita-content blockquote { border-left: 4px solid #ccc; margin: 1rem 0; padding-left: 1rem; color: #555; }
</style>
        <!--Start breadcrumb area-->
        <section class="breadcrumb-area style2" style="background-image: url(<?php echo base_url().'assets/'?>images/resources/breadcrumb-bg.jpg);">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="inner-content-box clearfix">
                            <div class="title-s2 text-center">
                                <span>BKD Provinsi Nusa Tenggara Barat</span>
                                <h1>Berita & Informasi Kegiatan</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--End breadcrumb area-->

        <section id="blog-area" class="blog-large-area">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="blog-post">
                            <div class="single-blog-post style4 wow fadeInUp" data-wow-delay="0ms" data-wow-duration="1500ms">
                                <div class="img-holder">
                                    <img src="<?php echo $img; ?>" alt="<?php echo html_escape($berita['judul_berita']); ?>">
                                </div>
                                <div class="text-holder">
                                    <h3><?php echo html_escape($berita['judul_berita']); ?></h3>
                                    <div class="meta-box">
                                        <ul class="meta-info">
                                            <li>Oleh <?php echo html_escape($berita['penulis']); ?></li>
                                            <li><?php echo format_tanggal_berita($berita['tanggal']); ?></li>
                                            <li>Bidang <a href="<?php echo url_bidang($berita['bidang']); ?>"><?php echo html_escape(label_bidang($berita['bidang'])); ?></a></li>
                                        </ul>
                                    </div>
                                    <div class="text berita-content">
                                        <?php echo render_isi_berita($berita['isi_berita']); ?>
                                    </div>
                                    <div class="mt-4">
                                        <a class="btn-one" href="<?php echo site_url('berita'); ?>">Kembali ke Berita<span class="flaticon-next"></span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
