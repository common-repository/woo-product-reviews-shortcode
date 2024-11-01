<?php
$site_lang = get_user_locale();
$de_lang_list = array(
    'de_CH_informal',
    'de_DE_formal',
    'de_AT',
    'de_CH',
    'de_DE'
);

?>
<div class="wrap wprshrtcd-help">
    <?php
    ob_start();
    if (in_array($site_lang, $de_lang_list)) {
        require_once 'intro_DE.php';
    } else {
        require_once 'intro_EN.php';
    }
    echo apply_filters('the_content', ob_get_clean());
    ?>
</div>
