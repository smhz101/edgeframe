<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Edgeframe
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Prints HTML with meta information for the current post-date/time.
 */
function edgeframe_posted_on() {
	echo '<span class="posted-on">' . esc_html( get_the_date() ) . '</span>';
}

/**
 * Prints HTML with meta information for the current author.
 */
function edgeframe_posted_by() {
	echo '<span class="byline">' . esc_html( get_the_author() ) . '</span>';
}

/**
 * Prints HTML with meta information for the categories.
 */
function edgeframe_entry_meta() {
	$cats = get_the_category_list( ', ' );
	if ( $cats ) {
		echo '<span class="cat-links">' . wp_kses_post( $cats ) . '</span>';
	}
}
