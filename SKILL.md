---
name: fse-theme-scaffold
description: Scaffolds a new WordPress Full Site Editing (FSE) block theme with a complete, working architecture (theme.json, block patterns/templates/parts, DOM/CSS helpers, responsive visibility system, per-page meta toggles, REST settings route, npm/wp-scripts build for the editor sidebar panels). Use when the user wants to start a brand-new FSE/block theme from scratch, asks for "a theme like the one we built before", or wants a repeatable starting point for WordPress FSE theme projects. Only needs a theme name and author from the user — everything else (namespace, constants, slug, folder structure) is derived and generated automatically.
---

# FSE Theme Scaffold

Generates a complete, working WordPress FSE (block) theme folder: `theme.json` design tokens, block-based `templates/`/`parts/`/`patterns/`, a small PHP "core" library (DOM helpers, CSS helpers, responsive visibility, per-page meta toggles, sticky/transparent header, REST settings route), and an `@wordpress/scripts` build for the two editor-sidebar panels.

The user should only need to give a **theme name** and **author**. Everything else is derived automatically. Don't ask more than that unless something genuinely can't be inferred (see Step 1).

## Step 1 — Get the inputs

Ask the user (if not already given in their message):

1. **Theme name** (e.g. "Acme Courses") — display name, used in `style.css`, `readme.txt`, on-screen panel titles.
2. **Author** name — used in `@author` docblocks and `readme.txt`.

