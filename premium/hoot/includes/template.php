<?php
/**
 * Functions for loading template parts. These functions are helper functions or more flexible functions 
 * than what core WordPress currently offers with template part loading.
 *
 * @package hoot
 * @subpackage framework
 * @since hoot 2.0.0
 */

/**
 * Add premium widget template locations
 *
 * @since 2.0.0
 * @param array $templates
 * @param string $name
 * @return array
 */
function hoot_premium_widget_template_hierarchy( $templates, $name ) {

	$base_premium = str_replace( trailingslashit( THEME_DIR ), '', trailingslashit( PREMIUM_DIR ) );

	// Lets rebuild the locations
	$templates = array();

	if ( '' !== $name ) {
		$templates[] = $base_premium . "widget-{$name}.php";
		$templates[] = "widget-{$name}.php";
		$templates[] = $base_premium . "widget/{$name}.php";
		$templates[] = "widget/{$name}.php";
		$templates[] = $base_premium . "template-parts/widget-{$name}.php";
		$templates[] = "template-parts/widget-{$name}.php";
	}

	$templates[] = $base_premium . 'widget.php';
	$templates[] = 'widget.php';
	$templates[] = $base_premium . 'widget/widget.php';
	$templates[] = 'widget/widget.php';
	$templates[] = $base_premium . 'template-parts/widget.php';
	$templates[] = 'template-parts/widget.php';

	return $templates;
}
add_filter( 'hoot_widget_template_hierarchy', 'hoot_premium_widget_template_hierarchy', 5, 2 );

/**
 * A function for locating a shortcode template. This works similar to the WordPress `get_*()` template
 * functions. It's purpose is for loading a shortcode display template. This function looks for shortcode
 * templates within the hoot-theme sub-folder or the hoot framework folder.
 *
 * @since 1.1.0
 * @access public
 * @param string $name
 * @return void
 */
function hoot_locate_shortcode( $name = '' ) {
	if ( '' !== $name ) {

		$templates = array();

		// Add these locations for easy child theme templates
		$templates[] = "shortcode-{$name}.php";
		$templates[] = "shortcodes/{$name}.php";
		$templates[] = "template-parts/shortcode-{$name}.php";

		// Add shortcode templates in premium theme
		$base_premium_theme = str_replace( trailingslashit( THEME_DIR ), '', trailingslashit( HOOT_PREMIUM_THEMEDIR ) );
		$templates[] = $base_premium_theme . "shortcodes/{$name}.php";

		// Add shortcode templates in premium framework extension
		$base_premium_core = str_replace( trailingslashit( THEME_DIR ), '', trailingslashit( HOOT_PREMIUM_DIR ) );
		$templates[] = $base_premium_core . "extensions/shortcodes/display/{$name}.php";

		// Add shortcode templates in theme
		// Added for brevity only as shortcodes is a premium feature
		$base_theme = str_replace( trailingslashit( THEME_DIR ), '', trailingslashit( HOOT_THEMEDIR ) );
		$templates[] = $base_theme . "shortcodes/{$name}.php";

		// Add shortcode templates in framework
		// Added for brevity only as shortcodes is a premium feature
		$base_core = str_replace( trailingslashit( THEME_DIR ), '', trailingslashit( HOOT_DIR ) );
		$templates[] = $base_core . "extensions/shortcodes/display/{$name}.php";

		// Apply filters and return
		$templates = apply_filters( 'hoot_shortcode_template_hierarchy', $templates, $name, $base_premium_theme, $base_premium_core, $base_theme, $base_core );
		return locate_template( $templates, false );

	}
}