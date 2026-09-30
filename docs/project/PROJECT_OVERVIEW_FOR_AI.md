# CodeSommet — Full Project Documentation (for AI assistants)

> **Purpose of this file:** give an AI assistant (ChatGPT, Claude, etc.) complete context about this
> codebase in one read — the stack, folder structure, routing, data model, CSS architecture,
> JavaScript architecture, and the SEO tools subsystem — so it can answer questions and write code
> that fits the existing conventions.

---

## 1. What this project is

**CodeSommet** (`codesommet.com`) is a **French-language digital agency website** built with
**Laravel 12 + Blade**. It was originally a static **Next.js export** and has been migrated,
page by page, into Laravel Blade templates.

The site has three distinct halves:

| Part | What it is | Auth |
|---|---|---|
| **Front-office** | Public marketing site: home, about, services, city landing pages, case studies, blog, and 45 free SEO tools | Public |
| **Back-office** | Private admin panel: projects, payments, finance, blog CMS, media library, newsletter, personal budget | Super-admin only |
| **Tools API** | JSON API that powers the SEO tools that need server-side URL fetching | Public (POST) |

**Important context:** the migration goal was an **exact 1:1 clone** of the original static site.
Structure, class names, spacing, animations and fonts were deliberately preserved — the CSS is
**not** meant to be "cleaned up" or refactored. Assume any oddity is intentional fidelity to the
original design unless proven otherwise.

---

## 2. Tech stack

| Layer | Technology |
|---|---|
| Framework | Laravel **12** (PHP **8.2+**) |
| Templating | **Blade** (no Livewire, no Inertia, no Vue/React) |
| Database | **SQLite** (`DB_CONNECTION=sqlite`) |
| Auth | Laravel session auth + `laravel/sanctum` + custom `super_admin` middleware |
| CSS | **Pre-compiled static CSS** in `public/css/` (Tailwind output + hand-written design system) |
| JS | **Vanilla JavaScript**, IIFE modules, no bundler at runtime, no framework |
| Build tooling | Vite + Tailwind v4 are installed, **but the live site does not use them** (see §6) |
| Analytics | Google Analytics (`G-3S8MG2YJ1K`) |
| Booking | Cal.com modal embed |
| Locale | **French only** (`APP_LOCALE=fr`) — no locale prefixes in URLs |

### Key composer packages
`laravel/framework ^12.0`, `laravel/sanctum ^4.0`, `laravel/tinker`.
Dev: `pest`-less — uses **PHPUnit 11**, plus `laravel/pint`, `laravel/pail`, `collision`, `faker`.

---

## 3. Directory structure

