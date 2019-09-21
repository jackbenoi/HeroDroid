<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Arya_Multipurpose
 */

if( ! function_exists( 'arya_multipurpose_categories_meta' ) ) :
	/*
	 * Prints HTML with meta information for post categories.
	 */
	function arya_multipurpose_categories_meta() {

		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {

			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list();

			if ( $categories_list ) {

				echo wp_kses_post( $categories_list );
			}
		}
	}
endif;


if( ! function_exists( 'arya_multipurpose_tags_meta' ) ) :
	/*
	 * Prints HTML with meta information for post categories.
	 */
	function arya_multipurpose_tags_meta() {

		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list();

			if ( $tags_list ) {
				?>
				<div class="entry-tags">
					<div class="post-tags">
						<?php echo wp_kses_post( $tags_list ); ?>
					</div>
				</div>
				<?php
			}
		}
	}
endif;

if ( ! function_exists( 'arya_multipurpose_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function arya_multipurpose_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		$display_image_overlay = arya_multipurpose_get_option( 'arya_multipurpose_display_image_overlay' );

		if ( is_singular() ) :
			?>

			<div class="post-thumb relative">
				<?php if( $display_image_overlay === true ) { 
					?>
					<div class="overlay overlay-bg"></div>
					<?php
				}
				?>
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

			<?php 
		else : 
			?>
			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<div class="post-thumb relative">
			        <?php if( $display_image_overlay === true ) { 
						?>
						<div class="overlay overlay-bg"></div>
						<?php
					}
					?>
			        <?php
					the_post_thumbnail( 'arya-multipurpose-thumbnail-one', array( 
						'class' => 'img-fluid',
						'alt' => the_title_attribute( array(
							'echo' => false,
						) ),
					) );
					?>
			    </div>
			</a>
			<?php
		endif; // End is_singular().
	}
endif;