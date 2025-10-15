<footer class="site-footer">
	<div class="ef-footer-inner">
		<?php get_template_part( 'template-parts/footer/site', 'info' ); ?>
	</div>
</footer>
<?php
// Close site wrapper for boxed-site mode.
if ( function_exists( 'edgeframe_opt' ) && 'boxed-site' === edgeframe_opt( 'container_mode', 'full' ) ) {
	echo '</div>';
}
?>
<?php wp_footer(); ?>
</body></html>
