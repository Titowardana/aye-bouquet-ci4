<!DOCTYPE html>
<html class="light scroll-smooth" lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title><?= esc($title ?? 'Admin Panel - Aye Bouquet') ?></title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "on-tertiary-fixed": "#2c1600", "on-tertiary-fixed-variant": "#623f18", "surface-container-high": "#eae8e7", "tertiary-fixed": "#ffdcbd", "secondary-fixed": "#e6e2dd", "primary-fixed-dim": "#e9bacd", "surface-bright": "#fbf9f8", tertiary: "#7d562d", "secondary-container": "#e6e2dd", "on-primary-container": "#765162", "secondary-fixed-dim": "#c9c6c1", "on-background": "#1b1c1c", "surface-tint": "#795465", "surface-dim": "#dbd9d9", "surface-container-low": "#f5f3f3", "primary-container": "#f8c8dc", primary: "#795465", "on-surface-variant": "#4f4448", "on-secondary-fixed": "#1c1c19", "surface-container-lowest": "#ffffff", "outline-variant": "#d2c3c7", "on-error": "#ffffff", "surface-container": "#efeded", "on-secondary-fixed-variant": "#484743", "inverse-primary": "#e9bacd", "on-surface": "#1b1c1c", "error-container": "#ffdad6", "surface-container-highest": "#e4e2e2", "on-primary-fixed": "#2e1221", background: "#fbf9f8", "on-tertiary": "#ffffff", "on-primary": "#ffffff", surface: "#fbf9f8", error: "#ba1a1a", "inverse-on-surface": "#f2f0f0", "on-primary-fixed-variant": "#5f3c4d", "surface-variant": "#e4e2e2", secondary: "#605e5b", outline: "#817478", "on-tertiary-container": "#7a542b", "inverse-surface": "#303030", "on-secondary": "#ffffff", "primary-fixed": "#ffd8e7", "tertiary-fixed-dim": "#f0bd8b", "on-secondary-container": "#666460", "on-error-container": "#93000a", "tertiary-container": "#ffcb99"
                    },
                    borderRadius: {DEFAULT: "0.25rem", lg: "0.5rem", xl: "0.75rem", full: "9999px"},
                    spacing: {"section-gap": "80px", "container-padding-desktop": "64px", gutter: "24px", "container-padding-mobile": "20px", base: "8px"},
                    fontFamily: {
                        "label-md": ["Plus Jakarta Sans"], "display-lg": ["Plus Jakarta Sans"], "body-md": ["Plus Jakarta Sans"], "label-sm": ["Plus Jakarta Sans"], "headline-lg-mobile": ["Plus Jakarta Sans"], "headline-md": ["Plus Jakarta Sans"], "headline-lg": ["Plus Jakarta Sans"], "body-lg": ["Plus Jakarta Sans"], headline: ["Plus Jakarta Sans"], display: ["Plus Jakarta Sans"], body: ["Plus Jakarta Sans"], label: ["Plus Jakarta Sans"]
                    },
                    fontSize: {
                        "label-md": ["14px", {lineHeight: "1.2", letterSpacing: "0.01em", fontWeight: "600"}], "display-lg": ["48px", {lineHeight: "1.2", letterSpacing: "-0.02em", fontWeight: "700"}], "body-md": ["16px", {lineHeight: "1.6", fontWeight: "400"}], "label-sm": ["12px", {lineHeight: "1.2", fontWeight: "500"}], "headline-lg-mobile": ["24px", {lineHeight: "1.3", fontWeight: "600"}], "headline-md": ["24px", {lineHeight: "1.4", fontWeight: "600"}], "headline-lg": ["32px", {lineHeight: "1.3", fontWeight: "600"}], "body-lg": ["18px", {lineHeight: "1.6", fontWeight: "400"}]
                    }
                }
            }
        };
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .soft-shadow {
            box-shadow: 0 10px 40px -10px rgba(121, 84, 101, 0.05);
        }
        .sidebar-active {
            background-color: #f8c8dc;
            color: #795465;
            font-weight: 600;
        }
        .dark .sidebar-active {
            background-color: #8a5a70;
            color: #ffffff;
        }
        nav a .material-symbols-outlined:first-child {
            transition: transform 0.2s ease;
        }
        nav a:hover .material-symbols-outlined:first-child {
            transform: scale(1.15);
        }
        
        /* Helper class for iOS Safe Area */
        .admin-mobile-safe {
            padding-top: env(safe-area-inset-top);
            padding-bottom: env(safe-area-inset-bottom);
        }
        /* Mobile max width wrapper */
        .admin-content-wrap {
            max-width: 100vw;
            overflow-x: hidden;
        }

        /* ── Clean sidebar scrollbar (hide up/down arrows) ── */
        #admin-sidebar nav {
            scrollbar-width: thin;
            scrollbar-color: rgba(121,84,101,0.25) transparent;
        }
        #admin-sidebar nav::-webkit-scrollbar {
            width: 4px;
        }
        #admin-sidebar nav::-webkit-scrollbar-track {
            background: transparent;
        }
        #admin-sidebar nav::-webkit-scrollbar-thumb {
            background: rgba(121,84,101,0.25);
            border-radius: 99px;
        }
        #admin-sidebar nav::-webkit-scrollbar-thumb:hover {
            background: rgba(121,84,101,0.4);
        }
        #admin-sidebar nav::-webkit-scrollbar-button {
            display: none;
            width: 0;
            height: 0;
        }

        /* ── Admin filter bar inputs / selects / date pickers ── */
        select.admin-filter-select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: none !important;
        }
        select.admin-filter-select::-ms-expand {
            display: none;
        }
        .dark select.admin-filter-select,
        .dark input.admin-filter-input,
        .dark input.admin-filter-date {
            background-color: #241b22 !important;
            color: #ffffff !important;
            border-color: rgba(255, 255, 255, 0.12) !important;
        }
        .dark input.admin-filter-input::placeholder,
        .dark input.admin-filter-date::placeholder {
            color: rgba(255, 255, 255, 0.45) !important;
        }
        .dark input[type="date"].admin-filter-date::-webkit-calendar-picker-indicator {
            filter: invert(1);
            opacity: 0.75;
        }
        input[type="date"].admin-filter-date {
            color-scheme: dark;
        }
    </style>
    <!-- Dark Mode Init Script -->
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="bg-surface dark:bg-inverse-surface text-on-surface dark:text-inverse-on-surface min-h-screen flex transition-colors duration-300 font-body-md overflow-x-hidden">
    <!-- Sidebar -->
    <aside id="admin-sidebar" class="fixed inset-y-0 left-0 z-40 w-64 bg-surface-container dark:bg-[#2a2328] border-r border-outline-variant/30 dark:border-white/10 flex flex-col transition-transform duration-300 -translate-x-full md:translate-x-0">
        <!-- Brand Header -->
        <div class="h-20 px-6 flex items-center gap-3 border-b border-outline-variant/30 dark:border-white/10">
            <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary dark:text-primary-fixed-dim p-1.5">
                <img src="<?= base_url('assets/images/aye-bouquet-logo.png') ?>" alt="Aye Bouquet Logo" class="w-full h-full object-contain">
            </div>
            <div>
                <span class="font-headline-md text-sm font-bold text-primary dark:text-primary-fixed-dim block">Aye Bouquet</span>
                <span class="text-[10px] text-on-surface-variant tracking-wider uppercase font-semibold">Admin Panel</span>
            </div>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-grow p-4 space-y-2 overflow-y-auto">
            <a href="<?= base_url('admin') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-surface-container-high dark:hover:bg-white/5 <?= ($activeMenu ?? '') === 'dashboard' ? 'sidebar-active font-semibold shadow-sm' : 'text-on-surface-variant hover:text-on-surface dark:text-white/70 dark:hover:text-white' ?>">
                <span class="material-symbols-outlined">dashboard</span>
                <span class="text-sm">Dashboard</span>
            </a>
            <a href="<?= base_url('admin/pesanan') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-surface-container-high dark:hover:bg-white/5 <?= ($activeMenu ?? '') === 'pesanan' ? 'sidebar-active font-semibold shadow-sm' : 'text-on-surface-variant hover:text-on-surface dark:text-white/70 dark:hover:text-white' ?>">
                <span class="material-symbols-outlined">receipt_long</span>
                <span class="text-sm">Pesanan</span>
            </a>
            <a href="<?= base_url('admin/pesanan/arsip') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-surface-container-high dark:hover:bg-white/5 <?= ($activeMenu ?? '') === 'arsip-pesanan' ? 'sidebar-active font-semibold shadow-sm' : 'text-on-surface-variant hover:text-on-surface dark:text-white/70 dark:hover:text-white' ?>">
                <span class="material-symbols-outlined">archive</span>
                <span class="text-sm">Arsip</span>
            </a>
            <a href="<?= base_url('admin/produk') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-surface-container-high dark:hover:bg-white/5 <?= ($activeMenu ?? '') === 'produk' || ($activeMenu ?? '') === 'products' ? 'sidebar-active font-semibold shadow-sm' : 'text-on-surface-variant hover:text-on-surface dark:text-white/70 dark:hover:text-white' ?>">
                <span class="material-symbols-outlined">inventory_2</span>
                <span class="text-sm">Products</span>
            </a>
            <a href="<?= base_url('admin/kategori') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-surface-container-high dark:hover:bg-white/5 <?= ($activeMenu ?? '') === 'categories' ? 'sidebar-active font-semibold shadow-sm' : 'text-on-surface-variant hover:text-on-surface dark:text-white/70 dark:hover:text-white' ?>">
                <span class="material-symbols-outlined">category</span>
                <span class="text-sm">Categories</span>
            </a>
            <a href="<?= base_url('admin/custom-options') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-surface-container-high dark:hover:bg-white/5 <?= ($activeMenu ?? '') === 'custom-options' ? 'sidebar-active font-semibold shadow-sm' : 'text-on-surface-variant hover:text-on-surface dark:text-white/70 dark:hover:text-white' ?>">
                <span class="material-symbols-outlined">tune</span>
                <span class="text-sm">Opsi Custom</span>
            </a>
            <a href="<?= base_url('admin/product-colors') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-surface-container-high dark:hover:bg-white/5 <?= ($activeMenu ?? '') === 'product-colors' ? 'sidebar-active font-semibold shadow-sm' : 'text-on-surface-variant hover:text-on-surface dark:text-white/70 dark:hover:text-white' ?>">
                <span class="material-symbols-outlined">palette</span>
                <span class="text-sm">Warna Produk</span>
            </a>
            <a href="<?= base_url('admin/galeri') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-surface-container-high dark:hover:bg-white/5 <?= ($activeMenu ?? '') === 'galeri' || ($activeMenu ?? '') === 'galleries' ? 'sidebar-active font-semibold shadow-sm' : 'text-on-surface-variant hover:text-on-surface dark:text-white/70 dark:hover:text-white' ?>">
                <span class="material-symbols-outlined">photo_library</span>
                <span class="text-sm">Galeri</span>
            </a>
            <a href="<?= base_url('admin/testimonials') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-surface-container-high dark:hover:bg-white/5 <?= ($activeMenu ?? '') === 'testimonials' ? 'sidebar-active font-semibold shadow-sm' : 'text-on-surface-variant hover:text-on-surface dark:text-white/70 dark:hover:text-white' ?>">
                <span class="material-symbols-outlined">reviews</span>
                <span class="text-sm">Testimonials</span>
            </a>
            <a href="<?= base_url('admin/faqs') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-surface-container-high dark:hover:bg-white/5 <?= ($activeMenu ?? '') === 'faqs' ? 'sidebar-active font-semibold shadow-sm' : 'text-on-surface-variant hover:text-on-surface dark:text-white/70 dark:hover:text-white' ?>">
                <span class="material-symbols-outlined">help_center</span>
                <span class="text-sm">FAQs</span>
            </a>
            <a href="<?= base_url('admin/contact') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-surface-container-high dark:hover:bg-white/5 <?= ($activeMenu ?? '') === 'contact' ? 'sidebar-active font-semibold shadow-sm' : 'text-on-surface-variant hover:text-on-surface dark:text-white/70 dark:hover:text-white' ?>">
                <span class="material-symbols-outlined">live_help</span>
                <span class="text-sm">Contact</span>
            </a>
            
            <div class="pt-4 border-t border-outline-variant/30 dark:border-white/10 my-4"></div>
            
            <a href="<?= base_url('/') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 text-on-surface-variant hover:text-primary dark:text-white/70 dark:hover:text-primary-fixed-dim hover:bg-surface-container-high dark:hover:bg-white/5">
                <span class="material-symbols-outlined">store</span>
                <span class="text-sm">Lihat Toko</span>
            </a>
            <button type="button" onclick="openAdminConfirm({ title: 'Keluar dari Admin?', message: 'Anda akan keluar dari sesi admin Aye Bouquet.', icon: 'logout', confirmText: 'Ya, Keluar', confirmClass: 'bg-error text-on-error hover:bg-error/90', action: '<?= base_url('admin/logout') ?>', method: 'POST' })" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 text-error hover:bg-error-container/20 text-left">
                <span class="material-symbols-outlined">logout</span>
                <span class="text-sm font-semibold">Keluar</span>
            </button>
        </nav>

        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-outline-variant/30 dark:border-white/10 bg-surface-container-low/50 dark:bg-[#1e1c1d]">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-primary text-on-primary flex items-center justify-center font-bold text-sm uppercase">
                    <?= esc(substr(session()->get('admin_name') ?? 'A', 0, 1)) ?>
                </div>
                <div>
                    <span class="text-xs font-bold block text-on-surface"><?= esc(session()->get('admin_name') ?? 'Administrator') ?></span>
                    <span class="text-[10px] text-on-surface-variant block"><?= esc(session()->get('admin_email') ?? 'admin@ayebouquet.com') ?></span>
                </div>
            </div>
        </div>
    </aside>

    <!-- Overlay for mobile sidebar -->
    <div id="sidebar-overlay" class="fixed inset-0 z-30 bg-black/40 backdrop-blur-sm hidden transition-opacity duration-300 md:hidden"></div>

    <!-- Main Content Area -->
    <div class="flex-grow md:pl-64 flex flex-col min-h-screen min-w-0">
        <!-- Top App Bar -->
        <header class="h-20 bg-surface/80 dark:bg-inverse-surface/80 backdrop-blur-md border-b border-outline-variant/20 dark:border-white/10 px-4 md:px-6 flex items-center justify-between sticky top-0 z-30 pt-[env(safe-area-inset-top)]">
            <!-- Mobile Menu Toggle Button -->
            <button id="sidebar-toggle" class="p-2 -ml-2 text-on-surface-variant hover:text-primary dark:hover:text-primary-fixed-dim hover:bg-primary-container/20 rounded-xl transition-colors md:hidden" aria-label="Toggle Sidebar">
                <span class="material-symbols-outlined text-2xl">menu</span>
            </button>

            <!-- Page Title -->
            <h1 class="text-base md:text-xl font-bold text-on-surface select-none pl-2 md:pl-0 flex-1 truncate mr-2 md:mr-4">
                <?= esc($pageTitle ?? 'Dashboard') ?>
            </h1>

            <!-- Topbar Right Actions -->
            <div class="flex items-center gap-3">
                <!-- Dark Mode Toggle Button -->
                <button onclick="toggleDarkMode()" class="p-2 text-on-surface-variant hover:text-primary hover:bg-primary-container/20 dark:hover:bg-primary-container/10 rounded-full transition-all duration-200" title="Toggle Dark/Light Mode">
                    <span id="theme-icon" class="material-symbols-outlined text-[22px]">dark_mode</span>
                </button>

                <!-- Notifications (Placeholder) -->
                <button class="p-2 text-on-surface-variant hover:text-primary hover:bg-primary-container/20 rounded-full transition-all duration-200 relative">
                    <span class="material-symbols-outlined text-[22px]">notifications</span>
                    <span class="absolute top-1 right-1 w-2 h-2 bg-error rounded-full ring-2 ring-surface"></span>
                </button>

                <div class="w-px h-6 bg-outline-variant/30 mx-1"></div>

                <!-- User Profile Dropdown Placeholder -->
                <div class="flex items-center gap-2 select-none">
                    <div class="w-8 h-8 rounded-full bg-secondary-container dark:bg-secondary-fixed flex items-center justify-center font-semibold text-xs text-on-secondary-container">
                        AD
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content Inner -->
        <main class="flex-grow p-4 md:p-8 bg-gradient-to-br from-surface via-surface-container-lowest/30 to-primary-container/5 dark:from-inverse-surface dark:via-inverse-surface/95 dark:to-primary-fixed/5 admin-enter admin-content-wrap pb-[calc(1rem+env(safe-area-inset-bottom))] md:pb-8">
            <?= $this->renderSection('content') ?>
        </main>
    </div>

    <!-- ============================================================
         GLOBAL ADMIN CONFIRMATION MODAL  (shadcn Alert Dialog style)
         ============================================================ -->
    <div id="adminConfirmModal" class="fixed inset-0 z-[60] flex items-center justify-center p-4 hidden" role="dialog" aria-modal="true">
        <!-- Overlay with blur -->
        <div id="adminConfirmOverlay" class="absolute inset-0 bg-black/60 backdrop-blur-md transition-all duration-300 opacity-0"></div>
        <!-- Card -->
        <div id="adminConfirmCard" class="relative bg-surface-container-lowest dark:bg-gray-900 w-full max-w-sm rounded-3xl border border-outline-variant/10 overflow-hidden transform scale-95 opacity-0 transition-all duration-300 ease-out shadow-[0_30px_70px_-15px_rgba(0,0,0,0.35)] dark:shadow-[0_30px_70px_-15px_rgba(0,0,0,0.6)]">
            <!-- Accent bar -->
            <div id="adminConfirmAccent" class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-error via-error to-error/50"></div>
            <div class="p-7 pt-8 text-center">
                <!-- Icon -->
                <div id="adminConfirmIconWrap" class="w-16 h-16 mx-auto mb-5 rounded-2xl bg-gradient-to-br from-error-container/60 to-error/5 flex items-center justify-center ring-1 ring-inset ring-error/10 shadow-sm">
                    <span id="adminConfirmIcon" class="material-symbols-outlined text-[32px] text-error">warning</span>
                </div>
                <!-- Title -->
                <h3 id="adminConfirmTitle" class="font-headline-md text-lg font-bold text-on-surface dark:text-white mb-2"></h3>
                <!-- Message -->
                <p id="adminConfirmMessage" class="text-sm text-on-surface-variant dark:text-gray-400 mb-7 leading-relaxed px-2"></p>
                <!-- Buttons -->
                <div class="flex flex-col sm:flex-row justify-center gap-2.5">
                    <button type="button" id="adminConfirmCancel" class="flex-1 px-5 py-2.5 rounded-2xl border border-outline-variant/60 text-sm font-semibold text-on-surface dark:text-gray-300 bg-transparent hover:bg-surface-container dark:hover:bg-gray-800 active:scale-[0.97] transition-all cursor-pointer">
                        Batal
                    </button>
                    <form id="adminConfirmForm" method="post" class="flex-1">
                        <?= csrf_field() ?>
                        <button type="submit" id="adminConfirmYes" class="px-5 py-2.5 rounded-full text-xs font-bold shadow-sm transition-all bg-error text-on-error hover:bg-error/90 hover:shadow-md" style="width:100%">
                            Ya, Lanjutkan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script for Sidebar Interactions & Theme -->
    <script>
        const sidebar = document.getElementById('admin-sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const toggleBtn = document.getElementById('sidebar-toggle');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        if (toggleBtn) {
            toggleBtn.addEventListener('click', openSidebar);
        }
        if (overlay) {
            overlay.addEventListener('click', closeSidebar);
        }

        // Handle window resize to clean up mobile states
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
            }
        });

        // Dark Mode Logic
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
            if (iconElement) {
                if (document.documentElement.classList.contains('dark')) {
                    iconElement.innerText = 'light_mode';
                } else {
                    iconElement.innerText = 'dark_mode';
                }
            }
        }
        document.addEventListener('DOMContentLoaded', updateThemeIcon);

        // ── Global Admin Confirmation Modal ──
        var _adminConfirmCallback = null;

        function openAdminConfirm(opts) {
            var modal   = document.getElementById('adminConfirmModal');
            var ovl     = document.getElementById('adminConfirmOverlay');
            var card    = document.getElementById('adminConfirmCard');
            var title   = document.getElementById('adminConfirmTitle');
            var msg     = document.getElementById('adminConfirmMessage');
            var form    = document.getElementById('adminConfirmForm');
            var yesBtn  = document.getElementById('adminConfirmYes');
            var icon    = document.getElementById('adminConfirmIcon');
            var accent  = document.getElementById('adminConfirmAccent');

            title.textContent = opts.title || 'Konfirmasi';
            msg.textContent   = opts.message || 'Apakah Anda yakin?';
            yesBtn.textContent = opts.confirmText || 'Ya, Lanjutkan';

            // Icon
            if (opts.icon) {
                icon.textContent = opts.icon;
            } else {
                icon.textContent = 'warning';
            }

            // Confirm button class
            yesBtn.className = 'px-5 py-2.5 rounded-full text-xs font-bold shadow-sm transition-all ';
            if (opts.confirmClass) {
                yesBtn.className += opts.confirmClass;
            } else {
                yesBtn.className += 'bg-error text-on-error hover:bg-error/90';
            }

            // Accent bar color
            if (opts.accentClass) {
                accent.className = 'absolute top-0 inset-x-0 h-1 ' + opts.accentClass;
            } else {
                accent.className = 'absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-error via-error to-error/50';
            }

            _adminConfirmCallback = null;

            if (typeof opts.onConfirm === 'function') {
                // Custom callback mode
                _adminConfirmCallback = opts.onConfirm;
                form.action = '';
                form.onsubmit = function(e) {
                    e.preventDefault();
                    _adminConfirmCallback();
                    closeAdminConfirm();
                };
            } else {
                // POST form mode (e.g. delete)
                form.action = opts.action || '';
                form.onsubmit = null;
            }

            // Show modal with animation
            modal.classList.remove('hidden');
            requestAnimationFrame(function() {
                ovl.classList.remove('opacity-0');
                ovl.classList.add('opacity-100');
                card.classList.remove('scale-95', 'opacity-0');
                card.classList.add('scale-100', 'opacity-100');
            });
        }

        function closeAdminConfirm() {
            var modal = document.getElementById('adminConfirmModal');
            var ovl   = document.getElementById('adminConfirmOverlay');
            var card  = document.getElementById('adminConfirmCard');
            var form  = document.getElementById('adminConfirmForm');

            ovl.classList.remove('opacity-100');
            ovl.classList.add('opacity-0');
            card.classList.remove('scale-100', 'opacity-100');
            card.classList.add('scale-95', 'opacity-0');

            setTimeout(function() {
                modal.classList.add('hidden');
                form.onsubmit = null;
                form.action = '';
                _adminConfirmCallback = null;
            }, 300);
        }

        // Cancel button
        document.getElementById('adminConfirmCancel').addEventListener('click', closeAdminConfirm);

        // Overlay click to close
        document.getElementById('adminConfirmOverlay').addEventListener('click', closeAdminConfirm);

        // Escape key to close
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                var modal = document.getElementById('adminConfirmModal');
                if (modal && !modal.classList.contains('hidden')) {
                    closeAdminConfirm();
                }
            }
        });
    </script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>

