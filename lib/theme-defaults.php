<?php
/**
 * Monochrome Pro.
 *
 * This file adds the default theme settings to the Monochrome Pro Theme.
 *
 * @package Monochrome
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/monochrome/
 */

add_filter( 'genesis_theme_settings_defaults', 'monochrome_theme_defaults' );
/**
 * Updates theme settings on reset.
 *
 * @since 1.0.0
 */
function monochrome_theme_defaults( $defaults ) {

	$defaults['blog_cat_num']              = 5;
	$defaults['content_archive']           = 'full';
	$defaults['content_archive_limit']     = 0;
	$defaults['content_archive_thumbnail'] = 0;
	$defaults['posts_nav']                 = 'numeric';
	$defaults['site_layout']               = 'full-width-content';

	return $defaults;

}

add_action( 'after_switch_theme', 'monochrome_theme_setting_defaults' );
/**
 * Updates theme settings on activation.
 *
 * @since 1.0.0
 */
function monochrome_theme_setting_defaults() {

	if ( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings( array(
			'blog_cat_num'              => 5,
			'content_archive'           => 'full',
			'content_archive_limit'     => 0,
			'content_archive_thumbnail' => 0,
			'posts_nav'                 => 'numeric',
			'site_layout'               => 'full-width-content',
		) );

	} 

	update_option( 'posts_per_page', 5 );

}

add_filter( 'simple_social_default_styles', 'monochrome_social_default_styles' );
/**
 * Updates Simple Social Icon settings on activation.
 *
 * @since 1.0.0
 */
function monochrome_social_default_styles( $defaults ) {

	$args = array(
		'alignment'              => 'alignleft',
		'background_color'       => '#f5f5f5',
		'background_color_hover' => '#000000',
		'border_radius'          => 3,
		'icon_color'             => '#000000',
		'icon_color_hover'       => '#ffffff',
		'size'                   => 38,
		);

	$args = wp_parse_args( $args, $defaults );

	return $args;

}
