<?php
/**
 * Custom template tags for stone
 *
 * @package Stone
 * @since Stone 1.0
 *
 * - Post title
 * - Post header
 * - Post footer
 * - Page header
 * - More than one category
 * - Flush categorized transient
 * - Display post thumbnail
 * - Post navigation
 * - Index page post navigation
 * - Custom comments
 * - Tag cloud widget
 * - Attached images 
 */

/**
 * ------------------------------------------------------------------------------------------------- 
 * Print HTML with the title for the current post/page
 * Checks to see if there is a title first and displays a fall back in that case
 * If the post/page is password protected the title isn't linked
 *
 * @since Stone 1.0
 * -------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'stone_post_title' ) ) :
	
	function stone_post_title() {

		// First check to see if there is a title 
		$post_title = get_the_title();

		if ( '' == $post_title ) :
			$post_title = '[ empty title ]'; 
			$css_class = 'no-title';

		else :	
			$css_class = '';

		endif;

		// Display the title
		if ( is_single() || ( is_page() && !is_front_page() ) ) :
			?>
			<h1 class="entry-title <?php echo esc_attr ( $css_class ); ?>"><?php echo esc_html ( $post_title ); ?></h1>
			<?php
		
		elseif ( post_password_required() ) :
			// If the post is password protected, don't add a link to the title
			?>
			<h3 class="entry-title <?php echo esc_attr ( $css_class ); ?>"><?php echo esc_html ( $post_title ); ?></h3>
			<?php
		
		else :			
			?>
			<h3 class="entry-title <?php echo esc_attr ( $css_class ); ?>"><a href="<?php esc_url( the_permalink() ); ?>" rel="bookmark"><?php echo esc_html ( $post_title ); ?></a></h3>
			<?php
		endif;
	}
endif;

/**
 * ------------------------------------------------------------------------------------------------- 
 * Print HTML with meta information for the current post on index pages:
 * date/time, author, categories and comments followed by the title
 *
 * @since Stone 1.0
 * -------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'stone_post_header' ) ) :

	function stone_post_header() {
	
		// Need this to add the post-type on the search result page
		global $post;
		?>
		<header class="entry-header">
			<div class="entry-meta">
				<?php
				// The edit link
				edit_post_link( __( 'Edit', 'stone' ), '<span class="edit-link">', '</span>' );
	 
	 			// If this excerpt appears on a search result page add the post type to the meta
	 			if ( is_search() ) :
					?>
					<span class="post-type">
						<?php echo $post->post_type; ?>
					</span>
					<?php
				endif;

	 			// The date
				printf('
					<span class="entry-date">
						<a href="%1$s" rel="bookmark"> 
							<time datetime="%2$s">%3$s</time>
						</a>
					</span>',
					esc_url( get_permalink() ),
					esc_attr( get_the_date( 'c' ) ),
					//esc_html( get_the_date( 'j M Y' ) )
					esc_html( get_the_date( get_option( 'date_format' ) ) )
				);
				
				if ( !is_single() ) :
	
					/*
					// The author
					printf('
						<span class="author vcard">
							<a class="url fn n" href="%1$s" rel="author">%2$s</a>
						</span>',
						esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
						get_the_author()
					);
					*/
					
					// The categories
					if ( in_array( 'category', get_object_taxonomies( get_post_type() ) ) && stone_categorized_blog() ) : 
						?>
						<span class="cat-links"><?php echo get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'stone' ) ); ?></span>
						<?php
					endif;

					/*
					Jetpack Portfolio content types needs to have its categories/tags displayed as well,
					so set up the necessary things to do so.
			
					If there are types or tags all the terms are fetched first and placed in an array,
					so that they can be printed with comma's in between.
					*/
					if ( 'jetpack-portfolio' == get_post_type() ) :
				
						$type_term_array = stone_jetpack_portfolio_types_and_tags( 'jetpack-portfolio-type' );
					
						if ( '' != $type_term_array ) :
							?>
							<span class="cat-links"><?php echo implode( ', ', $type_term_array ); ?></span>
							<?php
						endif;
					endif;

					// Are there comments?				
					if ( ! post_password_required() && ( comments_open() && (get_comments_number() > 1) ) ) :
						?>
						<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'stone' ), __( '1 Comment', 'stone' ), __( '% Comments', 'stone' ) ); ?></span>
						<?php
					endif;
				
				endif;
				?>
			</div>
		
			<?php
			stone_post_title();
			?>
		</header><!-- /.entry-header -->
		<?php	
	}
