<?php
/**
 * Shortcodes library functions
 *
 * @since      0.0.1
 */

function wprshrtcd_woo_product_reviews_shrortcode($attr = array()) {
    $is_premium = wprshrtcd_is_premium();

    if (!empty($attr["id"])) {
        $id = $attr["id"];

        if (!$is_premium) {
            $available_shortcodes = wprshrtcd_get_available_shortcodes();


            if (empty($available_shortcodes[$id])) {
                return '';
            }
        }

        $shortcode = get_post($id);

        if (empty($shortcode) || $shortcode->post_type !== 'review_shortcode' || $shortcode->post_status !== 'publish') {
            return '';
        }

        $shortcode_default_settings = wprshrtcd_get_default_attr();
        $shortcode_settings = get_post_meta($id, 'shortcode_settings', true);

        if (empty($shortcode_settings)) {
            $shortcode_settings = $shortcode_default_settings;
        } else {
            if (empty($shortcode_settings['multicolumn_mode'])) {
                $shortcode_default_settings['multicolumn_mode'] = 'no';
            }
            $shortcode_settings = array_merge($shortcode_default_settings, $shortcode_settings);
        }

        $attr = $shortcode_settings;
    }

    $atts = shortcode_atts(
        wprshrtcd_get_default_attr(),
        $attr
    );

    if (!$is_premium) {
        $atts['multicolumn_mode'] = 'no';
    }

    if ($atts['multicolumn_mode'] === 'no') {
        $atts['multicolumn_mode_desktop'] = '1_col';
        $atts['multicolumn_mode_desktop_thumb'] = 'left';
        $atts['multicolumn_mode_tablet'] = '1_col';
        $atts['multicolumn_mode_tablet_thumb'] = 'left';
        $atts['multicolumn_mode_mobile'] = '1_col';
        $atts['multicolumn_mode_mobile_thumb'] = 'top';
    }

    if (!empty($attr["products_ids_select"]) && 'all' === $attr["products_ids_select"]) {
        $product_ids = 'all';
    } else {
        $product_ids = !empty($attr['products_ids']) ? $attr['products_ids'] : '';
    }


    if (empty($product_ids)) {
        return '';
    }

    if ('all' === $product_ids) {
        global $wpdb;
        $sql = "SELECT ID FROM {$wpdb->posts} WHERE post_type = 'product' AND post_status = 'publish'";
        $result = $wpdb->get_results( $sql, ARRAY_A);

        if (!empty($result)) {
            $product_ids_array = array();

            foreach ($result as $item) {
                $product_ids_array[] = $item['ID'];
            }
        }
    } else {
        $product_ids_array = explode(',', $product_ids);
    }

    $products_array = array();
    $products_rating_count = 0;
    $products_review_count = 0;
    $products_average_array = array();

    if (!empty($product_ids_array)) {
        foreach ($product_ids_array as $product_id) {
            $product = wc_get_product($product_id);

            if (!empty($product) && 'grouped' !== $product->get_type()) {
                $products_array[$product_id] = $product;

                $rating_count = $product->get_rating_count();
                $review_count = $product->get_review_count();
                $average      = $product->get_average_rating();

                if (!empty($rating_count)) {
                    $products_rating_count = $products_rating_count + $rating_count;
                }

                if (!empty($review_count)) {
                    $products_review_count = $products_review_count + $review_count;
                }

                if (!empty($average)) {
                    $products_average_array[] = $average;
                }
            }
        }
    }

    if (empty($products_array)) {
        return '';
    }

    $products_keys = array_keys($products_array);

    $products_average = 0;

    if (!empty($products_average_array)) {

        foreach ($products_average_array as $products_average_item) {
            $products_average = (float) $products_average + (float) $products_average_item;
        }

        if (!empty($products_average)) {
            $products_average = round($products_average / count($products_average_array) , 2);
        }
    }

    $show_schema = 'yes' === $atts['show_schema'] ? true : false;
    $show_nested = 'yes' === $atts['show_nested'] ? true : false;
    $per_page = $atts['per_page'];

    if ('all' === $per_page) {
        $atts['per_page_select'] = 'all';
    }

    if (!empty($atts['per_page_select']) && 'all' === $atts['per_page_select']) {
        $per_page = '-1';
    } elseif (!empty($atts['per_page_select']) && 'no' === $atts['per_page_select']) {
        $per_page = 0;
    }

    $hide_reviews = false;

    if (0 === $per_page || '0' === $per_page) {
        $hide_reviews = true;
    }

    if (empty($atts['product_title'])) {
        $_product = wc_get_product($products_keys[0]);
        if (!empty($_product)) {
            $title = $_product->get_title();
            $atts['product_title'] = $title;
        }
    }

    $args = array(
        'products_array' => $products_array,
        'products_keys' => $products_keys,
        'product_title' => $atts['product_title'],
        'per_page' => $per_page,
        'show_schema' => $show_schema,
        'show_nested' => $show_nested,
        'products_rating_count' => $products_rating_count,
        'products_review_count' => $products_review_count,
        'products_average' => $products_average,
        'hide_reviews' => $hide_reviews,
        'show_pic' => $atts['show_pic'],
        'show_pic_type' => $atts['show_pic_type'],
        'show_pic_size' => $atts['show_pic_size'],
        'show_unique_type' => $atts['show_unique_type'],
        'show_unique_amount' => $atts['show_unique_amount'],
        'show_product_item_title' => $atts["show_product_item_title"],
        'show_product_item_link' => $atts["show_product_item_link"],
        'show_product_thumbnail_link' => $atts["show_product_thumbnail_link"],
        'review_link_type' => $atts["review_link_type"],
        'multicolumn_mode' => !empty($atts["multicolumn_mode"]) ? $atts["multicolumn_mode"] : 'no',
        'multicolumn_mode_desktop' => $atts["multicolumn_mode_desktop"],
        'multicolumn_mode_desktop_thumb' => $atts["multicolumn_mode_desktop_thumb"],
        'multicolumn_mode_tablet' => $atts["multicolumn_mode_tablet"],
        'multicolumn_mode_tablet_thumb' => $atts["multicolumn_mode_tablet_thumb"],
        'multicolumn_mode_mobile' => $atts["multicolumn_mode_mobile"],
        'multicolumn_mode_mobile_thumb' => $atts["multicolumn_mode_mobile_thumb"],
    );

    $product_reviews_attr = $args;
    $args['product_reviews_attr'] = $product_reviews_attr;

    ob_start();
    include plugin_dir_path( WPRSHRTCD_FILE )  . 'templates/product-reviews.php';
    return ob_get_clean();
}
add_shortcode( 'wprshrtcd_woo_product_reviews', 'wprshrtcd_woo_product_reviews_shrortcode' );