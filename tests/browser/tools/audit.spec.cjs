// @ts-check
const { test, expect } = require('@playwright/test');
const fs = require('fs');
const path = require('path');
const { TOOLS } = require('./_inventory.cjs');

const OUT_DIR = path.join(__dirname, '.results');
fs.mkdirSync(OUT_DIR, { recursive: true });

const ORIGIN = process.env.BASE_URL || 'http://127.0.0.1:8000';

/**
 * The site shows a site-wide promotional modal that overlays the page and
 * intercepts pointer events. A real visitor closes it once; suppression is
 * kept in sessionStorage. Dismiss it so the tool form is actually reachable.
 */
async function dismissPromo(page) {
    await page.evaluate(() => {
        try {
            sessionStorage.setItem('cs_promo_modal_closed', '1');
            sessionStorage.setItem('cs_promo_modal_pages', '0');
            localStorage.setItem('cs_promo_bar_dismissed_until', String(Date.now() + 864e5));
        } catch (e) { /* storage unavailable — fall through to clicking */ }
    }).catch(() => {});

    const closer = page.locator('#promoModal [data-promo-close]').first();
    if (await closer.count().catch(() => 0)) {
        await closer.click({ timeout: 3000 }).catch(() => {});
    }
    // Belt-and-braces: hide any promo chrome still capturing clicks.
    await page.evaluate(() => {
        document.querySelectorAll('#promoModal, #promoBar').forEach((el) => {
            el.setAttribute('hidden', '');
            el.style.display = 'none';
        });
        document.body.classList.remove('has-promo-modal', 'has-promo-bar');
    }).catch(() => {});
}

/**
 * Attach console + network collectors to a page.
 * Returns the mutable buckets so the test can assert on them afterwards.
 */
function collect(page) {
    const consoleErrors = [];
    const pageErrors = [];
    const failedRequests = [];

    page.on('console', (msg) => {
        if (msg.type() === 'error') consoleErrors.push(msg.text());
    });
    page.on('pageerror', (err) => pageErrors.push(String(err && err.message ? err.message : err)));
    page.on('requestfailed', (req) => {
        // Only same-origin failures indicate a defect in this app. Third-party
        // beacons (Google Analytics et al.) always fail in a sandboxed run.
        if (!req.url().startsWith(ORIGIN)) return;
        failedRequests.push({ url: req.url(), reason: req.failure()?.errorText || 'failed' });
    });
    page.on('response', (res) => {
        const url = res.url();
        // Only same-origin responses matter — third-party 4xx is out of scope.
        if (!url.startsWith('http://127.0.0.1:8000')) return;
        if (res.status() >= 400) failedRequests.push({ url, reason: `HTTP ${res.status()}` });
    });

    return { consoleErrors, pageErrors, failedRequests };
}

/**
 * Find the tool's primary action button.
 *
 * Tool scripts tag their own button with #tool-action-btn on init, so that is
 * the most reliable handle. Some pages carry several gradient/full-width
 * buttons (presets, "add a row", reset), so falling straight to the first one
 * clicks the wrong control — prefer the script-tagged button, then a button
 * whose label reads like a submit action, and only then the generic selector.
 */
async function primaryButton(page) {
    const tagged = page.locator('#tool-action-btn');
    if (await tagged.count()) return tagged.first();

    const byLabel = page.locator(
        'section.max-w-5xl button, section.max-w-4xl button'
    ).filter({ hasText: /^(générer|analyser|vérifier|convertir|calculer|encoder|décoder|minifier|formater|compter|extraire|construire|valider|tester)/i });
    if (await byLabel.count()) return byLabel.first();

    const scoped = page.locator(
        'section.max-w-5xl button[class*="bg-gradient"], section.max-w-5xl button.w-full, ' +
        'section.max-w-4xl button[class*="bg-gradient"], section.max-w-4xl button.w-full'
    );
    if (await scoped.count()) return scoped.first();
    return page.locator('#tool-action-btn').first();
}

/** Find the tool's primary text entry (textarea preferred, else text/url input). */
async function primaryInput(page) {
    const ta = page.locator('section.max-w-5xl textarea, section.max-w-4xl textarea').first();
    if (await ta.count()) return ta;
    const inp = page
        .locator('section.max-w-5xl input[type="url"], section.max-w-5xl input[type="text"], ' +
                 'section.max-w-4xl input[type="url"], section.max-w-4xl input[type="text"]')
        .first();
    if (await inp.count()) return inp;
    return null;
}

/** Snapshot of everything that reads as "a result appeared". */
async function resultSignal(page) {
    return page.evaluate(() => {
        const el = document.getElementById('tool-results');
        const err = document.getElementById('tool-error');
        const outputs = Array.from(
            document.querySelectorAll('pre, code, output, [id*="result"], [id*="output"], [class*="result"]')
        );
        const visibleText = outputs
            .filter((o) => o.offsetParent !== null)
            .map((o) => (o.textContent || '').trim())
            .filter(Boolean)
            .join('\n');
        return {
            hasResultsNode: !!el,
            resultText: el ? (el.textContent || '').trim().slice(0, 4000) : '',
            errorVisible: !!err && !err.classList.contains('hidden'),
            errorText: err ? (err.textContent || '').trim() : '',
            otherOutput: visibleText.slice(0, 4000),
        };
    });
}

