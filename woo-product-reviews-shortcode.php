<?php
/**
 * Plugin Name:     Builder for WooCommerce reviews shortcodes - ReviewShort
 * Description:     Show WooCommerce customer feedback anywhere with WooCommerce reviews shortcodes, beautifully and ...
 * Version:         1.01.7
 * Author:          Tobias Conrad
 * Author URI:      https://saleswonder.biz/
 * License:         GPL v3 or later
 * License URI:     https://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:     woo-product-reviews-shortcode
 * WC requires at least: 4.0
 * WC tested up to: 8.8
 *
 * Domain Path:     /languagess
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) die;

/**
 * Currently plugin version.
 * Start at version 0.0.1 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WPRSHRTCD_VERSION', '1.01.7' );

if ( ! defined( 'WPRSHRTCD_FILE' ) ) {
    define( 'WPRSHRTCD_FILE', __FILE__ );
}

require_once( 'includes/functions.php' );

function wprshrtcd_woocommerce_notice() {
    /* translators: 1. URL link. */
    echo '<div class="error"><p><strong>' . sprintf( esc_html__( 'Woo Product Reviews Shortcode requires Woocommerce plugin to be installed and active. You can install %s here.', 'woo-product-reviews-shortcode' ), '<a href="'.esc_url(get_admin_url(null, 'plugin-install.php?s=woocommerce&tab=search&type=term')).'" target="_blank">Woocommerce</a>' ) . '</strong></p></div>';
}

if ( !wprshrtcd_is_plugin_activated( 'woocommerce', 'woocommerce.php' ) ) {
    add_action( 'admin_notices', 'wprshrtcd_woocommerce_notice' );

    return;
}

add_action( 'before_woocommerce_init', function() {
    if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
    }
} );

function load_freemius_integration() {
    if (!wprshrtcd_is_wp2leads_premium()) {
        if ( ! function_exists( 'revrt_fs' ) ) {
            // Create a helper function for easy SDK access.
            function revrt_fs() {
                global $revrt_fs;

                if ( ! isset( $revrt_fs ) ) {
                    // Activate multisite network integration.
                    if ( ! defined( 'WP_FS__PRODUCT_5861_MULTISITE' ) ) {
                        define( 'WP_FS__PRODUCT_5861_MULTISITE', true );
                    }

                    // Include Freemius SDK.
                    require_once dirname(__FILE__) . '/freemius/start.php';

                    $revrt_fs = fs_dynamic_init( array(
                        'id'                  => '5861',
                        'slug'                => 'woo-product-reviews-shortcode',
                        'type'                => 'plugin',
                        'public_key'          => 'pk_a0d4552f973969e1ec0b9067951bf',
                        'is_premium'          => false,
                        'premium_suffix'      => 'Premium',
                        // If your plugin is a serviceware, set this option to false.
                        'has_premium_version' => false,
                        'has_addons'          => false,
                        'has_paid_plans'      => true,
                        'has_premium_version' => false,
                        'trial'               => array(
                            'days'               => 7,
                            'is_require_payment' => true,
                        ),
                        'has_affiliation'     => 'all',
                        'menu'                => array(
                            'slug'           => 'reviewshort',
                        ),
                        // Set the SDK to work in a sandbox mode (for development & testing).
                        // IMPORTANT: MAKE SURE TO REMOVE SECRET KEY BEFORE DEPLOYMENT.
                        'secret_key'          => '',
                    ) );
                }

                return $revrt_fs;
            }

            // Init Freemius.
            revrt_fs();
            // Signal that SDK was initiated.
            do_action( 'revrt_fs_loaded' );
        }
    }
}

add_action( 'plugins_loaded', 'load_freemius_integration' );

require_once( 'admin/functions.php' );

add_filter('plugin_action_links_' . plugin_basename(dirname(__FILE__)) . '/woo-product-reviews-shortcode.php', 'wprshrtcd_add_plugin_screen_link');


require_once( 'includes/cpt.php' );
require_once( 'includes/woo-hooks.php' );
require_once( 'includes/woo-functions.php' );
require_once( 'includes/shortcodes.php' );

add_action( 'plugins_loaded', 'wprshrtcd_load_plugin_textdomain' );

function wprshrtcd_load_plugin_textdomain() {
    add_filter( 'plugin_locale', 'wprshrtcd_check_de_locale');

    load_plugin_textdomain(
        'woo-product-reviews-shortcode',
        false,
        dirname( plugin_basename( __FILE__ ) ) . '/languagess/'
    );

    remove_filter( 'plugin_locale', 'wprshrtcd_check_de_locale');
}

function wprshrtcd_check_de_locale($domain) {
    $site_lang = get_user_locale();
    $de_lang_list = array(
        'de_CH_informal',
        'de_DE_formal',
        'de_AT',
        'de_CH',
        'de_DE'
    );

    if (in_array($site_lang, $de_lang_list)) return 'de_DE';
    return $domain;
}
