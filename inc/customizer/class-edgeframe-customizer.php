<?php
/**
 * EdgeFrame Customizer
 *
 * @package Edgeframe
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; }

/**
 * Class EdgeFrame_Customizer
 */
class EdgeFrame_Customizer {

	/**
	 * Register customizer settings and controls.
	 */
	public static function register() {
		add_action( 'customize_register', array( __CLASS__, 'register_settings' ) );
	}

	/**
	 * Register customizer settings and controls.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer object.
	 */
	public static function register_settings( WP_Customize_Manager $wp_customize ) {
		$wp_customize->add_section(
			'edgeframe_colors',
			array(
				'title'    => __( 'EdgeFrame Colors', 'edgeframe' ),
				'priority' => 30,
			)
		);

		$wp_customize->add_setting(
			'edgeframe_accent',
			array(
				'default'           => '#4f46e5',
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'refresh',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'edgeframe_accent',
				array(
					'label'   => __( 'Accent Color', 'edgeframe' ),
					'section' => 'edgeframe_colors',
				)
			)
		);
	}
}

// Initialize the customizer settings.
EdgeFrame_Customizer::register();
