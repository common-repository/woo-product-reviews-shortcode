<?php
add_action( 'admin_enqueue_scripts', 'wprshrtcd_enqueue_scripts' );

function wprshrtcd_enqueue_scripts() {
    if (!empty($_GET['page']) && ($_GET['page'] === 'wprshrtcd-builder' || $_GET['page'] === 'wprshrtcd-help' || $_GET['page'] === 'reviewshort')) {
        wp_enqueue_style( 'woo-product-reviews-shortcode-tipr', plugin_dir_url( __FILE__ ) . 'assets/css/tipr.css', array(), WPRSHRTCD_VERSION, 'all' );
        wp_enqueue_style( 'woo-product-reviews-shortcode', plugin_dir_url( __FILE__ ) . 'assets/css/style.css', array(), WPRSHRTCD_VERSION, 'all' );

        // Create a nonce
        $nonce = wp_create_nonce('wprshrtcd_ajax_nonce');

        wp_enqueue_script( 'woo-product-reviews-shortcode-tipr', plugin_dir_url( __FILE__ ) . 'assets/js/tipr.min.js', array( 'jquery' ), WPRSHRTCD_VERSION . time(), true );
        wp_enqueue_script( 'woo-product-reviews-shortcode', plugin_dir_url( __FILE__ ) . 'assets/js/script.js', array( 'jquery' ), WPRSHRTCD_VERSION . time(), true );

        // Localize the script with your nonce and the AJAX URL
        wp_localize_script('woo-product-reviews-shortcode', 'wprshrtcd_ajax_object', array(
            'nonce' => $nonce,
        ));
    }
}

add_action('admin_menu', 'wprshrtcd_plugin_menu');
add_action('admin_menu', 'wprshrtcd_plugin_menu_optin', 50);

function wprshrtcd_plugin_menu_optin() {
    global $submenu;

    if (function_exists('revrt_fs')) {
        $reconnect_url = revrt_fs()->get_activation_url( array(
            'nonce'     => wp_create_nonce( revrt_fs()->get_unique_affix() . '_reconnect' ),
            'fs_action' => ( revrt_fs()->get_unique_affix() . '_reconnect' ),
        ) );

        $is_registered = revrt_fs()->is_registered();

        if (!$is_registered && isset($submenu["reviewshort"])) {
            $submenu["reviewshort"][] = array(
                __('Opt-in to see account', 'woo-product-reviews-shortcode'),
                'manage_options',
                $reconnect_url
            );
        }
    }

}

function wprshrtcd_plugin_menu() {
    add_menu_page(
        __('ReviewShort', 'woo-product-reviews-shortcode'),
        __('ReviewShort', 'woo-product-reviews-shortcode'),
        'manage_options',
        'reviewshort',
        'wprshrtcd_builder_admin_page',
        'dashicons-id-alt',
        86.5
    );

    add_submenu_page(
        'reviewshort',
        __('How to Use', 'woo-product-reviews-shortcode'),
        __('How to Use', 'woo-product-reviews-shortcode'),
        'manage_options',
        'wprshrtcd-help',
        'wprshrtcd_admin_page'
    );
}

function wprshrtcd_admin_page() {
    include('templates/help.php');
}

function wprshrtcd_builder_admin_page() {
    include('templates/builder.php');
}

/**
 * Generate shortcode on the fly
 *
 * @param $data
 *
 * @return string
 */

function wprshrtcd_error_response($params = array()) {
    $response = array('success' => 0, 'error' => 1);

    if (!empty($params)) {
        $response = array_merge($response, $params);
    }

    echo json_encode($response);
    wp_die();
}

function wprshrtcd_success_response($params = array()) {
    $response = array('success' => 1, 'error' => 0);

    if (!empty($params) && is_array($params)) {
        $response = array_merge($response, $params);
    }

    echo json_encode($response);
    wp_die();
}

