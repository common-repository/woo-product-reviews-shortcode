<?php
/**
 * Link to more plugins
 */

$is_premium = wprshrtcd_is_premium();
?>

<div class="wptl-row">
    <div class="wptl-col-xs-12 wptl-col-md-6">
        <div class="wptl-row">
            <div class="wptl-col-xs-12">
                <h3 style="margin: 25px 0 10px 0"><?php echo __('Testing', 'woo-product-reviews-shortcode'); ?></h3>
            </div>

            <div class="wptl-col-xs-12">
                <p style="margin: 0 0 15px 0">
                    <?php echo __('Check your schema.org ratings markup by visting 
<a href="https://search.google.com/test/rich-results" rel="noopener" target="_blank">New google rich snippets tester</a> | 
<a href="https://search.google.com/structured-data/testing-tool/u/0/" rel="noopener" target="_blank">current, soon disabled google rich snippets tester</a></br>
Hint: All Warnings are okay and not needed to show the stars and rating details on google. This warnings only say optional data could be provided.</br>
Hint: Only one "product" element should be found, otherwise google does not know what markup to use. In each shortcode you can "disable schema".</br>Please disable all schemas and leave only one active.</br>
Idea: Leave the schema with the most reviews enabled.
', 'woo-product-reviews-shortcode'); ?>
                </p>
            </div>
        </div>
    </div>

    <div class="wptl-col-xs-12 wptl-col-md-6">
        <div class="wptl-row">
            <div class="wptl-col-xs-12">
                <h3 style="margin: 25px 0 10px 0"><?php echo __('More great plugins', 'woo-product-reviews-shortcode'); ?></h3>
            </div>

            <div class="wptl-col-xs-12">
                <p style="margin: 0 0 15px 0">
                    <?php
                    if ($is_premium) {
                        echo __('With the “<a href="https://wordpress.org/plugins/more-better-reviews-for-woocommerce/" target="_blank">Get Better Reviews for WooCommerce</a>” plugin collecting your customer ratings for your products is automated and easier than ever before.', 'woo-product-reviews-shortcode');
                    } else {
                        echo __('With the “<a href="https://wordpress.org/plugins/more-better-reviews-for-woocommerce/" target="_blank">Get Better Reviews for WooCommerce</a>” plugin collecting your customer ratings for your products is automated and easier than ever before. When you use the trial or the premium version of Get Better Reviews you get the "ReviewShort Plugin" <strong>premium version</strong> activated <strong>for free</strong>.', 'woo-product-reviews-shortcode');
                    }
                    ?>
                </p>

                <p style="margin: 0 0 15px 0">
                    <?php echo __('Please have a look at our other WP.org plugins too by visiting <a href="https://profiles.wordpress.org/tobias_conrad/#content-plugins" target="_blank">Show all plugins on WP.org</a>', 'woo-product-reviews-shortcode'); ?>
                </p>
            </div>
        </div>
    </div>
</div>