```
codesommet.com/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/            ← 10 admin controllers (back-office)
│   │   │   ├── Auth/             ← AdminLoginController
│   │   │   ├── BlogController.php        ← public blog index + show
│   │   │   ├── NewsletterController.php  ← public subscribe
│   │   │   └── ToolsApiController.php    ← the SEO tools API (1300+ lines)
│   │   └── Middleware/SuperAdmin.php
│   ├── Models/                   ← 10 Eloquent models
│   └── Providers/
│
├── bootstrap/app.php             ← Laravel 12 app config, registers `super_admin` alias
│
├── database/
│   ├── migrations/               ← 12 migrations
│   └── seeders/
│
├── lang/
│   ├── fr/                       ← French translation PHP files
│   └── fr.json
│
├── public/                       ← DOCUMENT ROOT
│   ├── css/
│   │   ├── main.css              ← 160 KB — Tailwind build + design tokens + base styles
│   │   ├── components.css        ← 36 KB — hand-written component & animation CSS
│   │   ├── 091f2075115b2b44.css  ← legacy Next.js chunk (kept for reference)
│   │   └── 82815d891246936f.css  ← legacy Next.js chunk
│   ├── js/
│   │   ├── app.js                ← 127 KB — site-wide behaviour (menu, animations, sliders)
│   │   ├── custom-select.js      ← custom <select> replacement widget
│   │   ├── tools-common.js       ← shared tool-page utilities (FAQ, copy, counters)
│   │   └── tools/                ← 24 per-tool scripts + api-tools.js + ai-tools.js
│   ├── fonts/                    ← Inter (woff2), Phudu (woff2), Satoshi (otf)
│   ├── images/ heros/ logos/ mockups/ videos/
│   ├── scripts/google-analytics.js
│   ├── favicon/  robots.txt  site.webmanifest
│   └── index.php                 ← Laravel entry point
│
├── resources/views/              ← 313 Blade files total
│   ├── frontoffice/              ← CURRENT public site (use this)
│   │   ├── layouts/app.blade.php
│   │   ├── partials/             ← header, header-mobile, footer, cal-modal, floating-actions…
│   │   ├── components/           ← breadcrumb, cta-banner, hero-background, newsletter-form
│   │   └── pages/
│   │       ├── home / about / contact / get-quote / our-work / industries / locations / tools
│   │       ├── services/         ← 16 SEO landing pages
│   │       ├── locations/        ← 35 city landing pages
│   │       ├── our-work/         ← 6 case studies
│   │       ├── tools/            ← 45 tool pages
│   │       ├── blog/             ← index, show, preview
│   │       └── legal/            ← 5 legal pages
│   ├── backoffice/               ← CURRENT admin panel (30 Blade files)
│   │   ├── layouts/              ← admin.blade.php, auth.blade.php
│   │   └── pages/                ← auth, blog, budget, categories, finance, media,
│   │                                newsletter, payments, projects, tags
│   ├── layouts/ partials/ pages/ components/   ← ⚠️ LEGACY duplicates, see §11
│
├── routes/
│   ├── web.php                   ← all front + admin routes (190 lines)
│   ├── api.php                   ← single tools API route
│   └── console.php
│
├── _next/                        ← original Next.js build chunks (source material, not served)
├── CLAUDE.md                     ← migration rules for AI agents
└── LOCALIZATION.md
```

---

## 4. Routing (`routes/web.php`)

The site is **French-only** — there are **no locale prefixes** in URLs.

Most public pages are **static views with no controller**, registered with `Route::view()`.

### 4.1 Core public routes

```php
Route::view('/',           'frontoffice.pages.home')->name('home');
Route::view('/about',      'frontoffice.pages.about')->name('about');
Route::view('/contact',    'frontoffice.pages.contact')->name('contact');
Route::view('/get-quote',  'frontoffice.pages.get-quote')->name('get-quote');
Route::view('/our-work',   'frontoffice.pages.our-work')->name('our-work');
Route::view('/industries', 'frontoffice.pages.industries')->name('industries');
Route::view('/locations',  'frontoffice.pages.locations')->name('locations');
Route::view('/tools',      'frontoffice.pages.tools')->name('tools');
```

### 4.2 Legal — `/legal/{page}`
`privacy-policy`, `terms-of-service`, `refund-policy`, `cookie-policy`, `acceptable-use`.

### 4.3 Services — `/services/{slug}` (whitelisted)

A single closure route validates `$slug` against a **hard-coded whitelist array**, then resolves
`frontoffice.pages.services.{slug}`. Anything not in the array → `404`.

16 slugs: `ecommerce-website-development`, `saas-platform-development`,
`fintech-platform-development`, `fintech-website-development`, `healthcare-website-development`,
`education-website-development`, `edtech-platform-development`, `elearning-platform-development`,
`online-course-platform-development`, `university-website-development`,
`language-school-website-development`, `study-abroad-website-development`,
`immigration-consultancy-website-development`, `real-estate-website-development`,
`telemedicine-platform-development`, `telemedicine-website-development`.

### 4.4 Locations — `/web-development-company/{city}` (whitelisted)

Same pattern; resolves `frontoffice.pages.locations.web-development-company-{city}`.

35 cities across Morocco (`casablanca`, `marrakech`, `rabat`, `tangier`), Gulf (`dubai`,
`abudhabi`, `riyadh`, `doha`, `kuwait-city`), Europe (`london`, `amsterdam`, `berlin`, `paris`,
`copenhagen`, `dublin`, `brussels`, `zurich`, `stockholm`, `madrid`, `barcelona`, `lisbon`,
`rome`, `milan`), North America (`new-york`, `san-francisco`, `los-angeles`, `austin`, `seattle`,
`boston`, `chicago`, `denver`, `toronto`, `vancouver`), Africa (`tunis`, `cairo`, `lagos`),
plus `worldwide`.

