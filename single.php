<?php get_header(); ?>
<main id="primary" class="site-main">
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
<?php get_sidebar(); ?>
<?php get_footer(); ?>
