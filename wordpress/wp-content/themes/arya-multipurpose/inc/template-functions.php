<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Arya_Multipurpose
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function arya_multipurpose_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	$sidebar_position = arya_multipurpose_sidebar_position();
	if ( ! is_active_sidebar( 'arya-multipurpose-sidebar' ) || $sidebar_position === 'none' ) {
		$classes[] = 'no-sidebar';
	}

	// Adds a class of boxed when site layout is boxed present.
	$site_layout = arya_multipurpose_get_option( 'arya_multipurpose_select_site_layout' );
	if( $site_layout === 'boxed' ) {
		$classes[] = 'boxed';
	}

	return $classes;
}
add_filter( 'body_class', 'arya_multipurpose_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function arya_multipurpose_pingback_header() {

	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'arya_multipurpose_pingback_header' );


if( ! function_exists( 'arya_multipurpose_main_container_class' ) ) {

	function arya_multipurpose_main_container_class() {

		$class = '';

		$sidebar_position = arya_multipurpose_sidebar_position();

		if( $sidebar_position == 'none' || $sidebar_position == '' ) {

			$class = 'col-lg-12';
		} else {

			$class = 'col-lg-8';
		}

		echo esc_attr( $class );
	}
}


/**
 * Inner banner template.
 */
if( ! function_exists( 'arya_multipurpose_inner_banner' ) ) {

	function arya_multipurpose_inner_banner() {
		?>
		<!-- Start page-top-banner section -->
	    <section class="page-top-banner section-gap-full relative" data-stellar-background-ratio="0.5">
	        <div class="overlay overlay-bg"></div>
	        <div class="container">
	            <div class="row section-gap-half">
	                <div class="col-lg-12 text-center">
	                	<?php
	                	if( is_singular() ) {

	                		while( have_posts() ) :

	                			the_post();
	                			?>
	                			<h1 class="page-title"><?php the_title(); ?></h1>
	                			<?php
	                		endwhile;
	                	}

	                	if( is_search() ) {
	                		?>
	                		<h1 class="page-title">
	                			<?php
								/* translators: %s: search query. */
								printf( esc_html__( 'Search Results for: %s', 'arya-multipurpose' ), '<span>' . get_search_query() . '</span>' );
								?>
	                		</h1>
	                		<?php
	                	}

	                	if( is_archive() ) {
	                		the_archive_title( '<h1 class="page-title">', '</h1>' );
	                	}

	                	if( is_home() ) {
	                		?>
	                		<h1 class="page-title"><?php esc_html_e( 'Recent Blog Posts', 'arya-multipurpose' ); ?></h1>
	                		<?php
	                	}

	                	if( is_404() ) {
	                		?>
	                		<h1 class="page-title"><?php echo esc_html_e( '404', 'arya-multipurpose' ); ?></h1>
	                		<?php
	                	}  
	                	?>
	                </div>
	            </div>
	        </div>
	    </section>
	    <!-- End about-top-banner section -->
		<?php
	}
}

/**
 * Function that defines posts pagination.
 */
if( ! function_exists( 'arya_multipurpose_pagination' ) ) {

	function arya_multipurpose_pagination() {
		
        the_posts_pagination( array(
    		'mid_size' => 0,
			'prev_text' => '<i class="ti ti-angle-left"></i>',
			'next_text' => '<i class="ti ti-angle-right"></i>',
    	) );
	}
}


/**
 * Function that defines post navigation.
 */
if( ! function_exists( 'arya_multipurpose_post_navigation' ) ) {

	function arya_multipurpose_post_navigation() {
		
		$next_post = get_next_post();

	    $previous_post = get_previous_post();

	    $navigation_args = array();

	    if( !empty( $next_post ) ) {
	    	$navigation_args['next_text'] = '<span class="next-nav" aria-hidden="true">' . esc_html__( 'Next', 'arya-multipurpose' ) . '</span><span class="next-post-title">' . esc_html( get_the_title( $next_post->ID ) ) . '</span>';
	    }

	    if( !empty( $previous_post ) ) {
	    	$navigation_args['prev_text'] = '<span class="prev-nav" aria-hidden="true">' . esc_html__( 'Prev', 'arya-multipurpose' ) . '</span><span class="prev-post-title">' . esc_html( get_the_title( $previous_post->ID ) ) . '</span>';
	    }

	    the_post_navigation( $navigation_args );
	}
}

/**
 * Copyright text template.
 */
if( ! function_exists( 'arya_multipurpose_copyright_text' ) ) {

	function arya_multipurpose_copyright_text() {

		$copyright_text = arya_multipurpose_get_option( 'arya_multipurpose_footer_copyright_text' );
        if( !empty( $copyright_text ) ) {
            ?>
            <div class="col-md-6">
                <div class="copyright-container text-left">
                    <p><?php echo esc_html( $copyright_text ); ?></p>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="col-md-6">
                <div class="copyright-container text-left">
                    <p>
                    	<?php
	                    /* translators: %s: CMS name, i.e. WordPress. */
	                    printf( esc_html__( 'Proudly powered by %s.', 'arya-multipurpose' ), '<a href="https://wordpress.org/">WordPress</a>' );
	                    ?>
	                </p>
                </div>
            </div>
            <?php
        }
	}
}

/**
 * Credit text template.
 */
if( ! function_exists( 'arya_multipurpose_credit_text' ) ) {

	function arya_multipurpose_credit_text() {
        ?>
        <div class="col-md-6">
            <div class="credit-container text-right">
                <p>
                	<?php
                    /* translators: %1$s: theme name, %2$s: theme author */
                    printf( esc_html__( '%1$s by %2$s.', 'arya-multipurpose' ), get_bloginfo( 'name' ), '<a href="https://everestthemes.com">Everestthemes</a>' );
                    ?>
                </p>
            </div>
        </div>
        <?php
	}
}

/**
 * Woocommerce Sidebar
 */
if( ! function_exists( 'arya_multipurpose_woocommerce_sidebar' ) ) {

	function arya_multipurpose_woocommerce_sidebar() {
		if( is_active_sidebar( 'arya-multipurpose-woocommerce-sidebar' ) )
		?>
		<div class="col-lg-4">
			<div id="secondary" class="widget-area sidebar-wrap">
				<?php dynamic_sidebar( 'arya-multipurpose-woocommerce-sidebar' ); ?>
			</div><!-- #secondary -->
		</div>
		<?php
	}
}