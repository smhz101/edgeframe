<?php
/**
 * Header: Centered (brand above nav)
 */
do_action( 'edgeframe_header_before' );
?>
<header class="site-header ef-header ef-header--centered" role="banner">
	<?php do_action( 'edgeframe_header_topbar' ); ?>
	<div class="ef-header-inner">
		<div class="ef-header-tools"><?php do_action( 'edgeframe_header_tools' ); ?></div>
		<div class="ef-header-branding">
			<?php do_action( 'edgeframe_header_branding' ); ?>
		</div>
		<nav class="ef-header-nav" aria-label="<?php echo esc_attr__( 'Primary', 'edgeframe' ); ?>">
			<?php do_action( 'edgeframe_header_nav' ); ?>
		</nav>
		<div class="ef-header-cta">
			<?php do_action( 'edgeframe_header_cta' ); ?>
		</div>
	</div>
</header>
<?php do_action( 'edgeframe_header_after' ); ?>
