<script src="<?php echo base_url('assets/js/jquery.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
<?php $this->load->view('admin/csrf_vars'); ?>
<?php if (!empty($use_editor)): ?>
    <?php $this->load->view('admin/layout_footer'); ?>
<?php endif; ?>
<?php if (!empty($use_list_ajax)): ?>
    <?php $this->load->view('admin/berita_list_scripts'); ?>
<?php endif; ?>
</body>
</html>