Optionally, if the user cares, you can also ask **where** to create it (default: a sibling folder next to the current theme/project, inside the WordPress `wp-content/themes/` directory — infer this from the current working directory if it's already inside a `wp-content/themes/<something>` path).

Do not ask about namespace, constant prefix, slug, or folder layout — derive them (Step 2) and just show the user the result at the end.

## Step 2 — Derive the tokens

From the theme name, compute (all pure string transforms, no user input needed):

| Token | Rule | Example (`"Acme Courses Pro"`) |
|---|---|---|
| `THEME_NAME` | given, as-is | `Acme Courses Pro` |
| `SLUG` | kebab-case, lowercase, non-alphanumeric → `-` | `acme-courses-pro` |
| `NAMESPACE` | PascalCase, words concatenated, no separators | `AcmeCoursesPro` |
| `CONST_PREFIX` | `NAMESPACE` upper-cased | `ACMECOURSESPRO` |
| `PFX` | `NAMESPACE` lower-cased (no hyphens — used inside PHP identifiers/CSS class fragments where `-pro` would be invalid or ambiguous) | `acmecoursespro` |
| `LOC` | `NAMESPACE` with first letter lower-cased (JS global object name for `wp_localize_script`) | `acmeCoursesPro` |
| `AUTHOR` | given, as-is | — |
| `YEAR` | current year | `2026` |

For a single-word theme name, `SLUG` and `PFX` end up identical (e.g. `"Acme Courses"` → `SLUG=acme-courses`, `PFX=acmecourses`) — that's expected.

## Step 3 — Copy the template and substitute tokens

The `template/` folder next to this file is a complete, working theme skeleton with every one of the above identifiers replaced by `{{TOKEN}}` placeholders (e.g. `{{THEME_NAME}}`, `{{SLUG}}`, `{{NAMESPACE}}`, `{{CONST_PREFIX}}`, `{{PFX}}`, `{{LOC}}`, `{{AUTHOR}}`, `{{YEAR}}`).

1. Copy `template/` (recursively, including empty directories like `assets/fonts`, `assets/image`, `languages`, `styles`) to the target directory (e.g. `wp-content/themes/<SLUG>/`). Confirm the target directory doesn't already exist before writing — don't overwrite an existing theme folder.
2. Run a find-and-replace across **every file** in the new theme folder (PHP, CSS, JSON, HTML, JS — not binary/image files) substituting each `{{TOKEN}}` with its computed value. A `sed` loop over all text files works well:

   ```bash
   find "<new-theme-dir>" -type f \( -name "*.php" -o -name "*.css" -o -name "*.json" -o -name "*.html" -o -name "*.js" -o -name "*.txt" \) | while read -r f; do
     sed -i \
       -e 's/{{THEME_NAME}}/<theme name>/g' \
       -e 's/{{SLUG}}/<slug>/g' \
       -e 's/{{NAMESPACE}}/<namespace>/g' \
       -e 's/{{CONST_PREFIX}}/<const prefix>/g' \
       -e 's/{{PFX}}/<pfx>/g' \
       -e 's/{{LOC}}/<loc>/g' \
       -e 's/{{AUTHOR}}/<author>/g' \
       -e 's/{{YEAR}}/<year>/g' \
       "$f"
   done
   ```

   Order doesn't matter here (unlike renaming an *existing* branded theme) because the tokens are unambiguous, delimited placeholders — there's no risk of one substitution corrupting another.

3. Copy `docs/DEVELOPMENT.md` (next to this file) into the new theme root as `DEVELOPMENT.md`, then run the same token substitution on that copy too — it travels with the generated theme for whoever needs to touch the PHP later.
4. Verify no placeholders are left: `grep -rl "{{" <new-theme-dir>` should return nothing.
5. Lint every PHP file: `php -l` each `*.php` file (or all at once in a loop) and fix anything that doesn't say "No syntax errors detected" before reporting success.

## Step 4 — Fill in the rest by hand (things that shouldn't be templated)

- **`screenshot.png`** — not generated. Tell the user it's optional but recommended (1200×900px), used in the Appearance → Themes grid.
- **`languages/{{SLUG}}.pot`** — not generated (needs `wp i18n make-pot` against the real, substituted theme, which only exists after Step 3). Mention this is optional and can be done later.

## Step 5 — JS build

The theme ships two editor-sidebar features (`src/editor.js`, `src/settings.js`) built with `@wordpress/scripts`. Tell the user:

```bash
cd <new-theme-dir>
npm install
npm run build      # one-time build → build/editor.js, build/settings.js
npm start          # optional: rebuild on every save while developing
```

Until `npm run build` has been run once, the theme still works fine on the frontend and in the Site Editor for content/patterns — only the two custom sidebar panels (page-level sticky/transparent-header + hide-section toggles, and the site-wide "scroll to top" toggle) are unavailable, and an admin notice will say so.

## Step 6 — CSS

No build step for CSS. Two plain files, both already enqueued by `includes/scripts.php`:

- `assets/css/style.min.css` — loaded on the **live frontend**. Add custom CSS below the marker comment at the bottom of the file.
- `assets/css/editor.min.css` — loaded **inside the Block/Site Editor canvas only** (via `add_editor_style()`), so the editor preview matches the frontend. Add the same rule here too if you want WYSIWYG parity. (Content inside a `wp:html` / Custom HTML block renders in its own sandboxed nested iframe in the editor and won't pick up either stylesheet — that's a Gutenberg limitation, not a bug; it still renders correctly on the live site.)

There's no RTL build step either — `style.min-rtl.css` / `editor.min-rtl.css` etc. exist and are auto-swapped in by `is_rtl()`, but they are **not** auto-generated from the LTR files. If you add a directional rule (`padding-left`, `margin-right`, ...) to the LTR file, mirror it by hand in the matching `-rtl.css` file, or better, use CSS logical properties (`padding-inline-start`, `margin-inline-end`, ...) in the LTR file only and skip the RTL file entirely for that rule.

## Step 7 — Report back

Show the user:
- The final folder path and a short `find <dir> -type f` tree.
- The derived tokens table (Step 2) so they know what their namespace/slug ended up as.
- The exact `npm install && npm run build` command to run next.
- A one-line pointer to `docs/DEVELOPMENT.md` (copied into the new theme) for anyone who needs to touch the PHP.
- Remind them: from here on, day-to-day content work (patterns, page layout, colors, text, images) happens entirely in **Appearance → Editor** — no PHP required for that part.

## Notes for whoever maintains this skill

- The `template/` folder is a frozen, hand-tokenized snapshot of a working theme's architecture (DOM helpers, responsive visibility, per-page meta toggles, REST settings route, block-style registrations). It deliberately excludes anything specific to one theme's branding (e.g. a "welcome notice" admin screen promoting a specific companion plugin) — keep it that way; only add things here that are genuinely reusable across unrelated FSE theme projects.
- If you fix a bug in a scaffolded theme's core files and it's a bug in the *architecture* (not that theme's content), port the fix back into `template/` too (re-tokenize the identifiers you touched) so future scaffolds don't regenerate the same bug.