### 4.5 Tools & case studies — view-existence routing

```php
Route::get('/tools/{slug}',    fn($slug) => view()->exists("frontoffice.pages.tools.$slug")    ? view(...) : abort(404));
Route::get('/our-work/{slug}', fn($slug) => view()->exists("frontoffice.pages.our-work.$slug") ? view(...) : abort(404));
```

No whitelist — **the existence of the Blade file is the whitelist**. Adding a tool page = dropping
a Blade file in the folder.

### 4.6 Blog (controller-driven)

```php
Route::get('/blog',          [BlogController::class, 'index']);
Route::get('/blog/preview',  fn() => view('frontoffice.pages.blog.preview'));
Route::get('/blog/{slug}',   [BlogController::class, 'show']);
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe']);
```

### 4.7 Admin routes

Login is **outside** the guard: `/admin/login` (GET, POST) and `/admin/logout` (POST).

Everything else sits behind `Route::middleware('super_admin')->prefix('admin')->name('admin.')`:

- `GET /admin/dashboard` — DashboardController
- `Route::resource('projects')` + custom POSTs: `update-status`, `update-progress`,
  `add-payment`, `generate-schedule`, `update-phases`
- `Route::resource('payments')` + `GET /projects/{project}/payments`
- **Finance:** `GET /finance`, `POST /finance/expense`, `DELETE /finance/expense/{expense}`
- **Blog:** `Route::resource('blog')` (full CMS)
- **Media library:** `picker`, `index`, `upload`, `update`, `destroy`
- **Newsletter:** `index`, `export`, `destroy`
- **Budget (PIN-locked):** `budget.lock` / `budget.unlock` / `budget.salary` / `budget.start`,
  plus index / store / destroy
- **Taxonomy:** `Route::resource('categories')` and `Route::resource('tags')`, each with an extra
  `POST .../quick` endpoint for inline creation from the blog editor

### 4.8 API route (`routes/api.php`)

```php
Route::post('/tools/{slug}', [ToolsApiController::class, 'handle'])->where('slug', '[a-z0-9-]+');
```

One route for all server-side tools. See §9.

---

## 5. Data model

10 Eloquent models in `app/Models/`, 12 migrations.

| Model | Purpose | Notable fields / behaviour |
|---|---|---|
| **User** | Admin accounts | `is_super_admin` boolean gates the whole admin panel |
| **BlogPost** | Blog CMS | `title, slug, excerpt, content, featured_image, featured_image_alt/caption/description, category_id, author, author_avatar, read_time, meta_title, meta_description, status, published_at`. `belongsTo(Category)`, `belongsToMany(Tag)` |
| **Category** | Blog taxonomy | `name, slug, description, color`. Auto-generates a **collision-free slug** in a `saving` hook via `uniqueSlug()` |
| **Tag** | Blog taxonomy | `name, slug, description`. Same `uniqueSlug()` pattern |
| **Media** | Media library | `uuid, original_name, disk, path, mime_type, size, alt, title`. Auto-assigns a UUID on `creating`; exposes a `url` accessor returning `asset('storage/'.$path)` |
| **Project** | Client projects | Status, progress %, phases, linked payments |
| **Payment** | Project payments | Linked to Project; supports generated payment schedules |
| **Expense** | Business expenses | Used by the Finance module |
| **BudgetEntry** | Personal budget | `entry_date, category, category_label, …` — PIN-locked module |
| **NewsletterSubscriber** | Email list | `email, name, source, ip_address, is_confirmed, subscribed_at, unsubscribed_at`. Has an `active()` scope = confirmed **and** not unsubscribed |

### Auth model

`SuperAdmin` middleware is deliberately minimal:

```php
if (! Auth::check() || ! Auth::user()->is_super_admin) {
    return redirect()->route('admin.login');
}
```

There are no roles or permissions — it's a **single-operator admin panel**.

---