// ─────────────────────────────────────────────────────────────────────────
// 1. The /tools index must expose one working card per tool page that exists
// ─────────────────────────────────────────────────────────────────────────
test('index: every tool card resolves to a live route', async ({ page }, testInfo) => {
    const buckets = collect(page);
    const res = await page.goto('/tools', { waitUntil: 'domcontentloaded' });
    expect(res?.status()).toBe(200);
    await dismissPromo(page);

    const slugs = await page.$$eval('#tools-grid a[href*="/tools/"]', (as) =>
        as.map((a) => a.getAttribute('href').split('/tools/')[1]).filter(Boolean)
    );

    const unique = [...new Set(slugs)];
    const known = TOOLS.map((t) => t.slug);
    const missingCards = known.filter((s) => !unique.includes(s));
    const orphanCards = unique.filter((s) => !known.includes(s));

    // Counter shown in the UI must agree with the number of cards rendered.
    const counterText = (await page.locator('#tools-count').textContent())?.trim();
    const searchPlaceholder = await page.locator('#tools-search').getAttribute('placeholder');

    fs.writeFileSync(
        path.join(OUT_DIR, `index-${testInfo.project.name}.json`),
        JSON.stringify(
            { cardCount: unique.length, counterText, searchPlaceholder, missingCards, orphanCards, ...buckets },
            null,
            2
        )
    );

    expect(orphanCards, 'cards pointing at non-existent tools').toEqual([]);
    expect(missingCards, 'tool pages with no card on /tools').toEqual([]);
    expect(Number(counterText), 'visible counter must match rendered cards').toBe(unique.length);
    expect(searchPlaceholder).toContain(String(unique.length));
});

// ─────────────────────────────────────────────────────────────────────────
// 2. Per-tool: load, no JS errors, form present, valid run, empty run
// ─────────────────────────────────────────────────────────────────────────
for (const tool of TOOLS) {
    test(`tool: ${tool.slug}`, async ({ page }, testInfo) => {
        const buckets = collect(page);
        const record = {
            name: tool.name,
            slug: tool.slug,
            url: `/tools/${tool.slug}`,
            type: tool.type,
            viewport: testInfo.project.name,
            http: null,
            formVisible: false,
            validInput: 'skip',
            emptyInput: 'skip',
            bugs: [],
        };

        const res = await page.goto(`/tools/${tool.slug}`, { waitUntil: 'domcontentloaded' });
        record.http = res?.status() ?? 0;
        expect(record.http, 'page must return 200').toBe(200);

        await page.waitForLoadState('load');
        await dismissPromo(page);

        const btn = await primaryButton(page);
        const input = await primaryInput(page);
        record.formVisible = (await btn.count()) > 0;

        if (!record.formVisible) {
            record.bugs.push('No primary action button found on the tool page.');
        } else {
            // ── Empty-input case first (must not crash, must not fake a result)
            if (input) await input.fill('');
            await btn.click({ trial: false }).catch(() => {});
            await page.waitForTimeout(1200);
            const empty = await resultSignal(page);
            record.emptyInput = empty.errorVisible || !empty.hasResultsNode ? 'pass' : 'fail';
            record.emptyResult = empty;
            if (record.emptyInput === 'fail') {
                record.bugs.push('Empty input produced a result instead of a validation message.');
            }

            // ── Valid-input case
            if (tool.fields) {
                // Multi-field tools (UTM builder, hreflang, local business schema…)
                // reject a single populated field, exactly as a real user would see.
                const all = page.locator(
                    'section.max-w-5xl input:not([type="file"]):not([type="hidden"]), section.max-w-5xl textarea, ' +
                    'section.max-w-4xl input:not([type="file"]):not([type="hidden"]), section.max-w-4xl textarea'
                );
                const n = await all.count();
                for (let i = 0; i < Math.min(n, tool.fields.length); i++) {
                    await all.nth(i).fill(tool.fields[i]).catch(() => {});
                }
            } else if (tool.upload) {
                const file = page.locator('input[type="file"]').first();
                if (await file.count()) {
                    await file.setInputFiles({
                        name: tool.upload.name,
                        mimeType: tool.upload.mimeType,
                        buffer: Buffer.from(tool.upload.base64, 'base64'),
                    });
                    await page.waitForTimeout(600);
                }
            } else if (tool.input !== null && input) {
                await input.fill(tool.input);
                // Confirm the value is committed before clicking: some tool
                // scripts read the field synchronously on click, and a click
                // racing the fill made a working tool look like it rejected
                // valid input.
                await expect(input).toHaveValue(tool.input, { timeout: 5000 }).catch(() => {});
                await input.dispatchEvent('input').catch(() => {});
                await input.dispatchEvent('change').catch(() => {});
            }
            await btn.click().catch((e) => record.bugs.push('Primary button click failed: ' + e.message));
            // API tools hit the network; client tools are instant.
            await page.waitForTimeout(tool.type === 'api' ? 12000 : 2000);
            const valid = await resultSignal(page);
            record.validResult = valid;

            const produced =
                (valid.hasResultsNode && valid.resultText.length > 0) || valid.otherOutput.length > 0;
            record.validInput = produced ? 'pass' : valid.errorVisible ? 'error' : 'fail';
            if (record.validInput === 'fail') {
                record.bugs.push('Valid input produced neither a result nor an error message.');
            }
        }

        record.consoleErrors = buckets.consoleErrors;
        record.pageErrors = buckets.pageErrors;
        record.failedRequests = buckets.failedRequests;

        fs.writeFileSync(
            path.join(OUT_DIR, `${tool.slug}-${testInfo.project.name}.json`),
            JSON.stringify(record, null, 2)
        );

        // Hard failures: uncaught JS exceptions and broken same-origin assets.
        expect(record.pageErrors, `uncaught JS errors on ${tool.slug}`).toEqual([]);
        expect(record.failedRequests, `failed same-origin requests on ${tool.slug}`).toEqual([]);
    });
}
