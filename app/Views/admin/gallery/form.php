<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>
<?php
$isEdit = !empty($gallery);
$action = $isEdit ? base_url('admin/galeri/update/' . $gallery['id']) : base_url('admin/galeri/store');
$catOptions = [
    'product_gallery' => 'Galeri Hasil Produk',
    'about_story' => 'Cerita Kami',
    'banner' => 'Banner/Hero',
    'other' => 'Dokumentasi Lainnya'
];
?>
<div class="mb-8 admin-enter">
    <h2 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface mb-2"><?= $isEdit ? 'Edit Foto Galeri' : 'Tambah Foto Galeri' ?></h2>
    <p class="font-body-md text-body-md text-on-surface-variant">Galeri ini akan tampil di halaman frontend jika statusnya aktif.</p>
</div>
<?php if (session()->getFlashdata('error')): ?><div class="mb-6 p-4 rounded-xl bg-[#FCE8E6] text-[#C5221F] text-sm font-semibold"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>
<form action="<?= $action ?>" method="post" enctype="multipart/form-data" class="bg-surface-container-lowest dark:bg-[#262024] shadow p-6 md:p-8 rounded-xl border border-outline-variant/20 dark:border-white/10 flex flex-col gap-6 admin-enter">
    <?= csrf_field() ?>
    <div>
        <label class="block font-label-md text-label-md text-on-surface dark:text-white mb-2">Upload foto produk <?= $isEdit ? '' : '<span class="text-error">*</span>' ?></label>
        <?php if ($isEdit && !empty($gallery['image'])): ?>
            <img src="<?= base_url('uploads/galleries/' . $gallery['image']) ?>" alt="<?= esc($gallery['title']) ?>" class="w-48 h-48 object-cover rounded-xl border dark:border-white/10 mb-3">
        <?php endif; ?>
        <input type="file" name="image" accept="image/png,image/jpeg,image/webp" class="w-full border border-outline-variant dark:border-white/15 rounded-xl px-4 py-3 bg-surface-bright dark:bg-white/5 text-on-surface dark:text-white" <?= $isEdit ? '' : 'required' ?>>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div><label class="block mb-2 font-bold text-on-surface dark:text-white">Judul foto</label><input name="title" type="text" value="<?= old('title', $gallery['title'] ?? '') ?>" required class="w-full px-4 py-3 border border-outline-variant dark:border-white/15 rounded-xl bg-surface-bright dark:bg-white/5 text-on-surface dark:text-white placeholder:text-on-surface-variant/50 dark:placeholder:text-white/40"></div>
        <div><label class="block mb-2 font-bold text-on-surface dark:text-white">Kategori</label><select name="category" required class="w-full px-4 py-3 border border-outline-variant dark:border-white/15 rounded-xl bg-surface-bright dark:bg-surface-container text-on-surface dark:text-white"><option value="">Pilih kategori</option><?php foreach ($catOptions as $val => $label): ?><option value="<?= $val ?>" <?= old('category', $gallery['category'] ?? '') === $val ? 'selected' : '' ?>><?= $label ?></option><?php endforeach; ?></select></div>
    </div>
    <div><label class="block mb-2 font-bold text-on-surface dark:text-white">Caption/deskripsi</label><textarea name="description" rows="4" class="w-full px-4 py-3 border border-outline-variant dark:border-white/15 rounded-xl bg-surface-bright dark:bg-white/5 text-on-surface dark:text-white placeholder:text-on-surface-variant/50 dark:placeholder:text-white/40"><?= old('description', $gallery['description'] ?? '') ?></textarea></div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div><label class="block mb-2 font-bold text-on-surface dark:text-white">Status</label><select name="status" class="w-full px-4 py-3 border border-outline-variant dark:border-white/15 rounded-xl bg-surface-bright dark:bg-surface-container text-on-surface dark:text-white"><option value="tampil" <?= (int)old('is_active', $gallery['is_active'] ?? 1) === 1 ? 'selected' : '' ?>>Tampil</option><option value="disembunyikan" <?= (int)old('is_active', $gallery['is_active'] ?? 1) === 0 ? 'selected' : '' ?>>Disembunyikan</option></select></div>
        <div><label class="block mb-2 font-bold text-on-surface dark:text-white">Urutan tampil</label><input name="sort_order" type="number" value="<?= old('sort_order', $gallery['sort_order'] ?? 0) ?>" class="w-full px-4 py-3 border border-outline-variant dark:border-white/15 rounded-xl bg-surface-bright dark:bg-white/5 text-on-surface dark:text-white"></div>
    </div>
    <div class="flex justify-end gap-3"><a href="<?= base_url('admin/galeri') ?>" class="px-6 py-3 rounded-full border border-outline-variant dark:border-white/15 text-on-surface dark:text-white hover:bg-surface-container dark:hover:bg-white/10 transition-colors">Batal</a><button class="px-6 py-3 rounded-full bg-primary text-on-primary font-bold" type="submit">Simpan</button></div>
</form>
<?= $this->endSection() ?>
