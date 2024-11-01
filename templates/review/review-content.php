<?php
/**
 * The template to display the reviewers avatar
 *
 * @var $show_schema
 */

defined( 'ABSPATH' ) || exit;

if (empty($comment)) return;

?>

<div class="description"<?php echo $show_schema ? ' itemprop="reviewBody"' : ''; ?>>
    <?php echo wpautop($comment->comment_content); ?>
</div>
