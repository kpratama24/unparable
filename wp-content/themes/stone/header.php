<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <main id="main">
 *
 * @package Stone
 * @since Stone 1.0
 */
?>
<!DOCTYPE html>
<!--[if IE 7]><html class="no-js ie ie7" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8]><html class="no-js ie ie8" <?php language_attributes(); ?>><![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!--><html class="no-js" <?php language_attributes(); ?>><!--<![endif]-->

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?php bloginfo( 'description' ); ?>">
	
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php
/*
The .hfeed class is part of the hAtom 0.1 microformat specification 
and indicates to machines that the enclosed content is syndicated content. 
Such as a blog feed.
MORE: http://microformats.org/wiki/hatom
*/
?>
<div id="wrapper" class="hfeed site">

	<a class="screen-reader-text skip-link" href="#main" title="<?php esc_attr_e( 'Skip to content', 'stone' ); ?>" role="navigation">
		<?php _e( 'Skip to content', 'stone' ); ?>
	</a>
	
	<?php 
	/*
	The theme comes with a default header image. 
	Check to see if the header image has been removed.
	*/
	//$header_image = get_header_image();
	if ( get_header_image() ) : 
		?>
		<div class="site-header-image" role="complementary">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<img class="site-header-image-img" src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
			</a>
		</div>
		<?php 
	endif; 
	?>

	<header id="masthead" class="site-header" role="banner">
		
		<?php stone_the_custom_logo(); ?>
		
		<div class="site-header-container">
			<div class="header-title">
				<a class="home-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
					<h1 class="site-title"><?php bloginfo( 'name' ); ?></h1>
				</a>
			</div><!-- .header-title -->
	
			<div class="header-nav">
		
				<nav id="site-navigation" class="navigation main-navigation" role="navigation">
					<button class="menu-toggle">
						<?php _e( 'Menu', 'stone' ); ?>
					</button>
				
					<?php 
					wp_nav_menu( array( 
						'theme_location' => 'main-navigation', 
						'menu_class' => 'nav-menu', 
						'container' => 'false', 
					) ); 

					?>
				</nav><!-- #site-navigation -->				
			</div><!-- .header-nav -->
		</div><!-- .site-header-container -->
	</header><!-- #masthead -->