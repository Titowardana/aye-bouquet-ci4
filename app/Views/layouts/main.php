<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'Aye Bouquet') ?></title>
    <meta name="description" content="Website katalog dan pemesanan bucket/gift custom via WhatsApp.">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>?v=<?= time() ?>"/>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "on-primary-fixed": "#2e1221",
                        "on-error-container": "#93000a",
                        "surface-dim": "#dbd9d9",
                        "surface-container": "#efeded",
                        surface: "#fbf9f8",
                        "surface-container-highest": "#e4e2e2",
                        "surface-container-low": "#f5f3f3",
                        "tertiary-fixed-dim": "#f0bd8b",
                        "tertiary-container": "#ffcb99",
                        "surface-container-high": "#eae8e7",
                        "primary-fixed": "#ffd8e7",
                        "outline-variant": "#d2c3c7",
                        "on-tertiary-container": "#7a542b",
                        tertiary: "#7d562d",
                        "secondary-container": "#e6e2dd",
                        "inverse-surface": "#303030",
                        "inverse-on-surface": "#f2f0f0",
                        "on-secondary-fixed-variant": "#484743",
                        "secondary-fixed-dim": "#c9c6c1",
                        "primary-container": "#f8c8dc",
                        "on-error": "#ffffff",
                        "on-secondary": "#ffffff",
                        "surface-tint": "#795465",
                        "on-surface": "#1b1c1c",
                        "on-tertiary-fixed-variant": "#623f18",
                        "secondary-fixed": "#e6e2dd",
                        secondary: "#605e5b",
                        "on-primary": "#ffffff",
                        "inverse-primary": "#e9bacd",
                        "on-secondary-fixed": "#1c1c19",
                        "on-secondary-container": "#666460",
                        "on-surface-variant": "#4f4448",
                        "error-container": "#ffdad6",
                        "on-tertiary": "#ffffff",
                        "tertiary-fixed": "#ffdcbd",
                        "surface-container-lowest": "#ffffff",
                        "surface-bright": "#fbf9f8",
                        background: "#fbf9f8",
                        error: "#ba1a1a",
                        "on-primary-fixed-variant": "#5f3c4d",
                        primary: "#795465",
                        outline: "#817478",
                        "on-primary-container": "#765162",
                        "on-background": "#1b1c1c",
                        "on-tertiary-fixed": "#2c1600",
                        "surface-variant": "#e4e2e2",
                        "primary-fixed-dim": "#e9bacd"
                    },
                    borderRadius: {
                        DEFAULT: "0.25rem",
                        lg: "0.5rem",
                        xl: "0.75rem",
                        full: "9999px"
                    },
                    spacing: {
                        gutter: "24px",
                        "section-gap": "80px",
                        "container-padding-desktop": "64px",
                        "container-padding-mobile": "20px",
                        base: "8px"
                    },
                    fontFamily: {
                        "body-lg": ["Plus Jakarta Sans"],
                        "label-md": ["Plus Jakarta Sans"],
                        "headline-lg-mobile": ["Plus Jakarta Sans"],
                        "body-md": ["Plus Jakarta Sans"],
                        "headline-lg": ["Plus Jakarta Sans"],
                        "display-lg": ["Plus Jakarta Sans"],
                        "headline-md": ["Plus Jakarta Sans"],
                        "label-sm": ["Plus Jakarta Sans"],
                        headline: ["Plus Jakarta Sans"],
                        display: ["Plus Jakarta Sans"],
                        body: ["Plus Jakarta Sans"],
                        label: ["Plus Jakarta Sans"]
                    },
                    fontSize: {
                        "body-lg": ["18px", {lineHeight: "1.6", fontWeight: "400"}],
                        "label-md": ["14px", {lineHeight: "1.2", letterSpacing: "0.01em", fontWeight: "600"}],
                        "headline-lg-mobile": ["24px", {lineHeight: "1.3", fontWeight: "600"}],
                        "body-md": ["16px", {lineHeight: "1.6", fontWeight: "400"}],
                        "headline-lg": ["32px", {lineHeight: "1.3", fontWeight: "600"}],
                        "display-lg": ["48px", {lineHeight: "1.2", letterSpacing: "-0.02em", fontWeight: "700"}],
                        "headline-md": ["24px", {lineHeight: "1.4", fontWeight: "600"}],
                        "label-sm": ["12px", {lineHeight: "1.2", fontWeight: "500"}]
                    }
                }
            }
        };
    </script>
    <style>
        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
        .soft-shadow {
            box-shadow: 0 10px 30px -10px rgba(121, 84, 101, 0.1);
        }
        .soft-shadow-hover:hover {
            box-shadow: 0 15px 35px -10px rgba(121, 84, 101, 0.15);
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="bg-background dark:bg-[#1f1b1d] text-on-background dark:text-inverse-on-surface font-body-md min-h-screen flex flex-col transition-colors duration-300">
    <?= $this->include('partials/navbar') ?>

    <main class="flex-grow">
        <?= $this->renderSection('content') ?>
    </main>

    <?= $this->include('partials/footer') ?>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?= base_url('assets/js/main.js') ?>?v=<?= time() ?>"></script>

    <!-- Lightbox Modal for Testimonial Photos -->
    <div id="testimonialImageModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/70 px-4">
        <div class="relative max-w-3xl w-full">
            <button type="button" id="closeTestimonialImageModal" class="absolute -top-12 right-0 text-white text-3xl leading-none hover:opacity-70 transition-opacity">&times;</button>
            <img id="testimonialImagePreview" src="" alt="Foto testimoni" class="max-h-[80vh] w-full object-contain rounded-2xl bg-white">
        </div>
    </div>
</body>
</html>
