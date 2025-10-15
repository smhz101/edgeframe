<?php
/**
 * Edgeframe functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Edgeframe
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Load constants first */
require get_template_directory() . '/inc/core/constants.php';

/** Core helpers */
require EDGEFRAME_PATH . 'inc/core/helpers.php';

/** Setup */
require EDGEFRAME_PATH . 'inc/setup/theme-support.php';
require EDGEFRAME_PATH . 'inc/setup/enqueue.php';
require EDGEFRAME_PATH . 'inc/setup/menus-sidebars.php';

/** Features */
require EDGEFRAME_PATH . 'inc/features/image-sizes.php';
require EDGEFRAME_PATH . 'inc/features/template-tags.php';
require EDGEFRAME_PATH . 'inc/features/pagination.php';
require EDGEFRAME_PATH . 'inc/features/breadcrumbs.php';
// Shortcodes are plugin territory; ship behind a filter for non-directory builds.
require EDGEFRAME_PATH . 'inc/features/security.php';
require EDGEFRAME_PATH . 'inc/features/performance.php';
require EDGEFRAME_PATH . 'inc/features/block-styles.php';
require EDGEFRAME_PATH . 'inc/features/block-patterns.php';
// Server-rendered blocks can be moved to a plugin; allow disabling via filter.
// Note: Shortcodes and block registration belong in a plugin per Theme Directory guidelines.
// require EDGEFRAME_PATH . 'inc/features/shortcodes.php';
// add_filter( 'edgeframe_enable_theme_shortcodes', '__return_false' );
// require EDGEFRAME_PATH . 'inc/blocks/index.php';
// add_filter( 'edgeframe_enable_theme_blocks', '__return_true' );

/** Widgets */
require EDGEFRAME_PATH . 'inc/widgets/class-edgeframe-widget-about.php';
require EDGEFRAME_PATH . 'inc/widgets/class-edgeframe-widget-recent-posts.php';

/** Compatibility */
require EDGEFRAME_PATH . 'inc/compatibility/block-editor.php';
if ( class_exists( 'WooCommerce' ) ) {
	require EDGEFRAME_PATH . 'inc/compatibility/woocommerce.php';
}

/** Customizer + Admin (minimal classes) */
require EDGEFRAME_PATH . 'inc/customizer/class-edgeframe-customizer.php';
require EDGEFRAME_PATH . 'inc/customizer/customizer-options.php';
require EDGEFRAME_PATH . 'inc/admin/class-edgeframe-admin.php';
require EDGEFRAME_PATH . 'inc/admin/settings-register.php';
require EDGEFRAME_PATH . 'inc/admin/settings-page.php';

/** Finally, wire actions and filters */
require EDGEFRAME_PATH . 'inc/hooks/actions.php';
require EDGEFRAME_PATH . 'inc/hooks/filters.php';
