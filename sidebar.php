<?php
/**
 * The sidebar containing the main widget area
 *
 * @package EdgeFrame
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}

$layout  = function_exists( 'edgeframe_opt' ) ? edgeframe_opt( 'layout', 'content-sidebar' ) : 'content-sidebar';
$classes = 'widget-area';
if ( 'sidebar-content' === $layout ) {
	$classes .= ' sidebar-left';
}
?>
<aside id="secondary" class="<?php echo esc_attr( $classes ); ?>">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>

