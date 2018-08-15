<?php
/**
 * Contact Info Widget
 *
 * @package hoot
 * @subpackage dispatch
 * @since dispatch 1.0
 */

/**
* Class Hoot_Contact_Info_Widget
*/
class Hoot_Contact_Info_Widget extends Hoot_WP_Widget {

	function __construct() {

		$settings['id'] = 'hoot-contact-info-widget';
		$settings['name'] = __( 'Hoot > Contact Info', 'dispatch-premium' );
		$settings['widget_options'] = array(
			'description'	=> __('Display Contact Information', 'dispatch-premium'),
			// 'classname'		=> 'hoot-contact-info-widget', // CSS class applied to frontend widget container via 'before_widget' arg
		);
		$settings['control_options'] = array();
		$settings['form_options'] = array(
			//'name' => can be empty or false to hide the name
			array(
				'name'		=> __( 'Title', 'dispatch-premium' ),
				'id'		=> 'title',
				'type'		=> 'text',
			),
			array(
				'name'		=> __( 'Address', 'dispatch-premium' ),
				'id'		=> 'address',
				'type'		=> 'textarea',
				'settings'	=> array( 'rows' => 3 ),
			),
			array(
				'name'		=> __( 'Phone', 'dispatch-premium' ),
				'id'		=> 'phone',
				'type'		=> 'text',
			),
			array(
				'name'		=> __( 'Email', 'dispatch-premium' ),
				'id'		=> 'email',
				'type'		=> 'text',
				'sanitize'	=> 'email',
			),
			array(
				'name'		=> __( 'Misc', 'dispatch-premium' ),
				'id'		=> 'profiles',
				'type'		=> 'group',
				'options'	=> array(
					'item_name'	=> __( 'Contact Link', 'dispatch-premium' ),
				),
				'fields'	=> array(
					array(
						'name'		=> __( 'Profile', 'dispatch-premium' ),
						'id'		=> 'icon',
						'type'		=> 'select',
						'options'	=> hoot_enum_social_profiles(),
					),
					array(
						'name'		=> __( 'Display Text', 'dispatch-premium' ),
						'id'		=> 'text',
						'type'		=> 'text',
					),
					array(
						'name'		=> __( 'URL (enter username for Skype, email address for Email)', 'dispatch-premium' ),
						'id'		=> 'url',
						'std'		=> 'http://',
						'type'		=> 'text',
						'sanitize'	=> 'contact_info_sanitize_url',
					),
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

		$settings = apply_filters( 'hoot_contact_info_widget_settings', $settings );

		parent::__construct( $settings['id'], $settings['name'], $settings['widget_options'], $settings['control_options'], $settings['form_options'] );

	}

	/**
	 * Echo the widget content
	 */
	function display_widget( $instance, $before_title = '', $title='', $after_title = '' ) {
		extract( $instance, EXTR_SKIP );
		include( hoot_locate_widget( 'contact-info' ) ); // Loads the widget/contact-info or template-parts/widget-contact-info.php template.
	}

}

/**
 * Register Widget
 */
function hoot_contact_info_widget_register(){
	register_widget('Hoot_Contact_Info_Widget');
}
add_action('widgets_init', 'hoot_contact_info_widget_register');

/**
 * Custom Sanitization Function
 */
function hoot_contact_info_sanitize_url( $value, $name, $instance ){
	if ( $name == 'contact_info_sanitize_url' ) {
		if ( !empty( $instance['icon'] ) && $instance['icon'] == 'fa-skype' )
			$new = sanitize_user( $value, true );
		elseif ( !empty( $instance['icon'] ) && $instance['icon'] == 'fa-envelope' )
			$new = is_email( $value );
		else
			$new = esc_url_raw( $value );
		return $new;
	}
	return $value;
}
add_filter('widget_admin_sanitize_field', 'hoot_contact_info_sanitize_url', 10, 3);