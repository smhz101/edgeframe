<?php
/**
 * Customizer Options
 *
 * @package Edgeframe
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get theme option value from options table.
 *
 * @param string $key     Option key.
 * @param mixed  $default Default value.
 * @return mixed
 */
function edgeframe_opt( string $key, $default = '' ) {
	$opts = get_option( 'edgeframe_settings', array() );
	return $opts[ $key ] ?? $default;
}

/**
 * Get theme option value.
 *
 * @param string $key     Option key.
 * @param mixed  $default Default value.
 * @return mixed
 */
function edgeframe_get_option( string $key, $default = '' ) {
	$map = array(
		'edgeframe_accent' => '#4f46e5',
	);
	$val = get_theme_mod( $key, $map[ $key ] ?? $default );
	return $val;
}

/**
 * Sanitize color.
 *
 * @param string $color Color.
 * @return string
 */
function edgeframe_sanitize_color( $color ) {
	if ( preg_match( '/^#[a-f0-9]{6}$/i', $color ) ) {
		return $color;
	}
	return '#4f46e5';
}

/**
 * Sanitize checkbox.
 *
 * @param bool $checked Checked.
 * @return bool
 */
function edgeframe_sanitize_checkbox( $checked ) {
	return ( ( isset( $checked ) && true === $checked ) ? true : false );
}

/**
 * Sanitize select.
 *
 * @param string $input   Input.
 * @param array  $setting Setting.
 * @return string
 */
function edgeframe_sanitize_select( $input, $setting ) {
	$input = sanitize_text_field( $input );

	if ( is_object( $setting ) ) {
		$choices = $setting->manager->get_control( $setting->id )->choices;
	} elseif ( is_array( $setting ) && isset( $setting['manager'], $setting['id'] ) ) {
		$choices = $setting['manager']->get_control( $setting['id'] )->choices;
	} else {
		$choices = array();
	}

	if ( array_key_exists( $input, $choices ) ) {
		return $input;
	} elseif ( is_object( $setting ) ) {
		return $setting->default;
	} elseif ( is_array( $setting ) && isset( $setting['default'] ) ) {
		return $setting['default'];
	} else {
		return '';
	}
}

/**
 * Sanitize radio.
 *
 * @param string $input   Input.
 * @param array  $setting Setting.
 * @return string
 */
function edgeframe_sanitize_radio( $input, $setting ) {
	$input = sanitize_text_field( $input );

	if ( is_object( $setting ) ) {
		$choices = $setting->manager->get_control( $setting->id )->choices;
	} elseif ( is_array( $setting ) && isset( $setting['manager'], $setting['id'] ) ) {
		$choices = $setting['manager']->get_control( $setting['id'] )->choices;
	} else {
		$choices = array();
	}

	if ( array_key_exists( $input, $choices ) ) {
		return $input;
	} elseif ( is_object( $setting ) ) {
		return $setting->default;
	} elseif ( is_array( $setting ) && isset( $setting['default'] ) ) {
		return $setting['default'];
	} else {
		return '';
	}
}

/**
 * Sanitize textarea.
 *
 * @param string $input Input.
 * @return string
 */
function edgeframe_sanitize_textarea( $input ) {
	return sanitize_textarea_field( $input );
}

/**
 * Sanitize integer.
 *
 * @param int $input Input.
 * @return int
 */
function edgeframe_sanitize_integer( $input ) {
	return (int) $input;
}

/**
 * Sanitize URL.
 *
 * @param string $input Input.
 * @return string
 */
function edgeframe_sanitize_url( $input ) {
	return esc_url_raw( $input );
}

/**
 * Sanitize HTML.
 *
 * @param string $input Input.
 * @return string
 */
function edgeframe_sanitize_html( $input ) {
	return wp_kses_post( $input );
}
