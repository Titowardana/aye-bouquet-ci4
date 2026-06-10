<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Hero Section -->
<section
    class="bg-warm-blush dark:bg-[#1a1517] py-20 md:py-28 px-container-padding-mobile md:px-container-padding-desktop text-center relative overflow-hidden">
    <!-- Decorative blobs -->
    <div class="hidden md:block deco-blob absolute -top-20 -left-20 w-72 h-72 bg-soft-pink-accent/40 dark:opacity-10 animate-float-slow"></div>
    <div class="hidden md:block deco-blob absolute -bottom-20 -right-20 w-80 h-80 bg-primary-container/30 dark:opacity-10 animate-float" style="animation-delay: 1s"></div>
    <!-- Floating petals -->
    <div class="hidden md:block deco-petal absolute top-16 left-[15%] w-5 h-5 bg-primary/15 dark:opacity-0 animate-drift" style="animation-delay: 0.2s"></div>
    <div class="hidden md:block deco-petal absolute bottom-20 right-[20%] w-4 h-4 bg-soft-beige/50 dark:opacity-0 animate-drift" style="animation-delay: 0.8s"></div>
    <div class="hidden md:block deco-petal absolute top-1/3 right-[10%] w-6 h-6 bg-soft-pink-accent/40 dark:opacity-0 animate-drift" style="animation-delay: 1.5s"></div>
    <!-- Radial gradient overlay for depth -->
    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-white/10 to-white/20 dark:via-transparent dark:to-transparent pointer-events-none"></div>
    <div class="max-w-[800px] mx-auto relative z-10">
        <span class="inline-block font-label-md text-xs font-extrabold text-primary dark:text-primary-fixed-dim uppercase tracking-[0.2em] mb-4 animate-on-scroll">Tentang Aye Bouquet</span>
        <h1 class="font-display-lg text-4xl md:text-5xl font-bold text-on-surface dark:text-white/95 mb-6 animate-on-scroll stagger-1">
            Cerita di Balik Setiap Buket
        </h1>
        <p class="font-body-lg text-lg text-on-surface-variant dark:text-white/70 max-w-3xl mx-auto animate-on-scroll stagger-2">
            <?= esc($contacts['about_hero_description'] ?? 'UMKM gift custom yang menyediakan buket bunga, buket uang, buket snack, selempang, bloom box, single flower, dan custom gift untuk berbagai acara.') ?>
        </p>
    </div>
</section>

<!-- Cerita Kami Section -->
<section class="py-section-gap px-container-padding-mobile md:px-container-padding-desktop bg-warm-cream dark:bg-[#1c191a]">
    <div class="max-w-[1280px] mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">

        <!-- Draggable Polaroid Card Stack -->
        <div class="animate-on-scroll slide-in-left">
            <div class="bg-white-warm dark:bg-[#262024] rounded-2xl p-4 md:p-6 shadow-[0_8px_30px_rgba(121,84,101,0.08)] dark:shadow-none border border-soft-beige/30 dark:border-white/10 hover:shadow-[0_12px_40px_rgba(121,84,101,0.12)] dark:hover:shadow-none transition-shadow duration-500">
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
    </div>
        </div>

        <!-- Text Content -->
        <div class="animate-on-scroll slide-in-right">
            <span class="inline-block font-label-md text-xs font-extrabold text-primary dark:text-primary-fixed-dim uppercase tracking-[0.2em] mb-3">Our Story</span>
            <h2 class="font-headline-lg text-3xl font-bold text-on-surface dark:text-white mb-6">
                Perjalanan Kami
            </h2>

            <div class="font-body-md text-base text-on-surface-variant dark:text-white/70 space-y-4 leading-relaxed">
                <?= nl2br(esc($contacts['about_story_content'] ?? 'Berawal dari kecintaan terhadap seni merangkai dan memberikan kebahagiaan melalui hadiah yang bermakna, Aye Bouquet hadir sebagai solusi untuk kebutuhan gift custom pelanggan.')) ?>
            </div>
        </div>
    </div>
    </div>
</section>

