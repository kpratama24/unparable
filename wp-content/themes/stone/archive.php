<?php
/**
 * The template for displaying Archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * It puts together category, tag, author, search and date-based pages.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for date.php
 *
 * @package Stone
 * @since Stone 1.0
 */

get_header(); 
?>

<main id="main" class="site-main" role="main">
	<?php
	if ( have_posts() ) :
		?>
		<header class="archive-header">
			<h1 class="archive-title">
				<?php
				/* Date based archives */
				if ( is_day() ) :
					printf( '<span class="title-meta">' . __( 'Daily Archives: ', 'stone' ) . '</span> %s', esc_html( get_the_date( get_option( 'date_format' ) ) ) );

				elseif ( is_month() ) :
					printf( '<span class="title-meta">' . __( 'Monthly Archives:', 'stone' ) . '</span> %s', get_the_date( _x( 'F Y', 'monthly archives date format', 'stone' ) ) );

				elseif ( is_year() ) :
					printf( '<span class="title-meta">' .  __( 'Yearly Archives:', 'stone' ) . '</span> %s', get_the_date( _x( 'Y', 'yearly archives date format', 'stone' ) ) );
				
				elseif ( 'jetpack-portfolio' == get_post_type() ) :
					_e( 'Portfolio', 'stone' );
					
				elseif ( 'jetpack-testimonial' == get_post_type() ) :
					_e( 'Testimonials', 'stone' );
					
				else :
					_e( 'Archives', 'stone' );

				endif;				
				?>
			</h1>
		</header><!-- .archive-header -->
		<?php
		
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