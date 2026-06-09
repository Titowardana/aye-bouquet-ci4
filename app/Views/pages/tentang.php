<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Hero Section -->
<section
    class="bg-primary-container/30 dark:bg-[#1a1517] py-24 md:py-32 px-container-padding-mobile md:px-container-padding-desktop text-center">
    <div class="max-w-[800px] mx-auto">
        <h1 class="font-display-lg text-4xl md:text-5xl font-bold text-on-surface dark:text-white/95 mb-6">
            <?= esc($contacts['about_hero_title'] ?? 'Tentang Aye Bouquet') ?>
        </h1>
        <p class="font-body-lg text-lg text-on-surface-variant dark:text-white/70 max-w-3xl mx-auto">
            <?= esc($contacts['about_hero_description'] ?? 'UMKM gift custom yang menyediakan buket bunga, buket uang, buket snack, selempang, bloom box, single flower, dan custom gift untuk berbagai acara.') ?>
        </p>
    </div>
</section>

<!-- Cerita Kami Section -->
<section class="py-section-gap px-container-padding-mobile md:px-container-padding-desktop max-w-[1280px] mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">

        <!-- Draggable Polaroid Card Stack -->
        <div class="story-drag-stage" id="storyDragStage">
            <?php if (!empty($aboutStoryGalleries)): ?>
                <?php
                $totalCards = count($aboutStoryGalleries);
                $rotations = [-6, 4, -3, 7, -5, 2, -8, 5];
                $offsetsX  = [0, 15, -10, 25, -20, 10, -15, 20];
                $offsetsY  = [0, -10, 8, -15, 12, -8, 5, -12];
                ?>
                <?php foreach ($aboutStoryGalleries as $i => $storyGallery): ?>
                    <?php
                    $rot = $rotations[$i % count($rotations)];
                    $ox  = $offsetsX[$i % count($offsetsX)];
                    $oy  = $offsetsY[$i % count($offsetsY)];
                    ?>
                    <div class="story-drag-card"
                         data-rotate="<?= $rot ?>"
                         data-init-x="<?= $ox ?>"
                         data-init-y="<?= $oy ?>"
                         style="z-index: <?= $i + 1 ?>; transform: translate(<?= $ox ?>px, <?= $oy ?>px) rotate(<?= $rot ?>deg);">
                        <img src="<?= base_url('uploads/galleries/' . $storyGallery['image']) ?>"
                             alt="<?= esc($storyGallery['title'] ?? 'Cerita Kami') ?>"
                             draggable="false"
                             onerror="this.onerror=null; this.src='<?= base_url('assets/images/no-image.svg') ?>'">
                        <?php if (!empty($storyGallery['title'])): ?>
                            <span class="story-drag-card__caption"><?= esc($storyGallery['title']) ?></span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="flex items-center justify-center h-full min-h-[300px]">
                    <div class="text-center">
                        <span class="material-symbols-outlined text-5xl text-on-surface-variant/30 dark:text-white/20 mb-3">photo_camera</span>
                        <p class="text-sm text-on-surface-variant dark:text-white/50">Foto cerita kami belum diunggah.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Text Content -->
        <div>
            <h2 class="font-headline-lg text-3xl font-bold text-on-surface dark:text-white mb-6">
                <?= esc($contacts['about_story_title'] ?? 'Cerita Kami') ?>
            </h2>

            <div class="font-body-md text-base text-on-surface-variant dark:text-white/70 space-y-4 leading-relaxed">
                <?= nl2br(esc($contacts['about_story_content'] ?? 'Berawal dari kecintaan terhadap seni merangkai dan memberikan kebahagiaan melalui hadiah yang bermakna, Aye Bouquet hadir sebagai solusi untuk kebutuhan gift custom pelanggan.')) ?>
            </div>
        </div>
    </div>
</section>

