<?php
// Register Custom Post Type
function wprshrtcd_review_shortcode() {
    $labels = array(
        'name'                  => _x( 'Review Shortcodes', 'Post Type General Name', 'woo-product-reviews-shortcode' ),
        'singular_name'         => _x( 'Review Shortcode', 'Post Type Singular Name', 'woo-product-reviews-shortcode' ),
        'menu_name'             => __( 'Review Shortcodes', 'woo-product-reviews-shortcode' ),
        'name_admin_bar'        => __( 'Review Shortcode', 'woo-product-reviews-shortcode' ),
        'archives'              => __( 'Review Shortcode Archives', 'woo-product-reviews-shortcode' ),
        'attributes'            => __( 'Review Shortcode Attributes', 'woo-product-reviews-shortcode' ),
        'parent_item_colon'     => __( 'Parent Review Shortcode:', 'woo-product-reviews-shortcode' ),
        'all_items'             => __( 'All Review Shortcodes', 'woo-product-reviews-shortcode' ),
        'add_new_item'          => __( 'Add New Review Shortcode', 'woo-product-reviews-shortcode' ),
        'add_new'               => __( 'Add New', 'woo-product-reviews-shortcode' ),
        'new_item'              => __( 'New Review Shortcode', 'woo-product-reviews-shortcode' ),
        'edit_item'             => __( 'Edit Review Shortcode', 'woo-product-reviews-shortcode' ),
        'update_item'           => __( 'Update Review Shortcode', 'woo-product-reviews-shortcode' ),
        'view_item'             => __( 'View Review Shortcode', 'woo-product-reviews-shortcode' ),
        'view_items'            => __( 'View Review Shortcodes', 'woo-product-reviews-shortcode' ),
        'search_items'          => __( 'Search Review Shortcode', 'woo-product-reviews-shortcode' ),
        'not_found'             => __( 'Not found', 'woo-product-reviews-shortcode' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'woo-product-reviews-shortcode' ),
        'featured_image'        => __( 'Featured Image', 'woo-product-reviews-shortcode' ),
        'set_featured_image'    => __( 'Set featured image', 'woo-product-reviews-shortcode' ),
        'remove_featured_image' => __( 'Remove featured image', 'woo-product-reviews-shortcode' ),
        'use_featured_image'    => __( 'Use as featured image', 'woo-product-reviews-shortcode' ),
        'insert_into_item'      => __( 'Insert into Review Shortcode', 'woo-product-reviews-shortcode' ),
        'uploaded_to_this_item' => __( 'Uploaded to this Review Shortcode', 'woo-product-reviews-shortcode' ),
        'items_list'            => __( 'Review Shortcodes list', 'woo-product-reviews-shortcode' ),
        'items_list_navigation' => __( 'Review Shortcodes list navigation', 'woo-product-reviews-shortcode' ),
        'filter_items_list'     => __( 'Filter Review Shortcodes list', 'woo-product-reviews-shortcode' ),
    );
    $args = array(
        'label'                 => __( 'Review Shortcode', 'woo-product-reviews-shortcode' ),
        'description'           => __( 'Generate Review Shortcodes', 'woo-product-reviews-shortcode' ),
        'labels'                => $labels,
        'supports'              => array( 'title' ),
        'hierarchical'          => false,
        'public'                => false,
        'show_ui'               => false,
        'show_in_menu'          => false,
        'menu_position'         => 5,
        'show_in_admin_bar'     => false,
        'show_in_nav_menus'     => false,
        'can_export'            => false,
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'publicly_queryable'    => false,
        'rewrite'               => false,
        'capability_type'       => 'page',
        'show_in_rest'          => false,
    );
    register_post_type( 'review_shortcode', $args );

}
add_action( 'init', 'wprshrtcd_review_shortcode', 0 );