if (!empty($_GET['page']) && ($_GET['page'] === 'wprshrtcd-builder' || $_GET['page'] === 'wprshrtcd-help' || $_GET['page'] === 'reviewshort')) {
    add_action( 'init', 'wprshrtcd_redirect' );
}

function wprshrtcd_redirect() {
    if (!is_user_logged_in()) {
        wp_redirect( home_url() );
        exit;
    }

    if (!current_user_can( 'manage_options' )) {
        wp_redirect( admin_url( 'admin.php?page=reviewshort' ) );
        exit;
    }

    $is_premium = wprshrtcd_is_premium();

    if (!empty($_GET['wprshrtcd-create'])) { // Create new shortcode
        if( empty($_GET['_nonce']) || !wp_verify_nonce( $_GET['_nonce'], 'wprshrtcd_create_nonce' ) ) {
            wp_redirect( home_url() );
            exit;
        }

        if (!$is_premium) {
            $shortcodes = wprshrtcd_get_available_shortcodes();

            if (!empty($shortcodes)) {
                wp_redirect( admin_url( 'admin.php?page=reviewshort' ) );
                exit;
            }
        }

        $post = array(
            'post_status' => 'draft',
            'post_title' => __('Review Shortcode', 'woo-product-reviews-shortcode') . ' ' . date('d-m-Y H:i:s'),
            'post_type' => 'review_shortcode',
            'post_content' => '[wprshrtcd_woo_product_reviews]',
        );

        $post_id = wp_insert_post( $post, true );

        if( is_wp_error($post_id) ){

        } else {
            wp_redirect( admin_url( 'admin.php?page=reviewshort&shortcode_id=' . $post_id ) );
            exit;
        }
    }

    if (!empty($_GET['shortcode_id'])) {
        $shortcode_id = sanitize_text_field($_GET['shortcode_id']);

        if (!empty($_GET['wprshrtcd-active'])) {
            if( empty($_GET['_nonce']) || !wp_verify_nonce( $_GET['_nonce'], 'wprshrtcd_active_nonce' ) ) {
                wp_redirect( home_url() );
                exit;
            }
            $active_shortcode_id = wprshrtcd_get_active_shortcode_id();

            if (!empty($active_shortcode_id)) {
                delete_post_meta($active_shortcode_id, 'wprshrtcd_active');
            }

            add_post_meta($shortcode_id, 'wprshrtcd_active', 1);
            wp_redirect( admin_url( 'admin.php?page=reviewshort' ) );

            exit;
        } elseif (!empty($_GET['wprshrtcd-delete'])) { // Delete shortcode
            if( empty($_GET['_nonce']) || !wp_verify_nonce( $_GET['_nonce'], 'wprshrtcd_delete_nonce' ) ) {
                wp_redirect( home_url() );
                exit;
            }
            wp_delete_post( $shortcode_id, true );
            wp_redirect( admin_url( 'admin.php?page=reviewshort' ) );

            exit;
        } else { // Edit shortcode
            $shortcodes = wprshrtcd_get_available_shortcodes();

            if (empty($shortcodes[$shortcode_id])) {
                wp_redirect( admin_url( 'admin.php?page=reviewshort' ) );
                exit;
            }
        }
    }
}

function wprshrtcd_get_reviews_product() {
    $products_args = array(
        'numberposts' => '-1',
        'orderby'     => 'title',
        'order'       => 'DESC',
        'post_type'   => 'product',
        'suppress_filters' => false,
        'status'    => 'publish',
    );

    $_products = wc_get_products( $products_args );
    $product_types = wc_get_product_types();
    $products = array();

    if (!empty($_products)) {
        foreach ($_products as $_product) {
            $product_type = $_product->get_type();
            if (!empty($product_types[$product_type])) {
                $product_type = $product_types[$product_type];
            }
            $products[$_product->get_id()] = $_product->get_title() . ' (' . $product_type . ')';
        }
    }

    return $products;
}

add_action( 'init', 'wprshrtcd_rewrite_rule' );

