<?php

/**
 * Function to get post thumbnail Alt text
 */
if( !function_exists( 'arya_multipurpose_thumbnail_alt_text' ) ) {

    function arya_multipurpose_thumbnail_alt_text( $post_id ) {

        $post_thumbnail_id = get_post_thumbnail_id( $post_id );

        $alt_text = '';

        if( !empty( $post_thumbnail_id ) ) {

            $alt_text = get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true );
        }

	    if( !empty( $alt_text ) ) {

	    	echo esc_attr( $alt_text );
	    } else {

	    	the_title_attribute();
	    }
    }
}


/**
 * Funtion To Get Sidebar Position
 */
if ( !function_exists( 'arya_multipurpose_sidebar_position' ) ) :

    /**
     * Return Position of Sidebar.
     *
     * @since 1.0.0
     * @return string Fonts URL.
     */
    function arya_multipurpose_sidebar_position() {

        $sidebar_position = '';

        if( class_exists( 'Woocommerce' ) ) {

            if( is_active_sidebar( 'arya-multipurpose-woocommerce-sidebar' ) && ( is_woocommerce() || is_cart() || is_checkout() || is_account_page() ) ) {

                $sidebar_position = arya_multipurpose_get_option( 'arya_multipurpose_woocommerce_sidebar_position' );
            } 

            if( ! ( is_woocommerce() || is_cart() || is_checkout() || is_account_page() ) && is_active_sidebar( 'arya-multipurpose-sidebar' ) ) {

                if( is_single() || is_page() ) {

                    $sidebar_position = arya_multipurpose_single_sidebar_position();
                } else {

                    $sidebar_position = arya_multipurpose_get_option( 'arya_multipurpose_global_sidebar_position' );
                }
            }

        } else {

            if( is_active_sidebar( 'arya-multipurpose-sidebar' ) ) {
                
                if( is_single() || is_page() ) {

                    $sidebar_position = arya_multipurpose_single_sidebar_position();
                } else {

                    $sidebar_position = arya_multipurpose_get_option( 'arya_multipurpose_global_sidebar_position' );
                }
            }            
        }
        

        return $sidebar_position;
    }
endif;



/*
 * Sidebar Position for single post and single page.
 */
if( ! function_exists( 'arya_multipurpose_single_sidebar_position' ) ) {

    function arya_multipurpose_single_sidebar_position() {

        $sidebar_position = get_post_meta( get_the_ID(), 'arya_multipurpose_sidebar_position', true );

        if( empty( $sidebar_position ) ) {

            $sidebar_position = 'right';
        }

        return $sidebar_position;
    }
}


/*
 * Hook - Plugin Recommendation
 */
if ( ! function_exists( 'arya_multipurpose_recommended_plugins' ) ) :
    /**
     * Recommend plugins.
     *
     * @since 1.0.0
     */
    function arya_multipurpose_recommended_plugins() {

        $plugins = array(
            array(
                'name'     => esc_html__( 'Everest Toolkit', 'arya-multipurpose' ),
                'slug'     => 'everest-toolkit',
                'required' => false,
            ),
            array(
                'name'     => esc_html__( 'Woocommerce', 'arya-multipurpose' ),
                'slug'     => 'woocommerce',
                'required' => false,
            ),
            array(
                'name'     => esc_html__( 'Elementor Page Builder', 'arya-multipurpose' ),
                'slug'     => 'elementor',
                'required' => false,
            ),
            array(
                'name'     => esc_html__( 'Contact Form by WPForms – Drag & Drop Form Builder for WordPress', 'arya-multipurpose' ),
                'slug'     => 'wpforms-lite',
                'required' => false,
            ),
        );

        tgmpa( $plugins );
    }

endif;
add_action( 'tgmpa_register', 'arya_multipurpose_recommended_plugins' );