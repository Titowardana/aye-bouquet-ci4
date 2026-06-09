<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<!-- Flash Messages -->
<?php if (session()->getFlashdata('error')): ?>
<div class="mb-6 p-4 rounded-xl bg-[#FCE8E6] border border-[#FAD2CF] text-[#C5221F] text-sm font-semibold flex items-center justify-between">
    <div class="flex items-center gap-2">
        <span class="material-symbols-outlined text-lg">error</span>
        <?= esc(session()->getFlashdata('error')) ?>
    </div>
</div>
<?php endif; ?>

<?php if (isset($validation) && $validation->getErrors()): ?>
<div class="mb-6 p-4 rounded-xl bg-[#FCE8E6] border border-[#FAD2CF] text-[#C5221F] text-sm font-semibold">
    <ul class="list-disc pl-5">
        <?php foreach ($validation->getErrors() as $error): ?>
            <li><?= esc($error) ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<div class="mb-8 admin-enter">
    <h2 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface mb-2">Tambah Foto Galeri</h2>
    <p class="font-body-md text-body-md text-on-surface-variant">Upload dan kelola foto hasil produk yang akan tampil di halaman galeri.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
    <!-- Left Column: Form -->
    <div class="lg:col-span-7 xl:col-span-8 flex flex-col gap-6">
        <div class="bg-surface-container-lowest shadow-[0_4px_20px_rgba(121,84,101,0.05)] p-6 md:p-8 rounded-xl border border-outline-variant/20 admin-enter">
            <form action="<?= base_url('admin/galeri/store') ?>" method="post" enctype="multipart/form-data" class="flex flex-col gap-6" id="gallery-form">
                <?= csrf_field() ?>
                
                <!-- Upload Area -->
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-2">Upload foto produk <span class="text-error">*</span></label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-outline-variant border-dashed hover:border-primary hover:bg-primary/5 transition-all cursor-pointer group rounded-xl relative" onclick="document.getElementById('image-upload').click()">
                        <div class="space-y-2 text-center" id="upload-placeholder">
                            <div class="w-12 h-12 mx-auto rounded-full bg-primary-container/30 flex items-center justify-center group-hover:bg-primary-container group-hover:scale-110 transition-all">
                                <span class="material-symbols-outlined text-primary text-3xl">cloud_upload</span>
                            </div>
                            <div class="font-body-md text-body-md text-on-surface-variant">
                                <span class="font-semibold text-primary">Klik untuk upload</span> atau drag and drop
                            </div>
                            <p class="font-label-sm text-label-sm text-outline">PNG, JPG, WEBP (Max. 2MB). Rekomendasi rasio 4:5.</p>
                        </div>
                        <img id="image-preview" src="#" alt="Preview" class="hidden w-full max-h-64 object-contain rounded-lg relative z-10" />
                        <input type="file" name="image" id="image-upload" class="hidden" accept="image/png, image/jpeg, image/webp" required onchange="previewImage(this)">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Title Input -->
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-2" for="title">Judul foto <span class="text-error">*</span></label>
                        <input name="title" id="title" type="text" value="<?= old('title') ?>" required class="w-full px-4 py-3 bg-surface-container-lowest border border-outline-variant text-body-md focus:border-primary focus:ring-1 focus:ring-primary transition-all placeholder:text-outline-variant shadow-sm rounded-xl" placeholder="Buket Wisuda Pink" oninput="updatePreview()">
                    </div>
                    
                    <!-- Category Dropdown -->
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-2" for="category">Pilih kategori <span class="text-error">*</span></label>
                        <div class="relative">
                            <select name="category" id="category" required class="w-full px-4 py-3 bg-surface-container-lowest border border-outline-variant text-body-md focus:border-primary focus:ring-1 focus:ring-primary transition-all appearance-none shadow-sm text-on-surface cursor-pointer rounded-xl" onchange="updatePreview()">
                                <option disabled <?= !old('category') ? 'selected' : '' ?> value="">Pilih Kategori...</option>
                                <?php
                                $catOptions = [
                                    'buket-bunga'   => 'Buket Bunga',
                                    'buket-uang'    => 'Buket Uang',
                                    'buket-snack'   => 'Buket Snack',
                                    'selempang'     => 'Selempang',
                                    'bloom-box'     => 'Bloom Box',
                                    'single-flower' => 'Single Flower',
                                    'custom-gift'   => 'Custom Gift',
                                ];
                                foreach ($catOptions as $val => $label): ?>
                                    <option value="<?= $val ?>" <?= old('category') === $val ? 'selected' : '' ?>><?= $label ?></option>
                                <?php endforeach; ?>
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-outline">expand_more</span>
                        </div>
                    </div>
                </div>

                <!-- Caption Textarea -->
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-2" for="caption">Caption/deskripsi singkat</label>
                    <textarea name="description" id="caption" rows="4" class="w-full px-4 py-3 bg-surface-container-lowest border border-outline-variant text-body-md focus:border-primary focus:ring-1 focus:ring-primary transition-all placeholder:text-outline-variant shadow-sm resize-y rounded-xl" placeholder="Buket bunga custom warna pink untuk hadiah wisuda..." oninput="updatePreview()"><?= old('description') ?></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-end border-t border-outline-variant/30 pt-6 mt-2">
                    <!-- Status Switch -->
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-3">Status tampilan</label>
                        <div class="flex items-center gap-4">
                            <label class="flex items-center cursor-pointer group">
                                <input class="hidden peer rounded-lg" name="status" type="radio" value="tampil" <?= old('status', 'tampil') === 'tampil' ? 'checked' : '' ?>>
                                <div class="w-5 h-5 rounded-full border-2 border-outline-variant peer-checked:border-primary peer-checked:bg-primary flex items-center justify-center mr-2 transition-all">
                                    <div class="w-2 h-2 rounded-full bg-surface-container-lowest opacity-0 peer-checked:opacity-100 transition-all scale-0 peer-checked:scale-100 rounded-lg"></div>
                                </div>
                                <span class="font-body-md text-body-md text-on-surface-variant peer-checked:text-on-surface font-semibold">Tampil</span>
                            </label>
                            
                            <label class="flex items-center cursor-pointer group">
                                <input class="hidden peer rounded-lg" name="status" type="radio" value="disembunyikan" <?= old('status') === 'disembunyikan' ? 'checked' : '' ?>>
                                <div class="w-5 h-5 rounded-full border-2 border-outline-variant peer-checked:border-primary peer-checked:bg-primary flex items-center justify-center mr-2 transition-all">
                                    <div class="w-2 h-2 rounded-full bg-surface-container-lowest opacity-0 peer-checked:opacity-100 transition-all scale-0 peer-checked:scale-100 rounded-lg"></div>
                                </div>
                                <span class="font-body-md text-body-md text-on-surface-variant peer-checked:text-on-surface font-semibold">Disembunyikan</span>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Sort Order -->
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-2" for="order">Urutan tampil (Opsional)</label>
                        <input name="sort_order" id="order" type="number" value="<?= old('sort_order', '0') ?>" class="w-full px-4 py-3 bg-surface-container-lowest border border-outline-variant text-body-md focus:border-primary focus:ring-1 focus:ring-primary transition-all placeholder:text-outline-variant shadow-sm rounded-xl">
                    </div>
                </div>
            </form>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end gap-4 mt-2">
            <a href="<?= base_url('admin/galeri') ?>" class="px-6 py-3 font-label-md text-sm font-bold text-on-surface-variant hover:bg-surface-variant transition-colors rounded-full border border-outline-variant/50">
                Batal
            </a>
            <button onclick="document.getElementById('gallery-form').submit()" class="px-6 py-3 font-label-md text-sm font-bold bg-primary text-on-primary hover:bg-on-primary-fixed-variant shadow-md hover:shadow-lg transition-all active:scale-95 flex items-center gap-2 rounded-full">
                <span class="material-symbols-outlined text-sm font-bold">save</span>
                Simpan Galeri
            </button>
        </div>
    </div>

    <!-- Right Column: Preview -->
    <div class="lg:col-span-5 xl:col-span-4 sticky top-24">
        <div class="bg-surface-container-lowest shadow-[0_4px_20px_rgba(121,84,101,0.05)] p-5 border border-primary-container/30 rounded-xl card-hover-admin admin-enter admin-enter-delay-1">
            <div class="flex items-center gap-2 mb-4 pb-3 border-b border-outline-variant/30">
                <span class="material-symbols-outlined text-primary">visibility</span>
                <h3 class="font-label-md text-label-md text-on-surface font-bold tracking-widest text-xs uppercase">Preview Galeri</h3>
            </div>
            
            <!-- Mockup Card -->
            <div class="group relative bg-surface overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300 rounded-xl border border-outline-variant/20">
                <!-- Image -->
                <div class="aspect-[4/5] w-full bg-surface-container-highest relative overflow-hidden flex items-center justify-center">
                    <img id="preview-img-el" src="" class="w-full h-full object-cover hidden">
                    <span id="preview-placeholder-icon" class="material-symbols-outlined text-6xl text-outline-variant/50">image</span>
                    
                    <!-- Category Badge -->
                    <div id="preview-badge" class="hidden absolute top-3 left-3 bg-surface-container-lowest/90 backdrop-blur-sm px-3 py-1.5 rounded-full flex items-center gap-1.5 shadow-sm border border-outline-variant/30">
                        <span class="w-2 h-2 rounded-full bg-primary"></span>
                        <span class="font-label-sm text-xs font-bold text-on-surface" id="preview-category"></span>
                    </div>
                </div>
                <!-- Content -->
                <div class="p-4 bg-surface-container-lowest">
                    <h4 class="font-headline-md text-headline-md text-on-surface text-lg font-bold mb-1 line-clamp-1" id="preview-title">Judul Foto</h4>
                    <p class="font-body-md text-body-md text-on-surface-variant text-sm line-clamp-2" id="preview-desc">Caption/deskripsi singkat foto galeri Anda akan muncul di sini.</p>
                </div>
            </div>
            
            <div class="mt-4 p-3 bg-secondary-container/30 rounded-xl flex gap-3 items-start border border-secondary-container/50">
                <span class="material-symbols-outlined text-secondary text-lg shrink-0">info</span>
                <p class="font-label-sm text-xs text-on-surface-variant leading-relaxed">Tampilan ini adalah simulasi bagaimana foto akan terlihat di halaman galeri publik oleh pelanggan.</p>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                document.getElementById('upload-placeholder').classList.add('hidden');
                document.getElementById('image-preview').src = e.target.result;
                document.getElementById('image-preview').classList.remove('hidden');
                
                document.getElementById('preview-img-el').src = e.target.result;
                document.getElementById('preview-img-el').classList.remove('hidden');
                document.getElementById('preview-placeholder-icon').classList.add('hidden');
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    function updatePreview() {
        const title = document.getElementById('title').value;
        const categorySelect = document.getElementById('category');
        const category = categorySelect.options[categorySelect.selectedIndex].text;
        const desc = document.getElementById('caption').value;

        if (title) {
            document.getElementById('preview-title').textContent = title;
        } else {
            document.getElementById('preview-title').textContent = 'Judul Foto';
        }

        if (category && categorySelect.value) {
            document.getElementById('preview-category').textContent = category;
            document.getElementById('preview-badge').classList.remove('hidden');
        } else {
            document.getElementById('preview-badge').classList.add('hidden');
        }

        if (desc) {
            document.getElementById('preview-desc').textContent = desc;
        } else {
            document.getElementById('preview-desc').textContent = 'Caption/deskripsi singkat foto galeri Anda akan muncul di sini.';
        }
    }

    // Initialize preview on load if there's old data
    document.addEventListener('DOMContentLoaded', function() {
        updatePreview();
    });
</script>

<?= $this->endSection() ?>
