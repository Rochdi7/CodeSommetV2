# SEOSignalX: public-surface reverse-engineering and build blueprint

**What this is:** a reproducible, evidence-backed study of https://seosignalx.com/ (an SEO SaaS) as an anonymous visitor on **2026-10-26**. It was carried out with Selenium and translated into specs for building comparable, **independently implemented** features in the codesommet.com Laravel app.

Start with [EXECUTIVE_SUMMARY.md](EXECUTIVE_SUMMARY.md).

## What was investigated

- **Routes:** 188 discovered (public JS router table + rendered links + probes). 89 render publicly, 60 redirect to login, 11 are client redirects and 28 were deliberately not visited (admin, OAuth, payment, `:id` routes). See [route-inventory.md](route-inventory.md) and [ROUTE_INVENTORY.csv](ROUTE_INVENTORY.csv).
- **Tools:** about 80 public tool routes inspected. Each has an input-state capture plus empty, valid and malformed-input cases where meaningful. See [TEST_RESULTS.md](TEST_RESULTS.md) and [test-matrix.csv](test-matrix.csv).
- **Marketing, pricing, FAQ, design tokens, app-shell geometry and the reference site's own SEO.**

## What remains inaccessible

Everything behind login: Site Auditor, Brand Radar, GSC Insights, dashboard, settings, LMS and MCP. Also the paywalled AI writer/chat, the OAuth flows (GSC, Bing) and real AI output (anonymous users get template fallbacks). See [RISKS_AND_UNKNOWNs.md](RISKS_AND_UNKNOWNs.md) U-01 to U-09. **No account was created and nothing was submitted** beyond benign tool inputs.

## Verified vs. inferred

Each document labels its claims as **Observed**, **Inferred — rationale**, **Not verified — reason**, or **Recommendation** (our design). Marketing numbers ("60+ tools", "312% lift", "2,000+ URLs") are quoted as claims only. Evidence IDs (PAGE-, TEST-, SHOT-, OBS-, FEATURE-, SEO-) resolve through [raw-observations/EVIDENCE_INDEX.md](raw-observations/EVIDENCE_INDEX.md).

## Folder map

| Path | Purpose |
|---|---|
| [EXECUTIVE_SUMMARY.md](EXECUTIVE_SUMMARY.md) | One-page findings and recommendations |
| [RESEARCH_METHODOLOGY.md](RESEARCH_METHODOLOGY.md) | How routes were discovered and tools tested; evidence rules |
| [ENVIRONMENT_AND_RUNBOOK.md](ENVIRONMENT_AND_RUNBOOK.md) | Environment, scripts and exact commands |
| [route-inventory.md](route-inventory.md) / [ROUTE_INVENTORY.csv](ROUTE_INVENTORY.csv) | Every route with access, metadata and screenshot |
| [FEATURE_INVENTORY.csv](FEATURE_INVENTORY.csv) | 75 features with inputs, outputs, backend, data, priority and evidence |
| [test-matrix.csv](test-matrix.csv) / [TEST_RESULTS.md](TEST_RESULTS.md) | Each test case with its status; summary and notable defects |
| [reference-site-seo-audit.md](reference-site-seo-audit.md) | The competitor's own SEO (13 verified defects) |
| [technical-observations.md](technical-observations.md) | Stack, API surface, hosting, auth, performance (OBS-001…020) |
| [design-system-observations.md](design-system-observations.md) | Tokens, app-shell anatomy, components, responsive, accessibility |
| [data-model-and-algorithm-notes.md](data-model-and-algorithm-notes.md) | Per-tool data models, inferred algorithms, data sources |
| [FEATURE_GAP_ANALYSIS.md](FEATURE_GAP_ANALYSIS.md) | Reference vs. our 46 existing tools |
| [IMPLEMENTATION_ROADMAP.md](IMPLEMENTATION_ROADMAP.md) | Architecture proposal, phases A–H, decisions required |
| [RISKS_AND_UNKNOWNs.md](RISKS_AND_UNKNOWNs.md) | Coverage gaps, legal, ethical and delivery risks |
| [workflows/](workflows/) | End-to-end workflow write-ups with Mermaid diagrams |
| [agent-implementation-specs/](agent-implementation-specs/) | 20-section specs per feature area (start with `00-CONVENTIONS.md`) |
| [screenshots/](screenshots/) | Visual references; index in [screenshots/README.md](screenshots/README.md) |
| [scripts/](scripts/) | Selenium and report tooling (re-runnable) |
| [raw-observations/](raw-observations/) | JSON evidence (no secrets, no cookies, no bundle copies) |

