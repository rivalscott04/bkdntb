<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="admin-brand">
    <a href="<?php echo site_url('admin/berita'); ?>">
        <img src="<?php echo base_url('assets/images/resources/logo2.png'); ?>" alt="BKD NTB">
    </a>
    <p>Panel Admin</p>
</div>
<ul class="admin-nav">
    <li class="<?php echo ($active_menu ?? '') === 'berita' ? 'active' : ''; ?>">
        <a href="<?php echo site_url('admin/berita'); ?>">Kelola Berita</a>
    </li>
    <li>
        <a href="<?php echo site_url(); ?>" target="_blank">Lihat Website</a>
    </li>
    <li>
        <?php echo form_open('admin/login/logout', array('class' => 'admin-logout-form')); ?>
            <button type="submit">Logout</button>
        <?php echo form_close(); ?>
    </li>
</ul>
