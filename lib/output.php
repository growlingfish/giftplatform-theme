<?php
/**
 * Monochrome Pro.
 *
 * This file adds the required CSS to the front end to the Monochrome Pro Theme.
 *
 * @package Monochrome
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/monochrome/
 */

add_action( 'wp_enqueue_scripts', 'monochrome_css' );
/**
 * Checks the settings for the link color and accent color.
 * If any of these value are set the appropriate CSS is output.
 *
 * @since 1.0.0
 */
function monochrome_css() {

	$handle  = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

	$color_link   = get_theme_mod( 'monochrome_link_color', monochrome_customizer_get_default_link_color() );
	$color_accent = get_theme_mod( 'monochrome_accent_color', monochrome_customizer_get_default_accent_color() );
	$footer_start = get_theme_mod( 'monochrome_footer_start_color', monochrome_customizer_get_default_footer_start_color() );
	$footer_end   = get_theme_mod( 'monochrome_footer_end_color', monochrome_customizer_get_default_footer_end_color() );

	$opts = apply_filters( 'monochrome_images', array( '1', '3', '5', '7' ) );

	$settings = array();

	foreach( $opts as $opt ) {
		$settings[$opt]['image'] = preg_replace( '/^https?:/', '', get_option( $opt .'-monochrome-image', sprintf( '%s/images/bg-%s.jpg', get_stylesheet_directory_uri(), $opt ) ) );
	}

	$css = '';

	foreach ( $settings as $section => $value ) {

		$background = $value['image'] ? sprintf( 'background-image: url(%s);', $value['image'] ) : '';

		if ( is_front_page() ) {
			$css .= ( ! empty( $section ) && ! empty( $background ) ) ? sprintf( '.front-page-%s { %s }', $section, $background ) : '';
		}

	}

	$css .= ( monochrome_customizer_get_default_link_color() !== $color_link ) ? sprintf( '

		a,
		.entry-meta a:hover,
		.entry-meta a:focus,
		.entry-title a:hover,
		.entry-title a:focus,
		.genesis-nav-menu a:focus,
		.genesis-nav-menu a:hover,
		.genesis-nav-menu .current-menu-item > a,
		.genesis-nav-menu .toggle-header-search:focus,
		.genesis-nav-menu .toggle-header-search:hover,
		.genesis-responsive-menu .genesis-nav-menu a:focus,
		.genesis-responsive-menu .genesis-nav-menu a:hover,
		.sub-menu-toggle:focus,
		.sub-menu-toggle:hover,
		#genesis-mobile-nav-primary:focus,
		#genesis-mobile-nav-primary:hover {
			color: %1$s;
		}

		@media only screen and (max-width: 1023px) {
			.genesis-responsive-menu .genesis-nav-menu a:focus,
			.genesis-responsive-menu .genesis-nav-menu a:hover,
			.genesis-responsive-menu .genesis-nav-menu .sub-menu .menu-item a:focus,
			.genesis-responsive-menu .genesis-nav-menu .sub-menu .menu-item a:hover,
			.genesis-responsive-menu.nav-primary .genesis-nav-menu .sub-menu .current-menu-item > a {
				color: %1$s;
			}
		}

		', $color_link ) : '';

	$css .= ( monochrome_customizer_get_default_accent_color() !== $color_accent ) ? sprintf( '

		button:hover,
		button:focus,
		input:hover[type="button"],
		input:hover[type="reset"],
		input:hover[type="submit"],
		input:focus[type="button"],
		input:focus[type="reset"],
		input:focus[type="submit"],
		.archive-pagination a:hover,
		.archive-pagination a:focus,
		.archive-pagination li.active a,
		.button:hover,
		.button:focus,
		.image-section button:hover,
		.image-section button:focus,
		.image-section input[type="button"]:hover,
		.image-section input[type="button"]:focus,
		.image-section input[type="reset"]:hover,
		.image-section input[type="reset"]:focus,
		.image-section input[type="submit"]:hover,
		.image-section input[type="submit"]:focus,
		.image-section .button:hover,
		.image-section .button:focus,
		.image-section .more-link:hover,
		.image-section .more-link:focus,
		.more-link:hover,
		.more-link:focus {
			background-color: %1$s;
			color: %2$s;
		}
		', $color_accent, monochrome_color_contrast( $color_accent ), monochrome_change_brightness( $color_accent ) ) : '';

	$css .= ( $footer_start !== monochrome_customizer_get_default_footer_start_color() ||
			  $footer_end   !== monochrome_customizer_get_default_footer_end_color()
			) ? sprintf('
			.before-footer-cta {
				background-color: %1$s;
				background: linear-gradient(45deg,%1$s,%2$s);
			}

			.before-footer-cta,
			.before-footer-cta a,
			.before-footer-cta p,
			.before-footer-cta .widget-title {
				color: %3$s;
			}
			', $footer_start, $footer_end, monochrome_color_contrast( $footer_start ) ) : '';

	if ( $css ) {
		wp_add_inline_style( $handle, $css );
	}

}
