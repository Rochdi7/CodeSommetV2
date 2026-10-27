"""Deep inspection of the public marketing surface: full visible text, pricing
(monthly/yearly toggle), FAQ answers, nav dropdowns, computed design tokens.

Usage: python scripts/inspect_marketing.py
Output: raw-observations/marketing.json, screenshots/02-navigation, 07-pricing
"""
import time

from selenium.webdriver.common.action_chains import ActionChains
from selenium.webdriver.common.by import By

from ssx_common import BASE, CRAWL_DELAY, SHOTS, dump, make_driver, now, scroll_through, wait_spa

TOKENS_JS = r"""
const pick=(el)=>{if(!el)return null;const c=getComputedStyle(el);return {font:c.fontFamily,size:c.fontSize,weight:c.fontWeight,lh:c.lineHeight,ls:c.letterSpacing,color:c.color,bg:c.backgroundColor,bgImage:c.backgroundImage.slice(0,160),radius:c.borderRadius,pad:c.padding,shadow:c.boxShadow.slice(0,120),border:c.border}};
const byText=(sel,t)=>[...document.querySelectorAll(sel)].find(e=>e.innerText.trim().startsWith(t));
return {
 body:pick(document.body), h1:pick(document.querySelector('h1')), h2:pick(document.querySelector('h2')),
 p:pick(document.querySelector('main p, section p')), header:pick(document.querySelector('header, nav')),
 primaryBtn:pick(byText('a,button','Start Your Free Audit')), secondaryBtn:pick(byText('a,button','Get Started')),
 card:pick(document.querySelector('[class*=rounded-2xl],[class*=rounded-xl]')),
 cssVars:[...document.styleSheets].flatMap(s=>{try{return [...s.cssRules]}catch(e){return []}})
   .filter(r=>r.selectorText===':root').map(r=>r.cssText.slice(0,3000)),
 tailwindColorClasses:[...new Set([...document.querySelectorAll('[class]')].flatMap(e=>(e.getAttribute('class')||'').split(/\s+/))
   .filter(c=>/^(bg|text|border|from|to|via)-(ink|brand|orange|amber|accent|primary)[-\w/]*$/.test(c)))].slice(0,80),
 breakpoints:[...new Set([...document.querySelectorAll('[class]')].flatMap(e=>(e.getAttribute('class')||'').split(/\s+/))
   .map(c=>c.split(':')[0]).filter(c=>/^(sm|md|lg|xl|2xl)$/.test(c)))]
};
"""


def text_of(d):
    return d.execute_script("return document.body.innerText")


def main():
    out = {"captured_at": now(), "pages": {}}
    d = make_driver()
    try:
        # Homepage
        d.get(BASE + "/")
        wait_spa(d)
        scroll_through(d)
        home = {"full_text": text_of(d), "tokens": d.execute_script(TOKENS_JS)}
        # Section ids (anchor targets)
        home["section_ids"] = d.execute_script("return [...document.querySelectorAll('section[id],div[id]')].map(e=>e.id).filter(i=>i!=='root')")
        # Nav hover menus
        for label in ["Features", "Help", "Desktop App", "Free SEO Audit"]:
            els = [e for e in d.find_elements(By.XPATH, f"//header//*[self::a or self::button][normalize-space()='{label}']") if e.is_displayed()]
            if els:
                ActionChains(d).move_to_element(els[0]).perform()
                time.sleep(1)
                p = SHOTS / "02-navigation" / f"nav-hover-{label.lower().replace(' ', '-')}-desktop.png"
                p.parent.mkdir(parents=True, exist_ok=True)
                d.save_screenshot(str(p))
                home.setdefault("nav_hover", []).append({"label": label, "href": els[0].get_attribute("href"), "shot": str(p.relative_to(SHOTS.parent))})
        # Pricing section + toggle
        d.get(BASE + "/#pricing")
        wait_spa(d)
        time.sleep(2)
        pr = d.find_elements(By.ID, "pricing")
        if pr:
            d.execute_script("arguments[0].scrollIntoView()", pr[0])
            time.sleep(1.5)
            home["pricing_monthly"] = pr[0].text
            (SHOTS / "07-pricing").mkdir(parents=True, exist_ok=True)
            pr[0].screenshot(str(SHOTS / "07-pricing" / "home-pricing-monthly-desktop.png"))
            yb = [b for b in d.find_elements(By.XPATH, "//button[starts-with(normalize-space(),'Yearly')]") if b.is_displayed()]
            if yb:
                yb[0].click()
                time.sleep(1)
                home["pricing_yearly"] = pr[0].text
                pr[0].screenshot(str(SHOTS / "07-pricing" / "home-pricing-yearly-desktop.png"))
        # FAQ: expand each question
        faqs = []
        qs = [b for b in d.find_elements(By.XPATH, "//section[@id='faq']//button") if b.is_displayed()]
        for b in qs:
            try:
                d.execute_script("arguments[0].scrollIntoView({block:'center'})", b)
                q = b.text.strip()
                b.click()
                time.sleep(0.6)
                parent = b.find_element(By.XPATH, "./..")
                faqs.append({"q": q, "block": parent.text.strip()})
            except Exception as e:
                faqs.append({"q": b.text, "error": str(e)[:120]})
        home["faq"] = faqs
        faq = d.find_elements(By.ID, "faq")
        if faq:
            (SHOTS / "01-homepage").mkdir(parents=True, exist_ok=True)
            faq[0].screenshot(str(SHOTS / "01-homepage" / "home-faq-expanded-desktop.png"))
        out["pages"]["/"] = home
        time.sleep(CRAWL_DELAY)

        for path in ["/lifetime-deal", "/privacy", "/terms", "/register", "/login", "/upgrade", "/mcp", "/resources/semantic", "/semantic-seo/resources"]:
            d.get(BASE + path)
            wait_spa(d)
            scroll_through(d)
            out["pages"][path] = {"final": d.current_url, "full_text": text_of(d)[:30000]}
            time.sleep(CRAWL_DELAY)
    finally:
        d.quit()
    dump("marketing.json", out)
    print("ok")


if __name__ == "__main__":
    main()
