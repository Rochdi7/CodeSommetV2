# Keyword research with Semrush — SOP

Cost-controlled, fresh-when-asked keyword research for CodeSommet (codesommet.com). One `seo:keywords`
invocation is one **research run**: it has its own unit budget, call limit,
in-run deduplication and a usage log entry per live call.

Semrush data is reached through its MCP endpoint (`mcp.semrush.com/v1/mcp`).
The key lives in `.env` as `SEMRUSH_API_KEY` and is never printed or logged.

## 1. Before you query

Write down, in this order, and reuse what the conversation already gave you:

| Item | CodeSommet default |
|---|---|
| Business | CodeSommet, agence de développement web (sites sur mesure, e-commerce, SaaS, SEO) |
| Country / database | Morocco → `--db=ma` (France `fr` only as a separate market, never merged) |
| Language | French queries (`--lang=fr`), Arabic/German where relevant |
| Topic | e.g. "agence web casablanca", "création site web maroc", "développement e-commerce" |
| Goal | discovery / validation / clustering / full report |

Never query a second country "because it has more data". `ma` is thin for
niche phrases; report that, do not substitute `fr` volumes.

## 2. Report choice (cheapest useful first)

| Task | `--type` | Semrush report | Measured cost (2026-10-19, `ma`/`fr`) |
|---|---|---|---|
| Validate known seeds (up to 100, one call) | `validate` | `phrase_these` | 10 units per keyword *returned* (keywords with no data are omitted and not billed) |
| Exact one keyword | `overview` | `phrase_this` | see usage log |
| Discover variants / modifiers | `broad` | `phrase_fullsearch` | 20 units/row |
| Semantic expansion | `related` | `phrase_related` | 40 units/row |
| Informational ideas | `questions` | `phrase_questions` | see usage log |
| Ranking feasibility (shortlist only) | `kd` | `phrase_kdi` | **50 units/keyword** (measured 2026-10-21) |
| Who ranks (shortlist only) | `serp` | `phrase_organic` | see usage log |

Costs are historical observations from `storage/app/seo/semrush-usage.jsonl`,
not a price list. `--estimate` prints an estimate from that log before any call.

## 3. Progressive expansion

1. 2–3 seeds → `--type=broad --limit=20` on the target database.
2. Shortlist by relevance and intent (drop wrong-intent: "berger allemand", "traduction …").
3. Validate the shortlist in one batch: `--type=validate "kw1;kw2;kw3"`.
4. Only if the shortlist is thin: one `related` or `questions` call on the best seed.
5. `kd` / `serp` only for the final candidates where it changes the priority.
6. Stop when the decision is defensible. A bigger spreadsheet is not a goal.

## 4. Fresh vs cached vs historical

| Term | Meaning in this workflow |
|---|---|
| Fresh API retrieval | A new Semrush call was made in this run (`Live Semrush retrieval at …`). |
| Cached | Identical report served from the local cache (`Served from cache (originally retrieved …)`), TTL `SEMRUSH_CACHE_TTL_HOURS` (default 24). |
| Historical | A previous snapshot CSV, labelled with its own `retrieved_at`. |
| Fresh database data | **Not verifiable.** The Semrush MCP response carries no database-update date. Every result says: *"Semrush report retrieved at [time]. The exact update date of the underlying search-volume data was not available."* |

- `--fresh` bypasses the local cache for the reports in that run only. It does
  not make Semrush refresh its own volumes; an unchanged volume is reported unchanged.
- Within one run identical reports are never sent twice, even with `--fresh`.
- If a refresh fails, the previous snapshot is still on disk under its original date;
  the command never swaps in a different database or provider.

## 5. Budget and usage

- Defaults: `SEMRUSH_BUDGET_UNITS=1000`, `SEMRUSH_MAX_CALLS=10` per run. Override with `--budget` / `--max-calls`.
- The check runs **before** each live call, using the measured units/row from the usage log to estimate the call. A report with no price history may request at most 3 rows unless `--allow-unmeasured` is passed (lesson from 2026-10-21: an unmeasured `phrase_kdi` call cost 600 units in one go). On a stop the command prints which
  report it wanted next and exits with code 2. Cached results are never blocked.
- Units are read from each response's `metadata.usage.api_units`. If a response
  lacks it the run total is reported as **unknown (≥ known part)**, never zero.
- Remaining account balance is **not exposed** by this API (the v3 balance endpoint
  rejects PAT keys). Read it in Semrush → Subscription info.
- Every live call is appended to `storage/app/seo/semrush-usage.jsonl`
  (report, db, phrase, rows, units, timestamps). No credentials.
- Retries: only when Semrush flags `retryable: true` or returns HTTP 429, max 2,
  short backoff. `no_data` and `validation_failed` are never retried.

## 6. Outputs

- Console table, or `--csv=path`, or `--snapshot` →
  `storage/app/seo/keywords/<db>/<seed>-<type>-<timestamp>.csv` plus a diff
  (NEW / MISSING / VOLUME) against the previous snapshot for the same seed+type.
- CSV columns, always in this order:
  `keyword;database;language;search_volume;cpc;competition;keyword_difficulty;intent;source_report;retrieved_at;data_freshness;notes`
- `competition` is Semrush's paid-competition index (0–1). `intent` is a
  rule-based heuristic and is labelled as such. Blank = not returned by that report.

## 7. Commands

```bash
# cost estimate from past measured calls, no API call
php artisan seo:keywords "cours allemand" --db=ma --type=broad --limit=20 --estimate

# discovery, cached if run in the last 24 h
php artisan seo:keywords "cours allemand" --db=ma --type=broad --limit=20 --snapshot

# force a new Semrush lookup and diff against the last snapshot
php artisan seo:keywords "cours allemand" --db=ma --type=broad --limit=20 --snapshot --fresh

# validate a shortlist in one batch call
php artisan seo:keywords "cours allemand casablanca;cours a1 allemand;apprendre allemand maroc" --db=ma --type=validate --lang=fr --csv=storage/app/seo/shortlist.csv

# tighter safeguards for an exploratory run
php artisan seo:keywords "examen goethe" --db=ma --type=related --limit=10 --budget=300 --max-calls=2
```

Tests (zero units): `./vendor/bin/phpunit tests/Unit/SemrushServiceTest.php`.

## 8. Skills to use with the data

- `/seo cluster plan <seed>` (claude-seo) for SERP-overlap clustering of the shortlist.
- `/seo plan` (claude-seo) for the strategy layer.
- aaron-seo-geo `keyword-research` for intent taxonomy and prioritisation scoring.
- Neither skill talks to Semrush; feed them the snapshot CSV.
