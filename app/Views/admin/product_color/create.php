<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<div class="flex items-center gap-2 text-sm text-on-surface-variant dark:text-white/60 mb-6">
    <a href="<?= base_url('admin') ?>" class="hover:text-primary transition-colors">Dashboard</a>
    <span class="material-symbols-outlined text-base">chevron_right</span>
    <a href="<?= base_url('admin/product-colors') ?>" class="hover:text-primary transition-colors">Warna Produk</a>
    <span class="material-symbols-outlined text-base">chevron_right</span>
    <span class="text-on-surface dark:text-white font-medium">Tambah Warna</span>
</div>

<?php if (session()->getFlashdata('error')): ?>
<div class="mb-4 px-5 py-4 rounded-2xl bg-error/10 border border-error/20 text-error-text dark:bg-error/15 dark:border-error/25 dark:text-error-text-dark flex items-center gap-3 shadow-sm" role="alert">
    <span class="material-symbols-outlined text-xl flex-shrink-0">error</span>
    <span class="text-sm font-medium"><?= esc(session()->getFlashdata('error')) ?></span>
    <button onclick="this.parentElement.remove()" class="ml-auto text-error-text/60 hover:text-error-text transition-colors" aria-label="Tutup">&times;</button>
</div>
<?php endif; ?>

<div class="max-w-2xl mx-auto">
    <form action="<?= base_url('admin/product-colors/store') ?>" method="post">
        <?= csrf_field() ?>

        <div class="bg-surface-container-lowest dark:bg-white/[0.03] rounded-2xl p-6 soft-shadow border border-outline-variant/20 dark:border-white/5 space-y-6">
            <h3 class="text-lg font-bold text-on-surface dark:text-white">Informasi Warna</h3>

            <div>
                <label for="name" class="block text-sm font-semibold text-on-surface dark:text-white mb-2">Nama Warna <span class="text-error">*</span></label>
                <input type="text" id="name" name="name" value="<?= old('name') ?>"
                       class="w-full px-4 py-3 rounded-xl bg-surface-container-high dark:bg-white/5 border border-outline-variant/30 dark:border-white/10 text-on-surface dark:text-white placeholder:text-on-surface-variant/50 dark:placeholder:text-white/30 focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary/50 transition-all duration-200 text-sm"
                       placeholder="Contoh: Hitam" required>
                <?php if (!empty($validation) && $validation->hasError('name')): ?>
                <p class="mt-1.5 text-xs text-error"><?= esc($validation->getError('name')) ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label for="hex_code" class="block text-sm font-semibold text-on-surface dark:text-white mb-2">Kode Hex Warna</label>
                <div class="flex items-center gap-3">
                    <input type="text" id="hex_code" name="hex_code" value="<?= old('hex_code') ?>"
                           class="flex-1 px-4 py-3 rounded-xl bg-surface-container-high dark:bg-white/5 border border-outline-variant/30 dark:border-white/10 text-on-surface dark:text-white placeholder:text-on-surface-variant/50 dark:placeholder:text-white/30 focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary/50 transition-all duration-200 text-sm font-mono"
                           placeholder="#000000" pattern="^#[0-9a-fA-F]{6}$">
                    <div id="color-preview" class="w-10 h-10 rounded-full border border-outline-variant/30 dark:border-white/10 flex-shrink-0" style="background-color: <?= old('hex_code') ?: '#f0f0f0' ?>"></div>
                </div>
                <?php if (!empty($validation) && $validation->hasError('hex_code')): ?>
                <p class="mt-1.5 text-xs text-error"><?= esc($validation->getError('hex_code')) ?></p>
                <?php endif; ?>
                <p class="mt-1.5 text-xs text-on-surface-variant dark:text-white/40">Format: #RRGGBB. Contoh: #ff0000 untuk merah. Kosongkan jika tidak ada.</p>
            </div>

            <div>
                <label for="sort_order" class="block text-sm font-semibold text-on-surface dark:text-white mb-2">Urutan Tampil</label>
                <input type="number" id="sort_order" name="sort_order" value="<?= old('sort_order', '0') ?>"
                       class="w-full max-w-xs px-4 py-3 rounded-xl bg-surface-container-high dark:bg-white/5 border border-outline-variant/30 dark:border-white/10 text-on-surface dark:text-white placeholder:text-on-surface-variant/50 dark:placeholder:text-white/30 focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary/50 transition-all duration-200 text-sm"
                       placeholder="0" min="0">
            </div>

            <div class="flex items-center gap-3">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" id="is_active" name="is_active" value="1" <?= old('is_active', '1') ? 'checked' : '' ?>
                       class="w-5 h-5 rounded border-outline-variant/30 dark:border-white/10 text-primary focus:ring-primary/40 bg-surface-container-high dark:bg-white/5">
                <label for="is_active" class="text-sm font-medium text-on-surface dark:text-white">Aktif</label>
            </div>
        </div>

        <div class="flex items-center gap-3 mt-6">
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-primary text-on-primary text-sm font-semibold hover:bg-primary/90 transition-all duration-200 shadow-sm">
                <span class="material-symbols-outlined text-lg">save</span>
                Simpan Warna
            </button>
            <a href="<?= base_url('admin/product-colors') ?>" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-surface-container-high dark:bg-white/5 text-on-surface-variant dark:text-white/70 text-sm font-semibold hover:bg-surface-container-highest dark:hover:bg-white/10 transition-all duration-200">
                Batal
            </a>
        </div>
    </form>
</div>

<script>
document.getElementById('hex_code')?.addEventListener('input', function() {
    const preview = document.getElementById('color-preview');
    preview.style.backgroundColor = this.value || '#f0f0f0';
});
</script>

<?= $this->endSection() ?>