<!-- Produk Kami Section -->
<section class="py-section-gap bg-surface-container-low dark:bg-[#1f1b1d] px-container-padding-mobile md:px-container-padding-desktop">
    <div class="max-w-[1280px] mx-auto text-center">
        <h2 class="font-headline-lg text-3xl font-bold text-on-surface dark:text-white mb-4">
            Produk Kami
        </h2>

        <p class="font-body-md text-on-surface-variant dark:text-white/70 mb-12 max-w-2xl mx-auto">
            Aye Bouquet menyediakan berbagai pilihan produk gift/custom yang dapat
            disesuaikan dengan kebutuhan acara dan budget pelanggan.
        </p>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $cat): ?>
                    <?php if ($cat['is_active']): ?>
                        <div class="bg-surface dark:bg-[#262024] rounded-xl p-8 shadow-level-1 hover:shadow-level-2 transition-all duration-300 flex flex-col items-center text-center">
                            <div class="w-16 h-16 rounded-full bg-primary-container/40 dark:bg-primary/25 text-primary dark:text-primary-fixed-dim flex items-center justify-center mb-4 transition-all duration-300">
                                <?php
                                $catIcon = $cat['icon'] ?? '';
                                $catIconIsFile = !empty($catIcon) && preg_match('/\.(jpg|jpeg|png|gif|webp|svg)$/i', $catIcon);
                                $catIconFilePath = FCPATH . 'uploads/categories/' . $catIcon;
                                if ($catIconIsFile && file_exists($catIconFilePath)):
                                ?>
                                    <img src="<?= base_url('uploads/categories/' . esc($catIcon)) ?>"
                                         alt="<?= esc($cat['name']) ?>"
                                         class="w-10 h-10 object-contain">
                                <?php elseif (!$catIconIsFile && !empty($catIcon)): ?>
                                    <span class="material-symbols-outlined font-semibold" style="font-size: 32px;"><?= esc($catIcon) ?></span>
                                <?php else: ?>
                                    <span class="material-symbols-outlined font-semibold" style="font-size: 32px;">category</span>
                                <?php endif; ?>
                            </div>
                            <h3 class="font-label-md text-base font-bold text-on-surface dark:text-white mb-2"><?= esc($cat['name']) ?></h3>
                            <p class="text-sm text-on-surface-variant dark:text-white/70 line-clamp-3">
                                <?= esc($cat['description'] ?? 'Produk custom Aye Bouquet') ?>
                            </p>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-span-full text-center text-on-surface-variant dark:text-white/60">Belum ada kategori aktif.</div>
            <?php endif; ?>

        </div>
    </div>
</section>

<!-- Keunggulan Section -->
<section class="py-section-gap px-container-padding-mobile md:px-container-padding-desktop max-w-[1280px] mx-auto">
    <div class="text-center mb-12">
        <h2 class="font-headline-lg text-3xl font-bold text-on-surface dark:text-white mb-4">
            Keunggulan
        </h2>
        <p class="font-body-md text-on-surface-variant dark:text-white/70 max-w-2xl mx-auto">
            Kami berusaha memberikan layanan yang mudah, fleksibel, dan sesuai
            dengan kebutuhan pelanggan.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-[900px] mx-auto">

        <div class="bg-surface-container-low dark:bg-[#211b1f] rounded-xl p-6 flex items-start gap-4">
            <span class="material-symbols-outlined text-primary dark:text-primary-fixed-dim"
                style="font-variation-settings: 'FILL' 1;">check_circle</span>
            <div>
                <h3 class="font-bold text-on-surface dark:text-white mb-1">Bisa Custom Sesuai Request</h3>
                <p class="text-sm text-on-surface-variant dark:text-white/70">
                    Pelanggan dapat menentukan warna, tema, model, dan catatan khusus.
                </p>
            </div>
        </div>

        <div class="bg-surface-container-low dark:bg-[#211b1f] rounded-xl p-6 flex items-start gap-4">
            <span class="material-symbols-outlined text-primary dark:text-primary-fixed-dim"
                style="font-variation-settings: 'FILL' 1;">check_circle</span>
            <div>
                <h3 class="font-bold text-on-surface dark:text-white mb-1">Banyak Pilihan Ukuran</h3>
                <p class="text-sm text-on-surface-variant dark:text-white/70">
                    Tersedia pilihan size seperti S, M, L, XL, XXL, hingga Jumbo.
                </p>
            </div>
        </div>

        <div class="bg-surface-container-low dark:bg-[#211b1f] rounded-xl p-6 flex items-start gap-4">
            <span class="material-symbols-outlined text-primary dark:text-primary-fixed-dim"
                style="font-variation-settings: 'FILL' 1;">check_circle</span>
            <div>
                <h3 class="font-bold text-on-surface dark:text-white mb-1">Bisa Tambah Kartu Ucapan</h3>
                <p class="text-sm text-on-surface-variant dark:text-white/70">
                    Pelanggan dapat menambahkan isi kartu ucapan pada pesanan.
                </p>
            </div>
        </div>

        <div class="bg-surface-container-low dark:bg-[#211b1f] rounded-xl p-6 flex items-start gap-4">
            <span class="material-symbols-outlined text-primary dark:text-primary-fixed-dim"
                style="font-variation-settings: 'FILL' 1;">check_circle</span>
            <div>
                <h3 class="font-bold text-on-surface dark:text-white mb-1">Konfirmasi Mudah via WhatsApp</h3>
                <p class="text-sm text-on-surface-variant dark:text-white/70">
                    Pesanan akan dikonfirmasi langsung melalui WhatsApp admin UMKM.
                </p>
            </div>
        </div>

        <div class="bg-surface-container-low dark:bg-[#211b1f] rounded-xl p-6 flex items-start gap-4 md:col-span-2">
            <span class="material-symbols-outlined text-primary dark:text-primary-fixed-dim"
                style="font-variation-settings: 'FILL' 1;">check_circle</span>
            <div>
                <h3 class="font-bold text-on-surface dark:text-white mb-1">Cocok untuk Banyak Acara</h3>
                <p class="text-sm text-on-surface-variant dark:text-white/70">
                    Produk dapat digunakan untuk wisuda, ulang tahun, anniversary,
                    seminar, hadiah pasangan, sahabat, keluarga, dan acara lainnya.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Proses Pemesanan Section -->
