<?php

/**
 * Funtion To Get Google Fonts
 */
if ( !function_exists( 'arya_multipurpose_fonts_url' ) ) {

    /**
     * Return Font's URL.
     *
     * @since 1.0.0
     * @return string Fonts URL.
     */
    function arya_multipurpose_fonts_url() {

        $fonts_url = '';
        $fonts     = array();
        $subsets   = 'latin,latin-ext';

        /* translators: If there are characters in your language that are not supported by Barlow, translate this to 'off'. Do not translate into your own language. */
        if ( 'off' !== _x( 'on', 'Sarabun: on or off', 'arya-multipurpose' ) ) {
            $fonts[] = 'Sarabun:300,400,500,600,700';
        }

        if ( $fonts ) {
            $fonts_url = add_query_arg( array(
                'family' => urlencode( implode( '|', $fonts ) ),
                'subset' => urlencode( $subsets ),
            ), '//fonts.googleapis.com/css' );
        }

        return $fonts_url;
    }
}


/**
 * Fallback For Main Menu
 */
if ( !function_exists( 'arya_multipurpose_navigation_fallback' ) ) {
    /**
     * Return unordered list.
     *
     * @since 1.0.0
     * @return unordered list.
     */
    function arya_multipurpose_navigation_fallback() {
        ?>
        <ul class="primary-menu">
            <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'arya-multipurpose' ); ?></a></li>
            <li><a href="<?php echo esc_url( admin_url( 'nav-menus.php' ) ); ?>"><?php esc_html_e( 'Add Menu Items', 'arya-multipurpose' ); ?></a></li>
        </ul>
        <?php
    }
}


/**
 * Hook for Search Form
 */
if( !function_exists( 'arya_multipurpose_search_form' ) ) {
    /**
     * Return custom search HTML template.
     *
     * @since 1.0.0
     * @return HTML markup.
     */
    function arya_multipurpose_search_form() {

        $form = '<form role="search" method="get" id="search-form" class="relative" action="' . esc_url( home_url( '/' ) ) . '"><input type="search" name="s" placeholder="' . esc_attr__( 'Search', 'arya-multipurpose' ) . '" value"' . esc_attr( get_search_query() ) . '"><button type="submit" id="submit"><i class="ti-search"></i></button></form>';

        return $form;
    }
}
add_filter( 'get_search_form', 'arya_multipurpose_search_form' );


/**
 * Filters For Excerpt Length
 */
if( !function_exists( 'arya_multipurpose_excerpt_length' ) ) :
    /*
     * Excerpt More
     */
    function arya_multipurpose_excerpt_length( $length ) {

        if( is_admin() ) {

            return $length;
        }

        $excerpt_length = arya_multipurpose_get_option( 'arya_multipurpose_excerpt_length' );

        if ( absint( $excerpt_length ) > 0 ) {
            
            $excerpt_length = absint( $excerpt_length );
        }

        return $excerpt_length;
    }
endif;
add_filter( 'excerpt_length', 'arya_multipurpose_excerpt_length' );


/**
 * Filter For Excerpt More
 */
if( !function_exists( 'arya_multipurpose_excerpt_more' ) ) :

    function arya_multipurpose_excerpt_more( $more ) {

        if ( is_admin() ) {

            return $more;
        }

        return '...';
    }
endif;
add_filter( 'excerpt_more', 'arya_multipurpose_excerpt_more' );
