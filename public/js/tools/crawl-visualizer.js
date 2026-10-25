/**
 * Visualiseur d'exploration — /tools/crawl-visualizer
 *
 * Le navigateur pilote l'exploration : file d'attente en largeur (BFS),
 * profondeur et nombre de pages limités, lots de 4 URL envoyés à
 * POST /api/crawl-visualizer. Le serveur inspecte chaque URL (robots.txt,
 * statut, indexabilité, liens internes) sans jamais quitter le domaine.
 *
 * Le graphe est un placement par forces dessiné sur <canvas>, sans
 * bibliothèque : arbre de découverte (chaque page reliée à celle qui l'a fait
 * découvrir), racine fixée au centre, pages orphelines rangées à part.
 */
(function () {
    'use strict';

    var ENDPOINT = '/api/crawl-visualizer';
    var SLUG = 'crawl-visualizer';
    var BATCH_SIZE = 4;          // = CrawlVisualizerController::MAX_URLS_PER_REQUEST
    var CONCURRENCY = 2;
    var REQUEST_TIMEOUT_MS = 45000;
    var MAX_TABLE_ROWS = 1000;

    var COLORS = {
        root: '#15803d',
        indexable: ['#22c55e', '#4ade80', '#86efac', '#a7f3d0'],
        nonindexable: '#ef4444',
        error: '#b91c1c',
        redirect: '#f97316',
        blocked: '#9ca3af',
        collapsed: '#eab308',
        pending: '#e5e7eb',
        orphanStroke: '#8b5cf6',
        accent: '#00AEEF',
        edge: 'rgba(107, 114, 128, 0.45)',
        edgeFaint: 'rgba(148, 163, 184, 0.22)',
        label: '#111827'
    };

    var KIND_LABELS = {
        indexable: 'Indexable',
        nonindexable: 'Non indexable',
        redirect: 'Redirection',
        error: 'Erreur',
        blocked: 'Bloquée (robots.txt)',
        orphan: 'Orpheline',
        pending: 'En attente'
    };

    function onReady(fn) {
        if (window.CodeSommetTools && window.CodeSommetTools.onReady) {
            window.CodeSommetTools.onReady(fn);
        } else if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', fn);
        } else {
            fn();
        }
    }

    function $(id) { return document.getElementById(id); }

    function escapeHtml(str) {
        return String(str == null ? '' : str)
            .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;').replace(/'/g, '&#39;');
    }

    function fmt(n) { return Number(n || 0).toLocaleString('fr-FR'); }

    /* ── URL helpers ──────────────────────────────────────────────────── */

    function normalizeInput(raw) {
        var value = String(raw || '').trim();
        if (!value) return { error: 'Saisissez l\'URL de votre site.' };
        if (!/^https?:\/\//i.test(value)) value = 'https://' + value;
        var url;
        try { url = new URL(value); } catch (e) { return { error: 'Cette adresse n\'est pas une URL valide.' }; }
        if (!/^https?:$/.test(url.protocol) || !url.hostname || url.hostname.indexOf('.') === -1) {
            return { error: 'Cette adresse n\'est pas une URL valide.' };
        }
        if (url.username || url.password) return { error: 'Les URL contenant des identifiants ne sont pas acceptées.' };
        url.hash = '';
        return { url: url.toString() };
    }

    function hostOf(url) {
        try { return new URL(url).host.toLowerCase(); } catch (e) { return ''; }
    }

    function labelFor(node) {
        if (node.depth === 0) return hostOf(node.url).replace(/^www\./, '');
        var u;
        try { u = new URL(node.url); } catch (e) { return node.url; }
        var parts = u.pathname.split('/').filter(Boolean);
        var text = parts.length ? parts[parts.length - 1] : '/';
        try { text = decodeURIComponent(text); } catch (e) { /* garde la forme encodée */ }
        if (u.search) text += '?…';
        return text.length > 26 ? text.slice(0, 25) + '…' : text;
    }

    /* ── State ────────────────────────────────────────────────────────── */

    var state;

    function freshState(root, settings) {
        return {
            root: root,
            host: hostOf(root),
            settings: settings,
            nodes: [],
            byUrl: new Map(),
            edges: [],
            edgeKeys: new Set(),
            queue: [],
            inflight: 0,
            running: false,
            stopped: false,
            truncated: false,
            finished: false,
            pausedUntil: 0,
            orphans: [],
            sitemapChecked: false,
            startedAt: new Date()
        };
    }

    function crawledNodes() {
        return state ? state.nodes.filter(function (n) { return !n.orphan; }) : [];
    }

    function addNode(url, depth, parent) {
        var node = {
            id: state.nodes.length,
            url: url,
            depth: depth,
            parent: parent || null,
            children: [],
            kind: 'pending',
            crawled: false,
            status: 0,
            reason: null,
            title: '',
            h1: '',
            canonical: null,
            metaRobots: '',
            followLinks: true,
            timeMs: 0,
            bytes: 0,
            inCount: 0,
            outCount: 0,
            externalLinks: 0,
            nofollowLinks: 0,
            redirectTo: null,
            retries: 0,
            collapsed: false,
            orphan: false,
            x: 0, y: 0, vx: 0, vy: 0, fixed: false
        };
        node.label = labelFor(node);
        if (parent) {
            parent.children.push(node);
            var angle = Math.random() * Math.PI * 2;
            var dist = depth === 1 ? 140 : 40;
            node.x = parent.x + Math.cos(angle) * dist;
            node.y = parent.y + Math.sin(angle) * dist;
        }
        state.nodes.push(node);
        state.byUrl.set(url, node);
        return node;
    }

    function addEdge(source, target) {
        if (source === target) return;
        var key = source.id + '>' + target.id;
        if (state.edgeKeys.has(key)) return;
        state.edgeKeys.add(key);
        state.edges.push({ s: source, t: target });
        target.inCount++;
    }

    function kindOf(page) {
        if (page.blockedByRobots) return 'blocked';
        if (!page.status) return 'error';
        if (page.status >= 300 && page.status < 400) return 'redirect';
        if (page.status >= 400) return 'error';
        return page.indexable ? 'indexable' : 'nonindexable';
    }

    /* ── Crawl ────────────────────────────────────────────────────────── */

    var ui = {};

    function startCrawl(rootUrl, settings, restarts) {
        state = freshState(rootUrl, settings);
        state.restarts = restarts || 0;
        state.running = true;
        selected = null;
        searchMatches = new Set();
        hideDetails();

        var root = addNode(rootUrl, 0, null);
        root.fixed = true;
        state.queue.push(root);

        ui.results.classList.remove('hidden');
        ui.progress.classList.remove('hidden');
        ui.stop.classList.remove('hidden');
        ui.url.disabled = true;
        setLoading(true);
        hideError();

        view.scale = 1;
        resizeCanvas();
        view.tx = canvasSize.w / 2;
        view.ty = canvasSize.h / 2;

        updateVisibility();
        reheat(1);
        updateProgress();
        pump();
    }

    function pump() {
        if (!state) return;
        if (!state.running) {
            maybeFinish();
            return;
        }
        var now = Date.now();
        if (state.pausedUntil > now) {
            setTimeout(pump, state.pausedUntil - now + 50);
            updateProgress();
            return;
        }
        while (state.running && state.inflight < CONCURRENCY && state.queue.length) {
            var batch = state.queue.splice(0, BATCH_SIZE);
            state.inflight++;
            runBatch(state, batch);
        }
        maybeFinish();
    }

    function runBatch(crawl, batch) {
        var controller = typeof AbortController !== 'undefined' ? new AbortController() : null;
        var timer = controller ? setTimeout(function () { controller.abort(); }, REQUEST_TIMEOUT_MS) : null;
        ui.progressUrl.textContent = batch[0].url;

        fetch(ENDPOINT, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({ action: 'pages', root: crawl.root, urls: batch.map(function (n) { return n.url; }) }),
            signal: controller ? controller.signal : undefined
        })
            .then(function (res) {
                return res.json().catch(function () { return {}; }).then(function (data) {
                    return { res: res, data: data };
                });
            })
            .then(function (r) {
                if (crawl !== state) return; // exploration remplacée entre-temps
                if (r.res.status === 429) {
                    var wait = parseInt(r.res.headers.get('Retry-After') || '15', 10);
                    crawl.pausedUntil = Date.now() + Math.max(5, Math.min(wait, 60)) * 1000;
                    crawl.queue = batch.concat(crawl.queue);
                    return;
                }
                if (!r.res.ok) {
                    failBatch(crawl, batch, (r.data && r.data.error) || 'Erreur serveur (' + r.res.status + ')');
                    return;
                }
                var pages = Array.isArray(r.data.pages) ? r.data.pages : [];
                pages.forEach(function (page) { applyPage(crawl, page); });
                var deferred = Array.isArray(r.data.deferred) ? r.data.deferred : [];
                var requeue = batch.filter(function (n) { return deferred.indexOf(n.url) !== -1; });
                if (requeue.length) crawl.queue = requeue.concat(crawl.queue);
            })
            .catch(function (err) {
                if (crawl !== state) return;
                failBatch(crawl, batch, err && err.name === 'AbortError' ? 'Délai dépassé' : 'Connexion interrompue');
            })
            .then(function () {
                if (timer) clearTimeout(timer);
                if (crawl !== state) return;
                crawl.inflight--;
                updateVisibility();
                reheat(0.5);
                updateProgress();
                updateStats();
                pump();
            });
    }

    function failBatch(crawl, batch, message) {
        var isRoot = batch.some(function (n) { return n.depth === 0; });
        if (isRoot) {
            showError(message);
            crawl.running = false;
            crawl.queue = [];
            batch.forEach(function (n) { markFailed(n, message); });
            return;
        }
        batch.forEach(function (n) {
            if (n.retries < 1) {
                n.retries++;
                crawl.queue.push(n);
            } else {
                markFailed(n, message);
            }
        });
    }

    function markFailed(node, message) {
        node.crawled = true;
        node.kind = 'error';
        node.reason = message;
    }

    function applyPage(crawl, page) {
        var node = crawl.byUrl.get(page.url);
        if (!node || node.crawled) return;

        node.crawled = true;
        node.status = page.status || 0;
        node.kind = kindOf(page);
        node.reason = page.reason || page.error || null;
        node.title = page.title || '';
        node.h1 = page.h1 || '';
        node.canonical = page.canonical || null;
        node.metaRobots = page.metaRobots || '';
        node.followLinks = page.followLinks !== false;
        node.timeMs = page.timeMs || 0;
        node.bytes = page.bytes || 0;
        node.redirectTo = page.redirectTo || null;
        node.externalLinks = page.externalLinks || 0;
        node.nofollowLinks = page.nofollowLinks || 0;

        var links = Array.isArray(page.links) ? page.links : [];
        node.outCount = links.length;

        // Racine redirigée vers un autre hôte (http → https, ajout du www…) :
        // on recommence depuis la destination plutôt que d'explorer une page vide.
        if (node.depth === 0 && node.kind === 'redirect' && node.redirectTo && hostOf(node.redirectTo) !== crawl.host) {
            if ((crawl.restarts || 0) < 3) {
                crawl.running = false;
                crawl.restarting = true;
                ui.url.value = node.redirectTo;
                startCrawl(node.redirectTo, crawl.settings, (crawl.restarts || 0) + 1);
            } else {
                showError('Trop de redirections depuis l\'URL de départ.');
                crawl.running = false;
            }
            return;
        }

        if (node.depth === 0 && node.kind === 'blocked') {
            showError('Le fichier robots.txt de ce site interdit l\'exploration de la page de départ.');
        } else if (node.depth === 0 && node.kind === 'error') {
            showError('Impossible de charger la page de départ : ' + (node.reason || 'erreur inconnue') + '.');
        }

        if (!node.followLinks) return;

        links.forEach(function (url) {
            if (hostOf(url) !== crawl.host) return;
            var target = crawl.byUrl.get(url);
            if (!target) {
                if (node.depth + 1 > crawl.settings.maxDepth) return;
                if (crawl.nodes.length >= crawl.settings.maxPages) {
                    crawl.truncated = true;
                    return;
                }
                target = addNode(url, node.depth + 1, node);
                crawl.queue.push(target);
            }
            addEdge(node, target);
        });
    }

    function maybeFinish() {
        if (!state || state.finished || state.restarting) return;
        // Terminé quand plus rien n'est en vol et que la file est vide (ou
        // l'exploration interrompue) ; une pause anti-surcharge n'est pas une fin.
        if (state.inflight > 0) return;
        if (state.running && state.queue.length) return;

        state.running = false;
        state.finished = true;

        var crawl = state;
        var root = crawl.nodes[0];
        var wantsSitemap = crawl.settings.sitemap && !crawl.stopped && root && root.crawled &&
            root.kind !== 'error' && root.kind !== 'blocked';
        if (!wantsSitemap) {
            finishUi();
            return;
        }

        ui.progressText.textContent = 'Lecture du sitemap pour repérer les pages orphelines…';
        ui.progressUrl.textContent = '';
        fetch(ENDPOINT, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({ action: 'sitemap', root: crawl.root })
        })
            .then(function (res) { return res.ok ? res.json() : null; })
            .then(function (data) {
                if (crawl !== state || !data || !Array.isArray(data.urls)) return;
                crawl.sitemapChecked = true;
                crawl.sitemapSources = data.sources || [];
                data.urls.forEach(function (url) {
                    if (crawl.byUrl.has(url) || hostOf(url) !== crawl.host) return;
                    var node = addNode(url, null, null);
                    node.orphan = true;
                    node.kind = 'orphan';
                    node.reason = crawl.truncated
                        ? 'Présente dans le sitemap, non atteinte (exploration partielle)'
                        : 'Présente dans le sitemap, aucun lien interne trouvé';
                    node.label = labelFor({ depth: 1, url: url });
                    crawl.orphans.push(node);
                });
            })
            .catch(function () { /* sitemap facultatif */ })
            .then(function () {
                if (crawl !== state) return;
                layoutOrphans();
                finishUi();
            });
    }

    function finishUi() {
        ui.stop.classList.add('hidden');
        ui.url.disabled = false;
        setLoading(false);
        updateVisibility();
        updateProgress();
        updateStats();
        renderTable();
        reheat(0.6);
        setTimeout(fitView, 400);
        if (window.CodeSommetTools && state.nodes.length && state.nodes[0].crawled) {
            window.CodeSommetTools.incrementUsage(SLUG, state.root);
        }
    }

    function stopCrawl() {
        if (!state || !state.running) return;
        state.stopped = true;
        state.truncated = true;
        state.running = false;
        state.queue = [];
        updateProgress();
        maybeFinish();
    }

    /* ── Progress & stats ─────────────────────────────────────────────── */

    function updateProgress() {
        if (!state) return;
        var crawled = crawledNodes().filter(function (n) { return n.crawled; }).length;
        var discovered = crawledNodes().length;
        var max = state.settings.maxPages;
        var pct = state.finished ? 100 : Math.min(100, Math.round((crawled / Math.max(1, Math.min(max, discovered))) * 100));
        ui.progressBar.style.width = pct + '%';

        var text;
        if (state.finished) {
            text = 'Exploration terminée : ' + fmt(crawled) + ' page' + (crawled > 1 ? 's' : '') + ' analysée' + (crawled > 1 ? 's' : '');
            if (state.stopped) text += ' (arrêtée)';
            else if (state.truncated) text += ' (limite de ' + fmt(max) + ' pages atteinte)';
            ui.progressUrl.textContent = '';
        } else if (state.pausedUntil > Date.now()) {
            text = 'Limite de requêtes atteinte, reprise dans ' + Math.ceil((state.pausedUntil - Date.now()) / 1000) + ' s…';
        } else {
            text = fmt(crawled) + ' / ' + fmt(discovered) + ' pages · ' + fmt(state.queue.length) + ' en attente';
        }
        ui.progressText.textContent = text;
    }

    function computeStats() {
        var pages = crawledNodes().filter(function (n) { return n.crawled; });
        var maxDepth = 0;
        var nonIndexable = 0;
        var errors = 0;
        pages.forEach(function (n) {
            if (n.depth > maxDepth) maxDepth = n.depth;
            if (n.kind !== 'indexable') nonIndexable++;
            if (n.kind === 'error') errors++;
        });
        return {
            pages: pages.length,
            edges: state.edges.length,
            orphans: state.orphans.length,
            depth: maxDepth,
            nonindexable: nonIndexable,
            errors: errors
        };
    }

    function updateStats() {
        if (!state) return;
        var s = computeStats();
        Object.keys(s).forEach(function (key) {
            var el = $('cv-stat-' + key);
            if (el) el.textContent = fmt(s[key]);
        });
        // Exploration partielle : une URL du sitemap non atteinte est peut-être
        // liée depuis une page qu'on n'a pas explorée.
        var label = $('cv-stat-orphans-label');
        if (label) label.textContent = state.truncated && s.orphans ? 'Orphelines (candidates)' : label.dataset.default;
    }

    /* ── Visibility (limit, collapse) ─────────────────────────────────── */

    var visible = [];
    var visibleSet = new Set();

    function updateVisibility() {
        visible = [];
        visibleSet = new Set();
        if (!state || !state.nodes.length) return;

        var limit = parseInt(ui.limit.value, 10) || Infinity;
        var stack = [state.nodes[0]];
        var tree = [];
        // Parcours en largeur pour respecter l'ordre de découverte.
        while (stack.length) {
            var n = stack.shift();
            tree.push(n);
            if (!n.collapsed) n.children.forEach(function (c) { stack.push(c); });
        }
        tree = tree.slice(0, limit);
        var orphans = state.orphans.slice(0, Math.max(0, limit - tree.length));
        visible = tree.concat(orphans);
        visible.forEach(function (n) { visibleSet.add(n); });
    }

    function hiddenDescendants(node) {
        var count = 0;
        var stack = node.children.slice();
        while (stack.length) {
            var n = stack.pop();
            count++;
            n.children.forEach(function (c) { stack.push(c); });
        }
        return count;
    }

    /* ── Force simulation ─────────────────────────────────────────────── */

    var alpha = 0;
    var reducedMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    function radiusOf(n) {
        if (n.orphan) return 7;
        if (n.depth === 0) return 28;
        var base = Math.max(5, 17 - 4 * (n.depth - 1));
        return base + Math.min(9, 1.6 * Math.sqrt(n.inCount));
    }

    function tick() {
        var nodes = visible.filter(function (n) { return !n.orphan; });
        var count = nodes.length;
        var i, j, a, b, dx, dy, d2, d, f;

        // Ressorts de l'arbre de découverte.
        for (i = 0; i < count; i++) {
            b = nodes[i];
            a = b.parent;
            if (!a || !visibleSet.has(a)) continue;
            dx = b.x - a.x; dy = b.y - a.y;
            d = Math.sqrt(dx * dx + dy * dy) || 0.01;
            var length = (a.depth === 0 ? 150 : 55) + 5 * Math.sqrt(a.children.length) + radiusOf(b);
            f = (d - length) / d * 0.08 * alpha;
            dx *= f; dy *= f;
            b.vx -= dx; b.vy -= dy;
            if (!a.fixed) { a.vx += dx * 0.5; a.vy += dy * 0.5; }
        }

        // Répulsion + collision (n² : au plus quelques centaines de nœuds).
        for (i = 0; i < count; i++) {
            a = nodes[i];
            var ra = radiusOf(a);
            for (j = i + 1; j < count; j++) {
                b = nodes[j];
                dx = b.x - a.x; dy = b.y - a.y;
                d2 = dx * dx + dy * dy;
                if (d2 < 0.01) { dx = Math.random() - 0.5; dy = Math.random() - 0.5; d2 = dx * dx + dy * dy; }
                if (d2 > 250000) continue;
                d = Math.sqrt(d2);
                f = 900 * alpha / d2;
                var minDist = ra + radiusOf(b) + 6;
                if (d < minDist) f += (minDist - d) / d * 0.5;
                dx *= f; dy *= f;
                if (!a.fixed) { a.vx -= dx; a.vy -= dy; }
                if (!b.fixed) { b.vx += dx; b.vy += dy; }
            }
        }

        for (i = 0; i < count; i++) {
            a = nodes[i];
            if (a.fixed) { a.vx = a.vy = 0; continue; }
            a.vx -= a.x * 0.002 * alpha;
            a.vy -= a.y * 0.002 * alpha;
            a.vx *= 0.6; a.vy *= 0.6;
            a.x += a.vx; a.y += a.vy;
        }

        alpha *= 0.985;
        if (alpha < 0.004) alpha = 0;
    }

    function reheat(value) {
        alpha = Math.max(alpha, value);
        if (reducedMotion) {
            for (var k = 0; k < 300 && alpha > 0; k++) tick();
            alpha = 0;
        }
        requestDraw();
    }

    /** Pages orphelines : grille compacte à droite du graphe. */
    function layoutOrphans() {
        if (!state.orphans.length) return;
        var maxX = 0;
        var minY = 0;
        crawledNodes().forEach(function (n) {
            maxX = Math.max(maxX, n.x + radiusOf(n));
            minY = Math.min(minY, n.y);
        });
        var cols = Math.max(4, Math.ceil(Math.sqrt(state.orphans.length)));
        state.orphans.forEach(function (n, i) {
            n.x = maxX + 140 + (i % cols) * 44;
            n.y = minY + Math.floor(i / cols) * 44;
            n.fixed = true;
        });
    }

    /* ── Rendering ────────────────────────────────────────────────────── */

    var canvas, ctx;
    var dpr = 1;
    var canvasSize = { w: 0, h: 0 };
    var view = { scale: 1, tx: 0, ty: 0 };
    var toggles = { labels: true, arrows: false, 'all-links': false };
    var selected = null;
    var hovered = null;
    var searchMatches = new Set();
    var rafId = null;
    var dirty = false;

    function resizeCanvas() {
        var rect = ui.stage.getBoundingClientRect();
        dpr = window.devicePixelRatio || 1;
        canvasSize.w = Math.max(1, rect.width);
        canvasSize.h = Math.max(1, rect.height);
        canvas.width = Math.round(canvasSize.w * dpr);
        canvas.height = Math.round(canvasSize.h * dpr);
        requestDraw();
    }

    function requestDraw() {
        dirty = true;
        if (rafId === null) rafId = requestAnimationFrame(frame);
    }

    function frame() {
        rafId = null;
        if (alpha > 0) tick();
        draw();
        dirty = false;
        if (alpha > 0) rafId = requestAnimationFrame(frame);
    }

    function matchesFilter(n) {
        switch (ui.filter.value) {
            case 'indexable': return n.kind === 'indexable';
            case 'nonindexable': return n.crawled && n.kind !== 'indexable';
            case 'redirect': return n.kind === 'redirect';
            case 'error': return n.kind === 'error';
            case 'orphan': return n.orphan;
            default: return true;
        }
    }

    function fillFor(n) {
        if (n.collapsed && n.children.length) return COLORS.collapsed;
        if (n.orphan) return '#ffffff';
        if (n.depth === 0 && n.kind === 'indexable') return COLORS.root;
        switch (n.kind) {
            case 'indexable': return COLORS.indexable[Math.min(COLORS.indexable.length - 1, Math.max(0, n.depth - 1))];
            case 'nonindexable': return COLORS.nonindexable;
            case 'error': return COLORS.error;
            case 'redirect': return COLORS.redirect;
            case 'blocked': return COLORS.blocked;
            default: return COLORS.pending;
        }
    }

    function draw() {
        if (!ctx) return;
        ctx.setTransform(1, 0, 0, 1, 0, 0);
        ctx.fillStyle = '#ffffff';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        if (!state) return;

        var s = view.scale;
        ctx.setTransform(dpr * s, 0, 0, dpr * s, dpr * view.tx, dpr * view.ty);

        var filterOn = ui.filter.value !== 'all';
        var searchOn = searchMatches.size > 0;
        function dim(n) {
            return (filterOn && !matchesFilter(n)) || (searchOn && !searchMatches.has(n));
        }

        // Arêtes : tous les liens (option), puis l'arbre de découverte.
        if (toggles['all-links']) {
            ctx.lineWidth = 0.7 / s;
            ctx.strokeStyle = COLORS.edgeFaint;
            ctx.beginPath();
            state.edges.forEach(function (e) {
                if (!visibleSet.has(e.s) || !visibleSet.has(e.t)) return;
                ctx.moveTo(e.s.x, e.s.y);
                ctx.lineTo(e.t.x, e.t.y);
            });
            ctx.stroke();
        }

        ctx.lineWidth = 1 / s;
        visible.forEach(function (n) {
            if (!n.parent || !visibleSet.has(n.parent)) return;
            ctx.strokeStyle = COLORS.edge;
            ctx.globalAlpha = dim(n) || dim(n.parent) ? 0.15 : 1;
            ctx.beginPath();
            ctx.moveTo(n.parent.x, n.parent.y);
            ctx.lineTo(n.x, n.y);
            ctx.stroke();
            if (toggles.arrows) drawArrow(n.parent, n, s);
        });
        ctx.globalAlpha = 1;

        // Nœuds.
        visible.forEach(function (n) {
            var r = radiusOf(n);
            ctx.globalAlpha = dim(n) ? 0.15 : 1;
            ctx.beginPath();
            ctx.arc(n.x, n.y, r, 0, Math.PI * 2);
            ctx.fillStyle = fillFor(n);
            ctx.fill();
            if (n.orphan) {
                ctx.lineWidth = 2.5 / s;
                ctx.strokeStyle = COLORS.orphanStroke;
                ctx.stroke();
            } else if (n.kind === 'pending') {
                ctx.lineWidth = 1 / s;
                ctx.strokeStyle = '#d1d5db';
                ctx.stroke();
            }
            if (n === selected || n === hovered || (searchOn && searchMatches.has(n))) {
                ctx.beginPath();
                ctx.arc(n.x, n.y, r + 4 / s, 0, Math.PI * 2);
                ctx.lineWidth = (n === selected ? 3 : 2) / s;
                ctx.strokeStyle = COLORS.accent;
                ctx.stroke();
            }
            if (n.collapsed && n.children.length) {
                ctx.fillStyle = '#111827';
                ctx.font = '600 ' + Math.max(9, r * 0.7) + 'px Inter, sans-serif';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.fillText('+' + hiddenDescendants(n), n.x, n.y);
            }
        });
        ctx.globalAlpha = 1;

        if (toggles.labels) drawLabels(s, dim);
    }

    function drawArrow(from, to, s) {
        var r = radiusOf(to);
        var dx = to.x - from.x;
        var dy = to.y - from.y;
        var d = Math.sqrt(dx * dx + dy * dy) || 1;
        var ux = dx / d;
        var uy = dy / d;
        var tipX = to.x - ux * (r + 1 / s);
        var tipY = to.y - uy * (r + 1 / s);
        var size = 7 / s;
        ctx.fillStyle = COLORS.edge;
        ctx.beginPath();
        ctx.moveTo(tipX, tipY);
        ctx.lineTo(tipX - ux * size - uy * size * 0.5, tipY - uy * size + ux * size * 0.5);
        ctx.lineTo(tipX - ux * size + uy * size * 0.5, tipY - uy * size - ux * size * 0.5);
        ctx.closePath();
        ctx.fill();
    }

    function drawLabels(s, dim) {
        var crowded = visible.length > 250 && s < 0.7;
        ctx.font = (11 / s) + 'px Inter, sans-serif';
        ctx.textAlign = 'center';
        ctx.textBaseline = 'top';
        ctx.lineJoin = 'round';
        visible.forEach(function (n) {
            var r = radiusOf(n);
            var important = n === selected || n === hovered || n.depth === 0 || searchMatches.has(n);
            if (!important) {
                if (dim(n)) return;
                if (crowded && n.depth > 1) return;
                if (r * s < 4) return;
            }
            var y = n.y + r + 3 / s;
            ctx.lineWidth = 3 / s;
            ctx.strokeStyle = 'rgba(255,255,255,0.9)';
            ctx.strokeText(n.label, n.x, y);
            ctx.fillStyle = COLORS.label;
            ctx.fillText(n.label, n.x, y);
        });
    }

    /* ── View helpers ─────────────────────────────────────────────────── */

    function toWorld(px, py) {
        return { x: (px - view.tx) / view.scale, y: (py - view.ty) / view.scale };
    }

    function zoomAt(factor, px, py) {
        var next = Math.max(0.05, Math.min(6, view.scale * factor));
        factor = next / view.scale;
        view.tx = px - (px - view.tx) * factor;
        view.ty = py - (py - view.ty) * factor;
        view.scale = next;
        requestDraw();
    }

    function fitView() {
        if (!visible.length) return;
        var minX = Infinity, minY = Infinity, maxX = -Infinity, maxY = -Infinity;
        visible.forEach(function (n) {
            var r = radiusOf(n) + 18;
            minX = Math.min(minX, n.x - r); maxX = Math.max(maxX, n.x + r);
            minY = Math.min(minY, n.y - r); maxY = Math.max(maxY, n.y + r);
        });
        var w = Math.max(1, maxX - minX);
        var h = Math.max(1, maxY - minY);
        view.scale = Math.max(0.05, Math.min(2, Math.min(canvasSize.w / w, canvasSize.h / h) * 0.92));
        view.tx = canvasSize.w / 2 - (minX + w / 2) * view.scale;
        view.ty = canvasSize.h / 2 - (minY + h / 2) * view.scale;
        requestDraw();
    }

    function centerOn(node) {
        if (view.scale < 0.6) view.scale = 0.9;
        view.tx = canvasSize.w / 2 - node.x * view.scale;
        view.ty = canvasSize.h / 2 - node.y * view.scale;
        requestDraw();
    }

    function hitTest(px, py) {
        var p = toWorld(px, py);
        var best = null;
        var bestDist = Infinity;
        for (var i = visible.length - 1; i >= 0; i--) {
            var n = visible[i];
            var dx = n.x - p.x;
            var dy = n.y - p.y;
            var d = Math.sqrt(dx * dx + dy * dy);
            var r = radiusOf(n) + 4 / view.scale;
            if (d <= r && d < bestDist) { best = n; bestDist = d; }
        }
        return best;
    }

    function revealNode(node) {
        var changed = false;
        for (var p = node.parent; p; p = p.parent) {
            if (p.collapsed) { p.collapsed = false; changed = true; }
        }
        if (changed || !visibleSet.has(node)) {
            if (!visibleSet.has(node)) ui.limit.value = '0';
            updateVisibility();
            reheat(0.3);
        }
    }

    function toggleCollapse(node) {
        if (!node || !node.children.length) return;
        node.collapsed = !node.collapsed;
        updateVisibility();
        reheat(0.4);
        if (selected === node) showDetails(node);
    }

    /* ── Pointer interactions ─────────────────────────────────────────── */

    function bindPointer() {
        var pointers = new Map();
        var drag = null;   // { node } | { pan: true }
        var downAt = null;
        var pinchDist = 0;

        function local(e) {
            var rect = canvas.getBoundingClientRect();
            return { x: e.clientX - rect.left, y: e.clientY - rect.top };
        }

        canvas.addEventListener('pointerdown', function (e) {
            if (!state) return;
            canvas.setPointerCapture(e.pointerId);
            var p = local(e);
            pointers.set(e.pointerId, p);
            if (pointers.size === 2) {
                var pts = Array.from(pointers.values());
                pinchDist = Math.hypot(pts[0].x - pts[1].x, pts[0].y - pts[1].y);
                drag = null;
                return;
            }
            downAt = { x: p.x, y: p.y, t: Date.now() };
            var node = hitTest(p.x, p.y);
            drag = node ? { node: node, wasFixed: node.fixed } : { pan: true, last: p };
            if (node) node.fixed = true;
            canvas.classList.add('is-dragging');
        });

        canvas.addEventListener('pointermove', function (e) {
            if (!state) return;
            var p = local(e);
            if (pointers.has(e.pointerId)) pointers.set(e.pointerId, p);

            if (pointers.size === 2) {
                var pts = Array.from(pointers.values());
                var dist = Math.hypot(pts[0].x - pts[1].x, pts[0].y - pts[1].y);
                if (pinchDist > 0) {
                    zoomAt(dist / pinchDist, (pts[0].x + pts[1].x) / 2, (pts[0].y + pts[1].y) / 2);
                }
                pinchDist = dist;
                return;
            }

            if (drag && drag.node) {
                var w = toWorld(p.x, p.y);
                drag.node.x = w.x;
                drag.node.y = w.y;
                drag.node.vx = drag.node.vy = 0;
                reheat(0.25);
            } else if (drag && drag.pan) {
                view.tx += p.x - drag.last.x;
                view.ty += p.y - drag.last.y;
                drag.last = p;
                requestDraw();
            } else {
                var over = hitTest(p.x, p.y);
                if (over !== hovered) {
                    hovered = over;
                    canvas.classList.toggle('is-hover', !!over);
                    canvas.title = over ? over.url : '';
                    requestDraw();
                }
            }
        });

        function release(e) {
            pointers.delete(e.pointerId);
            if (pointers.size < 2) pinchDist = 0;
            if (!drag) return;
            var p = local(e);
            var moved = downAt ? Math.hypot(p.x - downAt.x, p.y - downAt.y) : 99;
            if (drag.node) {
                // Le nœud déplacé reste où on l'a posé ; la racine reste fixe.
                drag.node.fixed = drag.wasFixed || moved > 4;
                if (moved <= 4) {
                    selected = drag.node;
                    showDetails(drag.node);
                }
            } else if (drag.pan && moved <= 4) {
                selected = null;
                hideDetails();
            }
            drag = null;
            canvas.classList.remove('is-dragging');
            requestDraw();
        }
        canvas.addEventListener('pointerup', release);
        canvas.addEventListener('pointercancel', release);
        canvas.addEventListener('pointerleave', function () {
            if (hovered) { hovered = null; canvas.classList.remove('is-hover'); requestDraw(); }
        });

        canvas.addEventListener('dblclick', function (e) {
            var p = local(e);
            toggleCollapse(hitTest(p.x, p.y));
        });

        canvas.addEventListener('wheel', function (e) {
            if (!state) return;
            e.preventDefault();
            var p = local(e);
            zoomAt(Math.exp(-e.deltaY * 0.0015), p.x, p.y);
        }, { passive: false });
    }

    /* ── Details panel ────────────────────────────────────────────────── */

    function badgeFor(n) {
        var cls = n.kind === 'indexable' ? 'cv-badge--ok'
            : n.kind === 'redirect' ? 'cv-badge--warn'
                : n.kind === 'orphan' ? 'cv-badge--orphan'
                    : n.kind === 'blocked' || n.kind === 'pending' ? 'cv-badge--muted'
                        : 'cv-badge--bad';
        return '<span class="cv-badge ' + cls + '">' + escapeHtml(KIND_LABELS[n.kind] || n.kind) + '</span>';
    }

    function row(label, value) {
        if (value === null || value === undefined || value === '') return '';
        return '<div class="flex justify-between gap-3 py-1.5 border-b border-gray-100 last:border-0">' +
            '<dt class="text-gray-500 flex-shrink-0">' + escapeHtml(label) + '</dt>' +
            '<dd class="text-gray-900 text-right break-all">' + value + '</dd></div>';
    }

    function showDetails(n) {
        var html = '<div class="flex items-start justify-between gap-2 mb-2">' +
            '<div class="min-w-0"><p class="font-semibold text-gray-900 break-words">' + escapeHtml(n.title || n.label) + '</p>' +
            '<a href="' + escapeHtml(n.url) + '" target="_blank" rel="noopener noreferrer nofollow" class="text-xs text-[#00AEEF] hover:underline break-all">' + escapeHtml(n.url) + '</a></div>' +
            '<button type="button" data-cv-close class="flex-shrink-0 w-7 h-7 rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100" aria-label="Fermer">✕</button></div>' +
            '<div class="mb-2">' + badgeFor(n) + '</div><dl class="text-xs">' +
            row('Raison', n.reason ? escapeHtml(n.reason) : '') +
            row('Statut HTTP', n.status ? String(n.status) : (n.crawled ? '—' : '')) +
            row('Profondeur', n.depth === null ? '' : n.depth + ' clic' + (n.depth > 1 ? 's' : '')) +
            row('Liens entrants', n.orphan ? '0' : fmt(n.inCount)) +
            row('Liens sortants internes', n.crawled ? fmt(n.outCount) : '') +
            row('Liens externes', n.crawled && n.externalLinks ? fmt(n.externalLinks) : '') +
            row('Liens nofollow', n.nofollowLinks ? fmt(n.nofollowLinks) : '') +
            row('Redirige vers', n.redirectTo ? escapeHtml(n.redirectTo) : '') +
            row('Canonique', n.canonical ? escapeHtml(n.canonical) : '') +
            row('Meta robots', n.metaRobots ? escapeHtml(n.metaRobots) : '') +
            row('H1', n.h1 ? escapeHtml(n.h1) : '') +
            row('Temps de réponse', n.timeMs ? fmt(n.timeMs) + ' ms' : '') +
            row('Taille HTML', n.bytes && window.CodeSommetTools ? window.CodeSommetTools.formatSize(n.bytes) : '') +
            row('Découverte depuis', n.parent ? '<button type="button" data-cv-goto="' + n.parent.id + '" class="text-[#00AEEF] hover:underline break-all text-right">' + escapeHtml(n.parent.label) + '</button>' : '') +
            '</dl><div class="flex flex-wrap gap-2 mt-3">' +
            '<button type="button" data-cv-center class="h-8 px-3 rounded-lg border border-gray-200 text-xs font-medium hover:border-[#00AEEF] hover:text-[#00AEEF]">Centrer</button>' +
            (n.children.length ? '<button type="button" data-cv-collapse class="h-8 px-3 rounded-lg border border-gray-200 text-xs font-medium hover:border-[#00AEEF] hover:text-[#00AEEF]">' + (n.collapsed ? 'Déplier la branche' : 'Replier la branche') + ' (' + hiddenDescendants(n) + ')</button>' : '') +
            '</div>';
        ui.details.innerHTML = html;
        ui.details.classList.remove('hidden');
        ui.details.querySelector('[data-cv-close]').addEventListener('click', function () { selected = null; hideDetails(); requestDraw(); });
        ui.details.querySelector('[data-cv-center]').addEventListener('click', function () { centerOn(n); });
        var collapseBtn = ui.details.querySelector('[data-cv-collapse]');
        if (collapseBtn) collapseBtn.addEventListener('click', function () { toggleCollapse(n); });
        var gotoBtn = ui.details.querySelector('[data-cv-goto]');
        if (gotoBtn) gotoBtn.addEventListener('click', function () { selectNode(n.parent); });
    }

    function hideDetails() {
        if (ui.details) { ui.details.classList.add('hidden'); ui.details.innerHTML = ''; }
    }

    function selectNode(node) {
        if (!node) return;
        revealNode(node);
        selected = node;
        showDetails(node);
        centerOn(node);
    }

    /* ── Table ────────────────────────────────────────────────────────── */

    function renderTable() {
        if (!state) return;
        var q = ui.tableFilter.value.trim().toLowerCase();
        var rows = state.nodes
            .filter(function (n) { return (n.crawled || n.orphan) && (!q || n.url.toLowerCase().indexOf(q) !== -1 || (n.title || '').toLowerCase().indexOf(q) !== -1); })
            .sort(function (a, b) {
                var da = a.depth === null ? 999 : a.depth;
                var db = b.depth === null ? 999 : b.depth;
                return da - db || (a.url < b.url ? -1 : 1);
            });
        var shown = rows.slice(0, MAX_TABLE_ROWS);
        var html = shown.map(function (n) {
            return '<tr class="hover:bg-gray-50 cursor-pointer" data-cv-row="' + n.id + '">' +
                '<td class="px-4 py-2.5"><div class="cv-url-cell text-gray-900" title="' + escapeHtml(n.url) + '">' + escapeHtml(n.url) + '</div>' +
                (n.title ? '<div class="cv-url-cell text-xs text-gray-500">' + escapeHtml(n.title) + '</div>' : '') + '</td>' +
                '<td class="px-4 py-2.5 text-gray-700">' + (n.status || '—') + '</td>' +
                '<td class="px-4 py-2.5 text-gray-700">' + (n.depth === null ? '—' : n.depth) + '</td>' +
                '<td class="px-4 py-2.5 text-gray-700">' + fmt(n.inCount) + '</td>' +
                '<td class="px-4 py-2.5 text-gray-700">' + (n.crawled ? fmt(n.outCount) : '—') + '</td>' +
                '<td class="px-4 py-2.5">' + badgeFor(n) + (n.reason && n.kind !== 'indexable' ? '<div class="text-xs text-gray-500 mt-1">' + escapeHtml(n.reason) + '</div>' : '') + '</td></tr>';
        }).join('');
        if (rows.length > shown.length) {
            html += '<tr><td colspan="6" class="px-4 py-3 text-xs text-gray-500">' + fmt(rows.length - shown.length) +
                ' lignes supplémentaires : téléchargez le CSV pour la liste complète.</td></tr>';
        }
        if (!rows.length) {
            html = '<tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">Aucune page ne correspond.</td></tr>';
        }
        ui.tableBody.innerHTML = html;
    }

    /* ── Exports ──────────────────────────────────────────────────────── */

    function exportRows() {
        return state.nodes.filter(function (n) { return n.crawled || n.orphan; }).map(function (n) {
            return {
                url: n.url,
                status: n.status || null,
                type: KIND_LABELS[n.kind] || n.kind,
                indexable: n.kind === 'indexable',
                reason: n.reason || '',
                depth: n.depth,
                inlinks: n.inCount,
                outlinks: n.crawled ? n.outCount : null,
                external_links: n.externalLinks,
                title: n.title,
                h1: n.h1,
                canonical: n.canonical || '',
                meta_robots: n.metaRobots,
                redirect_to: n.redirectTo || '',
                response_ms: n.timeMs || null,
                html_bytes: n.bytes || null,
                discovered_from: n.parent ? n.parent.url : ''
            };
        });
    }

    function csvCell(value) {
        var s = value === null || value === undefined ? '' : String(value);
        // Neutralise les formules (=, +, -, @) à l'ouverture dans un tableur.
        if (/^[=+\-@\t\r]/.test(s)) s = "'" + s;
        return /[",\n\r;]/.test(s) ? '"' + s.replace(/"/g, '""') + '"' : s;
    }

    function fileBase() {
        return 'exploration-' + state.host.replace(/[^a-z0-9.-]/gi, '_') + '-' + state.startedAt.toISOString().slice(0, 10);
    }

    function exportCsv() {
        var rows = exportRows();
        var headers = Object.keys(rows[0] || { url: '' });
        var lines = [headers.join(',')].concat(rows.map(function (r) {
            return headers.map(function (h) { return csvCell(r[h]); }).join(',');
        }));
        window.CodeSommetTools.downloadFile('﻿' + lines.join('\r\n'), fileBase() + '.csv', 'text/csv;charset=utf-8');
    }

    function exportJson() {
        var data = {
            tool: 'CodeSommet — Visualiseur d\'exploration',
            root: state.root,
            crawledAt: state.startedAt.toISOString(),
            settings: state.settings,
            truncated: state.truncated,
            sitemapChecked: state.sitemapChecked,
            stats: computeStats(),
            pages: exportRows(),
            links: state.edges.map(function (e) { return { from: e.s.url, to: e.t.url }; })
        };
        window.CodeSommetTools.downloadFile(JSON.stringify(data, null, 2), fileBase() + '.json', 'application/json');
    }

    function exportPng() {
        draw();
        canvas.toBlob(function (blob) {
            if (!blob) return;
            var url = URL.createObjectURL(blob);
            var a = document.createElement('a');
            a.href = url;
            a.download = fileBase() + '.png';
            a.click();
            setTimeout(function () { URL.revokeObjectURL(url); }, 1000);
        }, 'image/png');
    }

    function summaryText() {
        var s = computeStats();
        var lines = [
            'Exploration de ' + state.root + ' (' + state.startedAt.toLocaleDateString('fr-FR') + ')',
            '- Pages explorées : ' + s.pages + (state.truncated ? ' (exploration partielle)' : ''),
            '- Connexions internes uniques : ' + s.edges,
            '- Profondeur maximale : ' + s.depth + ' clic' + (s.depth > 1 ? 's' : ''),
            '- Pages non indexables : ' + s.nonindexable,
            '- Erreurs 4xx / 5xx : ' + s.errors,
            '- Pages orphelines : ' + (state.sitemapChecked ? s.orphans : 'non vérifié')
        ];
        var issues = state.nodes.filter(function (n) { return (n.crawled && n.kind !== 'indexable') || n.orphan; });
        if (issues.length) {
            lines.push('', 'Pages à vérifier :');
            issues.slice(0, 30).forEach(function (n) {
                lines.push('- ' + n.url + ' — ' + (n.reason || KIND_LABELS[n.kind]));
            });
            if (issues.length > 30) lines.push('… et ' + (issues.length - 30) + ' autres (voir l\'export CSV)');
        }
        return lines.join('\n');
    }

    /* ── Misc UI ──────────────────────────────────────────────────────── */

    function showError(message) {
        ui.error.textContent = message;
        ui.error.classList.remove('hidden');
    }

    function hideError() {
        ui.error.classList.add('hidden');
        ui.error.textContent = '';
    }

    var loadingOn = false;

    function setLoading(on) {
        // setLoading() mémorise le libellé courant : l'appeler deux fois
        // mémoriserait le spinner à la place du texte du bouton.
        if (on === loadingOn) return;
        loadingOn = on;
        if (window.CodeSommetTools && window.CodeSommetTools.setLoading) {
            window.CodeSommetTools.setLoading(on, 'tool-action-btn');
        } else {
            ui.button.disabled = on;
        }
    }

    function syncToggle(btn) {
        btn.setAttribute('aria-pressed', toggles[btn.dataset.cvToggle] ? 'true' : 'false');
    }

    function debounce(fn, ms) {
        var t;
        return function () {
            var args = arguments;
            clearTimeout(t);
            t = setTimeout(function () { fn.apply(null, args); }, ms);
        };
    }

    /* ── Init ─────────────────────────────────────────────────────────── */

    onReady(function () {
        canvas = $('cv-canvas');
        if (!canvas || !canvas.getContext) return;
        ctx = canvas.getContext('2d');

        ui = {
            form: $('cv-form'),
            url: $('cv-url'),
            maxPages: $('cv-max-pages'),
            maxDepth: $('cv-max-depth'),
            sitemap: $('cv-sitemap'),
            button: $('tool-action-btn'),
            stop: $('cv-stop'),
            error: $('tool-error'),
            progress: $('cv-progress'),
            progressBar: $('cv-progress-bar'),
            progressText: $('cv-progress-text'),
            progressUrl: $('cv-progress-url'),
            results: $('cv-results'),
            stage: $('cv-stage'),
            details: $('cv-details'),
            filter: $('cv-filter'),
            limit: $('cv-limit'),
            search: $('cv-search'),
            tableBody: $('cv-table-body'),
            tableFilter: $('cv-table-filter')
        };

        if (window.CodeSommetTools && window.CodeSommetTools.initUsageCounter) {
            window.CodeSommetTools.initUsageCounter(SLUG, 'explorations réalisées');
        }

        ui.form.addEventListener('submit', function (e) {
            e.preventDefault();
            if (state && state.running) return;
            var parsed = normalizeInput(ui.url.value);
            if (parsed.error) {
                showError(parsed.error);
                ui.url.focus();
                return;
            }
            ui.url.value = parsed.url;
            startCrawl(parsed.url, {
                maxPages: Math.min(500, Math.max(1, parseInt(ui.maxPages.value, 10) || 100)),
                maxDepth: Math.min(10, Math.max(1, parseInt(ui.maxDepth.value, 10) || 4)),
                sitemap: ui.sitemap.checked
            });
        });

        ui.stop.addEventListener('click', stopCrawl);

        document.querySelectorAll('[data-cv-action]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var action = btn.dataset.cvAction;
                if (action === 'zoom-in') zoomAt(1.3, canvasSize.w / 2, canvasSize.h / 2);
                else if (action === 'zoom-out') zoomAt(1 / 1.3, canvasSize.w / 2, canvasSize.h / 2);
                else if (action === 'fit') fitView();
                else if (action === 'fullscreen') {
                    if (document.fullscreenElement) document.exitFullscreen();
                    else if (ui.stage.requestFullscreen) ui.stage.requestFullscreen().catch(function () { /* refusé */ });
                }
            });
        });

        document.querySelectorAll('[data-cv-toggle]').forEach(function (btn) {
            syncToggle(btn);
            btn.addEventListener('click', function () {
                var key = btn.dataset.cvToggle;
                toggles[key] = !toggles[key];
                syncToggle(btn);
                requestDraw();
            });
        });

        ui.filter.addEventListener('change', requestDraw);
        ui.limit.addEventListener('change', function () {
            updateVisibility();
            reheat(0.3);
            setTimeout(fitView, 300);
        });

        ui.search.addEventListener('input', debounce(function () {
            searchMatches = new Set();
            var q = ui.search.value.trim().toLowerCase();
            if (state && q.length >= 2) {
                state.nodes.forEach(function (n) {
                    if (n.url.toLowerCase().indexOf(q) !== -1 || (n.title || '').toLowerCase().indexOf(q) !== -1) {
                        searchMatches.add(n);
                    }
                });
            }
            requestDraw();
        }, 200));
        ui.search.addEventListener('keydown', function (e) {
            if (e.key !== 'Enter') return;
            e.preventDefault();
            var first = searchMatches.values().next().value;
            if (first) selectNode(first);
        });

        ui.tableFilter.addEventListener('input', debounce(renderTable, 200));
        ui.tableBody.addEventListener('click', function (e) {
            var tr = e.target.closest('[data-cv-row]');
            if (!tr || !state) return;
            var node = state.nodes[parseInt(tr.dataset.cvRow, 10)];
            if (!node) return;
            selectNode(node);
            ui.stage.scrollIntoView({ behavior: 'smooth', block: 'center' });
        });

        document.querySelectorAll('[data-cv-export]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                if (!state || !state.nodes.length) return;
                var format = btn.dataset.cvExport;
                if (format === 'csv') exportCsv();
                else if (format === 'json') exportJson();
                else if (format === 'png') exportPng();
                else if (format === 'copy') window.CodeSommetTools.copyToClipboard(summaryText(), btn);
            });
        });

        bindPointer();
        if (window.ResizeObserver) {
            new ResizeObserver(resizeCanvas).observe(ui.stage);
        } else {
            window.addEventListener('resize', resizeCanvas);
        }
        document.addEventListener('fullscreenchange', function () { setTimeout(resizeCanvas, 50); });
        resizeCanvas();
    });
})();
