<?php

if ( ! function_exists( 'wprshrtcd_output_reviews_title' ) ) {

    /**
     * Output review avatar.
     */
    function wprshrtcd_output_reviews_title($product_reviews_attr) {
        wprshrtcd_get_template( 'product-reviews-title.php', $product_reviews_attr );
    }
}

if ( ! function_exists( 'wprshrtcd_output_reviews_meta' ) ) {

    /**
     * Output review avatar.
     */
    function wprshrtcd_output_reviews_meta($product_reviews_attr) {
        extract($product_reviews_attr);
        include plugin_dir_path( WPRSHRTCD_FILE )  . 'templates/product-reviews-meta.php';

        // wprshrtcd_get_template( 'product-reviews-meta.php', $product_reviews_attr );
    }
}

if ( ! function_exists( 'wprshrtcd_output_avatar' ) ) {

    /**
     * Output review avatar.
     *
     * @param $comment
     * @param $args
     *
     * @return string
     */
    function wprshrtcd_output_avatar($comment, $args) {
        $args['comment'] = $comment;

        extract($args["shortcode_attr"]);

        if ('no' === $show_pic) {
            return '';
        }

        $_product_id = $comment->comment_post_ID;
        $_product = wc_get_product($_product_id);

        if (empty($_product)) {
            return '';
        }

        if (!empty($show_pic_type) && 'avatar' === $show_pic_type) {
            $thumbnail = get_avatar( $comment, apply_filters( 'woocommerce_review_gravatar_size', '120' ), '' );
        } else {
            $thumbnail = get_the_post_thumbnail( $_product_id, $show_pic_size, array('class' => 'photo') );
        }

        if (!empty($show_product_thumbnail_link) && 'yes' === $show_product_thumbnail_link) {
            if (!empty($review_link_type) && 'comment' === $review_link_type) {
                $permalink = get_comment_link($comment);
            } else {
                $permalink = $_product->get_permalink();
            }

            $thumbnail = '<a href="'.$permalink.'">'.$thumbnail.'</a>';
        }

        wprshrtcd_get_template( 'review/review-avatar.php', array('comment' => $comment, 'thumbnail' => $thumbnail) );
    }
}

if ( ! function_exists( 'wprshrtcd_output_review_title' ) ) {

    /**
     * Output review rating.
     */
    function wprshrtcd_output_review_title($comment, $product_reviews_attr) {
        extract($product_reviews_attr["shortcode_attr"]);

        if (!empty($show_product_item_title) && 'no' === $show_product_item_title) {
            return '';
        }

        $_product_id = $comment->comment_post_ID;
        $_product = wc_get_product($_product_id);

        if (empty($_product)) {
            return '';
        }

        $title = $_product->get_title();

        if (!empty($show_product_item_link) && 'yes' === $show_product_item_link) {
            if (!empty($review_link_type) && 'comment' === $review_link_type) {
                $permalink = get_comment_link($comment);
            } else {
                $permalink = $_product->get_permalink();
            }

            $title = '<a href="'.$permalink.'">'.$title.'</a>';
        }


        wprshrtcd_get_template( 'review/review-title.php', array('comment' => $comment, 'title' => $title) );
    }
}

if ( ! function_exists( 'wprshrtcd_output_review_rating' ) ) {

    /**
     * Output review rating.
     */
    function wprshrtcd_output_review_rating($comment, $product_reviews_attr) {
        extract($product_reviews_attr);
        wprshrtcd_get_template( 'review/review-rating.php', array('comment' => $comment, 'show_schema' => $show_schema) );
    }
}

if ( ! function_exists( 'wprshrtcd_output_review_meta' ) ) {

    /**
     * Output review meta.
     */
    function wprshrtcd_output_review_meta($comment, $product_reviews_attr) {
        extract($product_reviews_attr);
        wprshrtcd_get_template( 'review/review-meta.php', array('comment' => $comment, 'show_schema' => $show_schema) );
    }
}

if ( ! function_exists( 'wprshrtcd_output_review_content' ) ) {

    /**
     * Output review content.
     */
    function wprshrtcd_output_review_content($comment, $product_reviews_attr) {
        extract($product_reviews_attr);
        wprshrtcd_get_template( 'review/review-content.php', array('comment' => $comment, 'show_schema' => $show_schema) );
    }
}



/**
 * Output the Review comments template.
 *
 * @param WP_Comment $comment Comment object.
 * @param array      $args Arguments.
 * @param int        $depth Depth.
 */
