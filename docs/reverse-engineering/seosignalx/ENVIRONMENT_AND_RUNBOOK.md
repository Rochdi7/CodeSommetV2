# Environment & runbook

## Environment (research run 2026-10-26)

| Item | Value |
|---|---|
| Host OS | Windows 11 Home 10.0.26300 |
| Python | 3.11.15 (existing interpreter; no venv needed) |
| Selenium | 4.46.0 (already installed; **no dependencies were installed**) |
| Browser | Google Chrome 155.0.8059.86, headless (`--headless=new`), incognito |
| Driver | Resolved automatically by Selenium Manager |
| Desktop viewport | 1440×900 |
| Mobile viewport | 390×844 @2x, iPhone UA via `mobileEmulation` |
| Crawl delay | 3 s between page loads (`SSX_DELAY`), one browser at a time |
| Target | https://seosignalx.com/ (Cloudflare Pages SPA) |
| Host project | codesommet.com Laravel repo, branch `seo-remediation-2026-10-01`; only `docs/reverse-engineering/seosignalx/` was written |

## Limitations of the environment

- No SEOSignalX account was used. No account was created: registration needs a real email address and would agree to the target's terms on the user's behalf. That decision belongs to the project owner. See [RISKS_AND_UNKNOWNS.md](RISKS_AND_UNKNOWNS.md).
- The browser runs in incognito mode, so cookies and storage are discarded after each run and nothing sensitive persists.
- `robots.txt`, `sitemap.xml` and `llms.txt` do not exist on the target. Every unknown path returns the SPA shell with HTTP 200. Bundle routes therefore stand in for a sitemap (see the methodology).

## Scripts

Run all commands from `docs/reverse-engineering/seosignalx/`. On Windows, set `PYTHONIOENCODING=utf-8` first (`$env:PYTHONIOENCODING='utf-8'` in PowerShell).

| Script | Purpose | Output |
|---|---|---|
| `scripts/ssx_common.py` | Shared helpers: driver factory, SPA wait, metadata extraction, console and network capture, scroll-reveal full-page screenshots, domain allowlist and deny-list | — |
| `scripts/extract_bundle_routes.py` | Reads the public entry JS bundle and extracts router paths. Also probes robots.txt, sitemap.xml and similar files | `raw-observations/bundle-routes.json` |
| `scripts/inspect_pages.py` | Visits every route candidate and records title, H1, meta, canonical, robots, links, inputs, buttons, console errors, request hosts, timing and auth gating. Writes a working screenshot per public page to `screenshots/_pages/`, which is deleted after the organised library is built. **Resumable** | `raw-observations/pages.json` |
| `scripts/generate_inventory.py` | Turns pages.json into the route inventory and links each public route to its library screenshot | `ROUTE_INVENTORY.csv`, `route-inventory.md` |
| `scripts/inspect_marketing.py` | Full text of the marketing pages, pricing (monthly/yearly), FAQ, nav hover states and computed tokens | `raw-observations/marketing.json`, `screenshots/02-*`, `07-*` |
| `scripts/capture_screenshots.py` | Builds the organised desktop and mobile screenshot library after scroll-reveal | `screenshots/0X-*/`, `raw-observations/screenshots.json` |
| `scripts/test_public_tools.py` | Functional tests of the public tools with benign inputs (input / empty / valid / malformed). **A fresh incognito browser per case**, because the app persists the last site in client storage | `raw-observations/tool-tests.json`, `screenshots/05-*/06-*/08-*/10-*` |
| `scripts/manual_checks.py` | Targeted probes the harness cannot judge (Robots Generator input remount, Text Editor transforms, Bot Viewer placeholder) | updates `tool-tests.json`, adds screenshots |
| `scripts/inspect_app_shell.py` | App-shell geometry at 1440/1024/768/390, light theme, website selector, tool search, mobile menu, FAQ answers | `raw-observations/app-shell.json`, `screenshots/02-navigation/` |
| `scripts/features.py` | The feature master list (data, not a runnable script) | used by build_reports |
| `scripts/build_reports.py` | Builds the test matrix (with status rules and evidence annotations), the feature inventory, the screenshot and evidence indexes and the TEST_RESULTS totals, and validates every relative link and screenshot reference | `test-matrix.csv`, `FEATURE_INVENTORY.csv`, `screenshots/README.md`, `raw-observations/EVIDENCE_INDEX.md`, `TEST_RESULTS.md` |

### Full re-run

```powershell
$env:PYTHONIOENCODING='utf-8'
python scripts/extract_bundle_routes.py          # 1. route candidates
python scripts/inspect_pages.py --fresh          # 2. ~190 routes, ~30 min
python scripts/inspect_pages.py --paths /this-page-does-not-exist-404-check
python scripts/generate_inventory.py             # 3. inventory
python scripts/inspect_marketing.py              # 4. pricing / FAQ / tokens
python scripts/capture_screenshots.py            # 5. screenshot library
Remove-Item -Recurse screenshots/_pages          #    (working captures, superseded)
python scripts/generate_inventory.py             #    re-link inventory to the library
python scripts/test_public_tools.py --fresh      # 6. functional tests (~2-3 h)
python scripts/manual_checks.py                  # 7. targeted probes
python scripts/inspect_app_shell.py              # 8. shell geometry, theme, FAQ
python scripts/build_reports.py                  # 9. matrix, features, indexes, link check
```

### Partial runs

```powershell
python scripts/inspect_pages.py --max 25                  # resume, 25 pages per run
python scripts/inspect_pages.py --paths /seo-tools /login # re-inspect specific paths
python scripts/capture_screenshots.py --only mobile
python scripts/test_public_tools.py --only /seo-tools/word-counter /tech-seo/eeat --cases input,valid
```

## Safety controls built into the scripts

- Domain allowlist: `seosignalx.com` only. External links are recorded but never opened.
- Deny-list: `/admin*`, `/oauth*`, `*/oauth-callback`, `/billing` and `/settings/stripe` are never visited.
- Parameterised routes (`:id`) are skipped because they would need guessed IDs.
- Login, registration, newsletter, payment and "forgot password" forms are **never submitted**. Only empty-submit validation is exercised.
- Tool tests use `example.com`, `iana.org` and the user's own domain `codesommet.com`, plus short synthetic text.
- No request headers, cookies or tokens are written to disk. The performance log is reduced to host names and the document status.
