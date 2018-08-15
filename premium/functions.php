<?php
/**
 * Hoot Premium Extension hooked into the theme and framework
 * This file is loaded at the beginning of launching core framework
 *
 * @package hoot
 * @subpackage dispatch
 * @since dispatch 2.0
 */

/**
 * Setup Hoot Premium Framework
 *
 * @since 2.0
 * @return void
 */
function hoot_premium_framework() {

	global $hoot_premium_class;

	/* Load the Core framework */
	require_once( $GLOBALS['hoot_base_dir'] . 'premium/hoot/hoot-premium.php' );

	/* Launch the Core framework. */
	$hoot_premium_class = new Hoot_Premium();

}
add_action( 'hoot_after_setup', 'hoot_premium_framework' );

/**
 * Setup Hoot Premium Theme Class
 *
 * @since 2.0
 * @return void
 */
function hoot_premium_theme() {

	global $hoot_premium_theme_class;

	/* Load the Theme files */
	require_once( $GLOBALS['hoot_base_dir'] . 'premium/hoot-theme/hoot-premium-theme.php' );

	/* Launch the Theme Premium */
	$hoot_premium_theme_class = new Hoot_Premium_Theme();

}
add_action( 'hoot_theme_after_setup', 'hoot_premium_theme' );





/**
 * FIX: hoot_get_mod (get_theme_mod) does not give live value (in customizer screen)
 * when used before 'wp_loaded' action @priority 10
 *
 * Currently customizer-options adds conditional options based on theme support for
 * 'hoot-scrollpoints' and 'hoot-waypoints' features
 * 
 * We cannot add following hook functions inside customizer-options.php as that file
 * itself is loaded on 'after_setup_theme' hook. (hooking into same hook from within
 * while hook is being executed leads to undesirable effects as
 * GLOBALS[$wp_filter]['after_setup_theme'] has already been ksorted)
 *
 * @todo: find a better home for these functions, and/or find a better logic to display
 * options (based on support for a feature) in customizer-options.php
 */

/* is_customize_preview() can be used since WordPress 4.0, else use global $wp_customize; */
global $wp_customize;
if ( ( function_exists( 'is_customize_preview' ) && is_customize_preview() ) || isset( $wp_customize ) ) :

	// Hence we remove hoot-scrollpoints and hoot-waypoints theme support (added at after_setup_theme
	// @priority 10) so scroller.php is not loaded by hoot framework (at after_setup_theme
	// @priority 14).
	add_action( 'after_setup_theme', 'hoot_customizer_fix_remove_support', 12 );

	// Re-add theme support for hoot-scrollpoints and hoot-waypoints (after_setup_theme @priority 14),
	// so customizer settings array (added at init hook @priority 0) generates related options.
	add_action( 'after_setup_theme', 'hoot_customizer_fix_add_support', 16 );

	// Load the scroller.php file at wp hook (after wp_loaded @priority 10) to init the class
	// if get_theme_mod() allows it
	add_action( 'wp', 'hoot_customizer_fix_load_extension' );

endif;
/** Remove Scroller Support **/
function hoot_customizer_fix_remove_support(){
	remove_theme_support( 'hoot-scrollpoints' );
	remove_theme_support( 'hoot-waypoints' );
}
/** Add Scroller Support **/
function hoot_customizer_fix_add_support(){
	add_theme_support( 'hoot-scrollpoints', array( 'goto-top', 'menu-scroll' ) );
	add_theme_support( 'hoot-waypoints', array( 'goto-top', 'sticky-header', 'circliful' ) );
}
/** Load Scroller **/
function hoot_customizer_fix_load_extension(){
	if ( current_theme_supports( 'hoot-scrollpoints' ) || current_theme_supports( 'hoot-waypoints' ) )
		require( trailingslashit( HOOT_PREMIUM_EXTENSIONS ) . 'scroller.php' );
}
