<?php
/**
 * Miscellaneous template functions.
 * These functions are for use throughout the theme's various template files.
 * This file is loaded via the 'after_setup_theme' hook at priority '10'
 *
 * @package hoot
 * @subpackage dispatch
 * @since dispatch 1.0
 */

/**
 * Remove the filter added for lite version ( to hide title area on static frontpage not
 * using Widgetized Template ). Instead let premium meta option decide this.
 */
remove_filter( 'hoot_loop_meta_display_title', 'hoot_hide_loop_meta_static_frontpage' );

/**
 * Apply Sidebar Layout for Widgetized Template
 *
 * @since 2.0
 * @param bool $sidebar
 * @return string
 */
function hoot_premium_widgetized_template_sidebar( $sidebar ) {
	return hoot_get_meta_option( 'wt_sidebar', 0, 'none' );
}
add_filter( 'widgetized_template_sidebar', 'hoot_premium_widgetized_template_sidebar', 5 );

/**
 * Override sidebar layout for Widgetized Template
 *
 * @since 2.0
 * @param bool $sidebar
 * @return string
 */
function hoot_premium_main_layout_widgetized_template( $sidebar ) {
	if ( is_page_template() ) {
		$template_slug = basename( get_page_template(), '.php' );
		if ( $template_slug == 'template-widgetized' )
			$sidebar = hoot_get_meta_option( 'wt_sidebar' );
	}
	return $sidebar;
}
add_filter( 'hoot_main_layout', 'hoot_premium_main_layout_widgetized_template', 6 ); // Widgetized Template gets priority over custom page layout meta

/**
 * Apply Sidebar Layout for Archives and Blog page
 * Add it at earliest priority as this is core option
 *
 * @since 2.0
 * @param bool $sidebar
 * @return string
 */
function hoot_premium_main_layout_extension( $sidebar ) {

	if ( is_archive() || is_home() )
		$sidebar = hoot_get_mod( 'sidebar_archives' );

	return $sidebar;

}
add_filter( 'hoot_main_layout', 'hoot_premium_main_layout_extension', 5 );

/**
 * Override sidebar layout for individual page/post
 *
 * @since 2.0
 * @param bool $sidebar
 * @return string
 */
function hoot_premium_main_layout_single_page( $sidebar ) {
	if ( is_singular() ) {
		$type = hoot_get_meta_option( 'sidebar_type' );
		if ( 'custom' === $type )
			$sidebar = hoot_get_meta_option( 'sidebar' );
	}
	return $sidebar;
}
add_filter( 'hoot_main_layout', 'hoot_premium_main_layout_single_page', 5 );

/**
 * Use premium sliders to display slider
 *
 * @since 2.0
 * @param string $output
 * @param string $slider_op
 * @return string
 */
function hoot_premium_widgetized_template_slider( $output, $slider_op ) {
	$sliderID = hoot_get_mod( $slider_op );
	$output = do_shortcode( '[hoot_slider id="' . $sliderID . '"]' );
	if ( empty( $output ) )
		$output = ' '; // Do not return empty (needed for installations migrated from lite to premium as they still contain lite sliders theme mods)
	return $output;
}
add_filter( 'widgetized_template_slider', 'hoot_premium_widgetized_template_slider', 5, 2 );

/**
 * Define archive type selected in options
 *
 * @since 2.0
 * @param string $archive_type
 * @param string $context
 * @return string
 */
function hoot_premium_default_archive_type( $archive_type, $context = '' ) {
	$archive_type = hoot_get_mod( 'archive_type' );
	return $archive_type;
}
add_filter( 'hoot_default_archive_type', 'hoot_premium_default_archive_type', 5, 2 );

/**
 * Locate archive type template location
 *
 * @since 2.0
 * @param string $template
 * @param string $archive_type
 * @param string $context
 * @return string
 */
function hoot_premium_default_archive_location( $template, $archive_type, $context = '' ) {

	if ( $archive_type == 'big' ) {
		return $template;
	} else {
		$base_premium = str_replace( trailingslashit( THEME_DIR ), '', trailingslashit( PREMIUM_DIR ) );
		return $base_premium . $template;
	}

}
add_filter( 'hoot_default_archive_location', 'hoot_premium_default_archive_location', 5, 3 );


/**
 * Set location for premium sliders
 *
 * @since 2.0
 * @param string $type
 * @return void
 */
function hoot_premium_slider_location( $type ) {

	if ( $type == 'carousel' ) {
		global $hoot_theme;
		$base_premium = str_replace( trailingslashit( THEME_DIR ), '', trailingslashit( PREMIUM_DIR ) );
		$hoot_theme->sliderSettings['template'] = $base_premium . "template-parts/slider-{$type}";
	}

}
add_action( 'hoot_slider_loaded', 'hoot_premium_slider_location', 5 );

