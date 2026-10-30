/* Mobile card rails: dots / numbered stepper under each .m-rail / .why-carousel.
   The rails themselves are pure CSS scroll-snap (components.css); this only adds
   the indicator. Hidden from 768px up, where the rails are plain grids again. */
(function () {
    'use strict';

    var smooth = window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth';

    function initRail(rail) {
        var items = Array.prototype.slice.call(rail.children);
        if (items.length < 2) return;

        var steps = rail.classList.contains('m-rail--steps');
        // Two-row rails fill column by column: one stop per column
        var targets = rail.classList.contains('m-rail--2row')
            ? items.filter(function (_, i) { return i % 2 === 0; })
            : items;

        var nav = document.createElement('div');
        nav.className = 'm-rail-dots' + (steps ? ' m-rail-dots--steps' : '');

        var buttons = targets.map(function (target, i) {
            var b = document.createElement('button');
            b.type = 'button';
            b.setAttribute('aria-label', (steps ? 'Étape ' : 'Carte ') + (i + 1) + ' sur ' + targets.length);
            if (steps) b.textContent = String(i + 1);
            b.addEventListener('click', function () {
                rail.scrollTo({ left: offsetIn(rail, target), behavior: smooth });
            });
            nav.appendChild(b);
            return b;
        });
        rail.parentNode.insertBefore(nav, rail.nextSibling);

        var ticking = false;
        function update() {
            ticking = false;
            var active = 0, best = Infinity;
            // Last stops can't snap to the start edge — treat the scroll end as the last one
            if (rail.scrollLeft >= rail.scrollWidth - rail.clientWidth - 2) {
                active = targets.length - 1;
            } else {
                targets.forEach(function (t, i) {
                    var d = Math.abs(offsetIn(rail, t) - rail.scrollLeft);
                    if (d < best) { best = d; active = i; }
                });
            }
            buttons.forEach(function (b, i) {
                b.setAttribute('aria-current', i === active ? 'true' : 'false');
                b.classList.toggle('is-done', i < active);
            });
        }
        rail.addEventListener('scroll', function () {
            if (!ticking) { ticking = true; requestAnimationFrame(update); }
        }, { passive: true });
        update();
    }

    // scrollLeft that puts `target` at the rail's snap edge (after its left padding)
    function offsetIn(rail, target) {
        var pad = parseFloat(getComputedStyle(rail).paddingLeft) || 0;
        return rail.scrollLeft + target.getBoundingClientRect().left - rail.getBoundingClientRect().left - pad;
    }

    function init() {
        document.querySelectorAll('.m-rail, .why-carousel').forEach(initRail);
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