## 6. CSS architecture

> ⚠️ **Critical:** the live site loads **pre-built static CSS from `public/css/`**. It does **not**
> compile Tailwind at runtime. Vite and Tailwind v4 are in `package.json` and `vite.config.js`
> points at `resources/css/app.css`, but that pipeline is **not what the site serves**.
> Editing Tailwind config will **not** change the site. Edit `public/css/*.css` directly.

Two stylesheets are loaded, in this order:

```blade
<link rel="stylesheet" href="{{ asset('css/main.css') }}" />
<link rel="stylesheet" href="{{ asset('css/components.css') }}" />
```

### 6.1 `main.css` (~160 KB, minified)

Contains, in order:
1. A **Tailwind preflight/reset**
2. A **compiled Tailwind utility layer** (all the `.px-4`, `.text-2xl`, `.flex` classes the markup uses)
3. A **`:root` design-token block** (the real design system — see below)
4. **Base element styles** (`h1`–`h6`, `p`, `a`, `body`) wired to the tokens
5. **`@font-face` declarations** for Inter, Phudu, Satoshi with `unicode-range` subsetting

Because it's minified, don't try to read it top-to-bottom. Search for the selector you need.

### 6.2 Design tokens (`:root`)

**Colours** — note the variable names are historical; `--color-primary-orange` is actually **cyan/blue**:

```css
--color-white: #FFFFFF;          --color-black: #0F0F0F;
--color-gray-50: #F7F9FC;        --color-gray-100: #EFF3F9;   --color-gray-200: #E1E8F0;
--color-primary-orange: #00AEEF;  /* brand cyan — the primary accent */
--color-orange-hover:  #0071BC;   /* darker blue hover */
--color-purple:        #7D53FF;   /* secondary accent */

--text-primary:   var(--color-black);
--text-secondary: rgba(15,15,15,0.7);
--text-tertiary:  rgba(15,15,15,0.5);
--text-accent:    var(--color-primary-orange);

--bg-primary: #FFFFFF;  --bg-secondary: #F7F9FC;  --bg-tertiary: #EFF3F9;

--border-light: rgba(15,15,15,0.08);
--border-default: rgba(15,15,15,0.12);
--border-strong: rgba(15,15,15,0.24);

--color-success: #22C55E;  --color-warning: #F59E0B;  --color-error: #EF4444;
```

**Spacing** — `--space-0` … `--space-24`, where `--space-1: 0.5rem` and `--space-2: 1rem`
(so the scale is **2× the Tailwind scale**).

**Layout** — `--container-max: 1280px`, `--container-padding: var(--space-6)`,
`--section-padding-y: var(--space-16)`, `--gutter: var(--space-4)`.

**Radii** — `--radius-xs .25rem`, `sm .5rem`, `md .75rem`, `lg 1rem`, `--radius-full 9999px`.

**Typography** — a **1.25 major-third modular scale**:

```css
--font-body:    var(--font-inter),   "Inter", sans-serif;
--font-heading: var(--font-satoshi), "Satoshi", sans-serif;
--font-display: var(--font-phudu),   "Phudu", sans-serif;
--font-mono:    "SF Mono", Monaco, Inconsolata, "Courier New", monospace;

--text-xs .75rem  --text-sm .875rem  --text-base 1rem   --text-lg 1.125rem
--text-xl 1.25rem --text-2xl 1.563rem --text-3xl 1.953rem --text-4xl 2.441rem
--text-5xl 3.052rem --text-6xl 3.815rem --text-7xl 4.768rem

--font-regular 400  --font-medium 500  --font-semibold 600  --font-bold 700
--leading-none 1 … --leading-loose 2
--tracking-tighter -0.05em … --tracking-widest 0.1em
```

**Motion** — `--transition-75/150/200/300/500`, easing curves `--ease-in/out/in-out`, and
composite shorthands `--transition-colors`, `--transition-transform`, `--transition-all`.

**Dark mode** — a `[data-theme=dark]` block redefines the colour and shadow tokens
(`--bg-primary: #0F0F0F`, `--text-primary: #F8F8F8`, heavier shadows). Dark mode is
**token-ready but not exposed via a UI toggle** on the public site.

