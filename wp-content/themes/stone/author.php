<?php
/**
 * The template for displaying Author archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Stone
 * @since Stone 1.0
 */

get_header(); 
?>

<main id="main" class="site-main" role="main">
	<?php
	if ( have_posts() ) :

		/*
		 * Queue the first post, that way we know what author
		 * we're dealing with (if that is the case).
		 *
		 * We reset this later so we can run the loop properly
		 * with a call to rewind_posts().
		 */
		the_post();
		?>
		
		<header class="archive-header">
			<h1 class="archive-title">
				<?php printf( '<span class="title-meta">' . __( 'All posts by', 'stone' ) . '</span> %s', get_the_author() ); ?>
			</h1>

			<div class="author-avatar">
				<?php
				/**
				 * Filter the author bio avatar size.
				 *
				 * @since Twenty Thirteen 1.0
				 *
				 * @param int $size The avatar height and width size in pixels.
		 		 */	
				
				$author_bio_avatar_size = apply_filters( 'stone_author_bio_avatar_size', 74 );
				echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size );
				?>
			</div><!-- .author-avatar -->

			<?php 
			// Show author descprition if there is one
			if ( get_the_author_meta( 'description' ) ) : 
				?>
			
				<div class="author-description"><?php the_author_meta( 'description' ); ?></div>
			
				<?php 
			endif; 
			?>
		</header><!-- .archive-header -->
		
		<?php
		
		/*
		 * Since we called the_post() above, we need to rewind
		 * the loop back to the beginning that way we can run
		 * the loop properly, in full.
		 */
		rewind_posts();

		// Start the Loop.
		while ( have_posts() ) : the_post();

			/*
			 * Include the post format-specific template for the content. If you want to
			 * use this in a child theme, then include a file called called content-___.php
			 * (where ___ is the post format) and that will be used instead.
			 */
			get_template_part( 'template-parts/content', get_post_format() );
		
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