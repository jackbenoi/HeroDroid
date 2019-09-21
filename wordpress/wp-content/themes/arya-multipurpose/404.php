<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Arya_Multipurpose
 */

get_header();
	?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php arya_multipurpose_inner_banner(); ?>
			
			<!-- Start blog-lists section -->
		    <section class="blog-lists-section section-gap-full ">
		    	
		        <div class="container">
		            <div class="row">
		            	<div class="col-md-12">
		            		<div class="page-not-found">
								<header class="page-header">
									<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'arya-multipurpose' ); ?></h1>
								</header><!-- .page-header -->

								<div class="page-content">
									<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'arya-multipurpose' ); ?></p>

									<?php get_search_form(); ?>

								</div><!-- .page-content -->
							</div>
						</div>
					</div>
				</div>
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

	<?php
get_footer();
