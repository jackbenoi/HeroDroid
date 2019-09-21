<?php

if( ! function_exists( 'arya_multipurpose_dynamic_style' ) ) {

	function arya_multipurpose_dynamic_style() {

		$fixed_header = arya_multipurpose_get_option( 'arya_multipurpose_header_enable_sticky_header' );

		$show_scroll_top_btn = arya_multipurpose_get_option( 'arya_multipurpose_footer_display_to_top_btn' );

		?>
		<style>
			<?php
			if( $fixed_header === false ) {
				?>
				.header-area,
				.everest-nav-container.everest-sticky {
					position: relative !important;
					background-color: #2196F3;
				}
				<?php
			}

			if( has_header_image() ) :
				?>
				.page-top-banner {
					background-image: url(<?php header_image(); ?>);
				}
				<?php
			endif;
			
			if( $show_scroll_top_btn === false ) {
				?>
				.scroll-top {
					display: none !important;
				}
				<?php
			}
			?>
		</style>
		<?php
	}
}
add_action( 'wp_head', 'arya_multipurpose_dynamic_style' );