function wprshrtcd_rewrite_rule() {
    flush_rewrite_rules();

    add_rewrite_rule('^wprshrtcd-shortcode-preview/(.*)/?', 'index.php?preview_shortcode_id=$matches[1]', 'top');
    add_rewrite_tag( '%preview_shortcode_id%', '([^&]+)' );
}

add_action( 'template_redirect', 'wprshrtcd_template_redirect' );

function wprshrtcd_template_redirect() {
    $preview_shortcode_id = get_query_var('preview_shortcode_id');

    if (!empty($preview_shortcode_id)) {
        $shortcode_post = get_post($preview_shortcode_id);

        if (empty($shortcode_post) || 'review_shortcode' !== $shortcode_post->post_type) {
            // TODO - Add Wrong post handler
            return;
        }

        $params = $_GET;

        $shortcode = wprshrtcd_generate_shortcode($params);

        global $content_width;

        $content_width = $content_width . 'px';

        $content_width = '900px';

        get_header();
        ?>
        <div id="style-preview-container" class="woocommerce" style="max-width: <?php echo $content_width ?>; margin: auto; padding: 20px;">
            <?php echo do_shortcode($shortcode); ?>
        </div>
        <?php
        get_footer();
        die;
    }
}

function wprshrtcd_get_available_shortcodes() {
    $is_premium = wprshrtcd_is_premium();

    $args = array (
        'numberposts' => '-1',
        'category'    => 0,
        'orderby'     => 'ID',
        'order'       => 'DESC',
        'include'     => array(),
        'exclude'     => array(),
        'meta_key'    => '',
        'meta_value'  =>'',
        'post_status'  =>'publish,draft',
        'post_type'   => 'review_shortcode',
        'suppress_filters' => false, // подавление работы фильтров изменения SQL запроса
    );

    if (!$is_premium) {

        $active_shortcode_id = wprshrtcd_get_active_shortcode_id();

        if (!empty($active_shortcode_id)) {
            $args['include'] = $active_shortcode_id;
        } else {
            $args['numberposts'] = 1;
            $args['order'] = 'ASC';
        }
    }

    $shortcodes = get_posts( $args );
    $shortcodes_by_id = array();

    if (!empty($shortcodes)) {
        foreach ($shortcodes as $shortcode) {
            $shortcodes_by_id[$shortcode->ID] = $shortcode;
        }
    }

    return $shortcodes_by_id;
}

function wprshrtcd_get_active_shortcode_id() {
    global $wpdb;
    $active_shortcode_sql = "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = 'wprshrtcd_active'";
    $active_shortcode_id_array = $wpdb->get_row( $active_shortcode_sql, ARRAY_A );

    if (!empty($active_shortcode_id_array)) {
        $active_shortcode_id = $active_shortcode_id_array['post_id'];
        $shortcode = get_post($active_shortcode_id);

        if (!empty($shortcode) && $shortcode->post_type === 'review_shortcode' && in_array($shortcode->post_status, array('publish','draft'))) {
            return $active_shortcode_id;
        }
    }

    return false;
}

function wprshrtcd_get_all_shortcodes() {
    $args = array (
        'numberposts' => '-1',
        'category'    => 0,
        'orderby'     => 'ID',
        'order'       => 'ASC',
        'include'     => array(),
        'exclude'     => array(),
        'meta_key'    => '',
        'meta_value'  =>'',
        'post_status'  =>'publish,draft',
        'post_type'   => 'review_shortcode',
        'suppress_filters' => false, // подавление работы фильтров изменения SQL запроса
    );

    $shortcodes = get_posts( $args );
    $shortcodes_by_id = array();

    if (!empty($shortcodes)) {
        foreach ($shortcodes as $shortcode) {
            $shortcodes_by_id[$shortcode->ID] = $shortcode;
        }
    }

    return $shortcodes_by_id;
}

