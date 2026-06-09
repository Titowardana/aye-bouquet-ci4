<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="mb-6 md:mb-8 admin-enter">
    <h1 class="font-headline-lg text-2xl md:text-headline-lg text-on-surface mb-1 md:mb-2">Kelola Testimonial</h1>
    <p class="font-body-md text-sm md:text-body-md text-on-surface-variant">Kelola ulasan dan testimonial dari pelanggan.</p>
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
<div class="bg-surface-container-lowest rounded-xl shadow-sm p-4 mb-6 flex flex-col md:flex-row gap-4 items-stretch md:items-center justify-between border border-outline-variant/20 card-hover-admin admin-enter admin-enter-delay-1">
    <form method="get" action="<?= base_url('admin/testimonials') ?>" class="flex flex-col sm:flex-row gap-3 flex-1">
        <div class="relative flex-1">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
            <input name="search" value="<?= esc($search ?? '') ?>" class="w-full pl-10 pr-4 py-2.5 bg-surface dark:bg-white/5 rounded-lg border border-outline-variant dark:border-white/15 focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none font-body-md text-sm text-on-surface dark:text-white transition-colors placeholder:text-on-surface-variant/50 dark:placeholder:text-white/40" placeholder="Cari nama atau ulasan..." type="text"/>
        </div>
        
        <div class="relative">
            <select name="status" onchange="this.form.submit()" class="w-full appearance-none pl-4 pr-10 py-2.5 bg-surface dark:bg-[#211b1f] rounded-lg border border-outline-variant dark:border-white/15 focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none font-body-md text-sm text-on-surface dark:text-white cursor-pointer min-w-[160px]">
                <option value="">Semua Status</option>
                <option value="approved" <?= ($selectedStatus ?? '') === 'approved' ? 'selected' : '' ?>>Disetujui</option>
                <option value="pending" <?= ($selectedStatus ?? '') === 'pending' ? 'selected' : '' ?>>Menunggu Review</option>
            </select>
            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none">expand_more</span>
        </div>
    </form>
</div>

<!-- ==========================================
     DESKTOP LAYOUT (Table & Container)
     ========================================== -->
