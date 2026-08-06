/**
 * API-Dependent Tools - Shared JavaScript
 * Tools that need server-side URL fetching via /api/tools/{slug} proxy
 * Each tool: website-analyzer, heading-analyzer, keyword-density, broken-link,
 * redirect, backlink, ssl, mobile-friendly, core-web-vitals, domain-authority,
 * domain-health, canonical, image-alt, image-compression, internal-link,
 * page-speed, robots-validator, sitemap-validator, website-readiness,
 * og-preview-generator
 */
(function () {
    'use strict';

    // Map tool slugs to their configurations
    var TOOL_CONFIG = {
        'website-analyzer': { title: 'Website Analyzer', action: 'Analyze Website', actionText: 'sites analysés', inputLabel: 'URL du site', inputPlaceholder: 'https://example.com' },
        'heading-analyzer': { title: 'Heading Analyzer', action: 'Analyze Headings', actionText: 'pages analysées', inputLabel: 'URL du site', inputPlaceholder: 'https://example.com' },
        'keyword-density-analyzer': { title: 'Keyword Density', action: 'Analyze Keywords', actionText: 'pages analysées', inputLabel: 'URL du site', inputPlaceholder: 'https://example.com' },
        'broken-link-checker': { title: 'Broken Link Checker', action: 'Check Links', actionText: 'pages scannées', inputLabel: 'URL du site', inputPlaceholder: 'https://example.com' },
        'redirect-checker': { title: 'Redirect Checker', action: 'Check Redirects', actionText: 'URL vérifiées', inputLabel: 'URL à vérifier', inputPlaceholder: 'https://example.com/old-page' },
        'backlink-checker': { title: 'Backlink Checker', action: 'Check Backlinks', actionText: 'domaines analysés', inputLabel: 'Domaine', inputPlaceholder: 'example.com' },
        'ssl-certificate-checker': { title: 'SSL Checker', action: 'Check SSL', actionText: 'certificats vérifiés', inputLabel: 'Domaine', inputPlaceholder: 'example.com' },
        'mobile-friendly-test': { title: 'Mobile Friendly', action: 'Test Mobile', actionText: 'pages testées', inputLabel: 'URL du site', inputPlaceholder: 'https://example.com' },
        'core-web-vitals-checker': { title: 'Core Web Vitals', action: 'Check Vitals', actionText: 'pages analysées', inputLabel: 'URL du site', inputPlaceholder: 'https://example.com' },
        'domain-authority-checker': { title: 'Domain Authority', action: 'Check Authority', actionText: 'domaines vérifiés', inputLabel: 'Domaine', inputPlaceholder: 'example.com' },
        'domain-health-checker': { title: 'Domain Health', action: 'Check Health', actionText: 'domaines vérifiés', inputLabel: 'Domaine', inputPlaceholder: 'example.com' },
        'canonical-checker': { title: 'Canonical Checker', action: 'Check Canonical', actionText: 'pages vérifiées', inputLabel: 'URL de la page', inputPlaceholder: 'https://example.com/page' },
        'image-alt-analyzer': { title: 'Image Alt Analyzer', action: 'Analyze Images', actionText: 'pages scannées', inputLabel: 'URL du site', inputPlaceholder: 'https://example.com' },
        'image-compression-analyzer': { title: 'Image Compression', action: 'Analyze Images', actionText: 'pages analysées', inputLabel: 'URL du site', inputPlaceholder: 'https://example.com' },
        'internal-link-analyzer': { title: 'Internal Links', action: 'Analyze Links', actionText: 'pages analysées', inputLabel: 'URL du site', inputPlaceholder: 'https://example.com' },
        'page-speed-analyzer': { title: 'Page Speed', action: 'Analyze Speed', actionText: 'pages analysées', inputLabel: 'URL du site', inputPlaceholder: 'https://example.com' },
        'robots-validator': { title: 'Robots Validator', action: 'Validate', actionText: 'fichiers validés', inputLabel: 'URL du site', inputPlaceholder: 'https://example.com' },
        'sitemap-validator': { title: 'Sitemap Validator', action: 'Validate', actionText: 'sitemaps validés', inputLabel: 'URL du sitemap', inputPlaceholder: 'https://example.com/sitemap.xml' },
        'website-readiness-checker': { title: 'Website Readiness', action: 'Check Readiness', actionText: 'sites vérifiés', inputLabel: 'URL du site', inputPlaceholder: 'https://example.com' },
        'og-preview-generator': { title: 'OG Preview', action: 'Preview', actionText: 'aperçus générés', inputLabel: 'URL du site', inputPlaceholder: 'https://example.com' }
    };

    CodeSommetTools.onReady(function () {
        // Detect which tool page we're on
        var slug = detectToolSlug();
        if (!slug || !TOOL_CONFIG[slug]) return;

        var config = TOOL_CONFIG[slug];
        var toolSection = document.querySelector('section.max-w-5xl');
        if (!toolSection) return;

        var actionBtn = toolSection.querySelector('button[class*="bg-gradient"], button.w-full');
        var urlInput = toolSection.querySelector('input[type="url"], input[type="text"]');
        if (!actionBtn) return;
        actionBtn.id = 'tool-action-btn';

        actionBtn.addEventListener('click', function () {
            CodeSommetTools.hideError();
            var url = urlInput ? urlInput.value.trim() : '';
            if (!url) { CodeSommetTools.showError('Veuillez saisir : ' + config.inputLabel); return; }

            if (!url.startsWith('http://') && !url.startsWith('https://') && !slug.includes('domain') && !slug.includes('backlink') && !slug.includes('ssl')) {
                url = 'https://' + url;
            }

            CodeSommetTools.setLoading(true);

            fetch('/api/tools/' + slug, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getCSRFToken(), 'Accept': 'application/json' },
                body: JSON.stringify({ url: url, domain: url.replace(/^https?:\/\//, '').replace(/\/.*$/, '') })
            })
            .then(function (res) {
                return res.text().then(function (text) {
                    var json = parseJsonSafe(text);
                    if (!res.ok) throw new Error(json.error || json.message || 'L\'analyse a échoué');
                    return json;
                });
            })
            .then(function (data) {
                CodeSommetTools.setLoading(false);
                CodeSommetTools.incrementUsage(slug);
                showGenericResult(data, slug, config);
            })
            .catch(function (err) {
                CodeSommetTools.setLoading(false);
                CodeSommetTools.showError(err.message || 'Analyse impossible. Vérifiez l\'URL et réessayez.');
            });
        });

        // Enter key on input
        if (urlInput) {
            urlInput.addEventListener('keydown', function (e) {
                if (e.key === 'Enter') { e.preventDefault(); actionBtn.click(); }
            });
        }

        CodeSommetTools.initUsageCounter(slug, config.actionText);
    });

    function detectToolSlug() {
        var path = window.location.pathname;
        var match = path.match(/\/tools\/([a-z0-9-]+)/);
        if (match) return match[1];
        // Fallback: check page title
        var title = document.title.toLowerCase();
        var slugs = Object.keys(TOOL_CONFIG);
        for (var i = 0; i < slugs.length; i++) {
            var words = slugs[i].replace(/-/g, ' ');
            if (title.includes(words) || title.includes(slugs[i])) return slugs[i];
        }
        return null;
    }

    function getCSRFToken() {
        var meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    /* ── Rendu du tableau de bord d'analyse ────────────────────────────────
     * Les résultats se fondaient dans la page : l'utilisateur ne distinguait
     * pas l'analyse de son site du contenu éditorial statique. Ils sont
     * désormais encadrés dans un conteneur propre — fond sombre, élévation,
     * en-tête dédié — pour qu'on comprenne au premier coup d'œil : « ceci est
     * l'analyse de MON site ».
     *
     * L'identité visuelle du site reste inchangée : seule la zone de résultats
     * est retravaillée.
     */
    function showGenericResult(data, slug, config) {
        var existing = document.getElementById('tool-results');
        if (existing) existing.remove();

        var score = (typeof data.score === 'number') ? data.score : (data.passed ? 100 : null);
        var grade = data.grade || (score === null ? null : gradeFor(score));

        var html = '<div id="tool-results" class="csr" role="region" aria-live="polite" ' +
            'aria-label="Résultats de l\'analyse">';

        // ── En-tête : sépare visuellement l'analyse du contenu statique ──
        html += renderResultsHeader(data, config);

        // Corps sur fond clair, décalé du reste de la page.
        html += '<div class="csr-body">';

        // ── Score, note, statut, confiance ──────────────────────────────
        if (score !== null) {
            html += renderScorePanel(score, grade, data);
        }

        // ── Avertissement de portée (page rendue côté client, etc.) ─────
        if (data.limitation) {
            html += '<div class="csr-scope">' +
                icon('info', 'csr-ico') +
                '<div><p class="csr-scope-t">Portée de l\'analyse</p>' +
                '<p class="csr-scope-m">' + escapeHtml(data.limitation) + '</p></div></div>';
        }

        // ── Statistiques ────────────────────────────────────────────────
        if (data.stats) html += renderStatCards(data.stats);

        // ── Problèmes groupés par sévérité ──────────────────────────────
        var buckets = groupIssues(data);
        if (buckets.total > 0) html += renderIssueGroups(buckets);

        // ── Contrôles réussis / échoués ─────────────────────────────────
        if (data.checks && data.checks.length) html += renderChecks(data.checks);

        // ── Recommandations ─────────────────────────────────────────────
        if (data.recommendations && data.recommendations.length > 0) {
            html += '<section class="csr-card">' +
                '<h3 class="csr-card-title">' +
                icon('lightbulb', 'csr-ico-b') + 'Recommandations</h3>' +
                '<div class="space-y-3">';
            data.recommendations.forEach(function (rec) {
                html += (typeof rec === 'string') ? renderSimpleRec(rec) : renderStructuredRec(rec);
            });
            html += '</div></section>';
        }

        // ── Données propres à l'outil ───────────────────────────────────
        if (data.ogData) html += renderOgPreview(data.ogData);
        if (data.images && data.images.length > 0) html += renderImagesTable(data.images);
        if (data.links && data.links.length > 0) html += renderLinksTable(data.links);
        if (data.headings && data.headings.length > 0) html += renderHeadingsTree(data.headings);
        if (data.redirectChain && data.redirectChain.length > 0) html += renderRedirectChain(data.redirectChain);

        // Repli : réponse au format inattendu.
        if (!data.stats && !data.issues && !data.warnings && score === null && !data.recommendations) {
            html += '<section class="csr-card">' +
                '<h3 class="csr-card-title">Données brutes</h3>' +
                '<div class="csr-raw">' +
                '<pre >' +
                escapeHtml(JSON.stringify(data, null, 2)) + '</pre></div></section>';
        }

        html += '</div></div>';

        var actionBtn = document.getElementById('tool-action-btn');
        var insertTarget = actionBtn ? actionBtn.closest('.space-y-4') || actionBtn.parentElement : null;
        if (!insertTarget) insertTarget = document.querySelector('section.max-w-5xl .space-y-6');
        if (insertTarget) {
            insertTarget.insertAdjacentHTML('afterend', html);
            var el = document.getElementById('tool-results');
            if (el) {
                el.scrollIntoView({ behavior: 'smooth', block: 'start' });
                // Cible focalisable : l'utilisateur au clavier arrive
                // directement sur les résultats après le scan.
                el.setAttribute('tabindex', '-1');
                el.focus({ preventScroll: true });
            }
        }
    }

    /* En-tête sombre : rupture visuelle nette avec le contenu éditorial. */
    function renderResultsHeader(data, config) {
        var url = data.analyzedUrl || '';
        var when = data.analyzedAt ? formatWhen(data.analyzedAt) : '';

        var h = '<div class="csr-head">' +
            '<div class="csr-head-row">' +
            '<div class="min-w-0">' +
            '<div class="csr-live">' +
            '<span class="csr-dot" aria-hidden="true">' +
            '<span class="csr-dot-ping"></span>' +
            '<span class="csr-dot-core"></span></span>' +
            '<p class="csr-live-label">Analyse en direct</p></div>' +
            '<h2 class="csr-title">Résultats' +
            (config && config.title ? ' — ' + escapeHtml(config.title) : '') + '</h2>';

        if (url) {
            h += '<p class="csr-url">' + escapeHtml(url) + '</p>';
        }

        h += '</div><div class="csr-chips">';
        if (when) h += metaChip(icon('clock', 'csr-ico-s'), when);
        if (typeof data.executionTimeMs === 'number') {
            h += metaChip(icon('bolt', 'csr-ico-s'), data.executionTimeMs + ' ms');
        }
        if (data.fromCache === true) h += metaChip(icon('database', 'csr-ico-s'), 'Depuis le cache');
        h += '</div></div></div>';

        return h;
    }

    function metaChip(iconHtml, label) {
        return '<span class="csr-chip">' +
            iconHtml + escapeHtml(label) + '</span>';
    }

    /* Score global : jauge, note, statut, confiance. */
    /* Score global : anneau de progression, note, statut, confiance. */
    function renderScorePanel(score, grade, data) {
        var tone = score >= 80 ? 'emerald' : score >= 50 ? 'amber' : 'red';
        var label = data.message || (data.passed ? 'Analyse réussie' : 'Problèmes détectés');

        var r = 42, c = 2 * Math.PI * r;
        var off = c - (Math.max(0, Math.min(100, score)) / 100) * c;

        var h = '<section class="csr-card"><div class="csr-score">' +
            '<div class="csr-ring" role="img" aria-label="Score global : ' + score + ' sur 100">' +
            '<svg viewBox="0 0 100 100">' +
            '<circle class="csr-ring-track" cx="50" cy="50" r="' + r + '" fill="none" stroke="currentColor" stroke-width="8"/>' +
            '<circle class="csr-ring-value csr-stroke-' + tone + '" cx="50" cy="50" r="' + r + '" fill="none" ' +
            'stroke="currentColor" stroke-width="8" stroke-linecap="round" stroke-dasharray="' + c.toFixed(1) + '" ' +
            'stroke-dashoffset="' + off.toFixed(1) + '"/></svg>' +
            '<div class="csr-ring-center"><div class="csr-ring-num">' + score + '</div>' +
            '<div class="csr-ring-sub">sur 100</div></div></div>';

        h += '<div><p class="csr-score-label">' + escapeHtml(label) + '</p><div class="csr-badges">';
        if (grade) h += badge('Note ' + grade, tone);
        h += badge(data.passed === false ? 'Échec' : 'Conforme', data.passed === false ? 'red' : 'emerald');
        if (typeof data.confidence === 'number') {
            h += badge('Confiance ' + data.confidence + ' %', data.confidence >= 80 ? 'slate' : 'amber');
        }
        h += '</div>';
        if (data.scoringMethod) h += '<p class="csr-note">' + escapeHtml(data.scoringMethod) + '</p>';

        return h + '</div></div></section>';
    }

    function badge(text, tone) {
        return '<span class="csr-badge csr-t-' + tone + '">' + escapeHtml(text) + '</span>';
    }

    /* Cartes de statistiques responsives. */
    function renderStatCards(stats) {
        var entries = Object.entries(stats).filter(function (e) {
            return e[1] !== null && e[1] !== undefined && e[1] !== '';
        });
        if (!entries.length) return '';

        var h = '<section><h3 class="csr-sr">Statistiques</h3><div class="csr-stats">';
        entries.forEach(function (e) {
            var v = (typeof e[1] === 'object') ? JSON.stringify(e[1]) : String(e[1]);
            h += '<div class="csr-stat"><div class="csr-stat-v">' + escapeHtml(v) + '</div>' +
                '<div class="csr-stat-l">' + escapeHtml(formatLabel(e[0])) + '</div></div>';
        });
        return h + '</div></section>';
    }

    /* Regroupe problèmes, avertissements et recommandations par sévérité. */
    function groupIssues(data) {
        var b = { critical: [], high: [], medium: [], low: [], total: 0 };

        (data.issues || []).forEach(function (i) {
            var t = i.type || i.severity || 'warning';
            var bucket = (t === 'error' || t === 'critical') ? 'critical' : (t === 'warning' ? 'medium' : 'low');
            b[bucket].push(i.message || String(i));
            b.total++;
        });

        (data.warnings || []).forEach(function (w) {
            b.medium.push(typeof w === 'string' ? w : (w.message || JSON.stringify(w)));
            b.total++;
        });

        // Les recommandations structurées portent déjà une priorité : on la
        // reprend telle quelle plutôt que d'en déduire une approximative.
        (data.recommendations || []).forEach(function (r) {
            if (typeof r === 'string' || !r.priority) return;
            if (r.priority === 'critical' && r.issue) { b.critical.push(r.issue); b.total++; }
            else if (r.priority === 'high' && r.issue) { b.high.push(r.issue); b.total++; }
        });

        // Déduplique : un même défaut apparaît souvent dans issues ET dans
        // recommendations.
        ['critical', 'high', 'medium', 'low'].forEach(function (k) {
            var seen = {};
            b[k] = b[k].filter(function (m) {
                if (seen[m]) return false;
                seen[m] = true;
                return true;
            });
        });
        b.total = b.critical.length + b.high.length + b.medium.length + b.low.length;

        return b;
    }

    function renderIssueGroups(b) {
        var groups = [
            { key: 'critical', label: 'Critique',  tone: 'red',    icon: 'alert' },
            { key: 'high',     label: 'Important', tone: 'orange', icon: 'alert' },
            { key: 'medium',   label: 'Moyen',     tone: 'amber',  icon: 'warning' },
            { key: 'low',      label: 'Mineur',    tone: 'sky',    icon: 'info' }
        ];

        var h = '<section class="csr-card">' +
            '<h3 class="csr-card-title">' + icon('alert', 'csr-ico-r') +
            'Problèmes détectés <span class="csr-group-count">' + b.total + '</span></h3><div>';

        groups.forEach(function (g) {
            var items = b[g.key];
            if (!items.length) return;

            // <details> natif : pliable au clavier, sans JavaScript.
            h += '<details class="csr-group csr-g-' + g.tone + '" open>' +
                '<summary><span style="display:flex;align-items:center;gap:.5rem">' +
                icon(g.icon, 'csr-ico-s') + escapeHtml(g.label) +
                '<span class="csr-group-count">' + items.length + '</span></span>' +
                icon('chevron', 'csr-ico-s csr-chevron') + '</summary><ul>';

            items.forEach(function (m) {
                h += '<li><span class="csr-bullet" aria-hidden="true"></span>' + escapeHtml(m) + '</li>';
            });

            h += '</ul></details>';
        });

        return h + '</div></section>';
    }

    /* Contrôles réussis et à corriger, présentés séparément. */
    function renderChecks(checks) {
        var passed = checks.filter(function (c) { return c.status === 'pass'; });
        var failed = checks.filter(function (c) { return c.status !== 'pass'; });

        return '<section class="csr-checks">' +
            checkColumn('Contrôles réussis', passed, 'emerald', 'check') +
            checkColumn('À corriger', failed, 'red', 'x') + '</section>';
    }

    function checkColumn(title, items, tone, iconName) {
        var h = '<div class="csr-card"><h3 class="csr-card-title">' +
            icon(iconName, 'csr-ico-' + (tone === 'emerald' ? 'g' : 'r')) + escapeHtml(title) +
            '<span class="csr-badge csr-t-' + tone + '">' + items.length + '</span></h3>';

        if (!items.length) {
            h += '<p class="csr-empty">Aucun</p>';
        } else {
            h += '<ul class="csr-check-list">';
            items.slice(0, 12).forEach(function (c) {
                // Points forcés en nombres avant interpolation : ils viennent
                // du serveur, mais le rendu ne doit dépendre d'aucune
                // hypothèse sur la charge utile reçue.
                var pts = (Number(c.max) > 0)
                    ? ' <span class="csr-check-pts">(' + Number(c.points) + '/' + Number(c.max) + ')</span>'
                    : '';
                h += '<li><span class="csr-bullet csr-t-' + tone + '" aria-hidden="true"></span>' +
                    '<span><span class="csr-check-name">' + escapeHtml(c.name) + '</span>' + pts +
                    '<br><span class="csr-check-msg">' + escapeHtml(c.message) + '</span></span></li>';
            });
            if (items.length > 12) h += '<li class="csr-empty">+ ' + (items.length - 12) + ' autre(s)</li>';
            h += '</ul>';
        }

        return h + '</div>';
    }

    function gradeFor(score) {
        if (score >= 90) return 'A';
        if (score >= 80) return 'B';
        if (score >= 60) return 'C';
        if (score >= 40) return 'D';
        return 'F';
    }

    function formatWhen(iso) {
        try {
            var d = new Date(iso);
            if (isNaN(d.getTime())) return '';
            return d.toLocaleString('fr-FR', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' });
        } catch (e) { return ''; }
    }

    /* Petits pictogrammes inline, marqués aria-hidden : purement décoratifs. */
    function icon(name, cls) {
        var paths = {
            check: '<path d="M20 6 9 17l-5-5"/>',
            x: '<path d="M18 6 6 18M6 6l12 12"/>',
            alert: '<path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><path d="M12 9v4"/><path d="M12 17h.01"/>',
            warning: '<circle cx="12" cy="12" r="10"/><path d="M12 8v4"/><path d="M12 16h.01"/>',
            info: '<circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/>',
            clock: '<circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>',
            bolt: '<path d="M13 2 3 14h9l-1 8 10-12h-9l1-8Z"/>',
            database: '<ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M3 5v14a9 3 0 0 0 18 0V5"/>',
            lightbulb: '<path d="M9 18h6"/><path d="M10 22h4"/><path d="M12 2a7 7 0 0 0-4 12.7V17h8v-2.3A7 7 0 0 0 12 2Z"/>',
            chevron: '<path d="m6 9 6 6 6-6"/>'
        };
        return '<svg class="' + cls + '" viewBox="0 0 24 24" fill="none" stroke="currentColor" ' +
            'stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' +
            (paths[name] || '') + '</svg>';
    }

    /* Recommandation structurée : l'essentiel visible, le détail replié. */
    function renderStructuredRec(rec) {
        var tones = { critical: 'red', high: 'orange', medium: 'amber', low: 'sky' };
        var labels = { critical: 'Critique', high: 'Important', medium: 'Moyen', low: 'Mineur' };
        var tone = tones[rec.priority] || 'amber';

        var h = '<div class="csr-rec csr-g-' + tone + '">' +
            '<div class="csr-rec-head">' +
            '<span class="csr-rec-prio">' + escapeHtml(labels[rec.priority] || 'Moyen') + '</span>' +
            '<span class="csr-rec-title">' + escapeHtml(rec.title || rec.check || '') + '</span>';
        if (rec.difficulty) {
            h += '<span class="csr-rec-diff">difficulté : ' + escapeHtml(rec.difficulty) + '</span>';
        }
        h += '</div>';

        if (rec.issue)  h += '<p>' + escapeHtml(rec.issue) + '</p>';
        if (rec.why)    h += '<p><strong>Pourquoi :</strong> ' + escapeHtml(rec.why) + '</p>';
        if (rec.impact) h += '<p><strong>Impact SEO :</strong> ' + escapeHtml(rec.impact) + '</p>';
        if (rec.fix)    h += '<p><strong>Correction :</strong> ' + escapeHtml(rec.fix) + '</p>';

        if (rec.goodExample || rec.badExample) {
            h += '<details><summary>Voir un exemple</summary><div>';
            if (rec.badExample) {
                h += '<div class="csr-ex-l-bad">À éviter</div>' +
                    '<pre class="csr-ex-bad"><code>' + escapeHtml(rec.badExample) + '</code></pre>';
            }
            if (rec.goodExample) {
                h += '<div class="csr-ex-l-good">Recommandé</div>' +
                    '<pre class="csr-ex-good"><code>' + escapeHtml(rec.goodExample) + '</code></pre>';
            }
            h += '</div></details>';
        }

        // rel="noopener" : sans lui, la page ouverte conserve une référence
        // window.opener vers la nôtre et peut la rediriger (tabnabbing).
        if (rec.docs) {
            h += '<a class="csr-docs" href="' + escapeHtml(rec.docs) + '" target="_blank" rel="noopener noreferrer">' +
                'Documentation officielle →</a>';
        }

        return h + '</div>';
    }

    /* Recommandation historique : une simple chaîne. */
    function renderSimpleRec(text) {
        return '<div class="csr-rec csr-g-sky"><p>' + escapeHtml(text) + '</p></div>';
    }

    function renderOgPreview(og) {
        var html = '<div class="bg-white rounded-xl border border-gray-100 p-6">' +
            '<h3 class="text-lg font-bold text-black mb-4">Aperçu Open Graph</h3>';
        // Social card preview
        html += '<div class="max-w-lg mx-auto border border-gray-200 rounded-xl overflow-hidden mb-6">';
        if (og.image) {
            html += '<div class="aspect-[1.91/1] bg-gray-100"><img src="' + escapeHtml(og.image) + '" class="w-full h-full object-cover" onerror="this.parentElement.innerHTML=\'<div class=\\\'flex items-center justify-center h-full text-gray-400 text-sm\\\'>Aucun aperçu d’image</div>\'" /></div>';
        } else {
            html += '<div class="aspect-[1.91/1] bg-gray-100 flex items-center justify-center text-gray-400 text-sm">No og:image set</div>';
        }
        html += '<div class="p-4 bg-[#F8F8F8]">' +
            '<p class="text-xs text-gray-500 uppercase mb-1">' + escapeHtml(og.siteName || og.url || '') + '</p>' +
            '<p class="font-bold text-sm text-black mb-1">' + escapeHtml(og.title || 'No title') + '</p>' +
            '<p class="text-xs text-gray-600 line-clamp-2">' + escapeHtml(og.description || 'No description') + '</p>' +
            '</div></div>';
        // Warnings
        if (og.warnings && og.warnings.length > 0) {
            html += '<div class="space-y-2">';
            og.warnings.forEach(function (w) {
                html += '<div class="flex items-start gap-2 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">' +
                    '<svg class="w-4 h-4 text-yellow-600 mt-0.5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>' +
                    '<span class="text-sm text-yellow-800">' + escapeHtml(w) + '</span></div>';
            });
            html += '</div>';
        }
        // Meta tags table
        html += '<div class="mt-4"><table class="w-full text-sm"><tbody>';
        var fields = [['og:title', og.title], ['og:description', og.description], ['og:image', og.image], ['og:type', og.type], ['og:site_name', og.siteName], ['og:url', og.url], ['twitter:image', og.twitterImage]];
        fields.forEach(function (f) {
            var val = f[1] || '';
            var color = val ? 'green' : 'red';
            html += '<tr class="border-b border-gray-100"><td class="py-2 px-2 font-mono text-xs text-gray-500">' + f[0] + '</td>' +
                '<td class="py-2 px-2 text-xs break-all">' + (val ? escapeHtml(val) : '<span class="text-red-500 italic">Missing</span>') + '</td>' +
                '<td class="py-2 px-2"><span class="w-2 h-2 rounded-full inline-block bg-' + color + '-500"></span></td></tr>';
        });
        html += '</tbody></table></div></div>';
        return html;
    }

    function renderImagesTable(images) {
        var html = '<div class="bg-white rounded-xl border border-gray-100 p-6 overflow-x-auto">' +
            '<h3 class="text-lg font-bold text-black mb-4">Images (' + images.length + ')</h3>' +
            '<table class="w-full text-sm"><thead><tr class="border-b border-gray-200">' +
            '<th class="text-left py-2 px-2 w-8">#</th>' +
            '<th class="text-left py-2 px-2">URL de l’image</th>' +
            '<th class="text-left py-2 px-2">Texte alternatif</th>' +
            '<th class="text-left py-2 px-2 w-24">Status</th></tr></thead><tbody>';
        images.forEach(function (img, i) {
            var statusColor = img.status === 'good' ? 'green' : img.status === 'empty' ? 'yellow' : 'red';
            var statusLabel = img.status === 'good' ? 'Good' : img.status === 'empty' ? 'Empty' : 'Missing';
            var altDisplay = img.status === 'good' ? escapeHtml(img.alt || '') :
                img.status === 'empty' ? '<span class="text-yellow-600 italic">alt=""</span>' :
                '<span class="text-red-600 italic">Attribut alt absent</span>';
            var urlDisplay = img.url ? escapeHtml(img.url) : '<span class="text-gray-400 italic">Attribut src absent</span>';
            html += '<tr class="border-b border-gray-100 hover:bg-gray-50">' +
                '<td class="py-2 px-2 text-gray-400 text-xs">' + (i + 1) + '</td>' +
                '<td class="py-2 px-2 font-mono text-xs break-all max-w-[350px]">' + urlDisplay + '</td>' +
                '<td class="py-2 px-2 text-xs max-w-[250px]">' + altDisplay + '</td>' +
                '<td class="py-2 px-2"><span class="px-2 py-0.5 rounded-full text-xs font-medium bg-' + statusColor + '-50 text-' + statusColor + '-700">' + statusLabel + '</span></td></tr>';
        });
        html += '</tbody></table></div>';
        return html;
    }

    function renderLinksTable(links) {
        var html = '<div class="bg-white rounded-xl border border-gray-100 p-6 overflow-x-auto">' +
            '<h3 class="text-lg font-bold text-black mb-4">Links (' + links.length + ')</h3>' +
            '<table class="w-full text-sm"><thead><tr class="border-b border-gray-200">' +
            '<th class="text-left py-2 px-2">URL</th><th class="text-left py-2 px-2">Status</th><th class="text-left py-2 px-2">Type</th></tr></thead><tbody>';
        links.slice(0, 50).forEach(function (link) {
            var s = (link.status || '').toLowerCase();
            var statusColor = (s === 'working' || s === 'good' || s === 'pass' || s === 'valid') ? 'green' : (s === 'redirect' || s === 'warning' || s === 'empty') ? 'yellow' : 'red';
            html += '<tr class="border-b border-gray-100">' +
                '<td class="py-2 px-2 font-mono text-xs break-all max-w-[300px]">' + escapeHtml(link.url || '') + '</td>' +
                '<td class="py-2 px-2"><span class="px-2 py-0.5 rounded-full text-xs font-medium bg-' + statusColor + '-50 text-' + statusColor + '-700">' + escapeHtml(link.status || link.statusCode || '') + '</span></td>' +
                '<td class="py-2 px-2 text-xs">' + escapeHtml(link.type || '') + '</td></tr>';
        });
        html += '</tbody></table></div>';
        return html;
    }

    function renderHeadingsTree(headings) {
        var html = '<div class="bg-white rounded-xl border border-gray-100 p-6">' +
            '<h3 class="text-lg font-bold text-black mb-4">Structure des titres</h3><div class="space-y-2">';
        headings.forEach(function (h) {
            // `level` vient de la réponse serveur : le ramener à un entier 1-6
            // avant de l'injecter, plutôt que de faire confiance à sa forme.
            var level = Math.min(6, Math.max(1, parseInt(h.level, 10) || 1));
            var indent = (level - 1) * 1.5;
            var color = level === 1 ? '#00AEEF' : level === 2 ? '#0F0F0F' : '#666';
            html += '<div style="padding-left:' + indent + 'rem" class="flex items-center gap-2">' +
                '<span class="px-2 py-0.5 rounded bg-gray-100 text-xs font-bold" style="color:' + color + '">H' + level + '</span>' +
                '<span class="text-sm text-gray-800">' + escapeHtml(h.text || '') + '</span></div>';
        });
        html += '</div></div>';
        return html;
    }

    function renderRedirectChain(chain) {
        var html = '<div class="bg-white rounded-xl border border-gray-100 p-6">' +
            '<h3 class="text-lg font-bold text-black mb-4">Chaîne de redirection</h3><div class="space-y-3">';
        chain.forEach(function (step, i) {
            html += '<div class="flex items-center gap-3 p-3 bg-[#F8F8F8] rounded-lg">' +
                '<span class="w-8 h-8 bg-[#00AEEF] text-white rounded-full flex items-center justify-center text-sm font-bold">' + (i + 1) + '</span>' +
                '<div class="flex-1"><div class="font-mono text-sm break-all">' + escapeHtml(step.url || '') + '</div>' +
                '<div class="text-xs text-gray-500 mt-1">Status: ' + escapeHtml(step.statusCode || '') + (step.timestamp ? ' • ' + escapeHtml(step.timestamp) + 'ms' : '') + '</div></div></div>';
            if (i < chain.length - 1) {
                html += '<div class="flex justify-center"><svg class="w-4 h-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14"/><path d="m19 12-7 7-7-7"/></svg></div>';
            }
        });
        html += '</div></div>';
        return html;
    }

    function parseJsonSafe(text) {
        // Strip any leading non-JSON characters (e.g. stray "1" from PHP output buffering)
        var idx = text.indexOf('{');
        if (idx > 0) text = text.substring(idx);
        try { return JSON.parse(text); }
        catch (e) { throw new Error('Réponse invalide du serveur'); }
    }

    function formatLabel(key) {
        return key.replace(/([A-Z])/g, ' $1').replace(/^./, function (s) { return s.toUpperCase(); }).replace(/_/g, ' ');
    }

    function escapeHtml(str) {
        return String(str == null ? '' : str)
            .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;').replace(/'/g, '&#39;');
    }
})();
