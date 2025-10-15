<?php
/**
 * Enqueue parent and child styles.
 */
add_action(
	'wp_enqueue_scripts',
	function () {
		$parent = 'edgeframe-main';
		wp_enqueue_style( $parent, get_template_directory_uri() . '/assets/css/main.css', array(), wp_get_theme( get_template() )->get( 'Version' ) );
		wp_enqueue_style( 'edgeframe-child', get_stylesheet_uri(), array( $parent ), wp_get_theme()->get( 'Version' ) );
	}
);
