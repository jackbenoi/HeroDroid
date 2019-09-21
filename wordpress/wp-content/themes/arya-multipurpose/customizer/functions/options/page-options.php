<?php

$defaults = arya_multipurpose_get_default_theme_options();

// Panel - Inner Pages
$wp_customize->add_panel( 'arya_multipurpose_site_pages',
	array(
		'title' 	=> esc_html__( 'Site Pages', 'arya-multipurpose' ),
		'priority' 	=> 2,
	)
);


/*================================== Blog Page Customizer Fields ===============================*/

// Section - Blog Page
$wp_customize->add_section( 'arya_multipurpose_blog_page', 
	array(
		'priority'		=> 2,
		'title'			=> esc_html__( 'Blog Page', 'arya-multipurpose' ),
		'panel'			=> 'arya_multipurpose_site_pages',
	)
);

// Field - Display Post Category
$wp_customize->add_setting( 'arya_multipurpose_blog_display_categories', 
	array(
		'sanitize_callback'		=> 'wp_validate_boolean',
		'default'				=> $defaults['arya_multipurpose_blog_display_categories'],
		'capability'        	=> 'edit_theme_options',
	)
);

$wp_customize->add_control( 
	new Arya_Multipurpose_Customizer_Toggle_Control( 
		$wp_customize, 'arya_multipurpose_blog_display_categories',
		array(
			'label'				=> esc_html__( 'Display Post Category', 'arya-multipurpose' ),
			'type'				=> 'ios', 
			'section' 			=> 'arya_multipurpose_blog_page',
		)
	) 
);

// Field - Display Post Author & Date
$wp_customize->add_setting( 'arya_multipurpose_blog_display_author_date', 
	array(
		'sanitize_callback'		=> 'wp_validate_boolean',
		'default'				=> $defaults['arya_multipurpose_blog_display_author_date'],
		'capability'        	=> 'edit_theme_options',
	)
);

$wp_customize->add_control( 
	new Arya_Multipurpose_Customizer_Toggle_Control( 
		$wp_customize, 'arya_multipurpose_blog_display_author_date',
		array(
			'label'				=> esc_html__( 'Display Post Author & Date', 'arya-multipurpose' ),
			'type'				=> 'ios', 
			'section' 			=> 'arya_multipurpose_blog_page',
		)
	) 
);

// Field - Display Post Excerpt
$wp_customize->add_setting( 'arya_multipurpose_blog_display_excerpt', 
	array(
		'sanitize_callback'		=> 'wp_validate_boolean',
		'default'				=> $defaults['arya_multipurpose_blog_display_excerpt'],
		'capability'        	=> 'edit_theme_options',
	)
);

$wp_customize->add_control( 
	new Arya_Multipurpose_Customizer_Toggle_Control( 
		$wp_customize, 'arya_multipurpose_blog_display_excerpt',
		array(
			'label'				=> esc_html__( 'Display Post Excerpt', 'arya-multipurpose' ),
			'type'				=> 'ios', 
			'section' 			=> 'arya_multipurpose_blog_page',
		)
	) 
);

// Field - Display Post Featured Image
$wp_customize->add_setting( 'arya_multipurpose_blog_display_featured_image', 
	array(
		'sanitize_callback'		=> 'wp_validate_boolean',
		'default'				=> $defaults['arya_multipurpose_blog_display_featured_image'],
		'capability'        	=> 'edit_theme_options',
	)
);

$wp_customize->add_control( 
	new Arya_Multipurpose_Customizer_Toggle_Control( 
		$wp_customize, 'arya_multipurpose_blog_display_featured_image',
		array(
			'label'				=> esc_html__( 'Display Post Featured Image', 'arya-multipurpose' ),
			'type'				=> 'ios', 
			'section' 			=> 'arya_multipurpose_blog_page',
		)
	) 
);



/*=============================== Archive Page Customizer Fields ===============================*/

// Section - Archive Page
$wp_customize->add_section( 'arya_multipurpose_archive_page', 
	array(
		'priority'		=> 2,
		'title'			=> esc_html__( 'Archive Page', 'arya-multipurpose' ),
		'panel'			=> 'arya_multipurpose_site_pages',
	)
);

// Field - Display Post Category
$wp_customize->add_setting( 'arya_multipurpose_archive_display_categories', 
	array(
		'sanitize_callback'		=> 'wp_validate_boolean',
		'default'				=> $defaults['arya_multipurpose_archive_display_categories'],
		'capability'        	=> 'edit_theme_options',
	)
);

$wp_customize->add_control( 
	new Arya_Multipurpose_Customizer_Toggle_Control( 
		$wp_customize, 'arya_multipurpose_archive_display_categories',
		array(
			'label'				=> esc_html__( 'Display Post Category', 'arya-multipurpose' ),
			'type'				=> 'ios', 
			'section' 			=> 'arya_multipurpose_archive_page',
		)
	) 
);

