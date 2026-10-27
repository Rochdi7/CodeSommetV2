"""Generate derived report artifacts from raw observations:
  test-matrix.csv, TEST_RESULTS.md (totals block between markers),
  screenshots/README.md, raw-observations/EVIDENCE_INDEX.md
and validate that every relative link in the report's .md files resolves.

Usage: python scripts/build_reports.py
"""
import csv
import json
import re
from collections import Counter
from pathlib import Path

from ssx_common import BASE, RAW, ROOT, SHOTS, slug

STATUS = {  # harness outcome -> test status
    "result": "PASS", "empty-result": "PASS", "validation-or-error": "PASS",
    "action-disabled-until-input": "PASS", "action-disabled-for-invalid-input": "PASS",
    "login-gate (redirect)": "BLOCKED", "login/plan-gate (message)": "BLOCKED",
    "no-visible-response": "INCONCLUSIVE", "no-action-button-detected": "NOT TESTED",
    "automation-error": "INCONCLUSIVE",
}
EXPECT = {
    "empty": "Validation message or disabled action; no request with empty input",
    "valid": "Tool output for benign input, or an explicit gate",
    "malformed": "Validation error for malformed URL",
}


# Output-correctness verdicts established by inspecting the evidence (see TEST_RESULTS.md "Notable defects").
ANNOTATIONS = {
    ("/seo-tools/sitemap-generator", "valid"): ("FAIL", "sitemap includes https://example.com/sitemap.xml which returns 404"),
    ("/geo/ai-compatibility", "malformed"): ("FAIL", "analysed 'https://not a url ::' and scored it 13 instead of rejecting"),
    ("/local-seo/rank-grid-pro", "valid"): ("INCONCLUSIVE", "requires selecting a Google Business listing first; not automatable"),
    ("/on-page/internal-link-opportunities", "valid"): ("BLOCKED", "needs a crawled project + GSC; nothing rendered for anonymous"),
    ("/geo/internal-links", "valid"): ("PASS", "crawl completed: 1 page, 0 links, linking score 100% (real output)"),
    ("/tech-seo/bulk-pagespeed", "valid"): ("PASS", "1 page tested; mobile 100 / desktop 100; PERF 100 A11Y 96 BP 100 SEO 80"),
    ("/tech-seo/duplicate", "valid"): ("PASS", "correct guard: 'Need at least two crawlable pages' on a 1-page site"),
    ("/seo-tools/domain-separator", "valid"): ("FAIL", "kept subdomain blog.iana.org although the tool promises root domains"),
    ("/seo-tools/domain-separator", "malformed"): ("FAIL", "counted 'not a url ::' as a unique domain"),
    ("/seo-tools/bot-viewer", "malformed"): ("FAIL", "reported HTTP 200 + placeholder title for 'not a url ::'"),
}
LIVE_TOOLS = {"/seo-tools/word-counter", "/content/watermark-remover"}


def status_for(case, rec, path=None):
    if (path, case) in ANNOTATIONS:
        return ANNOTATIONS[(path, case)][0]
    if rec.get("manual_verdict"):
        return rec["manual_verdict"]
    o = rec.get("outcome", "")
    calls = rec.get("api_calls", [])
    if any(c["path"] == "/api/deepseek" and c["status"] == 401 for c in calls) and not (
            case == "malformed" and any(c["path"] == "/api/proxy" and c["status"] == 400 for c in calls)):
        # AI endpoint refused (no Firebase token); any visible output is the client's template fallback.
        return "BLOCKED"
    added = (rec.get("added_text") or "").strip()
    if case == "empty" and "?website=" in (rec.get("final_url") or "") and not rec.get("input_value"):
        return "INCONCLUSIVE"  # app restored a previously analysed website (state leak), so not a true empty run
    if case in ("empty", "malformed") and len(added) < 200 and re.search(
            r"^(enter|please|invalid|at least)|required|not a valid|invalid url", added, re.I | re.M):
        return "PASS"  # explicit validation message
    if o.startswith("not-run") or o.startswith("not-applicable"):
        return "NOT TESTED" if "OAuth" not in o and "upload" not in o else "BLOCKED"
    failed_api = [c for c in calls if c["status"] >= 400 and c["path"] != "/api/auth"]
    if case == "valid" and len(added) >= 400 and not failed_api and not o.startswith("login"):
        return "PASS"  # substantial output with no failing request (classifier may have keyed on words like "Errors")
    if o.startswith("validation-or-error"):
        # On a valid-input case, an API error is a failure of the tool for that input, not a validation pass.
        if case == "valid":
            return "FAIL" if re.search(r"=5\d\d", o) else "BLOCKED" if re.search(r"=40[13]", o) else "FAIL"
        return "PASS"
    if case == "empty" and o == "result":
        return "INCONCLUSIVE"  # ran with no input: no validation observed
    if case == "malformed" and o == "result":
        return "FAIL"  # malformed URL produced output instead of validation
    return STATUS.get(o, "INCONCLUSIVE")


