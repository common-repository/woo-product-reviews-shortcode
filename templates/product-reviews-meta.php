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
?>

<h4>
    <span<?php echo $show_schema ? ' itemprop="aggregateRating" itemscope itemtype="https://schema.org/AggregateRating"' : ''; ?>>
        <?php echo __('Average rating', 'woo-product-reviews-shortcode'); ?>:
        <strong<?php echo $show_schema ? ' itemprop="ratingValue' : ''; ?>"><?php echo $products_average; ?></strong>
        <?php echo __('based on', 'woo-product-reviews-shortcode'); ?>
        <strong<?php echo $show_schema ? ' itemprop="ratingCount"' : ''; ?>><?php echo $products_rating_count; ?></strong>
        <?php echo __('reviews', 'woo-product-reviews-shortcode'); ?>
    </span>
</h4>
