<?php
/**
 * Theme Shortcodes
 * Hook into framework's core shortcodes and add/disable available shortcodes for this theme.
 *
 * @package hoot
 * @subpackage dispatch
 * @since dispatch 1.0
 */

/* Modify shortcode styles */
add_filter( 'hoot_shortcode_styles', 'hoot_theme_shortcodes_styles' );

/**
 * Add Theme Styles to shortcode styles
 *
 * @since 1.0
 * @access public
 * @param array $styles.
 * @return array
 */
function hoot_theme_shortcodes_styles( $styles ) {
	$theme_styles = array(
						'accent'  => __('Theme Accent Color', 'dispatch-premium'),
					);
	return hoot_array_insert( $theme_styles, $styles, 1 );
}

/* Modify core available shortcodes */
add_filter( 'hoot_shortcodes', 'hoot_theme_shortcodes' );

/**
 * Add Theme specific shortcodes, and disable any core shortcode not supported by this theme.
 * $shortcodes contains shortcode arrays with $key => $settings values
 *     Keys should be unique as they will be used as shortcode names.
 *     Example: [unique_key]Lorem Ipsum...[/unique_key]
 *     Settings are used in backend to create shortcode generator. Options arrays are for options used
 *     in Hoot Options Framework
 *
 * @since 1.0
 * @access public
 * @param array $shortcodes.
 * @return array
 */
function hoot_theme_shortcodes( $shortcodes ) {

	$insert = array(

		'hoot_content_block_row' => array(
			'title' => __( 'Content Blocks', 'dispatch-premium' ),
			'type' => 'shortcode',
			'options' => array(
				array(
					'name' => '',
					'desc' => sprintf( __("This shortcode displays content blocks similar to the %s'Hoot > Content Blocks'%s Widget.", 'dispatch-premium'), '<a href="' . esc_url( admin_url('widgets.p') ) . '" target="_blank">', '</a>' ),
					'type' => 'info', ),
				array(
					'name' => __('Display Type', 'dispatch-premium'),
					'id' => 'style',
					'type' => 'images',
					'std' => 'style1',
					'options' => array(
						'style1' => trailingslashit( HOOT_THEMEURI ) . 'admin/images/content-block-style-1.png',
						'style2' => trailingslashit( HOOT_THEMEURI ) . 'admin/images/content-block-style-2.png',
						'style3' => trailingslashit( HOOT_THEMEURI ) . 'admin/images/content-block-style-3.png',
						'style4' => trailingslashit( HOOT_THEMEURI ) . 'admin/images/content-block-style-4.png', ), ),
				array(
					'name' => __( 'No. Of Columns', 'dispatch-premium' ),
					'id' => 'columns',
					'type' => 'select',
					'std' => '3',
					'options' => array(
						'1' => __( '1', 'dispatch-premium' ),
						'2' => __( '2', 'dispatch-premium' ),
						'3' => __( '3', 'dispatch-premium' ),
						'4' => __( '4', 'dispatch-premium' ),
						'5' => __( '5', 'dispatch-premium' ), ), ),
				array(
					'name' => __( 'Icon Style', 'dispatch-premium' ),
					'id' => 'icon',
					'type' => 'select',
					'std' => 'circle',
					'options' => array(
						'' => '',
						'circle' => __( 'Circle', 'dispatch-premium' ),
						'square' => __( 'Square', 'dispatch-premium' ),
					),
				),
				array(
					'name' => __('Content Blocks', 'dispatch-premium'),
					'id' => 'hoot_content_block',
					'type' => 'group',
					'settings' => array(
						'title' => __('Content Block', 'dispatch-premium'),
						'add_button' => __('Add Another Block', 'dispatch-premium'),
						'remove_button' => __('Remove Block', 'dispatch-premium'),
						'repeatable' => true,    // Default false
						'sortable' => true,     // Default false
						'toggleview' => true, ), // Default true
					'fields' => array(
						array(
							'name' => __('Choose Icon', 'dispatch-premium'),
							'id' => 'icon',
							'type' => 'icon'),
						array(
							'name' => __('Image', 'dispatch-premium'),
							'desc' => __('Leave empty if you want to use the icon selected above.', 'dispatch-premium'),
							'id' => 'image',
							'type' => 'upload'),
						array(
							'name' => __('Title', 'dispatch-premium'),
							'id' => 'title',
							'type' => 'text'),
						array(
							'name' => __('Content', 'dispatch-premium'),
							'id' => 'content',
							'type' => 'textarea',
							'settings' => array( 'rows' => 3 ), ),
						), ),
			),
		),

		'hoot_content_block' => array(
			'type' => 'internal',
		),

	);

	return hoot_array_insert( $insert, $shortcodes, 'hoot_code' );

}