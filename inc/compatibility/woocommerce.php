<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package Edgeframe
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', 'edgeframe_wc_setup' );
/**
 * WooCommerce setup function.
 *
 * @return void
 */
function edgeframe_wc_setup() {
	// Keep minimal, add wrappers if needed later
}
