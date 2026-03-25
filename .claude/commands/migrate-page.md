# Migrate Page — Exact 1:1 Clone from Static HTML to Laravel Blade

You are migrating a page from the original static Next.js export into Laravel Blade.
The goal is a **pixel-perfect, exact clone** — not a redesign, not a simplification.

## Input
The user will provide a page name (e.g. "about", "ecommerce-website-development", "web-development-dubai").

## Steps

### 1. Locate Source Files
- Find the original static HTML file at the project root (e.g. `about.html`, `ecommerce-website-development.html`).
- Find the corresponding Blade view in `resources/views/pages/`.
- If the Blade view doesn't exist yet, create it in the correct location based on the route structure in `routes/web.php`.

### 2. Analyze the Original HTML
- Read the full source HTML file.
- Identify all CSS class names, inline styles, data attributes, and HTML structure.
- Identify all `_next/` chunk references (CSS and JS files).
- Read the referenced chunks to understand what styles and scripts are needed.

### 3. Extract Missing Assets
- Compare the styles from the chunks against `public/css/main.css` and `public/css/components.css`.
- If any CSS rules are missing, add them to the appropriate CSS file.
- If any JS behavior is missing, add it to `public/js/app.js` or create a page-specific script.
- If any images/icons are missing from `public/`, copy them from the source.

### 4. Build/Fix the Blade View
- The page must `@extends('layouts.app')` and use `@section('content')` ... `@endsection`.
- Set page-specific SEO sections: `@section('title')`, `@section('meta_description')`, etc.
- The HTML inside `@section('content')` must **exactly match** the original `<main>` content:
  - Same element hierarchy and nesting
  - Same class names (do not rename)
  - Same inline styles (do not remove)
  - Same data attributes
  - Same image sources (converted to `{{ asset('...') }}`)
  - Same link hrefs (converted to `{{ route('...') }}` or `{{ url('...') }}` where appropriate)
- Do **not** include `<html>`, `<head>`, `<body>`, header, or footer — those come from the layout and partials.

### 5. Verify Completeness
- Every section from the original HTML must be present in the Blade view.
- Every CSS class used in the Blade view must have corresponding rules in the CSS files.
- Every image referenced must exist in `public/`.
- Every link must point to a valid route.

### 6. Report
- List what was created or modified.
- List any missing assets that couldn't be found (images, fonts, etc.).
- List any CSS rules that were added.

## Rules
- Do NOT simplify, redesign, or approximate.
- Do NOT remove wrappers, containers, or seemingly redundant elements.
- Do NOT change class names.
- Do NOT use Tailwind or any utility framework unless the original uses it.
- Do NOT keep any `/_next/` references in the output.
- All asset paths must use `{{ asset('...') }}`.
- Exact clone. No exceptions.
