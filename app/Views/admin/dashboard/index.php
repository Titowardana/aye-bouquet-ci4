<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<!-- Bento Grid Statistics -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Stat Card 1: Total Produk -->
    <div class="bg-surface-container-lowest dark:bg-on-background rounded-2xl p-6 soft-shadow border border-outline-variant/20 flex items-center justify-between group hover:border-primary/20 transition-all duration-300 aye-bento-glow aye-hover-lift admin-enter admin-enter-delay-1">
        <div>
            <span class="text-xs font-bold text-on-surface-variant block uppercase tracking-wider mb-1">Total Produk</span>
            <span class="text-3xl font-extrabold text-on-surface block"><?= esc($totalProducts) ?></span>
            <span class="text-[10px] text-primary dark:text-primary-fixed-dim block mt-1 font-semibold flex items-center gap-0.5">
                <span class="material-symbols-outlined text-[12px]">trending_up</span> +<?= esc($newProductsThisWeek) ?> produk minggu ini
            </span>
        </div>
        <div class="w-12 h-12 rounded-xl bg-primary-container dark:bg-primary-fixed/20 text-primary dark:text-primary-fixed-dim flex items-center justify-center group-hover:scale-110 group-hover:-rotate-3 transition-all duration-300">
            <span class="material-symbols-outlined text-2xl font-bold">redeem</span>
        </div>
    </div>

    <!-- Stat Card 2: Total Kategori -->
    <div class="bg-surface-container-lowest dark:bg-on-background rounded-2xl p-6 soft-shadow border border-outline-variant/20 flex items-center justify-between group hover:border-primary/20 transition-all duration-300 aye-bento-glow aye-hover-lift admin-enter admin-enter-delay-2">
        <div>
            <span class="text-xs font-bold text-on-surface-variant block uppercase tracking-wider mb-1">Total Kategori</span>
            <span class="text-3xl font-extrabold text-on-surface block"><?= esc($totalCategories) ?></span>
            <span class="text-[10px] text-on-surface-variant block mt-1 font-semibold">Tersinkronisasi</span>
        </div>
        <div class="w-12 h-12 rounded-xl bg-tertiary-container dark:bg-tertiary-fixed/20 text-tertiary dark:text-tertiary-fixed-dim flex items-center justify-center group-hover:scale-110 group-hover:-rotate-3 transition-all duration-300">
            <span class="material-symbols-outlined text-2xl font-bold">category</span>
        </div>
    </div>

    <!-- Stat Card 3: Total Produk Aktif -->
    <div class="bg-surface-container-lowest dark:bg-on-background rounded-2xl p-6 soft-shadow border border-outline-variant/20 flex items-center justify-between group hover:border-primary/20 transition-all duration-300 aye-bento-glow aye-hover-lift admin-enter admin-enter-delay-3">
        <div>
            <span class="text-xs font-bold text-on-surface-variant block uppercase tracking-wider mb-1">Produk Ready</span>
            <span class="text-3xl font-extrabold text-on-surface block"><?= esc($readyCount) ?></span>
            <span class="text-[10px] text-[#2E7D4F] dark:text-[#C8F7DC] block mt-1 font-semibold flex items-center gap-0.5">
                <span class="material-symbols-outlined text-[12px]">check_circle</span> Siap dipesan
            </span>
        </div>
        <div class="w-12 h-12 rounded-xl bg-[#E6F4EA] dark:bg-[#E6F4EA]/10 text-[#137333] dark:text-[#C8F7DC] flex items-center justify-center group-hover:scale-110 group-hover:-rotate-3 transition-all duration-300">
            <span class="material-symbols-outlined text-2xl font-bold">inventory</span>
        </div>
    </div>

    <!-- Stat Card 4: Total Ulasan -->
    <div class="bg-surface-container-lowest dark:bg-on-background rounded-2xl p-6 soft-shadow border border-outline-variant/20 flex items-center justify-between group hover:border-primary/20 transition-all duration-300 aye-bento-glow aye-hover-lift admin-enter admin-enter-delay-4">
        <div>
            <span class="text-xs font-bold text-on-surface-variant block uppercase tracking-wider mb-1">Total Ulasan</span>
            <span class="text-3xl font-extrabold text-on-surface block"><?= esc($totalTestimonials) ?></span>
            <span class="text-[10px] text-primary dark:text-primary-fixed-dim block mt-1 font-semibold flex items-center gap-0.5">
                <span class="material-symbols-outlined text-[12px]" style="font-variation-settings: 'FILL' 1">star</span> <?= esc($avgRating) ?>/5 Rating Rata-rata
            </span>
        </div>
        <div class="w-12 h-12 rounded-xl bg-primary-container dark:bg-primary-fixed/20 text-primary dark:text-primary-fixed-dim flex items-center justify-center group-hover:scale-110 group-hover:-rotate-3 transition-all duration-300">
            <span class="material-symbols-outlined text-2xl font-bold" style="font-variation-settings: 'FILL' 1">star</span>
        </div>
    </div>
