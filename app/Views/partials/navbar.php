<?php $activeMenu = $activeMenu ?? ''; $cartBadgeCount = session_cart_badge_count(); ?>
<style>
    /* Mobile menu managed by style.css animations */
    
    /* Icon scale-up animation */
    .icon-anim {
        transition: transform 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275), color 0.25s ease, background-color 0.2s ease;
    }
    .icon-anim:hover {
        transform: scale(1.15) translateY(-1px);
    }
    .icon-anim:active {
        transform: scale(0.95);
    }

    /* Navbar Link Pill (Kotak-kotak) Animation */
    .nav-pill {
        transition: all 0.2s ease-in-out;
    }
    .nav-pill:active {
        transform: scale(0.92);
    }
</style>

<!-- Dark Mode Toggle Script -->
<script>
    // Cek preferensi awal
    if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }

    function toggleDarkMode() {
        if (document.documentElement.classList.contains('dark')) {
            document.documentElement.classList.remove('dark');
            localStorage.theme = 'light';
        } else {
            document.documentElement.classList.add('dark');
            localStorage.theme = 'dark';
        }
        updateThemeIcon();
    }

    function updateThemeIcon() {
        const iconElement = document.getElementById('theme-icon');
        if(iconElement) {
            if (document.documentElement.classList.contains('dark')) {
                iconElement.innerText = 'light_mode'; // Munculkan matahari saat gelap
            } else {
                iconElement.innerText = 'dark_mode'; // Munculkan bulan saat terang
            }
        }
    }
    
    // Set icon saat load
    document.addEventListener('DOMContentLoaded', updateThemeIcon);
</script>

