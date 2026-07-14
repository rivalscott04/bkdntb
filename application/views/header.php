<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?php echo !empty($page_title) ? html_escape($page_title) . ' - ' : ''; ?>BKD NTB | Situs Resmi</title>

    <!-- responsive meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- For IE -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- master stylesheet -->
    <link rel="stylesheet" href="<?php echo base_url().'assets/'?>css/style.css">
    <!-- Responsive stylesheet -->
    <link rel="stylesheet" href="<?php echo base_url().'assets/'?>css/responsive.css">
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url().'assets/'?>images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="<?php echo base_url().'assets/'?>images/favicon/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="<?php echo base_url().'assets/'?>images/favicon/favicon-16x16.png" sizes="16x16">

    <?php if (!empty($head_extra)): ?>
        <?php echo $head_extra; ?>
    <?php endif; ?>

    <!-- Fixing Internet Explorer-->
    <!--[if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <script src="js/html5shiv.js"></script>
    <![endif]-->

</head>

<body>
    <div class="boxed_wrapper">

        <div class="preloader"></div>

        <!-- Start Top Bar style3 -->
        <section class="topbar-style3-area">
            <div class="container clearfix">
                <div class="topbar-style3-content">
                    <div class="topbar-style3-left">
                        Selamat Datang di BKD Provinsi NTB
                    </div>
                    <div class="topbar-style3-right">
                        <ul class="clearfix">
                            <li><a href="https://www.facebook.com/bkdprovntb"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                            <li><a href="https://www.instagram.com/bkdprovinsintb/"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                            <li><a href="https://www.youtube.com/@bkdprovinsintb-ppid?sub_confirmation=1"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
                            
                        </ul>
                        <div>
                            
                         &nbsp;&nbsp; <a href="/konseling" class="btn-three" target="_blank">Konseling ASN</a>
                            
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--End Top Bar style3 -->

        <!--Start Header style3 Area-->
        <section class="header-style3-area">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="header-style3-content">
                            <div class="logo-box-style3 float-left">
                                <a href="/home">
                                    <img src="<?php echo base_url().'assets/'?>images/resources/logo.png" width="225x" height="35px" alt="Logo BKD">
                                </a>
                            </div>
                            <ul class="header-contact-info style2 float-left">
                                <li>
                                    <div class="single-item">
                                        <div class="icon">
                                            <span class="icon-maps-and-location"></span>
                                        </div>
                                        <div class="text">
                                            <h3>Alamat Kantor</h3>
                                            <p>Jl. Pejanggik No. 14 Mataram</p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="single-item">
                                        <div class="icon">
                                            <span class="icon-mail"></span>
                                        </div>
                                        <div class="text">
                                            <h3>Email Resmi</h3>
                                            <p>bkd@ntbprov.go.id</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>

                            <div class="float-right">
                                <a href="#"><img src="<?php echo base_url().'assets/'?>images/Logo_BerAKHLAK.svg.png" width="270x" height="40px" alt="Logo HUT NTB"></a>
                            </div>
							
							 <!--div class="float-right">
                                <a href="#"><img src="<?php echo base_url().'assets/'?>images/hutntb67.png" width="280x" height="40px" alt="Logo HUT NTB"></a>
                            </div-->

                            <!-- <div class="header-call-button float-right">
                                <a href="/konseling"><div class="inner">
                                    <div class="title">
                                        <span>Inovasi Layanan</span>
                                        <h3><b>e-Konseling ASN</b></h3>
                                    </div>
                                    <div class="icon">
                                        <span class="icon-support"></span>
                                    </div><br>
                                </div></a>
                            </div> -->

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--End Header style3 Area-->

        <!--Start Mainmenu Style3 Area-->
        <header class="mainmenu-style3-area stricky">
            <div class="container">
                <div class="main-menu-box clearfix">
                    <nav class="main-menu style3 clearfix float-left">
                        <div class="navbar-header clearfix">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        </div>
                        <div class="navbar-collapse collapse clearfix">
                            <ul class="navigation clearfix">
                                 <li><a href="home">Beranda</a>
    
                                                </li>
                                                
                                                <li class="dropdown"><a href="#">Profil</a>
                                                <ul>
                                                        <li><a href="/kaban">Kepala Badan</a></li>
                                                        <li><a href="/sekban">Sekretaris Badan</a></li>
                                                        <li><a href="/pimpinan">Pejabat OPD</a></li>
                                                        <li><a href="/pegawai">Data Kepegawaian</a></li>
                                                        <li><a href="/lhkpn">Informasi LHKPN</a></li>
                                                        <li><a href="/struktur">Struktur Organisasi</a></li>
                                                        <li><a href="/tupoksi">Tugas Pokok & Fungsi</a></li>
                                                        <li><a href="/visi">Visi & Misi</a></li>
                                                        <li><a href="/prestasi">Prestasi Badan</a></li>
                                                        <li><a href="/maklumat">Maklumat Pelayanan</a></li>
                                                        <li><a href="/evakuasi">SOP Peringatan Dini & Evakuasi</a></li>
                                                        <li><a href="/produkhukum">Produk Hukum</a></li>
                                                       
                                                    </ul>
                                                    
                                                </li>
                                                <li><a href="berita">Berita</a>
    
                                                </li>
                                               
                                                <li class="dropdown"><a href="">Bidang</a>
                                                <ul>
                                                        <?php $this->load->helper('berita'); ?>
                                                        <?php foreach (berita_bidang_list(TRUE) as $key => $val): ?>
                                                        <li><a href="<?php echo site_url($val['url']); ?>"><?php echo html_escape($val['label']); ?></a></li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </li>

                                                <li class="dropdown"><a href="#">Layanan Kepegawaian</a>
                                                <ul>
                                                         
                                                <li><a href="/wfh"><em>Work From Home</em> Setiap Jumat</a></li>
                                                <li><a href="/proasn"><em>Profilling</em> ASN (ProASN)</a></li>
                                                         <li><a href="/konseling">Konseling Psikologi ASN</a></li>
                                                        <li><a href="/tugasbelajar">Penerbitan SK Tugas Belajar</a></li>
                                                        <li><a href="/pengajuancuti">Pengajuan Cuti Bagi ASN</a></li>
                                                        <li><a href="/karpeg">Pengurusan Karpeg/Karis/Karsu</a></li>
                                                        <li><a href="/kenaikanpangkat">Kenaikan Pangkat</a></li>
                                                        <li><a href="/layananmutasi">Mutasi Pegawai</a></li>
                                                        <li><a href="/pensiun">Pemberhentian & Pensiun</a></li>
                                                        <li><a href="/disiplin">Penyelesaian Kasus ASN</a></li>
                                                        <!-- <li><a href="/konseling">Konseling Psikolog ASN</a></li> -->
                                                        <li><a href="/kawin">Izin Perkawinan/Cerai/Poligami</a></li>
                                                        <!-- <li><a href="/kebutuhan-asn">Perencanaan Kebutuhan ASN</a></li>
                                                        <li><a href="/ujikom">Uji Kompetensi</a></li> -->
                                                           <li><a href="/pengaduan">Layanan Aduan SPAN LAPOR</a></li>
                                                       
                                                    </ul>
    
                                                </li>

                                              
                                              
												<li class="dropdown"><a href="#">Rekrutmen</a>
													<ul>
													  <li><a href="/rekrutmen">CPNS & PPPK</a></li>
														 <li><a href="/seleksimadya">JPT Madya</a></li>
                                                        <li><a href="/seleksijpt">JPT Pratama</a></li>
                                                        <li><a href="/seleksija">Jabatan Administrator</a></li>
														<li><a href="/awards">ASN NTB Awards</a></li>
													</ul>
    
                                                </li>

                                                <!--li><a href="/rekrutmen/prosedur">Prosedur Pendaftaran
                                                
                                                </a>
    
                                                </li-->
                            </ul>
                        </div>
                    </nav>
                    <div class="mainmenu-right style3 float-right">
                        <div class="button">
                            <a class="btn-one" href="/ppid"><b>PPID BKD NTB</b><span class="flaticon-next"></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!--End Mainmenu Style3 Area-->
