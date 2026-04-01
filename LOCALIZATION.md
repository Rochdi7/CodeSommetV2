# Localization System — Pikasso Studio (pikassostudio.com)

## Overview

This Laravel 11 front-office website has been set up with **URL-prefix multilingual routing** for SEO-optimized translations using `mcamara/laravel-localization` v2.4.

## Languages

| Language | Code | URL Prefix | Example |
|----------|------|------------|---------|
| French (default) | `fr` | None (hidden) | `/about`, `/contact`, `/tools` |
| English | `en` | `/en/` | `/en/about`, `/en/contact`, `/en/tools` |

**French is the default language.** The `/fr/` prefix is hidden from URLs — visiting `/about` serves French, visiting `/en/about` serves English.

## Architecture

### Package
- **`mcamara/laravel-localization`** — handles locale detection, URL prefix routing, localized URL generation, hreflang helpers.

### Key Config Files
- `config/laravellocalization.php` — supported locales (`fr`, `en`), `hideDefaultLocaleInURL: true`, ignored URLs (`/admin/*`, `/api/*`)
- `config/app.php` — `locale: fr`, `fallback_locale: fr`
- `.env` — `APP_LOCALE=fr`, `APP_FALLBACK_LOCALE=fr`

### Middleware (registered in `bootstrap/app.php`)
```php
'localize'              => LaravelLocalizationRoutes::class,
'localizationRedirect'  => LaravelLocalizationRedirectFilter::class,
'localeSessionRedirect' => LocaleSessionRedirect::class,
'localeViewPath'        => LaravelLocalizationViewPath::class,
```

### Route Structure (`routes/web.php`)
All front-office routes are wrapped in a locale group:
```php
Route::group([
    'prefix'     => LaravelLocalization::setLocale(),
    'middleware' => ['localize', 'localizationRedirect', 'localeSessionRedirect'],
], function () {
    Route::view('/', 'frontoffice.pages.home')->name('home');
    Route::view('/about', 'frontoffice.pages.about')->name('about');
    // ... all front-office routes
});
```
**Admin routes (`/admin/*`) are NOT localized** — they sit outside the locale group.

### Translation Files
```
lang/
  fr.json   ← French translations (default)
  en.json   ← English translations
```
Format: flat JSON with dot-notation keys:
```json
{
    "nav.home": "Home",
    "nav.our_work": "Our Work",
    "footer.description": "CodeSommet is a digital agency...",
    "common.faq": "Frequently Asked Questions"
}
```
Used in Blade via: `{{ __('nav.home') }}` or `@lang('nav.home')`

### Key Translation Namespaces
- `nav.*` — Navigation labels (home, our_work, tools, blog, about, contact, get_quote, book_call)
- `footer.*` — Footer section (description, column headings, link labels)
- `layout.*` — Layout-level strings (org_description for JSON-LD schema)
- `common.*` — Shared strings across pages (CTA buttons, FAQ, stats, etc.)

## What Has Been Translated So Far

### Fully translated (using `__()` keys):
- **Layout** (`frontoffice/layouts/app.blade.php`) — `<html lang>`, `dir`, `og:locale`, hreflang tags, canonical URL, JSON-LD schema
- **Desktop header** (`frontoffice/partials/header.blade.php`) — nav labels, CTA buttons, language switcher
- **Mobile header** (`frontoffice/partials/header-mobile.blade.php`) — nav labels, CTA buttons, language switcher
- **Footer** (`frontoffice/partials/footer.blade.php`) — all column headings, link labels, description

### NOT yet translated (still hardcoded French):
- **All 116+ page Blade files** — hero sections, body content, meta tags, FAQ sections, Why Choose Us sections, CTA blocks, stats bars
- **Page-specific meta tags** (`@section('title')`, `@section('meta_description')`) — still hardcoded in each page file

## SEO Features Implemented

Every page automatically outputs:
```html
<html lang="fr" dir="ltr">
<!-- or -->
<html lang="en" dir="ltr">
```

```html
<link rel="canonical" href="https://pikassostudio.com/about" />
<link rel="alternate" hreflang="fr" href="https://pikassostudio.com/about" />
<link rel="alternate" hreflang="en" href="https://pikassostudio.com/en/about" />
<link rel="alternate" hreflang="x-default" href="https://pikassostudio.com/about" />
```

```html
<meta property="og:locale" content="fr_FR" />
<meta property="og:locale:alternate" content="en_GB" />
```

## Language Switcher

Both desktop and mobile headers have a globe icon dropdown with:
- French flag + "Français" → links to `LaravelLocalization::getLocalizedURL('fr')`
- UK flag + "English" → links to `LaravelLocalization::getLocalizedURL('en')`
- Active locale shows an orange dot indicator
- Clicking switches to the same page in the other language (e.g. `/en/about` ↔ `/about`)

## How to Generate Localized URLs in Blade

```blade
{{-- Link to current page in another locale --}}
{{ LaravelLocalization::getLocalizedURL('en') }}

{{-- Named route (automatically gets locale prefix) --}}
{{ route('about') }}          {{-- /about (fr) or /en/about (en) --}}
{{ route('contact') }}        {{-- /contact (fr) or /en/contact (en) --}}
{{ route('tool', 'website-analyzer') }}

{{-- Get current locale --}}
{{ app()->getLocale() }}      {{-- 'fr' or 'en' --}}
```

## How to Add a New Translation Key

1. Add the key + French text to `lang/fr.json`
2. Add the key + English text to `lang/en.json`
3. Use `{{ __('your.key') }}` in Blade

## How to Translate a Page (Step by Step)

For example, translating `resources/views/frontoffice/pages/about.blade.php`:

1. Read the page, identify all hardcoded French text
2. Create translation keys with `page_about.*` prefix
3. Add French strings to `lang/fr.json`
4. Add English strings to `lang/en.json`
5. Replace hardcoded text in Blade with `{{ __('page_about.hero_title') }}`
6. For `@section('title')`, use `@section('title', __('page_about.meta_title'))`

## How to Add Arabic (Future)

1. In `config/laravellocalization.php`, add to `supportedLocales`:
   ```php
   'ar' => ['name' => 'Arabic', 'script' => 'Arab', 'native' => 'العربية', 'regional' => 'ar_SA'],
   ```
2. Create `lang/ar.json` with all translation keys
3. Add Arabic option to language switcher in both headers
4. The layout already has `dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}"` — RTL is ready
5. Add RTL-specific CSS overrides if needed

## File Map

```
config/laravellocalization.php     ← locale config (supported locales, hide default, ignored URLs)
config/app.php                     ← default locale setting
.env                               ← APP_LOCALE=fr
bootstrap/app.php                  ← middleware aliases registered here
routes/web.php                     ← front-office routes in locale group, admin outside
lang/fr.json                       ← French translations
lang/en.json                       ← English translations
resources/views/frontoffice/
  layouts/app.blade.php            ← dynamic lang, hreflang, canonical, og:locale
  partials/header.blade.php        ← translated nav + language switcher (desktop)
  partials/header-mobile.blade.php ← translated nav + language switcher (mobile)
  partials/footer.blade.php        ← translated footer
  pages/**/*.blade.php             ← NOT YET TRANSLATED (116+ files)
```
