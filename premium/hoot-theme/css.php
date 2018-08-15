<?php
/**
 * Add custom css to frontend.
 *
 * @package hoot
 * @subpackage dispatch
 * @since dispatch 1.0
 */

/* Add CSS built from premium options to the dynamic CSS array */
add_action( 'hoot_dynamic_cssrules', 'hoot_premium_dynamic_cssrules', 9 );

/* Add user input Custom CSS */
add_filter( 'hoot_dynamic_css', 'hoot_premium_custom_user_css', 6, 2 );

/**
 * Custom CSS built from user premium theme options
 * For proper sanitization, always use functions from hoot/includes/sanitization.php
 * and hoot/customizer/sanitization.php
 *
 * @since 1.0
 * @access public
 * @param array $cssrules array of css rules
 * @param array $vars misc option values
 * @return array
 */
function hoot_premium_dynamic_cssrules( $cssrules, $vars = array() ) {

	/*** Settings Values ***/

	/* Lite Settings */

	$settings = array();
	// $settings['grid_width']           = intval( hoot_get_mod( 'site_width' ) ) . 'px';
	$settings['accent_color']         = hoot_get_mod( 'accent_color' );
	$settings['accent_color_dark']    = hoot_color_increase( $settings['accent_color'], 20, 20 );
	$settings['accent_font']          = hoot_get_mod( 'accent_font' );
	$settings['site_layout']          = hoot_get_mod( 'site_layout' );
	$settings['box_background_color'] = hoot_get_mod( 'box_background-color' );
	$settings['content_bg_color']     = ( $settings['site_layout'] == 'boxed' ) ?
	                                        $settings['box_background_color'] :
	                                        hoot_get_mod( 'background-color' );

	/* Premium Settings */

	$settings['contrast_color']           = hoot_get_mod( 'contrast_color' );
	$settings['contrast_font']            = hoot_get_mod( 'contrast_font' );
	$settings['highlight_color']          = hoot_get_mod( 'highlight_color' ); // Sample: #f1f1f1
	$settings['highlight_color_tone']     = hoot_color_increase( $settings['highlight_color'], 8.2 ); // Sample: #dddddd
	$settings['topbar_color']             = hoot_get_mod( 'topbar_color' );
	$settings['font_body_size']           = hoot_get_mod( 'font_body-size' );
	$settings['font_body_face']           = hoot_get_mod( 'font_body-face' );
	$settings['font_body_color']          = hoot_get_mod( 'font_body-color' ); // Sample: #444444
	$settings['font_body_light']          = hoot_color_increase( $settings['font_body_color'], 18, 18 ); // Sample: #666666
	$settings['font_body_lighter']        = hoot_color_increase( $settings['font_body_color'], 36.5, 36.5 ); // Sample: #888888
	// $settings['font_h1_size']             = hoot_get_mod( 'font_h1-size' );
	$settings['font_h3_size']             = hoot_get_mod( 'font_h3-size' );
	$settings['font_h3_face']             = hoot_get_mod( 'font_h3-face' );
	$settings['font_h6_size']             = hoot_get_mod( 'font_h6-size' );
	$settings['font_logo_size']           = hoot_get_mod( 'font_logo-size' );
	$settings['font_nav_dropdown_color']  = hoot_get_mod( 'font_nav_dropdown-color' );
	$settings['link_color']               = hoot_get_mod( 'link_color' );
	$settings['link_hover_color']         = hoot_get_mod( 'link_hover_color' );
	$settings['topbar_background']        = hoot_get_mod( 'topbar_background' );
	$settings['header_background_type']   = hoot_get_mod( 'header_background_type' );
	$settings['header_background']        = hoot_get_mod( 'header_background' );
	// $settings['logo_background_type']     = hoot_get_mod( 'logo_background_type' );
	// $settings['logo_background']          = hoot_get_mod( 'logo_background' );
	$settings['menu_icons_color']         = hoot_get_mod( 'menu_icons_color' );
	$settings['menu_dropdown_background'] = hoot_get_mod( 'menu_dropdown_background' ); // Sample: '#000000'
	$settings['menu_dropdown_highlight']  = hoot_color_increase( $settings['menu_dropdown_background'], 13.5 ); // Sample: #222222
	$settings['font_footer_color']        = hoot_get_mod( 'font_footer-color' ); // Sample: '#ffffff'
	$settings['font_footer_dark']         = hoot_color_increase( $settings['font_footer_color'], 40 ); // Sample: #999999
	$settings['font_footer_darker']       = hoot_color_increase( $settings['font_footer_color'], 53.5 ); // Sample: #777777

	extract( apply_filters( 'hoot_custom_css_settings', $settings, 'premium' ) );

	/*** Add Dynamic CSS ***/

	/* Base Typography and HTML */

	hoot_add_css_rule( array(
						'selector'  => 'body',
						'property'  => 'typography',
						'idtag'     => 'font_body',
					) );

	hoot_add_css_rule( array(
						'selector'         => 'h1, h2, h3, h4, h5, h6, .title',
						'property'         => 'typography',
						'idtag'            => 'font_h3',
						'typography_reset' => true,
					) );

	hoot_add_css_rule( array(
						'selector'         => 'h1',
						'property'         => 'typography',
						'idtag'            => 'font_h1',
						'typography_reset' => true,
					) );

	hoot_add_css_rule( array(
						'selector'         => 'h2',
						'property'         => 'typography',
						'idtag'            => 'font_h2',
						'typography_reset' => true,
					) );

	hoot_add_css_rule( array(
						'selector'         => 'h4',
						'property'         => 'typography',
						'idtag'            => 'font_h4',
						'typography_reset' => true,
					) );

	hoot_add_css_rule( array(
						'selector'         => 'h5',
						'property'         => 'typography',
						'idtag'            => 'font_h5',
						'typography_reset' => true,
					) );

	hoot_add_css_rule( array(
						'selector'         => 'h6',
						'property'         => 'typography',
						'idtag'            => 'font_h6',
						'typography_reset' => true,
					) );

	// Redundant: Already added above in 'h1, h2, h3, h4, h5, h6, .title' to use font_h3 typography
	// hoot_add_css_rule( array(
	// 					'selector'  => '.title',
	// 					'property'  => 'font-size',
	// 					'value'     => $font_h3_size,
	// 					'idtag'     => 'font_h3-size',
	// 				) );

	hoot_add_css_rule( array(
						'selector'  => '.titlefont',
						'property'  => 'font-family',
						'value'     => $font_h3_face,
						'idtag'     => 'font_h3-face',
					) );

	hoot_add_css_rule( array(
						'selector'  => '.bodyfont-title',
						'property'  => array(
							'font-family' => array( $font_body_face, 'font_body-face' ),
							'font-size'   => array( $font_body_size, 'font_body-size' ),
							),
					) );

	hoot_add_css_rule( array(
						'selector'  => 'blockquote',
						'property'  => array(
							'border-color' => array( $highlight_color_tone ),
							'color'        => array( $font_body_lighter ),
							'font-size'    => array( $font_h6_size, 'font_h6-size' ),
							),
					) );

	hoot_add_css_rule( array(
						'selector'  => 'a',
						'property'  => 'color',
						'value'     => $link_color,
						'idtag'     => 'link_color',
					) ); // Overriding non premium dynamic css

	hoot_add_css_rule( array(
						'selector'  => 'a:hover',
						'property'  => 'color',
						'value'     => $link_hover_color,
						'idtag'     => 'link_hover_color',
					) );

	hoot_add_css_rule( array(
						'selector'  => '.contrast-typo',
						'property'  => array(
							'background' => array( $contrast_color, 'contrast_color' ),
							'color'      => array( $contrast_font, 'contrast_font' ),
							),
					) );

	hoot_add_css_rule( array(
						'selector'  => '.contrast-typo a, .contrast-typo a:hover, .contrast-typo h1, .contrast-typo h2, .contrast-typo h3, .contrast-typo h4, .contrast-typo h5, .contrast-typo h6, .contrast-typo .title',
						'property'  => 'color',
						'value'     => $contrast_font,
					) );

	hoot_add_css_rule( array(
						'selector'  => '.enforce-typo',
						'property'  => array(
							'background' => array( $content_bg_color ),
							'color'      => array( $font_body_color, 'font_body_color' ),
							),
					) );

	hoot_add_css_rule( array(
						'selector'  => '.enforce-typo a, .enforce-typo a:hover, .enforce-typo h1, .enforce-typo h2, .enforce-typo h3, .enforce-typo h4, .enforce-typo h5, .enforce-typo h6, .enforce-typo .title',
						'property'  => 'color',
						'value'     => $font_body_color,
						'idtag'     => 'font_body_color',
					) );

	hoot_add_css_rule( array(
						'selector'  => '.enforce-body-font',
						'property'  => 'font-family',
						'value'     => $font_body_face,
						'idtag'     => 'font_body-face',
					) );

	hoot_add_css_rule( array(
						'selector'  => '.table-striped tbody tr:nth-child(odd) td, .table-striped tbody tr:nth-child(odd) th',
						'property'  => 'background',
						'value'     => $highlight_color,
						'idtag'     => 'highlight_color',
					) );

	/* Images, WP Gallery and Objects */

	hoot_add_css_rule( array(
						'selector'  => '.gallery',
						'property'  => array(
							'border-color' => array( $highlight_color_tone ),
							'background'   => array( $highlight_color, 'highlight_color' ),
							),
					) );

	hoot_add_css_rule( array(
						'selector'  => '.gallery .gallery-caption',
						'property'  => 'color',
						'value'     => $font_body_color,
						'idtag'     => 'font_body_color',
					) );

	hoot_add_css_rule( array(
						'selector'  => '.wp-caption',
						'property'  => 'background',
						'value'     => $highlight_color,
						'idtag'     => 'highlight_color',
					) );

	hoot_add_css_rule( array(
						'selector'  => '.wp-caption-text',
						'property'  => array(
							'border-color' => array( $highlight_color_tone ),
							'color'        => array( $font_body_color, 'font_body_color' ),
							),
					) );

	/* Header (Topbar, Header, Main Nav Menu) */
	// Topbar

	hoot_add_css_rule( array(
						'selector'  => '#topbar',
						'property'  => array(
							//'color'      => array( $font_body_lighter ),
							'background' => array( $topbar_background, 'topbar_background' ),
							),
					) );

	hoot_add_css_rule( array(
						'selector'  => '#topbar-left',
						'property'  => array(
							'color'      => array( $topbar_color ),
							// 'background' => array( $topbar_background, 'topbar_background' ),
							),
					) );

	hoot_add_css_rule( array(
						'selector'  => '#topbar-right-inner' . ', ' . '#topbar-right-inner input',
						'property'  => 'color',
						'value'     => $font_body_color,
					) );

	hoot_add_css_rule( array(
						'selector'  => '#topbar .widget-title',
						'property'  => 'font-size',
						'value'     => $font_body_size,
						'idtag'     => 'font_body-size',
					) );

	/* Header (Topbar, Header, Main Nav Menu) */
	// Header

	if ( $header_background_type == 'background' ) {
		hoot_add_css_rule( array(
						'selector'  => '#header',
						'property'  => 'background',
						'value'     => $header_background,
						'idtag'     => 'header_background',
					) );
	} elseif ( $header_background_type == 'transparent' ) {
		hoot_add_css_rule( array(
						'selector'  => '#header',
						'property'  => 'background',
						'value'     => 'none',
					) );
		hoot_add_css_rule( array(
						'selector'  => '#header.stuck',
						'property'  => 'background',
						'value'     => $content_bg_color,
					) );
	}

	/* Header (Topbar, Header, Main Nav Menu) */
	// Logo

	hoot_add_css_rule( array(
						'selector'         => '#site-title',
						'property'         => 'typography',
						'idtag'            => 'font_logo',
						'typography_reset' => true,
					) );

	hoot_add_css_rule( array(
						'selector'  => '#site-description',
						'property'  => array(
							// property  => array( value, idtag, important, typography_reset ),
							'opacity'    => array( '1' ), // Reset styles from stylesheets
							'typography' => array( '', 'font_tagline', false, true ),
							),
					) );

	/* Menu */

	hoot_add_css_rule( array(
						'selector'         => '#menu-primary-items > li a',
						'property'         => 'typography',
						'idtag'            => 'font_nav_menu',
						'typography_reset' => true,
					) );

	hoot_add_css_rule( array(
						'selector'  => '.site-header .hoot-megamenu-icon',
						'property'  => 'color',
						'value'     => $menu_icons_color,
						'idtag'     => 'menu_icons_color',
					) );

	hoot_add_css_rule( array(
						'selector'         => '#menu-primary-items > li ul a, #menu-primary-items ul li:hover > a' . ',' . '.mobilemenu-fixed .menu-toggle',
						'property'         => 'typography',
						'idtag'            => 'font_nav_dropdown',
						'typography_reset' => true,
					) );

	hoot_add_css_rule( array(
						'selector'  => '.sf-menu ul',
						'property'  => 'background-color',
						'value'     => $menu_dropdown_background,
						'idtag'     => 'menu_dropdown_background',
					) );

	hoot_add_css_rule( array(
						'selector'  => '.sf-menu ul li:hover',
						'property'  => 'background',
						'value'     => $menu_dropdown_highlight,
					) );

	hoot_add_css_rule( array(
						'selector'  => '.menu-toggle',
						'property'  => array(
							// property  => array( value, idtag, important, typography_reset ),
							'background' => array( $menu_dropdown_highlight ),
							'typography' => array( '', 'font_nav_dropdown', false, true ),
							),
					) );

	hoot_add_css_rule( array(
						'selector'  => '.mobilemenu-fixed .menu-toggle',
						'property'  => 'background',
						'value'     => $menu_dropdown_highlight,
					) );

	hoot_add_css_rule( array(
						'selector'  => '#menu-primary-items',
						'property'  => 'background',
						'value'     => $menu_dropdown_highlight,
						'media'     => 'only screen and (max-width: 799px)',
					) );

	hoot_add_css_rule( array(
						'selector'  => '#menu-primary-items ul',
						'property'  => 'background',
						'value'     => $menu_dropdown_highlight,
						'media'     => 'only screen and (max-width: 799px)',
					) );

	hoot_add_css_rule( array(
						'selector'         => '#menu-primary-items > li a',
						'property'         => 'typography',
						'idtag'            => 'font_nav_dropdown',
						'typography_reset' => false,
						'media'            => 'only screen and (max-width: 799px)',
					) );

	hoot_add_css_rule( array(
						'selector'  => '.sf-menu a:hover',
						'property'  => 'background',
						'value'     => $menu_dropdown_background,
						'idtag'     => 'menu_dropdown_background',
						'media'     => 'only screen and (max-width: 799px)',
					) );

	/* Main #Content */

	hoot_add_css_rule( array(
						'selector'  => '#loop-meta',
						'property'  => 'background',
						'idtag'     => 'pageheader_background',
					) );

	hoot_add_css_rule( array(
						'selector'         => '.loop-title',
						'property'         => 'typography',
						'idtag'            => 'font_h3',
						'typography_reset' => true,
					) );

	hoot_add_css_rule( array(
						'selector'  => '.entry-byline-block',
						'property'  => 'border-color',
						'value'     => $font_body_lighter,
					) );

	hoot_add_css_rule( array(
						'selector'  => '.entry-byline a, .entry-byline a:hover',
						'property'  => 'color',
						'value'     => $font_body_color,
						'idtag'     => 'font_body_color',
					) );

	hoot_add_css_rule( array(
						'selector'  => '.entry-content',
						'property'  => array(
							'-webkit-box-shadow' => array( '5px 5px 0 0 ' . $highlight_color ),
							'-moz-box-shadow'    => array( '5px 5px 0 0 ' . $highlight_color ),
							'box-shadow'         => array( '5px 5px 0 0 ' . $highlight_color ),
							'border-color'       => array( $highlight_color_tone ),
							),
					) );

	hoot_add_css_rule( array(
						'selector'  => '#comments-template',
						'property'  => 'border-color',
						'value'     => $highlight_color_tone,
					) );

	hoot_add_css_rule( array(
						'selector'  => '#comments-number',
						'property'  => 'font-size',
						'value'     => $font_body_size,
						'idtag'     => 'font_body-size',
					) );

	hoot_add_css_rule( array(
						'selector'  => '.comment li.comment',
						'property'  => 'border-color',
						'value'     => $highlight_color_tone,
					) );

	hoot_add_css_rule( array(
						'selector'  => '.comment-by-author',
						'property'  => 'color',
						'value'     => $font_body_lighter,
					) );

	hoot_add_css_rule( array(
						'selector'  => '.comment-meta-block, .comment-edit-link',
						'property'  => array(
							'color'        => array( $font_body_lighter ),
							'border-color' => array( $font_body_lighter ),
							),
					) );

	hoot_add_css_rule( array(
						'selector'  => '.comment.bypostauthor > article',
						'property'  => 'background',
						'value'     => $highlight_color,
						'idtag'     => 'highlight_color',
					) );

	hoot_add_css_rule( array(
						'selector'  => '.comment.bypostauthor + #respond',
						'property'  => 'background',
						'value'     => $highlight_color,
						'idtag'     => 'highlight_color',
					) );

	hoot_add_css_rule( array(
						'selector'  => '.comment-ping',
						'property'  => 'border-color',
						'value'     => $highlight_color_tone,
					) );

	hoot_add_css_rule( array(
						'selector'  => '#reply-title',
						'property'  => 'font-size',
						'value'     => $font_body_size,
						'idtag'     => 'font_body-size',
					) );

	hoot_add_css_rule( array(
						'selector'  => '#respond label',
						'property'  => 'color',
						'value'     => $font_body_lighter,
					) );

	/* Main #Content for Index (Archive / Blog List) */

	hoot_add_css_rule( array(
						'selector'  => '.entry-grid',
						'property'  => array(
							'-webkit-box-shadow' => array( '5px 5px 0 0 ' . $highlight_color ),
							'-moz-box-shadow'    => array( '5px 5px 0 0 ' . $highlight_color ),
							'box-shadow'         => array( '5px 5px 0 0 ' . $highlight_color ),
							'border-color'       => array( $highlight_color_tone ),
							),
					) );

	hoot_add_css_rule( array(
						'selector'  => '.entry-grid-content .entry-title',
						'property'  => 'font-size',
						'value'     => $font_h3_size,
						'idtag'     => 'font_h3-size',
					) );

	hoot_add_css_rule( array(
						'selector'  => '.entry-grid .entry-byline',
						'property'  => 'color',
						'value'     => $font_body_lighter,
					) );

	hoot_add_css_rule( array(
						'selector'  => '.entry-grid .entry-byline-block a, .entry-grid .entry-byline-block a:hover',
						'property'  => 'color',
						'value'     => $font_body_lighter,
					) );

	hoot_add_css_rule( array(
						'selector'  => '.archive-mosaic .entry-title',
						'property'  => 'font-size',
						'value'     => $font_h6_size,
						'idtag'     => 'font_h6-size',
					) );

	hoot_add_css_rule( array(
						'selector'  => '.archive-mosaic .mosaic-sub',
						'property'  => array(
							'background'   => array( $highlight_color, 'highlight_color' ),
							'border-color' => array( $highlight_color_tone ),
							),
					) );

	/* Shortcodes */

	hoot_add_css_rule( array(
						'selector'  => '.style-accent, .shortcode-button.style-accent, .style-accentlight',
						'property'  => array(
							'background' => array( $accent_color, 'accent_color' ),
							'color'      => array( $accent_font, 'accent_font' ),
							),
					) );

	hoot_add_css_rule( array(
						'selector'  => '.shortcode-button.style-accent:hover',
						'property'  => array(
							'background' => array( $accent_color_dark ),
							'color'      => array( $accent_font, 'accent_font' ),
							),
					) );

	hoot_add_css_rule( array(
						'selector'  => '.style-highlight, .style-highlightlight',
						'property'  => 'background',
						'value'     => $highlight_color,
						'idtag'     => 'highlight_color',
					) );

	hoot_add_css_rule( array(
						'selector'  => '.shortcode-toggle-head',
						'property'  => array(
							'background'   => array( $highlight_color, 'highlight_color' ),
							'border-color' => array( $highlight_color_tone ),
							),
					) );

	hoot_add_css_rule( array(
						'selector'  => '.shortcode-toggle-head:hover, .shortcode-toggle-active',
						'property'  => 'background',
						'value'     => $highlight_color_tone,
					) );

	hoot_add_css_rule( array(
						'selector'  => '.shortcode-toggle-box',
						'property'  => 'border-color',
						'value'     => $highlight_color_tone,
					) );

	hoot_add_css_rule( array(
						'selector'  => '#page-wrapper ul.shortcode-tabset-nav li',
						'property'  => array(
							'background'   => array( $highlight_color, 'highlight_color' ),
							'border-color' => array( $highlight_color_tone ),
							),
					) );

	hoot_add_css_rule( array(
						'selector'  => '#page-wrapper ul.shortcode-tabset-nav li.current',
						'property'  => 'border-bottom-color',
						'value'     => $content_bg_color,
					) );

	hoot_add_css_rule( array(
						'selector'  => '.shortcode-tabset-box',
						'property'  => 'border-color',
						'value'     => $highlight_color_tone,
					) );

	/* Sliders */

	// Lets skip this, and let it stay in em
	// hoot_add_css_rule( array(
	// 					'selector'  => '.hootslider-carousel-slide .lightSlideCarousel h1, .hootslider-carousel-slide .lightSlideCarousel h2, .hootslider-carousel-slide .lightSlideCarousel h3, .hootslider-carousel-slide .lightSlideCarousel h4, .hootslider-carousel-slide .lightSlideCarousel h5, .hootslider-carousel-slide .lightSlideCarousel h6, .hootslider-carousel-slide .lightSlideCarousel .title',
	// 					'property'  => 'font-size',
	// 					'value'     => $font_body_size,
	// 					'idtag'     => 'font_body-size',
	// 				) );

	/* Page Templates */

	hoot_add_css_rule( array(
						'selector'  => '.widgetized-template-area.area-highlight',
						'property'  => 'background',
						'value'     => $highlight_color,
						'idtag'     => 'highlight_color',
					) );

	/* Sidebars and Widgets */

	hoot_add_css_rule( array(
						'selector'         => '.sidebar',
						'property'         => 'typography',
						'idtag'            => 'font_sidebar',
						'typography_reset' => true,
					) );

	hoot_add_css_rule( array(
						'selector'         => '.sidebar .widget-title',
						'property'         => 'typography',
						'idtag'            => 'font_sidebar_heading',
						'typography_reset' => true,
					) );

	hoot_add_css_rule( array(
						'selector'  => '.widget-title',
						'property'  => 'font-size',
						'value'     => $font_h6_size,
						'idtag'     => 'font_h6-size',
					) );

	hoot_add_css_rule( array(
						'selector'  => '.topborder-line',
						'property'  => 'border-color',
						'value'     => $highlight_color_tone,
					) );

	hoot_add_css_rule( array(
						'selector'  => '.bottomborder-line',
						'property'  => 'border-color',
						'value'     => $highlight_color_tone,
					) );

	hoot_add_css_rule( array(
						'selector'  => '.topborder-shadow:before, .bottomborder-shadow:after',
						'property'  => 'background-color',
						'value'     => $contrast_color,
					) );

	hoot_add_css_rule( array(
						'selector'  => '.cta-widget-button',
						'property'  => 'font-size',
						'value'     => $font_h6_size,
						'idtag'     => 'font_h6-size',
					) );

	hoot_add_css_rule( array(
						'selector'  => '.content-block-content h4',
						'property'  => 'font-size',
						'value'     => $font_h6_size,
						'idtag'     => 'font_h6-size',
					) );

	hoot_add_css_rule( array(
						'selector'  => '.content-blocks-style3 .content-block',
						'property'  => 'border-color',
						'value'     => $highlight_color_tone,
					) );

	hoot_add_css_rule( array(
						'selector'  => '.social-icons-icon',
						'property'  => array(
							'color'        => array( $font_body_light ),
							'border-color' => array( $highlight_color_tone ),
							),
					) );

	hoot_add_css_rule( array(
						'selector'  => '.hoot-blogposts .hoot-blogposts-title',
						'property'  => 'border-color',
						'value'     => $highlight_color_tone,
					) );

	/* Footer */

	hoot_add_css_rule( array(
						'selector'  => '#sub-footer',
						'property'  => array(
							'background'   => array( '', 'subfooter_background' ),
							'border-color' => array( $highlight_color_tone ),
							),
					) );

	hoot_add_css_rule( array(
						'selector'  => '.footer',
						'property'  => array(
							// property  => array( value, idtag, important, typography_reset ),
							'background'   => array( '', 'footer_background' ),
							'typography'   => array( '', 'font_footer', false, true ),
							),
					) );

	hoot_add_css_rule( array(
						'selector'  => '.footer h1, .footer h2, .footer h3, .footer h4, .footer h5, .footer h6, .footer .title',
						'property'  => 'color',
						'value'     => $font_footer_color,
						'idtag'     => 'font_footer-color',
					) );

	hoot_add_css_rule( array(
						'selector'  => '.footer a, .footer a:hover',
						'property'  => 'color',
						'value'     => $font_footer_color,
						'idtag'     => 'font_footer-color',
					) );

	hoot_add_css_rule( array(
						'selector'         => '.footer .widget-title',
						'property'         => 'typography',
						'idtag'            => 'font_footer_heading',
						'typography_reset' => true,
					) );

	hoot_add_css_rule( array(
						'selector'  => '#post-footer',
						'property'  => array(
							'background'   => array( '', 'footer_background' ),
							'color'        => array( $font_footer_dark ),
							),
					) );

	hoot_add_css_rule( array(
						'selector'  => '#post-footer a',
						'property'  => 'color',
						'value'     => $font_footer_darker,
					) );

}

