"""Visit every route candidate with Selenium, record metadata, auth gating,
console errors, request hosts and screenshots. Resumable: skips paths already
present in raw-observations/pages.json unless --fresh is passed.

Usage:
  python scripts/inspect_pages.py                # all candidates
  python scripts/inspect_pages.py --max 20       # cap per run
  python scripts/inspect_pages.py --paths / /login
  python scripts/inspect_pages.py --fresh
Env: SSX_DELAY (seconds between pages, default 3)
"""
import argparse
import json
import re
import time
import traceback

from ssx_common import (BASE, CRAWL_DELAY, RAW, SHOTS, console_errors, denied, dump, full_screenshot,
                        is_internal, make_driver, network_hosts, now, page_meta, slug, wait_spa)

GATE_HINTS = re.compile(r"(sign in|log in|login|create account|continue with google)", re.I)


def classify(path, meta):
    final = meta["path"]
    if final.startswith("/login") and not path.startswith("/login"):
        return "auth-redirect"
    if final.rstrip("/") != path.split("?")[0].rstrip("/") and not path.startswith("/#"):
        return f"redirect:{final}"
    return "rendered"


def main():
    ap = argparse.ArgumentParser()
    ap.add_argument("--max", type=int, default=500)
    ap.add_argument("--paths", nargs="*")
    ap.add_argument("--fresh", action="store_true")
    a = ap.parse_args()

    store_p = RAW / "pages.json"
    store = {} if a.fresh or not store_p.exists() else json.loads(store_p.read_text(encoding="utf-8"))
    if a.paths:
        todo = a.paths
    else:
        cands = json.loads((RAW / "bundle-routes.json").read_text(encoding="utf-8"))["routes"]
        todo = ["/"] + [r for r in cands if r != "/"]
    todo = [p for p in dict.fromkeys(todo) if p not in store or a.paths]

    d = make_driver()
    done = 0
    try:
        for path in todo:
            if done >= a.max:
                break
            rec = {"requested": path, "inspected_at": now()}
            if ":" in path:
                rec.update(status="skipped", reason="parameterised route (needs real id)")
            elif denied(path):
                rec.update(status="skipped", reason="deny-list (admin/oauth/payment)")
            else:
                try:
                    t0 = time.time()
                    d.get(BASE + path)
                    wait_spa(d)
                    rec["render_seconds"] = round(time.time() - t0, 2)
                    meta = page_meta(d)
                    hosts, doc_status = network_hosts(d)
                    rec.update(meta)
                    rec["outcome"] = classify(path, meta)
                    rec["http_status"] = doc_status
                    rec["request_hosts"] = hosts
                    rec["console"] = console_errors(d)
                    rec["gate_text"] = bool(GATE_HINTS.search(meta["text_sample"]))
                    rec["internal_links"] = sorted({l["href"].replace(BASE, "") for l in meta["links"] if is_internal(l["href"])})
                    rec["external_links"] = sorted({l["href"] for l in meta["links"] if not is_internal(l["href"]) and l["href"].startswith("http")})
                    del rec["links"]
                    # One screenshot per distinct final page; auth redirects all share /login.
                    if rec["outcome"] == "rendered":
                        shot = SHOTS / "_pages" / f"{slug(path)}-desktop-full.png"
                        full_screenshot(d, shot)
                        rec["screenshot"] = str(shot.relative_to(SHOTS.parent)).replace("\\", "/")
                    rec["status"] = "inspected"
                except Exception as e:
                    rec.update(status="error", error=f"{type(e).__name__}: {str(e)[:300]}",
                               trace=traceback.format_exc()[-600:])
                done += 1
                time.sleep(CRAWL_DELAY)
            store[path] = rec
            dump("pages.json", store)
            print(f"[{len(store)}] {path} -> {rec.get('outcome', rec['status'])}")
    finally:
        d.quit()


if __name__ == "__main__":
    main()
