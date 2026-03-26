#!/usr/bin/env python3
"""
Batch converter: Static HTML → Laravel Blade views
===================================================

Converts all remaining static .html pages from the exported Next.js site
into Laravel Blade templates that extend layouts.app.

Usage:
    python scripts/convert-all-pages.py

The script:
1. Scans all .html files in the project root
2. Extracts <head> meta tags (title, description, keywords, OG, Twitter)
3. Extracts body content between last </header> and <footer
4. Converts asset URLs to Laravel asset() helper
5. Converts internal links to Laravel route() helper
6. Writes .blade.php files to the correct resources/views/ subfolder

Already-converted pages are skipped.
"""

import re
import os
import html as htmllib
import glob
import sys

# ─── Configuration ───────────────────────────────────────────────────────────

PROJECT_ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
VIEWS_DIR = os.path.join(PROJECT_ROOT, 'resources', 'views')

# Map of source HTML file → target Blade view path (relative to views/)
MANUAL_MAP = {
    'index.html': 'pages/home.blade.php',
    'about.html': 'pages/about.blade.php',
    'contact.html': 'pages/contact.blade.php',
    'get-quote.html': 'pages/get-quote.blade.php',
    'our-work.html': 'pages/our-work.blade.php',
    'industries.html': 'pages/industries.blade.php',
    'locations.html': 'pages/locations.blade.php',
    'tools.html': 'pages/tools.blade.php',
    'privacy-policy.html': 'pages/legal/privacy-policy.blade.php',
    'terms-of-service.html': 'pages/legal/terms-of-service.blade.php',
    'refund-policy.html': 'pages/legal/refund-policy.blade.php',
    'cookie-policy.html': 'pages/legal/cookie-policy.blade.php',
    'acceptable-use.html': 'pages/legal/acceptable-use.blade.php',
}

# Internal link → route() mapping
LINK_MAP = {
    'index.html': "{{ route('home') }}",
    'about.html': "{{ route('about') }}",
    'contact.html': "{{ route('contact') }}",
    'our-work.html': "{{ route('our-work') }}",
    'tools.html': "{{ route('tools') }}",
    'industries.html': "{{ route('industries') }}",
    'locations.html': "{{ route('locations') }}",
    'get-quote.html': "{{ route('get-quote') }}",
    'privacy-policy.html': "{{ route('privacy-policy') }}",
    'terms-of-service.html': "{{ route('terms-of-service') }}",
    'refund-policy.html': "{{ route('refund-policy') }}",
    'cookie-policy.html': "{{ route('cookie-policy') }}",
    'acceptable-use.html': "{{ route('acceptable-use') }}",
}


# ─── Helper Functions ────────────────────────────────────────────────────────

def extract_meta(html_content):
    """Extract SEO meta tags from <head>."""
    head = re.search(r'<head>(.*?)</head>', html_content, re.DOTALL)
    hc = head.group(1) if head else ''

    def get(pattern):
        m = re.search(pattern, hc)
        return htmllib.unescape(m.group(1)) if m else ''

    title = get(r'<title>([^<]*)</title>')
    # Remove duplicate " | CodeSommetStudio" suffixes
    title = re.sub(r'(\s*\|\s*CodeSommetStudio)+$', '', title).strip()

    return {
        'title': title,
        'desc': get(r'<meta name="description" content="([^"]*)'),
        'keywords': get(r'<meta name="keywords" content="([^"]*)'),
        'og_title': get(r'<meta property="og:title" content="([^"]*)'),
        'og_desc': get(r'<meta property="og:description" content="([^"]*)'),
        'og_url': get(r'<meta property="og:url" content="([^"]*)'),
        'twitter_desc': get(r'<meta name="twitter:description" content="([^"]*)'),
    }


def extract_body(html_content):
    """Extract main content between last </header> and <footer."""
    last_header_end = html_content.rfind('</header>')
    footer_start = html_content.find('<footer')
    if last_header_end == -1 or footer_start == -1:
        return ''
    return html_content[last_header_end + 9:footer_start]


def convert_links(body):
    """Convert .html links to Laravel route() calls."""
    # Static page links
    for old, new in LINK_MAP.items():
        body = body.replace(f'href="{old}"', f'href="{new}"')
        body = body.replace(f'href="/{old}"', f'href="{new}"')

    # Service pages: *-website-development.html, *-platform-development.html
    for slug in set(re.findall(r'href="([a-z-]+-(?:website|platform)-development)\.html"', body)):
        body = body.replace(
            f'href="{slug}.html"',
            f"href=\"{{{{ route('service', '{slug}') }}}}\""
        )

    # City pages: web-development-{city}.html
    for city in set(re.findall(r'href="web-development-([a-z-]+)\.html"', body)):
        body = body.replace(
            f'href="web-development-{city}.html"',
            f"href=\"{{{{ route('location', '{city}') }}}}\""
        )

    # Tool pages: tools/{slug}.html
    for tool in set(re.findall(r'href="tools/([a-z-]+)\.html"', body)):
        body = body.replace(
            f'href="tools/{tool}.html"',
            f"href=\"{{{{ route('tool', '{tool}') }}}}\""
        )

    # Case study pages: our-work/{slug}.html
    for slug in set(re.findall(r'href="our-work/([a-z-]+)\.html"', body)):
        body = body.replace(
            f'href="our-work/{slug}.html"',
            f"href=\"{{{{ route('case-study', '{slug}') }}}}\""
        )

    return body


