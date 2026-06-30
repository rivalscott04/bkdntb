  <!--Start breadcrumb area-->
        <section class="breadcrumb-area style2" style="background-image: url(<?php echo base_url().'assets/'?>images/resources/breadcrumb-bg.jpg);">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="inner-content-box clearfix">
                            <div class="title-s2 text-center">
                                <span>Informasi Kegiatan Bidang di BKD NTB</span>
                                <h1>Berita & Informasi</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--End breadcrumb area-->

        <!--Start blog area-->
        <section id="blog-area" class="blog-default-area">
            <div class="container">
                <div class="row">
                    <?php if (empty($berita_list)): ?>
                        <div class="col-12 text-center py-5">
                            <p>Belum ada berita yang dipublikasikan.</p>
                        </div>
                    <?php else: ?>
                        <?php $i = 0; foreach ($berita_list as $item): ?>
                            <?php $this->load->view('partials/berita_card_grid', array('item' => $item, 'delay' => ($i % 3) * 100)); $i++; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <?php if (!empty($pagination)): ?>
                <div class="row">
                    <div class="col-12 text-center mt-4">
                        <?php echo $pagination; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </section>
        <!--End blog area-->

        <!--Start Why choose Area-->
        <section class="why-choose-area" style="background-image:url(<?php echo base_url().'assets/'?>images/parallax-background/why-choose-bg.jpg);">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="why-choose-title float-left">
                            <div class="sec-title">
                                <div class="icon"><img src="<?php echo base_url().'assets/'?>images/icon/home.png" alt="Awesome Logo"></div>
                                <div class="title">Mekanisme <br>Rekrutmen ASN</div>
                            </div>
                            <ul>
                                <li>Membuat Akun Pada Portal SSCASN</li>
                                <li>Melengkapi Data Diri</li>
                                <li>Memilih Formasi Jabatan</li>
                                <li>Mengunggah Dokumen Persyaratan</li>
                                <li>Akhiri Pendaftaran</li>
                            </ul>
                            <br>
                            <div class="button">
                                <a class="btn-one" href="unduhan">Unduh Format Surat Dipersyaratkan<span class="flaticon-next"></span></a>
                            </div>
                        </div>
                        <div class="why-choose-content float-right">
                            <div class="single-box redbg">
                                <div class="icon-holder"><span class="icon-group"></span></div>
                                <div class="text-holder">
                                    <h3>Membuat Akun SSCASN</h3>
                                    <p>Pelamar wajib membuat akun pada Portal Sistem Seleksi Calon Aparatur Sipil Negara (SSCASN) milik BKN.</p>
                                </div>
                            </div>
                            <div class="single-box whitebg">
                                <div class="icon-holder"><span class="icon-guarantee-certificate1"></span></div>
                                <div class="text-holder">
                                    <h3>Melengkapi Data Diri</h3>
                                    <p>Pelamar mengisi biodata terdiri dari data diri, nama dan tanggal lahir sesuai ijazah yang dimiliki dan data diri lainnya.</p>
                                </div>
                            </div>
                            <div class="single-box whitebg">
                                <div class="icon-holder"><span class="icon-hr1"></span></div>
                                <div class="text-holder">
                                    <h3>Memilih Formasi Jabatan</h3>
                                    <p>Pelamar memilih jenis pengadaan yang akan dilamar, melengkapi data pendidikan kemudian memilih kualifikasi pendidikan, jabatan dan unit kerja sesuai dengan formasi yang ingin dilamar.</p>
                                </div>
                            </div>
                            <div class="single-box blackbg">
                                <div class="icon-holder"><span class="icon-document"></span></div>
                                <div class="text-holder">
                                    <h3>Mengunggah Dokumen</h3>
                                    <p>Pelamar mengunggah dokumen persyaratan, pastikan dokumen terunggah dan terbaca dengan baik sesuai dengan format dan ukuran yang ditentukan oleh Sistem SSCASN milik Badan Kepegawaian Negara RI.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--End Why choose Area-->
