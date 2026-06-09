<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<!-- Flash Messages -->
<?php if (session()->getFlashdata('success')): ?>
<div id="flash-success" class="mb-6 p-4 rounded-xl bg-[#DCEFDF] border border-[#C3E6CB] text-[#1E7E34] text-sm font-semibold flex items-center justify-between animate-fade-in">
    <div class="flex items-center gap-2">
        <span class="material-symbols-outlined text-lg">check_circle</span>
        <?= esc(session()->getFlashdata('success')) ?>
    </div>
    <button onclick="this.parentElement.remove()" class="text-[#1E7E34] hover:text-[#155724] transition-colors">
        <span class="material-symbols-outlined text-sm">close</span>
    </button>
</div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
<div id="flash-error" class="mb-6 p-4 rounded-xl bg-[#FCE8E6] border border-[#FAD2CF] text-[#C5221F] text-sm font-semibold flex items-center justify-between animate-fade-in">
    <div class="flex items-center gap-2">
        <span class="material-symbols-outlined text-lg">error</span>
        <?= esc(session()->getFlashdata('error')) ?>
    </div>
    <button onclick="this.parentElement.remove()" class="text-[#C5221F] hover:text-[#a5211f] transition-colors">
        <span class="material-symbols-outlined text-sm">close</span>
    </button>
</div>
<?php endif; ?>

<div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4 admin-enter">
    <div>
        <h2 class="font-display-lg text-headline-lg-mobile md:text-headline-lg text-on-surface mb-2">Kelola Galeri Hasil Produk</h2>
        <p class="font-body-md text-body-md text-on-surface-variant max-w-2xl">Kelola foto hasil pesanan sebagai portofolio dan inspirasi custom order untuk pelanggan Anda.</p>
    </div>
</div>

<!-- Controls Bar -->
<div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-8 bg-surface-container-lowest p-4 rounded-xl shadow-[0_4px_20px_0_rgba(121,84,101,0.05)] border border-outline-variant/20 card-hover-admin admin-enter admin-enter-delay-1">
    <a href="<?= base_url('admin/galeri/create') ?>" class="flex items-center gap-2 bg-primary text-on-primary px-6 py-3 rounded-full font-label-md text-label-md hover:bg-surface-tint hover:shadow-md transition-all active:scale-95 whitespace-nowrap">
        <span class="material-symbols-outlined text-[20px]">add</span>
        Tambah Foto Galeri
    </a>
    
    <form method="get" action="<?= base_url('admin/galeri') ?>" class="flex flex-col sm:flex-row w-full lg:w-auto gap-4">
        <!-- Search -->
        <div class="relative w-full sm:w-64">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
            <input name="search" value="<?= esc($search ?? '') ?>" class="w-full pl-10 pr-4 py-2.5 bg-surface rounded-lg border border-outline-variant/50 focus:border-primary focus:ring-1 focus:ring-primary transition-all font-body-md text-body-md" placeholder="Cari foto galeri..." type="text">
        </div>
        <!-- Category Filter -->
        <div class="relative w-full sm:w-48">
            <select name="category" onchange="this.form.submit()" class="w-full pl-4 pr-10 py-2.5 bg-surface rounded-lg border border-outline-variant/50 focus:border-primary focus:ring-1 focus:ring-primary transition-all font-body-md text-body-md appearance-none">
                <option value="">Semua Kategori</option>
                <?php
                $catOptions = [
                    'product_gallery' => 'Galeri Hasil Produk',
                    'about_story' => 'Cerita Kami',
                    'banner' => 'Banner/Hero',
                    'other' => 'Dokumentasi Lainnya'
                ];
                foreach ($catOptions as $val => $label): ?>
                    <option value="<?= $val ?>" <?= ($selectedCategory ?? '') === $val ? 'selected' : '' ?>><?= $label ?></option>
                <?php endforeach; ?>
            </select>
            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none">expand_more</span>
        </div>
        <!-- Status Filter -->
        <div class="relative w-full sm:w-48">
            <select name="status" onchange="this.form.submit()" class="w-full pl-4 pr-10 py-2.5 bg-surface rounded-lg border border-outline-variant/50 focus:border-primary focus:ring-1 focus:ring-primary transition-all font-body-md text-body-md appearance-none">
                <option value="">Semua Status</option>
                <option value="1" <?= ($selectedStatus ?? '') === '1' ? 'selected' : '' ?>>Tampil</option>
                <option value="0" <?= ($selectedStatus ?? '') === '0' ? 'selected' : '' ?>>Disembunyikan</option>
            </select>
            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none">expand_more</span>
        </div>
    </form>
</div>

