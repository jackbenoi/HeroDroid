<?php

$defaults = arya_multipurpose_get_default_theme_options();

// Section - Sidebar
$wp_customize->add_section( 'arya_multipurpose_woocommerce_sidebar', 
	array(
		'title'			=> esc_html__( 'Woocommerce Sidebar', 'arya-multipurpose' ),
		'panel'			=> 'woocommerce',
	)
);

// Field - Woocommerce Sidebar Position
$wp_customize->add_setting( 'arya_multipurpose_woocommerce_sidebar_position', 
	array(
		'sanitize_callback'		=> 'arya_multipurpose_sanitize_select',
		'default'				=> $defaults['arya_multipurpose_woocommerce_sidebar_position'],
	)
);

$wp_customize->add_control( 
	new Arya_Multipurpose_Radio_Image_Control( 
		$wp_customize, 'arya_multipurpose_woocommerce_sidebar_position', 
		array(
			'label'			=> esc_html__( 'Select Sidebar Position', 'arya-multipurpose' ),
			'type'			=> 'select',
			'choices' 		=> arya_multipurpose_sidebar_position_choices(),
			'section' 		=> 'arya_multipurpose_woocommerce_sidebar',
		) 
	)
);