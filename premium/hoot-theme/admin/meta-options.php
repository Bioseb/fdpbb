<?php
/**
 * Theme Meta Options displayed in admin.
 * Themes should use default 'main_box' as ID for the main meta options box id for brevity. This is the
 * default id used for 'hoot_get_meta_option()' function.
 *
 * @package hoot
 * @subpackage dispatch
 * @since dispatch 1.0
 */

/* Hook in to add some additiona css for specific options */
add_action( 'hoot_meta_options_enqueue', 'hoot_theme_meta_options_enqueue', 10, 3 );

/**
 * Add some additiona css for specific options
 * This hook is only fired when meta options are being displayed. So checking hook is redundant
 *
 * @since 2.0
 * @param string $hook
 * @return void
 */
function hoot_theme_meta_options_enqueue( $hook, $post_type, $supported_post_types ) {
	if ( $post_type == 'post' || $post_type == 'page' )
		add_action( 'admin_head', 'hoot_theme_meta_options_pagepost_scripts' );
	if ( $post_type == 'page' )
		add_action( 'admin_head', 'hoot_theme_meta_options_page_scripts' );
}

function hoot_theme_meta_options_pagepost_scripts() {
	echo '<style>
	#section-hoot-main_box-pre_title_content,
	#section-hoot-main_box-pre_title_content_post { border-bottom: none; padding-bottom: 10px; }
	#section-hoot-main_box-pre_title_content_post,
	#section-hoot-main_box-pre_title_content_stretch { padding-top: 0; }
	#section-hoot-main_box-pre_title_content_post h4,
	#section-hoot-main_box-pre_title_content_stretch h4 { display: none; }
	</style>';
}

function hoot_theme_meta_options_page_scripts(){
	echo '<style>
	#section-hoot-main_box-wt_sidebar { display: none; }
	.wtemplate #section-hoot-main_box-wt_sidebar { display: block; }
	.wtemplate #section-hoot-main_box-sidebar_type,
	.wtemplate #section-hoot-main_box-sidebar,
	.wtemplate #section-hoot-main_box-display_loop_meta,
	.wtemplate #section-hoot-main_box-meta_hide_info,
	.wtemplate #section-hoot-main_box-pre_title_content_stretch,
	.wtemplate #section-hoot-main_box-pre_title_content_post,
	.wtemplate #section-hoot-main_box-pre_title_content { display: none !important; }
	</style>';
	echo '<script type="text/javascript">jQuery(document).ready(function($) {
	var $hoot_pt = $("#page_template"), $hoot_mb = $("#hoot-meta-box-main_box");
	if ( $hoot_pt.val() == "page-templates/template-widgetized.php" )
		$hoot_mb.addClass("wtemplate");
	$hoot_pt.on("change", function(){
		if ( $hoot_pt.val() == "page-templates/template-widgetized.php" )
			$hoot_mb.addClass("wtemplate");
		else
			$hoot_mb.removeClass("wtemplate");
	});
	});</script>';
	global $post;
	// if ( !empty( $post->ID ) && ( $post->ID == get_option( 'page_on_front' ) ) ) {
	if ( !empty( $post->ID ) && ( $post->ID == get_option( 'page_for_posts' ) ) ) {
		echo '<style>
		#section-hoot-main_box-sidebar_type,
		#section-hoot-main_box-sidebar,
		#section-hoot-main_box-meta_hide_info { display: none !important; }
		</style>';
	} else {
		echo '<style>#hoot-main_box-frontpage_sidebar { display: none; }</style>';
	}
	if ( !empty( $post->ID ) && ( $post->ID == get_option( 'woocommerce_shop_page_id' ) ) ) {
		echo '<style>
		#section-hoot-main_box-sidebar_type,
		#section-hoot-main_box-sidebar,
		#section-hoot-main_box-meta_hide_info { display: none !important; }
		</style>';
	} else {
		echo '<style>#hoot-main_box-wooshop_sidebar { display: none; }</style>';
	}
}

