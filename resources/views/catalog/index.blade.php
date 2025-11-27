@extends('layouts.studentpedia')

@section('content')

<div class="max-w-6xl mx-auto mt-10 pb-20">

    {{-- Judul hasil pencarian cuma muncul kalau dari search --}}
    @if(!empty($from_search))
        <h2 class="text-white text-xl mt-4 mb-6">
            Hasil pencarian untuk: <b>{{ $keyword }}</b>
        </h2>
    @endif

    {{-- GRID PRODUK --}}
    <div class="grid grid-cols-4 gap-6">

        @forelse ($products as $product)
            <a href="{{ route('product.detailProduct', $product->id) }}" class="block">
                <div class="bg-white p-3 rounded-xl shadow border border-gray-200 hover:shadow-xl transition">

                    {{-- GAMBAR PRODUK --}}
                    <div class="w-full h-40 rounded-lg overflow-hidden bg-gray-100">
                        <img 
                            src="{{ $product->mainImage
                                    ? asset('img/' . $product->mainImage->path)
                                    : asset('img/default.jpg') }}"
                            class="w-full h-full object-cover"
                            alt="{{ $product->nama_produk }}"
                        >
                    </div>

                    {{-- NAMA PRODUK --}}
                    <p class="font-semibold text-sm mt-3 leading-tight">
                        {{ $product->nama_produk }}
                    </p>

                    {{-- HARGA --}}
                    <p class="text-pink-700 font-bold text-sm mt-1">
                        Rp{{ number_format($product->harga, 0, ',', '.') }}
                    </p>

                    {{-- RATING --}}
                    <p class="text-xs text-gray-600 mt-1">
                        ⭐ {{ number_format($product->average_rating ?? 0, 1) }}
                    </p>

                </div>
            </a>

        @empty
            {{-- Kalau kosong, bikin full lebar grid --}}
            <div class="col-span-4 bg-white/80 p-6 rounded-xl shadow text-center text-gray-700">
                Produk tidak ditemukan.
            </div>
        @endforelse

    </div>

    {{-- PAGINATION (placeholder) --}}
    <div class="text-center mt-6 text-gray-100 text-sm">
        &lt;1&gt;
    </div>

</div>

@endsection
