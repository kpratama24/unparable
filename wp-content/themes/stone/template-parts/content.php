<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 * Also used for post formats Audio, Chat, Link, Quote, Status and Video. They all follow the same pattern.
 *
 * @package Stone
 * @since stone 1.0
 */
?>

<article id="id-<?php echo stone_get_the_post_slug(get_the_ID()); ?>" <?php post_class(); ?>>

	<?php 
	stone_post_header(); 
	stone_post_thumbnail(); 
	?>

	<div class="entry-content">
		<?php
		if ( is_search() ) :
			
			/* translators: %s Name of current post */
			the_excerpt( sprintf( __( 'Read more %s', 'stone' ), the_title( '<span class="screen-reader-text">', '</span>', false ) ) );

		else :
			
			/* translators: %s Name of current post */
			the_content( sprintf( __( 'Read more %s', 'stone' ), the_title( '<span class="screen-reader-text">', '</span>', false ) ) );
			
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'stone' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			) );

		endif;
		?>	
	</div><!-- /.entry-content -->		
		
	<?php
	if ( is_single() && !post_password_required() ) :
		
		stone_post_footer();
	
	endif;
	?>
	
</article>