def convert_assets(body):
    """Convert image/asset src attributes to Laravel asset() helper."""
    asset_patterns = [
        (r'src="(images/[^"]+)"', r"images/"),
        (r'src="(mockups/[^"]+)"', r"mockups/"),
        (r'src="(logos/[^"]+)"', r"logos/"),
        (r'src="(our-work/[^"]+)"', r"our-work/"),
    ]
    for pattern, _ in asset_patterns:
        body = re.sub(pattern, lambda m: f'src="{{{{ asset(\'{m.group(1)}\') }}}}"', body)

    # Root-level images that should be under images/
    root_image_patterns = [
        r'src="(pikasso[^"]+\.(?:svg|png|webp)[^"]*)"',
        r'src="(hero[^"]+\.webp)"',
        r'src="(about[^"]+\.webp)"',
        r'src="(contact[^"]+\.webp)"',
        r'src="(our-work[^"]+\.webp)"',
        r'src="(featured[^"]+\.webp)"',
    ]
    for pattern in root_image_patterns:
        body = re.sub(pattern, lambda m: f'src="{{{{ asset(\'images/{m.group(1)}\') }}}}"', body)

    return body


def escape_blade(text):
    """Escape single quotes for Blade @section directives."""
    return text.replace("'", "\\'")


def make_blade(meta, body):
    """Wrap content in Blade template extending layouts.app."""
    return f"""@extends('layouts.app')

@section('title', '{escape_blade(meta["title"])} | CodeSommetStudio')
@section('meta_description', '{escape_blade(meta["desc"])}')
@section('meta_keywords', '{escape_blade(meta["keywords"])}')
@section('og_title', '{escape_blade(meta["og_title"])}')
@section('og_description', '{escape_blade(meta["og_desc"])}')
@section('twitter_description', '{escape_blade(meta["twitter_desc"])}')

@section('content')
{body}
@endsection
"""


def classify_file(filename):
    """Determine the target Blade view path for a given HTML file."""
    # Normalize path separators
    filename = filename.replace('\\', '/')

    # Check manual map first
    if filename in MANUAL_MAP:
        return MANUAL_MAP[filename]

    # Service/industry pages
    basename = os.path.basename(filename)
    if re.match(r'.+-(?:website|platform)-development\.html$', basename):
        slug = basename.replace('.html', '')
        return f'pages/services/{slug}.blade.php'

    # City pages
    m = re.match(r'web-development-(.+)\.html$', basename)
    if m:
        return f'pages/locations/{basename.replace(".html", ".blade.php")}'

    # Tool pages (in tools/ subfolder)
    if filename.startswith('tools/'):
        slug = filename.replace('tools/', '').replace('.html', '')
        return f'pages/tools/{slug}.blade.php'

    # Our work case studies
    if filename.startswith('our-work/'):
        slug = filename.replace('our-work/', '').replace('.html', '')
        return f'pages/our-work/{slug}.blade.php'

    return None


# ─── Main ────────────────────────────────────────────────────────────────────

def main():
    os.chdir(PROJECT_ROOT)

    # Find all HTML files
    html_files = []
    for f in glob.glob('*.html'):
        html_files.append(f)
    for f in glob.glob('tools/*.html'):
        html_files.append(f)
    for f in glob.glob('our-work/*.html'):
        html_files.append(f)

    converted = 0
    skipped = 0
    errors = 0

    for html_file in sorted(html_files):
        target = classify_file(html_file)
        if target is None:
            print(f'  SKIP (unknown type): {html_file}')
            skipped += 1
            continue

        output_path = os.path.join(VIEWS_DIR, target)

        # Skip if already converted
        if os.path.exists(output_path):
            print(f'  EXISTS: {target}')
            skipped += 1
            continue

        try:
            with open(html_file, 'r', encoding='utf-8') as f:
                html_content = f.read()

            meta = extract_meta(html_content)
            body = extract_body(html_content)

            if not body.strip():
                print(f'  WARN (empty body): {html_file}')
                errors += 1
                continue

            body = convert_links(body)
            body = convert_assets(body)
            blade = make_blade(meta, body)

            os.makedirs(os.path.dirname(output_path), exist_ok=True)
            with open(output_path, 'w', encoding='utf-8') as f:
                f.write(blade)

            print(f'  OK: {html_file} -> {target} ({len(blade):,} chars)')
            converted += 1

        except Exception as e:
            print(f'  ERROR: {html_file} -> {e}')
            errors += 1

    print(f'\n{"="*60}')
    print(f'Done! Converted: {converted}, Skipped: {skipped}, Errors: {errors}')
    print(f'Total HTML files found: {len(html_files)}')


if __name__ == '__main__':
    main()