// Field - Display Post Author & Date
$wp_customize->add_setting( 'arya_multipurpose_archive_display_author_date', 
	array(
		'sanitize_callback'		=> 'wp_validate_boolean',
		'default'				=> $defaults['arya_multipurpose_archive_display_author_date'],
		'capability'        	=> 'edit_theme_options',
	)
);

$wp_customize->add_control( 
	new Arya_Multipurpose_Customizer_Toggle_Control( 
		$wp_customize, 'arya_multipurpose_archive_display_author_date',
		array(
			'label'				=> esc_html__( 'Display Post Author & Date', 'arya-multipurpose' ),
			'type'				=> 'ios', 
			'section' 			=> 'arya_multipurpose_archive_page',
		)
	) 
);

// Field - Display Post Excerpt
$wp_customize->add_setting( 'arya_multipurpose_archive_display_excerpt', 
	array(
		'sanitize_callback'		=> 'wp_validate_boolean',
		'default'				=> $defaults['arya_multipurpose_archive_display_excerpt'],
		'capability'        	=> 'edit_theme_options',
	)
);

$wp_customize->add_control( 
	new Arya_Multipurpose_Customizer_Toggle_Control( 
		$wp_customize, 'arya_multipurpose_archive_display_excerpt',
		array(
			'label'				=> esc_html__( 'Display Post Excerpt', 'arya-multipurpose' ),
			'type'				=> 'ios', 
			'section' 			=> 'arya_multipurpose_archive_page',
		)
	) 
);

// Field - Display Post Featured Image
$wp_customize->add_setting( 'arya_multipurpose_archive_display_featured_image', 
	array(
		'sanitize_callback'		=> 'wp_validate_boolean',
		'default'				=> $defaults['arya_multipurpose_archive_display_featured_image'],
		'capability'        	=> 'edit_theme_options',
	)
);

$wp_customize->add_control( 
	new Arya_Multipurpose_Customizer_Toggle_Control( 
		$wp_customize, 'arya_multipurpose_archive_display_featured_image',
		array(
			'label'				=> esc_html__( 'Display Post Featured Image', 'arya-multipurpose' ),
			'type'				=> 'ios', 
			'section' 			=> 'arya_multipurpose_archive_page',
		)
	) 
);



/*================================ Search Page Customizer Fields ================================*/

// Section - Search Page
$wp_customize->add_section( 'arya_multipurpose_search_page', 
	array(
		'priority'		=> 2,
		'title'			=> esc_html__( 'Search Page', 'arya-multipurpose' ),
		'panel'			=> 'arya_multipurpose_site_pages',
	)
);

// Field - Display Post Category
$wp_customize->add_setting( 'arya_multipurpose_search_display_categories', 
	array(
		'sanitize_callback'		=> 'wp_validate_boolean',
		'default'				=> $defaults['arya_multipurpose_search_display_categories'],
		'capability'        	=> 'edit_theme_options',
	)
);

$wp_customize->add_control( 
	new Arya_Multipurpose_Customizer_Toggle_Control( 
		$wp_customize, 'arya_multipurpose_search_display_categories',
		array(
			'label'				=> esc_html__( 'Display Post Category', 'arya-multipurpose' ),
			'type'				=> 'ios', 
			'section' 			=> 'arya_multipurpose_search_page',
		)
	) 
);

// Field - Display Post Author & Date
$wp_customize->add_setting( 'arya_multipurpose_search_display_author_date', 
	array(
		'sanitize_callback'		=> 'wp_validate_boolean',
		'default'				=> $defaults['arya_multipurpose_search_display_author_date'],
		'capability'        	=> 'edit_theme_options',
	)
);

$wp_customize->add_control( 
	new Arya_Multipurpose_Customizer_Toggle_Control( 
		$wp_customize, 'arya_multipurpose_search_display_author_date',
		array(
			'label'				=> esc_html__( 'Display Post Author & Date', 'arya-multipurpose' ),
			'type'				=> 'ios', 
			'section' 			=> 'arya_multipurpose_search_page',
		)
	) 
);

// Field - Display Post Excerpt
$wp_customize->add_setting( 'arya_multipurpose_search_display_excerpt', 
	array(
		'sanitize_callback'		=> 'wp_validate_boolean',
		'default'				=> $defaults['arya_multipurpose_search_display_excerpt'],
		'capability'        	=> 'edit_theme_options',
	)
);

$wp_customize->add_control( 
	new Arya_Multipurpose_Customizer_Toggle_Control( 
		$wp_customize, 'arya_multipurpose_search_display_excerpt',
		array(
			'label'				=> esc_html__( 'Display Post Excerpt', 'arya-multipurpose' ),
			'type'				=> 'ios', 
			'section' 			=> 'arya_multipurpose_search_page',
		)
	) 
);

// Field - Display Post Featured Image
$wp_customize->add_setting( 'arya_multipurpose_search_display_featured_image', 
	array(
		'sanitize_callback'		=> 'wp_validate_boolean',
		'default'				=> $defaults['arya_multipurpose_search_display_featured_image'],
		'capability'        	=> 'edit_theme_options',
	)
);

