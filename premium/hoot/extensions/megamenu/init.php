<?php
/**
 * Megamenu Extension
 * This file is loaded at 'after_setup_theme' hook with 14 priority.
 * @credit Modified code from http://wordpress.stackexchange.com/questions/33342/
 *
 * @package hoot
 * @subpackage framework
 * @since hoot 1.1.0
 */

/**
 * Hoot Megamenu class.
 *
 * @since 1.1.0
 */
class Hoot_Megamenu {

	/**
	 * Holds the instance of this class.
	 *
	 * @since 1.1.0
	 * @access private
	 * @var object
	 */
	private static $instance;

	/**
	 * Holds the menu option fields
	 *
	 * @since 1.1.0
	 * @access private
	 * @var object
	 */
	private $megamenu_options;

	/**
	 * Hook into actions and filters
	 * 
	 * @since 1.1.0
	 * @access public
	 * @return void
	 */
	public function __construct() {

		/* Initialize Options Array */
		$this->megamenu_options = array();

		if ( is_admin() ) {

			/* Add the required scripts and styles */
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles_scripts' ) );

			/* Load the Walker Class for Edit Nav Menu */
			require_once( trailingslashit( HOOT_PREMIUM_EXTENSIONS ) . 'megamenu/class-hoot-edit-menu-walker.php' );

			/* Tell WordPress to use our Walker for Edit Nav */
			add_filter( 'wp_edit_nav_menu_walker', array( $this, 'modify_edit_nav_menu_walker' ) , 100, 2 );

			/* Adds value of new fields to $item object that will be passed to our Walker */
			add_filter( 'wp_setup_nav_menu_item', array( $this, 'setup_nav_item' ) , 100 );

			/* Save value of our custom fields */
			add_action( 'wp_update_nav_menu_item', array( $this, 'update_nav_menu' ), 100, 3 );

		} else {

			/* Load the Custom Walker Class for Displaying Nav Menu using 'wp_nav_menu()' */
			require_once( trailingslashit( HOOT_PREMIUM_EXTENSIONS ) . 'megamenu/class-hoot-megamenu-walker.php' );

			/* Apply Walker to Nav Menu displayed in frontend */
			add_filter( 'wp_nav_menu_args', array( $this, 'wp_nav_menu_walker' ) );

		}

	}

	/**
	 * Loads the required stylesheets and scripts
	 *
	 * @since 1.1.0
	 */
	function enqueue_admin_styles_scripts( $hook ) {

		if ( 'nav-menus.php' == $hook ) {

			/* Enqueue Megamenu Scripts */
			$script_uri = hoot_locate_script( trailingslashit( HOOT_JS ) . 'megamenu' );
			wp_enqueue_script( 'hoot-megamenu', $script_uri, array( 'jquery' ), HOOT_VERSION, true ); // possible future dependency: 'wp-color-picker'

		}

	}

	/**
	 * Tell WordPress to use our Walker for Edit Menu
	 *
	 * @since 1.1.0
	 */
	function modify_edit_nav_menu_walker( $walker, $menu_id ) {
		if ( class_exists( 'Hoot_Edit_Menu_Walker' ) )
			return 'Hoot_Edit_Menu_Walker';
		else
			return $walker;
	}

	/**
	 * Add value of our custom fields to $item object that will be passed to our walker for Edit Menu
	 *
	 * @since 1.1.0
	 */
	function setup_nav_item( $menu_item ) {
		$values = get_post_meta( $menu_item->ID, '_menu-item-hoot_megamenu', true );
		if ( !is_array( $values ) ) $values = array(); // Needed to prevent illegal offstring in certain xampp for $values[ $key ] = '';
		foreach ( $this->megamenu_options as $key => $option ) {
			if ( !isset( $values[ $key ] ) ) {
				$values[ $key ] = '';
				// $values[ $key ] = ( isset( $option['std'] ) ) ? $option['std'] : ''; // Std doesnt work for newly added items
			}
		}
		$menu_item->hoot_megamenu = $values;
		return $menu_item;
	}

	/*
	 * Save and Update the Custom Fields in Navigation Menu Items
	 * 
	 * @since 1.1.0
	 * @param int $menu_id
	 * @param int $menu_item_db
	 */
	function update_nav_menu( $menu_id, $menu_item_db_id, $args ) {
		$values = array();
		foreach ( $this->megamenu_options as $key => $option ) {
			$values[ $key ] = isset( $_POST[ 'menu-item-' . $key ][ $menu_item_db_id ] ) ? 
							  $_POST[ 'menu-item-' . $key ][ $menu_item_db_id ] :
							  '';
			if ( isset( $option['top_level'] ) && true === $option['top_level'] )
				$values[ $key . '_top_level' ] = '1';
		}
		update_post_meta( $menu_item_db_id, '_menu-item-hoot_megamenu', $values );
	}

	/*
	 * Apply Walker to Nav Menu displayed in frontend
	 * 
	 * @since 1.1.5
	 * @param array $args
	 * @return array
	 */
	function wp_nav_menu_walker( $args ) {
		// Apply walker if none already exists
		if ( class_exists( 'Hoot_Megamenu_Walker' ) && empty( $args['walker'] ) ) {
			$args['walker'] = new Hoot_Megamenu_Walker;
		}
		return $args;
	}

	/**
	 * Add menu option to $megamenu_options Array
	 *
	 * @since 2.0.0
	 * @access public
	 * @return void
	 */
	public function add_options( $megamenu_options = array() ) {
		$megamenu_options = apply_filters( 'hoot_theme_megamenu_options' , $megamenu_options );
		$this->megamenu_options = array_merge( $this->megamenu_options, $megamenu_options );
	}

	/**
	 * Get options Array
	 *
	 * @since 2.0.0
	 * @access public
	 * @return array
	 */
	public function get_options() {
		return $this->megamenu_options;
	}

	/**
	 * Returns the instance.
	 *
	 * @since 1.1.0
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
global $hoot_megamenu;
$hoot_megamenu = Hoot_Megamenu::get_instance();

/* Hook into this action to add meta options */
do_action( 'hoot_megamenu_loaded', $hoot_megamenu );