"""Functional tests for every tool page that renders for anonymous visitors.

For each tool: capture the input state, then run up to three cases:
  T-a empty submit       -> validation / login gate / nothing
  T-b valid benign input -> result / login gate / error
  T-c malformed URL      -> validation (URL tools only)
Benign inputs only (example.com, iana.org, codesommet.com, synthetic text).
Never touches login/register/newsletter/payment forms.

Usage:
  python scripts/test_public_tools.py                  # all public tool routes
  python scripts/test_public_tools.py --only /content/nlp /seo-tools/word-counter
  python scripts/test_public_tools.py --cases b        # only valid-input case
Output: raw-observations/tool-tests.json (resumable), screenshots/05-tool-inputs,
        06-tool-results, 10-errors-and-empty-states
"""
import argparse
import json
import re
import time
from urllib.parse import urlparse

from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys

from ssx_common import (BASE, CRAWL_DELAY, RAW, SHOTS, console_errors, dump, full_screenshot, make_driver,
                        now, slug, wait_spa)

NON_TOOL = ("/", "/login", "/register", "/lifetime-deal", "/lifetime-deal/", "/privacy", "/terms", "/upgrade")
IGNORE_PLACEHOLDERS = re.compile(r"^(search check points|search tools|search\.\.\.|get weekly)", re.I)
ACTION = re.compile(r"(analy|extract|check|generat|search|start|run|scan|find|creat|submit|get |fetch|audit|"
                    r"count|compress|convert|track|ask|send|separat|build|optimi|detect|validat|test|lookup|"
                    r"crawl|compare|write|calculate|explore|discover|go$|clean|process|inspect|view)", re.I)
NAV_BUTTONS = {"open section menu", "select website", "switch to blue light theme", "login", "patches"}
GATE = re.compile(r"(please (log|sign) ?in|sign in to|log ?in to|login required|create (a free )?account|"
                  r"upgrade to|requires? (a )?(pro|paid|premium)|insufficient credits|out of credits|subscribe to)",
                  re.I)
SAMPLE_TEXT = ("Semantic SEO helps search engines understand entities and topics. "
               "Technical SEO covers crawling, indexing, structured data and page speed. "
               "Content teams use keyword research to plan articles about search engine optimization.")

