# SEO Guides Audit — `SeoGuidesSeeder`

**Date:** 30 Oct 2026 · **File:** `database/seeders/SeoGuidesSeeder.php` (new, untracked) · **Production:** not seeded, not touched.

## 1. What the seeder does

| Item | Value |
|---|---|
| Category | `Category::firstOrCreate(['slug' => 'web-development'], …)`. It reuses the existing category and never renames it. |
| Upsert key | `BlogPost::updateOrCreate(['slug' => …], …)`. One row per slug. |
| Guide 1 | `prix-site-web-maroc-combien-coute-la-creation-d-un-site-internet`, published at fixed `2026-10-30 09:00:00` |
| Guide 2 | `e-commerce-maroc-guide-lancer-boutique-en-ligne`, published at fixed `2026-10-30 10:00:00` |
| Fields written | title, excerpt, content (HTML), meta_title, meta_description, category_id, author `CodeSommet`, status `published`, published_at |
| Fields not written | `featured_image` (stays `NULL`), views and any other column |
| Internal links | Built with `route(name, …, false)`, so they are relative and follow route definitions. |

## 2. Idempotence and isolation test

Run on an **isolated SQLite file** (the session scratchpad `isolated_guides.sqlite`) after `migrate --force` (`test-output/guides-migrate.txt`). Neither `.env` nor `database/database.sqlite` was used.

| State | Rows | Evidence |
|---|---|---|
| 0. Existing 5 articles only | 5 | `test-output/guides-state-0-articles-only.json` |
| 1. First seeder run | 7 (+2 guides) | `guides-state-1-first-run.json`. The 5 existing rows keep the same id, published_at and updated_at. |
| 2. Second seeder run | 7 | `guides-state-2-second-run.json`. Byte-identical to state 1, `updated_at` unchanged (no-op update). **Idempotent.** |
| 3. Run after the G-01 fix | 7 | `guides-state-3-after-G01-fix.json`. Only guide 1 changed (meta_description 157 → 147, updated_at bumped). |

**Conclusions:** re-running is safe. Existing posts are never modified. Dates are fixed, not `now()`, so re-runs don't reorder the blog.

## 3. Findings

| ID | Finding | Severity | Action |
|---|---|---|---|
| G-01 | Guide 1 `meta_description` was 157 characters, above the project's 155 rule (`SeoMetadataTest` convention) | Medium (defect) | **Fixed** to 147 characters: « Site vitrine, e-commerce, plateforme sur mesure : ce qui fait varier le prix d'un site web au Maroc, les coûts récurrents et les questions à poser. » Re-verified in isolated state 3. |
| G-02 | No `featured_image` on either guide. The 5 existing posts also have none in the isolated DB. | Low | Owner to supply 2 cover images (Hostinger blog-cover convention). Not blocking: the blog renders without them. |
| G-03 | Unsourced market statement in guide 2: « Au Maroc, le paiement à la livraison reste très répandu » | Low | General and widely reported, but no source is cited. Owner to keep it, or add a source. |
| G-04 | CMI process paragraph in guide 2 (exact text in `OWNER_DECISIONS.md`) | Low | Process description only, no capability claim. Listed for owner awareness with the e-commerce FAQ. |
| G-05 | 3 pre-existing posts have meta descriptions of 166–169 characters in the isolated DB | Info (pre-existing) | Out of scope. The existing migration `2026_10_28_000001_shorten_blog_post_seo_meta` is named for this purpose. Check on production whether it has run. Not touched. |
| G-06 | The local dev DB (`database/database.sqlite`, untracked, local only) still holds the guides from the implementation session, with the pre-G-01 157-character description (151 characters as rendered in the Selenium run) | Info | Left untouched on purpose (isolated-DB rule). A re-seed applies G-01 automatically, because `updateOrCreate` updates by slug. |
| — | No prices or tariffs in dirhams, no guarantees, no rankings promised | ✔ | The price guide explains cost drivers without inventing figures. |

## 4. Rendered checks (local, Selenium desktop 1440 + mobile 390)

| Guide | Title | H1 | Headings | Robots | Internal links checked (desktop) | Console errors | Overflow |
|---|---|---|---|---|---|---|---|
| Guide 1 (price) | Prix d'un site web au Maroc : ce qui fait le coût | 1 | 14 | index, follow | 36 × 200 | 0 | none |
| Guide 2 (e-commerce) | E-commerce au Maroc : lancer sa boutique en ligne | 1 | 12 | index, follow | 36 × 200 | 0 | none |

Both guides link to `/get-quote`, `/services/ecommerce-website-development`, and each other (guide 1 also links to `/services/seo-maroc`). Screenshots: `screenshots/guide-prix-site-web/`, `screenshots/guide-ecommerce-maroc/`.

## 5. Production procedure (owner runs this after merge to `main`; not executed)

```bash
php artisan db:seed --class=SeoGuidesSeeder --force
php artisan view:clear
```

The seeder needs no migration of its own. If the 2026-10-28 blog meta migration has not run yet on production, run `php artisan migrate --force` first, after a DB backup.
