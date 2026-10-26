---
name: semrush-keywords
description: Cost-controlled Semrush keyword research for CodeSommet (web dev agency; Morocco `ma` primary, French queries; `fr` only as a separate market). Use when asked for keyword research, search volume, keyword ideas, "fresh Semrush data", or to validate/compare keyword volumes. Enforces seed-first, cheapest-report-first, unit budget, and honest freshness labelling.
user-invokable: true
argument-hint: "<seed keyword> [--db=ma] [--fresh]"
---

# Semrush keyword research (CodeSommet)

Full SOP: `docs/seo-keyword-research.md`. Follow it; this file is the short form.

## Data sources, in order of preference

1. `php artisan seo:keywords …` (Bash) — cached, deduplicated, budgeted, logs usage, writes snapshots. **Default.**
2. MCP server `semrush-api` tools (`keyword_research` → `get_report_schema` → `execute_report`) — only for one-off lookups the command does not cover. Same rules apply; note the `api_units` from each response in your answer.
3. claude-seo `/seo cluster` and `/seo plan`, aaron `keyword-research` — for clustering, intent and prioritisation. They do not talk to Semrush; feed them the CSV.

Never: DataForSEO (not connected), WebSearch volumes, or numbers from memory.

## Protocol

1. State business, database (`ma` for Morocco; `fr` only as a separate market), language, topic, goal. Ask only if a missing item changes the result.
2. If the user wants a cost preview: `--estimate` first (no API call).
3. Start with 2–3 seeds, `--type=broad --limit=20`. Shortlist. Validate the shortlist with ONE `--type=validate "a;b;c"` call. Expand (`related`, `questions`) only if the shortlist is thin. `kd`/`serp` for finalists only.
4. Use `--fresh` only when the user asks for fresh/new/live Semrush data. Otherwise the 24 h cache is fine and must be reported as cached.
5. Use `--snapshot` so the next run can diff. Report NEW / MISSING / VOLUME changes.
6. Stop when the decision is defensible, or when the command prints `BUDGET STOP`. On a stop, tell the user which report it wanted next and why it would help; do not raise `--budget` on your own.

## Reporting rules

- Always include: database, retrieval timestamp, whether cached or live, API units used this run, and the line *"The exact update date of the underlying search-volume data was not available."*
- Never merge or add volumes across databases. Never put `fr` volumes in a `ma` column.
- `no_data` is final: say so, do not try another report/database to manufacture a number.
- Remaining account balance is not exposed by the API; point to Semrush → Subscription info.
- Never print, quote or store the API key. If a tool output shows it, do not repeat it.
