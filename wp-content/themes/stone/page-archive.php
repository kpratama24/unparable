<?php
/**
Template Name: Page - Archives
 *
 * This template displays an overview of categories, tags, monthly archives and recent posts
 *
 * @package Stone
 * @since Stone 1.0
 */

get_header(); ?>

<main id="main" class="site-main" role="main">

	<?php
	// Start the Loop.
	while ( have_posts() ) : the_post();

		// Include the page content template.
		get_template_part( 'template-parts/content', 'page' );
				
		wp_link_pages( array(
			'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'stone' ) . '</span>',
			'after'       => '</div>',
			'link_before' => '<span>',
			'link_after'  => '</span>',
		) );
		
	endwhile;
	?>

	<div class="archives-content widget_archive">
		<h3><?php _e( 'By category' , 'stone' ); ?></h3>
		<ul>
			<?php wp_list_categories( 'hierarchical=0&title_li=' ); ?>
		</ul>
	</div>
	
	<div class="archives-content widget_tag_cloud">
		<h3><?php _e( 'By tag' , 'stone' ); ?></h3>
		<ul class="tagcloud">
			<?php wp_tag_cloud(); ?>
		</ul>
	</div>

	<div class="archives-content widget_archive">
		<h3><?php _e( 'By month' , 'stone' ); ?></h3>
		<ul>
			<?php wp_get_archives(); ?>
		</ul>
	</div>

	<div class="archives-content widget_archive">
		<h3><?php _e( 'By year' , 'stone' ); ?></h3>
		<ul>
			<?php wp_get_archives( 'type=yearly' ); ?>
		</ul>
	</div>

	<div class="archives-content widget_archive">
		<h3><?php _e( 'By author' , 'stone' ); ?></h3>
		<ul>
			<?php wp_list_authors( 'optioncount=0' ); ?>
		</ul>
	</div>

</main><!-- #main -->

<?php 
get_sidebar();
get_footer();
?>