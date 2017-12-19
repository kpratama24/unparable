<?php
/**
 * The Sidebar containing the main widget area
 *
 * @package Stone
 * @since Stone 1.0
 */
?>

<aside id="sidebar-primary" class="sidebar sidebar-primary">

	<div class="widget-wrapper">
		<h2 class="screen-reader-text"><?php _e( 'Widget Area', 'stone' ); ?></h2>
		<?php dynamic_sidebar( 'footer-primary' ); ?>
	</div>
	
</aside><!-- /#sidebar-primary -->

<aside id="sidebar-secondary" class="sidebar sidebar-secondary">

	<div class="widget-wrapper">
		<?php dynamic_sidebar( 'footer-secondary' ); ?>
	</div>

</aside><!-- /#sidebar-secondary -->