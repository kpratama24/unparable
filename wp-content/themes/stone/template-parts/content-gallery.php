<?php
/**
 * The template for displaying posts in the Gallery post format
 *
 * @package Stone
 * @since stone 1.0
 */
?>

<article id="id-<?php echo stone_get_the_post_slug(get_the_ID()); ?>" <?php post_class(); ?>>

	<?php
	if ( post_password_required() || is_single() ) :

		stone_post_header(); 
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
		Things to consider with galleries in posts:
		(1) If a gallery is made up of images uploaded to the same post in which they appear, then they are "attached" to the post. In this case you can collect the gallery images with get_post or get_children.
		(2) If a gallery is made up of images uploaded to a different post or via the Media Library, then they are NOT attached to the post. In this case the only way to make them show is by using the_content().
		*/

		/* 
		Fetch the gallery images. 
		If they are attachments then $images_count should be greater than 0  
		*/
		$args = array(
			'post_parent' => $post->ID, 
			'post_type' => 'attachment', 
			'post_mime_type' => 'image', 
			'orderby' => 'menu_order', 
			'order' => 'ASC', 
			'numberposts' => -1, 
		);
			
		$images = get_children($args);
		$images_count = count($images);
				
		/*
		Use the post thumbnail as the gallery teaser in the excerpt,
		and display the amount of images in the gallery if they are attachments. 
		Always display a link.
		*/
		if ( has_post_thumbnail() ) :
			?>		
			<div class="entry-image">
				<?php	the_post_thumbnail( 'large' ); ?>
			</div>
			
			<div class="entry-content">
				<?php
				if ( 0 != $images_count ) :
					?>
					<p>
						<?php 
						printf( _n( 'This gallery contains %1$s photo.', 'This gallery contains %1$s photos.', $images_count, 'stone' ), number_format_i18n( $images_count )	); 
						?>
					</p>
					<?php
				endif;
				?>
					
				<a class="button" href="<?php esc_url( get_permalink() ); ?>" rel="bookmark"><?php _e( 'View Gallery', 'stone' ); ?></a>
			</div><!-- /.entry-content -->
			<?php
		
		/* Display the gallery */
		else :
			?>

			<div class="entry-gallery">
				<?php
				the_content( sprintf( __( 'View Gallery %s', 'stone' ), the_title( '<span class="screen-reader-text">', '</span>', false ) ) );

				wp_link_pages( array(
					'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'stone' ) . '</span>',
					'after'       => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
				) );
				?>	
			</div>

		<?php
		endif;
	endif;
	?>
</article>