### 6.3 `components.css` (~36 KB, readable & commented)

This is the **hand-written** file — the one you'll usually edit. Sections, in file order:

- CSS custom properties (a second, narrower token block)
- `@font-face` overrides, smooth scroll
- **Marquee animations** — CTA banner, CTA pill marquee (tripled items, `-33.333% → 0%`)
- **Ping** animation (green dot in badges)
- **Hero image fade-in** on page load
- **Scroll-driven entrance animations** + stagger delay classes + legacy `opacity:0` support
  + a `prefers-reduced-motion` block
- **Logo scroll** — infinite horizontal marquee
- **Hero text rotation**, **float** (hero image), **shine** (CTA buttons), **pulse**
- **Hero work-showcase carousel**, **scroll-left / scroll-right** feature carousels
- **Process-step card spin icon**
- **Flip card** ("6 Common Problems") — hover-flip on desktop, JS class-toggle tap-flip on mobile
- **Testimonial card** hover animation + hidden scrollbar for horizontal scroll
- **Cal.com booking modal**
- **Premium features hover tooltip**
- A **white-text override fix** (global `h1`–`h6`/`p` colour rules in `main.css` otherwise beat
  `.text-white` containers)
- **Preloader**
- **Blog content typography** (the long-form article styles) + responsive block
- **Promo banners**, **anchor hover colour guard**
- **Custom select (`cs-select`)** — trigger, placeholder, chevron, panel, portal-escape for
  clipping ancestors, drop-up when no room below, scrollbar styling

---

## 7. JavaScript architecture

**No framework, no bundler at runtime, no modules.** Every file is a **self-executing IIFE**
(`(function(){ 'use strict'; … })();`) loaded with plain `<script>` tags. State lives in the DOM.

### 7.1 `public/js/app.js` (~127 KB, ~208 functions)

Loaded with `defer` on every front-office page. Header comment:
`"CodeSommet – Core JavaScript / Handles: mobile menu, scroll animations, header scroll behavior, Cal.com"`.

Responsibilities:

1. **Mobile menu toggle** — open/close, close on link click, close on `Escape`, close on outside click
2. **Header scroll behaviour** — style changes as the page scrolls
3. **Hero image fade-in** on load
4. **Scroll-driven entrance animations** — the most interesting part. Rather than requiring
   authors to hand-tag elements, `app.js` **auto-detects what to animate** by walking the DOM and
   classifying nodes:
   - skips anything inside a continuously animated container (marquee, logo scroll)
   - skips the hero (first section)
   - §1 section headings (centred vs left-aligned in `space-y` containers)
   - §2 two-column layouts → **directional** fades (left/right), unless it's really a card grid
   - §3 card grids → **staggered** fade-up
   - §4 standalone CTA / large rounded blocks with buttons
   - §5 legacy inline `style="opacity:0"` elements from earlier edits
   - then reveals everything via a single **`IntersectionObserver`**
5. **Process-steps interactive cards** (desktop) — a scripted, cursor-driven demo:
   - Step 1: cards enter → fake cursor moves to "Book your Slot" → clicks → cards flip to "done"
   - Step 2: cursor grabs the "Urgent" item and drags it to the top, pushing the others down by
     exactly one slot (uses `offsetTop`, **not** `getBoundingClientRect`, because the list has a
     CSS `rotate` transform that would corrupt rect maths)
   - Step 3: cursor visits each checkbox in sequence and checks it
   - Hover/click handlers plus **auto-rotate every 5 s**
6. **Mobile process steps** — the same three animations, re-implemented as a **looping** version,
   only run when the mobile section is actually visible
7. Cal.com modal wiring, sliders/carousels, FAQ toggles, and the rest of the site interactions

### 7.2 `public/js/custom-select.js`

A custom dropdown widget (`cs-select`). The native `<select>` is kept in the DOM — hidden but
script-focusable — so **form submission still carries real form data**. Styles live in the
"Custom Select" section of `components.css`.

### 7.3 `public/js/tools-common.js`

