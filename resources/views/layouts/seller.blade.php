<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>StudentPedia Seller</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Bootstrap CSS --}}
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <style>
        :root {
            --pink-primary: #FF2D7A;
            --pink-soft: #FF5AA5;
            --pink-bg: #FFE0F0;
            --grey-page: #FFD3EB;
            --grey-border: #F9A8D4;
            --text-main: #111827;
            --text-muted: #6B7280;
        }

        body {
            background: var(--grey-page);
        }

        .seller-page {
            min-height: 100vh;
            padding: 24px;
            background: var(--grey-page);
        }

        .seller-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* HEADER DASHBOARD  */
        .seller-header-card {
            background: linear-gradient(135deg, #FF2D7A, #FF6FB8);
            border-radius: 16px;
            padding: 18px 22px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 8px 20px rgba(255, 45, 122, 0.35);
            margin-bottom: 18px;
            border: none;
            color: #ffffff;
        }

        .seller-header-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .seller-logo-circle {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
            color: #ffffff;
        }

        .seller-header-title {
            font-weight: 700;
            font-size: 18px;
            color: #ffffff;
        }

        .seller-header-subtitle {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.85);
        }

        .seller-header-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .seller-avatar {
            width: 32px;
            height: 32px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: #ffffff;
        }

        .btn-outline-grey {
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.7);
            padding: 6px 14px;
            font-size: 13px;
            background: transparent;
            color: #ffffff;
        }

        .btn-outline-grey:hover {
            background: rgba(255, 255, 255, 0.16);
        }

        .btn-primary-pink {
            border-radius: 999px;
            border: none;
            padding: 7px 16px;
            font-size: 13px;
            background: #ffffff;
            color: var(--pink-primary);
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 6px 16px rgba(255, 255, 255, 0.45);
        }

        .btn-primary-pink:hover {
            background: #FFF1F7;
        }

        /* SUMMARY CARDS */
        .summary-row {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
            margin-bottom: 18px;
        }

        .summary-card {
            background: #FFE9F4;
            border-radius: 12px;
            padding: 14px 16px;
            box-shadow: 0 4px 12px rgba(255, 45, 122, 0.12);
            border: 1px solid #F9A8D4;
        }

        .summary-label {
            font-size: 12px;
            color: #BE185D;
            margin-bottom: 4px;
        }

        .summary-value {
            font-size: 18px;
            font-weight: 700;
            color: #9D174D;
        }

        .summary-help {
            font-size: 11px;
            color: #9F1239;
            margin-top: 2px;
        }

        /* AREA PRODUK  */
        .seller-products-card {
            background: #FFE4F2;
            border-radius: 16px;
            padding: 18px 20px 20px;
            box-shadow: 0 6px 18px rgba(255, 45, 122, 0.18);
            border: 1px solid #F9A8D4;
        }

        .seller-products-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
        }

        .seller-products-title {
            font-weight: 600;
            font-size: 16px;
            color: #9D174D;
        }

        .seller-products-subtitle {
            font-size: 12px;
            color: #BE185D;
        }

        .seller-products-filters {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .seller-search {
            border-radius: 999px;
            border: 1px solid #F9A8D4;
            padding: 6px 12px;
            font-size: 12px;
            min-width: 180px;
            background: #FFF0F7;
        }

        .seller-select {
            border-radius: 999px;
            border: 1px solid #F9A8D4;
            padding: 6px 10px;
            font-size: 12px;
            background: #FFF0F7;
        }

        /* PRODUCT GRID */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
        }

        .product-card {
            border-radius: 14px;
            overflow: hidden;
            background: #FFEAF5;
            box-shadow: 0 3px 10px rgba(255, 45, 122, 0.15);
            border: 1px solid #F9A8D4;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .product-card img {
            width: 100%;
            height: 140px;
            object-fit: cover;
        }

        .product-card-body {
            padding: 10px 12px 12px;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .product-name {
            font-size: 13px;
            font-weight: 600;
            color: #7F1D4B;
            min-height: 32px;
        }

        .product-price {
            font-size: 13px;
            font-weight: 700;
            color: var(--pink-primary);
        }

        .product-meta-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 11px;
            color: #9F1239;
        }

        .product-rating {
            font-size: 11px;
            color: #FBBF24;
        }

        .product-stock {
            font-size: 11px;
            color: #9F1239;
        }

        .product-card-footer {
            margin-top: 8px;
            display: flex;
            gap: 6px;
        }

        .btn-sm-outline {
            border-radius: 999px;
            border: 1px solid #F9A8D4;
            background: #FFFFFF;
            font-size: 11px;
            padding: 4px 8px;
            flex: 1;
            text-align: center;
            color: #9D174D;
        }

        .btn-sm-outline:hover {
            border-color: var(--pink-primary);
            background: #FFF0F7;
        }

        .empty-state {
            padding: 32px 0;
            text-align: center;
            color: #9D174D;
            font-size: 13px;
        }

        /* FORM */
        .seller-form-shell {
            max-width: 520px;
            margin: 0 auto;
            background: #FEE7F4;
            border-radius: 24px;
            padding: 18px 20px 22px;
        }

        .seller-question-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 8px 12px 10px;
            margin-bottom: 10px;
            border: 1px solid #F9A8D4;
        }

        .seller-question-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--pink-primary);
            margin-bottom: 4px;
        }

        .seller-question-helper {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 4px;
        }

        .seller-input {
            width: 100%;
            border-radius: 8px;
            border: 1px solid #E5E7EB;
            background: #F9FAFB;
            font-size: 13px;
            padding: 7px 10px;
        }

        .seller-input:focus {
            box-shadow: none;
            border-color: var(--pink-primary);
            background: #ffffff;
        }

        .seller-textarea {
            min-height: 72px;
            resize: vertical;
        }

        .seller-upload-header {
            text-align: center;
            margin-bottom: 16px;
        }

        .seller-upload-icon-box {
            width: 72px;
            height: 72px;
            border-radius: 24px;
            margin: 0 auto 10px;
            background: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--pink-primary);
            font-size: 32px;
            overflow: hidden;
        }

        .btn-upload-photo {
            background: var(--pink-primary);
            color: #fff;
            border-radius: 999px;
            border: none;
            padding: 4px 14px;
            font-size: 12px;
            box-shadow: 0 6px 16px rgba(255, 45, 122, 0.35);
        }

        .btn-upload-photo:hover {
            background: var(--pink-soft);
        }

        .seller-modal-btn {
            background: var(--pink-primary) !important;
            color: #fff;
            border-radius: 999px;
            border: none;
            padding: 6px 20px;
            font-size: 13px;
            box-shadow: 0 6px 16px rgba(255, 45, 122, 0.35);
        }

        .seller-modal-btn:hover {
            background: var(--pink-soft) !important;
        }

        /* PREVIEW & THUMBNAILS */
        .upload-preview-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 24px;
        }

        .upload-thumb {
            width: 48px;
            height: 48px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid #F9A8D4;
        }

        /* RESPONSIVE */
        @media (max-width: 1024px) {
            .products-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 768px) {
            .seller-page {
                padding: 12px;
            }

            .seller-header-card {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .summary-row {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .products-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .seller-products-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }
        }

        @media (max-width: 480px) {
            .summary-row {
                grid-template-columns: 1fr;
            }

            .products-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body class="bg-pink-600 min-h-screen flex flex-col">

    {{-- HEADER UMUM STUDENTPEDIA --}}
    <header class="bg-pink-400 text-white py-4 shadow">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-6">

            {{-- LOGO --}}
            <div class="flex items-center space-x-3">
                <img src="../../../img/logo.png"
                     alt="Logo StudentPedia"
                     class="w-12 h-12 rounded-full object-cover">
                <span class="text-xl font-bold">StudentPedia</span>
            </div>

            {{-- USER ICON --}}
            <a href="/profile" class="p-2">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-8 h-8 text-white"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="white" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M6 21v-1a6 6 0 0112 0v1" />
                </svg>
            </a>
        </div>
    </header>

    {{-- CONTENT --}}
    <main class="flex-1 px-6 py-6">
        <div class="seller-page">
            <div class="seller-container">
                @yield('seller-content')
            </div>
        </div>
    </main>

    {{-- FOOTER --}}
    <footer class="bg-pink-500 py-6 text-center text-white font-bold mt-12">
        © StudentPedia 2025 — Semua Hak Dilindungi
    </footer>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- script tambahan dari halaman (preview upload, dsb.) --}}
    @stack('scripts')
</body>
</html>
