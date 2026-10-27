"""Organised screenshot library for public pages: desktop viewport + full page
(after scroll-reveal), mobile viewport + full page, open menus.

Usage: python scripts/capture_screenshots.py [--only desktop|mobile]
Reads public routes from raw-observations/pages.json (outcome == rendered).
Writes screenshots/<folder>/... and raw-observations/screenshots.json (index source).
"""
import argparse
import json
import time

from selenium.webdriver.common.by import By

from ssx_common import (BASE, CRAWL_DELAY, RAW, SHOTS, full_screenshot, make_driver, now, slug,
                        wait_spa)

FOLDER = {
    "/": "01-homepage", "/lifetime-deal": "07-pricing", "/login": "08-authentication",
    "/register": "08-authentication", "/privacy": "03-landing-pages", "/terms": "03-landing-pages",
}


def folder_for(path):
    if path in FOLDER:
        return FOLDER[path]
    if path.startswith("/#"):
        return "01-homepage"
    return "04-seo-tools"


def shot(d, rel, url, vp, state, demonstrates, idx, full=False):
    p = SHOTS / rel
    p.parent.mkdir(parents=True, exist_ok=True)
    if full:
        full_screenshot(d, p)
    else:
        d.save_screenshot(str(p))
    idx.append({"file": rel, "url": url, "viewport": vp, "captured_at": now(), "state": state,
                "demonstrates": demonstrates})


def main():
    ap = argparse.ArgumentParser()
    ap.add_argument("--only", choices=["desktop", "mobile"])
    a = ap.parse_args()
    pages = json.loads((RAW / "pages.json").read_text(encoding="utf-8"))
    public = [p for p, r in pages.items() if r.get("outcome") == "rendered" and not p.startswith("/#")]
    idx_p = RAW / "screenshots.json"
    idx = json.loads(idx_p.read_text(encoding="utf-8")) if idx_p.exists() else []

    modes = [("desktop", 1440, 900, False), ("mobile", 390, 844, True)]
    for name, w, h, mob in modes:
        if a.only and a.only != name:
            continue
        d = make_driver(w, h, mobile=mob)
        try:
            for path in public:
                url = BASE + path
                d.get(url)
                wait_spa(d)
                base = slug(path)
                folder = "09-mobile" if mob else folder_for(path)
                vp = f"{w}x{h}"
                shot(d, f"{folder}/{base}-{name}.png", url, vp, "initial viewport", f"{path} above the fold", idx)
                if path in ("/", "/lifetime-deal", "/privacy", "/terms") or not mob:
                    shot(d, f"{folder}/{base}-{name}-full.png", url, vp, "full page after scroll-reveal",
                         f"{path} complete layout", idx, full=True)
                if mob and path in ("/", "/seo-tools"):
                    # Open the mobile menu if a toggle is present.
                    for sel in ["button[aria-label*='menu' i]", "button[aria-label*='navigation' i]"]:
                        els = [e for e in d.find_elements(By.CSS_SELECTOR, sel) if e.is_displayed()]
                        if els:
                            els[0].click()
                            time.sleep(1)
                            shot(d, f"02-navigation/{base}-mobile-menu-open.png", url, vp, "mobile menu open",
                                 "mobile navigation drawer", idx)
                            break
                time.sleep(CRAWL_DELAY)
                print(name, path)
        finally:
            d.quit()
    # De-duplicate by file (latest wins).
    idx = list({i["file"]: i for i in idx}.values())
    idx_p.write_text(json.dumps(idx, indent=2), encoding="utf-8")


if __name__ == "__main__":
    main()
