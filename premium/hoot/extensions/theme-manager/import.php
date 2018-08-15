<?php
/**
 * Theme Manager Extension
 * This file is loaded at 'init' hook
 * This file is loaded only for is_admin()
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
class Hoot_Theme_Manager_Import extends Hoot_Theme_Manager {

	/**
	 * Initialize everything
	 * 
	 * @since 2.0.0
	 * @access public
	 * @return void
	 */
	public function __construct() {

		/* Perform action and populate messages and admin page content */
		add_action( 'hoot_theme_mgr_page', array( $this, 'do_import' ), 5 );
		add_action( 'hoot_theme_mgr_page', array( $this, 'print_import' ) );

	}

	/**
	 * Do Import and add messages
	 *
	 * @since 2.0.0
	 */
	function do_import() {

		if ( isset( $_POST['hoot-import-mod'] ) && !empty( $_POST['hoot-import-mod'] ) ) :
			$mods = unserialize( gzuncompress( base64_decode( $_POST['hoot-import-mod'] ) ) );
			$hoot_customizer = Hoot_Customizer::get_instance();
			$settings = $hoot_customizer->get_options('settings');
			if ( !empty( $mods ) && !empty( $settings ) && is_array( $mods ) && is_array( $settings ) ){
				remove_theme_mods();
				$done = 0;
				foreach ( $mods as $key => $value ) {
					if ( isset( $settings[ $key ] ) ) {
						set_theme_mod( $key, $value );
						$done++;
					}
				}
				?><div id="hoot-mgr-message" class="notice notice-success"><p><?php printf( __( '%s Customizer Settings imported successfully.', 'dispatch-premium' ), $done ); ?></p></div><?php
			} else {
				?><div id="hoot-mgr-message" class="notice notice-warning"><p><?php _e( 'Something went wrong. Customizer settings were not imported. Please try again later.', 'dispatch-premium' ); ?></p></div><?php
			}
		endif;

	}

	/**
	 * Print Theme Manager Page Content
	 *
	 * @since 2.0.0
	 */
	function print_import() {
		?>
		<div id="hoot-theme-mgr-import" class="hoot-theme-mgr">
			<h2><?php _e( 'Import Customizer Settings', 'dispatch-premium' ); ?></h2>
			<p><?php _e( 'Paste your exported code here from another theme/installation, and click the Import button.', 'dispatch-premium' ); ?></p>
			<p class="warning"><?php _e( '<strong>WARNING:</strong> All your current customizer settings will be overwritten.<br /><em>(It is recommended to backup your database before making any changes to your site; or at the very least copy and save the customizer settings for current active theme below to a text file on your computer.)</em>', 'dispatch-premium' ); ?></p>
			<form action="themes.php?page=hootthememanager" method="post">
				<textarea id="hoot-import-mod" name="hoot-import-mod" rows="6"></textarea>
				<br />
				<input class="button button-primary hoot-import-mod-button" type="submit" value="<?php _e( 'Import Settings', 'dispatch-premium' ); ?>" />
			</form>
		</div> <!-- .hoot-tm -->
		<?php
	}

}