function wprshrtcd_get_templates() {
    return array(
        'product-reviews-title' => array(
            'path' => 'product-reviews-title.php',
            'template_file' => ''
        ),
        'review-avatar' => array(
            'path' => 'review/review-avatar.php',
            'template_file' => ''
        ),
        'review-meta' => array(
            'path' => 'review/review-meta.php',
            'template_file' => ''
        ),
        'review-rating' => array(
            'path' => 'review/review-rating.php',
            'template_file' => ''
        ),
        'review-content' => array(
            'path' => 'review/review-content.php',
            'template_file' => ''
        ),
    );
}

function wprshrtcd_get_default_attr() {
    return array(
        'products_ids_select' => 'all',
        'products_ids' => '',
        'product_title' => '',
        'per_page_select' => 'custom',
        'per_page' => '5',
        'show_schema' => 'yes',
        'show_nested' => 'no',
        'show_pic' => 'yes',
        'show_pic_type' => 'thumbnail',
        'show_pic_size' => 'thumbnail',
        'show_unique_type' => 'all',
        'show_unique_amount' => '1',
        'show_product_item_title' => 'yes',
        'show_product_item_link' => 'no',
        'show_product_thumbnail_link' => 'no',
        'review_link_type' => 'product',
        'multicolumn_mode' => 'yes',
        'multicolumn_mode_desktop' => '3_cols',
        'multicolumn_mode_desktop_thumb' => 'left',
        'multicolumn_mode_tablet' => '2_cols',
        'multicolumn_mode_tablet_thumb' => 'left',
        'multicolumn_mode_mobile' => '1_col',
        'multicolumn_mode_mobile_thumb' => 'top',

    );
}

