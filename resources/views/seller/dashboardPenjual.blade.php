@extends('layouts.seller')

@section('seller-content')
    {{-- HEADER DASHBOARD --}}
    <div class="seller-header-card"
         style="
            background: linear-gradient(135deg, #FF2D7A, #FF6FB8);
            border-radius: 20px;
            padding: 20px 26px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 10px 25px rgba(255,45,122,0.3);
            color: white;
         ">
        <div class="seller-header-left" style="display:flex; gap:16px; align-items:center;">
            {{-- IKON SP --}}
            <div class="seller-logo-circle"
                 style="
                     width: 52px;
                     height: 52px;
                     border-radius: 14px;
                     background: linear-gradient(135deg, #FF6FB8, #FF2D7A);
                     border: 1px solid rgba(255,255,255,0.45);
                     display: flex;
                     align-items: center;
                     justify-content: center;
                     font-weight: 700;
                     font-size: 20px;
                     color: white;
                     letter-spacing: 1px;
                     box-shadow: 0 6px 14px rgba(255,45,122,0.35);
                     transition: all .25s ease;
                 "
                 onmouseover="this.style.transform='scale(1.08)'"
                 onmouseout="this.style.transform='scale(1)'"
            >
                SP
            </div>

            <div>
                <div class="seller-header-title" style="font-size:20px; font-weight:700;">
                    Halo, {{ $seller->nama_toko ?? $seller->nama_seller ?? $seller->name ?? 'Seller' }}
                </div>

                <div class="seller-header-subtitle" style="font-size:13px; opacity:0.9;">
                    StudentPedia Seller Center · Kelola produk dan performa tokomu
                </div>
            </div>
        </div>

        <div class="seller-header-right" style="display:flex; gap:14px; align-items:center;">
            <a href="{{ route('seller.products.create') }}"
               class="btn-primary-pink"
               style="
                    padding:8px 18px;
                    background:#fff;
                    color:#FF2D7A;
                    border-radius:10px;
                    font-weight:600;
                    display:inline-flex;
                    align-items:center;
                    gap:6px;
               ">
                <span>Tambah Produk</span>
                <span>＋</span>
            </a>
        </div>
    </div>

    {{-- SUMMARY (3 BOX RATA 1 BARIS) --}}
    <div class="summary-row"
         style="
            margin-top:25px;
            display:flex;
            gap:18px;
         ">
        <div class="summary-card" style="flex:1;">
            <div class="summary-label">Total Produk Aktif</div>
            <div class="summary-value">{{ $products->count() }}</div>
            <div class="summary-help">
                Produk yang tampil di katalog {{ $seller->nama_toko ?? 'toko kamu' }}
            </div>
        </div>

        <div class="summary-card" style="flex:1;">
            <div class="summary-label">Stok Keseluruhan</div>
            <div class="summary-value">{{ $products->sum('stok') }}</div>
            <div class="summary-help">Total stok dari semua produk aktif</div>
        </div>

        <div class="summary-card" style="flex:1;">
            <div class="summary-label">Rata-rata Rating</div>
            @php
                $avgRating = round(
                    $products
                        ->filter(fn($p) => $p->average_rating !== null)
                        ->avg('average_rating') ?? 0,
                    2
                );
            @endphp
            <div class="summary-value">{{ $avgRating }} ★</div>
            <div class="summary-help">Berdasarkan ulasan pengunjung</div>
        </div>
    </div>

    {{-- DASHBOARD GRAFIS --}}
    <div class="seller-products-card mb-4" style="margin-top:25px;">
        <div class="seller-products-header">
            <div>
                <div class="seller-products-title">Dashboard Grafis Toko</div>
                <div class="seller-products-subtitle">
                    Menampilkan sebaran stok setiap produk, sebaran nilai rating per produk,
                    dan sebaran pemberi rating berdasarkan lokasi provinsi.
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" style="margin-top:12px;">
            <div class="bg-white rounded-2xl p-4 shadow-sm">
                <h3 class="text-sm font-semibold text-pink-700 mb-2">Sebaran Stok per Produk</h3>
                <canvas id="stockChart" height="180"></canvas>
                <div class="mt-3 flex justify-end">
                    <a href="{{ route('seller.grafik.pdf', 'stok') }}"
                       class="px-3 py-1 rounded-lg border border-pink-500 text-pink-600 text-sm hover:bg-pink-50">
                        Download PDF
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-4 shadow-sm">
                <h3 class="text-sm font-semibold text-pink-700 mb-2">Sebaran Rating per Produk</h3>
                <canvas id="ratingChart" height="180"></canvas>
                <div class="mt-3 flex justify-end">
                    <a href="{{ route('seller.grafik.pdf', 'rating') }}"
                       class="px-3 py-1 rounded-lg border border-pink-500 text-pink-600 text-sm hover:bg-pink-50">
                        Download PDF
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-4 shadow-sm">
                <h3 class="text-sm font-semibold text-pink-700 mb-2">Pemberi Rating per Provinsi</h3>
                <canvas id="provinceChart" height="180"></canvas>
            </div>
        </div>
    </div>

    {{-- AREA PRODUK --}}
    <div class="seller-products-card" style="margin-top:20px;">
        <div class="seller-products-header">
            <div>
                <div class="seller-products-title">Produk Saya</div>
                <div class="seller-products-subtitle">
                    Kelola harga, stok, dan informasi produkmu
                </div>
            </div>

            <div class="seller-products-filters">
                <input type="text" class="seller-search" placeholder="Cari nama produk...">
                {{-- dropdown status dihapus --}}
            </div>
        </div>

        {{-- Notifikasi --}}
        @if(session('success'))
            <div class="alert alert-success py-1 px-2 mb-2" style="font-size: 13px;">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger py-1 px-2 mb-2" style="font-size: 13px;">
                <ul class="mb-0">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Products Grid --}}
        @if($products->count() > 0)
            <div class="products-grid">
                @foreach($products as $product)
                    @php
                        $productRating = round($product->average_rating ?? 0, 1);

                        $variationLabels = [
                            'warna'         => 'Warna',
                            'ukuran_sepatu' => 'Ukuran Sepatu',
                            'ukuran_baju'   => 'Ukuran Baju',
                        ];

                        // group variasi berdasarkan type
                        $variationGroups = $product->variations->groupBy('type');
                    @endphp

                    <div class="product-card">
                        {{-- FOTO BESAR --}}
                        @if($product->gambar)
                            <img src="{{ asset('storage/' . $product->gambar) }}"
                                 alt="{{ $product->nama_produk }}"
                                 style="width:100%; height:220px; object-fit:cover;">
                        @else
                            <img src="https://via.placeholder.com/400x260?text=No+Image"
                                 alt="no image"
                                 style="width:100%; height:220px; object-fit:cover;">
                        @endif

                        <div class="product-card-body">
                            {{-- NAMA PRODUK + KONDISI DI SAMPING --}}
                            <div style="display:flex; justify-content:space-between; align-items:center; gap:8px; margin-bottom:4px;">
                                <div class="product-name" style="margin-bottom:0;">
                                    {{ \Illuminate\Support\Str::limit($product->nama_produk, 40) }}
                                </div>

                                <div>
                                    @if($product->kondisi === 'baru')
                                        <span style="
                                            background:#dcfce7;
                                            color:#166534;
                                            padding:2px 10px;
                                            font-size:11px;
                                            border-radius:999px;
                                            border:1px solid #bbf7d0;
                                            white-space:nowrap;
                                        ">
                                            Baru
                                        </span>
                                    @else
                                        <span style="
                                            background:#fff7cd;
                                            color:#854d0e;
                                            padding:2px 10px;
                                            font-size:11px;
                                            border-radius:999px;
                                            border:1px solid #facc15;
                                            white-space:nowrap;
                                        ">
                                            Bekas
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- HARGA + VARIASI DALAM 1 BARIS --}}
                            <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:8px; margin-top:4px;">
                                <div>
                                    <div class="product-price">
                                        Rp {{ number_format($product->harga, 0, ',', '.') }}
                                    </div>
                                </div>

                                <div style="min-width:90px; text-align:right;">
                                    @if($variationGroups->isNotEmpty())
                                        @foreach($variationGroups as $type => $rows)
                                            <div style="margin-bottom:2px;">
                                                <div style="font-size:10px; font-weight:600; color:#9f1239; margin-bottom:2px;">
                                                    {{ $variationLabels[$type] ?? ucfirst(str_replace('_',' ',$type)) }}
                                                </div>
                                                <div style="display:flex; flex-wrap:wrap; gap:4px; justify-content:flex-end;">
                                                    @foreach($rows as $row)
                                                        <span style="
                                                            border-radius:999px;
                                                            border:1px solid #fecaca;
                                                            background:#ffe4f5;
                                                            padding:1px 7px;
                                                            font-size:11px;
                                                            color:#7f1d1d;
                                                        ">
                                                            {{ $row->value }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div style="display:flex; justify-content:flex-end;">
                                            <span style="
                                                border-radius:999px;
                                                border:1px dashed #fecaca;
                                                background:#ffeef7;
                                                padding:1px 8px;
                                                font-size:11px;
                                                color:#9f1239;
                                                opacity:.8;
                                            ">
                                                Tanpa variasi
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- DESKRIPSI SINGKAT --}}
                            <div style="font-size: 12px; color:#7f1d1d; margin-top:6px; min-height:32px;">
                                {{ \Illuminate\Support\Str::limit($product->deskripsi, 80) }}
                            </div>

                            <div class="product-meta-row" style="margin-top:6px;">
                                <div class="product-rating">
                                    ★ {{ number_format($productRating, 1) }}
                                    <span style="color:#9F1239;">
                                        ({{ $product->ratings->count() }})
                                    </span>
                                </div>
                                <div class="product-stock">
                                    Stok: {{ $product->stok }}
                                </div>
                            </div>

                            <div class="product-card-footer">
                                <a href="{{ route('seller.products.edit', $product->id) }}"
                                   class="btn-sm-outline">
                                    Edit
                                </a>

                                <form action="{{ route('seller.products.destroy', $product->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Hapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-sm-outline">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                Belum ada produk.
                <div class="mt-2">
                    <a href="{{ route('seller.products.create') }}" class="btn-primary-pink">
                        + Tambah Produk
                    </a>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const stockChart    = @json($stockChart);
            const ratingChart   = @json($ratingChart);
            const provinceChart = @json($provinceChart);

            new Chart(document.getElementById('stockChart'), {
                type: 'bar',
                data: {
                    labels: stockChart.labels,
                    datasets: [{
                        data: stockChart.data,
                        backgroundColor: 'rgba(255,107,176,0.75)',
                        borderColor: '#E01183',
                        borderWidth: 1,
                        borderRadius: 8,
                    }]
                },
                options: {
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true } }
                }
            });

            new Chart(document.getElementById('ratingChart'), {
                type: 'bar',
                data: {
                    labels: ratingChart.labels,
                    datasets: [{
                        data: ratingChart.data,
                        backgroundColor: 'rgba(255,160,200,0.75)',
                        borderColor: '#FF6FB8',
                        borderWidth: 1,
                        borderRadius: 8,
                    }]
                },
                options: {
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true, max: 5 } }
                }
            });

            new Chart(document.getElementById('provinceChart'), {
                type: 'pie',
                data: {
                    labels: provinceChart.labels,
                    datasets: [{
                        data: provinceChart.data,
                        backgroundColor: [
                            '#FFE4F4',
                            '#FFC1E5',
                            '#FF8AC2',
                            '#FF5AA5',
                            '#E01183'
                        ],
                        borderColor: '#ffffff',
                        borderWidth: 2,
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { font: { size: 10 } }
                        }
                    }
                }
            });
        });
    </script>
@endpush
