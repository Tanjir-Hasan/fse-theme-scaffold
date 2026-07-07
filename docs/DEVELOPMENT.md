# {{THEME_NAME}} — Architecture Reference

This file explains how the theme's PHP is wired together, for whoever (human or Claude) needs to extend it later. Content work (patterns, layout, colors, text, images) doesn't need any of this — that all happens in **Appearance → Editor**. This doc is only relevant once you want genuinely new *functionality*.

## Folder map

```
functions.php               bootstraps everything (constants, then requires includes/core/all.php;
                             on `init`, requires scripts.php, blocks, block-styles, admin/settings.php)
theme.json                  design tokens: color/spacing/typography presets, global styles
style.css                   theme header (name/author/version) — required by WordPress
index.php                   required fallback file, intentionally near-empty (FSE themes render via
                             theme.json + templates/, not classic PHP templates)

templates/*.html            block-markup page templates (index.html, home.html, ...)
parts/*.html                template parts (header.html, footer.html) — each is a one-line
                             `<!-- wp:pattern {"slug":"..."} /-->` pointing at a real pattern
patterns/*.php               the actual block markup (PHP so you can mix in esc_html_e(), loops, etc.)

includes/core/*.php          cross-cutting features, each self-registering its own hooks
includes/blocks/*.php        core block output overrides (render_block_core/xxx filters)
includes/block-styles/*.php  register_block_style() custom variants for core blocks
includes/admin/settings.php  REST route for theme-wide settings (read/write `{{PFX}}_theme_options`)
includes/scripts.php         all wp_enqueue_style/script calls, in one place

assets/css/*.min.css         plain CSS, no build step (see "CSS" below)
assets/js/script.js          plain frontend JS, no build step
src/editor.js, src/settings.js   editor-sidebar panels, built via `npm run build` → build/*.js
```

## The one pattern used everywhere in `includes/core/`

Almost every file in `includes/core/` follows the same shape:

```php
add_filter( 'render_block', {{CONST_PREFIX}}_NS . 'my_function', 10, 2 );

function my_function( string $block_content, array $block ): string {
	$dom     = dom( $block_content );          // parse the block's rendered HTML
	$element = get_dom_element( 'header', $dom ); // grab the element you want to change
	if ( ! $element ) {
		return $block_content;
	}
	$element->setAttribute( 'class', $element->getAttribute( 'class' ) . ' my-new-class' );
	return $dom->saveHTML();
}
```

`dom()` and `get_dom_element()` (in `includes/core/dom.php`) wrap PHP's `DOMDocument` so you can safely read/rewrite a block's saved HTML at render time — used to add classes, strip nodes, or inject markup without hand-editing every pattern that might need the behavior.

| File | What it does |
|---|---|
| `dom.php` | The `dom()`/`get_dom_element()`/`change_tag_name()` HTML-rewriting helpers above. |
| `helpers.php` | `get_uri()`, `parse_css()` (turns a PHP array into a CSS string, optionally wrapped in `@media`), `get_svg_icon()`/`fetch_svg_icon()` (reads `assets/svg/svgs.json`, cached per-request), `css_array_to_string()`/`css_string_to_array()`, `front_post_ID()` (safe current-post-ID resolver — **use this, not `get_the_ID()`**, inside `render_block` filters; see below). |
| `responsive.php` | Adds a `{{SLUG}}-hide-desktop` / `-hide-tablet` / `-hide-mobile` class to any block whose attributes contain `{{CONST_PREFIX}}HideDesktop`/`HideTab`/`HideMob` (set either by hand in a pattern, or by the "Hide on Device" editor panel from `src/editor.js`), then supplies the matching `@media` rules via the inline-CSS filter chain (see below). |
| `sticky-header.php` | Adds `{{SLUG}}-sticky-header` / `{{SLUG}}-transparent-header` to the header template part based on per-page meta (`_{{PFX}}_meta_sticky_header` etc., toggled from the page-editor sidebar panel), plus the inline CSS/JS needed to make it actually stick/go transparent. |
| `hide-elements.php` | Blanks out the header/footer template part entirely when the matching per-page meta is on. Also exposes `get_disable_section_fields()`, the list the editor sidebar panel renders as toggles. |
| `remove-blocks.php` | Blanks out page/post title, featured image, or comments blocks when they don't apply (no thumbnail set, comments closed, etc.). |
| `metabox.php` | `register_post_meta()` for all the per-page toggles above — this is what makes them show up in the REST API / block editor at all. |
| `admin-bar.php` | Adds an "Edit template" shortcut to the frontend admin bar, pointing at whichever template the current page actually uses. |
| `dynamic-variables.php` | Replaces a `{site_url}` placeholder in navigation link URLs with the real home URL (handy for patterns you want portable across environments). |

## The inline CSS/JS pipeline

