<?php
/**
 * Breadcrumbs feature for EdgeFrame theme.
 *
 * @package EdgeFrame
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Display breadcrumbs navigation.
 */
function edgeframe_breadcrumbs() {
	if ( is_front_page() ) {
		return;
	}

	echo '<nav class="breadcrumbs" aria-label="' . esc_attr__( 'Breadcrumbs', 'edgeframe' ) . '">';
	echo '<ol class="breadcrumb-list">';
	echo '<li class="breadcrumb-item"><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'edgeframe' ) . '</a></li>';

	if ( is_home() && ! is_front_page() ) {
		$blog = get_option( 'page_for_posts' );
		if ( $blog ) {
			echo '<li class="breadcrumb-item" aria-current="page">' . esc_html( get_the_title( (int) $blog ) ) . '</li>';
		}
	} elseif ( is_category() || is_tag() || is_tax() ) {
		echo '<li class="breadcrumb-item" aria-current="page">' . esc_html( single_term_title( '', false ) ) . '</li>';
	} elseif ( is_singular() ) {
		$post_type = get_post_type_object( get_post_type() );
		if ( $post_type && $post_type->has_archive ) {
			echo '<li class="breadcrumb-item"><a href="' . esc_url( get_post_type_archive_link( $post_type->name ) ) . '">' . esc_html( $post_type->labels->name ) . '</a></li>';
		}
		echo '<li class="breadcrumb-item" aria-current="page">' . esc_html( get_the_title() ) . '</li>';
	} elseif ( is_search() ) {
		echo '<li class="breadcrumb-item" aria-current="page">' . sprintf( esc_html__( 'Search: %s', 'edgeframe' ), esc_html( get_search_query() ) ) . '</li>';
	} elseif ( is_404() ) {
		echo '<li class="breadcrumb-item" aria-current="page">' . esc_html__( '404 Not Found', 'edgeframe' ) . '</li>';
	} elseif ( is_author() ) {
		echo '<li class="breadcrumb-item" aria-current="page">' . esc_html( get_the_author() ) . '</li>';
	} elseif ( is_date() ) {
		echo '<li class="breadcrumb-item" aria-current="page">' . esc_html( get_the_date() ) . '</li>';
	}

	echo '</ol>';
	echo '</nav>';
}
