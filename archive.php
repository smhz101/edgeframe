<?php get_header(); ?>
<?php $layout = edgeframe_opt( 'layout', 'content-sidebar' ); ?>
<main id="primary" class="site-main layout-<?php echo esc_attr( $layout ); ?>">
	<header class="page-header">
		<?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
		<?php the_archive_description( '<div class="archive-description">', '</div>' ); ?>
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
<?php
if ( 'full-width' !== $layout && 'sidebar-content' !== $layout ) {
	get_sidebar(); }
?>
<?php get_footer(); ?>
