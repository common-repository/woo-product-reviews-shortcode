<div class="wrap wprshrtcd-help">
    <div class="wptl-row">
        <div class="wptl-col-xs-12">
            <h1><?php echo __('ReviewShort Tutorial', 'woo-product-reviews-shortcode'); ?></h1>
        </div>
    </div>

    <div class="wptl-row">
        <div class="wptl-col-xs-12">
            <?php require_once 'intro.php'?>
        </div>
    </div>

    <div class="wptl-row">
        <div class="wptl-col-xs-12">
            <p>
                <?php echo __('You can copy one of our example below and add changes manually for your needs or use our Shortcode builder where you can create and save reusable reviews shortcodes.', 'woo-product-reviews-shortcode'); ?>
            </p>

            <p>
                <a class="button" href="?page=reviewshort">
                    <?php _e('Shortcodes list', 'woo-product-reviews-shortcode'); ?>
                </a>

                <?php echo wprshrtcd_get_create_new_button(); ?>
            </p>
        </div>
    </div>

    <div class="wptl-row">
        <div class="wptl-col-xs-12 wptl-col-md-6">
            <h3><?php echo __('Default shortcode usage', 'woo-product-reviews-shortcode'); ?></h3>

            <p>
                <?php echo __('To input your user reviews list on any site page use shortcode ', 'woo-product-reviews-shortcode'); ?>
                <code>[wprshrtcd_woo_product_reviews]</code>. <?php echo __('The only required parameter is <code>products_ids</code>', 'woo-product-reviews-shortcode'); ?>
            </p>

            <p>
                <strong><?php echo __('Example', 'woo-product-reviews-shortcode'); ?></strong>
            </p>

            <p class="code-example">
                <span class="code-example-value">[wprshrtcd_woo_product_reviews products_ids="123"]</span>

                <span class="code-example-copy"><?php echo __('Copy', 'woo-product-reviews-shortcode'); ?></span>
                <span class="code-example-copied"><?php echo __('Copied. Input into your content!', 'woo-product-reviews-shortcode'); ?></span>
            </p>
        </div>

        <div class="wptl-col-xs-12 wptl-col-md-6">
            <h3><?php echo __('Multiple products shortcode usage', 'woo-product-reviews-shortcode'); ?></h3>

            <p>
                <?php echo __('You can use as many products as you want, just separate products IDs with comma. As additional parameter you can add <code>product_title</code> to use it for all products', 'woo-product-reviews-shortcode'); ?>
                <?php echo __('Rating of multiple products will be summed up and shown as total rating.', 'woo-product-reviews-shortcode'); ?>
            </p>

            <p>
                <strong><?php echo __('Example', 'woo-product-reviews-shortcode'); ?></strong>
            </p>

            <p class="code-example">
                <span class="code-example-value">[wprshrtcd_woo_product_reviews products_ids="123,124,125" product_title="Multiple product title"]</span>

                <span class="code-example-copy"><?php echo __('Copy', 'woo-product-reviews-shortcode'); ?></span>
                <span class="code-example-copied"><?php echo __('Copied. Input into your content!', 'woo-product-reviews-shortcode'); ?></span>
            </p>

            <p>
                <?php echo __('If you need to show separated amount of reviews rating add each product via single product short code.', 'woo-product-reviews-shortcode'); ?>
            </p>

        </div>
    </div>

    <div class="wptl-row">
        <div class="wptl-col-xs-12 wptl-col-md-6">
            <h3><?php echo __('Number of reviews shortcode usage', 'woo-product-reviews-shortcode'); ?></h3>

            <p>
                <?php echo __('You can set up how many reviews should be displayed, by default it’s 5. Use parameter <code>per_page</code> to change this value. If you want to show all reviews set it to <strong>all</strong>', 'woo-product-reviews-shortcode'); ?>
            </p>

            <p>
                <strong><?php echo __('Example', 'woo-product-reviews-shortcode'); ?></strong>
            </p>

            <p class="code-example">
                <span class="code-example-value">[wprshrtcd_woo_product_reviews products_ids="123" per_page="all"]</span>

                <span class="code-example-copy"><?php echo __('Copy', 'woo-product-reviews-shortcode'); ?></span>
                <span class="code-example-copied"><?php echo __('Copied. Input into your content!', 'woo-product-reviews-shortcode'); ?></span>
            </p>
        </div>

        <div class="wptl-col-xs-12 wptl-col-md-6">
            <h3><?php echo __('No reviews just aggregate rating usage', 'woo-product-reviews-shortcode'); ?></h3>

            <p>
                <?php echo __('You can hide reviews list and show only aggregate rating as average rating from all customers reviews. Use parameter <code>per_page</code> and set it to <strong>0</strong>', 'woo-product-reviews-shortcode'); ?>
            </p>

            <p>
                <strong><?php echo __('Example', 'woo-product-reviews-shortcode'); ?></strong>
            </p>

            <p class="code-example">
                <span class="code-example-value">[wprshrtcd_woo_product_reviews products_ids="123" per_page="0"]</span>

                <span class="code-example-copy"><?php echo __('Copy', 'woo-product-reviews-shortcode'); ?></span>
                <span class="code-example-copied"><?php echo __('Copied. Input into your content!', 'woo-product-reviews-shortcode'); ?></span>
            </p>
        </div>
    </div>

    <div class="wptl-row">
        <div class="wptl-col-xs-12 wptl-col-md-6">
            <h3><?php echo __('Show reviews reply shortcode usage', 'woo-product-reviews-shortcode'); ?></h3>

            <p>
                <?php echo __('By default only customer reviews will be displayed, if you want to show reviews replies use parameter <code>show_nested</code> with value <strong>yes</strong>', 'woo-product-reviews-shortcode'); ?>
            </p>

            <p>
                <strong><?php echo __('Example', 'woo-product-reviews-shortcode'); ?></strong>
            </p>

            <p class="code-example">
                <span class="code-example-value">[wprshrtcd_woo_product_reviews products_ids="123" show_nested="yes"]</span>

                <span class="code-example-copy"><?php echo __('Copy', 'woo-product-reviews-shortcode'); ?></span>
                <span class="code-example-copied"><?php echo __('Copied. Input into your content!', 'woo-product-reviews-shortcode'); ?></span>
            </p>
        </div>

        <div class="wptl-col-xs-12 wptl-col-md-6">
            <h3><?php echo __('Disabled Structured Data shortcode usage', 'woo-product-reviews-shortcode'); ?></h3>

            <p>
                <?php echo __('If you are going to use more then one shortcode per page we recommend you to use structured data markup only for one, otherwise google get two reviews schemas. You can disable it by adding parameter <code>show_schema</code> with value <strong>no</strong>', 'woo-product-reviews-shortcode'); ?>
            </p>

            <p>
                <strong><?php echo __('Example', 'woo-product-reviews-shortcode'); ?></strong>
            </p>

            <p class="code-example">
                <span class="code-example-value">[wprshrtcd_woo_product_reviews products_ids="123" show_schema="no"]</span>

                <span class="code-example-copy"><?php echo __('Copy', 'woo-product-reviews-shortcode'); ?></span>
                <span class="code-example-copied"><?php echo __('Copied. Input into your content!', 'woo-product-reviews-shortcode'); ?></span>
            </p>
        </div>
    </div>

    <div class="wptl-row">
        <div class="wptl-col-xs-12">
            <h3><?php echo __('All parameters usage example', 'woo-product-reviews-shortcode'); ?></h3>

            <ul>
                <li>
                    <?php echo __('Show multiple products reviews in one shortcode: ', 'woo-product-reviews-shortcode'); ?> <code>products_ids="111,112,123"</code><br>
                </li>

                <li>
                    <?php echo __('Set one title for multiple products: ', 'woo-product-reviews-shortcode'); ?> <code>product_title="Multiple product title"</code><br>
                </li>

                <li>
                    <?php echo __('Show all product reviews: ', 'woo-product-reviews-shortcode'); ?> <code>per_page="all"</code><br>
                </li>

                <li>
                    <?php echo __('Show nested reviews (reply, comments etc.): ', 'woo-product-reviews-shortcode'); ?> <code>show_nested="yes"</code><br>
                </li>

                <li>
                    <?php echo __('Do not show schema.org markup: ', 'woo-product-reviews-shortcode'); ?> <code>show_schema="no"</code><br>
                </li>
            </ul>

            <p class="code-example">
                <span class="code-example-value">[wprshrtcd_woo_product_reviews products_ids="123,124,125" product_title="Multiple product title" per_page="all" show_nested="yes" show_schema="no"]</span>

                <span class="code-example-copy"><?php echo __('Copy', 'woo-product-reviews-shortcode'); ?></span>
                <span class="code-example-copied"><?php echo __('Copied. Input into your content!', 'woo-product-reviews-shortcode'); ?></span>
            </p>
        </div>
    </div>

    <div class="wptl-row">
        <div class="wptl-col-xs-12 wptl-col-md-6">

        </div>

        <div class="wptl-col-xs-12 wptl-col-md-6">

        </div>
    </div>

    <?php require_once 'templating.php'?>
    <?php require_once 'more-plugins.php'?>
</div>