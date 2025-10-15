<?php
/**
 * Helper functions
 *
 * @package Edgeframe
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Convert various values to boolean
 *
 * @param mixed $value Value to convert.
 * @return bool
 */
function edgeframe_bool( $value ) {
	return ! empty( $value ) && '0' !== $value && 'false' !== $value;
}

/**
 * Convert array of attributes to HTML attribute string
 *
 * @param array $attrs Attributes.
 * @return string
 */
function edgeframe_attr( $attrs ) {
	$out = array();
	foreach ( $attrs as $k => $v ) {
		if ( $v === true ) {
			$out[] = esc_attr( $k );
			continue; }
		if ( $v === false || $v === null ) {
			continue; }
		$out[] = sprintf( '%s="%s"', esc_attr( $k ), esc_attr( (string) $v ) );
	}
	return implode( ' ', $out );
}

/**
 * Check if current page is blog-like (blog index, archive, search)
 *
 * @return bool
 */
function edgeframe_is_blog_like() {
	return is_home() || is_archive() || is_search();
}

/**
 * Check if current page is singular (not front page)
 *
 * @return bool
 */
function edgeframe_is_singular() {
	return is_singular() && ! is_front_page();
}

/**
 * Get SVG icon
 *
 * @param string $name Icon name (without "icon-" prefix).
 * @return string
 */
function edgeframe_get_icon( $name ) {
	$icon_file = EDGEFRAME_PATH . '/assets/icons/icon-' . $name . '.svg';
	if ( file_exists( $icon_file ) ) {
		return file_get_contents( $icon_file );
	}
	return '';
}

/**
 * Echo SVG icon
 *
 * @param string $name Icon name (without "icon-" prefix).
 */
function edgeframe_icon( $name ) {
	echo edgeframe_get_icon( $name ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