# Per-tool overrides where the generic heuristic would pick the wrong value.
VALUE_OVERRIDES = {
    "/seo-tools/domain-separator": "https://www.example.com/page?a=1\nhttps://blog.iana.org/x\ncodesommet.com",
    "/seo-tools/url-editor": "https://Example.com/Path/?utm_source=x&b=2\nhttps://www.iana.org/domains/",
    "/seo-tools/da-pa-checker": "example.com\niana.org",
    "/seo-tools/meta-extractor": "https://example.com\nhttps://www.iana.org/",
    "/seo-tools/sitemap-generator": "https://example.com",
    "/seo-tools/sitemap-extractor": "https://codesommet.com/sitemap.xml",
    "/seo-tools/robots-generator": "https://example.com/sitemap.xml",
    "/seo-tools/text-editor": "beta line\nalpha line\nbeta line\n\n(bracketed) line",
    "/content/grammar": "Laptop",
    "/content/skip-gram": "bank",
    "/content/unique-ngrams": "laptop maintenance",
    "/content/entities-generator": "semantic seo\ntechnical seo",
    "/geo/citation-flow": "example.com",
    "/off-page/expired-domains": "example.com\niana.org\ncodesommet-research-unregistered-zz91.com",
    "/keywords/suggest": "semantic seo",
    "/keywords/ubersuggest": "semantic seo",
    "/keywords/research": "semantic seo",
}
# Tools with several inputs: values in DOM order of the detected inputs.
MULTI_VALUES = {
    "/geo/competitor-research": ["https://example.com", "https://www.iana.org"],
    "/on-page/analyzer": ["https://example.com", "/", "example domain"],
    "/tech-seo/semantic": ["https://example.com", "example domain"],
    "/tech-seo/backlinks": ["https://codesommet.com", "web development",
                            "Domain,DR,Backlinks,Country\nexample.com,90,10,US\nspam-casino-links.xyz,1,500,RU"],
    "/tech-seo/speed": ["https://example.com"],
}
# Exact primary action (prefix of the button's first text line).
PRIMARY = {
    "/content/entities-extractor": "Extract", "/content/entities-generator": "Generate Entities",
    "/content/grammar": "Generate", "/content/ngrams": "Extract", "/content/nlp": "Extract NLP",
    "/content/outline": "Extract + AI Combine", "/content/skip-gram": "Generate",
    "/content/unique-ngrams": "Generate", "/content/ai-helper": "Ask AI",
    "/geo/ai-compatibility": "Start Analysis", "/geo/ai-model-checker": "Analyze",
    "/geo/brand-sentiment": "Analyze page tone", "/geo/citation-flow": "Search citations",
    "/geo/competitor-research": "Analyze competitors", "/geo/internal-links": "Start crawl",
    "/geo/llms-generator": "Start Extraction", "/geo/prompt-tracking": "Extract prompt opportunities",
    "/keywords/research": "Search", "/keywords/suggest": "Generate Suggestions", "/keywords/ubersuggest": "Search",
    "/off-page/expired-domains": "Check availability", "/on-page/analyzer": "Analyze",
    "/on-page/page-seo": "Analyze URL", "/on-page/internal-link-opportunities": "Crawl all pages",
    "/local-seo/rank-grid-pro": "RUN ANALYSIS",
    "/seo-tools/bot-viewer": "View as Googlebot", "/seo-tools/da-pa-checker": "Check DA / PA",
    "/seo-tools/domain-separator": "Filter Domains", "/seo-tools/meta-extractor": "Extract Meta Data",
    "/seo-tools/robots-generator": "Generate Recommended", "/seo-tools/sitemap-extractor": "Extract URLs",
    "/seo-tools/sitemap-generator": "Start Crawl", "/seo-tools/text-editor": "Remove Duplicate Lines",
    "/seo-tools/url-editor": "Remove Params",
    "/tech-seo/backlinks": "Analyze", "/tech-seo/bulk-pagespeed": "Check All Pages", "/tech-seo/crawl": "Analyze",
    "/tech-seo/crawl-visualizer": "CRAWL & VISUALIZE", "/tech-seo/duplicate": "Scan Site",
    "/tech-seo/eeat": "Analyze", "/technical-seo/eeat-audit": "Analyze", "/tech-seo/plagiarism": "Scan Now",
    "/tech-seo/robots": "Analyze Robots.txt", "/tech-seo/schema-auditor": "Scan",
    "/tech-seo/security": "Run Audit", "/tech-seo/semantic": "Analyze", "/tech-seo/speed": "Test Speed",
}
# Never executed: outward-facing / OAuth / uploads / third-party submissions / pure content pages.
SKIP_RUN = {
    **{p: "requires Google Search Console OAuth (button starts an OAuth flow)" for p in
       ("/keywords/branded", "/keywords/cannibalization", "/keywords/lost", "/keywords/low-hanging",
        "/keywords/new", "/tech-seo/gsc-audit")},
    "/tech-seo/bing": "requires Bing Webmaster OAuth",
    "/off-page/backlink-indexer": "would submit URLs to IndexNow (third-party, outward-facing)",
    "/off-page/backlink-cleaner": "requires CSV file upload of a backlink export",
    "/on-page/bulk-image-compression": "requires image file upload",
    "/local-seo/image-geo-tagger": "requires image file upload",
    "/tech-seo/image-seo": "requires linked WordPress site + Patches plugin",
    "/tech-seo/link-checker": "requires a saved website project (logged-in)",
    "/off-page/backlink-directory": "static directory/listing — no run action",
    "/content/content-writer": "paywall card (Professional plan)", "/content/semantic-writer": "paywall card (Professional plan)",
    "/geo/ai-chat": "paywall card (Professional plan)",
    "/content/content-writer/editor": "blank for anonymous visitors", "/content/semantic-writer/editor": "blank for anonymous visitors",
    "/content/optimization": "blank for anonymous visitors",
    "/geo/encyclopedia": "knowledge-base content page", "/semantic-seo/encyclopedia": "knowledge-base content page",
    "/semantic-seo/resources": "resource library content page", "/semantic-seo/ai-agents": "GPT agent directory content page",
    "/semantic-seo/topical-map": "content page", "/resources/semantic": "content page",
    "/schema-seo": "landing/overview page", "/schema-seo/auditor": "landing/overview page", "/seo-tools": "tool directory",
}


