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

        // Tag element for scroll animation
        function tag(el, cls, delay) {
            if (el._stag || isMarquee(el)) return;
            el._stag = true;
            el.classList.add(cls);
            if (delay) el.setAttribute('data-delay', String(delay));
            animated.push(el);
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
                    !el.closest('.scroll-fade') && !el.closest('.scroll-fade-left')) {
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

    // Run after DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initScrollAnimations);
    } else {
        initScrollAnimations();
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
        var words = [
            'GROWTH',
            'RESULTS',
            'CONVERSIONS',
            'LEADS',
            'SALES',
            'BRAND BUILDING'
        ];
        var idx = 0;
        var textEl = document.getElementById('hero-rotating-text');
        var borderEl = textEl ? textEl.previousElementSibling.previousElementSibling : null;
        if (!textEl) return;

        setInterval(function () {
            idx = (idx + 1) % words.length;

            // Fade out
            textEl.style.animation = 'none';
            textEl.style.opacity = '0';
            if (borderEl) {
                borderEl.style.animation = 'none';
            }

            // Force reflow
            void textEl.offsetWidth;

            // Update text and replay animations
            textEl.textContent = words[idx];
            textEl.style.opacity = '';
            textEl.style.animation = 'textFadeIn 0.3s ease-in-out, textReveal 1.2s cubic-bezier(0.22, 1, 0.36, 1)';
            if (borderEl) {
                borderEl.style.animation = 'scaleIn 0.3s ease-out';
            }
        }, 5000);
    })();

    /* ── Cal.com Modal (iframe) ────────────────────────────────────────── */
    (function initCalModal() {
        var overlay  = document.getElementById('cal-modal-overlay');
        var iframe   = document.getElementById('cal-modal-iframe');
        var closeBtn = document.getElementById('cal-modal-close');
        var loading  = document.getElementById('cal-modal-loading');
        if (!overlay || !iframe) return;

        var calSrc = iframe.getAttribute('data-cal-src');

        // Hide spinner when iframe finishes loading
        iframe.addEventListener('load', function() {
            if (loading) loading.style.display = 'none';
        });

        function openModal() {
            // Show spinner on each open
            if (loading) loading.style.display = 'flex';
            // Load iframe src on first open
            if (!iframe.src || iframe.src === 'about:blank') {
                iframe.src = calSrc;
            }
            overlay.style.display = 'flex';
            document.body.style.overflow = 'hidden';
            // Trigger transition
            requestAnimationFrame(function() {
                overlay.classList.add('is-visible');
            });
        }

        function closeModal() {
            overlay.classList.remove('is-visible');
            document.body.style.overflow = '';
            setTimeout(function() {
                overlay.style.display = 'none';
            }, 250);
        }

        // Close button
        if (closeBtn) closeBtn.addEventListener('click', closeModal);

        // Click on overlay background
        overlay.addEventListener('click', function(e) {
            if (e.target === overlay) closeModal();
        });

        // Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && overlay.style.display === 'flex') closeModal();
        });

        // Attach to all "Book a Call" triggers
        document.querySelectorAll('[data-cal-link]').forEach(function(btn) {
            btn.removeAttribute('data-cal-link');
            btn.removeAttribute('data-cal-config');
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                openModal();
            });
        });
    })();

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
            'Global CDN': 'Lightning-fast content delivery with worldwide CDN infrastructure, edge caching, and optimized performance across all continents'
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
            if (h2.textContent.indexOf('18 Premium Features') !== -1) {
                premiumSection = h2.closest('section') || h2.closest('.space-y-4')?.parentElement;
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

            var prevBtn = section.querySelector('button[aria-label="Previous testimonials"]');
            var nextBtn = section.querySelector('button[aria-label="Next testimonials"]');
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
        // Generic FAQ answers keyed by question pattern
        var faqAnswers = {
            'why choose': 'We combine cutting-edge AI technology with premium design and rapid delivery. Unlike traditional agencies that take months, we deliver in 7-10 days with unlimited revisions. Our full-stack expertise covers everything from custom dashboards to AI chatbots, ensuring your business gets a competitive edge with modern web solutions.',
            'startups': 'Absolutely! We work with businesses of all sizes, from early-stage startups to established enterprises. Our flexible pricing model and retainer plans are designed to scale with your growth. Many of our startup clients appreciate our fast turnaround times and the ability to pause or cancel anytime.',
            'technologies': 'We use the latest modern technologies including Next.js, React, TypeScript, Node.js, and Laravel for web development. For AI features, we integrate OpenAI, custom chatbots, and intelligent automation. Our tech stack is chosen to ensure fast performance, excellent SEO, and scalability for your specific needs.',
            'integrate': 'Yes, we specialize in integrating with existing systems including CRMs, ERPs, payment gateways, booking systems, and third-party APIs. Whether you use Salesforce, HubSpot, Stripe, or custom internal tools, we ensure seamless integration with your new website while maintaining data integrity.',
            'unlimited revision': 'Our unlimited revision model means exactly that - we keep refining until you are 100% satisfied. There are no caps on the number of changes you can request. Each revision is typically turned around within 48-72 hours. This ensures your website perfectly matches your vision without any additional costs.',
            'ongoing support': 'Yes, we provide comprehensive ongoing support including premium hosting, maintenance, security updates, performance monitoring, and content updates. Our retainer plans include real-time collaboration on Slack so you can reach us anytime. We also offer dedicated support for bug fixes and feature enhancements post-launch.'
        };

        function findAnswer(questionText) {
            var q = questionText.toLowerCase();
            if (q.indexOf('why choose') !== -1) return faqAnswers['why choose'];
            if (q.indexOf('startup') !== -1 || q.indexOf('early-stage') !== -1) return faqAnswers['startups'];
            if (q.indexOf('technolog') !== -1) return faqAnswers['technologies'];
            if (q.indexOf('integrate') !== -1 || q.indexOf('existing system') !== -1) return faqAnswers['integrate'];
            if (q.indexOf('unlimited revision') !== -1) return faqAnswers['unlimited revision'];
            if (q.indexOf('ongoing support') !== -1 || q.indexOf('after launch') !== -1) return faqAnswers['ongoing support'];
            return 'Contact us for more details about this topic. We\'d love to discuss your specific needs and how we can help your business grow.';
        }

        var faqContainers = document.querySelectorAll('.max-w-4xl.mx-auto.bg-white.rounded-2xl.border');
        faqContainers.forEach(function (container) {
            var faqItems = container.querySelectorAll('.border-b');
            faqItems.forEach(function (item) {
                var btn = item.querySelector('button');
                if (!btn) return;

                var questionEl = btn.querySelector('h3');
                if (!questionEl) return;

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


    /* ── Retainer Social Media Toggle (location pages) ───────────────── */
    (function () {
        // Find retainer toggle button by text content "Include Social Media"
        var allButtons = document.querySelectorAll('button');
        var toggleBtn = null;
        allButtons.forEach(function (btn) {
            if (btn.textContent.trim().indexOf('Include Social Media') !== -1 && !btn.id) {
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
                if (p.textContent.indexOf('Perfect for businesses') !== -1) descP = p;
            });
        }

        var featuresContainer = innerCard ? innerCard.querySelector('.divide-y') : null;

        var isActive = false;

        // Social features HTML to inject
        var socialFeaturesHTML = '<div class="retainer-social-features" style="display:none">' +
            '<div class="flex items-start gap-3 py-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-share2 w-5 h-5 text-[var(--color-primary-orange)] mt-0.5 flex-shrink-0"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" x2="15.42" y1="13.51" y2="17.49"></line><line x1="15.41" x2="8.59" y1="6.51" y2="10.49"></line></svg><span class="text-[var(--color-primary-orange)]">Professional social media management</span></div>' +
            '<div class="flex items-start gap-3 py-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sparkles w-5 h-5 text-[var(--color-primary-orange)] mt-0.5 flex-shrink-0"><path d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z"></path><path d="M20 2v4"></path><path d="M22 4h-4"></path><circle cx="4" cy="20" r="2"></circle></svg><span class="text-[var(--color-primary-orange)]">Content creation for all platforms</span></div>' +
            '<div class="flex items-start gap-3 py-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar w-5 h-5 text-[var(--color-primary-orange)] mt-0.5 flex-shrink-0"><path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path></svg><span class="text-[var(--color-primary-orange)]">Strategic posting & scheduling</span></div>' +
            '<div class="flex items-start gap-3 py-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chart-column w-5 h-5 text-[var(--color-primary-orange)] mt-0.5 flex-shrink-0"><path d="M3 3v16a2 2 0 0 0 2 2h16"></path><path d="M18 17V9"></path><path d="M13 17V5"></path><path d="M8 17v-3"></path></svg><span class="text-[var(--color-primary-orange)]">Monthly analytics & growth reports</span></div>' +
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
                    descP.textContent = 'Complete digital transformation with social media management and content strategy.';
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
                    descP.textContent = 'Perfect for businesses needing ongoing AI features, dashboards, and website improvements.';
                }
                if (socialFeatures) {
                    socialFeatures.style.display = 'none';
                }
            }
        });
    })();

})();