<section class="py-section-gap bg-surface-container-low dark:bg-[#1f1b1d] px-container-padding-mobile md:px-container-padding-desktop">
    <div class="max-w-[1280px] mx-auto text-center">
        <h2 class="font-headline-lg text-3xl font-bold text-on-surface dark:text-white mb-4">
            Proses Pemesanan
        </h2>

        <p class="font-body-md text-on-surface-variant dark:text-white/70 mb-12 max-w-2xl mx-auto">
            Proses pemesanan dibuat sederhana agar pelanggan mudah memilih produk
            dan melakukan konfirmasi pesanan melalui WhatsApp.
        </p>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            <div class="bg-surface dark:bg-[#262024] rounded-xl p-8 shadow-level-1 flex flex-col items-center text-center">
                <div
                    class="w-12 h-12 rounded-full bg-primary text-on-primary font-bold flex items-center justify-center mb-6">
                    1
                </div>
                <h3 class="font-bold text-on-surface dark:text-white mb-3">Pilih Produk</h3>
                <p class="text-sm text-on-surface-variant dark:text-white/70">
                    Pelanggan memilih produk dari katalog sesuai kebutuhan acara.
                </p>
            </div>

            <div class="bg-surface dark:bg-[#262024] rounded-xl p-8 shadow-level-1 flex flex-col items-center text-center">
                <div
                    class="w-12 h-12 rounded-full bg-primary text-on-primary font-bold flex items-center justify-center mb-6">
                    2
                </div>
                <h3 class="font-bold text-on-surface dark:text-white mb-3">Pilih Size dan Custom</h3>
                <p class="text-sm text-on-surface-variant dark:text-white/70">
                    Pelanggan memilih ukuran, warna, tema, dan tambahan custom.
                </p>
            </div>

            <div class="bg-surface dark:bg-[#262024] rounded-xl p-8 shadow-level-1 flex flex-col items-center text-center">
                <div
                    class="w-12 h-12 rounded-full bg-primary text-on-primary font-bold flex items-center justify-center mb-6">
                    3
                </div>
                <h3 class="font-bold text-on-surface dark:text-white mb-3">Isi Data Pesanan</h3>
                <p class="text-sm text-on-surface-variant dark:text-white/70">
                    Pelanggan mengisi data pemesan, penerima, alamat, dan tanggal.
                </p>
            </div>

            <div class="bg-surface dark:bg-[#262024] rounded-xl p-8 shadow-level-1 flex flex-col items-center text-center">
                <div
                    class="w-12 h-12 rounded-full bg-primary text-on-primary font-bold flex items-center justify-center mb-6">
                    4
                </div>
                <h3 class="font-bold text-on-surface dark:text-white mb-3">Konfirmasi via WhatsApp</h3>
                <p class="text-sm text-on-surface-variant dark:text-white/70">
                    Admin akan mengonfirmasi detail pesanan dan pembayaran melalui WhatsApp.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-24 px-container-padding-mobile md:px-container-padding-desktop text-center max-w-[800px] mx-auto">
    <h2 class="font-headline-md text-2xl md:text-3xl font-bold text-on-surface dark:text-white mb-4">
        Siap merangkai kebahagiaan bersama kami?
    </h2>

    <p class="font-body-md text-on-surface-variant dark:text-white/70 mb-8">
        Temukan produk gift custom yang sesuai dengan momen spesialmu.
    </p>

    <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
        <a class="inline-flex items-center justify-center px-8 py-3 rounded-full bg-primary text-on-primary font-label-md text-sm font-bold hover:bg-primary/90 transition-colors shadow-level-1 hover:shadow-level-2 w-full sm:w-auto"
            href="<?= base_url('/katalog') ?>">
            Lihat Katalog
        </a>

        <a class="inline-flex items-center justify-center px-8 py-3 rounded-full border border-primary dark:border-primary-fixed-dim text-primary dark:text-primary-fixed-dim font-label-md text-sm font-bold hover:bg-primary-container dark:hover:bg-primary/20 transition-colors w-full sm:w-auto"
            href="<?= base_url('/kontak') ?>">
            Hubungi Kami
        </a>

        <a class="inline-flex items-center justify-center px-8 py-3 rounded-full border border-outline-variant dark:border-white/20 text-on-surface-variant dark:text-white/70 font-label-md text-sm font-bold hover:bg-surface-container-low dark:hover:bg-white/10 transition-colors w-full sm:w-auto"
            href="<?= base_url('/custom-order') ?>">
            Custom Order
        </a>
    </div>
