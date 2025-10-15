<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'edgeframe' ); ?></a>
<?php
// Resolve header layout and flags from settings.
$layout        = edgeframe_opt( 'header_layout', 'simple' );
$sticky        = edgeframe_bool( edgeframe_opt( 'header_sticky', 0 ) );
$transparent   = edgeframe_bool( edgeframe_opt( 'header_transparent', 0 ) );
$menu_align    = edgeframe_opt( 'header_menu_alignment', 'right' );
$show_search   = edgeframe_bool( edgeframe_opt( 'header_show_search', 1 ) );
$show_cta      = edgeframe_bool( edgeframe_opt( 'header_show_cta', 0 ) );
$cta           = (array) edgeframe_opt( 'header_cta', array() );

// Allow child themes to override layout programmatically.
$layout = apply_filters( 'edgeframe_header_layout', $layout );

// Hook default behaviors to header action slots if not provided by child themes.
add_action( 'edgeframe_header_branding', function() {
	get_template_part( 'template-parts/header/site', 'branding' );
} );

add_action( 'edgeframe_header_nav', function() use ( $menu_align ) {
	wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_class' => 'menu align-' . esc_attr( $menu_align ) ) );
} );

add_action( 'edgeframe_header_nav_left', function() {
	wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_class' => 'menu align-left' ) );
} );

add_action( 'edgeframe_header_nav_right', function() {
	wp_nav_menu( array( 'theme_location' => 'secondary', 'container' => false, 'menu_class' => 'menu align-right' ) );
} );

add_action( 'edgeframe_header_cta', function() use ( $show_cta, $cta ) {
	if ( ! $show_cta ) { return; }
	$text = isset( $cta['text'] ) ? $cta['text'] : __( 'Contact Us', 'edgeframe' );
	$url  = isset( $cta['url'] ) ? esc_url( $cta['url'] ) : '';
	$nt   = ! empty( $cta['new_tab'] );
	if ( $url ) {
		echo '<a class="ef-button ef-button--primary" href="' . esc_url( $url ) . '"' . ( $nt ? ' target="_blank" rel="noopener noreferrer"' : '' ) . '>' . esc_html( $text ) . '</a>';
	}
} );

// Tools area (e.g., mobile menu toggle). Child themes can override.
add_action( 'edgeframe_header_tools', function() {
	echo '<button class="ef-menu-toggle" aria-expanded="false" aria-controls="primary-menu">' . esc_html__( 'Menu', 'edgeframe' ) . '</button>';
} );

add_action( 'edgeframe_header_topbar', function() {
	if ( edgeframe_bool( edgeframe_opt( 'header_topbar_enable', 0 ) ) ) {
		$text = (string) edgeframe_opt( 'header_topbar_text', '' );
		if ( $text ) {
			echo '<div class="ef-topbar">' . wp_kses_post( wpautop( $text ) ) . '</div>';
		}
	}
} );

// Add computed header classes to body.
add_filter( 'body_class', function( $classes ) use ( $layout, $sticky, $transparent ) {
	$classes[] = 'ef-header-layout-' . sanitize_html_class( $layout );
	if ( $sticky ) { $classes[] = 'ef-header-sticky'; }
	if ( $transparent ) { $classes[] = 'ef-header-transparent'; }
	return $classes;
} );

get_template_part( 'template-parts/header/header', $layout );
?>
