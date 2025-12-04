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
            {{-- HANYA TOMBOL TAMBAH PRODUK --}}
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
        {{-- Card 1 --}}
        <div class="summary-card" style="flex:1;">
            <div class="summary-label">Total Produk Aktif</div>
            <div class="summary-value">{{ $products->count() }}</div>
            <div class="summary-help">
                Produk yang tampil di katalog {{ $seller->nama_toko ?? 'toko kamu' }}
            </div>
        </div>

        {{-- Card 2 --}}
        <div class="summary-card" style="flex:1;">
            <div class="summary-label">Stok Keseluruhan</div>
            <div class="summary-value">{{ $products->sum('stok') }}</div>
            <div class="summary-help">Total stok dari semua produk aktif</div>
        </div>

        {{-- Card 3 --}}
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
            {{-- Grafik 1 --}}
            <div class="bg-white rounded-2xl p-4 shadow-sm">
                <h3 class="text-sm font-semibold text-pink-700 mb-2">Sebaran Stok per Produk</h3>
                <canvas id="stockChart" height="180"></canvas>

                {{-- Tombol export PDF: produk stok < 2 --}}
                <div class="mt-3 flex justify-between items-center">
                    {{-- KIRI: tombol laporan stok segera dipesan --}}
                    <a href="{{ route('seller.products.export.lowstock') }}"
                    class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-pink-50 text-pink-700 border border-pink-200 hover:bg-pink-100 transition">
                        Export PDF – Produk stok &lt; 2
                    </a>
                </div>
            </div>

            {{-- Grafik 2 --}}
            <div class="bg-white rounded-2xl p-4 shadow-sm">
                <h3 class="text-sm font-semibold text-pink-700 mb-2">Sebaran Rating per Produk</h3>
                <canvas id="ratingChart" height="180"></canvas>
            </div>

            {{-- Grafik 3 --}}
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
                <select class="seller-select">
                    <option>Semua Status</option>
                    <option>Aktif</option>
                    <option>Stok Habis</option>
                </select>
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
                            <div class="product-name">
                                {{ \Illuminate\Support\Str::limit($product->nama_produk, 40) }}
                            </div>

                            <div class="product-price">
                                Rp {{ number_format($product->harga, 0, ',', '.') }}
                            </div>

                            <div class="product-meta-row">
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

            // Grafik 1: Stok per produk
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

            // Grafik 2: Rating per produk
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

            // Grafik 3: Pemberi rating per provinsi
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
