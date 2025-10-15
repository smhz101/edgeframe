<?php
/**
 * Theme constants
 *
 * @package Edgeframe
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'EDGEFRAME_VERSION' ) ) {
	define( 'EDGEFRAME_VERSION', '0.1.0' );
}

if ( ! defined( 'EDGEFRAME_SLUG' ) ) {
	define( 'EDGEFRAME_SLUG', 'edgeframe' );
}

if ( ! defined( 'EDGEFRAME_TEXTDOMAIN' ) ) {
	define( 'EDGEFRAME_TEXTDOMAIN', 'edgeframe' );
}

if ( ! defined( 'EDGEFRAME_PATH' ) ) {
	define( 'EDGEFRAME_PATH', trailingslashit( get_template_directory() ) );
}

if ( ! defined( 'EDGEFRAME_URI' ) ) {
	define( 'EDGEFRAME_URI', trailingslashit( get_template_directory_uri() ) );
}

if ( ! defined( 'EDGEFRAME_BUILD_URI' ) ) {
	define( 'EDGEFRAME_BUILD_URI', EDGEFRAME_URI . 'build/' );
}

if ( ! defined( 'EDGEFRAME_BUILD_PATH' ) ) {
	define( 'EDGEFRAME_BUILD_PATH', EDGEFRAME_PATH . 'build/' );
}
