<?php
/**
 * Custom Taxonomies array for the theme.
 *
 * @package hoot
 * @subpackage dispatch
 * @since dispatch 1.0
 */

/**
 * Defines an array of taxonomies settings that will be used to register Custom taxonomies
 * When creating the 'id' fields, make sure to use all lowercase and no spaces. ID can be max.
 * 32 characters
 *
 * Child themes can modify the taxonomies array using the 'hoot_theme_taxonomies' filter hook.
 *
 * @since 1.0
 * @param object $hoot_taxonomies
 * @return void
 */
function hoot_taxonomies( $hoot_taxonomies ) {

	$options = array();

	/*$options['hoot_slider_group'] = array(
		'object_type' => 'hoot_slider',
		'args' => array(
			'labels'	=> array(
				'name'				=> __( 'Slide Sets', 'dispatch-premium' ),
				'singular_name'		=> __( 'Slide Set', 'dispatch-premium' ),
				),
			'public'			=> false,
			'show_ui'			=> true,
			'hierarchical'		=> true,
			),
		);*/

	// Add taxonomy options to main class options object
	$hoot_taxonomies->add_options( $options );

}

/* Hook into action to add options */
add_action( 'hoot_taxonomies_loaded', 'hoot_taxonomies', 5, 1 );