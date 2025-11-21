<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Hasil Pencarian</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto mt-6">

        <!-- FILTER SECTION -->
        <div class="bg-white shadow rounded-lg p-4 mb-4">
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

        <!-- HASIL -->
        <h3 class="text-gray-700 mb-4">Hasil untuk: <b>{{ $keyword }}</b></h3>

        @if($result->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
                @foreach ($result as $item)
                    <div class="p-4 border rounded shadow hover:shadow-lg transition bg-white">
                        <h3 class="font-bold text-lg">{{ $item->nama_produk }}</h3>
                        <p class="text-sm text-gray-600">{{ Str::limit($item->deskripsi, 80) }}</p>
                        <p class="text-[#D90368] font-bold mt-2">
                            Rp {{ number_format($item->harga, 0, ',', '.') }}
                        </p>
                        <p class="text-xs text-gray-500">Stok: {{ $item->stok }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-600">Tidak ada data ditemukan.</p>
        @endif

    </div>

</x-app-layout>
