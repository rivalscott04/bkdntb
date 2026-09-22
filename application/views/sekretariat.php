<?php $this->load->view('partials/bidang_breadcrumb', array('bidang' => $bidang ?? array())); ?>

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
                    <?php $this->load->view('partials/bidang_sidebar_stack', array(
                        'bidang' => $bidang ?? array(),
                        'layanan_list' => $layanan_list ?? array(),
                    )); ?>
                </div>
            </div>
        </div>
    </div>
</section>
