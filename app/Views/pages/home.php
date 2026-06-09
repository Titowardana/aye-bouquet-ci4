<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<!-- Hero Section -->
<section class="relative pt-20 pb-32 overflow-hidden bg-primary-fixed/30 dark:bg-[#1a1517]">
    <div class="absolute inset-0 z-0">
        <img alt="Hero background - Aye Bouquet" class="w-full h-full object-cover opacity-20 hero-bg-zoom" src="<?= base_url('assets/images/hero-aye-bouquet.webp') ?>" onerror="this.onerror=null; this.src='<?= base_url('assets/images/no-image.svg') ?>'"/>
    </div>
    <div class="relative z-10 w-full px-6 md:px-12 lg:px-16 mx-auto flex flex-col items-center text-center">
        <span class="inline-block py-1 px-4 rounded-full bg-primary-container dark:bg-primary/30 text-on-primary-container dark:text-white text-xs mb-6 font-semibold shadow-sm tracking-wide animate__animated animate__fadeIn">Momen Spesial, Kado Spesial</span>
        <h1 class="font-display-lg text-4xl md:text-5xl lg:text-6xl text-on-surface dark:text-white/95 mb-6 max-w-5xl text-balance font-extrabold tracking-tight leading-tight animate__animated animate__fadeInUp">
            Pesan Buket dan Gift Custom Sesuai Keinginanmu
        </h1>
        <p class="font-body-lg text-base md:text-lg text-on-surface-variant dark:text-white/60 mb-10 max-w-3xl text-balance leading-relaxed animate__animated animate__fadeInUp">
            Hadirkan senyum dengan pilihan buket bunga, buket uang, buket snack, selempang, bloom box, dan custom gift yang dirangkai penuh kehangatan.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 w-full justify-center sm:w-auto px-4 sm:px-0 animate__animated animate__fadeInUp">
            <a class="bg-primary text-on-primary px-8 py-4 rounded-full font-label-md text-sm hover:bg-on-primary-fixed-variant transition-all hover:scale-105 active:scale-95 duration-200 shadow-sm soft-shadow-hover font-bold text-center" href="<?= base_url('/katalog') ?>">
                Belanja Sekarang
            </a>
            <a class="bg-surface dark:bg-white/5 text-primary dark:text-primary-fixed-dim border border-outline-variant dark:border-white/20 px-8 py-4 rounded-full font-label-md text-sm hover:bg-surface-container dark:hover:bg-white/10 transition-all hover:scale-105 active:scale-95 duration-200 shadow-sm soft-shadow-hover font-bold text-center" href="<?= base_url('/custom-order') ?>">
                Buat Custom Order
            </a>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-20 w-full px-6 md:px-12 lg:px-16 mx-auto animate-on-scroll" id="tentang">
    <div class="text-center mb-12">
        <h2 class="font-headline-lg text-3xl md:text-4xl text-on-surface dark:text-white/95 mb-4 font-bold tracking-tight">Kategori Pilihan</h2>
        <p class="font-body-md text-sm md:text-base text-on-surface-variant dark:text-white/60 max-w-md mx-auto">Temukan inspirasi kado menarik untuk setiap momen berharga.</p>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-6" data-stagger>
        <?php $categoryList = $categories ?? []; ?>
        <?php foreach ($categoryList as $category): ?>
            <a class="group flex flex-col items-center bg-surface-container-lowest dark:bg-[#262024] p-6 rounded-2xl soft-shadow soft-shadow-hover transition-all duration-300 border border-surface-container dark:border-white/10 hover:border-primary/30 animate-on-scroll" href="<?= base_url('/katalog?kategori=' . ($category['slug'] ?? '')) ?>">
                <div class="w-16 h-16 rounded-full bg-primary-container/40 dark:bg-primary/25 flex items-center justify-center mb-4 text-primary dark:text-primary-fixed-dim group-hover:scale-110 group-hover:bg-primary-container/70 dark:group-hover:bg-primary/40 transition-all duration-300">
                    <?php
                    $catIcon = $category['icon'] ?? '';
                    // Detect if icon is an uploaded image file (has a file extension) or a Material Symbol name
                    $catIconIsFile = !empty($catIcon) && preg_match('/\.(jpg|jpeg|png|gif|webp|svg)$/i', $catIcon);
                    $catIconFilePath = FCPATH . 'uploads/categories/' . $catIcon;
                    if ($catIconIsFile && file_exists($catIconFilePath)):
                    ?>
                        <img src="<?= base_url('uploads/categories/' . esc($catIcon)) ?>"
                             alt="<?= esc($category['name']) ?>"
                             class="w-8 h-8 object-contain">
                    <?php elseif (!$catIconIsFile && !empty($catIcon)): ?>
                        <span class="material-symbols-outlined font-semibold" style="font-size: 32px;"><?= esc($catIcon) ?></span>
                    <?php else: ?>
                        <span class="material-symbols-outlined font-semibold" style="font-size: 32px;">category</span>
                    <?php endif; ?>
                </div>
                <span class="font-label-md text-sm text-on-surface dark:text-white/90 text-center font-bold tracking-wide group-hover:text-primary dark:group-hover:text-primary-fixed-dim transition-colors"><?= esc($category['name']) ?></span>
            </a>
        <?php endforeach; ?>
    </div>
