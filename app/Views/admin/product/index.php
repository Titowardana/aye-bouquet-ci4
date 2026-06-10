<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<!-- Flash Messages -->
<?php if (!empty($flashSuccess)): ?>
<div id="flash-success" class="mb-6 p-4 rounded-xl bg-[#DCEFDF] dark:bg-green-900/20 border border-[#C3E6CB] dark:border-green-700/30 text-[#1E7E34] dark:text-green-300 text-sm font-semibold flex items-center justify-between animate-fade-in">
    <div class="flex items-center gap-2">
        <span class="material-symbols-outlined text-lg">check_circle</span>
        <?= esc($flashSuccess) ?>
    </div>
    <button onclick="this.parentElement.remove()" class="text-[#1E7E34] dark:text-green-300 hover:text-[#155724] transition-colors">
        <span class="material-symbols-outlined text-sm">close</span>
    </button>
</div>
<?php endif; ?>

<?php if (!empty($flashError)): ?>
<div id="flash-error" class="mb-6 p-4 rounded-xl bg-[#FCE8E6] dark:bg-red-900/20 border border-[#FAD2CF] dark:border-red-700/30 text-[#C5221F] dark:text-red-300 text-sm font-semibold flex items-center justify-between animate-fade-in">
    <div class="flex items-center gap-2">
        <span class="material-symbols-outlined text-lg">error</span>
        <?= esc($flashError) ?>
    </div>
    <button onclick="this.parentElement.remove()" class="text-[#C5221F] dark:text-red-300 hover:text-[#a5211f] transition-colors">
        <span class="material-symbols-outlined text-sm">close</span>
    </button>
</div>
<?php endif; ?>

<!-- Mobile Only Header & Description -->
<div class="md:hidden mb-6">
    <h2 class="text-2xl font-bold text-on-surface">Kelola Produk</h2>
    <p class="text-xs text-on-surface-variant mt-1">Daftar semua produk dalam katalog Aye Bouquet.</p>
</div>

<!-- Toolbar: Search, Filters & Add Product -->
<div class="bg-surface-container-lowest admin-dark-card rounded-2xl p-6 soft-shadow border border-outline-variant/20 mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4 card-hover-admin admin-enter">
    <!-- Left: Search & Filter Categories -->
    <form method="get" action="<?= base_url('admin/produk') ?>" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 flex-grow max-w-3xl w-full">
        <!-- Search Input -->
        <div class="relative flex items-center flex-grow">
            <span class="material-symbols-outlined absolute left-4 text-on-surface-variant select-none">search</span>
            <input type="text" name="search" value="<?= esc($search ?? '') ?>" placeholder="Cari nama produk atau SKU..." 
                   class="admin-filter-input w-full pl-12 pr-4 py-3 rounded-xl border border-outline-variant/60 dark:border-white/15 bg-surface-container-lowest text-sm text-on-surface dark:text-white focus:border-primary focus:ring-1 focus:ring-primary shadow-sm outline-none transition-all placeholder:text-on-surface-variant/50 dark:placeholder:text-white/40">
        </div>
        <!-- Filters Stack: Kategori & Status (Vertikal di Mobile, Horizontal di Desktop/Tablet) -->
        <div class="flex flex-col sm:flex-row items-stretch gap-3">
            <!-- Category Filter -->
            <div class="relative">
                <select name="category" onchange="this.form.submit()" class="admin-filter-select w-full pl-4 pr-10 py-3 rounded-xl border border-outline-variant/60 dark:border-white/15 bg-surface-container-lowest text-sm text-on-surface dark:text-white focus:border-primary focus:ring-primary shadow-sm transition-all cursor-pointer">
                    <option value="">Semua Kategori</option>
                    <?php foreach ($categories as $cat): ?>
                    <option value="<?= esc($cat['id']) ?>" <?= ($selectedCategory ?? '') == $cat['id'] ? 'selected' : '' ?>><?= esc($cat['name']) ?></option>
                    <?php endforeach; ?>
                </select>
                <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-outline">expand_more</span>
            </div>
            <!-- Status Filter (Server-side) -->
            <div class="relative">
                <select name="status" onchange="this.form.submit()" class="admin-filter-select w-full pl-4 pr-10 py-3 rounded-xl border border-outline-variant/60 dark:border-white/15 bg-surface-container-lowest text-sm text-on-surface dark:text-white focus:border-primary focus:ring-primary shadow-sm transition-all cursor-pointer">
                    <option value="">Semua Status</option>
                    <option value="ready" <?= ($selectedStatus ?? '') === 'ready' ? 'selected' : '' ?>>Ready</option>
                    <option value="pre-order" <?= ($selectedStatus ?? '') === 'pre-order' ? 'selected' : '' ?>>Pre-order</option>
                    <option value="habis" <?= ($selectedStatus ?? '') === 'habis' ? 'selected' : '' ?>>Habis</option>
                </select>
                <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-outline">expand_more</span>
            </div>
        </div>
    </form>

    <!-- Right: Add Product Button -->
    <a href="<?= base_url('admin/produk/create') ?>" class="bg-primary text-on-primary hover:bg-on-primary-fixed-variant px-5 py-3 rounded-full font-label-md text-sm font-bold flex items-center justify-center gap-2 shadow-sm transition-all hover:scale-[1.01] w-full sm:w-auto">
        <span class="material-symbols-outlined text-lg">add</span> Tambah Produk
    </a>
