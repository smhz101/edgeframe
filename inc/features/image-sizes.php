<?php
/**
 * Define custom image sizes.
 *
 * @package Edgeframe
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'after_setup_theme', 'edgeframe_add_image_sizes' );
/**
 * Add custom image sizes.
 */
function edgeframe_add_image_sizes() {
	add_image_size( 'edgeframe-card', 800, 450, true );
	add_image_size( 'edgeframe-thumb', 400, 400, true );
}