Shared across all 45 tool pages. Opens with a notable **`DOMContentLoaded` polyfill**: it monkey-
patches `document.addEventListener` so that a `DOMContentLoaded` handler registered *after* the
document is already parsed still fires (via `setTimeout(fn, 0)`). This exists because tool scripts
are deferred body scripts and would otherwise silently never run.

Also provides: FAQ accordion (located by finding the `<h3>` whose text is
`"Frequently Asked Questions"`, then walking to the nearest card container), usage counters,
copy-to-clipboard, download helpers, and tab switching.

### 7.4 `public/js/tools/` — 24 files

- **`api-tools.js`** — the shared driver for the **20 server-dependent tools**. It holds a
  `TOOL_CONFIG` map (slug → `{title, action, actionText, inputLabel, inputPlaceholder}`),
  **auto-detects the current tool slug from the page**, renders the right input UI, POSTs to
  `/api/tools/{slug}`, and renders the JSON response.
- **`ai-tools.js`** — driver for the generator-style tools.
- **21 single-purpose scripts** — for tools that run **entirely client-side** and need no server:
  `base64-encoder`, `color-palette-generator`, `css-minifier`, `duplicate-content-checker`,
  `faq-schema-generator`, `hreflang-generator`, `html-minifier`, `html-to-text`, `json-formatter`,
  `local-business-schema`, `lorem-ipsum-generator`, `meta-refresh-generator`,
  `nofollow-link-checker`, `qr-code-generator`, `readability-analyzer`, `robots-txt-generator`,
  `schema-generator`, `text-case-converter`, `url-slug-generator`, `utm-builder`,
  `word-counter`, `xml-sitemap-generator`.

---

## 8. Blade / layout system

### 8.1 Master layout — `resources/views/frontoffice/layouts/app.blade.php`

`<html lang="fr" dir="ltr">`. Provides a full SEO head driven entirely by `@yield` with sensible
French defaults:

| Section | Yields |
|---|---|
| Meta | `title`, `meta_description`, `meta_keywords` |
| Open Graph | `og_title`, `og_description`, `og_url`, `og_image`, `og_image_alt` |
| Twitter | `twitter_title`, `twitter_description`, `twitter_image` (card = `summary_large_image`) |
| Canonical | `canonical` (defaults to `url()->current()`) |
| Schema | `structured_data` (per-page JSON-LD) |
| Extensibility | `@stack('head')` and `@stack('scripts')` |

It also hard-codes a global **Organization JSON-LD** block (name, logo, `sameAs` social profiles,
`contactPoint` with phone/email and `availableLanguage: [English, French, Arabic]`).

> **Blade gotcha:** inside `<script type="application/ld+json">`, JSON-LD keys must be escaped as
> `@@context` / `@@type`, and Twitter handles as `@@code_sommet`, because a single `@` is Blade
> directive syntax.

Body order: preloader → `header` → `header-mobile` → `<main>@yield('content')</main>` → `footer`
→ `cal-modal` → `floating-actions` → `app.js` → `custom-select.js` → preloader-dismiss inline
script → Google Analytics → `@stack('scripts')`.

### 8.2 Partials — `frontoffice/partials/`
`header`, `header-mobile`, `footer`, `cal-modal`, `floating-actions` (WhatsApp + back-to-top),
`home-sections`, `home-testimonials`, `location-process-steps`.

Desktop and mobile headers are **two separate partials**, both always rendered, toggled by CSS.

### 8.3 Components — `frontoffice/components/`
`breadcrumb`, `cta-banner`, `hero-background`, `newsletter-form`.

### 8.4 Back-office layouts — `backoffice/layouts/`
`admin.blade.php` (the panel shell) and `auth.blade.php` (the login screen).

### 8.5 Repeated section patterns

The 90+ marketing pages are built from a small set of recurring sections. Approximate counts:
**FAQ** (~86 pages), **Why Choose Us** (~49), **CTA Footer** (~47), **Related Tools** (~42),
**Hero** (38+), **Stats Bar** (~38). Changing one of these means touching many files — grep for
the section's distinctive class or heading rather than editing page by page.

---

## 9. The SEO tools subsystem (the most complex part)

