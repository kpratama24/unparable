<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package Stone
 * @since Stone 1.0
 */
?>

<article id="id-<?php echo stone_get_the_post_slug(get_the_ID()); ?>" <?php post_class(); ?>>

	<?php 
	stone_page_header();
	stone_post_thumbnail();
	?>

	<div class="entry-content">
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
		
</article>