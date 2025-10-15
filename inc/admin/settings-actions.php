<?php
/**
 * Settings actions: export, import, reset
 *
 * @package Edgeframe
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once EDGEFRAME_PATH . 'inc/admin/settings-register.php';
require_once EDGEFRAME_PATH . 'inc/admin/settings-schema.php';

/**
 * Export settings as JSON
 */
add_action(
	'admin_post_edgeframe_export',
	function () {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Insufficient permissions.', 'edgeframe' ) );
		}
		check_admin_referer( 'edgeframe_export' );

		$opts = get_option( 'edgeframe_settings', array() );

		nocache_headers();
		header( 'Content-Disposition: attachment; filename=edgeframe-settings-' . gmdate( 'Ymd-His' ) . '.json' );
		// Send JSON safely (sets appropriate content-type and exits)
		wp_send_json( $opts );
	}
);

/**
 * Import settings from JSON file
 */
add_action(
	'admin_post_edgeframe_import',
	function () {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Insufficient permissions.', 'edgeframe' ) );
		}
		check_admin_referer( 'edgeframe_import' );

		if ( empty( $_FILES['edgeframe_import_file']['tmp_name'] ) ) {
			wp_safe_redirect( add_query_arg( 'ef_status', 'no_file', wp_get_referer() ?: admin_url( 'themes.php?page=edgeframe-settings' ) ) );
			exit;
		}

		$raw = file_get_contents( sanitize_text_field( wp_unslash( $_FILES['edgeframe_import_file']['tmp_name'] ) ) );
		$arr = json_decode( (string) $raw, true );
		if ( ! is_array( $arr ) ) {
			wp_safe_redirect( add_query_arg( 'ef_status', 'invalid_json', wp_get_referer() ?: admin_url( 'themes.php?page=edgeframe-settings' ) ) );
			exit;
		}

		// Sanitize against schema before saving
		$clean = edgeframe_sanitize_settings_from_schema( $arr );

		/**
		 * Filter imported settings before saving.
		 */
		$clean = apply_filters( 'edgeframe/admin/import_settings', $clean, $arr );

		update_option( 'edgeframe_settings', $clean );
		wp_safe_redirect( add_query_arg( 'ef_status', 'imported', admin_url( 'themes.php?page=edgeframe-settings' ) ) );
		exit;
	}
);

/**
 * Reset settings to defaults from schema
 */
add_action(
	'admin_post_edgeframe_reset',
	function () {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Insufficient permissions.', 'edgeframe' ) );
		}
		check_admin_referer( 'edgeframe_reset' );

		$defaults = edgeframe_defaults_from_schema();
		update_option( 'edgeframe_settings', $defaults );
		do_action( 'edgeframe/admin/reset_settings', $defaults );

		wp_safe_redirect( add_query_arg( 'ef_status', 'reset', admin_url( 'themes.php?page=edgeframe-settings' ) ) );
		exit;
	}
);
