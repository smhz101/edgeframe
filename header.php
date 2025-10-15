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
<header class="site-header">
	<div class="site-branding">
		<?php get_template_part( 'template-parts/header/site', 'branding' ); ?>
	</div>
	<nav class="primary-nav" aria-label="<?php esc_attr_e( 'Primary', 'edgeframe' ); ?>">
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'container'      => false,
			)
		);
		?>
	</nav>
</header>
