<?php
/**
 * Template Name: AM - Pagebuilder Template
 * Template Post Type: post, page
 */

get_header();
	?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<?php
			while ( have_posts() ) :

				the_post();

				the_content();

				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'arya-multipurpose' ),
					'after'  => '</div>',
				) );

			endwhile; // End of the loop.
        	?>
		</main><!-- .site-main -->
	</div><!-- #primary.content-area -->
	<?php
get_footer();