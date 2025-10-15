<?php
/**
 * Header: Split (nav left/right, brand center)
 */
do_action( 'edgeframe_header_before' );
?>
<header class="site-header ef-header ef-header--split" role="banner">
	<?php do_action( 'edgeframe_header_topbar' ); ?>
	<div class="ef-header-inner">
		<nav class="ef-header-nav--left ef-header-nav" aria-label="<?php echo esc_attr__( 'Primary', 'edgeframe' ); ?>">
			<?php do_action( 'edgeframe_header_nav_left' ); ?>
		</nav>
			<div class="ef-header-tools"><?php do_action( 'edgeframe_header_tools' ); ?></div>
		<div class="ef-header-branding">
			<?php do_action( 'edgeframe_header_branding' ); ?>
		</div>
		<nav class="ef-header-nav--right ef-header-nav" aria-label="<?php echo esc_attr__( 'Secondary', 'edgeframe' ); ?>">
			<?php do_action( 'edgeframe_header_nav_right' ); ?>
		</nav>
	</div>
	<div class="ef-header-cta">
		<?php do_action( 'edgeframe_header_cta' ); ?>
	</div>
</header>
<?php do_action( 'edgeframe_header_after' ); ?>