</section>

<!-- Popular Products Carousel -->
<section class="py-20 bg-surface-container-lowest dark:bg-[#1f1b1d] border-t border-surface-container dark:border-white/5 animate-on-scroll" id="catalog">
    <div class="w-full px-6 md:px-12 lg:px-16 mx-auto">
        <!-- Section Header -->
        <div class="flex justify-between items-end mb-12">
            <div>
                <h2 class="font-headline-lg text-3xl md:text-4xl text-on-surface dark:text-white/95 mb-2 font-bold tracking-tight">Produk Terpopuler</h2>
                <p class="font-body-md text-sm md:text-base text-on-surface-variant dark:text-white/60">Karya terbaik yang paling disukai pelanggan kami.</p>
            </div>
            <a class="hidden md:flex items-center gap-2 text-primary dark:text-primary-fixed-dim font-label-md text-sm hover:underline font-bold transition-all hover:translate-x-1" href="<?= base_url('/katalog') ?>">
                Lihat Semua <span class="material-symbols-outlined text-sm font-semibold">arrow_forward</span>
            </a>
        </div>

        <!-- Carousel Wrapper -->
        <div class="relative" id="product-carousel-wrapper">
            <!-- Prev Button -->
            <button id="carousel-prev" aria-label="Sebelumnya"
                class="absolute -left-4 md:-left-6 top-1/2 -translate-y-1/2 z-20 w-11 h-11 rounded-full bg-surface dark:bg-[#262024] border border-surface-container dark:border-white/10 soft-shadow flex items-center justify-center text-primary dark:text-primary-fixed-dim hover:bg-primary hover:text-on-primary hover:border-primary dark:hover:bg-primary-fixed-dim dark:hover:text-on-primary-fixed transition-all duration-300 active:scale-90 focus:outline-none focus:ring-2 focus:ring-primary/50">
                <span class="material-symbols-outlined text-xl font-semibold">chevron_left</span>
            </button>

            <!-- Carousel Track Container -->
            <div class="overflow-hidden rounded-2xl" id="carousel-container">
                <div class="flex transition-transform duration-500 ease-[cubic-bezier(0.25,0.46,0.45,0.94)]" id="carousel-track" style="will-change: transform;">

                    <?php if(!empty($featuredProducts)): ?>
                    <?php foreach ($featuredProducts as $index => $product): ?>
                    <!-- Carousel Slide Item -->
                    <div class="carousel-slide w-full md:w-1/2 lg:w-1/3 flex-shrink-0 px-3 animate-on-scroll" data-index="<?= $index ?>">
                        <div class="bg-surface dark:bg-[#262024] rounded-2xl overflow-hidden soft-shadow flex flex-col h-[420px] group border border-surface-container dark:border-white/10 hover:border-primary/30 transition-all duration-300 card-hover">
                            <!-- Image -->
                            <a href="<?= base_url('produk/' . esc($product['slug'])) ?>" class="relative h-3/5 overflow-hidden block">
                                <img
                                    alt="<?= esc($product['name']) ?>"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                                    src="<?= $product['primary_image'] ? base_url('uploads/products/' . $product['primary_image']) : base_url('assets/images/no-image.svg') ?>"
                                    onerror="this.onerror=null; this.src='<?= base_url('assets/images/no-image.svg') ?>'"
                                />
                                <!-- Status Badge -->
                                <div class="absolute top-3 left-3 bg-surface dark:bg-[#2a2328] text-on-surface dark:text-white/90 px-3 py-1 rounded-full font-label-sm text-xs font-bold shadow-sm flex items-center gap-1.5 border border-surface-container dark:border-white/10">
                                    <div class="w-2 h-2 rounded-full <?= $product['status'] == 'ready' ? 'bg-green-500' : ($product['status'] == 'pre-order' ? 'bg-amber-500' : 'bg-red-500') ?>"></div>
                                    <?= esc(ucfirst($product['status'])) ?>
                                </div>
                                <?php if($product['is_featured']): ?>
                                <!-- Type Badge -->
                                <div class="absolute top-3 right-3 px-3 py-1 rounded-full bg-primary text-on-primary text-[10px] font-extrabold shadow-md uppercase tracking-wide">
                                    Unggulan
                                </div>
                                <?php endif; ?>
                            </a>
                            <!-- Info -->
                            <div class="p-5 flex-grow flex flex-col justify-between">
                                <div>
                                    <span class="text-primary dark:text-primary-fixed-dim font-label-sm text-[11px] font-extrabold uppercase tracking-widest mb-1 block">
                                        <?= esc($product['category_name']) ?>
                                    </span>
                                    <h3 class="font-headline-md text-base md:text-lg text-on-surface dark:text-white/90 mb-2 font-bold line-clamp-1 group-hover:text-primary dark:group-hover:text-primary-fixed-dim transition-colors duration-300">
                                        <a href="<?= base_url('produk/' . esc($product['slug'])) ?>"><?= esc($product['name']) ?></a>
                                    </h3>
                                    <p class="text-xs text-on-surface-variant dark:text-white/60 mb-1">Belum ada ulasan</p>
                                </div>
                                <div class="flex justify-between items-center mt-3 pt-3 border-t border-surface-container dark:border-white/10">
                                    <div>
                                        <span class="block text-on-surface-variant dark:text-white/60 text-[11px] font-semibold">Mulai dari</span>
                                        <span class="font-body-lg text-base md:text-lg font-extrabold text-on-surface dark:text-white/90">Rp <?= number_format($product['price'], 0, ',', '.') ?></span>
                                    </div>
                                    <a href="<?= base_url('produk/' . esc($product['slug'])) ?>"
                                       class="w-10 h-10 rounded-full bg-primary-container dark:bg-primary/25 text-primary dark:text-primary-fixed-dim flex items-center justify-center hover:bg-primary hover:text-on-primary dark:hover:bg-primary-fixed-dim dark:hover:text-on-primary-fixed transition-all duration-300 shadow-sm active:scale-95"
                                       aria-label="Lihat detail <?= esc($product['name']) ?>"
                                       title="Lihat detail produk">
                                        <span class="material-symbols-outlined text-lg font-semibold">add_shopping_cart</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php else: ?>
                        <div class="w-full text-center py-12 text-on-surface-variant dark:text-white/60">Belum ada produk terpopuler.</div>
                    <?php endif; ?>

                </div><!-- end #carousel-track -->
            </div><!-- end #carousel-container -->

            <!-- Next Button -->
            <button id="carousel-next" aria-label="Selanjutnya"
                class="absolute -right-4 md:-right-6 top-1/2 -translate-y-1/2 z-20 w-11 h-11 rounded-full bg-surface dark:bg-[#262024] border border-surface-container dark:border-white/10 soft-shadow flex items-center justify-center text-primary dark:text-primary-fixed-dim hover:bg-primary hover:text-on-primary hover:border-primary dark:hover:bg-primary-fixed-dim dark:hover:text-on-primary-fixed transition-all duration-300 active:scale-90 focus:outline-none focus:ring-2 focus:ring-primary/50">
                <span class="material-symbols-outlined text-xl font-semibold">chevron_right</span>
            </button>
        </div>

        <!-- Dot Indicators -->
        <div class="flex justify-center gap-2.5 mt-8" id="carousel-dots" role="tablist" aria-label="Slide navigation">
        </div>

        <!-- Mobile "Lihat Semua" button -->
        <div class="flex justify-center mt-10 md:hidden">
            <a class="flex items-center gap-2 text-primary dark:text-primary-fixed-dim font-label-md text-sm hover:underline font-bold transition-all" href="<?= base_url('/katalog') ?>">
                Lihat Semua Produk <span class="material-symbols-outlined text-sm font-semibold">arrow_forward</span>
            </a>
        </div>
    </div>
