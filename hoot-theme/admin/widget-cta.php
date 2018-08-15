<?php
/**
 * Call To Action Widget
 *
 * @package hoot
 * @subpackage dispatch
 * @since dispatch 1.0
 */

/**
* Class Hoot_CTA_Widget
*/
class Hoot_CTA_Widget extends Hoot_WP_Widget {

	function __construct() {

		$settings['id'] = 'hoot-cta-widget';
		$settings['name'] = __( 'Hoot > Call To Action', 'dispatch-premium' );
		$settings['widget_options'] = array(
			'description'	=> __('Display Call To Action block.', 'dispatch-premium'),
			// 'classname'		=> 'hoot-cta-widget', // CSS class applied to frontend widget container via 'before_widget' arg
		);
		$settings['control_options'] = array();
		$settings['form_options'] = array(
			//'name' => can be empty or false to hide the name
			array(
				'name'		=> __( 'Headline', 'dispatch-premium' ),
				'id'		=> 'headline',
				'type'		=> 'text',
			),
			array(
				'name'		=> __( 'Description', 'dispatch-premium' ),
				'id'		=> 'description',
				'type'		=> 'textarea',
			),
			array(
				'name'		=> __( 'Button Text', 'dispatch-premium' ),
				'id'		=> 'button_text',
				'type'		=> 'text',
				'std'		=> __( 'KNOW MORE', 'dispatch-premium' ),
			),
			array(
				'name'		=> __( 'Button URL', 'dispatch-premium' ),
				'desc'		=> __( 'Leave empty if you dont want to show button', 'dispatch-premium' ),
				'id'		=> 'url',
				'type'		=> 'text',
				'sanitize'	=> 'url',
			),
			array(
				'name'		=> __( 'Border', 'dispatch-premium' ),
				'desc'		=> __( 'Top and bottom borders.', 'dispatch-premium' ),
				'id'		=> 'border',
				'type'		=> 'select',
				'std'		=> 'none none',
				'options'	=> array(
					'line line'	=> __( 'Top - Line || Bottom - Line', 'dispatch-premium' ),
					'line shadow'	=> __( 'Top - Line || Bottom - StrongDash', 'dispatch-premium' ),
					'line none'	=> __( 'Top - Line || Bottom - None', 'dispatch-premium' ),
					'shadow line'	=> __( 'Top - StrongDash || Bottom - Line', 'dispatch-premium' ),
					'shadow shadow'	=> __( 'Top - StrongDash || Bottom - StrongDash', 'dispatch-premium' ),
					'shadow none'	=> __( 'Top - StrongDash || Bottom - None', 'dispatch-premium' ),
					'none line'	=> __( 'Top - None || Bottom - Line', 'dispatch-premium' ),
					'none shadow'	=> __( 'Top - None || Bottom - StrongDash', 'dispatch-premium' ),
					'none none'	=> __( 'Top - None || Bottom - None', 'dispatch-premium' ),
				),
			),
			array(
				'name'		=> __( 'Widget CSS', 'dispatch-premium' ),
				'id'		=> 'customcss',
				'type'		=> 'collapse',
				'fields'	=> array(
					array(
						'name'		=> __( 'Custom CSS Class', 'dispatch-premium' ),
						'desc'		=> __( 'Give this widget a custom css classname', 'dispatch-premium' ),
						'id'		=> 'class',
						'type'		=> 'text',
					),
					array(
						'name'		=> __( 'Margin Top', 'dispatch-premium' ),
						'desc'		=> __( '(in pixels) Leave empty to load default margins', 'dispatch-premium' ),
						'id'		=> 'mt',
						'type'		=> 'text',
						'settings'	=> array( 'size' => 3 ),
						'sanitize'	=> 'integer',
					),
					array(
						'name'		=> __( 'Margin Bottom', 'dispatch-premium' ),
						'desc'		=> __( '(in pixels) Leave empty to load default margins', 'dispatch-premium' ),
						'id'		=> 'mb',
						'type'		=> 'text',
						'settings'	=> array( 'size' => 3 ),
						'sanitize'	=> 'integer',
					),
					array(
						'name'		=> __( 'Widget ID', 'dispatch-premium' ),
						'id'		=> 'widgetid',
						'type'		=> '<span class="widgetid" data-baseid="' . $settings['id'] . '">' . __( 'Save this widget to view its ID', 'dispatch-premium' ) . '</span>',
					),
				),
			),
		);

		$settings = apply_filters( 'hoot_cta_widget_settings', $settings );

		parent::__construct( $settings['id'], $settings['name'], $settings['widget_options'], $settings['control_options'], $settings['form_options'] );

	}

	/**
	 * Echo the widget content
	 */
	function display_widget( $instance, $before_title = '', $title='', $after_title = '' ) {
		extract( $instance, EXTR_SKIP );
		include( hoot_locate_widget( 'cta' ) ); // Loads the widget/cta or template-parts/widget-cta.php template.
	}

}

/**
 * Register Widget
 */
function hoot_cta_widget_register(){
	register_widget('Hoot_CTA_Widget');
}
add_action('widgets_init', 'hoot_cta_widget_register');