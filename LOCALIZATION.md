# Localization — CodeSommet (codesommet.com)

## Status: French-only

The site is **French only**. Multilingual routing has been removed.

There are no locale URL prefixes, no language switcher, no hreflang tags, and no
`mcamara/laravel-localization` package. Every URL serves French:
`/about`, `/contact`, `/tools`, etc.

## Translation files are still in use

Page text still lives in translation files and is rendered with `__()`. This is a
**content-organization layer, not a multilingual one** — there is exactly one locale.

```
lang/
  fr.json          ← shared strings (nav.*, footer.*, layout.*, common.*)
  fr/
    about.php      ← per-page strings (about.title, about.text_0, ...)
    home.php
    contact.php
    services/
    locations/
    tools/
    our-work/
    legal/
    blog/
```

Used in Blade:
```blade
@section('title', __('about.title'))
{{ __('about.text_0') }}
```

`config/app.php` sets `locale => fr` and `fallback_locale => fr` (from `APP_LOCALE`
in `.env`), so `__()` always resolves against `lang/fr/`.

## Editing site copy

To change text on a page, edit the matching key in `lang/fr/<page>.php` (or
`lang/fr.json` for shared nav/footer strings). Do not hardcode text back into the
Blade files — keep using the keys.

## Adding a new page

1. Create the Blade view under `resources/views/frontoffice/pages/`
2. Create `lang/fr/<page>.php` with its strings
3. Reference them with `__('<page>.<key>')`

## SEO output

Every page emits:
```html
<html lang="fr" dir="ltr">
<meta property="og:locale" content="fr_FR" />
<link rel="canonical" href="https://codesommet.com/<current-path>" />
```

A page can override the canonical with `@section('canonical', '...')`.

## If a second language is ever needed again

The `__()` call sites are already in place, so re-adding a language means:

1. `composer require mcamara/laravel-localization`
2. Re-add the middleware aliases in `bootstrap/app.php`
3. Wrap the front-office routes in `routes/web.php` in a
   `LaravelLocalization::setLocale()` prefix group
4. Publish `config/laravellocalization.php` and list the locales
5. Create `lang/<code>/` mirroring `lang/fr/`
6. Restore the hreflang / `og:locale:alternate` tags in
   `resources/views/frontoffice/layouts/app.blade.php`
7. Restore the language switcher in `partials/header.blade.php` and
   `partials/header-mobile.blade.php`

Git history holds the previous implementation of all seven steps.

## File map

```
config/app.php                     ← locale = fr, fallback = fr
.env                               ← APP_LOCALE=fr
routes/web.php                     ← front-office routes, no locale prefix
lang/fr.json                       ← shared strings
lang/fr/**                         ← per-page strings
resources/views/frontoffice/
  layouts/app.blade.php            ← lang="fr", og:locale, canonical
  partials/header.blade.php        ← nav (no switcher)
  partials/header-mobile.blade.php ← nav (no switcher)
```
