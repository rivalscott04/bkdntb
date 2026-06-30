<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="admin-shell">
    <aside class="admin-shell-sidebar">
        <?php $this->load->view('partials/admin_sidebar', array('active_menu' => $active_menu ?? '')); ?>
    </aside>
    <main class="admin-shell-main admin-panel">
        <?php $this->load->view('partials/admin_flash'); ?>
        <?php if (isset($content)) { echo $content; } ?>
    </main>
</div>
