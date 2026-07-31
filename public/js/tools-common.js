/**
 * CodeSommet – Tools Common JavaScript
 * Shared utilities for all tool pages: FAQ toggles, usage counter, copy, download, tabs
 */

/* ── Ready helper for deferred body scripts ─────────────────────────── */
/* Deferred tool scripts may register a DOMContentLoaded handler after the
 * event has already fired. Rather than globally monkey-patching
 * document.addEventListener (which breaks removeEventListener, the `this`
 * binding, and listener options), expose a safe, local onReady() helper.
 * Tool scripts should prefer CodeSommetTools.onReady(fn). */
window.CodeSommetTools = window.CodeSommetTools || {};
window.CodeSommetTools.onReady = function (fn) {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', fn, { once: true });
    } else {
        // DOM already parsed: run on the next tick so registration order is
        // preserved and errors don't block other scripts.
        setTimeout(function () { fn(); }, 0);
    }
};

(function () {
    'use strict';

    /* ── FAQ Accordion ─────────────────────────────────────────────────────
     * Volontairement absent ici. L'accordéon FAQ des pages /tools/ est déjà
     * géré par public/js/app.js ("Tool FAQ Accordion"), chargé sur toutes les
     * pages. Un second gestionnaire était attaché ici : les deux réagissaient
     * au même clic et le dernier refermait aussitôt la réponse ouverte par le
     * premier — l'accordéon paraissait donc inerte. Ne pas réintroduire de
     * gestionnaire FAQ dans ce fichier.
     */

    /* ── Scroll-to-tool CTA (e.g. "Scroll up to start") ────────────────
     * Buttons carrying [data-scroll-to-tool] scroll back to the tool form
     * and focus its first input — mirrors the original Next.js onClick. */
    function initScrollToToolButtons() {
        document.querySelectorAll('[data-scroll-to-tool]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                window.scrollTo({ top: 0, behavior: 'smooth' });
                setTimeout(function () {
                    var toolSection = document.querySelector('section.max-w-5xl') || document.querySelector('section.max-w-4xl');
                    var input = (toolSection || document).querySelector('input[type="text"], input[type="url"], textarea');
                    if (input) input.focus({ preventScroll: true });
                }, 500);
            });
        });
    }

    /* ── Tool Usage Counter (localStorage-based) ──────────────────────── */
    window.CodeSommetTools = window.CodeSommetTools || {};

    /* ── Page identity ────────────────────────────────────────────────────
     * The current tool's slug, taken from the URL (/tools/<slug>, optionally
     * behind a locale prefix like /fr/tools/<slug>).
     *
     * Tool scripts must gate on this rather than on document.title: titles are
     * translated, so an English check like title.includes('word') is false on
     * the French site and the tool silently never initialises.
     */
    window.CodeSommetTools.currentToolSlug = function () {
        var m = window.location.pathname.match(/\/tools\/([a-z0-9-]+)/i);
        return m ? m[1].toLowerCase() : '';
    };

    /* True when the page is the given tool. Accepts one slug or a list. */
    window.CodeSommetTools.isTool = function (slugs) {
        var current = window.CodeSommetTools.currentToolSlug();
        if (!current) return false;
        return (Array.isArray(slugs) ? slugs : [slugs]).indexOf(current) !== -1;
    };

    /* Real, server-side counter (see ToolsApiController::usageShow/usageIncrement).
     * Every visitor sees the same number because it's stored in the
     * `tool_usages` DB table, not per-browser localStorage. */
    function setCounterText(count) {
        var el = document.getElementById('usage-counter-value');
        if (el) el.textContent = Math.max(0, count).toLocaleString('en-US');
    }

    CodeSommetTools.incrementUsage = function (toolSlug) {
        fetch('/api/tools/' + encodeURIComponent(toolSlug) + '/usage', { method: 'POST' })
            .then(function (res) { return res.ok ? res.json() : null; })
            .then(function (data) { if (data && typeof data.count === 'number') setCounterText(data.count); })
            .catch(function () { /* counter is cosmetic; ignore network failures */ });
    };

    CodeSommetTools.initUsageCounter = function (toolSlug, actionText) {
        var container = document.getElementById('tool-usage-counter');
        if (!container) {
            var actionBtn = document.getElementById('tool-action-btn');
            if (!actionBtn) return;
            container = document.createElement('div');
            container.id = 'tool-usage-counter';
            container.className = 'flex items-center justify-center gap-2 text-sm text-gray-600 mt-3';
            container.innerHTML = '<svg class="w-4 h-4 text-[#00AEEF]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 7h6v6"/><path d="m22 7-8.5 8.5-5-5L2 17"/></svg>' +
                '<span><span id="usage-counter-value" class="font-semibold text-[#00AEEF]">0</span> ' + actionText + '</span>';
            actionBtn.insertAdjacentElement('afterend', container);
        } else {
            setCounterText(0);
        }

        fetch('/api/tools/' + encodeURIComponent(toolSlug) + '/usage')
            .then(function (res) { return res.ok ? res.json() : null; })
            .then(function (data) { if (data && typeof data.count === 'number') setCounterText(data.count); })
            .catch(function () { /* leave at 0 on failure */ });
    };

    /* ── Field lookup by label ────────────────────────────────────────────
     * Tool scripts locate their inputs by reading the <label> next to them.
     * The interface is French, so matching on English text alone silently
     * returns '' for every field and the tool appears broken. Match on a list
     * of accepted terms instead, ignoring case, accents and punctuation, and
     * accept both the French and English wording.
     */
    CodeSommetTools.normalizeLabel = function (str) {
        return String(str == null ? '' : str)
            .normalize('NFD')
            .replace(/[̀-ͯ]/g, '')  // strip accents: "Téléphone" → "Telephone"
            .replace(/['’]/g, ' ')            // "Nom de l'Entreprise" → "… l entreprise"
            .replace(/\s+/g, ' ')
            .trim()
            .toLowerCase();
    };

    /**
     * Value of the field whose label matches any of `terms`.
     * @param {Element} scope    container to search within
     * @param {string|string[]} terms  accepted label fragments (FR and/or EN)
     * @returns {string} trimmed value, or '' when no field matches
     */
    CodeSommetTools.fieldByLabel = function (scope, terms) {
        if (!scope) return '';
        var wanted = (Array.isArray(terms) ? terms : [terms])
            .map(CodeSommetTools.normalizeLabel)
            .filter(Boolean);
        if (!wanted.length) return '';

        var labels = scope.querySelectorAll('label');
        for (var i = 0; i < labels.length; i++) {
            var text = CodeSommetTools.normalizeLabel(labels[i].textContent);
            for (var j = 0; j < wanted.length; j++) {
                if (text.indexOf(wanted[j]) === -1) continue;

                // Several tool pages render the label with neither a for=
                // attribute nor a .space-y-* wrapper, so try progressively
                // looser associations rather than giving up.
                var input = null;

                // 1. Explicit for="id".
                var forId = labels[i].getAttribute('for');
                if (forId && window.CSS && CSS.escape) {
                    input = scope.querySelector('#' + CSS.escape(forId));
                }

                // 2. A field inside the usual wrapper.
                if (!input) {
                    var container = labels[i].closest('.space-y-2, .space-y-1');
                    input = container ? container.querySelector('input, select, textarea') : null;
                }

                // 3. The next field after the label in document order.
                if (!input) {
                    var node = labels[i];
                    while (node && !input) {
                        var sib = node.nextElementSibling;
                        while (sib && !input) {
                            input = sib.matches('input, select, textarea')
                                ? sib
                                : sib.querySelector('input, select, textarea');
                            sib = sib.nextElementSibling;
                        }
                        node = node.parentElement;
                        // Don't wander outside the field group.
                        if (node === scope) break;
                    }
                }

                if (input) return (input.value || '').trim();
            }
        }
        return '';
    };

    /* ── Copy to Clipboard ────────────────────────────────────────────── */
    CodeSommetTools.copyToClipboard = function (text, btn) {
        if (!btn) return;
        var orig = btn.innerHTML;

        function flash(label, ok) {
            btn.innerHTML = ok
                ? '<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg> ' + label
                : label;
            btn.classList.add(ok ? 'bg-green-500' : 'bg-red-500', 'text-white');
            setTimeout(function () {
                btn.innerHTML = orig;
                btn.classList.remove('bg-green-500', 'bg-red-500', 'text-white');
            }, 2000);
        }

        // navigator.clipboard rejette hors contexte sécurisé ou si l'utilisateur
        // refuse la permission. Sans .catch(), l'échec était silencieux et le
        // bouton restait figé : on informe explicitement l'utilisateur.
        if (!navigator.clipboard || !navigator.clipboard.writeText) {
            flash('Copie indisponible', false);
            return;
        }
        navigator.clipboard.writeText(text).then(
            function () { flash('Copié !', true); },
            function () { flash('Échec de la copie', false); }
        );
    };

    /* ── Download File ────────────────────────────────────────────────── */
    CodeSommetTools.downloadFile = function (content, filename, mimeType) {
        var blob = new Blob([content], { type: mimeType || 'text/plain' });
        var url = URL.createObjectURL(blob);
        var a = document.createElement('a');
        a.href = url;
        a.download = filename;
        a.click();
        URL.revokeObjectURL(url);
    };

    /* ── Tab Switching ────────────────────────────────────────────────── */
    CodeSommetTools.initTabs = function (containerSelector) {
        var container = document.querySelector(containerSelector);
        if (!container) return;
        var tabs = container.querySelectorAll('[data-tab]');
        var panels = container.querySelectorAll('[data-tab-panel]');
        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                var target = tab.dataset.tab;
                tabs.forEach(function (t) {
                    t.classList.remove('bg-[#00AEEF]', 'text-white', 'shadow-md');
                    t.classList.add('text-[#0F0F0F]', 'hover:bg-gray-50');
                });
                tab.classList.add('bg-[#00AEEF]', 'text-white', 'shadow-md');
                tab.classList.remove('text-[#0F0F0F]', 'hover:bg-gray-50');
                panels.forEach(function (p) {
                    p.classList.toggle('hidden', p.dataset.tabPanel !== target);
                });
            });
        });
    };

    /* ── Format File Size ─────────────────────────────────────────────── */
    CodeSommetTools.formatSize = function (bytes) {
        if (bytes < 1024) return bytes + ' B';
        if (bytes < 1048576) return (bytes / 1024).toFixed(2) + ' KB';
        return (bytes / 1048576).toFixed(2) + ' MB';
    };

    /* ── Error Display ────────────────────────────────────────────────── */
    CodeSommetTools.showError = function (msg) {
        var el = document.getElementById('tool-error');
        if (!el) {
            var actionBtn = document.getElementById('tool-action-btn');
            if (!actionBtn) return;
            el = document.createElement('div');
            el.id = 'tool-error';
            el.className = 'p-4 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm mt-4';
            actionBtn.parentElement.appendChild(el);
        }
        el.textContent = msg;
        el.classList.remove('hidden');
    };

    CodeSommetTools.hideError = function () {
        var el = document.getElementById('tool-error');
        if (el) el.classList.add('hidden');
    };

    /* ── Show/Hide Loading State ──────────────────────────────────────── */
    CodeSommetTools.setLoading = function (isLoading, btnId) {
        var btn = document.getElementById(btnId || 'tool-action-btn');
        if (!btn) return;
        if (isLoading) {
            btn._origText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<svg class="animate-spin mr-2 h-4 w-4 inline" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg> Traitement en cours…';
        } else {
            btn.disabled = false;
            if (btn._origText) btn.innerHTML = btn._origText;
        }
    };

    /* ── Universal Auto-Tab Initializer ──────────────────────────────── */
    /*
     * Auto-detects and wires up ALL tab/toggle patterns across every tool page:
     *
     * Pattern A: "flex-1 px-6 py-3 rounded-xl" buttons (Paste Text / Analyze URL)
     * Pattern B: "px-6 py-3 rounded-full" buttons (Encode / Decode, Format / Minify / Validate)
     * Pattern C: "p-4 rounded-lg border-2" cards (Create New / Improve Existing)
     * Pattern D: "flex-1 px-4 py-3 rounded-lg" buttons (Single / Batch)
     *
     * For each tab group found, it:
     *  1. Toggles active/inactive styles on click
     *  2. Shows/hides the corresponding form sections
     */
    function initAutoTabs() {
        var toolSection = document.querySelector('section.max-w-5xl') || document.querySelector('section.max-w-4xl');
        if (!toolSection) return;

        // ─── Pattern A: rounded-xl tab buttons (in a flex/grid row) ──
        var tabContainers = toolSection.querySelectorAll('.bg-white.rounded-2xl[class*="border"]');
        tabContainers.forEach(function (container) {
            var btns = container.querySelectorAll('button.flex-1');
            if (btns.length < 2) return;
            // Skip if already handled by individual tool JS (check for event listener marker)
            if (container.dataset.tabsInit) return;
            container.dataset.tabsInit = 'true';

            // Find the form area that follows this tab container
            var formParent = container.closest('.space-y-6, .space-y-4, .space-y-8');
            if (!formParent) return;

            btns.forEach(function (btn, idx) {
                btn.addEventListener('click', function () {
                    // Toggle active styles
                    btns.forEach(function (b) {
                        b.classList.remove('bg-[#00AEEF]', 'text-white');
                        b.classList.add('text-[#0F0F0F]', 'hover:bg-[#F8F8F8]');
                    });
                    btn.classList.add('bg-[#00AEEF]', 'text-white');
                    btn.classList.remove('text-[#0F0F0F]', 'hover:bg-[#F8F8F8]');

                    // Dispatch custom event for tool-specific JS to handle
                    var tabText = btn.textContent.trim();
                    window.dispatchEvent(new CustomEvent('toolTabChanged', {
                        detail: { index: idx, text: tabText, button: btn }
                    }));
                });
            });
        });

        // ─── Pattern B: rounded-full toggle buttons (Encode/Decode, Format/Minify/Validate) ──
        var toggleContainers = toolSection.querySelectorAll('.rounded-2xl[class*="border"][class*="inline-flex"], .rounded-2xl[class*="border"] .inline-flex');
        toggleContainers.forEach(function (container) {
            var btns = container.querySelectorAll('button.rounded-full');
            if (btns.length === 0) btns = container.querySelectorAll('button');
            if (btns.length < 2) return;
            if (container.dataset.tabsInit) return;
            container.dataset.tabsInit = 'true';

            btns.forEach(function (btn, idx) {
                btn.addEventListener('click', function () {
                    btns.forEach(function (b) {
                        b.classList.remove('bg-[#00AEEF]', 'text-white', 'shadow-md');
                        b.classList.add('text-[#0F0F0F]', 'hover:bg-gray-50');
                    });
                    btn.classList.add('bg-[#00AEEF]', 'text-white', 'shadow-md');
                    btn.classList.remove('text-[#0F0F0F]', 'hover:bg-gray-50');

                    window.dispatchEvent(new CustomEvent('toolTabChanged', {
                        detail: { index: idx, text: btn.textContent.trim(), button: btn }
                    }));
                });
            });
        });

        // ─── Pattern C: Card-style tabs (Create New / Improve Existing) ──
        var cardGrids = toolSection.querySelectorAll('.grid.grid-cols-2.gap-3');
        cardGrids.forEach(function (grid) {
            var cards = grid.querySelectorAll('button');
            if (cards.length < 2) return;
            if (grid.dataset.tabsInit) return;
            grid.dataset.tabsInit = 'true';

            cards.forEach(function (card, idx) {
                card.addEventListener('click', function () {
                    // Toggle card styles
                    cards.forEach(function (c) {
                        c.classList.remove('border-[var(--color-primary-orange)]', 'bg-orange-50', 'border-[#00AEEF]', 'bg-blue-50');
                        c.classList.add('border-gray-200', 'hover:border-gray-300');
                    });
                    card.classList.remove('border-gray-200', 'hover:border-gray-300');
                    card.classList.add('border-[#00AEEF]', 'bg-blue-50');

                    // Handle form section changes
                    var cardText = card.querySelector('p')?.textContent.trim() || '';
                    var isImproveExisting = cardText === 'Improve Existing' || idx === 1;

                    // Find text inputs and URL inputs in the form
                    var parent = grid.closest('.bg-white.rounded-2xl, .shadow-sm');
                    if (!parent) return;
                    var textInputs = parent.querySelectorAll('.space-y-2');
                    var actionBtn = parent.querySelector('button.w-full, button[class*="rounded-full"][class*="w-full"]');

                    if (isImproveExisting) {
                        // Hide all form fields except create a URL field
                        textInputs.forEach(function (ti) { ti.classList.add('hidden'); });
                        // Create URL input if it doesn't exist
                        var urlSection = parent.querySelector('#improve-url-section');
                        if (!urlSection) {
                            urlSection = document.createElement('div');
                            urlSection.id = 'improve-url-section';
                            urlSection.className = 'space-y-2';
                            urlSection.innerHTML = '<label class="block text-sm font-medium text-black">Landing Page URL<span class="text-[#00AEEF] ml-1">*</span></label>' +
                                '<input type="url" placeholder="https://example.com/landing-page" class="h-12 w-full px-4 rounded-lg bg-white border border-gray-200 text-black placeholder:text-gray-400 transition-all duration-200 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none">';
                            var formSpace = parent.querySelector('.space-y-6');
                            if (formSpace && actionBtn) {
                                formSpace.insertBefore(urlSection, actionBtn);
                            }
                        }
                        urlSection.classList.remove('hidden');
                    } else {
                        // Show text inputs, hide URL input
                        textInputs.forEach(function (ti) { ti.classList.remove('hidden'); });
                        var urlSec = parent.querySelector('#improve-url-section');
                        if (urlSec) urlSec.classList.add('hidden');
                    }

                    window.dispatchEvent(new CustomEvent('toolTabChanged', {
                        detail: { index: idx, text: cardText, button: card }
                    }));
                });
            });
        });

        // ─── Pattern D: Handle "Paste Text/HTML" vs "Analyze URL" form switching ──
        // This listens for tab changes and shows/hides form elements accordingly
        window.addEventListener('toolTabChanged', function (e) {
            var text = e.detail.text.toLowerCase();
            var toolArea = document.querySelector('section.max-w-5xl') || document.querySelector('section.max-w-4xl');
            if (!toolArea) return;

            // "Paste Text" / "Paste HTML" → show textarea, hide URL input
            // "Analyze URL" / "Enter URL" → show URL input, hide textarea
            if (text.includes('paste') || text.includes('text')) {
                var ta = toolArea.querySelector('textarea');
                var urlWrapper = toolArea.querySelector('#dynamic-url-input');
                if (ta) ta.closest('.space-y-2')?.classList.remove('hidden');
                if (urlWrapper) urlWrapper.classList.add('hidden');
            } else if (text.includes('url') || text.includes('analyze')) {
                var ta2 = toolArea.querySelector('textarea');
                if (ta2) ta2.closest('.space-y-2')?.classList.add('hidden');
                // Create URL input if needed
                var urlWrap = toolArea.querySelector('#dynamic-url-input');
                if (!urlWrap) {
                    urlWrap = document.createElement('div');
                    urlWrap.id = 'dynamic-url-input';
                    urlWrap.className = 'space-y-2';
                    urlWrap.innerHTML = '<label class="block text-sm font-medium text-black">Website URL<span class="text-[#00AEEF] ml-1">*</span></label>' +
                        '<input type="url" placeholder="https://example.com" class="h-12 w-full px-4 rounded-lg bg-white border border-gray-200 text-black placeholder:text-gray-400 transition-all duration-200 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none">';
                    var textareaParent = ta2?.closest('.space-y-4, .space-y-6');
                    if (textareaParent) {
                        textareaParent.insertBefore(urlWrap, ta2?.closest('.space-y-2'));
                    }
                }
                urlWrap.classList.remove('hidden');
            }

            // "Single" / "Batch" for url-slug-generator
            if (text.includes('single') || text.includes('batch')) {
                var input = toolArea.querySelector('input[type="text"]');
                var batchTa = toolArea.querySelector('textarea');
                if (text.includes('batch')) {
                    if (input) input.closest('.space-y-2')?.classList.add('hidden');
                    if (!batchTa) {
                        var batchWrap = document.createElement('div');
                        batchWrap.id = 'batch-input';
                        batchWrap.className = 'space-y-2';
                        batchWrap.innerHTML = '<label class="block text-sm font-medium text-black">Titles (one per line)<span class="text-[#00AEEF] ml-1">*</span></label>' +
                            '<textarea rows="6" placeholder="Enter multiple titles, one per line..." class="w-full px-4 py-3 rounded-lg bg-white border border-gray-200 text-black placeholder:text-gray-400 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none resize-y"></textarea>';
                        var inputParent = input?.closest('.space-y-4, .space-y-6');
                        if (inputParent) inputParent.insertBefore(batchWrap, input?.closest('.space-y-2'));
                    } else {
                        var batchEl = toolArea.querySelector('#batch-input');
                        if (batchEl) batchEl.classList.remove('hidden');
                    }
                } else {
                    if (input) input.closest('.space-y-2')?.classList.remove('hidden');
                    var batchEl2 = toolArea.querySelector('#batch-input');
                    if (batchEl2) batchEl2.classList.add('hidden');
                }
            }
        });
    }

    /* ── Init on DOMContentLoaded ─────────────────────────────────────── */
    function _initAll() {
        initAutoTabs();
        initScrollToToolButtons();
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', _initAll);
    } else {
        _initAll();
    }
})();
