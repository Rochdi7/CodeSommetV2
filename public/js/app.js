/**
 * CodeSommet – Core JavaScript
 * Handles: mobile menu, scroll animations, header scroll behavior, Cal.com
 */

(function () {
    'use strict';

    /* ── Mobile Menu Toggle ───────────────────────────────────────────── */
    const menuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    const iconOpen = document.getElementById('mobile-icon-open');
    const iconClose = document.getElementById('mobile-icon-close');

    function closeMobileMenu() {
        mobileMenu.classList.add('hidden');
        document.body.style.overflow = '';
        menuToggle.setAttribute('aria-expanded', 'false');
        if (iconOpen) iconOpen.classList.remove('hidden');
        if (iconClose) iconClose.classList.add('hidden');
    }

    function openMobileMenu() {
        mobileMenu.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        menuToggle.setAttribute('aria-expanded', 'true');
        if (iconOpen) iconOpen.classList.add('hidden');
        if (iconClose) iconClose.classList.remove('hidden');
    }

    if (menuToggle && mobileMenu) {
        menuToggle.addEventListener('click', function () {
            var isOpen = !mobileMenu.classList.contains('hidden');
            isOpen ? closeMobileMenu() : openMobileMenu();
        });

        // Close menu on link click
        mobileMenu.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', closeMobileMenu);
        });

        // Close on Escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && !mobileMenu.classList.contains('hidden')) {
                closeMobileMenu();
            }
        });

        // Close when clicking outside the panel
        mobileMenu.addEventListener('click', function (e) {
            if (e.target === mobileMenu) closeMobileMenu();
        });
    }

    /* ── Header scroll behavior ───────────────────────────────────────── */
    const desktopHeader = document.querySelector('header.hidden.lg\\:block');
    const mobileHeader = document.querySelector('header.lg\\:hidden');
    let lastScrollY = 0;

    function handleHeaderScroll() {
        const scrollY = window.scrollY;
        const scrollingDown = scrollY > lastScrollY && scrollY > 80;

        if (desktopHeader) {
            if (scrollingDown) {
                desktopHeader.style.transform = 'translateY(-100%)';
            } else {
                desktopHeader.style.transform = 'translateY(0)';
            }
        }

        lastScrollY = scrollY;
    }

    window.addEventListener('scroll', handleHeaderScroll, { passive: true });

    /* ── Hero image fade-in on page load ───────────────────────────────── */
    (function initHeroImageReveal() {
        // Target the desktop hero image container in the first section
        var hero = document.querySelector('section');
        if (!hero) return;
        // Pattern: hidden lg:flex container with an img inside the hero grid
        var imgContainers = hero.querySelectorAll('[class*="hidden"][class*="lg:flex"] img, [class*="hidden"][class*="lg:block"] img');
        imgContainers.forEach(function (img) {
            // Find the wrapper div (the one with h-[...] and hidden lg:flex)
            var wrapper = img.closest('[class*="hidden"][class*="lg:flex"], [class*="hidden"][class*="lg:block"]');
            if (wrapper && !wrapper.classList.contains('hero-img-reveal')) {
                wrapper.classList.add('hero-img-reveal');
            }
        });
    })();

    /* ── Scroll-driven entrance animations ─────────────────────────────── */
    /*
     * Auto-detects layout patterns across ALL pages and applies animations:
     *   • Section headings (h2/h3 blocks)  → fade up
     *   • Two-column layouts (text+image)  → text from left, image from right
     *   • Card grids                       → staggered fade up
     *   • CTA / standalone blocks          → fade up
     * Skips: hero, marquees, already-animated, continuously-animated elements
     */
    function initScrollAnimations() {
        var animated = [];
        var pending = [];

        // Is element inside a continuously animated container (marquee, logo scroll)?
        function isMarquee(el) {
            var p = el.parentElement;
            while (p && p !== document.body) {
                var s = window.getComputedStyle(p);
                if ((s.animationName || '') !== 'none' && s.animationIterationCount === 'infinite') return true;
                if (p.classList && p.classList.contains('logo-scroll-container')) return true;
                p = p.parentElement;
            }
            return false;
        }

        // Tag element for scroll animation. The classList/attribute writes are
        // DEFERRED to a single batch after the whole scan, so the geometry
        // reads below (offsetHeight, getBoundingClientRect) never hit an
        // invalidated layout — this scan used to be the page's main source
        // of forced reflows.
        function tag(el, cls, delay) {
            if (el._stag || isMarquee(el)) return;
            el._stag = true;
            el._stagCls = cls;
            pending.push([el, cls, delay]);
            animated.push(el);
        }

        // Deferred-write equivalent of el.closest('.scroll-fade') /
        // ('.scroll-fade-left'): matches classes already in the HTML AND
        // tags queued this run but not yet written to the DOM.
        function insideFade(el) {
            var p = el;
            while (p) {
                if (p._stagCls === 'scroll-fade' || p._stagCls === 'scroll-fade-left') return true;
                if (p.classList && (p.classList.contains('scroll-fade') || p.classList.contains('scroll-fade-left'))) return true;
                p = p.parentElement;
            }
            return false;
        }

        // Hero boundary — skip first section
        var heroBottom = 0;
        var hero = document.querySelector('section');
        if (hero) heroBottom = hero.getBoundingClientRect().bottom + window.scrollY;

        function belowHero(el) {
            return (el.getBoundingClientRect().top + window.scrollY) > (heroBottom - 50);
        }

        // ── 1. Section headings ─────────────────────────────────────────────
        document.querySelectorAll('section').forEach(function (sec) {
            if (!belowHero(sec)) return;
            // Centered headings
            sec.querySelectorAll('.text-center').forEach(function (el) {
                if (el.querySelector('h2, h3') && el.children.length < 8 && !el._stag) {
                    tag(el, 'scroll-fade');
                }
            });
            // Left-aligned headings inside space-y containers
            var directHeadings = sec.querySelectorAll(':scope > div > div > h2, :scope > div > h2');
            directHeadings.forEach(function (h) {
                var wrap = h.parentElement;
                if (wrap && !wrap._stag && !wrap.classList.contains('text-center') && belowHero(wrap)) {
                    // Don't tag if parent is already a two-col child (handled later)
                    var gridParent = wrap.parentElement;
                    if (gridParent && gridParent.className && gridParent.className.indexOf('grid-cols') !== -1) return;
                    tag(wrap, 'scroll-fade');
                }
            });
        });

        // ── 2. Two-column layouts: directional fades ────────────────────────
        document.querySelectorAll('[class*="grid-cols-2"], [class*="grid-cols-[1"]').forEach(function (grid) {
            if (!belowHero(grid)) return;
            var kids = [];
            for (var k = 0; k < grid.children.length; k++) {
                if (grid.children[k].offsetHeight > 30) kids.push(grid.children[k]);
            }
            if (kids.length !== 2) return;
            // Skip if this looks like a card grid (both children are cards in a list)
            if (grid.closest('[class*="grid-cols-3"]') || grid.closest('[class*="grid-cols-4"]')) return;

            var a = kids[0], b = kids[1];
            var aImg = a.querySelector('img, video, canvas, [class*="h-["]');
            var bImg = b.querySelector('img, video, canvas, [class*="h-["]');
            var aText = a.querySelector('h1, h2, h3');
            var bText = b.querySelector('h1, h2, h3');

            if (aText && bImg) {
                tag(a, 'scroll-fade-left');
                tag(b, 'scroll-fade-right');
            } else if (aImg && bText) {
                tag(a, 'scroll-fade-left');
                tag(b, 'scroll-fade-right');
            } else {
                // Both similar content — staggered fade up
                tag(a, 'scroll-fade', '1');
                tag(b, 'scroll-fade', '2');
            }
        });

        // ── 3. Card grids: staggered fade up ────────────────────────────────
        document.querySelectorAll('[class*="grid-cols"]').forEach(function (grid) {
            if (!belowHero(grid)) return;
            var kids = grid.children;
            if (kids.length < 2) return;

            for (var i = 0; i < kids.length; i++) {
                var child = kids[i];
                if (child.offsetHeight > 50 && !child._stag) {
                    tag(child, 'scroll-fade', Math.min(i + 1, 6));
                }
            }
        });

        // ── 4. Standalone CTA / content blocks ─────────────────────────────
        document.querySelectorAll('section').forEach(function (sec) {
            if (!belowHero(sec)) return;
            // Large rounded blocks with buttons (CTA)
            sec.querySelectorAll('[class*="rounded-2xl"], [class*="rounded-3xl"]').forEach(function (el) {
                if (el.offsetHeight > 100 && el.querySelector('a, button') &&
                    !el._stag && !el.closest('[class*="grid-cols"]') &&
                    !insideFade(el)) {
                    tag(el, 'scroll-fade');
                }
            });
        });

        // ── 5. Legacy: inline style opacity:0 (from earlier edits) ─────────
        document.querySelectorAll('[style*="opacity:0"]').forEach(function (el) {
            if (!el._stag) {
                el._stag = true;
                animated.push(el);
            }
        });

        // Apply every queued class/attribute in one batch — the scan above
        // was pure reads, so this is the first (and only) layout invalidation.
        pending.forEach(function (t) {
            t[0].classList.add(t[1]);
            if (t[2]) t[0].setAttribute('data-delay', String(t[2]));
        });

        if (!animated.length) return;

        // ── IntersectionObserver: reveal on scroll ──────────────────────────
        if ('IntersectionObserver' in window) {
            var observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.08, rootMargin: '0px 0px -30px 0px' });

            animated.forEach(function (el) { observer.observe(el); });
        } else {
            animated.forEach(function (el) { el.classList.add('is-visible'); });
        }
    }

    // Run once the browser is idle: the scan only tags BELOW-fold elements
    // for scroll-reveal (hero excluded by design), so nothing visible depends
    // on it at first paint — running it during load showed up as the page's
    // largest style/layout task in traces.
    function scheduleScrollAnimations() {
        if ('requestIdleCallback' in window) {
            requestIdleCallback(initScrollAnimations, { timeout: 1500 });
        } else {
            setTimeout(initScrollAnimations, 200);
        }
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', scheduleScrollAnimations);
    } else {
        scheduleScrollAnimations();
    }

    /* ── Process steps interactive cards ──────────────────────────────── */
    (function initProcessSteps() {
        var steps = document.querySelectorAll('.process-step');
        var cards = [
            document.getElementById('process-card-1'),
            document.getElementById('process-card-2'),
            document.getElementById('process-card-3')
        ];

        if (!steps.length || !cards[0]) return;

        var currentStep = 1;
        var isHovering = false;
        var autoTimer = null;
        var checkTimers = [];

        function setActiveStep(stepNum) {
            currentStep = stepNum;
            // Clear any running check animations
            checkTimers.forEach(clearTimeout);
            checkTimers = [];

            // Update step styling
            steps.forEach(function(s) {
                var num = parseInt(s.getAttribute('data-step'));
                var badge = s.querySelector('.process-step-badge');
                var title = s.querySelector('.process-step-title');
                var desc = s.querySelector('.process-step-desc');
                var bar = s.querySelector('.process-step-bar');

                if (num === stepNum) {
                    s.classList.remove('bg-gray-50');
                    s.classList.add('bg-white', 'shadow-lg');
                    s.style.transform = 'scale(1.02)';
                    if (badge) { badge.classList.remove('bg-gray-200', 'text-gray-600'); badge.classList.add('bg-[var(--text-primary)]', 'text-white'); }
                    if (title) { title.classList.remove('text-gray-700'); title.classList.add('text-[var(--text-primary)]'); }
                    if (desc) { desc.classList.remove('text-gray-500'); desc.classList.add('text-gray-600'); }
                    if (bar) bar.style.opacity = '1';
                } else {
                    s.classList.remove('bg-white', 'shadow-lg');
                    s.classList.add('bg-gray-50');
                    s.style.transform = 'scale(1)';
                    if (badge) { badge.classList.remove('bg-[var(--text-primary)]', 'text-white'); badge.classList.add('bg-gray-200', 'text-gray-600'); }
                    if (title) { title.classList.remove('text-[var(--text-primary)]'); title.classList.add('text-gray-700'); }
                    if (desc) { desc.classList.remove('text-gray-600'); desc.classList.add('text-gray-500'); }
                    if (bar) bar.style.opacity = '0';
                }
            });

            // Swap card states
            cards.forEach(function(card, i) {
                if (!card) return;
                if (i + 1 === stepNum) {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                    card.classList.remove('pointer-events-none');
                } else {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(30px)';
                    card.classList.add('pointer-events-none');
                }
            });

            // Reset backlog items when leaving step 2
            var backlogItems = document.querySelectorAll('.backlog-item');
            backlogItems.forEach(function(item) {
                item.style.transition = 'none';
                item.style.transform = 'translateY(0)';
                item.style.zIndex = '1';
                item.style.boxShadow = '';
            });

            // Run animations per step
            if (stepNum === 1) { animatePlanCards(); }
            if (stepNum === 2) { animateBacklogCursor(); }
            if (stepNum === 3) { animateChecklist(); }
        }

        // Step 1: cards enter → cursor clicks "Book" → transition to "done" state
        function animatePlanCards() {
            var retainer = document.getElementById('plan-card-retainer');
            var website = document.getElementById('plan-card-website');
            var planDetails = document.getElementById('plan-details');
            var planDone = document.getElementById('plan-done');
            var planCursor = document.getElementById('plan-cursor');
            var bookBtn = document.getElementById('plan-book-btn');
            if (!retainer || !website) return;

            // Reset everything
            retainer.style.transition = 'none';
            website.style.transition = 'none';
            retainer.style.transform = 'translateX(-50%) translateY(-50%) rotate(0deg) scale(0.9)';
            retainer.style.opacity = '0';
            website.style.transform = 'translateX(-50%) translateY(-50%) scale(0.9)';
            website.style.opacity = '0';
            if (planDetails) { planDetails.style.transition = 'none'; planDetails.style.opacity = '1'; }
            if (planDone) { planDone.style.transition = 'none'; planDone.style.opacity = '0'; planDone.classList.add('pointer-events-none'); }
            if (planCursor) { planCursor.style.transition = 'none'; planCursor.style.opacity = '0'; planCursor.style.bottom = '60px'; planCursor.style.right = '80px'; }
            if (bookBtn) { bookBtn.style.background = '#fff'; }

            // 1. Cards entrance
            checkTimers.push(setTimeout(function() {
                retainer.style.transition = 'all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1)';
                retainer.style.transform = 'translateX(-90%) translateY(-35%) rotate(-8deg) scale(1)';
                retainer.style.opacity = '1';
            }, 200));
            checkTimers.push(setTimeout(function() {
                website.style.transition = 'all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1)';
                website.style.transform = 'translateX(-50%) translateY(-50%) scale(1)';
                website.style.opacity = '1';
            }, 450));

            // 2. Show cursor moving toward "Book your Slot"
            checkTimers.push(setTimeout(function() {
                if (planCursor) {
                    planCursor.style.transition = 'opacity 0.4s, bottom 0.8s ease-in-out, right 0.8s ease-in-out';
                    planCursor.style.opacity = '1';
                    planCursor.style.bottom = '42px';
                    planCursor.style.right = '120px';
                }
            }, 2500));

            // 3. Cursor "clicks" — button highlights
            checkTimers.push(setTimeout(function() {
                if (bookBtn) { bookBtn.style.transition = 'background 0.15s'; bookBtn.style.background = '#e5e5e5'; }
            }, 3400));
            checkTimers.push(setTimeout(function() {
                if (bookBtn) { bookBtn.style.background = '#fff'; }
            }, 3600));

            // 4. Fade cursor, transition to "done" state
            checkTimers.push(setTimeout(function() {
                if (planCursor) { planCursor.style.opacity = '0'; }
                if (planDetails) { planDetails.style.transition = 'opacity 0.5s'; planDetails.style.opacity = '0'; }
            }, 3800));
            checkTimers.push(setTimeout(function() {
                if (planDone) { planDone.style.transition = 'opacity 0.5s'; planDone.style.opacity = '1'; planDone.classList.remove('pointer-events-none'); }
            }, 4200));
        }

        // Step 2: cursor grabs the Urgent item and drags it to the top
        function animateBacklogCursor() {
            var cursor = document.getElementById('backlog-cursor');
            var listEl = document.querySelector('.backlog-list');
            if (!cursor || !listEl) return;
            var items = Array.prototype.slice.call(listEl.querySelectorAll('.backlog-item'));
            if (items.length < 3) return;

            // Find the urgent item (index 2 = "Add a contact page")
            var urgentItem = items[2];
            var urgentIdx = 2;

            // Reset all items to normal position
            items.forEach(function(item) {
                item.style.transition = 'none';
                item.style.transform = 'translateY(0)';
                item.style.zIndex = '1';
                item.style.opacity = '1';
                item.style.boxShadow = '';
            });

            cursor.style.transition = 'none';
            cursor.style.opacity = '0';

            checkTimers.push(setTimeout(function() {
                // Use offsetTop — unaffected by CSS rotate transform
                var itemRects = items.map(function(item) {
                    return { top: item.offsetTop, height: item.offsetHeight };
                });

                // Cursor position: center of the urgent item
                var cursorX = 20;
                var cursorStartY = urgentItem.offsetTop + urgentItem.offsetHeight / 2;

                // 1. Show cursor at the urgent item
                cursor.style.left = cursorX + 'px';
                cursor.style.top = cursorStartY + 'px';
                cursor.style.transition = 'left 0.5s ease-in-out, top 0.6s ease-in-out, opacity 0.3s';
                cursor.style.opacity = '1';

                // 2. Start dragging: lift the urgent item
                checkTimers.push(setTimeout(function() {
                    urgentItem.style.transition = 'transform 0.6s ease-in-out, box-shadow 0.3s';
                    urgentItem.style.zIndex = '10';
                    urgentItem.style.boxShadow = '0 8px 25px rgba(0,0,0,0.15)';
                    urgentItem.style.transform = 'scale(1.03)';
                }, 500));

                // 3. Move urgent item up to position 0, push items 0 and 1 down by exactly one item slot
                var moveDistance = itemRects[urgentIdx].top - itemRects[0].top;
                // Gap between items = difference between item 1 top and (item 0 top + item 0 height)
                var gap = itemRects[1].top - (itemRects[0].top + itemRects[0].height);
                var oneSlot = itemRects[urgentIdx].height + gap;

                checkTimers.push(setTimeout(function() {
                    // Move urgent item to top
                    urgentItem.style.transform = 'translateY(-' + moveDistance + 'px) scale(1.03)';
                    cursor.style.top = (cursorStartY - moveDistance) + 'px';

                    // Push items 0 and 1 down by one slot each
                    items[0].style.transition = 'transform 0.6s ease-in-out';
                    items[0].style.transform = 'translateY(' + oneSlot + 'px)';
                    items[1].style.transition = 'transform 0.6s ease-in-out';
                    items[1].style.transform = 'translateY(' + oneSlot + 'px)';
                }, 1200));

                // 4. Drop: remove scale, settle
                checkTimers.push(setTimeout(function() {
                    urgentItem.style.transform = 'translateY(-' + moveDistance + 'px) scale(1)';
                    urgentItem.style.boxShadow = '';
                }, 2000));

                // 5. Fade cursor
                checkTimers.push(setTimeout(function() {
                    cursor.style.opacity = '0';
                }, 2400));

            }, 600));
        }

        // Step 3: cursor visits each checkbox sequentially and checks it
        function animateChecklist() {
            var card3 = document.getElementById('process-card-3');
            if (!card3) return;
            var items = card3.querySelectorAll('.checklist-item');
            var progressBar = document.getElementById('checklist-progress');
            var cursor = document.getElementById('checklist-cursor');
            var listEl = card3.querySelector('.checklist-list');

            // Reset all checkboxes
            items.forEach(function(item) {
                var check = item.querySelector('.checklist-check');
                var text = item.querySelector('.checklist-text');
                var box = item.querySelector('.checklist-box');
                if (check) { check.style.transition = 'none'; check.style.opacity = '0'; check.style.transform = 'scale(0)'; }
                if (text) { text.classList.remove('line-through', 'text-gray-400'); text.classList.add('text-gray-700', 'font-medium'); }
                if (box) { box.classList.remove('bg-[var(--color-primary-orange)]', 'border-[var(--color-primary-orange)]'); box.classList.add('border-gray-300'); }
            });
            if (progressBar) { progressBar.style.transition = 'none'; progressBar.style.width = '0%'; }
            if (cursor) { cursor.style.transition = 'none'; cursor.style.opacity = '0'; }

            // Use offsetTop (not getBoundingClientRect) — unaffected by CSS rotate transform
            checkTimers.push(setTimeout(function() {
                if (!listEl || !cursor || !items.length) return;

                // Get positions: item.offsetTop relative to listEl + half item height
                var pos = [];
                items.forEach(function(item) {
                    pos.push({
                        x: 20,
                        y: item.offsetTop + item.offsetHeight / 2
                    });
                });
                if (!pos.length) return;

                // Show cursor at first item
                cursor.style.left = pos[0].x + 'px';
                cursor.style.top = pos[0].y + 'px';
                cursor.style.transition = 'left 0.4s ease-in-out, top 0.4s ease-in-out, opacity 0.3s';
                cursor.style.opacity = '1';

                // Schedule: for each item, check it then move cursor to next
                var stepTime = 1000;
                for (var i = 0; i < items.length; i++) {
                    (function(idx) {
                        // Check item
                        checkTimers.push(setTimeout(function() {
                            var item = items[idx];
                            var check = item.querySelector('.checklist-check');
                            var text = item.querySelector('.checklist-text');
                            var box = item.querySelector('.checklist-box');
                            if (box) { box.classList.remove('border-gray-300'); box.classList.add('bg-[var(--color-primary-orange)]', 'border-[var(--color-primary-orange)]'); }
                            if (check) { check.style.transition = 'all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1)'; check.style.opacity = '1'; check.style.transform = 'scale(1)'; }
                            if (text) { text.classList.add('line-through', 'text-gray-400'); text.classList.remove('text-gray-700', 'font-medium'); }
                            if (progressBar) { progressBar.style.transition = 'width 0.5s ease-out'; progressBar.style.width = ((idx + 1) / items.length * 100) + '%'; }
                        }, stepTime * idx + 400));

                        // Move cursor to NEXT item
                        if (idx < items.length - 1) {
                            checkTimers.push(setTimeout(function() {
                                cursor.style.left = pos[idx + 1].x + 'px';
                                cursor.style.top = pos[idx + 1].y + 'px';
                            }, stepTime * idx + 750));
                        }
                    })(i);
                }

                // Hide cursor after all done
                checkTimers.push(setTimeout(function() {
                    cursor.style.opacity = '0';
                }, stepTime * items.length + 300));
            }, 600));
        }

        // Hover/click handlers
        steps.forEach(function(step) {
            step.addEventListener('mouseenter', function() {
                isHovering = true;
                if (autoTimer) clearInterval(autoTimer);
                setActiveStep(parseInt(step.getAttribute('data-step')));
            });
            step.addEventListener('mouseleave', function() {
                isHovering = false;
                startAutoRotate();
            });
            step.addEventListener('click', function() {
                setActiveStep(parseInt(step.getAttribute('data-step')));
            });
        });

        // Auto-rotate every 5s
        function startAutoRotate() {
            if (autoTimer) clearInterval(autoTimer);
            autoTimer = setInterval(function() {
                if (!isHovering) {
                    currentStep = currentStep % 3 + 1;
                    setActiveStep(currentStep);
                }
            }, 5000);
        }
        startAutoRotate();
    })();

    /* ── Mobile Process Steps Animations (looping) ─────────────────────── */
    (function initMobileProcessAnimations() {
        // Only run on mobile (when the mobile section is visible)
        var mobStep1 = document.getElementById('mob-step1');
        if (!mobStep1) return;
        // Check if mobile section is actually visible
        if (window.getComputedStyle(mobStep1.parentElement).display === 'none') return;

        var timers = [];

        function clearAllTimers() {
            timers.forEach(clearTimeout);
            timers = [];
        }

        // ── Step 1: Card entrance → cursor clicks Book → "done" state ──
        function animateMobStep1(onComplete) {
            var retainer = document.getElementById('mob-retainer');
            var website = document.getElementById('mob-website');
            var details = document.getElementById('mob-plan-details');
            var done = document.getElementById('mob-plan-done');
            var cursor = document.getElementById('mob-plan-cursor');
            var bookBtn = document.getElementById('mob-book-btn');
            if (!retainer || !website) { if (onComplete) onComplete(); return; }

            // Reset
            retainer.style.transition = 'none';
            website.style.transition = 'none';
            retainer.style.transform = 'translateX(-50%) translateY(-50%) rotate(0deg) scale(0.9)';
            retainer.style.opacity = '0';
            website.style.transform = 'translateX(-50%) translateY(-50%) scale(0.9)';
            website.style.opacity = '0';
            if (details) { details.style.transition = 'none'; details.style.opacity = '1'; }
            if (done) { done.style.transition = 'none'; done.style.opacity = '0'; }
            if (cursor) { cursor.style.transition = 'none'; cursor.style.opacity = '0'; cursor.style.bottom = '40px'; cursor.style.right = '40px'; }
            if (bookBtn) { bookBtn.style.background = '#fff'; }

            // 1. Cards entrance
            timers.push(setTimeout(function() {
                retainer.style.transition = 'all 0.5s cubic-bezier(0.34,1.56,0.64,1)';
                retainer.style.transform = 'translateX(-58%) translateY(-45%) rotate(-8deg) scale(1)';
                retainer.style.opacity = '1';
            }, 200));
            timers.push(setTimeout(function() {
                website.style.transition = 'all 0.5s cubic-bezier(0.34,1.56,0.64,1)';
                website.style.transform = 'translateX(-50%) translateY(-50%) scale(1)';
                website.style.opacity = '1';
            }, 400));

            // 2. Show cursor moving toward Book button
            timers.push(setTimeout(function() {
                if (cursor) {
                    cursor.style.transition = 'opacity 0.3s, bottom 0.6s ease-in-out, right 0.6s ease-in-out';
                    cursor.style.opacity = '1';
                    cursor.style.bottom = '28px';
                    cursor.style.right = '70px';
                }
            }, 1800));

            // 3. Cursor clicks — button flash
            timers.push(setTimeout(function() {
                if (bookBtn) { bookBtn.style.transition = 'background 0.15s'; bookBtn.style.background = '#e5e5e5'; }
            }, 2500));
            timers.push(setTimeout(function() {
                if (bookBtn) { bookBtn.style.background = '#fff'; }
            }, 2700));

            // 4. Fade cursor, transition to done state
            timers.push(setTimeout(function() {
                if (cursor) { cursor.style.opacity = '0'; }
                if (details) { details.style.transition = 'opacity 0.4s'; details.style.opacity = '0'; }
            }, 2900));
            timers.push(setTimeout(function() {
                if (done) { done.style.transition = 'opacity 0.4s'; done.style.opacity = '1'; }
            }, 3300));

            // Complete after 5s
            timers.push(setTimeout(function() {
                if (onComplete) onComplete();
            }, 5000));
        }

        // ── Step 2: Cursor drags Urgent item to top ──
        function animateMobStep2(onComplete) {
            var cursor = document.getElementById('mob-backlog-cursor');
            var listEl = document.getElementById('mob-backlog-list');
            if (!cursor || !listEl) { if (onComplete) onComplete(); return; }
            var items = Array.prototype.slice.call(listEl.querySelectorAll('.mob-backlog-item'));
            if (items.length < 3) { if (onComplete) onComplete(); return; }

            var urgentItem = items[2]; // "Add a contact page" is 3rd (index 2)

            // Reset positions
            items.forEach(function(item) {
                item.style.transition = 'none';
                item.style.transform = 'translateY(0)';
                item.style.zIndex = '1';
                item.style.boxShadow = '';
            });
            cursor.style.transition = 'none';
            cursor.style.opacity = '0';

            timers.push(setTimeout(function() {
                var itemRects = items.map(function(item) {
                    return { top: item.offsetTop, height: item.offsetHeight };
                });
                var cursorStartY = urgentItem.offsetTop + urgentItem.offsetHeight / 2;

                // Show cursor at urgent item
                cursor.style.left = '15px';
                cursor.style.top = cursorStartY + 'px';
                cursor.style.transition = 'left 0.4s ease-in-out, top 0.5s ease-in-out, opacity 0.3s';
                cursor.style.opacity = '1';

                // Lift urgent item
                timers.push(setTimeout(function() {
                    urgentItem.style.transition = 'transform 0.5s ease-in-out, box-shadow 0.3s';
                    urgentItem.style.zIndex = '10';
                    urgentItem.style.boxShadow = '0 6px 20px rgba(0,0,0,0.15)';
                    urgentItem.style.transform = 'scale(1.03)';
                }, 500));

                // Drag to top
                var moveDistance = itemRects[2].top - itemRects[0].top;
                var gap = itemRects[1].top - (itemRects[0].top + itemRects[0].height);
                var oneSlot = itemRects[2].height + gap;

                timers.push(setTimeout(function() {
                    urgentItem.style.transform = 'translateY(-' + moveDistance + 'px) scale(1.03)';
                    cursor.style.top = (cursorStartY - moveDistance) + 'px';
                    items[0].style.transition = 'transform 0.5s ease-in-out';
                    items[0].style.transform = 'translateY(' + oneSlot + 'px)';
                    items[1].style.transition = 'transform 0.5s ease-in-out';
                    items[1].style.transform = 'translateY(' + oneSlot + 'px)';
                }, 1200));

                // Drop
                timers.push(setTimeout(function() {
                    urgentItem.style.transform = 'translateY(-' + moveDistance + 'px) scale(1)';
                    urgentItem.style.boxShadow = '';
                }, 1900));

                // Fade cursor
                timers.push(setTimeout(function() {
                    cursor.style.opacity = '0';
                }, 2300));
            }, 400));

            // Complete after 5s
            timers.push(setTimeout(function() {
                if (onComplete) onComplete();
            }, 5000));
        }

        // ── Step 3: Cursor checks each item sequentially ──
        function animateMobStep3(onComplete) {
            var listEl = document.getElementById('mob-checklist-list');
            var cursor = document.getElementById('mob-checklist-cursor');
            var progressBar = document.getElementById('mob-progress-bar');
            var progressCount = document.getElementById('mob-progress-count');
            if (!listEl || !cursor) { if (onComplete) onComplete(); return; }
            var items = listEl.querySelectorAll('.mob-checklist-item');

            // Reset all checkboxes
            items.forEach(function(item) {
                var icon = item.querySelector('.mob-check-icon');
                var text = item.querySelector('.mob-check-text');
                var box = item.querySelector('.mob-check-box');
                if (icon) { icon.style.transition = 'none'; icon.style.opacity = '0'; icon.style.transform = 'scale(0)'; }
                if (text) { text.classList.remove('line-through', 'text-gray-400'); text.classList.add('text-gray-700'); }
                if (box) { box.style.transition = 'none'; box.className = box.className.replace(/bg-\[var\(--color-primary-orange\)\]/g, '').replace(/border-\[var\(--color-primary-orange\)\]/g, ''); box.classList.add('border-gray-300'); box.style.backgroundColor = ''; box.style.borderColor = ''; }
            });
            if (progressBar) { progressBar.style.transition = 'none'; progressBar.style.width = '0%'; }
            if (progressCount) { progressCount.textContent = '0/4'; }
            cursor.style.transition = 'none';
            cursor.style.opacity = '0';

            timers.push(setTimeout(function() {
                var pos = [];
                items.forEach(function(item) {
                    pos.push({ x: 12, y: item.offsetTop + item.offsetHeight / 2 });
                });
                if (!pos.length) return;

                // Show cursor at first item
                cursor.style.left = pos[0].x + 'px';
                cursor.style.top = pos[0].y + 'px';
                cursor.style.transition = 'left 0.3s ease-in-out, top 0.3s ease-in-out, opacity 0.3s';
                cursor.style.opacity = '1';

                var stepTime = 900;
                for (var i = 0; i < items.length; i++) {
                    (function(idx) {
                        // Check item
                        timers.push(setTimeout(function() {
                            var item = items[idx];
                            var icon = item.querySelector('.mob-check-icon');
                            var text = item.querySelector('.mob-check-text');
                            var box = item.querySelector('.mob-check-box');
                            if (box) { box.style.transition = 'all 0.3s'; box.style.backgroundColor = 'var(--color-primary-orange)'; box.style.borderColor = 'var(--color-primary-orange)'; }
                            if (icon) { icon.style.transition = 'all 0.3s cubic-bezier(0.34,1.56,0.64,1)'; icon.style.opacity = '1'; icon.style.transform = 'scale(1)'; }
                            if (text) { text.classList.add('line-through', 'text-gray-400'); text.classList.remove('text-gray-700'); }
                            if (progressBar) { progressBar.style.transition = 'width 0.4s ease-out'; progressBar.style.width = ((idx + 1) / items.length * 100) + '%'; }
                            if (progressCount) { progressCount.textContent = (idx + 1) + '/4'; }
                        }, stepTime * idx + 400));

                        // Move cursor to next
                        if (idx < items.length - 1) {
                            timers.push(setTimeout(function() {
                                cursor.style.left = pos[idx + 1].x + 'px';
                                cursor.style.top = pos[idx + 1].y + 'px';
                            }, stepTime * idx + 650));
                        }
                    })(i);
                }

                // Fade cursor
                timers.push(setTimeout(function() {
                    cursor.style.opacity = '0';
                }, stepTime * items.length + 300));
            }, 400));

            // Complete after 5s
            timers.push(setTimeout(function() {
                if (onComplete) onComplete();
            }, 5000));
        }

        // ── Intersection Observer: start loop when section is in view ──
        var loopRunning = false;

        function runLoop() {
            if (!loopRunning) return;
            clearAllTimers();
            animateMobStep1(function() {
                if (!loopRunning) return;
                // Step 2 starts after 2s pause
                timers.push(setTimeout(function() {
                    if (!loopRunning) return;
                    animateMobStep2(function() {
                        if (!loopRunning) return;
                        // Step 3 starts after 2s pause
                        timers.push(setTimeout(function() {
                            if (!loopRunning) return;
                            animateMobStep3(function() {
                                if (!loopRunning) return;
                                // Restart loop after 2s pause
                                timers.push(setTimeout(function() {
                                    runLoop();
                                }, 2000));
                            });
                        }, 2000));
                    });
                }, 2000));
            });
        }

        var processSection = document.getElementById('process');
        if (!processSection) return;

        if ('IntersectionObserver' in window) {
            var observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting && !loopRunning) {
                        loopRunning = true;
                        runLoop();
                    } else if (!entry.isIntersecting && loopRunning) {
                        loopRunning = false;
                        clearAllTimers();
                    }
                });
            }, { threshold: 0.2 });
            observer.observe(processSection);
        } else {
            // Fallback: just start
            loopRunning = true;
            runLoop();
        }
    })();

    /* ── Fun Fact auto-rotate (About page) ──────────────────────────────── */
    (function initFunFacts() {
        var textEl = document.getElementById('fun-fact-text');
        var btn    = document.getElementById('fun-fact-btn');
        if (!textEl || !btn) return;

        var facts = [
            "We deliver websites in 7-10 days while most agencies take 8-12 weeks! \u26A1",
            "Our AI-assisted development process is 3x faster than traditional coding! \uD83E\uDD16",
            "We\u2019ve delivered 95+ successful projects across 15+ countries worldwide! \uD83C\uDF0D",
            "Every website we build is conversion-optimized from day one - not just pretty! \uD83D\uDCC8",
            "Our team operates across 3 continents: Dubai, USA, and India! \uD83C\uDF0F",
            "We provide unlimited revisions on retainer plans - yes, truly unlimited! \uD83D\uDD04",
            "Our average client sees their first lead within 48 hours of launch! \uD83C\uDFAF",
            "We use the latest AI tools to deliver enterprise-quality at startup speed! \u2728",
            "48-hour task delivery on retainer - we\u2019re obsessed with speed without compromising quality! \u23F1\uFE0F",
            "Every project includes professional content writing and SEO optimization built-in! \uD83D\uDCDD",
            "We\u2019ve helped businesses across education, healthcare, SaaS, and e-commerce sectors! \uD83D\uDCBC",
            "Our websites are built mobile-first because 70% of your visitors are on phones! \uD83D\uDCF1"
        ];

        var currentIdx = 0;
        var autoTimer  = null;

        function pickNext() {
            var next = (currentIdx + 1) % facts.length;
            currentIdx = next;
            return facts[next];
        }

        function animateTo(newText) {
            textEl.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
            textEl.style.opacity = '0';
            textEl.style.transform = 'translateY(-20px)';
            setTimeout(function() {
                textEl.textContent = newText;
                textEl.style.transform = 'translateY(20px)';
                // Force reflow
                void textEl.offsetWidth;
                textEl.style.opacity = '1';
                textEl.style.transform = 'translateY(0)';
            }, 300);
        }

        function rotateFact() {
            animateTo(pickNext());
        }

        function startAuto() {
            if (autoTimer) clearInterval(autoTimer);
            autoTimer = setInterval(rotateFact, 4000);
        }

        btn.addEventListener('click', function() {
            rotateFact();
            // Reset timer so it doesn't fire right after manual click
            startAuto();
        });

        startAuto();
    })();

    /* ── Flip card tap-to-flip (mobile) ────────────────────────────────── */
    document.querySelectorAll('.flip-card').forEach(function (card) {
        card.addEventListener('click', function () {
            if (window.innerWidth < 768) {
                card.classList.toggle('flipped');
            }
        });
    });

    /* ── Hero rotating text (every 5s) ────────────────────────────────── */
    (function () {
        var phrases = [
            'DES RÉSULTATS',
            'DE LA CROISSANCE',
            'DES CONVERSIONS',
            'PLUS DE PROSPECTS',
            'PLUS DE VENTES',
            'UNE IMAGE DE MARQUE FORTE'
        ];
        var idx = 0;
        var textEl = document.getElementById('hero-rotating-text');
        var wrapperEl = document.getElementById('hero-rotating-wrapper');
        var borderEl = textEl ? textEl.previousElementSibling : null;
        if (!textEl || !wrapperEl) return;

        // The phrase is in normal flow (whitespace-nowrap), so the wrapper
        // auto-sizes to each phrase in the heading's real font context —
        // no offscreen measurement, and a stale width can never make the
        // phrase wrap and overlap the heading. The 0.3s width ease between
        // phrases is done FLIP-style: lock the old width, swap the text,
        // read the new natural width, ease between the two, then release
        // back to auto so font loads and breakpoint changes stay snug.
        wrapperEl.addEventListener('transitionend', function (e) {
            if (e.target === wrapperEl && e.propertyName === 'width') {
                wrapperEl.style.transition = 'none';
                wrapperEl.style.width = '';
            }
        });

        setInterval(function () {
            idx = (idx + 1) % phrases.length;

            // Fade out
            textEl.style.animation = 'none';
            textEl.style.opacity = '0';
            if (borderEl) {
                borderEl.style.animation = 'none';
            }

            var oldWidth = wrapperEl.offsetWidth;
            textEl.textContent = phrases[idx];
            wrapperEl.style.transition = 'none';
            wrapperEl.style.width = '';
            var newWidth = wrapperEl.offsetWidth;
            if (newWidth !== oldWidth) {
                wrapperEl.style.width = oldWidth + 'px';
                void wrapperEl.offsetWidth;
                wrapperEl.style.transition = 'width 0.3s ease-in-out';
                wrapperEl.style.width = newWidth + 'px';
            }

            // Replay animations
            textEl.style.opacity = '';
            textEl.style.animation = 'textFadeIn 0.3s ease-in-out, textReveal 1.2s cubic-bezier(0.22, 1, 0.36, 1)';
            if (borderEl) {
                borderEl.style.animation = 'scaleIn 0.3s ease-out';
            }
        }, 5000);
    })();

    /* ── Testimonials marquee: clone the track client-side ──────────────
       The CSS @keyframes testimonialScroll animation moves the track from
       translateX(0) to translateX(-50%), which requires the track to be
       exactly double-width so the loop is seamless. The server renders the
       testimonials once (real, unique, crawlable text); here we duplicate
       that single track via cloneNode so the required second half exists
       for the animation without shipping the quotes twice in the HTML
       response. ────────────────────────────────────────────────────────── */
    (function () {
        var track = document.getElementById('testimonial-scroll-container');
        if (!track) return;

        var cards = Array.prototype.slice.call(track.children);
        cards.forEach(function (card) {
            var clone = card.cloneNode(true);
            clone.setAttribute('aria-hidden', 'true');
            track.appendChild(clone);
        });

        /* :hover can't pause the marquee on touch devices, so a finger
           tapping a card to read it gets swept away mid-scroll. Pause on
           touch and resume shortly after release. */
        var resumeTimer;
        track.addEventListener('touchstart', function () {
            clearTimeout(resumeTimer);
            track.classList.add('is-paused');
        }, { passive: true });
        track.addEventListener('touchend', function () {
            resumeTimer = setTimeout(function () {
                track.classList.remove('is-paused');
            }, 2500);
        }, { passive: true });
    })();

    /* ── Cal.com is now handled by the official embed script in cal-modal partial ── */

    // Premium Features hover tooltip
    (function() {
        var featureDescriptions = {
            'AI Chatbots': '24/7 intelligent customer support and lead qualification with AI-powered conversations that understand context and provide personalized responses',
            'Booking Systems': 'Automated appointment scheduling with calendar sync, payment integration, and automated reminders for seamless client booking experience',
            'Payment Gateway': 'Secure Stripe, PayPal, and Razorpay integration for instant online payments with subscription management and recurring billing',
            'WhatsApp Business': 'Direct WhatsApp integration for instant lead capture, customer engagement, and automated responses through official WhatsApp Business API',
            'User Dashboards': 'Custom client portals with real-time analytics, interactive data visualization, account management, and personalized user experiences',
            'SEO Optimization': 'Technical SEO, schema markup, Core Web Vitals optimization, and strategic content optimization for top Google rankings and organic traffic',
            'Analytics & Heatmaps': 'Google Analytics 4 integration, user behavior heatmaps, conversion tracking, and data-driven insights for optimization decisions',
            'CRM Integration': 'Seamless sync with HubSpot, Salesforce, and Zoho for automated lead management, pipeline tracking, and customer relationship nurturing',
            'API Integration': 'Custom API development, third-party service integrations via webhooks, REST and GraphQL endpoints for seamless data exchange',
            'E-commerce': 'Full e-commerce platforms with product catalogs, inventory management, secure cart systems, and optimized checkout flows',
            'Authentication': 'Secure login/signup systems with OAuth, Single Sign-On (SSO), multi-factor authentication, and role-based access control',
            'Push Notifications': 'Real-time push notifications via email, SMS, browser alerts, and mobile apps for instant user engagement and updates',
            'Email Automation': 'Automated email campaigns, drip sequences, transactional emails, and personalized newsletters with open rate tracking and A/B testing',
            'Multi-language': 'International websites supporting Arabic, English, and 10+ languages with RTL support, locale detection, and cultural customization',
            'Mobile PWA': 'Progressive Web Apps that work offline, install like native mobile apps, send push notifications, and provide app-like experiences',
            'AI Automation': 'Intelligent workflow automation with AI-powered task execution, predictive scheduling, and smart process optimization',
            'Smart Search': 'AI-powered search with natural language processing, semantic understanding, auto-suggestions, and personalized search results',
            'Global CDN': 'Lightning-fast content delivery with worldwide CDN infrastructure, edge caching, and optimized performance across all continents',
            // French labels
            'Chatbots IA': 'Support client intelligent 24/7 et qualification de leads avec des conversations alimentées par l\'IA qui comprennent le contexte et fournissent des réponses personnalisées',
            'Systèmes de Réservation': 'Planification automatisée de rendez-vous avec synchronisation de calendrier, intégration de paiement et rappels automatisés pour une expérience de réservation fluide',
            'Passerelle de Paiement': 'Intégration sécurisée de Stripe, PayPal et Razorpay pour des paiements en ligne instantanés avec gestion des abonnements et facturation récurrente',
            'Tableaux de Bord Utilisateur': 'Portails clients personnalisés avec analyses en temps réel, visualisation interactive des données, gestion de compte et expériences utilisateur personnalisées',
            'Optimisation SEO': 'SEO technique, balisage schema, optimisation Core Web Vitals et optimisation stratégique du contenu pour un classement Google optimal et du trafic organique',
            'Analytiques & Cartes de Chaleur': 'Intégration Google Analytics 4, cartes de chaleur comportementales, suivi des conversions et insights basés sur les données pour des décisions d\'optimisation',
            'Intégration CRM': 'Synchronisation transparente avec HubSpot, Salesforce et Zoho pour la gestion automatisée des leads, le suivi du pipeline et la fidélisation client',
            'Intégration API': 'Développement d\'API personnalisées, intégrations de services tiers via webhooks, endpoints REST et GraphQL pour un échange de données fluide',
            'E-commerce': 'Plateformes e-commerce complètes avec catalogues de produits, gestion des stocks, systèmes de panier sécurisés et flux de paiement optimisés',
            'Authentification': 'Systèmes de connexion/inscription sécurisés avec OAuth, Single Sign-On (SSO), authentification multifacteur et contrôle d\'accès basé sur les rôles',
            'Notifications Push': 'Notifications push en temps réel par email, SMS, alertes navigateur et applications mobiles pour un engagement utilisateur instantané',
            'Automatisation Email': 'Campagnes email automatisées, séquences drip, emails transactionnels et newsletters personnalisées avec suivi du taux d\'ouverture et tests A/B',
            'Multilingue': 'Sites web internationaux supportant l\'arabe, l\'anglais et plus de 10 langues avec support RTL, détection de la locale et personnalisation culturelle',
            'PWA Mobile': 'Progressive Web Apps fonctionnant hors ligne, s\'installant comme des applications natives, envoyant des notifications push et offrant des expériences similaires aux apps',
            'Automatisation IA': 'Automatisation intelligente des workflows avec exécution de tâches alimentée par l\'IA, planification prédictive et optimisation intelligente des processus',
            'Recherche Intelligente': 'Recherche alimentée par l\'IA avec traitement du langage naturel, compréhension sémantique, suggestions automatiques et résultats de recherche personnalisés',
            'CDN Mondial': 'Livraison de contenu ultra-rapide avec infrastructure CDN mondiale, mise en cache en périphérie et performances optimisées sur tous les continents'
        };

        // Create tooltip element
        var tooltip = document.createElement('div');
        tooltip.id = 'feature-tooltip';
        tooltip.innerHTML = '<div class="feature-tooltip-inner">' +
            '<div class="feature-tooltip-bg"></div>' +
            '<div class="feature-tooltip-dots"></div>' +
            '<div class="feature-tooltip-shine"></div>' +
            '<div class="feature-tooltip-content">' +
            '<div class="feature-tooltip-header">' +
            '<div class="feature-tooltip-icon"></div>' +
            '<h3 class="feature-tooltip-title"></h3>' +
            '</div>' +
            '<p class="feature-tooltip-desc"></p>' +
            '<div class="feature-tooltip-line"></div>' +
            '</div></div>';
        document.body.appendChild(tooltip);

        var isMobile = window.innerWidth < 768;
        window.addEventListener('resize', function() { isMobile = window.innerWidth < 768; });

        // Find all feature pills in the premium features section
        var premiumSection = null;
        document.querySelectorAll('h2').forEach(function(h2) {
            if (h2.textContent.indexOf('18 Premium Features') !== -1 || h2.textContent.indexOf('18 Fonctionnalit') !== -1) {
                var spaceEl = h2.closest('.space-y-4');
                premiumSection = h2.closest('section') || (spaceEl ? spaceEl.parentElement : null);
            }
        });
        if (!premiumSection) return;

        var pills = premiumSection.querySelectorAll('.group.relative.inline-block');
        var hideTimeout = null;
        var activePill = null;

        function hideTooltip() {
            tooltip.classList.remove('visible');
            if (activePill) {
                var inner = activePill.querySelector('[class*="px-5"]');
                if (inner) inner.style.opacity = '1';
                activePill = null;
            }
        }

        function showTooltip(pill, label, desc, iconSvg) {
            clearTimeout(hideTimeout);

            // If switching pills, instantly reset (no transition) before showing new content
            if (activePill && activePill !== pill) {
                var oldInner = activePill.querySelector('[class*="px-5"]');
                if (oldInner) oldInner.style.opacity = '1';
                // Kill transition for instant content swap
                tooltip.style.transition = 'none';
                tooltip.classList.remove('visible');
                // Force reflow so the removal takes effect before re-adding
                void tooltip.offsetHeight;
                tooltip.style.transition = '';
            }

            activePill = pill;

            var rect = pill.getBoundingClientRect();
            var tooltipIcon = tooltip.querySelector('.feature-tooltip-icon');
            var tooltipTitle = tooltip.querySelector('.feature-tooltip-title');
            var tooltipDesc = tooltip.querySelector('.feature-tooltip-desc');

            tooltipTitle.textContent = label;
            tooltipDesc.textContent = desc;
            if (iconSvg) {
                tooltipIcon.innerHTML = '';
                var cloned = iconSvg.cloneNode(true);
                cloned.setAttribute('class', 'w-6 h-6 text-white');
                cloned.setAttribute('stroke-width', '2');
                tooltipIcon.appendChild(cloned);
            }

            // Measure tooltip height to position above the pill
            tooltip.style.left = '-9999px';
            tooltip.style.top = '0';
            tooltip.style.display = 'block';
            tooltip.classList.add('visible');
            var tooltipHeight = tooltip.offsetHeight;

            // Position: centered horizontally on the pill, above it
            var x = Math.min(Math.max(20, rect.left + rect.width / 2 - 160), window.innerWidth - 340);
            var y = Math.max(20, rect.top - tooltipHeight - 12);

            tooltip.style.left = x + 'px';
            tooltip.style.top = y + 'px';

            // Dim the hovered pill slightly
            var inner = pill.querySelector('[class*="px-5"]');
            if (inner) inner.style.opacity = '0.7';
        }

        pills.forEach(function(pill) {
            var span = pill.querySelector('span');
            if (!span) return;
            var label = span.textContent.replace(/\s+/g, ' ').trim();
            var desc = featureDescriptions[label];
            if (!desc) return;

            var iconSvg = pill.querySelector('svg');

            pill.addEventListener('mouseenter', function() {
                if (isMobile) return;
                showTooltip(pill, label, desc, iconSvg);
            });

            pill.addEventListener('mouseleave', function() {
                if (isMobile) return;
                clearTimeout(hideTimeout);
                hideTimeout = setTimeout(hideTooltip, 80);
            });
        });

        // Also pause scrolling when hovering the section rows
        var rows = premiumSection.querySelectorAll('.relative.w-full');
        rows.forEach(function(row) {
            row.addEventListener('mouseenter', function() {
                var scrollDiv = row.querySelector('[style*="animation"]');
                if (scrollDiv) scrollDiv.style.animationPlayState = 'paused';
            });
            row.addEventListener('mouseleave', function() {
                var scrollDiv = row.querySelector('[style*="animation"]');
                if (scrollDiv) scrollDiv.style.animationPlayState = 'running';
            });
        });
    })();


    /* ── Testimonials Carousel (location pages) ──────────────────────── */
    (function () {
        var sections = document.querySelectorAll('section');
        sections.forEach(function (section) {
            var heading = section.querySelector('h2');
            if (!heading || heading.textContent.indexOf('Clients Say') === -1) return;

            var grid = section.querySelector('.grid.grid-cols-1.lg\\:grid-cols-2');
            if (!grid) return;

            var cards = grid.children;
            if (cards.length < 2) return;

            var prevBtn = section.querySelector('button[aria-label="Previous testimonials"]') || section.querySelector('button[aria-label="Précédent testimonials"]');
            var nextBtn = section.querySelector('button[aria-label="Next testimonials"]') || section.querySelector('button[aria-label="Suivant testimonials"]');
            var dotsContainer = section.querySelector('.flex.justify-center.items-center.gap-3');
            var dots = dotsContainer ? dotsContainer.querySelectorAll('button') : [];

            var currentPage = 0;
            var totalPages = dots.length || 1;

            // Build card groups - each page shows 2 cards on desktop, 1 on mobile
            var allCards = Array.prototype.slice.call(cards);

            function isMobileView() {
                return window.innerWidth < 1024;
            }

            function getCardsPerPage() {
                return isMobileView() ? 1 : 2;
            }

            function getTotalPages() {
                var perPage = getCardsPerPage();
                return Math.ceil(allCards.length / perPage);
            }

            function showPage(page) {
                var perPage = getCardsPerPage();
                var total = getTotalPages();
                if (page < 0) page = total - 1;
                if (page >= total) page = 0;
                currentPage = page;

                allCards.forEach(function (card, i) {
                    var start = page * perPage;
                    var end = start + perPage;
                    if (i >= start && i < end) {
                        card.style.display = '';
                        card.style.opacity = '0';
                        card.style.transform = 'translateX(20px)';
                        setTimeout(function () {
                            card.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
                            card.style.opacity = '1';
                            card.style.transform = 'translateX(0)';
                        }, 50);
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Update dots
                dots.forEach(function (dot, i) {
                    if (i < total) {
                        dot.style.display = '';
                        if (i === currentPage) {
                            dot.className = 'transition-all duration-300 rounded-full w-3 h-3 bg-[#00AEEF] scale-125';
                        } else {
                            dot.className = 'transition-all duration-300 rounded-full w-2.5 h-2.5 bg-[#0F0F0F]/20 hover:bg-[#0F0F0F]/40';
                        }
                    } else {
                        dot.style.display = 'none';
                    }
                });
            }

            if (prevBtn) {
                prevBtn.addEventListener('click', function () {
                    showPage(currentPage - 1);
                });
            }
            if (nextBtn) {
                nextBtn.addEventListener('click', function () {
                    showPage(currentPage + 1);
                });
            }
            dots.forEach(function (dot, i) {
                dot.addEventListener('click', function () {
                    showPage(i);
                });
            });

            // Initialize
            showPage(0);

            // Auto-rotate every 6 seconds
            var autoRotate = setInterval(function () {
                showPage(currentPage + 1);
            }, 6000);

            section.addEventListener('mouseenter', function () { clearInterval(autoRotate); });
            section.addEventListener('mouseleave', function () {
                autoRotate = setInterval(function () { showPage(currentPage + 1); }, 6000);
            });

            // Handle resize
            window.addEventListener('resize', function () { showPage(currentPage); });
        });
    })();


    /* ── FAQ Accordion (location pages) ──────────────────────────────── */
    (function () {
        if (window.location.pathname.indexOf('/services/') === 0) return;

        // Accent-insensitive matching (same approach as the services FAQ block):
        // questions are French (sometimes half-English), so match normalized
        // French fragments first with English fallbacks.
        function normalizeText(value) {
            return (value || '')
                .toLowerCase()
                .normalize('NFD')
                .replace(/[̀-ͯ]/g, '')
                .replace(/[^a-z0-9]+/g, ' ')
                .trim();
        }

        var faqAnswers = {
            whyChoose: 'Nous combinons technologie IA de pointe, design premium et livraison rapide. Là où les agences traditionnelles prennent des mois, nous livrons en 7 à 10 jours avec des révisions illimitées. Notre expertise full-stack couvre tout, des tableaux de bord sur mesure aux chatbots IA, pour donner à votre entreprise un vrai avantage concurrentiel.',
            startups: 'Absolument ! Nous travaillons avec des entreprises de toutes tailles, des startups en démarrage aux structures établies. Notre tarification flexible et nos forfaits mensuels sont pensés pour évoluer avec votre croissance, avec des délais courts et la possibilité de mettre en pause ou d\'annuler à tout moment.',
            technologies: 'Nous utilisons des technologies modernes comme Next.js, React, TypeScript, Node.js et Laravel pour le développement web. Côté IA, nous intégrons OpenAI, des chatbots sur mesure et des automatisations intelligentes. Notre stack technique garantit des performances rapides, un excellent SEO et une vraie évolutivité.',
            integrate: 'Oui, nous sommes spécialisés dans l\'intégration avec vos systèmes existants : CRM, ERP, passerelles de paiement, systèmes de réservation et API tierces. Que vous utilisiez Salesforce, HubSpot, Stripe ou des outils internes, nous assurons une intégration fluide en préservant l\'intégrité de vos données.',
            revisions: 'Notre modèle de révisions illimitées signifie exactement cela : nous affinons jusqu\'à ce que vous soyez satisfait à 100 %. Aucune limite au nombre de modifications demandées, chaque révision étant généralement traitée sous 48 à 72 heures, sans coût supplémentaire.',
            support: 'Oui, nous proposons un support continu complet : hébergement premium, maintenance, mises à jour de sécurité, surveillance des performances et mises à jour de contenu. Nos forfaits incluent une collaboration en temps réel sur Slack, ainsi que la correction de bugs et les évolutions après le lancement.',
            remote: 'Notre équipe travaille à distance et accompagne des clients dans le monde entier. Tout se passe en ligne : appels vidéo, collaboration sur Slack et suivi de projet en temps réel, ce qui nous permet de rester très réactifs quel que soit votre fuseau horaire.',
            payment: 'Nous acceptons les principaux moyens de paiement : virement bancaire, carte et PayPal selon votre pays. Le paiement est généralement échelonné par jalons, avec un acompte au démarrage puis le solde à la livraison, factures à l\'appui.',
            compliance: 'Nous concevons des sites conformes aux bonnes pratiques et réglementations applicables, notamment le RGPD pour les données personnelles : consentement aux cookies, politique de confidentialité et sécurisation des données. Pour des exigences sectorielles ou locales spécifiques, nous adaptons la solution avec vous.',
            speed: 'La plupart des sites web sont livrés en 7 à 10 jours après validation du périmètre. Les plateformes plus complexes prennent généralement de 3 à 6 semaines. Nous pouvons aussi lancer une première version rapidement puis itérer par étapes.'
        };

        function findAnswer(questionText) {
            var q = normalizeText(questionText);
            var rules = [
                { fragments: ['pourquoi choisir'], answer: faqAnswers.whyChoose },
                { fragments: ['why choose'], answer: faqAnswers.whyChoose },
                { fragments: ['bureau'], answer: faqAnswers.remote },
                { fragments: ['a distance'], answer: faqAnswers.remote },
                { fragments: ['remote'], answer: faqAnswers.remote },
                { fragments: ['paiement'], answer: faqAnswers.payment },
                { fragments: ['payment'], answer: faqAnswers.payment },
                { fragments: ['conformite'], answer: faqAnswers.compliance },
                { fragments: ['lois'], answer: faqAnswers.compliance },
                { fragments: ['rgpd'], answer: faqAnswers.compliance },
                { fragments: ['compliance'], answer: faqAnswers.compliance },
                { fragments: ['quelle vitesse'], answer: faqAnswers.speed },
                { fragments: ['rapidement', 'lancer'], answer: faqAnswers.speed },
                { fragments: ['delai', 'livraison'], answer: faqAnswers.speed },
                { fragments: ['how fast'], answer: faqAnswers.speed },
                { fragments: ['startup'], answer: faqAnswers.startups },
                { fragments: ['early stage'], answer: faqAnswers.startups },
                { fragments: ['technolog'], answer: faqAnswers.technologies },
                { fragments: ['integr', 'systemes existants'], answer: faqAnswers.integrate },
                { fragments: ['integrate'], answer: faqAnswers.integrate },
                { fragments: ['revisions illimitees'], answer: faqAnswers.revisions },
                { fragments: ['unlimited revision'], answer: faqAnswers.revisions },
                { fragments: ['support continu'], answer: faqAnswers.support },
                { fragments: ['apres le lancement'], answer: faqAnswers.support },
                { fragments: ['ongoing support'], answer: faqAnswers.support },
                { fragments: ['after launch'], answer: faqAnswers.support }
            ];
            for (var i = 0; i < rules.length; i++) {
                var matches = rules[i].fragments.every(function (fragment) {
                    return q.indexOf(fragment) !== -1;
                });
                if (matches) return rules[i].answer;
            }
            return 'Contactez-nous pour en discuter en détail. Nous serons ravis d\'échanger sur vos besoins spécifiques et sur la façon dont nous pouvons aider votre entreprise à grandir.';
        }

        var faqContainers = document.querySelectorAll('.max-w-4xl.mx-auto.bg-white.rounded-2xl.border');
        faqContainers.forEach(function (container) {
            var faqItems = container.querySelectorAll('.border-b');
            faqItems.forEach(function (item) {
                var btn = item.querySelector('button');
                if (!btn) return;

                // Bind each FAQ button only once (shared marker with the other
                // FAQ initializer to prevent double-binding / desynced state).
                if (btn.dataset.faqBound === 'true') return;

                var questionEl = btn.querySelector('h3');
                if (!questionEl) return;

                btn.dataset.faqBound = 'true';

                var chevron = btn.querySelector('svg');
                var questionText = questionEl.textContent;

                // Create answer div
                var answerDiv = document.createElement('div');
                answerDiv.className = 'faq-answer overflow-hidden';
                answerDiv.style.maxHeight = '0';
                answerDiv.style.transition = 'max-height 0.3s ease-out, padding 0.3s ease-out';
                answerDiv.style.padding = '0 16px';
                answerDiv.innerHTML = '<p class="text-[#0F0F0F]/70 text-base leading-relaxed pb-6">' + findAnswer(questionText) + '</p>';
                item.appendChild(answerDiv);

                var isOpen = false;

                btn.addEventListener('click', function () {
                    isOpen = !isOpen;

                    if (isOpen) {
                        answerDiv.style.maxHeight = answerDiv.scrollHeight + 'px';
                        answerDiv.style.padding = '0 16px';
                        if (chevron) {
                            chevron.style.transition = 'transform 0.3s ease';
                            chevron.style.transform = 'rotate(180deg)';
                        }
                        btn.style.backgroundColor = 'rgba(0, 174, 239, 0.05)';
                    } else {
                        answerDiv.style.maxHeight = '0';
                        if (chevron) {
                            chevron.style.transform = 'rotate(0deg)';
                        }
                        btn.style.backgroundColor = '';
                    }
                });
            });
        });
    })();


    /* ── FAQ Accordion (tool pages) ──────────────────────────────────── */
    /* Services Testimonials Carousel */
    (function () {
        if (window.location.pathname.indexOf('/services/') !== 0) return;

        var sections = document.querySelectorAll('section');
        sections.forEach(function (section) {
            var heading = section.querySelector('h2');
            if (!heading || heading.textContent.indexOf('Les Clients Disent de Nous') === -1) return;

            var grid = section.querySelector('.grid.grid-cols-1.lg\\:grid-cols-2');
            var prevBtn = section.querySelector('button[aria-label="Previous testimonials"]') || section.querySelector('button[aria-label="Precedent testimonials"]') || section.querySelector('button[aria-label="Précédent testimonials"]');
            var nextBtn = section.querySelector('button[aria-label="Next testimonials"]') || section.querySelector('button[aria-label="Suivant testimonials"]');
            var dotsContainer = section.querySelector('.flex.justify-center.items-center.gap-3');
            var cards = grid ? Array.prototype.slice.call(grid.children) : [];
            var currentPage = 0;
            var autoRotate = null;
            var dots = [];

            if (!grid || !prevBtn || !nextBtn || cards.length < 2) return;

            function getCardsPerPage() {
                return Math.min(2, cards.length);
            }

            function getTotalPages() {
                return Math.ceil(cards.length / getCardsPerPage());
            }

            function stopAutoRotate() {
                if (autoRotate) {
                    clearInterval(autoRotate);
                    autoRotate = null;
                }
            }

            function startAutoRotate() {
                stopAutoRotate();
                autoRotate = setInterval(function () {
                    showPage(currentPage + 1);
                }, 6000);
            }

            function buildDots() {
                if (!dotsContainer) return;

                var totalPages = getTotalPages();
                dotsContainer.innerHTML = '';

                for (var i = 0; i < totalPages; i += 1) {
                    var dot = document.createElement('button');
                    dot.type = 'button';
                    dot.setAttribute('aria-label', 'Go to testimonial page ' + (i + 1));
                    dot.addEventListener('click', (function (pageIndex) {
                        return function () {
                            stopAutoRotate();
                            showPage(pageIndex);
                            startAutoRotate();
                        };
                    })(i));
                    dotsContainer.appendChild(dot);
                }

                dots = Array.prototype.slice.call(dotsContainer.querySelectorAll('button'));
            }

            function updateDots() {
                dots.forEach(function (dot, index) {
                    dot.className = index === currentPage
                        ? 'transition-all duration-300 rounded-full w-3 h-3 bg-[#00AEEF] scale-125'
                        : 'transition-all duration-300 rounded-full w-2.5 h-2.5 bg-[#0F0F0F]/20 hover:bg-[#0F0F0F]/40';
                });
            }

            function showPage(page) {
                var perPage = getCardsPerPage();
                var totalPages = getTotalPages();

                if (page < 0) page = totalPages - 1;
                if (page >= totalPages) page = 0;
                currentPage = page;

                cards.forEach(function (card, index) {
                    var start = page * perPage;
                    var end = start + perPage;
                    var isVisible = index >= start && index < end;

                    card.style.display = isVisible ? '' : 'none';
                    card.setAttribute('aria-hidden', isVisible ? 'false' : 'true');

                    if (!isVisible) return;

                    card.style.opacity = '0';
                    card.style.transform = 'translateX(20px)';
                    setTimeout(function () {
                        card.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
                        card.style.opacity = '1';
                        card.style.transform = 'translateX(0)';
                    }, 30);
                });

                updateDots();
            }

            if (section.dataset.serviceTestimonialsBound !== 'true') {
                prevBtn.addEventListener('click', function () {
                    stopAutoRotate();
                    showPage(currentPage - 1);
                    startAutoRotate();
                });

                nextBtn.addEventListener('click', function () {
                    stopAutoRotate();
                    showPage(currentPage + 1);
                    startAutoRotate();
                });

                section.addEventListener('mouseenter', stopAutoRotate);
                section.addEventListener('mouseleave', startAutoRotate);
                section.dataset.serviceTestimonialsBound = 'true';
            }

            buildDots();
            showPage(0);
            startAutoRotate();
        });
    })();


    /* Services FAQ Accordion */
    (function () {
        if (window.location.pathname.indexOf('/services/') !== 0) return;

        function normalizeText(value) {
            return (value || '')
                .toLowerCase()
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '')
                .replace(/[^a-z0-9]+/g, ' ')
                .trim();
        }

        function matchesQuestion(questionText, fragments) {
            return fragments.every(function (fragment) {
                return questionText.indexOf(fragment) !== -1;
            });
        }

        function findAnswer(questionText) {
            var q = normalizeText(questionText);
            var rules = [
                {
                    fragments: ['combien', 'temps', 'migrer'],
                    answer: "Une migration depuis Teachable, Thinkific ou Kajabi prend en general 7 a 14 jours selon le volume de cours, de videos, d'etudiants et d'automatisations a reprendre. Nous preparons la bascule sur un environnement de test pour eviter les interruptions."
                },
                {
                    fragments: ['combien', 'puis je economiser'],
                    answer: "Le gain depend de vos frais de plateforme, de vos commissions et de votre volume de ventes. Pour des activites regulieres, une plateforme sur mesure permet souvent de recuperer une part importante de marge des les premiers mois."
                },
                {
                    fragments: ['combien', 'temps', 'plateforme'],
                    answer: "Une plateforme sur mesure prend souvent entre 3 et 6 semaines selon les modules attendus, les integrations et les regles metier. Nous pouvons aussi lancer une V1 rapide puis ajouter les fonctions avancees par etapes."
                },
                {
                    fragments: ['combien', 'temps', 'site web'],
                    answer: "La plupart des sites web sectoriels se livrent en 2 a 4 semaines selon le nombre de pages, le contenu disponible et les integrations. Nous validons d'abord le perimetre pour garder un delai realiste."
                },
                {
                    fragments: ['passerelles', 'paiement'],
                    answer: "Nous integrons les passerelles les plus adaptees a votre marche comme Stripe, PayPal, Checkout.com, CMI ou d'autres solutions locales et internationales. Nous gerons aussi les paiements one-shot, les abonnements, les coupons et les webhooks."
                },
                {
                    fragments: ['stripe'],
                    answer: "Oui, nous integrons Stripe, Adyen, Checkout.com, PayPal et d'autres PSP selon votre pays, vos volumes et vos exigences de conformite. Nous pouvons aussi prendre en charge la fraude, le 3D Secure et les remboursements."
                },
                {
                    fragments: ['variations', 'produits'],
                    answer: "Oui. Nous pouvons gerer les tailles, couleurs, bundles, options personnalisees, regles de prix et variantes complexes avec une gestion simple cote administration."
                },
                {
                    fragments: ['stocks'],
                    answer: "Oui, nous mettons en place le suivi de stock en temps reel, les alertes, la gestion multi-entrepots et le traitement des commandes. Si besoin, nous pouvons aussi connecter votre logistique ou votre ERP."
                },
                {
                    fragments: ['recommandation', 'produits', 'ia'],
                    answer: "Le moteur IA peut utiliser l'historique d'achat, la navigation, les categories et les comportements de clients similaires pour proposer des produits pertinents et augmenter le panier moyen."
                },
                {
                    fragments: ['panier'],
                    answer: "Oui, les clients peuvent sauvegarder leur panier et leurs favoris puis reprendre leur parcours plus tard. C'est utile pour les achats compares et les paniers a cycle plus long."
                },
                {
                    fragments: ['achats mobiles'],
                    answer: "Oui, nous optimisons le parcours mobile, le poids des pages, le checkout et la vitesse de chargement pour garder de bonnes conversions sur smartphone."
                },
                {
                    fragments: ['google shopping'],
                    answer: "Oui, nous pouvons preparer le flux produit, le balisage schema, la structure SEO e-commerce et les bases de vos campagnes Google Shopping avec un tracking propre."
                },
                {
                    fragments: ['teachable', 'thinkific'],
                    answer: "Oui, nous pouvons migrer les cours, chapitres, videos, quiz, etudiants et donnees utiles depuis Teachable ou Thinkific. Nous verifions aussi les redirections et les acces avant la mise en ligne."
                },
                {
                    fragments: ['hebergement', 'video'],
                    answer: "Nous utilisons selon le projet des solutions comme Vimeo, Bunny Stream, Mux, Wistia ou un stockage prive type S3 avec CDN. Le choix depend du volume, du budget et du niveau de controle attendu."
                },
                {
                    fragments: ['marketplace', 'multi instructeurs'],
                    answer: "Oui, nous pouvons construire une marketplace multi-instructeurs avec espaces formateurs, partage de revenus, approbation de contenus, tableaux de bord et gestion des commissions."
                },
                {
                    fragments: ['gamification'],
                    answer: "Oui. Nous pouvons ajouter badges, points, certificats, progression, streaks, classements et rappels intelligents pour renforcer l'engagement et la completion."
                },
                {
                    fragments: ['appareils mobiles'],
                    answer: "Oui, les etudiants peuvent suivre leurs cours sur mobile avec une interface adaptee, progression synchronisee et, selon le besoin, certaines fonctions hors ligne."
                },
                {
                    fragments: ['redaction', 'contenu'],
                    answer: "Oui, nous pouvons vous aider sur l'arborescence, les messages cles, les pages de conversion et les textes SEO. Nous preferons toutefois travailler avec votre expertise metier pour garder un contenu credible."
                },
                {
                    fragments: ['chatbot', 'plusieurs langues'],
                    answer: "Oui, nous pouvons configurer un chatbot IA multilingue en francais, anglais, arabe ou d'autres langues selon votre public. Les reponses peuvent etre alimentees par votre contenu et vos procedures internes."
                },
                {
                    fragments: ['crm'],
                    answer: "Nous integrons regulierement HubSpot, Salesforce, Zoho, Pipedrive et d'autres CRM. Les leads, formulaires, rendez-vous et evenements peuvent etre synchronises automatiquement."
                },
                {
                    fragments: ['portail', 'candidature'],
                    answer: "Oui, nous pouvons creer un portail de candidature avec formulaires avances, upload de documents, suivi d'etapes, notifications et validation par votre equipe."
                },
                {
                    fragments: ['plusieurs devises'],
                    answer: "Oui, nous pouvons prendre en charge plusieurs devises, localiser les moyens de paiement et afficher des montants adaptes au pays de l'utilisateur avec les regles de taxe utiles."
                },
                {
                    fragments: ['qu est ce qui vous differencie'],
                    answer: "Nous combinons execution rapide, design premium et vraie logique produit. Le point cle est que nous adaptons le site ou la plateforme a votre secteur au lieu de livrer un modele generique."
                },
                {
                    fragments: ['google ads'],
                    answer: "Oui, nous pouvons preparer les landing pages, le tracking GA4 et GTM, les events de conversion et les fondations SEO pour soutenir vos campagnes Google Ads."
                },
                {
                    fragments: ['pci dss'],
                    answer: "Oui, nous concevons l'architecture avec les bonnes pratiques PCI-DSS et nous evitons que votre application stocke inutilement des donnees sensibles. La certification formelle depend ensuite de votre perimetre."
                },
                {
                    fragments: ['kyc'],
                    answer: "Nous pouvons integrer des fournisseurs KYC comme Sumsub, Persona, Onfido, Veriff ou d'autres services compatibles avec votre zone geographique et vos contraintes de conformite."
                },
                {
                    fragments: ['trading', 'temps reel'],
                    answer: "Oui, nous pouvons connecter des flux de marche en temps reel, construire des tableaux de bord, des watchlists et des alertes. Le perimetre exact depend ensuite des licences de donnees et des API disponibles."
                },
                {
                    fragments: ['transfrontaliers'],
                    answer: "Oui, nous pouvons gerer les paiements multi-devises, les parcours internationaux, les taux de change et les moyens de paiement adaptes a plusieurs regions."
                },
                {
                    fragments: ['conformite reglementaire'],
                    answer: "Oui, nous pouvons vous accompagner sur les besoins techniques lies a la conformite et travailler avec vos partenaires juridiques ou de licence pour cadrer correctement la solution."
                },
                {
                    fragments: ['donnees', 'temps reel'],
                    answer: "Oui, nous pouvons connecter des donnees en temps reel via API ou webhooks pour afficher soldes, disponibilites, statuts ou indicateurs metier sans retards inutiles."
                },
                {
                    fragments: ['hipaa'],
                    answer: "Oui, la plateforme peut etre concue avec des pratiques compatibles HIPAA comme le controle d'acces, la journalisation, le chiffrement et le choix de fournisseurs appropries. Le cadrage final depend toujours de votre organisation."
                },
                {
                    fragments: ['dse existant'],
                    answer: "Oui, nous pouvons integrer votre DSE via API, middleware ou echanges securises selon ce que permet votre systeme actuel. Nous verifions d'abord les points d'entree, les droits et les limites techniques."
                },
                {
                    fragments: ['dme existant'],
                    answer: "Oui, nous pouvons relier votre DME existant si une API, un connecteur ou un flux securise est disponible. Une phase de test est prevue pour fiabiliser les synchronisations sensibles."
                },
                {
                    fragments: ['formation', 'personnel'],
                    answer: "Oui, nous prevoyons une formation equipe, une documentation claire et une passation pour que vos collaborateurs puissent utiliser l'outil sans dependance inutile."
                },
                {
                    fragments: ['rendez vous en ligne'],
                    answer: "Oui, les patients peuvent reserver 24 h sur 24 avec choix du praticien, disponibilites, confirmations et rappels automatiques pour reduire les oublis."
                },
                {
                    fragments: ['telemedecine'],
                    answer: "Nous pouvons mettre en place une experience de telemedecine avec video securisee, salle d'attente, gestion de rendez-vous, comptes patients et historique utile au suivi."
                },
                {
                    fragments: ['absenteisme'],
                    answer: "Oui, avec rappels SMS et email, confirmations, reprogrammation simple et suivi des no-shows, il est possible de reduire nettement le taux d'absenteisme."
                },
                {
                    fragments: ['eligibilite', 'visa'],
                    answer: "Oui, nous pouvons creer des calculateurs d'eligibilite visa avec questions conditionnelles, scores, orientation par pays et capture de lead en fin de parcours."
                },
                {
                    fragments: ['suivi de dossiers'],
                    answer: "Oui, nous pouvons mettre en place un espace client avec suivi de dossier, checklist, demandes de documents, statut des etapes et notifications."
                },
                {
                    fragments: ['rgpd'],
                    answer: "Nous appliquons des mesures comme le chiffrement, les droits d'acces, les journaux, les consentements et une gestion propre des donnees personnelles pour rester alignes avec les bonnes pratiques RGPD."
                },
                {
                    fragments: ['hubspot'],
                    answer: "Oui, HubSpot, Salesforce, Zoho et d'autres CRM peuvent etre relies pour synchroniser prospects, dossiers, taches et relances commerciales."
                },
                {
                    fragments: ['types de visa'],
                    answer: "Oui, chaque pays et chaque type de visa peut avoir son propre parcours, ses documents requis, ses regles et ses automations dans le meme systeme."
                },
                {
                    fragments: ['perdre des etudiants'],
                    answer: "Non, pas si la migration est planifiee proprement. Nous migrons le contenu, conservons les acces, preparons les redirections utiles et validons le tout avant la bascule publique."
                },
                {
                    fragments: ['abonnements', 'plans de paiement'],
                    answer: "Oui, nous pouvons proposer des abonnements, des plans de paiement fractionnes, des coupons, des essais gratuits et des relances de paiement selon votre modele commercial."
                },
                {
                    fragments: ['contenu progressif'],
                    answer: "Oui, nous pouvons gerer le drip content, les prerequis, la planification des modules et l'ouverture automatique des lecons selon vos regles pedagogiques."
                },
                {
                    fragments: ['meilleur seo'],
                    answer: "Oui, une plateforme sur mesure donne un controle SEO beaucoup plus fin que les solutions fermees. Vous maitrisez l'URL, le balisage, la structure des pages et la performance."
                },
                {
                    fragments: ['teachable n offre pas'],
                    answer: "C'est justement l'avantage du sur-mesure. Si une fonctionnalite utile n'existe pas dans Teachable ou Kajabi, nous pouvons la concevoir autour de votre logique produit."
                },
                {
                    fragments: ['mls'],
                    answer: "Oui, nous pouvons integrer MLS, IDX ou vos flux immobiliers locaux selon les connecteurs et les droits disponibles, puis adapter la recherche a votre marche."
                },
                {
                    fragments: ['visites virtuelles'],
                    answer: "Oui, nous supportons les visites 360, les galeries interactives, les videos et des integrations comme Matterport pour mieux valoriser les biens."
                },
                {
                    fragments: ['agents', 'propres annonces'],
                    answer: "Oui, chaque agent peut disposer de son espace pour publier, modifier et suivre ses annonces, ses leads et ses performances sans exposer les donnees des autres."
                },
                {
                    fragments: ['prospects'],
                    answer: "Nous pouvons integrer un CRM immobilier pour capter, qualifier, distribuer et suivre les prospects avec historique, relances et attribution aux agents."
                },
                {
                    fragments: ['filtres', 'carte'],
                    answer: "Oui, nous pouvons ajouter des filtres avances par prix, surface, quartier, type de bien et disponibilite, ainsi qu'une carte interactive pour la recherche geolocalisee."
                },
                {
                    fragments: ['biens favoris'],
                    answer: "Oui, les acheteurs peuvent creer un compte, enregistrer leurs biens favoris, comparer des annonces et recevoir des alertes sur les nouvelles opportunites."
                },
                {
                    fragments: ['seo immobilier'],
                    answer: "Oui, nous optimisons les pages de ville, les fiches biens, le schema markup et les parcours de conversion, puis nous preparons le terrain pour vos campagnes Google Ads."
                },
                {
                    fragments: ['10 000 utilisateurs'],
                    answer: "Oui, nous pouvons concevoir une architecture evolutive avec separation claire du front, du back, du cache, des files de taches et de la base de donnees pour absorber la croissance."
                },
                {
                    fragments: ['facturation'],
                    answer: "Nous integrons selon le modele Stripe Billing, Paddle, Lemon Squeezy ou une logique de facturation plus personnalisee avec essais, plans, prorata et webhooks."
                },
                {
                    fragments: ['marque blanche'],
                    answer: "Oui, nous pouvons livrer une plateforme SaaS en marque blanche avec theming, domaines personnalises, parametrage client et une base produit reutilisable."
                },
                {
                    fragments: ['api'],
                    answer: "Oui, nous pouvons developper vos API REST ou GraphQL, gerer l'authentification, les permissions et la documentation pour vos partenaires ou clients."
                },
                {
                    fragments: ['publicite payante'],
                    answer: "Oui, nous pouvons preparer les pages de conversion, le tracking et les fondations SEO et SEA pour soutenir la croissance d'une plateforme SaaS apres le lancement."
                },
                {
                    fragments: ['documents de visa'],
                    answer: "Oui, nous pouvons suivre chaque document requis, son statut, ses dates limites, les validations internes et les relances automatiques vers l'etudiant."
                },
                {
                    fragments: ['mots cles', 'etudes a l etranger'],
                    answer: "Oui, nous pouvons structurer le site autour des mots-cles etudes a l'etranger, visas, destinations et programmes puis relier le tout a des landing pages performantes."
                },
                {
                    fragments: ['symptomes', 'ia'],
                    answer: "Oui, l'IA peut aider au pre-triage avec des questionnaires guides et des regles de securite. Elle ne remplace pas le jugement medical, mais elle peut accelerer l'orientation des patients."
                },
                {
                    fragments: ['plateforme video'],
                    answer: "Nous utilisons selon le besoin des solutions comme Twilio Video, Daily, Zoom SDK ou d'autres briques video securisees selon la qualite, le budget et la conformite attendus."
                },
                {
                    fragments: ['internationaux'],
                    answer: "Oui, nous pouvons gerer plusieurs fuseaux horaires, devises, langues et parcours patient pour des services de telemedecine a portee internationale, dans la limite des regles applicables."
                },
                {
                    fragments: ['prescriptions'],
                    answer: "Nous pouvons integrer des workflows de prescription securises, des validations internes et, si necessaire, des connexions a des services tiers ou logiciels metier."
                },
                {
                    fragments: ['commercialiser'],
                    answer: "Oui, nous pouvons vous aider sur la structure d'acquisition, les landing pages, le tracking, le SEO et les parcours de conversion pour soutenir le lancement commercial."
                },
                {
                    fragments: ['lms existant'],
                    answer: "Oui, nous pouvons nous integrer a Moodle, Canvas, Blackboard et d'autres LMS si des API ou connecteurs sont disponibles. Nous cadrons ensuite les flux de comptes, notes et contenus."
                },
                {
                    fragments: ['ferpa'],
                    answer: "Oui, nous pouvons structurer la plateforme avec de bonnes pratiques FERPA sur les acces, la confidentialite, les journaux et la separation des roles."
                },
                {
                    fragments: ['devise locale'],
                    answer: "Oui, les etudiants internationaux peuvent postuler et payer dans leur devise locale si le prestataire de paiement et votre modele de facturation le permettent."
                },
                {
                    fragments: ['verification', 'documents', 'admissions'],
                    answer: "Nous mettons en place un upload securise, des checklists, une validation interne, des statuts clairs et des notifications pour fluidifier la verification des dossiers d'admission."
                },
                {
                    fragments: ['statut', 'candidature'],
                    answer: "Oui, un portail peut permettre aux etudiants de suivre en temps reel le statut de leur candidature, les documents manquants et les prochaines actions attendues."
                },
                {
                    fragments: ['admission', 'enseignants'],
                    answer: "Oui, nous prevoyons onboarding, documentation et sessions de formation pour les equipes d'admission, les enseignants et les administrateurs."
                },
                {
                    fragments: ['plusieurs campus'],
                    answer: "Oui, un seul back-office peut gerer plusieurs campus, programmes, equipes et flux d'admission avec des permissions et des rapports distincts."
                }
            ];

            for (var i = 0; i < rules.length; i += 1) {
                if (matchesQuestion(q, rules[i].fragments)) {
                    return rules[i].answer;
                }
            }

            return "Oui, nous pouvons adapter cette partie a votre besoin metier et vous proposer une reponse precise apres avoir valide vos contraintes techniques, contenu et integrations.";
        }

        function closeItem(item, button, chevron, answerDiv) {
            item.dataset.open = 'false';
            answerDiv.style.maxHeight = '0';
            if (chevron) {
                chevron.style.transition = 'transform 0.3s ease';
                chevron.style.transform = 'rotate(0deg)';
            }
            button.style.backgroundColor = '';
        }

        function openItem(item, button, chevron, answerDiv) {
            item.dataset.open = 'true';
            answerDiv.style.maxHeight = answerDiv.scrollHeight + 'px';
            if (chevron) {
                chevron.style.transition = 'transform 0.3s ease';
                chevron.style.transform = 'rotate(180deg)';
            }
            button.style.backgroundColor = 'rgba(0, 174, 239, 0.05)';
        }

        var faqContainers = document.querySelectorAll('.max-w-4xl.mx-auto.bg-white.rounded-2xl.border');
        faqContainers.forEach(function (container) {
            var faqItems = container.querySelectorAll('.border-b');

            faqItems.forEach(function (item) {
                var btn = item.querySelector('button');
                if (!btn || btn.dataset.faqBound === 'true') return;

                var questionEl = btn.querySelector('h3');
                if (!questionEl) return;

                var chevron = btn.querySelector('svg');
                var answerDiv = item.querySelector('.faq-answer');

                if (!answerDiv) {
                    answerDiv = document.createElement('div');
                    answerDiv.className = 'faq-answer overflow-hidden';
                    answerDiv.style.maxHeight = '0';
                    answerDiv.style.transition = 'max-height 0.3s ease';
                    item.appendChild(answerDiv);
                }

                answerDiv.innerHTML = '<div class="px-6 pb-6"><p class="text-[#0F0F0F]/70 text-base leading-relaxed">' + findAnswer(questionEl.textContent) + '</p></div>';
                closeItem(item, btn, chevron, answerDiv);
                btn.dataset.faqBound = 'true';

                btn.addEventListener('click', function () {
                    var shouldOpen = item.dataset.open !== 'true';

                    faqItems.forEach(function (otherItem) {
                        var otherBtn = otherItem.querySelector('button');
                        var otherChevron = otherBtn ? otherBtn.querySelector('svg') : null;
                        var otherAnswerDiv = otherItem.querySelector('.faq-answer');
                        if (!otherBtn || !otherAnswerDiv) return;
                        closeItem(otherItem, otherBtn, otherChevron, otherAnswerDiv);
                    });

                    if (shouldOpen) {
                        openItem(item, btn, chevron, answerDiv);
                    }
                });
            });
        });
    })();


    /* Tool FAQ Accordion */
    (function () {
        if (window.location.pathname.indexOf('/tools/') !== 0) return;

        var faqAnswers = document.querySelectorAll('.faq-answer');
        if (!faqAnswers.length) return;

        faqAnswers.forEach(function (answer) {
            var btn = answer.previousElementSibling;
            if (!btn || btn.tagName !== 'BUTTON') return;

            var chevron = btn.querySelector('svg');

            btn.addEventListener('click', function () {
                var isHidden = answer.classList.contains('hidden');

                if (isHidden) {
                    answer.classList.remove('hidden');
                    if (chevron) {
                        chevron.style.transition = 'transform 0.3s ease';
                        chevron.style.transform = 'rotate(180deg)';
                    }
                    btn.style.backgroundColor = 'rgba(0, 174, 239, 0.05)';
                } else {
                    answer.classList.add('hidden');
                    if (chevron) {
                        chevron.style.transform = 'rotate(0deg)';
                    }
                    btn.style.backgroundColor = '';
                }
            });
        });
    })();


    /* ── Case-study screenshot tabs (our-work pages) ─────────────────── */
    /* The per-tab screenshot assets from the original site were not exported,
     * so the tabs only reflect the active selection state. */
    (function () {
        if (window.location.pathname.indexOf('/our-work/') !== 0) return;

        var containers = document.querySelectorAll('div.flex.justify-center.gap-2.mb-8.flex-wrap');
        containers.forEach(function (container) {
            var btns = container.querySelectorAll('button');
            if (btns.length < 2) return;

            btns.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    btns.forEach(function (b) {
                        b.classList.remove('bg-[#00AEEF]', 'text-white', 'shadow-md');
                        b.classList.add('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
                    });
                    btn.classList.add('bg-[#00AEEF]', 'text-white', 'shadow-md');
                    btn.classList.remove('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
                });
            });
        });
    })();


    /* ── Retainer Social Media Toggle (location pages) ───────────────── */
    (function () {
        // Find retainer toggle button by text content (FR or EN)
        var allButtons = document.querySelectorAll('button');
        var toggleBtn = null;
        allButtons.forEach(function (btn) {
            var txt = btn.textContent.trim();
            if ((txt.indexOf('Include Social Media') !== -1 || (txt.indexOf('Inclure') !== -1 && txt.indexOf('seaux Sociaux') !== -1)) && !btn.id) {
                toggleBtn = btn;
            }
        });
        if (!toggleBtn) return;

        // Find the retainer card container
        var retainerCard = toggleBtn.closest('.relative.bg-white.rounded-\\[32px\\]') || toggleBtn.closest('[class*="bg-white"][class*="rounded-[32px]"]');
        if (!retainerCard) {
            // Try finding by walking up
            var el = toggleBtn.parentElement;
            while (el) {
                if (el.classList.contains('bg-white') && el.className.indexOf('rounded-[32px]') !== -1) {
                    retainerCard = el;
                    break;
                }
                el = el.parentElement;
            }
        }
        if (!retainerCard) return;

        var innerCard = retainerCard.querySelector('[class*="rounded-[20px]"]');
        var toggleTrack = toggleBtn.querySelector('[class*="rounded-full"][class*="bg-black/20"]') ||
                          toggleBtn.querySelector('div.relative.rounded-full');
        var toggleDot = toggleTrack ? toggleTrack.querySelector('.absolute.rounded-full.bg-white') : null;
        var toggleText = toggleBtn.querySelector('span');
        var infinityIcon = retainerCard.querySelector('.lucide-infinity') ||
                          retainerCard.querySelector('svg path[d*="M6 16c5 0 7-8"]');
        if (infinityIcon && infinityIcon.tagName !== 'svg') infinityIcon = infinityIcon.closest('svg');
        var iconWrap = infinityIcon ? infinityIcon.parentElement : null;
        var titleH3 = retainerCard.querySelector('h3');
        var descP = retainerCard.querySelector('.text-black\\/70, p.text-black\\/70') ||
                    retainerCard.querySelector('p[class*="text-black/70"]');
        if (!descP) {
            var allP = retainerCard.querySelectorAll('p');
            allP.forEach(function(p) {
                if (p.textContent.indexOf('Perfect for businesses') !== -1 || p.textContent.indexOf('Parfait pour les entreprises') !== -1) descP = p;
            });
        }

        var featuresContainer = innerCard ? innerCard.querySelector('.divide-y') : null;

        var isActive = false;

        // Social features HTML to inject
        var socialFeaturesHTML = '<div class="retainer-social-features" style="display:none">' +
            '<div class="flex items-start gap-3 py-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-share2 w-5 h-5 text-[var(--color-primary-orange)] mt-0.5 flex-shrink-0"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" x2="15.42" y1="13.51" y2="17.49"></line><line x1="15.41" x2="8.59" y1="6.51" y2="10.49"></line></svg><span class="text-[var(--color-primary-orange)]">Gestion professionnelle des réseaux sociaux</span></div>' +
            '<div class="flex items-start gap-3 py-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sparkles w-5 h-5 text-[var(--color-primary-orange)] mt-0.5 flex-shrink-0"><path d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z"></path><path d="M20 2v4"></path><path d="M22 4h-4"></path><circle cx="4" cy="20" r="2"></circle></svg><span class="text-[var(--color-primary-orange)]">Création de contenu pour toutes les plateformes</span></div>' +
            '<div class="flex items-start gap-3 py-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar w-5 h-5 text-[var(--color-primary-orange)] mt-0.5 flex-shrink-0"><path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path></svg><span class="text-[var(--color-primary-orange)]">Publication stratégique & planification</span></div>' +
            '<div class="flex items-start gap-3 py-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chart-column w-5 h-5 text-[var(--color-primary-orange)] mt-0.5 flex-shrink-0"><path d="M3 3v16a2 2 0 0 0 2 2h16"></path><path d="M18 17V9"></path><path d="M13 17V5"></path><path d="M8 17v-3"></path></svg><span class="text-[var(--color-primary-orange)]">Rapports mensuels d\'analytique & croissance</span></div>' +
            '</div>';

        // Inject social features at the top of the features container
        if (featuresContainer && !featuresContainer.querySelector('.retainer-social-features')) {
            featuresContainer.insertAdjacentHTML('afterbegin', socialFeaturesHTML);
        }

        var socialFeatures = featuresContainer ? featuresContainer.querySelector('.retainer-social-features') : null;

        // Fix toggle button styling to match home page
        toggleBtn.className = 'flex items-center rounded-full transition-all duration-400 ease-out gap-0 p-0 bg-transparent';
        toggleBtn.style.marginTop = '9px';
        if (toggleTrack) {
            toggleTrack.className = 'relative rounded-full transition-all duration-400 ease-out w-14 h-7 bg-black/20';
        }
        if (toggleDot) {
            toggleDot.className = 'absolute top-0.5 w-6 h-6 rounded-full bg-white transition-all duration-400 ease-out left-0.5';
        }
        if (toggleText) {
            toggleText.className = 'text-sm whitespace-nowrap overflow-hidden transition-all duration-400 ease-out ml-2';
        }

        toggleBtn.addEventListener('click', function () {
            isActive = !isActive;

            if (isActive) {
                // Activate social
                if (innerCard) {
                    innerCard.style.borderColor = 'var(--color-primary-orange)';
                    innerCard.style.borderWidth = '2px';
                }
                if (toggleTrack) {
                    toggleTrack.classList.remove('bg-black/20');
                    toggleTrack.classList.add('bg-[var(--color-primary-orange)]');
                    toggleTrack.style.boxShadow = 'rgba(0, 174, 239, 0.4) 0px 0px 12px, rgba(0, 174, 239, 0.2) 0px 0px 24px';
                    // Force the orange background via inline style as fallback
                    toggleTrack.style.backgroundColor = 'var(--color-primary-orange)';
                }
                if (toggleDot) {
                    toggleDot.classList.remove('left-0.5');
                    toggleDot.classList.add('left-7');
                }
                if (toggleText) {
                    toggleText.style.opacity = '0';
                    toggleText.style.width = '0';
                    toggleText.style.marginLeft = '0';
                }
                if (titleH3) {
                    if (!titleH3.querySelector('.retainer-social-badge')) {
                        titleH3.insertAdjacentHTML('beforeend', ' <span class="retainer-social-badge text-[var(--color-primary-orange)]">+Social</span>');
                    }
                }
                if (descP) {
                    descP.textContent = 'Transformation digitale complète avec gestion des réseaux sociaux et stratégie de contenu.';
                }
                if (socialFeatures) {
                    socialFeatures.style.display = '';
                }
            } else {
                // Deactivate social
                if (innerCard) {
                    innerCard.style.borderColor = 'transparent';
                }
                if (toggleTrack) {
                    toggleTrack.classList.add('bg-black/20');
                    toggleTrack.classList.remove('bg-[var(--color-primary-orange)]');
                    toggleTrack.style.boxShadow = 'none';
                    toggleTrack.style.backgroundColor = '';
                }
                if (toggleDot) {
                    toggleDot.classList.add('left-0.5');
                    toggleDot.classList.remove('left-7');
                }
                if (toggleText) {
                    toggleText.style.opacity = '1';
                    toggleText.style.width = 'auto';
                    toggleText.style.marginLeft = '';
                    toggleText.classList.add('ml-2');
                }
                var badge = titleH3 ? titleH3.querySelector('.retainer-social-badge') : null;
                if (badge) badge.remove();
                if (descP) {
                    descP.textContent = 'Parfait pour les entreprises ayant besoin de fonctionnalités IA continues, de tableaux de bord et d\'améliorations de site web.';
                }
                if (socialFeatures) {
                    socialFeatures.style.display = 'none';
                }
            }
        });
    })();


    /* ── Count-Up Animation for .count-up elements (service hero stats) ── */
    (function () {
        var countEls = document.querySelectorAll('.count-up[data-target]');
        if (!countEls.length) return;

        function animateCountUp(el, target) {
            var duration = 2000;
            var suffix = el.getAttribute('data-suffix') || '+';
            var increment = target / (duration / 16);
            var current = 0;
            var timer = setInterval(function () {
                current += increment;
                if (current >= target) {
                    el.textContent = target + suffix;
                    clearInterval(timer);
                } else {
                    el.textContent = Math.floor(current) + suffix;
                }
            }, 16);
        }

        if ('IntersectionObserver' in window) {
            countEls.forEach(function (el) {
                var animated = false;
                var obs = new IntersectionObserver(function (entries) {
                    if (entries[0].isIntersecting && !animated) {
                        animated = true;
                        animateCountUp(el, parseInt(el.getAttribute('data-target'), 10));
                        obs.disconnect();
                    }
                }, {threshold: 0.1});
                obs.observe(el);
            });
        } else {
            countEls.forEach(function (el) {
                el.textContent = el.getAttribute('data-target') + (el.getAttribute('data-suffix') || '+');
            });
        }
    })();

    /* ── Count-Up Animation (location + service pages) ───────────────── */
    (function () {
        // Find all spans that contain "0" and are followed by "+ Leads" or "+ Clients"
        var statSpans = document.querySelectorAll('span.font-semibold');

        statSpans.forEach(function (parentSpan) {
            var innerSpan = parentSpan.querySelector('span');
            if (!innerSpan) return;

            var text = parentSpan.textContent.trim();
            var isLeads = text.indexOf('+ Leads') !== -1;
            var isClients = text.indexOf('+ Clients') !== -1;

            if (!isLeads && !isClients) return;
            if (innerSpan.textContent.trim() !== '0') return;

            // Determine target value from page slug
            var slug = window.location.pathname.replace(/^\//, '').replace(/\/$/, '');
            var targetValue = 0;

            // Location page metrics (leads: 150-500, clients: 25-50)
            var cityMetrics = {
                'web-development/abudhabi': {leads: 180, clients: 28},
                'web-development/amsterdam': {leads: 220, clients: 32},
                'web-development/austin': {leads: 250, clients: 35},
                'web-development/barcelona': {leads: 200, clients: 30},
                'web-development/berlin': {leads: 230, clients: 33},
                'web-development/boston': {leads: 240, clients: 34},
                'web-development/brussels': {leads: 190, clients: 29},
                'web-development/cairo': {leads: 170, clients: 27},
                'web-development/casablanca': {leads: 200, clients: 30},
                'web-development/chicago': {leads: 260, clients: 36},
                'web-development/copenhagen': {leads: 210, clients: 31},
                'web-development/denver': {leads: 230, clients: 33},
                'web-development/dubai': {leads: 280, clients: 38},
                'web-development/dublin': {leads: 200, clients: 30},
                'web-development/lagos': {leads: 180, clients: 27},
                'web-development/lisbon': {leads: 190, clients: 29},
                'web-development/london': {leads: 300, clients: 40},
                'web-development/los-angeles': {leads: 320, clients: 42},
                'web-development/madrid': {leads: 210, clients: 31},
                'web-development/marrakech': {leads: 160, clients: 26},
                'web-development/milan': {leads: 210, clients: 31},
                'web-development/new-york': {leads: 350, clients: 45},
                'web-development/paris': {leads: 270, clients: 37},
                'web-development/rabat': {leads: 160, clients: 26},
                'web-development/rome': {leads: 200, clients: 30},
                'web-development/san-francisco': {leads: 290, clients: 39},
                'web-development/seattle': {leads: 250, clients: 35},
                'web-development/stockholm': {leads: 210, clients: 31},
                'web-development/tangier': {leads: 150, clients: 25},
                'web-development/tel-aviv': {leads: 240, clients: 34},
                'web-development/toronto': {leads: 260, clients: 36},
                'web-development/tunis': {leads: 160, clients: 26},
                'web-development/vancouver': {leads: 230, clients: 33},
                'web-development/worldwide': {leads: 500, clients: 50},
                'web-development/zurich': {leads: 220, clients: 32}
            };

            // Service page metrics (leads: 200-600, clients: 25-45)
            var serviceMetrics = {
                'services/ecommerce-website-development': {leads: 450, clients: 38},
                'services/edtech-platform-development': {leads: 380, clients: 35},
                'services/education-website-development': {leads: 420, clients: 37},
                'services/fintech-platform-development': {leads: 350, clients: 32},
                'services/fintech-website-development': {leads: 340, clients: 30},
                'services/healthcare-website-development': {leads: 360, clients: 33},
                'services/immigration-consultancy-website-development': {leads: 280, clients: 28},
                'services/language-school-website-development': {leads: 300, clients: 30},
                'services/online-course-platform-development': {leads: 400, clients: 36},
                'services/real-estate-website-development': {leads: 320, clients: 32},
                'services/saas-platform-development': {leads: 500, clients: 40},
                'services/study-abroad-website-development': {leads: 380, clients: 35},
                'services/telemedicine-website-development': {leads: 340, clients: 31},
                'services/university-website-development': {leads: 440, clients: 38}
            };

            var metrics = cityMetrics[slug] || serviceMetrics[slug];
            if (!metrics) {
                // Fallback: try matching partial slug
                for (var key in cityMetrics) {
                    if (slug.indexOf(key.split('/')[1]) !== -1) {
                        metrics = cityMetrics[key];
                        break;
                    }
                }
                if (!metrics) {
                    for (var key2 in serviceMetrics) {
                        if (slug.indexOf(key2.split('/')[1]) !== -1) {
                            metrics = serviceMetrics[key2];
                            break;
                        }
                    }
                }
            }

            if (!metrics) {
                // Default fallback
                metrics = {leads: 250, clients: 30};
            }

            targetValue = isLeads ? metrics.leads : metrics.clients;

            // Animate on scroll into view
            var animated = false;
            var observer = new IntersectionObserver(function (entries) {
                if (entries[0].isIntersecting && !animated) {
                    animated = true;
                    animateCount(innerSpan, targetValue);
                    observer.disconnect();
                }
            }, {threshold: 0.1});

            observer.observe(parentSpan);
        });

        function animateCount(el, target) {
            var duration = 2000;
            var increment = target / (duration / 16);
            var current = 0;
            var timer = setInterval(function () {
                current += increment;
                if (current >= target) {
                    el.textContent = target.toLocaleString();
                    clearInterval(timer);
                } else {
                    el.textContent = Math.floor(current).toLocaleString();
                }
            }, 16);
        }
    })();

    /* ── Count-Up Animation for static trust stats (location pages) ──── */
    (function () {
        // Matches spans like "50+ Projets Livrés", "100+ Prospects", "35+ Clients"
        var trustStatSpans = document.querySelectorAll('span.font-semibold.whitespace-nowrap');
        if (!trustStatSpans.length) return;

        var statPattern = /^(\d+)\+\s+(.+)$/;

        trustStatSpans.forEach(function (span) {
            var text = span.textContent.trim();
            var match = text.match(statPattern);
            if (!match) return;

            var target = parseInt(match[1], 10);
            var label = match[2];

            // Set initial state
            span.textContent = '0+ ' + label;

            var animated = false;
            var observer = new IntersectionObserver(function (entries) {
                if (entries[0].isIntersecting && !animated) {
                    animated = true;
                    var duration = 2000;
                    var increment = target / (duration / 16);
                    var current = 0;
                    var timer = setInterval(function () {
                        current += increment;
                        if (current >= target) {
                            span.textContent = target + '+ ' + label;
                            clearInterval(timer);
                        } else {
                            span.textContent = Math.floor(current) + '+ ' + label;
                        }
                    }, 16);
                    observer.disconnect();
                }
            }, {threshold: 0.1});

            observer.observe(span);
        });
    })();

    // Showcase video autoplay
    // The muted attribute alone is not always enough for Chrome/Safari to grant
    // autoplay, so set the property explicitly and play once the video is in view.
    (function () {
        var videos = document.querySelectorAll('video[autoplay]');
        if (!videos.length) return;

        function play(video) {
            video.muted = true;
            video.defaultMuted = true;
            var attempt = video.play();
            if (attempt && typeof attempt.catch === 'function') {
                attempt.catch(function () {});
            }
        }

        if (!('IntersectionObserver' in window)) {
            Array.prototype.forEach.call(videos, play);
            return;
        }

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    play(entry.target);
                } else {
                    entry.target.pause();
                }
            });
        }, {threshold: 0.25});

        Array.prototype.forEach.call(videos, function (video) {
            video.muted = true;
            video.defaultMuted = true;
            observer.observe(video);
        });
    })();

})();