$wp_customize->add_control( 
	new Arya_Multipurpose_Customizer_Toggle_Control( 
		$wp_customize, 'arya_multipurpose_search_display_featured_image',
		array(
			'label'				=> esc_html__( 'Display Post Featured Image', 'arya-multipurpose' ),
			'type'				=> 'ios', 
			'section' 			=> 'arya_multipurpose_search_page',
		)
	) 
);




/*=============================== Post Single Customizer Fields ===============================*/

// Section - Excerpt
$wp_customize->add_section( 'arya_multipurpose_post_single', 
	array(
		'priority'		=> 2,
		'title'			=> esc_html__( 'Post Single', 'arya-multipurpose' ),
		'panel'			=> 'arya_multipurpose_site_pages',
	)
);

// Field - Display Post Category
$wp_customize->add_setting( 'arya_multipurpose_post_single_display_categories', 
	array(
		'sanitize_callback'		=> 'wp_validate_boolean',
		'default'				=> $defaults['arya_multipurpose_post_single_display_categories'],
		'capability'        	=> 'edit_theme_options',
	)
);

$wp_customize->add_control( 
	new Arya_Multipurpose_Customizer_Toggle_Control( 
		$wp_customize, 'arya_multipurpose_post_single_display_categories',
		array(
			'label'				=> esc_html__( 'Display Post Category', 'arya-multipurpose' ),
			'type'				=> 'ios', 
			'section' 			=> 'arya_multipurpose_post_single',
		)
	) 
);

// Field - Display Post Author & Date
$wp_customize->add_setting( 'arya_multipurpose_post_single_display_author_date', 
	array(
		'sanitize_callback'		=> 'wp_validate_boolean',
		'default'				=> $defaults['arya_multipurpose_post_single_display_author_date'],
		'capability'        	=> 'edit_theme_options',
	)
);

$wp_customize->add_control( 
	new Arya_Multipurpose_Customizer_Toggle_Control( 
		$wp_customize, 'arya_multipurpose_post_single_display_author_date',
		array(
			'label'				=> esc_html__( 'Display Post Author & Date', 'arya-multipurpose' ),
			'type'				=> 'ios',
			'section' 			=> 'arya_multipurpose_post_single',
		)
	) 
);

// Field - Display Post Tags
$wp_customize->add_setting( 'arya_multipurpose_post_single_display_tags', 
	array(
		'sanitize_callback'		=> 'wp_validate_boolean',
		'default'				=> $defaults['arya_multipurpose_post_single_display_tags'],
		'capability'        	=> 'edit_theme_options',
	)
);

$wp_customize->add_control( 
	new Arya_Multipurpose_Customizer_Toggle_Control( 
		$wp_customize, 'arya_multipurpose_post_single_display_tags',
		array(
			'label'				=> esc_html__( 'Display Post Tags', 'arya-multipurpose' ),
			'type'				=> 'ios', 
			'section' 			=> 'arya_multipurpose_post_single',
		)
	) 
);

// Field - Display Post Featured Image
$wp_customize->add_setting( 'arya_multipurpose_post_single_display_featured_image', 
	array(
		'sanitize_callback'		=> 'wp_validate_boolean',
		'default'				=> $defaults['arya_multipurpose_post_single_display_featured_image'],
		'capability'        	=> 'edit_theme_options',
	)
);

$wp_customize->add_control( 
	new Arya_Multipurpose_Customizer_Toggle_Control( 
		$wp_customize, 'arya_multipurpose_post_single_display_featured_image',
		array(
			'label'				=> esc_html__( 'Display Post Featured Image', 'arya-multipurpose' ),
			'type'				=> 'ios',
			'section' 			=> 'arya_multipurpose_post_single',
		)
	) 
);



/*=============================== Excerpt Customizer Fields ===============================*/

// Section - Excerpt
$wp_customize->add_section( 'arya_multipurpose_common', 
	array(
		'priority'		=> 2,
		'title'			=> esc_html__( 'Common Options', 'arya-multipurpose' ),
		'panel'			=> 'arya_multipurpose_site_pages',
	)
);

// Field - Excerpt Length
$wp_customize->add_setting( 'arya_multipurpose_excerpt_length', 
	array(
		'sanitize_callback'		=> 'arya_multipurpose_sanitize_number',
		'default'				=> $defaults['arya_multipurpose_excerpt_length'],
		'capability'        => 'edit_theme_options',
	)
);

$wp_customize->add_control( 
	'arya_multipurpose_excerpt_length',
	array(
		'label'				=> esc_html__( 'Excerpt Length', 'arya-multipurpose' ),
		'description'		=> esc_html__( 'Excerpt is short content of post. Excerpt length controls the number of words to display.', 'arya-multipurpose' ),
		'type'				=> 'number',
		'section' 			=> 'arya_multipurpose_common',
	) 
);