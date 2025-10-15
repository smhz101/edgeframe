# EdgeFrame

A developer-friendly, ThemeForest-ready WordPress parent theme with a schema-driven settings UI, accessible templates, and clean hooks.

## Highlights

-   Parent theme focused on clean architecture and extensibility
-   Schema-driven admin settings page with:
    -   Tabs, sections, fields (text, textarea, number, select, toggle, media)
    -   Advanced field types: group, repeater, radio-image, date, time, color, color palette
    -   Conditional logic, Select2 support, toasts, drag-and-drop repeaters
    -   Import / export / reset tools
-   Accessibility: skip link, ARIA-friendly breadcrumbs, semantic markup
-   Front-end baseline styles and RTL stylesheet
-   Block editor compatibility
-   Child theme included

## Requirements

-   WordPress 6.0+
-   PHP 7.4+

## Installation

1. Upload the `edgeframe` folder to `/wp-content/themes/`.
2. Activate the theme under Appearance → Themes.
3. (Optional) Activate the child theme in `child-theme/edgeframe-child/`.
4. Visit Appearance → EdgeFrame to configure settings.

## File structure

-   `inc/` — Core modules (setup, features, admin UI, compatibility)
-   `assets/` — CSS/JS and images (front and admin)
-   `template-parts/` — Content partials
-   `child-theme/edgeframe-child` — Starter child theme

## Hooks (actions & filters)

All new hooks follow snake_case naming for readability. Legacy slash hooks are still fired for back-compat.

### Filters

-   `edgeframe_admin_schema` → Filter full settings schema before render
-   `edgeframe_admin_schema_after` → Filter schema after initial filter
-   `edgeframe_settings_schema` → Filter schema at definition time
-   `edgeframe_admin_import_settings` → Filter imported settings just before saving

### Actions

-   `edgeframe_admin_before_render` → Before the settings UI renders
-   `edgeframe_admin_toolbar` → In the settings page toolbar
-   `edgeframe_admin_tabs_after` → After the sidebar tabs list
-   `edgeframe_admin_before_sections` → Before rendering sections in a tab
-   `edgeframe_admin_section_before` / `edgeframe_admin_section_after` → Around each section
-   `edgeframe_admin_after_sections` → After all sections in a tab
-   `edgeframe_admin_after_render` → After the settings UI renders
-   `edgeframe_admin_enqueue` → Enqueue extra assets on settings screen
-   `edgeframe_admin_reset_settings` → After settings are reset

Note: Legacy hooks like `edgeframe/admin/...` are still executed for child theme compatibility.

See also: `docs/hooks-reference.md` for full signatures and code examples.

## Theme support

-   Title tag, post thumbnails, HTML5 markup, feed links
-   Editor styles and block editor compatibility
-   Menus and sidebars

## Developer notes

-   Settings are registered via the Settings API and sanitized per field type.
-   New field types include dedicated sanitizers (date, time, color palette).
-   Repeaters support drag-and-drop and group items.
-   Select2 can be bundled locally or uses a CDN fallback in admin.

## Roadmap

-   theme.json with global styles
-   Block patterns (Hero, Features, CTA)
-   WooCommerce minimal templates/styles
-   Demo content (WXR) and detailed documentation site

## Changelog

See `CHANGELOG.md`.

## License

GPL-2.0-or-later. See license headers in `style.css` and `readme.txt`.
