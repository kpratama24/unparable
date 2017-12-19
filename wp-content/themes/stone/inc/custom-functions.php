<?php
/**
 * Custom functions for stone
 *
 * @package Stone
 * @since Stone 1.0
 */

/**
 * ------------------------------------------------------------------------------------------------- 
 * stone_get_the_post_slug()
 * Used to add a more useful unique ID to post articles
 * -------------------------------------------------------------------------------------------------
 */

function stone_get_the_post_slug($id) {
	$post_data = get_post($id, ARRAY_A);
	$slug = $post_data['post_name'];
	return $slug;
}

/**
 * ------------------------------------------------------------------------------------------------- 
 * Post thumbnail orientation
 * -------------------------------------------------------------------------------------------------
 */

function stone_post_thumbnail_orientation() {
	global $post;
	$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
	$post_thumbnail_meta = wp_get_attachment_metadata( $post_thumbnail_id );
	
	if ( $post_thumbnail_meta['width'] > $post_thumbnail_meta['height'] ) {
		$css_class = 'landscape';
	} else {
		$css_class = 'portrait';
	}
	
	return $css_class;
}

/**
 * ------------------------------------------------------------------------------------------------- 
 * Custom search form
 * So that I can add in the magnifiying glass Genericon in the HTML
 * -------------------------------------------------------------------------------------------------
 */

function stone_custom_search_form( $form ) {
	$form = '<form role="search" method="get" class="search-form" action="' . home_url( '/' ) . '" >';
	$form .= '<label class="screen-reader-text" for="s">' . __( 'Search for:', 'stone' ) . '</label>';
	$form .= '<input type="search" class="search-field" placeholder="Search &hellip;" value="" name="s" id="s" />';
	$form .= '<input class="screen-reader-text" type="submit" id="searchsubmit" value="'. esc_attr__( 'Search', 'stone' ) .'" />';
	$form .= '</form>';

	return $form;
}

add_filter( 'get_search_form', 'stone_custom_search_form' );

/**
 * ------------------------------------------------------------------------------------------------- 
 * Custom password form
 * Because I want the input field for the password outside of the label tags
 * -------------------------------------------------------------------------------------------------
 */

//apply_filters ( 'post_password_expires', 0 );

function stone_custom_password_form() {
	global $post;
	$label = 'pwbox-' . ( empty( $post->ID ) ? rand() : $post->ID );

	$form  = '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post" class="post-password-form">';
	$form .= __( 'This content is password protected. To view it please enter your password:', 'stone'  );
	$form .= '<label for="' . $label . '">' . __( 'Password:', 'stone'  ) . ' </label>';
	$form .= '<input name="post_password" id="' . $label . '" type="password" size="20" maxlength="20" />';
	$form .= '<input type="submit" name="Submit" value="' . esc_attr__( 'Submit', 'stone' ) . '" />';
	$form .= '</form>';
	
	return $form;
}
add_filter( 'the_password_form', 'stone_custom_password_form' );

/**
 * ------------------------------------------------------------------------------------------------- 
 * Custom footer credits
 * -------------------------------------------------------------------------------------------------
 */

function stone_custom_theme_credits() {

	$theme_credits = wp_get_theme();
	$theme_name = $theme_credits->get( 'Name' );
	$theme_name_link = $theme_credits->get( 'ThemeURI' );
	$theme_author = $theme_credits->get( 'Author' );
	$theme_author_link = $theme_credits->get( 'AuthorURI' );

	echo '<p>' . $theme_name . ' ' . __( 'by', 'stone' ) . ' ' . '<a href="' . $theme_author_link . '" rel="external">' . $theme_author . '</a></p>';
}

add_action( 'stone_credits','stone_custom_theme_credits' );

/**
 * ------------------------------------------------------------------------------------------------- 
 * Jetpack Portfolio content type
 * Find the project types and tags
 * -------------------------------------------------------------------------------------------------
 */

function stone_jetpack_portfolio_types_and_tags( $taxonomy ) {

	// Find the terms for the taxonomy
	$portfolio_terms = get_the_terms( get_the_ID(), $taxonomy );
				
	// Create an array for the terms
	$term_array = array();
	
	if ( $portfolio_terms ) :

		foreach ( $portfolio_terms as $type_term ) :
			array_push($term_array, $type_term->name);
		endforeach;
							
		// Order array alphabetically
		sort($term_array, SORT_NATURAL | SORT_FLAG_CASE);							

	endif;
	
	return $term_array;
}

?>