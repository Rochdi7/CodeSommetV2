# Research methodology

## Scope

The scope is the publicly reachable surface of https://seosignalx.com/ as an anonymous visitor on 2026-10-26. Anything behind the Firebase/`/api/auth` login wall was observed only up to the authentication boundary.

## Route discovery: four sources, reconciled

1. **Static discovery files.** `robots.txt`, `sitemap.xml`, `llms.txt`, `ads.txt` and `manifest.json` all return the SPA shell (`<div id="root">`, HTTP 200, 1,842 bytes). The site publishes **no** robots.txt and **no** sitemap. Evidence: `raw-observations/bundle-routes.json → static_file_probe`.
2. **Client router table.** The site is a single Vite/React bundle (`/assets/index-*.js`, about 1.7 MB) that is publicly served to every visitor. `extract_bundle_routes.py` extracts path literals used in `path:`, `to:`, `href:` and `navigate()`. It stores only the strings, not the bundle. This is the primary route source because nothing else lists the app routes.
3. **Rendered internal links.** Every inspected page records its `<a href>` targets. `generate_inventory.py` marks each route that also appears as a link (`discovery_source = internal-link`).
4. **Manual probes.** One non-existent path (`/this-page-does-not-exist-404-check`) was requested to observe 404 handling.

Routes from source 2 that are never linked publicly and redirect to `/login` are reported as **login-required**, not as orphans. Their link context is the authenticated app sidebar, which could not be observed.

## Page inspection

`inspect_pages.py` loads each route in headless Chrome. It waits until React has rendered into `#root` and the DOM length has stopped changing, then records:

- the final URL, which detects redirects such as the client-side redirect to `/login`
- the document HTTP status from the CDP performance log (always 200, because Cloudflare Pages serves the SPA fallback)
- title, all H1s, headings, meta description, canonical, robots meta, OG/Twitter tags and JSON-LD
- links (internal and external), inputs, buttons, images without alt text and landmark elements
- browser console warnings and errors, and the hosts of network requests
- Navigation Timing (TTFB, DCL, load) and paint timings
- a full-page screenshot for publicly rendered routes

Classification:

| Outcome | Meaning |
|---|---|
| `rendered` | Final path equals requested path; page content shown to an anonymous visitor |
| `auth-redirect` | Client router sent the anonymous visitor to `/login` |
| `redirect:<path>` | Any other client-side redirect |
| `skipped` | Deny-listed (admin/oauth/payment) or parameterised (`:id`) |
| `error` | Selenium failure (timeout etc.) — **not** evidence that the page is broken |

## Tool testing

A tool counts as **functionally tested** only if its output, or a clearly reproducible validation or error state, was observed and saved in `raw-observations/tool-tests.json` with a screenshot. The benign inputs were:

- domains `example.com`, `iana.org` and `codesommet.com` (owned by the user)
- short synthetic text written for the test

Edge cases per tool were empty input, malformed URLs and boundary-ish input where the UI suggested a limit.

## Evidence labels used throughout

- **Verified**: directly observed and stored as a raw observation or screenshot.
- **Inferred**: deduced from visible UI, marketing copy or public bundle strings. The rationale is stated each time.
- **Not verified — reason**: the feature could not be reached (normally because of the login wall).

Marketing claims such as "60+ tools", "312% avg lift" and "2,000+ URLs" are quoted as claims and never treated as measured facts.

## What was deliberately not done

- No account creation, login, password reset, newsletter signup or purchase.
- No direct calls to `/api/*` endpoints outside of what the page itself made during normal rendering.
- No vulnerability probing, header or cookie harvesting, or load generation.
- No copying of the target's source code, images or brand assets into our project. Screenshots are kept only as reference evidence inside this report folder.