endif;

/**
 * ------------------------------------------------------------------------------------------------- 
 * Print HTML with meta information for the current post on a singular page:
 * categories, tags and author
 *
 * @since Stone 1.0
 * -------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'stone_post_footer' ) ) :

	function stone_post_footer() {	
		?>
		<footer class="entry-footer">
			<?php
			/*
			Avoid adding a div if a post doesn't have any categories or tags.
			Posts always have at least one category, but if Custom Content types have been enabled
			in Jetpack, then the categories and tags are a different taxonomy. 
			So a post could have no categories or tags in that case.
			*/
			if ( has_category() || has_tag() ) :
				?>
				<div class="entry-meta">
					<?php
					// Categories
					if ( in_array( 'category', get_object_taxonomies( get_post_type() ) ) && stone_categorized_blog() ) : 
						?>
						<p>
							<span class="meta-title"><?php _e( 'Category', 'stone' ); ?></span>
							<span class="meta-links">
								<?php echo get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'stone' ) ); ?>
							</span>
						</p>
						<?php
					endif;
				
					// Tags
					if ( has_tag() ) :
						?>
						<p>
							<span class="meta-title"><?php _e( 'Tags', 'stone' ); ?></span>
							<span class="meta-links"><?php echo get_the_tag_list( '',', ','' ); ?></span>
						</p>
						<?php
					endif;
					?>
				</div><!-- /.entry-meta -->
				<?php
			endif;

			/*
			Jetpack Portfolio content types needs to have its categories/tags displayed as well,
			so set up the necessary things to do so.
			
			If there are types or tags all the terms are fetched first and placed in an array,
			so that they can be printed with comma's in between.
			*/
			if ( 'jetpack-portfolio' == get_post_type() ) :
				
				$type_term_array = stone_jetpack_portfolio_types_and_tags( 'jetpack-portfolio-type' );
				$tag_term_array = stone_jetpack_portfolio_types_and_tags( 'jetpack-portfolio-tag' );
								
				if ( ( '' != $type_term_array ) || ( '' != $tag_term_array ) ) :
					?>
					<div class="entry-meta">
						<?php
						if ( 0 != count( $type_term_array ) ) :
							?>
							<p>
								<span class="meta-title"><?php _e( 'Types', 'stone' ); ?></span>
								<span class="meta-links"><?php echo implode( ', ', $type_term_array ); ?></span>
							</p>
							<?php
						endif;
						
						if ( 0 != count( $tag_term_array ) ) :
							?>
							<p>
								<span class="meta-title"><?php _e( 'Tags', 'stone' ); ?></span>
								<span class="meta-links"><?php echo implode( ', ', $tag_term_array ); ?></span>
							</p>
							<?php
						endif;
						?>
					</div>
					<?php
				endif;

			endif;
			?>
				
			<div class="entry-author">
				<div class="author-avatar">
					<?php
					$author_bio_avatar_size = apply_filters( 'stone_author_bio_avatar_size', 100 );
					echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size );
					?>
				</div><!-- .author-avatar -->

				<div class="author-description">
					<?php
					// Set up author information.
					printf('
						<h3 class="author vcard">
							<a class="url fn n" href="%1$s" rel="author">%2$s</a>
						</h3>',
						esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
						get_the_author()
					);
					?>
					<?php the_author_meta( 'description' ); ?>
				</div>
	
			</div><!-- /.entry-author -->
		</footer><!-- /.entry-footer -->
		<?php	
	}
endif;

/**
 * ------------------------------------------------------------------------------------------------- 
 * Print HTML with meta information for the current page:
 * author and title
 *
 * @since Stone 1.0
 * -------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'stone_page_header' ) ) :
	
	function stone_page_header() {
		
		?>
		<header class="entry-header">
			<div class="entry-meta">
				<?php
				// The edit link
				edit_post_link( __( 'Edit', 'stone' ), '<span class="edit-link">', '</span>' );
				stone_post_title();				

				/*
				if ( is_page_template( 'template-pages/template-archive.php' ) ) :
					// Only print the title
					stone_post_title();
					
				elseif ( !is_front_page() ) : 
					// Set up author information.
					printf('
						<span class="author vcard">
							<a class="url fn n" href="%1$s" rel="author">%2$s</a>
						</span>',
						esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
						get_the_author()
					);

					stone_post_title();				
				endif;
				*/
				?>
			</div>
		</header><!-- /.entry-header -->
		<?php
	}
endif;

