// @ts-check
/**
 * FAQ accordion — browser/DOM contract for pages whose answers are server-rendered
 * (lang faq_a* keys). Verifies that:
 *   1. answers exist in the initial HTML (before any JS runs),
 *   2. JS does not overwrite them,
 *   3. clicking opens the answer, sets aria-expanded/aria-controls correctly,
 *   4. one-open-at-a-time accordion behaviour still works,
 *   5. no console errors are thrown.
 *
 * Pages under test come from FAQ_PAGES (comma-separated paths) or the default list.
 * Run against `php artisan serve` (BASE_URL defaults to http://127.0.0.1:8000).
 */
const { test, expect } = require('@playwright/test');

const DEFAULT_PAGES = [
    '/services/telemedicine-website-development',
    '/services/fintech-website-development',
    '/services/edtech-platform-development',
    '/services/elearning-platform-development',
    '/services/ecommerce-website-development',
    '/services/healthcare-website-development',
    '/web-development-company/casablanca',
];
const PAGES = (process.env.FAQ_PAGES ? process.env.FAQ_PAGES.split(',') : DEFAULT_PAGES).map((p) => p.trim()).filter(Boolean);

for (const path of PAGES) {
    test(`FAQ accordion is server-rendered and interactive: ${path}`, async ({ page, request, baseURL }) => {
        // 1. Initial HTML (no JS) contains the answers.
        const raw = await (await request.get(path)).text();
        const initialAnswers = (raw.match(/class="faq-answer/g) || []).length;
        const initialControls = (raw.match(/aria-controls="faq-answer-/g) || []).length;
        expect(initialAnswers, 'answers present in initial HTML').toBeGreaterThan(0);
        expect(initialControls, 'aria-controls present in initial HTML').toBe(initialAnswers);
        const firstAnswerText = (raw.match(/id="faq-answer-1"[\s\S]*?<p[^>]*>([\s\S]*?)<\/p>/) || [])[1];
        const decode = (t) => t.replace(/&#0?39;|&#x27;/g, "'").replace(/&quot;/g, '"').replace(/&lt;/g, '<').replace(/&gt;/g, '>').replace(/&nbsp;/g, ' ').replace(/&amp;/g, '&');
        expect(firstAnswerText && firstAnswerText.trim().length, 'first answer has text').toBeGreaterThan(20);

        // 2. Load with JS and make sure nothing was overwritten or duplicated.
        const errors = [];
        page.on('pageerror', (e) => errors.push(String(e)));
        page.on('console', (m) => { if (m.type() === 'error') errors.push(m.text()); });
        await page.goto(path, { waitUntil: 'networkidle' });
        // Dismiss marketing overlays (promo modal / sticky bar) that intercept pointer events.
        await page.evaluate(() => {
            ['promoModal', 'promoBar'].forEach((id) => { const el = document.getElementById(id); if (el) el.remove(); });
        });

        const answers = page.locator('.faq-answer');
        await expect(answers).toHaveCount(initialAnswers);
        const domFirst = (await page.locator('#faq-answer-1 p').first().textContent() || '').trim();
        expect(domFirst.replace(/\s+/g, ' ')).toBe(decode(firstAnswerText).trim().replace(/\s+/g, ' '));
        expect(domFirst).not.toContain('Contactez-nous pour en discuter en détail');

        const buttons = page.locator('button[aria-controls^="faq-answer-"]');
        await expect(buttons).toHaveCount(initialAnswers);
        const b1 = buttons.nth(0), b2 = buttons.nth(1);
        const a1 = page.locator('#faq-answer-1'), a2 = page.locator('#faq-answer-2');

        // 3. Collapsed by default.
        await expect(b1).toHaveAttribute('aria-expanded', 'false');
        expect(await a1.evaluate((el) => el.getBoundingClientRect().height)).toBe(0);

        // 4. Open first → visible, aria true.
        await b1.scrollIntoViewIfNeeded();
        await b1.click();
        await expect(b1).toHaveAttribute('aria-expanded', 'true');
        await expect.poll(async () => a1.evaluate((el) => el.getBoundingClientRect().height)).toBeGreaterThan(20);
        await expect(a1.locator('p').first()).toContainText(domFirst.slice(0, 30));

        // 5. Open second → first closes (existing one-open-at-a-time behaviour).
        await b2.scrollIntoViewIfNeeded();
        await b2.click();
        await expect(b2).toHaveAttribute('aria-expanded', 'true');
        await expect.poll(async () => a2.evaluate((el) => el.getBoundingClientRect().height)).toBeGreaterThan(20);
        if (path.startsWith('/services/')) {
            // service accordion: one open at a time
            await expect(b1).toHaveAttribute('aria-expanded', 'false');
            await expect.poll(async () => a1.evaluate((el) => el.getBoundingClientRect().height)).toBe(0);
        } else {
            // location accordion: independent toggles (existing behaviour)
            await expect(b1).toHaveAttribute('aria-expanded', 'true');
        }

        // 6. aria-controls points at the right panel.
        expect(await b1.getAttribute('aria-controls')).toBe('faq-answer-1');
        expect(await b2.getAttribute('aria-controls')).toBe('faq-answer-2');

        // 7. No JS errors.
        expect(errors, 'console/page errors').toEqual([]);
    });
}
