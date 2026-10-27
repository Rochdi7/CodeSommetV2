"""Shared helpers for the SEOSignalX public-surface audit.

Conservative by design: single browser, fixed crawl delay, domain allowlist,
no form submissions unless a script does so explicitly with benign input.
"""
import json
import os
import re
import time
from datetime import datetime, timezone
from pathlib import Path
from urllib.parse import urlparse

from selenium import webdriver
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.support.ui import WebDriverWait

BASE = "https://seosignalx.com"
ALLOWED_HOSTS = {"seosignalx.com", "www.seosignalx.com"}
ROOT = Path(__file__).resolve().parent.parent
SHOTS = ROOT / "screenshots"
RAW = ROOT / "raw-observations"
CRAWL_DELAY = float(os.environ.get("SSX_DELAY", "3"))
UA_NOTE = "research-audit (manual, low-rate)"

# Routes never visited: admin surfaces, OAuth endpoints, payment flows.
DENY_PATTERNS = [r"^/admin", r"^/oauth", r"/oauth-callback", r"^/billing", r"^/settings/stripe"]


def now():
    return datetime.now(timezone.utc).isoformat(timespec="seconds")


def is_internal(url):
    host = urlparse(url).hostname or ""
    return host in ALLOWED_HOSTS


def denied(path):
    return any(re.search(p, path) for p in DENY_PATTERNS)


def make_driver(width=1440, height=900, mobile=False):
    opts = Options()
    opts.add_argument("--headless=new")
    opts.add_argument("--disable-gpu")
    opts.add_argument("--no-first-run")
    opts.add_argument("--incognito")  # no stored cookies or credentials
    opts.add_argument(f"--window-size={width},{height}")
    if mobile:
        opts.add_experimental_option("mobileEmulation", {
            "deviceMetrics": {"width": width, "height": height, "pixelRatio": 2},
            "userAgent": "Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X) "
                         "AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.0 Mobile/15E148 Safari/604.1",
        })
    opts.set_capability("goog:loggingPrefs", {"browser": "ALL", "performance": "ALL"})
    d = webdriver.Chrome(options=opts)
    d.set_page_load_timeout(45)
    return d


def wait_spa(driver, timeout=20):
    """Wait until React has rendered into #root and network has mostly settled."""
    WebDriverWait(driver, timeout).until(
        lambda d: d.execute_script("const r=document.getElementById('root');return r && r.children.length>0"))
    # Auth resolution shows a full-screen "Loading..." spinner; wait it out first.
    try:
        WebDriverWait(driver, timeout).until(
            lambda d: d.execute_script("return document.body.innerText.trim()").lower().rstrip(".") not in ("loading", ""))
    except Exception:
        pass
    # Lazy chunks: poll until DOM size is stable.
    last, stable = -1, 0
    for _ in range(20):
        n = driver.execute_script("return document.body.innerHTML.length")
        stable = stable + 1 if n == last else 0
        if stable >= 2:
            break
        last = n
        time.sleep(0.5)


def console_errors(driver):
    out = []
    try:
        for e in driver.get_log("browser"):
            if e.get("level") in ("SEVERE", "WARNING"):
                out.append({"level": e["level"], "message": e["message"][:400]})
    except Exception:
        pass
    return out


def network_hosts(driver):
    """Distinct request hosts + document status from performance log (no headers kept)."""
    hosts, doc_status = set(), None
    try:
        for e in driver.get_log("performance"):
            m = json.loads(e["message"])["message"]
            if m.get("method") == "Network.requestWillBeSent":
                h = urlparse(m["params"]["request"]["url"]).hostname
                if h:
                    hosts.add(h)
            elif m.get("method") == "Network.responseReceived" and m["params"].get("type") == "Document":
                doc_status = m["params"]["response"].get("status")
    except Exception:
        pass
    return sorted(hosts), doc_status


