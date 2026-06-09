<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<!-- Flash Messages -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="mb-6 px-5 py-4 rounded-xl bg-green-50 border border-green-200 text-green-800 font-body-md text-sm flex items-start gap-3 animate__animated animate__fadeIn">
        <span class="material-symbols-outlined text-green-500 mt-0.5 flex-shrink-0" style="font-size:20px">check_circle</span>
        <span><?= esc(session()->getFlashdata('success')) ?></span>
    </div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
    <div class="mb-6 px-5 py-4 rounded-xl bg-red-50 border border-red-200 text-red-800 font-body-md text-sm flex items-start gap-3 animate__animated animate__fadeIn">
        <span class="material-symbols-outlined text-red-500 mt-0.5 flex-shrink-0" style="font-size:20px">error</span>
        <span><?= esc(session()->getFlashdata('error')) ?></span>
    </div>
<?php endif; ?>

<!-- Page Header -->
<div class="mb-6 md:mb-8 admin-enter">
    <h2 class="font-headline-lg text-2xl md:text-headline-lg text-on-surface mb-1 md:mb-2">Kelola Kategori</h2>
    <p class="font-body-md text-sm md:text-body-md text-on-surface-variant">Kelola kategori produk gift/custom yang tampil pada katalog.</p>
</div>

<!-- Action Bar -->
<div class="bg-surface-container-lowest rounded-xl p-4 shadow-sm border border-outline-variant/20 mb-6 flex flex-col gap-3 card-hover-admin admin-enter admin-enter-delay-1">
    <div class="flex flex-col sm:flex-row gap-3">
        <form method="get" action="<?= base_url('admin/kategori') ?>" class="flex-1 relative">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">search</span>
            <input name="keyword" value="<?= esc($keyword ?? '') ?>" class="w-full pl-10 pr-4 py-3 rounded-lg border border-outline-variant/50 focus:border-primary focus:ring-1 focus:ring-primary font-body-md text-body-md bg-surface transition-all" placeholder="Cari kategori..." type="text">
        </form>

        <form method="get" action="<?= base_url('admin/kategori') ?>" id="filterForm" class="flex-shrink-0">
            <?php if (!empty($keyword)): ?>
                <input type="hidden" name="keyword" value="<?= esc($keyword) ?>">
            <?php endif; ?>
            <div class="relative">
                <select name="status" onchange="document.getElementById('filterForm').submit()" class="w-full appearance-none rounded-lg border border-outline-variant/50 focus:border-primary focus:ring-1 focus:ring-primary font-label-md text-label-md py-3 pl-4 pr-10 bg-surface text-on-surface-variant cursor-pointer">
                    <option value="" <?= ($status === null || $status === '') ? 'selected' : '' ?>>Semua Status</option>
                    <option value="1" <?= ($status === '1') ? 'selected' : '' ?>>Aktif</option>
                    <option value="0" <?= ($status === '0') ? 'selected' : '' ?>>Nonaktif</option>
                </select>
                <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none">expand_more</span>
            </div>
        </form>
    </div>

    <a href="<?= base_url('admin/kategori/create') ?>" class="bg-primary hover:bg-primary/90 text-on-primary font-label-md text-label-md py-3 px-6 rounded-xl flex items-center justify-center gap-2 transition-all shadow-sm whitespace-nowrap w-full sm:w-auto sm:self-end">
        <span class="material-symbols-outlined text-sm">add</span>
        Tambah Kategori
    </a>
</div>

<!-- Categories Card Grid -->
<?php if (empty($categories)): ?>
    <div class="bg-surface-container-lowest rounded-xl p-10 shadow-sm border border-outline-variant/20 text-center admin-enter admin-enter-delay-2">
        <span class="material-symbols-outlined text-5xl text-outline-variant mb-4 block">category</span>
        <h3 class="font-headline-md text-xl font-bold text-on-surface mb-2">Belum Ada Kategori</h3>
        <p class="text-on-surface-variant mb-6">Anda belum menambahkan kategori apa pun. Kategori diperlukan untuk mengelompokkan produk.</p>
        <a href="<?= base_url('admin/kategori/create') ?>" class="bg-primary hover:bg-primary/90 text-on-primary font-label-md py-2.5 px-6 rounded-full inline-flex items-center gap-2 transition-all">
            <span class="material-symbols-outlined text-sm">add</span> Tambah Kategori
        </a>
    </div>
