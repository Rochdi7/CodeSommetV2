"""Derive client-side route candidates from the publicly served JS entry bundle.

The site has no robots.txt or sitemap (both fall through to the SPA shell), so
the router table in the entry bundle is the most complete public route source.
Only route strings are stored; the bundle itself is not saved.

Usage: python scripts/extract_bundle_routes.py
Output: raw-observations/bundle-routes.json
"""
import re
import sys
import urllib.request

from ssx_common import BASE, dump, now

UA = {"User-Agent": "Mozilla/5.0 (research audit)"}


def get(url):
    with urllib.request.urlopen(urllib.request.Request(url, headers=UA), timeout=40) as r:
        return r.status, r.read().decode("utf-8", "replace")


def main():
    _, html = get(BASE + "/")
    entry = re.search(r'src="(/assets/index-[^"]+\.js)"', html)
    if not entry:
        sys.exit("entry bundle not found")
    _, js = get(BASE + entry.group(1))
    pat = re.compile(r'(?:path|to|href|navigate\()[:=(]\s*["`](/[^"`]{0,80})["`]')
    raw = sorted(set(pat.findall(js)) | set(re.findall(r'"(/(?:[a-z0-9-]+/)*[a-z0-9-]+)"', js)))
    routes = []
    for r in raw:
        if "${" in r or r.startswith("/assets") or r.endswith("/*"):
            continue
        if re.search(r"\.(png|svg|jpg|webp|js|css|json|ico)$", r):
            continue
        routes.append(r)
    probe = {}
    for name in ("robots.txt", "sitemap.xml", "llms.txt", "ads.txt", "manifest.json", "favicon.ico"):
        try:
            st, body = get(f"{BASE}/{name}")
            probe[name] = {"status": st, "is_spa_shell": "<div id=\"root\">" in body, "bytes": len(body)}
        except Exception as e:
            probe[name] = {"error": str(e)}
    out = {"captured_at": now(), "entry_bundle": entry.group(1), "bundle_bytes": len(js),
           "lazy_chunks": len(set(re.findall(r"assets/[A-Za-z0-9_-]+\.js", js))),
           "static_file_probe": probe, "routes": routes}
    p = dump("bundle-routes.json", out)
    print(f"{len(routes)} route candidates -> {p}")


if __name__ == "__main__":
    main()
