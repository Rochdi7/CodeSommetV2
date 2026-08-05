# How the CodeSommet Tools Work

Technical documentation of the 46 free tools at `/tools/{slug}`.

**Source of truth:** this document was written by reading the actual code, not the marketing copy. Where a tool is a stub or an alias, it says so.

---

## Table of Contents

- [1. Overview](#1-overview)
- [2. The Three Tiers](#2-the-three-tiers)
- [3. Request Lifecycle](#3-request-lifecycle)
  - [3.1 Frontend dispatch](#31-frontend-dispatch)
  - [3.2 Slug-to-method routing](#32-slug-to-method-routing)
  - [3.3 Response shape](#33-response-shape)
- [4. Security Layer](#4-security-layer)
  - [4.1 SafeUrlValidator (SSRF)](#41-safeurlvalidator-ssrf)
  - [4.2 SafeHttpFetcher](#42-safehttpfetcher)
  - [4.3 Rate limiting](#43-rate-limiting)
- [5. Scoring Engine](#5-scoring-engine)
- [6. Tier A — Server-Side Analysis Tools](#6-tier-a--server-side-analysis-tools)
  - [6.1 Website Analyzer](#61-website-analyzer)
  - [6.2 Heading Analyzer](#62-heading-analyzer)
  - [6.3 Keyword Density Analyzer](#63-keyword-density-analyzer)
  - [6.4 Broken Link Checker](#64-broken-link-checker)
  - [6.5 Redirect Checker](#65-redirect-checker)
  - [6.6 OG Preview Generator](#66-og-preview-generator)
  - [6.7 SSL Certificate Checker](#67-ssl-certificate-checker)
  - [6.8 Canonical Checker](#68-canonical-checker)
  - [6.9 Image Alt Analyzer](#69-image-alt-analyzer)
  - [6.10 Domain Health Checker](#610-domain-health-checker)
  - [6.11 Internal Link Analyzer](#611-internal-link-analyzer)
  - [6.12 Robots.txt Validator](#612-robotstxt-validator)
  - [6.13 Sitemap Validator](#613-sitemap-validator)
  - [6.14 Mobile-Friendly Test](#614-mobile-friendly-test)
  - [6.15 Core Web Vitals Checker](#615-core-web-vitals-checker)
  - [6.16 Image Compression Analyzer](#616-image-compression-analyzer)
  - [6.17 Meta Tag Generator](#617-meta-tag-generator)
- [7. Tier B — Aliases and Stubs](#7-tier-b--aliases-and-stubs)
- [8. Tier C — Client-Side Tools](#8-tier-c--client-side-tools)
- [9. Known Limitations](#9-known-limitations)
- [10. Extending the System](#10-extending-the-system)
- [Appendix: Complete Tool Index](#appendix-complete-tool-index)

---

## 1. Overview

46 tools, each with a Blade view at `resources/views/frontoffice/pages/tools/{slug}.blade.php`.

The core design constraint: **a browser cannot fetch a third-party website's HTML** (CORS blocks it). So any tool that needs to read someone else's page must route through the server. Tools that only transform text the user already pasted run entirely in the browser.

That single constraint produces the whole architecture.

| Layer | File | Lines |
|---|---|---|
| API controller | `app/Http/Controllers/ToolsApiController.php` | 1422 |
| SSRF validator | `app/Services/SafeUrlValidator.php` | 237 |
| Safe HTTP client | `app/Services/SafeHttpFetcher.php` | 179 |
| API tool frontend | `public/js/tools/api-tools.js` | 350 |
| Generator frontend | `public/js/tools/ai-tools.js` | 265 |
| Shared UI helpers | `public/js/tools-common.js` | 492 |
| Routes | `routes/api.php` | 37 |

---

## 2. The Three Tiers

**Tier A — Server-side analysis (20 tools).** Fetches a remote URL, runs regex checks over the returned HTML, returns a score. Needs the server.

**Tier B — Aliases and stubs (5 tools).** Real endpoints that either delegate to another handler or return placeholder data because no third-party API key is configured.

**Tier C — Client-side (21 tools).** Pure JavaScript. No network request. Generators, formatters, converters, counters.

---

## 3. Request Lifecycle

### 3.1 Frontend dispatch

There is no per-tool JavaScript file for Tier A. One shared script drives all of them. It detects which tool page it is on by reading the URL path:

```js
function detectToolSlug() {
    var path = window.location.pathname;
    var match = path.match(/\/tools\/([a-z0-9-]+)/);
    if (match) return match[1];
    // …falls back to page title
}
```

It then looks up `TOOL_CONFIG[slug]` for the button label and placeholder text, binds the click handler, and POSTs:

```js
fetch('/api/tools/' + slug, {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': getCSRFToken(),
        'Accept': 'application/json'
    },
    body: JSON.stringify({
        url: url,
        domain: url.replace(/^https?:\/\//, '').replace(/\/.*$/, '')
    })
})
```

Both `url` and `domain` are always sent, so the same payload works for handlers that want a full URL and handlers that want a bare hostname.

### 3.2 Slug-to-method routing

One route serves every tool:

```php
Route::post('/tools/{slug}', [ToolsApiController::class, 'handle'])
    ->where('slug', '[a-z0-9-]+')
    ->middleware('throttle:tools-api');
```

`handle()` converts the slug into a method name and calls it. There is no registry array and no switch statement:

```php
$method = 'handle' . str_replace('-', '', ucwords($slug, '-'));
// 'domain-health-checker' → 'handleDomainHealthChecker'

if (! method_exists($this, $method)) {
    return response()->json(['error' => 'Tool not found'], 404);
}
```

**Consequence:** adding a tool means adding a method whose name matches the slug. Nothing else needs registering. The `[a-z0-9-]+` route constraint plus `method_exists` prevents the slug from reaching arbitrary controller methods.

Two exception paths wrap every handler:

| Exception | HTTP | Body returned to user |
|---|---|---|
| `UnsafeUrlException` | 422 | "The submitted URL could not be analyzed…" |
| `\Throwable` | 500 | "Analysis failed. Please verify the submitted URL…" |

The real reason is logged server-side but never sent to the client — leaking "host resolves to a private address" would turn the endpoint into an internal network scanner.

### 3.3 Response shape

Handlers converge on a common JSON envelope, which is why one renderer can display all of them:

```json
{
  "score": 85,
  "grade": "B",
  "passed": true,
  "stats":  { "score": "85/100", "checksRun": 8 },
  "issues": [ { "type": "warning", "message": "No sitemap.xml found" } ],
  "recommendations": [ "Improve: No sitemap.xml found" ]
}
```

Not every handler returns every key. Link-based tools add `links[]`, image tools add `images[]`, the heading analyzer adds `headings[]`.

---

## 4. Security Layer

This is the most carefully written part of the codebase, and for good reason: an endpoint that fetches user-supplied URLs is a textbook SSRF vector. Without protection, `http://169.254.169.254/latest/meta-data/` would make the server dump its own cloud credentials into the response.

### 4.1 SafeUrlValidator (SSRF)

Every outbound URL passes `validate()` before any packet leaves the server. The checks, in order:

1. **Control characters** — rejects `\x00-\x1F`, `\x7F`, and whitespace inside the URL.
2. **Scheme** — `http` and `https` only. Blocks `file://`, `gopher://`, `dict://`.
3. **Credentials** — any URL with `user:pass@` is rejected.
4. **Port** — 80 and 443 only. Blocks probing internal services on 6379, 3306, 8080.
5. **Host name blacklist** — `localhost` and its aliases; any host ending in `.localhost`, `.local`, `.internal`.
6. **DNS resolution** — the host is resolved to A and AAAA records.
7. **Every resolved IP is range-checked.** Not just the first one.

Step 7 matters: a public hostname can legitimately resolve to `127.0.0.1`. Checking the name is not enough; the IPs must be checked.

Blocked IPv4 ranges, beyond what PHP's `FILTER_FLAG_NO_PRIV_RANGE` covers:

| Range | Why |
|---|---|
| `0.0.0.0/8` | "This" network |
| `10.0.0.0/8` | Private |
| `100.64.0.0/10` | CGNAT |
| `127.0.0.0/8` | Loopback |
| `169.254.0.0/16` | Link-local — **includes `169.254.169.254` cloud metadata** |
| `172.16.0.0/12` | Private |
| `192.0.0.0/24` | IETF protocol assignments |
| `192.168.0.0/16` | Private |
| `198.18.0.0/15` | Benchmarking |
| `224.0.0.0/4` | Multicast |
| `240.0.0.0/4` | Reserved |

IPv6 is handled too: `::1`, `::`, `fc00::/7` unique-local, `fe80::/10` link-local, `ff00::/8` multicast.

Two bypass classes get explicit treatment:

**IPv4-mapped IPv6.** `::ffff:127.0.0.1` is a valid IPv6 address that reaches loopback. The validator extracts the embedded IPv4 and recursively re-checks it.

**Non-canonical numeric hosts.** `2130706433`, `0x7f000001`, and `0177.0.0.1` are all `127.0.0.1` in disguise. Rather than trying to parse each notation, the validator rejects anything matching `/^[0-9x.]+$/i` that is not already a canonical IP — such a string is not a valid DNS name anyway.

`validate()` returns the resolved IP list so the caller can pin to it.

### 4.2 SafeHttpFetcher

Validation alone leaves a race: the attacker's DNS can return a public IP during validation and a private one microseconds later during the fetch. That is **DNS rebinding**, and the fetcher closes the window.

**IP pinning.** The connection is forced to the already-validated IP via cURL's `CURLOPT_RESOLVE`, while still presenting the correct SNI/Host header so TLS and virtual hosting work:

```php
$curl[CURLOPT_RESOLVE] = ["{$validated['host']}:{$port}:{$pinnedIp}"];
```

**Fails closed.** If the cURL extension is unavailable, the PHP stream handler would silently ignore `CURLOPT_RESOLVE` and re-resolve the hostname — reopening the hole. So it throws instead of degrading:

```php
if (! extension_loaded('curl')) {
    throw new UnsafeUrlException('Safe fetching requires the cURL extension.');
}
```

**Manual redirects.** `allow_redirects` is off. Redirects are followed by hand, max 3 hops, and **each hop is re-validated**. A public URL cannot 302 you into the internal network.

**Proxy neutralized.** `CURLOPT_PROXY => ''` and `'proxy' => ''` stop `HTTP_PROXY` / `HTTPS_PROXY` environment variables from routing around the pinned IP.

**Body cap.** Responses are streamed and truncated at 5 MB, so a multi-gigabyte response cannot exhaust memory. `CURLOPT_ENCODING => 'identity'` also makes gzip-bomb attacks less trivial, though the capped read is the actual defence.

**Timeouts.** 8 s connect, 15 s total by default.

### 4.3 Rate limiting

The endpoint could otherwise be used as a **traffic amplifier**: one request to the broken-link checker produces up to 25 outbound requests. At 20 calls/min that is 500 outbound requests per minute per IP, pointed at any victim.

So the throttle is split by tool weight, keyed per IP, with **separate buckets** so heavy tools cannot starve light ones:

| Bucket | Limit | Tools |
|---|---|---|
| `tools-api-heavy` | 5/min | broken-link-checker, redirect-checker, domain-health-checker, domain-authority-checker, website-readiness-checker |
| `tools-api` | 20/min | everything else (single fetch) |

The bucket is chosen inside the rate limiter closure by inspecting the slug, because declaring two routes on the same URI would never reach the second one.

Individual tools have their own internal caps too: broken-link stops at 25 links, redirect-checker at 10 hops, image-alt at 100 images, image-compression at 20 images.

---

## 5. Scoring Engine

Two helpers back every score.

**Grade mapping** — note the wide C band:

```php
if ($score >= 90) return 'A';
if ($score >= 80) return 'B';
if ($score >= 60) return 'C';
if ($score >= 40) return 'D';
return 'F';
```

**Recommendations** are derived mechanically from failed checks — they are not authored advice:

```php
if ($c['status'] === 'fail')    $recs[] = 'Fix: '     . $c['message'];
elseif ($c['status'] === 'warning') $recs[] = 'Improve: ' . $c['message'];
```

Every check carries `status` of `pass`, `warning`, or `fail`. The `issues[]` array is simply everything that is not `pass`.

**All analysis is regex over raw HTML.** No DOM parser, no headless browser, no JavaScript execution.

---

## 6. Tier A — Server-Side Analysis Tools

### 6.1 Website Analyzer

`/tools/website-analyzer` · single fetch · **percentage-based scoring**

The only tool that computes `round(($score / $maxScore) * 100)` rather than summing to a fixed ceiling. It can genuinely reach 100.

| Check | Max | Pass condition | Partial |
|---|---|---|---|
| Title tag | 10 | 30–60 chars | 5 if present but wrong length |
| Meta description | 10 | 120–160 chars | 5 if present but wrong length |
| H1 | 10 | exactly one | 5 if multiple |
| Open Graph | 5 | any `og:` meta | — |
| Canonical | 5 | `rel="canonical"` present | — |
| Viewport | 5 | viewport meta present | — |
| Image alt text | 10 | all images have alt | 5 if some missing |
| HTTPS | 5 | URL starts `https://` | — |
| Page size | 5 | under 100 KB | 2 if larger |

Also counts internal vs external links (not scored). Verdict `passed` at ≥ 70.

### 6.2 Heading Analyzer

`/tools/heading-analyzer` · single fetch

Extracts every `<h1>`–`<h6>` with `preg_match_all` in document order, strips inner tags for the text, and counts per level.

Three validations:
- **No H1** → error. **Multiple H1** → warning.
- **No H2** when more than one heading exists → warning.
- **Hierarchy gap** → warning. Walks the list tracking the previous level; if the current level exceeds `previous + 1` (an H2 followed by an H4), it reports the skipped level and the offending heading text.

`passed` is true when there are no `error`-type issues; warnings do not fail it.

### 6.3 Keyword Density Analyzer

`/tools/keyword-density-analyzer` · single fetch

The text extraction is deliberately careful, because naive `strip_tags()` produces garbage keyword lists:

1. **Remove `<script>`, `<style>`, `<noscript>`, `<template>` bodies.** `strip_tags()` removes the tags but keeps their *contents*, which would leak CSS and JS source into the keyword list.
2. Remove HTML comments.
3. **Replace each remaining tag with a space**, so `…domain</h1><p>This…` does not fuse into the pseudo-word `domainthis`.
4. Decode HTML entities, collapse whitespace, lowercase (`mb_strtolower`, UTF-8).
5. Split on non-letter/digit with `/[^\p{L}\p{N}'-]+/u` — accent-aware, so French copy tokenizes correctly.
6. Drop words of 3 characters or fewer.

It then produces three lists: **single words** (top 20, stop-words filtered), **2-word phrases** (top 15, kept if at least one word is not a stop word), and **3-word phrases** (top 10, unfiltered).

Density is `count / totalWords * 100`. Stuffing warnings fire only when density > 3% **and** count ≥ 3 **and** the page has ≥ 100 words — on a 20-word page a single mention is already over 3%.

### 6.4 Broken Link Checker

`/tools/broken-link-checker` · **heavy, 5/min** · up to 26 fetches

Fetches the page, extracts every `href`, deduplicates, and takes **the first 25**. Relative paths are resolved against the base; non-HTTP schemes (`mailto:`, `tel:`) are skipped.

Each link is **individually re-validated** before being requested:

```php
$this->urlValidator->validate($link);
```

Without this, any attacker could host a page full of `http://169.254.169.254/` links and use your server as a scanner.

Classification: 2xx → working, 3xx → redirect, 4xx/5xx → broken. Per-link response time is measured with `microtime()`.

Blocked links are handled distinctively — they are **silently removed from the stats** rather than reported as broken, so the response cannot be used to infer which internal hosts exist.

### 6.5 Redirect Checker

`/tools/redirect-checker` · **heavy, 5/min** · up to 10 fetches

Uses `getNoRedirect()` to inspect each hop rather than letting cURL follow the chain. Loops up to 10 times, tracking visited URLs in an array; a repeat sets `hasLoop` and breaks.

Each hop records URL, status code, type (`301 Permanent` / `302 Temporary` / `Final`), latency, and `Location`. Relative `Location` headers are resolved against the current URL.

Severity: loop → `error`; more than 3 hops → `warning`; otherwise `success`. Blocked hops are recorded with `redirectType: 'blocked'`.

### 6.6 OG Preview Generator

`/tools/og-preview-generator` · single fetch

Extracts `og:` and `twitter:` meta tags with an alternation regex that handles **both attribute orders** — `property` before `content` and `content` before `property` — since either is valid HTML.

Falls back to `<title>` for a missing `og:title` and to `<meta name="description">` for a missing `og:description`. `twitter:image` falls back to `og:image`.

Warns on: missing `og:title`, missing `og:description`, missing `og:image` (no preview thumbnail on social shares), and `og:title` over 90 characters.

### 6.7 SSL Certificate Checker

`/tools/ssl-certificate-checker` · raw TLS socket, no HTTP

The only tool that does not use the HTTP fetcher. It opens a raw TLS socket and reads the certificate:

```php
$client = @stream_socket_client("ssl://{$connectTarget}:443", …);
$cert = openssl_x509_parse($params['options']['ssl']['peer_certificate']);
```

The host is validated first, and **the socket connects to the validated IP** while `peer_name` + `SNI_enabled` present the real hostname — same pinning idea as the HTTP fetcher.

Returns issuer, validity window, and days remaining. Scoring starts at 100: **expired** costs 60 points, **under 30 days remaining** costs 20.

Note `verify_peer => false`. This is intentional — the goal is to *read and report on* the certificate (including a broken or self-signed one) rather than refuse to connect.

### 6.8 Canonical Checker

`/tools/canonical-checker` · single fetch

Finds all `<link rel="canonical">` tags and flags:

- **None found** → error.
- **More than one** → error. Google may ignore all of them.
- **Cross-domain** — canonical host differs from page host → warning.
- **Relative URL** — does not start with `http` → warning.

Self-referencing canonicals are the healthy case and produce no issue.

**Known limitation:** the regex requires `rel` before `href`. A tag written `<link href="…" rel="canonical">` is valid HTML but will not be detected.

### 6.9 Image Alt Analyzer

`/tools/image-alt-analyzer` · single fetch · caps at 100 images

The most defensive attribute parsing in the file, because real-world `<img>` tags vary enormously. For `src` it tries, in order: quoted `src`, unquoted `src`, `data-src` (lazy loading), then the first `srcset` candidate.

Three-way classification — the distinction matters for accessibility:

| Status | Meaning |
|---|---|
| `missing` | No `alt` attribute at all — a screen reader announces the filename |
| `empty` | `alt=""` — **valid and correct** for decorative images |
| `good` | Non-empty alt text |

Score is `withAlt / total * 100`. Relative `src` values are resolved to absolute for display; data URIs render as `[inline data URI]`.

### 6.10 Domain Health Checker

`/tools/domain-health-checker` · **heavy, 5/min** · 3 fetches

Takes a bare hostname, forces `https://`, then makes three requests: the homepage, `/robots.txt`, and `/sitemap.xml`.

| Check | Points | Condition |
|---|---|---|
| Domain accessible | 15 | 2xx response |
| HTTPS | 15 | see caveat below |
| robots.txt | 10 | 2xx and body longer than 5 bytes |
| sitemap.xml | 10 | 2xx and body contains `<urlset` |
| Viewport | 10 | viewport meta present |
| Meta description | 10 | description meta present |
| H1 | 10 | any `<h1>` |
| Open Graph | 5 | any `og:` meta |

**Maximum achievable score is 85, not 100.** The weights sum to 85, so a flawless site is graded **B** and can never reach an A. This is why a fully passing scan shows "85/100".

**Caveat — HTTPS is double-counted.** Line 862 reads:

```php
$isHttps = $accessible;
```

Since the URL is hardcoded to `https://`, "accessible" and "HTTPS enabled" are the same boolean scored twice, for 30 of the 85 points. It cannot detect a site that works on HTTP but not HTTPS.

### 6.11 Internal Link Analyzer

`/tools/internal-link-analyzer` · single fetch

Extracts all `href` values and buckets them: root-relative paths and same-host absolute URLs are internal, everything else external. Returns totals plus a unique-internal count, listing the first 50.

Does **not** verify the links resolve — every returned link is optimistically labelled `working`. Use the broken-link checker for actual status codes.

### 6.12 Robots.txt Validator

`/tools/robots-validator` · single fetch

Appends `/robots.txt`, then parses line by line, skipping blanks and `#` comments.

- **No `User-agent` directive** → error.
- **`Disallow: /`** → warning with line number. This blocks all crawlers from the entire site — usually a staging config left in production.

Returns line count and byte size.

### 6.13 Sitemap Validator

`/tools/sitemap-validator` · single fetch

Appends `/sitemap.xml` unless the URL already contains "sitemap".

- Missing both `<urlset>` and `<sitemapindex>` → error (not a sitemap).
- Zero `<loc>` entries → error.
- Over 50,000 URLs → warning (the protocol limit).

Counts `<loc>` tags by regex; does not validate individual URLs or `lastmod` formats.

### 6.14 Mobile-Friendly Test

`/tools/mobile-friendly-test` · single fetch

| Check | Points | Method |
|---|---|---|
| Viewport | 30 | viewport meta present, reports its content |
| Media queries | 20 | `@media` appears anywhere in the HTML |
| Font sizes | 20 | heuristic (below) |
| Tap targets | 15 | **always awarded** |
| Horizontal scroll | 15 | no `overflow-x: scroll` |

Two caveats. **Tap targets is unconditional** — 15 free points with no analysis behind it, since measuring tap targets requires layout. And the **font-size heuristic is inverted**: it passes when it finds *no* pixel font sizes at all, or *any* size ≥ 14px. Since it only sees inline HTML, a site with all styles in an external stylesheet passes trivially.

Media queries in external CSS files are likewise invisible.

### 6.15 Core Web Vitals Checker

`/tools/core-web-vitals-checker` · single fetch

**This does not measure Core Web Vitals.** It measures *your server's* response time to *this* fetch, then counts tags.

```php
$start = microtime(true);
$html  = $this->fetchUrl($url);
$loadTime = round((microtime(true) - $start) * 1000);
```

Starts at 100 and subtracts: over 3000 ms costs 30, over 1500 ms costs 10; page over 500 KB costs 20; more than 15 `<script>` tags costs 10.

What is missing is everything that defines CWV: LCP, INP, and CLS are all **rendering** metrics requiring a real browser. TTFB from your datacenter also has little relation to a user's experience on mobile. For genuine field data you need the CrUX API or Google PageSpeed Insights.

Reported stats: response time, page size, and counts of images, scripts, stylesheets.

### 6.16 Image Compression Analyzer

`/tools/image-compression-analyzer` · single fetch · caps at 20 images

Classifies images by **file extension only** — `webp`/`avif` are modern, `jpg`/`jpeg`/`png`/`gif` are legacy. Recommends WebP conversion when legacy formats appear.

It never downloads the images, so it cannot report actual file sizes or compression ratios. An extensionless URL from a CDN is classified `other`.

### 6.17 Meta Tag Generator

`/tools/meta-tag-generator` · single fetch

The one generator that reads a live URL. Extracts the current title and description, runs the same careful text-extraction pipeline as the keyword analyzer, and derives the top 8 keywords by frequency.

Emits a ready-to-paste block: `<title>`, description, keywords, four `og:` tags, and three `twitter:` tags.

Two correctness details worth noting:

**Multibyte-safe truncation.** Uses `mb_strlen` / `mb_substr` throughout. Byte-based `substr` would cut a French accented character in half and produce mojibake.

**Attribute escaping.** All interpolated values pass through `htmlspecialchars(…, ENT_QUOTES)`. Without it, an apostrophe in the source title would terminate the `content="…"` attribute and emit broken markup — and in a copy-paste tool, that is also an injection vector.

---

## 7. Tier B — Aliases and Stubs

Five endpoints that are not what their names suggest.

### Aliases

| Tool | Actually runs | Effect |
|---|---|---|
| `page-speed-analyzer` | `handleCoreWebVitalsChecker` | Identical output |
| `website-readiness-checker` | `handleDomainHealthChecker` | Identical output |
| `domain-authority-checker` | `handleDomainHealthChecker` | Identical output |

```php
public function handleDomainAuthorityChecker(Request $request): JsonResponse
{
    // Without Moz API, provide basic domain analysis
    return $this->handleDomainHealthChecker($request);
}
```

**Domain Authority is the most misleading.** DA is a proprietary Moz metric derived from a backlink graph. This endpoint returns an on-page technical score with no backlink data whatsoever. A user seeing "85/100, grade B" will reasonably read it as their Domain Authority. It is not.

### Stubs

**Backlink Checker** returns a hardcoded `score: 50` and instructions to configure `MOZ_ACCESS_ID` / `MOZ_SECRET_KEY`. It performs no analysis.

**Color Palette Generator** (server endpoint) returns HTTP 400 by design — extraction happens client-side from an uploaded image via canvas. The endpoint exists only as a fallback that redirects the user to the upload UI.

### Template-based generators

`blog-title-generator`, `chatbot-script-generator`, and `landing-page-generator` sit under an "AI-Powered Tools" comment but call **no AI model**. They are string templates with `str_replace`.

The blog title generator fills 10 French templates and attaches `rand()` values:

```php
$titles[] = [
    'title'         => $title,
    'seoScore'      => rand(72, 95),
    'emotionalHook' => ['Curiosité', 'Urgence', …][rand(0, 4)],
    'ctrEstimate'   => rand(28, 65) / 10 . '%',
];
```

The SEO score and CTR estimate are **random numbers**, not predictions. Titles are then sorted by that random score. The landing-page generator is more honest — its output is explicitly labelled a *trame* (framework) with placeholders such as `_À remplacer par un témoignage client authentique._`

---

## 8. Tier C — Client-Side Tools

21 tools running entirely in the browser, one JS file each in `public/js/tools/`. No server request, no rate limit, nothing leaves the user's machine.

**Generators** — `faq-schema-generator`, `schema-generator`, `local-business-schema`, `hreflang-generator`, `robots-txt-generator`, `xml-sitemap-generator`, `meta-refresh-generator`, `qr-code-generator`, `utm-builder`, `lorem-ipsum-generator`, `url-slug-generator`.

**Formatters and converters** — `json-formatter`, `html-minifier`, `css-minifier`, `html-to-text`, `text-case-converter`, `base64-encoder`.

**Analyzers on pasted text** — `word-counter`, `readability-analyzer`, `duplicate-content-checker`, `nofollow-link-checker`.

The privacy property is real and worth advertising: pasting proprietary content into these tools never transmits it.

`color-palette-generator` also belongs here in practice — the browser reads the uploaded image into a canvas and samples pixels; the file is never uploaded.

---

## 9. Known Limitations

**Regex, not a DOM parser.** Every analysis runs `preg_match` against raw HTML. Attribute order matters, unusual quoting can defeat a pattern, and malformed markup is not normalized the way a browser would normalize it.

**No JavaScript execution.** Only server-rendered HTML is visible. A client-rendered SPA looks nearly empty — no H1, no content, no images — and scores terribly regardless of the SEO Google actually sees after rendering.

**External CSS is invisible.** The mobile-friendly and font-size checks only inspect inline HTML. Sites with proper external stylesheets are judged on markup they do not contain.

**Single page only.** No tool crawls. "Website Analyzer" analyzes exactly one URL.

**Domain Health caps at 85.** Weights sum to 85, so a perfect site grades B.

**HTTPS scored twice in Domain Health.** `$isHttps = $accessible` — 30 points for one fact.

**Mobile tap targets always pass.** 15 unconditional points.

**Core Web Vitals measures nothing resembling CWV.** Server response time from your datacenter, plus tag counts.

**Blog title SEO scores are `rand()`.** So are the CTR estimates.

**Domain Authority is not Domain Authority.**

**5 MB body cap.** Pages larger than 5 MB are truncated before the regexes run, so checks may miss content near the end.

---

## 10. Extending the System

### Adding a server-side tool

1. Create `resources/views/frontoffice/pages/tools/{slug}.blade.php`.
2. Add `handle{SlugInPascalCase}(Request $request): JsonResponse` to `ToolsApiController`.
3. Add an entry to `TOOL_CONFIG` in `public/js/tools/api-tools.js`.
4. If the tool makes more than one outbound request, add its slug to `HEAVY_TOOLS`.

No route registration is needed — `handle()` resolves the method from the slug, and the usage counter validates against `view()->exists()`.

Always take URLs through `requireUrl()` or `requireHost()`, and always fetch through `$this->fetcher`. Never call `Http::get()` directly on user input; that bypasses the entire SSRF layer.

### Enabling real backlink and DA data

The integration point already exists. Add to `.env`:

```
MOZ_ACCESS_ID=…
MOZ_SECRET_KEY=…
```

Then replace `handleBacklinkChecker` with a real Moz Links API call, and replace the `handleDomainAuthorityChecker` passthrough with a Domain Authority lookup.

### Making Core Web Vitals real

Replace the timing heuristic with the Google PageSpeed Insights API (lab data) or the CrUX API (real field data from Chrome users). Both return genuine LCP, INP, and CLS.

### Usage counter

The "N sites analysés" figure under each button is real, not decorative. It is a server-side `ToolUsage` row:

- `GET /api/tools/{slug}/usage` reads the count on page load
- `POST /api/tools/{slug}/usage` increments it after a successful scan

Both validate the slug against an existing Blade view, so the endpoint cannot be used to write arbitrary rows. It sits in a separate throttle bucket so counter traffic never consumes the scan budget.

---

## Appendix: Complete Tool Index

**Legend:** 🟢 real analysis · 🟡 alias or heuristic · 🔴 stub or placeholder · 🔵 client-side

| Tool | Tier | Outbound | Status |
|---|---|---|---|
| website-analyzer | A | 1 | 🟢 9 weighted checks, true percentage |
| heading-analyzer | A | 1 | 🟢 H1–H6 hierarchy + gap detection |
| keyword-density-analyzer | A | 1 | 🟢 1/2/3-word density, accent-aware |
| broken-link-checker | A | ≤26 | 🟢 status per link, capped at 25 |
| redirect-checker | A | ≤10 | 🟢 hop-by-hop chain + loop detection |
| og-preview-generator | A | 1 | 🟢 OG/Twitter tags with fallbacks |
| ssl-certificate-checker | A | TLS | 🟢 real certificate parse |
| canonical-checker | A | 1 | 🟢 attribute-order caveat |
| image-alt-analyzer | A | 1 | 🟢 missing/empty/good, 100 max |
| domain-health-checker | A | 3 | 🟡 caps at 85; HTTPS double-counted |
| internal-link-analyzer | A | 1 | 🟢 counts only, no verification |
| robots-validator | A | 1 | 🟢 syntax + `Disallow: /` |
| sitemap-validator | A | 1 | 🟢 structure + URL count |
| mobile-friendly-test | A | 1 | 🟡 tap targets always pass |
| core-web-vitals-checker | A | 1 | 🟡 not real CWV |
| image-compression-analyzer | A | 1 | 🟡 extension-based, 20 max |
| meta-tag-generator | A | 1 | 🟢 mb-safe, escaped output |
| page-speed-analyzer | B | 1 | 🟡 alias → core-web-vitals |
| website-readiness-checker | B | 3 | 🟡 alias → domain-health |
| domain-authority-checker | B | 3 | 🔴 alias → domain-health, no DA |
| backlink-checker | B | 0 | 🔴 hardcoded score 50 |
| blog-title-generator | B | 0 | 🔴 templates + `rand()` scores |
| chatbot-script-generator | B | 0 | 🟡 static French script |
| landing-page-generator | B | 0 | 🟡 labelled framework |
| color-palette-generator | C | 0 | 🔵 canvas, server returns 400 |
| faq-schema-generator | C | 0 | 🔵 |
| schema-generator | C | 0 | 🔵 |
| local-business-schema | C | 0 | 🔵 |
| hreflang-generator | C | 0 | 🔵 |
| robots-txt-generator | C | 0 | 🔵 |
| xml-sitemap-generator | C | 0 | 🔵 |
| meta-refresh-generator | C | 0 | 🔵 |
| qr-code-generator | C | 0 | 🔵 |
| utm-builder | C | 0 | 🔵 |
| lorem-ipsum-generator | C | 0 | 🔵 |
| url-slug-generator | C | 0 | 🔵 |
| json-formatter | C | 0 | 🔵 |
| html-minifier | C | 0 | 🔵 |
| css-minifier | C | 0 | 🔵 |
| html-to-text | C | 0 | 🔵 |
| text-case-converter | C | 0 | 🔵 |
| base64-encoder | C | 0 | 🔵 |
| word-counter | C | 0 | 🔵 |
| readability-analyzer | C | 0 | 🔵 |
| duplicate-content-checker | C | 0 | 🔵 |
| nofollow-link-checker | C | 0 | 🔵 |

**Totals:** 46 tools — 17 real server-side analysis, 8 aliases/heuristics/stubs, 21 client-side.
