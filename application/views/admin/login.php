<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="admin-login-shell admin-panel">
    <div class="admin-login-box">
        <div class="admin-login-brand">
            <a href="<?php echo site_url(); ?>">
                <img src="<?php echo base_url('assets/images/resources/logo.png'); ?>" alt="BKD NTB">
            </a>
        </div>
        <div class="contact-form">
            <div class="inner-box">
                <div class="sec-title">
                    <p>Panel Admin</p>
                    <div class="title">Masuk ke Sistem</div>
                </div>

                <?php $this->load->view('partials/admin_flash'); ?>

                    <?php echo form_open('admin/login/authenticate'); ?>
                        <div class="admin-field">
                            <label>Username</label>
                            <div class="input-box">
                                <input type="text" name="username" required autofocus>
                            </div>
                        </div>
                        <div class="admin-field">
                            <label>Password</label>
                            <div class="input-box">
                                <input type="password" name="password" required>
                            </div>
                        </div>
                        <div class="admin-actions">
                            <button type="submit" class="btn-one" style="width: 100%;">Masuk<span class="flaticon-next"></span></button>
                        </div>
                    <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
