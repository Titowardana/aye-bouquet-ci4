<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="mb-6 md:mb-8 admin-enter">
    <h1 class="font-headline-lg text-2xl md:text-headline-lg text-on-surface mb-1 md:mb-2">Kelola FAQ</h1>
    <p class="font-body-md text-sm md:text-body-md text-on-surface-variant">Kelola pertanyaan umum yang sering ditanyakan pelanggan.</p>
</div>

<!-- Flash Messages -->
<?php if (session()->getFlashdata('success')): ?>
<div class="mb-6 p-4 rounded-xl bg-[#DCEFDF] dark:bg-green-900/20 border border-[#C3E6CB] dark:border-green-700/30 text-[#1E7E34] dark:text-green-300 text-sm font-semibold flex items-center justify-between">
    <div class="flex items-center gap-2">
        <span class="material-symbols-outlined text-lg">check_circle</span>
        <?= esc(session()->getFlashdata('success')) ?>
    </div>
    <button onclick="this.parentElement.remove()" class="hover:text-[#155724] dark:text-green-300"><span class="material-symbols-outlined text-sm">close</span></button>
</div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
<div class="mb-6 p-4 rounded-xl bg-[#FCE8E6] dark:bg-red-900/20 border border-[#FAD2CF] dark:border-red-700/30 text-[#C5221F] dark:text-red-300 text-sm font-semibold flex items-center justify-between">
    <div class="flex items-center gap-2">
        <span class="material-symbols-outlined text-lg">error</span>
        <?= esc(session()->getFlashdata('error')) ?>
    </div>
    <button onclick="this.parentElement.remove()" class="hover:text-[#a5211f] dark:text-red-300"><span class="material-symbols-outlined text-sm">close</span></button>
</div>
<?php endif; ?>

<!-- Action Bar -->
<div class="bg-surface-container-lowest rounded-xl shadow-sm p-4 mb-6 flex flex-col md:flex-row gap-4 items-stretch md:items-center justify-between border border-outline-variant/20 dark:border-white/10 card-hover-admin admin-enter admin-enter-delay-1">
    <form method="get" action="<?= base_url('admin/faqs') ?>" class="flex flex-col sm:flex-row gap-3 flex-1">
        <div class="relative flex-1">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
            <input name="search" value="<?= esc($search ?? '') ?>" class="admin-filter-input w-full pl-10 pr-4 py-2.5 bg-surface rounded-lg border border-outline-variant dark:border-white/15 focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none font-body-md text-sm text-on-surface dark:text-white transition-colors placeholder:text-on-surface-variant/50 dark:placeholder:text-white/40" placeholder="Cari pertanyaan..." type="text"/>
        </div>
        
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="relative">
                <select name="status" onchange="this.form.submit()" class="admin-filter-select w-full pl-4 pr-10 py-2.5 bg-surface rounded-lg border border-outline-variant dark:border-white/15 focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none font-body-md text-sm text-on-surface dark:text-white cursor-pointer min-w-[160px]">
                    <option value="">Semua Status</option>
                    <option value="tampil" <?= ($selectedStatus ?? '') === 'tampil' ? 'selected' : '' ?>>Tampil</option>
                    <option value="disembunyikan" <?= ($selectedStatus ?? '') === 'disembunyikan' ? 'selected' : '' ?>>Disembunyikan</option>
                </select>
                <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none">expand_more</span>
            </div>
            
            <div class="relative">
                <select name="category" onchange="this.form.submit()" class="admin-filter-select w-full pl-4 pr-10 py-2.5 bg-surface rounded-lg border border-outline-variant dark:border-white/15 focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none font-body-md text-sm text-on-surface dark:text-white cursor-pointer min-w-[180px]">
                    <option value="">Semua Kategori</option>
                    <?php
                    $catOpts = [
                        'pemesanan' => 'Pemesanan',
                        'custom_order' => 'Custom Order',
                        'pembayaran' => 'Pembayaran',
                        'pengiriman' => 'Pengiriman',
                        'produk' => 'Produk'
                    ];
                    foreach ($catOpts as $v => $l): ?>
                        <option value="<?= $v ?>" <?= ($selectedCategory ?? '') === $v ? 'selected' : '' ?>><?= $l ?></option>
                    <?php endforeach; ?>
                </select>
                <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none">expand_more</span>
            </div>
        </div>
    </form>
    
    <a href="<?= base_url('admin/faqs/create') ?>" class="flex items-center justify-center gap-2 bg-primary text-on-primary hover:bg-on-primary-fixed-variant py-2.5 px-6 rounded-full font-label-md text-sm transition-colors shadow-sm whitespace-nowrap w-full sm:w-auto">
        <span class="material-symbols-outlined text-[20px]">add</span>
        Tambah FAQ
    </a>
