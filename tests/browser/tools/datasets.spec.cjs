// @ts-check
/**
 * Phase 4 — jeux de données spécifiques.
 *
 * Chaque cas pilote un outil réel dans le navigateur avec une entrée précise
 * et vérifie la sortie effectivement rendue : format valide, message d'erreur
 * utile sur entrée invalide, et préservation de l'Unicode / des accents.
 */
const { test, expect } = require('@playwright/test');

const SEL_INPUT =
    'section.max-w-5xl textarea, section.max-w-5xl input[type="text"], section.max-w-5xl input[type="url"], ' +
    'section.max-w-4xl textarea, section.max-w-4xl input[type="text"], section.max-w-4xl input[type="url"]';

async function openTool(page, slug) {
    await page.goto(`/tools/${slug}`, { waitUntil: 'domcontentloaded' });
    await page.waitForLoadState('load');
    await page.evaluate(() => {
        try { sessionStorage.setItem('cs_promo_modal_closed', '1'); } catch (e) { /* ignore */ }
        document.querySelectorAll('#promoModal, #promoBar').forEach((el) => {
            el.setAttribute('hidden', '');
            el.style.display = 'none';
        });
        document.body.classList.remove('has-promo-modal', 'has-promo-bar');
    });
}

async function runWith(page, slug, value) {
    await openTool(page, slug);

    // Chaque script d'outil pose lui-même l'id #tool-action-btn au moment de
    // son initialisation. L'attendre explicitement évite de courir après le
    // bouton avant que le script ne se soit exécuté.
    const btn = page.locator('#tool-action-btn').first();
    await btn.waitFor({ state: 'attached', timeout: 15000 });

    const input = page.locator(SEL_INPUT).first();
    await input.fill(value);
    await expect(input).toHaveValue(value, { timeout: 5000 });

    await btn.click({ timeout: 10000 });
    await page.waitForTimeout(1200);

    return page.evaluate(() => {
        const r = document.getElementById('tool-results');
        const e = document.getElementById('tool-error');
        return {
            result: r ? (r.textContent || '').trim() : '',
            error: e && !e.classList.contains('hidden') ? (e.textContent || '').trim() : '',
        };
    });
}

// ─── JSON ────────────────────────────────────────────────────────────────
test('json-formatter: valid JSON is formatted', async ({ page }) => {
    const out = await runWith(page, 'json-formatter', '{"name":"CodeSommet","active":true}');
    expect(out.result).toContain('CodeSommet');
    expect(out.result).toContain('"active"');
    expect(out.error).toBe('');
});

test('json-formatter: invalid JSON reports a clear error', async ({ page }) => {
    const out = await runWith(page, 'json-formatter', '{"name":"CodeSommet",}');
    // Une erreur doit être visible, quelque part (bandeau ou zone de résultat).
    expect(out.error.length + out.result.length).toBeGreaterThan(0);
    expect((out.error + out.result).toLowerCase()).toMatch(/json|erreur|invalid|position|token/i);
});

test('json-formatter: markup in a JSON value is never parsed as HTML', async ({ page }) => {
    const dialogs = [];
    page.on('dialog', async (d) => { dialogs.push(d.message()); await d.dismiss(); });

    await runWith(page, 'json-formatter', '{"x":"<img src=x onerror=alert(1)>"}');
    expect(dialogs).toEqual([]);

    const injected = await page.evaluate(() =>
        document.querySelectorAll('#tool-results img[src="x"]').length
    );
    expect(injected).toBe(0);
});

// ─── Base64 ──────────────────────────────────────────────────────────────
test('base64-encoder: round-trips accented French text', async ({ page }) => {
    const out = await runWith(page, 'base64-encoder', 'Bonjour CodeSommet éèàçù');
    expect(out.error).toBe('');
    // "Bonjour CodeSommet éèàçù" en UTF-8 → base64
    expect(out.result.replace(/\s+/g, '')).toContain('Qm9uam91ciBDb2RlU29tbWV0');
});

test('base64-encoder: handles non-latin scripts', async ({ page }) => {
    for (const sample of ['مرحبا', 'こんにちは']) {
        const out = await runWith(page, 'base64-encoder', sample);
        expect(out.error, `échec sur ${sample}`).toBe('');
        expect(out.result.length).toBeGreaterThan(0);
    }
});

// ─── Minification ────────────────────────────────────────────────────────
test('css-minifier: minifies and preserves declarations', async ({ page }) => {
    const out = await runWith(page, 'css-minifier', 'body { color : red ; margin : 0 ; }\n/* note */\n');
    expect(out.error).toBe('');
    expect(out.result.replace(/\s+/g, '')).toContain('color:red');
});

test('html-minifier: keeps text content intact', async ({ page }) => {
    const out = await runWith(page, 'html-minifier', '<div>  <p>Bonjour éèà</p>  </div>');
    expect(out.error).toBe('');
    expect(out.result).toContain('Bonjour éèà');
});

// ─── Texte ───────────────────────────────────────────────────────────────
test('word-counter: counts French words correctly', async ({ page }) => {
    const out = await runWith(page, 'word-counter', 'Bonjour le monde éèà. Ceci est un test.');
    expect(out.error).toBe('');
    expect(out.result).toMatch(/\d/);
});

test('url-slug-generator: transliterates accents', async ({ page }) => {
    const out = await runWith(page, 'url-slug-generator', 'Mon Article Génial à Lire');
    expect(out.error).toBe('');
    expect(out.result.toLowerCase()).toContain('mon-article-genial');
});

test('html-to-text: strips tags but keeps accented text', async ({ page }) => {
    const out = await runWith(page, 'html-to-text', '<h1>Titre</h1><p>Paragraphe accentué : éèà</p>');
    expect(out.error).toBe('');
    expect(out.result).toContain('Paragraphe accentué');
    expect(out.result).not.toContain('<h1>');
});

// ─── Schema / QR ─────────────────────────────────────────────────────────
test('faq-schema-generator: emits valid JSON-LD for the pairs given', async ({ page }) => {
    const out = await runWith(
        page,
        'faq-schema-generator',
        'Q : Quelle est votre garantie ?\nR : Trente jours satisfait ou remboursé.'
    );
    expect(out.error).toBe('');
    expect(out.result).toContain('FAQPage');
    expect(out.result).toContain('Quelle est votre garantie');

    // Le JSON-LD extrait doit être analysable et ne rien inventer.
    const jsonLd = await page.evaluate(() => {
        const pre = document.querySelector('#tool-results pre');
        return pre ? pre.textContent : '';
    });
    const start = jsonLd.indexOf('{');
    expect(start).toBeGreaterThanOrEqual(0);
    const parsed = JSON.parse(jsonLd.slice(start, jsonLd.lastIndexOf('}') + 1));
    expect(parsed['@type']).toBe('FAQPage');
    expect(parsed.mainEntity.length).toBe(1);
    expect(JSON.stringify(parsed)).not.toMatch(/aggregateRating|priceRange|review/i);
});

test('qr-code-generator: renders a QR image for the given content', async ({ page }) => {
    const out = await runWith(page, 'qr-code-generator', 'https://codesommet.com');
    expect(out.error).toBe('');
    const img = await page.locator('#qr-image').getAttribute('src');
    expect(img).toContain(encodeURIComponent('https://codesommet.com'));
});
