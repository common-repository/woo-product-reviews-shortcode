<?php
/**
 * The template to display the review product title
 *
 * @var $comment
 * @var $title
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.
if (empty($comment) || empty($title)) return; // Return if no comment or title
?>
<h4 style="margin-bottom: 0;margin-top:0;" class="<?php echo esc_attr( apply_filters( 'woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title' ) ) ?>"><?php echo $title; ?></h4>