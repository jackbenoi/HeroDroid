<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
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
		                	<?php
		                	while ( have_posts() ) :
								the_post();

								get_template_part( 'template-parts/content', 'single' );

								arya_multipurpose_post_navigation();

								// If comments are open or we have at least one comment, load up the comment template.
								if ( comments_open() || get_comments_number() ) :
									comments_template();
								endif;

							endwhile; // End of the loop.
		                	?>
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
