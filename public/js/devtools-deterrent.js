/**
 * CodeSommet – Source Inspection Deterrent
 * Disables right-click context menu and common DevTools / view-source
 * shortcuts. This is a deterrent for casual users only — it cannot stop
 * anyone determined to view the page source (browser menus, disabling JS,
 * or view-source: still work). Do not rely on this for real protection
 * of secrets; anything the browser renders is always inspectable.
 */
(function () {
    'use strict';

    document.addEventListener('contextmenu', function (e) {
        e.preventDefault();
    });

    document.addEventListener('keydown', function (e) {
        const key = e.key ? e.key.toUpperCase() : '';

        // F12
        if (e.keyCode === 123 || key === 'F12') {
            e.preventDefault();
            return;
        }

        // Ctrl+Shift+I / J / C (DevTools, console, inspect element)
        if ((e.ctrlKey || e.metaKey) && e.shiftKey && ['I', 'J', 'C'].includes(key)) {
            e.preventDefault();
            return;
        }

        // Ctrl+U (view source)
        if ((e.ctrlKey || e.metaKey) && key === 'U') {
            e.preventDefault();
            return;
        }

        // Ctrl+S (save page)
        if ((e.ctrlKey || e.metaKey) && key === 'S') {
            e.preventDefault();
            return;
        }
    });
})();
