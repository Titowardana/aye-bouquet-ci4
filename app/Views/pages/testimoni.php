<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<style>
    .rating-star {
        transition: color 0.15s ease, transform 0.15s ease;
        cursor: pointer;
    }
    .rating-star:hover { transform: scale(1.2); }
</style>

<!-- Flash Messages -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="max-w-2xl mx-auto mt-8 px-container-padding-mobile md:px-container-padding-desktop animate__animated animate__fadeIn">
        <div class="px-5 py-4 rounded-xl bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700/30 text-green-800 dark:text-green-300 font-body-md text-sm flex items-start gap-3">
            <span class="material-symbols-outlined text-green-500 dark:text-green-400 mt-0.5 flex-shrink-0" style="font-size:20px">check_circle</span>
            <span><?= esc(session()->getFlashdata('success')) ?></span>
        </div>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('errors')): ?>
    <div class="max-w-2xl mx-auto mt-8 px-container-padding-mobile md:px-container-padding-desktop animate__animated animate__fadeIn">
        <div class="px-5 py-4 rounded-xl bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700/30 text-red-800 dark:text-red-300 font-body-md text-sm flex items-start gap-3">
            <span class="material-symbols-outlined text-red-500 dark:text-red-400 mt-0.5 flex-shrink-0" style="font-size:20px">error</span>
            <ul class="list-disc list-inside">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
<?php endif; ?>

