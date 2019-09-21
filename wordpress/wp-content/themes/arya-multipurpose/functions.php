<?php
/**
 * Arya Multipurpose functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Arya_Multipurpose
 */

$current_theme = wp_get_theme( 'arya-multipurpose' );

define( 'ARYA_MULTIPURPOSE_VERSION', $current_theme->get( 'Version' ) );

if ( ! function_exists( 'arya_multipurpose_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function arya_multipurpose_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Arya Multipurpose, use a find and replace
		 * to change 'arya-multipurpose' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'arya-multipurpose', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'arya-multipurpose-thumbnail-one', 800, 450, true ); // Archive, Index, Search
		add_image_size( 'arya-multipurpose-thumbnail-two', 400, 200, true ); // Section Blog
		add_image_size( 'arya-multipurpose-thumbnail-three', 90, 70, true ); // Widget Recent Posts
		add_image_size( 'arya-multipurpose-thumbnail-four', 60, 60, true ); // Testimonial
		add_image_size( 'arya-multipurpose-thumbnail-five', 216, 248, true ); // Team
		add_image_size( 'arya-multipurpose-thumbnail-six', 192, 94, true ); // Partners
		

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'arya-multipurpose' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'arya_multipurpose_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'arya_multipurpose_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function arya_multipurpose_content_width() {

	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'arya_multipurpose_content_width', 640 );
}
add_action( 'after_setup_theme', 'arya_multipurpose_content_width', 0 );


/**
 * Enqueue scripts and styles.
 */
function arya_multipurpose_scripts() {

	wp_enqueue_style( 'arya-multipurpose-style', get_stylesheet_uri() );

	wp_enqueue_style( 'arya-multipurpose-fonts', arya_multipurpose_fonts_url(), array(), null );

	wp_enqueue_style( 'animate', get_template_directory_uri() . '/assets/css/animate.css' );

	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.css' );

	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.css' );

	wp_enqueue_style( 'owl-carousel', get_template_directory_uri() . '/assets/css/owl.carousel.css' );

	wp_enqueue_style( 'owl-theme-default', get_template_directory_uri() . '/assets/css/owl.theme.default.css' );

	wp_enqueue_style( 'themify-icons', get_template_directory_uri() . '/assets/css/themify-icons.css' );

	wp_enqueue_style( 'arya-multipurpose-main', get_template_directory_uri() . '/assets/css/main.css' );

	wp_enqueue_style( 'arya-multipurpose-responsive', get_template_directory_uri() . '/assets/css/responsive.css' );


	wp_enqueue_script( 'arya-multipurpose-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), ARYA_MULTIPURPOSE_VERSION, true );

	wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/assets/js/owl.carousel.js', array('jquery'), ARYA_MULTIPURPOSE_VERSION, true );

	wp_enqueue_script( 'waypoints', get_template_directory_uri() . '/assets/js/waypoints.js', array('jquery'), ARYA_MULTIPURPOSE_VERSION, true );

	wp_enqueue_script( 'jquery-stellar', get_template_directory_uri() . '/assets/js/jquery.stellar.js', array('jquery'), ARYA_MULTIPURPOSE_VERSION, true );

	wp_enqueue_script( 'jquery-counterup', get_template_directory_uri() . '/assets/js/jquery.counterup.js', array('jquery'), ARYA_MULTIPURPOSE_VERSION, true );

	wp_enqueue_script( 'popper', get_template_directory_uri() . '/assets/js/popper.js', array('jquery'), ARYA_MULTIPURPOSE_VERSION, true );

	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.js', array('jquery'), ARYA_MULTIPURPOSE_VERSION, true );

	wp_enqueue_script( 'arya-multipurpose-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array('jquery'), ARYA_MULTIPURPOSE_VERSION, true );

	wp_enqueue_script( 'arya-multipurpose-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), ARYA_MULTIPURPOSE_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'arya_multipurpose_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/theme-functions.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/helper-functions.php';


/**
 * Customizer additions.
 */
require get_template_directory() . '/customizer/customizer.php';

/**
 * Classes reponsibe for custom fields.
 */
require get_template_directory() . '/inc/custom-fields/single-sidebar.php';

/**
 * Load widgets and widget areas.
 */
require get_template_directory() . '/widgets/widgets-init.php';

/**
 * Load TGM Plugin Activation.
 */
require get_template_directory() . '/third-party/class-tgm-plugin-activation.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load Woocommerce compatibility file.
 */
if ( class_exists( 'Woocommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce/class-arya-multipurpose-woocommerce.php';
	require get_template_directory() . '/inc/woocommerce/woocommerce-template-functions.php';
}

