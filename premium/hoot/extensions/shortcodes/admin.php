<?php
/**
 * Hoot Shortcodes Admin - Shortcode Generator
 * This file is loaded via the 'after_setup_theme' hook at priority '14'
 *
 * @package hoot
 * @subpackage framework
 * @since hoot 1.1.0
 */

/**
 * Shortcodes Admin class. This wraps everything up nicely.
 *
 * @since 1.1.0
 */
class Hoot_Shortcodes_Admin {

	/**
	 * Holds the list of available shortcodes (and their settings+options).
	 *
	 * @since 1.1.0
	 * @access private
	 * @var object
	 */
	private $shortcodes;

	/**
	 * Setup Shortcodes
	 * 
	 * @since 1.1.0
	 * @access public
	 * @return void
	 */
	public function __construct() {

		/* Load the required Options Extension for building options */
		require_once( trailingslashit( HOOT_PREMIUM_EXTENSIONS ) . 'options/init.php' );
		add_action( 'hoot_shortcode_gen_enqueue', array( $this, 'options_enqueue' ) );

		// Hook Shortcode Generator to edit 'single' (post/page/cpt) screen
		add_action( 'load-post.php', array( $this, 'init' ) );
		add_action( 'load-post-new.php', array( $this, 'init' ) );

	}

	/**
	 * Init Shortcode Generator
	 * Hooked to 'load-(page)' action (after 'admin_init'), so 'get_current_screen()' function is available
	 * 
	 * @since 1.1.0
	 * @access public
	 * @return void
	 */
	public function init() {
		$screen = get_current_screen();
		$post_type = $screen->post_type;

		// Check current screen, and user capability
		if ( ( 'post' === $post_type && current_user_can( 'edit_posts' ) ) || ( 'page' === $post_type && current_user_can( 'edit_pages' ) ) ) :

			/* Get shortcodes array */
			$this->shortcodes = Hoot_Shortcodes::get_shortcodes_array();

			/* Add the required scripts and styles */
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles_scripts' ) );

			/* Add button to main content editor */
			add_action( 'media_buttons', array( $this, 'button' ), 1000 );

			/* Thickbox content */
			add_action( 'admin_footer', array( $this, 'thickbox' ) );

		endif;
	}

	/**
	 * Loads the required stylesheets and scripts
	 *
	 * @since 1.1.0
	 */
	function enqueue_admin_styles_scripts( $hook ) {

		/* Enqueue Supporting Scripts and Styles */
		wp_enqueue_style( 'font-awesome' );

		/* Magnific Popup */
		$style_uri = hoot_locate_style( trailingslashit( HOOT_CSS ) . 'magnific-popup' );
		wp_enqueue_style( 'magnific-popup', $style_uri, array(),  '1.0.0' );
		$script_uri = hoot_locate_script( trailingslashit( HOOT_JS ) . 'jquery.magnific-popup' );
		wp_enqueue_script( 'magnific-popup', $script_uri, array( 'jquery' ), '1.0.0', true );

		/* Enqueue Shortcode Generator Styles */
		$style_uri = hoot_locate_style( trailingslashit( HOOT_CSS ) . 'shortcode-gen' );
		wp_enqueue_style( 'hoot-shortcode-gen', $style_uri, array(),  HOOT_VERSION );

		/* Enqueue Shortcode Generator Scripts */
		$script_uri = hoot_locate_script( trailingslashit( HOOT_JS ) . 'shortcode-gen' );
		wp_enqueue_script( 'hoot-shortcode-gen', $script_uri, array( 'jquery','wp-color-picker','hoot-options-media-uploader' ), HOOT_VERSION, true );

		/* Let theme add custom css for specific shortcodes for the generator */
		do_action( 'hoot_shortcode_gen_enqueue', $hook );

	}

	/**
	 * Loads Hoot Options stylesheets and scripts
	 *
	 * @since 2.0.0
	 */
	function options_enqueue( $hook ) {
		global $hoot_options;
		$hoot_options->enqueue( $hook );
	}

	/**
	 * Generator button
	 *
	 * @since 1.1.0
	 */
	public static function button( $args = array() ) {

		// Prepare button target
		$target = is_string( $args ) ? $args : 'content';

		// Only add to main content editor
		if ( 'content' !== $target )
			return;

		// Prepare args
		$args = wp_parse_args( $args, array(
				'target'    => $target,
				'text'      => __( 'Insert shortcode', 'dispatch-premium' ),
				'class'     => 'button',
				'icon'      => true,
				'echo'      => true,
				'shortcode' => false
			) );

		// Prepare icon
		if ( $args['icon'] ) $args['icon'] = '<i class="fas fa-magic"></i> ';

		// Render button HTML
		if ( 'content' === $target )
			$button_id = 'id="hoot-insert-shortcode"';
		$button = '<a href="javascript:void(0);" ' . $button_id . ' class="hoot-sc-generator-button ' . $args['class'] . '" title="' . $args['text'] . '" data-target="' . $args['target'] . '" data-mfp-src="#hoot-sc-generator">' . $args['icon'] . $args['text'] . '</a>';

		if ( $args['echo'] )
			echo $button;
		return $button;
	}