<!-- Nilai Kami Section -->
<section class="py-section-gap px-container-padding-mobile md:px-container-padding-desktop bg-warm-blush/40 dark:bg-[#1f1b1d]">
    <div class="max-w-[900px] mx-auto text-center">
        <span class="inline-block font-label-md text-xs font-extrabold text-primary dark:text-primary-fixed-dim uppercase tracking-[0.2em] mb-3 animate-on-scroll">Nilai Kami</span>
        <h2 class="font-headline-lg text-3xl font-bold text-on-surface dark:text-white mb-12 animate-on-scroll stagger-1">
            Yang Kami Percaya
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-left" data-stagger>
            <div class="bg-white-warm dark:bg-[#262024] rounded-2xl p-8 card-shadow border border-soft-beige/30 dark:border-white/10 hover:-translate-y-1 hover:shadow-[0_12px_35px_rgba(121,84,101,0.1)] dark:hover:shadow-none transition-all duration-300 animate-on-scroll">
                <div class="w-14 h-14 rounded-2xl bg-primary-container/40 dark:bg-primary/20 flex items-center justify-center mb-5 text-primary dark:text-primary-fixed-dim">
                    <span class="material-symbols-outlined" style="font-size:28px">favorite</span>
                </div>
                <h3 class="font-label-md text-base font-bold text-on-surface dark:text-white mb-2">Dirangkai dengan Hati</h3>
                <p class="text-sm text-on-surface-variant dark:text-white/70 leading-relaxed">Setiap buket dirangkai dengan penuh ketelitian dan cinta untuk memastikan hasil yang sempurna.</p>
            </div>
            <div class="bg-white-warm dark:bg-[#262024] rounded-2xl p-8 card-shadow border border-soft-beige/30 dark:border-white/10 hover:-translate-y-1 hover:shadow-[0_12px_35px_rgba(121,84,101,0.1)] dark:hover:shadow-none transition-all duration-300 animate-on-scroll stagger-1">
                <div class="w-14 h-14 rounded-2xl bg-primary-container/40 dark:bg-primary/20 flex items-center justify-center mb-5 text-primary dark:text-primary-fixed-dim">
                    <span class="material-symbols-outlined" style="font-size:28px">auto_awesome</span>
                </div>
                <h3 class="font-label-md text-base font-bold text-on-surface dark:text-white mb-2">Custom Sesuai Cerita</h3>
                <p class="text-sm text-on-surface-variant dark:text-white/70 leading-relaxed">Kami mendengarkan keinginan Anda dan mewujudkannya dalam bentuk hadiah yang bermakna.</p>
            </div>
            <div class="bg-white-warm dark:bg-[#262024] rounded-2xl p-8 card-shadow border border-soft-beige/30 dark:border-white/10 hover:-translate-y-1 hover:shadow-[0_12px_35px_rgba(121,84,101,0.1)] dark:hover:shadow-none transition-all duration-300 animate-on-scroll stagger-2">
                <div class="w-14 h-14 rounded-2xl bg-primary-container/40 dark:bg-primary/20 flex items-center justify-center mb-5 text-primary dark:text-primary-fixed-dim">
                    <span class="material-symbols-outlined" style="font-size:28px">celebration</span>
                </div>
                <h3 class="font-label-md text-base font-bold text-on-surface dark:text-white mb-2">Hadiah untuk Momen Spesial</h3>
                <p class="text-sm text-on-surface-variant dark:text-white/70 leading-relaxed">Kami percaya setiap momen berharga layak dirayakan dengan hadiah yang istimewa.</p>
            </div>
        </div>
    </div>
</section>

