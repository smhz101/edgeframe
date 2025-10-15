<?php
/**
 * Default content template
 *
 * @package Edgeframe
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php if ( is_singular() ) : ?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php else : ?>
			<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		<?php endif; ?>
		<div class="entry-meta">
			<?php edgeframe_posted_on(); ?> <?php edgeframe_posted_by(); ?>
		</div>
	</header>

	<div class="entry-content">
		<?php
		if ( is_singular() ) {
			the_content();
			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'edgeframe' ),
					'after'  => '</div>',
				)
			);
		} else {
			the_excerpt();
		}
		?>
	</div>

	<footer class="entry-footer">
		<?php edgeframe_entry_meta(); ?>
	</footer>
</article>

