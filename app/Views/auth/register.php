<?= $this->extend('layouts/blank') ?>

<?= $this->section('content') ?>
<div class="flex flex-col md:flex-row min-h-screen overflow-x-hidden" style="min-height: 100dvh;">
    <!-- Form Section (Left on Desktop, Full on Mobile) -->
    <div class="w-full md:w-1/2 flex flex-col justify-center items-center px-6 sm:px-10 md:px-12 lg:px-16 relative bg-surface overflow-hidden"
         style="padding-top: max(2.5rem, env(safe-area-inset-top)); padding-bottom: max(2.5rem, env(safe-area-inset-bottom));">

        <!-- Decorative blobs -->
        <div class="absolute -top-24 -right-20 w-64 h-64 rounded-full pointer-events-none"
             style="background: radial-gradient(circle, rgba(248,200,220,0.45) 0%, transparent 70%); filter: blur(40px);"></div>
        <div class="absolute -bottom-20 -left-20 w-56 h-56 rounded-full pointer-events-none"
             style="background: radial-gradient(circle, rgba(240,189,139,0.35) 0%, transparent 70%); filter: blur(40px);"></div>

        <div class="w-full max-w-md relative z-10 animate__animated animate__fadeInLeft py-6">
            <!-- Brand Logo -->
            <div class="flex items-center gap-2.5 mb-8">
                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-primary-container to-primary-fixed flex items-center justify-center shadow-sm border border-primary/10">
                    <span class="material-symbols-outlined text-primary text-[20px]" style="font-variation-settings: 'FILL' 1;">card_giftcard</span>
                </div>
                <span class="font-bold text-xl text-primary tracking-tight">Aye Bouquet</span>
            </div>

            <!-- Header -->
            <div class="mb-7">
                <h1 class="text-3xl font-extrabold text-on-surface mb-2 tracking-tight">Daftar Akun</h1>
                <p class="text-sm text-on-surface-variant leading-relaxed">Bergabunglah untuk pengalaman memberikan hadiah yang tak terlupakan.</p>
            </div>

            <!-- Registration Form -->
            <form class="space-y-4" action="<?= base_url('/register') ?>" method="POST">
                <?= csrf_field() ?>

                <!-- Nama Lengkap -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-on-surface-variant tracking-wide" for="fullName">Nama Lengkap</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-outline group-focus-within:text-primary transition-colors text-[18px] pointer-events-none">person</span>
                        <input class="w-full pl-11 pr-4 py-3.5 bg-white dark:bg-surface-container border border-outline-variant rounded-xl text-sm text-on-surface placeholder:text-outline/60 transition-all focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 shadow-sm"
                               id="fullName" name="name" placeholder="Masukkan nama lengkap" type="text" required>
                    </div>
                </div>

                <!-- Nomor HP -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-on-surface-variant tracking-wide" for="phone">Nomor HP</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-outline group-focus-within:text-primary transition-colors text-[18px] pointer-events-none">phone</span>
                        <input class="w-full pl-11 pr-4 py-3.5 bg-white dark:bg-surface-container border border-outline-variant rounded-xl text-sm text-on-surface placeholder:text-outline/60 transition-all focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 shadow-sm"
                               id="phone" name="phone" placeholder="Masukkan nomor HP" type="tel" required>
                    </div>
                </div>

                <!-- Email -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-on-surface-variant tracking-wide" for="email">Email</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-outline group-focus-within:text-primary transition-colors text-[18px] pointer-events-none">mail</span>
                        <input class="w-full pl-11 pr-4 py-3.5 bg-white dark:bg-surface-container border border-outline-variant rounded-xl text-sm text-on-surface placeholder:text-outline/60 transition-all focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 shadow-sm"
                               id="email" name="email" placeholder="Masukkan email" type="email" required>
                    </div>
                </div>

                <!-- Password -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-on-surface-variant tracking-wide" for="password">Password</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-outline group-focus-within:text-primary transition-colors text-[18px] pointer-events-none">lock</span>
                        <input class="w-full pl-11 pr-11 py-3.5 bg-white dark:bg-surface-container border border-outline-variant rounded-xl text-sm text-on-surface placeholder:text-outline/60 transition-all focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 shadow-sm"
                               id="password" name="password" placeholder="Buat password" type="password" required>
                        <button class="absolute right-3.5 top-1/2 -translate-y-1/2 text-outline hover:text-primary transition-colors" type="button"
                                onclick="toggleRegPw(this, 'reg-pw-eye')">
                            <span class="material-symbols-outlined text-[18px]" id="reg-pw-eye">visibility</span>
                        </button>
                    </div>
                </div>

                <!-- Konfirmasi Password -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-on-surface-variant tracking-wide" for="confirmPassword">Konfirmasi Password</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-outline group-focus-within:text-primary transition-colors text-[18px] pointer-events-none">lock_reset</span>
                        <input class="w-full pl-11 pr-11 py-3.5 bg-white dark:bg-surface-container border border-outline-variant rounded-xl text-sm text-on-surface placeholder:text-outline/60 transition-all focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 shadow-sm"
                               id="confirmPassword" name="password_confirm" placeholder="Ulangi password" type="password" required>
                        <button class="absolute right-3.5 top-1/2 -translate-y-1/2 text-outline hover:text-primary transition-colors" type="button"
                                onclick="toggleRegPw(this, 'reg-pw-confirm-eye')">
                            <span class="material-symbols-outlined text-[18px]" id="reg-pw-confirm-eye">visibility</span>
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <button class="w-full bg-gradient-to-r from-primary to-on-primary-fixed-variant text-on-primary text-sm font-bold py-4 rounded-full mt-2 hover:shadow-xl transition-all shadow-md hover:-translate-y-[2px] duration-200 active:scale-[0.98] flex justify-center items-center gap-2" type="submit">
                    Daftar Sekarang
                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </button>
            </form>

            <!-- Footer Links -->
            <div class="mt-7 flex flex-col items-center gap-3">
                <div class="flex items-center gap-1 text-sm text-on-surface-variant">
                    <span>Sudah punya akun?</span>
                    <a class="font-bold text-primary hover:text-on-primary-fixed-variant hover:underline transition-colors ml-1" href="<?= base_url('/login') ?>">
                        Login disini
                    </a>
                </div>
                <a class="text-xs font-semibold text-outline hover:text-primary transition-colors flex items-center gap-1 group" href="<?= base_url('/') ?>">
                    <span class="material-symbols-outlined text-sm group-hover:-translate-x-1 transition-transform">arrow_back</span>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>

    <!-- Illustration Section (Right on Desktop) -->
    <div class="hidden md:flex w-1/2 bg-surface-container-low relative overflow-hidden items-center justify-center">
        <!-- Soft orbs -->
        <div class="absolute top-[-10%] right-[-10%] w-[500px] h-[500px] bg-primary-container rounded-full mix-blend-multiply filter blur-[80px] opacity-50 animate__animated animate__pulse animate__infinite animate__slow"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-[400px] h-[400px] bg-tertiary-container rounded-full mix-blend-multiply filter blur-[80px] opacity-50 animate__animated animate__pulse animate__infinite animate__slow" style="animation-delay: 2s;"></div>

        <!-- Image Container -->
        <div class="relative z-10 w-3/4 max-w-lg aspect-[4/5] rounded-3xl overflow-hidden shadow-[0_24px_60px_-12px_rgba(121,84,101,0.25)] bg-surface transform transition-transform hover:scale-[1.015] duration-500">
            <img class="w-full h-full object-cover" src="<?= base_url('assets/images/no-image.svg') ?>" alt="Aye Bouquet">
            <!-- Bottom gradient -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>

            <!-- Glassmorphism benefit card -->
            <div class="absolute bottom-6 left-5 right-5 p-4 rounded-2xl bg-white/80 backdrop-blur-md border border-white/50 shadow-lg flex items-center gap-3 animate__animated animate__fadeInUp animate__delay-1s">
                <div class="w-11 h-11 rounded-full bg-primary-container flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">favorite</span>
                </div>
                <div>
                    <p class="text-xs font-bold text-on-surface mb-0.5">Crafted with warmth</p>
                    <p class="text-[10px] text-on-surface-variant leading-snug">Setiap hadiah dikurasi khusus untuk orang terkasih.</p>
                </div>
            </div>
        </div>

        <!-- Top-right floating benefit badge -->
        <div class="absolute top-8 right-8 flex items-center gap-2 bg-white/90 backdrop-blur-md rounded-full px-4 py-2 shadow-md border border-white/50 animate__animated animate__fadeInDown animate__delay-1s">
            <img src="<?= base_url('assets/images/aye-bouquet-logo.png') ?>" alt="Logo" class="w-[16px] h-[16px] object-contain">
            <span class="text-xs font-bold text-primary">Gift yang bermakna</span>
        </div>
    </div>
</div>

<!-- SweetAlert Flash Messages -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    <?php if (session()->getFlashdata('errors')) : ?>
    if (typeof Swal !== 'undefined') {
        let errorHtml = '<ul style="text-align:left;margin:0;padding-left:1.2em;">';
        <?php foreach (session()->getFlashdata('errors') as $error) : ?>
        errorHtml += '<li style="margin-bottom:4px;"><?= esc($error) ?></li>';
        <?php endforeach; ?>
        errorHtml += '</ul>';

        Swal.fire({
            icon: 'warning',
            title: 'Pendaftaran Gagal',
            html: errorHtml,
            confirmButtonColor: '#795465',
            confirmButtonText: 'Perbaiki',
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

function toggleRegPw(btn, eyeId) {
    const input = btn.closest('.relative').querySelector('input[type="password"], input[type="text"]');
    const eye = document.getElementById(eyeId);
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