</section>


<?php if (!empty($productGalleries)): ?>
<section class="py-section-gap px-container-padding-mobile md:px-container-padding-desktop max-w-[1280px] mx-auto">
    <div class="text-center mb-12">
        <h2 class="font-headline-lg text-3xl font-bold text-on-surface dark:text-white mb-4">Galeri Hasil Produk</h2>
        <p class="font-body-md text-on-surface-variant dark:text-white/70 max-w-2xl mx-auto">Foto yang tampil di bagian ini berasal dari menu Admin Galeri.</p>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($productGalleries as $gallery): ?>
        <article class="bg-surface-container-lowest dark:bg-[#262024] rounded-2xl overflow-hidden border border-outline-variant/20 dark:border-white/10 shadow-sm">
            <img src="<?= base_url('uploads/galleries/' . $gallery['image']) ?>" alt="<?= esc($gallery['title']) ?>" class="w-full h-56 object-cover" onerror="this.onerror=null; this.src='<?= base_url('assets/images/no-image.svg') ?>'">
            <div class="p-5">
                <h3 class="font-bold text-on-surface dark:text-white mb-1"><?= esc($gallery['title']) ?></h3>
                <p class="text-sm text-on-surface-variant dark:text-white/70 line-clamp-2"><?= esc($gallery['description'] ?? '') ?></p>
            </div>
        </article>
        <?php endforeach; ?>
    </div>
    <?php if (isset($totalProductGalleries) && $totalProductGalleries > 6): ?>
        <div class="text-center mt-10">
            <a href="<?= base_url('/galeri') ?>" class="inline-flex items-center justify-center px-8 py-3 rounded-full border border-primary dark:border-primary-fixed-dim text-primary dark:text-primary-fixed-dim font-label-md text-sm font-bold hover:bg-primary-container dark:hover:bg-primary/20 transition-colors">
                Lihat Semua Galeri
            </a>
        </div>
    <?php endif; ?>
</section>
<?php endif; ?>

<?= $this->endSection() ?>