<?php

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function arya_multipurpose_widgets_init() {

	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'arya-multipurpose' ),
		'id'            => 'arya-multipurpose-sidebar',
		'description'   => esc_html__( 'Add widgets here.', 'arya-multipurpose' ),
		'before_widget' => '<div id="%1$s" class="single-widget widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 1', 'arya-multipurpose' ),
		'id'            => 'arya-multipurpose-footer-1',
		'description'   => esc_html__( 'Add widgets here.', 'arya-multipurpose' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 2', 'arya-multipurpose' ),
		'id'            => 'arya-multipurpose-footer-2',
		'description'   => esc_html__( 'Add widgets here.', 'arya-multipurpose' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 3', 'arya-multipurpose' ),
		'id'            => 'arya-multipurpose-footer-3',
		'description'   => esc_html__( 'Add widgets here.', 'arya-multipurpose' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 4', 'arya-multipurpose' ),
		'id'            => 'arya-multipurpose-footer-4',
		'description'   => esc_html__( 'Add widgets here.', 'arya-multipurpose' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	if( class_exists( 'Woocommerce' ) ) {

		register_sidebar( array(
			'name'          => esc_html__( 'Woocommerce Sidebar', 'arya-multipurpose' ),
			'id'            => 'arya-multipurpose-woocommerce-sidebar',
			'description'   => esc_html__( 'Add widgets here.', 'arya-multipurpose' ),
			'before_widget' => '<div id="%1$s" class="single-widget widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		) );
	}

	register_widget( 'Arya_Multipurpose_Post_Widget' );

	register_widget( 'Arya_Multipurpose_Social_Widget' );
}
add_action( 'widgets_init', 'arya_multipurpose_widgets_init' );


/**
 * Class for widgets displaying recent posts.
 */
require get_template_directory() . '/widgets/theme/recent-posts.php';

/**
 * Class for widgets displaying social links.
 */
require get_template_directory() . '/widgets/theme/social-links.php';