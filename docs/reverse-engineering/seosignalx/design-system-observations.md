# Design-system observations

The purpose is to understand the interface **patterns**, not to copy the look. Our build uses the codesommet design system (see project memory, "Design System & Replication Skill"). Brand colours, logos and illustrations of the reference must not be reused.

Confidence: **Measured** = `getComputedStyle` via Selenium (`raw-observations/marketing.json`, `app-shell.json`). **Visual** = estimated from screenshots.

## 1. Two visual systems

The site runs two distinct visual languages.

| Surface | Look | Where |
|---|---|---|
| Marketing | Near-black background, orange gradient accents, large tight headlines, glass cards | `/`, `/lifetime-deal`, `/login`, `/register` |
| App, "dark tool" | Same near-black, an orange active state in the sidebar, dark bordered cards, a radar chart and stat cards | `/tech-seo/*`, `/on-page/*`, `/keywords/*`, `/seo-tools/*` |
| App, "GEO tool" | **Indigo/violet gradient hero, white cards, green pill badges, a solid indigo primary button** | `/geo/*` (e.g. `06-tool-results/geo-ai-model-checker-valid-desktop.png`) |
| App, "utility" | Coloured gradient header banner, coloured icon tiles, coloured gradient "Go to Tool" pills | `/seo-tools` (`04-seo-tools/seo-tools-desktop.png`) |

**Inferred:** the sections were built at different times and the theme was not unified. Implication: **define one system first** (Phase A) so we don't repeat this.

## 2. Tokens (marketing, measured)

| Token | Value | Conf. |
|---|---|---|
| Page background | `rgb(8,8,11)` (Tailwind `ink-900`) | Measured |
| Body text | white; muted paragraph `rgba(255,255,255,.65)`, 18/28 | Measured |
| Font | Inter (Google Fonts, 300–900), fallback `ui-sans-serif, system-ui` | Measured |
| H1 | 88px / 88px, weight 700, letter-spacing −2.2px (desktop) | Measured |
| H2 | 48px / 48px, weight 700, letter-spacing −1.2px | Measured |
| Primary CTA | pill (`radius 9999px`), padding 14×28, 16px/600, `linear-gradient(135deg, #FB923C → #EA580C)`, glow `0 10px 40px -10px rgba(249,115,22,.55)` | Measured |
| Small CTA | pill, 8×16, 14px/600, `linear-gradient(to right, #F97316, #EA580C)` | Measured |
| Card | `rgba(13,13,18,.8)`, 1px `rgba(255,255,255,.1)` border, radius 16px | Measured |
| Header | sticky, `rgba(8,8,11,.85)` with backdrop blur (visual) | Measured bg; Visual blur |
| Light theme variables | `--lt-surface #fff`, `--lt-surface-2 #f6f8fb`, `--lt-border #dbe3ec`, `--lt-ink #0b223d`, `--lt-shadow 0 1px 2px #0f27470d, 0 8px 24px -12px #0f274724` | Measured (`:root`) |
| Colour scales in use | `ink-700…900`, `brand-300…600` (orange), `amber-400/500` | Measured (class names) |
| Breakpoints | Tailwind defaults `sm 640`, `md 768`, `lg 1024` | Measured (class prefixes) |

## 3. App shell anatomy

```
┌──────┬───────────────┬──────────────────────────────────────────────────────────┐
│ icon │ SECTION       │ [◉ Select website ▾] › Section › Tool  [Patches 0] [Share│
│ rail │ sidebar       │  report] [🔍 Search check points…] [☾] [Login]           │
│ 12   │ groups +      ├──────────────────────────────────────────────────────────┤
│ items│ tool links    │  URL bar  [Analyze] [Export CSV]                         │
│      │ (active =     │  Title + score visual (radar / gauge)                    │
│      │  orange tint) │  [PASSED] [FAILED] [UNKNOWN] [AUTOMATED] stat cards      │
│      │               │  Grouped check list / result table                       │
└──────┴───────────────┴──────────────────────────────────────────────────────────┘
```

- **Icon rail** (Measured 92px wide): Dashboard, Site Audit, GSC Insights, Technical SEO, On-Page SEO, Off-Page SEO, Keyword Research, Content Creation, Semantic SEO, Schema SEO, Local SEO, SEO Tools and GEO. The active item has an orange-tinted tile.
- **Section sidebar** (Measured 232px; hidden below the `lg` breakpoint): uppercase group labels (e.g. TECHNICAL SEO, SEARCH CONSOLE, CONTENT & LINKS) with a Lucide icon plus the tool name. GEO adds a promo card ("AI-Powered GEO").
- **Top bar:** website selector (global project context), breadcrumbs, a Patches counter (WordPress plugin fixes), Share report, a contextual search ("Search check points…" on audits, "Search tools…" on the hub), a theme toggle ("Switch to blue light theme") and Login.
- Measured geometry at 1440/1024/768/390 is in `raw-observations/app-shell.json` (see §7).

## 4. Components observed

