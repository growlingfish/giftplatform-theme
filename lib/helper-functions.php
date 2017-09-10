<?php
/**
 * Monochrome Pro.
 *
 * This file defines helper functions used elsewhere in the Monochrome Pro Theme.
 *
 * @package Monochrome
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/monochrome/
 */

/**
 * Get default link color for Customizer.
 * Abstracted here since at least two functions use it.
 *
 * @since 1.0.0
 *
 * @return string Hex color code for link color.
 */
function monochrome_customizer_get_default_link_color() {
	return '#0066cc';
}

/**
 * Get default accent color for Customizer.
 * Abstracted here since at least two functions use it.
 *
 * @since 1.0.0
 *
 * @return string Hex color code for accent color.
 */
function monochrome_customizer_get_default_accent_color() {
	return '#0066cc';
}

/**
 * Get default footer start color for Customizer.
 * Abstracted here since at least two functions use it.
 *
 * @since 1.0.0
 *
 * @return string Hex color code for footer start color.
 */
function monochrome_customizer_get_default_footer_start_color() {
	return '#0066cc';
}

/**
 * Get default footer end color for Customizer.
 * Abstracted here since at least two functions use it.
 *
 * @since 1.0.0
 *
 * @return string Hex color code for footer end color.
 */
function monochrome_customizer_get_default_footer_end_color() {
	return '#02cbfb';
}

/**
 * Get default search icon settings for Customizer.
 *
 * @since 1.0.0
 *
 * @return int 1 for true, in order to show the icon.
 */
function monochrome_customizer_get_default_search_setting() {
	return 1;
}

/**
 * Output the header search form toggle button.
 *
 * @return string HTML output of the Show Search button.
 *
 * @since 1.0.0
 */
function monochrome_get_header_search_toggle() {
	return sprintf( '<a href="#header-search-wrap" aria-controls="header-search-wrap" aria-expanded="false" role="button" class="toggle-header-search"><span class="screen-reader-text">%s</span><span class="ionicons ion-ios-search"></span></a>', __( 'Show Search', 'monochrome-pro' ) );
}

/**
 * Output the header search form.
 *
 * @since 1.0.0
 */
function monochrome_do_header_search_form() {

	$button = sprintf( '<a href="#" role="button" aria-expanded="false" aria-controls="header-search-wrap" class="toggle-header-search close"><span class="screen-reader-text">%s</span><span class="ionicons ion-ios-close-empty"></span></a>', __( 'Hide Search', 'monochrome-pro' ) );

	printf(
		'<div id="header-search-wrap" class="header-search-wrap">%s %s</div>',
		get_search_form( false ),
		$button
	);

}

/**
 * Calculate color contrast.
 *
 * @since 1.0.0
 */
function monochrome_color_contrast( $color ) {

	$hexcolor = str_replace( '#', '', $color );

	$red   = hexdec( substr( $hexcolor, 0, 2 ) );
	$green = hexdec( substr( $hexcolor, 2, 2 ) );
	$blue  = hexdec( substr( $hexcolor, 4, 2 ) );

	$luminosity = ( ( $red * 0.2126 ) + ( $green * 0.7152 ) + ( $blue * 0.0722 ) );

	return ( $luminosity > 128 ) ? '#000000' : '#ffffff';

}

/**
 * Calculate color brightness.
 *
 * @since 1.0.0
 */
function monochrome_color_brightness( $color, $change ) {

	$hexcolor = str_replace( '#', '', $color );

	$red   = hexdec( substr( $hexcolor, 0, 2 ) );
	$green = hexdec( substr( $hexcolor, 2, 2 ) );
	$blue  = hexdec( substr( $hexcolor, 4, 2 ) );

	$red   = max( 0, min( 255, $red + $change ) );
	$green = max( 0, min( 255, $green + $change ) );
	$blue  = max( 0, min( 255, $blue + $change ) );

	return '#'.dechex( $red ).dechex( $green ).dechex( $blue );

}

/**
 * Change color brightness.
 *
 * @since 1.0.0
 */
function monochrome_change_brightness( $color ) {

	$hexcolor = str_replace( '#', '', $color );

	$red   = hexdec( substr( $hexcolor, 0, 2 ) );
	$green = hexdec( substr( $hexcolor, 2, 2 ) );
	$blue  = hexdec( substr( $hexcolor, 4, 2 ) );

	$luminosity = ( ( $red * 0.2126 ) + ( $green * 0.7152 ) + ( $blue * 0.0722 ) );

	return ( $luminosity > 128 ) ? monochrome_color_brightness( '#000000', 20 ) : monochrome_color_brightness( '#ffffff', -50 );

}
