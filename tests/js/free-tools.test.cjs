/**
 * Unit tests for the pure logic of the client-side tools (no browser).
 * Run: node --test tests/js/free-tools.test.cjs
 */
const test = require('node:test');
const assert = require('node:assert/strict');
const path = require('node:path');
const fs = require('node:fs');
const vm = require('node:vm');

// The project's package.json is "type": "module", so these classic browser
// scripts cannot be require()d. Evaluate each one with a CommonJS-style
// `module` object instead (no window/document: only the pure logic runs).
const load = (name) => {
    const file = path.join(__dirname, '../../public/js/tools', name + '.js');
    const sandbox = { module: { exports: {} }, URL, console };
    vm.runInNewContext(fs.readFileSync(file, 'utf8'), sandbox, { filename: file });
    // Objects created in the sandbox belong to another realm: clone results
    // back so assert.deepStrictEqual compares values, not prototypes.
    const api = {};
    for (const [key, fn] of Object.entries(sandbox.module.exports)) {
        api[key] = (...args) => {
            const out = fn(...args);
            return out === undefined ? out : JSON.parse(JSON.stringify(out));
        };
    }
    return api;
};

const urlEditor = load('url-editor');
const textEditor = load('text-editor');
const domains = load('domain-extractor');
const cleaner = load('invisible-character-cleaner');
const images = load('image-compressor');
const keywords = load('keyword-modifier-generator');

test('url-editor removes tracking params, fragments and duplicates; keeps content params', () => {
    const r = urlEditor.process(
        'https://Example.com/page?utm_source=x&page=2#avis\nexample.com/page?page=2&gclid=abc\nnot a url ::\n\n',
        { trim: true, fragment: true, params: 'tracking', dedupe: true }
    );
    assert.deepEqual(r.urls, ['https://example.com/page?page=2']);
    assert.deepEqual(r.invalid, ['not a url ::']);
    assert.equal(r.duplicates, 1);
    assert.equal(r.inputLines, 3);
});

test('url-editor root, https, www and trailing slash options', () => {
    const o = { trim: true, https: true, www: true, slash: true, params: 'all', dedupe: true };
    assert.deepEqual(urlEditor.process('http://www.example.com/blog/post/?a=1', o).urls, ['https://example.com/blog/post']);
    assert.deepEqual(urlEditor.process('https://example.com/', o).urls, ['https://example.com']);
    assert.deepEqual(urlEditor.process('https://a.example.com/x/y', { trim: true, root: true }).urls, ['https://a.example.com/']);
    assert.deepEqual(urlEditor.process('https://a.com/blog\nhttps://a.com/tag/x', { trim: true, exclude: '/tag/' }).urls, ['https://a.com/blog']);
    assert.deepEqual(urlEditor.process('ftp://a.com/x\nhttps://localhost/', { trim: true }).invalid.length, 2);
});

test('text-editor applies operations in the documented order', () => {
    const r = textEditor.process('  agence web (prix)\nAgence Web\n\nseo rabat\nagence web', {
        trim: true, empty: true, dedupe: true, caseInsensitive: true, brackets: true, sort: 'az',
    });
    assert.deepEqual(r.lines, ['agence web', 'seo rabat']);
    assert.equal(r.duplicates, 2);
});

test('text-editor find/replace, regex errors, filters, prefix and numbering', () => {
    assert.deepEqual(textEditor.process('a-b\nc-d', { find: '-', replace: ' ' }).lines, ['a b', 'c d']);
    assert.deepEqual(textEditor.process('x1\nx22', { find: '\\d+', replace: '#', regex: true }).lines, ['x#', 'x#']);
    assert.match(textEditor.process('x', { find: '(', regex: true }).error, /invalide/);
    assert.deepEqual(textEditor.process('seo rabat\nweb fes', { keep: 'seo', prefix: '"', suffix: '"', number: true }).lines, ['1. "seo rabat"']);
    assert.deepEqual(textEditor.process('bb\na\nccc', { sort: 'lendesc' }).lines, ['ccc', 'bb', 'a']);
});

