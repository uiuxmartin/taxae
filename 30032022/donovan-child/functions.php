<?php
/**
 * Donovan functions and definitions
 *
 * @package Donovan
 */

/**
 * Donovan only works in WordPress 4.7 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}


if ( ! function_exists( 'donovan_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function donovan_setup() {

		// Make theme available for translation. Translations can be filed at https://translate.wordpress.org/projects/wp-themes/donovan
		load_theme_textdomain( 'donovan', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails on posts and pages.
		add_theme_support( 'post-thumbnails' );

		// Set detfault Post Thumbnail size.
		set_post_thumbnail_size( 1360, 765, true );

		// Register Navigation Menus.
		register_nav_menus( array(
			'primary' => esc_html__( 'Main Navigation', 'donovan' ),
			'social'  => esc_html__( 'Social Icons', 'donovan' ),
		) );

		// Switch default core markup for search form, comment form, and comments to output valid HTML5.
		add_theme_support( 'html5', array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'donovan_custom_background_args', array(
			'default-color' => 'cccccc',
		) ) );

		// Set up the WordPress core custom logo feature.
		add_theme_support( 'custom-logo', apply_filters( 'donovan_custom_logo_args', array(
			'height'      => 60,
			'width'       => 300,
			'flex-height' => true,
			'flex-width'  => true,
		) ) );

		// Set up the WordPress core custom header feature.
		add_theme_support( 'custom-header', apply_filters( 'donovan_custom_header_args', array(
			'header-text' => false,
			'width'       => 2560,
			'height'      => 500,
			'flex-width'  => true,
			'flex-height' => true,
		) ) );

		// Add extra theme styling to the visual editor.
		add_editor_style( array( 'assets/css/editor-style.css' ) );

		// Add Theme Support for Selective Refresh in Customizer.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for responsive embed blocks.
		add_theme_support( 'responsive-embeds' );
	}
endif;
add_action( 'after_setup_theme', 'donovan_setup' );


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function donovan_child_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'donovan_child_content_width', 910 );
}
add_action( 'after_setup_theme', 'donovan_child_content_width', 0 );


/**
 * Register widget areas and custom widgets.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function donovan_child_widgets_init() {

	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'donovan' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html_x( 'Sidebar will appear on posts and pages, except with the full width template.', 'widget area description', 'donovan' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

}
add_action( 'widgets_init', 'donovan_child_widgets_init' );

// Include Template Tags.
//require get_template_directory() . '/inc/template-tags.php';

/**
 * Enqueue scripts and styles.
 */
