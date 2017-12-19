<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #wrapper div elements.
 *
 * @package Stone
 * @since Stone 1.0
 */
?>

	<footer id="colophon" class="site-info" role="contentinfo">

		<div class="colophon-credits">
			<p><?php _e( 'Copyright', 'stone' ); ?> &copy; <?php echo date("Y"); ?> <?php bloginfo( 'name' ); ?>.</p>
			<p><?php printf( __( 'Proudly powered by', 'stone' ) ); ?> <a href="<?php echo esc_url( 'http://wordpress.org/', 'stone' ); ?>">WordPress</a>.</p>
			<?php do_action( 'stone_credits' ); ?>
		</div>
		
		<?php
		/* 
		If a Footer menu has not been set the Top main menu is repeated, but only top level pages.
		If no Top main menu is set, nothing is shown (that's what fallback_cb: false does). 
		*/
		if ( is_nav_menu( 'footer-navigation' ) ) :
			wp_nav_menu( array(
				'theme_location'=> 'footer-navigation',
				'depth' => 1,
				'container' => 'div', 
				'container_class' => 'colophon-menu', 
			) );
		else : 
			wp_nav_menu( array(
				'theme_location'=> 'main-navigation',
				'fallback_cb' => false,
				'depth' => 1,
				'container' => 'div', 
				'container_class' => 'colophon-menu', 
			) );
		endif;
		?> 

	</footer><!-- #site-info -->

</div><!-- #wrapper <?php /* opened in header.php */ ?> -->

<?php wp_footer(); ?>

</body>
</html>