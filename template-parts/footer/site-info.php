<?php
printf(
	'&copy; %s %s',
	esc_html( do_shortcode( '[year]' ) ),
	esc_html( get_bloginfo( 'name' ) )
);
