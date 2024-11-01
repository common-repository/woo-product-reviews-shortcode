<?php
/**
 * @var $shortcode_id
 */
$is_premium = wprshrtcd_is_premium();
$shortcodes = wprshrtcd_get_available_shortcodes();
$upgrade_link = wprshrtcd_get_upgrade_url();
$trial_link = wprshrtcd_get_upgrade_url(true);

$shortcode_post = get_post($shortcode_id);

if (empty($shortcode_post) || 'review_shortcode' !== $shortcode_post->post_type) {
    // TODO - Add Wrong post handler
    return;
}

$shortcode_default_settings = wprshrtcd_get_default_attr();
$shortcode_settings = get_post_meta($shortcode_id, 'shortcode_settings', true);

if (empty($shortcode_settings)) {
    $shortcode_settings = $shortcode_default_settings;
} else {
    if (empty($shortcode_settings['multicolumn_mode'])) {
        $shortcode_default_settings['multicolumn_mode'] = 'no';
    }
    $shortcode_settings = array_merge($shortcode_default_settings, $shortcode_settings);
}

$shortcode_title = !empty($shortcode_post->post_title) ? $shortcode_post->post_title : '';
$shortcode_content = !empty($shortcode_post->post_content) ? $shortcode_post->post_content : '[wprshrtcd_woo_product_reviews]';
$products =  wprshrtcd_get_reviews_product();
?>

<h1><?php echo __('Review Shortcodes Edit', 'woo-product-reviews-shortcode'); ?></h1>

<?php echo '<a class="button button-small" href="' . esc_url(get_admin_url(null, 'admin.php?page=reviewshort')) . '">'. __( "Shortcodes list", 'woo-product-reviews-shortcode' ) .'</a>'; ?>

