<?php
/**
 * Monochrome Pro.
 *
 * This file adds the required WooCommerce setup functions to the Monochrome Pro Theme.
 *
 * @package Monochrome
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/monochrome/
 */

// Add product gallery support.
if ( class_exists( 'WooCommerce' ) ) {
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
	add_theme_support( 'wc-product-gallery-zoom' );
}

add_action( 'wp_enqueue_scripts', 'monochrome_products_match_height', 99 );
/**
 * Print an inline script to the footer to keep products the same height.
 *
 * @since 1.1.0
 */
function monochrome_products_match_height() {

	// If WooCommerce isn't active or not on a WooCommerce page, exit early.
	if ( ! class_exists( 'WooCommerce' ) || ! is_shop() && ! is_woocommerce() && ! is_cart() ) {
		return;
	}

	wp_enqueue_script( 'monochrome-match-height', get_stylesheet_directory_uri() . '/js/jquery.matchHeight.min.js', array( 'jquery' ), CHILD_THEME_VERSION, true );
	wp_add_inline_script( 'monochrome-match-height', "jQuery(document).ready( function() { jQuery( '.product .woocommerce-LoopProduct-link').matchHeight(); });" );

}

add_filter( 'woocommerce_style_smallscreen_breakpoint', 'monochrome_woocommerce_breakpoint' );
/**
 * Modify the WooCommerce breakpoints.
 *
 * @since 1.1.0
 */
function monochrome_woocommerce_breakpoint() {

	$current = genesis_site_layout();
	$layouts = array(
		'content-sidebar',
		'sidebar-content',
	);

	if ( in_array( $current, $layouts ) ) {
		return '1200px';
	}
	else {
		return '800px';
	}

}

add_filter( 'genesiswooc_default_products_per_page', 'monochrome_default_products_per_page' );
/**
 * Set the default products per page value.
 *
 * @since 1.1.0
 *
 * @return int Number of products to show per page.
 */
function monochrome_default_products_per_page() {
	return 8;
}

add_filter( 'woocommerce_pagination_args', 	'monochrome_woocommerce_pagination' );
/**
 * Update the next and previous arrows to the default Genesis style.
 *
 * @since 1.1.0
 *
 * @return string New next and previous text string.
 */
function monochrome_woocommerce_pagination( $args ) {

	$args['prev_text'] = sprintf( '&laquo; %s', __( 'Previous Page', 'monochrome-pro' ) );
	$args['next_text'] = sprintf( '%s &raquo;', __( 'Next Page', 'monochrome-pro' ) );

	return $args;

}

add_action( 'after_switch_theme', 'monochrome_woocommerce_image_dimensions_after_theme_setup', 1 );
/**
 * Define WooCommerce image sizes on theme activation.
 *
 * @since 1.1.0
 */
function monochrome_woocommerce_image_dimensions_after_theme_setup() {

	global $pagenow;

	if ( ! isset( $_GET['activated'] ) || $pagenow != 'themes.php' || ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	monochrome_update_woocommerce_image_dimensions();

}

add_action( 'activated_plugin', 'monochrome_woocommerce_image_dimensions_after_woo_activation', 10, 2 );
/**
 * Define the WooCommerce image sizes on WooCommerce activation.
 *
 * @since 1.1.0
 */
function monochrome_woocommerce_image_dimensions_after_woo_activation( $plugin ) {

	// Check to see if WooCommerce is being activated.
	if ( $plugin !== 'woocommerce/woocommerce.php' ) {
		return;
	}

	monochrome_update_woocommerce_image_dimensions();

}

/**
 * Update WooCommerce image dimensions.
 *
 * @since 1.1.0
 */
function monochrome_update_woocommerce_image_dimensions() {

	$catalog = array(
		'width'  => '530', // px
		'height' => '530', // px
		'crop'   => 1,     // true
	);
	$single = array(
		'width'  => '720', // px
		'height' => '720', // px
		'crop'   => 1,     // true
	);
	$thumbnail = array(
		'width'  => '180', // px
		'height' => '180', // px
		'crop'   => 1,     // true
	);

	// Image sizes.
	update_option( 'shop_catalog_image_size', $catalog );     // Product category thumbs.
	update_option( 'shop_single_image_size', $single );       // Single product image.
	update_option( 'shop_thumbnail_image_size', $thumbnail ); // Image gallery thumbs.

}