Several files (`responsive.php`, `sticky-header.php`, `scroll-top.php` if present) need to inject `<style>`/`<script>` that depends on what's actually on the page. Instead of enqueueing static files for this, they hook:

```php
add_filter( '{{PFX}}_dynamic_theme_css', __NAMESPACE__ . '\\my_css_contribution' );
add_filter( '{{PFX}}_dynamic_theme_js',  __NAMESPACE__ . '\\my_js_contribution' );
```

`includes/scripts.php`'s `enqueue_frontend_scripts()` calls `apply_filters( '{{PFX}}_dynamic_theme_css', '' )` once per page load, collects everything every feature contributed, and outputs it with `wp_add_inline_style()`/`wp_add_inline_script()`. If you add a new feature that needs page-dependent CSS/JS, hook into these two filters rather than enqueueing a new file.

## `front_post_ID()` vs `get_the_ID()`

Inside a `render_block` filter you are not always inside the main loop (e.g. rendering a template part, or on the posts archive), so `get_the_ID()` can return the wrong post or `false`. `front_post_ID()` (in `helpers.php`) resolves the "current front-end post" correctly, including when the site's front page is a posts list. Use it, not `get_the_ID()`, anywhere you need the current post inside a render-time filter.

## Patterns, templates, and parts

- A **template** (`templates/*.html`) is what WordPress's template hierarchy resolves to for a given URL. Keep these thin — just `wp:template-part` + one `wp:pattern` reference.
- A **template part** (`parts/*.html`) is almost always a single `<!-- wp:pattern {"slug":"..."} /-->` line pointing at the real content in `patterns/`. This indirection means the actual markup lives in one place (the pattern) and you can register it under `Block Types: core/template-part/header` so it shows up as a swappable option when editing that template part in the Site Editor.
- A **pattern** (`patterns/*.php`) is the real block markup, in a PHP file so you can use `esc_html_e()`, loops, conditionals, etc. Every pattern file needs the doc-comment header:

  ```php
  /**
   * Title: My Pattern
   * Slug: {{SLUG}}/my-pattern
   * Categories: some-category
   */
  ```

## Editor-sidebar JS build

`src/editor.js` and `src/settings.js` are built by `@wordpress/scripts` (`npm run build`) into `build/editor.js` + `build/editor.asset.php` and `build/settings.js` + `build/settings.asset.php`. `includes/scripts.php`'s `register_built_script()` reads the `.asset.php` file for the correct WordPress-package dependencies and cache-busting version automatically — you never need to hand-maintain a dependency array. If `build/` doesn't exist yet, the theme shows an admin notice instead of a fatal error; the rest of the site works normally.

To add a third panel/feature: add a new `src/whatever.js`, add an `entry` for it in `webpack.config.js`, and call `register_built_script()` for it from `includes/scripts.php`.

## CSS

Two plain, no-build CSS files matter:

- `assets/css/style.min.css` — frontend (enqueued in `enqueue_frontend_scripts()`).
- `assets/css/editor.min.css` — Block/Site Editor canvas only (added via `add_editor_style()` in `enqueue_editor_block_styles()`), so the editor preview matches the frontend.

Known limitation: a `wp:html` (Custom HTML) block renders inside its own sandboxed nested `<iframe>` in the editor and does **not** load either stylesheet — it'll look unstyled in the editor but correct on the live site. This is a Gutenberg limitation, not a bug in this theme.

RTL: `*-rtl.css` files are separate, hand-maintained files, auto-swapped in by `is_rtl()` (see `includes/scripts.php`). They are **not** generated from the LTR files by any tool here — if you add a directional rule, either mirror it by hand in the `-rtl.css` file, or (preferred) write it as a CSS logical property (`padding-inline-start` instead of `padding-left`) in the LTR file only, which needs no RTL counterpart at all.

## Quick reference: "where do I add X?"

| I want to... | Do this |
|---|---|
| Add a new page section design | New file in `patterns/`, reference it with `<!-- wp:pattern {"slug":"..."} /-->` from a template or another pattern |
| Add a new custom block style (e.g. a button variant) | New file in `includes/block-styles/`, `register_block_style()`, require it from `includes/block-styles/all.php`, add the CSS to `assets/css/editor.min.css` (+ `style.min.css` marker section) |
| Add a new per-page toggle | Register the meta in `includes/core/metabox.php`, read it wherever needed (`hide-elements.php` style), add a `ToggleControl` for it in `src/editor.js`'s `disableSections`/panel |
| Add a new REST-backed global setting | Extend `includes/admin/settings.php`'s route, add a control for it in `src/settings.js` |
| Add page-dependent inline CSS/JS | Hook `{{PFX}}_dynamic_theme_css` / `{{PFX}}_dynamic_theme_js` from wherever the feature lives |
| Rewrite a block's rendered HTML | `add_filter('render_block', ...)` + `dom()`/`get_dom_element()` from `includes/core/dom.php` |
