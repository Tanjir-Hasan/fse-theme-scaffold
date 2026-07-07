# fse-theme-scaffold

A Claude Code skill that generates a new WordPress **Full Site Editing (FSE) block theme**, ready to use, from just a theme name and an author name.

```bash
Create a new FSE theme, [Name], [Author]
```

## What you get

A complete theme folder — not a bare `style.css` + `index.php` stub — with:

- `theme.json` with a sensible starter design-token system (colors, spacing, fluid font sizes, custom font-weight/line-height tokens)
- Block **templates**, **template parts** (header/footer), and **patterns** — the actual visual building blocks you'll edit in the Site Editor
- A small, working PHP "core" library that gives you, for free:
  - Per-page toggles for sticky header / transparent header / hide header / hide footer (shows up as a panel in the post/page editor sidebar)
  - A "hide this block on Desktop / Tablet / Mobile" control on every block in the editor
  - A site-wide "scroll to top button" toggle (Site Editor sidebar)
  - A REST route for reading/writing theme-wide settings
  - DOM/CSS helper functions used internally to rewrite block HTML at render time
- An `npm` + `@wordpress/scripts` build for the two editor-sidebar panels above
- Plain (no-build-required) CSS/JS files for everything else

## How to use it

Just ask, in the same session:

> "Create a new FSE theme called **XYZ**, author **Jane Doe**."

Claude will derive the slug, PHP namespace, constant prefix, and everything else from the name, generate the theme folder, and report back the result. You don't need to know what a "namespace" or "constant prefix" is — that's the whole point.

## After it's generated

```bash
cd wp-content/themes/<your-theme-slug>
npm install
npm run build
```

That's the only terminal step. Everything else — colors, text, images, page layout, new sections — happens in **WordPress Appearance → Editor**, visually.

### Where do I put custom CSS?

- `assets/css/style.min.css` — the live site. There's a marker comment near the bottom of the file showing where to add your own rules.
- `assets/css/editor.min.css` — same rules, so the Block/Site Editor *preview* matches the live site. (Only needed if you want what you see in the editor to exactly match the frontend.)

No Sass/build step for CSS — these are plain CSS files, edit and refresh.

### What still needs Claude / PHP knowledge

Anything that isn't "rearrange existing blocks / swap text, images, colors" — e.g. a brand-new repeating card grid, a new custom REST endpoint, a new per-page toggle — is still a PHP change. The scaffold gives you a solid, bug-checked starting architecture; it doesn't remove the need for a developer (or Claude) when you want genuinely new functionality.

## Files in this skill

```
SKILL.md              — instructions Claude follows when this skill runs
README.md             — this file
docs/DEVELOPMENT.md   — architecture reference for whoever (human or Claude)
                         needs to touch the generated theme's PHP later
template/             — the tokenized theme skeleton that gets copied + filled in
```

`docs/DEVELOPMENT.md` is also copied into every generated theme, so it travels with the project.
