<?php
/**
 * General Variables available: $name, $params, $args, $content
 * $args has been 'extract'ed
 */

global $hoot_theme;

$block = array();

$block['icon'] = ( !empty( $icon ) && empty( $image ) ) ? $icon : '';
$block['image'] = ( !empty( $image ) ) ? $image : '';
$block['title'] = ( !empty( $title ) ) ? $title : '';
$block['content'] = $content;

$hoot_theme->contentblocks[] = $block;

return '';