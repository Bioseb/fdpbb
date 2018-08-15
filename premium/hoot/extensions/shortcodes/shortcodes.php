<?php
/**
 * List of core shortcodes and their settings.
 * * Themes can modify this array (add/unset) using the 'hoot_shortcodes' filter available in
 *   'hoot/extensions/shortcodes/init.php'. The preferred location for this is in the
 *   'hoot-theme/admin/shortcodes.php' file which is included automatically if available.
 * * Themes can override display templates of core shortcodes by adding {key}.php file in the
 *   'hoot-theme/shortcodes' directory of the theme folder
 * 
 * Hence, for a theme to add a new shortcode:
 * 1. In the 'hoot-theme/admin/shortcodes.php' hook into 'hoot_shortcodes' filter to add the new
 *    shortcode key and its settings to this array. This will add the shortcode to the Shortcode
 *    generator.
 * 2. Add the display template in the 'hoot-theme/shortcodes' directory . Name this template file
 *    as {key}.php where {key} is the name of the shortcode.
 *
 * @package hoot
 * @subpackage framework
 * @since hoot 1.1.0
 */

/**
 * Array with $key => $settings values
 * Keys should be unique as they will be used as shortcode names.
 *   Example: [unique_key]Lorem Ipsum...[/unique_key]
 * Settings are used in backend to create shortcode generator. Options arrays are for options used
 * in Hoot Options Framework
 *
 * Any field with 'id' set to 'content' will be used for the Shortcode content. This will make the
 * shortcode a closing shortcode (i.e. it will have a [/name] tag at the end). Ofcourse, for each
 * shortcode, there should only be 1 content id.
 * Rest of the fields will be used as attributes (unless 'hide_as_attribute' is set to (bool) true
 * for the field)
 *
 * Attributes do not support groups, but main content can be a group.
 */