<!-- Submission Form -->
<div class="flex items-center justify-center py-12 md:py-16 px-container-padding-mobile md:px-container-padding-desktop animate-on-scroll">
    <div class="w-full max-w-2xl bg-white dark:bg-[#262024] rounded-xl shadow-[0_4px_20px_rgba(121,84,101,0.05)] dark:shadow-none p-8 md:p-12 card-hover">
        <div class="text-center mb-10">
            <h1 class="font-headline-lg text-2xl md:text-3xl font-bold text-primary dark:text-primary-fixed-dim mb-4">Bagikan Kebahagiaan Anda</h1>
            <p class="font-body-md text-base text-on-surface-variant dark:text-white/70">Ceritakan pengalaman manis Anda bersama kami. Testimoni Anda sangat berarti untuk membantu kami menyebarkan lebih banyak kebahagiaan.</p>
        </div>
        <form class="space-y-8" action="<?= base_url('/testimoni') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <!-- Rating -->
            <div class="flex flex-col items-center gap-3">
                <label class="font-label-md text-sm font-bold text-on-surface dark:text-white/80">Penilaian Anda</label>
                <div id="ratingWrapper" class="flex justify-center gap-2">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                    <button type="button" class="rating-star text-4xl <?= old('rating') && (int)old('rating') >= $i ? 'text-primary' : 'text-gray-300 dark:text-white/20' ?>" data-rating="<?= $i ?>" aria-label="<?= $i ?> bintang">&#9733;</button>
                    <?php endfor; ?>
                    <input type="hidden" name="rating" id="ratingInput" value="<?= old('rating') ?>">
                </div>
            </div>

            <!-- Review Textarea -->
            <div>
                <label class="block font-label-md text-sm font-bold text-on-surface dark:text-white/80 mb-2" for="review">Ulasan Anda</label>
                <textarea class="w-full bg-surface-container-low dark:bg-white/5 border border-surface-variant dark:border-white/15 rounded-lg p-4 font-body-md text-base text-on-surface dark:text-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary-container transition-all resize-none placeholder:text-on-surface-variant/50 dark:placeholder:text-white/40" id="review" name="review" placeholder="Tuliskan pengalaman Anda di sini..." rows="4"><?= old('review') ?></textarea>
            </div>

            <!-- Image Upload -->
            <div>
                <label class="block font-label-md text-sm font-bold text-on-surface dark:text-white/80 mb-2">Unggah Foto (Opsional)</label>
                <div class="border-2 border-dashed border-outline-variant dark:border-white/15 rounded-lg p-8 flex flex-col items-center justify-center text-center bg-surface-container-low dark:bg-white/5 hover:bg-surface-container dark:hover:bg-white/10 transition-colors cursor-pointer group">
                    <span class="material-symbols-outlined text-outline dark:text-white/40 text-4xl mb-3 group-hover:text-primary dark:group-hover:text-primary-fixed-dim transition-colors">cloud_upload</span>
                    <p class="font-body-md text-base text-on-surface-variant dark:text-white/70 mb-2">Tarik dan lepas foto ke sini, atau</p>
                    <button class="font-label-md text-sm font-bold text-primary dark:text-primary-fixed-dim bg-primary-container/30 dark:bg-primary/20 px-4 py-2 rounded-full hover:bg-primary-container dark:hover:bg-primary/30 transition-colors" type="button" onclick="document.getElementById('foto_upload').click()">Pilih Foto</button>
                    <p class="font-label-sm text-xs text-outline dark:text-white/40 mt-3">Format didukung: JPG, PNG. Maks ukuran 5MB.</p>
                    <input id="foto_upload" accept="image/*" class="hidden" name="foto" type="file">
                </div>
            </div>

            <!-- Personal Info Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block font-label-md text-sm font-bold text-on-surface dark:text-white/80 mb-2" for="name">Nama Lengkap</label>
                    <input class="w-full bg-surface-container-low dark:bg-white/5 border border-surface-variant dark:border-white/15 rounded-lg p-3 font-body-md text-base text-on-surface dark:text-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary-container transition-all placeholder:text-on-surface-variant/50 dark:placeholder:text-white/40" id="name" name="name" placeholder="Cth: Jane Doe" type="text" value="<?= old('name') ?>" required>
                </div>
                <div>
                    <label class="block font-label-md text-sm font-bold text-on-surface dark:text-white/80 mb-2" for="city">Kota Asal</label>
                    <input class="w-full bg-surface-container-low dark:bg-white/5 border border-surface-variant dark:border-white/15 rounded-lg p-3 font-body-md text-base text-on-surface dark:text-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary-container transition-all placeholder:text-on-surface-variant/50 dark:placeholder:text-white/40" id="city" name="city" placeholder="Cth: Jakarta Selatan" type="text" value="<?= old('city') ?>">
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4">
                <button class="w-full bg-primary text-on-primary font-label-md text-sm font-bold py-4 rounded-full hover:bg-surface-tint hover:shadow-md transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-primary-container" type="submit">
                    Kirim Testimoni
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Approved Testimonials List -->
<?php if (!empty($testimonials)): ?>
<section class="py-12 md:py-16 px-container-padding-mobile md:px-container-padding-desktop animate-on-scroll bg-surface-container-low/30 dark:bg-[#1f1b1d]">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-12">
            <h2 class="font-headline-lg text-3xl md:text-4xl text-on-surface dark:text-white/95 mb-4 font-bold tracking-tight">Testimoni Pelanggan</h2>
            <p class="font-body-md text-sm md:text-base text-on-surface-variant dark:text-white/60 max-w-md mx-auto">Apa kata mereka yang telah mempercayakan kebahagiaannya di Aye Bouquet.</p>
            <?php if ($totalCount > 0): ?>
            <div class="mt-4 flex items-center justify-center gap-2 text-on-surface-variant dark:text-white/60">
                <span class="material-symbols-outlined text-primary dark:text-primary-fixed-dim" style="font-variation-settings: 'FILL' 1">star</span>
                <span class="font-label-md font-bold text-primary dark:text-primary-fixed-dim"><?= number_format($avgRating, 1) ?></span>
                <span class="text-sm dark:text-white/60">dari <?= $totalCount ?> ulasan</span>
            </div>
            <?php endif; ?>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" data-stagger>
            <?php foreach ($testimonials as $testimonial): ?>
            <div class="bg-surface dark:bg-[#262024] rounded-2xl p-8 soft-shadow border border-surface-container dark:border-white/10 flex flex-col justify-between hover:border-primary/20 transition-all duration-300 group animate-on-scroll">
                <div>
                    <div class="flex gap-1 mb-4 text-primary dark:text-primary-fixed-dim">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' <?= $i <= (int)$testimonial['rating'] ? 1 : 0 ?>">star</span>
                        <?php endfor; ?>
                    </div>
                    <p class="font-body-md text-on-surface dark:text-white/90 mb-6 italic leading-relaxed text-sm md:text-base">"<?= esc($testimonial['message']) ?>"</p>
                    <?php if (!empty($testimonial['photo']) && file_exists(FCPATH . 'uploads/testimonials/' . $testimonial['photo'])): ?>
                    <div class="mt-4 flex justify-center">
                        <button type="button" class="testimonial-image-trigger group" data-image="<?= base_url('uploads/testimonials/' . $testimonial['photo']) ?>" data-name="<?= esc($testimonial['customer_name'], 'attr') ?>">
                            <img src="<?= base_url('uploads/testimonials/' . $testimonial['photo']) ?>" alt="Foto <?= esc($testimonial['customer_name']) ?>" class="w-32 h-32 object-cover rounded-2xl border border-primary/10 dark:border-white/10 shadow-sm group-hover:scale-105 transition duration-300 cursor-pointer">
                        </button>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="flex items-center gap-4 border-t border-surface-container dark:border-white/10 pt-4 mt-2">
                    <div class="w-12 h-12 rounded-full bg-primary-container dark:bg-primary/25 flex items-center justify-center text-primary dark:text-primary-fixed-dim font-bold shadow-inner group-hover:scale-105 transition-transform duration-300">
                        <?= strtoupper(substr(esc($testimonial['customer_name']), 0, 1)) ?>
                    </div>
                    <div>
                        <h4 class="font-label-md text-on-surface dark:text-white/90 font-bold text-sm"><?= esc($testimonial['customer_name']) ?></h4>
                        <p class="text-xs text-on-surface-variant dark:text-white/60"><?= !empty($testimonial['city']) ? esc($testimonial['city']) : 'Pelanggan Setia' ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var stars = document.querySelectorAll('.rating-star');
    var ratingInput = document.getElementById('ratingInput');
    var selectedRating = ratingInput && ratingInput.value ? parseInt(ratingInput.value) : 0;

    function paintStars(value) {
        stars.forEach(function (star) {
            var starValue = parseInt(star.dataset.rating);
            star.classList.remove('dark:text-white/20');
            if (starValue <= value) {
                star.classList.remove('text-gray-300');
                star.classList.add('text-primary');
            } else {
                star.classList.remove('text-primary');
                star.classList.add('text-gray-300');
                star.classList.add('dark:text-white/20');
            }
        });
    }

    stars.forEach(function (star) {
        star.addEventListener('click', function () {
            selectedRating = parseInt(this.dataset.rating);
            ratingInput.value = selectedRating;
            paintStars(selectedRating);
        });
        star.addEventListener('mouseenter', function () {
            paintStars(parseInt(this.dataset.rating));
        });
    });

    var ratingWrapper = document.getElementById('ratingWrapper');
    if (ratingWrapper) {
        ratingWrapper.addEventListener('mouseleave', function () {
            paintStars(selectedRating);
        });
    }

    paintStars(selectedRating);
});
</script>
<?= $this->endSection() ?>