function wprshrtcd_comments( $comment, $args, $depth ) {
    global $show_parent;
    global $count;

    $GLOBALS['comment'] = $comment; // WPCS: override ok.
    $is_children = $depth > 1;

    if (!$is_children) {
        $show_parent = wprshrtcd_is_comment_show($comment, $args, $depth);
    }

    if (!$show_parent) {
        return '';
    }

    $show_schema = $args["show_schema"];

    if ('review' !== get_comment_type( $comment->comment_ID ) || $is_children ) {
        $show_schema = false;
    }

    $comment_container_class = '';
    if ($depth === 1 && !empty($args["comment_column_class"])) {
        $comment_container_class = ' ' . $args["comment_column_class"];
    }

    ?>
    <div <?php comment_class($comment_container_class); ?> id="li-comment-<?php comment_ID(); ?>"<?php echo $depth > 1 ? ' style="padding-left:35px;"' : ''; ?><?php echo $show_schema ? ' itemprop="review" itemscope itemtype="http://schema.org/Review"' : ''; ?>>
    <?php

    $show_pic = $args['show_pic'];
    if ($is_children) $show_pic = 'no';
    $show_pic_style = '';
    if ('no' === $show_pic) $args["show_pic"] = 'no';

    wprshrtcd_get_template(
        'review/review.php',

        array(
            'comment' => $comment,
            'args'    => $args,
            'depth'   => $depth,
            'show_schema'   => $args['show_schema'],
            'show_pic'   => $show_pic,
            'show_pic_style' => $show_pic_style,
        )
    );
}

function wprshrtcd_comments_end($comment, $args, $depth) {
    global $count;
    global $show_parent;

    if (!$show_parent) {
        return '';
    }

    $is_children = $depth > 0;
    ?>
    </div>
    <?php

    if (!$is_children && $show_parent) {
        $count++;
    }
}

function wprshrtcd_is_comment_show($comment, $args, $depth) {
    global $count;
    global $show_parent;
    global $authors;
    global $products;

    $show_parent = true;

    $email = get_comment_author_email($comment);
    $product_id = $comment->comment_post_ID;

    if (!empty($email)) {
        if (empty($authors[$email])) {
            $authors[$email][] = $product_id;
        } else {
            //if (!in_array($product_id, $authors[$email])) {
                $authors[$email][] = $product_id;
            //}
        }

        if ($args["show_unique_type"] === 'reviewer') {
            $products_per_author = count($authors[$email]);

            if ($products_per_author > $args["show_unique_amount"]) {
                $show_parent = false;
                return false;
            }
        }

        if ($args["show_unique_type"] === 'reviewer_product') {
            $reviewer_per_product = 0;

            if (!empty($authors[$email])) {
                foreach ($authors[$email] as $reviewer_per_product_id) {
                    if ($product_id === $reviewer_per_product_id) {
                        $reviewer_per_product++;
                    }
                }

                if ($reviewer_per_product > $args["show_unique_amount"]) {
                    $show_parent = false;
                    return false;
                }
            }
        }
    }

    if (!empty($product_id)) {
        if (empty($products[$product_id])) {
            $products[$product_id][] = $email;
        } else {
            if (!in_array($email, $products[$product_id])) {
                $products[$product_id][] = $email;
            }
        }

        $authors_per_product = count($products[$product_id]);

        if ($args["show_unique_type"] === 'product' && $authors_per_product > $args["show_unique_amount"]) {
            $show_parent = false;
            return false;
        }
    }

    if ('-1' !== $args["max_comments"] && (int)$args["max_comments"] < $count) {
        $show_parent = false;
        return false;
    }

    return true;
}

