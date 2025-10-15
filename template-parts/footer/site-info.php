<?php
$show_credits = function_exists( 'edgeframe_opt' ) ? edgeframe_opt( 'footer_show_credits', 1 ) : 1;
$custom_c     = function_exists( 'edgeframe_opt' ) ? edgeframe_opt( 'footer_copyright', '' ) : '';

if ( $show_credits ) {
	if ( $custom_c ) {
		echo wp_kses_post( $custom_c );
	} else {
		printf(
			'&copy; %s %s',
			esc_html( gmdate( 'Y' ) ),
			esc_html( get_bloginfo( 'name' ) )
		);
	}
}