/**
 * Add custom css rules added by user in Theme Options
 *
 * @since 1.0
 * @access public
 * @param string $css css string
 * @param array $vars misc option values
 * @return array
 */
function hoot_premium_custom_user_css( $css, $vars = array() ) {

	$custom_css = hoot_get_mod( 'custom_css', '' );
	$user_css = '';

	// Add Custom CSS
	if ( !empty( $custom_css ) ) {
		$user_css .= "\n" . htmlspecialchars_decode( $custom_css );
	}

	// Add Custom Responsive CSS
	$custom_responsive_css = hoot_get_mod( 'custom_responsive_css', '' );
	if ( !empty( $custom_responsive_css ) ) {
		if ( !empty( $custom_css ) ) // Added so that in WP>4.7, if no custom_css, WP's Custom CSS is used
		$user_css .= "\n" . '@media only screen and (max-width: 799px) {' . "\n"
				. htmlspecialchars_decode( $custom_responsive_css )
				. "\n" . '}';
	}

	// Add Custom Post/Page CSS
	if ( is_singular() ) {
		$page_css = hoot_get_meta_option( 'page_css' );
		$user_css .= ( !empty( $page_css ) ) ?  "\n" . $page_css : '';
	}

	// Add Custom CSS for page set as Blog Page
	if ( is_home() && !is_front_page() ) {
		$post_id = get_option( 'page_for_posts' );
		$page_css = hoot_get_meta_option( 'page_css', $post_id );
		$user_css .= ( !empty( $page_css ) ) ?  "\n" . $page_css : '';
	}

	// Add Custom CSS for page set as Shop Page
	if ( current_theme_supports( 'woocommerce' ) && is_shop() ) {
		$post_id = get_option( 'woocommerce_shop_page_id' );
		$page_css = hoot_get_meta_option( 'page_css', $post_id );
		$user_css .= ( !empty( $page_css ) ) ?  "\n" . $page_css : '';
	}

	// Allow child themes to modify and Return css string
	$user_css = apply_filters( 'hoot_premium_custom_user_css', $user_css, $css, $vars );
	return $css . $user_css;
}