function wprshrtcd_generate_shortcode($data) {
    $is_premium = wprshrtcd_is_premium();

    $shortcode = '[wprshrtcd_woo_product_reviews';

    if (!empty($data["products_ids_select"]) && 'all' === $data["products_ids_select"]) {
        $shortcode .= ' products_ids="all"';
    } else {
        if (!empty($data['products_ids'])) {
            $shortcode .= ' products_ids="'.$data['products_ids'].'"';
        }
    }

    if (!empty($data["product_title"])) {
        $shortcode .= ' product_title="'.$data['product_title'].'"';
    }

    if (!empty($data["show_schema"])) {
        if ('no' === $data["show_schema"]) {
            $shortcode .= ' show_schema="'.$data['show_schema'].'"';
        }
    }

    $show_review = true;

    if (!empty($data["per_page_select"])) {
        if ('all' === $data["per_page_select"]) {
            $shortcode .= ' per_page="all"';
        } elseif ('no' === $data["per_page_select"]) {
            $shortcode .= ' per_page="0"';
            $show_review = false;
        } else {
            if (isset($data["per_page"])) {
                $shortcode .= ' per_page="'.$data['per_page'].'"';
            } else {
                $shortcode .= ' per_page="5"';
            }
        }
    } else {
        if (isset($data["per_page"])) {
            $shortcode .= ' per_page="'.$data['per_page'].'"';
        } else {
            $shortcode .= ' per_page="5"';
        }
    }

    if ($show_review) {
        if (!empty($data["show_nested"])) {
            if ('yes' === $data["show_nested"]) {
                $shortcode .= ' show_nested="'.$data['show_nested'].'"';
            }
        }

        if (!empty($data["show_pic"])) {
            if ('no' === $data["show_pic"]) {
                $shortcode .= ' show_pic="'.$data['show_pic'].'"';
            } else {
                if ('avatar' === $data["show_pic_type"]) {
                    $shortcode .= ' show_pic_type="'.$data['show_pic_type'].'"';
                } else {
                    if ('thumbnail' !== $data["show_pic_size"]) {
                        $shortcode .= ' show_pic_size="'.$data['show_pic_size'].'"';
                    }

                    if (!empty($data["show_product_thumbnail_link"]) && 'yes' === $data["show_product_thumbnail_link"]) {
                        $shortcode .= ' show_product_thumbnail_link="'.$data['show_product_thumbnail_link'].'"';
                    }
                }
            }
        }

        if (!empty($data["show_unique_type"])) {
            if ('all' !== $data["show_unique_type"]) {
                $shortcode .= ' show_unique_type="'.$data['show_unique_type'].'"';

                if (!empty($data["show_unique_amount"])) {
                    $shortcode .= ' show_unique_amount="'.$data['show_unique_amount'].'"';
                } else {
                    $shortcode .= ' show_unique_amount="1"';
                }
            }
        }

        if (!empty($data["show_product_item_title"])) {
            if ('no' === $data["show_product_item_title"]) {
                $shortcode .= ' show_product_item_title="'.$data['show_product_item_title'].'"';
            } else {
                if (!empty($data["show_product_item_link"]) && 'yes' === $data["show_product_item_link"]) {
                    $shortcode .= ' show_product_item_link="'.$data['show_product_item_link'].'"';
                }
            }
        }

        if (
            (!empty($data['show_product_item_link'] && 'yes' === $data["show_product_item_link"])) ||
            (!empty($data['show_product_thumbnail_link'] && 'yes' === $data["show_product_thumbnail_link"]))
        ) {
            if (!empty($data['review_link_type']) && 'comment' === $data['review_link_type']) {
                $shortcode .= ' review_link_type="'.$data['review_link_type'].'"';
            }
        }
    }

    if (
        !empty($is_premium)
        && !empty($data['multicolumn_mode']) && 'yes' === $data['multicolumn_mode']
        && !empty($data['multicolumn_mode_desktop'])
        && !empty($data['multicolumn_mode_desktop_thumb'])
        && !empty($data['multicolumn_mode_tablet'])
        && !empty($data['multicolumn_mode_tablet_thumb'])
        && !empty($data['multicolumn_mode_mobile'])
        && !empty($data['multicolumn_mode_mobile_thumb'])
    ) {
        $shortcode .= ' multicolumn_mode="yes"';
        $shortcode .= ' multicolumn_mode_desktop="'.$data['multicolumn_mode_desktop'].'"';
        $shortcode .= ' multicolumn_mode_desktop_thumb="'.$data['multicolumn_mode_desktop_thumb'].'"';
        $shortcode .= ' multicolumn_mode_tablet="'.$data['multicolumn_mode_tablet'].'"';
        $shortcode .= ' multicolumn_mode_tablet_thumb="'.$data['multicolumn_mode_tablet_thumb'].'"';
        $shortcode .= ' multicolumn_mode_mobile="'.$data['multicolumn_mode_mobile'].'"';
        $shortcode .= ' multicolumn_mode_mobile_thumb="'.$data['multicolumn_mode_mobile_thumb'].'"';
    }

    $shortcode .= ']';

    return $shortcode;
}

/**
 * Ajax Functions
 */

add_action('wp_ajax_wprshrtcd_save_settings', 'wprshrtcd_save_settings');

function wprshrtcd_save_settings() {
    check_ajax_referer( 'wprshrtcd_ajax_nonce', 'nonce' );

    if (!is_user_logged_in() || !current_user_can('manage_options')) {
        wprshrtcd_error_response(array(
            'message' => __('Cheating, hah?', 'woo-product-reviews-shortcode')
        ));
    }
    if (empty($_POST['formData']) || !is_array($_POST['formData'])) {
        $params = array(
            'message' => __('Cheating, hah?', 'woo-product-reviews-shortcode')
        );

        wprshrtcd_error_response($params);
    }

    $data = array();

    foreach ($_POST['formData'] as $form_data) {
        $data[sanitize_text_field($form_data['name'])] = sanitize_text_field($form_data['value']);
    }

    if ('yes' === $data["show_schema"] && empty(trim($data["product_title"]))) {
        $params = array(
            'message' => __('If schema is enabled "Set reviews section title" field is required to prevent error "The review does not have a reviewed item with a name specified. A value for the name field is required." in Structured Data', 'woo-product-reviews-shortcode')
        );

        wprshrtcd_error_response($params);
    }

    $post = array(
        'ID' => $data["post_id"],
        'post_status' => 'publish',
        'post_title' => $data["post_title"],
        'post_type' => 'review_shortcode',
    );

    if (!empty($data["products_ids_select"]) && 'all' === $data["products_ids_select"]) {
        $data['products_ids'] = '';
    }

    $shortcode = wprshrtcd_generate_shortcode($data);

    $post['post_content'] = $shortcode;

    unset($data["post_title"]);
    unset($data["post_id"]);

    $post_id = wp_insert_post( wp_slash($post), true );
    $post_meta = update_post_meta( $post_id, 'shortcode_settings', $data);

    $params = array(
        'message' => __('Saved', 'woo-product-reviews-shortcode'),
        'reload' => 1,
    );

    wprshrtcd_success_response($params);
}

