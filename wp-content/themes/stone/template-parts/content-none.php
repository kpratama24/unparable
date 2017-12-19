<?php
/**
 * The template for displaying a "No posts found" message
 *
 * @package Stone
 * @since Stone 1.0
 */


?>

<article class="page">

	<div class="entry-content">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) : 
			?>
			<p><?php printf( __( 'Ready to publish your first post?', 'stone' ) . ' <a href="%1$s">' . __( 'Get started here', 'stone' ) . '</a>.', admin_url( 'post-new.php' ) ); ?></p>
			<?php 

		elseif ( is_search() ) : 
			?>
			<p><?php _e( 'Nothing matched your search terms. Please try again with some different keywords.', 'stone' ); ?></p>
			<?php 
			get_search_form(); 

		else : 
			?>
			<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'stone' ); ?></p>
			<?php 
			get_search_form(); 

		endif; 
		?>
	</div><!-- /.entry-content -->
		
</article>