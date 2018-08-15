<?php
/**
 * Modify the default 404 page to show a custom static Page instead
 *
 * @package hoot
 * @subpackage framework
 * @since hoot 1.1.0
 */

/* modify main query for 404 page: use 'wp' instead of 'pre_get_posts' action. */
add_action( 'wp', 'hoot_alter_404_query', 10 );

/**
 * Alter main query to display a user set custom page as 404 page
 * This function is hooked to 'wp' instead of 'pre_get_posts':
 *     1. to allow use of conditional tag is_404() within the function
 *     2. alter query only once early on (pre_get_posts can be executed more than once)
 *
 * @since 1.0.0
 * @access public
 * @return void
 */
function hoot_alter_404_query() {
	if ( is_404() ) {
		if ( 'custom' == hoot_get_mod('404_page') ) {

			$page_404 = intval( hoot_get_mod('404_custom_page') );
			if ( !empty( $page_404 ) && !is_admin() && is_main_query() ) {

				// alter main query
				query_posts( "page_id=$page_404" );
				//restores the global $post variable to the current post in the main query.
				wp_reset_postdata();

				// Once query is changed and postdata is updated, is_404() will return false. Hence set our own variable.
				global $hoot;
				$hoot->is_404 = true;

			}

		}
	}
}