<!-- Produk Kami Section -->
<section class="py-section-gap bg-warm-cream dark:bg-[#1c191a] px-container-padding-mobile md:px-container-padding-desktop">
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
                        <div class="bg-white-warm dark:bg-[#262024] rounded-xl p-8 shadow-level-1 hover:shadow-level-2 transition-all duration-300 flex flex-col items-center text-center">
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
    <div class="text-center mb-12 animate-on-scroll">
        <span class="inline-block font-label-md text-xs font-extrabold text-primary dark:text-primary-fixed-dim uppercase tracking-[0.2em] mb-3">Mengapa Kami</span>
        <h2 class="font-headline-lg text-3xl font-bold text-on-surface dark:text-white mb-4">
            Keunggulan
        </h2>
        <p class="font-body-md text-on-surface-variant dark:text-white/70 max-w-2xl mx-auto">
            Kami berusaha memberikan layanan yang mudah, fleksibel, dan sesuai
            dengan kebutuhan pelanggan.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-[900px] mx-auto">

        <div class="bg-white-warm dark:bg-[#262024] rounded-xl p-6 flex items-start gap-4 border border-soft-beige/30 dark:border-white/10 hover:-translate-y-0.5 hover:shadow-[0_6px_20px_rgba(121,84,101,0.06)] dark:hover:shadow-none transition-all duration-300">
            <span class="material-symbols-outlined text-primary dark:text-primary-fixed-dim"
                style="font-variation-settings: 'FILL' 1;">check_circle</span>
            <div>
                <h3 class="font-bold text-on-surface dark:text-white mb-1">Bisa Custom Sesuai Request</h3>
                <p class="text-sm text-on-surface-variant dark:text-white/70">
                    Pelanggan dapat menentukan warna, tema, model, dan catatan khusus.
                </p>
            </div>
        </div>

        <div class="bg-white-warm dark:bg-[#262024] rounded-xl p-6 flex items-start gap-4 border border-soft-beige/30 dark:border-white/10 hover:-translate-y-0.5 hover:shadow-[0_6px_20px_rgba(121,84,101,0.06)] dark:hover:shadow-none transition-all duration-300">
            <span class="material-symbols-outlined text-primary dark:text-primary-fixed-dim"
                style="font-variation-settings: 'FILL' 1;">check_circle</span>
            <div>
                <h3 class="font-bold text-on-surface dark:text-white mb-1">Banyak Pilihan Ukuran</h3>
                <p class="text-sm text-on-surface-variant dark:text-white/70">
                    Tersedia pilihan size seperti S, M, L, XL, XXL, hingga Jumbo.
                </p>
            </div>
        </div>

        <div class="bg-white-warm dark:bg-[#262024] rounded-xl p-6 flex items-start gap-4 border border-soft-beige/30 dark:border-white/10 hover:-translate-y-0.5 hover:shadow-[0_6px_20px_rgba(121,84,101,0.06)] dark:hover:shadow-none transition-all duration-300">
            <span class="material-symbols-outlined text-primary dark:text-primary-fixed-dim"
                style="font-variation-settings: 'FILL' 1;">check_circle</span>
            <div>
                <h3 class="font-bold text-on-surface dark:text-white mb-1">Bisa Tambah Kartu Ucapan</h3>
                <p class="text-sm text-on-surface-variant dark:text-white/70">
                    Pelanggan dapat menambahkan isi kartu ucapan pada pesanan.
                </p>
            </div>
        </div>

        <div class="bg-white-warm dark:bg-[#262024] rounded-xl p-6 flex items-start gap-4 border border-soft-beige/30 dark:border-white/10 hover:-translate-y-0.5 hover:shadow-[0_6px_20px_rgba(121,84,101,0.06)] dark:hover:shadow-none transition-all duration-300">
            <span class="material-symbols-outlined text-primary dark:text-primary-fixed-dim"
                style="font-variation-settings: 'FILL' 1;">check_circle</span>
            <div>
                <h3 class="font-bold text-on-surface dark:text-white mb-1">Konfirmasi Mudah via WhatsApp</h3>
                <p class="text-sm text-on-surface-variant dark:text-white/70">
                    Pesanan akan dikonfirmasi langsung melalui WhatsApp admin UMKM.
                </p>
            </div>
        </div>

        <div class="bg-white-warm dark:bg-[#262024] rounded-xl p-6 flex items-start gap-4 border border-soft-beige/30 dark:border-white/10 hover:-translate-y-0.5 hover:shadow-[0_6px_20px_rgba(121,84,101,0.06)] dark:hover:shadow-none transition-all duration-300 md:col-span-2">
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
<section class="py-section-gap bg-warm-cream dark:bg-[#1c191a] px-container-padding-mobile md:px-container-padding-desktop">
    <div class="max-w-[1280px] mx-auto text-center">
        <span class="inline-block font-label-md text-xs font-extrabold text-primary dark:text-primary-fixed-dim uppercase tracking-[0.2em] mb-3 animate-on-scroll">Cara Pemesanan</span>
        <h2 class="font-headline-lg text-3xl font-bold text-on-surface dark:text-white mb-4 animate-on-scroll stagger-1">
            Proses Pemesanan
        </h2>

        <p class="font-body-md text-on-surface-variant dark:text-white/70 mb-12 max-w-2xl mx-auto">
            Proses pemesanan dibuat sederhana agar pelanggan mudah memilih produk
            dan melakukan konfirmasi pesanan melalui WhatsApp.
        </p>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            <div class="bg-white-warm dark:bg-[#262024] rounded-xl p-8 shadow-level-1 border border-soft-beige/30 dark:border-white/10 flex flex-col items-center text-center hover:-translate-y-1 hover:shadow-level-2 transition-all duration-300 animate-on-scroll">
                <div
                    class="w-12 h-12 rounded-full bg-primary text-on-primary font-bold flex items-center justify-center mb-6">
                    1
                </div>
                <h3 class="font-bold text-on-surface dark:text-white mb-3">Pilih Produk</h3>
                <p class="text-sm text-on-surface-variant dark:text-white/70">
                    Pelanggan memilih produk dari katalog sesuai kebutuhan acara.
                </p>
            </div>

            <div class="bg-white-warm dark:bg-[#262024] rounded-xl p-8 shadow-level-1 border border-soft-beige/30 dark:border-white/10 flex flex-col items-center text-center hover:-translate-y-1 hover:shadow-level-2 transition-all duration-300 animate-on-scroll stagger-1">
                <div
                    class="w-12 h-12 rounded-full bg-primary text-on-primary font-bold flex items-center justify-center mb-6">
                    2
                </div>
                <h3 class="font-bold text-on-surface dark:text-white mb-3">Pilih Size dan Custom</h3>
                <p class="text-sm text-on-surface-variant dark:text-white/70">
                    Pelanggan memilih ukuran, warna, tema, dan tambahan custom.
                </p>
            </div>

            <div class="bg-white-warm dark:bg-[#262024] rounded-xl p-8 shadow-level-1 border border-soft-beige/30 dark:border-white/10 flex flex-col items-center text-center hover:-translate-y-1 hover:shadow-level-2 transition-all duration-300 animate-on-scroll stagger-2">
                <div
                    class="w-12 h-12 rounded-full bg-primary text-on-primary font-bold flex items-center justify-center mb-6">
                    3
                </div>
                <h3 class="font-bold text-on-surface dark:text-white mb-3">Isi Data Pesanan</h3>
                <p class="text-sm text-on-surface-variant dark:text-white/70">
                    Pelanggan mengisi data pemesan, penerima, alamat, dan tanggal.
                </p>
            </div>

            <div class="bg-white-warm dark:bg-[#262024] rounded-xl p-8 shadow-level-1 border border-soft-beige/30 dark:border-white/10 flex flex-col items-center text-center hover:-translate-y-1 hover:shadow-level-2 transition-all duration-300 animate-on-scroll stagger-3">
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

        <a class="inline-flex items-center justify-center px-8 py-3 rounded-full border border-soft-beige/30 dark:border-white/20 text-on-surface-variant dark:text-white/70 font-label-md text-sm font-bold hover:bg-white-warm dark:hover:bg-white/10 transition-colors w-full sm:w-auto"
            href="<?= base_url('/custom-order') ?>">
            Custom Order
        </a>
    </div>
</section>


<?php if (!empty($productGalleries)): ?>
<section class="py-section-gap px-container-padding-mobile md:px-container-padding-desktop max-w-[1280px] mx-auto bg-warm-cream dark:bg-[#1c191a]">
    <div class="text-center mb-12 animate-on-scroll">
        <span class="inline-block font-label-md text-xs font-extrabold text-primary dark:text-primary-fixed-dim uppercase tracking-[0.2em] mb-3">Hasil Karya</span>
        <h2 class="font-headline-lg text-3xl font-bold text-on-surface dark:text-white mb-4">Galeri Hasil Produk</h2>
        <p class="font-body-md text-on-surface-variant dark:text-white/70 max-w-2xl mx-auto">Foto yang tampil di bagian ini berasal dari menu Admin Galeri.</p>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($productGalleries as $gallery): ?>
        <article class="bg-white-warm dark:bg-[#262024] rounded-2xl overflow-hidden border border-soft-beige/30 dark:border-white/10 shadow-sm hover:-translate-y-1 hover:shadow-[0_8px_25px_rgba(121,84,101,0.08)] dark:hover:shadow-none transition-all duration-300">
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