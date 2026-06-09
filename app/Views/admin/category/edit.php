<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<!-- Page Header -->
<div class="mb-8 flex items-center justify-between">
    <div>
        <h2 class="font-headline-lg text-headline-lg text-on-surface mb-2">Edit Kategori</h2>
        <p class="font-body-md text-body-md text-on-surface-variant max-w-2xl">Perbarui data kategori produk yang akan ditampilkan pada katalog. Gunakan gambar resolusi tinggi untuk hasil terbaik.</p>
    </div>
    <a href="<?= base_url('admin/kategori') ?>" class="text-on-surface-variant hover:text-primary transition-colors flex items-center gap-1 font-label-md">
        <span class="material-symbols-outlined text-sm">arrow_back</span> Kembali
    </a>
</div>

<?php if (session()->has('errors')): ?>
<div class="mb-6 p-4 rounded-xl bg-error-container/20 border border-error/30 text-error flex items-start gap-3">
    <span class="material-symbols-outlined mt-0.5">error</span>
    <div>
        <h4 class="font-bold mb-1">Terdapat Kesalahan</h4>
        <ul class="list-disc pl-5 text-sm space-y-1">
            <?php foreach (session('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach ?>
        </ul>
    </div>
</div>
<?php endif; ?>

<form action="<?= base_url('admin/kategori/update/' . $category['id']) ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    
    <div class="grid grid-cols-1 xl:grid-cols-12 gap-8 items-start pb-24">
        <!-- Left Column: Form -->
        <div class="xl:col-span-8 bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/30 overflow-hidden">
            <div class="p-6 md:p-8 space-y-8">
                <!-- Upload Section -->
                <div>
                    <label class="block font-label-md text-label-md text-on-surface dark:text-white mb-3">Foto / Icon Kategori</label>
                    <div class="relative border-2 border-dashed border-outline-variant dark:border-white/15 hover:border-primary transition-colors bg-surface-bright dark:bg-white/5 rounded-xl p-8 flex flex-col items-center justify-center cursor-pointer group min-h-[200px]" id="uploadContainer">
                        <input type="file" name="icon" id="iconInput" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" accept="image/*">
                        <input type="hidden" name="remove_icon" id="removeIconInput" value="0">
                        
                        <?php $hasIcon = !empty($category['icon']) && file_exists(FCPATH . 'uploads/categories/' . $category['icon']); ?>
                        
                        <div id="uploadPrompt" class="flex flex-col items-center <?= $hasIcon ? 'hidden' : '' ?>">
                            <div class="w-16 h-16 rounded-full bg-primary-container text-primary flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                                <span class="material-symbols-outlined text-3xl">add_photo_alternate</span>
                            </div>
                            <p class="font-label-md text-label-md text-on-surface dark:text-white mb-1 group-hover:text-primary transition-colors">Click to upload or drag and drop</p>
                            <p class="font-label-sm text-label-sm text-secondary dark:text-white/60">SVG, PNG, JPG or GIF (max. 800x400px)</p>
                        </div>
                        
                        <div id="imagePreviewContainer" class="absolute inset-0 w-full h-full bg-surface-bright rounded-xl overflow-hidden flex items-center justify-center <?= $hasIcon ? '' : 'hidden' ?>">
                            <img id="imagePreview" src="<?= $hasIcon ? base_url('uploads/categories/' . esc($category['icon'])) : '' ?>" alt="Preview" class="max-h-full max-w-full object-contain">
                            <div class="absolute inset-0 bg-black/40 opacity-0 hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                                <span class="bg-surface-container-lowest text-on-surface px-4 py-2 rounded-lg font-label-md flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm">edit</span> Ganti
                                </span>
                                <button type="button" id="removeIconButton" class="bg-error-container text-error px-4 py-2 rounded-lg font-label-md flex items-center gap-2 z-20 hover:bg-error hover:text-on-error transition-colors">
                                    <span class="material-symbols-outlined text-sm">delete</span> Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Input: Nama Kategori -->
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface dark:text-white mb-2" for="categoryName">Nama Kategori <span class="text-error">*</span></label>
                        <input name="name" id="categoryName" value="<?= old('name', esc($category['name'])) ?>" class="w-full bg-surface-bright dark:bg-white/5 border border-outline-variant dark:border-white/15 rounded-lg px-4 py-3 font-body-md text-body-md text-on-surface dark:text-white focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none transition-shadow placeholder:text-on-surface-variant/50 dark:placeholder:text-white/40" placeholder="Cth: Buket Bunga" type="text" required>
                    </div>

                    <!-- Input: Slug Kategori -->
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface dark:text-white mb-2" for="categorySlug">Slug Kategori</label>
                        <input name="slug" id="categorySlug" value="<?= old('slug', esc($category['slug'])) ?>" class="w-full bg-surface-bright dark:bg-white/5 border border-outline-variant dark:border-white/15 rounded-lg px-4 py-3 font-body-md text-body-md text-on-surface dark:text-white focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none transition-shadow placeholder:text-on-surface-variant/50 dark:placeholder:text-white/40" placeholder="Cth: buket-bunga" type="text">
                        <p class="font-label-sm text-label-sm text-secondary dark:text-white/60 mt-1">URL friendly name, otomatis digenerate jika kosong.</p>
                    </div>
                </div>

                <!-- Textarea: Deskripsi -->
                <div>
                    <label class="block font-label-md text-label-md text-on-surface dark:text-white mb-2" for="categoryDesc">Deskripsi Singkat</label>
                    <textarea name="description" id="categoryDesc" class="w-full bg-surface-bright dark:bg-white/5 border border-outline-variant dark:border-white/15 rounded-lg px-4 py-3 font-body-md text-body-md text-on-surface dark:text-white focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none transition-shadow resize-none placeholder:text-on-surface-variant/50 dark:placeholder:text-white/40" placeholder="Masukkan deskripsi kategori di sini..." rows="4"><?= old('description', esc($category['description'])) ?></textarea>
                    <div class="flex justify-between mt-1">
                        <p class="font-label-sm text-label-sm text-secondary dark:text-white/60">Penjelasan singkat tentang kategori produk.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-outline-variant/40">
                    <!-- Status Kategori -->
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-3">Status Kategori</label>
                        <div class="flex items-center gap-4">
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <div class="relative flex items-center justify-center w-5 h-5">
                                    <input name="is_active" type="radio" value="1" class="peer sr-only" <?= old('is_active', $category['is_active']) == '1' ? 'checked' : '' ?>>
                                    <div class="w-5 h-5 rounded-full border-2 border-outline-variant peer-checked:border-primary transition-colors"></div>
                                    <div class="absolute w-2.5 h-2.5 rounded-full bg-primary scale-0 peer-checked:scale-100 transition-transform duration-200"></div>
                                </div>
                                <span class="font-body-md text-body-md text-on-surface group-hover:text-primary transition-colors">Aktif</span>
                            </label>

                            <label class="flex items-center gap-2 cursor-pointer group">
                                <div class="relative flex items-center justify-center w-5 h-5">
                                    <input name="is_active" type="radio" value="0" class="peer sr-only" <?= old('is_active', $category['is_active']) == '0' ? 'checked' : '' ?>>
                                    <div class="w-5 h-5 rounded-full border-2 border-outline-variant peer-checked:border-primary transition-colors"></div>
                                    <div class="absolute w-2.5 h-2.5 rounded-full bg-primary scale-0 peer-checked:scale-100 transition-transform duration-200"></div>
                                </div>
                                <span class="font-body-md text-body-md text-secondary group-hover:text-on-surface transition-colors">Nonaktif</span>
                            </label>
                        </div>
                    </div>

                    <!-- Input: Urutan -->
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface dark:text-white mb-2" for="categoryOrder">Urutan Tampil</label>
                        <input name="sort_order" id="categoryOrder" value="<?= old('sort_order', esc($category['sort_order'])) ?>" class="w-24 bg-surface-bright dark:bg-white/5 border border-outline-variant dark:border-white/15 rounded-lg px-4 py-2 font-body-md text-body-md text-on-surface dark:text-white focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none transition-shadow" type="number" min="1">
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="bg-surface-container-low dark:bg-[#241d22] px-6 md:px-8 py-5 border-t border-outline-variant/30 dark:border-white/10 flex justify-end gap-3">
                <a href="<?= base_url('admin/kategori') ?>" class="font-label-md text-label-md text-secondary dark:text-white/80 hover:text-on-surface dark:hover:text-white px-6 py-2.5 rounded-full hover:bg-surface-variant dark:hover:bg-white/10 transition-colors">
                    Batal
                </a>
                <button type="submit" class="font-label-md text-label-md bg-primary text-on-primary px-8 py-2.5 rounded-full hover:bg-primary/90 shadow-sm hover:shadow-md transition-all transform hover:-translate-y-0.5">
                    Simpan Perubahan
                </button>
            </div>
        </div>

        <!-- Right Column: Live Preview -->
        <div class="xl:col-span-4 sticky top-[100px]">
            <div class="flex items-center justify-between mb-4 px-2">
                <h3 class="font-label-md text-label-md text-secondary uppercase tracking-wider">Live Preview</h3>
                <span class="material-symbols-outlined text-outline-variant text-[20px]">visibility</span>
            </div>

            <!-- Customer Facing Card Design -->
            <div class="bg-surface-container-lowest rounded-[1rem] overflow-hidden shadow-sm border border-outline-variant/20 hover:shadow-md transition-all duration-300 group">
                <!-- Image Area -->
                <div class="relative h-48 w-full bg-surface-container-high overflow-hidden flex items-center justify-center">
                    <img id="livePreviewImg" src="<?= $hasIcon ? base_url('uploads/categories/' . esc($category['icon'])) : '' ?>" alt="Preview" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 <?= $hasIcon ? '' : 'hidden' ?>">
                    <span id="livePreviewIcon" class="material-symbols-outlined text-6xl text-outline-variant/50 <?= $hasIcon ? 'hidden' : '' ?>">category</span>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 transition-opacity"></div>
                </div>

                <!-- Content Area -->
                <div class="p-6">
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-secondary-container text-on-secondary-container mb-3">
                        <span class="material-symbols-outlined text-[14px]">local_florist</span>
                        <span class="font-label-sm text-label-sm">Kategori Utama</span>
                    </div>
                    
                    <h4 class="font-headline-md text-xl font-bold text-on-surface mb-2" id="livePreviewName"><?= esc($category['name']) ?></h4>
                    <p class="font-body-md text-sm text-on-surface-variant line-clamp-2 mb-6" id="livePreviewDesc"><?= esc($category['description'] ?: 'Deskripsi singkat kategori akan tampil di sini.') ?></p>
                    
                    <a href="<?= base_url('katalog?kategori=' . urlencode($category['slug'])) ?>" target="_blank" rel="noopener" class="w-full font-label-md text-sm font-semibold border border-outline-variant text-on-surface py-2.5 rounded-full flex justify-center items-center gap-2 group-hover:border-primary group-hover:text-primary transition-colors">
                        Lihat Produk
                        <span class="material-symbols-outlined text-[18px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </a>
                </div>
            </div>

            <!-- Helper Text -->
            <p class="font-label-sm text-xs text-center text-outline-variant mt-4">
                Tampilan ini menyesuaikan dengan desain katalog di sisi pelanggan.
            </p>
        </div>
    </div>
</form>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const nameInput = document.getElementById('categoryName');
        const descInput = document.getElementById('categoryDesc');
        const iconInput = document.getElementById('iconInput');
        const removeIconInput = document.getElementById('removeIconInput');
        const removeIconButton = document.getElementById('removeIconButton');
        
        const previewName = document.getElementById('livePreviewName');
        const previewDesc = document.getElementById('livePreviewDesc');
        const previewImg = document.getElementById('livePreviewImg');
        const previewIcon = document.getElementById('livePreviewIcon');
        
        const formImagePreview = document.getElementById('imagePreview');
        const formPreviewContainer = document.getElementById('imagePreviewContainer');
        const formUploadPrompt = document.getElementById('uploadPrompt');

        // Text Live Previews
        nameInput.addEventListener('input', (e) => {
            previewName.textContent = e.target.value || 'Nama Kategori';
        });

        descInput.addEventListener('input', (e) => {
            previewDesc.textContent = e.target.value || 'Deskripsi singkat kategori akan tampil di sini.';
        });

        // Image Live Preview
        iconInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    removeIconInput.value = '0'; // reset remove intent
                    
                    // Update Form Image
                    formImagePreview.src = e.target.result;
                    formPreviewContainer.classList.remove('hidden');
                    formUploadPrompt.classList.add('hidden');
                    
                    // Update Live Preview Card Image
                    previewImg.src = e.target.result;
                    previewImg.classList.remove('hidden');
                    previewIcon.classList.add('hidden');
                }
                
                reader.readAsDataURL(this.files[0]);
            }
        });

        if (removeIconButton) {
            removeIconButton.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                
                iconInput.value = ''; // clear file input
                removeIconInput.value = '1'; // set intent to remove
                
                // Hide images
                formPreviewContainer.classList.add('hidden');
                formUploadPrompt.classList.remove('hidden');
                
                previewImg.classList.add('hidden');
                previewIcon.classList.remove('hidden');
                
                formImagePreview.src = '';
                previewImg.src = '';
            });
        }
    });
</script>
<?= $this->endSection() ?>