def visible(els):
    return [e for e in els if e.is_displayed() and e.is_enabled()]


def main_inputs(d):
    els = visible(d.find_elements(By.CSS_SELECTOR, "main input[type=text], main input[type=url], main input:not([type]), "
                                                   "main textarea, input[type=url], textarea"))
    if not els:
        els = visible(d.find_elements(By.CSS_SELECTOR, "input[type=text], input:not([type])"))
    out = []
    for e in els:
        ph = (e.get_attribute("placeholder") or "")
        if IGNORE_PLACEHOLDERS.search(ph.strip()):
            continue
        if e.get_attribute("readonly"):
            continue
        out.append(e)
    return list(dict.fromkeys(out))


LIVE = {"/seo-tools/word-counter", "/content/watermark-remover"}  # output updates while typing


def action_button(d, path=None):
    if path in LIVE:
        return None, None
    if path in PRIMARY:
        want = PRIMARY[path].lower()
        # Include disabled buttons: many tools disable the action until input is valid.
        shown = [e for e in d.find_elements(By.CSS_SELECTOR, "button, [role=button], input[type=submit]") if e.is_displayed()]
        for b in shown:
            t = (b.text or b.get_attribute("value") or "").strip().split("\n")[0].strip()
            if t.lower() == want or (t.lower().startswith(want) and len(t) <= len(want) + 12):
                return b, t
        return None, None
    cands = []
    for b in visible(d.find_elements(By.CSS_SELECTOR, "button, [role=button], input[type=submit]")):
        t = (b.text or b.get_attribute("aria-label") or b.get_attribute("value") or "").strip()
        if not t or t.lower() in NAV_BUTTONS or len(t) > 40:
            continue
        if ACTION.search(t):
            cands.append((b, t))
    # Prefer buttons inside a form / near the input: last matching in DOM order is usually the submit.
    return cands[0] if len(cands) == 1 else (cands[-1] if cands else (None, None))


def value_for(path, el):
    if path in VALUE_OVERRIDES:
        return VALUE_OVERRIDES[path]
    ph = (el.get_attribute("placeholder") or "").lower()
    tag = el.tag_name.lower()
    if re.search(r"https?://|url|website|page|domain|\.com|site", ph):
        return "https://example.com" if "http" in ph or "url" in ph else "example.com"
    if re.search(r"keyword|topic|seed|query|brand|niche|term|prompt", ph):
        return "semantic seo"
    if tag == "textarea":
        return SAMPLE_TEXT
    return "semantic seo"


def api_calls(d):
    """Same-origin /api/* paths and response statuses seen since the last call (no headers stored)."""
    calls = []
    try:
        for e in d.get_log("performance"):
            m = json.loads(e["message"])["message"]
            if m.get("method") == "Network.responseReceived":
                u = urlparse(m["params"]["response"]["url"])
                if u.path.startswith("/api/") or (u.hostname and "seosignalx" not in u.hostname
                                                  and u.hostname not in ("fonts.gstatic.com", "fonts.googleapis.com")
                                                  and m["params"].get("type") in ("Fetch", "XHR")):
                    calls.append({"host": u.hostname, "path": u.path, "status": m["params"]["response"]["status"]})
    except Exception:
        pass
    return calls


def body_text(d):
    # Include textarea/readonly field values: utilities write their output into form fields, not text nodes.
    return d.execute_script(
        "return document.body.innerText + '\\n' + [...document.querySelectorAll('textarea, pre, code, output')]"
        ".map(t => (t.value !== undefined ? t.value : t.textContent)).filter(Boolean).join('\\n')")


