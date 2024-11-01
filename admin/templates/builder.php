<?php
$shortcode_id = !empty($_GET['shortcode_id']) ? sanitize_text_field($_GET['shortcode_id']) : false;

?>
<div class="wrap wprshrtcd-help">
    <?php
    if ($shortcode_id) {
        include('builder-edit.php');
    } else {
        include('builder-list.php');
    }
    ?>

    <?php require_once 'more-plugins.php'?>
</div>