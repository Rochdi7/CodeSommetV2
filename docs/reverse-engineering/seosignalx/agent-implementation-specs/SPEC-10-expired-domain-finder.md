# SPEC-10 — Expired Domain Finder (RDAP + DNS)

Feature: FEATURE-050. Phase **E**. Workflow: [../workflows/07-expired-domain-finder.md](../workflows/07-expired-domain-finder.md).

## 1. Objective
Bulk-check up to 50 domains for registration status, registrar, creation and expiry dates and DNS resolution, using registry data only.

## 2. User stories
- As a link builder, I paste 50 candidate domains and see which are available, with an exportable list.
- As a buyer, I see how long registered domains have until they expire.

## 3. Reference URLs
`/off-page/expired-domains`.

## 4. Evidence
Valid test (PASS), observed on example.com, iana.org and an unregistered domain:

- One `/api/domain-status` call, about 3 s.
- Rows: "DNS resolves / No DNS", registrar, "since 1995", "expires 13/08/2027", "Registry has no record of this domain".
- Counters: All / Available / Registered / Unknown.
- Insights: availability rate, DNS resolving, median age, expiring ≤30 d, expiry runway histogram, domain-age histogram, status by TLD.

## 5. Functional requirements
1. Parse the input: lines, commas and spaces. Accept URLs (extract the host) and IDNs (punycode). De-duplicate. Maximum 50.
2. Per domain, look up RDAP through the IANA bootstrap (`https://data.iana.org/rdap/dns.json`, cached 24 h). Extract events (`registration`, `expiration`, `last changed`), registrar entity name and status array.
3. DNS check: `dns_get_record($d, DNS_A|DNS_AAAA|DNS_NS)`.
4. Classification:
   - `registered`: RDAP 200
   - `available`: RDAP 404 and no NS records
   - `unknown`: TLD without RDAP, timeout or an inconsistent answer. Show the reason.
5. Insights computed client-side from the result (the reference shows the same set).
6. Actions: filter chips, Copy available, CSV export, and "Verify" (re-check one row).

## 6. Non-functional requirements
Concurrency of 10 RDAP requests. Per-registry rate limits are respected (back off on 429). P95 under 10 s for 50 domains.

## 7. Input schema
`{"domains":"example.com\niana.org\n…"}`

## 8. Output schema
```json
{"summary":{"total":3,"available":1,"registered":2,"unknown":0},
 "rows":[{"domain":"example.com","status":"registered","registrar":"RESERVED-Internet Assigned Numbers Authority",
  "created":"1995-08-14","expires":"2027-08-13","dns":true,"rdap_server":"https://rdap.verisign.com/com/v1/","reason":null}]}
```

## 9. UI behaviour
The button is disabled while empty, and Ctrl+Enter submits (observed). Results show colour-coded status pills plus text labels.

## 10. Backend behaviour
Synchronous up to 10 domains, otherwise queued with progress.

## 11. Database changes
`rdap_cache(domain PK, payload json, fetched_at)` with a TTL of 12 h.

## 12. External dependencies
Public RDAP servers (free), system DNS.

## 13. Validation rules
Each token must be a syntactically valid hostname with a public suffix (PSL). Invalid tokens are listed back as "invalid" and are not silently dropped.

## 14. Error handling
Per-row `unknown` with a reason. The whole run never fails because of one domain.

## 15. Security
RDAP hosts come only from the IANA bootstrap (no user-supplied URLs fetched).

## 16. Accessibility
Status is conveyed by text as well as colour.

## 17. Test cases
`Http::fake` RDAP 200, 404 and 429; a DNS stub; IDN input; URL input; more than 50 tokens → 422; a TLD with no RDAP → unknown.

## 18. Acceptance criteria
The three reference test domains reproduce the observed classifications.

## 19. Implementation dependencies
SPEC-01.

## 20. Known unknowns
None that block. The marketing claims about DA/PA, spam score and WHOIS for 300+ TLDs were **not observed** in the tool and are out of scope.