<!-- Navbar -->
<!-- Background warna yang bagus sesuai tema (misal putih tulang / surface terang di light mode) -->
<header class="bg-surface-container-lowest/95 dark:bg-inverse-surface/95 backdrop-blur-md docked w-full top-0 sticky shadow-md z-50 border-b border-outline-variant/10">
    <div class="flex justify-between items-center w-full px-6 md:px-12 lg:px-16 h-20">
        <!-- Brand & Logo on the extreme left -->
        <a class="flex items-center gap-3 group" href="<?= base_url('/') ?>">
            <!-- Slot untuk Logo Anda -->
            <div class="w-10 h-10 rounded-full bg-primary/10 dark:bg-primary-fixed-dim/20 flex items-center justify-center overflow-hidden border border-primary/20 transition-transform group-hover:scale-105 group-active:scale-95">
                <img src="<?= base_url('assets/images/aye-bouquet-logo.png') ?>" alt="Aye Bouquet Logo" class="w-full h-full object-contain p-0.5">
            </div>
            
            <span class="font-headline-md text-headline-md-mobile md:text-headline-md text-primary dark:text-primary-fixed-dim tracking-tight font-extrabold text-xl md:text-2xl group-hover:opacity-90 transition-opacity">
                Aye Bouquet
            </span>
        </a>
        
        <!-- Desktop Nav in the middle -->
        <nav class="hidden lg:flex items-center gap-2">
            <a class="nav-pill px-4 py-2 rounded-xl font-label-md text-sm transition-colors <?= $activeMenu === 'home' ? 'bg-primary/10 text-primary dark:bg-primary-fixed-dim/15 dark:text-primary-fixed-dim font-bold shadow-sm' : 'text-on-surface-variant dark:text-surface-variant hover:bg-surface-variant/50 dark:hover:bg-surface-dim hover:text-primary dark:hover:text-primary-fixed-dim font-semibold' ?>" href="<?= base_url('/') ?>">Beranda</a>
            
            <a class="nav-pill px-4 py-2 rounded-xl font-label-md text-sm transition-colors <?= $activeMenu === 'catalog' ? 'bg-primary/10 text-primary dark:bg-primary-fixed-dim/15 dark:text-primary-fixed-dim font-bold shadow-sm' : 'text-on-surface-variant dark:text-surface-variant hover:bg-surface-variant/50 dark:hover:bg-surface-dim hover:text-primary dark:hover:text-primary-fixed-dim font-semibold' ?>" href="<?= base_url('/katalog') ?>">Katalog</a>
            
            <a class="nav-pill px-4 py-2 rounded-xl font-label-md text-sm transition-colors <?= $activeMenu === 'custom-order' ? 'bg-primary/10 text-primary dark:bg-primary-fixed-dim/15 dark:text-primary-fixed-dim font-bold shadow-sm' : 'text-on-surface-variant dark:text-surface-variant hover:bg-surface-variant/50 dark:hover:bg-surface-dim hover:text-primary dark:hover:text-primary-fixed-dim font-semibold' ?>" href="<?= base_url('/custom-order') ?>">Custom Order</a>
            
            <a class="nav-pill px-4 py-2 rounded-xl font-label-md text-sm transition-colors <?= $activeMenu === 'testimoni' ? 'bg-primary/10 text-primary dark:bg-primary-fixed-dim/15 dark:text-primary-fixed-dim font-bold shadow-sm' : 'text-on-surface-variant dark:text-surface-variant hover:bg-surface-variant/50 dark:hover:bg-surface-dim hover:text-primary dark:hover:text-primary-fixed-dim font-semibold' ?>" href="<?= base_url('/testimoni') ?>">Testimoni</a>
            
            <a class="nav-pill px-4 py-2 rounded-xl font-label-md text-sm transition-colors <?= $activeMenu === 'tentang' ? 'bg-primary/10 text-primary dark:bg-primary-fixed-dim/15 dark:text-primary-fixed-dim font-bold shadow-sm' : 'text-on-surface-variant dark:text-surface-variant hover:bg-surface-variant/50 dark:hover:bg-surface-dim hover:text-primary dark:hover:text-primary-fixed-dim font-semibold' ?>" href="<?= base_url('/tentang') ?>">Tentang Kami</a>
            
            <a class="nav-pill px-4 py-2 rounded-xl font-label-md text-sm transition-colors <?= $activeMenu === 'kontak' ? 'bg-primary/10 text-primary dark:bg-primary-fixed-dim/15 dark:text-primary-fixed-dim font-bold shadow-sm' : 'text-on-surface-variant dark:text-surface-variant hover:bg-surface-variant/50 dark:hover:bg-surface-dim hover:text-primary dark:hover:text-primary-fixed-dim font-semibold' ?>" href="<?= base_url('/kontak') ?>">Kontak</a>
        </nav>

        <!-- Action Icons on the extreme right -->
        <div class="flex items-center gap-3">
            <!-- Theme Toggle -->
            <button onclick="toggleDarkMode()" class="text-primary dark:text-primary-fixed-dim hover:bg-primary/10 dark:hover:bg-primary-fixed-dim/20 p-2.5 rounded-full transition-all icon-anim flex items-center justify-center" aria-label="Toggle Dark Mode">
                <span id="theme-icon" class="material-symbols-outlined font-semibold" style="font-size: 24px;">dark_mode</span>
            </button>
            
            <!-- Cart Icon with badge (hidden when admin-only mode) -->
            <?php if (!session()->get('admin_logged_in') || session()->get('logged_in')): ?>
            <button onclick="handleCartClick()" class="relative text-primary dark:text-primary-fixed-dim hover:bg-primary/10 dark:hover:bg-primary-fixed-dim/20 p-2.5 rounded-full transition-all icon-anim flex items-center justify-center" aria-label="Keranjang" id="cart-btn">
                <span class="material-symbols-outlined font-semibold" style="font-size: 24px;">shopping_cart</span>
                <?php if (session()->get('logged_in')): ?>
                <span class="absolute top-1 right-1 w-4 h-4 bg-primary dark:bg-primary-fixed-dim text-on-primary dark:text-on-primary-fixed text-[9px] font-extrabold rounded-full flex items-center justify-center shadow-sm leading-none border border-surface-container-lowest" id="cart-badge"><?= (int) $cartBadgeCount ?></span>
                <?php endif; ?>
            </button>
            <?php endif; ?>
            
            <!-- Account Icon -->
            <?php if (session()->get('logged_in')): ?>
            <div class="relative" id="account-dropdown-wrapper">
                <button onclick="toggleAccountDropdown()" class="text-primary dark:text-primary-fixed-dim hover:bg-primary/10 dark:hover:bg-primary-fixed-dim/20 p-2.5 rounded-full transition-all icon-anim flex items-center justify-center" aria-label="Akun" id="account-btn">
                    <span class="material-symbols-outlined font-semibold" style="font-size: 24px; font-variation-settings: 'FILL' 1;">account_circle</span>
                </button>
                <div id="account-dropdown" class="hidden absolute right-0 top-14 w-56 bg-surface-container-lowest dark:bg-inverse-surface rounded-2xl shadow-xl border border-outline-variant/20 overflow-hidden z-50 animate-dropdown">
                    <div class="px-4 py-3 border-b border-outline-variant/10">
                        <p class="text-sm font-bold text-on-surface dark:text-inverse-on-surface truncate"><?= esc(session()->get('user_name')) ?></p>
                        <p class="text-xs text-on-surface-variant truncate"><?= esc(session()->get('user_email')) ?></p>
                    </div>
                    <form action="<?= base_url('/logout') ?>" method="POST" class="block">
                        <?= csrf_field() ?>
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-sm text-error hover:bg-error-container/30 transition-colors">
                            <span class="material-symbols-outlined text-lg">logout</span>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
            <?php elseif (session()->get('admin_logged_in')): ?>
            <div class="flex items-center gap-1.5 sm:gap-2 bg-primary/10 dark:bg-primary-fixed-dim/20 px-2 sm:px-3 py-1 sm:py-1.5 rounded-full border border-primary/20 max-w-[150px] sm:max-w-none">
                <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-error animate-pulse flex-shrink-0" title="Admin Active"></span>
                <span class="text-[10px] sm:text-xs font-bold text-primary dark:text-primary-fixed-dim hidden sm:inline">Mode Admin</span>
                <span class="text-[10px] font-bold text-primary dark:text-primary-fixed-dim sm:hidden">Admin</span>
                <a href="<?= base_url('/admin') ?>" class="text-[9px] sm:text-[10px] font-bold bg-primary text-on-primary px-2 py-0.5 sm:py-1 rounded-full hover:bg-on-primary-fixed-variant transition-colors ml-0.5 sm:ml-1 shadow-sm whitespace-nowrap">
                    Kembali
                </a>
            </div>
            <?php else: ?>
            <a href="<?= base_url('/login') ?>" class="text-primary dark:text-primary-fixed-dim hover:bg-primary/10 dark:hover:bg-primary-fixed-dim/20 p-2.5 rounded-full transition-all icon-anim flex items-center justify-center" aria-label="Akun">
                <span class="material-symbols-outlined font-semibold" style="font-size: 24px;">account_circle</span>
            </a>
            <?php endif; ?>
            
            <!-- Mobile Menu Toggle -->
            <button id="mobileMenuButton" class="lg:hidden text-primary dark:text-primary-fixed-dim p-2.5 rounded-full hover:bg-primary/10 dark:hover:bg-primary-fixed-dim/20 transition-all icon-anim flex items-center justify-center flex-shrink-0" aria-label="Buka menu">
                <span id="mobileMenuIcon" class="material-symbols-outlined font-semibold" style="font-size: 24px; transition: transform 0.2s;">menu</span>
            </button>
        </div>
    </div>
    
    <!-- Mobile Nav Menu -->
    <div id="mobileMenu"
         class="hidden lg:hidden fixed left-0 right-0 top-20 z-[9999] bg-surface-container-lowest/95 dark:bg-inverse-surface/95 backdrop-blur-xl border-t border-outline-variant/30 shadow-xl overflow-y-auto max-h-[calc(100vh-80px)]">
        <nav class="px-6 py-5 space-y-2">
            <a href="<?= base_url('/') ?>" class="block px-4 py-3 rounded-2xl font-semibold transition <?= $activeMenu === 'home' ? 'bg-primary/10 text-primary dark:bg-primary-fixed-dim/15 dark:text-primary-fixed-dim font-bold' : 'text-on-surface-variant hover:bg-primary/10 hover:text-primary dark:text-surface-variant dark:hover:bg-surface-dim dark:hover:text-primary-fixed-dim' ?>">Beranda</a>
            
            <a href="<?= base_url('/katalog') ?>" class="block px-4 py-3 rounded-2xl font-semibold transition <?= $activeMenu === 'catalog' ? 'bg-primary/10 text-primary dark:bg-primary-fixed-dim/15 dark:text-primary-fixed-dim font-bold' : 'text-on-surface-variant hover:bg-primary/10 hover:text-primary dark:text-surface-variant dark:hover:bg-surface-dim dark:hover:text-primary-fixed-dim' ?>">Katalog</a>
            
            <a href="<?= base_url('/custom-order') ?>" class="block px-4 py-3 rounded-2xl font-semibold transition <?= $activeMenu === 'custom-order' ? 'bg-primary/10 text-primary dark:bg-primary-fixed-dim/15 dark:text-primary-fixed-dim font-bold' : 'text-on-surface-variant hover:bg-primary/10 hover:text-primary dark:text-surface-variant dark:hover:bg-surface-dim dark:hover:text-primary-fixed-dim' ?>">Custom Order</a>
            
            <a href="<?= base_url('/testimoni') ?>" class="block px-4 py-3 rounded-2xl font-semibold transition <?= $activeMenu === 'testimoni' ? 'bg-primary/10 text-primary dark:bg-primary-fixed-dim/15 dark:text-primary-fixed-dim font-bold' : 'text-on-surface-variant hover:bg-primary/10 hover:text-primary dark:text-surface-variant dark:hover:bg-surface-dim dark:hover:text-primary-fixed-dim' ?>">Testimoni</a>
            
            <a href="<?= base_url('/tentang') ?>" class="block px-4 py-3 rounded-2xl font-semibold transition <?= $activeMenu === 'tentang' ? 'bg-primary/10 text-primary dark:bg-primary-fixed-dim/15 dark:text-primary-fixed-dim font-bold' : 'text-on-surface-variant hover:bg-primary/10 hover:text-primary dark:text-surface-variant dark:hover:bg-surface-dim dark:hover:text-primary-fixed-dim' ?>">Tentang Kami</a>
            
            <a href="<?= base_url('/kontak') ?>" class="block px-4 py-3 rounded-2xl font-semibold transition <?= $activeMenu === 'kontak' ? 'bg-primary/10 text-primary dark:bg-primary-fixed-dim/15 dark:text-primary-fixed-dim font-bold' : 'text-on-surface-variant hover:bg-primary/10 hover:text-primary dark:text-surface-variant dark:hover:bg-surface-dim dark:hover:text-primary-fixed-dim' ?>">Kontak</a>
        </nav>
    </div>
