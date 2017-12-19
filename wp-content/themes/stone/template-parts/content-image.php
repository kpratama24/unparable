<?php
/**
 * The template for displaying posts in the Image post format
 *
 * @package Stone
 * @since Stone 1.0
 */
?>

<article id="id-<?php echo stone_get_the_post_slug(get_the_ID()); ?>" <?php post_class(); ?>>

	<?php
	if ( post_password_required() || is_single() ) :

		stone_post_header(); 
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
		
		<?php		
		stone_post_footer();

	else :		
		stone_post_header();
		
		/* 
		If there is a post thumbnail (or just a post thumbnail), 
		display it below the title.
		*/
		
		if ( has_post_thumbnail() ) :
			?>
			<div class="entry-image">
				<?php the_post_thumbnail( 'large' ); ?>
			</div>
			
			<div class="entry-content">
				<?php
				/* translators: %s: Name of current post */
				the_content( sprintf( __( 'Read more %s', 'stone' ), the_title( '<span class="screen-reader-text">', '</span>', false ) ) );
				?>
			</div><!-- /.entry-content -->
			<?php
		
		/*
		If the image sits in the content, display the content.
		*/
		else :		
			
			?>

			<div class="entry-content">
				<?php 
				the_content( sprintf( __( 'Read more %s', 'stone' ), the_title( '<span class="screen-reader-text">', '</span>', false ) ) );

				wp_link_pages( array(
					'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'stone' ) . '</span>',
					'after'       => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
				) );
				?>
			</div><!-- /.entry-content -->

			<?php
			
		endif;

	endif;
	?>
</article>