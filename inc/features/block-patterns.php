<?php
/**
 * Block pattern categories and patterns for EdgeFrame.
 *
 * @package EdgeFrame
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', 'edgeframe_register_block_pattern_categories' );
function edgeframe_register_block_pattern_categories() {
	if ( ! function_exists( 'register_block_pattern_category' ) ) {
		return;
	}

	register_block_pattern_category( 'edgeframe-hero', array( 'label' => __( 'EdgeFrame Hero', 'edgeframe' ) ) );
	register_block_pattern_category( 'edgeframe-sections', array( 'label' => __( 'EdgeFrame Sections', 'edgeframe' ) ) );
	register_block_pattern_category( 'edgeframe-cta', array( 'label' => __( 'EdgeFrame CTAs', 'edgeframe' ) ) );
}

add_action( 'init', 'edgeframe_register_block_patterns' );
function edgeframe_register_block_patterns() {
	if ( ! function_exists( 'register_block_pattern' ) ) {
		return;
	}

	// Hero pattern
	register_block_pattern(
		'edgeframe/hero-simple',
		array(
			'title'       => __( 'Hero with heading and button', 'edgeframe' ),
			'description' => __( 'A simple hero section with large heading, paragraph and primary button.', 'edgeframe' ),
			'categories'  => array( 'edgeframe-hero' ),
			'content'     => '<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"80px","bottom":"80px"}}},"backgroundColor":"muted"} -->
<div class="wp-block-group alignfull has-muted-background-color has-background" style="padding-top:80px;padding-bottom:80px"><!-- wp:group {"layout":{"type":"constrained","contentSize":"800px"}} -->
<div class="wp-block-group"><!-- wp:heading {"textAlign":"center","level":1} -->
<h1 class="wp-block-heading has-text-align-center">' . esc_html__( 'Build faster with EdgeFrame', 'edgeframe' ) . '</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">' . esc_html__( 'A clean starting point with thoughtful defaults. Customize easily with global styles.', 'edgeframe' ) . '</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"accent"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-accent-background-color has-background">' . esc_html__( 'Get Started', 'edgeframe' ) . '</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->',
		)
	);

	// Features grid pattern
	register_block_pattern(
		'edgeframe/features-grid-3',
		array(
			'title'       => __( 'Features grid (3 columns)', 'edgeframe' ),
			'description' => __( 'Three-column features grid with icons and descriptions.', 'edgeframe' ),
			'categories'  => array( 'edgeframe-sections' ),
			'content'     => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"60px","bottom":"60px"}}}} -->
<div class="wp-block-group" style="padding-top:60px;padding-bottom:60px"><!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">' . esc_html__( 'Fast setup', 'edgeframe' ) . '</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>' . esc_html__( 'Opinionated defaults to get you going quickly.', 'edgeframe' ) . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">' . esc_html__( 'Flexible', 'edgeframe' ) . '</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>' . esc_html__( 'Customize easily via Global Styles and theme settings.', 'edgeframe' ) . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">' . esc_html__( 'Accessible', 'edgeframe' ) . '</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>' . esc_html__( 'Built with accessibility and best practices in mind.', 'edgeframe' ) . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->',
		)
	);

	// CTA pattern
	register_block_pattern(
		'edgeframe/cta-centered',
		array(
			'title'       => __( 'Centered call to action', 'edgeframe' ),
			'description' => __( 'Centered paragraph and button for a simple call to action.', 'edgeframe' ),
			'categories'  => array( 'edgeframe-cta' ),
			'content'     => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"60px","bottom":"60px"}}},"backgroundColor":"muted"} -->
<div class="wp-block-group has-muted-background-color has-background" style="padding-top:60px;padding-bottom:60px"><!-- wp:paragraph {"align":"center","fontSize":"large"} -->
<p class="has-large-font-size has-text-align-center">' . esc_html__( 'Ready to ship faster?', 'edgeframe' ) . '</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-edgeframe-outline"} -->
<div class="wp-block-button is-style-edgeframe-outline"><a class="wp-block-button__link">' . esc_html__( 'Contact Us', 'edgeframe' ) . '</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->',
		)
	);
}
