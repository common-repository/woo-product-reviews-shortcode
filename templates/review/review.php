<?php
/**
 * Review Comments Template
 *
 * @var $show_pic
 * @var $show_schema
 * @var $show_pic_style
 * @var $args
 * @var $comment
 * @var $depth
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$text_comment_column_class = 'wptl-col-xs-12';
$thumb_comment_column_class = 'wptl-col-xs-4 wptl-col-md-3 wptl-col-lg-2';

if ('yes' === $show_pic
    && !empty($args["thumb_comment_column_class"])
    && !empty($args["text_comment_column_class"])
) {
    $text_comment_column_class = $args["text_comment_column_class"];
    $thumb_comment_column_class = $args["thumb_comment_column_class"];
}
?>
<div id="comment-<?php comment_ID(); ?>" class="comment_container" style="margin-bottom: 15px;">
    <div class="wptl-row">
        <?php
        $col_style = 'wptl-col-xs-12';

        if ('yes' === $show_pic) {
            ?>
            <div class="<?php echo $thumb_comment_column_class ?>">
                <?php
                /**
                 * wprshrtcd_before_comment_content hook.
                 *
                 * @hooked wprshrtcd_output_avatar - 15
                 */
                do_action( 'wprshrtcd_before_comment_content', $comment, $args );
                ?>
            </div>
            <?php
            $col_style = 'wptl-col-xs-8 wptl-col-md-9 wptl-col-lg-10';
        }
        ?>

        <div class="<?php echo $text_comment_column_class ?>">
            <div class="comment-text">
                <?php
                /**
                 * wprshrtcd_before_comment_content hook.
                 *
                 * @hooked wprshrtcd_output_review_rating - 10
                 * @hooked wprshrtcd_output_review_meta - 15
                 * @hooked wprshrtcd_output_review_content - 20
                 */
                do_action( 'wprshrtcd_comment_content', $comment, $args );
                ?>
            </div>
        </div>
    </div>
    <?php
    /**
     * wprshrtcd_after_comment_content hook.
     */
    do_action( 'wprshrtcd_after_comment_content', $comment, $args );
    ?>
</div>
