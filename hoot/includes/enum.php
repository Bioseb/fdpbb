<?php
/**
 * Data Sets
 *
 * @package hoot
 * @subpackage framework
 * @since hoot 2.0.0
 */

/**
 * Get background repeat settings
 *
 * @param string $return array to return icons|sections|list/empty
 * @return array
 */
if ( !function_exists( 'hoot_enum_icons' ) ):
function hoot_enum_icons( $return = 'list' ) {
	$return = ( empty( $return ) ) ? 'list' : $return;
	$list = array();

	if ( !function_exists( 'hoot_fonticons_list' ) ) return array();

	if ( $return == 'sections' || $return == 'section' )
		$list = hoot_fonticons_list('sections');

	if ( $return == 'icons' || $return == 'icon' )
		$list = hoot_fonticons_list('icons');

	if ( $return == 'lists' || $return == 'list' ) {
		$iconsList = hoot_fonticons_list('icons');
		foreach ( $iconsList as $name => $array )
			$list = array_merge( $list, $array );
	}

	return apply_filters( 'hoot_enum_icons', $list, $return );

}
endif;

/**
 * Get background repeat settings
 *
 * @return array
 */
if ( !function_exists( 'hoot_enum_background_repeat' ) ):
function hoot_enum_background_repeat() {
	$default = array(
		'no-repeat' => __( 'No Repeat', 'dispatch-premium' ),
		'repeat-x'  => __( 'Repeat Horizontally', 'dispatch-premium' ),
		'repeat-y'  => __( 'Repeat Vertically', 'dispatch-premium' ),
		'repeat'    => __( 'Repeat All', 'dispatch-premium' ),
		);
	return apply_filters( 'hoot_enum_background_repeat', $default );
}
endif;

/**
 * Get background positions
 *
 * @return array
 */
if ( !function_exists( 'hoot_enum_background_position' ) ):
function hoot_enum_background_position() {
	$default = array(
		'top left'      => __( 'Top Left', 'dispatch-premium' ),
		'top center'    => __( 'Top Center', 'dispatch-premium' ),
		'top right'     => __( 'Top Right', 'dispatch-premium' ),
		'center left'   => __( 'Middle Left', 'dispatch-premium' ),
		'center center' => __( 'Middle Center', 'dispatch-premium' ),
		'center right'  => __( 'Middle Right', 'dispatch-premium' ),
		'bottom left'   => __( 'Bottom Left', 'dispatch-premium' ),
		'bottom center' => __( 'Bottom Center', 'dispatch-premium' ),
		'bottom right'  => __( 'Bottom Right', 'dispatch-premium')
		);
	return apply_filters( 'hoot_enum_background_position', $default );
}
endif;

/**
 * Get background attachment settings
 *
 * @return array
 */
if ( !function_exists( 'hoot_enum_background_attachment' ) ):
function hoot_enum_background_attachment() {
	$default = array(
		'scroll' => __( 'Scroll Normally', 'dispatch-premium' ),
		'fixed'  => __( 'Fixed in Place', 'dispatch-premium'),
		);
	return apply_filters( 'hoot_enum_background_attachment', $default );
}
endif;

/**
 * Get background types
 *
 * @return array
 */
if ( !function_exists( 'hoot_enum_background_type' ) ):
function hoot_enum_background_type() {
	$default = array(
		'predefined' => __( 'Predefined Pattern', 'dispatch-premium' ),
		'custom'     => __( 'Custom Image', 'dispatch-premium' ),
		);
	return apply_filters( 'hoot_enum_background_type', $default );
}
endif;

/**
 * Get background patterns
 *
 * @return array
 */
