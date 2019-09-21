<?php

if ( ! function_exists( 'arya_multipurpose_get_option' ) ) {

    /**
     * Get theme option.
     *
     * @since 1.0.0
     *
     * @param string $key Option key.
     * @return mixed Option value.
     */
    function arya_multipurpose_get_option( $key ) {

        if ( empty( $key ) ) {
            return;
        }

        $value = '';

        $default = arya_multipurpose_get_default_theme_options();

        $default_value = null;

        if ( is_array( $default ) && isset( $default[ $key ] ) ) {
            $default_value = $default[ $key ];
        }

        if ( null !== $default_value ) {
            $value = get_theme_mod( $key, $default_value );
        }
        else {
            $value = get_theme_mod( $key );
        }

        return $value;
    }
}


if ( ! function_exists( 'arya_multipurpose_get_default_theme_options' ) ) {

    /**
     * Get default theme options.
     *
     * @since 1.0.0
     *
     * @return array Default theme options.
     */
    function arya_multipurpose_get_default_theme_options() {

        $defaults = array(
            'arya_multipurpose_select_site_layout' => 'fullwidth',

            'arya_multipurpose_header_enable_sticky_header' => false,

            'arya_multipurpose_blog_display_categories' => true,
            'arya_multipurpose_blog_display_author_date' => true,
            'arya_multipurpose_blog_display_excerpt' => true,
            'arya_multipurpose_blog_display_featured_image' => true,

            'arya_multipurpose_archive_display_categories' => true,
            'arya_multipurpose_archive_display_author_date' => true,
            'arya_multipurpose_archive_display_excerpt' => true,
            'arya_multipurpose_archive_display_featured_image' => true,

            'arya_multipurpose_search_display_categories' => true,
            'arya_multipurpose_search_display_author_date' => true,
            'arya_multipurpose_search_display_excerpt' => true,
            'arya_multipurpose_search_display_featured_image' => true,
            'arya_multipurpose_search_display_page_results' => true,

            'arya_multipurpose_post_single_display_categories' => true,
            'arya_multipurpose_post_single_display_tags' => true,
            'arya_multipurpose_post_single_display_author_date' => true,
            'arya_multipurpose_post_single_display_featured_image' => true,

            'arya_multipurpose_excerpt_length' => 40,

            'arya_multipurpose_global_sidebar_position' => 'right',

            'arya_multipurpose_footer_copyright_text' => esc_html__( 'Copyright &copy; 2019. All Rights Reserved.', 'arya-multipurpose' ),
            'arya_multipurpose_footer_display_to_top_btn' => true,
        );

        if( class_exists( 'Woocommerce' ) ) {

            $defaults['arya_multipurpose_woocommerce_sidebar_position'] = 'right';
        }

        return $defaults;
    }
}