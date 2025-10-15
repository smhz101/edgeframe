<?php
/**
 * Block editor compatibility for the EdgeFrame theme.
 *
 * @package EdgeFrame
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'after_setup_theme', 'edgeframe_block_editor_supports' );
/**
 * Add support for block editor features.
 */
function edgeframe_block_editor_supports() {
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'wp-block-styles' );
}
