<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Arya_Multipurpose
 */

if ( ! is_active_sidebar( 'arya-multipurpose-sidebar' ) ) {
	return;
}
?>
<div class="col-lg-4">
	<div id="secondary" class="widget-area sidebar-wrap">
		<?php dynamic_sidebar( 'arya-multipurpose-sidebar' ); ?>
	</div><!-- #secondary -->
</div>