if ( !function_exists( 'hoot_enum_background_pattern' ) ):
function hoot_enum_background_pattern() {
	$relative = trailingslashit( substr( trailingslashit( HOOT_IMAGES ) . 'patterns' , ( strlen( THEME_URI ) + 1 ) ) );
	$default = array(
		0 => trailingslashit( HOOT_IMAGES ) . 'patterns/0_preview.jpg',
		$relative . '1.png' => trailingslashit( HOOT_IMAGES ) . 'patterns/1_preview.jpg',
		$relative . '2.png' => trailingslashit( HOOT_IMAGES ) . 'patterns/2_preview.jpg',
		$relative . '3.png' => trailingslashit( HOOT_IMAGES ) . 'patterns/3_preview.jpg',
		$relative . '4.png' => trailingslashit( HOOT_IMAGES ) . 'patterns/4_preview.jpg',
		$relative . '5.png' => trailingslashit( HOOT_IMAGES ) . 'patterns/5_preview.jpg',
		$relative . '6.png' => trailingslashit( HOOT_IMAGES ) . 'patterns/6_preview.jpg',
		$relative . '7.png' => trailingslashit( HOOT_IMAGES ) . 'patterns/7_preview.jpg',
		$relative . '8.png' => trailingslashit( HOOT_IMAGES ) . 'patterns/8_preview.jpg',
		);
	return apply_filters( 'hoot_enum_background_pattern', $default );
}
endif;

/**
 * Get background attachment
 *
 * @return array
 */
if ( !function_exists( 'hoot_enum_background_attachment' ) ):
function hoot_enum_background_attachment() {
	$default = array(
		'scroll' => __( 'Scroll Normally', 'dispatch-premium' ),
		'fixed'  => __( 'Fixed in Place', 'dispatch-premium')
		);
	return apply_filters( 'hoot_enum_background_attachment', $default );
}
endif;

/**
 * Get font sizes.
 *
 * Returns an indexed array of all recognized font sizes.
 * Values are integers and represent a range of sizes from
 * smallest to largest.
 *
 * @return array
 */
if ( !function_exists( 'hoot_enum_font_sizes' ) ):
function hoot_enum_font_sizes( $min = 9, $max = 82 ) {
	static $cache = array();
	if ( empty( $cache ) || $min != 9 || $max != 82 ) {
		$range = wp_parse_args( apply_filters( 'hoot_enum_font_sizes', array() ), array(
			'min' => $min,
			'max' => $max,
			) );
		$sizes = range( $range['min'], $range['max'] );
		$sizes = array_map( 'absint', $sizes );
	}
	if ( empty( $cache ) && $min == 9 && $max -= 82 )
		$cache = $sizes;
	return $sizes;
}
endif;

/**
 * Get font sizes for optiosn array
 *
 * Returns an indexed array of all recognized font sizes.
 * Values are integers and represent a range of sizes from
 * smallest to largest.
 *
 * @return array
 */
if ( !function_exists( 'hoot_enum_font_sizes_array' ) ):
function hoot_enum_font_sizes_array( $min = 9, $max = 82, $postfix = 'px' ) {
	$sizes = hoot_enum_font_sizes( $min, $max );
	$output = array();
	foreach ( $sizes as $size )
		$output[ $size ] = $size . $postfix;
	return $output;
}
endif;

/**
 * Get font faces.
 *
 * Returns an array of all recognized font faces.
 * Keys are intended to be stored in the database
 * while values are ready for display in in html.
 *
 * @param string $return array to return websafe|google-fonts|empty/list
 * @return array
 */
if ( !function_exists( 'hoot_enum_font_faces' ) ):
function hoot_enum_font_faces( $return = '' ) {
	$fonts = array();
	$webfonts = ( function_exists('hoot_fonts_list') ) ? hoot_fonts_list() : array();
	$googlefonts = ( function_exists('hoot_googlefonts_list') ) ? hoot_googlefonts_list() : apply_filters( 'hoot_google_fonts', array() );

	if ( $return == 'websafe' )
		$fonts = $webfonts;
	elseif ( $return == 'google-fonts' || $return == 'google-font' )
		$fonts = $googlefonts;
	else
		$fonts = array_merge( $webfonts, $googlefonts );

	return apply_filters( 'hoot_enum_font_faces', $fonts, $return );
}
endif;