test('domain-extractor handles multi-level public suffixes and counts URLs', () => {
    assert.equal(domains.rootDomain('blog.exemple.co.ma'), 'exemple.co.ma');
    assert.equal(domains.rootDomain('shop.exemple.com'), 'exemple.com');
    assert.equal(domains.rootDomain('a.b.example.co.uk'), 'example.co.uk');
    assert.equal(domains.rootDomain('user.github.io'), 'user.github.io');
    const r = domains.process('https://blog.exemple.co.ma/a\nwww.exemple.co.ma/b\nhttps://shop.other.com/x\n192.168.0.1\n:::', 'root');
    assert.deepEqual(r.domains, [{ domain: 'exemple.co.ma', count: 2 }, { domain: 'other.com', count: 1 }]);
    assert.equal(r.invalid.length, 2);
    assert.deepEqual(domains.process('https://blog.exemple.co.ma/a', 'host').domains[0].domain, 'blog.exemple.co.ma');
});

test('invisible-character-cleaner removes hidden characters but keeps emoji sequences', () => {
    const dirty = 'Agence​ web Maroc‮­';
    const r = cleaner.clean(dirty, { spaces: true });
    assert.equal(r.text, 'Agence web Maroc');
    assert.equal(r.invisible, 3);
    assert.equal(r.spaces, 1);
    assert.deepEqual(r.findings.map((f) => f.code).sort(), ['U+00A0', 'U+00AD', 'U+200B', 'U+202E']);
    // Family emoji uses U+200D between emoji: must be kept.
    const family = '\u{1F468}‍\u{1F469}‍\u{1F467}';
    assert.equal(cleaner.clean(family, { spaces: true }).text, family);
    // Tag characters outside a flag are removed.
    assert.equal(cleaner.clean('ok\u{E0041}\u{E0042}', {}).text, 'ok');
    // Line breaks and tabs are preserved.
    assert.equal(cleaner.clean('a\n\tb', {}).text, 'a\n\tb');
});

test('invisible-character-cleaner optional normalisations', () => {
    const r = cleaner.clean('« Il dit  “oui”… »', { spaces: true, quotes: true, ellipsis: true, collapse: true });
    assert.equal(r.text, '" Il dit "oui"... "');
    assert.ok(r.other > 0);
    assert.equal(cleaner.clean('propre', { spaces: true }).findings.length, 0);
});

test('image-compressor never upscales and names outputs', () => {
    assert.deepEqual(images.targetSize(4000, 3000, 1600), { width: 1600, height: 1200 });
    assert.deepEqual(images.targetSize(800, 600, 1600), { width: 800, height: 600 });
    assert.deepEqual(images.targetSize(800, 600, 0), { width: 800, height: 600 });
    assert.equal(images.outputName('photo.vacances.PNG', 'image/webp'), 'photo.vacances-optimise.webp');
    assert.equal(images.formatBytes(2048), '2,0 Ko');
});

test('keyword-modifier-generator is deterministic and deduplicated', () => {
    const a = keywords.generate(['création site web'], 'fr', ['questions', 'transactional', 'local'], ['Rabat']);
    const b = keywords.generate(['création site web'], 'fr', ['questions', 'transactional', 'local'], ['Rabat']);
    assert.deepEqual(a, b);
    const all = a.groups.flatMap((g) => g.items);
    assert.equal(new Set(all).size, all.length);
    assert.ok(all.includes('création site web prix'));
    assert.ok(all.includes('création site web à rabat'));
    assert.ok(all.includes('comment choisir création site web'));
    assert.equal(a.total, all.length);
    assert.deepEqual(keywords.generate(['seo'], 'en', ['local'], ['Casablanca']).groups[0].items, ['seo near me', 'seo nearby', 'seo casablanca', 'seo in casablanca']);
    assert.deepEqual(keywords.splitList('a, b\nb\n\n c', 5), ['a', 'b', 'c']);
});
