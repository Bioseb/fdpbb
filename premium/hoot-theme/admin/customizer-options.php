<?php
/**
 * Defines customizer premium options
 *
 * This file is loaded at 'after_setup_theme' hook with 10 priority.
 *
 * @package hoot
 * @subpackage dispatch
 * @since dispatch 2.0
 */

/**
 * Build the Customizer options (panels, sections, settings)
 *
 * Always remember to mention specific priority for non-static options like:
 *     - options being added based on a condition (eg: if woocommerce is active)
 *     - options which may get removed (eg: logo_size, headings_fontface)
 *     - options which may get rearranged (eg: logo_background_type)
 *     This will allow other options inserted with priority to be inserted at
 *     their intended place.
 *
 * @since 2.0
 * @access public
 * @return array
 */
if ( !function_exists( 'hoot_premium_customizer_options' ) ) :
function hoot_premium_customizer_options() {

	// Stores all the settings to be added
	$settings = array();

	// Stores all the sections to be added
	$sections = array();

	// Stores all the panels to be added
	$panels = array();

	// Theme defaults
	extract( apply_filters( 'hoot_theme_options_defaults', array(
		// Lite version
		'accent_color'    => '#48ab79',
		'accent_font'     => '#ffffff',
		'box_background'  => '#ffffff',
		'site_background' => '#ffffff',
		// 'wt_html_slide_background' => '#ffffff',
		// Premium only options
		'contrast_color'             => '#000000',
		'contrast_font'              => '#ffffff',
		'highlight_color'            => '#f1f1f1',
		'topbar_background'          => '#f1f1f1',
		'header_background'          => '#000000',
		// 'logo_background'            => '#f3595b',
		'menu_icons_color'           => '#ffffff',
		'menu_dropdown_background'   => '#000000',
		'pageheader_background'      => '#f1f1f1',
		'subfooter_background'       => '#f1f1f1',
		'footer_background'          => '#000000',
		'topbar_color'               => '#888888',
		'font_logo_size'             => '54px',
		'font_logo_face'             => '"Oswald", sans-serif',
		'font_logo_style'            => 'uppercase bold',
		'font_logo_color'            => '#ffffff',
		'font_tagline_size'          => '14px',
		'font_tagline_face'          => '"Oswald", sans-serif',
		'font_tagline_style'         => 'uppercase',
		'font_tagline_color'         => '#ffffff',
		'font_nav_menu_size'         => '12px',
		'font_nav_menu_face'         => '"Open Sans", sans-serif',
		'font_nav_menu_style'        => 'uppercase bold',
		'font_nav_menu_color'        => '#ffffff',
		'font_nav_dropdown_size'     => '12px',
		'font_nav_dropdown_style'    => 'uppercase bold',
		'font_nav_dropdown_color'    => '#ffffff',
		'font_body_size'             => '14px',
		'font_body_face'             => '"Open Sans", sans-serif',
		'font_body_style'            => 'none',
		'font_body_color'            => '#444444',
		'font_h3_size'               => '24px',
		'font_h3_face'               => '"Oswald", sans-serif',
		'font_h3_style'              => 'none',
		'font_h3_color'              => '#000000',
		'link_color'                 => '#48ab79',
		'link_hover_color'           => '#48ab79',
		'font_h1_size'               => '30px',
		'font_h1_style'              => 'none',
		'font_h1_color'              => '#000000',
		'font_h2_size'               => '26px',
		'font_h2_style'              => 'none',
		'font_h2_color'              => '#000000',
		'font_h4_size'               => '22px',
		'font_h4_style'              => 'none',
		'font_h4_color'              => '#000000',
		'font_h5_size'               => '20px',
		'font_h5_style'              => 'none',
		'font_h5_color'              => '#000000',
		'font_h6_size'               => '18px',
		'font_h6_style'              => 'none',
		'font_h6_color'              => '#000000',
		'font_sidebar_heading_size'  => '14px',
		'font_sidebar_heading_face'  => '"Open Sans", sans-serif',
		'font_sidebar_heading_style' => 'uppercase bold',
		'font_sidebar_heading_color' => '#000000',
		'font_sidebar_size'          => '14px',
		'font_sidebar_style'         => 'none',
		'font_sidebar_color'         => '#444444',
		'font_footer_heading_size'   => '14px',
		'font_footer_heading_face'   => '"Open Sans", sans-serif',
		'font_footer_heading_style'  => 'uppercase bold',
		'font_footer_heading_color'  => '#ffffff',
		'font_footer_size'           => '14px',
		'font_footer_style'          => 'none',
		'font_footer_color'          => '#ffffff',
	) ) );

	// Directory path for radioimage buttons
	$imagepath =  trailingslashit( HOOT_THEMEURI ) . 'admin/images/';

	/*** Add Options (Panels, Sections, Settings) ***/

	/** Section **/

	$section = 'title_tagline';

	$settings['sidebar_archives'] = array(
		'label'       => __( 'Sidebar Layout (for Blog/Archives)', 'dispatch-premium' ),
		'section'     => $section,
		'type'        => 'radioimage',
		'priority'    => '55',
		'choices'     => array(
			'wide-right'   => $imagepath . 'sidebar-wide-right.png',
			'narrow-right' => $imagepath . 'sidebar-narrow-right.png',
			'wide-left'    => $imagepath . 'sidebar-wide-left.png',
			'narrow-left'  => $imagepath . 'sidebar-narrow-left.png',
			'none'         => $imagepath . 'sidebar-none.png',
		),
		'default'     => 'wide-right',
		'description' => __("Set the default sidebar width and position for blog and archives pages like categories, tags etc.", 'dispatch-premium'),
	);

	$settings['disable_lightbox'] = array(
		'label'       => __( 'Disable Lightbox', 'dispatch-premium' ),
		'section'     => $section,
		'type'        => 'checkbox',
		'priority'    => '75',
		'description' => __('Check this if you do not want image links to open in a lightbox throughout your site.<hr>Users can always add the <code>class="no-lightbox"</code> tag to links to stop them from opening in lightbox. Example:<hr><code>&lt;a href="image.png" class="no-lightbox"&gt;Content&lt;/a&gt;</code>', 'dispatch-premium'),
	);

	if ( hoot_theme_supports( 'hoot-waypoints', 'sticky-header' ) ) {
		$settings['disable_sticky_header'] = array(
			'label'       => __( 'Disable Sticky Header', 'dispatch-premium' ),
			'section'     => $section,
			'type'        => 'checkbox',
			'priority'    => '75',
			'description' => __( 'Check this if you do not want to display a fixed Header at top when a user scrolls down the page.', 'dispatch-premium' ),
		);
	}

	if ( hoot_theme_supports( 'hoot-scrollpoints', 'goto-top' ) ) {
		$settings['disable_goto_top'] = array(
			'label'       => __( "Disable 'Goto Top' Button", 'dispatch-premium' ),
			'section'     => $section,
			'type'        => 'checkbox',
			'priority'    => '75',
			'description' => __( 'Check this to hide "Top" button (bottom right of screen) when a user scrolls down the page.', 'dispatch-premium' ),
		);
	}

	if ( hoot_theme_supports( 'hoot-scrollpoints', 'menu-scroll' ) ) {
		$settings['scrollpadding'] = array(
			'label'       => __( "Custom padding for scrollpoints", 'dispatch-premium' ),
			'section'     => $section,
			'type'        => 'text',
			'default'     => '50',
			'priority'    => '75',
			'description' => __( 'This is the distance from the top of the screen when the page scrolls down to a scrollpoint.', 'dispatch-premium' ),
			'input_attrs' => array(
				'placeholder' => __( 'default: 50', 'dispatch-premium' ),
			),
		);
	}

	/** Section **/

	$section = 'colors';

	$settings['contrast_color'] = array(
		'label'       => __( 'Contrast Color', 'dispatch-premium' ),
		'section'     => $section,
		'type'        => 'color',
		'default'     => $contrast_color,
	);

	$settings['contrast_font'] = array(
		'label'       => __( 'Font Color on Contrast Color', 'dispatch-premium' ),
		'section'     => $section,
		'type'        => 'color',
		'default'     => $contrast_font,
	);

	$settings['highlight_color'] = array(
		'label'       => __( 'Highlight Color', 'dispatch-premium' ),
		'section'     => $section,
		'type'        => 'color',
		'default'     => $highlight_color,
		'description' => __('For highlighting backgrounds.<hr>It is best to choose a highlight color which is close to the content background color. For example, for a white site, select highlight color as light gray.', 'dispatch-premium'),
	);

	$settings['menu_icons_color'] = array(
		'label'       => __( 'Header Nav Menu - Icon Color', 'dispatch-premium' ),
		'section'     => $section,
		'type'        => 'color',
		'default'     => $menu_icons_color,
		'description' => sprintf( __('You can add icons to your navigation menu from the %sMenu Management screen%s.', 'dispatch-premium'), '<a href="' . esc_url( admin_url('nav-menus.php') ) . '" target="_blank">', '</a>' ),
	);

	/** Section **/

	$section = 'backgrounds';

	$settings['topbar_background'] = array(
		'label'       => __( 'Topbar Background', 'dispatch-premium' ),
		'section'     => $section,
		'type'        => 'color',
		'default'     => $topbar_background,
	);

	$settings['header_background_type'] = array(
		'label'       => __( 'Site Header Background', 'dispatch-premium' ),
		'section'     => $section,
		'type'        => 'radio',
		'choices'     => array(
			'transparent' => __('None (Transparent)', 'dispatch-premium'),
			'background'  => __('Background Color', 'dispatch-premium'),
		),
		'default'     => 'background',
		'description' => __( 'This is the Site Header containing Logo and Menu', 'dispatch-premium' ),
	);

	$settings['header_background'] = array(
		'label'           => __( 'Site Header Background Color', 'dispatch-premium' ),
		'section'         => $section,
		'type'            => 'color',
		'default'         => $header_background,
		'active_callback' => 'hoot_callback_header_background',
	);

	$settings['menu_dropdown_background'] = array(
		'label'       => __( 'Menu Dropdown Background', 'dispatch-premium' ),
		'section'     => $section,
		'type'        => 'color',
		'default'     => $menu_dropdown_background,
	);

	$settings['pageheader_background'] = array(
		'label'       => __( 'Page Title Header Background', 'dispatch-premium' ),
		'section'     => $section,
		'type'        => 'betterbackground',
		'default'     => array(
			'color'      => $pageheader_background,
		),
		'description' => __( 'This is the Page Header area at top (below Logo and Menu) containing Page/Post Title and Meta details like author, categories etc.', 'dispatch-premium' ),
	);

	$settings['subfooter_background'] = array(
		'label'       => __( 'Sub Footer Background', 'dispatch-premium' ),
		'section'     => $section,
		'type'        => 'betterbackground',
		'default'     => array(
			'color'      => $subfooter_background,
		),
		'description' => sprintf( __("This background will be used for subfooter if active (i.e. you have added widgets in the %s'Subfooter' Widget area%s)", 'dispatch-premium'), '<a href="' . esc_url( admin_url('widgets.php') ) . '" target="_blank">', '</a>' ),
	);

	$settings['footer_background'] = array(
		'label'       => __( 'Footer Background', 'dispatch-premium' ),
		'section'     => $section,
		'type'        => 'betterbackground',
		'default'     => array(
			'color'      => $footer_background,
		),
	);

	/** Section **/

	$section = 'typography';

	$sections[ $section ] = array(
		'title'       => __( 'Typography', 'dispatch-premium' ),
		'priority'    => '23',
	);

	$settings['topbar_color'] = array(
		'label'       => __( 'Topbar Font', 'dispatch-premium' ),
		'section'     => $section,
		'type'        => 'color',
		'default'     => $topbar_color,
	);

	$settings['font_logo'] = array(
		'label'       => __( 'Logo', 'dispatch-premium' ),
		'section'     => $section,
		'type'        => 'typography',
		'default'     => array(
			'size'  => $font_logo_size,
			'face'  => $font_logo_face,
			'style' => $font_logo_style,
			'color' => $font_logo_color,
		),
		'description' => sprintf( __("For 'Plain Text' Logo option. Site Title can be changed via %sWordPress Settings%s.", 'dispatch-premium'), '<a href="' . esc_url( admin_url('options-general.php') ) . '" target="_blank">', '</a>' ),
	);

	$settings['font_tagline'] = array(
		'label'       => __( 'Logo Tagline', 'dispatch-premium' ),
		'section'     => $section,
		'type'        => 'typography',
		'default'     => array(
			'size'  => $font_tagline_size,
			'face'  => $font_tagline_face,
			'style' => $font_tagline_style,
			'color' => $font_tagline_color,
		),
		'description' => sprintf( __("For 'Plain Text' Logo option. Site Tagline can be changed via %sWordPress Settings%s.", 'dispatch-premium'), '<a href="' . esc_url( admin_url('options-general.php') ) . '" target="_blank">', '</a>' ),
	);

	$settings['font_nav_menu'] = array(
		'label'       => __( 'Menu Font', 'dispatch-premium' ),
		'section'     => $section,
		'type'        => 'typography',
		'default'     => array(
			'size'  => $font_nav_menu_size,
			'face'  => $font_nav_menu_face,
			'style' => $font_nav_menu_style,
			'color' => $font_nav_menu_color,
		),
	);

	$settings['font_nav_dropdown'] = array(
		'label'       => __( 'Menu Dropdown Font', 'dispatch-premium' ),
		'section'     => $section,
		'type'        => 'typography',
		'default'     => array(
			'size'  => $font_nav_dropdown_size,
			'style' => $font_nav_dropdown_style,
			'color' => $font_nav_dropdown_color,
		),
		'options'     => array( 'size', 'style', 'color' ),
	);

	$settings['font_body'] = array(
		'label'       => __( 'Body Content', 'dispatch-premium' ),
		'section'     => $section,
		'type'        => 'typography',
		'default'     => array(
			'size'  => $font_body_size,
			'face'  => $font_body_face,
			'style' => $font_body_style,
			'color' => $font_body_color,
		),
	);

	$settings['link_color'] = array(
		'label'       => __( 'Link Color', 'dispatch-premium' ),
		'section'     => $section,
		'type'        => 'color',
		'default'     => $link_color,
	);

	$settings['link_hover_color'] = array(
		'label'       => __( 'Link Hover Color', 'dispatch-premium' ),
		'section'     => $section,
		'type'        => 'color',
		'default'     => $link_hover_color,
	);

	$settings['font_h3'] = array(
		'label'       => __( 'General Headings (Heading 3)', 'dispatch-premium' ),
		'section'     => $section,
		'type'        => 'typography',
		'default'     => array(
			'size'  => $font_h3_size,
			'face'  => $font_h3_face,
			'style' => $font_h3_style,
			'color' => $font_h3_color,
		),
	);

	$settings['font_h1'] = array(
		'label'       => __( 'Heading 1', 'dispatch-premium' ),
		'section'     => $section,
		'type'        => 'typography',
		'default'     => array(
			'size'  => $font_h1_size,
			'style' => $font_h1_style,
			'color' => $font_h1_color,
		),
		'options'     => array( 'size', 'style', 'color' ),
	);

	$settings['font_h2'] = array(
		'label'       => __( 'Heading 2', 'dispatch-premium' ),
		'section'     => $section,
		'type'        => 'typography',
		'default'     => array(
			'size'  => $font_h2_size,
			'style' => $font_h2_style,
			'color' => $font_h2_color,
		),
		'options'     => array( 'size', 'style', 'color' ),
	);

	$settings['font_h4'] = array(
		'label'       => __( 'Heading 4', 'dispatch-premium' ),
		'section'     => $section,
		'type'        => 'typography',
		'default'     => array(
			'size'  => $font_h4_size,
			'style' => $font_h4_style,
			'color' => $font_h4_color,
		),
		'options'     => array( 'size', 'style', 'color' ),
	);

	$settings['font_h5'] = array(
		'label'       => __( 'Heading 5', 'dispatch-premium' ),
		'section'     => $section,
		'type'        => 'typography',
		'default'     => array(
			'size'  => $font_h5_size,
			'style' => $font_h5_style,
			'color' => $font_h5_color,
		),
		'options'     => array( 'size', 'style', 'color' ),
	);

	$settings['font_h6'] = array(
		'label'       => __( 'Heading 6', 'dispatch-premium' ),
		'section'     => $section,
		'type'        => 'typography',
		'default'     => array(
			'size'  => $font_h6_size,
			'style' => $font_h6_style,
			'color' => $font_h6_color,
		),
		'options'     => array( 'size', 'style', 'color' ),
	);

	$settings['font_sidebar_heading'] = array(
		'label'       => __( 'Sidebar Widget Heading', 'dispatch-premium' ),
		'section'     => $section,
		'type'        => 'typography',
		'default'     => array(
			'size'  => $font_sidebar_heading_size,
			'face'  => $font_sidebar_heading_face,
			'style' => $font_sidebar_heading_style,
			'color' => $font_sidebar_heading_color,
		),
	);

	$settings['font_sidebar'] = array(
		'label'       => __( 'Sidebar Widget Text', 'dispatch-premium' ),
		'section'     => $section,
		'type'        => 'typography',
		'default'     => array(
			'size'  => $font_sidebar_size,
			'style' => $font_sidebar_style,
			'color' => $font_sidebar_color,
		),
		'options'     => array( 'size', 'style', 'color' ),
	);

	$settings['font_footer_heading'] = array(
		'label'       => __( 'Footer Widget Heading', 'dispatch-premium' ),
		'section'     => $section,
		'type'        => 'typography',
		'default'     => array(
			'size'  => $font_footer_heading_size,
			'face'  => $font_footer_heading_face,
			'style' => $font_footer_heading_style,
			'color' => $font_footer_heading_color,
		),
	);

	$settings['font_footer'] = array(
		'label'       => __( 'Footer Widget Text', 'dispatch-premium' ),
		'section'     => $section,
		'type'        => 'typography',
		'default'     => array(
			'size'  => $font_footer_size,
			'style' => $font_footer_style,
			'color' => $font_footer_color,
		),
		'options'     => array( 'size', 'style', 'color' ),
	);

	/** Section **/

	$section = 'slider_html';

	$settings['wt_cpt_slider_a'] = array(
		'label'       => __( 'Select a Slider', 'dispatch-premium' ),
		'section'     => $section,
		'type'        => 'select',
		'choices'     => Hoot_Options_Helper::cpt( 'hoot_slider', false, __( 'Select Slider', 'dispatch-premium' ) ),
		'description' => sprintf( __('You can Create New Sliders from the %sAdd New Slider%s screen.', 'dispatch-premium'), '<a href="' . esc_url( admin_url('post-new.php?post_type=hoot_slider') ) . '" target="_blank">', '</a>' ),
	);

	/** Section **/

	$section = 'slider_img';

	$settings['wt_cpt_slider_b'] = array(
		'label'       => __( 'Select a Slider', 'dispatch-premium' ),
		'section'     => $section,
		'type'        => 'select',
		'choices'     => Hoot_Options_Helper::cpt( 'hoot_slider', false, __( 'Select Slider', 'dispatch-premium' ) ),
		'description' => sprintf( __('You can Create New Sliders from the %sAdd New Slider%s screen.', 'dispatch-premium'), '<a href="' . esc_url( admin_url('post-new.php?post_type=hoot_slider') ) . '" target="_blank">', '</a>' ),
	);

	/** Section **/

	$section = 'archives';

	$settings['archive_type'] = array(
		'label'       => __( 'Archive (Blog) Layout', 'dispatch-premium' ),
		'section'     => $section,
		'type'        => 'radioimage',
		'priority'    => '385',
		'choices'     => array(
			'big'     => $imagepath . 'archive-big.png',
			'medium'  => $imagepath . 'archive-medium.png',
			'small'   => $imagepath . 'archive-small.png',
			'mosaic2' => $imagepath . 'archive-mosaic2.png',
			'mosaic3' => $imagepath . 'archive-mosaic3.png',
			// 'mosaic4' => $imagepath . 'archive-mosaic4.png',
		),
		'default'     => 'big',
		'description' => __("Set the post style for archive pages like your Blog.<hr>* Big Image<br />* Medium Image (Non Cropped)<br />* Small Image (Cropped)<br />* Mosaic 2 column<br />* Mosaic 3 column", 'dispatch-premium'),
	);

	if ( current_theme_supports( 'custom-404' ) ) :

		/** Section **/

		$section = 'page_404';

		$sections[ $section ] = array(
			'title'       => __( '404 Page', 'dispatch-premium' ),
			'priority'    => '47',
		);

		$settings['404_page'] = array(
			'label'       => __( '404 (Not Found) Page', 'dispatch-premium' ),
			'section'     => $section,
			'type'        => 'radio',
			'choices'     => array(
				'default' => __( "Theme's default 404 page", 'dispatch-premium' ),
				'custom' => __( 'Custom 404 page', 'dispatch-premium' ),
			),
			'default'     => 'default',
		);

		$settings['404_custom_page'] = array(
			'label'           => __( 'Custom 404 Page Content', 'dispatch-premium' ),
			'section'         => $section,
			'type'            => 'select',
			'choices'         => Hoot_Options_Helper::pages(),
			'description'     => __( 'Select a custom page to be used as content for the 404 Not Found page', 'dispatch-premium' ),
			'active_callback' => 'hoot_callback_404_custom_page',
		);

	endif;

	/** Section **/

	$section = 'code';

	$sections[ $section ] = array(
		'title'       => __( 'Custom Code', 'dispatch-premium' ),
	);

	$exist_custom_css = hoot_get_mod( 'custom_css' );
	if ( !empty( $exist_custom_css ) ) :

		$settings['custom_css'] = array(
			'label'       => __( 'Custom CSS', 'dispatch-premium' ),
			'section'     => $section,
			'type'        => 'textarea',
			'priority'    => '1805', // Non static options must have a priority
			'description' => __( 'You can add any custom CSS snippets here. These settings will stay unaffected by Theme updates', 'dispatch-premium' ),
		);

		$settings['custom_responsive_css'] = array(
			'label'       => __( 'Custom Responsive CSS (for Mobile)', 'dispatch-premium' ),
			'section'     => $section,
			'type'        => 'textarea',
			'priority'    => '1805', // Non static options must have a priority
			'description' => __( 'You can add any custom CSS snippets here for Mobile. These settings will stay unaffected by Theme updates', 'dispatch-premium' ),
		);

	endif;

	$settings['custom_js'] = array(
		'label'       => __( 'Custom Javascript (Google Analytics Code)', 'dispatch-premium' ),
		'section'     => $section,
		'type'        => 'textarea',
		'description' => __( 'You can add custom JS snippets (like Google Analytics code) here. These settings will stay unaffected by Theme updates', 'dispatch-premium' ),
		'sanitize_callback' => 'hoot_custom_sanitize_textarea_allowscript',
	);

	$settings['custom_js_inheader'] = array(
		'label'       => __( 'Include Custom Javascript in Header', 'dispatch-premium' ),
		'sublabel'    => __( 'By default, javascript is added in footer.', 'dispatch-premium' ),
		'section'     => $section,
		'type'        => 'checkbox',
		'description' => __( 'Check this if you want to include it in <code>&lt;head&gt;</code> tag.<br />This can be useful for adding scripts like <strong>Google Analytics</strong> code.', 'dispatch-premium' ),
	);

	/*** Return Options Array ***/
	return apply_filters( 'hoot_premium_customizer_options', array(
		'settings' => $settings,
		'sections' => $sections,
		'panels'   => $panels,
	) );

}
endif;

