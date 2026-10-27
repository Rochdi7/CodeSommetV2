# SPEC-08 — Google Search Console connection and keyword reports

Features: FEATURE-034, -063 (New, Lost, Low-hanging, Branded, Cannibalization). Phase **F**.

## 1. Objective
Let a logged-in user connect GSC read-only and get five opportunity reports computed from Search Analytics data.

## 2. User stories
- As a site owner, I connect GSC once and pick a property.
- I see keywords I gained, lost and nearly rank for, brand queries, and queries where several of my URLs compete.

## 3. Reference URLs
`/keywords/new`, `/keywords/lost`, `/keywords/low-hanging`, `/keywords/branded`, `/keywords/cannibalization`, `/tech-seo/gsc-audit`, `/gsc/*` (gated).

## 4. Evidence
The input-state screenshots `05-tool-inputs/keywords-*-input-desktop.png` show the connect card, the read-only scope explanation and the report definitions (observed copy). The OAuth flow itself was **not tested** (outward-facing).

## 5. Functional requirements
1. OAuth 2.0 with scope `https://www.googleapis.com/auth/webmasters.readonly`. Refresh token stored encrypted in `gsc_connections`.
2. Property picker (`sites.list`). Both domain and URL-prefix properties are supported.
3. Daily sync job: `searchanalytics.query` with dimensions `query,page,date`, the last 16 months on first sync, then incremental. Store in `gsc_rows` (aggregated per day).
4. Reports. The period defaults to the last 28 days vs. the previous 28 days:
   - **New:** queries with impressions > 0 in the current period and 0 in the previous one.
   - **Lost:** clicks or impressions > 0 in the previous period and 0 in the current one.
   - **Low-hanging:** average position between 4 and 30 and impressions ≥ a threshold (default 50). Sort by impressions × (1/position). (*Recommendation*; the reference says "around page 1–3".)
   - **Branded:** the query matches the brand terms the user configured (regex list, accent-insensitive).
   - **Cannibalization:** the same query with ≥ 2 pages each taking ≥ 10% of its impressions in the period. Show the pages with clicks, position and impression share.
5. Each report is a sortable, filterable table with CSV export.

## 6. Non-functional requirements
The sync respects GSC quotas with backoff. Reports read from local tables and return in under 1 s for 100k rows.

## 7. Input schema
`{"property":"sc-domain:codesommet.com","period":"28d|90d|custom","compare":"previous|yoy","brand_terms":["codesommet","code sommet"]}`

## 8. Output schema
`{"report":"low_hanging","rows":[{"query":"…","page":"…","clicks":3,"impressions":420,"ctr":0.007,"position":8.4,"delta_position":-1.2}],"totals":{…}}`

## 9. UI behaviour
When not connected, show a connect card (explain read-only access). Once connected, show a report table with a period selector and a property selector in the header (it maps to the "Select website" pattern).

## 10. Backend behaviour
`SyncGscPropertyJob` runs daily (scheduler). Report queries are SQL aggregates over `gsc_rows`.

## 11. Database changes
```
gsc_connections(id, user_id, google_sub, refresh_token encrypted, scopes, created_at)
gsc_properties(id, connection_id, site_url, permission, last_synced_at)
gsc_rows(property_id, date, query, page, clicks, impressions, position) — index (property_id,date), (property_id,query)
```

## 12. External dependencies
Google Search Console API (free; quota-limited), Google OAuth client (Socialite).

## 13. Validation rules
Period ≤ 16 months. Brand terms ≤ 20.

## 14. Error handling
Revoked token: mark the connection `needs_reauth` and show a reconnect banner. Quota errors: retry with exponential backoff.

## 15. Security
Read-only scope only. Encrypted tokens. Rows scoped by user to prevent IDOR.

## 16. Accessibility
Standard data-table requirements (conventions).

## 17. Test cases
Fake the API: a first sync stores rows; each report's SQL produces the expected sets on a fixture dataset (one new, one lost, a cannibalised query with 2 pages); revoked token handling.

## 18. Acceptance criteria
Connecting the codesommet.com property (owner's account) produces all five reports, and the numbers match the GSC UI totals within GSC's own sampling rules.

## 19. Implementation dependencies
FEATURE-001 accounts (Phase G minimal), SPEC-01.

## 20. Known unknowns
The reference's exact thresholds (not public). The reference's Bing/Yandex bulk analysis (gated) is out of scope here.