<div class="hidden md:block bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/20 overflow-hidden card-hover-admin admin-enter admin-enter-delay-2">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-surface-container-low dark:bg-[#2a2328] border-b border-outline-variant/30 dark:border-white/10">
                    <th class="py-4 px-6 font-label-md text-label-md text-on-surface-variant dark:text-white/70">Pelanggan</th>
                    <th class="py-4 px-6 font-label-md text-label-md text-on-surface-variant dark:text-white/70">Rating</th>
                    <th class="py-4 px-6 font-label-md text-label-md text-on-surface-variant dark:text-white/70 hidden md:table-cell">Ulasan</th>
                    <th class="py-4 px-6 font-label-md text-label-md text-on-surface-variant dark:text-white/70 text-center">Status</th>
                    <th class="py-4 px-6 font-label-md text-label-md text-on-surface-variant dark:text-white/70 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/20">
                <?php if (!empty($testimonials)): ?>
                    <?php foreach ($testimonials as $testimonial): ?>
                    <tr class="hover:bg-surface-container-low/50 transition-colors group">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <?php if (!empty($testimonial['photo'])): ?>
                                    <div class="w-10 h-10 rounded-full overflow-hidden flex-shrink-0 bg-surface-container">
                                        <img src="<?= base_url('uploads/testimonials/' . $testimonial['photo']) ?>" alt="<?= esc($testimonial['customer_name']) ?>" class="w-full h-full object-cover">
                                    </div>
                                <?php else: ?>
                                    <div class="w-10 h-10 rounded-full bg-primary-container text-primary flex items-center justify-center font-bold text-sm flex-shrink-0">
                                        <?= strtoupper(substr($testimonial['customer_name'], 0, 1)) ?>
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <div class="font-body-md text-sm text-on-surface font-semibold"><?= esc($testimonial['customer_name']) ?></div>
                                    <div class="font-body-md text-xs text-on-surface-variant"><?= formatTanggalIndo($testimonial['created_at']) ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center text-amber-500">
                                <?php for($i=1; $i<=5; $i++): ?>
                                    <span class="material-symbols-outlined text-[16px]" style="font-variation-settings: 'FILL' <?= $i <= $testimonial['rating'] ? '1' : '0' ?>;"><?= $i <= $testimonial['rating'] ? 'star' : 'star_border' ?></span>
                                <?php endfor; ?>
                            </div>
                        </td>
                        <td class="py-4 px-6 font-body-md text-sm text-on-surface-variant truncate max-w-sm hidden md:table-cell">
                            <?= esc(mb_strimwidth($testimonial['message'], 0, 60, '...')) ?>
                        </td>
                        <td class="py-4 px-6 text-center">
                            <?php if ($testimonial['is_approved']): ?>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-[#e8f5e9] dark:bg-green-900/30 text-[#2e7d32] dark:text-green-300">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#4caf50]"></span> Disetujui
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-[#fff3e0] dark:bg-yellow-900/30 text-[#e65100] dark:text-yellow-300">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#ff9800]"></span> Pending
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="py-4 px-6 text-right space-x-1 whitespace-nowrap">
                            <form action="<?= base_url('admin/testimonials/toggle-status/' . $testimonial['id']) ?>" method="post" class="inline">
                                <?= csrf_field() ?>
                                <?php if ($testimonial['is_approved']): ?>
                                <button type="submit" class="p-2 text-on-surface-variant hover:text-error rounded-full hover:bg-error-container/20 transition-colors" title="Batalkan Persetujuan">
                                    <span class="material-symbols-outlined text-[20px]">cancel</span>
                                </button>
                                <?php else: ?>
                                <button type="submit" class="p-2 text-on-surface-variant hover:text-[#2e7d32] rounded-full hover:bg-[#e8f5e9] transition-colors" title="Setujui Testimonial">
                                    <span class="material-symbols-outlined text-[20px]">check_circle</span>
                                </button>
                                <?php endif; ?>
                            </form>
                            
                            <button type="button" onclick="openAdminConfirm({ title: 'Hapus Testimonial?', message: 'Yakin ingin menghapus testimonial ini? Tindakan ini tidak bisa dibatalkan.', confirmText: 'Ya, Hapus', confirmClass: 'bg-error text-on-error hover:bg-error/90', action: '<?= base_url('admin/testimonials/delete/' . $testimonial['id']) ?>', method: 'POST' })" class="p-2 text-on-surface-variant hover:text-error rounded-full hover:bg-error-container/50 transition-colors" title="Hapus">
                                <span class="material-symbols-outlined text-[20px]">delete</span>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="py-12 text-center text-on-surface-variant">
                            <span class="material-symbols-outlined text-4xl block mb-2 opacity-50">reviews</span>
                            Belum ada testimonial.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Pagination Footer Desktop -->
    <?php if (isset($pager)): ?>
    <div class="px-6 py-4 border-t border-outline-variant/20 bg-surface-container-lowest flex items-center justify-between">
        <?= $pager->links('default', 'admin_pagination') ?>
    </div>
    <?php endif; ?>
</div>

<!-- ==========================================
     MOBILE LAYOUT (Card List)
     ========================================== -->
<div class="md:hidden space-y-4 admin-enter admin-enter-delay-2">
    <?php if (!empty($testimonials)): ?>
        <?php foreach ($testimonials as $testimonial): ?>
        <div class="bg-surface-container-lowest rounded-2xl p-5 border border-outline-variant/20 soft-shadow flex flex-col gap-3">
            <div class="flex justify-between items-start">
                <div class="flex items-center gap-3">
                    <?php if (!empty($testimonial['photo'])): ?>
                        <div class="w-12 h-12 rounded-full overflow-hidden flex-shrink-0 bg-surface-container border border-outline-variant/20">
                            <img src="<?= base_url('uploads/testimonials/' . $testimonial['photo']) ?>" alt="<?= esc($testimonial['customer_name']) ?>" class="w-full h-full object-cover">
                        </div>
                    <?php else: ?>
                        <div class="w-12 h-12 rounded-full bg-primary-container text-primary flex items-center justify-center font-bold text-lg flex-shrink-0 border border-primary/20">
                            <?= strtoupper(substr($testimonial['customer_name'], 0, 1)) ?>
                        </div>
                    <?php endif; ?>
                    <div>
                        <div class="font-bold text-sm text-on-surface leading-tight"><?= esc($testimonial['customer_name']) ?></div>
                        <div class="text-[11px] text-on-surface-variant mt-0.5"><?= formatTanggalIndo($testimonial['created_at']) ?></div>
                    </div>
                </div>
                
                <?php if ($testimonial['is_approved']): ?>
                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-medium bg-[#e8f5e9] dark:bg-green-900/30 text-[#2e7d32] dark:text-green-300 flex-shrink-0">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#4caf50]"></span> Disetujui
                    </span>
                <?php else: ?>
                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-medium bg-[#fff3e0] dark:bg-yellow-900/30 text-[#e65100] dark:text-yellow-300 flex-shrink-0">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#ff9800]"></span> Pending
                    </span>
                <?php endif; ?>
            </div>
            
            <div class="mt-1">
                <div class="flex items-center text-amber-500 mb-1.5">
                    <?php for($i=1; $i<=5; $i++): ?>
                        <span class="material-symbols-outlined text-[16px]" style="font-variation-settings: 'FILL' <?= $i <= $testimonial['rating'] ? '1' : '0' ?>;"><?= $i <= $testimonial['rating'] ? 'star' : 'star_border' ?></span>
                    <?php endfor; ?>
                </div>
                <p class="text-[13px] text-on-surface-variant line-clamp-4 leading-relaxed italic">"<?= esc($testimonial['message']) ?>"</p>
            </div>
            
            <div class="flex items-center justify-end border-t border-outline-variant/10 pt-3 mt-1 gap-2">
                <form action="<?= base_url('admin/testimonials/toggle-status/' . $testimonial['id']) ?>" method="post" class="inline flex-1">
                    <?= csrf_field() ?>
                    <?php if ($testimonial['is_approved']): ?>
                    <button type="submit" class="w-full py-2.5 flex items-center justify-center gap-1.5 text-on-surface-variant hover:text-error rounded-xl bg-surface hover:bg-error-container/20 transition-colors border border-outline-variant/40 text-xs font-semibold" title="Batalkan Persetujuan">
                        <span class="material-symbols-outlined text-[18px]">cancel</span> Batal Setuju
                    </button>
                    <?php else: ?>
                    <button type="submit" class="w-full py-2.5 flex items-center justify-center gap-1.5 text-[#2e7d32] rounded-xl bg-[#e8f5e9]/50 hover:bg-[#e8f5e9] transition-colors border border-[#4caf50]/30 text-xs font-semibold" title="Setujui Testimonial">
                        <span class="material-symbols-outlined text-[18px]">check_circle</span> Setujui
                    </button>
                    <?php endif; ?>
                </form>
                
                <button type="button" onclick="openAdminConfirm({ title: 'Hapus Testimonial?', message: 'Yakin ingin menghapus testimonial ini? Tindakan ini tidak bisa dibatalkan.', confirmText: 'Ya, Hapus', confirmClass: 'bg-error text-on-error hover:bg-error/90', action: '<?= base_url('admin/testimonials/delete/' . $testimonial['id']) ?>', method: 'POST' })" class="w-12 py-2.5 flex items-center justify-center text-on-surface-variant hover:text-error rounded-xl bg-surface hover:bg-error-container/50 transition-colors border border-outline-variant/40" title="Hapus">
                    <span class="material-symbols-outlined text-[18px]">delete</span>
                </button>
            </div>
        </div>
        <?php endforeach; ?>
        
        <!-- Pagination Footer Mobile -->
        <?php if (isset($pager)): ?>
        <div class="px-4 py-3 bg-surface-container-lowest rounded-2xl border border-outline-variant/20 flex items-center justify-center soft-shadow">
            <?= $pager->links('default', 'admin_pagination') ?>
        </div>
        <?php endif; ?>

    <?php else: ?>
        <div class="bg-surface-container-lowest rounded-2xl p-8 text-center border border-outline-variant/20 soft-shadow">
            <span class="material-symbols-outlined text-4xl block mb-2 opacity-50 text-on-surface-variant">reviews</span>
            <h3 class="text-sm font-bold text-on-surface">Belum ada testimonial</h3>
            <p class="text-xs text-on-surface-variant mt-1 mb-4">Ulasan pelanggan akan tampil di sini setelah dikirim atau disetujui.</p>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
