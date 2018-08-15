<?php
/**
 * Hoot Shortcodes Helper Functions
 *
 * @package hoot
 * @subpackage framework
 * @since hoot 1.1.1
 */

/**
 * Return Array of Common Style Names for various shortcodes
 * 
 * @since 1.1.1
 * @access public
 * @param string $filtered apply filters or return original
 * @return array
 */
function hoot_shortcode_styles( $filtered = true ) {

	$styles = array(
		''       => '',
		'white'  => __('White', 'dispatch-premium'),
		'black'  => __('Black', 'dispatch-premium'),
		'brown'  => __('Brown', 'dispatch-premium'),
		'blue'   => __('Blue', 'dispatch-premium'),
		'cyan'   => __('Cyan', 'dispatch-premium'),
		'green'  => __('Green', 'dispatch-premium'),
		'yellow' => __('Yellow', 'dispatch-premium'),
		'amber'  => __('Amber', 'dispatch-premium'),
		'orange' => __('Orange', 'dispatch-premium'),
		'red'    => __('Red', 'dispatch-premium'),
		'pink'   => __('Pink', 'dispatch-premium'),
		);

	if ( $filtered )
		$styles = apply_filters( 'hoot_shortcode_styles', $styles );

	return $styles;

}

/**
 * Return attribute string
 * 
 * @since 1.1.1
 * @access public
 * @param string $action
 * @param string $input
 * @return string
 */
function hoot_sc_attr( $action, $input ) {
	if ( empty( $input ) )
		return;
	switch ( $action ) {
		case 'style':
			return ' style="' . esc_attr( $input ) . '" ';
			break;
		case 'class':
			return ' class="' . esc_attr( $input ) . '" ';
			break;
		case 'target':
			if ( $input == 'blank' )
			return ' target="_blank" ';
			break;
	}
}

/**
 * Return sizes array
 * 
 * @since 1.1.1
 * @access public
 * @param mixed $start
 * @param mixed $end
 * @param string $pre
 * @param string $post
 * @return array
 */
function hoot_sc_range( $start=9, $end=82, $pre='', $post='' ) {
	$range = range( $start, $end );
	$output = array();
	foreach ( $range as $unit ) {
		$output[ $unit ] = $pre . $unit . $post;
	}
	return $output;
}