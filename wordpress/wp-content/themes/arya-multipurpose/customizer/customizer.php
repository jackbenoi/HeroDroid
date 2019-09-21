<?php
/**
 * Arya Multipurpose Theme Customizer
 *
 * @package Arya_Multipurpose
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function arya_multipurpose_customize_register( $wp_customize ) {

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	/**
	 * Load custom customizer control for radio image control
	 */
	require get_template_directory() . '/customizer/controls/class-customizer-radio-image-control.php';

	/**
	 * Load custom customizer control for toggle control
	 */
	require get_template_directory() . '/customizer/controls/class-customizer-toggle-control.php';

	/**
	 * Load customizer functions for sanitization of input values of contol fields
	 */
	require get_template_directory() . '/customizer/functions/sanitize-callback.php';

	// Upspell
	require_once trailingslashit( get_template_directory() ) . '/customizer/upgrade-to-pro/upgrade.php';

	$wp_customize->register_section_type( 'Arya_Multipurpose_Customize_Section_Upsell' );

	// Register sections.
	$wp_customize->add_section(
		new Arya_Multipurpose_Customize_Section_Upsell(
			$wp_customize,
			'theme_upsell',
			array(
				'title'    => esc_html__( 'Arya Multipurpose Pro', 'arya-multipurpose' ),
				'pro_text' => esc_html__( 'Buy Now', 'arya-multipurpose' ),
				'pro_url'  => 'https://everestthemes.com/themes/arya-multipurpose-pro-themes/',
				'priority' => 1,
			)
		)
	);
	
	/**
	 * Load customizer options
	 */
	require get_template_directory() . '/customizer/functions/options.php';


	if ( isset( $wp_customize->selective_refresh ) ) {

		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'arya_multipurpose_customize_partial_blogname',
		) );

		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'arya_multipurpose_customize_partial_blogdescription',
		) );
	}
}
add_action( 'customize_register', 'arya_multipurpose_customize_register' );

/**
 * Load function to load customizer field's default values.
 */
require get_template_directory() . '/customizer/functions/customizer-defaults.php';


/**
 * Load function to load customizer field's option choices.
 */
require get_template_directory() . '/customizer/functions/option-choices.php';


/**
 * Load function to load dynamic style.
 */
require get_template_directory() . '/customizer/functions/dynamic-style.php';

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function arya_multipurpose_customize_partial_blogname() {

	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function arya_multipurpose_customize_partial_blogdescription() {

	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function arya_multipurpose_customize_preview_js() {

	wp_enqueue_script( 'arya-multipurpose-customizer', get_template_directory_uri() . '/customizer/assets/js/customizer.js', array( 'customize-preview' ), ARYA_MULTIPURPOSE_VERSION, true );
}
add_action( 'customize_preview_init', 'arya_multipurpose_customize_preview_js' );

/**
 * Enqueue Customizer Scripts and Styles
 */
function arya_multipurpose_customizer_enqueues() {

	wp_enqueue_style( 'arya-multipurpose-upgrade', get_template_directory_uri() . '/customizer/upgrade-to-pro/upgrade.css' );

	wp_enqueue_style( 'arya-multipurpose-customizer-style', get_template_directory_uri() . '/customizer/assets/css/customizer-style.css' );

	wp_enqueue_script( 'arya-multipurpose-upgrade', get_template_directory_uri() . '/customizer/upgrade-to-pro/upgrade.js', array( 'jquery' ), ARYA_MULTIPURPOSE_VERSION, true );

	wp_enqueue_script( 'arya-multipurpose-customizer-script', get_template_directory_uri() . '/customizer/assets/js/customizer-script.js', array( 'jquery' ), ARYA_MULTIPURPOSE_VERSION, true );
}
add_action( 'customize_controls_enqueue_scripts', 'arya_multipurpose_customizer_enqueues' );
