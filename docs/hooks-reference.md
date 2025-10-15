# EdgeFrame Hooks Reference

This document lists all public hooks (actions and filters) available in EdgeFrame.
All new hooks use snake_case. Legacy slash-named hooks are still triggered for backward compatibility.

## Filters

-   `edgeframe_admin_schema` — Filter the settings schema before render
    -   Arguments: (array $schema)
-   `edgeframe_admin_schema_after` — Filter schema after initial filter
    -   Arguments: (array $schema)
-   `edgeframe_settings_schema` — Filter the schema at definition time
    -   Arguments: (array $schema)
-   `edgeframe_admin_import_settings` — Filter imported settings before save
    -   Arguments: (array $clean, array $raw)

## Actions

-   `edgeframe_admin_before_render` — Before the settings UI renders
    -   Arguments: (array $schema)
-   `edgeframe_admin_toolbar` — Inside the settings page toolbar
    -   Arguments: ()
-   `edgeframe_admin_tabs_after` — After the sidebar tabs list
    -   Arguments: (array $schema)
-   `edgeframe_admin_before_sections` — Before sections in a tab render
    -   Arguments: (array $tab, string $tab_key)
-   `edgeframe_admin_section_before` — Before a section renders
    -   Arguments: (string $tab_key, string $section_key, array $section)
-   `edgeframe_admin_section_after` — After a section renders
    -   Arguments: (string $tab_key, string $section_key, array $section)
-   `edgeframe_admin_after_sections` — After all sections in a tab render
    -   Arguments: (array $tab, string $tab_key)
-   `edgeframe_admin_after_render` — After the settings UI renders
    -   Arguments: (array $schema)
-   `edgeframe_admin_enqueue` — Enqueue extra assets for the settings UI
    -   Arguments: (string $hook)
-   `edgeframe_admin_reset_settings` — After settings are reset to defaults
    -   Arguments: (array $defaults)

## Examples

```php
// Add a custom script on the settings page
add_action( 'edgeframe_admin_enqueue', function( $hook ) {
	wp_enqueue_style( 'my-theme-settings', get_stylesheet_directory_uri() . '/assets/admin.css', [], '1.0' );
} );

// Add a tab to the settings schema
add_filter( 'edgeframe_admin_schema', function( $schema ) {
	$schema['my_tab'] = [
		'label'    => __( 'My Tab', 'edgeframe' ),
		'icon'     => 'dashicons-admin-generic',
		'sections' => [
			'general' => [
				'label'  => __( 'General', 'edgeframe' ),
				'fields' => [
					'enabled' => [ 'type' => 'toggle', 'label' => __( 'Enabled', 'edgeframe' ), 'default' => 0 ],
				],
			],
		],
	];
	return $schema;
} );

// Post-process imported settings
add_filter( 'edgeframe_admin_import_settings', function( $clean, $raw ) {
	// e.g., migrate old keys
	if ( isset( $clean['old_key'] ) && ! isset( $clean['new_key'] ) ) {
		$clean['new_key'] = $clean['old_key'];
		unset( $clean['old_key'] );
	}
	return $clean;
}, 10, 2 );
```

## Backward compatibility

For legacy child themes using hooks like `edgeframe/admin/...`, EdgeFrame still triggers those hooks when listeners exist. Prefer migrating to snake_case going forward.
