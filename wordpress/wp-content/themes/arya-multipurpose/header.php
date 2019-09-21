<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Arya_Multipurpose
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php
if( class_exists( 'wp_body_open' ) ) { 
    wp_body_open(); 
}
?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'arya-multipurpose' ); ?></a>

    <?php
    $enable_preloader = arya_multipurpose_get_option( 'arya_multipurpose_enable_preloader' );
    if( $enable_preloader == true ) {
        ?>
    	<!-- Start Preloader -->
        <div id="loader-wrapper">
            <div id="loader"></div>
            <div class="loader-section section-left"></div>
            <div class="loader-section section-right"></div>
        </div>
        <!-- End Preloader -->
        <?php
    }
    ?>

    <!-- Start header section -->
    <header class="header-area" id="header-area">
        <div class="everest-nav-container breakpoint-off">
            <div class="container">
                <div class="row">
                    <!-- everest Menu -->
                    <nav class="everest-navbar justify-content-between" id="everestNav">
						<!-- Start Site Branding -->
                        <div class="site-branding">
	                        <?php
	                        if( has_custom_logo() ) :
	                        	the_custom_logo();
	                        else :
	                        	?>
	                        	<span class="site-title">
	                        		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
	                        	</span>
	                        	<?php
	                        	$arya_multipurpose_description = get_bloginfo( 'description', 'display' );
								if ( $arya_multipurpose_description || is_customize_preview() ) :
									?>
									<p class="site-description"><?php echo $arya_multipurpose_description; /* WPCS: xss ok. */ ?></p>
									<?php 
								endif; 
	                        endif;
	                        ?>
                        </div>
						<!-- End Site Branding -->

                        <!-- Navbar Toggler -->
                        <div class="everest-navbar-toggler">
                            <span class="navbarToggler">
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                        </div>

                        <!-- Menu -->
                        <div class="everest-menu">
                            <!-- close btn -->
                            <div class="everestcloseIcon">
                                <div class="cross-wrap">
                                    <span class="top"></span>
                                    <span class="bottom"></span>
                                </div>
                            </div>
                            <!-- Nav Start -->
                            <div class="everestnav">
                            	<?php
	                        	$menu_args = array(
						 			'theme_location' => 'menu-1',
						 			'container' => '',
						 			'menu_class' => '',
									'menu_id' => 'nav',
									'fallback_cb' => 'arya_multipurpose_navigation_fallback',
						 		);
								wp_nav_menu( $menu_args );
	                        	?>
                            </div>
                            <!-- Nav End -->
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- End header section -->
