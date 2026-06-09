<?= $this->extend('admin/layouts/auth') ?>

<?= $this->section('content') ?>
<div class="w-full max-w-md">
    <!-- Brand / Logo Area -->
    <div class="text-center mb-7">
        <!-- Floral icon circle with glow -->
        <div class="relative inline-flex mb-4">
            <div class="absolute inset-0 rounded-full bg-primary/20 blur-xl scale-150 opacity-60"></div>
            <div class="relative w-18 h-18 w-[72px] h-[72px] rounded-full bg-gradient-to-br from-primary-container via-primary-fixed to-primary-fixed-dim flex items-center justify-center shadow-lg border border-primary/20 p-3">
                <img src="<?= base_url('assets/images/aye-bouquet-logo.png') ?>" alt="Aye Bouquet Logo" class="w-full h-full object-contain drop-shadow-md">
            </div>
        </div>
        <h1 class="font-display-lg text-2xl font-extrabold text-primary tracking-tight leading-tight">Aye Bouquet</h1>
        <p class="text-xs font-semibold text-on-surface-variant mt-1 tracking-widest uppercase">Portal Administrasi Sistem</p>
    </div>

    <!-- Login Card -->
    <div class="auth-card-glass rounded-3xl p-7 sm:p-8 relative overflow-hidden">
        <!-- Top accent gradient bar -->
        <div class="absolute top-0 inset-x-0 h-[3px] bg-gradient-to-r from-primary-fixed-dim via-primary to-tertiary-fixed-dim rounded-t-3xl"></div>

        <!-- Floral decoration inside card -->
        <span class="floral-deco" style="bottom:-16px; right:-18px; font-size:110px; transform:rotate(15deg);">🌸</span>

        <!-- Card title -->
        <div class="mb-6">
            <h2 class="text-lg font-bold text-on-surface">Selamat Datang Kembali</h2>
            <p class="text-xs text-on-surface-variant mt-0.5">Masuk ke panel admin Aye Bouquet</p>
        </div>

        <!-- Error Alert -->
        <?php if (!empty($flashError)): ?>
        <div class="mb-5 p-3.5 rounded-2xl bg-error-container/40 border border-error/20 text-error text-xs font-semibold flex items-start gap-2.5">
            <span class="material-symbols-outlined text-base shrink-0 mt-0.5">error</span>
            <span><?= esc($flashError) ?></span>
        </div>
        <?php endif; ?>

        <form action="<?= base_url('admin/login') ?>" method="post" class="space-y-5">
            <?= csrf_field() ?>

            <!-- Email -->
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-on-surface-variant tracking-wide">Email Admin</label>
                <div class="relative flex items-center group">
                    <span class="material-symbols-outlined absolute left-3.5 text-outline group-focus-within:text-primary transition-colors text-[20px] select-none">mail</span>
                    <input type="email" name="email" value="<?= old('email') ?>" placeholder="admin@ayebouquet.com" required autocomplete="email"
                           class="input-focus-ring w-full pl-11 pr-4 py-3 rounded-xl border border-outline-variant/60 bg-white/70 dark:bg-surface-container text-sm text-on-surface placeholder:text-outline/60 transition-all">
                </div>
            </div>

            <!-- Password -->
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-on-surface-variant tracking-wide">Kata Sandi</label>
                <div class="relative flex items-center group">
                    <span class="material-symbols-outlined absolute left-3.5 text-outline group-focus-within:text-primary transition-colors text-[20px] select-none">lock</span>
                    <input type="password" name="password" placeholder="Masukkan password" required autocomplete="current-password"
                           class="input-focus-ring w-full pl-11 pr-11 py-3 rounded-xl border border-outline-variant/60 bg-white/70 dark:bg-surface-container text-sm text-on-surface placeholder:text-outline/60 transition-all">
                    <button type="button" onclick="togglePassword(this)" class="absolute right-3.5 text-outline hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[20px]" id="pw-eye">visibility</span>
                    </button>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                    class="btn-lift w-full bg-gradient-to-r from-primary to-on-primary-fixed-variant text-on-primary py-3.5 rounded-full font-bold text-sm shadow-md transition-all flex items-center justify-center gap-2 mt-2">
                <span class="material-symbols-outlined text-[18px]">login</span>
                Masuk ke Dashboard
            </button>
        </form>
    </div>

    <!-- Back to shop link -->
    <div class="text-center mt-5">
        <a href="<?= base_url('/') ?>" class="inline-flex items-center gap-1.5 text-xs text-on-surface-variant hover:text-primary font-semibold transition-colors group">
            <span class="material-symbols-outlined text-sm group-hover:-translate-x-1 transition-transform">arrow_back</span>
            Kembali ke Halaman Utama
        </a>
    </div>

    <!-- Copyright -->
    <p class="text-center text-[10px] text-on-surface-variant/50 mt-4">© <?= date('Y') ?> Aye Bouquet. All rights reserved.</p>
</div>

<script>
function togglePassword(btn) {
    const input = btn.closest('.relative').querySelector('input[type="password"], input[type="text"]');
    const eye   = document.getElementById('pw-eye');
    if (input.type === 'password') {
        input.type = 'text';
        eye.textContent = 'visibility_off';
    } else {
        input.type = 'password';
        eye.textContent = 'visibility';
    }
}
</script>
<?= $this->endSection() ?>
