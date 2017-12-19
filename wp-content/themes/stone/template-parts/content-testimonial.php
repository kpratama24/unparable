<?php
/**
 * The template for displaying posts in the Quote post format
 *
 * @package Stone
 * @since stone 1.0
 */
?>

<article id="id-<?php echo stone_get_the_post_slug(get_the_ID()); ?>" <?php post_class(); ?>>

	<?php edit_post_link( __( 'Edit', 'stone' ), '<footer class="entry-meta"><span class="edit-link">', '</span></footer>' ); ?>

	<div class="content-container">
		<div class="testimonial-entry-content">
			<?php
			/* translators: %s: Name of current post */
			the_content( sprintf( __( 'Read more %s', 'stone' ), the_title( '<span class="screen-reader-text">', '</span>', false ) ) );
	
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'stone' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			) );
			?>
		</div><!-- /.entry-content -->

		<p class="testimonial-entry-title">
			<?php the_title( '&mdash; <a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a>' ); ?>
		</p>
	</div>

	<?php 
	if ( '' != get_the_post_thumbnail() ) : 
		?>
		<div class="testimonial-featured-image">
			<?php the_post_thumbnail( 'thumbnail' ); ?>
		</div>
		<?php 
	endif; 
	?>

</article>