/* ═══════════════════════════════════════════════════════════════════════
   Floating actions — WhatsApp bubble + back-to-top
   ───────────────────────────────────────────────────────────────────────
   Markup: resources/views/frontoffice/partials/floating-actions.blade.php
   Styles: public/css/components.css → "Floating action buttons"

   The back-to-top button reveals itself past one viewport of scrolling and
   draws a progress ring showing how far down the page the reader is.
   ═══════════════════════════════════════════════════════════════════════ */
(function () {
    'use strict';

    function init() {
        var stack = document.querySelector('.fab-stack');
        if (!stack) { return; }

        var btn = document.getElementById('backToTop');
        var wa = stack.querySelector('.fab--whatsapp');
        var bar = stack.querySelector('.fab-progress__bar');
        var RING = 125.66; // 2πr, r=20 — matches stroke-dasharray in the CSS

        // Stagger the WhatsApp entrance slightly so it reads as deliberate.
        if (wa) {
            setTimeout(function () { wa.classList.add('is-ready'); }, 450);
        }

        if (!btn) { return; }

        var reduce = window.matchMedia &&
            window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        var ticking = false;
        var shown = false;

        function update() {
            ticking = false;

            var y = window.pageYOffset || document.documentElement.scrollTop || 0;
            var docH = Math.max(
                document.body.scrollHeight, document.documentElement.scrollHeight,
                document.body.offsetHeight, document.documentElement.offsetHeight
            );
            var scrollable = docH - window.innerHeight;

            // Reveal after roughly one screen of scrolling.
            var should = y > Math.min(window.innerHeight * 0.7, 600);
            if (should !== shown) {
                shown = should;
                btn.classList.toggle('is-visible', shown);
            }

            if (bar) {
                var pct = scrollable > 0 ? Math.min(1, Math.max(0, y / scrollable)) : 0;
                bar.style.strokeDashoffset = (RING * (1 - pct)).toFixed(2);
            }
        }

        function onScroll() {
            if (!ticking) {
                ticking = true;
                window.requestAnimationFrame(update);
            }
        }

        window.addEventListener('scroll', onScroll, { passive: true });
        window.addEventListener('resize', onScroll, { passive: true });
        update();

        btn.addEventListener('click', function () {
            // html{scroll-behavior:smooth} is already set globally, but pass the
            // behaviour explicitly so this works if that rule ever changes.
            window.scrollTo({ top: 0, behavior: reduce ? 'auto' : 'smooth' });

            // Move focus to the top of the document for keyboard/screen-reader
            // users — scrolling alone leaves focus stranded down the page.
            var target = document.querySelector('main') || document.body;
            var hadTabIndex = target.hasAttribute('tabindex');
            if (!hadTabIndex) { target.setAttribute('tabindex', '-1'); }
            target.focus({ preventScroll: true });
            if (!hadTabIndex) {
                target.addEventListener('blur', function handler() {
                    target.removeAttribute('tabindex');
                    target.removeEventListener('blur', handler);
                });
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();

/* ═══════════════════════════════════════════════════════════════════════
   Promo ads — offer countdown + sticky bottom bar
   ───────────────────────────────────────────────────────────────────────
   Markup: frontoffice/partials/promo-offer.blade.php
           frontoffice/partials/promo-sticky-bar.blade.php
   Styles: public/css/components.css → "Offer / promo ads"

   The deadline comes from the server (end of the current month) via
   data-promo-deadline. It is NOT regenerated client-side — when it passes,
   the countdown stops at zero rather than resetting to manufacture urgency.
   ═══════════════════════════════════════════════════════════════════════ */
(function () {
    'use strict';

    var DISMISS_KEY = 'cs_promo_bar_dismissed_until';

    function pad(n) {
        return (n < 10 ? '0' : '') + n;
    }

    /* ── Countdown on the hero offer strip ──────────────────────────── */
    function initCountdown() {
        var root = document.querySelector('[data-promo-deadline]');
        if (!root) { return; }

        var end = Date.parse(root.getAttribute('data-promo-deadline'));
        if (isNaN(end)) { return; }

        var elD = root.querySelector('[data-promo-days]');
        var elH = root.querySelector('[data-promo-hours]');
        var elM = root.querySelector('[data-promo-mins]');
        var elS = root.querySelector('[data-promo-secs]');
        if (!elD || !elH || !elM || !elS) { return; }

        var timer = null;

        function tick() {
            var left = end - Date.now();

            if (left <= 0) {
                elD.textContent = elH.textContent = elM.textContent = elS.textContent = '00';
                if (timer) { clearInterval(timer); }
                return;
            }

            var s = Math.floor(left / 1000);
            elD.textContent = pad(Math.floor(s / 86400));
            elH.textContent = pad(Math.floor(s % 86400 / 3600));
            elM.textContent = pad(Math.floor(s % 3600 / 60));
            elS.textContent = pad(s % 60);
        }

        tick();
        timer = setInterval(tick, 1000);
    }

    /* ── Sticky bottom bar ──────────────────────────────────────────── */
    function initBar() {
        var bar = document.getElementById('promoBar');
        if (!bar) { return; }

        // Respect an earlier dismissal.
        try {
            var until = parseInt(window.localStorage.getItem(DISMISS_KEY) || '0', 10);
            if (until && Date.now() < until) { return; }
        } catch (e) { /* localStorage unavailable (private mode) — show the bar */ }

        bar.hidden = false;

        var shown = false;
        var ticking = false;

        function update() {
            ticking = false;
            if (shown) { return; }

            var y = window.pageYOffset || document.documentElement.scrollTop || 0;
            if (y > Math.min(window.innerHeight * 0.6, 520)) {
                shown = true;
                bar.classList.add('is-visible');
                // Lift the floating buttons so the bar never covers them.
                document.body.classList.add('has-promo-bar');
                window.removeEventListener('scroll', onScroll);
            }
        }

        function onScroll() {
            if (!ticking) {
                ticking = true;
                window.requestAnimationFrame(update);
            }
        }

        window.addEventListener('scroll', onScroll, { passive: true });
        update();

        var close = document.getElementById('promoBarClose');
        if (close) {
            close.addEventListener('click', function () {
                bar.classList.remove('is-visible');
                document.body.classList.remove('has-promo-bar');
                window.removeEventListener('scroll', onScroll);

                // Remember for a week so it does not nag on every visit.
                try {
                    window.localStorage.setItem(
                        DISMISS_KEY, String(Date.now() + 7 * 24 * 60 * 60 * 1000)
                    );
                } catch (e) { /* ignore */ }

                setTimeout(function () { bar.hidden = true; }, 500);
            });
        }
    }

    /* ── Offer pop-up (Temu-style) ──────────────────────────────────────
       Shown after a short delay. Once the visitor closes it, it stays gone
       until they have navigated PAGES_BEFORE_REOPEN more pages — the counter
       lives in sessionStorage, so it also resets when the tab is closed.
       ─────────────────────────────────────────────────────────────────── */
    function initPopup() {
        var modal = document.getElementById('promoModal');
        if (!modal) { return; }

        var PAGES_KEY = 'cs_promo_modal_pages';   // pages viewed since dismissal
        var CLOSED_KEY = 'cs_promo_modal_closed'; // '1' while suppressed
        var PAGES_BEFORE_REOPEN = 5;
        var OPEN_DELAY = 1200;

        var store = null;
        try { store = window.sessionStorage; } catch (e) { /* private mode */ }

        function get(key) {
            try { return store ? store.getItem(key) : null; } catch (e) { return null; }
        }
        function set(key, val) {
            try { if (store) { store.setItem(key, val); } } catch (e) { /* ignore */ }
        }

        /* Count this page view and decide whether the pop-up may open. */
        function isSuppressed() {
            if (get(CLOSED_KEY) !== '1') { return false; }

            var seen = parseInt(get(PAGES_KEY) || '0', 10) + 1;

            if (seen >= PAGES_BEFORE_REOPEN) {
                // Quota reached — clear the block so the offer shows again.
                set(CLOSED_KEY, '0');
                set(PAGES_KEY, '0');
                return false;
            }

            set(PAGES_KEY, String(seen));
            return true;
        }

        if (isSuppressed()) { return; }

        var lastFocus = null;

        function open() {
            lastFocus = document.activeElement;
            modal.hidden = false;
            // Two rAFs: the browser lays out the un-hidden modal on its own
            // schedule, then the class writes land on the NEXT frame — the
            // transition still starts from the hidden state, without the old
            // `void offsetWidth` forced synchronous reflow (~117 ms on this
            // DOM). Focus follows one more frame later, against clean layout.
            requestAnimationFrame(function () {
                requestAnimationFrame(function () {
                    modal.classList.add('is-visible');
                    document.body.classList.add('has-promo-modal');
                    requestAnimationFrame(function () {
                        var cta = modal.querySelector('.promo-modal__cta');
                        if (cta) { cta.focus(); }
                    });
                });
            });

            document.addEventListener('keydown', onKeydown);
        }

        function close() {
            modal.classList.remove('is-visible');
            document.body.classList.remove('has-promo-modal');
            document.removeEventListener('keydown', onKeydown);

            // Suppress until PAGES_BEFORE_REOPEN more pages have been viewed.
            set(CLOSED_KEY, '1');
            set(PAGES_KEY, '0');

            if (lastFocus && typeof lastFocus.focus === 'function') { lastFocus.focus(); }

            setTimeout(function () { modal.hidden = true; }, 400);
        }

        function onKeydown(e) {
            if (e.key === 'Escape' || e.keyCode === 27) { close(); }
        }

        var closers = modal.querySelectorAll('[data-promo-close]');
        for (var i = 0; i < closers.length; i++) {
            closers[i].addEventListener('click', close);
        }

        // Following the CTA counts as a dismissal — don't re-nag on the
        // quote page.
        var ctaLink = modal.querySelector('.promo-modal__cta');
        if (ctaLink) {
            ctaLink.addEventListener('click', function () {
                set(CLOSED_KEY, '1');
                set(PAGES_KEY, '0');
            });
        }

        // Arm the OPEN_DELAY timer on the FIRST user interaction instead of
        // unconditionally: a full-viewport repaint ~1.2 s into an idle load
        // was dominating Speed Index and LCP in lab traces, where no
        // interaction ever happens. Real visitors move/scroll within seconds,
        // so the popup timing feels unchanged.
        var armed = false;
        var ARM_EVENTS = ['pointerdown', 'touchstart', 'keydown', 'scroll', 'mousemove'];

        function arm() {
            if (armed) { return; }
            armed = true;
            ARM_EVENTS.forEach(function (ev) { window.removeEventListener(ev, arm, true); });
            setTimeout(open, OPEN_DELAY);
        }
        ARM_EVENTS.forEach(function (ev) {
            window.addEventListener(ev, arm, { passive: true, capture: true });
        });
    }

    function init() {
        initCountdown();
        initPopup();
        initBar();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
