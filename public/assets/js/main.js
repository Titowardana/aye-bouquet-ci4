/**
 * Main JS - Animation orchestration & UI enhancements
 */

document.addEventListener('DOMContentLoaded', () => {
    'use strict';

    // ── Scroll-based Navbar Effect ──
    const navbar = document.querySelector('header.sticky');
    if (navbar) {
        const toggleNavbarClass = () => {
            navbar.classList.toggle('navbar-scrolled', window.scrollY > 50);
        };
        toggleNavbarClass();
        window.addEventListener('scroll', toggleNavbarClass, { passive: true });
    }

    // ── IntersectionObserver: Scroll-triggered animations ──
    if ('IntersectionObserver' in window) {
        const animObserver = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-visible');
                        animObserver.unobserve(entry.target);
                    }
                });
            },
            {
                threshold: 0.1,
                rootMargin: '0px 0px -40px 0px'
            }
        );

        document.querySelectorAll('.animate-on-scroll').forEach((el) => {
            animObserver.observe(el);
        });

        // Support data-stagger attribute for parent containers
        document.querySelectorAll('[data-stagger]').forEach((parent) => {
            const children = parent.querySelectorAll('.animate-on-scroll');
            children.forEach((child) => {
                animObserver.observe(child);
            });
        });
    } else {
        // Fallback for older browsers
        document.querySelectorAll('.animate-on-scroll').forEach((el) => {
            el.classList.add('animate-visible');
        });
    }

    // ── Hero Parallax Effect ──
    const heroSection = document.querySelector('.hero-parallax');
    if (heroSection) {
        window.addEventListener('scroll', () => {
            const scrollY = window.scrollY;
            if (scrollY < window.innerHeight) {
                heroSection.style.transform = `translateY(${scrollY * 0.15}px)`;
            }
        }, { passive: true });
    }

    // ── FAQ Smooth Accordion ──
    document.querySelectorAll('details.faq-item').forEach((detail) => {
        const summary = detail.querySelector('summary');
        const content = detail.querySelector('p');
        if (!summary || !content) return;

        // Set initial state
        content.style.maxHeight = detail.open ? content.scrollHeight + 'px' : '0';
        content.style.overflow = 'hidden';
        content.style.transition = 'max-height 0.35s ease, opacity 0.25s ease, margin 0.25s ease';
        content.style.opacity = detail.open ? '1' : '0';
        content.style.margin = detail.open ? '' : '0';

        summary.addEventListener('click', (e) => {
            e.preventDefault();
            if (detail.open) {
                // Close
                content.style.maxHeight = '0';
                content.style.opacity = '0';
                content.style.margin = '0';
                setTimeout(() => { detail.open = false; }, 350);
            } else {
                // Open
                detail.open = true;
                requestAnimationFrame(() => {
                    content.style.maxHeight = content.scrollHeight + 'px';
                    content.style.opacity = '1';
                });
            }
        });
    });

    // ── Testimonial Photo Lightbox ──
    const modal = document.getElementById('testimonialImageModal');
    const preview = document.getElementById('testimonialImagePreview');
    const closeBtn = document.getElementById('closeTestimonialImageModal');
    const triggers = document.querySelectorAll('.testimonial-image-trigger');

    if (modal && preview && triggers.length > 0) {
        triggers.forEach(function (trigger) {
            trigger.addEventListener('click', function () {
                preview.src = this.dataset.image;
                preview.alt = this.dataset.name || 'Foto testimoni';
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.classList.add('overflow-hidden');
            });
        });

        function closeLightbox() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            preview.src = '';
            document.body.classList.remove('overflow-hidden');
        }

        if (closeBtn) {
            closeBtn.addEventListener('click', closeLightbox);
        }

        modal.addEventListener('click', function (event) {
            if (event.target === modal) {
                closeLightbox();
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
                closeLightbox();
            }
        });
    }
    // ── Story Card Draggable Polaroid Stack ──
    const storyStage = document.getElementById('storyDragStage');
    if (storyStage) {
        const cards = storyStage.querySelectorAll('.story-drag-card:not(.story-drag-card--solo)');
        let topZ = cards.length + 1;

        cards.forEach((card) => {
            const initRotate = parseFloat(card.dataset.rotate) || 0;
            const initX = parseFloat(card.dataset.initX) || 0;
            const initY = parseFloat(card.dataset.initY) || 0;

            let isDragging = false;
            let startPX = 0, startPY = 0;
            let currentX = initX, currentY = initY;
            let dragStartX = 0, dragStartY = 0;

            function applyTransform(x, y, rotate) {
                card.style.transform = 'translate(' + x + 'px, ' + y + 'px) rotate(' + rotate + 'deg)';
            }

            function clamp(val, min, max) {
                return Math.max(min, Math.min(max, val));
            }

            card.addEventListener('pointerdown', function(e) {
                e.preventDefault();
                isDragging = true;
                card.classList.add('is-dragging');
                card.style.zIndex = topZ++;

                startPX = e.clientX;
                startPY = e.clientY;
                dragStartX = currentX;
                dragStartY = currentY;

                try { card.setPointerCapture(e.pointerId); } catch(_) {}
            });

            card.addEventListener('pointermove', function(e) {
                if (!isDragging) return;
                e.preventDefault();

                const stageRect = storyStage.getBoundingClientRect();
                const cardW = card.offsetWidth;
                const cardH = card.offsetHeight;

                // How far the pointer has moved since pointerdown
                const dx = e.clientX - startPX;
                const dy = e.clientY - startPY;

                // New position relative to center
                let newX = dragStartX + dx;
                let newY = dragStartY + dy;

                // Clamp so card stays mostly within stage
                const halfW = cardW * 0.4;
                const halfH = cardH * 0.4;
                const maxX = stageRect.width / 2 - halfW;
                const maxY = stageRect.height / 2 - halfH;

                newX = clamp(newX, -maxX, maxX);
                newY = clamp(newY, -maxY, maxY);

                currentX = newX;
                currentY = newY;

                applyTransform(currentX, currentY, initRotate);
            });

            function stopDrag(e) {
                if (!isDragging) return;
                isDragging = false;
                card.classList.remove('is-dragging');
                try { card.releasePointerCapture(e.pointerId); } catch(_) {}
            }

            card.addEventListener('pointerup', stopDrag);
            card.addEventListener('pointercancel', stopDrag);
        });
    }
});