/**
 * Add Options (settings, sections and panels) to Hoot_Customizer class options object
 *
 * @since 2.0
 * @access public
 * @return void
 */
if ( !function_exists( 'hoot_premium_add_customizer_options' ) ) :
function hoot_premium_add_customizer_options() {

	$hoot_customizer = Hoot_Customizer::get_instance();

	// Modify Lite version Options

	// Deprecated. Added to 'hoot_theme_customizer_options' filter as we avoid using
	// recursive merge as unfortunately a lot of users are still on PHP < 5.3
	// $mergesettings = $mergesections = array();
	// $mergesettings['load_minified']['section'] = 'tweaks';
	// $mergesettings['widgetized_template_sections']['choices']['slider_html'] =
	// $mergesections['slider_html']['title'] = __('Widgetized Template - Slider A', 'dispatch-premium');
	// $mergesettings['widgetized_template_sections']['choices']['slider_img'] =
	// $mergesections['slider_img']['title'] = __('Widgetized Template - Slider B', 'dispatch-premium');

	// $hoot_customizer->edit_settings( $mergesettings, 'recursive' );
	// $hoot_customizer->edit_sections( $mergesections, 'recursive' );

	$hoot_customizer->remove_settings( 'logo_size' );
	$hoot_customizer->remove_settings( array( 'wt_html_slider' ) );
	$hoot_customizer->remove_settings( 'wt_img_slider' );

	// Add Options
	$options = hoot_premium_customizer_options();
	$hoot_customizer->add_options( array(
		'settings' => $options['settings'],
		'sections' => $options['sections'],
		'panels' => $options['panels'],
		) );

	// Remove Premium infobutton
	$hoot_customizer->remove_infobuttons( 'premium' );

}
endif;
add_action( 'init', 'hoot_premium_add_customizer_options', 0 ); // cannot hook into 'after_setup_theme' as this hook is already being executed (this file is loaded at after_setup_theme @priority 10) (hooking into same hook from within while hook is being executed leads to undesirable effects as $GLOBALS[$wp_filter]['after_setup_theme'] has already been ksorted)
// Hence, we hook into 'init' @priority 0, so that settings array gets populated before 'widgets_init' action ( which itself is hooked to 'init' at priority 1 ) for creating widget areas ( settings array is needed for creating defaults when user value has not been stored )
// Since this file is loaded after lite version, hoot_premium_add_customizer_options() will execute after hoot_add_customizer_options() even if we set same priority 0 [can be added at later priority to ensure loading after lite version settings as premium does not contain settings needed for registering widget areas during widgets_init hook]

