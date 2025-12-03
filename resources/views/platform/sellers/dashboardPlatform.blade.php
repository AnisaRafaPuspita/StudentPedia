{{-- resources/views/platform/sellers/dashboardPlatform.blade.php --}}
<x-app-layout>
    <style>
        :root{
            /* ==== PINK THEME (single tone, no gradient) ==== */
            --pink-bg: #ff5fa3;          /* main pink */
            --pink-bg-soft: #ffd3e6;     /* soft pink */
            --pink-bg-softer:#ffe6f1;    /* softer */
            --pink-ink: #b8125b;         /* dark pink for titles */

            --ink-900:#0f172a;
            --ink-700:#334155;
            --ink-500:#64748b;

            --card:#ffffff;
            --line:#eef2f7;
        }

        /* ========= GLOBAL BACKGROUND ========= */
        html, body{
            background: var(--pink-bg-soft) !important;
            background-attachment: fixed !important;
        }
        body, main, #app, .min-h-screen, .app-layout,
        .bg-gray-100, .bg-white, header + main{
            background: transparent !important;
        }

        /* ========= PAGE SHELL ========= */
        .platform-page{
            min-height:100vh;
            padding: 18px 14px 44px;
            position: relative;
            overflow:hidden;
            background: transparent !important;
        }

        /* glossy + dotted texture */
        .platform-page:before{
            content:"";
            position:absolute; inset:0;
            background-image:
                radial-gradient(rgba(184,18,91,.14) 1px, transparent 1px);
            background-size: 18px 18px;
            pointer-events:none;
            opacity:.45;
        }
        .platform-page:after{
            content:"";
            position:absolute; inset:-20% -10% auto -10%;
            height:320px;
            background: radial-gradient(900px circle at 50% 0%, #ffffffaa, transparent 55%);
            pointer-events:none;
            opacity:.55;
        }

        .platform-wrap{
            max-width:1200px;
            margin:0 auto;
            position:relative;
            z-index:1;
        }

        /* ========= HEADER / TOPBAR ========= */
        .topbar{
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:12px;
            margin-bottom:14px;

            background: var(--pink-bg);
            color:white;
            border-radius:18px;
            padding:16px 18px;
            box-shadow:0 14px 30px rgba(184,18,91,.35);
            border:2px solid rgba(255,255,255,.6);
            position:relative;
            overflow:hidden;
        }
        /* glossy highlight */
        .topbar:before{
            content:"";
            position:absolute; inset:-40% -20% auto -20%;
            height:130%;
            background: radial-gradient(600px circle at 50% 0%, #ffffff88, transparent 60%);
            opacity:.7;
        }

        .topbar-left{
            position:relative; z-index:2;
            display:flex; align-items:center; gap:12px;
        }
        .brand-chip{
            width:44px;height:44px;border-radius:14px;
            background:#ffffff22;
            display:grid;place-items:center;
            font-weight:900;
        }
        .topbar-left h1{
            font-size:22px;
            font-weight:900;
            margin:0;
            letter-spacing:.2px;
        }
        .topbar-left p{
            margin:2px 0 0;
            font-size:12px;
            font-weight:700;
            opacity:.9;
        }

        /* button glossy 1 warna */
        .btn-premium{
            position:relative; z-index:2;
            background:#ffffff;
            color:var(--pink-ink) !important;
            border:none;
            padding:10px 16px;
            border-radius:14px;
            font-weight:900;
            font-size:13px;
            box-shadow:0 10px 20px rgba(15,23,42,.18);
            transition:.2s ease;
        }
        .topbar-actions{
            position:relative;
            z-index:2;
            display:flex;
            align-items:center;
            gap:8px;
        }

        /* tombol kecil glossy outline */
        .btn-ghost{
            background: rgba(255,255,255,.18);
            color:#fff !important;
            border:1.5px solid rgba(255,255,255,.75);
            padding:8px 12px;
            border-radius:12px;
            font-weight:900;
            font-size:12.5px;
            letter-spacing:.2px;
            box-shadow:0 6px 14px rgba(15,23,42,.18);
            transition:.2s ease;
            backdrop-filter: blur(4px);
            white-space:nowrap;
        }
        .btn-ghost:hover{
            transform: translateY(-1px);
            background: rgba(255,255,255,.28);
        }

        /* versi logout biar agak "warning" tapi masih pinky */
        .btn-ghost.danger{
            background: rgba(255,255,255,.95);
            color: var(--pink-ink) !important;
            border-color: rgba(255,255,255,1);
        }
        .btn-ghost.danger:hover{
            filter: brightness(.98);
        }

        .btn-premium:hover{
            transform:translateY(-1px);
            box-shadow:0 14px 26px rgba(15,23,42,.22);
        }

        /* ========= SUMMARY WRAP (anti bocor pink) ========= */
        .summary-wrap{
            background:#ffffff;
            border-radius:18px;
            padding:12px;
            margin-bottom:14px;
            box-shadow:0 12px 26px rgba(15,23,42,.10);
            border:1px solid var(--line);
        }

        .summary-grid{
            display:grid;
            grid-template-columns: repeat(3,1fr);
            gap:12px;
        }
        @media (max-width: 992px){
            .summary-grid{ grid-template-columns: repeat(2,1fr); }
        }
        @media (max-width: 520px){
            .summary-grid{ grid-template-columns: 1fr; }
        }

        .summary-card{
            background:#ffffff !important;
            opacity:1 !important;
            border:1px solid var(--line);
            border-radius:16px;
            padding:14px;
            box-shadow:0 8px 18px rgba(15,23,42,.08);
            display:flex;
            align-items:center;
            gap:12px;
            position:relative;
            overflow:hidden;
            isolation:isolate;
        }
        .summary-accent{
            position:absolute; left:0; top:0; bottom:0; width:6px;
            background: var(--pink-bg);
        }
        .summary-icon{
            width:44px; height:44px; border-radius:14px;
            background: var(--pink-bg-softer);
            display:grid; place-items:center;
            color: var(--pink-ink);
            font-weight:900;
            font-size:14px;
        }
        .summary-label{
            font-size:12px; color:var(--ink-500); font-weight:800;
        }
        .summary-value{
            font-size:22px; font-weight:900; color:var(--ink-900);
            margin-top:2px;
        }

        /* ========= PANELS ========= */
        .panel{
            background:#ffffff;
            border:1px solid var(--line);
            border-radius:18px;
            box-shadow:0 12px 26px rgba(15,23,42,.10);
            overflow:hidden;
        }
        .panel-head{
            padding:12px 14px;
            border-bottom:1px solid var(--line);
        }
        .panel-title{
            font-size:13.5px;
            font-weight:900;
            color:var(--pink-ink);
            letter-spacing:.2px;
        }
        .panel-sub{
            font-size:11.5px; color:var(--ink-500); font-weight:700;
            margin-top:3px;
        }
        .panel-body{ padding:12px 14px 10px; }

        .chart-wrap-260{ height:260px; }
        .chart-wrap-300{ height:300px; }

        /* provinsi lebih kecil */
        .chart-wrap-provinsi{
            height:380px; /* base lebih kecil */
        }

        /* layout rows */
        .charts-top{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:12px;
            margin-bottom:12px;
        }
        @media (max-width: 768px){
            .charts-top{ grid-template-columns:1fr; }
        }

        .chart-full{ margin-bottom:12px; }
    </style>

    <div class="platform-page">
        <div class="platform-wrap">

            {{-- TOPBAR --}}
            <div class="topbar">
                <div class="topbar-left">
                    <div class="brand-chip">SP</div>
                    <div>
                        <h1>Dashboard Platform StudentPedia</h1>
                        <p>Ringkasan Performa StudentPedia</p>
                    </div>
                </div>

                <div class="topbar-actions">

    <a href="{{ route('platform.sellers.index') }}" class="btn-premium">
        Verifikasi Seller
    </a>

    <form method="POST" action="{{ route('logout') }}" class="d-inline">
        @csrf
        <button type="submit" class="btn-ghost danger">
            Logout
        </button>
    </form>
</div>
            </div>

            {{-- SUMMARY (SRS) --}}
            <div class="summary-wrap">
                <div class="summary-grid">
                    <div class="summary-card">
                        <span class="summary-accent"></span>
                        <div class="summary-icon">SA</div>
                        <div>
                            <div class="summary-label">Seller Aktif</div>
                            <div class="summary-value">{{ $penjualAktif }}</div>
                        </div>
                    </div>

                    <div class="summary-card">
                        <span class="summary-accent"></span>
                        <div class="summary-icon">ST</div>
                        <div>
                            <div class="summary-label">Seller Tidak Aktif</div>
                            <div class="summary-value">{{ $penjualTidakAktif }}</div>
                        </div>
                    </div>

                    <div class="summary-card">
                        <span class="summary-accent"></span>
                        <div class="summary-icon">RT</div>
                        <div>
                            <div class="summary-label">Komentar dan Rating</div>
                            <div class="summary-value">{{ $jumlahKomentar + $jumlahRating }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ROW ATAS: Keaktifan + Komentar/Rating --}}
            <div class="charts-top">
                <div class="panel">
                    <div class="panel-head">
                        <div class="panel-title">Keaktifan Penjual</div>
                        <div class="panel-sub">Approved = aktif, selain itu = tidak aktif</div>
                    </div>
                    <div class="panel-body">
                        <div class="chart-wrap-260">
                            <canvas id="chartKeaktifanSeller"
                                    data-chart='@json($keaktifanSellerChart)'></canvas>
                        </div>
                    </div>
                </div>

                <div class="panel">
                    <div class="panel-head">
                        <div class="panel-title">Pengunjung memberi Komentar & Rating</div>
                        <div class="panel-sub">Perbandingan total interaksi pengunjung</div>
                    </div>
                    <div class="panel-body">
                        <div class="chart-wrap-260">
                            <canvas id="chartRating"
                                    data-chart='@json($komentarRatingChart)'></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- FULL: Produk per Kategori --}}
            <div class="panel chart-full">
                <div class="panel-head">
                    <div class="panel-title">Sebaran Jumlah Produk per Kategori</div>
                    <div class="panel-sub">Akumulasi seluruh produk dari semua seller</div>
                </div>
                <div class="panel-body">
                    <div class="chart-wrap-300">
                        <canvas id="chartProdukKategori"
                                data-chart='@json($produkKategoriChart)'></canvas>
                    </div>
                </div>
            </div>

            {{-- FULL: Provinsi --}}
            <div class="panel">
                <div class="panel-head">
                    <div class="panel-title">Sebaran Jumlah Toko per Provinsi</div>
                </div>
                <div class="panel-body">
                    <div id="provinsiWrap" class="chart-wrap-provinsi">
                        <canvas id="chartTokoProvinsi"
                                data-chart='@json($tokoProvinsiChart)'></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                function getChartData(id) {
                    const el = document.getElementById(id);
                    return JSON.parse(el.dataset.chart || '{"labels":[],"data":[]}');
                }

                const produkChart   = getChartData('chartProdukKategori');
                const provinsiChart = getChartData('chartTokoProvinsi');
                const aktifChart    = getChartData('chartKeaktifanSeller');
                const krChart       = getChartData('chartRating');

                Chart.defaults.font.family = "Inter, system-ui, sans-serif";
                Chart.defaults.font.size = 11;
                Chart.defaults.color = "#64748b";

                const pinkMain  = "#ff5fa3";
                const pinkDark  = "#b8125b";
                const pinkSoft  = "rgba(255,95,163,0.28)";
                const pinkFill  = "rgba(255,95,163,0.12)";
                const gridSoft  = "rgba(15,23,42,0.06)";

                // BAR Produk/Kategori
                new Chart(document.getElementById('chartProdukKategori'), {
                    type: 'bar',
                    data: {
                        labels: produkChart.labels,
                        datasets: [{
                            label: 'Jumlah Produk',
                            data: (produkChart.data || []).map(Number),
                            backgroundColor: pinkSoft,
                            borderColor: pinkMain,
                            borderWidth: 1.6,
                            borderRadius: 12,
                            maxBarThickness: 52
                        }]
                    },
                    options: {
                        responsive:true,
                        maintainAspectRatio:false,
                        plugins:{
                            legend:{ display:false },
                            tooltip:{
                                backgroundColor:"#0f172a",
                                titleColor:"#fff",
                                bodyColor:"#fff",
                                padding:10,
                                cornerRadius:8
                            }
                        },
                        scales:{
                            x:{ grid:{ display:false }, ticks:{ font:{ size:10 } } },
                            y:{ beginAtZero:true, grid:{ color:gridSoft }, ticks:{ precision:0 } }
                        }
                    }
                });

                // PROVINSI (lebih kecil + label miring)
                const provWrap = document.getElementById('provinsiWrap');
                const provLabels = provinsiChart.labels || [];
                provWrap.style.height = Math.max(380, provLabels.length * 12) + "px";

                new Chart(document.getElementById('chartTokoProvinsi'), {
                    type: 'line',
                    data: {
                        labels: provinsiChart.labels,
                        datasets: [{
                            label: 'Jumlah Toko',
                            data: (provinsiChart.data || []).map(Number),
                            borderColor: pinkMain,
                            backgroundColor: pinkFill,
                            fill: true,
                            tension: 0.35,
                            pointRadius: 2.6,
                            pointHoverRadius: 4.5,
                            pointBackgroundColor: pinkDark,
                            pointBorderColor: "#fff",
                            pointBorderWidth: 2
                        }]
                    },
                    options: {
                        responsive:true,
                        maintainAspectRatio:false,
                        layout:{ padding:{ bottom: 18 } },
                        plugins:{
                            legend:{ display:false },
                            tooltip:{
                                backgroundColor:"#0f172a",
                                titleColor:"#fff",
                                bodyColor:"#fff",
                                padding:10,
                                cornerRadius:8
                            }
                        },
                        scales:{
                            x:{
                                grid:{ display:false },
                                ticks:{
                                    autoSkip:false,
                                    maxRotation:55,
                                    minRotation:55,
                                    font:{ size:9, weight:'700' },
                                    padding: 6
                                }
                            },
                            y:{
                                beginAtZero:true,
                                grid:{ color:gridSoft },
                                ticks:{ precision:0 }
                            }
                        }
                    }
                });

                function doughnut(el, chartData, colors){
                    return new Chart(document.getElementById(el), {
                        type:'doughnut',
                        data:{
                            labels: chartData.labels,
                            datasets:[{
                                data: (chartData.data || []).map(Number),
                                backgroundColor: colors,
                                borderWidth: 0,
                                hoverOffset: 6,
                                cutout: "72%"
                            }]
                        },
                        options:{
                            responsive:true,
                            maintainAspectRatio:false,
                            plugins:{
                                legend:{
                                    position:'bottom',
                                    labels:{ boxWidth:10, padding:14, font:{ size:11 } }
                                }
                            }
                        }
                    });
                }

                doughnut("chartKeaktifanSeller", aktifChart, ["#ffd3e6", pinkMain]);
                doughnut("chartRating", krChart, ["#ffd3e6", pinkMain]);
            });
        </script>
    @endpush
</x-app-layout>
