<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<section class="breadcrumb-area style2" style="background-image: url(<?php echo base_url('assets/images/resources/breadcrumb-bg.jpg'); ?>);">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="inner-content-box clearfix">
                    <div class="title-s2 text-center">
                        <?php if (!empty($breadcrumb_subtitle)): ?>
                            <span><?php echo html_escape($breadcrumb_subtitle); ?></span>
                        <?php endif; ?>
                        <h1><?php echo html_escape($breadcrumb_title ?? ($title ?? 'Admin')); ?></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
