@extends('layouts.seller')

@section('seller-content')
    {{-- HEADER DASHBOARD --}}
    <div class="seller-header-card">
        <div class="seller-header-left">
            <div class="seller-logo-circle">
                SP
            </div>
            <div>
                <div class="seller-header-title">
                    StudentPedia Seller Center
                </div>
                <div class="seller-header-subtitle">
                    Kelola produk dan performa tokomu
                </div>
            </div>
        </div>
        <div class="seller-header-right">
            <button class="btn-outline-grey">
                Pusat Bantuan
            </button>
            {{-- Pindah ke halaman upload, bukan modal --}}
            <a href="{{ route('seller.products.create') }}" class="btn-primary-pink">
                <span>Tambah Produk</span>
                <span>＋</span>
            </a>
            <div class="seller-avatar">
                <i class="bi bi-person"></i>
            </div>
        </div>
    </div>

    {{-- SUMMARY --}}
    <div class="summary-row">
        <div class="summary-card">
            <div class="summary-label">Total Produk Aktif</div>
            <div class="summary-value">{{ $products->count() }}</div>
            <div class="summary-help">Produk yang tampil di katalog StudentPedia</div>
        </div>
        <div class="summary-card">
            <div class="summary-label">Stok Keseluruhan</div>
            <div class="summary-value">{{ $products->sum('stok') }}</div>
            <div class="summary-help">Total stok dari semua produk aktif</div>
        </div>
        <div class="summary-card">
            <div class="summary-label">Rata-rata Rating</div>
            @php
                $avgRating = round(
                    $products->filter(fn($p) => $p->average_rating)->avg('average_rating') ?? 0,
                    2
                );
            @endphp
            <div class="summary-value">{{ $avgRating }} ★</div>
            <div class="summary-help">Berdasarkan ulasan pengunjung</div>
        </div>
    </div>

    {{-- AREA PRODUK --}}
    <div class="seller-products-card">
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

        @if($products->count() > 0)
            <div class="products-grid">
                @foreach($products as $product)
                    <div class="product-card">
                        @if($product->gambar)
                            <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_produk }}">
                        @else
                            <img src="https://via.placeholder.com/300x200?text=No+Image" alt="no image">
                        @endif

                        <div class="product-card-body">
                            <div class="product-name" title="{{ $product->nama_produk }}">
                                {{ \Illuminate\Support\Str::limit($product->nama_produk, 40) }}
                            </div>
                            <div class="product-price">
                                Rp {{ number_format($product->harga, 0, ',', '.') }}
                            </div>
                            <div class="product-meta-row">
                                <div class="product-rating">
                                    ★ {{ $product->average_rating ?? '5.0' }}
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
