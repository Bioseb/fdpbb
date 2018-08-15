<?php
/**
 * Theme Manager Extension
 * This file is loaded at 'after_setup_theme' hook with 14 priority.
 * This file is loaded only when is_admin() and current_user_can( 'edit_theme_options' )
 *
 * @package hoot
 * @subpackage framework
 * @since hoot 2.0.0
 */

/**
 * Theme Manager class. This wraps everything up nicely.
 *
 * @since 2.0.0
 */
class Hoot_Theme_Manager {

	/**
	 * Holds the instance of this class.
	 *
	 * @since 2.0.0
	 * @access private
	 * @var object
	 */
	private static $instance;

	/**
	 * Supported modules
	 *
	 * @since 2.0.0
	 * @access public
	 * @var array
	 */
	public $support = array();

	/**
	 * Initialize everything
	 * 
	 * @since 2.0.0
	 * @access public
	 * @return void
	 */
	public function __construct() {

		/* Get Modules Support */
		if ( hoot_theme_supports( 'hoot-theme-manager', 'autoupgrade' ) )
			$this->support[] = 'autoupgrade';
		if ( hoot_theme_supports( 'hoot-theme-manager', 'import' ) )
			$this->support[] = 'import';
		if ( hoot_theme_supports( 'hoot-theme-manager', 'export' ) )
			$this->support[] = 'export';

		/* Add the Theme Manager page */
		add_action( 'admin_menu', array( $this, 'manager_add_page' ) );
		add_action( 'admin_menu', array( $this, 'reorder_custom_options_page' ), 9999 );

		/* Add the required scripts and styles */
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_wp_styles_scripts' ) );

		/* Add modules */
		add_action( 'init', array( $this, 'add_modules' ) );

	}

	/**
	 * Loads the required stylesheets and scripts
	 *
	 * @since 2.0.0
	 */
	function enqueue_wp_styles_scripts( $hook ) {
		if ( 'appearance_page_hootthememanager' == $hook ) {
			$style_uri = hoot_locate_style( trailingslashit( HOOT_CSS ) . 'theme-manager' );
			wp_enqueue_style( 'hoot-theme-manager', $style_uri, array(),  HOOT_VERSION );
		}
	}

	/**
	 * Add Theme Manager Page
	 *
	 * @since 2.0.0
	 */
	function manager_add_page() {

		add_theme_page( 'Hoot Theme Manager', 'Hoot Theme Manager', 'manage_options', 'hootthememanager', array( $this, 'manager_do_page' ) );

	}

	/**
	 * Reorder subpage called "Theme Options" in the appearance menu.
	 *
	 * @since 1.0.0
	 */
	function reorder_custom_options_page() {
		global $submenu;
		$menu_slug = 'hootthememanager';
		$index = '';

		if ( !isset( $submenu['themes.php'] ) ) {
			// probably current user doesn't have this item in menu
			return;
		}

		foreach ( $submenu['themes.php'] as $key => $sm ) {
			if ( $sm[2] == $menu_slug ) {
				$index = $key;
				break;
			}
		}

		if ( ! empty( $index ) ) {
			//$item = $submenu['themes.php'][ $index ];
			//unset( $submenu['themes.php'][ $index ] );
			//array_splice( $submenu['themes.php'], 1, 0, array($item) );
			/* array_splice does not preserve numeric keys, so instead we do our own rearranging. */
			$smthemes = array();
			foreach ( $submenu['themes.php'] as $key => $sm ) {
				if ( $key != $index ) {
					$setkey = $key;
					for ( $i = $key; $i < 1000; $i++ ) { 
						if( !isset( $smthemes[$i] ) ) {
							$setkey = $i;
							break;
						}
					}
					$smthemes[ $setkey ] = $sm;
					if ( $sm[1] == 'customize' ) { // if ( $sm[2] == 'themes.php' ) {
						$smthemes[ $setkey + 1 ] = $submenu['themes.php'][ $index ];
					}
				}
			}
			hoot_array_empty( $submenu['themes.php'], $smthemes );
		}

	}

	/**
	 * Print Theme Manager
	 *
	 * @since 2.0.0
	 */
	function manager_do_page() {
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.', 'dispatch-premium' ) );
		}

		?>
		<div id="hoot-theme-mgr" class="wrap">
			<h1><?php _e( 'Hoot Theme Manager', 'dispatch-premium' ); ?></h1>
			<?php do_action( 'hoot_theme_mgr_page' ); ?>
		</div>
		<?php

	}

	/**
	 * Add Theme Manager Modules
	 *
	 * @since 2.0.0
	 */
	function add_modules() {

		/** Auto Updater **/
		if ( in_array( 'autoupgrade', $this->support ) ) {
			require_once( trailingslashit( HOOT_PREMIUM_EXTENSIONS ) . 'theme-manager/autoupgrade.php' );
			require_once( trailingslashit( HOOT_PREMIUM_EXTENSIONS ) . 'theme-manager/updater.php' );
			new Hoot_Theme_Manager_Autoupgrade();
		}

		/** Import **/
		if ( in_array( 'import', $this->support ) ) {
			require_once( trailingslashit( HOOT_PREMIUM_EXTENSIONS ) . 'theme-manager/import.php' );
			new Hoot_Theme_Manager_Import();
		}

		/** Export **/
		if ( in_array( 'export', $this->support ) ) {
			require_once( trailingslashit( HOOT_PREMIUM_EXTENSIONS ) . 'theme-manager/export.php' );
			new Hoot_Theme_Manager_Export();
		}

	}

	/**
	 * Returns the instance.
	 *
	 * @since 2.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		if ( !self::$instance )
			self::$instance = new self;

		return self::$instance;
	}

}

/* Initialize class */
global $hoot_theme_manager;
$hoot_theme_manager = Hoot_Theme_Manager::get_instance();