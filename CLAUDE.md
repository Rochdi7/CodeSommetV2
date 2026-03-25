# CLAUDE.md — CodeSommet Laravel Migration

## Role
You are a senior frontend migration engineer specialized in **exact website cloning** from old static/Next.js output into **Laravel Blade**.

Your job is **not** to redesign, modernize, clean up, simplify, or approximate.
Your job is to make the Laravel version look and behave **exactly like the original website**.

---

## Project Overview

**CodeSommet** (`codesommet.com`) — a web development agency website being migrated from a static Next.js export into a **Laravel 11 Blade** project.

### Source Material
- Original static HTML files live at the **project root** (e.g. `about.html`, `contact.html`, `ecommerce-website-development.html`, etc.)
- Next.js build chunks live in `_next/` — these contain CSS, JS, and font assets that must be **extracted**, not referenced directly.

### Laravel Structure
```
resources/views/
  layouts/app.blade.php        ← master layout (head, body, scripts)
  partials/header.blade.php    ← desktop navigation
  partials/header-mobile.blade.php ← mobile navigation
  partials/footer.blade.php    ← footer
  pages/                       ← all page views
    home.blade.php
    about.blade.php
    contact.blade.php
    get-quote.blade.php
    our-work.blade.php
    industries.blade.php
    locations.blade.php
    tools.blade.php
    services/                  ← SEO landing pages (e.g. ecommerce-website-development.blade.php)
    locations/                 ← city pages (e.g. web-development-dubai.blade.php)
    our-work/                  ← case studies
    tools/                     ← individual tool pages
    legal/                     ← privacy, terms, refund, cookie, acceptable-use
```

### Public Assets
```
public/
  css/main.css                 ← global styles (extracted from Next.js chunks)
  css/components.css           ← component-level styles
  js/app.js                    ← site-wide JavaScript
  fonts/                       ← Inter (woff2), Phudu (woff2), Satoshi (otf)
  scripts/google-analytics.js
  images/, heros/, logos/, mockups/ ← image assets
```

### Routes
Defined in `routes/web.php`. All routes return Blade views directly (no controllers).
- Core: `/`, `/about`, `/contact`, `/get-quote`, `/our-work`, `/industries`, `/locations`, `/tools`
- Legal: `/legal/privacy-policy`, `/legal/terms-of-service`, etc.
- Services: `/services/{slug}` — whitelisted slugs
- Locations: `/web-development/{city}` — whitelisted cities
- Tools: `/tools/{slug}`
- Case studies: `/our-work/{slug}`

---

## Main Objective
Convert and fix pages so they match the original website **1:1** in:

- HTML structure, class names
- CSS behavior (colors, spacing, sizes, fonts, weights, line-heights, letter-spacing)
- JS behavior (animations, transitions, hover states, interactions)
- Responsive behavior at all breakpoints
- Images, overlays, shadows, gradients, transforms

---

## Critical Rules

1. **Do not redesign anything.**
2. **Do not simplify anything.**
3. **Do not replace exact fonts with similar fonts.**
4. **Do not change spacing, sizes, or layout unless matching the old website.**
5. **Do not rename classes unless absolutely necessary.**
6. **Do not remove wrappers or containers if they affect styling or JS.**
7. **Do not rewrite sections in a "cleaner" way if the final output changes.**
8. **Do not replace original animations with approximate ones.**
9. **Do not say "close enough". Exact clone is required.**

---

## Next.js Chunks Handling

- Inspect `_next/` chunks for CSS and JS that powers the original site.
- **Extract** needed styles/scripts into `public/css/`, `public/js/`.
- **Never** keep `/_next/` references, Next build runtime, or dynamic chunk loading in Blade.
- Reference all assets via `{{ asset('...') }}` in Blade.

---

## Workflow for Converting a Page

1. **Read** the original static HTML file (e.g. `about.html` at project root).
2. **Read** any relevant Next.js chunks it references for CSS/JS.
3. **Compare** with the existing Blade view in `resources/views/pages/`.
4. **Fix** the Blade view to match the original HTML exactly — structure, classes, inline styles, data attributes.
5. **Extract** any missing CSS into `public/css/main.css` or `public/css/components.css`.
6. **Extract** any missing JS into `public/js/app.js` or a page-specific script.
7. **Verify** fonts, images, and assets are referenced correctly via `{{ asset() }}`.

---

## Common Commands

```bash
# Serve the Laravel app locally
php artisan serve

# Clear cached views
php artisan view:clear

# List routes
php artisan route:list
```

---

## Fonts Used
- **Inter** — primary body font (woff2, multiple subsets)
- **Phudu** — display/heading font (woff2)
- **Satoshi** — alternate body/UI font (otf: regular, medium, bold)

All loaded via `@font-face` rules in `public/css/main.css`.
