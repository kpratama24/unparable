<?php
/**
 * Stone functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * @link https://codex.wordpress.org/Plugin_API
 *
 * @package Stone
 * @since Stone 1.0
 */

/**
 * ------------------------------------------------------------------------------------------------- 
 * Set up the content width value based on the theme's design.
 *
 * @see stone_content_width()
 *
 * @since Stone 1.0
 * -------------------------------------------------------------------------------------------------
 */

if ( ! isset( $content_width ) ) {
	$content_width = 1024;
}

/**
 * ------------------------------------------------------------------------------------------------- 
 * stone only works in WordPress 3.6 or later.
 * -------------------------------------------------------------------------------------------------
 */

if ( version_compare( $GLOBALS['wp_version'], '3.6', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}

/**
 * ------------------------------------------------------------------------------------------------- 
 * Set up one language for admin and the other for the theme
 * -------------------------------------------------------------------------------------------------
 */
/*
function stone_set_my_locale($locale) {
    
    if ( is_admin() ) : return 'en_US';
	else : return 'nl'; 
	endif;
	
    return $locale;
}
add_filter( 'locale', 'stone_set_my_locale' );

/**
 * ------------------------------------------------------------------------------------------------- 
 * Stone setup.
 *
 * Set up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support post thumbnails.
 *
 * @since Stone 1.0
 * -------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'stone_setup' ) ) :
	
	function stone_setup() {
		// Make stone available for translation.
		// Translations can be added to the /languages/ directory.
		// If you're building a theme based on stone, find and
		// replace 'stone' to the name of your theme in all
		// template files.
		load_theme_textdomain( 'stone', get_template_directory() . '/languages' );

		// This theme styles the visual editor to resemble the theme style.
		add_editor_style( array( 'css/editor-style.css', stone_opensans_url(), stone_montserrat_url(), 'genericons/genericons.css' ) );

		// Add RSS feed links to <head> for posts and comments.
		add_theme_support( 'automatic-feed-links' );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus( array(
			'main-navigation'   => __( 'Top main menu', 'stone' ),
			'footer-navigation'   => __( 'Footer menu', 'stone' ),
		) );

		// Enable support for Post Thumbnails.
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'stone-thumb-width', 300, 300, false );
		add_image_size( 'stone-medium-width', 700, 700, false );

		// Enable support for custom logo.
		add_theme_support( 'custom-logo', array(
			'height'      => 300,
			'width'       => 150,
			'flex-height' => true,
		) );

		// Switch default core markup for search form, comment form, and comments
	 	// to output valid HTML5.
		add_theme_support( 'html5', array(
			'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
		) );

		// Enable support for Post Formats.
		add_theme_support( 'post-formats', array(
			'audio', 'chat', 'gallery','image', 'link', 'quote', 'status', 'video', 
		) );
		
		// Theme support for title-tag
		add_theme_support( 'title-tag' );

		// This theme allows users to set a custom background.
		add_theme_support( 'custom-background', array( 'default-color' => 'ffffff', ) );

		// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
		register_default_headers( array(
			'stones' => array(
				'url' => '%s/images/headers/stones.jpg',
				'thumbnail_url' => '%s/images/headers/stones-thumbnail.jpg',
				/* translators: header image description */
				'description' => __( 'Stones', 'stone' )
			)	
		) );

	}

endif; // stone_setup
add_action( 'after_setup_theme', 'stone_setup' );

/**
 * -------------------------------------------------------------------------------------------------
 * Other theme settings
 *
 * @since Stone 1.0
 * -------------------------------------------------------------------------------------------------
 */

// Wrap the read more link in a div
function stone_wrap_more_link( $more_link ) {
	return '<div>' . $more_link . '</div>';
}
add_filter( 'the_content_more_link', 'stone_wrap_more_link', 10, 1);

// Remove inline styles from the gallery shortcode is used
function stone_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
add_filter( 'gallery_style', 'stone_remove_gallery_css' );

// Remove paragraph tags from around images
function stone_filter_ptags_on_images($content) {
	return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}
add_filter( 'the_content', 'stone_filter_ptags_on_images' );
add_filter( 'acf_the_content', 'stone_filter_ptags_on_images' );

// Remove empty p tags
function stone_remove_empty_p( $content ){
	// clean up p tags around block elements
	$content = preg_replace( array(
		'#<p>\s*<(div|aside|section|article|header|footer)#',
		'#</(div|aside|section|article|header|footer)>\s*</p>#',
		'#</(div|aside|section|article|header|footer)>\s*<br ?/?>#',
		'#<(div|aside|section|article|header|footer)(.*?)>\s*</p>#',
		'#<p>\s*</(div|aside|section|article|header|footer)#',
	), array(
		'<$1',
		'</$1>',
		'</$1>',
		'<$1$2>',
		'</$1',
	), $content );
	return preg_replace('#<p>(\s|&nbsp;)*+(<br\s*/*>)*(\s|&nbsp;)*</p>#i', '', $content);
}
add_filter( 'the_content', 'stone_remove_empty_p', 20, 1 );

