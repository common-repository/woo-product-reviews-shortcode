<?php

?>
<div class="wptl-row">
    <div class="wptl-col-xs-12">
        <h3><?php echo __('Reviews shortcode templating', 'woo-product-reviews-shortcode'); ?></h3>

        <p>
            <?php echo __('Styles are taken from WooCommerce, so it looks the same as on the product details page.', 'woo-product-reviews-shortcode'); ?>
            <?php echo __('Structure of the reviews can be changed by copy files in the list below to your custom field, then this structure will be used by default', 'woo-product-reviews-shortcode'); ?>:
        </p>

        <ul>
            <?php
            $templates = wprshrtcd_get_templates();
            $theme_path = esc_html( trailingslashit( basename( get_stylesheet_directory() ) ) );
            $default_path = untrailingslashit( plugin_dir_path( WPRSHRTCD_FILE ) ) . '/templates/';

            foreach ($templates as $template => $template_data) {
                $default_file_path = untrailingslashit( plugin_dir_path( WPRSHRTCD_FILE ) ) . '/templates/' . $templates[$template]['path'];
                $theme_file_path = get_stylesheet_directory() . '/woocommerce/wprshrtcd/' . $templates[$template]['path'];
                ?>
                <li style="line-height:26px;">
                    <?php
                    if (!file_exists($theme_file_path)) {
                        ?>
                        <code>woo-product-reviews-shortcode/templates/<?php echo $template_data['path'] ?></code>
                        =>
                        <?php
                    }
                    ?>
                    <code><?php echo $theme_path ?>woocommerce/wprshrtcd/<?php echo $template_data['path'] ?></code>

                    <button class="button button-small show-template" data-template="<?php echo $template ?>" type="button"><?php echo __('Show template', 'woo-product-reviews-shortcode'); ?></button>

                    <button class="button button-small hide-template" data-template="<?php echo $template ?>" type="button" style="display: none;"><?php echo __('Hide template', 'woo-product-reviews-shortcode'); ?></button>

                    <?php
                    if (!file_exists($theme_file_path)) {
                        ?>
                        <button class="button button-small copy-template" data-template="<?php echo $template ?>" type="button">
                            <?php echo __('Copy template', 'woo-product-reviews-shortcode'); ?>
                        </button>
                        <?php
                    } else {
                        ?>
                        <a target="_blank" class="button button-small" href="theme-editor.php?file=woocommerce/wprshrtcd/<?php echo $template_data['path'] ?>&theme=<?php echo $theme_path ?>">
                            <?php echo __('Edit template', 'woo-product-reviews-shortcode'); ?>
                        </a>

                        <button class="button button-small delete-template" data-template="<?php echo $template ?>" type="button">
                            <?php echo __('Delete template', 'woo-product-reviews-shortcode'); ?>
                        </button>
                        <?php
                    }
                    ?>

                    <div id="template_<?php echo $template ?>" class="editor" style="display:none;margin: 15px 0;">
                        <?php
                        if (!file_exists($theme_file_path)) {
                            ?>
                            <textarea class="code" readonly="readonly" disabled="disabled" rows="20" style="width:100%; max-width: 1000px;"><?php echo esc_html( file_get_contents( $default_file_path ) );  // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents ?></textarea>
                            <?php
                        } else {
                            ?>
                            <textarea class="code" readonly="readonly" disabled="disabled" rows="20" style="width:100%; max-width: 1000px;"><?php echo esc_html( file_get_contents( $theme_file_path ) );  // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents ?></textarea>
                            <?php
                        }
                        ?>
                    </div>
                </li>
                <?php
            }
            ?>
        </ul>
    </div>
</div>
