<?php
/**
 * Page content template
 *
 * @package Edgeframe
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php if ( has_post_thumbnail() ) : ?>
			<figure class="post-thumbnail">
				<?php the_post_thumbnail( 'edgeframe-card', array( 'alt' => the_title_attribute( array( 'echo' => false ) ) ) ); ?>
			</figure>
		<?php endif; ?>
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header>
	<div class="entry-content">
		<?php
		the_content();
		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'edgeframe' ),
				'after'  => '</div>',
			)
		);
		?>
	</div>
</article>

