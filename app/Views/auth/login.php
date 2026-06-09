<?= $this->extend('layouts/blank') ?>

<?= $this->section('content') ?>
<main class="min-h-screen flex w-full overflow-x-hidden" style="min-height: 100dvh;">
    <!-- Left Column: Login Form -->
    <div class="w-full lg:w-[45%] xl:w-[42%] flex flex-col justify-center px-6 sm:px-10 md:px-14 lg:px-16 py-10 relative bg-surface overflow-hidden"
         style="padding-bottom: max(2.5rem, env(safe-area-inset-bottom)); padding-top: max(2.5rem, env(safe-area-inset-top));">

        <!-- Decorative soft blobs -->
        <div class="absolute -top-24 -right-24 w-64 h-64 rounded-full pointer-events-none"
             style="background: radial-gradient(circle, rgba(248,200,220,0.45) 0%, transparent 70%); filter: blur(40px);"></div>
        <div class="absolute -bottom-24 -left-24 w-56 h-56 rounded-full pointer-events-none"
             style="background: radial-gradient(circle, rgba(240,189,139,0.35) 0%, transparent 70%); filter: blur(40px);"></div>

        <div class="w-full max-w-sm mx-auto flex flex-col relative z-10 animate__animated animate__fadeInLeft">
            <!-- Back Link -->
            <a class="inline-flex items-center gap-2 text-on-surface-variant hover:text-primary transition-colors text-sm font-semibold mb-10 self-start group" href="<?= base_url('/') ?>">
                <span class="material-symbols-outlined text-[18px] group-hover:-translate-x-1 transition-transform">arrow_back</span>
                Kembali ke Beranda
            </a>

            <!-- Header: Brand -->
            <div class="mb-8">
                <div class="flex items-center gap-2.5 mb-5">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-primary-container to-primary-fixed flex items-center justify-center shadow-sm border border-primary/10">
                        <span class="material-symbols-outlined text-primary text-[20px]" style="font-variation-settings: 'FILL' 1;">featured_seasonal_and_gifts</span>
                    </div>
                    <span class="font-bold text-xl text-primary tracking-tight">Aye Bouquet</span>
                </div>
                <h1 class="text-4xl font-extrabold text-on-background mb-2 tracking-tight">Selamat Datang</h1>
                <p class="text-sm text-on-surface-variant leading-relaxed">Masuk ke akun Anda untuk melanjutkan belanja.</p>
            </div>

            <!-- Form -->
            <form class="flex flex-col gap-4" action="<?= base_url('/login') ?>" method="POST">
                <?= csrf_field() ?>

                <!-- Email Field -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-on-surface-variant tracking-wide" for="email">Email</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-outline group-focus-within:text-primary transition-colors text-[18px] pointer-events-none">mail</span>
                        <input class="w-full pl-11 pr-4 py-3.5 bg-white dark:bg-surface-container border border-outline-variant rounded-xl text-sm text-on-surface placeholder:text-outline/60 transition-all focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 shadow-sm"
                               id="email" name="email" placeholder="Masukkan email" type="text" required>
                    </div>
                </div>

                <!-- Password Field -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-on-surface-variant tracking-wide" for="password">Password</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-outline group-focus-within:text-primary transition-colors text-[18px] pointer-events-none">lock</span>
                        <input class="w-full pl-11 pr-11 py-3.5 bg-white dark:bg-surface-container border border-outline-variant rounded-xl text-sm text-on-surface placeholder:text-outline/60 transition-all focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 shadow-sm"
                               id="password" name="password" placeholder="Masukkan password" type="password" required>
                        <button type="button" onclick="toggleLoginPw(this)" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-outline hover:text-primary transition-colors">
                            <span class="material-symbols-outlined text-[18px]" id="login-pw-eye">visibility</span>
                        </button>
                    </div>
                </div>

                <!-- Submit -->
                <button class="w-full bg-gradient-to-r from-primary to-on-primary-fixed-variant text-on-primary text-sm font-bold py-4 rounded-full mt-2 hover:shadow-xl transition-all shadow-md hover:-translate-y-[2px] duration-200 active:scale-[0.98] flex items-center justify-center gap-2" type="submit">
                    <span class="material-symbols-outlined text-[18px]">login</span>
                    Masuk Sekarang
                </button>
            </form>

            <!-- Registration Link -->
            <div class="mt-7 text-center">
                <p class="text-xs text-on-surface-variant">Belum punya akun?</p>
                <a class="text-sm font-bold text-primary hover:text-on-primary-fixed-variant hover:underline transition-colors mt-1 inline-block" href="<?= base_url('/register') ?>">
                    Daftar Sekarang →
                </a>
            </div>
        </div>
    </div>

    <!-- Right Column: Visual (Hidden on mobile) -->
    <div class="hidden lg:block lg:w-[55%] xl:w-[58%] relative bg-surface-container-low overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0 w-full h-full bg-cover bg-center transition-transform duration-[1200ms] hover:scale-105"
             style="background-image: url('<?= base_url('assets/images/no-image.svg') ?>'); background-size: cover; background-position: center;">
        </div>
        <!-- Gradient overlay -->
        <div class="absolute inset-0 bg-gradient-to-r from-surface via-surface/30 to-transparent"></div>
        <!-- Bottom gradient for badges -->
        <div class="absolute bottom-0 inset-x-0 h-2/3 bg-gradient-to-t from-black/40 via-black/10 to-transparent"></div>

        <!-- Floating brand badge top-right -->
        <div class="absolute top-8 right-8 flex items-center gap-2 bg-white/90 backdrop-blur-md rounded-full px-4 py-2 shadow-lg border border-white/50 animate__animated animate__fadeInDown animate__delay-1s">
            <img src="<?= base_url('assets/images/aye-bouquet-logo.png') ?>" alt="Aye Bouquet Logo" class="w-[18px] h-[18px] object-contain">
            <span class="text-xs font-bold text-primary">Aye Bouquet</span>
        </div>

        <!-- Floating benefit badges bottom -->
        <div class="absolute bottom-10 left-8 right-8 flex flex-col gap-3">
            <div class="flex items-center gap-3 bg-white/85 backdrop-blur-md rounded-2xl px-4 py-3 shadow-lg border border-white/40 w-fit animate__animated animate__fadeInUp animate__delay-1s">
                <div class="w-9 h-9 rounded-full bg-primary-container flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-primary text-[18px]" style="font-variation-settings: 'FILL' 1;">favorite</span>
                </div>
                <div>
                    <p class="text-xs font-bold text-on-surface">Crafted with warmth</p>
                    <p class="text-[10px] text-on-surface-variant">Hadiah dikurasi khusus untuk momen spesial</p>
                </div>
            </div>
            <div class="flex items-center gap-3 bg-white/85 backdrop-blur-md rounded-2xl px-4 py-3 shadow-lg border border-white/40 w-fit animate__animated animate__fadeInUp animate__delay-2s">
                <div class="w-9 h-9 rounded-full bg-tertiary-container flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-tertiary text-[18px]" style="font-variation-settings: 'FILL' 1;">chat</span>
                </div>
                <div>
                    <p class="text-xs font-bold text-on-surface">Pesan via WhatsApp</p>
                    <p class="text-[10px] text-on-surface-variant">Mudah, cepat, dan terpercaya</p>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- SweetAlert Flash Messages -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    <?php if (session()->getFlashdata('success')) : ?>
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '<?= esc(session()->getFlashdata('success')) ?>',
            confirmButtonColor: '#795465',
            confirmButtonText: 'OK',
            timer: 4000,
            timerProgressBar: true,
            customClass: {
                popup: 'swal-custom',
                confirmButton: '!rounded-full !font-semibold !px-6 !py-3 !text-sm',
            },
            showClass: { popup: 'animate__animated animate__fadeInDown animate__faster' },
            hideClass: { popup: 'animate__animated animate__fadeOutUp animate__faster' },
        });
    }
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '<?= esc(session()->getFlashdata('error')) ?>',
            confirmButtonColor: '#795465',
            confirmButtonText: 'Coba Lagi',
            customClass: {
                popup: 'swal-custom',
                confirmButton: '!rounded-full !font-semibold !px-6 !py-3 !text-sm',
            },
            showClass: { popup: 'animate__animated animate__shakeX animate__faster' },
            hideClass: { popup: 'animate__animated animate__fadeOutUp animate__faster' },
        });
    }
    <?php endif; ?>
});

function toggleLoginPw(btn) {
    const input = btn.closest('.relative').querySelector('input[type="password"], input[type="text"]');
    const eye = document.getElementById('login-pw-eye');
    if (input.type === 'password') {
        input.type = 'text';
        eye.textContent = 'visibility_off';
    } else {
        input.type = 'password';
        eye.textContent = 'visibility';
    }
}
</script>

<style>
.swal2-popup.swal-custom {
    border-radius: 1.25rem !important;
    padding: 2rem !important;
    font-family: 'Plus Jakarta Sans', sans-serif !important;
}
.swal2-popup.swal-custom .swal2-title {
    font-weight: 700 !important;
    color: #1b1c1c !important;
}
.swal2-popup.swal-custom .swal2-html-container,
.swal2-popup.swal-custom .swal2-content {
    color: #4f4448 !important;
}
</style>

<?= $this->endSection() ?>
