<?php
/**
 * Register EdgeFrame blocks.
 *
 * @package EdgeFrame
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

add_filter( 'block_categories_all', function( $categories ) {
    $slug = 'edgeframe';
    foreach ( $categories as $cat ) {
        if ( isset( $cat['slug'] ) && $cat['slug'] === $slug ) {
            return $categories;
        }
    }
    $categories[] = array(
        'slug'  => $slug,
        'title' => __( 'EdgeFrame', 'edgeframe' ),
        'icon'  => null,
    );
    return $categories;
} );

add_action( 'init', function() {
    if ( ! function_exists( 'register_block_type' ) ) { return; }
    register_block_type( __DIR__ . '/breadcrumbs' );
    register_block_type( __DIR__ . '/recent-posts' );
} );
