<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo !empty($page_title) ? html_escape($page_title) . ' - ' : ''; ?>Admin BKD NTB</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/responsive.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/admin.css'); ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url('assets/images/favicon/apple-touch-icon.png'); ?>">
    <link rel="icon" type="image/png" href="<?php echo base_url('assets/images/favicon/favicon-32x32.png'); ?>" sizes="32x32">
    <?php if (!empty($head_extra)): ?>
        <?php echo $head_extra; ?>
    <?php endif; ?>
</head>
<body class="admin-body">
