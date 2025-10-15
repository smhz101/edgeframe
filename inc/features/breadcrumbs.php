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

	$items = array();
	$items[] = array( 'url' => home_url( '/' ), 'name' => __( 'Home', 'edgeframe' ), 'current' => false );

	echo '<nav class="breadcrumbs" aria-label="' . esc_attr__( 'Breadcrumbs', 'edgeframe' ) . '">';
	echo '<ol class="breadcrumb-list">';
	echo '<li class="breadcrumb-item"><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'edgeframe' ) . '</a></li>';

	if ( is_home() && ! is_front_page() ) {
		$blog = get_option( 'page_for_posts' );
		if ( $blog ) {
			$title = get_the_title( (int) $blog );
			echo '<li class="breadcrumb-item" aria-current="page">' . esc_html( $title ) . '</li>';
			$items[] = array( 'url' => get_permalink( (int) $blog ), 'name' => $title, 'current' => true );
		}
	} elseif ( is_category() || is_tag() || is_tax() ) {
		$title = single_term_title( '', false );
		echo '<li class="breadcrumb-item" aria-current="page">' . esc_html( $title ) . '</li>';
		$items[] = array( 'url' => get_term_link( get_queried_object() ), 'name' => $title, 'current' => true );
	} elseif ( is_singular() ) {
		$post_type = get_post_type_object( get_post_type() );
		if ( $post_type && $post_type->has_archive ) {
			$archive_url = get_post_type_archive_link( $post_type->name );
			echo '<li class="breadcrumb-item"><a href="' . esc_url( $archive_url ) . '">' . esc_html( $post_type->labels->name ) . '</a></li>';
			$items[] = array( 'url' => $archive_url, 'name' => $post_type->labels->name, 'current' => false );
		}
		$title = get_the_title();
		echo '<li class="breadcrumb-item" aria-current="page">' . esc_html( $title ) . '</li>';
		$items[] = array( 'url' => get_permalink(), 'name' => $title, 'current' => true );
	} elseif ( is_search() ) {
		$title = sprintf( __( 'Search: %s', 'edgeframe' ), get_search_query() );
		echo '<li class="breadcrumb-item" aria-current="page">' . esc_html( $title ) . '</li>';
		$items[] = array( 'url' => '', 'name' => $title, 'current' => true );
	} elseif ( is_404() ) {
		$title = __( '404 Not Found', 'edgeframe' );
		echo '<li class="breadcrumb-item" aria-current="page">' . esc_html( $title ) . '</li>';
		$items[] = array( 'url' => '', 'name' => $title, 'current' => true );
	} elseif ( is_author() ) {
		$title = get_the_author();
		echo '<li class="breadcrumb-item" aria-current="page">' . esc_html( $title ) . '</li>';
		$items[] = array( 'url' => get_author_posts_url( get_the_author_meta( 'ID' ) ), 'name' => $title, 'current' => true );
	} elseif ( is_date() ) {
		$title = get_the_date();
		echo '<li class="breadcrumb-item" aria-current="page">' . esc_html( $title ) . '</li>';
		$items[] = array( 'url' => '', 'name' => $title, 'current' => true );
	}

	echo '</ol>';
	echo '</nav>';

	// Output JSON-LD structured data for BreadcrumbList
	$position = 1;
	$list     = array();
	foreach ( $items as $it ) {
		$list[] = array(
			'@type'    => 'ListItem',
			'position' => $position++,
			'name'     => wp_strip_all_tags( $it['name'] ),
			'item'     => ! empty( $it['url'] ) ? esc_url_raw( $it['url'] ) : get_permalink(),
		);
	}
	$data = array(
		'@context'        => 'https://schema.org',
		'@type'           => 'BreadcrumbList',
		'itemListElement' => $list,
	);
	echo '<script type="application/ld+json">' . wp_json_encode( $data ) . '</script>';
}