</section>

<script>
(function () {
    'use strict';

    const track       = document.getElementById('carousel-track');
    const container   = document.getElementById('carousel-container');
    const prevBtn     = document.getElementById('carousel-prev');
    const nextBtn     = document.getElementById('carousel-next');
    const dotsWrapper = document.getElementById('carousel-dots');
    const slides      = Array.from(document.querySelectorAll('.carousel-slide'));

    if (!track || !slides.length) return;

    let currentIndex  = 0;
    let autoPlayTimer = null;
    let visibleCount  = 1;
    let maxIndex      = 0;
    let isDragging    = false;
    let startX        = 0;
    let dragThreshold = 50;

    /* ── Determine how many slides are visible ── */
    function getVisibleCount() {
        const w = window.innerWidth;
        if (w >= 1024) return 3;
        if (w >= 768)  return 2;
        return 1;
    }

    /* ── Build dot indicators ── */
    function buildDots() {
        dotsWrapper.innerHTML = '';
        const total = slides.length;
        for (let i = 0; i < total; i++) {
            const dot = document.createElement('button');
            dot.setAttribute('role', 'tab');
            dot.setAttribute('aria-label', 'Slide ' + (i + 1));
            dot.setAttribute('aria-selected', i === currentIndex ? 'true' : 'false');
            dot.dataset.index = i;

            dot.className = [
                'rounded-full transition-all duration-300 focus:outline-none',
                i === currentIndex
                    ? 'w-6 h-2.5 bg-primary shadow-sm'
                    : 'w-2.5 h-2.5 bg-surface-container hover:bg-primary/40'
            ].join(' ');

            dot.addEventListener('click', () => goTo(i));
            dotsWrapper.appendChild(dot);
        }
    }

    /* ── Update dots to reflect current index ── */
    function updateDots() {
        const dots = dotsWrapper.querySelectorAll('button');
        dots.forEach((dot, i) => {
            const active = i === currentIndex;
            dot.setAttribute('aria-selected', active ? 'true' : 'false');
            dot.className = [
                'rounded-full transition-all duration-300 focus:outline-none',
                active
                    ? 'w-6 h-2.5 bg-primary shadow-sm'
                    : 'w-2.5 h-2.5 bg-surface-container hover:bg-primary/40'
            ].join(' ');
        });
    }

    /* ── Move carousel to a specific index ── */
    function goTo(index) {
        visibleCount = getVisibleCount();
        maxIndex     = Math.max(0, slides.length - visibleCount);
        currentIndex = Math.max(0, Math.min(index, maxIndex));

        const slideWidthPercent = 100 / visibleCount;
        const translateX        = -(currentIndex * slideWidthPercent);
        track.style.transform   = 'translateX(' + translateX + '%)';

        /* Resize each slide to fit the visible count */
        slides.forEach(slide => {
            slide.style.width = (100 / visibleCount) + '%';
        });

        updateDots();
        updateArrows();
    }

    /* ── Toggle arrow disabled states ── */
    function updateArrows() {
        prevBtn.style.opacity = currentIndex === 0       ? '0.35' : '1';
        nextBtn.style.opacity = currentIndex >= maxIndex ? '0.35' : '1';
    }

    /* ── Auto-play ── */
    function startAutoPlay() {
        stopAutoPlay();
        autoPlayTimer = setInterval(() => {
            const next = currentIndex >= maxIndex ? 0 : currentIndex + 1;
            goTo(next);
        }, 4000);
    }

    function stopAutoPlay() {
        if (autoPlayTimer) {
            clearInterval(autoPlayTimer);
            autoPlayTimer = null;
        }
    }

    /* ── Arrow click handlers ── */
    prevBtn.addEventListener('click', () => {
        goTo(currentIndex - 1);
        stopAutoPlay();
        startAutoPlay();
    });

    nextBtn.addEventListener('click', () => {
        goTo(currentIndex + 1);
        stopAutoPlay();
        startAutoPlay();
    });

    /* ── Touch / Mouse drag support ── */
    function onDragStart(clientX) {
        isDragging = true;
        startX = clientX;
        track.style.transition = 'none';
    }

    function onDragEnd(clientX) {
        if (!isDragging) return;
        isDragging = false;
        track.style.transition = '';
        const diff = startX - clientX;
        if (Math.abs(diff) > dragThreshold) {
            goTo(diff > 0 ? currentIndex + 1 : currentIndex - 1);
            stopAutoPlay();
            startAutoPlay();
        } else {
            goTo(currentIndex); /* snap back */
        }
    }

    container.addEventListener('mousedown',  e => onDragStart(e.clientX));
    container.addEventListener('mouseup',    e => onDragEnd(e.clientX));
    container.addEventListener('mouseleave', e => { if (isDragging) onDragEnd(e.clientX); });
    container.addEventListener('touchstart', e => onDragStart(e.touches[0].clientX), { passive: true });
    container.addEventListener('touchend',   e => onDragEnd(e.changedTouches[0].clientX));

    /* ── Pause on hover ── */
    container.addEventListener('mouseenter', stopAutoPlay);
    container.addEventListener('mouseleave', startAutoPlay);

    /* ── Re-calculate on resize ── */
    window.addEventListener('resize', () => goTo(currentIndex));

    /* ── Init ── */
    buildDots();
    goTo(0);
    startAutoPlay();
})();
</script>

