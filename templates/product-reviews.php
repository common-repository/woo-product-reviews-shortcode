<?php
/**
 * @var $products_array
 * @var $products_keys
 * @var $per_page
 * @var $product_title
 * @var $products_rating_count
 * @var $products_review_count
 * @var $products_average
 * @var $show_schema
 * @var $show_nested
 * @var $hide_reviews
 * @var $product_reviews_attr
 */

/**
 * Hook: wprshrtcd_before_reviews_container.
 */
do_action( 'wprshrtcd_before_reviews_container' );

if (empty($products_array)) return;

if (!empty($products_array)) {
    $args = array('post__in' => $products_keys);
    $product_title = !empty($product_title) ? $product_title : get_the_title($products_keys[0]);
    ?>
    <div class="woocommerce-tabs woocommerce">
        <div id="reviews" class="product-reviews-container"<?php echo $show_schema ? ' itemscope itemtype="http://schema.org/Product"' : ''; ?>>
            <?php
            /**
             * wprshrtcd_before_comments hook.
             */
            do_action( 'wprshrtcd_before_comments', $product_reviews_attr );

            /**
             * wprshrtcd_comments hook.
             */
            do_action( 'wprshrtcd_comments', $product_reviews_attr );

            /**
             * wprshrtcd_after_comments hook.
             */
            do_action( 'wprshrtcd_after_comments', $product_reviews_attr );
            ?>
        </div>
    </div>
<?php
}

/**
 * Hook: wprshrtcd_after_reviews_container.
 */
do_action( 'wprshrtcd_after_reviews_container' );
?>