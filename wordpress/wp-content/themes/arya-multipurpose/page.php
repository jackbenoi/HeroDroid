<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Arya_Multipurpose
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php arya_multipurpose_inner_banner(); ?>

			<!-- Start blog-lists section -->
		    <section class="blog-lists-section section-gap-full">
		        <div class="container">
		            <div class="row">
		            	<?php
		            	$sidebar_position = arya_multipurpose_sidebar_position();

		            	if( class_exists( 'Woocommerce' ) ) {

            				if( is_active_sidebar( 'arya-multipurpose-woocommerce-sidebar' ) && ( is_woocommerce() || is_cart() || is_checkout() || is_account_page() ) && $sidebar_position === 'left' ) {

            					arya_multipurpose_woocommerce_sidebar();
            				}

            				 if( ! ( is_woocommerce() || is_cart() || is_checkout() || is_account_page() ) && is_active_sidebar( 'arya-multipurpose-sidebar' ) && $sidebar_position === 'left' ) {

            				 	get_sidebar();
            				 }
            			} else {
            				if( is_active_sidebar( 'arya-multipurpose-sidebar' ) && $sidebar_position === 'left' ) {

            					get_sidebar();
            				}
            			}
		            	?>
		                <div class="<?php arya_multipurpose_main_container_class(); ?>">
		                	<?php
		                	while ( have_posts() ) :

								the_post();

								get_template_part( 'template-parts/content', 'page' );

								// If comments are open or we have at least one comment, load up the comment template.
								if ( comments_open() || get_comments_number() ) :
									comments_template();
								endif;

							endwhile; // End of the loop.
		                	?>
		                </div>
		                <?php 
		                if( class_exists( 'Woocommerce' ) ) {

            				if( is_active_sidebar( 'arya-multipurpose-woocommerce-sidebar' ) && ( is_woocommerce() || is_cart() || is_checkout() || is_account_page() ) && $sidebar_position === 'right' ) {

            					arya_multipurpose_woocommerce_sidebar();
            				}

            				 if( ! ( is_woocommerce() || is_cart() || is_checkout() || is_account_page() ) && is_active_sidebar( 'arya-multipurpose-sidebar' ) && $sidebar_position === 'right' ) {

            				 	get_sidebar();
            				 }
            			} else {
            				if( is_active_sidebar( 'arya-multipurpose-sidebar' ) && $sidebar_position === 'right' ) {

            					get_sidebar();
            				}
            			}
		                ?>
		            </div>
		        </div>
		    </section>
		    <!-- End blog-lists section -->
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