45 free SEO tools live at `/tools/{slug}`. They split into two categories.

### 9.1 Client-side tools (~25)

Run fully in the browser. No network call. Each has a dedicated script in `public/js/tools/`.
Examples: JSON formatter, CSS/HTML minifiers, Base64 encoder, QR code generator, UTM builder,
schema generators, lorem ipsum, word counter, text case converter, colour palette generator.

### 9.2 Server-dependent tools (~20)

These must fetch a third-party URL, which the browser can't do because of CORS — so Laravel acts
as a **fetch proxy and analyser**.

**Flow:**

```
Blade tool page
   → public/js/tools/api-tools.js  (detects slug, builds UI, POSTs JSON)
      → POST /api/tools/{slug}
         → ToolsApiController@handle
            → dispatches to handle{StudlySlug}()      e.g. website-analyzer → handleWebsiteAnalyzer
               → fetchUrl()  (Guzzle via Http facade, 15 s timeout, custom UA)
               → regex/DOM analysis
               → JsonResponse
```

**The dispatcher** (`ToolsApiController::handle`) converts the slug to a method name and calls it
dynamically:

```php
$method = 'handle' . str_replace('-', '', ucwords($slug, '-'));
if (method_exists($this, $method)) {
    try { return $this->$method($request); }
    catch (\Throwable $e) {
        Log::error("Tool API error [{$slug}]: " . $e->getMessage());
        return response()->json(['error' => 'Analysis failed: '.$e->getMessage()], 500);
    }
}
return response()->json(['error' => 'Tool not found'], 404);
```

> **To add a server-side tool:** add a `handleYourToolName()` method, add the slug to
> `TOOL_CONFIG` in `api-tools.js`, and create the Blade page. No route changes needed.

**Two private helpers** back every handler:
- `fetchUrl(string $url, int $timeout = 15)` — sends a `CodeSommetBot/1.0` User-Agent and an
  HTML `Accept` header; throws on non-2xx.
- `normalizeUrl(string $url)` — prepends `https://` when the scheme is missing.

**Implemented handlers** (26 methods, ~1300 lines):
`handleWebsiteAnalyzer` (a 70+ check audit that accumulates `$score` / `$maxScore`),
`handleHeadingAnalyzer`, `handleKeywordDensityAnalyzer`, `handleBrokenLinkChecker`,
`handleRedirectChecker`, `handleOgPreviewGenerator`, `handleSslCertificateChecker`,
`handleCanonicalChecker`, `handleImageAltAnalyzer`, `handleDomainHealthChecker`,
`handleInternalLinkAnalyzer`, `handleRobotsValidator`, `handleSitemapValidator`,
`handleWebsiteReadinessChecker`, `handleDomainAuthorityChecker`, `handleMobileFriendlyTest`,
`handleCoreWebVitalsChecker`, `handlePageSpeedAnalyzer`, `handleImageCompressionAnalyzer`,
`handleBacklinkChecker`, `handleBlogTitleGenerator`, `handleChatbotScriptGenerator`,
`handleLandingPageGenerator`, `handleMetaTagGenerator`, `handleColorPaletteGenerator`.

**Note:** HTML parsing is done with **regular expressions** (e.g.
`preg_match('/<title[^>]*>(.*?)<\/title>/is', $html, $m)`), not a DOM parser.

---

## 10. Fonts & assets

Three families, all self-hosted in `public/fonts/`:

| Family | Role | Format | Files |
|---|---|---|---|
| **Inter** | Body text (`--font-body`) | woff2 | 7 subsets: latin, latin-ext, cyrillic, cyrillic-ext, greek, greek-ext, vietnamese |
| **Phudu** | Display (`--font-display`) | woff2 | 4 subsets: latin, latin-ext, cyrillic-ext, vietnamese |
| **Satoshi** | Headings (`--font-heading`) | **otf** | regular, medium, bold |

Inter and Phudu use `unicode-range` subsetting with `font-display: swap`. Satoshi is `.otf`
(heavier than woff2) — a known, accepted trade-off from the original design.

**Always reference assets through `{{ asset('...') }}`.** Never emit `/_next/...` paths — the
`_next/` folder is kept only as source material for the migration.

