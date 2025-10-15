<?php get_header(); ?>
<?php $layout = edgeframe_opt( 'layout', 'content-sidebar' ); ?>
<main id="primary" class="site-main layout-<?php echo esc_attr( $layout ); ?>">
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
<?php if ( 'full-width' !== $layout && 'sidebar-content' !== $layout ) { get_sidebar(); } ?>
<?php get_footer(); ?>