<div id="poststuff">
    <div id="post-body">
        <form id="wprshrtcd_save_settings_form">
                <div class="wptl-row">
                    <div class="wptl-col-xs-12 wptl-col-md-8 wptl-col-lg-9">
                        <div id="post-body-content">
                            <div id="titlediv">
                                <div id="titlewrap">
                                    <label class="screen-reader-text" id="title-prompt-text" for="title">
                                        <?php echo __('Add title', 'woo-product-reviews-shortcode'); ?>
                                    </label>

                                    <input type="text" name="post_title" size="30" value="<?php echo $shortcode_title; ?>" id="title" spellcheck="true" autocomplete="off">

                                    <input type="hidden" class="form-input" id="preview_url" value="">
                                    <input type="hidden" class="form-input" id="request_params" value="">
                                    <input type="hidden" class="form-input" id="request_url" value='<?php echo get_site_url(); ?>/wprshrtcd-shortcode-preview/<?php echo $shortcode_id ?>?preview_shortcode_id=<?php echo $shortcode_id ?>&on_load=1'>
                                </div>

                                <div class="inside">
                                    <p class="code-example" style="margin-bottom: 0;">
                                        <span class="code-example-value">[wprshrtcd_woo_product_reviews id="<?php echo $shortcode_id ?>"]</span>
                                        <span class="code-example-copy"><?php echo __('Copy', 'woo-product-reviews-shortcode'); ?></span>
                                        <span class="code-example-copied"><?php echo __('Copied. Input into your content!', 'woo-product-reviews-shortcode'); ?></span>
                                    </p>

                                    <p style="margin: 5px 0 10px 0;">
                                        <?php echo __('You can use this shortcode if you do not want to add manual changes to shortcodes on your pages. If you make changes in settings changes will be applied on all pages at once. If you delete this Shortcode no reviews will be shown.', 'woo-product-reviews-shortcode'); ?>
                                    </p>
                                </div>

                                <div class="inside">
                                    <p class="code-example" style="margin-bottom: 0;">
                                        <span class="code-example-value"><?php echo $shortcode_content; ?></span>
                                        <span class="code-example-copy"><?php echo __('Copy', 'woo-product-reviews-shortcode'); ?></span>
                                        <span class="code-example-copied"><?php echo __('Copied. Input into your content!', 'woo-product-reviews-shortcode'); ?></span>
                                    </p>

                                    <p style="margin: 5px 0 25px 0;">
                                        <?php echo __('You can use this shortcode if you are going to make changes manualy. If you delete this Shortcode reviews still will be shown.', 'woo-product-reviews-shortcode'); ?>
                                    </p>
                                </div>
                            </div>

                            <div class="wptl-row">
                                <div class="wptl-col-xs-12 wptl-col-md-6">

                                    <div class="wptl-row">
                                        <div class="wptl-col-xs-12 wptl-col-lg-5">
                                            <h4 class="wptl-tip-container" style="margin:5px 0">
                                                <label for="products_ids">
                                                    <?php echo __('Set reviews section title', 'woo-product-reviews-shortcode'); ?>
                                                    <?php
                                                    $tip = __('If you enabled schema this field is required to prevent error "The review does not have a reviewed item with a name specified. A value for the name field is required." in Structured Data', 'woo-product-reviews-shortcode');
                                                    wprshrtcd_tipr(sanitize_text_field($tip));
                                                    ?>
                                                </label>
                                            </h4>
                                        </div>

                                        <div class="wptl-col-xs-12 wptl-col-lg-7">
                                            <p style="margin:5px 0">
                                                <input type="text" class="form-input" name="product_title" value="<?php echo $shortcode_settings['product_title'] ?>" id="product_title">
                                            </p>
                                        </div>
                                    </div>

                                    <div class="wptl-row">
                                        <div class="wptl-col-xs-12 wptl-col-lg-5">
                                            <h4 style="margin:5px 0" class="wptl-tip-container">
                                                <label for="products_ids">
                                                    <?php echo __('Select products', 'woo-product-reviews-shortcode'); ?>

                                                    <?php
                                                    $tip = __('You can use as many products as you want. Rating of multiple products will be summed up and shown as total rating. If you need to show separated amount of reviews rating add each product via single product short code.', 'woo-product-reviews-shortcode');
                                                    wprshrtcd_tipr(sanitize_text_field($tip));
                                                    ?>
                                                </label>
                                            </h4>
                                        </div>

                                        <div class="wptl-col-xs-12 wptl-col-lg-7">
                                            <?php
                                            if (!empty($products)) {
                                                ?>
                                                <p style="margin:5px 0">
                                                    <select name="products_ids_select" class="form-input" id="products_ids_select">
                                                        <option value="all"<?php echo 'all' === $shortcode_settings['products_ids_select'] ? ' selected' : ''; ?>><?php echo __('All products', 'woo-product-reviews-shortcode'); ?></option>
                                                        <option value="custom"<?php echo 'custom' === $shortcode_settings['products_ids_select'] ? ' selected' : ''; ?>><?php echo __('Specified products', 'woo-product-reviews-shortcode'); ?></option>
                                                    </select>
                                                </p>
                                                <?php
                                                $selected_products = array();

                                                if ('all' !== $shortcode_settings['products_ids_select']) {
                                                    $selected_products = explode(',', $shortcode_settings['products_ids']);
                                                }

                                                ?>
                                                <div id="wprshrtcd_products_list" style="margin:5px 0;<?php echo 'all' === $shortcode_settings['products_ids_select'] ? ' display:none;' : ''; ?>">
                                                    <?php
                                                    foreach ($products as $product_id => $product) {
                                                        $selected = false;

                                                        if ( in_array( $product_id, $selected_products ) ) {
                                                            $selected = true;
                                                        }
                                                        ?>
                                                        <fieldset>
                                                            <input id="product_<?php echo $product_id ?>" type="checkbox" value="<?php echo $product_id ?>"<?php echo $selected ? ' checked' : ''; ?>>
                                                            <label for="product_<?php echo $product_id ?>"><?php echo $product; ?></label>
                                                        </fieldset>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                                <?php
                                            } else {
                                                ?>
                                                <p style="margin:5px 0">
                                                    <?php
                                                    $create_product_link = '<a href="'.esc_url(get_admin_url(null, 'edit.php?post_type=product')).'" target="_blank">' . __( 'here', 'woo-product-reviews-shortcode' ) . '</a>';
                                                    $label = sprintf( __( 'You have no products in your shop. Please add some products %s and come back.', 'woo-product-reviews-shortcode' ), $create_product_link );

                                                    echo $label;
                                                    ?>
                                                </p>
                                                <?php
                                            }
                                            ?>

                                            <input type="hidden" class="form-input" name="products_ids" value="<?php echo $shortcode_settings['products_ids'] ?>" id="products_ids">
                                        </div>
                                    </div>

                                    <div class="wptl-row">
                                        <div class="wptl-col-xs-12 wptl-col-lg-5">
                                            <h4 class="wptl-tip-container" style="margin:5px 0">
                                                <label for="products_ids">
                                                    <?php echo __('Enable/Disable schema', 'woo-product-reviews-shortcode'); ?>
                                                    <?php
                                                    $tip = __('If you are going to use more then one shortcode per page we recommend you to use structured data markup only for one, otherwise google get two reviews schemas. You can disable it by selecting Disable from dropdown.', 'woo-product-reviews-shortcode');
                                                    wprshrtcd_tipr(sanitize_text_field($tip));
                                                    ?>
                                                </label>
                                            </h4>
                                        </div>

                                        <div class="wptl-col-xs-12 wptl-col-lg-7">
                                            <p style="margin:5px 0">
                                                <select name="show_schema" class="form-input" id="show_schema">
                                                    <option value="no"<?php echo 'no' === $shortcode_settings['show_schema'] ? ' selected' : ''; ?>><?php echo __('Disable', 'woo-product-reviews-shortcode'); ?></option>
                                                    <option value="yes"<?php echo 'yes' === $shortcode_settings['show_schema'] ? ' selected' : ''; ?>><?php echo __('Enable', 'woo-product-reviews-shortcode'); ?></option>
                                                </select>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="wptl-row">
                                        <div class="wptl-col-xs-12">
                                            <div class="wptl-row">
                                                <div class="wptl-col-xs-12 wptl-col-lg-5">
                                                    <h4 class="wptl-tip-container" style="margin:5px 0">
                                                        <label for="products_ids">
                                                            <?php echo __('Set reviews number', 'woo-product-reviews-shortcode'); ?>
                                                            <?php
                                                            $tip = __('Here you can set up how many reviews should be displayed, by default it’s 5. Select custom number of reviews to display. Select All to show all reviews, or select Hide so No reviews just aggregate rating will be shown.', 'woo-product-reviews-shortcode');
                                                            wprshrtcd_tipr(sanitize_text_field($tip));
                                                            ?>
                                                        </label>
                                                    </h4>
                                                </div>

                                                <div class="wptl-col-xs-12 wptl-col-lg-7">
                                                    <div class="wptl-row">
                                                        <div class="wptl-col-xs-12 wptl-col-md-6">
                                                            <p style="margin:5px 0">
                                                                <select name="per_page_select" class="form-input" id="per_page_select">
                                                                    <option value="all"<?php echo 'all' === $shortcode_settings['per_page_select'] ? ' selected' : ''; ?>><?php echo __('All', 'woo-product-reviews-shortcode'); ?></option>
                                                                    <option value="no"<?php echo 'no' === $shortcode_settings['per_page_select'] ? ' selected' : ''; ?>><?php echo __('Hide', 'woo-product-reviews-shortcode'); ?></option>
                                                                    <option value="custom"<?php echo 'custom' === $shortcode_settings['per_page_select'] ? ' selected' : ''; ?>><?php echo __('Number', 'woo-product-reviews-shortcode'); ?></option>
                                                                </select>
                                                            </p>
                                                        </div>

                                                        <div class="wptl-col-xs-12 wptl-col-md-6">
                                                            <p style="margin:5px 0">
                                                                <input type="number" min="1" class="form-input" name="per_page" value="<?php echo $shortcode_settings['per_page'] ?>" id="per_page"<?php echo 'custom' !== $shortcode_settings['per_page_select'] ? ' readonly' : ''; ?>>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="wptl-col-xs-12">
                                            <div class="wptl-row">
                                                <div class="wptl-col-xs-12 wptl-col-lg-5">
                                                    <h4 class="wptl-tip-container" style="margin:5px 0">
                                                        <label for="show_unique_type">
                                                            <?php echo __('Filter unique reviews', 'woo-product-reviews-shortcode'); ?>
                                                            <?php
                                                            $tip = __('By default we show all reviews according to settings. If you want to limit reviews amount per reviewer or per product, you can use this settings. Set maximum limit amount for unique reviews/products. F.e. Reviewer: 2 - show not more than 2 last reviews for each reviewer. Product: 2 - show not more than 2 last reviews for each product. Reviewer per product: 2 - show not more than 2 last reviews from one reviewer for each product.', 'woo-product-reviews-shortcode');
                                                            wprshrtcd_tipr(sanitize_text_field($tip));
                                                            ?>
                                                        </label>
                                                    </h4>
                                                </div>

                                                <div class="wptl-col-xs-12 wptl-col-lg-7">
                                                    <p style="margin:5px 0">
                                                        <select name="show_unique_type" class="form-input" id="show_unique_type">
                                                            <option value="all"<?php echo 'all' === $shortcode_settings['show_unique_type'] ? ' selected' : ''; ?>><?php echo __('Show all', 'woo-product-reviews-shortcode'); ?></option>
                                                            <option value="reviewer"<?php echo 'reviewer' === $shortcode_settings['show_unique_type'] ? ' selected' : ''; ?>><?php echo __('Reviewer', 'woo-product-reviews-shortcode'); ?></option>
                                                            <option value="product"<?php echo 'product' === $shortcode_settings['show_unique_type'] ? ' selected' : ''; ?>><?php echo __('Product', 'woo-product-reviews-shortcode'); ?></option>
                                                            <option value="reviewer_product"<?php echo 'reviewer_product' === $shortcode_settings['show_unique_type'] ? ' selected' : ''; ?>><?php echo __('Reviewer per product', 'woo-product-reviews-shortcode'); ?></option>
                                                        </select>
                                                    </p>

                                                    <div id="show_unique_type_settings" class="wptl-row"<?php echo 'all' === $shortcode_settings['show_unique_type'] ? ' style="display:none;"' : ''; ?>>
                                                        <div class="wptl-col-xs-12 wptl-col-lg-6">
                                                            <h4 style="margin:5px 0">
                                                                <label for="show_unique_amount">
                                                                    <?php echo __('Maximum', 'woo-product-reviews-shortcode'); ?>

                                                                </label>
                                                            </h4>
                                                        </div>
                                                        <div class="wptl-col-xs-12 wptl-col-lg-6">
                                                            <p style="margin:5px 0">
                                                                <input type="number" min="1" class="form-input" name="show_unique_amount" value="<?php echo $shortcode_settings['show_unique_amount'] ?>" id="show_unique_amount">
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="wptl-col-xs-12 wptl-col-md-6">
                                    <div class="wptl-row">

                                        <div class="wptl-col-xs-12">
                                            <div class="wptl-row">
                                                <div class="wptl-col-xs-12 wptl-col-lg-6">
                                                    <h4 class="wptl-tip-container" style="margin:5px 0">
                                                        <label for="show_product_item_title">
                                                            <?php echo __('Show/hide review item product title', 'woo-product-reviews-shortcode'); ?>
                                                            <?php
                                                            $tip = __('By default we show product title for each review, if you are showing only one product in current shortcode, you can hide it.', 'woo-product-reviews-shortcode');
                                                            wprshrtcd_tipr(sanitize_text_field($tip));
                                                            ?>
                                                        </label>
                                                    </h4>
                                                </div>

                                                <div class="wptl-col-xs-12 wptl-col-lg-6">
                                                    <p style="margin:5px 0">
                                                        <select name="show_product_item_title" class="form-input" id="show_product_item_title">
                                                            <option value="yes"<?php echo 'yes' === $shortcode_settings['show_product_item_title'] ? ' selected' : ''; ?>><?php echo __('Show', 'woo-product-reviews-shortcode'); ?></option>
                                                            <option value="no"<?php echo 'no' === $shortcode_settings['show_product_item_title'] ? ' selected' : ''; ?>><?php echo __('Hide', 'woo-product-reviews-shortcode'); ?></option>
                                                        </select>
                                                    </p>

                                                    <div id="show_product_item_title_settings" class="wptl-row"<?php echo 'no' === $shortcode_settings['show_product_item_title'] ? ' style="display:none;"' : ''; ?>>
                                                        <div class="wptl-col-xs-12 wptl-col-lg-6">
                                                            <h4 style="margin:5px 0">
                                                                <label for="show_product_item_link">
                                                                    <?php echo __('Product link', 'woo-product-reviews-shortcode'); ?>

                                                                </label>
                                                            </h4>
                                                        </div>
                                                        <div class="wptl-col-xs-12 wptl-col-lg-6">
                                                            <p style="margin:5px 0">
                                                                <select name="show_product_item_link" class="form-input" id="show_product_item_link">
                                                                    <option value="yes"<?php echo 'yes' === $shortcode_settings['show_product_item_link'] ? ' selected' : ''; ?>><?php echo __('Show', 'woo-product-reviews-shortcode'); ?></option>
                                                                    <option value="no"<?php echo 'no' === $shortcode_settings['show_product_item_link'] ? ' selected' : ''; ?>><?php echo __('Hide', 'woo-product-reviews-shortcode'); ?></option>
                                                                </select>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="wptl-col-xs-12">
                                            <div class="wptl-row">
                                                <div class="wptl-col-xs-12 wptl-col-lg-6">
                                                    <h4 class="wptl-tip-container" style="margin:5px 0">
                                                        <label for="show_pic">
                                                            <?php echo __('Show/Hide reviews picture', 'woo-product-reviews-shortcode'); ?>
                                                            <?php
                                                            $tip = __('By default customer avatar will be displayed. You can hide picture, or set product thumbnail as a picture', 'woo-product-reviews-shortcode');
                                                            wprshrtcd_tipr(sanitize_text_field($tip));
                                                            ?>
                                                        </label>
                                                    </h4>
                                                </div>

                                                <div class="wptl-col-xs-12 wptl-col-lg-6">
                                                    <p style="margin:5px 0">
                                                        <select name="show_pic" class="form-input" id="show_pic">
                                                            <option value="no"<?php echo 'no' === $shortcode_settings['show_pic'] ? ' selected' : ''; ?>><?php echo __('Hide', 'woo-product-reviews-shortcode'); ?></option>
                                                            <option value="yes"<?php echo 'yes' === $shortcode_settings['show_pic'] ? ' selected' : ''; ?>><?php echo __('Show', 'woo-product-reviews-shortcode'); ?></option>
                                                        </select>
                                                    </p>

                                                    <div id="show_pic_settings"<?php echo 'no' === $shortcode_settings['show_pic'] ? ' style="display:none;"' : ''; ?>>
                                                        <p style="margin:5px 0">
                                                            <select name="show_pic_type" class="form-input" id="show_pic_type">
                                                                <option value="avatar"<?php echo 'avatar' === $shortcode_settings['show_pic_type'] ? ' selected' : ''; ?>><?php echo __('Avatar', 'woo-product-reviews-shortcode'); ?></option>
                                                                <option value="thumbnail"<?php echo 'thumbnail' === $shortcode_settings['show_pic_type'] ? ' selected' : ''; ?>><?php echo __('Product thumbnail', 'woo-product-reviews-shortcode'); ?></option>
                                                            </select>
                                                        </p>

                                                        <p id="show_pic_size_settings" style="margin:5px 0;<?php echo 'avatar' === $shortcode_settings['show_pic_type'] ? ' display:none;' : ''; ?>">
                                                            <?php
                                                            $all_image_sizes = wprshrtcd_get_all_image_sizes();
                                                            ?>
                                                            <select name="show_pic_size" class="form-input" id="show_pic_size">
                                                                <?php
                                                                foreach ($all_image_sizes as $size => $values) {
                                                                    ?>
                                                                    <option value="<?php echo $size; ?>"<?php echo $size === $shortcode_settings['show_pic_size'] ? ' selected' : ''; ?>>
                                                                        <?php echo ucfirst(str_replace('_', ' ', $size)); ?>:
                                                                        <?php echo __('width', 'woo-product-reviews-shortcode') . ' ' . $values['width'] . 'px, ' . __('height', 'woo-product-reviews-shortcode') . ' ' . $values['height'] . 'px'; ?>
                                                                        (<?php echo !empty($values['crop']) ? __('cropped', 'woo-product-reviews-shortcode') : __('not cropped', 'woo-product-reviews-shortcode') ?>)
                                                                    </option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </p>

                                                        <div id="show_product_thumbnail_link_settings" class="wptl-row"<?php echo 'avatar' === $shortcode_settings['show_pic_type'] ? ' style="display:none;"' : ''; ?>>
                                                            <div class="wptl-col-xs-12 wptl-col-lg-6">
                                                                <h4 style="margin:5px 0">
                                                                    <label for="show_product_thumbnail_link">
                                                                        <?php echo __('Thumbnail link', 'woo-product-reviews-shortcode'); ?>

                                                                    </label>
                                                                </h4>
                                                            </div>
                                                            <div class="wptl-col-xs-12 wptl-col-lg-6">
                                                                <p style="margin:5px 0">
                                                                    <select name="show_product_thumbnail_link" class="form-input" id="show_product_thumbnail_link">
                                                                        <option value="yes"<?php echo 'yes' === $shortcode_settings['show_product_thumbnail_link'] ? ' selected' : ''; ?>><?php echo __('Show', 'woo-product-reviews-shortcode'); ?></option>
                                                                        <option value="no"<?php echo 'no' === $shortcode_settings['show_product_thumbnail_link'] ? ' selected' : ''; ?>><?php echo __('Hide', 'woo-product-reviews-shortcode'); ?></option>
                                                                    </select>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <?php
                                        $show_review_link_type_settings = false;

                                        if (
                                            $shortcode_settings['show_product_item_title'] === 'yes' &&
                                            $shortcode_settings['show_product_item_link'] === 'yes'
                                        ) {
                                            $show_review_link_type_settings = true;
                                        } elseif (
                                            $shortcode_settings['show_pic'] === 'yes' &&
                                            $shortcode_settings['show_pic_type'] === 'yes' &&
                                            $shortcode_settings['show_product_thumbnail_link'] === 'yes'
                                        ) {
                                            $show_review_link_type_settings = true;
                                        }
                                        ?>

                                        <div id="review_link_type_settings" class="wptl-col-xs-12"<?php echo $show_review_link_type_settings ? '' : ' style="display:none;"' ?>>
                                            <div class="wptl-row">
                                                <div class="wptl-col-xs-12 wptl-col-lg-6">
                                                    <h4 class="wptl-tip-container" style="margin:5px 0">
                                                        <label for="review_link_type">
                                                            <?php echo __('Review link type', 'woo-product-reviews-shortcode'); ?>
                                                            <?php
                                                            $tip = __('If product link or thumbnail link is enabled you can specify link type: to product page or to comment on product page. By default it would be product page.', 'woo-product-reviews-shortcode');
                                                            wprshrtcd_tipr(sanitize_text_field($tip));
                                                            ?>
                                                        </label>
                                                    </h4>
                                                </div>

                                                <div class="wptl-col-xs-12 wptl-col-lg-6">
                                                    <p style="margin:5px 0">
                                                        <select name="review_link_type" class="form-input" id="review_link_type">
                                                            <option value="product"<?php echo 'product' === $shortcode_settings['review_link_type'] ? ' selected' : ''; ?>><?php echo __('Product page', 'woo-product-reviews-shortcode'); ?></option>
                                                            <option value="comment"<?php echo 'comment' === $shortcode_settings['review_link_type'] ? ' selected' : ''; ?>><?php echo __('Comment link', 'woo-product-reviews-shortcode'); ?></option>
                                                        </select>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="wptl-col-xs-12">
                                            <div class="wptl-row">
                                                <div class="wptl-col-xs-12 wptl-col-lg-6">
                                                    <h4 class="wptl-tip-container" style="margin:5px 0">
                                                        <label for="show_nested">
                                                            <?php echo __('Show/Hide reviews replies', 'woo-product-reviews-shortcode'); ?>
                                                            <?php
                                                            $tip = __('By default only customer reviews will be displayed, if you want to show reviews replies select Show from dropdown.', 'woo-product-reviews-shortcode');
                                                            wprshrtcd_tipr(sanitize_text_field($tip));
                                                            ?>
                                                        </label>
                                                    </h4>
                                                </div>

                                                <div class="wptl-col-xs-12 wptl-col-lg-6">
                                                    <p style="margin:5px 0">
                                                        <select name="show_nested" class="form-input" id="show_nested">
                                                            <option value="no"<?php echo 'no' === $shortcode_settings['show_nested'] ? ' selected' : ''; ?>><?php echo __('Hide', 'woo-product-reviews-shortcode'); ?></option>
                                                            <option value="yes"<?php echo 'yes' === $shortcode_settings['show_nested'] ? ' selected' : ''; ?>><?php echo __('Show', 'woo-product-reviews-shortcode'); ?></option>
                                                        </select>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Multicolumn mode - start -->
                                    <?php
                                    if (empty($is_premium)) {
                                        ?>
                                        <div class="wptl-row">
                                            <div class="wptl-col-xs-12 wptl-col-lg-5">
                                                <h4 class="wptl-tip-container" style="margin:5px 0">
                                                    <label for="multicolumn_mode">
                                                        <?php echo __('Multicolumn mode', 'woo-product-reviews-shortcode'); ?>
                                                    </label>
                                                </h4>
                                            </div>

                                            <div class="wptl-col-xs-12 wptl-col-lg-7">
                                                <p style="margin:5px 0">
                                                    <?php
                                                    $free_string = sprintf( __( 'In Free version Multicolumn mode disabled. If you want more, please %s or %s.', 'woo-product-reviews-shortcode' ), $upgrade_link, $trial_link );
                                                    echo $free_string;
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <div id="multicolumn_mode_container"<?php echo empty($is_premium) ? ' style="display:none;"' : ''; ?>>
                                        <?php
                                        $is_multicolumn = true;

                                        if (empty($shortcode_settings['multicolumn_mode']) || 'no' === $shortcode_settings['multicolumn_mode']) {
                                            $is_multicolumn = false;
                                        }
                                        ?>
                                        <div class="wptl-row">
                                            <div class="wptl-col-xs-12 wptl-col-lg-5">
                                                <h4 class="wptl-tip-container" style="margin:5px 0">
                                                    <label for="multicolumn_mode">
                                                        <?php echo __('Multicolumn mode', 'woo-product-reviews-shortcode'); ?>
                                                    </label>
                                                </h4>
                                            </div>

                                            <div class="wptl-col-xs-12 wptl-col-lg-7">
                                                <p style="margin:5px 0">
                                                    <select name="multicolumn_mode" class="form-input" id="multicolumn_mode">
                                                        <option value="no"<?php echo !$is_multicolumn ? ' selected' : ''; ?>><?php echo __('Disable', 'woo-product-reviews-shortcode'); ?></option>
                                                        <option value="yes"<?php echo $is_multicolumn ? ' selected' : ''; ?>><?php echo __('Enable', 'woo-product-reviews-shortcode'); ?></option>
                                                    </select>
                                                </p>
                                            </div>
                                        </div>

                                        <div id="multicolumn_mode_settings_container" style="padding: 0 5px 0 10px; border: 1px solid #ddd; <?php echo !$is_multicolumn ? ' display:none;' : ''; ?>">
                                            <div class="wptl-row">
                                                <div class="wptl-col-xs-12 wptl-col-lg-5">
                                                    <h4 class="wptl-tip-container" style="margin:5px 0">
                                                        <label>
                                                            <?php echo __('Desktop', 'woo-product-reviews-shortcode'); ?>
                                                        </label>
                                                    </h4>
                                                </div>

                                                <div class="wptl-col-xs-12 wptl-col-lg-7">
                                                    <p style="margin:5px 0">
                                                        <label for="multicolumn_mode_desktop">
                                                            <?php echo __('Columns', 'woo-product-reviews-shortcode'); ?>
                                                        </label>
                                                    </p>
                                                    <p style="margin:5px 0">
                                                        <select name="multicolumn_mode_desktop" class="form-input" id="multicolumn_mode_desktop">
                                                            <option value="6_cols"<?php echo $shortcode_settings['multicolumn_mode_desktop'] === '6_cols' ? ' selected' : ''; ?>><?php echo __('6 columns', 'woo-product-reviews-shortcode'); ?></option>
                                                            <option value="4_cols"<?php echo $shortcode_settings['multicolumn_mode_desktop'] === '4_cols' ? ' selected' : ''; ?>><?php echo __('4 columns', 'woo-product-reviews-shortcode'); ?></option>
                                                            <option value="3_cols"<?php echo $shortcode_settings['multicolumn_mode_desktop'] === '3_cols' ? ' selected' : ''; ?>><?php echo __('3 columns', 'woo-product-reviews-shortcode'); ?></option>
                                                            <option value="2_cols"<?php echo $shortcode_settings['multicolumn_mode_desktop'] === '2_cols' ? ' selected' : ''; ?>><?php echo __('2 columns', 'woo-product-reviews-shortcode'); ?></option>
                                                            <option value="1_cols"<?php echo $shortcode_settings['multicolumn_mode_desktop'] === '1_cols' ? ' selected' : ''; ?>><?php echo __('1 columns', 'woo-product-reviews-shortcode'); ?></option>
                                                        </select>
                                                    </p>

                                                    <p style="margin:5px 0">
                                                        <label for="multicolumn_mode_desktop_thumb">
                                                            <?php echo __('Picture position', 'woo-product-reviews-shortcode'); ?>
                                                        </label>
                                                    </p>
                                                    <p style="margin:5px 0">
                                                        <select name="multicolumn_mode_desktop_thumb" class="form-input" id="multicolumn_mode_desktop_thumb">
                                                            <option value="top"<?php echo $shortcode_settings['multicolumn_mode_desktop_thumb'] === 'top' ? ' selected' : ''; ?>><?php echo __('Top', 'woo-product-reviews-shortcode'); ?></option>
                                                            <option value="left"<?php echo $shortcode_settings['multicolumn_mode_desktop_thumb'] === 'left' ? ' selected' : ''; ?>><?php echo __('Side', 'woo-product-reviews-shortcode'); ?></option>
                                                        </select>
                                                    </p>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="wptl-row">
                                                <div class="wptl-col-xs-12 wptl-col-lg-5">
                                                    <h4 class="wptl-tip-container" style="margin:5px 0">
                                                        <label>
                                                            <?php echo __('Tablet', 'woo-product-reviews-shortcode'); ?>
                                                        </label>
                                                    </h4>
                                                </div>

                                                <div class="wptl-col-xs-12 wptl-col-lg-7">
                                                    <p style="margin:5px 0">
                                                        <label for="multicolumn_mode_tablet">
                                                            <?php echo __('Columns', 'woo-product-reviews-shortcode'); ?>
                                                        </label>
                                                    </p>
                                                    <p style="margin:5px 0">
                                                        <select name="multicolumn_mode_tablet" class="form-input" id="multicolumn_mode_tablet">
                                                            <option value="4_cols"<?php echo $shortcode_settings['multicolumn_mode_tablet'] === '4_cols' ? ' selected' : ''; ?>><?php echo __('4 columns', 'woo-product-reviews-shortcode'); ?></option>
                                                            <option value="3_cols"<?php echo $shortcode_settings['multicolumn_mode_tablet'] === '3_cols' ? ' selected' : ''; ?>><?php echo __('3 columns', 'woo-product-reviews-shortcode'); ?></option>
                                                            <option value="2_cols"<?php echo $shortcode_settings['multicolumn_mode_tablet'] === '2_cols' ? ' selected' : ''; ?>><?php echo __('2 columns', 'woo-product-reviews-shortcode'); ?></option>
                                                            <option value="1_cols"<?php echo $shortcode_settings['multicolumn_mode_tablet'] === '1_cols' ? ' selected' : ''; ?>><?php echo __('1 columns', 'woo-product-reviews-shortcode'); ?></option>
                                                        </select>
                                                    </p>

                                                    <p style="margin:5px 0">
                                                        <label for="multicolumn_mode_tablet_thumb">
                                                            <?php echo __('Picture position', 'woo-product-reviews-shortcode'); ?>
                                                        </label>
                                                    </p>
                                                    <p style="margin:5px 0">
                                                        <select name="multicolumn_mode_tablet_thumb" class="form-input" id="multicolumn_mode_tablet_thumb">
                                                            <option value="top"<?php echo $shortcode_settings['multicolumn_mode_tablet_thumb'] === 'top' ? ' selected' : ''; ?>><?php echo __('Top', 'woo-product-reviews-shortcode'); ?></option>
                                                            <option value="left"<?php echo $shortcode_settings['multicolumn_mode_tablet_thumb'] === 'left' ? ' selected' : ''; ?>><?php echo __('Side', 'woo-product-reviews-shortcode'); ?></option>
                                                        </select>
                                                    </p>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="wptl-row">
                                                <div class="wptl-col-xs-12 wptl-col-lg-5">
                                                    <h4 class="wptl-tip-container" style="margin:5px 0">
                                                        <label>
                                                            <?php echo __('Mobile', 'woo-product-reviews-shortcode'); ?>
                                                        </label>
                                                    </h4>
                                                </div>

                                                <div class="wptl-col-xs-12 wptl-col-lg-7">
                                                    <p style="margin:5px 0">
                                                        <label>
                                                            <?php echo __('Columns', 'woo-product-reviews-shortcode'); ?>
                                                        </label>
                                                    </p>
                                                    <p style="margin:5px 0">
                                                        <input class="form-input" type="text" readonly value="<?php echo __('1 column only', 'woo-product-reviews-shortcode'); ?>">
                                                        <input id="multicolumn_mode_mobile" name="multicolumn_mode_mobile"  type="hidden" readonly value="1_col">
                                                    </p>

                                                    <p style="margin:5px 0">
                                                        <label for="multicolumn_mode_tablet_thumb">
                                                            <?php echo __('Picture position', 'woo-product-reviews-shortcode'); ?>
                                                        </label>
                                                    </p>
                                                    <p style="margin:5px 0">
                                                        <select name="multicolumn_mode_mobile_thumb" class="form-input" id="multicolumn_mode_mobile_thumb">
                                                            <option value="top"<?php echo $shortcode_settings['multicolumn_mode_mobile_thumb'] === 'top' ? ' selected' : ''; ?>><?php echo __('Top', 'woo-product-reviews-shortcode'); ?></option>
                                                            <option value="left"<?php echo $shortcode_settings['multicolumn_mode_mobile_thumb'] === 'left' ? ' selected' : ''; ?>><?php echo __('Side', 'woo-product-reviews-shortcode'); ?></option>
                                                        </select>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Multicolumn mode - end -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="wptl-col-xs-12 wptl-col-md-4 wptl-col-lg-3">
                        <div class="postbox-container">
                            <div class="wptl-row">
                                <div class="wptl-col-xs-12">
                                    <div id="side-sortables" class="meta-box-sortables ui-sortable" style=""><div id="submitdiv" class="postbox ">
                                            <button type="button" class="handlediv" aria-expanded="true"><span class="screen-reader-text">Toggle panel: Publish</span><span class="toggle-indicator" aria-hidden="true"></span></button><h2 class="hndle ui-sortable-handle"><span>Publish</span></h2>
                                            <div class="inside">
                                                <div class="submitbox" id="submitpost">

                                                    <div id="minor-publishing">

                                                        <div id="misc-publishing-actions">

                                                            <div class="misc-pub-section misc-pub-post-status">
                                                                Status: <span id="post-status-display"><?php echo ucfirst($shortcode_post->post_status); ?></span>
                                                            </div><!-- .misc-pub-section -->

                                                        </div>
                                                        <div class="clear"></div>
                                                    </div>

                                                    <div id="major-publishing-actions">
                                                        <div id="delete-action">
                                                            <?php
                                                            $delete_url = wp_nonce_url( "?page=reviewshort&wprshrtcd-delete=1&shortcode_id=$shortcode_id", 'wprshrtcd_delete_nonce', '_nonce') ;
                                                            ?>
                                                            <a class="submitdelete deletion" href="<?php echo $delete_url; ?>"><?php echo __('Delete', 'woo-product-reviews-shortcode'); ?></a>
                                                        </div>

                                                        <div id="publishing-action">
                                                            <input type="hidden" name="post_id" value="<?php echo $shortcode_id ?>">
                                                            <?php
                                                            $url = get_site_url() . "/wprshrtcd-shortcode-preview/$shortcode_id?preview_shortcode_id=$shortcode_id&on_load=1"
                                                            ?>
                                                            <a id="preview_link" class="button" href="<?php echo $url; ?>" target="wprshrtcd-<?php echo $shortcode_id ?>">
                                                                <?php echo __('Preview', 'woo-product-reviews-shortcode'); ?>
                                                            </a>

                                                            <button id="wprshrtcd_save_settings" class="button" type="button">
                                                                <?php
                                                                if ($shortcode_post->post_status === 'draft') {
                                                                    echo __('Publish', 'woo-product-reviews-shortcode');
                                                                } else {
                                                                    echo __('Update', 'woo-product-reviews-shortcode');
                                                                }
                                                                ?>
                                                            </button>
                                                        </div>
                                                        <div class="clear"></div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

        </form>

        <?php require_once 'templating.php'?>
    </div>
</div>
