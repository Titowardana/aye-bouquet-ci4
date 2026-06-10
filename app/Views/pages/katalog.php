<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
    /* Card subtle shadow & lift */
    .card-shadow { box-shadow: 0 4px 20px rgba(121, 84, 101, 0.05); }
    .card-shadow:hover { box-shadow: 0 8px 30px rgba(121, 84, 101, 0.10); }

    /* Size pill active state */
    .size-pill.active {
        border-color: #795465;
        background-color: #795465;
        color: #ffffff;
    }

    /* Color swatch active ring */
    .color-swatch.active { outline: 3px solid #795465; outline-offset: 2px; }

    /* Custom checkbox & radio theme */
    input[type="checkbox"] { accent-color: #795465; }
    input[type="radio"]    { accent-color: #795465; }
    input[type="range"]    { accent-color: #795465; }
</style>

<!-- Page wrapper: sidebar + content -->
<form action="<?= base_url('/katalog') ?>" method="GET" id="filterForm">
<div class="w-full px-6 md:px-12 lg:px-16 mx-auto py-12 flex flex-col md:flex-row gap-8 bg-warm-cream dark:bg-[#1c191a]">

    <!-- Mobile Filter Overlay -->
    <div id="mobile-filter-overlay" class="fixed inset-0 bg-black/50 z-[60] hidden opacity-0 transition-opacity duration-300 md:hidden"></div>

    <!-- ══════════════════════════════════════
         LEFT SIDEBAR: FILTERS
         ══════════════════════════════════════ -->
    <aside id="filter-sidebar" class="fixed inset-y-0 right-0 z-[70] w-[85%] max-w-sm bg-white-warm dark:bg-[#262024] transform translate-x-full transition-transform duration-300 md:static md:translate-x-0 md:z-auto md:w-64 md:bg-transparent overflow-y-auto md:overflow-visible flex-shrink-0 shadow-2xl md:shadow-none mb-8 md:mb-0">
        
        <!-- Mobile close header -->
        <div class="md:hidden flex justify-between items-center p-5 border-b border-soft-beige/30 dark:border-white/10 sticky top-0 bg-white-warm dark:bg-[#2a2328] z-10">
            <h2 class="font-headline-md text-lg font-bold text-on-surface flex items-center gap-2">
                <span class="material-symbols-outlined text-primary" style="font-size:20px">tune</span>
                Filter Produk
            </h2>
            <button type="button" id="close-filter-btn" class="p-2 -mr-2 text-on-surface-variant hover:text-primary rounded-full hover:bg-soft-beige/30 dark:hover:bg-[#332b30] transition-colors flex items-center justify-center" aria-label="Tutup filter">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <div class="bg-white-warm dark:bg-[#262024] md:rounded-2xl p-6 md:card-shadow border-0 md:border border-soft-beige/30 dark:border-white/10 md:sticky top-24">
            <!-- Desktop Header -->
            <h2 class="hidden md:flex font-headline-md text-lg font-bold text-on-surface mb-6 border-b border-soft-beige/30 dark:border-white/10 pb-4 items-center gap-2">
                <span class="material-symbols-outlined text-primary" style="font-size:20px">filter_list</span>
                Filter Produk
            </h2>

            <!-- Kategori -->
            <div class="mb-6 pb-6 border-b border-soft-beige/30 dark:border-white/10">
                <h3 class="font-label-md text-xs font-extrabold text-on-surface-variant mb-3 uppercase tracking-widest">Kategori</h3>
                <div class="flex flex-col gap-2.5">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="radio" name="kategori" value=""
                               onchange="if(window.innerWidth >= 768) this.form.submit();"
                               class="w-4 h-4 border-outline-variant text-primary focus:ring-primary"
                               <?= empty($selectedCategory) ? 'checked' : '' ?>>
                        <span class="text-sm text-on-surface-variant group-hover:text-primary transition-colors font-medium">
                            Semua Produk
                        </span>
                    </label>
                    <?php foreach ($categories as $cat): ?>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="radio" name="kategori" value="<?= esc($cat['slug']) ?>"
                                   onchange="if(window.innerWidth >= 768) this.form.submit();"
                                   class="w-4 h-4 border-outline-variant text-primary focus:ring-primary"
                                   <?= $selectedCategory === $cat['slug'] ? 'checked' : '' ?>>
                            <span class="text-sm text-on-surface-variant group-hover:text-primary transition-colors font-medium">
                                <?= esc($cat['name']) ?>
                            </span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Ukuran -->
            <div class="mb-6 pb-6 border-b border-soft-beige/30 dark:border-white/10">
                <h3 class="font-label-md text-xs font-extrabold text-on-surface-variant mb-3 uppercase tracking-widest">Ukuran</h3>
                <div class="flex flex-wrap gap-2">
                    <?php
                    $selectedUkuran = $filters['ukuran'] ?? [];
                    if (!is_array($selectedUkuran)) $selectedUkuran = [];
                    foreach (['S', 'M', 'L', 'XL', 'XXL', 'Jumbo'] as $size): ?>
                        <label class="cursor-pointer">
                            <input type="checkbox" name="ukuran[]" value="<?= esc($size) ?>" onchange="if(window.innerWidth >= 768) this.form.submit();" class="peer hidden" <?= in_array($size, $selectedUkuran) ? 'checked' : '' ?>>
                            <div class="px-3.5 py-1.5 rounded-full border border-outline-variant text-xs font-semibold text-on-surface-variant bg-white-warm dark:bg-[#2a2328] peer-checked:border-primary peer-checked:bg-primary peer-checked:text-on-primary hover:border-primary hover:text-primary transition-all duration-200 shadow-sm">
                                <?= esc($size) ?>
                            </div>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Rentang Harga -->
            <div class="mb-6 pb-6 border-b border-soft-beige/30 dark:border-white/10">
                <h3 class="font-label-md text-xs font-extrabold text-on-surface-variant mb-3 uppercase tracking-widest">Rentang Harga</h3>
                <div class="flex flex-col gap-2.5">
                    <?php
                    $priceRanges = [
                        'under_50'  => 'di bawah Rp50.000',
                        '50_100'    => 'Rp50.000 - Rp100.000',
                        '100_200'   => 'Rp100.000 - Rp200.000',
                        '200_500'   => 'Rp200.000 - Rp500.000',
                        'above_500' => 'di atas Rp500.000',
                    ];
                    $selectedPrice = $filters['price_range'] ?? '';
                    ?>
                    <?php foreach ($priceRanges as $val => $label): ?>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="radio" name="price_range" value="<?= $val ?>" onchange="if(window.innerWidth >= 768) this.form.submit();"
                                   class="w-4 h-4 border-outline-variant text-primary focus:ring-primary"
                                   <?= $selectedPrice === $val ? 'checked' : '' ?>>
                            <span class="text-sm text-on-surface-variant group-hover:text-primary transition-colors font-medium">
                                <?= esc($label) ?>
                            </span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Warna -->
            <div class="mb-6 pb-6 border-b border-soft-beige/30 dark:border-white/10">
                <h3 class="font-label-md text-xs font-extrabold text-on-surface-variant mb-3 uppercase tracking-widest">Warna</h3>
                <div class="flex gap-2.5 flex-wrap">
                    <?php $selectedColor = $filters['warna'] ?? ''; ?>
                    <?php foreach ($colors as $color): ?>
                    <?php
                    $hex = $color['hex_code'] ?? '#f0f0f0';
                    $isWhite = strtolower(ltrim($hex, '#')) === 'ffffff';
                    ?>
                    <label class="cursor-pointer">
                        <input type="radio" name="warna" value="<?= esc($color['name']) ?>" onchange="if(window.innerWidth >= 768) this.form.submit();" class="peer hidden" <?= $selectedColor === $color['name'] ? 'checked' : '' ?>>
                        <div aria-label="<?= esc($color['name']) ?>" class="w-8 h-8 rounded-full <?= $isWhite ? 'border border-outline-variant' : 'border-2 border-transparent' ?> peer-checked:outline peer-checked:outline-2 peer-checked:outline-primary peer-checked:outline-offset-2 hover:outline hover:outline-2 hover:outline-primary hover:outline-offset-2 transition-all duration-200" style="background-color: <?= $hex ?>"></div>
                    </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Status -->
            <div>
                <h3 class="font-label-md text-xs font-extrabold text-on-surface-variant mb-3 uppercase tracking-widest">Status</h3>
                <div class="flex flex-col gap-2.5">
                    <?php $selectedStatus = $filters['status'] ?? ''; ?>
                    <?php foreach (['Ready', 'Pre-order', 'Habis'] as $status): ?>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="radio" name="status" value="<?= strtolower($status) ?>" onchange="if(window.innerWidth >= 768) this.form.submit();"
                                   class="w-4 h-4 border-outline-variant text-primary focus:ring-primary"
                                   <?= $selectedStatus === strtolower($status) ? 'checked' : '' ?>>
                            <span class="text-sm text-on-surface-variant group-hover:text-primary transition-colors font-medium">
                                <?= esc($status) ?>
                            </span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Mobile Apply Button -->
            <button type="submit" class="md:hidden mt-6 w-full py-3 rounded-full bg-primary text-on-primary font-bold shadow-md active:scale-95 transition-all text-sm">
                Terapkan Filter
            </button>

            <!-- Reset Button -->
            <a href="<?= base_url('/katalog') ?>" class="mt-4 md:mt-6 w-full py-2.5 rounded-full border border-soft-beige/30 dark:border-white/10 text-on-surface-variant text-sm font-semibold hover:bg-white-warm dark:hover:bg-[#2a2328] hover:text-primary transition-all duration-200 flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-base">refresh</span>
                Reset Filter
            </a>
        </div>
    </aside>

    <!-- ══════════════════════════════════════
         RIGHT CONTENT: CATALOG GRID
         ══════════════════════════════════════ -->
    <div class="flex-grow min-w-0">

        <!-- Page Title -->
        <div class="mb-8">
            <h1 class="font-display-lg text-3xl md:text-4xl font-extrabold text-on-surface tracking-tight">Katalog Produk</h1>
            <p class="text-sm text-on-surface-variant mt-1">Temukan koleksi kado dan buket custom premium terbaik untuk Anda.</p>
        </div>

        <!-- Search & Sort bar -->
        <div class="flex flex-col sm:flex-row justify-between gap-4 mb-8 bg-white-warm dark:bg-[#2a2328] p-4 rounded-2xl card-shadow border border-soft-beige/30 dark:border-white/10 items-center">
            <!-- Search -->
            <div class="relative w-full sm:max-w-sm flex items-center border border-soft-beige/30 dark:border-white/10 rounded-full bg-white-warm dark:bg-[#2a2328] px-4 py-2.5 focus-within:border-primary focus-within:ring-2 focus-within:ring-primary/20 transition-all">
                <span class="material-symbols-outlined text-on-surface-variant mr-2 text-lg select-none">search</span>
                <input id="catalog-search"
                       type="text"
                       name="search"
                       value="<?= esc($search ?? '') ?>"
                       onkeydown="if(event.key==='Enter') this.form.submit();"
                       placeholder="Cari produk..."
                       class="bg-transparent border-0 p-0 text-sm focus:ring-0 w-full text-on-surface outline-none placeholder:text-gray-400 dark:placeholder:text-gray-300">
            </div>
            <!-- Sort & Filter Mobile -->
            <div class="flex items-center justify-between sm:justify-end gap-3 w-full sm:w-auto">
                <!-- Mobile Filter Toggle Button -->
                <button type="button" id="open-filter-btn" class="md:hidden flex items-center gap-2 px-4 py-2.5 rounded-full border border-soft-beige/30 dark:border-white/10 bg-white-warm dark:bg-[#2a2328] text-sm font-bold text-on-surface hover:bg-white-warm dark:hover:bg-[#332b30] transition-colors shadow-sm whitespace-nowrap">
                    <span class="material-symbols-outlined text-[18px]">tune</span>
                    Filter
                </button>

                <div class="flex items-center gap-2 w-full sm:w-auto flex-grow sm:flex-grow-0">
                    <span class="hidden sm:inline font-label-md text-xs font-bold text-on-surface-variant whitespace-nowrap uppercase tracking-wider">Urutkan:</span>
                    <select id="catalog-sort" name="sort" onchange="document.getElementById('filterForm').submit()"
                            class="w-full sm:w-48 px-4 py-2.5 rounded-full border border-soft-beige/30 dark:border-white/10 bg-white-warm dark:bg-[#2a2328] text-sm text-on-surface focus:border-primary focus:ring-0 outline-none cursor-pointer shadow-sm">
                        <option value="terbaru" <?= (isset($_GET['sort']) && $_GET['sort'] == 'terbaru') ? 'selected' : '' ?>>Terbaru</option>
                        <option value="harga_rendah" <?= (isset($_GET['sort']) && $_GET['sort'] == 'harga_rendah') ? 'selected' : '' ?>>Harga Terendah</option>
                        <option value="harga_tinggi" <?= (isset($_GET['sort']) && $_GET['sort'] == 'harga_tinggi') ? 'selected' : '' ?>>Harga Tertinggi</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- ── Product Grid ── -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" data-stagger>
            <?php if(!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <article class="bg-white-warm dark:bg-[#262024] rounded-2xl overflow-hidden card-shadow border border-soft-beige/30 dark:border-white/10 flex flex-col group transition-all duration-300 hover:-translate-y-1 card-hover animate-on-scroll">
                    <!-- Product Image -->
                    <div class="aspect-[4/5] bg-surface-container-high relative overflow-hidden">
                        <img
                            alt="<?= esc($product['name']) ?>"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                            src="<?= $product['primary_image'] ? base_url('uploads/products/' . $product['primary_image']) : base_url('assets/images/no-image.svg') ?>"
                            onerror="this.onerror=null; this.src='<?= base_url('assets/images/no-image.svg') ?>'"
                        />
                        <!-- Gradient overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <!-- Status Badge -->
                        <div class="absolute top-3 right-3">
                            <?php if ($product['status'] === 'ready'): ?>
                                <span class="px-3 py-1 rounded-full bg-green-100 text-green-800 text-[10px] font-bold tracking-wider uppercase border border-green-200 shadow-sm">Ready</span>
                            <?php elseif ($product['status'] === 'pre-order'): ?>
                                <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-800 text-[10px] font-bold tracking-wider uppercase border border-amber-200 shadow-sm">Pre-order</span>
                            <?php else: ?>
                                <span class="px-3 py-1 rounded-full bg-red-100 text-red-800 text-[10px] font-bold tracking-wider uppercase border border-red-200 shadow-sm">Habis</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- Product Info -->
                    <div class="p-5 flex flex-col flex-grow">
                        <span class="font-label-md text-[11px] font-extrabold text-primary uppercase tracking-widest mb-1 block">
                            <?= esc($product['category_name']) ?>
                        </span>
                        <h3 class="font-headline-md text-base text-on-surface font-bold line-clamp-1 mb-1 group-hover:text-primary transition-colors duration-300">
                            <?= esc($product['name']) ?>
                        </h3>
                        <p class="text-xs text-on-surface-variant font-medium mb-auto pb-3">
                            <?= esc($product['sku'] ?? 'SKU N/A') ?>
                        </p>
                        <div class="flex justify-between items-center pt-3 border-t border-soft-beige/30 dark:border-white/10 mt-3">
                            <div>
                                <span class="block text-[10px] text-on-surface-variant font-semibold">Mulai dari</span>
                                <span class="font-body-lg text-base font-extrabold text-on-surface">
                                    Rp <?= number_format($product['price'], 0, ',', '.') ?>
                                </span>
                            </div>
                            <a href="<?= base_url('/produk/' . esc($product['slug'])) ?>"
                               class="flex items-center gap-1.5 bg-primary/10 text-primary hover:bg-primary hover:text-on-primary px-4 py-2 rounded-full font-label-sm text-xs font-bold transition-all duration-300 shadow-sm active:scale-95">
                                Lihat Detail
                                <span class="material-symbols-outlined text-sm font-semibold">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
            <?php else: ?>
                <div class="col-span-full text-center py-12 text-on-surface-variant bg-white-warm dark:bg-[#262024] rounded-2xl card-shadow border border-soft-beige/30 dark:border-white/10">
                    <div class="flex flex-col items-center gap-3">
                        <span class="material-symbols-outlined text-4xl text-on-surface-variant/50">inventory_2</span>
                        <p class="text-sm font-medium">Tidak ada produk ditemukan.</p>
                        <a href="<?= base_url('/katalog') ?>" class="text-primary text-sm font-bold hover:underline">Reset filter</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- ── Pagination ── -->
        <div class="mt-12 flex justify-center">
            <?= $pager->links('default', 'frontend_pagination') ?>
        </div>

    </div><!-- end right content -->
</div><!-- end page wrapper -->
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterSidebar = document.getElementById('filter-sidebar');
    const overlay = document.getElementById('mobile-filter-overlay');
    const openBtn = document.getElementById('open-filter-btn');
    const closeBtn = document.getElementById('close-filter-btn');

    function openFilter() {
        if (!filterSidebar || !overlay) return;
        overlay.classList.remove('hidden');
        // trigger reflow
        void overlay.offsetWidth;
        overlay.classList.remove('opacity-0');
        overlay.classList.add('opacity-100');
        
        filterSidebar.classList.remove('translate-x-full');
        filterSidebar.classList.add('translate-x-0');
        document.body.style.overflow = 'hidden'; // prevent background scrolling
    }

    function closeFilter() {
        if (!filterSidebar || !overlay) return;
        overlay.classList.remove('opacity-100');
        overlay.classList.add('opacity-0');
        
        filterSidebar.classList.remove('translate-x-0');
        filterSidebar.classList.add('translate-x-full');
        document.body.style.overflow = ''; // restore scrolling
        
        // hide overlay completely after transition
        setTimeout(() => {
            overlay.classList.add('hidden');
        }, 300);
    }

    if (openBtn) openBtn.addEventListener('click', openFilter);
    if (closeBtn) closeBtn.addEventListener('click', closeFilter);
    if (overlay) overlay.addEventListener('click', closeFilter);

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeFilter();
    });
});
</script>

<?= $this->endSection() ?>
