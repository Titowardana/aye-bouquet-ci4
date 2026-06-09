<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title><?= esc($title ?? 'Aye Bouquet') ?></title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>"/>
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
                        "2xl": "1rem",
                        "3xl": "1.5rem",
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
                    }
                }
            }
        };
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="bg-surface dark:bg-inverse-surface text-on-surface dark:text-inverse-on-surface antialiased min-h-screen transition-colors duration-300">
    <div class="animate__animated animate__fadeIn">
    <?= $this->renderSection('content') ?>
    </div>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
