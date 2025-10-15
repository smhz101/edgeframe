<?php
/**
 * Enqueue scripts and styles.
 *
 * @package Edgeframe
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_enqueue_scripts', 'edgeframe_enqueue_front' );
/**
 * Enqueue front-end scripts and styles.
 */
function edgeframe_enqueue_front() {
	wp_enqueue_style( 'edgeframe-main', EDGEFRAME_URI . 'assets/css/main.css', array(), EDGEFRAME_VERSION );

	// Prefer Customizer theme mod for WP.org compliance; fallback to settings option.
	$accent = edgeframe_get_option( 'edgeframe_accent', edgeframe_opt( 'accent', '#4f46e5' ) );
	wp_add_inline_style( 'edgeframe-main', ':root{--ef-accent:' . esc_attr( $accent ) . ';}' );

	wp_enqueue_script( 'edgeframe-main', EDGEFRAME_URI . 'assets/js/main.js', array(), EDGEFRAME_VERSION, true );

	// Threaded comments support
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'enqueue_block_editor_assets', 'edgeframe_enqueue_editor' );
/**
 * Enqueue editor styles.
 */
function edgeframe_enqueue_editor() {
	wp_enqueue_style( 'edgeframe-editor', EDGEFRAME_URI . 'assets/css/main.css', array(), EDGEFRAME_VERSION );
}

add_action( 'admin_enqueue_scripts', 'edgeframe_enqueue_admin' );
/**
 * Enqueue admin scripts and styles.
 *
 * @param string $hook The current admin page.
 */
function edgeframe_enqueue_admin( $hook ) {
	// Only load on our settings page.
	if ( 'appearance_page_edgeframe-settings' !== $hook ) {
		return;
	}

	// Inline admin variables so child themes can also override via filters later if they want
	$accent = edgeframe_get_option( 'edgeframe_accent', edgeframe_opt( 'accent', '#4f46e5' ) );
	$vars   = ':root{--ef-accent:' . esc_attr( $accent ) . ';--ef-radius:10px;--ef-gap:16px;--ef-card-bg:#fff;--ef-card-bd:#e5e7eb;}';
	wp_add_inline_style( 'edgeframe-admin', $vars );

	// Enqueue admin styles and scripts.
	wp_enqueue_style( 'edgeframe-admin', EDGEFRAME_URI . 'assets/css/admin.css', array(), EDGEFRAME_VERSION );

	// Optional: Select2 (theme-bundled or CDN fallback)
	// WordPress core does not include Select2 by default. If the theme ships it locally, enqueue it;
	// otherwise register from a reliable CDN as a fallback so enhanced selects work out of the box.
	$has_local_select2 = file_exists( EDGEFRAME_PATH . 'assets/vendor/select2/select2.min.js' );
	if ( $has_local_select2 ) {
		wp_enqueue_style( 'select2', EDGEFRAME_URI . 'assets/vendor/select2/select2.min.css', array(), EDGEFRAME_VERSION );
		wp_enqueue_script( 'select2', EDGEFRAME_URI . 'assets/vendor/select2/select2.min.js', array( 'jquery' ), EDGEFRAME_VERSION, true );
	} else {
		// Register CDN versions to avoid breaking if vendor files are missing.
		wp_register_style( 'select2', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css', array(), '4.1.0-rc.0' );
		wp_register_script( 'select2', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js', array( 'jquery' ), '4.1.0-rc.0', true );
		wp_enqueue_style( 'select2' );
		wp_enqueue_script( 'select2' );
	}

	$deps = array( 'jquery' );
	if ( wp_script_is( 'select2', 'registered' ) || wp_script_is( 'select2', 'enqueued' ) ) {
		$deps[] = 'select2';
	}
	wp_enqueue_script( 'edgeframe-admin', EDGEFRAME_URI . 'assets/js/admin.js', $deps, EDGEFRAME_VERSION, true );
}
