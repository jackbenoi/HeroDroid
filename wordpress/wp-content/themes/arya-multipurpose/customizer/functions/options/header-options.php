<?php

$defaults = arya_multipurpose_get_default_theme_options();

// Panel - Site Header
$wp_customize->add_panel( 'arya_multipurpose_site_header',
	array(
		'title' => esc_html__( 'Site Header', 'arya-multipurpose' ),
		'priority' => 2,
	)
);

// Section - Logo
$wp_customize->add_section( 'arya_multipurpose_site_logo', 
	array(
		'priority'		=> 1,
		'title'			=> esc_html__( 'Site Identity', 'arya-multipurpose' ),
		'panel'			=> 'arya_multipurpose_site_header'
	)
);

// Section - Favicon
$wp_customize->add_section( 'arya_multipurpose_site_favicon', 
	array(
		'priority'		=> 1,
		'title'			=> esc_html__( 'Site Favicon', 'arya-multipurpose' ),
		'panel'			=> 'arya_multipurpose_site_header'
	)
);

// Section - Background
$wp_customize->add_section( 'arya_multipurpose_header_image', 
	array(
		'priority'		=> 1,
		'title'			=> esc_html__( 'Header Image', 'arya-multipurpose' ),
		'panel'			=> 'arya_multipurpose_site_header'
	)
);

// Section - Header
$wp_customize->add_section( 'arya_multipurpose_main_header', 
	array(
		'priority'		=> 1,
		'title'			=> esc_html__( 'Main Header', 'arya-multipurpose' ),
		'panel'			=> 'arya_multipurpose_site_header'
	)
);

$wp_customize->get_control( 'header_textcolor' )->label = esc_html__( 'Site Title Color', 'arya-multipurpose' );
$wp_customize->get_control( 'header_textcolor' )->section = 'title_tagline';

$wp_customize->get_control( 'custom_logo' )->section = 'arya_multipurpose_site_logo';
$wp_customize->get_control( 'blogname' )->section = 'arya_multipurpose_site_logo';
$wp_customize->get_control( 'blogdescription' )->section = 'arya_multipurpose_site_logo';
$wp_customize->get_control( 'header_textcolor' )->section = 'arya_multipurpose_site_logo';
$wp_customize->get_control( 'display_header_text' )->section = 'arya_multipurpose_site_logo';
$wp_customize->get_control( 'site_icon' )->section = 'arya_multipurpose_site_favicon';


// Field - Enable Sticky Header
$wp_customize->add_setting( 'arya_multipurpose_header_enable_sticky_header', 
	array(
		'sanitize_callback'		=> 'wp_validate_boolean',
		'default'				=> $defaults['arya_multipurpose_header_enable_sticky_header'],
		'capability'        => 'edit_theme_options',
	)
);

$wp_customize->add_control( 
	new Arya_Multipurpose_Customizer_Toggle_Control( 
		$wp_customize, 'arya_multipurpose_header_enable_sticky_header',
		array(
			'label'				=> esc_html__( 'Enable Sticky Header', 'arya-multipurpose' ),
			'type'				=> 'ios', 
			'section' 			=> 'arya_multipurpose_main_header',
		)
	) 
);

$wp_customize->get_control( 'header_image' )->section = 'arya_multipurpose_header_image';
$wp_customize->get_section( 'arya_multipurpose_header_image' )->title = esc_html__( 'Inner Banner', 'arya-multipurpose' );