if ( ! function_exists( 'wprshrtcd_output_comments' ) ) {

    /**
     * Output review content.
     */
    function wprshrtcd_output_comments($product_reviews_attr) {
        $shortcode_attr = $product_reviews_attr;
        /**
         * @var $show_schema
         * @var $per_page
         * @var $hide_reviews
         * @var $products_keys
         * @var $show_nested
         * @var $show_pic
         * @var $show_pic_type
         * @var $show_pic_size
         * @var $show_unique_type
         * @var $show_unique_amount
         */
        extract($product_reviews_attr);
        global $count;
        global $authors;
        global $products;

        $count = 1;
        $authors = array();
        $products = array();

        if (
            empty($product_reviews_attr['multicolumn_mode'])
            || 'no' === $product_reviews_attr['multicolumn_mode']
            || empty($product_reviews_attr['multicolumn_mode_desktop'])
            || empty($product_reviews_attr['multicolumn_mode_tablet'])
            || empty($product_reviews_attr['multicolumn_mode_mobile'])
            || empty($product_reviews_attr['multicolumn_mode_desktop_thumb'])
            || empty($product_reviews_attr['multicolumn_mode_tablet_thumb'])
            || empty($product_reviews_attr['multicolumn_mode_mobile_thumb'])
        ) {
            $comment_column_class = 'wptl-col-xs-12';
            $thumb_comment_column_class = 'wptl-col-xs-12 wptl-col-md-3 wptl-col-lg-2';
            $text_comment_column_class = 'wptl-col-xs-12 wptl-col-md-9 wptl-col-lg-10';
        } else {
            $comment_column_class = 'wptl-col-xs-12';
            $thumb_comment_column_class = '';
            $text_comment_column_class = '';

            if ($product_reviews_attr['multicolumn_mode_mobile_thumb'] === 'top') {
                $thumb_comment_column_class .= 'wptl-col-xs-12';
                $text_comment_column_class .= 'wptl-col-xs-12';
            } else {
                $thumb_comment_column_class .= 'wptl-col-xs-4';
                $text_comment_column_class .= 'wptl-col-xs-8';
            }

            if ($product_reviews_attr['multicolumn_mode_tablet_thumb'] === 'top') {
                $thumb_comment_column_class .= ' wptl-col-md-12';
                $text_comment_column_class .= ' wptl-col-md-12';
            } else {
                $thumb_comment_column_class .= ' wptl-col-md-3';
                $text_comment_column_class .= ' wptl-col-md-9';
            }

            if ($product_reviews_attr['multicolumn_mode_desktop_thumb'] === 'top') {
                $thumb_comment_column_class .= ' wptl-col-lg-12';
                $text_comment_column_class .= ' wptl-col-lg-12';
            } else {
                $thumb_comment_column_class .= ' wptl-col-lg-2';
                $text_comment_column_class .= ' wptl-col-lg-10';
            }

            if ($product_reviews_attr['multicolumn_mode_tablet'] === '4_cols') {
                $comment_column_class .= ' wptl-col-md-3';
            } elseif ($product_reviews_attr['multicolumn_mode_tablet'] === '3_cols') {
                $comment_column_class .= ' wptl-col-md-4';
            } elseif ($product_reviews_attr['multicolumn_mode_tablet'] === '2_cols') {
                $comment_column_class .= ' wptl-col-md-6';
            }

            if ($product_reviews_attr['multicolumn_mode_desktop'] === '6_cols') {
                $comment_column_class .= ' wptl-col-lg-2';
            } elseif ($product_reviews_attr['multicolumn_mode_desktop'] === '4_cols') {
                $comment_column_class .= ' wptl-col-lg-3';
            } elseif ($product_reviews_attr['multicolumn_mode_desktop'] === '3_cols') {
                $comment_column_class .= ' wptl-col-lg-4';
            } elseif ($product_reviews_attr['multicolumn_mode_desktop'] === '2_cols') {
                $comment_column_class .= ' wptl-col-lg-6';
            }
        }

        if (!$hide_reviews) {
            $args = array('post__in' => $products_keys);
            $args['status'] = 'approve';
            $comments = get_comments( $args );

            if (!$show_nested) {
                foreach ($comments as $comment_i => $comment_data) {
                    if (!empty($comment_data->comment_parent)) {
                        unset($comments[$comment_i]);
                    }
                }
            }
            ?>

            <div class="commentlist">
                <div class="wptl-row">
                    <?php
                    $comments_args = array(
                        'style' => 'div',
                        'page' => 1,
                        'per_page' => '-1',
                        'max_comments' => $per_page,
                        'reverse_top_level' => false,
                        'show_schema' => $show_schema,
                        'callback' => 'wprshrtcd_comments',
                        'end-callback' => 'wprshrtcd_comments_end',
                        'show_pic' => $show_pic,
                        'show_pic_type' => $show_pic_type,
                        'show_pic_size' => $show_pic_size,
                        'show_unique_type' => $show_unique_type,
                        'show_unique_amount' => $show_unique_amount,
                        'shortcode_attr' => $shortcode_attr,
                        'comment_column_class' => $comment_column_class,
                        'text_comment_column_class' => $text_comment_column_class,
                        'thumb_comment_column_class' => $thumb_comment_column_class,
                    );

                    wp_list_comments($comments_args, $comments);
                    ?>
                </div>
            </div>
            <?php
        }
    }
}