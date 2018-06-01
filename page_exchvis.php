<?php
/**
 * Template Name: Vis
 *
 * @package Genesis Sample
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://www.studiopress.com/
 */

if ( !is_user_logged_in () ) { // Not logged in
	wp_redirect( esc_url( home_url( '/', 'https' ) ) );
	exit;
}

// Add landing page body class to the head.
add_filter( 'body_class', 'genesis_sample_add_body_class' );
function genesis_sample_add_body_class( $classes ) {

	$classes[] = 'landing-page';

	return $classes;

}

// Remove Skip Links.
remove_action ( 'genesis_before_header', 'genesis_skip_links', 5 );

// Dequeue Skip Links Script.
add_action( 'wp_enqueue_scripts', 'genesis_sample_dequeue_skip_links' );
function genesis_sample_dequeue_skip_links() {
	wp_dequeue_script( 'skip-links' );
}

// Force full width content layout.
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

// Remove site header elements.
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );

// Remove navigation.
remove_theme_support( 'genesis-menus' );

// Remove breadcrumbs.
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

// Remove footer widgets.
remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );

// Remove site footer elements.
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'gift_vis_loop' );
function gift_vis_loop () { 
	if( current_user_can('administrator') || current_user_can('editor')) {
		if ($_GET['tool'] == 'exchange') {
			get_template_part( 'templates/report', 'exchvis' );
		} else if ($_GET['tool'] == 'gifts') {
			get_template_part( 'templates/report', 'giftsvis' );
		} else if ($_GET['tool'] == 'gift' && isset($_GET['id'])) {
			get_template_part( 'templates/report', 'gift' );
		} else {
			get_template_part( 'templates/index', 'vis' );
		}
	} else {
		get_template_part( 'templates/vis', 'unauthorised' );
	}
}

genesis();
