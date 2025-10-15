<?php
get_header(); ?>
<main id="primary" class="site-main">
	<section class="error-404 not-found">
		<header class="page-header">
			<h1 class="page-title"><?php esc_html_e( 'Page not found', 'edgeframe' ); ?></h1>
		</header>
		<div class="page-content">
			<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search or check the links below.', 'edgeframe' ); ?></p>
			<?php get_search_form(); ?>
			<div class="error-404-links">
				<h2><?php esc_html_e( 'Popular links', 'edgeframe' ); ?></h2>
				<ul>
					<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'edgeframe' ); ?></a></li>
					<li><a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>"><?php esc_html_e( 'Blog', 'edgeframe' ); ?></a></li>
					<li><a href="<?php echo esc_url( get_permalink( get_option( 'page_on_front' ) ) ); ?>"><?php esc_html_e( 'Front Page', 'edgeframe' ); ?></a></li>
				</ul>
			</div>
		</div>
	</section>
</main>
<?php get_footer(); ?>
