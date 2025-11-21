<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Hasil Pencarian</h2>
    </x-slot>

    <div class="max-w-6xl mx-auto mt-10">

        {{-- FILTER --}}
        <div class="bg-white shadow rounded-lg p-4 mb-5">
            <form action="{{ route('search.results') }}" method="GET" class="flex flex-wrap gap-4">

                <input type="hidden" name="query" value="{{ request('query') }}">

                <select name="category" class="border rounded px-3 py-2">
                    <option value="">Semua Kategori</option>
                    <option value="1" @selected(request('category') == 1)>Elektronik</option>
                    <option value="2" @selected(request('category') == 2)>Fashion</option>
                    <option value="3" @selected(request('category') == 3)>Kecantikan</option>
                </select>

                <select name="harga" class="border rounded px-3 py-2">
                    <option value="">Semua Harga</option>
                    <option value="1" @selected(request('harga') == 1)>&lt; 100.000</option>
                    <option value="2" @selected(request('harga') == 2)>100.000 - 500.000</option>
                    <option value="3" @selected(request('harga') == 3)>500.000 - 1.000.000</option>
                    <option value="4" @selected(request('harga') == 4)>&gt; 1.000.000</option>
                </select>

                <button class="px-4 py-2 bg-[#D90368] text-white rounded">
                    Terapkan
                </button>
            </form>
        </div>

        <h3 class="text-gray-700 mb-4">Hasil pencarian untuk: <b>{{ $keyword }}</b></h3>

        {{-- GRID PRODUK (SAMA PERSIS KATALOG) --}}
        <div class="grid grid-cols-4 gap-6">

            @forelse ($products as $product)
                <div class="bg-white p-3 rounded-xl shadow border border-gray-200">

                    {{-- GAMBAR PRODUK --}}
                    <div class="w-full h-40 rounded-lg overflow-hidden bg-gray-100">
                        <img src="{{ asset('storage/products/' . ($product->gambar ?? 'default.png')) }}"
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
            @empty
                <p class="text-gray-600">Tidak ada produk ditemukan.</p>
            @endforelse
        </div>

    </div>
</x-app-layout>
