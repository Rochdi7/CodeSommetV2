/* ═══════════════════════════════════════════════════════════════════════
   Custom Select (cs-select)
   ───────────────────────────────────────────────────────────────────────
   Replaces the browser's native dropdown UI with a themed one, while
   KEEPING the original <select> in the DOM. All existing form handlers,
   FormData serialisation, required-validation and .value reads keep
   working exactly as before.

   Usage: automatic. Every <select> is enhanced on DOMContentLoaded.
   Opt out with  data-no-custom-select  on the <select>.
   Variants:     data-cs-variant="sm"  or  "dark"  (or both: "sm dark")
   ═══════════════════════════════════════════════════════════════════════ */
(function () {
    'use strict';

    var CHEVRON = '<svg class="cs-select__arrow" viewBox="0 0 20 20" fill="none" aria-hidden="true">' +
        '<path d="M5.5 7.5L10 12l4.5-4.5" stroke="currentColor" stroke-width="1.6" ' +
        'stroke-linecap="round" stroke-linejoin="round"/></svg>';

    var CHECK = '<svg class="cs-select__check" viewBox="0 0 20 20" fill="none" aria-hidden="true">' +
        '<path d="M4.5 10.5l3.5 3.5 7.5-8" stroke="currentColor" stroke-width="2" ' +
        'stroke-linecap="round" stroke-linejoin="round"/></svg>';

    var uid = 0;
    var instances = [];

    function esc(str) {
        return String(str)
            .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;').replace(/'/g, '&#39;');
    }

    function CustomSelect(select) {
        this.select = select;
        this.id = 'cs-' + (++uid);
        this.open = false;
        this.activeIndex = -1;
        this.searchBuffer = '';
        this.searchTimer = null;
        this.build();
        this.bind();
        this.syncFromNative();
    }

    CustomSelect.prototype.build = function () {
        var select = this.select;

        // Carry sizing/theme hints from the original markup or data attribute.
        var variant = (select.getAttribute('data-cs-variant') || '').split(/\s+/);
        var cls = select.className || '';
        if (variant.indexOf('sm') === -1 && /\bpy-2\b|\btext-sm\b/.test(cls) && !/\bpy-3\b/.test(cls)) {
            variant.push('sm');
        }

        var wrap = document.createElement('div');
        wrap.className = 'cs-select';
        variant.forEach(function (v) {
            if (v) { wrap.classList.add('cs-select--' + v); }
        });
        if (select.disabled) { wrap.classList.add('is-disabled'); }

        select.parentNode.insertBefore(wrap, select);
        wrap.appendChild(select);
        select.classList.add('cs-select__native');
        // Keep the native element out of the tab order; the trigger owns focus.
        select.setAttribute('tabindex', '-1');
        select.setAttribute('aria-hidden', 'true');

        var trigger = document.createElement('button');
        trigger.type = 'button';
        trigger.className = 'cs-select__trigger';
        trigger.id = this.id + '-trigger';
        trigger.setAttribute('aria-haspopup', 'listbox');
        trigger.setAttribute('aria-expanded', 'false');
        trigger.disabled = select.disabled;
        trigger.innerHTML = '<span class="cs-select__value"></span>' + CHEVRON;

        // Point the existing <label for="..."> at the visible control.
        var label = select.id ? document.querySelector('label[for="' + select.id + '"]') : null;
        if (label) {
            if (!label.id) { label.id = this.id + '-label'; }
            trigger.setAttribute('aria-labelledby', label.id + ' ' + this.id + '-trigger');
            label.addEventListener('click', function (e) {
                e.preventDefault();
                trigger.focus();
            });
        }

        var panel = document.createElement('div');
        panel.className = 'cs-select__panel';
        panel.id = this.id + '-panel';
        panel.setAttribute('role', 'listbox');
        if (label && label.id) { panel.setAttribute('aria-labelledby', label.id); }

        wrap.appendChild(trigger);
        wrap.appendChild(panel);

        this.wrap = wrap;
        this.trigger = trigger;
        this.panel = panel;
        this.valueEl = trigger.querySelector('.cs-select__value');

        this.renderOptions();
    };

    // Build the option rows from the native <option> / <optgroup> tree.
    CustomSelect.prototype.renderOptions = function () {
        var self = this;
        var html = '';
        var idx = 0;

        Array.prototype.forEach.call(this.select.children, function (node) {
            if (node.tagName === 'OPTGROUP') {
                html += '<div class="cs-select__group-label">' + esc(node.label) + '</div>';
                Array.prototype.forEach.call(node.children, function (opt) {
                    html += self.optionHtml(opt, idx++);
                });
            } else if (node.tagName === 'OPTION') {
                html += self.optionHtml(node, idx++);
            }
        });

        this.panel.innerHTML = html;
        this.options = Array.prototype.slice.call(
            this.panel.querySelectorAll('.cs-select__option')
        );
    };

    CustomSelect.prototype.optionHtml = function (opt, index) {
        return '<div class="cs-select__option" role="option" ' +
            'id="' + this.id + '-opt-' + index + '" ' +
            'data-index="' + index + '" ' +
            'data-value="' + esc(opt.value) + '" ' +
            'aria-selected="false"' +
            (opt.disabled ? ' aria-disabled="true"' : '') + '>' +
            '<span>' + esc(opt.textContent.trim()) + '</span>' + CHECK +
            '</div>';
    };

    // Reflect the native select's current value into the custom UI.
    CustomSelect.prototype.syncFromNative = function () {
        var i = this.select.selectedIndex;
        var opt = i > -1 ? this.select.options[i] : null;

        this.options.forEach(function (row, n) {
            var on = n === i;
            row.classList.toggle('is-selected', on);
            row.setAttribute('aria-selected', on ? 'true' : 'false');
        });

        this.valueEl.textContent = opt ? opt.textContent.trim() : '';
        // Empty value = placeholder styling (greyed, like the original).
        this.trigger.setAttribute('data-placeholder', (!opt || opt.value === '') ? 'true' : 'false');

        if (opt && this.options[i]) {
            this.trigger.setAttribute('aria-activedescendant', this.options[i].id);
        }
    };

    CustomSelect.prototype.setActive = function (index) {
        if (!this.options.length) { return; }
        var max = this.options.length - 1;
        index = Math.max(0, Math.min(max, index));

        this.options.forEach(function (row) { row.classList.remove('is-active'); });
        var row = this.options[index];
        if (!row) { return; }
        row.classList.add('is-active');
        this.activeIndex = index;
        this.trigger.setAttribute('aria-activedescendant', row.id);

        // Keep the active row inside the scrollable panel.
        var pTop = this.panel.scrollTop;
        var pBottom = pTop + this.panel.clientHeight;
        var rTop = row.offsetTop;
        var rBottom = rTop + row.offsetHeight;
        if (rTop < pTop) {
            this.panel.scrollTop = rTop - 4;
        } else if (rBottom > pBottom) {
            this.panel.scrollTop = rBottom - this.panel.clientHeight + 4;
        }
    };

    // Skip over disabled rows when arrowing.
    CustomSelect.prototype.move = function (from, step) {
        var i = from;
        for (var guard = 0; guard < this.options.length; guard++) {
            i += step;
            if (i < 0 || i > this.options.length - 1) { return; }
            var row = this.options[i];
            if (row && row.getAttribute('aria-disabled') !== 'true') {
                this.setActive(i);
                return;
            }
        }
    };

    // True when an ancestor would either crop the panel or trap its z-index.
    //
    //  - Clipping: overflow != visible (the get-quote wizard's #stepsContainer
    //    uses overflow-hidden for its slide animation).
    //  - Trapping: an ancestor that forms a stacking context confines the
    //    panel's z-index to that layer, so a LATER sibling field paints over
    //    the open panel no matter how high the z-index is. The .scroll-fade
    //    entrance animation does exactly this — it sets both opacity and
    //    transform, and mid-animation opacity < 1 creates the context.
    //
    // Either way the answer is the same: move the panel to <body>.
    CustomSelect.prototype.needsFloating = function () {
        var node = this.wrap.parentNode;
        while (node && node.nodeType === 1 && node !== document.body) {
            var o = getComputedStyle(node);

            if (o.overflow !== 'visible' || o.overflowY !== 'visible' || o.overflowX !== 'visible') {
                return true;
            }
            if (o.transform !== 'none' || o.perspective !== 'none' ||
                o.filter !== 'none' || o.isolation === 'isolate' ||
                (o.opacity !== '' && parseFloat(o.opacity) < 1) ||
                (o.willChange && /transform|opacity|filter/.test(o.willChange)) ||
                (o.position === 'fixed' || o.position === 'sticky') ||
                (o.zIndex !== 'auto' && o.position !== 'static') ||
                o.contain === 'paint' || o.contain === 'layout' ||
                o.mixBlendMode !== 'normal') {
                return true;
            }
            node = node.parentNode;
        }
        return false;
    };

    // Pin the panel to the viewport, aligned to the trigger. Used whenever an
    // ancestor would crop the panel or trap its z-index. The panel is moved to
    // <body> first: a transformed ancestor becomes the containing block for
    // position:fixed, which would offset these viewport coordinates.
    CustomSelect.prototype.position = function () {
        if (!this.floating) { return; }
        var r = this.trigger.getBoundingClientRect();
        var p = this.panel;
        p.style.width = r.width + 'px';
        p.style.left = r.left + 'px';

        // Never let the panel run past the viewport edge; cap its height and
        // let it scroll instead (the stylesheet already sets overflow-y:auto).
        if (this.wrap.classList.contains('is-up')) {
            p.style.top = 'auto';
            p.style.bottom = (window.innerHeight - r.top + 6) + 'px';
            p.style.maxHeight = Math.max(120, r.top - 14) + 'px';
        } else {
            p.style.bottom = 'auto';
            p.style.top = (r.bottom + 6) + 'px';
            p.style.maxHeight = Math.max(120, window.innerHeight - r.bottom - 14) + 'px';
        }
    };

    // While floating, the panel lives on <body>; the .is-open class that
    // reveals it sits on the wrapper, so mirror the open state onto the panel.
    CustomSelect.prototype.detachPanel = function () {
        document.body.appendChild(this.panel);
        this.panel.classList.add('cs-select__panel--fixed');
    };

    CustomSelect.prototype.reattachPanel = function () {
        this.panel.classList.remove('cs-select__panel--fixed', 'is-open');
        this.panel.style.cssText = '';
        this.wrap.appendChild(this.panel);
    };

    CustomSelect.prototype.openPanel = function () {
        if (this.open || this.select.disabled) { return; }

        // Close any other open dropdown first.
        instances.forEach(function (inst) {
            if (inst.open) { inst.closePanel(); }
        });

        // Escape a clipping/stacking ancestor by moving the panel to <body>
        // and positioning it against the viewport.
        this.floating = this.needsFloating();
        if (this.floating) { this.detachPanel(); }

        // Flip upward when the panel would overflow the viewport. Measure the
        // panel itself rather than assuming a height — a 3-option list fits
        // where a 9-option one does not. offsetHeight is readable while the
        // panel is still visibility:hidden.
        var rect = this.trigger.getBoundingClientRect();
        var below = window.innerHeight - rect.bottom - 8;
        var above = rect.top - 8;
        var needed = this.panel.offsetHeight || 240;
        this.wrap.classList.toggle('is-up', below < needed && above > below);

        if (this.floating) {
            this.position();

            // The trigger may still be moving (the .scroll-fade entrance
            // animates transform/opacity). Re-anchor on the following frames
            // so the panel doesn't sit at a stale offset.
            var self = this;
            var frames = 0;
            var track = function () {
                if (!self.open || !self.floating || frames++ > 40) { return; }
                self.position();
                requestAnimationFrame(track);
            };
            requestAnimationFrame(track);
        }

        this.open = true;
        this.wrap.classList.add('is-open');
        if (this.floating) { this.panel.classList.add('is-open'); }
        this.trigger.setAttribute('aria-expanded', 'true');

        var i = this.select.selectedIndex;
        this.setActive(i > -1 ? i : 0);
    };

    CustomSelect.prototype.closePanel = function () {
        if (!this.open) { return; }
        this.open = false;
        this.wrap.classList.remove('is-open');
        this.trigger.setAttribute('aria-expanded', 'false');
        this.options.forEach(function (row) { row.classList.remove('is-active'); });

        if (this.floating) {
            this.floating = false;
            this.reattachPanel();
        }
    };

    CustomSelect.prototype.toggle = function () {
        if (this.open) { this.closePanel(); } else { this.openPanel(); }
    };

    // Commit a choice to the native select and fire the usual events so
    // existing listeners (validation, conditional fields) still run.
    CustomSelect.prototype.choose = function (index) {
        var row = this.options[index];
        if (!row || row.getAttribute('aria-disabled') === 'true') { return; }

        this.select.selectedIndex = index;
        this.syncFromNative();
        this.clearError();
        this.select.dispatchEvent(new Event('input', { bubbles: true }));
        this.select.dispatchEvent(new Event('change', { bubbles: true }));

        this.closePanel();
        this.trigger.focus();
    };

    // Type-ahead: jump to the first option starting with the typed letters.
    CustomSelect.prototype.typeAhead = function (char) {
        var self = this;
        clearTimeout(this.searchTimer);
        this.searchBuffer += char.toLowerCase();
        this.searchTimer = setTimeout(function () { self.searchBuffer = ''; }, 600);

        for (var i = 0; i < this.options.length; i++) {
            var text = this.options[i].textContent.trim().toLowerCase();
            if (text.indexOf(this.searchBuffer) === 0 &&
                this.options[i].getAttribute('aria-disabled') !== 'true') {
                if (this.open) { this.setActive(i); } else { this.choose(i); }
                return;
            }
        }
    };

    CustomSelect.prototype.bind = function () {
        var self = this;

        // Toggle on mousedown so it sequences correctly with the document-level
        // mousedown that closes other panels. (On click, pressing an already-open
        // trigger would close it there and reopen it here.)
        this.trigger.addEventListener('mousedown', function (e) {
            if (e.button !== 0) { return; }
            e.preventDefault();
            e.stopPropagation();
            self.toggle();
        });

        // Keyboard activation of a <button> emits click with no preceding
        // mousedown; Enter/Space are handled in keydown, so ignore it here.
        this.trigger.addEventListener('click', function (e) {
            e.preventDefault();
        });

        // Commit on mouseup: the document mousedown handler preventDefaults
        // presses inside the panel (to hold focus), which suppresses click.
        this.panel.addEventListener('mouseup', function (e) {
            var row = e.target.closest('.cs-select__option');
            if (!row) { return; }
            e.preventDefault();
            e.stopPropagation();
            self.choose(parseInt(row.getAttribute('data-index'), 10));
        });

        this.panel.addEventListener('mousemove', function (e) {
            var row = e.target.closest('.cs-select__option');
            if (row && row.getAttribute('aria-disabled') !== 'true') {
                self.setActive(parseInt(row.getAttribute('data-index'), 10));
            }
        });

        this.trigger.addEventListener('keydown', function (e) {
            var key = e.key;

            if (key === 'ArrowDown' || key === 'ArrowUp') {
                e.preventDefault();
                if (!self.open) {
                    self.openPanel();
                } else {
                    self.move(self.activeIndex, key === 'ArrowDown' ? 1 : -1);
                }
                return;
            }
            if (key === 'Home' || key === 'End') {
                if (!self.open) { return; }
                e.preventDefault();
                if (key === 'Home') {
                    self.move(-1, 1);
                } else {
                    self.move(self.options.length, -1);
                }
                return;
            }
            if (key === 'Enter' || key === ' ' || key === 'Spacebar') {
                e.preventDefault();
                if (self.open) { self.choose(self.activeIndex); } else { self.openPanel(); }
                return;
            }
            // Escape is handled document-level (see below) so it also works
            // when focus has left the trigger.
            if (key === 'Escape') { return; }
            if (key === 'Tab') {
                self.closePanel();
                return;
            }
            if (key && key.length === 1 && !e.ctrlKey && !e.metaKey && !e.altKey) {
                e.preventDefault();
                self.typeAhead(key);
            }
        });

        // Something else changed the native value (JS assignment, server-side
        // repopulation, conditional-field logic) — mirror it.
        this.select.addEventListener('change', function () { self.syncFromNative(); });

        // Native constraint validation failed (e.g. a `required` select left
        // empty). The native element is clipped to 1px, so the browser cannot
        // show its validation bubble there or focus it visibly — the form
        // would just refuse to submit with nothing on screen. Mirror the error
        // state and move focus to the visible trigger instead.
        this.select.addEventListener('invalid', function (e) {
            self.wrap.classList.add('is-invalid');
            e.preventDefault();

            // The suppressed bubble carried the message — render it inline.
            // The browser's own text follows the *browser* locale, which may
            // differ from the page's, so prefer an explicit override, then a
            // page-language default, then whatever the browser supplies.
            var msg = self.select.getAttribute('data-error-message');
            if (!msg) {
                var lang = (document.documentElement.lang || '').slice(0, 2);
                msg = lang === 'fr' ? 'Veuillez sélectionner une option'
                                    : self.select.validationMessage;
            }
            self.showError(msg);

            // Only the first invalid control in the form should take focus.
            var form = self.select.form;
            if (form && !form.__csFocused) {
                form.__csFocused = true;
                setTimeout(function () { form.__csFocused = false; }, 0);
                self.trigger.focus();
                if (self.trigger.scrollIntoView) {
                    self.trigger.scrollIntoView({ block: 'center' });
                }
            }
        });
    };

    // Inline validation message, announced to screen readers via the
    // trigger's aria-describedby. Reuses the page's own error styling
    // conventions (small red text under the field).
    CustomSelect.prototype.showError = function (msg) {
        if (!msg) { return; }
        if (!this.errorEl) {
            this.errorEl = document.createElement('p');
            this.errorEl.className = 'cs-select__error';
            this.errorEl.id = this.id + '-error';
            this.errorEl.setAttribute('role', 'alert');
            this.wrap.parentNode.insertBefore(this.errorEl, this.wrap.nextSibling);
        }
        this.errorEl.textContent = msg;
        this.errorEl.hidden = false;
        this.trigger.setAttribute('aria-describedby', this.errorEl.id);
        this.trigger.setAttribute('aria-invalid', 'true');
    };

    CustomSelect.prototype.clearError = function () {
        this.wrap.classList.remove('is-invalid');
        this.trigger.removeAttribute('aria-invalid');
        this.trigger.removeAttribute('aria-describedby');
        if (this.errorEl) { this.errorEl.hidden = true; }
    };

    CustomSelect.prototype.destroy = function () {
        this.wrap.parentNode.insertBefore(this.select, this.wrap);
        this.select.classList.remove('cs-select__native');
        this.select.removeAttribute('tabindex');
        this.select.removeAttribute('aria-hidden');
        this.wrap.parentNode.removeChild(this.wrap);
    };

    function enhanceAll(root) {
        var scope = root || document;
        var selects = scope.querySelectorAll('select:not(.cs-select__native)');

        Array.prototype.forEach.call(selects, function (select) {
            if (select.hasAttribute('data-no-custom-select')) { return; }
            if (select.multiple || select.size > 1) { return; }
            if (select.closest('.cs-select')) { return; }
            instances.push(new CustomSelect(select));
        });
    }

    // Press outside → close everything. This runs on mousedown, not click:
    // an open panel overlaps whatever sits below it, so waiting for click
    // would let the panel swallow a press aimed at another control.
    document.addEventListener('mousedown', function (e) {
        var inPanel = e.target.closest && e.target.closest('.cs-select__panel');

        // Keep focus on the trigger when pressing an option row.
        if (inPanel) { e.preventDefault(); }

        instances.forEach(function (inst) {
            // A floating panel is a child of <body>, not of the wrapper.
            if (inst.open && !inst.wrap.contains(e.target) && !inst.panel.contains(e.target)) {
                inst.closePanel();
            }
        });
    });

    // Escape at the document level. Clicking a disabled option or a group
    // label moves focus to <body>, so the trigger's own keydown handler
    // would never fire and the panel would stay stuck open over the page.
    document.addEventListener('keydown', function (e) {
        if (e.key !== 'Escape') { return; }
        instances.forEach(function (inst) {
            if (inst.open) {
                inst.closePanel();
                inst.trigger.focus();
            }
        });
    });

    // Close on resize — the flip-up calculation would be stale otherwise.
    window.addEventListener('resize', function () {
        instances.forEach(function (inst) { inst.closePanel(); });
    });

    function closeAll() {
        instances.forEach(function (inst) { inst.closePanel(); });
    }

    // Anything that opens a full-screen layer (mobile nav, Cal.com booking
    // modal) must not have a dropdown floating over it. Close on the way in.
    document.addEventListener('click', function (e) {
        if (!e.target.closest) { return; }
        if (e.target.closest('#mobile-menu-toggle, [data-cal-link], .cal-modal-overlay, [data-modal-open]')) {
            closeAll();
        }
    }, true);

    // Leaving the tab/window with a panel open leaves it stranded on return.
    window.addEventListener('blur', closeAll);
    document.addEventListener('visibilitychange', function () {
        if (document.hidden) { closeAll(); }
    });

    // A viewport-fixed panel doesn't move with its trigger, so re-anchor it
    // while scrolling (capture: catches scroll on any ancestor too).
    window.addEventListener('scroll', function () {
        instances.forEach(function (inst) {
            if (inst.open && inst.floating) { inst.position(); }
        });
    }, true);

    // Wheel/touch scrolling while a dropdown is open must not scroll the page
    // behind it — a native select keeps the page still. `overscroll-behavior`
    // only helps once a container actually scrolls, so a short (non-scrolling)
    // list still chains to the page; cancel those gestures outright.
    //
    // Bound in the capture phase on window: the panel is a child of <body>
    // while floating, so a bubble-phase document listener resolves too late.
    function scrollGuard(e) {
        var open = null;
        for (var n = 0; n < instances.length; n++) {
            if (instances[n].open) { open = instances[n]; break; }
        }
        if (!open || !e.cancelable) { return; }

        var p = open.panel;
        var insidePanel = e.target && e.target.closest && e.target.closest('.cs-select__panel');

        if (insidePanel) {
            // Let the list scroll itself, but never past its own ends.
            if (p.scrollHeight > p.clientHeight + 1) {
                var dy = e.deltaY || 0;
                var atTop = p.scrollTop <= 0;
                var atBottom = p.scrollTop + p.clientHeight >= p.scrollHeight - 1;
                if (!((dy < 0 && atTop) || (dy > 0 && atBottom))) { return; }
            }
        }
        e.preventDefault();
    }

    window.addEventListener('wheel', scrollGuard, { passive: false, capture: true });
    window.addEventListener('touchmove', scrollGuard, { passive: false, capture: true });

    // form.reset() fires after the native values are restored.
    document.addEventListener('reset', function (e) {
        if (e.target.tagName !== 'FORM') { return; }
        setTimeout(function () {
            instances.forEach(function (inst) {
                if (e.target.contains(inst.select)) {
                    inst.clearError();
                    inst.syncFromNative();
                }
            });
        }, 0);
    });

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () { enhanceAll(); });
    } else {
        enhanceAll();
    }

    // Exposed so dynamically injected forms (multi-step, AJAX) can enhance too.
    window.CustomSelect = { enhance: enhanceAll, instances: instances };
})();