def settle(d, before, timeout=45):
    """Wait for a response to the action: redirect, gate text, or the page text to change then stabilise."""
    t0, last, stable = time.time(), before, 0
    while time.time() - t0 < timeout:
        time.sleep(1)
        if "/login" in d.current_url:
            return "redirect-login", round(time.time() - t0, 1)
        cur = body_text(d)
        busy = re.search(r"(analy[sz]ing|loading|processing|crawling|fetching|generating|please wait|testing\.\.\.|"
                         r"checking website|running crawl|pages tested|stop check|extracting\.\.\.)",
                         cur, re.I)
        if cur != last:
            stable = 0
            last = cur
        else:
            stable += 1
        if cur != before and stable >= 2 and not busy:
            return "changed", round(time.time() - t0, 1)
    return ("changed-timeout" if last != before else "no-change"), round(time.time() - t0, 1)


def new_text(before, after):
    b = set(before.splitlines())
    return "\n".join(l for l in after.splitlines() if l.strip() and l not in b)[:2500]


def classify(state, added, alerts, calls=()):
    if state == "redirect-login":
        return "login-gate (redirect)"
    if GATE.search(added) or any(GATE.search(a) for a in alerts):
        return "login/plan-gate (message)"
    failed = [c for c in calls if c["status"] >= 400]
    if failed and len(added) < 300:
        return "validation-or-error (api %s)" % ",".join(f"{c['path']}={c['status']}" for c in failed[:3])
    if re.search(r"\((0)\)|no results|nothing found|no data", added, re.I) and len(added) < 400:
        return "empty-result"
    if len(added) >= 400:
        return "result"  # substantial output; may legitimately contain words like "FAILED" (check results)
    if re.search(r"(invalid|please enter|^enter |at least one|required|enter a valid|is not a valid|error|failed|could not|unable)",
                 added + " ".join(alerts), re.I):
        return "validation-or-error"
    if state == "no-change":
        return "no-visible-response"
    return "result"


def run_case(d, path, case, idx):
    rec = {"case": case, "started_at": now()}
    # The app persists the last analysed website in browser storage; reset it so cases stay independent.
    if "seosignalx.com" in (d.current_url or ""):
        d.execute_script("try{localStorage.clear();sessionStorage.clear();"
                         "indexedDB.databases().then(l=>l.forEach(x=>indexedDB.deleteDatabase(x.name)))}catch(e){}")
        d.delete_all_cookies()
    d.get(BASE + path)
    wait_spa(d)
    d.get_log("performance")  # flush
    d.get_log("browser")
    inputs = main_inputs(d)
    btn, btxt = action_button(d, path)
    rec["action_button"] = btxt
    rec["input_count"] = len(inputs)
    s = slug(path)
    if case == "input":
        p = full_screenshot(d, SHOTS / "05-tool-inputs" / f"{s}-input-desktop.png", max_h=5000, reveal=False)
        rec["screenshot"] = str(p.relative_to(SHOTS.parent)).replace("\\", "/")
        rec["inputs"] = [{"tag": e.tag_name, "placeholder": e.get_attribute("placeholder")} for e in inputs]
        rec["outcome"] = "captured"
        return rec
    if path in SKIP_RUN:
        rec["outcome"] = "not-run: " + SKIP_RUN[path]
        return rec
    live = path in LIVE
    if not btn and not live:
        rec["outcome"] = "no-action-button-detected"
        return rec
    if case == "empty" and btn is not None and not btn.is_enabled():
        rec["outcome"] = "action-disabled-until-input"
        rec["screenshot"] = None
        return rec
    value = ""
    if case == "valid" and inputs:
        value = value_for(path, inputs[0])
    elif case == "malformed" and inputs:
        value = "not a url ::"
    # For live tools the snapshot is taken before typing so the output counts as a change.
    before = body_text(d)
    values = [value] if value else []
    if case == "valid" and path in MULTI_VALUES:
        values = MULTI_VALUES[path]
    for el, v in zip(inputs, values):
        try:
            el.click()
        except Exception:
            d.execute_script("arguments[0].scrollIntoView({block:'center'});arguments[0].focus()", el)
        el.send_keys(Keys.CONTROL, "a")
        el.send_keys(v)
    value = " ‖ ".join(values)
    rec["input_value"] = value
    alerts = []
    if live:
        rec["mode"] = "live (no action button; output updates while typing)"
    else:
        time.sleep(0.5)
        btn, btxt = action_button(d, path)  # re-resolve: React may re-render / enable it after typing
        rec["action_button"] = btxt
        if btn is None:
            rec["outcome"] = "no-action-button-detected"
            return rec
        rec["action_enabled_after_input"] = btn.is_enabled()
        if case == "malformed" and not btn.is_enabled():
            rec["outcome"] = "action-disabled-for-invalid-input"
            return rec
        before = body_text(d)
        try:
            d.execute_script("arguments[0].scrollIntoView({block:'center'})", btn)
            btn.click()
        except Exception:
            d.execute_script("arguments[0].click()", btn)  # overlay intercepted the native click
            rec["click_mode"] = "js"
    try:
        a = d.switch_to.alert
        alerts.append(a.text)
        a.accept()
    except Exception:
        pass
    slow = path in ("/tech-seo/speed", "/tech-seo/bulk-pagespeed", "/tech-seo/semantic")  # PageSpeed-backed
    state, secs = settle(d, before, timeout=(180 if slow else 60) if case == "valid" else 15)
    after = body_text(d)
    # HTML5 validation message on the input, if any
    if inputs:
        try:
            vm = d.execute_script("return arguments[0].validationMessage", inputs[0])
            if vm:
                alerts.append("html5: " + vm)
        except Exception:
            pass
    added = new_text(before, after)
    calls = api_calls(d)
    rec.update(final_url=d.current_url, wait_state=state, seconds=secs, alerts=alerts, added_text=added,
               outcome=classify(state, added, alerts, calls), api_calls=calls, console=console_errors(d))
    folder = {"valid": "06-tool-results"}.get(case, "10-errors-and-empty-states")
    if rec["outcome"].startswith("login"):
        folder = "08-authentication"
    p = full_screenshot(d, SHOTS / folder / f"{s}-{case}-desktop.png", max_h=6000, reveal=False)
    rec["screenshot"] = str(p.relative_to(SHOTS.parent)).replace("\\", "/")
    return rec


