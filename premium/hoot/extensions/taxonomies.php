<?php
/**
 * Custom Taxonomies Extension
 * This file is loaded at 'after_setup_theme' hook with 14 priority.
 *
 * @package hoot
 * @subpackage framework
 * @since hoot 1.1.0
 */

/**
 * Hoot Taxonomies class. This wraps everything up nicely.
 *
 * @since 1.1.0
 */
final class Hoot_Taxonomies {

	/**
	 * The one instance of Hoot_Taxonomies.
	 *
	 * @since 2.0.0
	 * @access private
	 * @var Hoot_Taxonomies The one instance for the singleton.
	 */
	private static $instance;

	/**
	 * The array for storing $options.
	 *
	 * @since 2.0.0
	 * @access public
	 * @var array Holds the options array.
	 */
	public $options = array();

	/**
	 * Hook into actions and filters
	 * 
	 * @since 1.1.0
	 * @access public
	 * @return void
	 */
	public function __construct() {

		/* Initialize Options Array */
		$this->options = array();

		/* 'register_taxonomy()' should only be invoked through the 'init' action */
		add_action( 'init', array( $this, 'register_taxonomy' ) );

	}

	/**
	 * Register Custom Taxonomies for the theme
	 * 
	 * @since 1.1.0
	 */
	function register_taxonomy() {

		/* Process and register CPT */
		foreach ( $this->options as $taxonomy => $settings ) {

			if ( empty( $settings['object_type'] ) )
				continue;

			// Default Labels
			$labels = ( isset( $settings['args']['labels'] ) ) ? $settings['args']['labels'] : array();
			$singular = ( isset( $labels['singular_name'] ) ) ? $labels['singular_name'] : __( 'Group', 'dispatch-premium' );
			$plural = ( isset( $labels['name'] ) ) ? $labels['name'] : __( 'Groups', 'dispatch-premium' );
			$settings['args']['labels'] = wp_parse_args( $labels, array(
				'name'				=> $plural,
				'singular_name'		=> $singular,
				'menu_name'			=> $plural,
				'all_items'			=> sprintf( __( 'All %s', 'dispatch-premium' ), $plural ),
				'edit_item'			=> sprintf( __( 'Edit %s', 'dispatch-premium' ), $singular ),
				'view_item'			=> sprintf( __( 'View %s', 'dispatch-premium' ), $singular ),
				'update_item'		=> sprintf( __( 'Update %s', 'dispatch-premium' ), $singular ),
				'add_new_item'		=> sprintf( __( 'Add New %s', 'dispatch-premium' ), $singular ),
				'new_item_name'		=> sprintf( __( 'New %s Name', 'dispatch-premium' ), $singular ),
				'parent_item'		=> sprintf( __( 'Parent %s', 'dispatch-premium' ), $singular ),
				'parent_item_colon'	=> sprintf( __( 'Parent %s:', 'dispatch-premium' ), $singular ),
				'search_items' 		=> sprintf( __( 'Search %s', 'dispatch-premium' ), $plural ),
				) );

			// Default Args
			$settings['args'] = wp_parse_args( $settings['args'], array(
				'public'				=> false, // Default: true
				//'show_ui'				=> false, // Default: value of public argument
				//'show_in_nav_menus'	=> false, // Default: value of public argument
				//'show_tagcloud'		=> false, // Default: value of show_ui argument
				'show_admin_column'		=> true, // Default: false
				//'hierarchical'		=> false, // Default: false
				//'query_var'			=> false, // Default: $taxonomy i.e. taxonomy's name (false or string)
				) );

			// Register Taxonomy
			register_taxonomy( $taxonomy, $settings['object_type'], $settings['args'] );
			//register_taxonomy_for_object_type( $taxonomy, $settings['object_type'] );

		}

	}

	/**
	 * Add option to Options Array
	 *
	 * @since 2.0.0
	 * @access public
	 * @return void
	 */
	public function add_options( $options = array() ) {
		$options = apply_filters( 'hoot_theme_taxonomies' , $options );
		$this->options = array_merge( $this->options, $options );
	}

	/**
	 * Get options Array
	 *
	 * @since 2.0.0
	 * @access public
	 * @return array
	 */
	public function get_options() {
		return $this->options;
	}

	/**
	 * Instantiate or return the one Hoot_Taxonomies instance.
	 *
	 * @since 2.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

}

/* Initialize class */
global $hoot_taxonomies;
$hoot_taxonomies = Hoot_Taxonomies::get_instance();

/* Hook into this action to add options */
do_action( 'hoot_taxonomies_loaded', $hoot_taxonomies );