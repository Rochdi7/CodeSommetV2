/**
 * CodeSommet – Source Inspection Deterrent
 *
 * Blocks the casual routes to page source: right-click context menu,
 * DevTools / view-source / save / print keyboard shortcuts, text selection,
 * copy, cut and drag-out of page content.
 *
 * IMPORTANT — READ BEFORE RELYING ON THIS:
 * This is a deterrent against casual users only. It cannot stop anyone who
 * wants the source. The browser menu (⋮ → Developer tools), the
 * `view-source:` URL scheme, disabling JavaScript, "Save page as" from the
 * menu, a proxy, or plain `curl https://...` all bypass every line below,
 * because the server sends this HTML/CSS/JS to the client by definition.
 * Never put a secret, key, or private logic in front-end code and expect
 * this file to protect it. Real protection = keep it server-side.
 */
(function () {
    'use strict';

    // Elements where selection and copy must keep working: users have to be
    // able to select and copy inside form fields, or the site breaks.
    // (Right-click is blocked everywhere and does not use this guard.)
    var INTERACTIVE = 'input, textarea, select, option, [contenteditable=""], [contenteditable="true"]';

    function isInteractive(node) {
        if (!node || typeof node.closest !== 'function') {
            return false;
        }
        // Opt-out hook: add data-allow-select to any block that must stay
        // selectable (e.g. a code snippet the user is meant to copy).
        return !!node.closest(INTERACTIVE + ', [data-allow-select]');
    }

    // --- Right-click -------------------------------------------------------
    // Blocked EVERYWHERE, including inside form fields. Users can still type,
    // paste with Ctrl/Cmd+V, and select inside inputs — only the context menu
    // itself is suppressed.
    document.addEventListener('contextmenu', function (e) {
        e.preventDefault();
    }, true);


    // --- Selection / copy / cut / drag ------------------------------------
    document.addEventListener('selectstart', function (e) {
        if (isInteractive(e.target)) {
            return;
        }
        e.preventDefault();
    });

    document.addEventListener('dragstart', function (e) {
        if (isInteractive(e.target)) {
            return;
        }
        e.preventDefault();
    });

    ['copy', 'cut'].forEach(function (type) {
        document.addEventListener(type, function (e) {
            if (isInteractive(e.target)) {
                return;
            }
            e.preventDefault();
        });
    });

    // --- Keyboard shortcuts ------------------------------------------------
    document.addEventListener('keydown', function (e) {
        var key = e.key ? e.key.toUpperCase() : '';
        var mod = e.ctrlKey || e.metaKey;

        // F12 — DevTools
        if (e.keyCode === 123 || key === 'F12') {
            e.preventDefault();
            return;
        }

        // Ctrl/Cmd+Shift+I  inspect
        // Ctrl/Cmd+Shift+J  console
        // Ctrl/Cmd+Shift+C  element picker
        // Ctrl/Cmd+Shift+K  console (Firefox)
        // Ctrl/Cmd+Shift+E  network (Firefox)
        // Ctrl/Cmd+Shift+M  device toolbar
        if (mod && e.shiftKey && ['I', 'J', 'C', 'K', 'E', 'M'].indexOf(key) !== -1) {
            e.preventDefault();
            return;
        }

        // Cmd+Option+I / J / C / U — macOS DevTools + view source
        if (e.metaKey && e.altKey && ['I', 'J', 'C', 'U'].indexOf(key) !== -1) {
            e.preventDefault();
            return;
        }

        // Ctrl/Cmd+U — view source
        // Ctrl/Cmd+S — save page
        // Ctrl/Cmd+P — print (print preview exposes content)
        if (mod && ['U', 'S', 'P'].indexOf(key) !== -1) {
            e.preventDefault();
            return;
        }

        // Ctrl/Cmd+A / C / X inside non-interactive content — select-all and
        // copy. Forms keep working through the isInteractive() guard.
        if (mod && ['A', 'C', 'X'].indexOf(key) !== -1 && !isInteractive(e.target)) {
            e.preventDefault();
            return;
        }
    });
})();
