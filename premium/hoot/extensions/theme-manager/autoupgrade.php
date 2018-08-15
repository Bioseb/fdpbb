<?php
/**
 * Theme Manager Extension
 * This file is loaded at 'init' hook
 * This file is loaded only for is_admin()
 *
 * License is checked using transients only when user visits the Theme Manager page
 *
 * @package hoot
 * @subpackage framework
 * @since hoot 2.0.0
 */

// @note
// edd API Calls:
// * when print theme manager content (to check license) - once 14 days using transient
// * when user clicks activate/deactivate
// {updater.php}
// * on 'site_transient_update_themes' action - only if license status is valid

/**
 * Theme Manager class. This wraps everything up nicely.
 *
 * @since 2.0.0
 */
class Hoot_Theme_Manager_Autoupgrade extends Hoot_Theme_Manager {

	/**
	 * Update Arguments
	 *
	 * @since 2.0.0
	 * @access protected
	 * @var array
	 */
	protected $args = array();

	/**
	 * Initialize everything
	 * 
	 * @since 2.0.0
	 * @access public
	 * @return void
	 */
	public function __construct() {

		global $hoot_theme;

		$this->args = wp_parse_args( apply_filters( 'hoot_updater_args', array() ), array(
			'remote_api_url' => 'https://wphoot.com',
			'theme_slug' => str_replace( '_', '-', THEME_SLUG ), // get_template() = directory name
			'item_name' => TEMPLATE_NAME, // Must match wpHoot 'download' cpt title
			'license' => '',
			'version' => THEME_VERSION,
			'author' => $hoot_theme->theme->get( 'Author' ),
			'download_id' => '', // Optional, used for generating a license renewal link
			'renew_url' => '', // Optional, allows for a custom license renewal link
			'beta' => false,
		) );

		/* Register Setting */
		add_action( 'admin_init', array( $this, 'register_setting' ) );

		/* Perform action and populate messages and admin page content */
		add_action( 'admin_init', array( $this, 'license_action' ) ); // cant use hoot_theme_mgr_page hook as license_action() requires $_POST values
		add_action( 'hoot_theme_mgr_page', array( $this, 'print_autoupgrade' ) );

		/* Update license activation status when new license value is saved */
		add_action( 'update_option_' . THEME_SLUG . '_license_key', array( $this, 'save_license' ), 10, 2 );

		/* Disable requests to wp.org repository for this theme */
		add_filter( 'http_request_args', array( $this, 'disable_wporg_request' ), 5, 2 );

		/* Run the theme updater */
		add_action( 'admin_init', array( $this, 'updater' ) );

	}

	/**
	 * Register Settings
	 *
	 * @since 2.0.0
	 */
	function register_setting() {

		register_setting(
			THEME_SLUG . '-license',
			THEME_SLUG . '_license_key',
			array( $this, 'sanitize_license' )
		);

	}

	/**
	 * Print Theme Manager Page Content
	 *
	 * @since 2.0.0
	 */
	function print_autoupgrade() {
		$license = trim( get_option( THEME_SLUG . '_license_key' ) );
		$active = get_option( THEME_SLUG . '_active_status', false );
		/* Backward Compat */ if ( $active === false ) $active = get_option( THEME_SLUG . '_license_key_status', false );

		// Checks license to display under license key
		if ( ! $license ) {
			$message = __( 'Enter your theme license key.', 'dispatch-premium' );
		} else {
			if ( $active == 'hootuser_deactive' ) {
				$message = '<span class="licstat-inactive">' . __( "This site is deactive.<br />Please press the 'Activate' button below to activate the current site.", 'dispatch-premium' ) . '</span>';
			} else {
				if ( ! get_transient( THEME_SLUG . '_license_message', false ) )
					$this->activate_license();
				$message = get_transient( THEME_SLUG . '_license_message' );
			}
		}
		?>
		<div id="hoot-theme-mgr-autoupgrade" class="hoot-theme-mgr">
			<h2><?php _e( 'Theme Updates', 'dispatch-premium' ); ?></h2>
			<p><?php _e( 'Enter your theme license key to enable theme updates directly via WordPress backend.<br />You can find your key at <a href="https://wphoot.com/?p=2" target="_blank">wphoot.com/downloads</a>.', 'dispatch-premium' ); ?></p>
			<form action="options.php" method="post">
				<?php settings_fields( THEME_SLUG . '-license' ); ?>
				<label for="<?php echo THEME_SLUG; ?>_license_key"><?php _e( 'Enter License Key', 'dispatch-premium' ); ?></label>
				<input id="<?php echo THEME_SLUG; ?>_license_key" type="text" name="<?php echo THEME_SLUG; ?>_license_key" value="<?php echo esc_attr( $license ); ?>">
				<?php
				if ( empty( $license ) ) :
					submit_button( __( 'Save License Key', 'dispatch-premium' ), 'secondary', 'submit', false );
				else :
					submit_button( __( 'Update License Key', 'dispatch-premium' ), 'secondary', 'submit', false ); ?>
					<p class="description"><?php echo $message; ?></p>
					<?php wp_nonce_field( THEME_SLUG . '_nonce', THEME_SLUG . '_nonce' ); ?>
					<?php if ( 'valid' == $active ) { ?>
						<p class="hoot-deactivate-license"><input type="submit" class="button button-primary" name="<?php echo THEME_SLUG; ?>_license_deactivate" value="<?php _e( 'Deactivate License for this Site', 'dispatch-premium' ); ?>"/></p>
					<?php } else { ?>
						<p class="hoot-activate-license"><input type="submit" class="button button-primary" name="<?php echo THEME_SLUG; ?>_license_activate" value="<?php _e( 'Activate License for this Site', 'dispatch-premium' ); ?>"/></p>
					<?php }
				endif; ?>
			</form>
		</div> <!-- .hoot-theme-mgr -->
		<?php
	}

