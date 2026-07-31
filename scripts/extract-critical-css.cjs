/**
 * Extract the homepage-used subset of main.css + components.min.css into
 * public/css/critical-home.min.css, which the layout inlines on the home
 * route (full sheets then load async — final cascade identical).
 *
 * Method: real-browser selector matching at 375 / 768 / 1440 px. A rule is
 * kept if any of its selectors (pseudo-classes/elements stripped) matches an
 * element intersecting the first viewport (+25 % buffer) at any of the
 * viewports. Hidden elements (rect 0×0 — mobile menu, modals) are kept, so
 * pre-CSS interactions stay styled. @font-face, @keyframes, and :root rules
 * are always kept; @media ancestry is preserved. Order follows the sources.
 *
 * Usage: node scripts/extract-critical-css.js [baseUrl]
 */
const { chromium } = require('playwright');
const fs = require('fs');
const path = require('path');

const BASE = process.argv[2] || 'http://127.0.0.1:8000/';
const OUT = path.join(__dirname, '..', 'public', 'css', 'critical-home.min.css');
const SHEETS = ['css/main.css', 'css/components.min.css'];
const VIEWPORTS = [[375, 812], [768, 1024], [1440, 900]];

(async () => {
  const browser = await chromium.launch();
  // key = sheetIndex:ruleIndexPath  → { order, css }
  const used = new Map();

  for (const [w, h] of VIEWPORTS) {
    const ctx = await browser.newContext({ viewport: { width: w, height: h } });
    const page = await ctx.newPage();
    await page.goto(BASE, { waitUntil: 'load', timeout: 90000 });
    await page.waitForTimeout(2000); // promo modal, sticky bar, deferred JS states

    const rules = await page.evaluate((sheetHints) => {
      const out = [];

      function selectorMatches(sel) {
        // Strip pseudo-classes/elements so :hover/::before rules are kept
        // when their base element exists.
        const base = sel
          .replace(/::?[a-zA-Z-]+(\([^)]*\))?/g, (m) => {
            // keep functional selectors that change matching (:not, :nth-child…)
            return /^::?(not|is|where|has|nth|first|last|only)/.test(m) ? m : '';
          })
          .trim();
        if (!base || base === '' || /^[>+~,]/.test(base)) return true; // bare pseudo (e.g. ::selection) — keep
        let els;
        try { els = document.querySelectorAll(base); } catch (e) { return true; } // unparseable → keep (safe)
        const limit = window.innerHeight * 1.25;
        for (const el of els) {
          const r = el.getBoundingClientRect();
          // 0×0 = display:none (mobile menu, modals) — keep so pre-CSS
          // interactions render correctly.
          if (r.width === 0 && r.height === 0) return true;
          if (r.top < limit && r.bottom > -50) return true;
        }
        return false;
      }

      function walk(ruleList, sheetIdx, mediaStack, counter) {
        for (const rule of ruleList) {
          counter.i++;
          const order = counter.i;
          if (rule.type === CSSRule.STYLE_RULE) {
            // ALWAYS keep rules for elements that remove themselves from the
            // DOM before this extractor samples the page (the preloader
            // self-removes ~600 ms after dismissal): querySelector would miss
            // them and an unstyled preloader block shifts the whole page
            // (measured CLS 0.133 in production).
            const alwaysKeep = /preloader/i.test(rule.selectorText);
            const sels = rule.selectorText.split(',');
            if (alwaysKeep || sels.some((s) => selectorMatches(s.trim()))) {
              out.push({ sheetIdx, order, media: mediaStack.join(' && '), css: rule.cssText });
            }
          } else if (rule.type === CSSRule.MEDIA_RULE) {
            walk(rule.cssRules, sheetIdx, mediaStack.concat(rule.conditionText), counter);
          } else if (rule.type === CSSRule.SUPPORTS_RULE) {
            walk(rule.cssRules, sheetIdx, mediaStack.concat('supports:' + rule.conditionText), counter);
          } else if (rule.type === CSSRule.FONT_FACE_RULE) {
            // French content only ever renders the latin subsets; the async
            // full sheet restores cyrillic/greek/vietnamese declarations.
            const src = rule.style.getPropertyValue('src') || '';
            if (src.includes('-latin.') || src.includes('satoshi') || src.includes('local(')) {
              out.push({ sheetIdx, order, media: mediaStack.join(' && '), css: rule.cssText });
            }
          } else if (
            rule.type === CSSRule.KEYFRAMES_RULE ||
            rule.type === CSSRule.PAGE_RULE ||
            rule.type === CSSRule.NAMESPACE_RULE ||
            rule.type === CSSRule.IMPORT_RULE
          ) {
            out.push({ sheetIdx, order, media: mediaStack.join(' && '), css: rule.cssText });
          } else if (rule.cssText && rule.cssText.startsWith(':root')) {
            out.push({ sheetIdx, order, media: mediaStack.join(' && '), css: rule.cssText });
          }
        }
      }

      const sheets = [...document.styleSheets].filter((s) => s.href && sheetHints.some((hint) => s.href.includes(hint)));
      sheets.forEach((sheet) => {
        const sheetIdx = sheetHints.findIndex((hint) => sheet.href.includes(hint));
        try {
          walk(sheet.cssRules, sheetIdx, [], { i: 0 });
        } catch (e) { /* cross-origin — skip */ }
      });
      return out;
    }, SHEETS.map((s) => s.split('/').pop()));

    for (const r of rules) {
      const key = `${r.sheetIdx}:${r.order}:${r.media}`;
      if (!used.has(key)) used.set(key, r);
    }
    await ctx.close();
  }
  await browser.close();

  // Emit in original order: sheet 0 rules first, then sheet 1; group
  // consecutive rules sharing the same media condition.
  const sorted = [...used.values()].sort((a, b) => a.sheetIdx - b.sheetIdx || a.order - b.order);
  let css = '';
  let openMedia = null;
  for (const r of sorted) {
    const media = r.media && !r.media.startsWith('supports:') ? r.media.split(' && ').filter((m) => !m.startsWith('supports:')).join(' and ') : '';
    if (media !== openMedia) {
      if (openMedia) css += '}';
      if (media) css += `@media ${media}{`;
      openMedia = media || null;
    }
    css += r.css;
  }
  if (openMedia) css += '}';

  fs.writeFileSync(OUT, css);
  console.log('rules kept:', sorted.length, '| bytes:', css.length, '→', OUT);
})();
