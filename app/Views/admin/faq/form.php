<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<!-- Header Section -->
<div class="mb-section-gap mb-8 admin-enter">
    <h2 class="font-display-lg text-headline-lg text-on-surface mb-2"><?= $faq ? 'Edit' : 'Tambah' ?> FAQ</h2>
    <p class="font-body-lg text-body-md text-on-surface-variant">Masukkan pertanyaan dan jawaban yang akan ditampilkan pada halaman FAQ.</p>
</div>

<!-- Flash Messages -->
<?php if (session()->getFlashdata('error')): ?>
<div class="mb-6 p-4 rounded-xl bg-[#FCE8E6] border border-[#FAD2CF] text-[#C5221F] text-sm font-semibold flex items-center justify-between">
    <div class="flex items-center gap-2">
        <span class="material-symbols-outlined text-lg">error</span>
        <?= esc(session()->getFlashdata('error')) ?>
    </div>
    <button onclick="this.parentElement.remove()" class="hover:text-[#a5211f]"><span class="material-symbols-outlined text-sm">close</span></button>
</div>
<?php endif; ?>

<!-- Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    <!-- Left Column (Form) -->
    <div class="lg:col-span-8">
        <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/30 p-6 md:p-8 flex flex-col gap-6 relative overflow-hidden group admin-enter">
            <!-- Subtle decorative gradient -->
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-primary-container opacity-20 rounded-full blur-2xl group-hover:scale-110 transition-transform duration-500 pointer-events-none"></div>
            
            <form action="<?= $faq ? base_url('admin/faqs/update/' . $faq['id']) : base_url('admin/faqs/store') ?>" method="post" class="flex flex-col gap-6 relative z-10" id="faq-form">
                <?= csrf_field() ?>
                
                <!-- Pertanyaan -->
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-2" for="pertanyaan">Pertanyaan <span class="text-error">*</span></label>
                    <input class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-3 font-body-md text-body-md text-on-surface focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none transition-all placeholder:text-on-surface-variant/50" id="pertanyaan" name="pertanyaan" placeholder="Apakah bisa custom warna?" type="text" value="<?= old('pertanyaan', $faq['question'] ?? '') ?>" required/>
                </div>
                
                <!-- Kategori FAQ -->
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-2" for="kategori">Kategori FAQ <span class="text-error">*</span></label>
                    <div class="relative">
                        <select class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-3 font-body-md text-body-md text-on-surface appearance-none focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none transition-all cursor-pointer" id="kategori" name="kategori" required>
                            <option disabled value="" <?= old('kategori', $faq['category'] ?? '') === '' ? 'selected' : '' ?>>Pilih Kategori</option>
                            <?php
                            $catOpts = [
                                'pemesanan' => 'Pemesanan',
                                'custom_order' => 'Custom Order',
                                'pembayaran' => 'Pembayaran',
                                'pengiriman' => 'Pengiriman',
                                'produk' => 'Produk'
                            ];
                            foreach ($catOpts as $val => $label): ?>
                                <option value="<?= $val ?>" <?= old('kategori', $faq['category'] ?? '') === $val ? 'selected' : '' ?>><?= $label ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none">expand_more</span>
                    </div>
                </div>
                
                <!-- Jawaban -->
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-2" for="jawaban">Jawaban <span class="text-error">*</span></label>
                    <textarea class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-3 font-body-md text-body-md text-on-surface focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none transition-all resize-y placeholder:text-on-surface-variant/50" id="jawaban" name="jawaban" placeholder="Bisa, pelanggan dapat memilih warna dominan sesuai request." rows="5" required><?= old('jawaban', $faq['answer'] ?? '') ?></textarea>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-end mt-2">
                    <!-- Status Tampilan -->
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-3">Status Tampilan</label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <div class="relative w-5 h-5 flex items-center justify-center">
                                    <input class="peer sr-only" name="status" type="radio" value="tampil" <?= old('status', isset($faq) ? ($faq['is_active'] ? 'tampil' : 'sembunyi') : 'tampil') === 'tampil' ? 'checked' : '' ?>/>
                                    <div class="w-5 h-5 rounded-full border-2 border-outline-variant peer-checked:border-primary transition-colors"></div>
                                    <div class="w-2.5 h-2.5 rounded-full bg-primary absolute scale-0 peer-checked:scale-100 transition-transform"></div>
                                </div>
                                <span class="font-body-md text-body-md text-on-surface group-hover:text-primary transition-colors">Tampil</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <div class="relative w-5 h-5 flex items-center justify-center">
                                    <input class="peer sr-only" name="status" type="radio" value="sembunyi" <?= old('status', isset($faq) ? ($faq['is_active'] ? 'tampil' : 'sembunyi') : '') === 'sembunyi' ? 'checked' : '' ?>/>
                                    <div class="w-5 h-5 rounded-full border-2 border-outline-variant peer-checked:border-primary transition-colors"></div>
                                    <div class="w-2.5 h-2.5 rounded-full bg-primary absolute scale-0 peer-checked:scale-100 transition-transform"></div>
                                </div>
                                <span class="font-body-md text-body-md text-on-surface group-hover:text-primary transition-colors">Disembunyikan</span>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Urutan Tampil -->
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-2" for="urutan">Urutan Tampil</label>
                        <input class="w-full md:w-32 bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-3 font-body-md text-body-md text-on-surface focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none transition-all" id="urutan" min="1" name="urutan" type="number" value="<?= old('urutan', $faq['sort_order'] ?? '1') ?>"/>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="flex items-center justify-end gap-4 pt-6 mt-4 border-t border-outline-variant/30">
                    <a href="<?= base_url('admin/faqs') ?>" class="px-6 py-2.5 rounded-full border border-outline font-label-md text-label-md text-on-surface hover:bg-surface-container transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-full bg-primary text-on-primary font-label-md text-label-md shadow-[0_4px_15px_rgba(121,84,101,0.2)] hover:bg-on-primary-fixed-variant transition-all transform hover:-translate-y-0.5">
                        Simpan FAQ
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Right Column (Live Preview) -->
    <div class="lg:col-span-4">
        <div class="sticky top-24 bg-surface-container-lowest rounded-xl shadow-[0_4px_15px_rgba(0,0,0,0.02)] border border-outline-variant/30 p-6 flex flex-col gap-4 card-hover-admin admin-enter admin-enter-delay-1">
            <div class="flex items-center gap-2 mb-2 pb-4 border-b border-outline-variant/20">
                <span class="material-symbols-outlined text-primary" style="font-size: 20px;">visibility</span>
                <h3 class="font-label-md text-label-md text-on-surface tracking-wider uppercase font-bold">Live Preview</h3>
            </div>
            
            <!-- Preview Accordion -->
            <div class="bg-primary-container/30 rounded-lg border border-primary-fixed-dim/50 overflow-hidden cursor-pointer group">
                <div class="px-5 py-4 flex justify-between items-start gap-4">
                    <h4 class="font-headline-md text-lg font-semibold text-on-primary-container leading-snug" id="preview-question">Apakah bisa custom warna?</h4>
                    <span class="material-symbols-outlined text-primary mt-1 transform group-hover:-translate-y-1 transition-transform">keyboard_arrow_down</span>
                </div>
                <div class="px-5 pb-5">
                    <p class="font-body-md text-body-md text-on-surface-variant" id="preview-answer">Bisa, pelanggan dapat memilih warna dominan sesuai request.</p>
                    <div class="mt-4 flex gap-2">
                        <span class="inline-block px-3 py-1 bg-surface-container-lowest rounded-full font-label-sm text-xs font-bold text-primary border border-primary-fixed-dim" id="preview-category">Custom Order</span>
                    </div>
                </div>
            </div>
            
            <p class="font-body-md text-xs text-on-surface-variant/70 text-center mt-4">
                Tampilan ini menunjukkan simulasi bagaimana FAQ akan terlihat oleh pengunjung.
            </p>
        </div>
    </div>
</div>

<!-- Simple JS for live preview updating -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const inputQ = document.getElementById('pertanyaan');
        const inputA = document.getElementById('jawaban');
        const selectC = document.getElementById('kategori');
        
        const prevQ = document.getElementById('preview-question');
        const prevA = document.getElementById('preview-answer');
        const prevC = document.getElementById('preview-category');

        const updatePreview = () => {
            prevQ.textContent = inputQ.value || 'Apakah bisa custom warna?';
            prevA.textContent = inputA.value || 'Bisa, pelanggan dapat memilih warna dominan sesuai request.';
            
            const selectedText = selectC.options[selectC.selectedIndex].text;
            if(selectC.value !== "") {
                prevC.textContent = selectedText;
                prevC.style.display = 'inline-block';
            } else {
                prevC.style.display = 'none';
            }
        };

        inputQ.addEventListener('input', updatePreview);
        inputA.addEventListener('input', updatePreview);
        selectC.addEventListener('change', updatePreview);
        
        // Initial call
        if(inputQ.value || inputA.value) updatePreview();
    });
</script>

<?= $this->endSection() ?>
