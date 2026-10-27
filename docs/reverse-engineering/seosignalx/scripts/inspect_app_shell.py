"""App-shell measurements (icon rail, section sidebar, top bar, tool cards) at
several widths, theme toggle, tool search, and homepage FAQ answers.

Usage: python scripts/inspect_app_shell.py
Output: raw-observations/app-shell.json, screenshots/02-navigation/*
"""
import time

from selenium.webdriver.common.by import By

from ssx_common import BASE, CRAWL_DELAY, SHOTS, dump, make_driver, now, wait_spa

MEASURE_JS = r"""
const box=e=>{if(!e)return null;const r=e.getBoundingClientRect(),c=getComputedStyle(e);
 return {w:Math.round(r.width),h:Math.round(r.height),x:Math.round(r.x),y:Math.round(r.y),bg:c.backgroundColor,
 bgImage:c.backgroundImage.slice(0,140),border:c.borderRight||c.border,radius:c.borderRadius,font:c.fontSize+'/'+c.lineHeight+' '+c.fontWeight,
 color:c.color,display:c.display,position:c.position}};
const asides=[...document.querySelectorAll('aside, nav')].filter(e=>e.getBoundingClientRect().height>300);
const header=document.querySelector('header');
const card=[...document.querySelectorAll('a,div')].find(e=>/Go to Tool/.test(e.innerText||'')&&e.getBoundingClientRect().width<500&&e.getBoundingClientRect().width>200);
const goBtn=[...document.querySelectorAll('a,button,span')].find(e=>(e.innerText||'').trim()==='Go to Tool');
const h1=document.querySelector('h1');
const input=document.querySelector('main input, main textarea');
const primary=[...document.querySelectorAll('main button')].find(b=>/analy|extract|generate|check|scan|search/i.test(b.innerText));
return {vw:innerWidth, rails:asides.map(box), header:box(header), h1:box(h1), card:box(card), goBtn:box(goBtn),
 input:box(input), primary:box(primary), htmlClass:document.documentElement.className, bodyBg:getComputedStyle(document.body).backgroundColor};
"""


def main():
    out = {"captured_at": now(), "shell": {}, "faq": []}
    for w in (1440, 1024, 768, 390):
        d = make_driver(w, 900, mobile=(w == 390))
        try:
            for path in ("/seo-tools", "/tech-seo/eeat"):
                d.get(BASE + path)
                wait_spa(d)
                out["shell"][f"{path}@{w}"] = d.execute_script(MEASURE_JS)
                if w in (1024, 768):
                    p = SHOTS / "02-navigation" / f"app-shell{path.replace('/', '-')}-{w}.png"
                    p.parent.mkdir(parents=True, exist_ok=True)
                    d.save_screenshot(str(p))
                time.sleep(CRAWL_DELAY)
            if w == 390:
                # Marketing header hamburger has no aria-label: take the last visible header button.
                d.get(BASE + "/")
                wait_spa(d)
                hb = [b for b in d.find_elements(By.CSS_SELECTOR, "header button, nav button") if b.is_displayed()]
                if hb:
                    hb[-1].click()
                    time.sleep(1)
                    d.save_screenshot(str(SHOTS / "02-navigation" / "home-mobile-menu-open.png"))
                    out["home_mobile_menu"] = d.execute_script("return document.body.innerText.slice(0,600)")
            if w == 1440:
                # Light ("blue light") theme toggle + tool search
                d.get(BASE + "/seo-tools")
                wait_spa(d)
                t = [b for b in d.find_elements(By.CSS_SELECTOR, "button[aria-label*='theme' i]") if b.is_displayed()]
                if t:
                    t[0].click()
                    time.sleep(1)
                    d.save_screenshot(str(SHOTS / "02-navigation" / "app-shell-light-theme-desktop.png"))
                    out["light_theme"] = d.execute_script(MEASURE_JS)
                    t[0].click()
                s = [i for i in d.find_elements(By.CSS_SELECTOR, "input[placeholder='Search tools...']") if i.is_displayed()]
                if s:
                    s[0].send_keys("sitemap")
                    time.sleep(1.2)
                    d.save_screenshot(str(SHOTS / "02-navigation" / "app-tool-search-sitemap-desktop.png"))
                    out["tool_search_sitemap"] = d.execute_script(
                        "return [...document.querySelectorAll('[role=listbox] *, [role=option], .absolute a, .absolute button')]"
                        ".map(e=>e.innerText.trim()).filter(Boolean).slice(0,30)")
                ws = [b for b in d.find_elements(By.XPATH, "//button[normalize-space()='Select website']") if b.is_displayed()]
                if ws:
                    ws[0].click()
                    time.sleep(1)
                    d.save_screenshot(str(SHOTS / "02-navigation" / "app-website-selector-open-desktop.png"))
                # Homepage FAQ answers
                d.get(BASE + "/")
                wait_spa(d)
                faq = d.find_element(By.ID, "faq")
                d.execute_script("arguments[0].scrollIntoView()", faq)
                time.sleep(1.5)
                for b in [b for b in faq.find_elements(By.TAG_NAME, "button") if b.is_displayed()]:
                    q = b.text.strip()
                    before = faq.text
                    d.execute_script("arguments[0].click()", b)
                    time.sleep(0.8)
                    added = [l for l in faq.text.splitlines() if l not in before.splitlines()]
                    out["faq"].append({"q": q, "a": " ".join(added)[:800]})
        finally:
            d.quit()
    dump("app-shell.json", out)
    print("ok")


if __name__ == "__main__":
    main()
