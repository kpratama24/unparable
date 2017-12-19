<?php
/**
 * Custom widget to create Social Links menu
 *
 * @package Stone
 * @since Stone 1.0
 */

class stone_SocialLinksMenu_Widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			'SocialLinksMenu', // Base ID
			__( 'Social Media Icons (Stone)', 'stone' ), // Name
			array( 
				'classname' => 'widget_social_links',
				'description' => __( 'Link to your social profiles like Twitter, Facebook, Instagram and more', 'stone' ), 
			) // Args
		);
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		echo $before_widget;
		
		$title = empty($instance['title']) ? ' ' : apply_filters( 'widget_profile', $instance['title'] );

		$codepen_profile = empty($instance['codepen_profile']) ? ' ' : apply_filters( 'widget_codepen_profile', $instance['codepen_profile'] );
		$dribbble_profile = empty($instance['dribbble_profile']) ? ' ' : apply_filters( 'widget_dribbble_profile', $instance['dribbble_profile'] );
		$facebook_profile = empty($instance['facebook_profile']) ? ' ' : apply_filters( 'widget_facebook_profile', $instance['facebook_profile'] );
		$flickr_profile = empty($instance['flickr_profile']) ? ' ' : apply_filters( 'widget_flickr_profile', $instance['flickr_profile'] );
		$github_profile = empty($instance['github_profile']) ? ' ' : apply_filters( 'widget_github_profile', $instance['github_profile'] );
		$googleplus_profile = empty($instance['googleplus_profile']) ? ' ' : apply_filters( 'widget_googleplus_profile', $instance['googleplus_profile'] );
		$instagram_profile = empty($instance['instagram_profile']) ? ' ' : apply_filters( 'widget_instagram_profile', $instance['instagram_profile'] );
		$linkedin_profile = empty($instance['linkedin_profile']) ? ' ' : apply_filters( 'widget_linkedin_profile', $instance['linkedin_profile'] );
		$pinterest_profile = empty($instance['pinterest_profile']) ? ' ' : apply_filters( 'widget_pinterest_profile', $instance['pinterest_profile'] );
		$tumblr_profile = empty($instance['tumblr_profile']) ? ' ' : apply_filters( 'widget_tumblr_profile', $instance['tumblr_profile'] );
		$twitter_profile = empty($instance['twitter_profile']) ? ' ' : apply_filters( 'widget_twitter_profile', $instance['twitter_profile'] );
		$vimeo_profile = empty($instance['vimeo_profile']) ? ' ' : apply_filters( 'widget_vimeo_profile', $instance['vimeo_profile'] );
		$youtube_profile = empty($instance['youtube_profile']) ? ' ' : apply_filters( 'widget_youtube_profile', $instance['youtube_profile'] );

		if ( !empty( $title ) ) :
			echo $before_title . $title . $after_title; 
		endif;
		
		echo '<ul>';

		if($codepen_profile == ' ') { echo ''; } 
		else {  
			echo '<li class="codepen">
					<a href="http://codepen.io/'. esc_html( $codepen_profile ) .'" rel="external"><span class="screen-reader-text">' . __( 'View profile on Codepen', 'stone' ) . '</span></a>
					</li>'; 
		}
		if($dribbble_profile == ' ') { echo ''; } 
		else {  
			echo '<li class="dribbble">
					<a href="https://dribbble.com/'. esc_html( $dribbble_profile ) .'" rel="external"><span class="screen-reader-text">' . __( 'View profile on Dribbble', 'stone' ) . '</span></a>
					</li>'; 
		}
		if($facebook_profile == ' ') { echo ''; } 
		else {  
			echo '<li class="facebook">
					<a href="https://www.facebook.com/'. esc_html( $facebook_profile ) .'" rel="external"><span class="screen-reader-text">' . __( 'View profile on Facebook', 'stone' ) . '</span></a>
					</li>'; 
		}
		if($flickr_profile == ' ') { echo ''; } 
		else {  
			echo '<li class="flickr">
					<a href="https://www.flickr.com/photos/'. esc_html( $flickr_profile ) .'" rel="external"><span class="screen-reader-text">' . __( 'View profile on Flickr', 'stone' ) . '</span></a>
					</li>'; 
		}
		if($github_profile == ' ') { echo ''; } 
		else {  
			echo '<li class="github">
					<a href="https://github.com/'. esc_html( $github_profile ) .'" rel="external"><span class="screen-reader-text">' . __( 'View profile on Github', 'stone' ) . '</span></a>
					</li>'; 
		}
		if($googleplus_profile == ' ') { echo ''; } 
		else {  
			echo '<li class="googleplus">
					<a href="https://plus.google.com/u/0/+'. esc_html( $googleplus_profile ) .'" rel="external"><span class="screen-reader-text">' . __( 'View profile on Google+', 'stone' ) . '</span></a>
					</li>'; 
		}
		if($instagram_profile == ' ') { echo ''; } 
		else {  
			echo '<li class="instagram">
					<a href="https://instagram.com/'. esc_html( $instagram_profile ) .'" rel="external"><span class="screen-reader-text">' . __( 'View profile on Instagram', 'stone' ) . '</span></a>
					</li>'; 
		}
		if($linkedin_profile == ' ') { echo ''; } 
		else {  
			echo '<li class="linkedin">
					<a href="https://www.linkedin.com/in/'. esc_html( $linkedin_profile ) .'" rel="external"><span class="screen-reader-text">' . __( 'View profile on LinkedIn', 'stone' ) . '</span></a>
					</li>'; 
		}
		if($pinterest_profile == ' ') { echo ''; } 
		else {  
			echo '<li class="pinterest">
					<a href="https://www.pinterest.com/'. esc_html( $pinterest_profile ) .'" rel="external"><span class="screen-reader-text">' . __( 'View profile on Pinterest', 'stone' ) . '</span></a>
					</li>'; 
		}
		if($tumblr_profile == ' ') { echo ''; } 
		else {  
			echo '<li class="tumblr">
					<a href="http://'. esc_html( $tumblr_profile ) .'.tumblr.com" rel="external"><span class="screen-reader-text">' . __( 'View profile on Tumblr', 'stone' ) . '</span></a>
					</li>'; 
		}
		if($twitter_profile == ' ') { echo ''; } 
		else {  
			echo '<li class="twitter">
					<a href="https://twitter.com/'. esc_html( $twitter_profile ) .'" rel="external"><span class="screen-reader-text">' . __( 'View profile on Twitter', 'stone' ) . '</span></a>
					</li>'; 
		}
		if($vimeo_profile == ' ') { echo ''; } 
		else {  
			echo '<li class="vimeo">
					<a href="https://vimeo.com/'. esc_html( $vimeo_profile ) .'" rel="external"><span class="screen-reader-text">' . __( 'View profile on Vimeo', 'stone' ) . '</span></a>
					</li>'; 
		}
		if($youtube_profile == ' ') { echo ''; } 
		else {  
			echo '<li class="youtube">
					<a href="https://www.youtube.com/channel/'. esc_html( $youtube_profile ) .'" rel="external"><span class="screen-reader-text">' . __( 'View profile on YouTube', 'stone' ) . '</span></a>
					</li>'; 
		}

		echo '</ul>';
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		
		$instance['codepen_profile'] = strip_tags($new_instance['codepen_profile']);
		$instance['dribbble_profile'] = strip_tags($new_instance['dribbble_profile']);
		$instance['facebook_profile'] = strip_tags($new_instance['facebook_profile']);
		$instance['flickr_profile'] = strip_tags($new_instance['flickr_profile']);
		$instance['github_profile'] = strip_tags($new_instance['github_profile']);
		$instance['googleplus_profile'] = strip_tags($new_instance['googleplus_profile']);
		$instance['instagram_profile'] = strip_tags($new_instance['instagram_profile']);
		$instance['linkedin_profile'] = strip_tags($new_instance['linkedin_profile']);
		$instance['pinterest_profile'] = strip_tags($new_instance['pinterest_profile']);
		$instance['tumblr_profile'] = strip_tags($new_instance['tumblr_profile']);
		$instance['twitter_profile'] = strip_tags($new_instance['twitter_profile']);
		$instance['vimeo_profile'] = strip_tags($new_instance['vimeo_profile']);
		$instance['youtube_profile'] = strip_tags($new_instance['youtube_profile']);
		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args(

		(array) $instance, array(
			'title' => '',

			'codepen_profile' => '',
			'dribbble_profile' => '',
			'facebook_profile' => '',
			'flickr_profile' => '',
			'github_profile' => '',
			'googleplus_profile' => '',
			'instagram_profile' => '',
			'linkedin_profile' => '',
			'pinterest_profile' => '',
			'tumblr_profile' => '',
			'twitter_profile' => '',
			'vimeo_profile' => '',
			'youtube_profile' => '',
		) );

		$title = strip_tags($instance['title']);

		$codepen_profile = strip_tags($instance['codepen_profile']);
		$dribbble_profile = strip_tags($instance['dribbble_profile']);
		$facebook_profile = strip_tags($instance['facebook_profile']);
		$flickr_profile = strip_tags($instance['flickr_profile']);
		$github_profile = strip_tags($instance['github_profile']);
		$googleplus_profile = strip_tags($instance['googleplus_profile']);
		$instagram_profile = strip_tags($instance['instagram_profile']);
		$linkedin_profile = strip_tags($instance['linkedin_profile']);
		$pinterest_profile = strip_tags($instance['pinterest_profile']);
		$tumblr_profile = strip_tags($instance['tumblr_profile']);
		$twitter_profile = strip_tags($instance['twitter_profile']);
		$vimeo_profile = strip_tags($instance['vimeo_profile']);
		$youtube_profile = strip_tags($instance['youtube_profile']);
		
		?><p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'stone' ); ?> <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p><p><label for="<?php echo $this->get_field_id( 'codepen_profile' ); ?>"><?php _e( 'Codepen username:', 'stone' ); ?> <input class="widefat" id="<?php echo $this->get_field_id( 'codepen_profile' ); ?>" name="<?php echo $this->get_field_name( 'codepen_profile' ); ?>" type="text" value="<?php echo esc_attr($codepen_profile); ?>" /></label></p><p><label for="<?php echo $this->get_field_id( 'dribbble_profile' ); ?>"><?php _e( 'Dribbble username:', 'stone' ); ?> <input class="widefat" id="<?php echo $this->get_field_id( 'dribbble_profile' ); ?>" name="<?php echo $this->get_field_name( 'dribbble_profile' ); ?>" type="text" value="<?php echo esc_attr($dribbble_profile); ?>" /></label></p><p><label for="<?php echo $this->get_field_id( 'facebook_profile' ); ?>"><?php _e( 'Facebook username:', 'stone' ); ?> <input class="widefat" id="<?php echo $this->get_field_id( 'facebook_profile' ); ?>" name="<?php echo $this->get_field_name( 'facebook_profile' ); ?>" type="text" value="<?php echo esc_attr($facebook_profile); ?>" /></label></p><p><label for="<?php echo $this->get_field_id( 'flickr_profile' ); ?>"><?php _e( 'Flickr username:', 'stone' ); ?> <input class="widefat" id="<?php echo $this->get_field_id( 'flickr_profile' ); ?>" name="<?php echo $this->get_field_name( 'flickr_profile' ); ?>" type="text" value="<?php echo esc_attr($flickr_profile); ?>" /></label></p><p><label for="<?php echo $this->get_field_id( 'github_profile' ); ?>"><?php _e( 'GitHub username:', 'stone' ); ?> <input class="widefat" id="<?php echo $this->get_field_id( 'github_profile' ); ?>" name="<?php echo $this->get_field_name( 'github_profile' ); ?>" type="text" value="<?php echo esc_attr($github_profile); ?>" /></label></p><p><label for="<?php echo $this->get_field_id( 'googleplus_profile' ); ?>"><?php _e( 'Google+ profile name (no need to include the + at the start):', 'stone' ); ?> <input class="widefat" id="<?php echo $this->get_field_id( 'googleplus_profile' ); ?>" name="<?php echo $this->get_field_name( 'googleplus_profile' ); ?>" type="text" value="<?php echo esc_attr($googleplus_profile); ?>" /></label></p><p><label for="<?php echo $this->get_field_id( 'instagram_profile' ); ?>"><?php _e( 'Instagram username:', 'stone' ); ?> <input class="widefat" id="<?php echo $this->get_field_id( 'instagram_profile' ); ?>" name="<?php echo $this->get_field_name( 'instagram_profile' ); ?>" type="text" value="<?php echo esc_attr($instagram_profile); ?>" /></label></p><p><label for="<?php echo $this->get_field_id( 'linkedin_profile' ); ?>"><?php _e( 'LinkedIn username:', 'stone' ); ?> <input class="widefat" id="<?php echo $this->get_field_id( 'linkedin_profile' ); ?>" name="<?php echo $this->get_field_name( 'linkedin_profile' ); ?>" type="text" value="<?php echo esc_attr($linkedin_profile); ?>" /></label></p><p><label for="<?php echo $this->get_field_id( 'pinterest_profile' ); ?>"><?php _e( 'Pinterest username:', 'stone' ); ?> <input class="widefat" id="<?php echo $this->get_field_id( 'pinterest_profile' ); ?>" name="<?php echo $this->get_field_name( 'pinterest_profile' ); ?>" type="text" value="<?php echo esc_attr($pinterest_profile); ?>" /></label></p><p><label for="<?php echo $this->get_field_id( 'tumblr_profile' ); ?>"><?php _e( 'Tumblr username:', 'stone' ); ?> <input class="widefat" id="<?php echo $this->get_field_id( 'tumblr_profile' ); ?>" name="<?php echo $this->get_field_name( 'tumblr_profile' ); ?>" type="text" value="<?php echo esc_attr($tumblr_profile); ?>" /></label></p><p><label for="<?php echo $this->get_field_id( 'twitter_profile' ); ?>"><?php _e( 'Twitter username:', 'stone' ); ?> <input class="widefat" id="<?php echo $this->get_field_id( 'twitter_profile' ); ?>" name="<?php echo $this->get_field_name( 'twitter_profile' ); ?>" type="text" value="<?php echo esc_attr($twitter_profile); ?>" /></label></p><p><label for="<?php echo $this->get_field_id( 'vimeo_profile' ); ?>"><?php _e( 'Vimeo username:', 'stone' ); ?> <input class="widefat" id="<?php echo $this->get_field_id( 'vimeo_profile' ); ?>" name="<?php echo $this->get_field_name( 'vimeo_profile' ); ?>" type="text" value="<?php echo esc_attr($vimeo_profile); ?>" /></label></p><p><label for="<?php echo $this->get_field_id( 'youtube_profile' ); ?>"><?php _e( 'YouTube channel ID:', 'stone' ); ?> <input class="widefat" id="<?php echo $this->get_field_id( 'youtube_profile' ); ?>" name="<?php echo $this->get_field_name( 'youtube_profile' ); ?>" type="text" value="<?php echo esc_attr($youtube_profile); ?>" /></label></p><?php
	}
}

// register stone SocialLinksMenu Widget
add_action( 'widgets_init', create_function( '', 'return register_widget("stone_SocialLinksMenu_Widget");' ) );
?>