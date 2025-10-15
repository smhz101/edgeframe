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
		'general'      => array(
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
							'type'    => 'select',
							'label'   => __( 'Site Layout', 'edgeframe' ),
							'tooltip' => __( 'Choose the default content/sidebar arrangement for most templates.', 'edgeframe' ),
							'attrs'   => array( 'class' => 'ef-select2' ),
							'options' => array(
								'content-sidebar' => __( 'Content / Sidebar', 'edgeframe' ),
								'sidebar-content' => __( 'Sidebar / Content', 'edgeframe' ),
								'full-width'      => __( 'Full Width', 'edgeframe' ),
							),
							'default' => 'content-sidebar',
						),
					),
				),
			),
		),

		'appearance'   => array(
			'label'    => __( 'Appearance', 'edgeframe' ),
			'icon'     => 'dashicons-art',
			'desc'     => __( 'Global visual styles.', 'edgeframe' ),
			'sections' => array(
				'layout_choices' => array(
					'label'  => __( 'Layouts', 'edgeframe' ),
					'desc'   => __( 'Pick a global layout style for your site.', 'edgeframe' ),
					'fields' => array(
						'layout_choice' => array(
							'type'    => 'radio_image',
							'label'   => __( 'Layout Style', 'edgeframe' ),
							'tooltip' => __( 'Choose the base layout for content areas.', 'edgeframe' ),
							'default' => 'style-a',
							'options' => array(
								'style-a' => array(
									'label' => 'Style A',
									'image' => EDGEFRAME_URI . 'assets/images/layout-a.svg',
								),
								'style-b' => array(
									'label' => 'Style B',
									'image' => EDGEFRAME_URI . 'assets/images/layout-b.svg',
								),
								'style-c' => array(
									'label' => 'Style C',
									'image' => EDGEFRAME_URI . 'assets/images/layout-c.svg',
								),
							),
						),
					),
				),
				'colors'         => array(
					'label'  => __( 'Colors', 'edgeframe' ),
					'fields' => array(
						'background_color' => array(
							'type'    => 'color',
							'label'   => __( 'Background Color', 'edgeframe' ),
							'tooltip' => __( 'Global background color used behind content areas.', 'edgeframe' ),
							'default' => '#ffffff',
						),
						'text_color'       => array(
							'type'    => 'color',
							'label'   => __( 'Text Color', 'edgeframe' ),
							'tooltip' => __( 'Base body text color for paragraphs and default text.', 'edgeframe' ),
							'default' => '#111827',
						),
						'border_radius'    => array(
							'type'    => 'number',
							'label'   => __( 'Border Radius (px)', 'edgeframe' ),
							'tooltip' => __( 'Roundness applied to cards, buttons, and inputs.', 'edgeframe' ),
							'default' => 8,
							'attrs'   => array(
								'min' => 0,
								'max' => 32,
							),
						),
						'spacing_scale'    => array(
							'type'    => 'select',
							'label'   => __( 'Spacing Scale', 'edgeframe' ),
							'tooltip' => __( 'Controls padding/margins scale for theme spacing.', 'edgeframe' ),
							'default' => 'md',
							'attrs'   => array( 'class' => 'ef-select2' ),
							'options' => array(
								'sm' => __( 'Compact', 'edgeframe' ),
								'md' => __( 'Comfortable', 'edgeframe' ),
								'lg' => __( 'Spacious', 'edgeframe' ),
							),
						),
					),
				),
				'components'     => array(
					'label'  => __( 'Components', 'edgeframe' ),
					'fields' => array(
						'enable_cta'      => array(
							'type'    => 'toggle',
							'label'   => __( 'Enable CTA Block', 'edgeframe' ),
							'tooltip' => __( 'Toggle the call-to-action block used in templates/widgets.', 'edgeframe' ),
							'default' => 1,
						),
						'cta_block'       => array(
							'type'    => 'group',
							'label'   => __( 'CTA Block', 'edgeframe' ),
							'tooltip' => __( 'Configure CTA text and link.', 'edgeframe' ),
							'show_if' => array(
								array(
									'field'  => 'enable_cta',
									'truthy' => true,
								),
							),
							'fields'  => array(
								'title'    => array(
									'type'    => 'text',
									'label'   => __( 'Title', 'edgeframe' ),
									'default' => '',
								),
								'subtitle' => array(
									'type'    => 'textarea',
									'label'   => __( 'Subtitle', 'edgeframe' ),
									'default' => '',
								),
								'link'     => array(
									'type'    => 'text',
									'label'   => __( 'URL', 'edgeframe' ),
									'default' => '',
								),
								'new_tab'  => array(
									'type'    => 'toggle',
									'label'   => __( 'Open in new tab', 'edgeframe' ),
									'default' => 0,
								),
							),
						),
						'features'        => array(
							'type'    => 'repeater',
							'label'   => __( 'Feature Bullets', 'edgeframe' ),
							'tooltip' => __( 'Short bullet points displayed as highlights.', 'edgeframe' ),
							'desc'    => __( 'Short bullet points highlighting your product.', 'edgeframe' ),
							'item'    => array(
								'type'  => 'text',
								'attrs' => array( 'placeholder' => __( 'Enter a feature point…', 'edgeframe' ) ),
							),
							'min'     => 0,
							'max'     => 10,
						),
						'feature_toggles' => array(
							'type'    => 'repeater',
							'label'   => __( 'Feature Toggles', 'edgeframe' ),
							'tooltip' => __( 'Repeatable switches to enable/disable optional elements.', 'edgeframe' ),
							'desc'    => __( 'Repeatable on/off switches (e.g., enable comments, show date).', 'edgeframe' ),
							'item'    => array(
								'type'   => 'group',
								'fields' => array(
									'label'   => array(
										'type'  => 'text',
										'label' => __( 'Label', 'edgeframe' ),
										'attrs' => array( 'placeholder' => __( 'Toggle label', 'edgeframe' ) ),
									),
									'enabled' => array(
										'type'    => 'toggle',
										'label'   => __( 'Enabled', 'edgeframe' ),
										'default' => 0,
									),
								),
							),
						),
					),
				),
				'content'        => array(
					'label'  => __( 'Content Blocks', 'edgeframe' ),
					'fields' => array(
						'team' => array(
							'type'    => 'repeater',
							'label'   => __( 'Team Members', 'edgeframe' ),
							'tooltip' => __( 'Add team profiles when using the Full Width layout (Style C).', 'edgeframe' ),
							'show_if' => array(
								array(
									'field'  => 'layout_choice',
									'equals' => 'style-c',
								),
							),
							'item'    => array(
								'type'   => 'group',
								'fields' => array(
									'name'  => array(
										'type'  => 'text',
										'label' => __( 'Name', 'edgeframe' ),
									),
									'role'  => array(
										'type'  => 'text',
										'label' => __( 'Role', 'edgeframe' ),
									),
									'photo' => array(
										'type'  => 'media',
										'label' => __( 'Photo', 'edgeframe' ),
									),
									'bio'   => array(
										'type'  => 'textarea',
										'label' => __( 'Bio', 'edgeframe' ),
									),
								),
							),
						),
					),
				),
			),
			'inputs'   => array(
				'label'  => __( 'Inputs', 'edgeframe' ),
				'desc'   => __( 'Demo of date/time and color palette pickers.', 'edgeframe' ),
				'fields' => array(
					'demo_date'    => array(
						'type'    => 'date',
						'label'   => __( 'Demo Date', 'edgeframe' ),
						'tooltip' => __( 'Pick a date (native date input).', 'edgeframe' ),
						'default' => '',
					),
					'demo_time'    => array(
						'type'    => 'time',
						'label'   => __( 'Demo Time', 'edgeframe' ),
						'tooltip' => __( 'Pick a time (HH:MM 24h).', 'edgeframe' ),
						'default' => '',
					),
					'demo_palette' => array(
						'type'    => 'color_palette',
						'label'   => __( 'Demo Color Palette', 'edgeframe' ),
						'tooltip' => __( 'Choose from pre-set color swatches.', 'edgeframe' ),
						'palette' => array( '#111827', '#374151', '#4f46e5', '#10b981', '#ef4444', '#f59e0b' ),
						'default' => '#4f46e5',
					),
				),
			),
		),

		'header'       => array(
			'label'    => __( 'Header', 'edgeframe' ),
			'icon'     => 'dashicons-editor-kitchensink',
			'sections' => array(
				'layout' => array(
					'label'  => __( 'Header Options', 'edgeframe' ),
					'fields' => array(
						'header_sticky'      => array(
							'type'    => 'toggle',
							'label'   => __( 'Sticky Header', 'edgeframe' ),
							'default' => 0,
						),
						'header_transparent' => array(
							'type'    => 'toggle',
							'label'   => __( 'Transparent on Front Page', 'edgeframe' ),
							'default' => 0,
						),
						'header_height'      => array(
							'type'    => 'number',
							'label'   => __( 'Header Height (px)', 'edgeframe' ),
							'default' => 80,
							'attrs'   => array(
								'min' => 48,
								'max' => 200,
							),
						),
						'logo_max_width'     => array(
							'type'    => 'number',
							'label'   => __( 'Logo Max Width (px)', 'edgeframe' ),
							'default' => 180,
							'attrs'   => array(
								'min' => 60,
								'max' => 400,
							),
						),
						'show_tagline'       => array(
							'type'    => 'toggle',
							'label'   => __( 'Show Site Tagline', 'edgeframe' ),
							'default' => 1,
						),
					),
				),
			),
		),

		'footer'       => array(
			'label'    => __( 'Footer', 'edgeframe' ),
			'icon'     => 'dashicons-editor-underline',
			'sections' => array(
				'layout' => array(
					'label'  => __( 'Footer Layout', 'edgeframe' ),
					'fields' => array(
						'footer_columns'      => array(
							'type'    => 'number',
							'label'   => __( 'Widget Columns', 'edgeframe' ),
							'default' => 3,
							'attrs'   => array(
								'min' => 1,
								'max' => 4,
							),
						),
						'footer_show_credits' => array(
							'type'    => 'toggle',
							'label'   => __( 'Show Credits', 'edgeframe' ),
							'default' => 1,
						),
						'footer_copyright'    => array(
							'type'    => 'text',
							'label'   => __( 'Copyright Text', 'edgeframe' ),
							'default' => '© ' . gmdate( 'Y' ) . ' ' . get_bloginfo( 'name' ),
						),
					),
				),
			),
		),

		'blog'         => array(
			'label'    => __( 'Blog', 'edgeframe' ),
			'icon'     => 'dashicons-admin-post',
			'sections' => array(
				'list'   => array(
					'label'  => __( 'Archive', 'edgeframe' ),
					'fields' => array(
						'excerpt_length' => array(
							'type'    => 'number',
							'label'   => __( 'Excerpt Length', 'edgeframe' ),
							'default' => 30,
							'attrs'   => array(
								'min' => 0,
								'max' => 200,
							),
						),
						'read_more_text' => array(
							'type'    => 'text',
							'label'   => __( 'Read More Text', 'edgeframe' ),
							'default' => __( 'Read more', 'edgeframe' ),
						),
						'show_meta'      => array(
							'type'    => 'toggle',
							'label'   => __( 'Show Meta (date, author)', 'edgeframe' ),
							'default' => 1,
						),
					),
				),
				'single' => array(
					'label'  => __( 'Single Post', 'edgeframe' ),
					'fields' => array(
						'show_categories' => array(
							'type'    => 'toggle',
							'label'   => __( 'Show Categories', 'edgeframe' ),
							'default' => 1,
						),
						'show_tags'       => array(
							'type'    => 'toggle',
							'label'   => __( 'Show Tags', 'edgeframe' ),
							'default' => 1,
						),
						'show_author_box' => array(
							'type'    => 'toggle',
							'label'   => __( 'Show Author Box', 'edgeframe' ),
							'default' => 0,
						),
					),
				),
			),
		),

		'typography'   => array(
			'label'    => __( 'Typography', 'edgeframe' ),
			'icon'     => 'dashicons-editor-textcolor',
			'sections' => array(
				'base' => array(
					'label'  => __( 'Base', 'edgeframe' ),
					'fields' => array(
						'font_family'   => array(
							'type'    => 'text',
							'label'   => __( 'Font Family (CSS stack)', 'edgeframe' ),
							'default' => 'Inter, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif',
						),
						'font_size'     => array(
							'type'    => 'number',
							'label'   => __( 'Base Font Size (px)', 'edgeframe' ),
							'default' => 16,
							'attrs'   => array(
								'min' => 12,
								'max' => 22,
							),
						),
						'heading_scale' => array(
							'type'    => 'select',
							'label'   => __( 'Heading Scale', 'edgeframe' ),
							'tooltip' => __( 'Modular scale used to size H1-H6 headings.', 'edgeframe' ),
							'default' => 'modular-1.25',
							'attrs'   => array( 'class' => 'ef-select2' ),
							'options' => array(
								'modular-1.2'  => __( 'Modular 1.20', 'edgeframe' ),
								'modular-1.25' => __( 'Modular 1.25', 'edgeframe' ),
								'modular-1.33' => __( 'Modular 1.33', 'edgeframe' ),
							),
						),
					),
				),
			),
		),

		'performance'  => array(
			'label'    => __( 'Performance', 'edgeframe' ),
			'icon'     => 'dashicons-dashboard',
			'sections' => array(
				'core' => array(
					'label'  => __( 'Core Performance', 'edgeframe' ),
					'fields' => array(
						'perf_disable_emojis'   => array(
							'type'    => 'toggle',
							'label'   => __( 'Disable Emojis', 'edgeframe' ),
							'default' => 1,
						),
						'perf_unload_dashicons' => array(
							'type'    => 'toggle',
							'label'   => __( 'Unload Dashicons on Front', 'edgeframe' ),
							'default' => 0,
							'show_if' => array(
								array(
									'field'  => 'perf_disable_emojis',
									'truthy' => true,
								),
							),
						),
					),
				),
			),
		),

		'integrations' => array(
			'label'    => __( 'Integrations', 'edgeframe' ),
			'icon'     => 'dashicons-admin-links',
			'sections' => array(
				'apis' => array(
					'label'  => __( 'API Keys', 'edgeframe' ),
					'fields' => array(
						'google_maps_api' => array(
							'type'    => 'text',
							'label'   => __( 'Google Maps API Key', 'edgeframe' ),
							'default' => '',
						),
						'mailchimp_api'   => array(
							'type'    => 'text',
							'label'   => __( 'Mailchimp API Key', 'edgeframe' ),
							'default' => '',
						),
					),
				),
			),
		),

		'tools'        => array(
			'label'    => __( 'Tools', 'edgeframe' ),
			'icon'     => 'dashicons-admin-tools',
			'desc'     => __( 'Import/Export and maintenance tools.', 'edgeframe' ),
			'sections' => array(),
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
