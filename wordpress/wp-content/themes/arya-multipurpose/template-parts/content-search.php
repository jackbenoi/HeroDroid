<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Arya_Multipurpose
 */
$show_category = arya_multipurpose_get_option( 'arya_multipurpose_search_display_categories' );
$show_author_date = arya_multipurpose_get_option( 'arya_multipurpose_search_display_author_date' );
$show_excerpt = arya_multipurpose_get_option( 'arya_multipurpose_search_display_excerpt' );
$show_featured_image = arya_multipurpose_get_option( 'arya_multipurpose_search_display_featured_image' );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="single-blog-post">
		<?php 
		if( $show_featured_image === true ) {
			arya_multipurpose_post_thumbnail();
		}
		?>
	    <div class="post-details">
	    	<?php 
	    	if( get_post_type() === 'post' && $show_category === true ) {
	    		arya_multipurpose_categories_meta(); 
	    	}
	    	?>
	        <a href="<?php the_permalink(); ?>">
	            <h1><?php the_title(); ?></h1>
	        </a>
	        <?php 
	        if( $show_excerpt === true ) {
	        	the_excerpt(); 
	        }
	        ?>
	        <?php
            if( get_post_type() == 'post' && $show_author_date === true ) {
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
	    </div>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
