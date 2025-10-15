<?php
/**
 * Menus and Sidebars setup
 *
 * @package Edgeframe
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'after_setup_theme', 'edgeframe_register_menus' );
/**
 * Register navigation menus.
 */
function edgeframe_register_menus() {
	register_nav_menus(
		array(
			'primary'   => __( 'Primary Menu', 'edgeframe' ),
			'secondary' => __( 'Secondary Menu', 'edgeframe' ),
		)
	);
}

add_action( 'widgets_init', 'edgeframe_register_sidebars' );
/**
 * Register sidebars and widget areas.
 */
function edgeframe_register_sidebars() {
	register_sidebar(
		array(
			'name'          => __( 'Sidebar', 'edgeframe' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Main sidebar.', 'edgeframe' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}

// Note: Custom widgets are considered plugin territory by Theme Review guidelines.
// If needed, register them via a separate plugin.
