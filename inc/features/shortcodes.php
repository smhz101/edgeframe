<?php
/**
 * Shortcodes
 *
 * @package Edgeframe
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Year shortcode (plugin territory)
 *
 * Note: Shortcodes should be registered by plugins, not themes.
 * If you need this, move it to a small utility plugin and register via add_shortcode there.
 */
if ( ! function_exists( 'edgeframe_sc_year' ) ) {
	function edgeframe_sc_year() {
		return (string) gmdate( 'Y' );
	}
}
// add_shortcode( 'year', 'edgeframe_sc_year' ); // Intentionally disabled in theme for WP.org compliance.
