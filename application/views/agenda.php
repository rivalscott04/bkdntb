<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!--Start breadcrumb area-->
<section class="breadcrumb-area style2" style="background-image: url(<?php echo base_url().'assets/'?>images/resources/breadcrumb-bg-01.jpg);">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="inner-content-box clearfix">
                    <div class="title-s2 text-center">
                        <span>BKD Provinsi NTB</span>
                        <h1>Agenda Harian Kepala Badan</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--End breadcrumb area-->

<?php
$rentang = format_tanggal_berita($senin) . ' s.d. ' . format_tanggal_berita($minggu);
$per_tanggal = array_count_values(array_column($agenda_list, 'tanggal'));
?>
<section class="agenda-area">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="text">
                    
                    <span>Rekapituasi Agenda Kegiatan : </span><h5><?php echo html_escape($rentang); ?></h5>
                </div>
<br>
                <div class="table-responsive">
                    <table class="table agenda-table">
                        <thead>
                            <tr>
                                <th>Hari/Tanggal</th>
                                <th>Asal Surat/Undangan</th>
                                <th>Agenda Kegiatan</th>
                                <th>Waktu (WITA)</th>
                                <th>Tempat</th>
                                <th>Keterangan</th>
                                <th>Foto Kegiatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($agenda_list)): ?>
                                <tr>
                                    <td colspan="7" class="text-center">Belum ada agenda untuk minggu ini.</td>
                                </tr>
                            <?php else: ?>
                                <?php $tgl_sebelumnya = null; ?>
                                <?php foreach ($agenda_list as $row): ?>
                                    <tr class="<?php echo $row['tanggal'] === $hari_ini ? 'agenda-hari-ini' : ''; ?>">
                                        <?php if ($row['tanggal'] !== $tgl_sebelumnya): ?>
                                            <td rowspan="<?php echo (int) $per_tanggal[$row['tanggal']]; ?>" class="agenda-tanggal">
                                                <?php echo html_escape(agenda_hari_tanggal($row['tanggal'])); ?>
                                                <?php if ($row['tanggal'] === $hari_ini): ?>
                                                    <br><span class="agenda-badge">Hari ini</span>
                                                <?php endif; ?>
                                            </td>
                                            <?php $tgl_sebelumnya = $row['tanggal']; ?>
                                        <?php endif; ?>
                                        <td class="agenda-asal" data-label="Asal Surat"><?php echo html_escape($row['asal_surat'] ?? ''); ?></td>
                                        <td class="agenda-kegiatan"><a href="<?php echo html_escape(agenda_surat_url($row['surat_file'])); ?>"><?php echo html_escape($row['kegiatan']); ?></a></td>
                                        <td class="agenda-waktu" data-label="Waktu">
                                            <?php if (!empty($row['surat_file'])): ?>
                                                <a href="<?php echo html_escape(agenda_surat_url($row['surat_file'])); ?>" class="btn-three" target="_blank" rel="noopener" title="Lihat surat"><?php echo html_escape(agenda_waktu($row) ?: 'Lihat surat'); ?></a>
                                            <?php else: ?>
                                                <?php echo html_escape(agenda_waktu($row)); ?>
                                            <?php endif; ?>
                                        </td>
                                        <td class="agenda-tempat" data-label="Tempat"><?php echo html_escape($row['tempat'] ?? ''); ?></td>
                                        <td class="agenda-keterangan" data-label="Keterangan"><?php echo html_escape($row['keterangan'] ?? ''); ?></td>
                                        <td class="agenda-foto" data-label="Foto Kegiatan">
                                            <?php if (!empty($row['foto_file'])): ?>
                                                <a href="<?php echo html_escape(agenda_surat_url($row['foto_file'])); ?>" target="_blank" rel="noopener">Lihat Foto</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($pagination): ?>
                    <?php if ($page === 1): ?>
                        <p class="agenda-pagination-hint">Halaman berikutnya menampilkan agenda minggu sebelumnya.</p>
                    <?php endif; ?>
                    <div class="blog-post"><?php echo $pagination; ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

 <section class="single-service-area">
            <div class="container">
                
			<div class="how-work-box">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="image-box">
                                        <img src="<?php echo base_url().'assets/'?>images/services/service-single/kaban.jpg" alt="Kaban"><br><br>
                                      
                                             
                                                   
                                               
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="how-works-content">
                                        <h5>Profil Kepala Badan</h5>
                                        <ul>
                                            <li>
                                                <div class="icon">
                                                    <span class="icon-tick"></span>
                                                </div>
                                                <div class="text">
                                                    <span>Nama Lengkap :</span><br>
                                                    <b>Drs. Tri Budiprayitno, M.Si</b>
                                                 
                                                </div>
                                            </li>
                                            <li>
                                                <div class="icon">
                                                    <span class="icon-tick"></span>
                                                </div>
                                                <div class="text">
                                                    <span>Pangkat / Golongan</span><br>
                                                    Pembina Utama Madya (IV/d)
                                                </div>
                                            </li>
                                            <li>
                                                <div class="icon">
                                                    <span class="icon-tick"></span>
                                                </div>
                                                <div class="text">
                                                    <span>Tempat & Tanggal Lahir</span><br>
                                                    Mataram, 16 Oktober 1968
                                                </div>
                                            </li>
											<li>
                                                <div class="icon">
                                                    <span class="icon-tick"></span>
                                                </div>
                                                <div class="text">
                                                    <span>Pendidikan</span><br>
                                                    S2 Administrasi Publik (UGM Yogyakarta) Tahun 2000<br>
                                                    S1 Ilmu Pemerintahan (IIP Jakarta) Tahun 1995<br>
                                                    DIII APDN Mataram Tahun 1990
                                                </div>
                                            </li>
											<li>
                                                <div class="icon">
                                                    <span class="icon-tick"></span>
                                                </div>
                                                <div class="text">
                                                    <span>Riwayat Jabatan</span><br>
                                                    <b>Kepala BKD Provinsi NTB (Sekarang)</b><br>
													Kepala Dinas Pemuda & Olahraga <br>
													Kepala Dinas Perpustakaan dan Kearsipan<br>
													Kepala Satuan Polisi Pamong Praja<br>
													Kepala Badan Pengembangan Sumber Daya Manusia Daerah<br>
													Kepala Dinas Komunikasi, Informatika dan Statistik<br>
													Kepala Biro Organisasi<br>

														
                                                </div>
                                            </li>

                                            <li>
                                                <div class="icon">
                                                    <span class="icon-tick"></span>
                                                </div>
                                                <div class="text">
                                                    <span>Informasi LHKPN</span><br><br>
                                                    <a class="btn-one black" href="/lhkpn">Lihat LHKPN Kepala BKD Provinsi NTB</a>
                                                </div>
                                            </li>


											

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                
			</div>
