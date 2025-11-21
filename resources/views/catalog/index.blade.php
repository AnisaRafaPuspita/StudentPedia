@extends('layouts.studentpedia')

@section('content')

<div class="max-w-6xl mx-auto mt-10">

    {{-- GRID PRODUK --}}
    <div class="grid grid-cols-4 gap-6">

        @foreach ($products as $product)
            <div class="bg-white p-3 rounded-xl shadow border border-gray-200">

                {{-- GAMBAR PRODUK --}}
                <div class="w-full h-40 rounded-lg overflow-hidden bg-gray-100">
                    <img src="{{ asset('storage/products/'.$product->gambar) }}"
                         class="w-full h-full object-cover">
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
                    ⭐ {{ $product->average_rating ?? '5.0' }}
                </p>

            </div>
        @endforeach

    </div>
</div>

{{-- PAGINATION (placeholder) --}}
<div class="text-center mt-6 text-gray-700 text-sm">
    &lt;1&gt;
</div>

@endsection
