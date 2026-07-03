<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
$judul = !empty($bidang['judul_halaman']) ? $bidang['judul_halaman'] : ($bidang['label'] ?? '');
$sub = $bidang['subjudul'] ?? '';
?>
<!--Start breadcrumb area-->
<section class="breadcrumb-area style2" style="background-image: url(<?php echo base_url().'assets/'?>images/resources/breadcrumb-bg.jpg);">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="inner-content-box clearfix">
                    <div class="title-s2 text-center">
                        <h1><?php echo html_escape($judul); ?></h1>
                        <?php if ($sub !== ''): ?>
                            <span><?php echo html_escape($sub); ?></span>
                        <?php endif; ?>
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
