// @ts-check
/**
 * SEO remediation contract (audit 2026-09-30, remediation 2026-10-01).
 * Guards the fixes that are easy to regress silently:
 *   1. hero H1 contains its highlighted phrase once (data-sizer pattern, F-03),
 *   2. no template syntax / mojibake / Cloudflare email placeholder is visible (F-04, F-05, F-28),
 *   3. showcase videos are not downloaded before they approach the viewport (F-08),
 *   4. without JavaScript the preloader never hides the page (F-07),
 *   5. no console errors, no horizontal overflow.
 *
 * Run against `php artisan serve` (BASE_URL defaults to http://127.0.0.1:8000).
 */
const { test, expect } = require('@playwright/test');

const PAGES = [
    '/',
    '/services/ecommerce-website-development',
    '/services/edtech-platform-development',
    '/web-development-company/paris',
    '/web-development-company/casablanca',
    '/our-work/dental-pro',
    '/blog/creer-une-plateforme-saas-mvp-multi-tenant-facturation-par-ou-commencer',
    '/legal/privacy-policy',
    '/tools/utm-builder',
    '/tools/qr-code-generator',
];

for (const path of PAGES) {
    test(`clean render: ${path}`, async ({ page }) => {
        const errors = [];
        // Third parties are blocked below; their aborted requests surface as console
        // "ERR_FAILED" errors whose source URL is the blocked host — ignore only those.
        const THIRD_PARTY = /googletagmanager|google-analytics|cal\.com|recaptcha|gstatic/;
        page.on('console', (m) => {
            if (m.type() === 'error' && !THIRD_PARTY.test(m.text()) && !THIRD_PARTY.test(m.location().url || '')) errors.push(m.text());
        });
        page.on('pageerror', (e) => errors.push(String(e)));
        await page.route(THIRD_PARTY, (r) => r.abort());

        const response = await page.goto(path, { waitUntil: 'load' });
        expect(response && response.status()).toBe(200);

        const text = await page.evaluate(() => document.body.innerText);
        expect(text, 'no Blade syntax').not.toMatch(/\{\{|\}\}|__\(|@lang/);
        expect(text, 'no Cloudflare email placeholder').not.toContain('[email');
        expect(text, 'no mojibake').not.toMatch(/Ã[\u0080-ÿ]|â€/);

        const h1 = await page.evaluate(() => {
            const els = document.querySelectorAll('h1');
            return { count: els.length, text: els[0] ? els[0].textContent.replace(/\s+/g, ' ').trim() : '' };
        });
        expect(h1.count).toBe(1);
        // The old markup put the phrase in two adjacent spans with no whitespace between
        // them ("…B2BPLATEFORMES EDTECH B2B"), so compare with all whitespace removed.
        const compact = h1.text.toLowerCase().replace(/\s+/g, '');
        expect(compact, 'H1 does not repeat a phrase').not.toMatch(/(.{8,})\1/);

        const overflow = await page.evaluate(() => document.documentElement.scrollWidth - window.innerWidth);
        expect(overflow, 'no horizontal overflow').toBeLessThanOrEqual(1);
        expect(errors).toEqual([]);
    });
}

test('showcase videos are only requested near the viewport', async ({ page }) => {
    const mp4 = new Set();
    page.on('request', (r) => { if (/\.mp4(\?|$)/.test(r.url())) mp4.add(r.url()); });
    await page.goto('/web-development-company/abudhabi', { waitUntil: 'load' });
    await page.waitForTimeout(1000);
    expect(mp4.size, 'no MP4 before scrolling').toBe(0);

    const video = page.locator('video').first();
    await video.scrollIntoViewIfNeeded();
    await expect.poll(() => video.evaluate((v) => !!v.getAttribute('src'))).toBe(true);
    expect(mp4.size).toBeGreaterThan(0);
});

test.describe('without JavaScript', () => {
    test.use({ javaScriptEnabled: false });

    test('preloader never hides the page', async ({ page }) => {
        await page.goto('/services/ecommerce-website-development', { waitUntil: 'load' });
        const display = await page.evaluate(() => {
            const p = document.getElementById('preloader');
            return p ? getComputedStyle(p).display : 'none';
        });
        expect(display).toBe('none');
    });
});
