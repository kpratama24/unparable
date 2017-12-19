<?php
/**
 * The template for displaying Jetpack Portfolio Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Stone
 * @since Stone 1.0
 */

get_header();
?>

<main id="main" class="site-main" role="main">

	<header class="archive-header">
		<h1 class="archive-title"><?php _e( 'Portfolio', 'stone' ); ?></h1>
	</header><!-- .archive-header -->

	<?php
	if ( have_posts() ) :
		
		// Start the Loop.
		while ( have_posts() ) : the_post();

			/*
			 * Include the post format-specific template for the content. If you want to
			 * use this in a child theme, then include a file called called content-___.php
			 * (where ___ is the post format) and that will be used instead.
			 */

			get_template_part( 'template-parts/content', '' );

		endwhile;
		
		// Previous/next post navigation.
		stone_paging_nav();

	else :
	
		// If no content, include the "No posts found" template.
		get_template_part( 'template-parts/content', 'none' );
		
	endif;
	?>

</main><!-- #main -->

<?php
get_sidebar();
get_footer();
?>