<?php
/**
 * General Variables available: $name, $params, $args, $content
 * $args has been 'extract'ed
 */

/* Reset any previous contentblocks */
global $hoot_theme;
$hoot_theme->contentblocks = array();

/* Generate contentblocks data */
do_shortcode( $content );
$style = ( empty( $style ) ) ? 'style1' : $style;
$columns = ( empty( $columns ) ) ? '3' : $columns;
$icon_style = ( empty( $icon ) ) ? 'none' : $icon;

// Get total columns and set column counter
$columns = ( intval( $columns ) >= 1 && intval( $columns ) <= 5 ) ? intval( $columns ) : 3;
$column = $count = 1;

/* Display Content Block Row */

$output = '';

$output .= '<div class="shortcode-content-block content-blocks-widget-wrap topborder-none">';
	$output .= '<div class="content-blocks-widget-box bottomborder-none">';
		$output .= '<div class="content-blocks-widget ' . esc_attr( 'content-blocks-widget-' . $style ) . '">';
			if ( !empty( $hoot_theme->contentblocks ) ) :

				$output .= '<div class="flush-columns">';

				foreach ( $hoot_theme->contentblocks as $block ) :

					$has_image = $has_icon = false;
					if ( !empty( $block['image'] ) )
						$has_image = true;
					elseif ( !empty( $block['icon'] ) )
						$has_icon = true;

					$blockstyle = $style;
					// Style-3 exceptions: doesnt work great with icons of 'None' style, or with images. So revert to Style-2 for this scenario.
					if ( $style == 'style3' && ( $has_image || ( $has_icon && $icon_style == 'none' ) ) ) $blockstyle = 'style2';

					$output .= '<div class="content-block-column hcolumn-1-' . esc_attr( $columns ) . " content-block-{$count} " . esc_attr( 'content-block-' . $blockstyle ). '">';
					$count++;

						$block_class = ( !$has_image && !$has_icon ) ? 'no-highlight' : ( ( $blockstyle == 'style2' ) ? 'contrast-typo' : '' );

						$output .= '<div class="content-block ' . $block_class . '">';

							if ( $has_image ) {
								$output .= '<div class="content-block-visual content-block-image">';
									$output .= '<img src="' . esc_url( $block['image'] ) . '" class="content-block-img" itemprop="image">';
								$output .= '</div>';
							} elseif ( $has_icon ) {
								$contrast_class = ( 'none' == $icon_style ) ? '' : ' contrast-typo ';
								$output .= '<div class="content-block-visual content-block-icon icon-style-' . esc_attr( $icon_style ) . $contrast_class . '">';
									$output .= '<i class="' . hoot_sanitize_fa( $block['icon'] ) . '"></i>';
								$output .= '</div>';
							}

							$content_class = '';
							if ( $has_image ) $content_class = ' content-block-content-hasimage';
							elseif ( $has_icon ) $content_class = ' content-block-content-hasicon';
							else $content_class = ' no-visual';
							$output .= '<div class="content-block-content ' . $content_class . '">';
								if ( !empty( $block['title'] ) )
									$output .= '<h4>' . esc_html( $block['title'] ) . '</h4>';
								$output .= '<div class="content-block-text">' . wpautop( do_shortcode( $block['content'] ) ) .'</div>';
							$output .= '</div>';

						$output .= '</div>';
					$output .= '</div>';

					$column++;
					if ( $column > $columns ) {
						$column = 1;
						$output .= '<div class="clearfix"></div>';
					}

				endforeach;

				$output .= '</div>';

			endif;
			$output .= '<div class="clearfix"></div>';
		$output .= '</div>';
	$output .= '</div>';
$output .= '</div>';

return $output;