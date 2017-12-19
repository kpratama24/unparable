<?php
/**
 * The Template for displaying image attachments.
 *
 * @package Stone
 * @since Stone 1.0
 */

if ( ! isset( $content_width ) ) {
	$content_width = 1024;
}

// Retrieve attachment metadata.
$metadata = wp_get_attachment_metadata();

get_header(); 
?>

<main id="main" class="site-main" role="main">

	<?php 	
	// Start the Loop.
	while ( have_posts() ) : the_post();
		?>
		<article id="id-<?php echo stone_get_the_post_slug(get_the_ID()); ?>" <?php post_class(); ?>>

			<header class="entry-header">
				<div class="entry-meta">
					<?php edit_post_link( __( 'Edit', 'stone' ), '<span class="edit-link">', '</span>' ); ?>
					<span class="entry-date">
						<time class="entry-date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
							<?php echo esc_html( get_the_date( get_option( 'date_format' ) ) ); ?>	
						</time>
					</span>

					<span class="full-size-link">
						<a href="<?php echo esc_url( wp_get_attachment_url() ); ?>">
							<?php echo esc_html( $metadata['width'] ); ?> &times; <?php echo esc_html( $metadata['height'] ); ?>
						</a>
					</span>

					<span class="parent-post-link">
						<a href="<?php echo esc_url( get_permalink( $post->post_parent ) ); ?>" rel="gallery">
							<?php echo get_the_title( $post->post_parent ); ?>
						</a>
					</span>
				</div>
				<h1><?php the_title(); ?></h1>
			</header>
			
			<div class="entry-content">
				<?php
				stone_the_attached_image();
								
				if ( has_excerpt() ) : 
					?>
					<div class="entry-caption">
						<?php the_excerpt(); ?>
					</div>
					<?php
				endif;

				/* translators: %s: Name of current post */
				the_content( sprintf( __( 'Read more %s', 'stone' ), the_title( '<span class="screen-reader-text">', '</span>', false ) ) );

				wp_link_pages( array(
					'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'stone' ) . '</span>',
					'after'       => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
				) );				
				?>
			</div>

		</article>

		<?php
		// Previous/next post navigation.
		stone_post_nav();

	// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) :
				comments_template();
		endif;
	endwhile;
?>

</main><!-- #main (opened in header.php) -->

<?php
get_sidebar();
get_footer();
?>