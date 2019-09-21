<?php
/**
 * Default loop columns on product archives.
 *
 * @return integer products per row.
 */
function arya_multipurpose_woocommerce_loop_columns() {
	$sidebar_position = arya_multipurpose_sidebar_position();

	if( $sidebar_position == 'none' || !is_active_sidebar( 'arya-multipurpose-woocommerce-sidebar' ) ) {
		return 4;
	} else {
		return 3;
	}
	
}
add_filter( 'loop_shop_columns', 'arya_multipurpose_woocommerce_loop_columns' );

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function arya_multipurpose_woocommerce_related_products_args( $args ) {

	$columns = 3;
	$sidebar_position = arya_multipurpose_sidebar_position();

	if( $sidebar_position == 'none' || !is_active_sidebar( 'arya-multipurpose-woocommerce-sidebar' ) ) {
		$columns = 4;
	} else {
		$columns = 3;
	}

	$defaults = array(
		'posts_per_page' => 3,
		'columns'        => $columns,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'arya_multipurpose_woocommerce_related_products_args' );

if ( ! function_exists( 'arya_multipurpose_woocommerce_product_columns_wrapper' ) ) {
	/**
	 * Product columns wrapper.
	 *
	 * @return  void
	 */
	function arya_multipurpose_woocommerce_product_columns_wrapper() {
		$columns = arya_multipurpose_woocommerce_loop_columns();
		echo '<div class="columns-' . absint( $columns ) . '">';
	}
}
add_action( 'woocommerce_before_shop_loop', 'arya_multipurpose_woocommerce_product_columns_wrapper', 40 );

if ( ! function_exists( 'arya_multipurpose_woocommerce_product_columns_wrapper_close' ) ) {
	/**
	 * Product columns wrapper close.
	 *
	 * @return  void
	 */
	function arya_multipurpose_woocommerce_product_columns_wrapper_close() {
		echo '</div>';
	}
}
add_action( 'woocommerce_after_shop_loop', 'arya_multipurpose_woocommerce_product_columns_wrapper_close', 40 );

/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );



if ( ! function_exists( 'arya_multipurpose_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function arya_multipurpose_woocommerce_wrapper_before() {
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

			            	if( $sidebar_position == 'left' && is_active_sidebar( 'arya-multipurpose-woocommerce-sidebar' ) ) {
			            		arya_multipurpose_woocommerce_sidebar();
			            	}
			            	?>
			                <div class="<?php arya_multipurpose_main_container_class(); ?>">
			                	<div class="woocommerce-container">
	                        	<?php
	}
}
add_action( 'woocommerce_before_main_content', 'arya_multipurpose_woocommerce_wrapper_before' );

if ( ! function_exists( 'arya_multipurpose_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	function arya_multipurpose_woocommerce_wrapper_after() {
								?>
								</div>
			                </div>
				            <?php
				            $sidebar_position = arya_multipurpose_sidebar_position();

			                if( $sidebar_position == 'right' && is_active_sidebar( 'arya-multipurpose-woocommerce-sidebar' ) ) {
			            		arya_multipurpose_woocommerce_sidebar();
			            	}
			                ?>
			            </div>
			        </div>
			    </section>
			    <!-- End blog-lists section -->
			</main><!-- #main -->
		</div><!-- #primary -->
		<?php
	}
}
add_action( 'woocommerce_after_main_content', 'arya_multipurpose_woocommerce_wrapper_after' );

/**
 * Sample implementation of the WooCommerce Mini Cart.
 *
 * You can add the WooCommerce Mini Cart to header.php like so ...
 *
	<?php
		if ( function_exists( 'arya_multipurpose_woocommerce_header_cart' ) ) {
			arya_multipurpose_woocommerce_header_cart();
		}
	?>
 */

if ( ! function_exists( 'arya_multipurpose_woocommerce_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function arya_multipurpose_woocommerce_cart_link_fragment( $fragments ) {
		ob_start();
		arya_multipurpose_woocommerce_cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'arya_multipurpose_woocommerce_cart_link_fragment' );

if ( ! function_exists( 'arya_multipurpose_woocommerce_cart_link' ) ) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function arya_multipurpose_woocommerce_cart_link() {
		?>
		<a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'arya-multipurpose' ); ?>">
			<?php
			$item_count_text = sprintf(
				/* translators: number of items in the mini cart. */
				_n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'arya-multipurpose' ),
				WC()->cart->get_cart_contents_count()
			);
			?>
			<span class="amount"><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></span> <span class="count"><?php echo esc_html( $item_count_text ); ?></span>
		</a>
		<?php
	}
}

if ( ! function_exists( 'arya_multipurpose_woocommerce_header_cart' ) ) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function arya_multipurpose_woocommerce_header_cart() {
		if ( is_cart() ) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
		?>
		<ul id="site-header-cart" class="site-header-cart">
			<li class="<?php echo esc_attr( $class ); ?>">
				<?php arya_multipurpose_woocommerce_cart_link(); ?>
			</li>
			<li>
				<?php
				$instance = array(
					'title' => '',
				);

				the_widget( 'WC_Widget_Cart', $instance );
				?>
			</li>
		</ul>
		<?php
	}
}