<?php
/**
 * Helpers library functions
 *
 * @since      0.0.1
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * wprshrtcd_is_plugin_activated.
 *
 * @version 0.0.1
 * @since   0.0.1
 * @return  bool
 */
function wprshrtcd_is_plugin_activated( $plugin_folder, $plugin_file ) {
    if ( wprshrtcd_is_plugin_active_simple( $plugin_folder . '/' . $plugin_file ) ) {
        return true;
    } else {
        return wprshrtcd_is_plugin_active_by_file( $plugin_file );
    }
}

/**
 * wprshrtcd_is_plugin_active_simple.
 *
 * @version 0.0.1
 * @since   0.0.1
 * @return  bool
 */
function wprshrtcd_is_plugin_active_simple( $plugin ) {
    return (
        in_array( $plugin, apply_filters( 'active_plugins', get_option( 'active_plugins', array() ) ) ) ||
        ( is_multisite() && array_key_exists( $plugin, get_site_option( 'active_sitewide_plugins', array() ) ) )
    );
}

/**
 * wprshrtcd_is_plugin_active_by_file.
 *
 * @version 0.0.1
 * @since   0.0.1
 * @return  bool
 */
function wprshrtcd_is_plugin_active_by_file( $plugin_file ) {
    foreach ( wprshrtcd_get_active_plugins() as $active_plugin ) {
        $active_plugin = explode( '/', $active_plugin );

        if ( isset( $active_plugin[1] ) && $plugin_file === $active_plugin[1] ) {
            return true;
        }
    }

    return false;
}

/**
 * wprshrtcd_get_active_plugins.
 *
 * @version 0.0.1
 * @since   0.0.1
 * @return  array
 */
function wprshrtcd_get_active_plugins() {
    $active_plugins = apply_filters( 'active_plugins', get_option( 'active_plugins', array() ) );

    if ( is_multisite() ) {
        $active_plugins = array_merge( $active_plugins, array_keys( get_site_option( 'active_sitewide_plugins', array() ) ) );
    }

    return $active_plugins;
}

/**
 * Get other templates (e.g. product attributes) passing attributes and including the file.
 *
 * @param string $template_name Template name.
 * @param array  $args          Arguments. (default: array).
 * @param string $template_path Template path. (default: '').
 * @param string $default_path  Default path. (default: '').
 */
function wprshrtcd_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
    $template = wprshrtcd_locate_template( $template_name, $template_path, $default_path );

    do_action( 'wprshrtcd_before_template_part', $template_name, $template_path, $args );

    if (!empty($args) && is_array($args)) {
        extract($args);
    }

    include $template;

    do_action( 'wprshrtcd_after_template_part', $template_name, $template_path, $args );
}

/**
 * Like wc_get_template, but returns the HTML instead of outputting.
 *
 * @see wc_get_template
 * @since 2.5.0
 * @param string $template_name Template name.
 * @param array  $args          Arguments. (default: array).
 * @param string $template_path Template path. (default: '').
 * @param string $default_path  Default path. (default: '').
 *
 * @return string
 */
function wprshrtcd_get_template_html( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
    ob_start();
    wprshrtcd_get_template( $template_name, $args, $template_path, $default_path );
    return ob_get_clean();
}
/**
 * Locate a template and return the path for inclusion.
 *
 * This is the load order:
 *
 * yourtheme/$template_path/$template_name
 * yourtheme/$template_name
 * $default_path/$template_name
 *
 * @param string $template_name Template name.
 * @param string $template_path Template path. (default: '').
 * @param string $default_path  Default path. (default: '').
 * @return string
 */
function wprshrtcd_locate_template( $template_name, $template_path = '', $default_path = '' ) {
    if ( ! $template_path ) {
        $template_path = 'woocommerce/wprshrtcd';
    }

    if ( ! $default_path ) {
        $default_path = untrailingslashit( plugin_dir_path( WPRSHRTCD_FILE ) ) . '/templates/';
    }

    // Look within passed path within the theme - this is priority.
    $template = locate_template(
        array(
            trailingslashit( $template_path ) . $template_name,
            $template_name,
        )
    );

    // Get default template/.
    if ( ! $template ) {
        $template = $default_path . $template_name;
    }

    // Return what we found.
    return $template;
}