/**
 * Hide or display meta information for current page/post
 *
 * @since 2.0
 * @param string $hide
 * @param string $context
 * @return string
 */
function hoot_premium_hide_meta_info( $hide, $context ) {
	$hide = hoot_get_meta_option( 'meta_hide_info' );
	return $hide;
}
add_filter( 'hoot_hide_meta_info', 'hoot_premium_hide_meta_info', 5, 2 );

/**
 * Hide or display Page Loop Area for current page/post
 *
 * @since 2.0
 * @param string $value
 * @return string
 */
function hoot_premium_loop_meta_display_title( $value ) {
	if ( is_page() || is_singular( 'post' ) )
		$id = get_queried_object_id();
	elseif ( is_home() && !is_front_page() )
		$id = get_option( 'page_for_posts' );
	elseif ( current_theme_supports( 'woocommerce' ) && is_shop() )
		$id = get_option( 'woocommerce_shop_page_id' );
	else
		return $value;
	return hoot_get_meta_option( 'display_loop_meta', $id );
}
add_filter( 'hoot_loop_meta_display_title', 'hoot_premium_loop_meta_display_title', 5 );

/**
 * Hide or display Page Loop Area for Woocommerce Shop Page
 *
 * @since 3.0
 * @param string $value
 * @return string
 */
function hoot_premium_wooloop_meta_display_title( $value ) {
	if ( current_theme_supports( 'woocommerce' ) && is_shop() ) {
		$id = get_option( 'woocommerce_shop_page_id' );
		return hoot_get_meta_option( 'display_loop_meta', $id );
	}
	return $value;
}
add_filter( 'hoot_wooloop_meta_display_title', 'hoot_premium_wooloop_meta_display_title', 5 );


/**
 * Page Loop Area
 *
 * @since 2.0
 * @param string $value
 * @param string $location
 * @param string $context
 * @return string
 */
function hoot_premium_loop_meta_pre_title_content( $value, $location, $context ) {
	if ( is_page() || is_singular( 'post' ) )
		$id = get_queried_object_id();
	elseif ( is_home() && !is_front_page() )
		$id = get_option( 'page_for_posts' );
	elseif ( current_theme_supports( 'woocommerce' ) && is_shop() )
		$id = get_option( 'woocommerce_shop_page_id' );
	else
		return $value;
	return hoot_get_meta_option( 'pre_title_content', $id );
}
add_filter( 'hoot_loop_meta_pre_title_content', 'hoot_premium_loop_meta_pre_title_content', 5, 3 );

/**
 * Page Loop Area
 *
 * @since 2.0
 * @param string $value
 * @param string $location
 * @param string $context
 * @return string
 */
function hoot_premium_loop_meta_pre_title_content_stretch( $value, $location, $context ) {
	if ( is_page() || is_singular( 'post' ) )
		$id = get_queried_object_id();
	elseif ( is_home() && !is_front_page() )
		$id = get_option( 'page_for_posts' );
	elseif ( current_theme_supports( 'woocommerce' ) && is_shop() )
		$id = get_option( 'woocommerce_shop_page_id' );
	else
		return $value;
	return hoot_get_meta_option( 'pre_title_content_stretch', $id );
}
add_filter( 'hoot_loop_meta_pre_title_content_stretch', 'hoot_premium_loop_meta_pre_title_content_stretch', 5, 3 );

/**
 * Page Loop Area
 *
 * @since 2.0
 * @param string $value
 * @param string $location
 * @param string $context
 * @return string
 */
function hoot_premium_loop_meta_pre_title_content_post( $value, $location, $context ) {
	if ( is_page() || is_singular( 'post' ) )
		$id = get_queried_object_id();
	elseif ( is_home() && !is_front_page() )
		$id = get_option( 'page_for_posts' );
	elseif ( current_theme_supports( 'woocommerce' ) && is_shop() )
		$id = get_option( 'woocommerce_shop_page_id' );
	else
		return $value;
	return hoot_get_meta_option( 'pre_title_content_post', $id );
}
add_filter( 'hoot_loop_meta_pre_title_content_post', 'hoot_premium_loop_meta_pre_title_content_post', 5, 3 );

/**
 * Allow users to determine WooCommerce Page Layouts
 *
 * @since 3.0
 * @param bool
 * @return bool
 */
function hoot_premium_woo_pages_force_nosidebar( $value ) {
	return false;
}
add_filter( 'hoot_woo_pages_force_nosidebar', 'hoot_premium_woo_pages_force_nosidebar', 5 );