<!-- Main Gallery Grid (Bento/Card Style) -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 admin-enter admin-enter-delay-2">

    <?php if (!empty($galleries)): ?>
        <?php foreach ($galleries as $gal): ?>
            <!-- Card -->
            <div class="bg-surface-container-lowest rounded-xl overflow-hidden shadow-[0_4px_20px_0_rgba(121,84,101,0.05)] hover:shadow-[0_8px_30px_0_rgba(121,84,101,0.1)] transition-all hover:-translate-y-1 group flex flex-col border border-outline-variant/20">
                <div class="relative h-48 overflow-hidden bg-secondary-container">
                    <img src="<?= base_url('uploads/galleries/' . esc($gal['image'])) ?>" alt="<?= esc($gal['title']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    
                    <?php if ($gal['is_active']): ?>
                        <div class="absolute top-3 left-3 bg-tertiary-fixed text-on-tertiary-fixed-variant px-2.5 py-1 rounded-full font-label-sm text-label-sm shadow-sm backdrop-blur-sm bg-opacity-90 border border-tertiary-fixed/50">
                            Tampil
                        </div>
                    <?php else: ?>
                        <div class="absolute top-3 left-3 bg-surface-variant text-on-surface-variant px-2.5 py-1 rounded-full font-label-sm text-label-sm shadow-sm backdrop-blur-sm bg-opacity-90 border border-outline-variant/50">
                            Disembunyikan
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="p-5 flex flex-col flex-1">
                    <div class="flex justify-between items-start mb-2">
                        <span class="font-label-sm text-label-sm text-surface-tint uppercase tracking-wider">
                            <?= ucwords(str_replace(['-', '_'], ' ', esc($gal['category']))) ?>
                        </span>
                        <span class="font-label-sm text-label-sm text-on-surface-variant/70">
                            <?= formatTanggalIndo($gal['created_at']) ?>
                        </span>
                    </div>
                    
                    <h3 class="font-headline-md text-[18px] leading-snug font-semibold text-on-surface mb-2"><?= esc($gal['title']) ?></h3>
                    
                    <p class="font-body-md text-body-md text-on-surface-variant text-sm line-clamp-2 mb-4 flex-1">
                        <?= esc($gal['description']) ?>
                    </p>
                    
                    <div class="flex items-center justify-end gap-2 pt-4 border-t border-outline-variant/30 mt-auto">
                        <a href="<?= base_url('admin/galeri/edit/' . $gal['id']) ?>" class="p-2 text-on-surface-variant hover:text-primary hover:bg-primary-container/30 rounded-full transition-colors" title="Edit">
                            <span class="material-symbols-outlined text-[20px]">edit</span>
                        </a>
                        <form action="<?= base_url('admin/galeri/toggle-status/' . $gal['id']) ?>" method="post" class="inline">
                            <?= csrf_field() ?>
                            <button type="submit" class="p-2 text-on-surface-variant hover:text-primary hover:bg-primary-container/30 rounded-full transition-colors" title="Toggle Visibility">
                                <span class="material-symbols-outlined text-[20px]"><?= $gal['is_active'] ? 'visibility' : 'visibility_off' ?></span>
                            </button>
                        </form>
                        
                        <button onclick="confirmDelete(<?= $gal['id'] ?>, '<?= esc(addslashes($gal['title'])) ?>')" class="p-2 text-on-surface-variant hover:text-error hover:bg-error-container/30 rounded-full transition-colors" title="Delete">
                            <span class="material-symbols-outlined text-[20px]">delete</span>
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-span-full py-12 text-center bg-surface-container-lowest rounded-xl border border-outline-variant/20 shadow-sm">
            <span class="material-symbols-outlined text-4xl text-on-surface-variant/40 mb-3 block">photo_library</span>
            <p class="text-on-surface-variant mb-4">Belum ada foto galeri.</p>
        </div>
    <?php endif; ?>

    <!-- Add New Placeholder Card -->
    <a href="<?= base_url('admin/galeri/create') ?>" class="bg-surface-container/50 border-2 border-dashed border-outline-variant/50 rounded-xl overflow-hidden hover:bg-primary-container/10 hover:border-primary/50 transition-all cursor-pointer group flex flex-col items-center justify-center min-h-[380px]">
        <div class="w-16 h-16 rounded-full bg-primary-container flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-sm">
            <span class="material-symbols-outlined text-primary text-[32px]">add_a_photo</span>
        </div>
        <span class="font-label-md text-label-md text-primary">Tambah Foto Baru</span>
    </a>

</div>

<!-- Pagination -->
<?php if (isset($pager)): ?>
<div class="mt-8 flex justify-center items-center gap-2">
    <?= $pager->links('default', 'admin_pagination') ?>
</div>
<?php endif; ?>

<script>
    function confirmDelete(id, name) {
        openAdminConfirm({
            title: 'Hapus Galeri?',
            message: 'Apakah Anda yakin ingin menghapus galeri "' + name + '"? Tindakan ini tidak dapat dibatalkan.',
            confirmText: 'Ya, Hapus',
            confirmClass: 'bg-error text-on-error hover:bg-error/90',
            action: '<?= base_url('admin/galeri/delete/') ?>' + id,
            method: 'POST'
        });
    }

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
