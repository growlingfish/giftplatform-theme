<?php
/**
 * Monochrome Pro.
 *
 * This file adds the Customizer additions to the Monochrome Pro Theme.
 *
 * @package Monochrome
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/monochrome/
 */

add_action( 'customize_register', 'monochrome_customizer_register' );
/**
 * Register settings and controls with the Customizer.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function monochrome_customizer_register( $wp_customize ) {

	$images = apply_filters( 'monochrome_images', array( '1', '3' ) );

	$wp_customize->add_section( 'monochrome_theme_options', array(
		'description' => __( 'Personalize the Monochrome Pro theme with these available options.', 'monochrome-pro' ),
		'title'       => __( 'Theme Options', 'monochrome-pro' ),
		'priority'    => 30,
	) );

	$wp_customize->add_section( 'monochrome-settings', array(
		'description' => __( 'Use the included default images or personalize your site by uploading your own images.<br /><br />The default images are <strong>1600 pixels wide and 800 pixels tall</strong>.', 'monochrome-pro' ),
		'title'       => __( 'Front Page Background Images', 'monochrome-pro' ),
		'priority'    => 35,
	) );

	foreach( $images as $image ) {

		// Add setting for front page background images.
		$wp_customize->add_setting( $image .'-monochrome-image', array(
			'default'           => sprintf( '%s/images/bg-%s.jpg', get_stylesheet_directory_uri(), $image ),
			'sanitize_callback' => 'esc_url_raw',
			'type'              => 'option',
		) );

		// Add control for front page background images.
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $image .'-monochrome-image', array(
			'label'    => sprintf( __( 'Featured Section %s Image:', 'monochrome-pro' ), $image ),
			'section'  => 'monochrome-settings',
			'settings' => $image .'-monochrome-image',
			'priority' => $image+1,
		) ) );

	}

	// Add setting for link color.
	$wp_customize->add_setting(
		'monochrome_link_color',
		array(
			'default'           => monochrome_customizer_get_default_link_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	// Add control for link color.
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'monochrome_link_color',
			array(
				'description' => __( 'Change the default color for hovers for linked titles, menu links, entry meta links, and more.', 'monochrome-pro' ),
				'label'       => __( 'Link Color', 'monochrome-pro' ),
				'section'     => 'colors',
				'settings'    => 'monochrome_link_color',
			)
		)
	);

	// Add setting for accent color.
	$wp_customize->add_setting(
		'monochrome_accent_color',
		array(
			'default'           => monochrome_customizer_get_default_accent_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	// Add control for accent color.
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'monochrome_accent_color',
			array(
				'description' => __( 'Change the default color for button hovers.', 'monochrome-pro' ),
				'label'       => __( 'Accent Color', 'monochrome-pro' ),
				'section'     => 'colors',
				'settings'    => 'monochrome_accent_color',
			)
		)
	);

	// Add setting for footer start color.
	$wp_customize->add_setting(
		'monochrome_footer_start_color',
		array(
			'default'           => monochrome_customizer_get_default_footer_start_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	// Add control for footer start color.
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'monochrome_footer_start_color',
			array(
				'description' => __( 'Change the default color for start of footer gradient.', 'monochrome-pro' ),
				'label'       => __( 'Footer Start Color', 'monochrome-pro' ),
				'section'     => 'colors',
				'settings'    => 'monochrome_footer_start_color',
			)
		)
	);

	// Add setting for footer end color.
	$wp_customize->add_setting(
		'monochrome_footer_end_color',
		array(
			'default'           => monochrome_customizer_get_default_footer_end_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	// Add control for footer end color.
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'monochrome_footer_end_color',
			array(
				'description' => __( 'Change the default color for end of footer gradient.', 'monochrome-pro' ),
				'label'       => __( 'Footer End Color', 'monochrome-pro' ),
				'section'     => 'colors',
				'settings'    => 'monochrome_footer_end_color',
			)
		)
	);

	// Add control for search option.
	$wp_customize->add_setting(
		'monochrome_header_search',
		array(
			'default'           => monochrome_customizer_get_default_search_setting(),
			'sanitize_callback' => 'absint',
		)
	);

	// Add setting for search option.
	$wp_customize->add_control(
		'monochrome_header_search',
		array(
			'label'       => __( 'Show Menu Search Icon?', 'monochrome-pro' ),
			'description' => __( 'Check the box to show a search icon in the menu.', 'monochrome-pro' ),
			'section'     => 'monochrome_theme_options',
			'type'        => 'checkbox',
			'settings'    => 'monochrome_header_search',
		)
	);

}
