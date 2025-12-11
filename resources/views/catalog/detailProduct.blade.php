@extends('layouts.studentpedia')

@section('content')
<div x-data="{ openBiodata: false }">
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        .thumb-nav {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.95);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border: 2px solid #f472b6;
            transition: all 0.2s ease;
        }
        .thumb-nav:hover { 
            background: #f472b6; 
            transform: scale(1.05);
        }
        .thumb-nav:hover svg { stroke: white; }
        .thumb-nav svg { 
            stroke: #f472b6;
            transition: stroke 0.2s ease;
        }
    </style>

    @php
        $imageUrls = $product->images
            ->map(function ($img) {
                return asset('storage/'.$img->path);
            })
            ->values()
            ->all();
    @endphp

    <div class="max-w-6xl mx-auto mt-10 grid grid-cols-12 gap-10">
        {{-- KOLOM KIRI: GALERI GAMBAR --}}
        <div
            class="col-span-12 md:col-span-5"
            x-data="{
                images: @js($imageUrls),
                current: 0,
                get mainImage() {
                    return this.images[this.current] || @js($product->catalog_image_url);
                }
            }"
        >
            <div class="bg-white rounded-3xl shadow-lg border border-pink-100 overflow-hidden">
                <div class="w-full h-[480px] bg-white flex items-center justify-center">
                    <img
                        :src="mainImage"
                        class="w-full h-full object-cover object-center transition-transform duration-500 hover:scale-[1.02]"
                        alt="{{ $product->nama_produk }}"
                    >
                </div>
            </div>

            {{-- THUMBNAIL + NAV --}}
            <div class="relative mt-4 flex items-center gap-2">
                {{-- BUTTON KIRI: PREV --}}
                <button
                    type="button"
                    class="thumb-nav flex-shrink-0"
                    @click="
                        if (images.length > 0) {
                            current = (current - 1 + images.length) % images.length;
                            $refs.thumb.scrollTo({
                                left: current * 92,
                                behavior: 'smooth'
                            });
                        }
                    "
                    aria-label="Gambar sebelumnya"
                >
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </button>

                {{-- LIST THUMBNAIL --}}
                <div
                    x-ref="thumb"
                    class="flex gap-3 overflow-x-auto scroll-smooth snap-x snap-mandatory
                           px-4 py-2 rounded-2xl bg-white/90 backdrop-blur
                           border border-pink-100 shadow-sm no-scrollbar flex-1"
                >
                    @foreach ($imageUrls as $idx => $url)
                        <button
                            type="button"
                            class="snap-start flex-shrink-0"
                            @click="
                                current = {{ $idx }};
                                $refs.thumb.scrollTo({
                                    left: current * 92,
                                    behavior: 'smooth'
                                });
                            "
                        >
                            <img
                                src="{{ $url }}"
                                class="w-20 h-20 rounded-xl object-cover cursor-pointer border
                                       bg-white transition duration-200 hover:scale-[1.04]"
                                :class="current === {{ $idx }}
                                          ? 'ring-2 ring-pink-400 border-pink-400'
                                          : 'border-gray-200'"
                                alt="thumbnail {{ $product->nama_produk }}"
                            >
                        </button>
                    @endforeach
                </div>

                {{-- BUTTON KANAN: NEXT --}}
                <button
                    type="button"
                    class="thumb-nav flex-shrink-0"
                    @click="
                        if (images.length > 0) {
                            current = (current + 1) % images.length;
                            $refs.thumb.scrollTo({
                                left: current * 92,
                                behavior: 'smooth'
                            });
                        }
                    "
                    aria-label="Gambar berikutnya"
                >
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </button>
            </div>
        </div>

        {{-- KOLOM KANAN: DETAIL PRODUK --}}
        <div class="col-span-12 md:col-span-7 space-y-3">
            {{-- INFO TOKO --}}
            <div class="inline-flex items-center gap-2 bg-white/90 backdrop-blur
                        px-4 py-2 rounded-xl border border-pink-100 shadow-sm">
                <div class="w-8 h-8 rounded-full bg-pink-100 flex items-center justify-center
                            text-pink-600 font-bold text-sm">
                    {{ strtoupper(substr($product->seller->nama_toko ?? $product->seller->name ?? 'T', 0, 1)) }}
                </div>
                <div class="leading-tight">
                    <p class="text-[11px] text-gray-500">Toko</p>
                    <p class="text-sm font-semibold text-gray-900">
                        {{ $product->seller->nama_toko ?? $product->seller->name ?? 'Toko' }}
                    </p>
                </div>
            </div>

            {{-- CARD DETAIL --}}
            <div class="bg-white/95 backdrop-blur rounded-3xl shadow-lg border border-pink-100 p-6 space-y-4">
                <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 leading-tight">
                    {{ $product->nama_produk }}
                </h2>

                {{-- RATING, PENILAIAN, STOK --}}
                <div class="flex flex-wrap items-center gap-3 text-[15px] text-gray-700 font-medium">
                    <div class="flex items-center gap-1">
                        <span class="text-yellow-500 text-lg">⭐</span>
                        <span class="font-bold text-gray-900">
                            {{ number_format($product->average_rating ?? 0, 1) }}
                        </span>
                    </div>
                    <span class="text-gray-300">•</span>
                    <span>{{ $product->ratings->count() }} penilaian</span>
                    <span class="text-gray-300">•</span>
                    <span>
                        Stok:
                        <b class="text-gray-900">{{ $product->stok }}</b>
                    </span>
                </div>

                {{-- KONDISI --}}
                <div class="flex items-center gap-2">
                    <p class="text-[15px] text-gray-700 font-medium">Kondisi:</p>

                    @if (strtolower($product->kondisi) === 'baru')
                        <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-600 px-3 py-1
                                     rounded-full text-sm font-semibold border border-emerald-200">
                            <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                            Baru
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-600 px-3 py-1
                                     rounded-full text-sm font-semibold border border-amber-200">
                            <span class="w-2 h-2 bg-amber-500 rounded-full"></span>
                            Bekas
                        </span>
                    @endif
                </div>

                {{-- HARGA --}}
                <p class="text-pink-600 font-extrabold text-3xl tracking-tight">
                    Rp{{ number_format($product->harga, 0, ',', '.') }}
                </p>

                {{-- BUTTON TAMBAH KOMENTAR --}}
                <button
                    type="button"
                    @click="openBiodata = true"
                    class="inline-block mt-1 bg-pink-700 hover:bg-pink-800 text-white text-sm font-semibold
                           px-5 py-2.5 rounded-lg transition"
                >
                    Tambah Komentar
                </button>

                <hr class="border-pink-100 my-1">

                {{-- DESKRIPSI --}}
                <div class="space-y-2">
                    <div class="inline-block">
                        <h3 class="text-base font-extrabold text-gray-900 inline-block relative">
                            Deskripsi Produk
                            <span class="block h-[4px] bg-pink-600 rounded-full mt-2 w-full"></span>
                        </h3>
                    </div>

                    <div class="text-gray-700 leading-relaxed text-sm md:text-base">
                        {{ $product->deskripsi }}
                    </div>
                </div>

                {{-- VARIASI PRODUK --}}
                @if ($product->variations && $product->variations->count())
                    <div class="mt-4 space-y-3">
                        <div class="inline-block">
                            <h3 class="text-sm font-extrabold text-gray-900 inline-block relative">
                                Variasi Produk
                                <span class="block h-[3px] bg-pink-500 rounded-full mt-1 w-full"></span>
                            </h3>
                        </div>

                        @foreach ($product->variations->groupBy('type') as $type => $items)
                            <div class="space-y-2">
                                <p class="text-sm font-semibold text-gray-700 capitalize">
                                    {{ str_replace('_', ' ', $type) }}:
                                </p>

                                <div class="flex flex-wrap gap-2">
                                    @foreach ($items as $item)
                                        <span class="inline-block bg-pink-50 text-pink-600 px-4 py-2 rounded-lg
                                                     text-sm font-medium border border-pink-200 hover:bg-pink-100 transition">
                                            {{ $item->value }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- LIST KOMENTAR --}}
    <div class="max-w-6xl mx-auto mt-10">
        <div class="bg-white/95 backdrop-blur p-6 rounded-3xl shadow-lg border border-pink-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-extrabold text-lg text-gray-900">Komentar</h3>
                <div class="text-sm text-gray-600">
                    ⭐ {{ number_format($product->average_rating ?? 0, 1) }} • {{ $product->ratings->count() }} ulasan
                </div>
            </div>

            @forelse ($product->ratings as $rate)
                <div class="py-4 border-b last:border-b-0 border-pink-50">
                    <div class="flex items-center justify-between">
                        <p class="font-semibold text-gray-900">
                            {{ $rate->nama_pengunjung ?? $rate->user->name ?? 'Pengunjung' }}
                        </p>
                        <p class="text-yellow-500 text-sm font-semibold">
                            ⭐ {{ $rate->rating }}
                        </p>
                    </div>

                    <p class="text-gray-700 mt-1 text-sm leading-relaxed">
                        {{ $rate->komentar }}
                    </p>
                </div>
            @empty
                <p class="text-gray-500 text-sm italic">
                    Belum ada komentar untuk produk ini.
                </p>
            @endforelse
        </div>
    </div>

    {{-- MODAL BIODATA PENGUNJUNG --}}
    <div
        x-show="openBiodata"
        x-transition
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
        style="display: none;"
    >
        <div
            @click.outside="openBiodata = false"
            class="bg-white rounded-3xl w-[90%] max-w-xl p-6 shadow-2xl border border-pink-100"
        >
            <h2 class="text-xl font-bold text-pink-600 text-center mb-4">
                Harap masukkan biodata sebelum memberi komentar!
            </h2>

            <form
                action="{{ route('visitor.store', $product->id) }}"
                method="POST"
                class="space-y-3"
            >
                @csrf

                <div>
                    <label class="text-sm font-semibold text-gray-700">Nama*</label>
                    <input
                        name="nama_pengunjung"
                        required
                        class="w-full border border-pink-200 rounded-lg px-3 py-2 mt-1 focus:border-pink-400 focus:ring-2 focus:ring-pink-100 outline-none"
                        placeholder="Nama lengkap"
                    >
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-700">Nomor HP*</label>
                    <input
                        name="nomor_hp"
                        required
                        class="w-full border border-pink-200 rounded-lg px-3 py-2 mt-1 focus:border-pink-400 focus:ring-2 focus:ring-pink-100 outline-none"
                        placeholder="08xxxxxxxxxx"
                    >
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-700">Email*</label>
                    <input
                        name="email"
                        type="email"
                        required
                        class="w-full border border-pink-200 rounded-lg px-3 py-2 mt-1 focus:border-pink-400 focus:ring-2 focus:ring-pink-100 outline-none"
                        placeholder="email@gmail.com"
                    >
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-700">Provinsi*</label>
                    <select
                        name="nama_provinsi"
                        required
                        class="w-full border border-pink-200 rounded-lg px-3 py-2 mt-1 focus:border-pink-400 focus:ring-2 focus:ring-pink-100 outline-none"
                    >
                        <option value="">-- Pilih Provinsi --</option>
                        @foreach ($provinces as $prov)
                            <option value="{{ $prov->nama }}">{{ $prov->nama }}</option>
                        @endforeach
                    </select>

                    @error('kode_provinsi')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-center pt-3">
                    <button
                        type="submit"
                        class="bg-pink-600 hover:bg-pink-700 text-white px-6 py-2.5 rounded-lg font-semibold transition"
                    >
                        Lanjut Komentar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection