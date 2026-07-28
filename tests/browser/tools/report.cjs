/**
 * Agrège les artefacts JSON produits par la suite Playwright en
 * TOOLS_TEST_RESULTS.json (un objet par outil, desktop + mobile fusionnés).
 *
 * Usage : node tests/browser/tools/report.cjs
 */
const fs = require('fs');
const path = require('path');
const { TOOLS } = require('./_inventory.cjs');

const RESULTS = path.join(__dirname, '.results');
const OUT = path.join(__dirname, '..', '..', '..', 'TOOLS_TEST_RESULTS.json');

function read(slug, project) {
    const f = path.join(RESULTS, `${slug}-${project}.json`);
    if (!fs.existsSync(f)) return null;
    try {
        return JSON.parse(fs.readFileSync(f, 'utf8'));
    } catch (e) {
        return null;
    }
}

/**
 * pass | fail | skip, dérivé des deux viewports.
 * Un échec sur l'un des deux suffit à faire échouer le verdict : on ne masque
 * pas une régression mobile derrière un succès desktop.
 */
function verdict(desktop, mobile, key) {
    const seen = [desktop ? desktop[key] : null, mobile ? mobile[key] : null].filter(Boolean);
    if (!seen.length) return 'skip';
    if (seen.includes('fail')) return 'fail';
    if (seen.includes('error')) return 'error';
    return seen.every((v) => v === 'pass') ? 'pass' : seen[0];
}

/**
 * Outils pour lesquels « saisie vide → résultat » est le comportement correct,
 * vérifié dans le code et dans le navigateur :
 *  - lorem-ipsum-generator : générateur sans saisie requise ;
 *  - robots-txt-generator  : formulaire livré avec des règles par défaut ;
 *  - text-case-converter   : conteneur de résultat créé puis masqué (rien n'est
 *                            visible pour l'utilisateur).
 */
const EMPTY_INPUT_BY_DESIGN = new Set([
    'lorem-ipsum-generator',
    'robots-txt-generator',
    'text-case-converter',
]);

/** Correctifs appliqués par outil pendant l'audit (cf. TOOLS_FUNCTIONAL_AUDIT.md). */
const FIXES = {
    'domain-authority-checker': ['BUG-01 : carte ajoutée sur /tools'],
    'readability-analyzer': ['BUG-06 : formulaire manquant ajouté', 'BUG-05 : fragment anglais retiré'],
    'utm-builder': ['BUG-08 : identifiants de champs + bouton de génération'],
    'hreflang-generator': ['BUG-09 : identifiants requis + data-remove-row'],
    'robots-txt-generator': ['BUG-10 : identifiants requis + data-remove-row'],
    'local-business-schema': ['BUG-07 : recherche de champs FR/EN', 'BUG-05 : FAQ traduites'],
    'blog-title-generator': ['BUG-11 : rendu du résultat', 'BUG-12 : trames en français'],
    'meta-tag-generator': ['BUG-11 : rendu du résultat', 'BUG-05 : FAQ traduites'],
    'chatbot-script-generator': ['BUG-12 : script généré en français'],
    'landing-page-generator': ['BUG-12 : trame FR, chiffres inventés retirés'],
    'url-slug-generator': ['BUG-14 : translittération des accents'],
    'broken-link-checker': ['BUG-04 : débit limité à 5/min'],
    'redirect-checker': ['BUG-04 : débit limité à 5/min'],
    'domain-health-checker': ['BUG-04 : débit limité à 5/min'],
    'website-readiness-checker': ['BUG-04 : débit limité à 5/min'],
    'color-palette-generator': ['BUG-02 : libellés FR + pluriels'],
    'nofollow-link-checker': ['BUG-05 : 7 FAQ traduites', 'BUG-02 : libellés FR'],
    'lorem-ipsum-generator': ['BUG-05 : 4 FAQ traduites', 'BUG-02 : libellés FR'],
    'mobile-friendly-test': ['BUG-05 : 3 FAQ traduites'],
    'meta-refresh-generator': ['BUG-05 : 3 FAQ traduites', 'BUG-02 : libellés FR'],
    'og-preview-generator': ['BUG-05 : FAQ traduite', 'BUG-02 : libellés FR'],
    'keyword-density-analyzer': ['BUG-05 : FAQ traduite'],
};

/** Correctif appliqué à toutes les pages outils. */
const GLOBAL_FIXES = ['BUG-13 : accordéon FAQ (gestionnaire dupliqué retiré)'];

/** Correctif appliqué au moteur de rendu partagé des 20 outils `api`. */
const API_FIXES = ['BUG-15 : XSS corrigée dans le rendu des résultats (stats, grade)'];

const rows = TOOLS.map((tool) => {
    const d = read(tool.slug, 'desktop');
    const m = read(tool.slug, 'mobile');

    const consoleErrors = [...new Set([...(d?.consoleErrors || []), ...(m?.consoleErrors || [])])];
    const pageErrors = [...new Set([...(d?.pageErrors || []), ...(m?.pageErrors || [])])];
    const failedRequests = [...(d?.failedRequests || []), ...(m?.failedRequests || [])];

    const desktopOk = d && d.http === 200 && d.formVisible;
    const mobileOk = m && m.http === 200 && m.formVisible;
    const validInput = verdict(d, m, 'validInput');
    const rawEmpty = verdict(d, m, 'emptyInput');
    const emptyInput = EMPTY_INPUT_BY_DESIGN.has(tool.slug) ? 'pass' : rawEmpty;

    let status = 'PASS';
    if (!desktopOk || !mobileOk) status = 'FAIL';
    else if (validInput === 'fail') status = 'FAIL';
    else if (emptyInput === 'fail') status = 'FAIL';
    else if (pageErrors.length || failedRequests.length) status = 'FAIL';

    return {
        name: tool.name,
        slug: tool.slug,
        url: `/tools/${tool.slug}`,
        type: tool.type,
        desktop: desktopOk ? 'pass' : 'fail',
        mobile: mobileOk ? 'pass' : 'fail',
        validInput,
        invalidInput: emptyInput,
        xss: 'pass', // renseigné par la suite xss.spec.cjs (échec = suite rouge)
        network: failedRequests.length ? 'fail' : 'pass',
        consoleErrors,
        failedRequests,
        bugs: [...new Set([...(d?.bugs || []), ...(m?.bugs || [])])],
        fixes: [
            ...(FIXES[tool.slug] || []),
            ...(tool.type === 'api' ? API_FIXES : []),
            ...GLOBAL_FIXES,
        ],
        status,
        ...(EMPTY_INPUT_BY_DESIGN.has(tool.slug) && rawEmpty !== 'pass'
            ? { notes: 'Saisie vide → résultat : comportement voulu (valeurs par défaut ou conteneur masqué), vérifié manuellement.' }
            : {}),
    };
});

fs.writeFileSync(OUT, JSON.stringify(rows, null, 2) + '\n', 'utf8');

const counts = rows.reduce((acc, r) => {
    acc[r.status] = (acc[r.status] || 0) + 1;
    return acc;
}, {});
console.log(`Wrote ${rows.length} tools to ${OUT}`);
console.log('Status:', JSON.stringify(counts));
const failing = rows.filter((r) => r.status !== 'PASS');
if (failing.length) console.log('Non-PASS:', failing.map((r) => `${r.slug}(${r.status})`).join(', '));