/**
 * Get font styles.
 *
 * Returns an array of all recognized font styles.
 * Keys are intended to be stored in the database
 * while values are ready for display in in html.
 *
 * @return array
 */
if ( !function_exists( 'hoot_enum_font_styles' ) ):
function hoot_enum_font_styles() {
	$default = array(
		'none'                     => __( 'None', 'dispatch-premium' ),
		'italic'                   => __( 'Italic', 'dispatch-premium' ),
		'bold'                     => __( 'Bold', 'dispatch-premium' ),
		'bold italic'              => __( 'Bold Italic', 'dispatch-premium' ),
		'lighter'                  => __( 'Light', 'dispatch-premium' ),
		'lighter italic'           => __( 'Light Italic', 'dispatch-premium' ),
		'uppercase'                => __( 'Uppercase', 'dispatch-premium' ),
		'uppercase italic'         => __( 'Uppercase Italic', 'dispatch-premium' ),
		'uppercase bold'           => __( 'Uppercase Bold', 'dispatch-premium' ),
		'uppercase bold italic'    => __( 'Uppercase Bold Italic', 'dispatch-premium' ),
		'uppercase lighter'        => __( 'Uppercase Light', 'dispatch-premium' ),
		'uppercase lighter italic' => __( 'Uppercase Light Italic', 'dispatch-premium' )
		);
	return apply_filters( 'hoot_enum_font_styles', $default );
}
endif;

/**
 * Get social profiles and icons
 *
 * Returns an array of all recognized social profiles.
 * Keys are intended to be stored in the database
 * while values are ready for display in in html.
 *
 * @return array
 */
