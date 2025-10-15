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

add_action( 'after_setup_theme', 'edgeframe_wc_setup' );
/**
 * WooCommerce setup function.
 *
 * @return void
 */
function edgeframe_wc_setup() {
	// Declare WooCommerce support and product gallery features.
	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 400,
			'single_image_width'    => 800,
			'product_grid'          => array(
				'default_rows'    => 4,
				'default_columns' => 3,
				'min_columns'     => 2,
				'max_columns'     => 4,
			),
		)
	);

	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}

/**
 * Replace WooCommerce content wrappers with theme wrappers.
 */
add_action(
	'init',
	function () {
		// Remove default Woo wrappers.
		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
		remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

		// Add theme wrappers.
		add_action( 'woocommerce_before_main_content', 'edgeframe_wc_wrapper_start', 10 );
		add_action( 'woocommerce_after_main_content', 'edgeframe_wc_wrapper_end', 10 );
	}
);

function edgeframe_wc_wrapper_start() {
	echo '<main id="primary" class="site-main">';
}

function edgeframe_wc_wrapper_end() {
	echo '</main>';
}