def main():
    ap = argparse.ArgumentParser()
    ap.add_argument("--only", nargs="*")
    ap.add_argument("--cases", default="input,empty,valid,malformed")
    ap.add_argument("--fresh", action="store_true")
    a = ap.parse_args()
    pages = json.loads((RAW / "pages.json").read_text(encoding="utf-8"))
    tools = a.only or [p for p, r in pages.items()
                       if r.get("outcome") == "rendered" and p not in NON_TOOL and not p.startswith("/#")
                       and (r.get("text_len") or 0) > 50]
    store_p = RAW / "tool-tests.json"
    store = {} if a.fresh or not store_p.exists() else json.loads(store_p.read_text(encoding="utf-8"))
    cases = a.cases.split(",")
    # A fresh incognito browser per case: the app restores the last analysed website from
    # client storage, which otherwise leaks one case's input into the next (observed).
    d = None
    try:
        for path in tools:
            entry = store.setdefault(path, {"path": path, "title": pages.get(path, {}).get("title"), "cases": {}})
            is_url_tool = entry.get("url_input")
            for case in cases:
                if case in entry["cases"] and not a.only:
                    continue
                if case == "malformed" and is_url_tool is False:
                    entry["cases"][case] = {"case": case, "outcome": "not-applicable (no URL input)"}
                    continue
                d = make_driver()
                try:
                    rec = run_case(d, path, case, None)
                except Exception as e:
                    rec = {"case": case, "outcome": "automation-error", "error": f"{type(e).__name__}: {str(e)[:250]}"}
                finally:
                    d.quit()
                    d = None
                if case == "input":
                    phs = " ".join((i.get("placeholder") or "") for i in rec.get("inputs", []))
                    is_url_tool = bool(re.search(r"http|url|domain|\.com|website", phs, re.I))
                    entry["url_input"] = is_url_tool
                entry["cases"][case] = rec
                dump("tool-tests.json", store)
                print(path, case, rec.get("outcome"), flush=True)
                time.sleep(CRAWL_DELAY)
    finally:
        if d:
            d.quit()


if __name__ == "__main__":
    main()