<!-- Testimonials Section -->
<?php if (!empty($testimonials)): ?>
<section class="py-20 w-full px-6 md:px-12 lg:px-16 mx-auto animate-on-scroll" id="testimoni">
    <div class="text-center mb-12">
        <h2 class="font-headline-lg text-3xl md:text-4xl text-on-surface dark:text-white/95 mb-4 font-bold tracking-tight">Testimonial Pelanggan</h2>
        <p class="font-body-md text-sm md:text-base text-on-surface-variant dark:text-white/60 max-w-md mx-auto">Apa kata mereka yang telah mempercayakan kebahagiaannya di Aye Bouquet.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8" data-stagger>
        <?php foreach ($testimonials as $testimonial): ?>
        <div class="bg-surface dark:bg-[#262024] rounded-2xl p-8 soft-shadow border border-surface-container dark:border-white/10 flex flex-col justify-between hover:border-primary/20 transition-all duration-300 group animate-on-scroll">
            <div>
                <div class="flex gap-1 mb-4 text-primary dark:text-primary-fixed-dim">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' <?= $i <= (int)$testimonial['rating'] ? 1 : 0 ?>">star</span>
                    <?php endfor; ?>
                </div>
                <p class="font-body-md text-on-surface dark:text-white/90 mb-6 italic leading-relaxed text-sm md:text-base">"<?= esc($testimonial['message']) ?>"</p>
                <?php if (!empty($testimonial['photo']) && file_exists(FCPATH . 'uploads/testimonials/' . $testimonial['photo'])): ?>
                <div class="mt-5 flex justify-center">
                    <button type="button" class="testimonial-image-trigger group" data-image="<?= base_url('uploads/testimonials/' . $testimonial['photo']) ?>" data-name="<?= esc($testimonial['customer_name'], 'attr') ?>">
                        <img src="<?= base_url('uploads/testimonials/' . $testimonial['photo']) ?>" alt="Foto <?= esc($testimonial['customer_name']) ?>" class="w-24 h-24 object-cover rounded-2xl border border-primary/10 shadow-sm cursor-pointer group-hover:scale-105 transition duration-300">
                    </button>
                </div>
                <?php endif; ?>
            </div>
            <div class="flex items-center gap-4 border-t border-surface-container dark:border-white/10 pt-4 mt-2">
                <div class="w-12 h-12 rounded-full bg-primary-container dark:bg-primary/25 flex items-center justify-center text-primary dark:text-primary-fixed-dim font-bold shadow-inner group-hover:scale-105 transition-transform duration-300"><?= strtoupper(substr(esc($testimonial['customer_name']), 0, 1)) ?></div>
                <div>
                    <h4 class="font-label-md text-on-surface dark:text-white/90 font-bold text-sm"><?= esc($testimonial['customer_name']) ?></h4>
                    <p class="text-xs text-on-surface-variant dark:text-white/60"><?= !empty($testimonial['city']) ? esc($testimonial['city']) : 'Pelanggan Setia' ?></p>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>
<?= $this->endSection() ?>
