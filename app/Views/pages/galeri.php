<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Hero Section -->
<section
    class="bg-primary-container/30 py-24 md:py-32 px-container-padding-mobile md:px-container-padding-desktop text-center">
    <div class="max-w-[800px] mx-auto">
        <h1 class="font-display-lg text-4xl md:text-5xl font-bold text-on-surface mb-6">
            Galeri Hasil Produk
        </h1>
        <p class="font-body-lg text-lg text-on-surface-variant max-w-3xl mx-auto">
            Koleksi portofolio dan hasil pesanan custom pelanggan Aye Bouquet. 
            Jadikan inspirasi untuk hadiah spesialmu selanjutnya.
        </p>
    </div>
</section>

<!-- Gallery Grid -->
<section class="py-section-gap px-container-padding-mobile md:px-container-padding-desktop max-w-[1280px] mx-auto">
    <?php if (!empty($galleries)): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php foreach ($galleries as $gallery): ?>
            <article class="bg-surface-container-lowest rounded-2xl overflow-hidden border border-outline-variant/20 shadow-sm hover:shadow-md transition-shadow group">
                <div class="overflow-hidden">
                    <img src="<?= base_url('uploads/galleries/' . $gallery['image']) ?>" alt="<?= esc($gallery['title']) ?>" class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-500" onerror="this.onerror=null; this.src='<?= base_url('assets/images/no-image.svg') ?>'">
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-on-surface mb-1"><?= esc($gallery['title']) ?></h3>
                    <?php if (!empty($gallery['description'])): ?>
                        <p class="text-sm text-on-surface-variant line-clamp-3"><?= esc($gallery['description']) ?></p>
                    <?php endif; ?>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="text-center py-20 bg-surface-container-low rounded-2xl border border-outline-variant/20">
            <span class="material-symbols-outlined text-5xl text-outline mb-4">photo_library</span>
            <h3 class="font-bold text-xl text-on-surface mb-2">Belum Ada Foto</h3>
            <p class="text-on-surface-variant">Galeri hasil produk saat ini masih kosong.</p>
            <a href="<?= base_url('/katalog') ?>" class="inline-block mt-6 px-6 py-2.5 rounded-full bg-primary text-on-primary font-bold hover:bg-primary/90 transition-colors">Lihat Katalog</a>
        </div>
    <?php endif; ?>
</section>

<?= $this->endSection() ?>
