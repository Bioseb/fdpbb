<?php
/**
 * Hoot Premium hooked into the framework
 *
 * @package hoot
 * @subpackage dispatch
 * @since dispatch 1.0
 */

/**
 * The Hoot_Premium_Theme class launches the theme premium extension setup.
 * It follows the Hoot_Theme structure closely. See Hoot_Theme class for further details.
 * 
 * @since dispatch 1.0
 * @access public
 */
if ( !class_exists( 'Hoot_Premium_Theme' ) ) {
	class Hoot_Premium_Theme {

		/**
		 * Constructor method to controls the load order of the required files
		 *
		 * @since 1.0
		 * @access public
		 * @return void
		 */
		function __construct() {

			/* Initialize the actions and filters. */
			add_action( 'after_setup_theme', array( $this, 'hooks' ), 3 );

			/* Load theme includes. Must keep priority 10 for theme constants to be available. */
			add_action( 'after_setup_theme', array( $this, 'includes' ), 10 );

			/* Theme setup on the 'after_setup_theme' hook. Must keep priority 10 for framework to load properly. */
			add_action( 'after_setup_theme', array( $this, 'theme_setup' ), 10 );

			/* Insert Custom Javascript code from the user */
			add_action( 'init', array( $this, 'custom_user_js' ) );

		}

		/**
		 * Adds the actions and filters.
		 *
		 * @since 2.0
		 * @access public
		 * @return void
		 */
		function hooks() {

			/* Unload premium upsell page for premium themes */
			add_filter( 'hoot_load_upsell_subpage', array( $this, 'unload_upsell' ) );

		}

		/**
		 * Loads the theme files supported by themes and template-related functions/classes.  Functionality 
		 * in these files should not be expected within the theme setup function.
		 *
		 * @since 1.0
		 * @access public
		 * @return void
		 */
		function includes() {

			/* Load enqueue functions */
			require_once( trailingslashit( HOOT_PREMIUM_THEMEDIR ) . 'enqueue.php' );

			/* Load the google font functions. */
			require_once( trailingslashit( HOOT_PREMIUM_THEMEDIR ) . 'fonts.php' );

			/* Load the custom css functions */
			require_once( trailingslashit( HOOT_PREMIUM_THEMEDIR ) . 'css.php' );

			/* Load the misc template functions. */
			require_once( trailingslashit( HOOT_PREMIUM_THEMEDIR ) . 'template-helpers.php' );

			/* Load Customizer Options Extend */
			if ( file_exists( trailingslashit( HOOT_PREMIUM_THEMEDIR ) . 'admin/customizer-options.php' ) )
				require_once( trailingslashit( HOOT_PREMIUM_THEMEDIR ) . 'admin/customizer-options.php' );

			/* Load Meta Options */
			if ( file_exists( trailingslashit( HOOT_PREMIUM_THEMEDIR ) . 'admin/meta-options.php' ) )
				require_once( trailingslashit( HOOT_PREMIUM_THEMEDIR ) . 'admin/meta-options.php' );

			/* Load Megamenu Options */
			if ( file_exists( trailingslashit( HOOT_PREMIUM_THEMEDIR ) . 'admin/megamenu-options.php' ) )
				require_once( trailingslashit( HOOT_PREMIUM_THEMEDIR ) . 'admin/megamenu-options.php' );

			/* Load CPT Options */
			if ( file_exists( trailingslashit( HOOT_PREMIUM_THEMEDIR ) . 'admin/cpt.php' ) )
				require_once( trailingslashit( HOOT_PREMIUM_THEMEDIR ) . 'admin/cpt.php' );

			/* Load Taxonomy Options */
			if ( file_exists( trailingslashit( HOOT_PREMIUM_THEMEDIR ) . 'admin/taxonomies.php' ) )
				require_once( trailingslashit( HOOT_PREMIUM_THEMEDIR ) . 'admin/taxonomies.php' );

		}

		/**
		 * Add theme supports. This is how the theme hooks into the framework and loads proper modules.
		 *
		 * @since 1.0
		 * @access public
		 * @return void
		 */
		function theme_setup() {

			// Add meta support if needed
			add_theme_support( 'hoot-options-meta' );

			// Add Shortcodes
			add_theme_support( 'hoot-shortcodes' );

			// Add CPT
			add_theme_support( 'hoot-cpt' );

			// Add Taxonomies
			// add_theme_support( 'hoot-taxonomies' );

			// Add Mega Menu
			add_theme_support( 'hoot-megamenu', array( 'menuitem_icon' ) );

			// Custom 404 page option
			add_theme_support( 'custom-404' );

			// Add Scrollpoints Support for goto-top
			add_theme_support( 'hoot-scrollpoints', array( 'goto-top', 'menu-scroll' ) );

			// Add Waypoints Support for sticky-header, goto-top
			add_theme_support( 'hoot-waypoints', array( 'goto-top', 'sticky-header' ) );

			// Add Lightbox Support (thus light-gallery)
			add_theme_support( 'hoot-lightbox' );
			add_theme_support( 'light-gallery' );

			// Add Slider Support for shortcodes
			add_theme_support( 'light-slider' );

			// Add Theme Manager Support
			add_theme_support( 'hoot-theme-manager', array( 'autoupgrade', 'import', 'export' ) );

		}

		/**
		 * Insert Custom Javascript code by the user
		 *
		 * @since 1.0
		 * @access public
		 * @return void
		 */
		function custom_user_js() {
			if ( hoot_get_mod( 'custom_js_inheader' ) )
				add_action( 'wp_head', array( $this, 'insert_custom_user_js' ) );
			else
				add_action( 'wp_footer', array( $this, 'insert_custom_user_js' ) );
		}

		/**
		 * Insert Custom Javascript code by the user in either header or footer
		 *
		 * @since 1.0
		 * @access public
		 * @return void
		 */
		function insert_custom_user_js() {
			$custom_js = trim( hoot_get_mod( 'custom_js', '' ) );
			if ( !empty( $custom_js ) ) {
				if ( !strpos( $custom_js, '<script>' ) && !strpos( $custom_js, '</script>' ) ) {
					$start = '<script>'; $end = '</script>';
				} else $start = $end = '';
				// $custom_js = preg_replace( '/^' . preg_quote('<script>', '/') . '/', '', $custom_js);
				// $custom_js = preg_replace( '/' . preg_quote('</script>', '/') . '$/', '', $custom_js);
				echo "\n" . $start . htmlspecialchars_decode( $custom_js ) . $end . "\n";
			}
		}

		/**
		 * Unload premium upsell page for premium themes
		 *
		 * @since 1.0
		 * @access public
		 * @param bool $load
 		 * @return bool
		 */
		function unload_upsell( $load ) {
			return false;
		}

	} // end class
} // end if