---

## 11. ⚠️ Known state: duplicated view trees

`resources/views/` currently contains **two parallel copies** of the site:

| Legacy (older) | Current (canonical) |
|---|---|
| `resources/views/layouts/` | `resources/views/frontoffice/layouts/` + `backoffice/layouts/` |
| `resources/views/partials/` | `resources/views/frontoffice/partials/` |
| `resources/views/components/` | `resources/views/frontoffice/components/` |
| `resources/views/pages/` | `resources/views/frontoffice/pages/` |
| `resources/views/pages/admin/` | `resources/views/backoffice/pages/` |

**`routes/web.php` points exclusively at `frontoffice.*` and the admin controllers render
`backoffice.*`.** The bare `layouts/`, `partials/`, `pages/`, `components/` folders are **leftovers
from a folder-restructure that is still in progress** (see recent commits: *"big update
folderstrucutre"*, *"new update fixed some sections remain"*).

> **Rule for any AI working here: always edit the `frontoffice/` or `backoffice/` copy.**
> Editing the legacy path will appear to do nothing on the live site.

Related in-flight work visible in `git status`: the original root `.html` files and the `lang/en/`
translation tree are being deleted (English → French-only migration), and a `HomeAd`
model/controller/migration was removed.

---

## 12. Common commands

```bash
php artisan serve             # local dev server (http://localhost:8000)
php artisan route:list        # list all routes
php artisan view:clear        # clear compiled Blade views
php artisan migrate           # run migrations (SQLite)
php artisan tinker            # REPL

composer setup                # install + key:generate + migrate + npm install + build
composer dev                  # concurrently: serve + queue:listen + pail + vite
composer test                 # config:clear + artisan test (PHPUnit 11)
./vendor/bin/pint             # code style
```

---

## 13. Conventions & rules for editing this codebase

1. **This was an exact-clone migration.** Do not redesign, simplify, or "modernise" markup, CSS,
   or animations. Fidelity to the original beats cleanliness.
2. **Don't rename classes** — `app.js` auto-detects animation targets by structure and class
   names, so renames silently break scroll animations.
3. **Don't remove wrapper `<div>`s** — many exist purely for layout or as JS query anchors.
4. **CSS goes in `public/css/components.css`** (hand-written, commented). Only touch `main.css`
   for design tokens or `@font-face`. **Do not** expect Tailwind config changes to take effect.
5. **JS goes in `public/js/app.js`** (site-wide) or a dedicated file in `public/js/tools/`.
   Match the existing IIFE + `'use strict'` style; no ES modules, no imports.
6. **All assets via `{{ asset() }}`.** Never reference `/_next/`.
7. **French only.** UI copy, comments in Blade, and meta text are French. There is no locale
   routing to preserve.
8. **Escape `@` in Blade** as `@@` inside JSON-LD and Twitter handles.
9. **Adding a service or city page** requires two edits: the Blade file **and** the whitelist array
   in `routes/web.php`. Adding a **tool** or **case study** requires only the Blade file.
10. **Fonts are exact** — Inter, Phudu, Satoshi. Never substitute similar fonts.

---

## 14. Quick reference — where to look

| I need to… | Go to |
|---|---|
| Add/change a public page | `resources/views/frontoffice/pages/` |
| Change nav or footer | `resources/views/frontoffice/partials/` |
| Change site-wide `<head>` / SEO defaults | `resources/views/frontoffice/layouts/app.blade.php` |
| Change colours, spacing, typography | `:root` block in `public/css/main.css` |
| Add component styles or animations | `public/css/components.css` |
| Change scroll animations / menu / sliders | `public/js/app.js` |
| Add a client-side tool | new file in `public/js/tools/` + Blade page |
| Add a server-side tool | `handleX()` in `ToolsApiController` + `TOOL_CONFIG` in `api-tools.js` + Blade page |
| Add a route | `routes/web.php` (remember the whitelist arrays) |
| Change admin behaviour | `app/Http/Controllers/Admin/` + `resources/views/backoffice/` |
| Change the data model | `app/Models/` + a new migration in `database/migrations/` |
