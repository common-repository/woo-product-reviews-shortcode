<?php
$is_premium = wprshrtcd_is_premium();
$shortcodes = wprshrtcd_get_available_shortcodes();
$upgrade_link = wprshrtcd_get_upgrade_url();
$trial_link = wprshrtcd_get_upgrade_url(true);

if (!$is_premium && !empty($shortcodes)) {
    $active_shortcode = $shortcodes;
    $active_shortcode_key = array_keys($active_shortcode)[0];
    $shortcodes = wprshrtcd_get_all_shortcodes();
    unset($shortcodes[$active_shortcode_key]);
    $shortcodes = array_merge($active_shortcode, $shortcodes);
}
?>

<h1><?php echo __('Review Shortcodes List', 'woo-product-reviews-shortcode'); ?></h1>

<div id="wprshrtcd_builder_control">
    <div class="wptl-row">
        <div class="wptl-col-xs-12">
            <p>
                <?php echo wprshrtcd_get_create_new_button(); ?>
            </p>

            <?php
            if (!$is_premium && !empty($shortcodes) && 1 === count($shortcodes)) {
                $free_global_string = sprintf( __( 'In Free version you can create and use only one shortcode. If you want more, please %s or %s.', 'woo-product-reviews-shortcode' ), $upgrade_link, $trial_link );
                ?>
                <p>
                    <?php echo $free_global_string; ?>
                </p>
                <?php
            }
            ?>
        </div>
    </div>
</div>

<table class="wp-list-table widefat fixed striped pages">
    <thead>
    <tr>
        <td class="manage-column column-cb check-column">
            <label class="screen-reader-text" for="cb-select-all-1"><?php echo __( 'Select All', 'woo-product-reviews-shortcode' ) ?></label>
            <input id="cb-select-all-1" type="checkbox" />
        </td>
        <th class="column-primary"><?php _e('Order', 'woo-product-reviews-shortcode'); ?></th>
        <th class="column-shortcode"><?php _e('Shortcode', 'woo-product-reviews-shortcode'); ?></th>
        <th class="date column-date"></th>
    </tr>
    </thead>

    <?php
    if (!empty($shortcodes)) {
        ?>
        <tbody id="the-list">
            <?php
            $i = 1;
            foreach ($shortcodes as $shortcode) {
                ?>
                <tr>
                    <th class="check-column">
                        <input id="cb-select-<?php echo $shortcode->ID; ?>" type="checkbox" value="<?php echo $shortcode->ID; ?>">
                    </th>
                    <td class="column-primary has-row-actions">
                        <?php
                        if ($is_premium || $i < 2) {
                            ?><a title="<?php _e('Edit', 'woo-product-reviews-shortcode'); ?>" href="?page=reviewshort&shortcode_id=<?php echo $shortcode->ID; ?>"><?php
                        }
                        echo $shortcode->post_title;
                        if ($is_premium || $i < 2) {
                            ?></a><?php
                        }
                        ?>

                        <button type="button" class="toggle-row"><span class="screen-reader-text">Show more details</span></button>
                    </td>
                    <td class="column-shortcode" data-colname="<?php _e('Shortcode', 'woo-product-reviews-shortcode'); ?>">
                        <?php
                        if ('draft' !== $shortcode->post_status) {
                            ob_start();
                            ?>
                            <p class="code-example" style="margin: 0 0 5px 0">
                                <span class="code-example-value">[wprshrtcd_woo_product_reviews id="<?php echo $shortcode->ID ?>"]</span>
                                <span class="code-example-copy"><?php echo __('Copy', 'woo-product-reviews-shortcode'); ?></span>
                                <span class="code-example-copied"><?php echo __('Copied. Input into your content!', 'woo-product-reviews-shortcode'); ?></span>
                            </p>

                            <p class="code-example" style="margin: 0">
                                <span class="code-example-value"><?php echo $shortcode->post_content; ?></span>
                                <span class="code-example-copy"><?php echo __('Copy', 'woo-product-reviews-shortcode'); ?></span>
                                <span class="code-example-copied"><?php echo __('Copied. Input into your content!', 'woo-product-reviews-shortcode'); ?></span>
                            </p>
                            <?php
                            $shortcodes_output = ob_get_clean();

                            if ($is_premium) {
                                echo $shortcodes_output;
                            } else {
                                if ($i < 2) {
                                    echo $shortcodes_output;
                                } else {

                                    if (!wprshrtcd_is_trial_utilized()) {
                                        $free_string = sprintf( __( 'In Free version only one shortcode can be active. To get it work again click "Make active" button, %s or %s to activate all shortcodes.', 'woo-product-reviews-shortcode' ), $upgrade_link, $trial_link );
                                    } else {
                                        $free_string = sprintf( __( 'In Free version only one shortcode can be active. To get it work again click "Make active" button or %s to Premium to activate all shortcodes.', 'woo-product-reviews-shortcode' ), $upgrade_link );
                                    }


                                    ?>
                                    <p><?php echo $free_string; ?></p>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </td>
                    <td class="date column-date" data-colname="<?php _e('Actions', 'woo-product-reviews-shortcode'); ?>" style="text-align: right;">
                        <?php
                        if (!$is_premium && $i > 1) {
                            $active_url = wp_nonce_url( "?page=reviewshort&wprshrtcd-active=1&shortcode_id=$shortcode->ID", 'wprshrtcd_active_nonce', '_nonce') ;
                            ?>
                            <a class="button button-small" href="<?php echo $active_url; ?>">
                                <?php _e('Make active', 'more-better-reviews-for-woocommerce'); ?>
                            </a>
                            <?php
                        }

                        if ($is_premium && 'draft' !== $shortcode->post_status) {
                            ?>
                            <button class="wprshrtcd-duplicate button button-small" data-duplicate="<?php echo $shortcode->ID; ?>">
                                <?php _e('Duplicate shortcode', 'more-better-reviews-for-woocommerce'); ?>
                            </button>
                            <?php
                        }
                        ?>
                        <?php
                        $delete_url = wp_nonce_url( "?page=reviewshort&wprshrtcd-delete=1&shortcode_id=$shortcode->ID", 'wprshrtcd_delete_nonce', '_nonce') ;
                        ?>
                        <a class="button button-small" href="<?php echo $delete_url; ?>">
                            <?php _e('Delete', 'more-better-reviews-for-woocommerce'); ?>
                        </a>
                    </td>
                </tr>

                <?php
                $i++;
            }
            ?>
        </tbody>
        <?php
    } else {
        ?>
        <tbody id="the-list">
        <tr>
            <td colspan="4">
                <p style="text-align: center;">
                    <?php echo __('You do not have any shortcode created. Start to build one by clicking "Create new"', 'woo-product-reviews-shortcode'); ?>
                </p>

                <p style="text-align: center;">
                    <?php echo wprshrtcd_get_create_new_button(); ?>
                </p>
            </td>
        </tr>
        </tbody>
        <?php
    }
    ?>

    <tfoot>
    <tr>
        <td class="manage-column column-cb check-column">
            <label class="screen-reader-text" for="cb-select-all-2"><?php echo __( 'Select All', 'woo-product-reviews-shortcode' ) ?></label>
            <input id="cb-select-all-2" type="checkbox" />
        </td>
        <th class="column-primary"><?php _e('Order', 'woo-product-reviews-shortcode'); ?></th>
        <th class="column-shortcode"><?php _e('Shortcode', 'woo-product-reviews-shortcode'); ?></th>
        <th class="date column-date"></th>
    </tr>
    </tfoot>
</table>
