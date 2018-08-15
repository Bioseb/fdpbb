<?php
/**
 * Hoot Customizer framework is an extended version of the
 * Customizer Library v1.3.0, Copyright 2010 - 2014, WP Theming http://wptheming.com
 * and is licensed under GPLv2
 *
 * This file is loaded at 'after_setup_theme' hook with 5 priority.
 *
 * @package hoot
 * @subpackage hoot-customizer
 * @since hoot 2.0.0
 */

/** Include Hoot Customizer files **/
// require_once trailingslashit( HOOT_PREMIUM_DIR ) . 'customizer/functions.php';

/** Include custom controls **/
foreach ( glob( trailingslashit( HOOT_PREMIUM_DIR ) . 'customizer/control-*.php' ) as $file_path ) {
	include_once( $file_path );
}

/**
 * Enqueue scripts to customizer screen
 *
 * @since 2.0.0
 * @return void
 */
function hoot_premium_customize_enqueue_scripts() {

	wp_enqueue_style( 'hoot-premium-customizer-styles', trailingslashit( HOOT_PREMIUM_URI ) . 'customizer/assets/style.css', array(),  HOOT_VERSION );
	wp_enqueue_script( 'hoot-premium-customizer-script', trailingslashit( HOOT_PREMIUM_URI ) . 'customizer/assets/script.js', array( 'jquery', 'wp-color-picker', 'customize-controls' ), HOOT_VERSION, true );

}
// Load scripts at priority 11 so that Hoot Customizer Custom Controls have loaded their scripts
add_action( 'customize_controls_enqueue_scripts', 'hoot_premium_customize_enqueue_scripts', 11 );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @since 2.0.0
 * @return void
 */
function hoot_premium_customizer_customize_preview_js() {

	if ( file_exists( trailingslashit( HOOT_PREMIUM_THEMEDIR ) . 'admin/js/customizer-preview.js' ) )
		wp_enqueue_script( 'hoot_premium_customizer_preview', trailingslashit( HOOT_PREMIUM_THEMEURI ) . 'admin/js/customizer-preview.js', array( 'customize-preview' ), HOOT_VERSION, true );

}
add_action( 'customize_preview_init', 'hoot_premium_customizer_customize_preview_js' );