</div>

<!-- Stat Card 5: Total Pesanan -->
<div class="bg-surface-container-lowest dark:bg-on-background rounded-2xl p-6 soft-shadow border border-outline-variant/20 flex items-center justify-between group hover:border-primary/20 transition-all duration-300 aye-bento-glow aye-hover-lift admin-enter admin-enter-delay-5 mb-8">
    <div>
            <span class="text-xs font-bold text-on-surface-variant block uppercase tracking-wider mb-1">Total Pesanan</span>
            <span class="text-3xl font-extrabold text-on-surface block"><?= esc($totalOrders ?? 0) ?></span>
            <span class="text-[10px] text-primary dark:text-primary-fixed-dim block mt-1 font-semibold flex items-center gap-0.5">
                <span class="material-symbols-outlined text-[12px]" style="font-variation-settings: 'FILL' 1">receipt_long</span>
                <?= esc($newOrders ?? 0) ?> Pesanan Baru
            </span>
    </div>
    <div class="w-12 h-12 rounded-xl bg-primary-container dark:bg-primary-fixed/20 text-primary dark:text-primary-fixed-dim flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
        <span class="material-symbols-outlined text-2xl font-bold" style="font-variation-settings: 'FILL' 1">receipt_long</span>
    </div>
</div>

<!-- Bento Grid: Main Content & Recent Orders -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Recent Products Table (2 Columns Span) -->
    <div class="bg-surface-container-lowest dark:bg-on-background rounded-2xl p-6 soft-shadow border border-outline-variant/20 lg:col-span-2 flex flex-col justify-between card-hover-admin admin-enter admin-enter-delay-2">
        <div>
            <div class="flex items-center justify-between border-b border-outline-variant/20 pb-4 mb-4">
                <h3 class="font-headline-md text-lg font-bold text-on-surface">Produk Terbaru</h3>
                <a href="<?= base_url('admin/produk') ?>" class="text-xs text-primary dark:text-primary-fixed-dim font-bold cursor-pointer hover:underline">Lihat Semua</a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead>
                        <tr class="text-on-surface-variant font-bold border-b border-outline-variant/20">
                            <th class="py-2.5 px-3 pl-0">Produk</th>
                            <th class="py-2.5 px-3">Kategori</th>
                            <th class="py-2.5 px-3">Harga</th>
                            <th class="py-2.5 px-3 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/10">
                        <?php if (!empty($recentProducts)): ?>
                            <?php foreach ($recentProducts as $product): ?>
                            <tr class="text-on-surface hover:bg-surface-container-low/30 transition-colors">
                                <td class="py-3 px-3 pl-0 font-medium"><?= esc($product['name']) ?></td>
                                <td class="py-3 px-3 text-on-surface-variant"><?= esc($product['category_name'] ?? '-') ?></td>
                                <td class="py-3 px-3 text-primary dark:text-primary-fixed-dim font-semibold">Rp <?= number_format($product['price'], 0, ',', '.') ?></td>
                                <td class="py-3 px-3 text-right">
                                    <?php
                                        $statusClasses = [
                                            'ready'     => 'bg-[#DCEFDF] text-[#1E7E34] border-[#C3E6CB]',
                                            'pre-order' => 'bg-[#FFEDD5] text-[#9A3412] border-[#FED7AA]',
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
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold <?= $cls ?> border">
                                        <?= $lbl ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="py-6 text-center text-on-surface-variant text-sm">Belum ada produk.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right Side: Quick Action & Testimonial Carousel -->
    <div class="space-y-6">
        <!-- Quick Actions Panel -->
        <div class="bg-surface-container-lowest dark:bg-on-background rounded-2xl p-6 soft-shadow border border-outline-variant/20 card-hover-admin admin-enter admin-enter-delay-3">
            <h3 class="font-headline-md text-lg font-bold text-on-surface border-b border-outline-variant/20 pb-4 mb-4">Aksi Cepat</h3>
            <div class="grid grid-cols-2 gap-4">
                <a href="<?= base_url('admin/produk') ?>" class="p-4 bg-primary-container/30 dark:bg-primary/10 border border-primary/10 rounded-xl hover:bg-primary-container/50 transition-colors text-center flex flex-col items-center gap-2 group">
                    <span class="material-symbols-outlined text-primary dark:text-primary-fixed-dim text-2xl group-hover:scale-110 transition-transform">add_circle</span>
                    <span class="text-xs font-bold text-on-surface">Tambah Produk</span>
                </a>
                <a href="<?= base_url('/') ?>" class="p-4 bg-tertiary-container/30 dark:bg-tertiary/10 border border-tertiary/10 rounded-xl hover:bg-tertiary-container/50 transition-colors text-center flex flex-col items-center gap-2 group">
                    <span class="material-symbols-outlined text-tertiary dark:text-tertiary-fixed-dim text-2xl group-hover:scale-110 transition-transform">visibility</span>
                    <span class="text-xs font-bold text-on-surface">Lihat Toko</span>
                </a>
            </div>
        </div>

        <!-- Latest Testimonials Widget -->
        <div class="bg-surface-container-lowest dark:bg-on-background rounded-2xl p-6 soft-shadow border border-outline-variant/20 card-hover-admin admin-enter admin-enter-delay-4">
            <div class="flex items-center justify-between border-b border-outline-variant/20 pb-4 mb-4">
                <h3 class="font-headline-md text-lg font-bold text-on-surface">Ulasan Terbaru</h3>
                <span class="material-symbols-outlined text-on-surface-variant cursor-pointer hover:text-primary">rate_review</span>
            </div>
            
            <div class="space-y-4">
                <?php if (!empty($latestTestimonials)): ?>
                    <?php foreach ($latestTestimonials as $i => $testi): ?>
                    <div class="<?= $i < count($latestTestimonials) - 1 ? 'border-b border-outline-variant/10 pb-3' : 'pb-3' ?>">
                        <div class="flex items-center gap-1 mb-1">
                            <?php for ($s = 1; $s <= 5; $s++): ?>
                            <span class="material-symbols-outlined text-sm text-primary" style="font-variation-settings: 'FILL' <?= $s <= $testi['rating'] ? '1' : '0' ?>"><?= $s <= $testi['rating'] ? 'star' : 'star' ?></span>
                            <?php endfor; ?>
                        </div>
                        <p class="text-xs text-on-surface-variant italic mb-2">"<?= esc(mb_strimwidth($testi['message'], 0, 80, '...')) ?>"</p>
                        <div class="flex items-center justify-between text-[10px] text-on-surface-variant">
                            <span class="font-bold"><?= esc($testi['customer_name']) ?></span>
                            <span><?= formatTanggalIndo($testi['created_at']) ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-xs text-on-surface-variant text-center py-4">Belum ada ulasan.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
