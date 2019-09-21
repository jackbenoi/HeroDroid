<?php
/**
 * Template part for displaying page content in post.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Arya_Multipurpose
 */
$show_category = arya_multipurpose_get_option( 'arya_multipurpose_post_single_display_categories' );
$show_author_date = arya_multipurpose_get_option( 'arya_multipurpose_post_single_display_author_date' );
$show_tags = arya_multipurpose_get_option( 'arya_multipurpose_post_single_display_tags' );
$show_featured_image = arya_multipurpose_get_option( 'arya_multipurpose_post_single_display_featured_image' );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="blog-details">
	    <?php 
		if( $show_featured_image === true ) {
			arya_multipurpose_post_thumbnail(); 	
		}
		?>
	    <div class="post-details">
	        <?php 
	    	if( $show_category === true ) {
	    		arya_multipurpose_categories_meta(); 
	    	}
	    	?>
			
	        <div class="entry-header">
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			</div><!-- .entry-header -->
			<?php
            if( $show_author_date === true ) {
	            ?>
				<div class="user-details d-flex align-items-center">
		            <div class="user-img">
		            	<?php echo get_avatar( get_the_author_meta( 'ID' ), 300 ); ?>
		            </div>
		            
		            <div class="details">
		                <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
		                    <h4><?php echo esc_html( get_the_author() ); ?></h4>
		                </a>
		                <p><?php echo esc_html( get_the_date() ); ?></p>
		            </div>
		        </div>
		        <?php
		    }
		    ?>
			
			<div class="entry-content">
				<?php
				the_content();

				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'arya-multipurpose' ),
					'after'  => '</div>',
				) );

				if( $show_tags === true ) {
					arya_multipurpose_tags_meta();
				}

				if ( get_edit_post_link() ) :

					edit_post_link(
						sprintf(
							wp_kses(
								/* translators: %s: Name of current post. Only visible to screen readers */
								__( 'Edit <span class="screen-reader-text">%s</span>', 'arya-multipurpose' ),
								array(
									'span' => array(
										'class' => array(),
									),
								)
							),
							get_the_title()
						),
						'<span class="edit-link">',
						'</span>'
					);
				endif;
				?>
			</div><!-- .entry-content -->	
	    </div>
	</div>
</article>