return array(

	'title_content' => array(
		'title' => __( 'Content', 'dispatch-premium' ),
		'type' => 'title',
	),

	'hoot_list' => array(
		'title' => __( 'Icon Lists', 'dispatch-premium' ),
		'type' => 'shortcode',
		'options' => array(
			array(
				'name' => __( 'Choose Icon', 'dispatch-premium' ),
				'id' => 'icon',
				'type' => 'icon' ),
			array(
				'name' => __( 'List Items', 'dispatch-premium' ),
				'id' => 'hoot_li',
				'type' => 'group',
				'settings' => array(
					//'title' => __( 'List Item', 'dispatch-premium' ),
					'add_button' => __( 'Add Another List Item', 'dispatch-premium' ),
					'remove_button' => __( 'Remove List Item', 'dispatch-premium' ),
					'repeatable' => true,    // Default false
					'sortable' => false,     // Default false
					'toggleview' => false, ), // Default true
				'fields' => array(
					array(
						//'name' => __( 'List Item', 'dispatch-premium' ),
						'id' => 'content',
						'type' => 'text' ),
					), ),
		),
	),

	'hoot_li' => array(
		'type' => 'internal',
	),

	'hoot_box' => array(
		'title' => __( 'Notice Box', 'dispatch-premium' ),
		'type' => 'shortcode',
		'options' => array(
			array(
				'name' => __( 'Box Text', 'dispatch-premium' ),
				'id' => 'content',
				'type' => 'textarea',
				),
			array(
				'name' => __( 'Preset Type', 'dispatch-premium' ),
				'id' => 'type',
				'type' => 'select',
				'options' => array(
					'' => '',
					'success' => __( 'Success', 'dispatch-premium' ),
					'warning' => __( 'Warning', 'dispatch-premium' ),
					'error' => __( 'Error', 'dispatch-premium' ),
					'info' => __( 'Info', 'dispatch-premium' ),
					'note' => __( 'Note', 'dispatch-premium' ),
					'flag' => __( 'Flag', 'dispatch-premium' ),
					'pushpin' => __( 'Pushpin', 'dispatch-premium' ),
					'setting' => __( 'Setting', 'dispatch-premium' ), ) ),
			array(
				'name' => __( 'Color', 'dispatch-premium' ),
				'desc' => __( 'You can leave this empty if you are using a Preset Type above.', 'dispatch-premium' ),
				'id' => 'color',
				'type' => 'select',
				'options' => hoot_shortcode_styles() ),
			array(
				'name' => __( 'Choose Icon', 'dispatch-premium' ),
				'desc' => __( 'You can leave this empty if you are using a Preset Type above.', 'dispatch-premium' ),
				'id' => 'icon',
				'type' => 'icon' ),
			array(
				'name' => __( 'Background Color', 'dispatch-premium' ),
				'desc' => __( 'You can leave this empty if you are using a Preset Type or Color above.', 'dispatch-premium' ),
				'id' => 'background',
				'type' => 'color' ),
			array(
				'name' => __( 'Text Color', 'dispatch-premium' ),
				'desc' => __( 'You can leave this empty if you are using a Preset Type or Color above.', 'dispatch-premium' ),
				'id' => 'text',
				'type' => 'color' ),
		),
	),

	'hoot_toggle' => array(
		'title' => __( 'Toggle Box', 'dispatch-premium' ),
		'type' => 'shortcode',
		'options' => array(
			array(
				'name' => __( 'Title', 'dispatch-premium' ),
				'id' => 'title',
				'type' => 'text' ),
			array(
				'name' => __( 'Content', 'dispatch-premium' ),
				'id' => 'content',
				'type' => 'textarea' ),
			array(
				'name' => __( 'Initial State', 'dispatch-premium' ),
				'desc' => __("Check this to set Toggle box as 'open'. By default, toggle boxes are closed on page load.", 'dispatch-premium' ),
				'id' => 'open',
				'type' => 'checkbox', ),
		),
	),

	'hoot_tabset' => array(
		'title' => __( 'Tab Set', 'dispatch-premium' ),
		'type' => 'shortcode',
		'options' => array(
			array(
				'name' => __( 'Tabs', 'dispatch-premium' ),
				'id' => 'hoot_tab',
				'type' => 'group',
				'settings' => array(
					'title' => __( 'Tab', 'dispatch-premium' ),
					'add_button' => __( 'Add Another Tab', 'dispatch-premium' ),
					'remove_button' => __( 'Remove Tab', 'dispatch-premium' ),
					'repeatable' => true,    // Default false
					'sortable' => true,     // Default false
					'toggleview' => true, ), // Default true
				'fields' => array(
					array(
						'name' => __( 'Tab Title', 'dispatch-premium' ),
						'id' => 'title',
						'type' => 'text' ),
					array(
						'name' => __( 'Tab Content', 'dispatch-premium' ),
						'id' => 'content',
						'type' => 'textarea',
						'settings' => array( 'rows' => 3 ), ),
					), ),
		),
	),

	'hoot_tab' => array(
		'type' => 'internal',
	),

	'hoot_code' => array(
		'title' => __( 'Code Block', 'dispatch-premium' ),
		'type' => 'shortcode',
		'options' => array(
			array(
				'name' => __( 'Display Code', 'dispatch-premium' ),
				'id' => 'content',
				'type' => 'textarea', ),
		),
	),

	'title_columns' => array(
		'title' => __( 'Columns', 'dispatch-premium' ),
		'type' => 'title',
	),

	'hoot_one_half' => array(
		'title' => __( 'Column - One Half / Two Fourth', 'dispatch-premium' ),
		'type' => 'shortcode',
		'options' => array(
			array(
				'name' => __( 'Column Content', 'dispatch-premium' ),
				'id' => 'content',
				'type' => 'textarea', ),
			array(
				'name' => __( 'Last Column?', 'dispatch-premium' ),
				'desc' => __( 'Is this the last column in its row?', 'dispatch-premium' ),
				'id' => 'last',
				'type' => 'checkbox', ),
		),
	),

	'hoot_one_third' => array(
		'title' => __( 'Column - One Third', 'dispatch-premium' ),
		'type' => 'shortcode',
		'options' => array(
			array(
				'name' => __( 'Column Content', 'dispatch-premium' ),
				'id' => 'content',
				'type' => 'textarea', ),
			array(
				'name' => __( 'Last Column?', 'dispatch-premium' ),
				'desc' => __( 'Is this the last column in its row?', 'dispatch-premium' ),
				'id' => 'last',
				'type' => 'checkbox', ),
		),
	),

	'hoot_two_third' => array(
		'title' => __( 'Column - Two Third', 'dispatch-premium' ),
		'type' => 'shortcode',
		'options' => array(
			array(
				'name' => __( 'Column Content', 'dispatch-premium' ),
				'id' => 'content',
				'type' => 'textarea', ),
			array(
				'name' => __( 'Last Column?', 'dispatch-premium' ),
				'desc' => __( 'Is this the last column in its row?', 'dispatch-premium' ),
				'id' => 'last',
				'type' => 'checkbox', ),
		),
	),

	'hoot_one_fourth' => array(
		'title' => __( 'Column - One Fourth', 'dispatch-premium' ),
		'type' => 'shortcode',
		'options' => array(
			array(
				'name' => __( 'Column Content', 'dispatch-premium' ),
				'id' => 'content',
				'type' => 'textarea', ),
			array(
				'name' => __( 'Last Column?', 'dispatch-premium' ),
				'desc' => __( 'Is this the last column in its row?', 'dispatch-premium' ),
				'id' => 'last',
				'type' => 'checkbox', ),
		),
	),

	'hoot_three_fourth' => array(
		'title' => __( 'Column - Three Fourth', 'dispatch-premium' ),
		'type' => 'shortcode',
		'options' => array(
			array(
				'name' => __( 'Column Content', 'dispatch-premium' ),
				'id' => 'content',
				'type' => 'textarea', ),
			array(
				'name' => __( 'Last Column?', 'dispatch-premium' ),
				'desc' => __( 'Is this the last column in its row?', 'dispatch-premium' ),
				'id' => 'last',
				'type' => 'checkbox', ),
		),
	),

	'hoot_one_fifth' => array(
		'title' => __( 'Column - One Fifth', 'dispatch-premium' ),
		'type' => 'shortcode',
		'options' => array(
			array(
				'name' => __( 'Column Content', 'dispatch-premium' ),
				'id' => 'content',
				'type' => 'textarea', ),
			array(
				'name' => __( 'Last Column?', 'dispatch-premium' ),
				'desc' => __( 'Is this the last column in its row?', 'dispatch-premium' ),
				'id' => 'last',
				'type' => 'checkbox', ),
		),
	),

	'hoot_two_fifth' => array(
		'title' => __( 'Column - Two Fifth', 'dispatch-premium' ),
		'type' => 'shortcode',
		'options' => array(
			array(
				'name' => __( 'Column Content', 'dispatch-premium' ),
				'id' => 'content',
				'type' => 'textarea', ),
			array(
				'name' => __( 'Last Column?', 'dispatch-premium' ),
				'desc' => __( 'Is this the last column in its row?', 'dispatch-premium' ),
				'id' => 'last',
				'type' => 'checkbox', ),
		),
	),

	'hoot_three_fifth' => array(
		'title' => __( 'Column - Three Fifth', 'dispatch-premium' ),
		'type' => 'shortcode',
		'options' => array(
			array(
				'name' => __( 'Column Content', 'dispatch-premium' ),
				'id' => 'content',
				'type' => 'textarea', ),
			array(
				'name' => __( 'Last Column?', 'dispatch-premium' ),
				'desc' => __( 'Is this the last column in its row?', 'dispatch-premium' ),
				'id' => 'last',
				'type' => 'checkbox', ),
		),
	),

	'hoot_four_fifth' => array(
		'title' => __( 'Column - Four Fifth', 'dispatch-premium' ),
		'type' => 'shortcode',
		'options' => array(
			array(
				'name' => __( 'Column Content', 'dispatch-premium' ),
				'id' => 'content',
				'type' => 'textarea', ),
			array(
				'name' => __( 'Last Column?', 'dispatch-premium' ),
				'desc' => __( 'Is this the last column in its row?', 'dispatch-premium' ),
				'id' => 'last',
				'type' => 'checkbox', ),
		),
	),

	'title_display' => array(
		'title' => __( 'Display Elements', 'dispatch-premium' ),
		'type' => 'title',
	),

	'hoot_dropcap' => array(
		'title' => __( 'Dropcap', 'dispatch-premium' ),
		'type' => 'shortcode',
		'options' => array(
			array(
				'name' => __( 'Dropcap Text', 'dispatch-premium' ),
				'id' => 'content',
				'type' => 'text',
				),
		),
	),

	'hoot_highlight' => array(
		'title' => __( 'Highlight Text', 'dispatch-premium' ),
		'type' => 'shortcode',
		'options' => array(
			array(
				'name' => __( 'Highlight Text', 'dispatch-premium' ),
				'id' => 'content',
				'type' => 'text',
				),
			array(
				'name' => __( 'Color', 'dispatch-premium' ),
				'desc' => __( 'You can leave this empty if you are using a Preset Type above.', 'dispatch-premium' ),
				'id' => 'color',
				'type' => 'select',
				'options' => hoot_shortcode_styles() ),
		),
	),

	'hoot_button' => array(
		'title' => __( 'Buttons', 'dispatch-premium' ),
		'type' => 'shortcode',
		'options' => array(
			array(
				'name' => __( 'Button Text', 'dispatch-premium' ),
				'id' => 'content',
				'type' => 'text',
				),
			array(
				'name' => __( 'URL (link)', 'dispatch-premium' ),
				'id' => 'url',
				'std' => 'http://',
				'type' => 'text',
				),
			array(
				'name' => __( 'Open Link In', 'dispatch-premium' ),
				'id' => 'target',
				'type' => 'select',
				'options' => array(
					'self' => __( 'Same Window', 'dispatch-premium' ),
					'blank' => __( 'New Blank Window', 'dispatch-premium' ), ) ),
			array(
				'name' => __( 'Size', 'dispatch-premium' ),
				'id' => 'size',
				'type' => 'select',
				'options' => array(
					'small' => __( 'Small', 'dispatch-premium' ),
					'medium' => __( 'Medium', 'dispatch-premium' ),
					'large' => __( 'Large', 'dispatch-premium') ) ),
			array(
				'name' => __( 'Align', 'dispatch-premium' ),
				'id' => 'align',
				'type' => 'select',
				'options' => array(
					'' => '',
					'left' => __( 'Left', 'dispatch-premium' ),
					'right' => __( 'Right', 'dispatch-premium' ),
					'center' => __( 'Center', 'dispatch-premium' ), ) ),
			array(
				'name' => __( 'Color', 'dispatch-premium' ),
				'desc' => __( 'Select a predefined color set, or set your custom colors below.', 'dispatch-premium' ),
				'id' => 'color',
				'type' => 'select',
				'options' => hoot_shortcode_styles() ),
			array(
				'name' => __( 'Background Color', 'dispatch-premium' ),
				'desc' => __( 'You can leave this empty if you are using a predefined color set above.', 'dispatch-premium' ),
				'id' => 'background',
				'type' => 'color' ),
			array(
				'name' => __( 'Text Color', 'dispatch-premium' ),
				'desc' => __( 'You can leave this empty if you are using a predefined color set above.', 'dispatch-premium' ),
				'id' => 'text',
				'type' => 'color' ),
		),
	),

	'hoot_icon' => array(
		'title' => __( 'Icon', 'dispatch-premium' ),
		'type' => 'shortcode',
		'options' => array(
			array(
				'name' => __( 'Choose Icon', 'dispatch-premium' ),
				'id' => 'icon',
				'type' => 'icon' ),
			array(
				'name' => __( 'Color', 'dispatch-premium' ),
				'desc' => __( '(Optional)', 'dispatch-premium' ),
				'id' => 'color',
				'type' => 'color' ),
			array(
				'name' => __( 'Size', 'dispatch-premium' ),
				'id' => 'size',
				'type' => 'select',
				'std' => 14,
				'options' => hoot_sc_range( 9, 100, '', ' ' . __( 'px', 'dispatch-premium') ) ),
		),
	),

	'hoot_social_profile' => array(
		'title' => __( 'Social Profile', 'dispatch-premium' ),
		'type' => 'shortcode',
		'options' => array(
			array(
				'name' => __( 'Icon Size', 'dispatch-premium' ),
				'id' => 'size',
				'type' => 'select',
				'std' => 'medium',
				'options' => array(
					'small' => __( 'Small', 'dispatch-premium' ),
					'medium' => __( 'Medium', 'dispatch-premium' ),
					'large' => __( 'Large', 'dispatch-premium' ),
					'huge' => __( 'Huge', 'dispatch-premium' ),
					) ),
			array(
				'name' => __( 'Icon', 'dispatch-premium' ),
				'id' => 'icon',
				'type' => 'select',
				'options' => hoot_enum_social_profiles( false ),
				),
			array(
				'name' => __( 'URL (enter email address for Email)', 'dispatch-premium' ),
				'id' => 'url',
				'std' => 'http://',
				'type' => 'text',
				),
			array(
				'name' => __( 'Open Link In', 'dispatch-premium' ),
				'id' => 'target',
				'type' => 'select',
				'options' => array(
					'self' => __( 'Same Window', 'dispatch-premium' ),
					'blank' => __( 'New Blank Window', 'dispatch-premium' ), ) ),
		),
	),

	'hoot_divider' => array(
		'title' => __( 'Divider', 'dispatch-premium' ),
		'type' => 'shortcode',
		'options' => array(
			array(
				'name' => __( 'Color', 'dispatch-premium' ),
				'desc' => __( 'Leave empty for default colors.', 'dispatch-premium' ),
				'id' => 'color',
				'type' => 'select',
				'options' => hoot_shortcode_styles() ),
			array(
				'name' => __( 'Use Bright Color Scheme', 'dispatch-premium' ),
				'desc' => __("If you have selected a 'color' above, you can use the bright color scheme instead of the default.", 'dispatch-premium' ),
				'id' => 'bright',
				'type' => 'select',
				'options' => array(
					'' => '',
					'yes' => __( 'Bright', 'dispatch-premium' ),
					) ),
			array(
				'name' => __("Show 'Goto Top' Link", 'dispatch-premium' ),
				'id' => 'top',
				'type' => 'checkbox', ),
		),
	),

	'hoot_htmltag' => array(
		'title' => __( 'Div / Span', 'dispatch-premium' ),
		'type' => 'shortcode',
		'options' => array(
			array(
				'name' => __( 'HTML Tags', 'dispatch-premium' ),
				'desc' => __( 'This shortcode is often used by developer users for special cases. Feel free to ignore it if you dont know what it does.', 'dispatch-premium' ),
				'type' => 'info',
				),
			array(
				'name' => __( 'HTML Tag', 'dispatch-premium' ),
				'id' => 'tag',
				'type' => 'select',
				'options' => array(
					'div' => __( 'Div', 'dispatch-premium' ),
					'span' => __( 'Span', 'dispatch-premium' ), ) ),
			array(
				'name' => __( 'Classes', 'dispatch-premium' ),
				'id' => 'class',
				'type' => 'text',
				),
			array(
				'name' => __( 'Styles', 'dispatch-premium' ),
				'id' => 'style',
				'desc' => __( 'CSS Rules to apply to the div/span', 'dispatch-premium' ),
				'type' => 'textarea',
				'settings' => array( 'rows' => 2, 'code' => true ),
				),
			array(
				'name' => __( 'Content', 'dispatch-premium' ),
				'id' => 'content',
				'type' => 'textarea' ),
		),
	),

	'hoot_clear' => array(
		'title' => __( 'Clear Floats', 'dispatch-premium' ),
		'type' => 'shortcode',
		'options' => array(
			array(
				'name' => '',
				'desc' => __( 'This shortcode does not have any options.', 'dispatch-premium' ),
				'type' => 'info',
				),
		),
	),

	'title_media' => array(
		'title' => __( 'Media', 'dispatch-premium' ),
		'type' => 'title',
	),

	'hoot_slider' => array(
		'title' => __( 'Slider / Carousel', 'dispatch-premium' ),
		'type' => 'shortcode',
		'options' => array(
			array(
				'name' => __( 'Select Slider / Carousel', 'dispatch-premium' ),
				'desc' => sprintf( __( 'You can Create New Sliders from the %sAdd New Slider%s screen.', 'dispatch-premium' ), '<a href="' . esc_url( admin_url('post-new.php?post_type=hoot_slider') ) . '" target="_blank">', '</a>' ),
				'id' => 'id',
				'type' => 'select',
				'options' => Hoot_Options_Helper::cpt('hoot_slider', false ), ),
		),
	),

);