  <!--Start breadcrumb area-->
        <section class="breadcrumb-area style2" style="background-image: url(<?php echo base_url().'assets/'?>images/resources/breadcrumb-bg.jpg);">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="inner-content-box clearfix">
                            <div class="title-s2 text-center">
                               
                                <h1>Sekretariat BKD NTB</h1>
                                 <span>PPID BKD Provinsi NTB</span>
                            </div>
                            <div class="breadcrumb-menu float-left">
                                <ul class="clearfix">
                                    <li><a href="#"></a></li>
                                   
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--End breadcrumb area-->

        
        <!--Start blog area-->
        <section id="blog-area" class="blog-large-area">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
                        <div class="blog-post">
                            <?php $this->load->view('partials/bidang_berita_posts', array('berita_list' => $berita_list ?? array())); ?>
                        </div>
                        <!-- <div class="row">
                            <div class="col-md-12">
                                <ul class="post-pagination text-center">
                                    <li><a href="#"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
                                    <li class="active"><a href="#">1</a></li>
                                    <li><a href="#">2</a></li>
                                    <li><a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                                </ul>
                            </div>
                        </div> -->
                    </div>

                   <div class="col-xl-4 col-lg-5 col-md-12 col-sm-12">
                        <div class="single-service-sidebar">
                            <!--Start Single sidebar-->
                             <div class="sidebar-contact-box text-center">
                                <div class="inner-content">
                                    <img src="<?php echo base_url().'assets/'?>images/team/sekban.png" alt="Awesome Image">
                                  
                                    <div class="bottom-box">
                                        <h3>Sekretaris Badan</h3>
                                        <span>Ida Bagus Arnawa, SE</span><br>
                                         <span>NIP. 197406121993031003</span>
                                    </div>
                                    <div class="button">
                                        <a class="btn-one wow slideInUp" data-wow-delay="0ms" data-wow-duration="1500ms" href="#">Informasi LHKPN
                                    <span class="flaticon-next"></span>
                                </a>
                                    </div>
                                </div>
                            </div>

                          
                           
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
 
       