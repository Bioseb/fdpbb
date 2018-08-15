<?php
$site_info = hoot_get_mod( 'site_info' );
$site_info = str_replace( "<!--year-->" , date_i18n( 'Y' ) , $site_info );
if ( !empty( $site_info ) ) :
?>
	<div id="post-footer" class="hgrid-stretch contrast-typo">
		<div class="hgrid">
			<div class="hgrid-span-12">
				<p class="credit small">
					<?php
					if ( trim( $site_info ) == '<!--default-->' ) {
						printf(
							/* Translators: 1 is Privacy Policy link 2 is Theme name/link, 3 is WordPress name/link, 4 is site name/link */
							__( '%1$s Designed using %2$s. Powered by %3$s.', 'dispatch-premium' ),
							( function_exists( 'get_the_privacy_policy_link' ) ) ? get_the_privacy_policy_link() : '',
							hoot_get_wp_theme_link( 'https://wordpress.org/themes/dispatch/' ),
							hoot_get_wp_link(),
							hoot_get_site_link()
						);
					} else {
						echo $site_info;
					} ?>
				</p><!-- .credit -->
			</div>
		</div>
	</div>
<?php
endif;
?>