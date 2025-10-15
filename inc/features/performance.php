<?php
/**
 * Performance features for the EdgeFrame theme.
 *
 * @package EdgeFrame
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', 'edgeframe_disable_emojis' );
/**
 * Disable emojis for better performance.
 */
function edgeframe_disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
}

add_filter( 'wp_resource_hints', 'edgeframe_dns_prefetch', 10, 2 );
/**
 * Add DNS prefetch for Google Fonts to improve performance.
 *
 * @param array  $hints         The URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed for.
 * @return array Modified array of URLs to print for resource hints.
 */
function edgeframe_dns_prefetch( $hints, $relation_type ) {
	if ( 'dns-prefetch' === $relation_type ) {
		$hints[] = 'https://fonts.gstatic.com';
		$hints[] = 'https://fonts.googleapis.com';
	}
	return $hints;
}