function wprshrtcd_add_plugin_screen_link($links) {
    $create_url = wp_nonce_url( "?page=reviewshort&wprshrtcd-create=1", 'wprshrtcd_create_nonce', '_nonce') ;
    $shortcodes = wprshrtcd_get_available_shortcodes();

    if (empty($shortcodes)) {
        $links[] = '<a href="' . esc_url(get_admin_url(null, "admin.php{$create_url}")) . '" target="_balank">'. __( "Start", 'woo-product-reviews-shortcode' ) .'</a>';
    } else {
        $links[] = '<a href="' . esc_url(get_admin_url(null, 'admin.php?page=reviewshort')) . '" target="_balank">'. __( "Start", 'woo-product-reviews-shortcode' ) .'</a>';
    }

    $links[] = '<a href="' . esc_url(get_admin_url(null, 'admin.php?page=wprshrtcd-help')) . '" target="_balank">'. __( "How to use", 'woo-product-reviews-shortcode' ) .'</a>';
    return $links;
}

add_action( 'wp_enqueue_scripts', 'wprshrtcd_enqueue_public_scripts' );

function wprshrtcd_enqueue_public_scripts() {
    wp_enqueue_style( 'woo-product-reviews-shortcode', plugin_dir_url( WPRSHRTCD_FILE ) . 'assets/css/style.css', array(), WPRSHRTCD_VERSION, 'all' );
}

function wprshrtcd_is_premium() {
    if (function_exists('revrt_fs')) {
        $is_paying = revrt_fs()->is_paying_or_trial();

        if ($is_paying) {
            return  'pro';
        }

        if (revrt_fs()->is_paying__fs__()) {
            return  'pro';
        }

        if (revrt_fs()->is_trial()) {
            return  'pro';
        }
    }

    return wprshrtcd_is_wp2leads_premium();
}

function wprshrtcd_is_wp2leads_premium() {
    if ( !wprshrtcd_is_plugin_activated( 'wp2leads', 'wp2leads.php' ) && !wprshrtcd_is_plugin_activated( 'more-better-reviews-for-woocommerce', 'more-better-reviews-for-woocommerce.php' )) {
        return false;
    }

    if (wprshrtcd_is_plugin_activated( 'wp2leads', 'wp2leads.php' )) {
        if (class_exists('Wp2leads_License')) {
            $wp2l_license_level = Wp2leads_License::get_license_level();

            if ('free' !== $wp2l_license_level) {
                return true;
            }
        } else {
            $plugin_path = WP_PLUGIN_DIR;

            $wp2leads_path = $plugin_path . '/wp2leads/includes/class-wp2leads-license.php';

            if (file_exists($wp2leads_path)) {
                include ($wp2leads_path);
            }
        }
        if (class_exists('Wp2leads_License')) {
            $wp2l_license_level = Wp2leads_License::get_license_level();

            if ('free' !== $wp2l_license_level) {
                return true;
            }
        }
    }

    if (wprshrtcd_is_plugin_activated( 'more-better-reviews-for-woocommerce', 'more-better-reviews-for-woocommerce.php' ) && class_exists('Wtsr_License')) {
        if (function_exists('mbrfw_fs')) {

            if ( mbrfw_fs()->is_trial() ) {
                return true;
            }
        } else {
            if ('free' === Wtsr_License::get_license_version()) {
                return false;
            } else {
                return true;
            }
        }
    }

    return false;
}

function wprshrtcd_get_upgrade_url($trial = false) {
    if (function_exists('revrt_fs')) {
        if ($trial) {
            $url = revrt_fs()->get_trial_url();
            $link = sprintf( __( '<a href="%s" target="_blank">Start trial</a>', 'woo-product-reviews-shortcode' ), $url );
        } else {
            $url = revrt_fs()->get_upgrade_url();
            $link = sprintf( __( '<a href="%s" target="_blank">Upgrade</a>', 'woo-product-reviews-shortcode' ), $url );
        }

        return $link;
    }

    return '';
}

function wprshrtcd_is_trial_utilized() {
    if (function_exists('revrt_fs')) {
        revrt_fs()->is_trial_utilized();
    }

    return false;
}
