<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0, viewport-fit=cover" name="viewport">
    <title><?= esc($title ?? 'Admin Login - Aye Bouquet') ?></title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "on-tertiary-fixed": "#2c1600", "on-tertiary-fixed-variant": "#623f18", "surface-container-high": "#eae8e7", "tertiary-fixed": "#ffdcbd", "secondary-fixed": "#e6e2dd", "primary-fixed-dim": "#e9bacd", "surface-bright": "#fbf9f8", tertiary: "#7d562d", "secondary-container": "#e6e2dd", "on-primary-container": "#765162", "secondary-fixed-dim": "#c9c6c1", "on-background": "#1b1c1c", "surface-tint": "#795465", "surface-dim": "#dbd9d9", "surface-container-low": "#f5f3f3", "primary-container": "#f8c8dc", primary: "#795465", "on-surface-variant": "#4f4448", "on-secondary-fixed": "#1c1c19", "surface-container-lowest": "#ffffff", "outline-variant": "#d2c3c7", "on-error": "#ffffff", "surface-container": "#efeded", "on-secondary-fixed-variant": "#484743", "inverse-primary": "#e9bacd", "on-surface": "#1b1c1c", "error-container": "#ffdad6", "surface-container-highest": "#e4e2e2", "on-primary-fixed": "#2e1221", background: "#fbf9f8", "on-tertiary": "#ffffff", "on-primary": "#ffffff", surface: "#fbf9f8", error: "#ba1a1a", "inverse-on-surface": "#f2f0f0", "on-primary-fixed-variant": "#5f3c4d", "surface-variant": "#e4e2e2", secondary: "#605e5b", outline: "#817478", "on-tertiary-container": "#7a542b", "inverse-surface": "#303030", "on-secondary": "#ffffff", "primary-fixed": "#ffd8e7", "tertiary-fixed-dim": "#f0bd8b", "on-secondary-container": "#666460", "on-error-container": "#93000a", "tertiary-container": "#ffcb99"
                    },
                    borderRadius: {DEFAULT: "0.25rem", lg: "0.5rem", xl: "0.75rem", "2xl": "1rem", "3xl": "1.5rem", full: "9999px"},
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
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #fbf4f7 0%, #fff0f5 25%, #fbf9f8 50%, #f7ece6 75%, #fef6f0 100%);
        }
        /* Auth Decorative Blobs */
        .auth-blob {
            position: fixed;
            border-radius: 50%;
            filter: blur(70px);
            opacity: 0.55;
            pointer-events: none;
            animation: blobFloat 10s ease-in-out infinite;
            z-index: 0;
        }
        .auth-blob-1 {
            width: 420px; height: 420px;
            background: radial-gradient(circle, #f8c8dc 0%, #fde8f0 60%, transparent 100%);
            top: -120px; right: -100px;
            animation-delay: 0s;
        }
        .auth-blob-2 {
            width: 360px; height: 360px;
            background: radial-gradient(circle, #f0bd8b 0%, #ffecd8 60%, transparent 100%);
            bottom: -100px; left: -80px;
            animation-delay: -5s;
        }
        .auth-blob-3 {
            width: 200px; height: 200px;
            background: radial-gradient(circle, #d2c3c7 0%, #efe8eb 60%, transparent 100%);
            top: 40%; left: 10%;
            animation-delay: -3s;
            opacity: 0.3;
        }
        @keyframes blobFloat {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(12px, -18px) scale(1.04); }
            66% { transform: translate(-10px, 10px) scale(0.97); }
        }
        /* Admin Enter Animation */
        .admin-enter {
            animation: adminFadeUp 0.55s cubic-bezier(0.22, 1, 0.36, 1) both;
        }
        @keyframes adminFadeUp {
            from { opacity: 0; transform: translateY(22px) scale(0.98); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }
        /* Card Glass Effect */
        .auth-card-glass {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(210, 195, 199, 0.4);
            box-shadow: 0 24px 64px -12px rgba(121, 84, 101, 0.18), 0 4px 16px -4px rgba(121, 84, 101, 0.08);
        }
        .dark .auth-card-glass {
            background: rgba(30, 24, 27, 0.88);
            border-color: rgba(79, 68, 72, 0.4);
        }
        /* Soft shadow for inputs */
        .soft-shadow { box-shadow: 0 10px 40px -10px rgba(121, 84, 101, 0.1); }
        /* Input focus glow */
        .input-focus-ring:focus {
            outline: none;
            border-color: #795465;
            box-shadow: 0 0 0 3px rgba(248, 200, 220, 0.45);
        }
        /* Floral decorations */
        .floral-deco {
            position: absolute;
            opacity: 0.06;
            pointer-events: none;
            font-size: 96px;
            line-height: 1;
            color: #795465;
            font-variation-settings: 'FILL' 1, 'wght' 400;
            user-select: none;
        }
        /* Hover lift */
        .btn-lift:hover { transform: translateY(-2px); }
        .btn-lift:active { transform: translateY(0) scale(0.98); }
    </style>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body class="min-h-screen flex items-center justify-center p-4 sm:p-6 relative overflow-hidden" style="padding-bottom: max(1.5rem, env(safe-area-inset-bottom));">

    <!-- Decorative floating blobs -->
    <div class="auth-blob auth-blob-1"></div>
    <div class="auth-blob auth-blob-2"></div>
    <div class="auth-blob auth-blob-3"></div>

    <!-- Content -->
    <div class="relative z-10 w-full flex items-center justify-center admin-enter">
        <?= $this->renderSection('content') ?>
    </div>
</body>
</html>
