<?php
/**
 * Custom block styles for EdgeFrame theme.
 *
 * @package EdgeFrame
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'init', 'edgeframe_register_block_styles' );
/**
 * Register custom block styles.
 */
function edgeframe_register_block_styles() {
    // Ensure function exists (WP 5.3+)
    if ( ! function_exists( 'register_block_style' ) ) {
        return;
    }

    // Button: Outline
    register_block_style( 'core/button', array(
        'name'         => 'edgeframe-outline',
        'label'        => __( 'Outline', 'edgeframe' ),
        // Use theme main stylesheet for both editor and front
        'style_handle' => 'edgeframe-main',
    ) );

    // Quote: Bordered
    register_block_style( 'core/quote', array(
        'name'         => 'edgeframe-bordered',
        'label'        => __( 'Bordered', 'edgeframe' ),
        'style_handle' => 'edgeframe-main',
    ) );

    // Image: Shadow
    register_block_style( 'core/image', array(
        'name'         => 'edgeframe-shadow',
        'label'        => __( 'Shadow', 'edgeframe' ),
        'style_handle' => 'edgeframe-main',
    ) );
}
