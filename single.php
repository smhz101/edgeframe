<?php get_header(); ?>
<?php $layout = edgeframe_opt( 'layout', 'content-sidebar' ); ?>
<main id="primary" class="site-main layout-<?php echo esc_attr( $layout ); ?>">
	<?php
	while ( have_posts() ) :
		the_post();
		get_template_part( 'template-parts/content/content', get_post_type() );
		edgeframe_the_post_navigation();

		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
	endwhile; // End of the loop.
	?>
</main>
<?php if ( 'full-width' !== $layout && 'sidebar-content' !== $layout ) { get_sidebar(); } ?>
<?php get_footer(); ?>
