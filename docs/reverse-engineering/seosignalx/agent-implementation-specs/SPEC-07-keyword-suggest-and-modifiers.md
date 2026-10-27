# SPEC-07 — Keyword Suggest (A–Z / 0–9) and modifier explorer

Features: FEATURE-060, -061 (and the provider seam for -062). Phase **F**. Workflow: [../workflows/06-keyword-research.md](../workflows/06-keyword-research.md).

## 1. Objective
Expand a seed keyword into long-tail ideas from search autocomplete, grouped by letter or digit and by question, preposition and comparison modifiers, with copy and CSV export.

## 2. User stories
- As a content planner, I enter "création site web" with country France and get grouped long-tail ideas.
- As a planner, I switch to the Questions view to find FAQ topics.

## 3. Reference URLs
`/keywords/suggest`, `/keywords/ubersuggest`.

## 4. Evidence
The Suggest and Ubersuggest valid rows (PASS). Observed details:

- Suggest: 15 seed suggestions, then `+A … +Z` and digit groups.
- Ubersuggest: "Questions 37 · Prepositions 100 · Comparisons 45", groups who/what/where/when/why/how/can/are/is/which, "182 keyword ideas fetched from Google autocomplete".
- Many `/api/autocomplete` calls per run.

## 5. Functional requirements
1. Inputs: seed (2–80 chars), country (at least FR, MA, US, GB, CA, BE, CH, AE), language (fr/en/ar).
2. Suggest mode queries the seed, then `seed + {a..z}` and `seed + {0..9}`, de-duplicates, and keeps each group's order.
3. Modifier mode uses templates:
   - Questions: who, what, where, when, why, how, can, are, is, which, plus FR equivalents: qui, quoi, où, quand, pourquoi, comment, est-ce
   - Prepositions: for, with, without, to, near, vs, like, pour, avec, sans, près de
   - Comparisons: vs, versus, or, and, like, ou, contre
   - Each template is run as both `modifier + seed` and `seed + modifier`.
4. Output groups with counts. Copy group, Copy all and CSV export.
5. Cache results per (seed, country, language) for 7 days.
6. The provider is behind a `KeywordSuggestionProvider` interface. Implementations: `DataForSeoAutocompleteProvider` (*Recommendation*) or another licensed SERP API (DR-2). **Do not** call `suggestqueries.google.com` directly in production (R-05).

## 6. Non-functional requirements
At most 50 provider calls per run, concurrency 5, and a P95 under 8 s. Calls are counted against the user's credit ledger (SPEC-01 / plans).

## 7. Input schema
`{"seed":"semantic seo","country":"US","language":"en","mode":"letters|modifiers"}`

## 8. Output schema
```json
{"seed":"semantic seo","total":182,"groups":[{"key":"seed","label":"Suggestions","items":["semantic seo tool",…]},
 {"key":"a","label":"+A","items":[…]},{"key":"q:what","label":"what","items":[…]}],"provider":"dataforseo","cached":false}
```

## 9. UI behaviour
The button is disabled while the seed is empty. A progress bar reflects provider calls as they complete. Groups render as collapsible cards with a count and "No suggestions" when empty (observed). A Visualization tab (*Recommendation*: a simple radial or tree view, P3) sits next to the Data tab.

## 10. Backend behaviour
Queued if more than 10 provider calls are needed. Results stream progressively (partial result updates through the run polling).

## 11. Database changes
`keyword_suggestion_cache(hash PK, provider, payload json, expires_at)`.

## 12. External dependencies
A licensed autocomplete/SERP provider (DR-2).

## 13. Validation rules
Seed is trimmed and has at least 2 characters. No URL validation; the reference correctly accepts any text.

## 14. Error handling
On partial provider failure, render the successful groups plus a "N groups failed" note. `provider_error` if all fail. `quota_exceeded` when credits run out.

## 15. Security
Provider keys are kept in `.env`/encrypted settings and never exposed. Throttle per user.

## 16. Accessibility
Groups use `<section>` with headings, and copy buttons announce "Copied".

## 17. Test cases
- The provider is faked with `Http::fake`: 37 calls for letters mode, groups assembled in order, de-duplication across groups.
- Cache hit avoids provider calls.
- A partial failure renders a partial result.
- An empty seed returns 422.

## 18. Acceptance criteria
- A CSV with group and keyword columns.
- FR seed with country FR returns French suggestions (manual check).
- The provider can be swapped by config.

## 19. Implementation dependencies
SPEC-01. The DR-2 decision.

## 20. Known unknowns
Provider pricing and rate limits, to be confirmed at selection time. The reference's exact modifier lists (only group names are observed).