</header>

<style>
    /* Dropdown animation */
    @keyframes dropdownSlide {
        from { opacity: 0; transform: translateY(-10px) scale(0.95); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }
    .animate-dropdown { animation: dropdownSlide 0.2s ease-out forwards; }

    /* SweetAlert custom styles */
    .swal2-popup.swal-custom {
        border-radius: 1.25rem !important;
        padding: 2rem !important;
    }
    .swal2-popup.swal-custom .swal2-title {
        font-family: 'Plus Jakarta Sans', sans-serif !important;
        font-weight: 700 !important;
        color: #1b1c1c !important;
    }
    .swal2-popup.swal-custom .swal2-html-container {
        font-family: 'Plus Jakarta Sans', sans-serif !important;
        color: #4f4448 !important;
    }
</style>

<script>
// Global login state
const isLoggedIn = <?= session()->get('logged_in') ? 'true' : 'false' ?>;
const cartUrl    = '<?= base_url('/keranjang') ?>';
const loginUrl   = '<?= base_url('/login') ?>';

function handleCartClick() {
    if (isLoggedIn) {
        window.location.href = cartUrl;
        return;
    }

    // Beautiful SweetAlert animation for non-logged-in users
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: 'info',
            title: 'Login Diperlukan',
            html: '<p style="margin-top:4px;">Silakan login terlebih dahulu untuk mengakses keranjang belanja Anda.</p>',
            showCancelButton: true,
            confirmButtonText: '<span class="material-symbols-outlined" style="font-size:18px;vertical-align:middle;margin-right:6px;">login</span> Login Sekarang',
            cancelButtonText: 'Nanti Saja',
            confirmButtonColor: '#795465',
            cancelButtonColor: '#605e5b',
            customClass: {
                popup: 'swal-custom',
                confirmButton: '!rounded-full !font-semibold !px-6 !py-3 !text-sm',
                cancelButton: '!rounded-full !font-semibold !px-6 !py-3 !text-sm',
            },
            showClass: {
                popup: 'animate__animated animate__fadeInDown animate__faster'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp animate__faster'
            },
            backdrop: `rgba(0,0,0,0.4)`,
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = loginUrl;
            }
        });
    } else {
        // Fallback if SweetAlert is not loaded
        window.location.href = loginUrl;
    }
}