/**
 * Defines an array of meta options that will be used to generate the metabox.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * Child themes can modify the meta options array using the 'hoot_theme_meta_options' filter hook.
 *
 * @since 1.0
 * @param object $hoot_options_meta_admin
 * @return void
 */
function hoot_meta_options( $hoot_options_meta_admin ) {

	// define a directory path for using image radio buttons
	$imagepath =  trailingslashit( HOOT_THEMEURI ) . 'admin/images/';

	$options = array();
	global $hoot_options_meta_admin;

	/*** 'hoot_slider' post-type meta ***/

	$options['hoot_slider']['main_box'] = array(
		'title'    => __( 'Edit Slider', 'dispatch-premium' ),
		'context'  => 'normal',
		'priority' => 'high',
	);

		$options['hoot_slider']['main_box']['options'][] = array(
			'name' => __('Slider Type', 'dispatch-premium'),
			'type' => 'heading',
		);

		$options['hoot_slider']['main_box']['options'][] = array(
			// 'name'    => "",
			'id'      => "type",
			'class'   => 'slider_type',
			'default' => "image",
			'type'    => "images",
			'options' => array(
				'image' => $imagepath . 'slider-type-image.png',
				'html' => $imagepath . 'slider-type-html.png',
				'carousel' => $imagepath . 'slider-type-carousel.png',
			),
		);

		$options['hoot_slider']['main_box']['options'][] = array(
			'name' => __('Slider Settings', 'dispatch-premium'),
			'type' => 'subheading',
		);

		$options['hoot_slider']['main_box']['options'][] = array(
			'name'    => __('Auto Play', 'dispatch-premium'),
			'desc'    => __('Check this to automatically start playing the slider.', 'dispatch-premium'),
			'id'      => 'auto',
			'default' => '1',
			'type'    => 'checkbox',
		);

		$options['hoot_slider']['main_box']['options'][] = array(
			'name'    => __('Pause Time', 'dispatch-premium'),
			'desc'    => __('The time (in ms) between each auto transition.<br />Example: 5 seconds is 5000 ms', 'dispatch-premium'),
			'id'      => 'pause',
			'default' => '5000',
			'class'   => 'mini',
			'type'    => 'text',
		);

		$options['hoot_slider']['main_box']['options'][] = array(
			'default' => '<div class="show-on-select" data-selector="slider_type">',
			'type'    => 'html',
		);

		$options['hoot_slider']['main_box']['options'][] = array(
			'name'    => __('Carousel Items', 'dispatch-premium'),
			'desc'    => __('Number of items to show in the carousel.', 'dispatch-premium'),
			'id'      => 'item',
			'class'   => 'show-on-select-block slider_type-carousel hoothide mini',
			'default' => '3',
			'type'    => 'text',
		);

		/*$options['hoot_slider']['main_box']['options'][] = array(
			'name'    => __('Adaptive Height', 'dispatch-premium'),
			'desc'    => __('Adjust the height according to height of slide being displayed.', 'dispatch-premium'),
			'id'      => 'adaptiveheight',
			'class'   => 'show-on-select-block slider_type-image slider_type-carousel hoothide',
			'default' => '1',
			'type'    => 'checkbox',
		);*/

		/* slidemove will be 1 if loop is true, which it is for hoot-theme
		$options['hoot_slider']['main_box']['options'][] = array(
			'name'    => __('Move Items', 'dispatch-premium'),
			'desc'    => __('Number of carousel items to move at a time.', 'dispatch-premium'),
			'id'      => 'slidemove',
			'class'   => 'show-on-select-block slider_type-carousel hoothide mini',
			'default' => '1',
			'type'    => 'text',
		);*/

		$options['hoot_slider']['main_box']['options'][] = array(
			'default' => '</div>',
			'type'    => 'html',
		);

		$options['hoot_slider']['main_box']['options'][] = array(
			'default' => '<div class="show-on-select" data-selector="slider_type"><div class="show-on-select-block slider_type-image hoothide">',
			'type'    => 'html',
		);

			$options['hoot_slider']['main_box']['options'][] = array(
				'name' => __('Image Slider', 'dispatch-premium'),
				'type' => 'subheading',
			);

			$options['hoot_slider']['main_box']['options'][] = array(
				//'name' => __('Slides', 'dispatch-premium'),
				'id'       => 'image_slider',
				'type'     => 'group',
				'settings' => array(
					'title'         => __( 'Image Slide', 'dispatch-premium' ),
					'add_button'    => __( 'Add New Slide', 'dispatch-premium' ),
					'remove_button' => __( 'Remove Slide', 'dispatch-premium' ),
					'repeatable'    => true,
					'sortable'      => true,
				),
				'fields'   => array(
					array(
						'name' => __('Slide Image', 'dispatch-premium'),
						'desc' => __('The main showcase image.', 'dispatch-premium'),
						'id'   => 'image',
						'type' => 'upload',
					),
					array(
						'name' => __('Slide Caption (optional)', 'dispatch-premium'),
						'id'   => 'caption',
						'type' => 'text',
					),
					array(
						'name' => __('Slide Link', 'dispatch-premium'),
						'desc' => __('Leave empty if you do not want to link the slide.', 'dispatch-premium'),
						'id'   => 'url',
						'type' => 'text',
					),
				),
			);

		$options['hoot_slider']['main_box']['options'][] = array(
			'default' => '</div><div class="show-on-select-block slider_type-html hoothide">',
			'type'    => 'html',
		);

			$options['hoot_slider']['main_box']['options'][] = array(
				'name' => __('HTML Slider', 'dispatch-premium'),
				'type' => 'subheading',
			);

			$options['hoot_slider']['main_box']['options'][] = array(
				// 'name'     => __('Slides', 'dispatch-premium'),
				'id'       => 'html_slider',
				'type'     => 'group',
				'settings' => array(
					'title'         => __( 'HTML Slide', 'dispatch-premium' ),
					'add_button'    => __( 'Add New Slide', 'dispatch-premium' ),
					'remove_button' => __( 'Remove Slide', 'dispatch-premium' ),
					'repeatable'    => true,
					'sortable'      => true,
				),
				'fields'   => array(
					array(
						'name' => __('Slide Image', 'dispatch-premium'),
						'id'   => 'image',
						'type' => 'upload',
					),
					array(
						'name' => __('Title', 'dispatch-premium'),
						'id'   => 'title',
						'type' => 'text',
					),
					array(
						'name'     => __('Content', 'dispatch-premium'),
						'id'       => 'content',
						'type'     => 'textarea',
						'settings' => array( 'rows' => 4 ),
					),
					array(
						'name' => __('Button Text', 'dispatch-premium'),
						'id'   => 'button',
						'type' => 'text',
					),
					array(
						'name' => __('Button URL', 'dispatch-premium'),
						'desc' => __('Leave empty if you do not want to show the button.', 'dispatch-premium'),
						'id'   => 'url',
						'type' => 'text',
					),
					array(
						'name'    =>  __('Slide Background', 'dispatch-premium'),
						'desc'    => __('This can be useful if you are using transparent images', 'dispatch-premium'),
						'id'      => 'background',
						'default' => '#ffffff',
						'type'    => 'color',
					),
				),
			);

		$options['hoot_slider']['main_box']['options'][] = array(
			'default' => '</div><div class="show-on-select-block slider_type-carousel hoothide">',
			'type'    => 'html',
		);

			$options['hoot_slider']['main_box']['options'][] = array(
				'name' => __('Carousel Slider', 'dispatch-premium'),
				'type' => 'subheading',
			);

			$options['hoot_slider']['main_box']['options'][] = array(
				// 'name'     => __('Slides', 'dispatch-premium'),
				'id'       => 'carousel_slider',
				'type'     => 'group',
				'settings' => array(
					'title'         => __( 'Carousel Slide', 'dispatch-premium' ),
					'add_button'    => __( 'Add New Slide', 'dispatch-premium' ),
					'remove_button' => __( 'Remove Slide', 'dispatch-premium' ),
					'repeatable'    => true,
					'sortable'      => true,
				),
				'fields'   => array(
					array(
						'name' => __('Slide Image', 'dispatch-premium'),
						'desc' => __('The main showcase image.', 'dispatch-premium'),
						'id'   => 'image',
						'type' => 'upload',
					),
					array(
						'name'     => __('Content', 'dispatch-premium'),
						'desc'     => __('You can use the <code>&lt;h3&gt;Lorem Ipsum Dolor&lt;/h3&gt;</code> tag to create styled heading.', 'dispatch-premium'),
						'id'       => 'content',
						'default'  => '<h3>Lorem Ipsum Dolor</h3>'."\n".'<p>This is a sample description text for the slide.</p>',
						'type'     => 'textarea',
						'settings' => array( 'rows' => 4 ),
					),
					array(
						'name' => __('Image Link', 'dispatch-premium'),
						'desc' => __('Leave empty if you do not want to link the image.', 'dispatch-premium'),
						'id'   => 'url',
						'type' => 'text',
					),
				),
			);

		$options['hoot_slider']['main_box']['options'][] = array(
			'default' => '</div>',
			'type'    => 'html',
		);



	$options['page']['main_box'] =
	$options['post']['main_box'] = array(
		'title'    => __( 'Page Options', 'dispatch-premium' ),
		'context'  => 'normal',
		'priority' => 'high',
	);

		$options['page']['main_box']['options'][] =
		$options['post']['main_box']['options'][] = array(
			'name'    => __( 'Sidebar Layout', 'dispatch-premium' ),
			'id'      => "sidebar_type",
			'class'   => 'sidebar_selector',
			'default' => "default",
			'type'    => "radio",
			'options' => array(
				'default' => __('Default layout as selected in Theme Options', 'dispatch-premium'),
				'custom'  => __('Custom Layout for this page.', 'dispatch-premium'),
			),
		);

		$options['page']['main_box']['options'][] =
		$options['post']['main_box']['options'][] = array(
			'default' => '<div class="show-on-select" data-selector="sidebar_selector">',
			'type'    => 'html',
		);

		$options['page']['main_box']['options'][] =
		$options['post']['main_box']['options'][] = array(
			'name'    => __( 'Custom Sidebar Layout for page', 'dispatch-premium' ),
			'id'      => "sidebar",
			'class'   => 'show-on-select-block sidebar_selector-custom hoothide',
			'default' => "wide-right",
			'type'    => "images",
			'options' => array(
				'wide-right'   => $imagepath . 'sidebar-wide-right.png',
				'narrow-right' => $imagepath . 'sidebar-narrow-right.png',
				'wide-left'    => $imagepath . 'sidebar-wide-left.png',
				'narrow-left'  => $imagepath . 'sidebar-narrow-left.png',
				'none'         => $imagepath . 'sidebar-none.png',
			),
		);

		$options['page']['main_box']['options'][] =
		$options['post']['main_box']['options'][] = array(
			'default' => '</div>',
			'type'    => 'html',
		);

		$options['page']['main_box']['options'][] = array(
			'name'    => __( 'Sidebar Layout', 'dispatch-premium' ),
			'id'      => "frontpage_sidebar",
			'desc'    => '<em>' . __( "This option is not available since this page is set as the 'Blog' page. Please go to <strong>'Appearance &gt; Customize &gt; Setup &amp; Layout &gt; Sidebar Layout (for Blog)'</strong> to change the layout for Blog/Archive Pages", 'dispatch-premium' ) . '</em>',
			'type'    => "info",
		);

		$options['page']['main_box']['options'][] = array(
			'name'    => __( 'Sidebar Layout', 'dispatch-premium' ),
			'id'      => "wooshop_sidebar",
			'desc'    => '<em>' . __( "This option is not available since this page is set as the 'Shop' page. Please go to <strong>'Appearance &gt; Customizer &gt; Woocommerce'</strong> section  to change the layout for Woocommerce Pages", 'dispatch-premium' ) . '</em>',
			'type'    => "info",
		);

		$options['page']['main_box']['options'][] = array(
			'name'    => __( 'Sidebar Layout for Widgetized Template', 'dispatch-premium' ),
			'id'      => "wt_sidebar",
			'desc'    => __( "<strong>Select 'No Sidebar' if you have stretched (full width) sliders enabled for this template in Customizer.</strong>", 'dispatch-premium' ),
			'default' => "none",
			'type'    => "images",
			'options' => array(
				'wide-right'   => $imagepath . 'sidebar-wide-right.png',
				'narrow-right' => $imagepath . 'sidebar-narrow-right.png',
				'wide-left'    => $imagepath . 'sidebar-wide-left.png',
				'narrow-left'  => $imagepath . 'sidebar-narrow-left.png',
				'none'         => $imagepath . 'sidebar-full.png',
			),
		);

		$options['page']['main_box']['options'][] =
		$options['post']['main_box']['options'][] = array(
			'name'    => __( 'Title Area', 'dispatch-premium' ),
			'id'      => "display_loop_meta",
			'class'   => 'titlearea_selector',
			'default' => "show",
			'type'    => "radio",
			'options' => array(
				'show' => __('Display Title Area (default)', 'dispatch-premium'),
				'hide' => __('Hide Title Area for this page.', 'dispatch-premium'),
			),
		);

		$options['page']['main_box']['options'][] =
		$options['post']['main_box']['options'][] = array(
			'default' => '<div class="show-on-select" data-selector="titlearea_selector">',
			'type'    => 'html',
		);

		$options['page']['main_box']['options'][] =
		$options['post']['main_box']['options'][] = array(
			'name'  => __( 'Hide Meta Info', 'dispatch-premium' ),
			'desc'  => __( 'Hide Meta Info like Author, Date etc. for this page', 'dispatch-premium' ),
			'id'    => "meta_hide_info",
			'class' => 'show-on-select-block titlearea_selector-show hoothide',
			'type'  => "checkbox",
		);

		$options['page']['main_box']['options'][] =
		$options['post']['main_box']['options'][] = array(
			'default' => '</div>',
			'type'    => 'html',
		);

		$options['page']['main_box']['options'][] =
		$options['post']['main_box']['options'][] = array(
			'name'     => __( 'Custom Content before/after Title Area', 'dispatch-premium' ),
			'id'       => "pre_title_content",
			'desc'     => __('Display some content before/after the title area.<br />You can add any content like images, slider shortcodes etc. to appear before the Title Area on this page.', 'dispatch-premium'),
			'type'     => "textarea",
			'settings' => array( 'rows' => 3 ),
		);

		$options['page']['main_box']['options'][] =
		$options['post']['main_box']['options'][] = array(
			'name' => __( 'Display Content after Title Area', 'dispatch-premium' ),
			'desc' => __( 'Display the above content <strong>after</strong> the Title Area. (by default it appears <strong>before</strong> title area)', 'dispatch-premium' ),
			'id'   => "pre_title_content_post",
			'type' => "checkbox",
		);

		$options['page']['main_box']['options'][] =
		$options['post']['main_box']['options'][] = array(
			'name' => __( 'Remove Padding from Title Area Content', 'dispatch-premium' ),
			'desc' => __( 'Stretch the above content area from edge to edge.<br />This is useful if you are adding content like images or sliders, and dont want any padding/margins.', 'dispatch-premium' ),
			'id'   => "pre_title_content_stretch",
			'type' => "checkbox",
		);

		$options['page']['main_box']['options'][] =
		$options['post']['main_box']['options'][] = array(
			'name'     => __( 'Custom CSS', 'dispatch-premium' ),
			'id'       => "page_css",
			'desc'     => __('Custom CSS for this page only', 'dispatch-premium'),
			'type'     => "textarea",
			'settings' => array( 'code' => true, 'rows' => 3 ),
		);

	// Add meta options to main class options object
	$hoot_options_meta_admin->add_options( $options );

}

/* Hook into action to add options */
add_action( 'hoot_options_meta_admin_loaded', 'hoot_meta_options', 5, 1 );