def main():
    tests = json.loads((RAW / "tool-tests.json").read_text(encoding="utf-8"))
    pages = json.loads((RAW / "pages.json").read_text(encoding="utf-8"))
    rows, n = [], 0
    for path, t in tests.items():
        for case in ("empty", "valid", "malformed"):
            rec = t["cases"].get(case)
            if not rec:
                continue
            o = rec.get("outcome", "")
            # One row per skipped tool (not two), and no "empty submit" case for type-as-you-go tools.
            if (case in ("empty", "malformed") and o.startswith("not-run")) or (case == "empty" and path in LIVE_TOOLS):
                continue
            if o.startswith("not-applicable"):
                continue
            n += 1
            st = status_for(case, rec, path)
            note = ANNOTATIONS.get((path, case), (None, ""))[1]
            rows.append({
                "test_id": f"TEST-{n:03d}", "feature": t.get("title", "").split("|")[0].strip(), "page_url": BASE + path,
                "case": case, "preconditions": "anonymous visitor, desktop 1440x900, no account",
                "test_input": rec.get("input_value", ""), "steps": f"open page; fill input; click '{rec.get('action_button') or '-'}'",
                "expected_result": EXPECT[case], "actual_result": rec.get("outcome", ""),
                "status": st, "seconds": rec.get("seconds", ""),
                "api_calls": "; ".join(f"{c['path']}={c['status']}" for c in rec.get("api_calls", [])[:6]),
                "evidence_screenshot": rec.get("screenshot", ""),
                "error_details": (note or rec.get("error") or rec.get("click_error") or "; ".join(rec.get("alerts", [])))[:200],
                "result_excerpt": (rec.get("added_text") or "")[:300].replace("\n", " | "),
                "follow_up": {"BLOCKED": ("AI call 401 for anonymous; visible output is template fallback"
                                          if any(c["path"] == "/api/deepseek" for c in rec.get("api_calls", []))
                                          else "needs account/plan or OAuth"), "FAIL": "re-run; inspect manually",
                              "INCONCLUSIVE": "manual check", "NOT TESTED": "see reason"}.get(st, ""),
            })
    with (ROOT / "test-matrix.csv").open("w", newline="", encoding="utf-8") as f:
        w = csv.DictWriter(f, fieldnames=list(rows[0].keys()))
        w.writeheader()
        w.writerows(rows)
    c = Counter(r["status"] for r in rows)
    block = ["<!-- totals:start -->", "| Status | Count |", "|---|---|"]
    block += [f"| {k} | {c.get(k, 0)} |" for k in ("PASS", "FAIL", "BLOCKED", "INCONCLUSIVE", "NOT TESTED")]
    block += [f"| **Total** | **{len(rows)}** |", "<!-- totals:end -->"]
    tr = ROOT / "TEST_RESULTS.md"
    if tr.exists():
        txt = tr.read_text(encoding="utf-8")
        txt = re.sub(r"<!-- totals:start -->.*<!-- totals:end -->", "\n".join(block), txt, flags=re.S)
        tr.write_text(txt, encoding="utf-8")
    print("tests", dict(c), len(rows))

    # Feature inventory: features.py merged with test evidence
    from features import F
    by_path = {}
    for r in rows:
        by_path.setdefault(r["page_url"].replace(BASE, ""), []).append(r)
    frows = []
    for feat in F:
        paths = [p for p in by_path if re.search(r"(^|[\s(:])" + re.escape(p) + r"(?=[\s;,)]|$)", feat["routes"])]
        trs = [r for p in paths for r in by_path[p]]
        valid = [r for r in trs if r["case"] == "valid"]
        if feat["source"] in ("gated", "paywall", "marketing", "content") and not valid:
            observed = {"gated": "Not verified: login required (client redirect to /login)",
                        "paywall": "Observed paywall card only (Professional plan)",
                        "marketing": "Not verified: described in /lifetime-deal copy only",
                        "content": "Observed content page (not a tool)"}[feat["source"]]
            conf = "Low" if feat["source"] in ("gated", "marketing") else "Medium"
            tstat = "BLOCKED" if feat["source"] in ("gated", "paywall") else "NOT TESTED"
        elif valid:
            v = valid[0]
            observed = f"{v['status']}: {v['actual_result']}" + (f" — {v['result_excerpt'][:180]}" if v["result_excerpt"] else "")
            tstat = v["status"]
            conf = "High" if v["status"] == "PASS" else "Medium"
        else:
            observed, tstat, conf = "Platform capability inferred from tool behaviour", "NOT TESTED", "Medium"
        frows.append({**feat, "observed_behavior": observed, "test_status": tstat,
                      "evidence": " ".join(r["test_id"] for r in trs) or "route inventory / lifetime-deal copy",
                      "authentication_requirements": {"public-tool": "none to open; see test for run-time gate",
                                                      "gated": "login", "paywall": "paid plan"}.get(feat["source"], "n/a"),
                      "testing_requirements": "unit tests for parsers/rules; HTTP fakes for providers; feature test per endpoint",
                      "confidence": conf})
    with (ROOT / "FEATURE_INVENTORY.csv").open("w", newline="", encoding="utf-8") as fh:
        w = csv.DictWriter(fh, fieldnames=list(frows[0].keys()))
        w.writeheader()
        w.writerows(frows)
    print("features", len(frows), dict(Counter(r["test_status"] for r in frows)))

    # Screenshot index
    idx = {i["file"]: i for i in json.loads((RAW / "screenshots.json").read_text(encoding="utf-8"))}
    for path, t in tests.items():
        for case, rec in t["cases"].items():
            if rec.get("screenshot"):
                f = rec["screenshot"].replace("screenshots/", "", 1)
                idx[f] = {"file": f, "url": BASE + path, "viewport": "1440x900", "captured_at": rec.get("started_at", ""),
                          "state": f"tool test: {case}", "demonstrates": rec.get("outcome", "")}
    for p in sorted(SHOTS.rglob("*.png")):
        rel = p.relative_to(SHOTS).as_posix()
        if rel not in idx:
            idx[rel] = {"file": rel, "url": "", "viewport": "1440x900" if "mobile" not in rel else "390x844",
                        "captured_at": "2026-10-26", "state": "", "demonstrates": "see filename"}
    existing = {p.relative_to(SHOTS).as_posix() for p in SHOTS.rglob("*.png")}
    lines = ["# Screenshot index", "", f"{len(existing)} PNG files. Captured 2026-10-26 with headless Chrome 155 "
             "(desktop 1440×900, mobile 390×844 @2x). Generated by `scripts/build_reports.py`.", "",
             "Screenshots are visual references only. They do not prove hidden backend behaviour.", "",
             "| SHOT ID | File | URL | Viewport | State | Demonstrates |", "|---|---|---|---|---|---|"]
    for i, k in enumerate(sorted(k for k in idx if k in existing), 1):
        e = idx[k]
        lines.append(f"| SHOT-{i:03d} | [{k}]({k}) | {e['url']} | {e['viewport']} | {e['state']} | {e['demonstrates']} |")
    (SHOTS / "README.md").write_text("\n".join(lines) + "\n", encoding="utf-8")

    # Evidence index
    ev = ["# Evidence index", "", "Maps evidence IDs to their sources. PAGE-xxx = `ROUTE_INVENTORY.csv`, "
          "TEST-xxx = `test-matrix.csv`, SHOT-xxx = `screenshots/README.md`, OBS-xxx = `technical-observations.md`, "
          "FEATURE-xxx = `FEATURE_INVENTORY.csv`, SEO-xx = `reference-site-seo-audit.md`.", "",
          "| Raw file | Produced by | Contents |", "|---|---|---|",
          "| bundle-routes.json | extract_bundle_routes.py | route strings from the public JS bundle + static file probes |",
          "| pages.json | inspect_pages.py | per-route metadata, links, inputs, console, hosts, timing |",
          "| marketing.json | inspect_marketing.py | full text of marketing pages, pricing monthly/yearly, computed tokens |",
          "| app-shell.json | inspect_app_shell.py | app shell geometry at 1440/1024/768/390, FAQ answers, theme/search states |",
          "| screenshots.json | capture_screenshots.py | screenshot metadata |",
          "| tool-tests.json | test_public_tools.py | per-tool test cases: inputs, outcome, added text, API paths/statuses |",
          "", "## Tests → screenshots", "", "| TEST | Feature | Case | Status | Screenshot |", "|---|---|---|---|---|"]
    for r in rows:
        s = f"[png](../{r['evidence_screenshot']})" if r["evidence_screenshot"] else ""
        ev.append(f"| {r['test_id']} | {r['feature']} | {r['case']} | {r['status']} | {s} |")
    (RAW / "EVIDENCE_INDEX.md").write_text("\n".join(ev) + "\n", encoding="utf-8")

    # Link validation
    bad = []
    bad_shots = []
    for md in ROOT.rglob("*.md"):
        text = md.read_text(encoding="utf-8")
        # Backticked screenshot references must exist too (e.g. `06-tool-results/x.png`).
        for m in re.finditer(r"`((?:screenshots/)?(?:0\d-[a-z0-9-]+|_pages)/[^`\s]+\.png)`", text):
            rel = m.group(1) if m.group(1).startswith("screenshots/") else "screenshots/" + m.group(1)
            if "*" not in rel and not (ROOT / rel).exists():
                bad_shots.append(f"{md.relative_to(ROOT)} -> {rel}")
        text = re.sub(r"```.*?```", "", text, flags=re.S)
        text = re.sub(r"`[^`\n]*`", "", text)  # ignore links shown as code examples
        for m in re.finditer(r"\]\(([^)#\s]+)(#[^)]*)?\)", text):
            target = m.group(1)
            if target.startswith(("http", "mailto")):
                continue
            if not (md.parent / target).exists():
                bad.append(f"{md.relative_to(ROOT)} -> {target}")
    print("broken links:", len(bad))
    for b in bad[:40]:
        print("  ", b)
    print("missing screenshot refs:", len(bad_shots))
    for b in bad_shots[:60]:
        print("  ", b)


if __name__ == "__main__":
    main()
