<?php
/**
 * Pagination feature.
 *
 * @package Edgeframe
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Display pagination to next/previous pages when applicable.
 */
function edgeframe_the_posts_pagination() {
	the_posts_pagination(
		array(
			'mid_size'  => 2,
			'prev_text' => __( 'Prev', 'edgeframe' ),
			'next_text' => __( 'Next', 'edgeframe' ),
		)
	);
}

/**
 * Display pagination to next/previous pages when applicable.
 */
function edgeframe_the_post_navigation() {
	the_post_navigation(
		array(
			'prev_text' => '<span class="nav-subtitle">' . __( 'Previous:', 'edgeframe' ) . '</span> <span class="nav-title">%title</span>',
			'next_text' => '<span class="nav-subtitle">' . __( 'Next:', 'edgeframe' ) . '</span> <span class="nav-title">%title</span>',
		)
	);
}