	/**
	 * Action on saving license key.
	 *
	 * @since 2.0.0
	 */
	function save_license($e,$r) {
		// Set license and site activation status
		// $this->check_license(); // activate_license() deletes transient, so check_license will also get run automatically in print_autoupgrade
		$this->activate_license(); // Run even if user is saving empty value - to update activation status as 'invalid'
	}

	/**
	 * Checks if a license action was submitted.
	 *
	 * @since 2.0.0
	 */
	function license_action() {

		if ( isset( $_POST[ THEME_SLUG . '_license_activate' ] ) ) {
			if ( check_admin_referer( THEME_SLUG . '_nonce', THEME_SLUG . '_nonce' ) ) {
				$this->activate_license();
			}
		}

		if ( isset( $_POST[THEME_SLUG . '_license_deactivate'] ) ) {
			if ( check_admin_referer( THEME_SLUG . '_nonce', THEME_SLUG . '_nonce' ) ) {
				$this->deactivate_license();
			}
		}

	}

	/**
	 * Activates the license key.
	 *
	 * @since 2.0.0
	 */
	function activate_license() {

		$license = trim( get_option( THEME_SLUG . '_license_key' ) );

		// Data to send in our API request.
		$api_params = array(
			'edd_action' => 'activate_license',
			'license'    => $license,
			'item_name'  => urlencode( $this->args['item_name'] ),
			'url'        => home_url()
		);
		// 'activate_license' response:
		// success=true/false, license=valid/invalid, item_name, error=(missing,no_activations_left,etc), max_sites, license_limit, site_count, expires, activations_left, checksum, payment_id, customer_name, customer_email, price_id

		$license_data = $this->get_api_response( $api_params );

		$message = '';
		if ( isset( $license_data->license ) && $license_data->license == 'valid' ) {
			$message .= '<span class="licstat-active">';
			$message .= __( 'License key is active for this site.', 'dispatch-premium' ) . ' ';
			// Lets skip this for now...
			// if ( $expires ) {
			// 	$message .= '<br />';
			// 	$message .= sprintf( __( 'Expires: %s', 'dispatch-premium' ), date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires, current_time( 'timestamp' ) ) ) ) . ' ';
			// }
			// if ( $site_count && $license_limit ) {
			// 	$message .= '<br />';
			// 	$message .= sprintf( __( 'You have %1$s / %2$s sites activated.', 'dispatch-premium' ), $site_count, $license_limit );
			// }
			$message .= '</span>';
		} elseif ( !empty( $license_data->error ) ) {
			switch( $license_data->error ) {
				case 'expired' :
					$message .= '<span class="licstat-invalid">';
					if ( !empty( $license_data->expires ) ) {
						$message .= sprintf( __( 'Your license key expired on %s.', 'dispatch-premium' ), date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires, current_time( 'timestamp' ) ) ) );
					} else {
						$message .= __( 'Your license key has expired', 'dispatch-premium' );
					}
					$message .= '</span>';
					break;
				case 'revoked' :
					$message .= '<span class="licstat-inactive">' . __( 'Your license key has been disabled.', 'dispatch-premium' ) . '</span>';
					break;
				case 'missing' :
					$message .= '<span class="licstat-invalid">' . __( 'Invalid license key.', 'dispatch-premium' ) . '</span>';
					break;
				case 'invalid' :
				case 'site_inactive' :
					$message .= '<span class="licstat-inactive">' . __( 'Your license is not active for this URL.', 'dispatch-premium' ) . '</span>';
					break;
				case 'item_name_mismatch' :
					$message .= '<span class="licstat-invalid">' . __( 'This appears to be an invalid license key for %s.', 'dispatch-premium' ) . '</span>';
					break;
				case 'no_activations_left':
					$message .= '<span class="licstat-inactive">' . __( 'Your license key has reached its activation limit.', 'dispatch-premium' ) . '</span>';
					break;
				default :
					$message .= '<span class="licstat-unknown">' . __( 'An error occurred, please try again.', 'dispatch-premium' ) . '</span>';
					break;
			}
		} else {
			$message .= '<span class="licstat-unknown">' . __( 'An unknown error occurred. Please try again after sometime.', 'dispatch-premium' ) . '</span>';
		}

		if ( isset( $license_data->license ) )
			update_option( THEME_SLUG . '_active_status', $license_data->license );
		set_transient( THEME_SLUG . '_license_message', $message, ( 60 * 60 * 24 * 14 ) ); // since we have lifetime licenses, lets set this to 14 instead of 1

		wp_redirect( admin_url( 'themes.php?page=hootthememanager' ) );
		exit();
	}

	/**
	 * Deactivates the license key.
	 *
	 * @since 2.0.0
	 */
	function deactivate_license() {

		// Retrieve the license from the database.
		$license = trim( get_option( THEME_SLUG . '_license_key' ) );

		// Data to send in our API request.
		$api_params = array(
			'edd_action' => 'deactivate_license',
			'license'    => $license,
			'item_name'  => urlencode( $this->args['item_name'] ),
			'url'        => home_url()
		);

		$license_data = $this->get_api_response( $api_params );

		// $license_data->license will be either "deactivated" or "failed"
		if ( isset( $license_data->license ) && ( $license_data->license == 'deactivated' ) ) {
			update_option( THEME_SLUG . '_active_status', 'hootuser_deactive' );
			delete_transient( THEME_SLUG . '_license_message' );
		}

		wp_redirect( admin_url( 'themes.php?page=hootthememanager' ) );
		exit();
	}

	/**
	 * Sanitizes the license key.
	 *
	 * since 2.0.0
	 * @param string $new License key that was submitted.
	 * @return string $new Sanitized license key.
	 */
	function sanitize_license( $new ) {

		$old = get_option( THEME_SLUG . '_license_key' );

		if ( $old && $old != $new ) {
			// New license has been entered, so must reactivate
			delete_option( THEME_SLUG . '_license_key_status' );
			delete_transient( THEME_SLUG . '_license_message' );
		}

		return $new;
	}

	/**
	 * Checks if license is valid and gets expire date.
	 * Updates the THEME_SLUG . '_license_key_status' option and
	 * return value which is used to set transient THEME_SLUG . '_license_message'
	 *
	 * @since 1.0.0
	 *
	 * @return string $message License status message.
	 */
	function check_license() {

		$license = trim( get_option( THEME_SLUG . '_license_key' ) );

		$api_params = array(
			'edd_action' => 'check_license',
			'license'    => $license,
			'item_name'  => urlencode( $this->args['item_name'] ),
			'url'        => esc_url( home_url() ),
		);
		// 'check_license' response:
		// success=true/false, license=valid/invalid, item_name, checksum
		// expires, payment_id, customer_name, customer_email, license_limit, site_count, activations_left, price_id

		$license_data = $this->get_api_response( $api_params );

		// If response doesn't include license data, return
		if ( !isset( $license_data->license ) ) {
			$message = '<span class="licstat-unknown">' . __( 'License status is unknown.', 'dispatch-premium' ) . '</span>';
			return $message;
		}

		/** We need to update the license status at the same time the message is updated **/
		if ( $license_data && isset( $license_data->license ) ) {
			update_option( THEME_SLUG . '_license_key_status', $license_data->license );
		}

		/** Return Message **/

		// Get expire date
		$expires = false;
		if ( isset( $license_data->expires ) && $license_data->expires != 'lifetime' ) {
			$expires = date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires ) );
			$renew_link = '<a href="' . esc_url( $this->get_renewal_link() ) . '" target="_blank">' . __( 'Renew?', 'dispatch-premium' ) . '</a>';
		}

		// Get site counts
		$site_count = isset( $license_data->site_count ) ? $license_data->site_count : 0;
		$license_limit = isset( $license_data->license_limit ) ? $license_data->license_limit : 0;

		// If unlimited
		if ( 0 == $license_limit ) {
			$license_limit = __( 'unlimited', 'dispatch-premium' );
		}

		// If lifetime
		$expire_limit = ( isset( $license_data->expires ) && $license_data->expires == 'lifetime' ) ? __( 'Never', 'dispatch-premium' ) : $expires;

		if ( $license_data->license == 'valid' ) {
			$message = '<span class="licstat-active">';
			$message .= __( 'License key is valid.', 'dispatch-premium' ) . ' ';
			// Lets skip this for now...
			// if ( $expire_limit ) {
			// 	$message .= '<br />';
			// 	$message .= sprintf( __( 'Expires: %s', 'dispatch-premium' ), $expire_limit ) . ' ';
			// }
			// if ( $site_count && $license_limit ) {
			// 	$message .= '<br />';
			// 	$message .= sprintf( __( 'You have %1$s / %2$s sites activated.', 'dispatch-premium' ), $site_count, $license_limit );
			// }
			$message .= '</span>';
		} else if ( $license_data->license == 'expired' ) {
			$message = '<span class="licstat-expired">';
			if ( $expires ) {
				$message .= sprintf( __( 'License key expired %s.', 'dispatch-premium' ), $expires );
			} else {
				$message .= __( 'License key has expired.', 'dispatch-premium' );
			}
			if ( $renew_link ) {
				$message .= ' ' . $renew_link;
			}
			$message .= '</span>';
		} else if ( $license_data->license == 'invalid' ) {
			$message = '<span class="licstat-invalid">' . __( 'License keys do not match.', 'dispatch-premium' ) . '</span>';
		} else if ( $license_data->license == 'inactive' ) {
			$message = '<span class="licstat-inactive">' . __( 'License key is inactive.', 'dispatch-premium' ) . '</span>';
		} else if ( $license_data->license == 'disabled' ) {
			$message = '<span class="licstat-disabled">' . __( 'License key is disabled.', 'dispatch-premium' ) . '</span>';
		} else if ( $license_data->license == 'site_inactive' ) {
			$message = '<span class="licstat-site_inactive">' . __( 'License key is inactive for this site.', 'dispatch-premium' ) . '</span>';
		} else {
			$message = '<span class="licstat-unknown">' . __( 'License status is unknown.', 'dispatch-premium' ) . '</span>';
		}

		return $message;
	}

	/**
	 * Constructs a renewal link
	 *
	 * @since 2.0.0
	 */
	function get_renewal_link() {

		// If a renewal link was passed in the config, use that
		if ( '' != $this->args['renew_url'] ) {
			return $this->args['renew_url'];
		}

		// If download_id was passed in the config, a renewal link can be constructed
		$license_key = trim( get_option( THEME_SLUG . '_license_key', false ) );
		if ( '' != $this->args['download_id'] && $license_key ) {
			$url = esc_url( $this->args['remote_api_url'] );
			$url .= '/checkout/?edd_license_key=' . $license_key . '&download_id=' . $this->args['download_id'];
			return $url;
		}

		// Otherwise return the remote_api_url
		return $this->args['remote_api_url'];

	}

	/**
	 * Makes a call to the API.
	 *
	 * @since 2.0.0
	 * @param array $api_params to be used for wp_remote_get.
	 * @return array $response decoded JSON response.
	 */
	function get_api_response( $api_params ) {

		// Call the custom API.
		$verify_ssl = (bool) apply_filters( 'edd_sl_api_request_verify_ssl', true );
		$response = wp_remote_post( $this->args['remote_api_url'], array( 'timeout' => 15, 'sslverify' => $verify_ssl, 'body' => $api_params ) );

		// Make sure the response came back okay.
		if ( is_wp_error( $response ) ) {
			return false;
			// wp_die( $response->get_error_message(), __( 'Error' ) . $response->get_error_code() );
		}

		$response = json_decode( wp_remote_retrieve_body( $response ) );

		return $response;
	}

	/**
	 * Disable requests to wp.org repository for this theme.
	 *
	 * @since 2.0.0
	 */
	function disable_wporg_request( $r, $url ) {

		// If it's not a theme update request, bail.
		if ( 0 !== strpos( $url, 'https://api.wordpress.org/themes/update-check/1.1/' ) ) {
 			return $r;
 		}

 		// Decode the JSON response
 		$themes = json_decode( $r['body']['themes'] );

 		// Remove the active parent and child themes from the check
 		$parent = get_option( 'template' );
 		$child = get_option( 'stylesheet' );
 		unset( $themes->themes->$parent );
 		unset( $themes->themes->$child );

 		// Encode the updated JSON response
 		$r['body']['themes'] = json_encode( $themes );

 		return $r;
	}

	/**
	 * Creates the updater class.
	 *
	 * since 1.0.0
	 */
	function updater() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		/* If site is not active, don't allow updates. */
		$active = get_option( THEME_SLUG . '_active_status', false );
		if ( $active === false ) $active = get_option( THEME_SLUG . '_license_key_status', false ); // Backward Compat
		if ( $active != 'valid' ) {
			return;
		}

		new Hoot_Theme_Updater( array(
			'remote_api_url' 	=> $this->args['remote_api_url'],
			'version' 			=> $this->args['version'],
			'license' 			=> trim( get_option( THEME_SLUG . '_license_key' ) ),
			'item_name' 		=> $this->args['item_name'],
			'author'			=> $this->args['author'],
		) );
	}

}