if ( !function_exists( 'hoot_enum_social_profiles' ) ):
function hoot_enum_social_profiles( $skype = true, $email = true ) {
	$social = array(
		'fa-amazon'         => __( 'Amazon', 'dispatch-premium' ),
		'fa-android'        => __( 'Android', 'dispatch-premium' ),
		'fa-apple'          => __( 'Apple', 'dispatch-premium' ),
		'fa-bandcamp'       => __( 'Bandcamp', 'dispatch-premium' ),
		'fa-behance'        => __( 'Behance', 'dispatch-premium' ),
		'fa-bitbucket'      => __( 'Bitbucket', 'dispatch-premium' ),
		'fa-btc'            => __( 'BTC', 'dispatch-premium' ),
		'fa-buysellads'     => __( 'BuySellAds', 'dispatch-premium' ),
		'fa-codepen'        => __( 'Codepen', 'dispatch-premium' ),
		'fa-codiepie'       => __( 'Codie Pie', 'dispatch-premium' ),
		'fa-contao'         => __( 'Contao', 'dispatch-premium' ),
		'fa-dashcube'       => __( 'Dash Cube', 'dispatch-premium' ),
		'fa-delicious'      => __( 'Delicious', 'dispatch-premium' ),
		'fa-deviantart'     => __( 'Deviantart', 'dispatch-premium' ),
		'fa-digg'           => __( 'Digg', 'dispatch-premium' ),
		'fa-dribbble'       => __( 'Dribbble', 'dispatch-premium' ),
		'fa-dropbox'        => __( 'Dropbox', 'dispatch-premium' ),
		'fa-eercast'        => __( 'Eercast', 'dispatch-premium' ),
		'fa-envelope'       => __( 'Email', 'dispatch-premium' ),
		'fa-etsy'           => __( 'Etsy', 'dispatch-premium' ),
		'fa-facebook'       => __( 'Facebook', 'dispatch-premium' ),
		'fa-flickr'         => __( 'Flickr', 'dispatch-premium' ),
		'fa-forumbee'       => __( 'Forumbee', 'dispatch-premium' ),
		'fa-foursquare'     => __( 'Foursquare', 'dispatch-premium' ),
		'fa-free-code-camp' => __( 'Free Code Camp', 'dispatch-premium' ),
		'fa-get-pocket'     => __( 'Pocket (getpocket)', 'dispatch-premium' ),
		'fa-github'         => __( 'Github', 'dispatch-premium' ),
		'fa-google'         => __( 'Google', 'dispatch-premium' ),
		'fa-google-plus'    => __( 'Google Plus', 'dispatch-premium' ),
		'fa-google-wallet'  => __( 'Google Wallet', 'dispatch-premium' ),
		'fa-houzz'          => __( 'Houzz', 'dispatch-premium' ),
		'fa-imdb'           => __( 'IMDB', 'dispatch-premium' ),
		'fa-instagram'      => __( 'Instagram', 'dispatch-premium' ),
		'fa-jsfiddle'       => __( 'JS Fiddle', 'dispatch-premium' ),
		'fa-lastfm'         => __( 'Last FM', 'dispatch-premium' ),
		'fa-leanpub'        => __( 'Leanpub', 'dispatch-premium' ),
		'fa-linkedin'       => __( 'Linkedin', 'dispatch-premium' ),
		'fa-meetup'         => __( 'Meetup', 'dispatch-premium' ),
		'fa-mixcloud'       => __( 'Mixcloud', 'dispatch-premium' ),
		'fa-paypal'         => __( 'Paypal', 'dispatch-premium' ),
		'fa-pinterest'      => __( 'Pinterest', 'dispatch-premium' ),
		'fa-quora'          => __( 'Quora', 'dispatch-premium' ),
		'fa-reddit'         => __( 'Reddit', 'dispatch-premium' ),
		'fa-rss'            => __( 'RSS', 'dispatch-premium' ),
		'fa-scribd'         => __( 'Scribd', 'dispatch-premium' ),
		'fa-skype'          => __( 'Skype', 'dispatch-premium' ),
		'fa-slack'          => __( 'Slack', 'dispatch-premium' ),
		'fa-slideshare'     => __( 'Slideshare', 'dispatch-premium' ),
		'fa-snapchat'       => __( 'Snapchat', 'dispatch-premium' ),
		'fa-soundcloud'     => __( 'Soundcloud', 'dispatch-premium' ),
		'fa-spotify'        => __( 'Spotify', 'dispatch-premium' ),
		'fa-stack-exchange' => __( 'Stack Exchange', 'dispatch-premium' ),
		'fa-stack-overflow' => __( 'Stack Overflow', 'dispatch-premium' ),
		'fa-steam'          => __( 'Steam', 'dispatch-premium' ),
		'fa-stumbleupon'    => __( 'Stumbleupon', 'dispatch-premium' ),
		'fa-trello'         => __( 'Trello', 'dispatch-premium' ),
		'fa-tripadvisor'    => __( 'Trip Advisor', 'dispatch-premium' ),
		'fa-tumblr'         => __( 'Tumblr', 'dispatch-premium' ),
		'fa-twitch'         => __( 'Twitch', 'dispatch-premium' ),
		'fa-twitter'        => __( 'Twitter', 'dispatch-premium' ),
		'fa-viadeo'         => __( 'Viadeo', 'dispatch-premium' ),
		'fa-vimeo-square'   => __( 'Vimeo', 'dispatch-premium' ),
		'fa-vk'             => __( 'VK', 'dispatch-premium' ),
		'fa-wikipedia-w'    => __( 'Wikipedia', 'dispatch-premium' ),
		'fa-windows'        => __( 'Windows', 'dispatch-premium' ),
		'fa-wordpress'      => __( 'Wordpress', 'dispatch-premium' ),
		'fa-xing'           => __( 'Xing', 'dispatch-premium' ),
		'fa-y-combinator'   => __( 'Y Combinator', 'dispatch-premium' ),
		'fa-yelp'           => __( 'Yelp', 'dispatch-premium' ),
		'fa-youtube'        => __( 'Youtube', 'dispatch-premium' ),
	);
	if ( !$skype ) unset( $social['fa-skype'] );
	if ( !$email ) unset( $social['fa-envelope'] );
	return apply_filters( 'hoot_enum_social_profiles', $social, $skype );
}
endif;