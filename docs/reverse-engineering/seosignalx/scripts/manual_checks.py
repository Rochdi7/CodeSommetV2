"""Targeted probes for behaviours the generic harness cannot judge, written back
into raw-observations/tool-tests.json as `valid` cases with an explicit verdict.

  - Robots Generator: does the sitemap field keep its value while typing?
  - Text Editor: do Remove Duplicate Lines / UPPERCASE transform the textarea?
  - Bot Viewer: is the result fetched (title of a real page) or a placeholder?

Usage: python scripts/manual_checks.py
"""
import json
import time

from selenium.webdriver.common.by import By

from ssx_common import BASE, RAW, SHOTS, make_driver, now, wait_spa


def buttons(d, label):
    return [b for b in d.find_elements(By.TAG_NAME, "button") if b.text.strip().split("\n")[0] == label]


def robots_generator(d):
    d.get(BASE + "/seo-tools/robots-generator")
    wait_spa(d)
    find = lambda: [i for i in d.find_elements(By.CSS_SELECTOR, "input")
                    if (i.get_attribute("placeholder") or "").startswith("https://example.com/sitemap.xml")][0]
    e1 = find()
    e1.click()
    e1.send_keys("h")
    time.sleep(0.5)
    e2 = find()
    same = e1.id == e2.id
    focused = d.execute_script("return document.activeElement===arguments[0]", e2)
    value = e2.get_attribute("value")
    shot = SHOTS / "10-errors-and-empty-states" / "seo-tools-robots-generator-input-remount-desktop.png"
    d.save_screenshot(str(shot))
    ok = same and focused
    return {"case": "valid", "started_at": now(), "input_value": "type 'h' into sitemap field, then continue typing",
            "outcome": "result" if ok else "defect: input remounts after each keystroke",
            "manual_verdict": "PASS" if ok else "FAIL",
            "added_text": f"same element after 1 key: {same}; focused: {focused}; value: {value!r}",
            "screenshot": str(shot.relative_to(SHOTS.parent)).replace("\\", "/"), "api_calls": [], "seconds": 1}


def text_editor(d):
    d.get(BASE + "/seo-tools/text-editor")
    wait_spa(d)
    ta = [t for t in d.find_elements(By.TAG_NAME, "textarea") if t.is_displayed()][0]
    ta.send_keys("beta\nalpha\nbeta\n\n(x) line")
    buttons(d, "Remove Duplicate Lines")[0].click()
    time.sleep(1)
    dedup = ta.get_attribute("value")
    buttons(d, "UPPERCASE")[0].click()
    time.sleep(1)
    upper = ta.get_attribute("value")
    shot = SHOTS / "06-tool-results" / "seo-tools-text-editor-transformed-desktop.png"
    d.save_screenshot(str(shot))
    ok = dedup.count("beta") == 1 and upper == upper.upper()
    return {"case": "valid", "started_at": now(), "input_value": "beta/alpha/beta/(blank)/(x) line",
            "action_button": "Remove Duplicate Lines, UPPERCASE", "outcome": "result" if ok else "unexpected",
            "manual_verdict": "PASS" if ok else "FAIL", "added_text": f"after dedupe: {dedup!r}; after upper: {upper!r}",
            "screenshot": str(shot.relative_to(SHOTS.parent)).replace("\\", "/"), "api_calls": [], "seconds": 2}


def bot_viewer(d):
    results = []
    for url in ("https://www.iana.org/", "https://codesommet.com/"):
        d.get(BASE + "/seo-tools/bot-viewer")
        wait_spa(d)
        d.get_log("performance")
        inp = [i for i in d.find_elements(By.CSS_SELECTOR, "input") if "view as bot" in (i.get_attribute("placeholder") or "").lower()][0]
        inp.send_keys(url)
        buttons(d, "View as Googlebot")[0].click()
        time.sleep(4)
        txt = d.execute_script("return document.body.innerText")
        i = txt.find("Crawled as")
        results.append({"url": url, "excerpt": txt[i:i + 300] if i >= 0 else txt[-300:]})
        calls = [json.loads(e["message"])["message"] for e in d.get_log("performance")]
        results[-1]["api_requests"] = sorted({m["params"]["request"]["url"].split("?")[0] for m in calls
                                              if m.get("method") == "Network.requestWillBeSent"
                                              and "/api/" in m["params"]["request"]["url"]})
    shot = SHOTS / "10-errors-and-empty-states" / "seo-tools-bot-viewer-placeholder-desktop.png"
    d.save_screenshot(str(shot))
    placeholder = all("Example Page Title" in r["excerpt"] for r in results)
    return {"case": "valid", "started_at": now(), "input_value": " ‖ ".join(r["url"] for r in results),
            "action_button": "View as Googlebot",
            "outcome": "defect: static placeholder output, no fetch" if placeholder else "result",
            "manual_verdict": "FAIL" if placeholder else "PASS",
            "added_text": json.dumps(results, ensure_ascii=False)[:2400],
            "screenshot": str(shot.relative_to(SHOTS.parent)).replace("\\", "/"), "api_calls": [], "seconds": 4}


def main():
    p = RAW / "tool-tests.json"
    store = json.loads(p.read_text(encoding="utf-8"))
    for path, fn in (("/seo-tools/robots-generator", robots_generator), ("/seo-tools/text-editor", text_editor),
                     ("/seo-tools/bot-viewer", bot_viewer)):
        d = make_driver()
        try:
            rec = fn(d)
        finally:
            d.quit()
        store[path]["cases"]["valid"] = rec
        print(path, rec["manual_verdict"], rec["added_text"][:200])
    p.write_text(json.dumps(store, indent=2, ensure_ascii=False), encoding="utf-8")


if __name__ == "__main__":
    main()