add_action('wp_ajax_wprshrtcd_duplicate_settings', 'wprshrtcd_duplicate_settings');

function wprshrtcd_duplicate_settings() {
    check_ajax_referer( 'wprshrtcd_ajax_nonce', 'nonce' );

    if (!is_user_logged_in() || !current_user_can('manage_options')) {
        wprshrtcd_error_response(array(
            'message' => __('Cheating, hah?', 'woo-product-reviews-shortcode')
        ));
    }
    $duplicate = !empty($_POST['duplicate']) ? $_POST['duplicate'] : false;

    if (empty($duplicate)) {
        $params = array(
            'message' => __('Select shortcode', 'woo-product-reviews-shortcode')
        );

        wprshrtcd_error_response($params);
    }

    $origin_shortcode = get_post( $duplicate );
    $origin_shortcode_settings = get_post_meta( $duplicate, 'shortcode_settings', true );
    $old_post_title = $origin_shortcode->post_title;

    $post = array(
        'post_status' => 'publish',
        'post_title' => $old_post_title . ' (' . __('Copy', 'woo-product-reviews-shortcode') . ')',
        'post_type' => 'review_shortcode',
        'post_content' => $origin_shortcode->post_content,
    );

    $post_id = wp_insert_post( $post, true );

    if( is_wp_error($post_id) ){
        $params = array(
            'message' => __('Not duplicated', 'woo-product-reviews-shortcode')
        );

        wprshrtcd_error_response($params);
    } else {
        $post_meta = update_post_meta( $post_id, 'shortcode_settings', $origin_shortcode_settings);
    }

    $params = array(
        'message' => __('Duplicated', 'woo-product-reviews-shortcode'),
        'url' => admin_url( 'admin.php?page=reviewshort&shortcode_id=' . $post_id ),
    );

    wprshrtcd_success_response($params);
}

add_action('wp_ajax_wprshrtcd_copy_template', 'wprshrtcd_copy_template');

function wprshrtcd_copy_template() {
    check_ajax_referer( 'wprshrtcd_ajax_nonce', 'nonce' );

    if (!is_user_logged_in() || !current_user_can('manage_options')) {
        wprshrtcd_error_response(array(
            'message' => __('Cheating, hah?', 'woo-product-reviews-shortcode')
        ));
    }
    $template = !empty($_POST['template']) ? $_POST['template'] : false;

    if (empty($template)) {
        $params = array(
            'message' => __('Select template', 'woo-product-reviews-shortcode')
        );

        wprshrtcd_error_response($params);
    }

    $templates = wprshrtcd_get_templates();

    if (empty($templates[$template])) {
        $params = array(
            'message' => __('No such template', 'woo-product-reviews-shortcode')
        );

        wprshrtcd_error_response($params);
    }

    $theme_file_path = get_stylesheet_directory() . '/woocommerce/wprshrtcd/' . $templates[$template]['path'];
    $default_file_path = untrailingslashit( plugin_dir_path( WPRSHRTCD_FILE ) ) . '/templates/' . $templates[$template]['path'];

    if (!file_exists($default_file_path)) {
        $params = array(
            'message' => __('No such template', 'woo-product-reviews-shortcode')
        );

        wprshrtcd_error_response($params);
    }

    if (file_exists($theme_file_path)) {
        $params = array(
            'message' => __('Template already exists', 'woo-product-reviews-shortcode')
        );

        wprshrtcd_error_response($params);
    }

    if ( wp_mkdir_p( dirname( $theme_file_path ) ) ) {
        copy( $default_file_path, $theme_file_path );

        $params = array(
            'message' => __('Copied', 'woo-product-reviews-shortcode'),
            'reload' => 1,
        );

        wprshrtcd_success_response($params);
    }

    $params = array(
        'message' => __('Template could not be copied, check your folder write permission', 'woo-product-reviews-shortcode')
    );

    wprshrtcd_error_response($params);
}

