<?php
/**
 * Post List Widget
 *
 * @package hoot
 * @subpackage dispatch
 * @since dispatch 1.0
 */

/**
* Class Hoot_Post_List_Widget
*/
class Hoot_Post_List_Widget extends Hoot_WP_Widget {

	function __construct() {

		$settings['id'] = 'hoot-post-list-widget';
		$settings['name'] = __( 'Hoot > Post List', 'dispatch-premium' );
		$settings['widget_options'] = array(
			'description'	=> __('Display Blog Post List (all or specific category).', 'dispatch-premium'),
			// 'classname'		=> 'hoot-post-list-widget', // CSS class applied to frontend widget container via 'before_widget' arg
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
				'name'		=> __( 'Category', 'dispatch-premium' ),
				'desc'		=> __( 'Leave empty to display posts from all categories.', 'dispatch-premium' ),
				'id'		=> 'category',
				'type'		=> 'select',
				'options'	=> array( '0' => '' ) + Hoot_WP_Widget::get_tax_list('category') ,
			),
			array(
				'name'		=> __( 'Number of Posts to show', 'dispatch-premium' ),
				'desc'		=> __( 'Default: 3', 'dispatch-premium' ),
				'id'		=> 'count',
				'type'		=> 'text',
				'settings'	=> array( 'size' => 3, ),
				'sanitize'	=> 'absint',
			),
			array(
				'name'		=> __( 'Hide Thumbnails', 'dispatch-premium' ),
				'id'		=> 'hide_thumbnails',
				'type'		=> 'checkbox',
			),
			array(
				'name'		=> __( 'Hide Post Date', 'dispatch-premium' ),
				'id'		=> 'hide_date',
				'type'		=> 'checkbox',
			),
			array(
				'name'		=> __( 'Hide number of comments', 'dispatch-premium' ),
				'id'		=> 'hide_comments',
				'type'		=> 'checkbox',
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

		$settings = apply_filters( 'hoot_post_list_widget_settings', $settings );

		parent::__construct( $settings['id'], $settings['name'], $settings['widget_options'], $settings['control_options'], $settings['form_options'] );

	}

	/**
	 * Echo the widget content
	 */
	function display_widget( $instance, $before_title = '', $title='', $after_title = '' ) {
		extract( $instance, EXTR_SKIP );
		include( hoot_locate_widget( 'post-list' ) ); // Loads the widget/post-list or template-parts/widget-post-list.php template.
	}

}

/**
 * Register Widget
 */
function hoot_post_list_widget_register(){
	register_widget('Hoot_Post_List_Widget');
}
add_action('widgets_init', 'hoot_post_list_widget_register');