</div>

<!-- ==========================================
     DESKTOP LAYOUT (Table & Container)
     ========================================== -->
<div class="hidden md:block bg-surface-container-lowest admin-dark-card rounded-2xl soft-shadow border border-outline-variant/20 overflow-hidden card-hover-admin admin-enter admin-enter-delay-1">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead>
                <tr class="bg-surface-container-low/50 dark:bg-white/5 text-on-surface-variant dark:text-white/70 font-bold border-b border-outline-variant/20 dark:border-white/10">
                    <th class="py-4 px-6 w-16">Foto</th>
                    <th class="py-4 px-6">Produk</th>
                    <th class="py-4 px-6">Kategori</th>
                    <th class="py-4 px-6">Ukuran</th>
                    <th class="py-4 px-6">Warna</th>
                    <th class="py-4 px-6">Harga</th>
                    <th class="py-4 px-6">Status</th>
                    <th class="py-4 px-6 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/10">
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                    <tr class="hover:bg-surface-container-low/30 transition-colors group">
                        <td class="py-4 px-6">
                            <div class="w-12 h-12 rounded-xl overflow-hidden bg-primary-container/20 border border-outline-variant/20 flex items-center justify-center">
                                <?php if (!empty($product['primary_image'])): ?>
                                    <img src="<?= base_url('uploads/products/' . $product['primary_image']) ?>" alt="<?= esc($product['name']) ?>" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <?php
                                        // Choose icon based on category
                                        $catIcons = [
                                            'Buket Bunga' => 'local_florist',
                                            'Buket Uang'  => 'payments',
                                            'Buket Snack' => 'lunch_dining',
                                            'Selempang'   => 'award_star',
                                            'Bloom Box'   => 'inventory_2',
                                            'Custom Gift' => 'redeem',
                                        ];
                                        $icon = $catIcons[$product['category_name'] ?? ''] ?? 'redeem';
                                    ?>
                                    <span class="material-symbols-outlined text-primary text-xl"><?= $icon ?></span>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="font-label-md text-sm font-bold text-on-surface block"><?= esc($product['name']) ?></span>
                            <span class="text-xs text-on-surface-variant block mt-0.5">SKU: <?= esc($product['sku'] ?? '-') ?></span>
                        </td>
                        <td class="py-4 px-6 text-on-surface-variant text-sm"><?= esc($product['category_name'] ?? '-') ?></td>
                        <td class="py-4 px-6">
                            <div class="flex gap-1 flex-wrap">
                                <?php if (!empty($product['variants'])): ?>
                                    <?php foreach ($product['variants'] as $variant): ?>
                                    <span class="px-2 py-0.5 rounded-full bg-secondary-container dark:bg-secondary-fixed/20 text-on-secondary-container dark:text-secondary-fixed-dim text-[10px] font-bold"><?= esc($variant['size_label']) ?></span>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <span class="text-xs text-on-surface-variant">-</span>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <?php if (!empty($product['color'])): ?>
                            <?php
                                $colorMap = [
                                    'Pink'   => ['bg' => '#ec5aa6', 'text' => '#ffffff'],
                                    'Merah'  => ['bg' => '#e52525', 'text' => '#ffffff'],
                                    'Putih'  => ['bg' => '#ffffff', 'text' => '#1b1c1c'],
                                    'Biru'   => ['bg' => '#3b82f6', 'text' => '#ffffff'],
                                    'Ungu'   => ['bg' => '#a855f7', 'text' => '#ffffff'],
                                    'Kuning' => ['bg' => '#facc15', 'text' => '#1b1c1c'],
                                ];
                                $c = $colorMap[$product['color']] ?? ['bg' => '#e4e2e2', 'text' => '#1b1c1c'];
                            ?>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-semibold border border-outline-variant/30" style="background-color: <?= $c['bg'] ?>; color: <?= $c['text'] ?>;">
                                <span class="w-2 h-2 rounded-full" style="background-color: <?= $c['bg'] ?>; border: 1px solid <?= $c['text'] ?>20;"></span>
                                <?= esc($product['color']) ?>
                            </span>
                            <?php else: ?>
                            <span class="text-xs text-on-surface-variant">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="py-4 px-6 font-bold text-primary dark:text-primary-fixed-dim text-sm">Rp <?= number_format($product['price'], 0, ',', '.') ?></td>
                        <td class="py-4 px-6">
                            <?php
                                $statusClasses = [
                                    'ready'     => 'bg-[#E6F4EA] text-[#137333] border-[#CEEAD6]',
                                    'pre-order' => 'bg-[#FEF7E0] text-[#B06000] border-[#FEEFC3]',
                                    'habis'     => 'bg-[#FCE8E6] text-[#C5221F] border-[#FAD2CF]',
                                ];
                                $statusLabels = [
                                    'ready'     => 'Ready',
                                    'pre-order' => 'Pre-order',
                                    'habis'     => 'Habis',
                                ];
                                $cls = $statusClasses[$product['status']] ?? $statusClasses['ready'];
                                $lbl = $statusLabels[$product['status']] ?? $product['status'];
                            ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold <?= $cls ?> border">
                                <?= $lbl ?>
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <a href="<?= base_url('admin/produk/' . $product['id'] . '/varian') ?>" class="p-2 text-on-surface-variant hover:text-tertiary hover:bg-tertiary-container/20 rounded-xl transition-colors" title="Kelola Varian">
                                    <span class="material-symbols-outlined text-lg">tune</span>
                                </a>
                                <a href="<?= base_url('admin/produk/edit/' . $product['id']) ?>" class="p-2 text-on-surface-variant hover:text-primary hover:bg-primary-container/20 rounded-xl transition-colors" title="Edit">
                                    <span class="material-symbols-outlined text-lg">edit</span>
                                </a>
                                <button onclick="confirmDelete(<?= $product['id'] ?>, '<?= esc(addslashes($product['name'])) ?>')" class="p-2 text-on-surface-variant hover:text-error hover:bg-error-container/20 rounded-xl transition-colors" title="Hapus">
                                    <span class="material-symbols-outlined text-lg">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="py-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <span class="material-symbols-outlined text-4xl text-on-surface-variant/40">inventory_2</span>
                                <span class="text-sm text-on-surface-variant">Belum ada produk. Mulai tambahkan produk pertama Anda!</span>
                                <a href="<?= base_url('admin/produk/create') ?>" class="bg-primary text-on-primary px-4 py-2 rounded-full text-xs font-bold hover:bg-on-primary-fixed-variant transition-all">
                                    <span class="material-symbols-outlined text-sm align-middle mr-1">add</span> Tambah Produk
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Table Footer / Pagination -->
    <?php if (!empty($products)): ?>
    <div class="p-6 bg-surface-container-low/30 dark:bg-white/5 border-t border-outline-variant/20 dark:border-white/10 flex flex-col sm:flex-row items-center justify-between gap-4">
        <span class="text-xs text-on-surface-variant dark:text-white/60">Menampilkan <?= count($products) ?> produk</span>
        
        <?php if (isset($pager)): ?>
        <div class="flex items-center gap-2">
            <?= $pager->links('default', 'admin_pagination') ?>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>

