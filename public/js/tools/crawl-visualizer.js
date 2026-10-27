/**
 * Visualiseur d'exploration — /tools/crawl-visualizer
 *
 * Le navigateur pilote l'exploration : file d'attente en largeur (BFS),
 * profondeur et nombre de pages limités, lots de 4 URL envoyés à
 * POST /api/crawl-visualizer. Le serveur inspecte chaque URL (robots.txt,
 * statut, indexabilité, liens internes et leurs ancres) sans jamais quitter
 * le domaine.
 *
 * Sept vues, dessinées sur un même <canvas> sans bibliothèque :
 *   - deux graphes : arbre de découverte (chaque page reliée à celle qui l'a
 *     fait découvrir) et arbre des répertoires (segments d'URL) ;
 *   - trois dispositions pour chacun : arbre, forces 2D, forces 3D ;
 *   - un nuage des mots employés dans les ancres des liens internes.
 */
(function () {
    'use strict';

    var ENDPOINT = '/api/crawl-visualizer';
    var SLUG = 'crawl-visualizer';
    var BATCH_SIZE = 4;          // = CrawlVisualizerController::MAX_URLS_PER_REQUEST
    var CONCURRENCY = 2;
    var REQUEST_TIMEOUT_MS = 45000;
    var MAX_TABLE_ROWS = 1000;
    var MAX_CLOUD_WORDS = 150;
    var FOCAL = 900;             // distance focale de la projection 3D
    var STORAGE_KEY = 'cv-view';

    var VIEWS = {
        'crawl-tree': { graph: 'crawl', layout: 'tree' },
        'dir-tree': { graph: 'dir', layout: 'tree' },
        'crawl-force': { graph: 'crawl', layout: 'force' },
        'dir-force': { graph: 'dir', layout: 'force' },
        'crawl-3d': { graph: 'crawl', layout: '3d' },
        'dir-3d': { graph: 'dir', layout: '3d' },
        'anchor-cloud': { graph: null, layout: 'cloud' }
    };
    var DEFAULT_VIEW = 'crawl-force';

    var COLORS = {
        root: '#15803d',
        indexable: ['#22c55e', '#4ade80', '#86efac', '#a7f3d0'],
        nonindexable: '#ef4444',
        error: '#b91c1c',
        redirect: '#f97316',
        blocked: '#9ca3af',
        collapsed: '#eab308',
        pending: '#e5e7eb',
        folderFill: '#dbeafe',
        folderStroke: '#3b82f6',
        orphanStroke: '#8b5cf6',
        accent: '#00AEEF',
        edge: 'rgba(107, 114, 128, 0.45)',
        edgeFaint: 'rgba(148, 163, 184, 0.22)',
        label: '#111827'
    };

    var CLOUD_COLORS = ['#0089bd', '#00AEEF', '#15803d', '#0f766e', '#7c3aed', '#c2410c', '#1d4ed8', '#16a34a'];

    var KIND_LABELS = {
        indexable: 'Indexable',
        nonindexable: 'Non indexable',
        redirect: 'Redirection',
        error: 'Erreur',
        blocked: 'Bloquée (robots.txt)',
        orphan: 'Orpheline',
        pending: 'En attente'
    };

    // Mots-outils retirés du nuage (français et anglais). Les mots génériques
    // comme « lire » ou « plus » restent : une ancre « en savoir plus » est
    // justement un défaut de maillage à repérer.
    var STOPWORDS = new Set((
        'les des une un le la de du et en au aux ou où est sont pour par sur dans avec sans sous ' +
        'vos votre nos notre leur leurs ses son sa ces cet cette ce qui que quoi dont il elle ils elles ' +
        'nous vous on je tu me te se lui mon ton ma ta mes tes pas ne ni mais donc car comme ' +
        'tout tous toute toutes très aussi bien chez entre vers ici the and for with your our you are ' +
        'from this that into are was were has have had its it can all any not but how what why who'
    ).split(/\s+/));

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

    function storageGet(key) {
        try { return window.localStorage.getItem(key); } catch (e) { return null; }
    }

    function storageSet(key, value) {
        try { window.localStorage.setItem(key, value); } catch (e) { /* stockage indisponible */ }
    }

    function decodeSafe(str) {
        try { return decodeURIComponent(str); } catch (e) { return str; }
    }

    function truncate(text, max) {
        return text.length > max ? text.slice(0, max - 1) + '…' : text;
    }

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

    function pageLabel(url, isRoot) {
        if (isRoot) return hostOf(url).replace(/^www\./, '');
        var u;
        try { u = new URL(url); } catch (e) { return url; }
        var parts = u.pathname.split('/').filter(Boolean);
        var text = parts.length ? decodeSafe(parts[parts.length - 1]) : '/';
        if (u.search) text += '?…';
        return truncate(text, 26);
    }

    /* ── Crawl state ──────────────────────────────────────────────────── */

    var state = null;

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
            restarting: false,
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
            anchors: null,
            retries: 0,
            orphan: false
        };
        node.label = pageLabel(url, depth === 0);
        if (parent) parent.children.push(node);
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
        graphs.crawl = emptyGraph();
        graphs.dir = emptyGraph();
        cloud = { words: [], builtAt: 0 };
        selected = null;
        searchMatches = new Set();
        hideDetails();

        var root = addNode(rootUrl, 0, null);
        state.queue.push(root);

        ui.results.classList.remove('hidden');
        ui.progress.classList.remove('hidden');
        ui.stop.classList.remove('hidden');
        ui.url.disabled = true;
        setLoading(true);
        hideError();

        resizeCanvas();
        view.scale = 1;
        view.tx = canvasSize.w / 2;
        view.ty = canvasSize.h / 2;

        dataChanged(true);
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
                dataChanged(false);
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
        node.anchors = page.anchors && typeof page.anchors === 'object' && !Array.isArray(page.anchors) ? page.anchors : null;

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
                    node.label = pageLabel(url, false);
                    crawl.orphans.push(node);
                });
            })
            .catch(function () { /* sitemap facultatif */ })
            .then(function () {
                if (crawl !== state) return;
                finishUi();
            });
    }

    function finishUi() {
        ui.stop.classList.add('hidden');
        ui.url.disabled = false;
        setLoading(false);
        dataChanged(true);
        updateProgress();
        updateStats();
        renderTable();
        scheduleFit();
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

    /* ── Graph models (shared by tree, 2D and 3D layouts) ─────────────── */

    var graphs = { crawl: emptyGraph(), dir: emptyGraph() };

    function emptyGraph() {
        return { byKey: new Map(), nodes: [], root: null, edges: [], vOfPage: new Map(), stale: true };
    }

    function makeVertex(key) {
        return {
            key: key, page: null, folder: false, label: '', depth: 0, parent: null, children: [],
            collapsed: false, orphan: false, pageCount: 0, fresh: true, fixed: false,
            x: 0, y: 0, z: 0, vx: 0, vy: 0, vz: 0, tx: 0, ty: 0, sx: 0, sy: 0, sr: 0, sz: 0
        };
    }

    /** Graphe de découverte : un sommet par page, parent = page découvreuse. */
    function buildCrawlGraph(g) {
        var prev = g.byKey;
        var byKey = new Map();
        var nodes = [];
        var vOfPage = new Map();

        state.nodes.forEach(function (p) {
            var v = prev.get(p.url) || makeVertex(p.url);
            v.page = p;
            v.folder = false;
            v.label = p.label;
            v.depth = p.depth;
            v.orphan = p.orphan;
            v.parent = null;
            v.children = [];
            byKey.set(p.url, v);
            vOfPage.set(p, v);
            nodes.push(v);
        });
        nodes.forEach(function (v) {
            var pv = v.page.parent ? vOfPage.get(v.page.parent) : null;
            if (pv) {
                v.parent = pv;
                pv.children.push(v);
            }
        });

        g.byKey = byKey;
        g.nodes = nodes;
        g.vOfPage = vOfPage;
        g.root = nodes[0] || null;
        g.edges = state.edges.map(function (e) { return { s: vOfPage.get(e.s), t: vOfPage.get(e.t) }; });
    }

    /**
     * Graphe des répertoires : un sommet par segment de chemin. Un dossier
     * qui correspond aussi à une page explorée porte cette page ; sinon c'est
     * un dossier « virtuel ». La query string devient une feuille.
     */
    function buildDirGraph(g) {
        var prev = g.byKey;
        var byKey = new Map();
        var nodes = [];
        var vOfPage = new Map();

        function vertex(key, label, depth, parent) {
            var v = byKey.get(key);
            if (v) return v;
            v = prev.get(key) || makeVertex(key);
            v.page = null;
            v.folder = true;
            v.orphan = false;
            v.label = truncate(label, 26);
            v.depth = depth;
            v.parent = parent;
            v.children = [];
            v.pageCount = 0;
            if (parent) parent.children.push(v);
            byKey.set(key, v);
            nodes.push(v);
            return v;
        }

        function attach(v, p) {
            v.page = p;
            v.folder = false;
            v.orphan = p.orphan;
            vOfPage.set(p, v);
        }

        var root = vertex('/', state.host.replace(/^www\./, ''), 0, null);

        state.nodes.forEach(function (p) {
            var u;
            try { u = new URL(p.url); } catch (e) { return; }
            var segments = u.pathname.split('/').filter(Boolean);
            var cur = root;
            var path = '';
            segments.forEach(function (segment, i) {
                path += '/' + segment;
                cur = vertex(path, decodeSafe(segment), i + 1, cur);
            });
            if (u.search) {
                cur = vertex(path + u.search, '?' + decodeSafe(u.search.slice(1)), segments.length + 1, cur);
            }
            if (!cur.page) {
                attach(cur, p);
            } else if (cur.page !== p) {
                // « /blog » et « /blog/ » : deux pages pour le même chemin.
                attach(vertex(cur.key + '|' + p.url, cur.label + (u.pathname.slice(-1) === '/' ? '/' : ''), cur.depth + 1, cur), p);
            }
        });

        // Pages contenues dans chaque branche (enfants créés après leur parent).
        for (var i = nodes.length - 1; i >= 0; i--) {
            var v = nodes[i];
            v.pageCount = (v.page ? 1 : 0) + v.children.reduce(function (sum, c) { return sum + c.pageCount; }, 0);
        }

        g.byKey = byKey;
        g.nodes = nodes;
        g.vOfPage = vOfPage;
        g.root = root;
        g.edges = state.edges
            .map(function (e) { return { s: vOfPage.get(e.s), t: vOfPage.get(e.t) }; })
            .filter(function (e) { return e.s && e.t && e.s !== e.t; });
    }

    function ensureGraph(kind) {
        var g = graphs[kind];
        if (!g || !state) return g;
        if (g.stale) {
            if (kind === 'crawl') buildCrawlGraph(g); else buildDirGraph(g);
            placeFresh(g);
            g.stale = false;
        }
        return g;
    }

    /** Nouveaux sommets placés près de leur parent pour un départ en douceur. */
    function placeFresh(g) {
        g.nodes.forEach(function (v) {
            if (!v.fresh) return;
            v.fresh = false;
            var p = v.parent;
            var angle = Math.random() * Math.PI * 2;
            var dist = p && p.depth === 0 ? 140 : 40;
            v.x = (p ? p.x : 0) + (p ? Math.cos(angle) * dist : 0);
            v.y = (p ? p.y : 0) + (p ? Math.sin(angle) * dist : 0);
            v.z = (p ? p.z : 0) + (Math.random() - 0.5) * dist;
            v.tx = p ? p.tx : 0;
            v.ty = p ? p.ty : 0;
        });
    }

    function graph() {
        return current.graph ? ensureGraph(current.graph) : null;
    }

    /* ── Visibility (limit, collapse, filter, search) ─────────────────── */

    var visible = [];
    var visibleSet = new Set();
    var filterMatches = null;  // null = aucun filtre
    var searchMatches = new Set();

    function updateVisibility() {
        visible = [];
        visibleSet = new Set();
        var g = graph();
        if (!g || !g.root) return;

        var limit = parseInt(ui.limit.value, 10) || Infinity;
        var queue = [g.root];
        while (queue.length && visible.length < limit) {
            var v = queue.shift();
            visible.push(v);
            if (!v.collapsed) v.children.forEach(function (c) { queue.push(c); });
        }
        g.nodes.forEach(function (v) {
            if (v.orphan && !v.parent && v !== g.root && visible.length < limit) visible.push(v);
        });
        visible.forEach(function (v) { visibleSet.add(v); });
    }

    function hiddenDescendants(v) {
        var count = 0;
        var stack = v.children.slice();
        while (stack.length) {
            var n = stack.pop();
            count++;
            n.children.forEach(function (c) { stack.push(c); });
        }
        return count;
    }

    function pageMatchesFilter(p) {
        switch (ui.filter.value) {
            case 'indexable': return p.kind === 'indexable';
            case 'nonindexable': return p.crawled && p.kind !== 'indexable';
            case 'redirect': return p.kind === 'redirect';
            case 'error': return p.kind === 'error';
            case 'orphan': return p.orphan;
            default: return true;
        }
    }

    /** Un dossier reste visible si une page de sa branche correspond. */
    function refreshFilter() {
        var g = graph();
        if (!g || ui.filter.value === 'all') {
            filterMatches = null;
            return;
        }
        filterMatches = new Set();
        for (var i = g.nodes.length - 1; i >= 0; i--) {
            var v = g.nodes[i];
            var match = v.page ? pageMatchesFilter(v.page) : false;
            if (!match) {
                for (var j = 0; j < v.children.length; j++) {
                    if (filterMatches.has(v.children[j])) { match = true; break; }
                }
            }
            if (match) filterMatches.add(v);
        }
    }

    function refreshSearch() {
        searchMatches = new Set();
        var q = ui.search.value.trim().toLowerCase();
        if (!state || q.length < 2) return;
        if (current.layout === 'cloud') {
            cloud.words.forEach(function (w) { if (w.text.indexOf(q) !== -1) searchMatches.add(w); });
            return;
        }
        var g = graph();
        if (!g) return;
        g.nodes.forEach(function (v) {
            var hay = v.page ? v.page.url + ' ' + (v.page.title || '') : v.key;
            if (hay.toLowerCase().indexOf(q) !== -1) searchMatches.add(v);
        });
    }

    function isDimmed(v) {
        return (filterMatches && !filterMatches.has(v)) || (searchMatches.size > 0 && !searchMatches.has(v));
    }

    /* ── Data / view refresh ──────────────────────────────────────────── */

    var cloudTimer = null;

    /** Appelé après chaque lot : les graphes sont reconstruits à la demande. */
    function dataChanged(force) {
        graphs.crawl.stale = true;
        graphs.dir.stale = true;
        if (current.layout === 'cloud') {
            if (force || Date.now() - cloud.builtAt > 1500) buildCloud();
            else if (!cloudTimer) cloudTimer = setTimeout(function () { cloudTimer = null; buildCloud(); requestDraw(); }, 1500);
            requestDraw();
            return;
        }
        relayout(force ? 1 : 0.5);
    }

    function relayout(heat) {
        updateVisibility();
        refreshFilter();
        refreshSearch();
        if (current.layout === 'tree') layoutTree();
        else {
            if (current.graph === 'crawl') layoutOrphans();
            reheat(heat);
        }
        requestDraw();
    }

    /* ── Layout: tree ─────────────────────────────────────────────────── */

    var TREE_ROW = 24;
    var TREE_WRAP = 10;      // au-delà, une fratrie de feuilles passe sur plusieurs colonnes
    var TREE_LEAF_COL = 230;
    var animating = false;

    function visibleKids(v) {
        return v.collapsed ? [] : v.children.filter(function (c) { return visibleSet.has(c); });
    }

    function layoutTree() {
        var g = graph();
        if (!g || !g.root) return;
        var col = current.graph === 'dir' ? 200 : 230;
        var leaf = 0;

        function walk(v, depth) {
            v.tx = depth * col;
            v.wrapCol = 0;
            var kids = visibleKids(v);
            if (!kids.length) {
                v.ty = leaf * TREE_ROW;
                leaf++;
                return;
            }
            // Une page qui lie 40 feuilles (ex. /tools) rendrait l'arbre
            // interminable : ses feuilles sont rangées sur 2 à 4 colonnes.
            var allLeaves = kids.every(function (c) { return !visibleKids(c).length; });
            if (allLeaves && kids.length > TREE_WRAP) {
                var cols = Math.min(4, Math.ceil(kids.length / TREE_WRAP));
                var rows = Math.ceil(kids.length / cols);
                kids.forEach(function (c, i) {
                    c.wrapCol = Math.floor(i / rows);
                    c.tx = (depth + 1) * col + c.wrapCol * TREE_LEAF_COL;
                    c.ty = (leaf + (i % rows)) * TREE_ROW;
                });
                v.ty = (leaf + (rows - 1) / 2) * TREE_ROW;
                leaf += rows + 1;
                return;
            }
            kids.forEach(function (c) { walk(c, depth + 1); });
            v.ty = (kids[0].ty + kids[kids.length - 1].ty) / 2;
        }
        walk(g.root, 0);

        // Pages orphelines : grille sous l'arbre.
        var top = leaf * TREE_ROW + 80;
        visible.filter(function (v) { return v.orphan && !v.parent && v !== g.root; }).forEach(function (v, i) {
            v.wrapCol = 0;
            v.tx = (i % 4) * TREE_LEAF_COL;
            v.ty = top + Math.floor(i / 4) * TREE_ROW;
        });

        if (reducedMotion) {
            visible.forEach(function (v) { v.x = v.tx; v.y = v.ty; });
        }
        animating = true;
        requestDraw();
    }

    function stepTree() {
        var moving = false;
        visible.forEach(function (v) {
            var dx = v.tx - v.x;
            var dy = v.ty - v.y;
            if (Math.abs(dx) > 0.3 || Math.abs(dy) > 0.3) {
                v.x += dx * 0.2;
                v.y += dy * 0.2;
                moving = true;
            } else {
                v.x = v.tx;
                v.y = v.ty;
            }
        });
        return moving;
    }

    /* ── Layout: force (2D and 3D) ────────────────────────────────────── */

    var alpha = 0;
    var reducedMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    function forceRadius(v) {
        if (v.orphan) return 7;
        if (v.depth === 0) return current.graph === 'dir' ? 24 : 28;
        if (v.folder) return 6 + Math.min(10, 1.5 * Math.sqrt(v.pageCount));
        var base = Math.max(5, 17 - 4 * (v.depth - 1));
        return base + Math.min(9, 1.6 * Math.sqrt(v.page.inCount));
    }

    function treeRadius(v) {
        if (v.depth === 0) return 9;
        if (v.folder) return 5;
        return 5 + Math.min(4, 0.6 * Math.sqrt(v.page.inCount));
    }

    function radiusOf(v) {
        return current.layout === 'tree' ? treeRadius(v) : forceRadius(v);
    }

    function tick(is3d) {
        var nodes = visible.filter(function (v) { return !v.orphan || v.parent; });
        var count = nodes.length;
        var i, j, a, b, dx, dy, dz, d2, d, f;

        // Ressorts de l'arbre.
        for (i = 0; i < count; i++) {
            b = nodes[i];
            a = b.parent;
            if (!a || !visibleSet.has(a)) continue;
            dx = b.x - a.x; dy = b.y - a.y; dz = is3d ? b.z - a.z : 0;
            d = Math.sqrt(dx * dx + dy * dy + dz * dz) || 0.01;
            var length = (a.depth === 0 ? 150 : 55) + 5 * Math.sqrt(a.children.length) + forceRadius(b);
            f = (d - length) / d * 0.08 * alpha;
            dx *= f; dy *= f; dz *= f;
            b.vx -= dx; b.vy -= dy; b.vz -= dz;
            if (!a.fixed) { a.vx += dx * 0.5; a.vy += dy * 0.5; a.vz += dz * 0.5; }
        }

        // Répulsion + collision (n² : au plus quelques centaines de nœuds).
        for (i = 0; i < count; i++) {
            a = nodes[i];
            var ra = forceRadius(a);
            for (j = i + 1; j < count; j++) {
                b = nodes[j];
                dx = b.x - a.x; dy = b.y - a.y; dz = is3d ? b.z - a.z : 0;
                d2 = dx * dx + dy * dy + dz * dz;
                if (d2 < 0.01) { dx = Math.random() - 0.5; dy = Math.random() - 0.5; dz = is3d ? Math.random() - 0.5 : 0; d2 = dx * dx + dy * dy + dz * dz; }
                if (d2 > 250000) continue;
                d = Math.sqrt(d2);
                f = 900 * alpha / d2;
                var minDist = ra + forceRadius(b) + 6;
                if (d < minDist) f += (minDist - d) / d * 0.5;
                dx *= f; dy *= f; dz *= f;
                if (!a.fixed) { a.vx -= dx; a.vy -= dy; a.vz -= dz; }
                if (!b.fixed) { b.vx += dx; b.vy += dy; b.vz += dz; }
            }
        }

        for (i = 0; i < count; i++) {
            a = nodes[i];
            if (a.fixed) { a.vx = a.vy = a.vz = 0; continue; }
            a.vx -= a.x * 0.002 * alpha;
            a.vy -= a.y * 0.002 * alpha;
            a.vz -= a.z * 0.002 * alpha;
            a.vx *= 0.6; a.vy *= 0.6; a.vz *= 0.6;
            a.x += a.vx; a.y += a.vy;
            a.z = is3d ? a.z + a.vz : 0;
        }

        alpha *= 0.985;
        if (alpha < 0.004) alpha = 0;
        tickCount++;
        // Pendant la stabilisation : l'anneau d'orphelines suit le cœur du
        // graphe et le cadrage suit la disposition (tant qu'on n'y touche pas).
        if (alpha > 0 && tickCount % 30 === 0) {
            if (current.graph === 'crawl') layoutOrphans();
            if (pendingFit) fitView();
        }
        if (alpha === 0) {
            if (current.graph === 'crawl') layoutOrphans();
            if (pendingFit) {
                pendingFit = false;
                fitView();
            }
        }
    }

    /**
     * Cadrage : immédiat pour l'arbre et le nuage (positions finales connues),
     * puis de nouveau quand les forces se stabilisent — sauf si l'utilisateur
     * a zoomé ou déplacé la vue entre-temps.
     */
    var pendingFit = false;
    var tickCount = 0;

    function scheduleFit() {
        pendingFit = current.layout === 'force' || current.layout === '3d';
        setTimeout(fitView, current.layout === 'tree' || current.layout === 'cloud' ? 300 : 600);
    }

    function cancelPendingFit() {
        pendingFit = false;
    }

    function reheat(value) {
        alpha = Math.max(alpha, value);
        if (reducedMotion) {
            for (var k = 0; k < 300 && alpha > 0; k++) tick(current.layout === '3d');
            alpha = 0;
        }
        requestDraw();
    }

    /**
     * Prépare une disposition par forces : racine fixée à l'origine, la
     * position actuelle (venant éventuellement d'une autre vue) sert de départ.
     */
    function enterForce(is3d) {
        var g = graph();
        if (!g || !g.root) return;
        var ox = g.root.x;
        var oy = g.root.y;
        g.nodes.forEach(function (v) {
            v.x -= ox;
            v.y -= oy;
            v.fixed = false;
            if (is3d && Math.abs(v.z) < 1 && v !== g.root) v.z = (Math.random() - 0.5) * 300;
            if (!is3d) v.z = 0;
        });
        g.root.x = g.root.y = g.root.z = 0;
        g.root.fixed = true;
        if (current.graph === 'crawl') layoutOrphans();
        reheat(1);
    }

    /** Pages orphelines du graphe d'exploration : grille (2D) ou anneau (3D). */
    function layoutOrphans() {
        var g = graphs.crawl;
        var orphans = visible.filter(function (v) { return v.orphan && !v.parent; });
        if (!orphans.length || current.graph !== 'crawl' || current.layout === 'tree') return;
        var maxX = 0;
        var minY = 0;
        var maxR = 0;
        visible.forEach(function (v) {
            if (v.orphan && !v.parent) return;
            maxX = Math.max(maxX, v.x + forceRadius(v));
            minY = Math.min(minY, v.y);
            maxR = Math.max(maxR, Math.sqrt(v.x * v.x + v.y * v.y + v.z * v.z) + forceRadius(v));
        });
        if (current.layout === '3d') {
            var ring = Math.max(200, maxR * 1.1) + 60;
            orphans.forEach(function (v, i) {
                var angle = (i / orphans.length) * Math.PI * 2;
                v.x = Math.cos(angle) * ring;
                v.z = Math.sin(angle) * ring;
                v.y = ((i % 5) - 2) * 24;
                v.fixed = true;
            });
        } else {
            var cols = Math.max(4, Math.ceil(Math.sqrt(orphans.length)));
            orphans.forEach(function (v, i) {
                v.x = maxX + 140 + (i % cols) * 44;
                v.y = minY + Math.floor(i / cols) * 44;
                v.z = 0;
                v.fixed = true;
            });
        }
        return g;
    }

    /* ── Anchor-text word cloud ───────────────────────────────────────── */

    var cloud = { words: [], builtAt: 0 };

    function tokenize(text) {
        return text.toLowerCase()
            .split(/[^0-9a-zà-öø-ÿœæ'’-]+/i)
            .map(function (w) { return w.replace(/^['’-]+|['’-]+$/g, '').replace(/^(?:l|d|j|m|n|s|t|c|qu)['’]/, ''); })
            .filter(function (w) { return w.length >= 3 && !STOPWORDS.has(w) && !/^\d+$/.test(w); });
    }

    function buildCloud() {
        cloud.builtAt = Date.now();
        var counts = new Map();
        if (state) {
            state.nodes.forEach(function (source) {
                if (!source.anchors) return;
                Object.keys(source.anchors).forEach(function (url) {
                    var target = state.byUrl.get(url) || null;
                    var texts = Array.isArray(source.anchors[url]) ? source.anchors[url] : [];
                    texts.forEach(function (text) {
                        var tokens = toggles.phrases
                            ? [String(text).toLowerCase().replace(/\s+/g, ' ').trim()].filter(function (t) { return t.length >= 2 && t.length <= 60; })
                            : tokenize(String(text));
                        var seen = new Set();
                        tokens.forEach(function (token) {
                            if (seen.has(token)) return;
                            seen.add(token);
                            var w = counts.get(token);
                            if (!w) {
                                w = { isWord: true, text: token, count: 0, targets: new Map(), sources: new Set(), anchors: new Map() };
                                counts.set(token, w);
                            }
                            w.count++;
                            w.sources.add(source);
                            w.anchors.set(text, (w.anchors.get(text) || 0) + 1);
                            if (target) w.targets.set(target, (w.targets.get(target) || 0) + 1);
                        });
                    });
                });
            });
        }
        var words = Array.from(counts.values())
            .sort(function (a, b) { return b.count - a.count || (a.text < b.text ? -1 : 1); })
            .slice(0, MAX_CLOUD_WORDS);
        layoutCloud(words);
        cloud.words = words;
        if (selected && selected.isWord) {
            selected = words.find(function (w) { return w.text === selected.text; }) || null;
            if (!selected) hideDetails();
        }
        refreshSearch();
    }

    function wordFont(w) {
        return (w.size > 30 ? '700 ' : '600 ') + w.size + 'px Inter, sans-serif';
    }

    /** Placement en spirale (sans chevauchement), centré sur l'origine. */
    function layoutCloud(words) {
        if (!words.length) return;
        var max = Math.sqrt(words[0].count);
        var min = Math.sqrt(words[words.length - 1].count);
        var placed = [];

        words.forEach(function (w, i) {
            w.size = Math.round(13 + (max === min ? 0.5 : (Math.sqrt(w.count) - min) / (max - min)) * 47);
            w.color = CLOUD_COLORS[i % CLOUD_COLORS.length];
            ctx.font = wordFont(w);
            var width = ctx.measureText(w.text).width + 8;
            var height = w.size * 1.1 + 4;
            var angle = 0;
            var radius = 0;
            w.placed = false;
            while (radius < 2000) {
                var cx = radius * Math.cos(angle) * 1.5;
                var cy = radius * Math.sin(angle) * 0.85;
                var rect = { x: cx - width / 2, y: cy - height / 2, w: width, h: height };
                var free = true;
                for (var k = 0; k < placed.length; k++) {
                    var o = placed[k];
                    if (rect.x < o.x + o.w && rect.x + rect.w > o.x && rect.y < o.y + o.h && rect.y + rect.h > o.y) {
                        free = false;
                        break;
                    }
                }
                if (free) {
                    w.rect = rect;
                    w.x = cx;
                    w.y = cy;
                    w.placed = true;
                    placed.push(rect);
                    break;
                }
                angle += Math.min(0.35, 8 / Math.max(radius, 1));
                radius = angle * 1.3;
            }
        });
    }

    /* ── Rendering ────────────────────────────────────────────────────── */

    var canvas, ctx;
    var dpr = 1;
    var canvasSize = { w: 0, h: 0 };
    var view = { scale: 1, tx: 0, ty: 0 };
    var cam = { yaw: 0.6, pitch: -0.35, dist: FOCAL, radius: 1 };
    var toggles = { labels: true, arrows: false, 'all-links': false, rotate: !reducedMotion, phrases: false };
    var current = { view: DEFAULT_VIEW, graph: 'crawl', layout: 'force' };
    var selected = null;   // sommet de graphe, ou mot du nuage (isWord)
    var hovered = null;
    var rafId = null;
    var pointerActive = false;

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
        if (rafId === null) rafId = requestAnimationFrame(frame);
    }

    function frame() {
        rafId = null;
        var active = false;
        if (state) {
            if (current.layout === 'tree') {
                active = animating = stepTree();
            } else if (current.layout === 'force' || current.layout === '3d') {
                if (alpha > 0) { tick(current.layout === '3d'); active = true; }
                if (current.layout === '3d' && toggles.rotate && !pointerActive && !document.hidden) {
                    cam.yaw += 0.0025;
                    active = true;
                }
            }
        }
        draw();
        if (active) rafId = requestAnimationFrame(frame);
    }

    function fillFor(v) {
        if (v.collapsed && v.children.length) return COLORS.collapsed;
        if (!v.page) return COLORS.folderFill;
        var p = v.page;
        if (p.orphan) return '#ffffff';
        if (v.depth === 0 && p.kind === 'indexable') return COLORS.root;
        switch (p.kind) {
            case 'indexable': return COLORS.indexable[Math.min(COLORS.indexable.length - 1, Math.max(0, v.depth - 1))];
            case 'nonindexable': return COLORS.nonindexable;
            case 'error': return COLORS.error;
            case 'redirect': return COLORS.redirect;
            case 'blocked': return COLORS.blocked;
            default: return COLORS.pending;
        }
    }

    function strokeFor(v) {
        if (v.collapsed && v.children.length) return null;
        if (!v.page) return COLORS.folderStroke;
        if (v.page.orphan) return COLORS.orphanStroke;
        if (v.page.kind === 'pending') return '#d1d5db';
        return null;
    }

    function draw() {
        if (!ctx) return;
        ctx.setTransform(1, 0, 0, 1, 0, 0);
        ctx.fillStyle = '#ffffff';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        if (!state) return;

        if (current.layout === 'cloud') drawCloud();
        else if (current.layout === '3d') draw3d();
        else draw2d();
    }

    function draw2d() {
        var g = graph();
        if (!g) return;
        var s = view.scale;
        var tree = current.layout === 'tree';
        ctx.setTransform(dpr * s, 0, 0, dpr * s, dpr * view.tx, dpr * view.ty);

        if (toggles['all-links'] && !tree) {
            ctx.lineWidth = 0.7 / s;
            ctx.strokeStyle = COLORS.edgeFaint;
            ctx.beginPath();
            g.edges.forEach(function (e) {
                if (!visibleSet.has(e.s) || !visibleSet.has(e.t)) return;
                ctx.moveTo(e.s.x, e.s.y);
                ctx.lineTo(e.t.x, e.t.y);
            });
            ctx.stroke();
        }

        ctx.lineWidth = 1 / s;
        visible.forEach(function (v) {
            var p = v.parent;
            if (!p || !visibleSet.has(p)) return;
            ctx.strokeStyle = COLORS.edge;
            // Colonnes de feuilles repliées : traits atténués pour ne pas barrer les libellés.
            ctx.globalAlpha = (isDimmed(v) ? 0.15 : 1) * (tree && v.wrapCol ? 0.35 : 1);
            ctx.beginPath();
            ctx.moveTo(p.x, p.y);
            if (tree) {
                var mx = (p.x + v.x) / 2;
                ctx.bezierCurveTo(mx, p.y, mx, v.y, v.x, v.y);
            } else {
                ctx.lineTo(v.x, v.y);
            }
            ctx.stroke();
            if (toggles.arrows) {
                if (tree) drawArrow({ x: v.x - 20, y: v.y }, v, s);
                else drawArrow(p, v, s);
            }
        });
        ctx.globalAlpha = 1;

        visible.forEach(function (v) {
            var r = radiusOf(v);
            ctx.globalAlpha = isDimmed(v) ? 0.15 : 1;
            ctx.beginPath();
            ctx.arc(v.x, v.y, r, 0, Math.PI * 2);
            ctx.fillStyle = fillFor(v);
            ctx.fill();
            var stroke = strokeFor(v);
            if (stroke) {
                ctx.lineWidth = (v.page && v.page.orphan ? 2.5 : 1.5) / s;
                ctx.strokeStyle = stroke;
                ctx.stroke();
            }
            if (v === selected || v === hovered || searchMatches.has(v)) {
                ctx.beginPath();
                ctx.arc(v.x, v.y, r + 4 / s, 0, Math.PI * 2);
                ctx.lineWidth = (v === selected ? 3 : 2) / s;
                ctx.strokeStyle = COLORS.accent;
                ctx.stroke();
            }
            if (v.collapsed && v.children.length && !tree) {
                ctx.fillStyle = '#111827';
                ctx.font = '600 ' + Math.max(9, r * 0.7) + 'px Inter, sans-serif';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.fillText('+' + hiddenDescendants(v), v.x, v.y);
            }
        });
        ctx.globalAlpha = 1;

        if (toggles.labels) drawLabels2d(s, tree);
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

    function labelText(v) {
        if (v.collapsed && v.children.length) return v.label + ' (+' + hiddenDescendants(v) + ')';
        if (v.folder && v.pageCount) return v.label + '/';
        return v.label;
    }

    function drawLabels2d(s, tree) {
        var crowded = tree ? TREE_ROW * s < 10 : visible.length > 250 && s < 0.7;
        ctx.font = (11 / s) + 'px Inter, sans-serif';
        ctx.textAlign = tree ? 'left' : 'center';
        ctx.textBaseline = tree ? 'middle' : 'top';
        ctx.lineJoin = 'round';
        visible.forEach(function (v) {
            var r = radiusOf(v);
            var important = v === selected || v === hovered || v.depth === 0 || searchMatches.has(v);
            if (!important) {
                if (isDimmed(v)) return;
                if (crowded && v.depth > 1) return;
                if (!tree && r * s < 4) return;
            }
            var x = tree ? v.x + r + 4 / s : v.x;
            var y = tree ? v.y : v.y + r + 3 / s;
            var text = labelText(v);
            ctx.lineWidth = 3 / s;
            ctx.strokeStyle = 'rgba(255,255,255,0.9)';
            ctx.strokeText(text, x, y);
            ctx.fillStyle = COLORS.label;
            ctx.fillText(text, x, y);
        });
    }

    /* 3D : rotation (lacet puis tangage) et projection perspective. */
    /**
     * Distance de la caméra proportionnelle au rayon du graphe : un nœud ne
     * passe jamais assez près de l'objectif pour exploser à l'écran.
     */
    function updateCamera() {
        var radius = 1;
        visible.forEach(function (v) { radius = Math.max(radius, Math.sqrt(v.x * v.x + v.y * v.y + v.z * v.z)); });
        cam.radius = radius;
        cam.dist = Math.max(FOCAL, radius * 2.5);
    }

    function project(v, scale, tx, ty) {
        var cy = Math.cos(cam.yaw), sy = Math.sin(cam.yaw);
        var cp = Math.cos(cam.pitch), sp = Math.sin(cam.pitch);
        var x1 = v.x * cy - v.z * sy;
        var z1 = v.x * sy + v.z * cy;
        var y1 = v.y * cp - z1 * sp;
        var z2 = v.y * sp + z1 * cp;
        var f = cam.dist / Math.max(cam.dist * 0.3, cam.dist + z2);
        v.sx = tx + x1 * f * scale;
        v.sy = ty + y1 * f * scale;
        v.sz = z2;
        v.sf = f;
        v.sr = forceRadius(v) * f * scale;
    }

    function draw3d() {
        var g = graph();
        if (!g) return;
        var s = view.scale;
        updateCamera();
        visible.forEach(function (v) { project(v, s, view.tx, view.ty); });

        ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
        var depthAlpha = function (v) { return Math.max(0.35, Math.min(1, 1 - 0.65 * (v.sz + cam.radius) / (2 * cam.radius))); };

        if (toggles['all-links']) {
            ctx.lineWidth = 0.6;
            ctx.strokeStyle = COLORS.edgeFaint;
            ctx.beginPath();
            g.edges.forEach(function (e) {
                if (!visibleSet.has(e.s) || !visibleSet.has(e.t)) return;
                ctx.moveTo(e.s.sx, e.s.sy);
                ctx.lineTo(e.t.sx, e.t.sy);
            });
            ctx.stroke();
        }

        ctx.lineWidth = 1;
        visible.forEach(function (v) {
            var p = v.parent;
            if (!p || !visibleSet.has(p)) return;
            ctx.globalAlpha = (isDimmed(v) ? 0.15 : 1) * Math.min(depthAlpha(v), depthAlpha(p));
            ctx.strokeStyle = COLORS.edge;
            ctx.beginPath();
            ctx.moveTo(p.sx, p.sy);
            ctx.lineTo(v.sx, v.sy);
            ctx.stroke();
        });

        // Peintre : du plus lointain au plus proche.
        var order = visible.slice().sort(function (a, b) { return b.sz - a.sz; });
        order.forEach(function (v) {
            var r = Math.max(1.5, v.sr);
            ctx.globalAlpha = (isDimmed(v) ? 0.15 : 1) * depthAlpha(v);
            ctx.beginPath();
            ctx.arc(v.sx, v.sy, r, 0, Math.PI * 2);
            ctx.fillStyle = fillFor(v);
            ctx.fill();
            var stroke = strokeFor(v);
            if (stroke) {
                ctx.lineWidth = v.page && v.page.orphan ? 2 : 1.2;
                ctx.strokeStyle = stroke;
                ctx.stroke();
            }
            // Reflet : donne du volume à la sphère.
            if (r > 4) {
                ctx.beginPath();
                ctx.arc(v.sx - r * 0.3, v.sy - r * 0.3, r * 0.35, 0, Math.PI * 2);
                ctx.fillStyle = 'rgba(255,255,255,0.35)';
                ctx.fill();
            }
            if (v === selected || v === hovered || searchMatches.has(v)) {
                ctx.globalAlpha = 1;
                ctx.beginPath();
                ctx.arc(v.sx, v.sy, r + 4, 0, Math.PI * 2);
                ctx.lineWidth = v === selected ? 3 : 2;
                ctx.strokeStyle = COLORS.accent;
                ctx.stroke();
            }
        });
        ctx.globalAlpha = 1;

        if (toggles.labels) {
            ctx.font = '11px Inter, sans-serif';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'top';
            ctx.lineJoin = 'round';
            order.forEach(function (v) {
                var important = v === selected || v === hovered || v.depth === 0 || searchMatches.has(v);
                if (!important && (isDimmed(v) || v.sr < 6)) return;
                var text = labelText(v);
                ctx.globalAlpha = important ? 1 : depthAlpha(v);
                ctx.lineWidth = 3;
                ctx.strokeStyle = 'rgba(255,255,255,0.9)';
                ctx.strokeText(text, v.sx, v.sy + v.sr + 3);
                ctx.fillStyle = COLORS.label;
                ctx.fillText(text, v.sx, v.sy + v.sr + 3);
            });
            ctx.globalAlpha = 1;
        }
    }

    function drawCloud() {
        var s = view.scale;
        ctx.setTransform(dpr * s, 0, 0, dpr * s, dpr * view.tx, dpr * view.ty);
        if (!cloud.words.length) {
            ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
            ctx.fillStyle = '#6b7280';
            ctx.font = '14px Inter, sans-serif';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillText(state && state.finished
                ? 'Aucun texte d\'ancre trouvé dans les liens internes explorés.'
                : 'Les textes d\'ancre apparaîtront au fil de l\'exploration…', canvasSize.w / 2, canvasSize.h / 2);
            return;
        }
        var searching = searchMatches.size > 0;
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        cloud.words.forEach(function (w) {
            if (!w.placed) return;
            if (w === selected || w === hovered) {
                ctx.globalAlpha = 1;
                ctx.fillStyle = w === selected ? 'rgba(0,174,239,0.14)' : 'rgba(0,174,239,0.07)';
                ctx.fillRect(w.rect.x, w.rect.y, w.rect.w, w.rect.h);
            }
            ctx.globalAlpha = searching && !searchMatches.has(w) ? 0.18 : 1;
            ctx.font = wordFont(w);
            ctx.fillStyle = w === selected ? '#0F0F0F' : w.color;
            ctx.fillText(w.text, w.x, w.y);
        });
        ctx.globalAlpha = 1;
    }

    /* ── View helpers ─────────────────────────────────────────────────── */

    function toWorld(px, py) {
        return { x: (px - view.tx) / view.scale, y: (py - view.ty) / view.scale };
    }

    function zoomAt(factor, px, py) {
        cancelPendingFit();
        var next = Math.max(0.05, Math.min(6, view.scale * factor));
        factor = next / view.scale;
        view.tx = px - (px - view.tx) * factor;
        view.ty = py - (py - view.ty) * factor;
        view.scale = next;
        requestDraw();
    }

    function fitView() {
        var minX = Infinity, minY = Infinity, maxX = -Infinity, maxY = -Infinity;
        function grow(x0, y0, x1, y1) {
            minX = Math.min(minX, x0); minY = Math.min(minY, y0);
            maxX = Math.max(maxX, x1); maxY = Math.max(maxY, y1);
        }
        if (current.layout === 'cloud') {
            cloud.words.forEach(function (w) { if (w.placed) grow(w.rect.x, w.rect.y, w.rect.x + w.rect.w, w.rect.y + w.rect.h); });
        } else if (current.layout === '3d') {
            updateCamera();
            visible.forEach(function (v) {
                project(v, 1, 0, 0);
                var r = forceRadius(v) * v.sf + 14;
                grow(v.sx - r, v.sy - r, v.sx + r, v.sy + r);
            });
        } else {
            var tree = current.layout === 'tree';
            visible.forEach(function (v) {
                var x = tree ? v.tx : v.x;
                var y = tree ? v.ty : v.y;
                var r = radiusOf(v) + 18;
                grow(x - r, y - r, x + r + (tree ? 160 : 0), y + r);
            });
        }
        if (minX === Infinity) return;
        var w = Math.max(1, maxX - minX);
        var h = Math.max(1, maxY - minY);
        view.scale = Math.max(0.05, Math.min(2, Math.min(canvasSize.w / w, canvasSize.h / h) * (current.layout === '3d' ? 0.8 : 0.92)));
        view.tx = canvasSize.w / 2 - (minX + w / 2) * view.scale;
        view.ty = canvasSize.h / 2 - (minY + h / 2) * view.scale;
        requestDraw();
    }

    function centerOn(target) {
        if (view.scale < 0.6) view.scale = 0.9;
        if (current.layout === '3d') {
            updateCamera();
            project(target, view.scale, 0, 0);
            view.tx = canvasSize.w / 2 - target.sx;
            view.ty = canvasSize.h / 2 - target.sy;
        } else {
            var x = current.layout === 'tree' ? target.tx : target.x;
            var y = current.layout === 'tree' ? target.ty : target.y;
            view.tx = canvasSize.w / 2 - x * view.scale;
            view.ty = canvasSize.h / 2 - y * view.scale;
        }
        requestDraw();
    }

    function hitTest(px, py) {
        var i;
        if (current.layout === 'cloud') {
            var pw = toWorld(px, py);
            for (i = 0; i < cloud.words.length; i++) {
                var w = cloud.words[i];
                if (w.placed && pw.x >= w.rect.x && pw.x <= w.rect.x + w.rect.w && pw.y >= w.rect.y && pw.y <= w.rect.y + w.rect.h) return w;
            }
            return null;
        }
        var best = null;
        var bestScore = Infinity;
        if (current.layout === '3d') {
            for (i = 0; i < visible.length; i++) {
                var v3 = visible[i];
                var d3 = Math.hypot(v3.sx - px, v3.sy - py);
                // À distance égale, le nœud le plus proche de la caméra gagne.
                if (d3 <= Math.max(6, v3.sr) + 3 && v3.sz < bestScore) { best = v3; bestScore = v3.sz; }
            }
            return best;
        }
        var p = toWorld(px, py);
        for (i = visible.length - 1; i >= 0; i--) {
            var v = visible[i];
            var d = Math.hypot(v.x - p.x, v.y - p.y);
            if (d <= radiusOf(v) + 4 / view.scale && d < bestScore) { best = v; bestScore = d; }
        }
        return best;
    }

    function revealVertex(v) {
        var changed = false;
        for (var p = v.parent; p; p = p.parent) {
            if (p.collapsed) { p.collapsed = false; changed = true; }
        }
        if (!visibleSet.has(v)) {
            ui.limit.value = '0';
            changed = true;
        }
        if (changed) relayout(0.3);
    }

    function toggleCollapse(v) {
        if (!v || v.isWord || !v.children.length) return;
        v.collapsed = !v.collapsed;
        relayout(0.4);
        if (selected === v) showVertexDetails(v);
    }

    /* ── View switching ───────────────────────────────────────────────── */

    function setView(key, opts) {
        if (!VIEWS[key]) key = DEFAULT_VIEW;
        var previousSelectedPage = selected && !selected.isWord ? selected.page : null;
        current = { view: key, graph: VIEWS[key].graph, layout: VIEWS[key].layout };
        storageSet(STORAGE_KEY, key);
        syncViewPicker();
        syncLayoutUi();

        hovered = null;
        selected = null;
        hideDetails();
        alpha = 0;

        if (!state) return;
        if (current.layout === 'cloud') {
            buildCloud();
        } else {
            ensureGraph(current.graph);
            updateVisibility();
            refreshFilter();
            refreshSearch();
            if (current.layout === 'tree') layoutTree();
            else enterForce(current.layout === '3d');
            if (previousSelectedPage) {
                var v = graph().vOfPage.get(previousSelectedPage);
                if (v) { revealVertex(v); selected = v; showVertexDetails(v); }
            }
        }
        if (!(opts && opts.keepCamera)) {
            scheduleFit();
        }
        requestDraw();
    }

    function syncViewPicker() {
        var option = $('cv-view-' + current.view);
        ui.viewMenu.querySelectorAll('[data-cv-view]').forEach(function (el) {
            el.setAttribute('aria-selected', el === option ? 'true' : 'false');
        });
        if (!option) return;
        ui.viewCurrent.textContent = option.querySelector('.cv-view-option-title').textContent;
        ui.viewIcon.innerHTML = option.querySelector('.cv-view-option-icon').innerHTML;
        ui.viewMenu.setAttribute('aria-activedescendant', option.id);
    }

    function syncLayoutUi() {
        document.querySelectorAll('[data-cv-layouts]').forEach(function (el) {
            el.classList.toggle('hidden', el.dataset.cvLayouts.split(' ').indexOf(current.layout) === -1);
        });
        document.querySelectorAll('[data-cv-graphs]').forEach(function (el) {
            el.classList.toggle('hidden', el.dataset.cvGraphs.split(' ').indexOf(current.graph || '') === -1);
        });
        var hints = {};
        try { hints = JSON.parse(ui.hint.dataset.hints || '{}'); } catch (e) { /* garde le texte par défaut */ }
        if (hints[current.layout]) ui.hint.textContent = hints[current.layout];
        ui.search.placeholder = current.layout === 'cloud' ? 'Rechercher un mot' : ui.search.dataset.placeholder;
    }

    function bindViewPicker() {
        var options = Array.prototype.slice.call(ui.viewMenu.querySelectorAll('[data-cv-view]'));
        var activeIndex = 0;

        function setActive(i) {
            activeIndex = (i + options.length) % options.length;
            options.forEach(function (o, k) { o.classList.toggle('is-active', k === activeIndex); });
            ui.viewMenu.setAttribute('aria-activedescendant', options[activeIndex].id);
            options[activeIndex].scrollIntoView({ block: 'nearest' });
        }

        function open() {
            ui.viewMenu.classList.remove('hidden');
            ui.viewBtn.setAttribute('aria-expanded', 'true');
            setActive(Math.max(0, options.findIndex(function (o) { return o.dataset.cvView === current.view; })));
            ui.viewMenu.focus();
        }

        function close(focusButton) {
            ui.viewMenu.classList.add('hidden');
            ui.viewBtn.setAttribute('aria-expanded', 'false');
            if (focusButton) ui.viewBtn.focus();
        }

        function choose(i) {
            close(true);
            if (options[i].dataset.cvView !== current.view) setView(options[i].dataset.cvView);
        }

        ui.viewBtn.addEventListener('click', function () {
            if (ui.viewMenu.classList.contains('hidden')) open(); else close(false);
        });
        ui.viewBtn.addEventListener('keydown', function (e) {
            if (e.key === 'ArrowDown' || e.key === 'ArrowUp') { e.preventDefault(); open(); }
        });
        ui.viewMenu.addEventListener('keydown', function (e) {
            if (e.key === 'ArrowDown') { e.preventDefault(); setActive(activeIndex + 1); }
            else if (e.key === 'ArrowUp') { e.preventDefault(); setActive(activeIndex - 1); }
            else if (e.key === 'Home') { e.preventDefault(); setActive(0); }
            else if (e.key === 'End') { e.preventDefault(); setActive(options.length - 1); }
            else if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); choose(activeIndex); }
            else if (e.key === 'Escape') { e.preventDefault(); close(true); }
            else if (e.key === 'Tab') { close(false); }
        });
        options.forEach(function (o, i) {
            o.addEventListener('click', function () { choose(i); });
            o.addEventListener('mousemove', function () { if (activeIndex !== i) setActive(i); });
        });
        document.addEventListener('click', function (e) {
            if (!ui.viewMenu.classList.contains('hidden') && !$('cv-view-picker').contains(e.target)) close(false);
        });
    }

    /* ── Pointer interactions ─────────────────────────────────────────── */

    function bindPointer() {
        var pointers = new Map();
        var drag = null;   // { node } | { pan } | { rotate }
        var downAt = null;
        var pinchDist = 0;

        function local(e) {
            var rect = canvas.getBoundingClientRect();
            return { x: e.clientX - rect.left, y: e.clientY - rect.top };
        }

        canvas.addEventListener('pointerdown', function (e) {
            if (!state) return;
            canvas.setPointerCapture(e.pointerId);
            pointerActive = true;
            var p = local(e);
            pointers.set(e.pointerId, p);
            if (pointers.size === 2) {
                var pts = Array.from(pointers.values());
                pinchDist = Math.hypot(pts[0].x - pts[1].x, pts[0].y - pts[1].y);
                drag = null;
                return;
            }
            downAt = { x: p.x, y: p.y };
            var hit = hitTest(p.x, p.y);
            if (current.layout === 'force' && hit) {
                drag = { node: hit, wasFixed: hit.fixed, hit: hit };
                hit.fixed = true;
            } else if (current.layout === '3d' && !e.shiftKey && e.button !== 1) {
                drag = { rotate: true, last: p, hit: hit };
            } else {
                drag = { pan: true, last: p, hit: hit };
            }
            canvas.classList.add('is-dragging');
        });

        canvas.addEventListener('pointermove', function (e) {
            if (!state) return;
            var p = local(e);
            if (pointers.has(e.pointerId)) pointers.set(e.pointerId, p);

            if (pointers.size === 2) {
                var pts = Array.from(pointers.values());
                var dist = Math.hypot(pts[0].x - pts[1].x, pts[0].y - pts[1].y);
                if (pinchDist > 0) zoomAt(dist / pinchDist, (pts[0].x + pts[1].x) / 2, (pts[0].y + pts[1].y) / 2);
                pinchDist = dist;
                return;
            }

            if (drag && drag.node) {
                var w = toWorld(p.x, p.y);
                drag.node.x = w.x;
                drag.node.y = w.y;
                drag.node.vx = drag.node.vy = 0;
                reheat(0.25);
            } else if (drag && drag.rotate) {
                cancelPendingFit();
                cam.yaw += (p.x - drag.last.x) * 0.006;
                cam.pitch = Math.max(-1.4, Math.min(1.4, cam.pitch + (p.y - drag.last.y) * 0.006));
                drag.last = p;
                requestDraw();
            } else if (drag && drag.pan) {
                cancelPendingFit();
                view.tx += p.x - drag.last.x;
                view.ty += p.y - drag.last.y;
                drag.last = p;
                requestDraw();
            } else {
                var over = hitTest(p.x, p.y);
                if (over !== hovered) {
                    hovered = over;
                    canvas.classList.toggle('is-hover', !!over);
                    canvas.title = over ? (over.isWord ? over.text + ' — ' + fmt(over.count) + ' liens' : (over.page ? over.page.url : over.key)) : '';
                    requestDraw();
                }
            }
        });

        function release(e) {
            pointers.delete(e.pointerId);
            if (pointers.size < 2) pinchDist = 0;
            if (pointers.size === 0) pointerActive = false;
            if (!drag) { requestDraw(); return; }
            var p = local(e);
            var moved = downAt ? Math.hypot(p.x - downAt.x, p.y - downAt.y) : 99;
            if (drag.node) {
                // Le nœud déplacé reste où on l'a posé ; la racine reste fixe.
                drag.node.fixed = drag.wasFixed || moved > 4;
            }
            if (moved <= 4) {
                if (drag.hit) select(drag.hit);
                else { selected = null; hideDetails(); }
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

    function actionButton(attr, label) {
        return '<button type="button" ' + attr + ' class="h-8 px-3 rounded-lg border border-gray-200 text-xs font-medium hover:border-[#00AEEF] hover:text-[#00AEEF]">' + label + '</button>';
    }

    function linkButton(page, text) {
        return '<button type="button" data-cv-page="' + page.id + '" class="text-[#00AEEF] hover:underline break-all text-left">' + escapeHtml(text) + '</button>';
    }

    function closeButton() {
        return '<button type="button" data-cv-close class="flex-shrink-0 w-7 h-7 rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100" aria-label="Fermer">✕</button>';
    }

    /** Ancres les plus fréquentes des liens qui pointent vers une page. */
    function inboundAnchors(page) {
        var counts = new Map();
        state.nodes.forEach(function (source) {
            var texts = source.anchors && source.anchors[page.url];
            if (!Array.isArray(texts)) return;
            texts.forEach(function (t) { counts.set(t, (counts.get(t) || 0) + 1); });
        });
        return Array.from(counts.entries()).sort(function (a, b) { return b[1] - a[1]; });
    }

    function showPageDetails(n, v) {
        var anchors = n.crawled || n.orphan ? inboundAnchors(n).slice(0, 5) : [];
        var html = '<div class="flex items-start justify-between gap-2 mb-2">' +
            '<div class="min-w-0"><p class="font-semibold text-gray-900 break-words">' + escapeHtml(n.title || n.label) + '</p>' +
            '<a href="' + escapeHtml(n.url) + '" target="_blank" rel="noopener noreferrer nofollow" class="text-xs text-[#00AEEF] hover:underline break-all">' + escapeHtml(n.url) + '</a></div>' +
            closeButton() + '</div>' +
            '<div class="mb-2">' + badgeFor(n) + '</div><dl class="text-xs">' +
            row('Raison', n.reason ? escapeHtml(n.reason) : '') +
            row('Statut HTTP', n.status ? String(n.status) : (n.crawled ? '—' : '')) +
            row('Profondeur', n.depth === null ? '' : n.depth + ' clic' + (n.depth > 1 ? 's' : '')) +
            row('Liens entrants', n.orphan ? '0' : fmt(n.inCount)) +
            row('Liens sortants internes', n.crawled ? fmt(n.outCount) : '') +
            row('Liens externes', n.crawled && n.externalLinks ? fmt(n.externalLinks) : '') +
            row('Liens nofollow', n.nofollowLinks ? fmt(n.nofollowLinks) : '') +
            row('Ancres reçues', anchors.length ? anchors.map(function (a) { return '« ' + escapeHtml(a[0]) + ' »' + (a[1] > 1 ? ' ×' + a[1] : ''); }).join('<br>') : '') +
            row('Redirige vers', n.redirectTo ? escapeHtml(n.redirectTo) : '') +
            row('Canonique', n.canonical ? escapeHtml(n.canonical) : '') +
            row('Meta robots', n.metaRobots ? escapeHtml(n.metaRobots) : '') +
            row('H1', n.h1 ? escapeHtml(n.h1) : '') +
            row('Temps de réponse', n.timeMs ? fmt(n.timeMs) + ' ms' : '') +
            row('Taille HTML', n.bytes && window.CodeSommetTools ? window.CodeSommetTools.formatSize(n.bytes) : '') +
            row('Découverte depuis', n.parent ? linkButton(n.parent, n.parent.label) : '') +
            '</dl><div class="flex flex-wrap gap-2 mt-3">' +
            (v ? actionButton('data-cv-center', 'Centrer') : '') +
            (v && v.children.length ? actionButton('data-cv-collapse', (v.collapsed ? 'Déplier la branche' : 'Replier la branche') + ' (' + hiddenDescendants(v) + ')') : '') +
            '</div>';
        openDetails(html, v);
    }

    function showFolderDetails(v) {
        var pages = [];
        var stack = [v];
        while (stack.length && pages.length < 12) {
            var n = stack.shift();
            if (n.page && n !== v) pages.push(n.page);
            n.children.forEach(function (c) { stack.push(c); });
        }
        var html = '<div class="flex items-start justify-between gap-2 mb-2">' +
            '<div class="min-w-0"><p class="font-semibold text-gray-900 break-all">' + escapeHtml(v.key === '/' ? '/' : v.key + '/') + '</p>' +
            '<p class="text-xs text-gray-500">Dossier sans page propre</p></div>' + closeButton() + '</div>' +
            '<dl class="text-xs">' +
            row('Pages dans la branche', fmt(v.pageCount)) +
            row('Sous-éléments directs', fmt(v.children.length)) +
            row('Niveau de dossier', String(v.depth)) +
            '</dl>' +
            (pages.length ? '<p class="text-xs font-semibold text-gray-700 mt-3 mb-1">Pages</p><ul class="text-xs space-y-1">' +
                pages.map(function (p) { return '<li>' + linkButton(p, p.url.replace(/^https?:\/\/[^/]+/, '') || '/') + '</li>'; }).join('') + '</ul>' : '') +
            '<div class="flex flex-wrap gap-2 mt-3">' + actionButton('data-cv-center', 'Centrer') +
            (v.children.length ? actionButton('data-cv-collapse', (v.collapsed ? 'Déplier' : 'Replier') + ' (' + hiddenDescendants(v) + ')') : '') +
            '</div>';
        openDetails(html, v);
    }

    function showWordDetails(w) {
        var targets = Array.from(w.targets.entries()).sort(function (a, b) { return b[1] - a[1]; }).slice(0, 12);
        var anchors = Array.from(w.anchors.entries()).sort(function (a, b) { return b[1] - a[1]; }).slice(0, 5);
        var html = '<div class="flex items-start justify-between gap-2 mb-2">' +
            '<div class="min-w-0"><p class="font-semibold text-gray-900 break-words">« ' + escapeHtml(w.text) + ' »</p>' +
            '<p class="text-xs text-gray-500">Texte d\'ancre de liens internes</p></div>' + closeButton() + '</div>' +
            '<dl class="text-xs">' +
            row('Liens qui l\'utilisent', fmt(w.count)) +
            row('Pages sources', fmt(w.sources.size)) +
            row('Pages ciblées', fmt(w.targets.size)) +
            row('Ancres complètes', anchors.map(function (a) { return '« ' + escapeHtml(a[0]) + ' »' + (a[1] > 1 ? ' ×' + a[1] : ''); }).join('<br>')) +
            '</dl>' +
            (targets.length ? '<p class="text-xs font-semibold text-gray-700 mt-3 mb-1">Pages ciblées</p><ul class="text-xs space-y-1">' +
                targets.map(function (t) {
                    return '<li class="flex justify-between gap-2">' + linkButton(t[0], t[0].url.replace(/^https?:\/\/[^/]+/, '') || '/') +
                        '<span class="text-gray-500 flex-shrink-0">×' + t[1] + '</span></li>';
                }).join('') + '</ul>' : '') +
            (w.targets.size > 1 && !toggles.phrases ? '<p class="text-xs text-gray-500 mt-3">Un même mot d\'ancre vers plusieurs pages peut brouiller le sujet de chacune : variez les ancres selon la page ciblée.</p>' : '');
        openDetails(html, null);
    }

    function openDetails(html, v) {
        ui.details.innerHTML = html;
        ui.details.classList.remove('hidden');
        ui.details.querySelector('[data-cv-close]').addEventListener('click', function () { selected = null; hideDetails(); requestDraw(); });
        var center = ui.details.querySelector('[data-cv-center]');
        if (center && v) center.addEventListener('click', function () { centerOn(v); });
        var collapse = ui.details.querySelector('[data-cv-collapse]');
        if (collapse && v) collapse.addEventListener('click', function () { toggleCollapse(v); });
        ui.details.querySelectorAll('[data-cv-page]').forEach(function (btn) {
            btn.addEventListener('click', function () { selectPage(state.nodes[parseInt(btn.dataset.cvPage, 10)]); });
        });
    }

    function showVertexDetails(v) {
        if (v.page) showPageDetails(v.page, v); else showFolderDetails(v);
    }

    function hideDetails() {
        if (ui.details) { ui.details.classList.add('hidden'); ui.details.innerHTML = ''; }
    }

    function select(target) {
        selected = target;
        if (target.isWord) showWordDetails(target); else showVertexDetails(target);
        requestDraw();
    }

    /** Sélectionne une page dans la vue courante (ou la vue d'exploration). */
    function selectPage(page) {
        if (!page) return;
        if (current.layout === 'cloud') setView('crawl-force', { keepCamera: true });
        var v = graph().vOfPage.get(page);
        if (!v) return;
        revealVertex(v);
        select(v);
        setTimeout(function () { centerOn(v); }, current.layout === 'tree' ? 250 : 0);
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
                inbound_anchors: inboundAnchors(n).slice(0, 5).map(function (a) { return a[0]; }).join(' | '),
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
        if (!cloud.words.length) buildCloud();
        var data = {
            tool: 'CodeSommet — Visualiseur d\'exploration',
            root: state.root,
            crawledAt: state.startedAt.toISOString(),
            settings: state.settings,
            truncated: state.truncated,
            sitemapChecked: state.sitemapChecked,
            stats: computeStats(),
            pages: exportRows(),
            links: state.edges.map(function (e) {
                var texts = e.s.anchors && e.s.anchors[e.t.url];
                return { from: e.s.url, to: e.t.url, anchors: Array.isArray(texts) ? texts : [] };
            }),
            anchorWords: cloud.words.map(function (w) { return { word: w.text, links: w.count, targets: w.targets.size }; })
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
            a.download = fileBase() + '-' + current.view + '.png';
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
            hint: $('cv-hint'),
            viewBtn: $('cv-view-btn'),
            viewMenu: $('cv-view-menu'),
            viewCurrent: $('cv-view-current'),
            viewIcon: $('cv-view-icon'),
            tableBody: $('cv-table-body'),
            tableFilter: $('cv-table-filter')
        };
        ui.search.dataset.placeholder = ui.search.placeholder;

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
                if (key === 'phrases' && state) {
                    selected = null;
                    hideDetails();
                    buildCloud();
                    scheduleFit();
                }
                requestDraw();
            });
        });

        ui.filter.addEventListener('change', function () { refreshFilter(); requestDraw(); });
        ui.limit.addEventListener('change', function () {
            relayout(0.3);
            scheduleFit();
        });

        ui.search.addEventListener('input', debounce(function () { refreshSearch(); requestDraw(); }, 200));
        ui.search.addEventListener('keydown', function (e) {
            if (e.key !== 'Enter') return;
            e.preventDefault();
            var first = searchMatches.values().next().value;
            if (!first) return;
            if (first.isWord) { select(first); return; }
            revealVertex(first);
            select(first);
            centerOn(first);
        });

        ui.tableFilter.addEventListener('input', debounce(renderTable, 200));
        ui.tableBody.addEventListener('click', function (e) {
            var tr = e.target.closest('[data-cv-row]');
            if (!tr || !state) return;
            selectPage(state.nodes[parseInt(tr.dataset.cvRow, 10)]);
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

        bindViewPicker();
        bindPointer();
        if (window.ResizeObserver) {
            new ResizeObserver(resizeCanvas).observe(ui.stage);
        } else {
            window.addEventListener('resize', resizeCanvas);
        }
        document.addEventListener('fullscreenchange', function () { setTimeout(resizeCanvas, 50); });
        document.addEventListener('visibilitychange', requestDraw);
        resizeCanvas();

        var saved = storageGet(STORAGE_KEY);
        setView(saved && VIEWS[saved] ? saved : DEFAULT_VIEW, { keepCamera: true });
    });
})();
