<?php

if( ! function_exists( 'arya_multipurpose_site_layout_choices' ) ) {

	function arya_multipurpose_site_layout_choices() {

		return array(
			'boxed' => esc_html__( 'Boxed', 'arya-multipurpose' ),
			'fullwidth' => esc_html__( 'Fullwidth', 'arya-multipurpose' ),
		);
	}
}

if( ! function_exists( 'arya_multipurpose_sidebar_position_choices' ) ) {

	function arya_multipurpose_sidebar_position_choices() {

		return array( 
			'left' => get_template_directory_uri() . '/customizer/assets/images/sidebar_left.png',
			'right' => get_template_directory_uri() . '/customizer/assets/images/sidebar_right.png',
			'none' => get_template_directory_uri() . '/customizer/assets/images/sidebar_none.png', 
		);
	}
}