@extends('layouts.studentpedia')

@section('content')

<div class="max-w-7xl mx-auto pb-16 px-4 sm:px-6 lg:px-8">

    {{-- HERO / KATALOG UTAMA --}}
    @if(empty($from_search))
    <section class="mb-12">
        <div class="relative bg-gradient-to-br from-pink-500 via-pink-400 to-rose-400
                    rounded-3xl shadow-2xl overflow-hidden group">

            {{-- DEKORASI BACKGROUND --}}
            <div class="absolute inset-0 bg-gradient-to-tr from-pink-600/20 to-transparent"></div>
            <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
            <div class="absolute bottom-0 left-0 w-80 h-80 bg-pink-600/20 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>

            {{-- LABEL KECIL DI POJOK KIRI ATAS --}}
            <div class="absolute top-6 left-7 z-10">
                <div class="flex items-center gap-2 backdrop-blur-md bg-white/20 px-4 py-2 rounded-full border border-white/30">
                    <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
                    <p class="text-[11px] uppercase tracking-[0.15em] text-white font-semibold">
                        StudentPedia · Catalog
                    </p>
                </div>
            </div>

            {{-- BANNER GAMBAR FULL BOX --}}
            <img
                src="{{ asset('img/banner studentpedia.png') }}"
                alt="StudentPedia Catalog"
                class="w-full h-[220px] sm:h-[280px] md:h-[320px] lg:h-[360px]
                       object-cover relative z-[1] group-hover:scale-[1.02] transition-transform duration-700"
            >

            {{-- GRADIENT OVERLAY BOTTOM --}}
            <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-pink-900/30 to-transparent z-[2]"></div>
        </div>
    </section>

    {{-- KATEGORI CHIP --}}
    @isset($categories)
    <section class="mb-10">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="text-lg font-bold text-gray-900 mb-1">
                    Jelajahi Kategori
                </h2>
                <p class="text-xs text-gray-500">Temukan produk favoritmu dengan mudah</p>
            </div>
        </div>

        <div class="flex flex-wrap gap-2.5">
            @foreach($categories as $cat)
                <a href="{{ route('search.results', ['category' => $cat->id]) }}"
                   class="group px-5 py-2.5 rounded-full text-xs font-medium
                          bg-gradient-to-r from-pink-50 to-rose-50 border-2 border-pink-200
                          text-gray-700 hover:from-pink-500 hover:to-rose-500 hover:text-white
                          hover:border-pink-500 hover:shadow-lg hover:shadow-pink-200
                          hover:-translate-y-0.5 transition-all duration-300">
                    <span class="inline-block group-hover:scale-110 transition-transform duration-300">
                        {{ $cat->nama }}
                    </span>
                </a>
            @endforeach
        </div>
    </section>
    @endisset

    @else
    {{-- MODE SEARCH --}}
    <section class="mb-8">
        <div class="bg-gradient-to-r from-pink-50 to-rose-50 rounded-2xl p-6 border border-pink-200">
            <p class="text-xs text-gray-600 font-medium uppercase tracking-wide mb-1">Hasil Pencarian</p>
            <h1 class="text-2xl font-bold bg-gradient-to-r from-pink-600 to-rose-600 bg-clip-text text-transparent">
                "{{ $keyword }}"
            </h1>
        </div>
    </section>
    @endif


    {{-- GRID PRODUK --}}
    <section>
        {{-- HEADER SECTION --}}
        @if(!empty($products) && count($products) > 0)
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-gray-900">
                {{ empty($from_search) ? 'Semua Produk' : 'Produk Ditemukan' }}
            </h2>
            <span class="text-xs text-gray-500 bg-pink-50 px-3 py-1 rounded-full">
                {{ count($products) }} produk
            </span>
        </div>
        @endif

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 lg:gap-5">

            @forelse ($products as $product)
                @php
                    $avgRating = $product->average_rating ?? 0;
                    $countRating = $product->ratings_count
                        ?? (isset($product->ratings) ? $product->ratings->count() : 0);
                @endphp

                <a href="{{ route('product.detailProduct', $product->id) }}" class="block group">
                    <div class="bg-white rounded-2xl border-2 border-pink-100 overflow-hidden
                                hover:border-pink-300 hover:shadow-xl hover:shadow-pink-100
                                hover:-translate-y-1 transition-all duration-300">

                        {{-- GAMBAR PRODUK --}}
                        <div class="relative w-full aspect-square bg-gradient-to-br from-pink-50 to-rose-50 overflow-hidden">
                            <img
                                src="{{ $product->catalog_image_url }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                alt="{{ $product->nama_produk }}"
                            >
                            

                        </div>

                        {{-- INFO PRODUK --}}
                        <div class="p-3.5">
                            <h3 class="font-semibold text-[15px] leading-snug line-clamp-2 h-[42px]
                                       text-gray-800 group-hover:text-pink-600 transition-colors mb-0.5">
                                {{ $product->nama_produk }}
                            </h3>

                            <div class="space-y-2">
                                <p class="text-pink-600 font-bold text-base">
                                    Rp{{ number_format($product->harga, 0, ',', '.') }}
                                </p>

                                <div class="flex items-center gap-1.5">
                                    <div class="flex items-center bg-yellow-50 px-2 py-0.5 rounded-full border border-yellow-200">
                                        <span class="text-yellow-500 text-xs mr-1">★</span>
                                        <span class="font-bold text-[11px] text-gray-800">
                                            {{ number_format($avgRating, 1) }}
                                        </span>
                                    </div>
                                    <span class="text-[10px] text-gray-500">
                                        ({{ $countRating }})
                                    </span>
                                </div>
                            </div>

                            {{-- ACTION BUTTON --}}
                            <div class="mt-3">
                                <div class="w-full bg-[#D91A7E] text-white
                                           text-xs font-semibold py-2 rounded-xl text-center
                                           group-hover:bg-[#C01670] group-hover:shadow-lg 
                                           transition-all duration-300">
                                    Lihat Detail
                                </div>
                            </div>
                        </div>

                    </div>
                </a>

            @empty
                <div class="col-span-full">
                    <div class="bg-gradient-to-br from-pink-50 via-white to-rose-50 rounded-3xl p-12 text-center 
                                border-2 border-dashed border-pink-300 shadow-lg">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-pink-100 rounded-full mb-4">
                            <svg class="w-10 h-10 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Produk Tidak Ditemukan</h3>
                        <p class="text-sm text-gray-600 mb-6">Coba ubah kata kunci pencarian atau filter kategori.</p>
                        <a href="{{ route('search.results') }}" 
                           class="inline-flex items-center gap-2 bg-gradient-to-r from-pink-500 to-rose-500 
                                  text-white px-6 py-3 rounded-xl font-semibold hover:shadow-lg 
                                  hover:-translate-y-0.5 transition-all duration-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Kembali ke Katalog
                        </a>
                    </div>
                </div>
            @endforelse

        </div>
    </section>

</div>

@endsection