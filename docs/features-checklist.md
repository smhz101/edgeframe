# Parent Theme Features Checklist

Use this checklist to decide which features to include. Check the boxes you want; I can implement them next.

## Core templates & structure

-   [x] Header/Footer/Sidebar
-   [x] 404, Search, Archive, Index, Single, Page
-   [ ] Front Page (custom), Home (blog) templates
-   [ ] Full Width and Sidebar Left page templates

## Navigation & SEO

-   [x] Accessible breadcrumbs (ARIA/ol/aria-current)
-   [x] Pagination (archive) and post navigation (single)
-   [x] Skip pagination to top/bottom controls
-   [x] Schema.org JSON-LD for breadcrumbs

## Accessibility (a11y)

-   [x] Skip link to main content
-   [ ] Focus-visible and high-contrast modes
-   [x] ARIA-expanded states for menus

## Design system / editor

-   [x] theme.json for global styles (colors, spacing, typography)
-   [x] Editor color palette synced with settings
-   [x] Block styles (Buttons: Outline; Quote: Bordered)
-   [x] Block patterns (Hero, Features, CTA)

## WooCommerce (optional)

-   [x] add_theme_support('woocommerce')
-   [x] Basic product/archive layout and styles
-   [x] Mini-cart styling (if widget enabled)

## Performance

-   [x] Defer/async strategies for non-critical scripts
-   [x] Preload key fonts (if any) and assets

## Internationalization

-   [x] POT present
-   [x] Regenerate POT with all latest strings

## RTL

-   [x] rtl.css basic
-   [x] Expand RTL styles for navigation, comments, pagination arrows

## Options & Customizer

-   [x] Schema-driven settings UI (tabs/sections/fields)
-   [x] Advanced fields (group, repeater, radio-image, date/time/color/palette)
-   [x] Import/export/reset tools
-   [x] theme.json integration with settings (sync colors/spacing)

## Demo & Docs

-   [ ] Demo content (WXR) and widgets JSON
-   [x] README and hooks reference
-   [x] Detailed documentation site (installation, settings guide)

## QA

-   [ ] WPCS/PHPCS pass
-   [ ] Theme Check pass
-   [ ] Basic unit tests for helpers
