<?php
/**
 * The template to display the reviewers avatar
 *
 * @var $show_schema
 */

defined( 'ABSPATH' ) || exit;

if (empty($comment) || empty($thumbnail)) return;
?> <?php echo $thumbnail ?>