add_action('wp_ajax_wprshrtcd_delete_template', 'wprshrtcd_delete_template');

function wprshrtcd_delete_template() {
    check_ajax_referer( 'wprshrtcd_ajax_nonce', 'nonce' );

    if (!is_user_logged_in() || !current_user_can('manage_options')) {
        wprshrtcd_error_response(array(
            'message' => __('Cheating, hah?', 'woo-product-reviews-shortcode')
        ));
    }
    $template = !empty($_POST['template']) ? $_POST['template'] : false;

    if (empty($template)) {
        $params = array(
            'message' => __('Select template', 'woo-product-reviews-shortcode')
        );

        wprshrtcd_error_response($params);
    }

    $templates = wprshrtcd_get_templates();

    if (empty($templates[$template])) {
        $params = array(
            'message' => __('No such template', 'woo-product-reviews-shortcode')
        );

        wprshrtcd_error_response($params);
    }

    $theme_file_path = get_stylesheet_directory() . '/woocommerce/wprshrtcd/' . $templates[$template]['path'];

    if (!file_exists($theme_file_path)) {
        $params = array(
            'message' => __('No such template', 'woo-product-reviews-shortcode')
        );

        wprshrtcd_error_response($params);
    }

    unlink( $theme_file_path );

    $params = array(
        'message' => __('Deleted', 'woo-product-reviews-shortcode'),
        'reload' => 1,
    );

    wprshrtcd_success_response($params);
}

function wprshrtcd_tipr($tipr) {
    ?>
    <span class="dashicons dashicons-editor-help wptl-tip" data-tip="<?php echo $tipr; ?>"></span>
    <?php
}

function wprshrtcd_get_all_image_sizes() {
    global $_wp_additional_image_sizes;

    $default_image_sizes = get_intermediate_image_sizes();

    foreach ( $default_image_sizes as $size ) {
        $image_sizes[ $size ][ 'width' ] = intval( get_option( "{$size}_size_w" ) );
        $image_sizes[ $size ][ 'height' ] = intval( get_option( "{$size}_size_h" ) );
        $image_sizes[ $size ][ 'crop' ] = get_option( "{$size}_crop" ) ? get_option( "{$size}_crop" ) : false;
    }

    if ( isset( $_wp_additional_image_sizes ) && count( $_wp_additional_image_sizes ) ) {
        $image_sizes = array_merge( $image_sizes, $_wp_additional_image_sizes );
    }

    return $image_sizes;
}

function wprshrtcd_get_create_new_button() {
    $create_url = wp_nonce_url( "?page=reviewshort&wprshrtcd-create=1", 'wprshrtcd_create_nonce', '_nonce') ;
    ob_start();
    ?>
    <a class="button" href="<?php echo $create_url; ?>">
        <?php _e('Create new', 'woo-product-reviews-shortcode'); ?>
    </a>
    <?php
    $button = ob_get_clean();

    if (wprshrtcd_is_premium()) {
        return $button;
    }

    $shortcodes = wprshrtcd_get_available_shortcodes();

    if (empty($shortcodes)) {
        return $button;
    }

    return '';
}
