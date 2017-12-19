<?php
/**
 * stone back compat functionality
 *
 * Prevents stone from running on WordPress versions prior to 3.6,
 * since this theme is not meant to be backward compatible beyond that
 * and relies on many newer functions and markup changes introduced in 3.6.
 *
 * @package Stone
 * @since Stone 1.0
 */

/**
 * ------------------------------------------------------------------------------------------------- 
 * Prevent switching to stone on old versions of WordPress.
 *
 * Switches to the default theme.
 *
 * @since Stone 1.0
 * -------------------------------------------------------------------------------------------------
 */

function stone_switch_theme() {
	switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'stone_upgrade_notice' );
}
add_action( 'after_switch_theme', 'stone_switch_theme' );

/**
 * ------------------------------------------------------------------------------------------------- 
 * Add message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * stone on WordPress versions prior to 3.6.
 *
 * @since Stone 1.0
 * -------------------------------------------------------------------------------------------------
 */

function stone_upgrade_notice() {
	$message = sprintf( __( 'Stone requires at least WordPress version 3.6. You are running version %s. Please upgrade and try again.', 'stone' ), $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );
}

/**
 * ------------------------------------------------------------------------------------------------- 
 * Prevent the Customizer from being loaded on WordPress versions prior to 3.6.
 *
 * @since Stone 1.0
 * -------------------------------------------------------------------------------------------------
 */

function stone_customize() {
	wp_die( sprintf( __( 'Stone requires at least WordPress version 3.6. You are running version %s. Please upgrade and try again.', 'stone' ), $GLOBALS['wp_version'] ), '', array(
		'back_link' => true,
	) );
}
add_action( 'load-customize.php', 'stone_customize' );

/**
 * ------------------------------------------------------------------------------------------------- 
 * Prevent the Theme Preview from being loaded on WordPress versions prior to 3.4.
 *
 * @since Stone 1.0
 * -------------------------------------------------------------------------------------------------
 */

function stone_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( __( 'Stone requires at least WordPress version 3.6. You are running version %s. Please upgrade and try again.', 'stone' ), $GLOBALS['wp_version'] ) );
	}
}
add_action( 'template_redirect', 'stone_preview' );
?>