<?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 md:gap-6 admin-enter admin-enter-delay-2">
        <?php foreach ($categories as $category): ?>
            <div class="bg-surface-container-lowest rounded-2xl p-5 shadow-sm border border-outline-variant/20 hover:shadow-md transition-all flex flex-col group relative">
                <!-- Header row: icon + actions always visible on mobile -->
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-xl bg-primary-container flex items-center justify-center text-on-primary-container overflow-hidden flex-shrink-0">
                        <?php
                        $catIconVal = $category['icon'] ?? '';
                        $catIconIsFile = !empty($catIconVal) && preg_match('/\.(jpg|jpeg|png|gif|webp|svg)$/i', $catIconVal);
                        $catIconPath = FCPATH . 'uploads/categories/' . $catIconVal;
                        if ($catIconIsFile && file_exists($catIconPath)):
                        ?>
                            <img src="<?= base_url('uploads/categories/' . esc($catIconVal)) ?>" alt="<?= esc($category['name']) ?>" class="w-full h-full object-cover">
                        <?php else: ?>
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">category</span>
                        <?php endif; ?>
                    </div>

                    <!-- Action buttons — always visible (not group-hover only) -->
                    <div class="flex gap-1.5 z-10">
                        <a href="<?= base_url('admin/kategori/edit/' . $category['id']) ?>" class="w-9 h-9 flex items-center justify-center p-2 text-on-surface-variant hover:bg-secondary-container hover:text-primary rounded-full transition-colors border border-outline-variant/30" title="Edit">
                            <span class="material-symbols-outlined text-sm">edit</span>
                        </a>
                        <button onclick="confirmDelete(<?= $category['id'] ?>)" class="w-9 h-9 flex items-center justify-center p-2 text-error hover:bg-error-container rounded-full transition-colors border border-outline-variant/30 cursor-pointer" type="button" title="Hapus">
                            <span class="material-symbols-outlined text-sm">delete</span>
                        </button>
                    </div>
                </div>

                <div class="mb-4 flex-1">
                    <h3 class="font-headline-md text-base font-bold text-on-surface mb-1.5"><?= esc($category['name']) ?></h3>
                    <p class="font-body-md text-sm text-on-surface-variant line-clamp-3 leading-relaxed"><?= esc($category['description']) ?></p>
                </div>

                <div class="flex justify-between items-center pt-4 border-t border-outline-variant/10 mt-auto">
                    <?php 
                        $catModel = new \App\Models\CategoryModel();
                        $productCount = $catModel->countProducts($category['id']);
                    ?>
                    <span class="font-label-sm text-xs font-semibold text-secondary bg-secondary-container px-3 py-1 rounded-full"><?= $productCount ?> Produk</span>

                    <form action="<?= base_url('admin/kategori/toggle-status/' . $category['id']) ?>" method="post" class="inline-flex items-center gap-2">
                        <?= csrf_field() ?>
                        <span class="font-label-sm text-xs font-semibold <?= (int) $category['is_active'] === 1 ? 'text-on-surface-variant' : 'text-gray-400' ?>">
                            <?= (int) $category['is_active'] === 1 ? 'Aktif' : 'Nonaktif' ?>
                        </span>
                        <button type="submit" class="relative inline-flex h-6 w-11 cursor-pointer items-center rounded-full border-0 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-primary/50 <?= (int) $category['is_active'] === 1 ? 'bg-primary' : 'bg-surface-variant' ?>" title="<?= (int) $category['is_active'] === 1 ? 'Klik untuk nonaktifkan' : 'Klik untuk aktifkan' ?>">
                            <span class="inline-block h-5 w-5 transform rounded-full bg-white shadow transition-all duration-200 <?= (int) $category['is_active'] === 1 ? 'ml-[22px]' : 'ml-[2px]' ?>"></span>
                        </button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <?php if ($pager->getPageCount() > 1): ?>
        <div class="mt-8 flex justify-center">
            <?= $pager->links('default', 'admin_pagination') ?>
        </div>
    <?php endif; ?>
<?php endif; ?>

<!-- Delete Form -->
<form id="delete-form" method="post" action="" class="hidden">
    <?= csrf_field() ?>
</form>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function confirmDelete(id) {
        openAdminConfirm({
            title: 'Hapus Kategori?',
            message: 'Kategori yang masih memiliki produk tidak dapat dihapus. Tindakan ini tidak bisa dibatalkan.',
            confirmText: 'Ya, Hapus',
            confirmClass: 'bg-error text-on-error hover:bg-error/90',
            action: `<?= base_url('admin/kategori/delete') ?>/${id}`,
            method: 'POST'
        });
    }
</script>
<?= $this->endSection() ?>
