<?php

$defaults = arya_multipurpose_get_default_theme_options();

// Section - Footer
$wp_customize->add_section( 'arya_multipurpose_site_footer', 
	array(
		'priority'		=> 2,
		'title'			=> esc_html__( 'Site Footer', 'arya-multipurpose' ),
	)
);

// Field - Copyright Text
$wp_customize->add_setting( 'arya_multipurpose_footer_copyright_text', 
	array(
		'sanitize_callback'		=> 'sanitize_text_field',
		'default'				=> $defaults['arya_multipurpose_footer_copyright_text'],
		'capability'        => 'edit_theme_options',
	)
);

$wp_customize->add_control( 
	'arya_multipurpose_footer_copyright_text',
	array(
		'label'				=> esc_html__( 'Copyright Text', 'arya-multipurpose' ),
		'type'				=> 'text',
		'section' 			=> 'arya_multipurpose_site_footer',
	) 
);

// Field - Show Scroll Top Button
$wp_customize->add_setting( 'arya_multipurpose_footer_display_to_top_btn', 
	array(
		'sanitize_callback'		=> 'wp_validate_boolean',
		'default'				=> $defaults['arya_multipurpose_footer_display_to_top_btn'],
		'capability'        	=> 'edit_theme_options',
	)
);

$wp_customize->add_control( 
	new Arya_Multipurpose_Customizer_Toggle_Control( 
		$wp_customize, 'arya_multipurpose_footer_display_to_top_btn',
		array(
			'label'				=> esc_html__( 'Show Scroll Top Button', 'arya-multipurpose' ),
			'type'				=> 'ios', 
			'section' 			=> 'arya_multipurpose_site_footer',
		)
	) 
);