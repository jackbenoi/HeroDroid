<?php

$defaults = arya_multipurpose_get_default_theme_options();

// Section - Layout
$wp_customize->add_section( 'arya_multipurpose_site_layout', 
	array(
		'priority'		=> 1,
		'title'			=> esc_html__( 'Site Layout', 'arya-multipurpose' ),
	)
);

// Field - Select Layout
$wp_customize->add_setting( 'arya_multipurpose_select_site_layout', 
	array(
		'sanitize_callback'		=> 'arya_multipurpose_sanitize_select',
		'default'				=> $defaults['arya_multipurpose_select_site_layout'],
		'capability'        	=> 'edit_theme_options',
	)
);

$wp_customize->add_control( 'arya_multipurpose_select_site_layout', 
	array(
		'label'			=> esc_html__( 'Select Layout', 'arya-multipurpose' ),
		'type'			=> 'radio',
		'choices' 		=> arya_multipurpose_site_layout_choices(),
		'section' 		=> 'arya_multipurpose_site_layout',
	) 
);