// @ts-check
/**
 * Adversarial rendering checks.
 *
 * These drive the real client-side renderers with hostile payloads and assert
 * that nothing is interpreted as markup or script. A payload that survives as
 * *text* is correct; a payload that becomes a DOM element is a defect.
 */
const { test, expect } = require('@playwright/test');
const { HOSTILE_INPUTS } = require('./_inventory.cjs');

const ORIGIN = process.env.BASE_URL || 'http://127.0.0.1:8000';

async function dismissPromo(page) {
    await page.evaluate(() => {
        try {
            sessionStorage.setItem('cs_promo_modal_closed', '1');
        } catch (e) { /* ignore */ }
        document.querySelectorAll('#promoModal, #promoBar').forEach((el) => {
            el.setAttribute('hidden', '');
            el.style.display = 'none';
        });
        document.body.classList.remove('has-promo-modal', 'has-promo-bar');
    }).catch(() => {});
}

/** Fail the test if the page ever raises a dialog (alert from a fired payload). */
function trapDialogs(page, sink) {
    page.on('dialog', async (d) => {
        sink.push(d.message());
        await d.dismiss().catch(() => {});
    });
}

/**
 * Tools whose main input is free text and which render that text back.
 * Each entry: slug + the payload we type in.
 */
const TEXT_TOOLS = [
    'word-counter',
    'text-case-converter',
    'html-to-text',
    'url-slug-generator',
    'readability-analyzer',
    'base64-encoder',
    'duplicate-content-checker',
    'lorem-ipsum-generator',
];

for (const slug of TEXT_TOOLS) {
    for (const [label, payload] of Object.entries(HOSTILE_INPUTS)) {
        test(`xss: ${slug} / ${label}`, async ({ page }) => {
            const dialogs = [];
            trapDialogs(page, dialogs);

            await page.goto(`/tools/${slug}`, { waitUntil: 'domcontentloaded' });
            await page.waitForLoadState('load');
            await dismissPromo(page);

            const input = page
                .locator('section.max-w-5xl textarea, section.max-w-5xl input[type="text"], ' +
                         'section.max-w-4xl textarea, section.max-w-4xl input[type="text"]')
                .first();
            if (await input.count()) await input.fill(payload);

            const btn = page
                .locator('section.max-w-5xl button[class*="bg-gradient"], section.max-w-5xl button.w-full, ' +
                         'section.max-w-4xl button[class*="bg-gradient"], section.max-w-4xl button.w-full')
                .first();
            if (await btn.count()) await btn.click({ timeout: 8000 }).catch(() => {});

            await page.waitForTimeout(1500);

            // No payload may have executed.
            expect(dialogs, 'a hostile payload triggered a dialog').toEqual([]);

            // No injected element may exist anywhere in the document.
            const injected = await page.evaluate(() => {
                const bad = [];
                document.querySelectorAll('img[src="x"], svg[onload], script').forEach((el) => {
                    // Inline app scripts are legitimate; only flag ones holding our marker.
                    if (el.tagName === 'SCRIPT' && !/alert\(1\)/.test(el.textContent || '')) return;
                    bad.push(el.outerHTML.slice(0, 120));
                });
                return bad;
            });
            expect(injected, 'hostile markup was parsed into the DOM').toEqual([]);
        });
    }
}

/**
 * The API result renderer interpolates server values into innerHTML.
 * Drive it with a stubbed API response containing markup in every field a
 * renderer touches, and assert none of it becomes DOM.
 */
test('xss: API result renderer escapes all server-supplied fields', async ({ page }) => {
    const dialogs = [];
    trapDialogs(page, dialogs);

    const PAYLOAD = '<img src=x onerror=alert(1)>';

    await page.route('**/api/tools/website-analyzer', async (route) => {
        await route.fulfill({
            status: 200,
            contentType: 'application/json',
            body: JSON.stringify({
                score: 50,
                grade: PAYLOAD,
                message: PAYLOAD,
                stats: { evil: PAYLOAD, alsoEvil: `<svg onload=alert(1)>` },
                issues: [{ type: PAYLOAD, message: PAYLOAD }],
                warnings: [PAYLOAD],
                recommendations: [PAYLOAD],
                links: [{ url: PAYLOAD, status: PAYLOAD, type: PAYLOAD }],
                headings: [{ level: 1, text: PAYLOAD }],
            }),
        });
    });

    await page.goto('/tools/website-analyzer', { waitUntil: 'domcontentloaded' });
    await page.waitForLoadState('load');
    await dismissPromo(page);

    // api-tools.js pose #tool-action-btn à l'initialisation : l'attendre plutôt
    // que de cliquer sur un bouton pas encore relié à son gestionnaire.
    const btn = page.locator('#tool-action-btn').first();
    await btn.waitFor({ state: 'attached', timeout: 15000 });

    await page.locator('section.max-w-5xl input').first().fill('https://example.com');
    await btn.click({ timeout: 10000 });

    await page.waitForTimeout(2500);

    expect(dialogs, 'server-supplied payload executed').toEqual([]);

    const injected = await page.evaluate(() => {
        const results = document.getElementById('tool-results');
        if (!results) return ['NO_RESULTS_RENDERED'];
        return Array.from(results.querySelectorAll('img[src="x"], svg[onload]')).map((el) =>
            el.outerHTML.slice(0, 120)
        );
    });
    expect(injected, 'server field was injected as markup into the results').toEqual([]);
});
