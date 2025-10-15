<?php
/**
 * Admin settings schema.
 *
 * @package EdgeFrame
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * EdgeFrame settings schema.
 *
 * Return an array of tabs -> sections -> fields. Child themes/plugins can
 * extend or modify via the 'edgeframe_settings_schema' filter.
 */
function edgeframe_get_settings_schema(): array {
	$schema = array(
		'general' => array(
			'label'    => __( 'General', 'edgeframe' ),
			'icon'     => 'dashicons-admin-generic',
			'desc'     => __( 'Core theme options.', 'edgeframe' ),
			'sections' => array(
				'brand' => array(
					'label'  => __( 'Brand', 'edgeframe' ),
					'fields' => array(
						'accent' => array(
							'type'    => 'color',
							'label'   => __( 'Accent Color', 'edgeframe' ),
							'desc'    => __( 'Used across UI elements.', 'edgeframe' ),
							'tooltip' => __( 'This color is applied to highlights, buttons, and interactive accents across the theme.', 'edgeframe' ),
							'default' => '#4f46e5',
						),
						'layout' => array(
							'type'    => 'radio_image',
							'label'   => __( 'Site Layout', 'edgeframe' ),
							'tooltip' => __( 'Choose the default content/sidebar arrangement for most templates.', 'edgeframe' ),
							'options' => array(
								'content-sidebar' => array(
									'label' => __( 'Content / Sidebar', 'edgeframe' ),
									'image' => EDGEFRAME_URI . 'assets/images/layout-content-sidebar.svg',
								),
								'sidebar-content' => array(
									'label' => __( 'Sidebar / Content', 'edgeframe' ),
									'image' => EDGEFRAME_URI . 'assets/images/layout-sidebar-content.svg',
								),
								'full-width'      => array(
									'label' => __( 'Full Width', 'edgeframe' ),
									'image' => EDGEFRAME_URI . 'assets/images/layout-full-width.svg',
								),
							),
							'default' => 'content-sidebar',
						),
					),
					'layout' => array(
						'label'  => __( 'Layout Container', 'edgeframe' ),
						'fields' => array(
							'container_mode'    => array(
								'type'    => 'radio_image',
								'label'   => __( 'Container Mode', 'edgeframe' ),
								'tooltip' => __( 'Choose full-width, boxed site, or boxed sections.', 'edgeframe' ),
								'options' => array(
									'full'           => array(
										'label' => __( 'Full Width', 'edgeframe' ),
										'image' => EDGEFRAME_URI . 'assets/images/container-full.svg',
									),
									'boxed-site'     => array(
										'label' => __( 'Boxed Site', 'edgeframe' ),
										'image' => EDGEFRAME_URI . 'assets/images/container-boxed-site.svg',
									),
									'boxed-sections' => array(
										'label' => __( 'Boxed Sections', 'edgeframe' ),
										'image' => EDGEFRAME_URI . 'assets/images/container-boxed-sections.svg',
									),
								),
								'default' => 'full',
							),
							'container_width'   => array(
								'type'    => 'number',
								'label'   => __( 'Container Max Width (px)', 'edgeframe' ),
								'default' => 1200,
								'attrs'   => array(
									'min'  => 800,
									'max'  => 1920,
									'step' => 10,
								),
							),
							'container_padding' => array(
								'type'    => 'number',
								'label'   => __( 'Container Horizontal Padding (px)', 'edgeframe' ),
								'default' => 24,
								'attrs'   => array(
									'min' => 0,
									'max' => 80,
								),
							),
						),
					),
				),
			),
		),
		'header'  => array(
			'label'    => __( 'Header', 'edgeframe' ),
			'icon'     => 'dashicons-align-wide',
			'desc'     => __( 'Configure global header layout and elements.', 'edgeframe' ),
			'sections' => array(
				'layout'   => array(
					'label'  => __( 'Layout', 'edgeframe' ),
					'fields' => array(
						'header_layout'         => array(
							'type'    => 'radio_image',
							'label'   => __( 'Header Layout', 'edgeframe' ),
							'options' => apply_filters(
								'edgeframe_header_layout_options',
								array(
									'simple'   => array(
										'label' => __( 'Simple', 'edgeframe' ),
										'image' => EDGEFRAME_URI . 'assets/images/header-simple.svg',
									),
									'centered' => array(
										'label' => __( 'Centered', 'edgeframe' ),
										'image' => EDGEFRAME_URI . 'assets/images/header-centered.svg',
									),
									'split'    => array(
										'label' => __( 'Split', 'edgeframe' ),
										'image' => EDGEFRAME_URI . 'assets/images/header-split.svg',
									),
									'stacked'  => array(
										'label' => __( 'Stacked', 'edgeframe' ),
										'image' => EDGEFRAME_URI . 'assets/images/header-stacked.svg',
									),
								)
							),
							'default' => 'simple',
						),
						'header_sticky'         => array(
							'type'    => 'toggle',
							'label'   => __( 'Sticky Header', 'edgeframe' ),
							'default' => 0,
						),
						'header_transparent'    => array(
							'type'    => 'toggle',
							'label'   => __( 'Transparent (overlay)', 'edgeframe' ),
							'default' => 0,
						),
						'header_menu_alignment' => array(
							'type'    => 'select',
							'label'   => __( 'Menu Alignment', 'edgeframe' ),
							'attrs'   => array( 'class' => 'ef-select2' ),
							'options' => array(
								'left'   => __( 'Left', 'edgeframe' ),
								'center' => __( 'Center', 'edgeframe' ),
								'right'  => __( 'Right', 'edgeframe' ),
							),
							'default' => 'right',
						),
					),
				),
				'elements' => array(
					'label'  => __( 'Elements', 'edgeframe' ),
					'fields' => array(
						'header_show_cta' => array(
							'type'    => 'toggle',
							'label'   => __( 'Show CTA Button', 'edgeframe' ),
							'default' => 0,
						),
						'header_cta'      => array(
							'type'    => 'group',
							'label'   => __( 'CTA Button', 'edgeframe' ),
							'show_if' => array(
								array(
									'field'  => 'header_show_cta',
									'truthy' => true,
								),
							),
							'fields'  => array(
								'text'    => array(
									'type'    => 'text',
									'label'   => __( 'Text', 'edgeframe' ),
									'default' => __( 'Contact Us', 'edgeframe' ),
								),
								'url'     => array(
									'type'    => 'text',
									'label'   => __( 'URL', 'edgeframe' ),
									'default' => '',
								),
								'new_tab' => array(
									'type'    => 'toggle',
									'label'   => __( 'Open in new tab', 'edgeframe' ),
									'default' => 0,
								),
							),
						),
					),
				),
				'topbar'   => array(
					'label'  => __( 'Top Bar', 'edgeframe' ),
					'fields' => array(
						'header_topbar_enable' => array(
							'type'    => 'toggle',
							'label'   => __( 'Enable Top Bar', 'edgeframe' ),
							'default' => 0,
						),
						'header_topbar_text'   => array(
							'type'    => 'textarea',
							'label'   => __( 'Top Bar Text', 'edgeframe' ),
							'tooltip' => __( 'Short text for the top bar (accepts basic HTML).', 'edgeframe' ),
							'show_if' => array(
								array(
									'field'  => 'header_topbar_enable',
									'truthy' => true,
								),
							),
							'default' => '',
						),
					),
				),
			),
		),
		'tools'   => array(
			'label'    => __( 'Tools', 'edgeframe' ),
			'icon'     => 'dashicons-admin-tools',
			'desc'     => __( 'Import/Export and maintenance tools.', 'edgeframe' ),
			'sections' => array(),
		),
		'footer'  => array(
			'label'    => __( 'Footer', 'edgeframe' ),
			'icon'     => 'dashicons-editor-underline',
			'desc'     => __( 'Footer display options.', 'edgeframe' ),
			'sections' => array(
				'layout' => array(
					'label'  => __( 'Footer Content', 'edgeframe' ),
					'fields' => array(
						'footer_show_credits' => array(
							'type'    => 'toggle',
							'label'   => __( 'Show Credits', 'edgeframe' ),
							'default' => 1,
						),
						'footer_copyright'    => array(
							'type'    => 'text',
							'label'   => __( 'Copyright Text', 'edgeframe' ),
							'tooltip' => __( 'Leave blank to use default: © YEAR Site Name', 'edgeframe' ),
							'default' => '',
						),
					),
				),
			),
		),
	);

	// New snake_case filter
	$schema = apply_filters( 'edgeframe_settings_schema', $schema );
	// Back-compat for older slash-named filters
	if ( has_filter( 'edgeframe/settings_schema' ) ) {
		$schema = apply_filters( 'edgeframe/settings_schema', $schema );
	}
	return $schema;
}
