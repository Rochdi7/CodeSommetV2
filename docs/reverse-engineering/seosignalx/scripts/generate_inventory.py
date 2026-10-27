"""Build ROUTE_INVENTORY.csv + route-inventory.md from raw-observations/pages.json.

Usage: python scripts/generate_inventory.py
"""
import csv
import json
from collections import Counter, defaultdict

from ssx_common import RAW, ROOT, SHOTS, slug


def library_shot(path, fallback):
    """Prefer the organised screenshot library over the crawl's _pages capture."""
    if path.startswith("/#"):
        path = "/"  # hash anchors are the homepage
    hits = sorted(p for p in SHOTS.glob(f"0*/{slug(path)}-desktop-full.png"))
    return hits[0].relative_to(ROOT).as_posix() if hits else (fallback or "")

SECTION = {
    "": "marketing", "#": "marketing-anchor", "lifetime-deal": "pricing", "upgrade": "pricing",
    "login": "authentication", "register": "authentication", "onboarding": "authentication",
    "privacy": "legal", "terms": "legal", "auditor": "site-audit", "gsc": "search-console",
    "tech-seo": "technical-seo", "technical-seo": "technical-seo", "on-page": "on-page-seo",
    "off-page": "off-page-seo", "keywords": "keyword-research", "content": "content-creation",
    "semantic-seo": "semantic-seo", "resources": "semantic-seo", "schema-seo": "schema-seo",
    "local-seo": "local-seo", "seo-tools": "seo-utilities", "geo": "geo-ai-search",
    "brand-radar": "brand-radar", "lms": "lms-courses", "mcp": "integrations",
    "settings": "account", "billing": "account", "dashboard": "app-dashboard", "admin": "admin",
    "oauth": "integrations",
}


def section(path):
    head = path.lstrip("/").split("/")[0].split("?")[0]
    if head.startswith("#"):
        return SECTION["#"]
    return SECTION.get(head, "other")


def access(rec):
    if rec.get("status") != "inspected":
        return "not-visited"
    o = rec.get("outcome", "")
    if o == "auth-redirect":
        return "login-required"
    if o.startswith("redirect"):
        return "redirected"
    return "public"


def main():
    pages = json.loads((RAW / "pages.json").read_text(encoding="utf-8"))
    bundle = set(json.loads((RAW / "bundle-routes.json").read_text(encoding="utf-8"))["routes"])
    linked_from = defaultdict(set)
    for p, r in pages.items():
        for l in r.get("internal_links", []):
            linked_from[l].add(p)

    rows = []
    for i, (p, r) in enumerate(sorted(pages.items()), 1):
        src = []
        if p in bundle:
            src.append("js-router-bundle")
        if linked_from.get(p):
            src.append("internal-link")
        if not src:
            src.append("manual-probe")
        acc = access(r)
        tool = bool(r.get("inputs")) and acc == "public" and section(p) not in ("marketing", "authentication", "legal", "pricing")
        rows.append({
            "page_id": f"PAGE-{i:03d}", "url": "https://seosignalx.com" + p, "requested_path": p,
            "final_path": r.get("path", ""), "discovery_source": "+".join(src), "section": section(p),
            "access": acc, "http_status": r.get("http_status", ""), "title": r.get("title", ""),
            "h1": " | ".join(r.get("h1", []) or []), "meta_description": r.get("description", "") or "",
            "canonical": r.get("canonical", "") or "", "robots": r.get("robots", "") or "",
            "has_interactive_tool": "yes" if tool else ("unknown" if acc == "login-required" else "no"),
            "linked_from_count": len(linked_from.get(p, [])),
            "internal_links_out": len(r.get("internal_links", [])), "render_seconds": r.get("render_seconds", ""),
            "console_errors": len([c for c in r.get("console", []) if c["level"] == "SEVERE"]),
            "screenshot": library_shot(p, r.get("screenshot")) if acc == "public" else "", "inspection_status": r.get("status"),
            "notes": r.get("reason") or r.get("error") or ("outcome=" + r.get("outcome", "")),
        })

    out = ROOT / "ROUTE_INVENTORY.csv"
    with out.open("w", newline="", encoding="utf-8") as f:
        w = csv.DictWriter(f, fieldnames=list(rows[0].keys()))
        w.writeheader()
        w.writerows(rows)

    by_acc = Counter(r["access"] for r in rows)
    by_sec = defaultdict(Counter)
    for r in rows:
        by_sec[r["section"]][r["access"]] += 1
    titles = Counter(r["title"] for r in rows if r["access"] == "public")
    lines = ["# Route inventory — seosignalx.com", "",
             f"Generated from `raw-observations/pages.json` by `scripts/generate_inventory.py`. "
             f"Full data: [ROUTE_INVENTORY.csv](ROUTE_INVENTORY.csv).", "",
             "## Totals", "", "| Access | Routes |", "|---|---|"]
    lines += [f"| {k} | {v} |" for k, v in sorted(by_acc.items())]
    lines += [f"| **total** | **{len(rows)}** |", "", "## By section", "",
              "| Section | public | login-required | redirected | not-visited |", "|---|---|---|---|---|"]
    for s, c in sorted(by_sec.items()):
        lines.append(f"| {s} | {c['public']} | {c['login-required']} | {c['redirected']} | {c['not-visited']} |")
    lines += ["", "## Duplicate titles among public routes", ""]
    dup = [(t, n) for t, n in titles.items() if n > 1]
    lines += [f"- `{t}` × {n}" for t, n in dup] or ["- none"]
    lines += ["", "## All routes", "", "| ID | Path | Section | Access | Title | Screenshot |", "|---|---|---|---|---|---|"]
    for r in rows:
        shot = f"[png]({r['screenshot']})" if r["screenshot"] else ""
        lines.append(f"| {r['page_id']} | `{r['requested_path']}` | {r['section']} | {r['access']} | {r['title']} | {shot} |")
    (ROOT / "route-inventory.md").write_text("\n".join(lines) + "\n", encoding="utf-8")
    print(f"{len(rows)} rows; {dict(by_acc)}")


if __name__ == "__main__":
    main()
