# Workflow: Expired Domain Finder

**Reference URL:** `/off-page/expired-domains` (FEATURE-050). This is also the default landing page for `/off-page`.
**User objective:** check whether domains are available or registered, and when they expire.

## Steps (observed)

1. Header badge "LIVE RDAP · DNS". The copy reads: "Check live registry records and DNS resolution for up to 50 domains at once … nothing is simulated or guessed". Feature pills: No simulated availability · Registry-sourced dates · CSV export.
2. Textarea (one per line; accepts bare domains, URLs and comma-separated lists), plus **Import file**, **Clear** and **Check availability** (Ctrl+Enter). The button is disabled while the field is empty.
3. Input: `example.com`, `iana.org`, `codesommet-research-unregistered-zz91.com` → one `/api/domain-status` call (200), about 3 s.
4. Results:
   - Counter chips: **All 3 · Available 1 · Registered 2 · Unknown 0**. Actions: Copy available, CSV.
   - Each row shows the domain, DNS state ("DNS resolves" / "No DNS"), registrar ("RESERVED-Internet Assigned Numbers Authority", "CSC Corporate Domains, Inc."), "since 1995" and "expires 13/08/2027". For the unregistered domain: "Registry has no record of this domain", with a **Verify** action.
   - An **Insights** panel "built from this lookup's registry and DNS data": availability rate 33%, DNS resolving 2/3, median domain age 31 yrs, "Expiring ≤30 days: nothing close to dropping", an expiry-runway histogram (Past, ≤30d, 1–3m, 3–6m, 6–12m, 1–2y, 2y+), a domain-age histogram (<1 to 20+ yrs) and status by TLD.
5. Malformed input `not a url ::` → a validation message (PASS).

## Inferred implementation

RDAP lookup via the IANA bootstrap registry, plus a DNS A/NS query per domain, done server-side in one batch call (`/api/domain-status`). "Available" = RDAP 404 and no DNS. "Unknown" = RDAP unsupported or an error.

## Development implications

- This is a quick win with no paid dependency. PHP can query RDAP over HTTPS and DNS through `dns_get_record`.
- The marketing claims "Moz DA/PA metrics", "WHOIS for 300+ TLDs" and "spam score filtering" were **not observed** in the tool. Do not spec them from the copy.
- Spec: [../agent-implementation-specs/SPEC-10-expired-domain-finder.md](../agent-implementation-specs/SPEC-10-expired-domain-finder.md).
