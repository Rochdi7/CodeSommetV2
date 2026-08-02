/**
 * audit-homepage.js — DEV-ONLY homepage quality audit.
 *
 * Not referenced by any Blade view; never shipped to production pages.
 * Run it from the browser console (paste the file) or inject it via
 * Selenium/Puppeteer, then read `window.__homepageAudit` or the console
 * tables it prints.
 *
 * Sections:
 *   A. Internal links (duplicate anchor texts, empty/icon-only links)
 *   B. Headings (order, duplicates, hidden, level skips)
 *   C. Contrast candidates (computed fg/bg, approximate WCAG ratio)
 *   D. DOM / HTML size indicators (node count, big inline blocks, SVG, attrs)
 *   E. Resources & security (failed requests, third parties, CSP violations)
 *
 * Known limitation: section C's effectiveBg() walk can misattribute the
 * background on elements with a solid inline background-color sitting under
 * a differently-styled ancestor chain (observed on the hero's black CTA
 * pill). Treat flagged items as leads to verify visually / in DevTools, not
 * as certified WCAG failures — cross-check against Lighthouse's
 * color-contrast audit before acting on a report from this script.
 */
(function () {
    'use strict';

    // ---------- helpers ----------
    function visible(el) {
        var r = el.getBoundingClientRect();
        var cs = getComputedStyle(el);
        return cs.display !== 'none' && cs.visibility !== 'hidden' &&
            parseFloat(cs.opacity || '1') > 0.05 && (r.width > 0 || r.height > 0);
    }
    function parseColor(str) {
        var m = /rgba?\(([\d.]+)[,\s]+([\d.]+)[,\s]+([\d.]+)(?:[,\s/]+([\d.]+%?))?\)/.exec(str || '');
        if (!m) return null;
        var a = m[4] === undefined ? 1 : (m[4].indexOf('%') > -1 ? parseFloat(m[4]) / 100 : parseFloat(m[4]));
        return [parseFloat(m[1]), parseFloat(m[2]), parseFloat(m[3]), a];
    }
    function blend(top, bottom) { // both [r,g,b,a]
        var a = top[3] + bottom[3] * (1 - top[3]);
        if (a === 0) return [0, 0, 0, 0];
        return [
            (top[0] * top[3] + bottom[0] * bottom[3] * (1 - top[3])) / a,
            (top[1] * top[3] + bottom[1] * bottom[3] * (1 - top[3])) / a,
            (top[2] * top[3] + bottom[2] * bottom[3] * (1 - top[3])) / a, a];
    }
    function effectiveBg(el) {
        // Walk up the tree stacking translucent backgrounds; white fallback.
        var stack = [], node = el, hasImage = false;
        while (node && node !== document.documentElement) {
            var cs = getComputedStyle(node);
            if (cs.backgroundImage && cs.backgroundImage !== 'none') hasImage = true;
            var c = parseColor(cs.backgroundColor);
            if (c && c[3] > 0) {
                stack.push(c);
                if (c[3] >= 1) break;
            }
            node = node.parentElement;
        }
        var bg = [255, 255, 255, 1];
        for (var i = stack.length - 1; i >= 0; i--) bg = blend(stack[i], bg);
        return { color: bg, hasImage: hasImage };
    }
    function lum(rgb) {
        var t = rgb.slice(0, 3).map(function (c) {
            c /= 255; return c <= 0.03928 ? c / 12.92 : Math.pow((c + 0.055) / 1.055, 2.4);
        });
        return 0.2126 * t[0] + 0.7152 * t[1] + 0.0722 * t[2];
    }
    function ratio(fg, bg) {
        var l1 = lum(fg), l2 = lum(bg);
        if (l1 < l2) { var t = l1; l1 = l2; l2 = t; }
        return (l1 + 0.05) / (l2 + 0.05);
    }
    function cssPath(el) {
        var parts = [];
        while (el && el.nodeType === 1 && parts.length < 5) {
            var s = el.tagName.toLowerCase();
            if (el.id) { parts.unshift(s + '#' + el.id); break; }
            var cls = (el.className && typeof el.className === 'string') ? el.className.trim().split(/\s+/)[0] : '';
            if (cls) s += '.' + cls;
            parts.unshift(s);
            el = el.parentElement;
        }
        return parts.join(' > ');
    }
    function txt(el) { return (el.textContent || '').replace(/\s+/g, ' ').trim(); }

    var audit = { url: location.href, when: new Date().toISOString() };

    // ---------- A. internal links ----------
    var origin = location.origin;
    var links = Array.prototype.slice.call(document.querySelectorAll('a[href]')).map(function (a) {
        var href = a.getAttribute('href') || '';
        var abs; try { abs = new URL(href, location.href); } catch (e) { abs = null; }
        var internal = abs && abs.origin === origin;
        var t = txt(a);
        var aria = a.getAttribute('aria-label') || '';
        var accessibleName = aria || t || (a.querySelector('img[alt]') ? a.querySelector('img[alt]').alt : '') ||
            (a.title || '');
        return {
            href: href,
            url: internal ? (abs.pathname.replace(/\/$/, '') || '/') : (abs ? abs.href : href),
            internal: !!internal, text: t, accessibleName: accessibleName,
            iconOnly: !t && !!a.querySelector('svg,img'), visible: visible(a), selector: cssPath(a)
        };
    });
    var internals = links.filter(function (l) { return l.internal; });
    var byText = {}, byUrl = {};
    internals.forEach(function (l) {
        var k = l.text || '[' + (l.accessibleName || 'EMPTY') + ']';
        (byText[k] = byText[k] || []).push(l.url);
        (byUrl[l.url] = byUrl[l.url] || new Set()).add(l.text);
    });
    var duplicateTexts = Object.keys(byText).filter(function (k) { return byText[k].length > 1; })
        .map(function (k) {
            var urls = Array.from(new Set(byText[k]));
            return { text: k, uses: byText[k].length, urls: urls, sameTextDifferentUrls: urls.length > 1 };
        }).sort(function (a, b) { return b.uses - a.uses; });
    audit.links = {
        total: links.length, internal: internals.length,
        duplicateTexts: duplicateTexts,
        emptyAccessibleName: links.filter(function (l) { return !l.accessibleName; }),
        iconOnly: links.filter(function (l) { return l.iconOnly; }),
        inconsistentUrlTexts: Object.keys(byUrl).filter(function (u) { return byUrl[u].size >= 3; })
            .map(function (u) { return { url: u, texts: Array.from(byUrl[u]) }; })
    };

    // ---------- B. headings ----------
    var hs = Array.prototype.slice.call(document.querySelectorAll('h1,h2,h3,h4,h5,h6'));
    var seen = {}, prev = 0, skips = [];
    audit.headings = {
        total: hs.length,
        byLevel: {},
        list: hs.map(function (h, i) {
            var lvl = +h.tagName[1], t = txt(h);
            audit.headings ? null : null;
            if (lvl > prev + 1 && prev !== 0) skips.push({ index: i, from: 'h' + prev, to: 'h' + lvl, text: t.slice(0, 60) });
            prev = lvl;
            seen[t] = (seen[t] || 0) + 1;
            return { order: i + 1, level: lvl, text: t, hidden: !visible(h), selector: cssPath(h) };
        }),
        duplicates: [], empty: [], skips: skips
    };
    hs.forEach(function (h) { var l = +h.tagName[1]; audit.headings.byLevel['h' + l] = (audit.headings.byLevel['h' + l] || 0) + 1; });
    Object.keys(seen).forEach(function (t) { if (t && seen[t] > 1) audit.headings.duplicates.push({ text: t, count: seen[t] }); });
    audit.headings.empty = audit.headings.list.filter(function (h) { return !h.text; });

    // ---------- C. contrast candidates ----------
    var flagged = [];
    var walker = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT, null);
    var checked = new Set();
    var n;
    while ((n = walker.nextNode())) {
        var el = n.parentElement;
        if (!el || checked.has(el)) continue;
        checked.add(el);
        if (!n.nodeValue || !n.nodeValue.trim()) continue;
        if (/^(SCRIPT|STYLE|NOSCRIPT|TITLE)$/.test(el.tagName)) continue;
        if (!visible(el)) continue;
        var cs = getComputedStyle(el);
        var fg = parseColor(cs.color);
        if (!fg) continue;
        var bg = effectiveBg(el);
        if (fg[3] < 1) fg = blend(fg, bg.color);
        var r = ratio(fg, bg.color);
        var size = parseFloat(cs.fontSize), weight = parseInt(cs.fontWeight, 10) || 400;
        var large = size >= 24 || (size >= 18.66 && weight >= 700);
        var threshold = large ? 3 : 4.5;
        if (r < threshold + 0.2) { // report near-misses too
            flagged.push({
                text: n.nodeValue.replace(/\s+/g, ' ').trim().slice(0, 60),
                fg: cs.color, effBg: 'rgb(' + bg.color.slice(0, 3).map(Math.round).join(',') + ')',
                bgHasImage: bg.hasImage, fontSize: size, fontWeight: weight,
                ratio: Math.round(r * 100) / 100, threshold: threshold,
                fails: r < threshold, selector: cssPath(el)
            });
        }
    }
    audit.contrast = flagged.sort(function (a, b) { return a.ratio - b.ratio; }).slice(0, 80);

    // ---------- D. DOM / size indicators ----------
    var allEls = document.getElementsByTagName('*');
    var bigScripts = Array.prototype.slice.call(document.querySelectorAll('script:not([src])'))
        .map(function (s) { return { bytes: (s.textContent || '').length, type: s.type || 'text/javascript', head: (s.textContent || '').slice(0, 80) }; })
        .sort(function (a, b) { return b.bytes - a.bytes; }).slice(0, 10);
    var bigStyles = Array.prototype.slice.call(document.querySelectorAll('style'))
        .map(function (s) { return { bytes: (s.textContent || '').length, head: (s.textContent || '').slice(0, 80) }; })
        .sort(function (a, b) { return b.bytes - a.bytes; }).slice(0, 10);
    var svgs = Array.prototype.slice.call(document.querySelectorAll('svg'))
        .map(function (s) { return { bytes: s.outerHTML.length, selector: cssPath(s) }; })
        .sort(function (a, b) { return b.bytes - a.bytes; });
    var bigAttrs = [];
    Array.prototype.slice.call(allEls).forEach(function (el) {
        Array.prototype.slice.call(el.attributes).forEach(function (at) {
            if (at.value.length > 512) bigAttrs.push({ attr: at.name, bytes: at.value.length, selector: cssPath(el) });
        });
    });
    // duplicated subtree suspects: identical outerHTML appearing 2+ times (>=2 KB)
    var htmlCounts = {};
    Array.prototype.slice.call(document.querySelectorAll('section [class]')).forEach(function (el) {
        var h = el.outerHTML;
        if (h.length >= 2048) {
            var key = h.length + ':' + h.slice(0, 120);
            (htmlCounts[key] = htmlCounts[key] || { count: 0, bytes: h.length, head: h.slice(0, 100) }).count++;
        }
    });
    var dupSubtrees = Object.keys(htmlCounts).map(function (k) { return htmlCounts[k]; })
        .filter(function (d) { return d.count > 1; }).sort(function (a, b) { return b.bytes * b.count - a.bytes * a.count; }).slice(0, 15);
    audit.dom = {
        nodeCount: allEls.length,
        htmlBytes: document.documentElement.outerHTML.length,
        inlineScripts: bigScripts, inlineStyles: bigStyles,
        svgCount: svgs.length, svgTotalBytes: svgs.reduce(function (s, x) { return s + x.bytes; }, 0),
        biggestSvgs: svgs.slice(0, 10), oversizedAttributes: bigAttrs.sort(function (a, b) { return b.bytes - a.bytes; }).slice(0, 10),
        duplicatedSubtreeSuspects: dupSubtrees
    };

    // ---------- E. resources & security ----------
    var res = performance.getEntriesByType ? performance.getEntriesByType('resource') : [];
    var thirdParty = {};
    res.forEach(function (r) {
        try {
            var o = new URL(r.name).origin;
            if (o !== origin) (thirdParty[o] = thirdParty[o] || []).push(r.initiatorType);
        } catch (e) { }
    });
    audit.resources = {
        total: res.length,
        thirdPartyOrigins: Object.keys(thirdParty).map(function (o) { return { origin: o, count: thirdParty[o].length, types: Array.from(new Set(thirdParty[o])) }; }),
        mixedContent: res.filter(function (r) { return location.protocol === 'https:' && r.name.indexOf('http://') === 0; }).map(function (r) { return r.name; }),
        cspViolations: (window.__cspViolations || []).slice(0, 50)
    };

    // ---------- output ----------
    window.__homepageAudit = audit;
    try {
        console.group('%cHomepage audit', 'font-weight:bold');
        console.table(audit.links.duplicateTexts);
        console.table(audit.headings.duplicates);
        console.table(audit.contrast.filter(function (c) { return c.fails; }));
        console.table(audit.dom.duplicatedSubtreeSuspects);
        console.table(audit.resources.cspViolations);
        console.log('DOM nodes:', audit.dom.nodeCount, '| headings:', audit.headings.total,
            '| internal links:', audit.links.internal, '| SVG bytes:', audit.dom.svgTotalBytes);
        console.groupEnd();
    } catch (e) { }
    return audit;
})();
