<?php
/**
 * Render callback for EdgeFrame Recent Posts block.
 *
 * @package EdgeFrame
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; }

$count = isset( $attributes['count'] ) ? (int) $attributes['count'] : 5;
$count = $count > 0 && $count <= 10 ? $count : 5;

$q = new WP_Query(
	array(
		'posts_per_page'      => $count,
		'no_found_rows'       => true,
		'post_status'         => 'publish',
		'ignore_sticky_posts' => true,
	)
);

ob_start();
if ( $q->have_posts() ) {
	echo '<ul class="ef-recent-posts">';
	while ( $q->have_posts() ) {
		$q->the_post();
		echo '<li class="ef-recent-item">';
		if ( has_post_thumbnail() ) {
			echo '<a class="ef-thumb" href="' . esc_url( get_permalink() ) . '" aria-hidden="true" tabindex="-1">';
			the_post_thumbnail( 'edgeframe-thumb', array( 'alt' => the_title_attribute( array( 'echo' => false ) ) ) );
			echo '</a>';
		}
		echo '<div class="ef-meta">';
		echo '<a class="ef-title" href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a>';
		echo '<time class="ef-date" datetime="' . esc_attr( get_the_date( DATE_W3C ) ) . '">' . esc_html( get_the_date() ) . '</time>';
		echo '</div>';
		echo '</li>';
	}
	echo '</ul>';
	wp_reset_postdata();
}
return (string) ob_get_clean();
