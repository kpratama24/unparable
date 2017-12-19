<?php
/**
 * The template for displaying Comments
 *
 * The area of the page that contains comments and the comment form.
 *
 * @package Stone
 * @since Stone 1.0
 */

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

		<?php 
		comment_form(); 

		if ( have_comments() ) : 
			?>
			<h2 class="comments-title">
				<?php
					printf( _n( '1 Comment', '%1$s Comments', get_comments_number(), 'stone' ), number_format_i18n( get_comments_number() ), get_the_title() );
				?>
			</h2>

			<?php 
			if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : 
				?>
				<nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
					<p class="screen-reader-text"><?php _e( 'Comment navigation', 'stone' ); ?></p>
					<div class="nav-previous">
						<?php previous_comments_link( '&larr; ' . __( 'Older Comments', 'stone' ) ); ?>
					</div>
					<div class="nav-next">
						<?php next_comments_link( __( 'Newer Comments', 'stone' ) . ' &rarr;' ); ?>
					</div>
				</nav><!-- #comment-nav-above -->
				<?php 
			endif; // Check for comment navigation. 
			?>

			<ol class="comment-list">
				<?php
				/*
				wp_list_comments( array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 100,
				) );
				*/
				wp_list_comments( array( 'callback' => 'stone_custom_comments' ) ); 
				?>
			</ol><!-- .comment-list -->

			<?php 
			if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : 
				?>
				<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
					<p class="screen-reader-text"><?php _e( 'Comment navigation', 'stone' ); ?></p>
					<div class="nav-previous">
						<?php previous_comments_link( '&larr; ' . __( 'Older Comments', 'stone' ) ); ?>
					</div>
					<div class="nav-next">
						<?php next_comments_link( __( 'Newer Comments', 'stone' ) . ' &rarr;' ); ?>
					</div>
				</nav><!-- #comment-nav-below -->
				<?php 
			endif; // Check for comment navigation. 
			
			if ( ! comments_open() ) : 
				?>
				<p class="no-comments"><?php _e( 'Comments are closed.', 'stone' ); ?></p>
				<?php 
			endif; 
			
		endif; // have_comments() 
		?>

</div><!-- #comments -->