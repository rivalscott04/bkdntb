<?php $this->load->view('partials/bidang_breadcrumb', array('bidang' => $bidang ?? array())); ?>

        
        <!--Start blog area-->
        <section id="blog-area" class="blog-large-area">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
                                                <div class="blog-post">
                            <?php $this->load->view('partials/bidang_berita_posts', array('berita_list' => $berita_list ?? array())); ?>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <ul class="post-pagination text-center">
                                    <li><a href="#"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
                                    <li class="active"><a href="#">1</a></li>
                                    <li><a href="#">2</a></li>
                                    <li><a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                   <div class="col-xl-4 col-lg-5 col-md-12 col-sm-12">
                        <div class="single-service-sidebar">
                            <!--Start Single sidebar-->
                             <?php $this->load->view('partials/bidang_sidebar_kepala', array('bidang' => $bidang ?? array())); ?>

                            <div class="single-sidebar">
                                <div class="title">
                                <h5><?php echo html_escape(!empty($bidang['layanan_judul']) ? $bidang['layanan_judul'] : ('Layanan ' . ($bidang['label'] ?? ''))); ?></h5>
                            </div><br>
                                <ul class="service-pages">
                                    <li>
                                        <a href="/tugasbelajar">
                                            <div class="title">
                                                <h3 class="static">Izin Tugas Belajar</h3>
                                                <div class="overlay-title">
                                                    <h3>Tugas Belajar</h3>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="title">
                                                <h3 class="static">Permohonan Formasi JF</h3>
                                                <div class="overlay-title">
                                                    <h3>Formasi JF</h3>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="title">
                                                <h3 class="static">Penerbitan SK JF</h3>
                                                <div class="overlay-title">
                                                    <h3>Penerbitan SK JF</h3>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="title">
                                                <h3 class="static">Uji Kompetensi JF</h3>
                                                <div class="overlay-title">
                                                    <h3>Uji Kompetensi JF</h3>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="title">
                                                <h3 class="static">Pencantuman Gelar</h3>
                                                <div class="overlay-title">
                                                    <h3>Pencantuman Gelar</h3>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    

                                </ul>
                            </div>
                            <!--End Single sidebar-->
                           
                            <!--Start Single sidebar-->
                            <div class="single-sidebar">
                                <ul class="service-pack-download">
                                    <li class="clearfix">
                                        <div class="title-holder">
                                            <a href="<?php echo base_url().'assets/'?>download/Pergub 42 Tahun 2017.pdf">Tugas Pokok & Fungsi <span>(307 kb)</span></a>
                                        </div>
                                        <div class="icon-holder">
                                            <i class="fa fa-download" aria-hidden="true"></i>
                                        </div>
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
 
       