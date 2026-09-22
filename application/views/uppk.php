<?php $this->load->view('partials/bidang_breadcrumb', array('bidang' => $bidang ?? array())); ?>
<?php
$layanan_items = $layanan_list ?? array();
$has_konseling = FALSE;
foreach ($layanan_items as $item) {
	$url = strtolower(trim((string) ($item['url'] ?? '')));
	if ($url === '/konseling' || $url === 'konseling' || substr($url, -10) === '/konseling') {
		$has_konseling = TRUE;
		break;
	}
}
?>

<section id="blog-area" class="blog-large-area">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
                <div class="blog-post">
                    <?php $this->load->view('partials/bidang_berita_posts', array('berita_list' => $berita_list ?? array())); ?>
                </div>
                <?php $this->load->view('partials/bidang_berita_pagination', array('pagination' => $pagination ?? '')); ?>
            </div>

            <div class="col-xl-4 col-lg-5 col-md-12 col-sm-12">
                <div class="single-service-sidebar">
                    <?php if (!$has_konseling): ?>
                    <div class="single-sidebar">
                        <ul class="service-pack-download">
                            <li class="clearfix">
                                <div class="title-holder">
                                    <a href="<?php echo site_url('konseling'); ?>">
                                        Layanan SiKOPI (Sistem Informasi Konseling Psikologi Interaktif)
                                    </a>
                                </div>
                                <div class="icon-holder">
                                    <i class="fa fa-download" aria-hidden="true"></i>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <?php endif; ?>

                    <?php $this->load->view('partials/bidang_sidebar_stack', array(
                        'bidang' => $bidang ?? array(),
                        'layanan_list' => $layanan_items,
                        'show_pergub' => FALSE,
                    )); ?>
                </div>
            </div>
        </div>
    </div>
</section>