function donovan_child_scripts() {

	// Get Theme Version.
	$theme_version = wp_get_theme()->get( 'Version' );

	// Register and Enqueue Stylesheet.
	wp_enqueue_style( 'donovan-stylesheet', get_stylesheet_uri(), array(), $theme_version );

	// Register and enqueue navigation.min.js.
	if ( ( has_nav_menu( 'primary' ) || has_nav_menu( 'secondary' ) ) && ! donovan_is_amp() ) {
		wp_enqueue_script( 'donovan-navigation', get_theme_file_uri( '/assets/js/navigation.min.js' ), array( 'jquery' ), '20200822', true );
		$donovan_l10n = array(
			'expand'   => esc_html__( 'Expand child menu', 'donovan' ),
			'collapse' => esc_html__( 'Collapse child menu', 'donovan' ),
			'icon'     => donovan_get_svg( 'expand' ),
		);
		wp_localize_script( 'donovan-navigation', 'donovanScreenReaderText', $donovan_l10n );
	}

	// Enqueue svgxuse to support external SVG Sprites in Internet Explorer.
	if ( ! donovan_is_amp() ) {
		wp_enqueue_script( 'svgxuse', get_theme_file_uri( '/assets/js/svgxuse.min.js' ), array(), '1.2.6' );
	}

	// Register Comment Reply Script for Threaded Comments.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'donovan_child_scripts' );


/**
* Enqueue theme fonts.
*/
function donovan_child_theme_fonts() {
	$fonts_url = donovan_child_get_fonts_url();

	// Load Fonts if necessary.
	if ( $fonts_url ) {
		require_once get_theme_file_path( 'inc/wptt-webfont-loader.php' );
		wp_enqueue_style( 'donovan-theme-fonts', wptt_get_webfont_url( $fonts_url ), array(), '20201110' );
	}
}
add_action( 'wp_enqueue_scripts', 'donovan_child_theme_fonts', 1 );
add_action( 'enqueue_block_editor_assets', 'donovan_child_theme_fonts', 1 );


/**
 * Retrieve webfont URL to load fonts locally.
 */
function donovan_child_get_fonts_url() {
	$font_families = array(
		'Raleway:400,400italic,700,700italic',
		'Quicksand:400,400italic,700,700italic',
	);

	$query_args = array(
		'family'  => urlencode( implode( '|', $font_families ) ),
		'subset'  => urlencode( 'latin,latin-ext' ),
		'display' => urlencode( 'swap' ),
	);

	return apply_filters( 'donovan_child_get_fonts_url', add_query_arg( $query_args, 'https://fonts.googleapis.com/css' ) );
}


/**
 * Add custom sizes for featured images
 */
function donovan_child_add_image_sizes() {

	add_image_size( 'donovan-list-post', 600, 450, true );

}
add_action( 'after_setup_theme', 'donovan_child_add_image_sizes' );


/**
 * Make custom image sizes available in Gutenberg.
 */
function donovan_child_add_image_size_names( $sizes ) {
	return array_merge( $sizes, array(
		'post-thumbnail'    => esc_html__( 'Donovan Single Post', 'donovan' ),
		'donovan-list-post' => esc_html__( 'Donovan List Post', 'donovan' ),
	) );
}
add_filter( 'image_size_names_choose', 'donovan_child_add_image_size_names' );


/**
 * Add pingback url on single posts
 */
function donovan_child_pingback_url() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
	}
}
add_action( 'wp_head', 'donovan_child_pingback_url' );



/**
 * Webp
 */
//** *Enable upload for webp image files.*/
function webp_upload_mimes($existing_mimes) {
$existing_mimes['webp'] = 'image/webp';
return $existing_mimes;
}
add_filter('mime_types', 'webp_upload_mimes');

//Remove Tag word
//Remove Category word from Title
function prefix_category_title( $title ) {
    if ( is_category() ) {
        $title = single_cat_title( '', false );
    }
    return $title;
}
add_filter( 'get_the_archive_title', 'prefix_category_title' );

//Breadcrumb


function crunchify_gravatar_alt($crunchifyGravatar) {
	if (have_comments()) {
		$alt = get_comment_author();
	}
	else {
		$alt = get_the_author_meta('display_name');
	}
	$crunchifyGravatar = str_replace('alt=\'\'', 'alt=\'Avatar for ' . $alt . '\' title=\'Gravatar for ' . $alt . '\'', $crunchifyGravatar);
	return $crunchifyGravatar;
}
add_filter('get_avatar', 'crunchify_gravatar_alt');

//Chat Button
if ( ! function_exists( 'donovan_site_chatnow' ) ) :
	/**
	 * Displays the Chat in the header area
	 */
	function donovan_site_chatnow() {

		echo '<a href="javascript:$zopim.livechat.window.show();" class="btn chat-btn" rel="nofollow">Chat now</a>';
	}
endif;

//Remove Nofollow link on recent comments in widget area
function dofollow_comment_author_link() {
    $url    = get_comment_author_url();
    $author = get_comment_author();
 
    if ( empty( $url ) || ('http://' == $url))
        return $author;
    else
        $link = "<a href='$url' rel='external' class='url'>$author</a>";
        return $link;
}
//http://codex.wordpress.org/Function_Reference/add_action
add_action('get_comment_author_link', 'dofollow_comment_author_link');
/* End of Section1 */
