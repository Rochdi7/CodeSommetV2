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
        'website-analyzer': { title: 'Website Analyzer', action: 'Analyze Website', actionText: 'websites analyzed', inputLabel: 'Website URL', inputPlaceholder: 'https://example.com' },
        'heading-analyzer': { title: 'Heading Analyzer', action: 'Analyze Headings', actionText: 'pages analyzed', inputLabel: 'Website URL', inputPlaceholder: 'https://example.com' },
        'keyword-density-analyzer': { title: 'Keyword Density', action: 'Analyze Keywords', actionText: 'pages analyzed', inputLabel: 'Website URL', inputPlaceholder: 'https://example.com' },
        'broken-link-checker': { title: 'Broken Link Checker', action: 'Check Links', actionText: 'pages scanned', inputLabel: 'Website URL', inputPlaceholder: 'https://example.com' },
        'redirect-checker': { title: 'Redirect Checker', action: 'Check Redirects', actionText: 'URLs checked', inputLabel: 'URL to Check', inputPlaceholder: 'https://example.com/old-page' },
        'backlink-checker': { title: 'Backlink Checker', action: 'Check Backlinks', actionText: 'domains analyzed', inputLabel: 'Domain', inputPlaceholder: 'example.com' },
        'ssl-certificate-checker': { title: 'SSL Checker', action: 'Check SSL', actionText: 'certificates checked', inputLabel: 'Domain', inputPlaceholder: 'example.com' },
        'mobile-friendly-test': { title: 'Mobile Friendly', action: 'Test Mobile', actionText: 'pages tested', inputLabel: 'Website URL', inputPlaceholder: 'https://example.com' },
        'core-web-vitals-checker': { title: 'Core Web Vitals', action: 'Check Vitals', actionText: 'pages analyzed', inputLabel: 'Website URL', inputPlaceholder: 'https://example.com' },
        'domain-authority-checker': { title: 'Domain Authority', action: 'Check Authority', actionText: 'domains checked', inputLabel: 'Domain', inputPlaceholder: 'example.com' },
        'domain-health-checker': { title: 'Domain Health', action: 'Check Health', actionText: 'domains checked', inputLabel: 'Domain', inputPlaceholder: 'example.com' },
        'canonical-checker': { title: 'Canonical Checker', action: 'Check Canonical', actionText: 'pages checked', inputLabel: 'Page URL', inputPlaceholder: 'https://example.com/page' },
        'image-alt-analyzer': { title: 'Image Alt Analyzer', action: 'Analyze Images', actionText: 'pages scanned', inputLabel: 'Website URL', inputPlaceholder: 'https://example.com' },
        'image-compression-analyzer': { title: 'Image Compression', action: 'Analyze Images', actionText: 'pages analyzed', inputLabel: 'Website URL', inputPlaceholder: 'https://example.com' },
        'internal-link-analyzer': { title: 'Internal Links', action: 'Analyze Links', actionText: 'pages analyzed', inputLabel: 'Website URL', inputPlaceholder: 'https://example.com' },
        'page-speed-analyzer': { title: 'Page Speed', action: 'Analyze Speed', actionText: 'pages analyzed', inputLabel: 'Website URL', inputPlaceholder: 'https://example.com' },
        'robots-validator': { title: 'Robots Validator', action: 'Validate', actionText: 'files validated', inputLabel: 'Website URL', inputPlaceholder: 'https://example.com' },
        'sitemap-validator': { title: 'Sitemap Validator', action: 'Validate', actionText: 'sitemaps validated', inputLabel: 'Sitemap URL', inputPlaceholder: 'https://example.com/sitemap.xml' },
        'website-readiness-checker': { title: 'Website Readiness', action: 'Check Readiness', actionText: 'websites checked', inputLabel: 'Website URL', inputPlaceholder: 'https://example.com' },
        'og-preview-generator': { title: 'OG Preview', action: 'Preview', actionText: 'previews generated', inputLabel: 'Website URL', inputPlaceholder: 'https://example.com' }
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
            if (!url) { CodeSommetTools.showError('Please enter a ' + config.inputLabel.toLowerCase()); return; }

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
                    if (!res.ok) throw new Error(json.error || json.message || 'Analysis failed');
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
                CodeSommetTools.showError(err.message || 'Failed to analyze. Please check the URL and try again.');
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

    function showGenericResult(data, slug, config) {
        var existing = document.getElementById('tool-results');
        if (existing) existing.remove();

        var html = '<div id="tool-results" class="space-y-6 mt-8">';

        // Score/status banner
        if (data.score !== undefined || data.passed !== undefined) {
            var score = data.score || (data.passed ? 100 : 0);
            var color = score >= 80 ? 'green' : score >= 50 ? 'yellow' : 'red';
            var grade = data.grade || (score >= 90 ? 'A' : score >= 80 ? 'B' : score >= 60 ? 'C' : score >= 40 ? 'D' : 'F');
            html += '<div class="rounded-2xl border-2 p-8 bg-' + color + '-50 border-' + color + '-200 text-center">' +
                '<div class="text-5xl font-bold text-' + color + '-600 mb-2">' + (data.grade ? grade : score + '/100') + '</div>' +
                '<div class="text-lg font-semibold text-' + color + '-900">' + escapeHtml(data.message || (data.passed ? 'Passed' : 'Issues Found')) + '</div></div>';
        }

        // Stats grid
        if (data.stats) {
            html += '<div class="grid grid-cols-2 md:grid-cols-4 gap-4">';
            Object.entries(data.stats).forEach(function (entry) {
                html += '<div class="bg-[#F8F8F8] p-4 rounded-lg border border-gray-200">' +
                    '<div class="text-2xl font-bold text-[#00AEEF]">' + entry[1] + '</div>' +
                    '<div class="text-sm text-gray-600 mt-1">' + formatLabel(entry[0]) + '</div></div>';
            });
            html += '</div>';
        }

        // Warnings
        if (data.warnings && data.warnings.length > 0) {
            html += '<div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6"><h3 class="font-bold text-yellow-900 mb-3">Warnings</h3><ul class="space-y-2">';
            data.warnings.forEach(function (w) {
                html += '<li class="text-sm text-yellow-800 flex items-start gap-2"><svg class="w-4 h-4 text-yellow-600 mt-0.5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>' + escapeHtml(typeof w === 'string' ? w : w.message || JSON.stringify(w)) + '</li>';
            });
            html += '</ul></div>';
        }

        // Issues
        if (data.issues && data.issues.length > 0) {
            html += '<div class="bg-white rounded-xl border border-gray-100 p-6"><h3 class="text-lg font-bold text-black mb-4">Issues Found</h3><div class="space-y-3">';
            data.issues.forEach(function (issue) {
                var severity = issue.type || issue.severity || 'warning';
                var sColor = severity === 'error' ? 'red' : 'yellow';
                html += '<div class="p-4 bg-' + sColor + '-50 border border-' + sColor + '-200 rounded-lg">' +
                    '<div class="flex items-start gap-2"><span class="px-2 py-0.5 rounded-full text-xs font-medium bg-' + sColor + '-100 text-' + sColor + '-800">' + escapeHtml(severity) + '</span>' +
                    '<p class="text-sm text-' + sColor + '-900">' + escapeHtml(issue.message || JSON.stringify(issue)) + '</p></div></div>';
            });
            html += '</div></div>';
        }

        // Recommendations
        if (data.recommendations && data.recommendations.length > 0) {
            html += '<div class="bg-white rounded-xl border border-gray-100 p-6"><h3 class="text-lg font-bold text-black mb-4">Recommendations</h3><div class="space-y-2">';
            data.recommendations.forEach(function (rec) {
                html += '<div class="flex items-start gap-2 p-3 bg-blue-50 rounded-lg"><svg class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>' +
                    '<p class="text-sm text-blue-900">' + escapeHtml(typeof rec === 'string' ? rec : rec.message || JSON.stringify(rec)) + '</p></div>';
            });
            html += '</div></div>';
        }

        // Tool-specific data display
        if (data.ogData) {
            html += renderOgPreview(data.ogData);
        }
        if (data.images && data.images.length > 0) {
            html += renderImagesTable(data.images);
        }
        if (data.links && data.links.length > 0) {
            html += renderLinksTable(data.links);
        }
        if (data.headings && data.headings.length > 0) {
            html += renderHeadingsTree(data.headings);
        }
        if (data.redirectChain && data.redirectChain.length > 0) {
            html += renderRedirectChain(data.redirectChain);
        }

        // Raw data fallback
        if (!data.stats && !data.issues && !data.warnings && !data.score && !data.passed) {
            html += '<div class="bg-white rounded-2xl border-2 border-gray-200 p-8"><div class="space-y-4">' +
                '<h3 class="text-lg font-semibold text-[#0F0F0F]">Analysis Results</h3>' +
                '<div class="bg-[#F8F8F8] rounded-lg p-4 border border-gray-200 overflow-x-auto">' +
                '<pre class="text-sm text-[#0F0F0F] font-mono whitespace-pre-wrap">' + escapeHtml(JSON.stringify(data, null, 2)) + '</pre></div></div></div>';
        }

        html += '</div>';

        // Insert results right after the form area (button's parent), before FAQ
        var existing = document.getElementById('tool-results');
        var actionBtn = document.getElementById('tool-action-btn');
        var insertTarget = actionBtn ? actionBtn.closest('.space-y-4') || actionBtn.parentElement : null;
        if (!insertTarget) {
            insertTarget = document.querySelector('section.max-w-5xl .space-y-6');
        }
        if (insertTarget) {
            insertTarget.insertAdjacentHTML('afterend', html);
            var resultsEl = document.getElementById('tool-results');
            if (resultsEl) resultsEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    function renderOgPreview(og) {
        var html = '<div class="bg-white rounded-xl border border-gray-100 p-6">' +
            '<h3 class="text-lg font-bold text-black mb-4">Open Graph Preview</h3>';
        // Social card preview
        html += '<div class="max-w-lg mx-auto border border-gray-200 rounded-xl overflow-hidden mb-6">';
        if (og.image) {
            html += '<div class="aspect-[1.91/1] bg-gray-100"><img src="' + escapeHtml(og.image) + '" class="w-full h-full object-cover" onerror="this.parentElement.innerHTML=\'<div class=\\\'flex items-center justify-center h-full text-gray-400 text-sm\\\'>No image preview</div>\'" /></div>';
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
            '<th class="text-left py-2 px-2">Image URL</th>' +
            '<th class="text-left py-2 px-2">Alt Text</th>' +
            '<th class="text-left py-2 px-2 w-24">Status</th></tr></thead><tbody>';
        images.forEach(function (img, i) {
            var statusColor = img.status === 'good' ? 'green' : img.status === 'empty' ? 'yellow' : 'red';
            var statusLabel = img.status === 'good' ? 'Good' : img.status === 'empty' ? 'Empty' : 'Missing';
            var altDisplay = img.status === 'good' ? escapeHtml(img.alt || '') :
                img.status === 'empty' ? '<span class="text-yellow-600 italic">alt=""</span>' :
                '<span class="text-red-600 italic">No alt attribute</span>';
            var urlDisplay = img.url ? escapeHtml(img.url) : '<span class="text-gray-400 italic">No src</span>';
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
            '<h3 class="text-lg font-bold text-black mb-4">Heading Structure</h3><div class="space-y-2">';
        headings.forEach(function (h) {
            var indent = (h.level - 1) * 1.5;
            var color = h.level === 1 ? '#00AEEF' : h.level === 2 ? '#0F0F0F' : '#666';
            html += '<div style="padding-left:' + indent + 'rem" class="flex items-center gap-2">' +
                '<span class="px-2 py-0.5 rounded bg-gray-100 text-xs font-bold" style="color:' + color + '">H' + h.level + '</span>' +
                '<span class="text-sm text-gray-800">' + escapeHtml(h.text || '') + '</span></div>';
        });
        html += '</div></div>';
        return html;
    }

    function renderRedirectChain(chain) {
        var html = '<div class="bg-white rounded-xl border border-gray-100 p-6">' +
            '<h3 class="text-lg font-bold text-black mb-4">Redirect Chain</h3><div class="space-y-3">';
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
        catch (e) { throw new Error('Invalid response from server'); }
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
