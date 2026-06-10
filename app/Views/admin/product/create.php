<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<!-- Breadcrumb -->
<div class="flex items-center gap-2 text-sm text-on-surface-variant mb-6">
    <a href="<?= base_url('admin/produk') ?>" class="hover:text-primary transition-colors">Kelola Produk</a>
    <span class="material-symbols-outlined text-sm">chevron_right</span>
    <span class="text-on-surface font-semibold">Tambah Produk Baru</span>
</div>

<!-- Flash Messages -->
<?php if (session()->getFlashdata('error')): ?>
<div class="mb-6 p-4 rounded-xl bg-[#FCE8E6] border border-[#FAD2CF] text-[#C5221F] text-sm"><?= esc(session()->getFlashdata('error')) ?></div>
<?php elseif (session()->getFlashdata('success')): ?>
<div class="mb-6 p-4 rounded-xl bg-[#E6F4EA] border border-[#CEEAD6] text-[#1E7E34] text-sm"><?= esc(session()->getFlashdata('success')) ?></div>
<?php endif; ?>

<form action="<?= base_url('admin/produk/store') ?>" method="post" enctype="multipart/form-data" class="admin-enter">
    <?= csrf_field() ?>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column: Main Form -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Info Card -->
            <div class="bg-surface-container-lowest admin-dark-card rounded-2xl p-6 soft-shadow border border-outline-variant/20">
                <h3 class="font-headline-md text-base font-bold text-on-surface border-b border-outline-variant/20 pb-4 mb-5">Informasi Produk</h3>
                
                <div class="space-y-5">
                    <!-- Name & SKU -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-on-surface-variant">Nama Produk <span class="text-error">*</span></label>
                            <input type="text" name="name" value="<?= old('name') ?>" placeholder="Masukkan nama buket/gift..." required
                                   class="w-full px-4 py-2.5 rounded-xl border border-outline-variant bg-surface-container-lowest text-sm text-on-surface placeholder:text-outline-variant focus:border-primary focus:ring-1 focus:ring-primary shadow-sm outline-none transition-all">
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-on-surface-variant">SKU</label>
                            <input type="text" name="sku" value="<?= old('sku') ?>" placeholder="Contoh: BKT-002"
                                   class="w-full px-4 py-2.5 rounded-xl border border-outline-variant bg-surface-container-lowest text-sm text-on-surface placeholder:text-outline-variant focus:border-primary focus:ring-1 focus:ring-primary shadow-sm outline-none transition-all">
                        </div>
                    </div>

                    <!-- Category & Price -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-on-surface-variant">Kategori <span class="text-error">*</span></label>
                            <div class="relative">
                                <select name="category_id" required class="w-full px-4 py-2.5 pr-10 rounded-xl border border-outline-variant bg-surface-container-lowest text-sm text-on-surface placeholder:text-outline-variant focus:border-primary focus:ring-1 focus:ring-primary shadow-sm outline-none transition-all appearance-none">
                                    <option value="">Pilih Kategori</option>
                                    <?php foreach ($categories as $cat): ?>
                                    <option value="<?= esc($cat['id']) ?>" <?= old('category_id') == $cat['id'] ? 'selected' : '' ?>><?= esc($cat['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-outline text-lg">expand_more</span>
                            </div>
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-on-surface-variant">Harga Mulai Dari <span class="text-error">*</span></label>
                            <input type="number" name="price" value="<?= old('price') ?>" placeholder="Contoh: 150000" required
                                   class="w-full px-4 py-2.5 rounded-xl border border-outline-variant bg-surface-container-lowest text-sm text-on-surface placeholder:text-outline-variant focus:border-primary focus:ring-1 focus:ring-primary shadow-sm outline-none transition-all">
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-on-surface-variant">Deskripsi</label>
                        <textarea name="description" rows="4" placeholder="Deskripsi detail produk..."
                                  class="w-full px-4 py-2.5 rounded-xl border border-outline-variant bg-surface-container-lowest text-sm text-on-surface placeholder:text-outline-variant focus:border-primary focus:ring-1 focus:ring-primary shadow-sm outline-none transition-all resize-none"><?= old('description') ?></textarea>
                    </div>

                    <!-- Color -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-on-surface-variant">Warna Produk</label>
                            <div class="relative">
                                <select name="color" class="w-full px-4 py-2.5 pr-10 rounded-xl border border-outline-variant bg-surface-container-lowest text-sm text-on-surface placeholder:text-outline-variant focus:border-primary focus:ring-1 focus:ring-primary shadow-sm outline-none transition-all appearance-none">
                                    <option value="">Tidak ditentukan</option>
                                    <?php foreach ($colors as $color): ?>
                                    <option value="<?= esc($color['name']) ?>" <?= old('color') == $color['name'] ? 'selected' : '' ?>><?= esc($color['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-outline text-lg">expand_more</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Variants Card -->
            <div class="bg-surface-container-lowest admin-dark-card rounded-2xl p-6 soft-shadow border border-outline-variant/20">
                <div class="flex items-center justify-between border-b border-outline-variant/20 pb-4 mb-5">
                    <h3 class="font-headline-md text-base font-bold text-on-surface">Varian Ukuran & Harga</h3>
                    <button type="button" onclick="addVariantRow()" class="text-primary dark:text-primary-fixed-dim text-xs font-bold flex items-center gap-1 hover:underline">
                        <span class="material-symbols-outlined text-sm">add</span> Tambah Varian
                    </button>
                </div>

                <div id="variants-container" class="space-y-3">
                    <!-- Template row -->
                    <div class="variant-row flex flex-col sm:flex-row sm:items-center gap-3">
                        <input type="text" name="variant_size[]" placeholder="Ukuran (S, M, L, XL...)"
                               class="w-full sm:flex-1 px-4 py-2.5 rounded-xl border border-outline-variant bg-surface-container-lowest text-sm text-on-surface placeholder:text-outline-variant focus:border-primary focus:ring-1 focus:ring-primary shadow-sm outline-none transition-all">
                        <input type="number" name="variant_price[]" placeholder="Harga varian"
                               class="w-full sm:flex-1 px-4 py-2.5 rounded-xl border border-outline-variant bg-surface-container-lowest text-sm text-on-surface placeholder:text-outline-variant focus:border-primary focus:ring-1 focus:ring-primary shadow-sm outline-none transition-all">
                        <button type="button" onclick="this.closest('.variant-row').remove()" class="p-2 text-on-surface-variant hover:text-error hover:bg-error-container/20 rounded-xl transition-colors">
                            <span class="material-symbols-outlined text-lg">close</span>
                        </button>
                    </div>
                </div>
                <p class="text-[10px] text-on-surface-variant mt-3">Tambahkan varian jika produk memiliki beberapa pilihan ukuran/harga. Kosongkan jika hanya 1 varian.</p>
            </div>

            <!-- Image Upload Card -->
            <div class="bg-surface-container-lowest admin-dark-card rounded-2xl p-6 soft-shadow border border-outline-variant/20">
                <h3 class="font-headline-md text-base font-bold text-on-surface border-b border-outline-variant/20 pb-4 mb-5">Foto Produk</h3>

                <div class="space-y-1.5">
                    <label for="product-images-input" class="border-2 border-dashed border-outline-variant/60 rounded-2xl p-8 text-center hover:border-primary/40 transition-colors cursor-pointer flex flex-col items-center gap-3 group">
                        <span class="material-symbols-outlined text-4xl text-on-surface-variant group-hover:text-primary transition-colors">cloud_upload</span>
                        <div>
                            <span class="text-sm font-bold text-primary dark:text-primary-fixed-dim">Klik untuk unggah foto</span>
                            <span class="text-[10px] text-on-surface-variant block mt-1">PNG, JPG, WEBP - Maksimal 5MB per file</span>
                        </div>
                    </label>
                    <input type="file" name="product_images[]" id="product-images-input" multiple accept="image/*" class="hidden" onchange="previewImages(this)">
                    
                    <!-- Image Preview -->
                    <div id="image-preview" class="grid grid-cols-3 sm:grid-cols-4 gap-3 mt-4"></div>
                    <div id="product-image-error" class="text-xs text-error mt-2 hidden"></div>
                </div>
            </div>
        </div>

        <!-- Right Column: Sidebar -->
        <div class="space-y-6">
            <!-- Status & Actions -->
            <div class="bg-surface-container-lowest admin-dark-card rounded-2xl p-6 soft-shadow border border-outline-variant/20">
                <h3 class="font-headline-md text-base font-bold text-on-surface border-b border-outline-variant/20 pb-4 mb-5">Publikasi</h3>
                
                <div class="space-y-4">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-on-surface-variant">Status</label>
                        <div class="relative">
                            <select name="status" required class="w-full px-4 py-2.5 pr-10 rounded-xl border border-outline-variant bg-surface-container-lowest text-sm text-on-surface placeholder:text-outline-variant focus:border-primary focus:ring-1 focus:ring-primary shadow-sm outline-none transition-all appearance-none">
                                <option value="ready" <?= old('status') == 'ready' ? 'selected' : '' ?>>Ready</option>
                                <option value="pre-order" <?= old('status') == 'pre-order' ? 'selected' : '' ?>>Pre-order</option>
                                <option value="habis" <?= old('status') == 'habis' ? 'selected' : '' ?>>Habis</option>
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-outline text-lg">expand_more</span>
                        </div>
                    </div>

                    <label class="flex items-center gap-3 p-3 rounded-xl border border-outline-variant/40 hover:border-primary/30 transition-colors cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" <?= old('is_featured') ? 'checked' : '' ?>
                               class="rounded border-outline-variant text-primary focus:ring-primary h-4 w-4">
                        <div>
                            <span class="text-xs font-bold text-on-surface block">Produk Unggulan</span>
                            <span class="text-[10px] text-on-surface-variant">Tampilkan di halaman depan</span>
                        </div>
                    </label>
                </div>

                <div class="flex flex-col gap-3 mt-6 pt-5 border-t border-outline-variant/20">
                    <button type="submit" class="bg-primary text-on-primary hover:bg-on-primary-fixed-variant w-full py-3 rounded-full text-sm font-bold shadow-sm transition-all flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-lg">save</span> Simpan Produk
                    </button>
                    <a href="<?= base_url('admin/produk') ?>" class="w-full py-3 rounded-full border border-outline-variant/80 text-sm font-bold text-on-surface hover:bg-surface-container transition-colors text-center">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    function addVariantRow() {
        const container = document.getElementById('variants-container');
        const row = document.createElement('div');
        row.className = 'variant-row flex flex-col sm:flex-row sm:items-center gap-3';
        row.innerHTML = `
            <input type="text" name="variant_size[]" placeholder="Ukuran (S, M, L, XL...)"
                   class="w-full sm:flex-1 px-4 py-2.5 rounded-xl border border-outline-variant bg-surface-container-lowest text-sm text-on-surface placeholder:text-outline-variant focus:border-primary focus:ring-1 focus:ring-primary shadow-sm outline-none transition-all">
            <input type="number" name="variant_price[]" placeholder="Harga varian"
                   class="w-full sm:flex-1 px-4 py-2.5 rounded-xl border border-outline-variant bg-surface-container-lowest text-sm text-on-surface placeholder:text-outline-variant focus:border-primary focus:ring-1 focus:ring-primary shadow-sm outline-none transition-all">
            <button type="button" onclick="this.closest('.variant-row').remove()" class="p-2 text-on-surface-variant hover:text-error hover:bg-error-container/20 rounded-xl transition-colors">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        `;
        container.appendChild(row);
    }

    function previewImages(input) {
        const preview = document.getElementById('image-preview');
        const errorEl = document.getElementById('product-image-error');
        preview.innerHTML = '';
        errorEl.classList.add('hidden');
        errorEl.textContent = '';

        if (!input.files || input.files.length === 0) return;

        const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        const maxSize = 5 * 1024 * 1024;

        for (const file of input.files) {
            if (!allowedTypes.includes(file.type)) {
                errorEl.textContent = 'Format file tidak didukung. Gunakan JPG, PNG, atau WEBP.';
                errorEl.classList.remove('hidden');
                input.value = '';
                return;
            }
            if (file.size > maxSize) {
                errorEl.textContent = 'Ukuran gambar maksimal 5MB per file.';
                errorEl.classList.remove('hidden');
                input.value = '';
                return;
            }
        }

        Array.from(input.files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = (e) => {
                const div = document.createElement('div');
                div.className = 'relative group';
                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-24 object-cover rounded-xl border border-outline-variant/30" alt="Preview">
                    ${index === 0 ? '<span class="absolute top-1 left-1 bg-primary text-on-primary text-[8px] font-bold px-1.5 py-0.5 rounded-full">Utama</span>' : ''}
                `;
                preview.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }
</script>
<?= $this->endSection() ?>
