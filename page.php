<?php get_header(); ?>
<main id="primary" class="site-main">
	<?php
	while ( have_posts() ) :
		the_post();
		get_template_part( 'template-parts/content/content', 'page' );
		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
	endwhile; // End of the loop.
	?>
</main>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
