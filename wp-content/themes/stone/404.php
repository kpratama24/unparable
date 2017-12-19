<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package Stone
 * @since Stone 1.0
 */

get_header(); 
?>

<main id="main" class="site-main" role="main">

	<article class="page">

		<header class="entry-header">
			<h1 class="entry-title"><?php _e( 'Not Found', 'stone' ); ?></h1>
		</header><!-- /.entry-header -->

		<div class="entry-content">
			<p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'stone' ); ?></p>

			<?php get_search_form(); ?>
		</div><!-- /.entry-content -->
		
	</article>

</main><!-- #main (opened in header.php) -->

<?php
get_sidebar();
get_footer();
?>