// Account dropdown
function toggleAccountDropdown() {
    const dropdown = document.getElementById('account-dropdown');
    if (dropdown) {
        dropdown.classList.toggle('hidden');
    }
}

// Close dropdown when clicking outside
document.addEventListener('click', function(e) {
    const wrapper = document.getElementById('account-dropdown-wrapper');
    const dropdown = document.getElementById('account-dropdown');
    if (wrapper && dropdown && !wrapper.contains(e.target)) {
        dropdown.classList.add('hidden');
    }
});

// Mobile Nav Toggle
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuButton = document.getElementById('mobileMenuButton');
    const mobileMenu = document.getElementById('mobileMenu');
    const mobileMenuIcon = document.getElementById('mobileMenuIcon');

    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function (e) {
            e.stopPropagation();
            const isOpen = mobileMenu.classList.contains('is-open');

            if (isOpen) {
                mobileMenu.classList.remove('is-open');
                mobileMenu.classList.add('hidden');
                if (mobileMenuIcon) {
                    mobileMenuIcon.style.transform = 'rotate(0deg)';
                    setTimeout(() => mobileMenuIcon.textContent = 'menu', 100);
                }
            } else {
                mobileMenu.classList.add('is-open');
                mobileMenu.classList.remove('hidden');
                if (mobileMenuIcon) {
                    mobileMenuIcon.style.transform = 'rotate(90deg)';
                    setTimeout(() => mobileMenuIcon.textContent = 'close', 100);
                }
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && mobileMenu.classList.contains('is-open')) {
                mobileMenu.classList.remove('is-open');
                mobileMenu.classList.add('hidden');
                if (mobileMenuIcon) {
                    mobileMenuIcon.style.transform = 'rotate(0deg)';
                    setTimeout(() => mobileMenuIcon.textContent = 'menu', 100);
                }
            }
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (mobileMenu.classList.contains('is-open') && !mobileMenu.contains(e.target) && !mobileMenuButton.contains(e.target)) {
                mobileMenu.classList.remove('is-open');
                mobileMenu.classList.add('hidden');
                if (mobileMenuIcon) {
                    mobileMenuIcon.style.transform = 'rotate(0deg)';
                    setTimeout(() => mobileMenuIcon.textContent = 'menu', 100);
                }
            }
        });
    }
});
</script>
