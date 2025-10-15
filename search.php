<?php get_header(); ?>
<main id="primary" class="site-main">
	<header class="page-header">
		<h1 class="page-title">
			<?php printf( esc_html__( 'Search results for: %s', 'edgeframe' ), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?>
		</h1>
	</header>

	<?php if ( have_posts() ) : ?>
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<?php get_template_part( 'template-parts/content/content', get_post_type() ); ?>
		<?php endwhile; ?>
		<?php edgeframe_the_posts_pagination(); ?>
	<?php else : ?>
		<?php get_template_part( 'template-parts/content/content', 'none' ); ?>
	<?php endif; ?>
</main>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
