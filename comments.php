<?php
/**
 * The template for displaying comments
 *
 * @package Edgeframe
 */

if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
			$comments_number = get_comments_number();
			if ( 1 === (int) $comments_number ) {
				printf( esc_html__( 'One thought on “%1$s”', 'edgeframe' ), '<span>' . get_the_title() . '</span>' );
			} else {
				printf( esc_html( _nx( '%1$s thought on “%2$s”', '%1$s thoughts on “%2$s”', $comments_number, 'comments title', 'edgeframe' ) ), number_format_i18n( $comments_number ), '<span>' . get_the_title() . '</span>' );
			}
			?>
		</h2>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'      => 'ol',
					'short_ping' => true,
				)
			);
			?>
		</ol>

		<?php the_comments_navigation(); ?>

		<?php if ( ! comments_open() ) : ?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'edgeframe' ); ?></p>
		<?php endif; ?>

	<?php endif; // have_comments() ?>

	<?php comment_form(); ?>

</div>