	/**
	 * Render Shortcode Generator Thickbox HTML
	 *
	 * @since 1.1.0
	 */
	function thickbox() { ?>

		<div id="hoot-sc-generator-wrap">
			<div id="hoot-sc-generator" class="mfp-hide">
				<div class="hoot-sc-generator-menu">
					<h4><?php _e( 'Select Shortcode', 'dispatch-premium' ) ?></h4>
					<div class="hoot-sc-generator-list">
						<ul>
							<?php
							$hoot_scgen_title = '';
							foreach( $this->shortcodes as $key => $settings ) {
								if ( !isset( $settings['type'] ) )
									continue;
								// Skip if internal
								if ( 'shortcode' == $settings['type'] && isset( $settings['options'] ) ) {
									$hoot_scgen_title = ( empty( $hoot_scgen_title ) ) ? $settings['title'] : $hoot_scgen_title;
									echo '<li>'
										. '<a href="#" data-shortcode="' . esc_attr( $key ) . '">'
										. esc_html( $settings['title'] )
										. '</a>'
										. '</li>';
								} elseif ( 'title' == $settings['type'] ) {
									echo '<li class="subhead">' . esc_html( $settings['title'] ) . '</li>';
								}
							} ?>
						</ul>
					</div>
				</div>
				<div class="hoot-sc-generator-content-wrap">
					<div class="hoot-sc-generator-content">
						<h2><?php printf( __( '%s Shortcode', 'dispatch-premium' ), "<span>$hoot_scgen_title</span>" ) ?></h2>
						<div class="hoot-sc-generator-content-inner hootoptions">
							<?php $this->thickbox_fields(); ?>
						</div>
					</div>
					<div class="hoot-sc-generator-toolbar">
						<a href="#" class="button button-primary button-large hoot-sc-generator-insert">Insert into post</a>
						<div class="clear"></div>
					</div>
				</div>
			</div>
		</div>

	<?php
	}

	/**
	 * Render Shortcode Generator's Shortcode Fields
	 *
	 * @since 1.1.0
	 */
	function thickbox_fields() {
		foreach( $this->shortcodes as $key => $settings ) {

			// Skip if not a shortcode
			if ( !isset( $settings['type'] ) || 'shortcode' !== $settings['type'] || !isset( $settings['options'] ) )
				continue;

			// Filter Options
			$check = array();
			foreach( $settings['options'] as $opkey => $opvalue ) {
				if ( isset( $opvalue['id'] ) ) {

					// Check for duplicates
					if ( !in_array( $opvalue['id'], $check ) )
						$check[] = $opvalue['id'];
					else
						unset( $settings['options'][ $opkey ] );

					/* Process Fields (Add required data attributes) */
					if ( 'info' == $opvalue['type'] ) { //Do nothing. Keep this check here.
					}
					// Main Content Field
					elseif ( 'content' == $opvalue['id'] ) {
						$settings['options'][ $opkey ]['data']['sctype'] = 'content';
					}
					// Setup groups as content field
					elseif ( 'group' == $opvalue['type'] ) {
						$settings['options'][ $opkey ]['data']['sctype'] = 'content';
						$settings['options'][ $opkey ]['data']['scname'] = $opvalue['id'];
						foreach( $opvalue['fields'] as $groupkey => $groupfield ) {
							if ( 'info' == $groupfield['type'] ) { // Do nothing. Keep this check here.
							} elseif ( 'content' === $groupfield['id'] ) {
								$settings['options'][ $opkey ]['fields'][ $groupkey ]['data']['subsctype'] = 'content';
							} elseif ( !isset( $groupfield['hide_as_attribute'] ) || true !== $groupfield['hide_as_attribute'] ) {
								$settings['options'][ $opkey ]['fields'][ $groupkey ]['data']['subsctype'] = 'attribute';
								$settings['options'][ $opkey ]['fields'][ $groupkey ]['data']['subscname'] = $groupfield['id'];
							}
						}
					}
					// Attributes Fields
					elseif ( !isset( $opvalue['hide_as_attribute'] ) || true !== $opvalue['hide_as_attribute'] ) {
						$settings['options'][ $opkey ]['data']['sctype'] = 'attribute';
						$settings['options'][ $opkey ]['data']['scname'] = $opvalue['id'];
					}
					// Custom Filtering
					$settings['options'][ $opkey ] = apply_filters( 'hoot_shortcode_generator_single_option', $settings['options'][ $opkey ] );

				}
			}

			// Prepare Options Array for Shortcode
			$options = array();
			$options[] = array(
				'type' => 'html',
				'std'  => '<div class="hoot-sc-section hoot-sc-section-' . esc_attr( $key ) . '" data-shortcode="' . esc_attr( $key ) . '">',
				);
			$options = array_merge( $options, $settings['options'] );
			$options[] = array(
				'type' => 'html',
				'std'  => '</div>',
				);

			// Display Fields
			Hoot_Options::build( $options, array(), 'hoot-scfield-' . $key );

		}
	}

}