<!-- ==========================================
     MOBILE LAYOUT (Card List & Container)
     ========================================== -->
<div class="md:hidden space-y-4 admin-enter admin-enter-delay-1">
    <?php if (!empty($products)): ?>
        <?php foreach ($products as $product): ?>
        <?php
            $cls = $statusClasses[$product['status']] ?? $statusClasses['ready'];
            $lbl = $statusLabels[$product['status']] ?? $product['status'];
        ?>
        <div class="product-card-mobile bg-surface-container-lowest admin-dark-card rounded-2xl p-5 soft-shadow border border-outline-variant/20 flex flex-col gap-4">
            <!-- Upper Area: Image & Info -->
            <div class="flex gap-4">
                <!-- Image Wrapper -->
                <div class="w-20 h-20 rounded-xl overflow-hidden bg-primary-container/20 border border-outline-variant/20 flex items-center justify-center flex-shrink-0">
                    <?php if (!empty($product['primary_image'])): ?>
                        <img src="<?= base_url('uploads/products/' . $product['primary_image']) ?>" alt="<?= esc($product['name']) ?>" class="w-full h-full object-cover">
                    <?php else: ?>
                        <?php
                            $catIcons = [
                                'Buket Bunga' => 'local_florist',
                                'Buket Uang'  => 'payments',
                                'Buket Snack' => 'lunch_dining',
                                'Selempang'   => 'award_star',
                                'Bloom Box'   => 'inventory_2',
                                'Custom Gift' => 'redeem',
                            ];
                            $icon = $catIcons[$product['category_name'] ?? ''] ?? 'redeem';
                        ?>
                        <span class="material-symbols-outlined text-primary text-2xl"><?= $icon ?></span>
                    <?php endif; ?>
                </div>

                <!-- Info Details -->
                <div class="flex-grow min-w-0">
                    <span class="font-label-md text-sm font-bold text-on-surface block break-words line-clamp-2 leading-tight"><?= esc($product['name']) ?></span>
                    <span class="text-[11px] text-on-surface-variant block mt-1">SKU: <?= esc($product['sku'] ?? '-') ?></span>
                    <span class="text-[11px] text-on-surface-variant block">Kategori: <?= esc($product['category_name'] ?? '-') ?></span>
                    
                    <div class="flex items-center gap-1.5 mt-2 flex-wrap">
                        <!-- Status Badge -->
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold <?= $cls ?> border">
                            <?= $lbl ?>
                        </span>
                        <!-- Active Badge -->
                        <?php if (isset($product['is_active'])): ?>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold <?= $product['is_active'] ? 'bg-[#E6F4EA] text-[#137333] border-[#CEEAD6]' : 'bg-surface-container text-on-surface-variant border-outline-variant/30' ?> border">
                                <?= $product['is_active'] ? 'Aktif' : 'Nonaktif' ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Price & Varian Row -->
            <div class="border-t border-b border-outline-variant/10 py-3 flex flex-col gap-2">
                <div class="flex items-center justify-between text-xs">
                    <span class="text-on-surface-variant">Harga</span>
                    <span class="font-bold text-primary dark:text-primary-fixed-dim text-sm">Rp <?= number_format($product['price'], 0, ',', '.') ?></span>
                </div>
                
                <div class="flex items-start justify-between text-xs gap-4">
                    <span class="text-on-surface-variant flex-shrink-0 mt-0.5">Varian</span>
                    <div class="flex gap-1 flex-wrap justify-end">
                        <?php if (!empty($product['variants'])): ?>
                            <?php foreach ($product['variants'] as $variant): ?>
                            <span class="px-2 py-0.5 rounded-full bg-secondary-container dark:bg-secondary-fixed/20 text-on-secondary-container dark:text-secondary-fixed-dim text-[10px] font-bold"><?= esc($variant['size_label']) ?></span>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <span class="text-on-surface-variant">-</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Actions Row -->
            <div class="grid grid-cols-3 gap-2">
                <a href="<?= base_url('admin/produk/' . $product['id'] . '/varian') ?>" class="flex items-center justify-center gap-1.5 py-2.5 rounded-xl border border-outline-variant text-xs font-semibold text-on-surface hover:bg-surface-container-high transition-colors" title="Kelola Varian">
                    <span class="material-symbols-outlined text-base">tune</span> Varian
                </a>
                <a href="<?= base_url('admin/produk/edit/' . $product['id']) ?>" class="flex items-center justify-center gap-1.5 py-2.5 rounded-xl bg-primary/10 text-primary hover:bg-primary/20 text-xs font-semibold transition-colors" title="Edit">
                    <span class="material-symbols-outlined text-base">edit</span> Edit
                </a>
                <button onclick="confirmDelete(<?= $product['id'] ?>, '<?= esc(addslashes($product['name'])) ?>')" class="flex items-center justify-center gap-1.5 py-2.5 rounded-xl bg-error/10 text-error hover:bg-error/20 text-xs font-semibold transition-colors" title="Hapus">
                    <span class="material-symbols-outlined text-base">delete</span> Hapus
                </button>
            </div>
        </div>
        <?php endforeach; ?>

        <!-- Mobile Pagination Container -->
        <?php if (isset($pager)): ?>
        <div class="p-4 bg-surface-container-lowest admin-dark-card rounded-2xl border border-outline-variant/20 soft-shadow flex flex-col items-center justify-between gap-4">
            <span class="text-xs text-on-surface-variant">Menampilkan <?= count($products) ?> produk</span>
            <div class="flex items-center gap-2">
                <?= $pager->links('default', 'admin_pagination') ?>
            </div>
        </div>
        <?php endif; ?>

    <?php else: ?>
        <div class="bg-surface-container-lowest admin-dark-card rounded-2xl p-8 text-center border border-outline-variant/20 soft-shadow">
            <span class="material-symbols-outlined text-4xl text-on-surface-variant/40 mb-3 block">inventory_2</span>
            <h3 class="text-sm font-bold text-on-surface">Belum ada produk</h3>
            <p class="text-xs text-on-surface-variant mt-1 mb-4">Tambahkan produk pertama untuk mulai mengisi katalog.</p>
            <a href="<?= base_url('admin/produk/create') ?>" class="inline-flex items-center justify-center gap-2 bg-primary text-on-primary px-5 py-2.5 rounded-full text-xs font-bold hover:bg-on-primary-fixed-variant transition-all shadow-sm w-full">
                <span class="material-symbols-outlined text-sm">add</span> Tambah Produk
            </a>
        </div>
    <?php endif; ?>
</div>

<script>
    function confirmDelete(id, name) {
        openAdminConfirm({
            title: 'Hapus Produk?',
            message: 'Apakah Anda yakin ingin menghapus produk "' + name + '"? Tindakan ini tidak dapat dibatalkan. Semua varian dan gambar juga akan dihapus.',
            confirmText: 'Ya, Hapus',
            confirmClass: 'bg-error text-on-error hover:bg-error/90',
            action: '<?= base_url('admin/produk/delete/') ?>' + id,
            method: 'POST'
        });
    }

    // Auto-dismiss flash messages after 5 seconds
    setTimeout(() => {
        const flash = document.getElementById('flash-success') || document.getElementById('flash-error');
        if (flash) {
            flash.style.transition = 'opacity 0.5s';
            flash.style.opacity = '0';
            setTimeout(() => flash.remove(), 500);
        }
    }, 5000);
</script>
<?= $this->endSection() ?>
