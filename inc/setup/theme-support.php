<?php
/**
 * Theme support setup.
 *
 * @package Edgeframe
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'after_setup_theme', 'edgeframe_setup_theme_support' );
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * @return void
 */
function edgeframe_setup_theme_support() {
	// Make theme available for translation.
	load_theme_textdomain( 'edgeframe', EDGEFRAME_PATH . 'languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );

	// Switch default core markup for search form, comment form, and comments to output valid HTML5.
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 64,
			'width'       => 180,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	// Add support for core custom logo.
	add_theme_support( 'editor-styles' );

	// Enqueue editor styles.
	add_editor_style( 'assets/css/main.css' );

	// Set the content width in pixels, based on the theme's design and stylesheet.
	if ( ! isset( $GLOBALS['content_width'] ) ) {
		$GLOBALS['content_width'] = 800;
	}

	// Add support for selective refresh for widgets in customizer.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Add support for full and wide align images.
	add_theme_support( 'align-wide' );

	// Add support for editor font sizes.
	add_theme_support(
		'editor-font-sizes',
		array(
			array(
				'name' => __( 'Small', 'edgeframe' ),
				'size' => 12,
				'slug' => 'small',
			),
			array(
				'name' => __( 'Regular', 'edgeframe' ),
				'size' => 16,
				'slug' => 'regular',
			),
			array(
				'name' => __( 'Large', 'edgeframe' ),
				'size' => 36,
				'slug' => 'large',
			),
			array(
				'name' => __( 'Larger', 'edgeframe' ),
				'size' => 48,
				'slug' => 'larger',
			),
		)
	);

	// Custom Header (recommended when using header images)
	add_theme_support(
		'custom-header',
		array(
			'width'       => 1920,
			'height'      => 480,
			'flex-width'  => true,
			'flex-height' => true,
			'header-text' => false,
			'video'       => false,
		)
	);

	// Custom Background (recommended when using background images/colors)
	add_theme_support(
		'custom-background',
		array(
			'default-color' => 'ffffff',
		)
	);
}