/**
 * Modify default WordPress Settings Sections and Panels
 *
 * @since 4.1
 * @param object $wp_customize
 * @return void
 */
function hoot_premium_customizer_modify_default_options( $wp_customize ) {

	if ( function_exists( 'wp_get_custom_css' ) )
		$wp_customize->get_control( 'custom_css' )->section = 'code';

}
add_action( 'customize_register', 'hoot_premium_customizer_modify_default_options', 100 );

/**
 * Modify Options array directly
 *
 * @since 2.0
 * @access public
 * @return void
 */
function hoot_theme_modify_customizer_options( $options ) {

	for ( $slide = 1; $slide <= 4; $slide++ ) {
		unset( $options['settings']["wt_html_slide_{$slide}"] );
		unset( $options['settings']["wt_html_slide_{$slide}-background"] );
		unset( $options['settings']["wt_img_slide_{$slide}"] );
	}

	// $options['settings']['load_minified']['section'] = 'tweaks';
	// $options['settings']['load_minified']['priority'] = '1825';
	$options['sections']['colors']['description'] =
	$options['sections']['backgrounds']['description'] = '';
	$options['settings']['widgetized_template_sections']['choices']['slider_html'] = __( 'Slider A', 'dispatch-premium');
	$options['sections']['slider_html']['title'] = __('Widgetized Template - Slider A', 'dispatch-premium');
	$options['settings']['widgetized_template_sections']['choices']['slider_img'] = __( 'Slider B', 'dispatch-premium');
	$options['sections']['slider_img']['title'] = __('Widgetized Template - Slider B', 'dispatch-premium');

	return $options;
}
add_filter( 'hoot_theme_customizer_options', 'hoot_theme_modify_customizer_options', 9 );

/**
 * Add theme specific option specific css
 *
 * @since 4.1
 * @access public
 * @return void
 */
function hoot_theme_premium_customizer_inlinecss() {
	echo '<style>' . '#customize-control-header_background{margin-top:-15px;}#customize-control-header_background .customize-control-title{font-size:12px;}' . '</style>';
}
add_action( 'customize_controls_print_styles', 'hoot_theme_premium_customizer_inlinecss' );

/**
 * Callback Functions for customizer settings
 */

function hoot_callback_header_background( $control ) {
	$selector = $control->manager->get_setting('header_background_type')->value();
	return ( $selector == 'background' ) ? true : false;
}

function hoot_callback_404_custom_page( $control ) {
	$selector = $control->manager->get_setting('404_page')->value();
	return ( $selector == 'custom' ) ? true : false;
}