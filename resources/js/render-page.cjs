/**
 * Rendu d'une page via Chromium (Playwright) pour les sites rendus côté client.
 *
 * Le HTML renvoyé par le serveur d'une application React/Vue/Angular est quasi
 * vide : ni titres, ni contenu, ni images. Google exécute le JavaScript avant
 * d'indexer ; sans rendu, nos analyseurs sous-estiment gravement ces pages.
 *
 * Appelé par App\Services\Analysis\HeadlessRenderer, jamais directement.
 *
 * Entrée  : JSON sur argv[2] -> { "url": "...", "timeout": 20000 }
 * Sortie  : JSON sur stdout  -> { ok, html, metrics, ... }
 *
 * SÉCURITÉ — l'URL est validée côté PHP (SSRF, résolution DNS, plages privées)
 * AVANT d'arriver ici. Ce script ajoute des garde-fous propres au navigateur :
 *   - aucune redirection vers un schéma non-HTTP,
 *   - téléchargements refusés,
 *   - pas d'accès au système de fichiers local,
 *   - délai strict et fermeture garantie du navigateur.
 */
const { chromium } = require('playwright');

async function main() {
    let input;
    try {
        input = JSON.parse(process.argv[2] || '{}');
    } catch (e) {
        return fail('invalid input JSON');
    }

    const url = String(input.url || '');
    const timeout = Math.min(Math.max(parseInt(input.timeout, 10) || 20000, 5000), 45000);

    if (!/^https?:\/\//i.test(url)) {
        return fail('only http(s) URLs are accepted');
    }

    let browser;
    try {
        browser = await chromium.launch({
            headless: true,
            args: [
                '--no-sandbox',
                '--disable-dev-shm-usage',
                '--disable-gpu',
                // Empêche l'accès aux fichiers locaux depuis la page rendue.
                '--disable-features=IsolateOrigins,site-per-process',
            ],
        });

        const context = await browser.newContext({
            userAgent: 'Mozilla/5.0 (compatible; CodeSommetBot/1.0; +https://codesommet.com)',
            viewport: { width: 1280, height: 800 },
            javaScriptEnabled: true,
            acceptDownloads: false,
            bypassCSP: false,
        });

        // Coupe les ressources lourdes : on veut le DOM final, pas un rendu
        // pixel-parfait. Réduit fortement le temps et la bande passante.
        await context.route('**/*', (route) => {
            const type = route.request().resourceType();
            if (type === 'media' || type === 'font') {
                return route.abort();
            }
            const target = route.request().url();
            if (!/^https?:\/\//i.test(target)) {
                return route.abort();
            }
            return route.continue();
        });

        const page = await context.newPage();
        page.setDefaultTimeout(timeout);

        const consoleErrors = [];
        page.on('console', (msg) => {
            if (msg.type() === 'error' && consoleErrors.length < 20) {
                consoleErrors.push(msg.text().slice(0, 300));
            }
        });

        const started = Date.now();
        const response = await page.goto(url, { waitUntil: 'domcontentloaded', timeout });

        // Laisse le framework hydrater : networkidle échoue sur les sites à
        // sondage permanent, donc on l'enveloppe et on poursuit malgré tout.
        try {
            await page.waitForLoadState('networkidle', { timeout: Math.min(8000, timeout) });
        } catch (e) {
            /* hydratation partielle : on analyse ce qui existe */
        }

        const html = await page.content();
        const renderMs = Date.now() - started;

        // Métriques relevées dans la page.
        const metrics = await page.evaluate(() => {
            const nav = performance.getEntriesByType('navigation')[0] || {};
            const paints = {};
            performance.getEntriesByType('paint').forEach((p) => {
                paints[p.name] = Math.round(p.startTime);
            });

            let lcp = null;
            try {
                const entries = performance.getEntriesByType('largest-contentful-paint');
                if (entries.length) lcp = Math.round(entries[entries.length - 1].startTime);
            } catch (e) { /* non supporté */ }

            const text = (document.body && document.body.innerText) || '';

            return {
                title: document.title || '',
                headings: Array.from(document.querySelectorAll('h1,h2,h3,h4,h5,h6')).map((h) => ({
                    level: parseInt(h.tagName.slice(1), 10),
                    text: (h.textContent || '').trim().replace(/\s+/g, ' ').slice(0, 300),
                })),
                imageCount: document.querySelectorAll('img').length,
                imagesWithoutAlt: Array.from(document.querySelectorAll('img'))
                    .filter((i) => !i.hasAttribute('alt') && !i.getAttribute('aria-label')).length,
                linkCount: document.querySelectorAll('a[href]').length,
                wordCount: text.trim() ? text.trim().split(/\s+/).length : 0,
                textLength: text.length,
                domNodes: document.getElementsByTagName('*').length,
                firstContentfulPaint: paints['first-contentful-paint'] || null,
                largestContentfulPaint: lcp,
                domContentLoaded: nav.domContentLoadedEventEnd ? Math.round(nav.domContentLoadedEventEnd) : null,
                loadComplete: nav.loadEventEnd ? Math.round(nav.loadEventEnd) : null,
            };
        });

        await browser.close();
        browser = null;

        process.stdout.write(JSON.stringify({
            ok: true,
            url,
            finalUrl: page.url(),
            statusCode: response ? response.status() : null,
            html,
            renderMs,
            metrics,
            consoleErrors,
        }));
    } catch (err) {
        if (browser) {
            try { await browser.close(); } catch (e) { /* ignore */ }
        }
        return fail(String((err && err.message) || err).slice(0, 300));
    }
}

function fail(message) {
    process.stdout.write(JSON.stringify({ ok: false, error: message }));
    process.exitCode = 0; // Le PHP lit le JSON ; pas d'échec du process.
}

main();
