<?php
/**
 * Build Megamenu Options
 *
 * @package hoot
 * @subpackage framework
 * @since hoot 1.0
 */

/**
 * Defines an array of megamenu options that will be used to generate the megamenu.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * Child themes can modify the megamenu options array using the 'hoot_theme_megamenu_options' filter hook.
 *
 * @since 1.0
 * @param object $hoot_megamenu
 * @return void
 */
function hoot_megamenu_options( $hoot_megamenu ) {

	$options = array();

	/* Add supported options */
	// Keys must be small caps with no spaces (used as css ids, and as meta key stored in database)
	if ( hoot_theme_supports( 'hoot-megamenu', 'menuitem_icon' ) ) {
		$options[ 'hoot_icon' ] = array(
			'name' => __('Icon', 'dispatch-premium'),
			'type' => 'icon',
			//'top_level' => true,
			);
	}

	// Add megamenu options to main class options object
	$hoot_megamenu->add_options( $options );

}

/* Hook into action to add options */
add_action( 'hoot_megamenu_loaded', 'hoot_megamenu_options', 5, 1 );