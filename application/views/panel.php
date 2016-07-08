<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Admin Panel</title>

    <link rel="shortcut icon" href="<?= base_url('assets/img/panel-favicon.ico') ?>"/>
    <meta name="robots" content="noindex, nofollow">

    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/style.css') ?>"/>

    <?php
    foreach ($css_files as $file): ?>
        <link type="text/css" rel="stylesheet" href="<?=$file; ?>"/>
    <?php endforeach; ?>
    <?php foreach ($js_files as $file): ?>
        <script src="<?=$file; ?>"></script>
    <?php endforeach;
    ?>
</head>
<body>
<?php


if ($this->session->flashdata('test')) {
    print_r($this->session->flashdata('test'));
}
?>
<div class="top_menu">
    <ul>
        <li><a href='<?= base_url('panel/events') ?>'>Events</a></li>
        <li><a href='<?= base_url('panel/categories') ?>'>Categories</a></li>
        <li><a href='<?= base_url('panel/checkpoints') ?>'>Checkpoints</a></li>
        <li><a href='<?= base_url('panel/participants') ?>'>Participants</a></li>
        <li><a href='<?= base_url('panel/add_to_event') ?>'>Add participant to event</a></li>

        <li class="right special">
            <a href='<?= base_url('panel/simulate') ?>'>
                <b>Simulate checkpoints</b></a>
        </li>
    </ul>
</div>
<div>
    <?= $output; ?>
</div>

</body>
</html>
