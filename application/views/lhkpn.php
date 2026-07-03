<!--Start breadcrumb area-->
<section class="breadcrumb-area style2" style="background-image: url(<?php echo base_url().'assets/'?>images/resources/breadcrumb-bg-01.jpg);">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="inner-content-box clearfix">
                            <div class="title-s2 text-center">
                                <span>Badan Kepegawaian Daerah Provinsi NTB
                                <h1>Informasi LHKPN</h1>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--End breadcrumb area-->

<br>
		 <section class="company-overview-area">
		<div class="container">
		<div class="row">
                    <div class="col-xl-12">
                        <div class="intro-box clearfix">
                            <div class="sec-title">
                                <p>Informasi Publik</p>
                                <div class="title">Laporan Harta<br>Kekayaan<br>Penyelenggara Negara</div>
                            </div>
                            <div class="text">
                                <p>
                                   LHKPN merupakan laporan yang wajib diisi dan disampaikan oleh penyelenggara negara kepada Komisi Pemberantasan Korupsi (KPK), berisi data tentang seluruh harta kekayaan yang dimiliki, baik atas nama sendiri maupun pasangan dan anak yang masih menjadi tanggungan.</p><br>
                            	<a href="<?php echo base_url().'assets/'?>download/Laporan LHKPN NTB 2025.pdf" class="btn-three" target="_blank">Informasi Jumlah & Prosentase Yang Wajib LHKPN</a>
							</div>
							
                        </div>

						
                    </div>
					
        </div>
		
		</div>
		</section>
<div class="container">
<div class="row">
<div class="col-xl-12">
<br>
<h3> Daftar Informasi LHKPN BKD Provinsi NTB</h3><br>
        <table id="datatable" class="table table-striped">
                        <thead>
                            <tr>
                            <td><b>No.</b></td>
                                <td><b>Nama</b></td>
                               <td><b>Jabatan</b></td>
                               
                               <td><b>Aksi</b></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $this->load->helper('berita'); ?>
                                <tr>
                                <td>1.</td>
                                    <td>Drs. Tri Budiprayitno, M.Si</td>
                                   <td>Kepala Badan</td> 
                                   
                                   <td><a href="<?php echo base_url().'assets/'?>download/Kaban.pdf" class="btn-three" target="_blank">Lihat LHKPN</a></td>
                                </tr>

                                  <tr>
                                <td>2.</td>
                                    <td><?php echo html_escape(bidang_field('Sekretariat', 'kepala_nama', 'Ida Bagus Arnawa, SE')); ?></td>
                                   <td><?php echo html_escape(bidang_field('Sekretariat', 'kepala_judul', 'Sekretaris Badan')); ?></td> 
                                   
                                   <td><a href="#" class="btn-three" target="_blank">Lihat LHKPN</a></td>
                                </tr>

                                <?php $lhkpn_no = 3; $this->load->view('partials/lhkpn_bidang_rows'); ?>

                               

                                
                               
                        </tbody>
                    </table>
</div>   
</div> </div> 




  