## How agents should use the specs

1. Read [agent-implementation-specs/00-CONVENTIONS.md](agent-implementation-specs/00-CONVENTIONS.md) (run API, check shape, validation, a11y, tests).
2. Build in roadmap order: SPEC-01 → SPEC-02 → the rest (each spec lists its dependencies in §19).
3. Treat "Observed" items as the behavioural target, "Recommendation" items as our design, and "Decision required" as blockers to escalate.
4. **Do not copy** reference code, copy, branding, icons or datasets (R-01, R-02). Screenshots are for reference only.
5. Reuse existing services (`SafeUrlValidator`, `SafeHttpFetcher`, `App\Services\Analysis`, `SeoApiClient`, `HeadlessRenderer`). Don't rebuild them.

| Spec | Area | Phase |
|---|---|---|
| [SPEC-01](agent-implementation-specs/SPEC-01-platform-foundations.md) | Run API, storage, shared UI, share/export | A |
| [SPEC-02](agent-implementation-specs/SPEC-02-site-crawler-core.md) | Site crawler core | B |
| [SPEC-03](agent-implementation-specs/SPEC-03-eeat-audit.md) | E-E-A-T Audit | C |
| [SPEC-04](agent-implementation-specs/SPEC-04-on-page-analyzer.md) | On-Page Analyzer / Page SEO | C |
| [SPEC-05](agent-implementation-specs/SPEC-05-robots-and-ai-crawler-access.md) | Robots analyzer + AI crawler access | B |
| [SPEC-06](agent-implementation-specs/SPEC-06-text-analysis-engine.md) | NLP / n-grams / entities | E |
| [SPEC-07](agent-implementation-specs/SPEC-07-keyword-suggest-and-modifiers.md) | Keyword suggest and modifiers | F |
| [SPEC-08](agent-implementation-specs/SPEC-08-gsc-keyword-reports.md) | GSC connection and keyword reports | F |
| [SPEC-09](agent-implementation-specs/SPEC-09-crawl-based-generators.md) | Sitemap / LLMs.txt / internal links / visualizer | B–D |
| [SPEC-10](agent-implementation-specs/SPEC-10-expired-domain-finder.md) | Expired domain finder | E |
| [SPEC-11](agent-implementation-specs/SPEC-11-seo-utilities-bundle.md) | Utilities bundle | E |
| [SPEC-12](agent-implementation-specs/SPEC-12-speed-and-bulk-pagespeed.md) | Speed test and bulk PSI | C/D |
| [SPEC-13](agent-implementation-specs/SPEC-13-site-auditor.md) | Site Auditor (low confidence) | D |
| [SPEC-14](agent-implementation-specs/SPEC-14-geo-page-analyzers.md) | GEO page analyzers | C |
| [SPEC-15](agent-implementation-specs/SPEC-15-technical-page-checks.md) | Crawl optimisation, security, schema, semantic, duplicate | C/D |
| [SPEC-16](agent-implementation-specs/SPEC-16-ai-generation-service.md) | AI generation service | F |

## Re-running the research

Run these from this folder. On Windows, set `$env:PYTHONIOENCODING='utf-8'` first. Details are in [ENVIRONMENT_AND_RUNBOOK.md](ENVIRONMENT_AND_RUNBOOK.md).

```powershell
python scripts/extract_bundle_routes.py      # route candidates from the public bundle
python scripts/inspect_pages.py --fresh      # inspect all routes (resumable; ~30 min)
python scripts/generate_inventory.py         # ROUTE_INVENTORY.csv + route-inventory.md
python scripts/inspect_marketing.py          # pricing, FAQ, tokens
python scripts/capture_screenshots.py        # desktop + mobile library
python scripts/test_public_tools.py --fresh  # tool tests (~2–3 h; fresh browser per case)
python scripts/inspect_app_shell.py          # shell geometry, theme, selector, FAQ
python scripts/build_reports.py              # test-matrix, FEATURE_INVENTORY, indexes, link check
```

To re-test specific tools: `python scripts/test_public_tools.py --only /tech-seo/eeat /content/nlp`.

## Next investigations

1. A supervised logged-in session (owner's account, DR-7) for the Site Auditor, Brand Radar, GSC and real AI output.
2. A second-site check of the inferred E-E-A-T formula (unweighted pass rate).
3. The Text-mode runs of the content tools, and the LLMs.txt generation step.
