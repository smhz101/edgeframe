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
 * Register theme shortcodes if enabled.
 *
 * Use filter 'edgeframe_enable_theme_shortcodes' to disable in environments where shortcodes are plugin territory.
 */
// Disabled in theme build. Move shortcodes to a plugin.
// add_action( 'init', function() {
// add_shortcode( 'year', 'edgeframe_sc_year' );
// add_shortcode( 'site_title', 'edgeframe_sc_site_title' );
// add_shortcode( 'site_tagline', 'edgeframe_sc_site_tagline' );
// add_shortcode( 'button', 'edgeframe_sc_button' );
// add_shortcode( 'breadcrumbs', 'edgeframe_sc_breadcrumbs' );
// } );

/**
 * [year] — current year
 */
function edgeframe_sc_year() {
	return (string) gmdate( 'Y' );
}

/**
 * [site_title] — blog name
 */
function edgeframe_sc_site_title() {
	return esc_html( get_bloginfo( 'name' ) );
}

/**
 * [site_tagline] — blog description
 */
function edgeframe_sc_site_tagline() {
	return esc_html( get_bloginfo( 'description' ) );
}

/**
 * [button text="Buy Now" url="https://example.com" target="_blank" style="outline"]Content overrides text[/button]
 */
function edgeframe_sc_button( $atts = array(), $content = '' ) {
	$atts = shortcode_atts(
		array(
			'text'   => '',
			'url'    => '',
			'target' => '', // _self|_blank
			'style'  => 'primary', // primary|outline|ghost
		),
		$atts,
		'button'
	);

	$text   = $content !== '' ? wp_strip_all_tags( $content ) : $atts['text'];
	$text   = $text ? $text : __( 'Learn more', 'edgeframe' );
	$url    = esc_url( $atts['url'] );
	$target = in_array( $atts['target'], array( '_blank', '_self' ), true ) ? $atts['target'] : '';
	$style  = in_array( $atts['style'], array( 'primary', 'outline', 'ghost' ), true ) ? $atts['style'] : 'primary';

	$classes = 'ef-button ef-button--' . $style;
	$attrs   = array( 'class' => $classes );
	if ( $url ) {
		$attrs['href'] = $url;
	}
	if ( '_blank' === $target ) {
		$attrs['target'] = '_blank';
		$attrs['rel']    = 'noopener noreferrer';
	}

	$attr_html = '';
	foreach ( $attrs as $k => $v ) {
		$attr_html .= ' ' . $k . '="' . esc_attr( $v ) . '"';
	}

	return '<a' . $attr_html . '>' . esc_html( $text ) . '</a>';
}

/**
 * [breadcrumbs] — outputs the theme breadcrumbs
 */
function edgeframe_sc_breadcrumbs() {
	if ( ! function_exists( 'edgeframe_breadcrumbs' ) ) {
		return '';
	}
	ob_start();
	edgeframe_breadcrumbs();
	return (string) ob_get_clean();
}