</div>

<!-- ==========================================
     DESKTOP LAYOUT (Table & Container)
     ========================================== -->
<div class="hidden md:block bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/20 overflow-hidden card-hover-admin admin-enter admin-enter-delay-2">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-surface-container-low dark:bg-[#2a2328] border-b border-outline-variant/30 dark:border-white/10">
                    <th class="py-4 px-6 font-label-md text-label-md text-on-surface-variant dark:text-white/70">Pertanyaan</th>
                    <th class="py-4 px-6 font-label-md text-label-md text-on-surface-variant dark:text-white/70 whitespace-nowrap">Kategori</th>
                    <th class="py-4 px-6 font-label-md text-label-md text-on-surface-variant dark:text-white/70 hidden md:table-cell">Jawaban Singkat</th>
                    <th class="py-4 px-6 font-label-md text-label-md text-on-surface-variant dark:text-white/70 text-center">Status</th>
                    <th class="py-4 px-6 font-label-md text-label-md text-on-surface-variant dark:text-white/70 text-center">Urutan</th>
                    <th class="py-4 px-6 font-label-md text-label-md text-on-surface-variant dark:text-white/70 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/20">
                <?php if (!empty($faqs)): ?>
                    <?php foreach ($faqs as $faq): ?>
                    <tr class="hover:bg-surface-container-low/50 transition-colors group">
                        <td class="py-4 px-6 font-body-md text-sm text-on-surface font-medium"><?= esc($faq['question']) ?></td>
                        <td class="py-4 px-6 font-body-md text-sm text-on-surface-variant">
                            <span class="bg-secondary-container px-3 py-1 rounded-full text-xs font-semibold">
                                <?= ucwords(str_replace('_', ' ', esc($faq['category']))) ?>
                            </span>
                        </td>
                        <td class="py-4 px-6 font-body-md text-sm text-on-surface-variant truncate max-w-xs hidden md:table-cell">
                            <?= esc(mb_strimwidth($faq['answer'], 0, 40, '...')) ?>
                        </td>
                        <td class="py-4 px-6 text-center">
                            <?php if ($faq['is_active']): ?>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-[#e8f5e9] dark:bg-green-900/30 text-[#2e7d32] dark:text-green-300">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#4caf50]"></span> Tampil
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-surface-variant dark:bg-white/10 text-on-surface-variant dark:text-white/60">
                                    <span class="w-1.5 h-1.5 rounded-full bg-outline dark:bg-white/40"></span> Sembunyi
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="py-4 px-6 font-body-md text-sm text-on-surface-variant text-center"><?= esc($faq['sort_order']) ?></td>
                        <td class="py-4 px-6 text-right space-x-1">
                            <form action="<?= base_url('admin/faqs/toggle-status/' . $faq['id']) ?>" method="post" class="inline">
                                <?= csrf_field() ?>
                                <button type="submit" class="p-2 text-on-surface-variant hover:text-primary rounded-full hover:bg-primary-container/20 transition-colors" title="Toggle Tampil">
                                    <span class="material-symbols-outlined text-[20px]"><?= $faq['is_active'] ? 'visibility' : 'visibility_off' ?></span>
                                </button>
                            </form>
                            
                            <a href="<?= base_url('admin/faqs/edit/' . $faq['id']) ?>" class="inline-block p-2 text-on-surface-variant hover:text-primary rounded-full hover:bg-primary-container/20 transition-colors" title="Edit">
                                <span class="material-symbols-outlined text-[20px]">edit</span>
                            </a>
                            
                            <button type="button" onclick="openAdminConfirm({ title: 'Hapus FAQ?', message: 'Yakin ingin menghapus FAQ ini? Tindakan ini tidak bisa dibatalkan.', confirmText: 'Ya, Hapus', confirmClass: 'bg-error text-on-error hover:bg-error/90', action: '<?= base_url('admin/faqs/delete/' . $faq['id']) ?>', method: 'POST' })" class="p-2 text-on-surface-variant hover:text-error rounded-full hover:bg-error-container/50 transition-colors" title="Hapus">
                                <span class="material-symbols-outlined text-[20px]">delete</span>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="py-12 text-center text-on-surface-variant">
                            <span class="material-symbols-outlined text-4xl block mb-2 opacity-50">quiz</span>
                            Belum ada FAQ yang ditambahkan.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Pagination Footer Desktop -->
    <?php if (isset($pager)): ?>
    <div class="px-6 py-4 border-t border-outline-variant/20 bg-surface-container-lowest flex items-center justify-between">
        <?= $pager->links('admin_pagination', 'admin_pagination') ?>
    </div>
    <?php endif; ?>
</div>

<!-- ==========================================
     MOBILE LAYOUT (Card List)
     ========================================== -->
<div class="md:hidden space-y-4 admin-enter admin-enter-delay-2">
    <?php if (!empty($faqs)): ?>
        <?php foreach ($faqs as $faq): ?>
        <div class="bg-surface-container-lowest rounded-2xl p-5 border border-outline-variant/20 soft-shadow flex flex-col gap-3">
            <div class="flex justify-between items-start gap-3">
                <span class="bg-secondary-container px-2.5 py-1 rounded-full text-[10px] font-semibold text-on-surface flex-shrink-0">
                    <?= ucwords(str_replace('_', ' ', esc($faq['category']))) ?>
                </span>
                <?php if ($faq['is_active']): ?>
                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-medium bg-[#e8f5e9] dark:bg-green-900/30 text-[#2e7d32] dark:text-green-300 flex-shrink-0">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#4caf50]"></span> Tampil
                    </span>
                <?php else: ?>
                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-medium bg-surface-variant dark:bg-white/10 text-on-surface-variant dark:text-white/60 flex-shrink-0">
                        <span class="w-1.5 h-1.5 rounded-full bg-outline dark:bg-white/40"></span> Sembunyi
                    </span>
                <?php endif; ?>
            </div>
            
            <div>
                <h3 class="font-bold text-sm text-on-surface mb-1.5 leading-snug"><?= esc($faq['question']) ?></h3>
                <p class="text-[13px] text-on-surface-variant line-clamp-3 leading-relaxed"><?= esc($faq['answer']) ?></p>
            </div>
            
            <div class="flex items-center justify-between border-t border-outline-variant/10 pt-3 mt-1">
                <span class="text-[11px] text-on-surface-variant">Urutan: <strong class="text-on-surface"><?= esc($faq['sort_order']) ?></strong></span>
                <div class="flex items-center gap-2">
                    <form action="<?= base_url('admin/faqs/toggle-status/' . $faq['id']) ?>" method="post" class="inline">
                        <?= csrf_field() ?>
                        <button type="submit" class="w-9 h-9 flex items-center justify-center text-on-surface-variant hover:text-primary rounded-full bg-surface hover:bg-primary-container/20 transition-colors border border-outline-variant/40" title="Toggle Tampil">
                            <span class="material-symbols-outlined text-[18px]"><?= $faq['is_active'] ? 'visibility' : 'visibility_off' ?></span>
                        </button>
                    </form>
                    
                    <a href="<?= base_url('admin/faqs/edit/' . $faq['id']) ?>" class="w-9 h-9 flex items-center justify-center text-on-surface-variant hover:text-primary rounded-full bg-surface hover:bg-primary-container/20 transition-colors border border-outline-variant/40" title="Edit">
                        <span class="material-symbols-outlined text-[18px]">edit</span>
                    </a>
                    
                    <button type="button" onclick="openAdminConfirm({ title: 'Hapus FAQ?', message: 'Yakin ingin menghapus FAQ ini? Tindakan ini tidak bisa dibatalkan.', confirmText: 'Ya, Hapus', confirmClass: 'bg-error text-on-error hover:bg-error/90', action: '<?= base_url('admin/faqs/delete/' . $faq['id']) ?>', method: 'POST' })" class="w-9 h-9 flex items-center justify-center text-on-surface-variant hover:text-error rounded-full bg-surface hover:bg-error-container/50 transition-colors border border-outline-variant/40" title="Hapus">
                        <span class="material-symbols-outlined text-[18px]">delete</span>
                    </button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        
        <!-- Pagination Footer Mobile -->
        <?php if (isset($pager)): ?>
        <div class="px-4 py-3 bg-surface-container-lowest rounded-2xl border border-outline-variant/20 flex items-center justify-center soft-shadow">
            <?= $pager->links('admin_pagination', 'admin_pagination') ?>
        </div>
        <?php endif; ?>

    <?php else: ?>
        <div class="bg-surface-container-lowest rounded-2xl p-8 text-center border border-outline-variant/20 soft-shadow">
            <span class="material-symbols-outlined text-4xl block mb-2 opacity-50 text-on-surface-variant">quiz</span>
            <h3 class="text-sm font-bold text-on-surface">Belum ada FAQ</h3>
            <p class="text-xs text-on-surface-variant mt-1 mb-4">Tambahkan pertanyaan umum agar pelanggan lebih mudah memahami layanan Aye Bouquet.</p>
            <a href="<?= base_url('admin/faqs/create') ?>" class="inline-flex items-center justify-center gap-2 bg-primary text-on-primary px-5 py-2.5 rounded-full text-xs font-bold hover:bg-on-primary-fixed-variant transition-all shadow-sm w-full">
                <span class="material-symbols-outlined text-sm">add</span> Tambah FAQ
            </a>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
