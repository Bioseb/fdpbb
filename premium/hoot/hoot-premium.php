<?php
/**
 * Premium extension for Hoot framework
 *
 * @package hoot
 * @subpackage framework
 * @since hoot 2.0.0
 */

/**
 * The Hoot_Premium class launches the premium framework.
 * It follows the Hoot structure closely. See Hoot class for further details.
 * 
 * @since 2.0.0
 * @access public
 */
if ( !class_exists( 'Hoot_Premium' ) ) {
	class Hoot_Premium {

		/**
		 * Constructor method to controls the load order of the required files for running 
		 * the framework.
		 *
		 * @since 2.0.0
		 * @access public
		 * @return void
		 */
		function __construct() {

			/* Define framework, parent theme, and child theme constants. */
			add_action( 'after_setup_theme', array( $this, 'constants' ), 1 );

			/* Initialize the actions and filters. */
			add_action( 'after_setup_theme', array( $this, 'hooks' ), 3 );

			/* Load the customizer framework. */
			add_action( 'after_setup_theme', array( $this, 'customizer' ), 5 );

			/* Load framework includes. */
			add_action( 'after_setup_theme', array( $this, 'includes' ), 13 );

			/* Load the framework extensions. */
			add_action( 'after_setup_theme', array( $this, 'extensions' ), 14 );

		}

		/**
		 * Defines the constant paths for use within the core framework, parent theme, and child theme.  
		 * Constants prefixed with 'HOOT' are for use only within the core framework and don't 
		 * reference other areas of the parent or child theme.
		 *
		 * @since 2.0.0
		 * @access public
		 * @return void
		 */
		function constants() {

			// Sets the path to the premium directory.
			define( 'PREMIUM_DIR', trailingslashit( THEME_DIR ) . 'premium' );

			// Sets the path to the premium directory URI.
			define( 'PREMIUM_URI', trailingslashit( THEME_URI ) . 'premium' );

			// Sets the path to the core framework directory.
			define( 'HOOT_PREMIUM_DIR', trailingslashit( PREMIUM_DIR ) . 'hoot' );

			// Sets the path to the core framework directory URI.
			define( 'HOOT_PREMIUM_URI', trailingslashit( PREMIUM_URI ) . 'hoot' );

			// Sets the path to the framework theme directory.
			define( 'HOOT_PREMIUM_THEMEDIR', trailingslashit( PREMIUM_DIR ) . 'hoot-theme' );

			// Sets the path to the framework theme directory URI.
			define( 'HOOT_PREMIUM_THEMEURI', trailingslashit( PREMIUM_URI ) . 'hoot-theme' );

			/** Set Additional Paths **/

			// Sets the path to the core framework extensions directory.
			define( 'HOOT_PREMIUM_EXTENSIONS', trailingslashit( HOOT_PREMIUM_DIR ) . 'extensions' );

		}

		/**
		 * Adds the actions and filters.
		 *
		 * @since 2.0.0
		 * @access public
		 * @return void
		 */
		function hooks() {

			/* Make text widgets shortcode aware. */
			add_filter( 'widget_text', 'do_shortcode' );

			/* Add premium widget locations to get loaded in the Hoot Widget extension */
			add_filter( 'hoot_load_widgets', array( $this, 'load_widgets' ) );

			/* Add premium background options */
			add_filter( 'hoot_enum_background_pattern', array( $this, 'background_pattern' ), 5 );

		}

		/**
		 * Loads the framework files supported by themes and template-related functions/classes.
		 * Functionality in these files should not be expected within the theme setup function.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		function includes() {

			/* Load the template functions. */
			require_once( trailingslashit( HOOT_PREMIUM_DIR ) . 'includes/template.php' );

			/* Load the google font functions. */
			require_once( trailingslashit( HOOT_PREMIUM_DIR ) . 'includes/fonts-google.php' );

		}

		/**
		 * Load extensions (external projects).
		 *
		 * @since 2.0.0
		 * @access public
		 * @return void
		 */
		function extensions() {

			/* Load the Shortcodes extension if supported. */
			require_if_theme_supports( 'hoot-shortcodes', trailingslashit( HOOT_PREMIUM_EXTENSIONS ) . 'shortcodes/init.php' );

			/* Load the CPT extension if supported. */
			require_if_theme_supports( 'hoot-cpt', trailingslashit( HOOT_PREMIUM_EXTENSIONS ) . 'cpt.php' );

			/* Load the Taxonomies extension if supported. */
			require_if_theme_supports( 'hoot-taxonomies', trailingslashit( HOOT_PREMIUM_EXTENSIONS ) . 'taxonomies.php' );

			/* Load the Meta extension if supported. */
			require_if_theme_supports( 'hoot-options-meta', trailingslashit( HOOT_PREMIUM_EXTENSIONS ) . 'options-meta.php' );

			/* Load the Megamenu extension if supported. */
			require_if_theme_supports( 'hoot-megamenu', trailingslashit( HOOT_PREMIUM_EXTENSIONS ) . 'megamenu/init.php' );

			/* Load the custom404 extension if supported. */
			require_if_theme_supports( 'custom-404', trailingslashit( HOOT_PREMIUM_EXTENSIONS ) . 'custom-404.php' );

			/* Load the Scroller extension if supported. */
			if ( current_theme_supports( 'hoot-scrollpoints' ) || current_theme_supports( 'hoot-waypoints' ) )
				require( trailingslashit( HOOT_PREMIUM_EXTENSIONS ) . 'scroller.php' );

			/* Load the theme manager extension. */
			if ( is_admin() && current_user_can( 'edit_theme_options' ) )
				require_if_theme_supports( 'hoot-theme-manager', trailingslashit( HOOT_PREMIUM_EXTENSIONS ) . 'theme-manager/init.php' );

		}

		/**
		 * Load Hoot Customizer framework.
		 *
		 * @since 2.0.0
		 * @access public
		 * @return void
		 */
		function customizer() {

			/* Load the Hoot Customizer framework */
			require_once( trailingslashit( HOOT_PREMIUM_DIR ) . 'customizer/hoot-customizer.php' );

		}

		/**
		 * Add premium widget locations to get loaded in the Hoot Widget extension
		 *
		 * @since 2.0.0
		 * @param array $locations
		 * @return array
		 */
		function load_widgets( $locations ) {
			$locations[] = trailingslashit( HOOT_PREMIUM_THEMEDIR ) . 'admin/widget-*.php';
			return $locations;
		}

		/**
		 * Make premium background patterns available for loading into the options
		 *
		 * @since 2.0.0
		 * @param array $locations
		 * @return array
		 */
		function background_pattern( $patterns ) {
			$relative = trailingslashit( substr( trailingslashit( HOOT_PREMIUM_URI ) . 'images/patterns' , ( strlen( THEME_URI ) + 1 ) ) );
			$patterns = $patterns + array(
				$relative . '1.jpg' => trailingslashit( HOOT_PREMIUM_URI ) . 'images/patterns/1_preview.jpg',
				$relative . '2.jpg' => trailingslashit( HOOT_PREMIUM_URI ) . 'images/patterns/2_preview.jpg',
				$relative . '3.jpg' => trailingslashit( HOOT_PREMIUM_URI ) . 'images/patterns/3_preview.jpg',
				$relative . '4.jpg' => trailingslashit( HOOT_PREMIUM_URI ) . 'images/patterns/4_preview.jpg',
				$relative . '5.jpg' => trailingslashit( HOOT_PREMIUM_URI ) . 'images/patterns/5_preview.jpg',
				$relative . '6.jpg' => trailingslashit( HOOT_PREMIUM_URI ) . 'images/patterns/6_preview.jpg',
				$relative . '7.png' => trailingslashit( HOOT_PREMIUM_URI ) . 'images/patterns/7_preview.jpg',
				$relative . '8.jpg' => trailingslashit( HOOT_PREMIUM_URI ) . 'images/patterns/8_preview.jpg',
				$relative . '9.jpg' => trailingslashit( HOOT_PREMIUM_URI ) . 'images/patterns/9_preview.jpg',
				$relative . '10.jpg' => trailingslashit( HOOT_PREMIUM_URI ) . 'images/patterns/10_preview.jpg',
				$relative . '11.jpg' => trailingslashit( HOOT_PREMIUM_URI ) . 'images/patterns/11_preview.jpg',
				$relative . '12.jpg' => trailingslashit( HOOT_PREMIUM_URI ) . 'images/patterns/12_preview.jpg',
				$relative . '13.jpg' => trailingslashit( HOOT_PREMIUM_URI ) . 'images/patterns/13_preview.jpg',
				$relative . '14.jpg' => trailingslashit( HOOT_PREMIUM_URI ) . 'images/patterns/14_preview.jpg',
				$relative . '15.jpg' => trailingslashit( HOOT_PREMIUM_URI ) . 'images/patterns/15_preview.jpg',
				$relative . '16.png' => trailingslashit( HOOT_PREMIUM_URI ) . 'images/patterns/16_preview.jpg',
				$relative . '17.jpg' => trailingslashit( HOOT_PREMIUM_URI ) . 'images/patterns/17_preview.jpg',
				$relative . '18.jpg' => trailingslashit( HOOT_PREMIUM_URI ) . 'images/patterns/18_preview.jpg',
				$relative . '19.jpg' => trailingslashit( HOOT_PREMIUM_URI ) . 'images/patterns/19_preview.jpg',
				$relative . '20.png' => trailingslashit( HOOT_PREMIUM_URI ) . 'images/patterns/20_preview.jpg',
				$relative . '21.png' => trailingslashit( HOOT_PREMIUM_URI ) . 'images/patterns/21_preview.jpg',
				$relative . '22.png' => trailingslashit( HOOT_PREMIUM_URI ) . 'images/patterns/22_preview.jpg',
				$relative . '23.jpg' => trailingslashit( HOOT_PREMIUM_URI ) . 'images/patterns/23_preview.jpg',
				$relative . '24.png' => trailingslashit( HOOT_PREMIUM_URI ) . 'images/patterns/24_preview.jpg',
				$relative . '25.jpg' => trailingslashit( HOOT_PREMIUM_URI ) . 'images/patterns/25_preview.jpg',
			);
			return $patterns;
		}

	} // end class
} // end if