/**
 * ------------------------------------------------------------------------------------------------- 
 * Find out if blog has more than one category.
 *
 * @since Stone 1.0
 *
 * @return boolean true if blog has more than 1 category
 * -------------------------------------------------------------------------------------------------
 */

function stone_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'stone_category_count' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );
		
		set_transient( 'stone_category_count', $all_the_cool_cats );
	}

	if ( 1 !== (int) $all_the_cool_cats ) {
		// This blog has more than 1 category so stone_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so stone_categorized_blog should return false
		return false;
	}
}

/**
 * ------------------------------------------------------------------------------------------------- 
 * Flush out the transients used in stone_categorized_blog.
 *
 * @since Stone 1.0
 * -------------------------------------------------------------------------------------------------
 */

function stone_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'stone_category_count' );
}

add_action( 'edit_category', 'stone_category_transient_flusher' );
add_action( 'save_post',     'stone_category_transient_flusher' );

/**
 * ------------------------------------------------------------------------------------------------- 
 * Display an optional post thumbnail.
 *
 * Wraps the post thumbnail in a div element,
 * and fetches a different size depending on index or single views.
 *
 * @since Stone 1.0
 * -------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'stone_post_thumbnail' ) ) :

	function stone_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( has_post_thumbnail() ) :
		
			$css_class = stone_post_thumbnail_orientation();
			?>
			<div class="entry-image <?php echo esc_attr ( $css_class ); ?>">
				<?php the_post_thumbnail( 'large' ); ?>
			</div>
			<?php

		endif;
	}
endif;

/**
 * ------------------------------------------------------------------------------------------------- 
 * Display navigation to next/previous post when applicable.
 *
 * @since Stone 1.0
 * -------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'stone_post_nav' ) ) :
	function stone_post_nav() {
		// Don't print empty markup if there's nowhere to navigate.
		$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
		$next     = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous ) {
			return;
		}

		?>
		<nav class="navigation post-navigation" role="navigation">
			<p class="screen-reader-text"><?php _e( 'Post navigation', 'stone' ); ?></p>
			<div class="nav-links">
				<?php
				if ( is_attachment() ) :

					previous_image_link( 0, '<span class="previous-image"><span class="previous genericon genericon-previous"></span> ' . __( 'Previous Image', 'stone' ) . '</span>' ); 
					next_image_link( 0, '<span class="next-image">' . __( 'Next Image', 'stone' ) . '<span class="next genericon genericon-next"></span></span>' ); 

				else :
					previous_post_link( '%link', '<span class="previous genericon genericon-previous"></span> %title' );
					next_post_link( '%link', '%title <span class="next genericon genericon-next"></span>' );

				endif;
				?>
			</div><!-- .nav-links -->
		</nav><!-- .navigation -->
		<?php
	}
endif;

/**
 * ------------------------------------------------------------------------------------------------- 
 * Display navigation to next/previous set of posts when applicable.
 *
 * @since Stone 1.0
 *
 * @global WP_Query   $wp_query   WordPress Query object.
 * @global WP_Rewrite $wp_rewrite WordPress Rewrite object.
 * -------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'stone_paging_nav' ) ) :
	function stone_paging_nav() {
		global $wp_query, $wp_rewrite;

		// Don't print empty markup if there's only one page.
		if ( $wp_query->max_num_pages < 2 ) {
			return;
		}

		$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
		$pagenum_link = html_entity_decode( get_pagenum_link() );
		$query_args   = array();
		$url_parts    = explode( '?', $pagenum_link );

		if ( isset( $url_parts[1] ) ) {
			wp_parse_str( $url_parts[1], $query_args );
		}

		$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
		$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

		$format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
		$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

		// Set up paginated links.
		$links = paginate_links( array(
			'base'     => $pagenum_link,
			'format'   => $format,
			'total'    => $wp_query->max_num_pages,
			'current'  => $paged,
			'mid_size' => 1,
			'add_args' => array_map( 'urlencode', $query_args ),
			'prev_text' => '&larr; ' . __( 'Previous', 'stone' ),
			'next_text' => __( 'Next', 'stone' ) . ' &rarr;',
		) );

		if ( $links ) :

		?>
		<nav class="navigation paging-navigation" role="navigation">
			<p class="screen-reader-text"><?php _e( 'Posts navigation', 'stone' ); ?></p>
			<div class="pagination loop-pagination">
				<?php echo esc_html ( $links ); ?>
			</div><!-- .pagination -->
		</nav><!-- .navigation -->
		<?php
		endif;
	}
endif;

/**
 * ------------------------------------------------------------------------------------------------- 
 * Custom comments list
 *
 * @since Stone 1.0
 * -------------------------------------------------------------------------------------------------
 */

