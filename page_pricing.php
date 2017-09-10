<?php
/**
 * Monochrome Pro.
 *
 * This file adds the pricing page template to the Monochrome Pro Theme.
 *
 * Template Name: Pricing
 *
 * @package Monochrome
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/monochrome/
 */

// Add pricing page body class to the head.
add_filter( 'body_class', 'monochrome_add_body_class' );
function monochrome_add_body_class( $classes ) {

	$classes[] = 'pricing-page';

	return $classes;

}

// Force full width content layout.
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

// Run the Genesis loop.
genesis();
