<?php
/**
 * The template for displaying archive pages
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

		            	if( $sidebar_position == 'left' && is_active_sidebar( 'arya-multipurpose-sidebar' ) ) {
		            		get_sidebar();
		            	}
		            	?>
		                <div class="<?php arya_multipurpose_main_container_class(); ?>">
		                    <div class="blog-lists">
		                    	<?php
		                    	if( have_posts() ) :

		                    		/* Start the Loop */
									while ( have_posts() ) :
										
										the_post();

										/*
										 * Include the Post-Type-specific template for the content.
										 * If you want to override this in a child theme, then include a file
										 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
										 */
										get_template_part( 'template-parts/content', get_post_type() );

									endwhile;

									arya_multipurpose_pagination();

								else :

									get_template_part( 'template-parts/content', 'none' );

								endif;

		                    	?>
		                    </div>
		                </div>
		                <?php 
		                if( $sidebar_position == 'right' && is_active_sidebar( 'arya-multipurpose-sidebar' ) ) {
		            		get_sidebar();
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