function stone_custom_comments( $comment, $args, $depth ) {
   
	$GLOBALS['comment'] = $comment; 
	?>

	<li id="comment-<?php comment_ID() ?>" <?php comment_class(); ?>>

		<div class="comment-avatar">
			<?php echo get_avatar( $comment, 100 ); ?>
		</div><!-- .author-avatar -->

		<header class="comment-header">				
			<span class="entry-meta">
				<?php 
				// Set up date.
				printf('
					<span class="entry-date">
						<a href="%1$s">
							<time datetime="%2$s">%3$s</time>
						</a>
					</span>',
					esc_attr( get_comment_link() ),
					esc_attr( get_comment_time( 'c' ) ),
					esc_html( get_comment_time( 'j M Y - H:i' ) )
				);
				?>
			</span>
			<h3><?php comment_author_link() ?></h3>
		</header>

		<div class="comment-content">
			<?php
			if ( $comment->comment_approved == '1' ): comment_text();
			else: 
				?>
				<p><em><?php _e( 'Your comment is awaiting moderation.', 'stone' ); ?></em></p>	
				<?php 
			endif; 
					
			// Comment edit link
			edit_comment_link(__( 'Edit', 'stone' ), '<span class="edit-link">', '</span>'); 

			// Comment reply link
			comment_reply_link(array_merge( $args, array(
				'reply_text' => __( 'Reply', 'stone' ), 
				'add_below' => 'comment', 
				'depth' => $depth, 
				'max_depth' => $args['max_depth'],
			))); 
			?>
		</div>

	</li><!-- /.comment -->
	<?php 
}

// Remove inline styles
function stone_remove_style_tag_cloud($tag_string) {
   return preg_replace("/style='font-size:.+pt;'/", '', $tag_string);
}
add_filter( 'wp_tag_cloud', 'stone_remove_style_tag_cloud' );

/**
 * ------------------------------------------------------------------------------------------------- 
 * Print the attached image with a link to the next attached image.
 * Filter the default stone attachment size.
 *
 * @since Stone 1.0
 *
 * @param array $dimensions {
 *     An array of height and width dimensions.
 *
 *     @type int $height Height of the image in pixels. Default 810.
 *     @type int $width  Width of the image in pixels. Default 810.
 * }
 *
 * @since Stone 1.0
 * -------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'stone_the_attached_image' ) ) :

	function stone_the_attached_image() {
		$post                = get_post();
		$attachment_size     = apply_filters( 'stone_attachment_size', array( 810, 810 ) );
		$next_attachment_url = wp_get_attachment_url();

		/*
		 * Grab the IDs of all the image attachments in a gallery so we can get the URL
		 * of the next adjacent image in a gallery, or the first image (if we're
		 * looking at the last image in a gallery), or, in a gallery of one, just the
		 * link to that image file.
		 */
		$attachment_ids = get_posts( array(
			'post_parent'    => $post->post_parent,
			'fields'         => 'ids',
			'numberposts'    => -1,
			'post_status'    => 'inherit',
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'order'          => 'ASC',
			'orderby'        => 'menu_order ID',
		) );

		// If there is more than 1 attachment in a gallery...
		if ( count( $attachment_ids ) > 1 ) {
			foreach ( $attachment_ids as $attachment_id ) {
				if ( $attachment_id == $post->ID ) {
					$next_id = current( $attachment_ids );
					break;
				}
			}

			// get the URL of the next image attachment...
			if ( $next_id ) {
				$next_attachment_url = get_attachment_link( $next_id );
			}

			// or get the URL of the first image attachment.
			else {
				$next_attachment_url = get_attachment_link( reset( $attachment_ids ) );
			}
		}

		printf( '<a href="%1$s" rel="attachment">%2$s</a>',
			esc_url( $next_attachment_url ),
			wp_get_attachment_image( $post->ID, $attachment_size )
		);
	}
endif;

/**
 * ------------------------------------------------------------------------------------------------- 
 * Displays the optional custom logo.
 *
 * Does nothing if the custom logo is not available.
 *
 * @since Stone 1.0
 * -------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'stone_the_custom_logo' ) ) :

	function stone_the_custom_logo() {
		if ( function_exists( 'the_custom_logo' ) ) {
			?>
			<div class="site-header-container">
				<?php the_custom_logo(); ?>
			</div>
			<?php
		}
	}

endif;

?>