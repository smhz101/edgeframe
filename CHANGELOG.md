# Changelog

All notable changes to this project will be documented in this file.

The format is based on Keep a Changelog, and this project adheres to Semantic Versioning.

## [0.1.0] - 2025-10-15

### Added

-   Schema-driven admin settings UI (tabs, sections, fields) with import/export/reset
-   Advanced field types: group, repeater, radio-image, media, toggle, select2; new date, time, color palette
-   Conditional field visibility, toasts, drag-and-drop repeaters
-   Accessibility: skip-link, improved breadcrumbs markup
-   Front-end baseline styles and RTL stylesheet
-   Archive, Search, and 404 templates; accessible search form
-   Theme supports (title-tag, thumbnails, HTML5, editor-styles), menus and sidebars
-   Customizer accent color and helpers
-   Block editor compatibility
-   JSON-LD BreadcrumbList output alongside HTML breadcrumbs
-   Block styles (Buttons: Outline; Quote: Bordered; Image: Shadow)
-   Block pattern categories and starter patterns (Hero, Features grid, CTA)
-   theme.json with palette, typography, and spacing units
-   Enqueue comment-reply on singular when threaded comments enabled
-   Template enhancements: featured images on posts/pages; post tags output
-   Custom Header and Custom Background theme supports

### Changed

-   Escaping and sanitization across settings and templates
-   Removed plugin-territory code (shortcodes/security tweaks)
-   Pagination and template improvements

### Fixed

-   Renderer issues for new field types; sanitizer mapping
-   CSS admin stylesheet corruption; added palette styles