</section>	

<section class="featured-area">
            
            <div class="container about-style3-content">
                  <div class="row">
                    <div class="col-xl-12">
                        
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-xl-12">
                        <div class="project-carousel-v2 owl-carousel owl-theme">
                            <!--Start single project style1-->
                            <div class="single-project-style2">
                                <div class="img-holder">
                                    <a href="https://www.instagram.com/p/DajYFhKDwkb/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA=="><img src="<?php echo base_url().'assets/'?>images/kaban/1.png" alt="Awesome Image"></a>
                                    
                                    
                                </div>
                            </div>
                            <!--End single project style1-->
                            <!--Start single project style1-->
                            <div class="single-project-style2">
                                <div class="img-holder">
                                    <a href="https://www.instagram.com/p/DajYFhKDwkb/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA=="><img src="<?php echo base_url().'assets/'?>images/kaban/2.png" alt="Awesome Image"></a>
                                    
                                    
                                </div>
                            </div>
                            <!--End single project style1-->
                            <!--Start single project style1-->
                            <div class="single-project-style2">
                                <div class="img-holder">
                                    <a href="https://www.instagram.com/p/DajYFhKDwkb/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA=="><img src="<?php echo base_url().'assets/'?>images/kaban/3.png" alt="Awesome Image"></a>
                                    
                                  
                                </div>
                            </div>
                            <!--End single project style1-->

                            <!--Start single project style1-->
                            <div class="single-project-style2">
                                <div class="img-holder">
                                    <a href="https://www.instagram.com/p/DajYFhKDwkb/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA=="><img src="<?php echo base_url().'assets/'?>images/kaban/4.png" alt="Awesome Image"></a>
                                    
                                   
                                </div>
                            </div>
                            <!--End single project style1-->
                            <!--Start single project style1-->
                            <div class="single-project-style2">
                                <div class="img-holder">
                                    <a href="https://www.instagram.com/p/DajYFhKDwkb/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA=="><img src="<?php echo base_url().'assets/'?>images/kaban/5.png" alt="Awesome Image"></a>
                                    
                                   
                                </div>
                            </div>
                            <!--End single project style1-->
                             <!--Start single project style1-->
                            <div class="single-project-style2">
                                <div class="img-holder">
                                    <a href="https://www.instagram.com/p/DajYFhKDwkb/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA=="><img src="<?php echo base_url().'assets/'?>images/kaban/6.png" alt="Awesome Image"></a>
                                    
                                   
                                </div>
                            </div>
                            <!--End single project style1-->
                          

                          
                      
                        </div>
                       
                    </div>
                </div>



            </div>

              
        </section>

