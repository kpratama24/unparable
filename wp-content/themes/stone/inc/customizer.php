<?php
/**
 * stone Customizer support
 *
 * @package WordPress
 * @subpackage stone
 * @since Stone 1.0
 */

/**
 * ------------------------------------------------------------------------------------------------- 
 * Implement Customizer additions and adjustments.
 *
 * @since Stone 1.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 * -------------------------------------------------------------------------------------------------
 */

function stone_customize_register( $wp_customize ) {
	// Add postMessage support for site title and description.
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	// Rename the label to "Site Title Color" because this only affects the site title in this theme.
	$wp_customize->get_control( 'header_textcolor' )->label = __( 'Site Title Color', 'stone' );


	// Custom Colors.
	$wp_customize->add_setting( 'link_color' , array(
    	'default'     => '#88b47f',
		'transport'   => 'refresh',
		'sanitize_callback'	=> 'sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'special_color', array(
		'label'        => __( 'Link Color', 'stone' ),
		'section'    => 'colors',
		'settings'   => 'link_color',
	) ) );



}
add_action( 'customize_register', 'stone_customize_register' );

/**
 * ------------------------------------------------------------------------------------------------- 
 * Bind JS handlers to make Customizer preview reload changes asynchronously.
 *
 * @since Stone 1.0
 * -------------------------------------------------------------------------------------------------
 */

function stone_customize_preview_js() {
	wp_enqueue_script( 'stone_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20131205', true );
}
add_action( 'customize_preview_init', 'stone_customize_preview_js' );
?>