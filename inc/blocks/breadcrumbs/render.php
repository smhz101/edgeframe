<?php
/**
 * Render callback for EdgeFrame Breadcrumbs block.
 *
 * @package EdgeFrame
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

ob_start();
if ( function_exists( 'edgeframe_breadcrumbs' ) ) {
    edgeframe_breadcrumbs();
}
return (string) ob_get_clean();
