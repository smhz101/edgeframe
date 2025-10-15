<?php get_header(); ?>
<main id="primary" class="site-main">
	<?php
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			?>
			<?php get_template_part( 'template-parts/content/content', get_post_type() ); ?>
			<?php
	endwhile;
		edgeframe_the_posts_pagination(); else :
			?>
				<?php get_template_part( 'template-parts/content/content', 'none' ); ?>
			<?php endif; ?>
</main>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