// Add responsive container to video embeds, but not Twitter embeds
function stone_embed_html( $html ) {
	if (( stripos($html, 'youtube.com') !== FALSE ) && ( stripos($html, 'iframe') !== FALSE )) {
		return '<div class="video-container">' . $html . '</div>';
	} else {
    	return $html;
   }   
}
add_filter( 'embed_oembed_html', 'stone_embed_html', 10, 3 );

// Add theme support for Jetpack Responsive Videos
function stone_jetpack_responsive_videos_setup() {
    add_theme_support( 'jetpack-responsive-videos' );
}
add_action( 'after_setup_theme', 'stone_jetpack_responsive_videos_setup' );

/**
 * ------------------------------------------------------------------------------------------------- 
 * Register stone widget areas.
 *
 * @since Stone 1.0
 * -------------------------------------------------------------------------------------------------
 */

function stone_widgets_init() {

	register_sidebar( array(
		'name'          => __( 'Primary Footer Widget Area', 'stone' ),
		'id'            => 'footer-primary',
		'description'   => __( 'Appears in the footer section of the site. On wide viewports widgets will appear in rows of three.', 'stone' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Secondary Footer Widget Area', 'stone' ),
		'id'            => 'footer-secondary',
		'description'   => __( 'Appears in the footer section of the site. On wide viewports widgets will appear in rows of two, with the first widget in a row taking up two-thirds of the available width.', 'stone' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'stone_widgets_init' );

/**
 * ------------------------------------------------------------------------------------------------- 
 * Register Google fonts for stone: Open Sans + Montserrat
 *
 * @since Stone 1.0
 *
 * @return string
 * -------------------------------------------------------------------------------------------------
 */

function stone_opensans_url() {
	$opensans_url = '';

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Open Sans, translate this to 'off'. Do not translate into your own language.
	 */

	if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'stone' ) ) {
		$query_args = array(
			'family' => urlencode( 'Open Sans:400,600,800,300italic,600italic' ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$opensans_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
	}

	return $opensans_url;
}

function stone_montserrat_url() {
	$montserrat_url = '';

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Montserrat, translate this to 'off'. Do not translate into your own language.
	 */

	if ( 'off' !== _x( 'on', 'Montserrat font: on or off', 'stone' ) ) {
		$query_args = array(
			'family' => urlencode( 'Montserrat:700' ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$montserrat_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
	}

	return $montserrat_url;
}

/**
 * ------------------------------------------------------------------------------------------------- 
 * Enqueue styles for the front end.
 *
 * @since Stone 1.0
 * -------------------------------------------------------------------------------------------------
 */

function stone_styles() {

	// Load the main stylesheet.
	wp_enqueue_style( 'stone-style', get_stylesheet_uri() );

	// Add Open Sans font, used in the main stylesheet.
	wp_enqueue_style( 'stone-opensans', stone_opensans_url(), array(), null );

	// Add Montserrat font, used in the main stylesheet.
	wp_enqueue_style( 'stone-montserrat', stone_montserrat_url(), array(), null );

	// Add Genericons font, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), null );


	/*
	// For RTL languages you need to uncomment this line
	wp_enqueue_style( 'rtl', get_template_directory_uri() . '/rtl.css', array(), null );
	*/
}

add_action( 'wp_enqueue_scripts', 'stone_styles' );

/**
 * ------------------------------------------------------------------------------------------------- 
 * JavaScript Detection.
 * Replace 'no-js' class on root <html> element with 'js' when JavaScript is detected.
 *
 * @since Stone 1.0
 * -------------------------------------------------------------------------------------------------
 */

function stone_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'stone_javascript_detection', 0 );


/**
 * ------------------------------------------------------------------------------------------------- 
 * Enqueue scripts for the front end.
 *
 * @since Stone 1.0
 * -------------------------------------------------------------------------------------------------
 */

function stone_scripts() {

	// Load JavaScript helpers for IE
    wp_enqueue_script( 'html5Shiv', get_template_directory_uri() . '/js/html5shiv.min.js', '', '', true );
    wp_script_add_data( 'html5Shiv', 'conditional', 'lt IE 9' );
    wp_enqueue_script( 'respondJS', get_template_directory_uri() . '/js/respond.min.js', '', '', true );
    wp_script_add_data( 'respondJS', 'conditional', 'lt IE 9' );

	// Enqueue the comment-reply script
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Load theme functions
	wp_enqueue_script( 'stone-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20150812', true );

}

add_action( 'wp_enqueue_scripts', 'stone_scripts' );
    
/**
 * ------------------------------------------------------------------------------------------------- 
 * Enqueue Google fonts style to admin screen for custom header display.
 *
 * @since Stone 1.0
 * -------------------------------------------------------------------------------------------------
 */

function stone_admin_fonts() {
	wp_enqueue_style( 'stone-opensans', stone_opensans_url(), array(), null );
	wp_enqueue_style( 'stone-montserrat', stone_montserrat_url(), array(), null );
}

add_action( 'admin_print_scripts-appearance_page_custom-header', 'stone_admin_fonts' );

/**
 * ------------------------------------------------------------------------------------------------- 
 * Create a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since Stone 1.0
 *
 * @global int $paged WordPress archive pagination page count.
 * @global int $page  WordPress paginated post page count.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 * -------------------------------------------------------------------------------------------------
 */

function stone_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name', 'display' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	// Add a page number if necessary.
	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'stone' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'stone_wp_title', 10, 2 );

/**
 * ------------------------------------------------------------------------------------------------- 
 * Extend the default WordPress body classes.
 *
 * Adds body classes to denote:
 * 1. Single or multiple authors.
 * 2. Presence of header image except in Multisite signup and activate pages.
 * 3. Index views.
 * 4. Full-width content layout.
 * 5. Presence of footer widgets.
 * 6. Single views.
 * 7. Featured content layout.
 *
 * @since Stone 1.0
 *
 * @param array $classes A list of existing body class values.
 * @return array The filtered body class list.
 * -------------------------------------------------------------------------------------------------
 */

function stone_body_classes( $classes ) {
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	if ( get_header_image() ) {
		$classes[] = 'header-image';
	} elseif ( ! in_array( $GLOBALS['pagenow'], array( 'wp-activate.php', 'wp-signup.php' ) ) ) {
		$classes[] = 'masthead-fixed';
	}

	if ( is_archive() || is_search() || is_home() ) {
		$classes[] = 'list-view';
	}

	if ( is_singular() && ! is_front_page() ) {
		$classes[] = 'singular';
	}

	if ( is_front_page() ) {
		$classes[] = 'front-page';
	}

	return $classes;
}
add_filter( 'body_class', 'stone_body_classes' );

/**
 * ------------------------------------------------------------------------------------------------- 
 * Extend the default WordPress post classes.
 *
 * Adds a post class to denote:
 * Non-password protected page with a post thumbnail.
 *
 * @since Stone 1.0
 *
 * @param array $classes A list of existing post class values.
 * @return array The filtered post class list.
 * -------------------------------------------------------------------------------------------------
 */

function stone_post_classes( $classes ) {

	/* Add a class to indicate if a post has a featured image */
	if ( !post_password_required() && !is_attachment() && has_post_thumbnail() ) {
		$classes[] = 'has-post-thumbnail';
	} else {
		$classes[] = 'no-post-thumbnail';
	}

	/* Add a class to indicate if a post has a featured image when the post is a jetpack-portfolio one */
	if ( ( is_page() && ( 'jetpack-portfolio' == get_post_type(get_the_ID()) ) ) || 
		( is_singular() && ( 'jetpack-portfolio' == get_post_type(get_the_ID()) ) ) ) {
		$classes[] = 'has-post-thumbnail';
	}

	/*
	Add a class to create a difference between a post excerpt on an index page
	and a full post on a single page.
	*/
	if ( is_home() || is_front_page() || is_archive() ) {
		$classes[] = 'post-excerpt';
	} else {
		$classes[] = 'post-single';
	}

	/* Add a class to indicate if a post is a post-format */
	$format = get_post_format();
	$formats = array( 'audio', 'chat', 'gallery','image', 'link', 'quote', 'status', 'video' );
	if ( in_array($format, $formats) ) {
		$classes[] = 'is-post-format';
	}
	
	return $classes;
}
add_filter( 'post_class', 'stone_post_classes' );

/**
 * ------------------------------------------------------------------------------------------------- 
 * Include files
 * -------------------------------------------------------------------------------------------------
 */

// Add Customizer functionality.
require get_template_directory() . '/inc/customizer.php';

// Implement Custom Header features.
require get_template_directory() . '/inc/custom-header.php';

// Custom functions for various things
require get_template_directory() . '/inc/custom-functions.php';

// Custom template tags for this theme.
require get_template_directory() . '/inc/template-tags.php';

// Custom widgets
require get_template_directory() . '/inc/widgets.php';

// Walker Class
require get_template_directory() . '/inc/walker-class.php';
?>