PAGE_META_JS = r"""
const q=s=>document.querySelector(s);
const attr=(s,a)=>{const e=q(s);return e?e.getAttribute(a):null};
const nav=performance.getEntriesByType('navigation')[0];
const paint=performance.getEntriesByType('paint').reduce((o,p)=>(o[p.name]=Math.round(p.startTime),o),{});
const links=[...document.querySelectorAll('a[href]')].map(a=>({href:a.href,text:(a.innerText||a.getAttribute('aria-label')||'').trim().slice(0,80)}));
const heads=[...document.querySelectorAll('h1,h2,h3')].map(h=>h.tagName+': '+h.innerText.trim().slice(0,120));
const imgs=[...document.querySelectorAll('img')];
const forms=[...document.querySelectorAll('form, input, textarea, select, button')].length;
const inputs=[...document.querySelectorAll('input,textarea,select')].map(i=>({tag:i.tagName,type:i.type||null,name:i.name||null,placeholder:i.placeholder||null,required:i.required,aria:i.getAttribute('aria-label')}));
const buttons=[...document.querySelectorAll('button,[role=button]')].map(b=>(b.innerText||b.getAttribute('aria-label')||'').trim().slice(0,60)).filter(Boolean);
const ld=[...document.querySelectorAll('script[type="application/ld+json"]')].map(s=>s.textContent.slice(0,500));
return {
 url:location.href, path:location.pathname+location.search, title:document.title,
 h1:[...document.querySelectorAll('h1')].map(h=>h.innerText.trim()),
 description:attr('meta[name=description]','content'),
 canonical:attr('link[rel=canonical]','href'),
 robots:attr('meta[name=robots]','content'),
 og:[...document.querySelectorAll('meta[property^="og:"],meta[name^="twitter:"]')].map(m=>(m.getAttribute('property')||m.getAttribute('name'))+'='+(m.content||'').slice(0,100)),
 lang:document.documentElement.lang, headings:heads, links:links,
 images:imgs.length, images_no_alt:imgs.filter(i=>!i.hasAttribute('alt')||!i.alt.trim()).length,
 inputs:inputs, buttons:[...new Set(buttons)].slice(0,80), form_controls:forms, jsonld:ld,
 text_len:document.body.innerText.length, text_sample:document.body.innerText.slice(0,1500),
 timing:nav?{ttfb:Math.round(nav.responseStart),dcl:Math.round(nav.domContentLoadedEventEnd),load:Math.round(nav.loadEventEnd),transfer:nav.transferSize}:null,
 paint:paint, doc_height:document.documentElement.scrollHeight,
 landmarks:{header:!!q('header'),nav:!!q('nav'),main:!!q('main'),footer:!!q('footer')}
};
"""


def page_meta(driver):
    return driver.execute_script(PAGE_META_JS)


def scroll_through(driver, step=600, pause=0.35):
    """Scroll the whole page so IntersectionObserver reveal animations fire, then return to top."""
    h = driver.execute_script("return document.documentElement.scrollHeight")
    y = 0
    while y < h:
        driver.execute_script(f"window.scrollTo(0,{y})")
        time.sleep(pause)
        y += step
        h = driver.execute_script("return document.documentElement.scrollHeight")
    time.sleep(1.5)  # let count-up counters finish
    driver.execute_script("window.scrollTo(0,0)")
    time.sleep(0.5)


def full_screenshot(driver, path, max_h=12000, reveal=True):
    """Full-page capture via CDP; falls back to viewport."""
    path = Path(path)
    path.parent.mkdir(parents=True, exist_ok=True)
    if reveal:
        scroll_through(driver)
    try:
        import base64
        h = min(driver.execute_script("return document.documentElement.scrollHeight"), max_h)
        w = driver.execute_script("return document.documentElement.clientWidth")
        r = driver.execute_cdp_cmd("Page.captureScreenshot", {
            "format": "png", "captureBeyondViewport": True,
            "clip": {"x": 0, "y": 0, "width": w, "height": h, "scale": 1}})
        path.write_bytes(base64.b64decode(r["data"]))
    except Exception:
        driver.save_screenshot(str(path))
    return path


def slug(path):
    s = re.sub(r"[^a-z0-9]+", "-", path.lower()).strip("-")
    return s or "home"


def dump(name, data):
    RAW.mkdir(parents=True, exist_ok=True)
    p = RAW / name
    p.write_text(json.dumps(data, indent=2, ensure_ascii=False), encoding="utf-8")
    return p
