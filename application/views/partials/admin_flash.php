<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if ($this->session->flashdata('success')): ?>
    <div class="admin-alert admin-alert-success"><?php echo $this->session->flashdata('success'); ?></div>
<?php endif; ?>
<?php if ($this->session->flashdata('error')): ?>
    <div class="admin-alert admin-alert-error"><?php echo $this->session->flashdata('error'); ?></div>
<?php endif; ?>