| Component | Notes | Evidence |
|---|---|---|
| URL bar | Globe icon, wide input, primary action on the right, secondary Export | `05-tool-inputs/tech-seo-eeat-input-desktop.png` |
| Disabled-until-valid action | The primary button is disabled while the input is empty | test-matrix rows `action-disabled-until-input` |
| Radar chart | The four E-E-A-T axes with the score in the centre (/100) | `04-seo-tools/tech-seo-eeat-desktop.png` |
| Score gauge | "90/100 GOOD — Crawlability score" | Crawl Optimization result |
| Stat cards | Four cards: PASSED (green), FAILED (red), UNKNOWN (yellow), AUTOMATED (orange), each with a dot, big number and caption | E-E-A-T |
| Grouped check list | Group header with "x/y passed", rows of check name + finding | E-E-A-T, Crawl Optimization |
| Result table | Header row, avatar-letter badge per row, status pill ("Allowed" in green), monospace codes | AI Model Checker |
| Tabs / segmented control | URL / Text modes; 1-gram / 2-gram / 3-gram | NLP, N-Grams |
| Chips | Example topics that fill the input in one click | Grammar, Skip-gram, Unique n-grams |
| Paywall card | Lock, "X is a paid feature", description, **Upgrade to unlock** + **Sign in** | `/content/content-writer` |
| Connect card | "Connect Google Search Console" with an explanation of read-only scope | `/keywords/*` |
| Loading | Full-screen centred spinner (orange arc) + "Loading…" during auth resolution, shown on every gated route before the redirect to `/login` | Observed during the route crawl (screenshot not retained) |
| Empty state | Icon + title + one-line hint ("Start Your Keyword Research…") | `/keywords/research` |
| Tool hub card | Gradient icon tile, title, coloured "Go to Tool ›" pill | `/seo-tools` |
| Pricing card | Plan, tagline, price, ✓/✕ feature list, CTA; "MOST POPULAR" badge; Monthly/Yearly toggle with a "−20%" badge | `07-pricing/*` |
| FAQ accordion | Question rows with a ⊕ icon, one open at a time (Visual) | `01-homepage/home-faq-expanded-desktop.png` |

## 5. Responsive behaviour

| Width | Observation | Evidence |
|---|---|---|
| 390 (marketing) | Hamburger; hero H1 wraps to 4 lines; CTAs stack | `09-mobile/home-mobile.png` |
| 768 (app) | The section sidebar is hidden and only the 92px rail remains | `02-navigation/app-shell-seo-tools-768.png` |
| 390 (app) | The audit URL input is measured at **0px wide**. The **icon rail stays visible** (92px) and the section sidebar collapses behind a ☰ button in the rail. The **top bar overflows** (the search field is cut off at the right edge) and cards go single-column. | `02-navigation/seo-tools-mobile-menu-open.png`, `09-mobile/*` |

**Recommendation for our build:** on mobile, hide the rail behind a bottom sheet or drawer and move the website selector into it.

## 6. Accessibility observations

- Inputs have **no `name`** and mostly no `aria-label` (placeholders only), except the Watermark textarea (`aria-label="Original text"`). Evidence: `inputs` in `pages.json`.
- Icon-only buttons use `aria-label` ("Open section menu", "Switch to blue light theme").
- 20 of 135 public `<img>` elements have no alt text.
- No `<footer>` landmark in the app shell. `<main>` and `<nav>` are present.
- Keyboard and focus order were not audited (**not verified**).

## 7. App-shell measurements

See `raw-observations/app-shell.json`. A summary is added below by the research run.

<!-- app-shell:start -->
Measured at viewport widths 1440, 1024, 768 and 390 (the CSS viewport is about 26px narrower because of the scrollbar).

| Element | 1440 | 1024 | 768 | 390 |
|---|---|---|---|---|
| Icon rail | 92px, `rgba(8,8,11,.95)` | 92px | 92px | 92px (**still visible**) |
| Section sidebar | 232px at x=92, `rgba(8,8,11,.6)` | 232px | **hidden** (behind the rail's ☰) | hidden |
| Top bar | 56px high, `rgba(8,8,11,.8)` | 56px | 56px | 56px, only 298px wide (overflows) |
| Tool H1 | 24/32 (hub) and 30/36 (audit), weight **900**, white | same | same | same |
| Tool card (hub) | 328×187, radius 16, `rgb(13,17,23)`, border `rgba(255,255,255,.08)` | 308×187 | 296×187 | full width |
| Primary action (audit) | 120×40, radius 12, `linear-gradient(to right, #F97316, #F59E0B)` | same | same | same |
| URL input (audit) | 689px | 289px | 255px | **0px: the input collapses and is unusable** |

Other states captured:

- **Light theme.** "Switch to blue light theme" adds `theme-blue` to `<html>` and the body becomes `rgba(255,255,255,.97)`. Screenshot: `02-navigation/app-shell-light-theme-desktop.png`.
- **Website selector (anonymous).** Dropdown with "YOUR WEBSITES · No websites yet. · + Add New Project". Screenshot: `02-navigation/app-website-selector-open-desktop.png`.
- **Tool search.** Typing "sitemap" in the hub's "Search tools…" field filtered nothing and showed no dropdown within 1.2 s. Screenshot: `02-navigation/app-tool-search-sitemap-desktop.png`. Whether it needs Enter or has a longer delay is **not verified**.
- **Marketing mobile menu.** The hamburger opens a full menu (Features, Lifetime Deal, Pricing, Help, Desktop App, Free SEO Audit, Theme, Sign in, Get Started). Screenshot: `02-navigation/home-mobile-menu-open.png`.
- Tablet layouts: `02-navigation/app-shell-*-1024.png`, `app-shell-*-768.png`.
<!-- app-shell:end -->
