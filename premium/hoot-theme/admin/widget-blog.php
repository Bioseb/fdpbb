<?php
/**
 * Blog Widget
 *
 * @package hoot
 * @subpackage dispatch
 * @since dispatch 1.0
 */

/**
* Class Hoot_Blog_Widget
*/
class Hoot_Blog_Widget extends Hoot_WP_Widget {

	function __construct() {

		$settings['id'] = 'hoot-blog-widget';
		$settings['name'] = __( 'Hoot > Blog Posts', 'dispatch-premium' );
		$settings['widget_options'] = array(
			'description'	=> __('Display Blog (typically used in Widgetized Template Areas to display Blog Posts)', 'dispatch-premium'),
			//'help'			=> __('The sidebar layout will be same as you set it in Customizer &gt; Setup &amp; Layout &gt; Sidebar Layout for Blog', 'dispatch-premium'),
			// 'classname'		=> 'hoot-blog-widget', // CSS class applied to frontend widget container via 'before_widget' arg
		);
		$settings['control_options'] = array();
		$settings['form_options'] = array(
			//'name' => can be empty or false to hide the name
			array(
				'name'		=> __( "Title (optional)", 'dispatch-premium' ),
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
			// array(
			// 	'name'		=> __( 'Display Sidebar', 'dispatch-premium' ),
			// 	'desc'		=> __('Sidebar layout can be set in Customizer &gt; Setup &amp; Layout &gt; Sidebar Layout for Blog', 'dispatch-premium'),
			// 	'id'		=> 'sidebar',
			// 	'type'		=> 'checkbox',
			// ),
			// Deprecated for proper pagination, now undeprecated
			array(
				'name'		=> __( 'Number of Posts to show', 'dispatch-premium' ),
				'desc'		=> __( 'Default: 3', 'dispatch-premium' ),
				'id'		=> 'count',
				'type'		=> 'text',
				'sanitize'	=> 'absint',
			),
			array(
				'name'		=> __( 'Custom Content After Widget', 'dispatch-premium' ),
				'id'		=> 'post_content',
				'type'		=> 'textarea',
				'settings'	=> array( 'rows' => 3 ),
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

		$settings = apply_filters( 'hoot_blog_widget_settings', $settings );

		parent::__construct( $settings['id'], $settings['name'], $settings['widget_options'], $settings['control_options'], $settings['form_options'] );

	}

	/**
	 * Echo the widget content
	 */
	function display_widget( $instance, $before_title = '', $title='', $after_title = '' ) {
		extract( $instance, EXTR_SKIP );
		include( hoot_locate_widget( 'blog' ) ); // Loads the widget/blog or template-parts/widget-blog.php template.
	}

}

/**
 * Register Widget
 */
function hoot_blog_widget_register(){
	register_widget('Hoot_Blog_Widget');
}
add_action('widgets_init', 'hoot_blog_widget_register');