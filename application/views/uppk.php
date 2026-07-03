<?php $this->load->view('partials/bidang_breadcrumb', array('bidang' => $bidang ?? array())); ?>

        
        <!--Start blog area-->
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
							 <!--Start Single sidebar-->
                            <div class="single-sidebar">
                                <ul class="service-pack-download">
                                    <li class="clearfix">
                                        <div class="title-holder">
                                            <a href="/konseling">Layanan SiKOPI (Sistem Informasi Konseling Psikologi Interaktif)</span></a>
                                        </div>
                                        <div class="icon-holder">
                                            <i class="fa fa-download" aria-hidden="true"></i>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <!--End Single sidebar-->
                            <!--Start Single sidebar-->
                             <?php $this->load->view('partials/bidang_sidebar_kepala', array('bidang' => $bidang ?? array())); ?>

                            <div class="single-sidebar">
                                <div class="title">
                                <h5><?php echo html_escape(!empty($bidang['layanan_judul']) ? $bidang['layanan_judul'] : ('Layanan ' . ($bidang['label'] ?? ''))); ?></h5>
                            </div><br>
                                <ul class="service-pages">
                                    <li>
                                        <a href="#">
                                            <div class="title">
                                                <h3 class="static">Penilaian Kompetensi</h3>
                                                <div class="overlay-title">
                                                    <h3>Penilaian Kompetensi</h3>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="title">
                                                <h3 class="static">Konseling Karir ASN</h3>
                                                <div class="overlay-title">
                                                    <h3>Konseling Karir ASN</h3>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="title">
                                                <h3 class="static">Konseling Psikologi ASN</h3>
                                                <div class="overlay-title">
													<h3>Konseling Psikologi ASN</h3>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                   

                                </ul>
                            </div>
                            <!--End Single sidebar-->
                           
                           
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!--End blog area-->
 
       