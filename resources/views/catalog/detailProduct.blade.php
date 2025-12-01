@extends('layouts.studentpedia')

@section('content')
<div x-data="{ openBiodata: false }">
  <style>
  .no-scrollbar::-webkit-scrollbar { display: none; }
  .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

  /* tombol geser thumbnail gaya kotak pink + segitiga */
  .thumb-nav {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    background: linear-gradient(145deg, #ffb6d9, #ff7db8);
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 20px rgba(217, 3, 104, 0.25);
    transition: 0.2s ease;
  }
  .thumb-nav:hover { transform: scale(1.06); }
  .thumb-nav:active { transform: scale(0.94); }

  .thumb-triangle {
    width: 0; height: 0;
    border-top: 8px solid transparent;
    border-bottom: 8px solid transparent;
    border-left: 14px solid white; /* segitiga kanan */
  }
  .thumb-triangle.left { transform: rotate(180deg); }
  </style>


  <div class="max-w-6xl mx-auto mt-10 grid grid-cols-12 gap-10">

    {{-- FOTO PRODUK (Modern Gallery) --}}
    <div 
      class="col-span-12 md:col-span-5"
      x-data="{
        main: '{{ $product->mainImage
                  ? asset('img/'.$product->mainImage->path)
                  : asset('img/default.jpg') }}'
      }"
    >
      {{-- MAIN IMAGE CARD --}}
      <div class="bg-white rounded-2xl shadow-sm border border-white/60 overflow-hidden">
        <div class="w-full h-[380px] bg-white flex items-center justify-center">
          <img 
            :src="main" 
            class="w-full h-full object-contain transition duration-300"
            alt="{{ $product->nama_produk }}"
          >
        </div>
      </div>

      {{-- THUMB STRIP --}}
      <div class="relative mt-4">

        {{-- LEFT ARROW (pink box style) --}}
        <button
          type="button"
          class="absolute -left-2 top-1/2 -translate-y-1/2 thumb-nav z-10"
          @click="$refs.thumb.scrollBy({ left: -220, behavior: 'smooth' })"
          aria-label="Scroll left"
        >
          <div class="thumb-triangle left"></div>
        </button>

        {{-- THUMB CONTAINER --}}
        <div
          x-ref="thumb"
          class="flex gap-3 overflow-x-auto scroll-smooth snap-x snap-mandatory
                  px-8 py-2 rounded-xl bg-white/70 backdrop-blur
                  border border-white/60 shadow-sm no-scrollbar"
        >
          @foreach ($product->images as $img)
            @php $url = asset('img/'.$img->path); @endphp

            <button type="button" class="snap-start flex-shrink-0">
              <img
                src="{{ $url }}"
                @click="main='{{ $url }}'"
                :class="main === '{{ $url }}'
                          ? 'ring-2 ring-pink-500 border-pink-500'
                          : 'border-gray-200'"
                class="w-20 h-20 rounded-xl object-cover cursor-pointer border
                        hover:scale-[1.04] transition duration-200 bg-white"
                alt="thumbnail {{ $product->nama_produk }}"
              >
            </button>
          @endforeach
        </div>

        {{-- RIGHT ARROW (pink box style) --}}
        <button
          type="button"
          class="absolute -right-2 top-1/2 -translate-y-1/2 thumb-nav z-10"
          @click="$refs.thumb.scrollBy({ left: 220, behavior: 'smooth' })"
          aria-label="Scroll right"
        >
          <div class="thumb-triangle"></div>
        </button>
      </div>
    </div>


    {{-- DETAIL PRODUK (SRS-04) --}}
  <div class="col-span-12 md:col-span-7 space-y-3">

  {{-- KOTAK TOKO TERPISAH (di atas card) --}}
  <div class="inline-flex items-center gap-2 bg-white/85 backdrop-blur
              px-4 py-2 rounded-xl border border-white/70 shadow-sm">
    <div class="w-8 h-8 rounded-full bg-pink-100 flex items-center justify-center
                text-pink-700 font-bold text-sm">
      {{ strtoupper(substr($product->seller->nama_toko ?? $product->seller->name ?? 'T', 0, 1)) }}
    </div>
    <div class="leading-tight">
      <p class="text-[11px] text-gray-500">Toko</p>
      <p class="text-sm font-semibold text-gray-900">
        {{ $product->seller->nama_toko ?? $product->seller->name ?? 'Toko' }}
      </p>
    </div>
  </div>

  {{-- CARD UTAMA DETAIL --}}
  <div class="bg-white/95 backdrop-blur rounded-2xl shadow-sm border border-white/60 p-6 space-y-4">

    {{-- NAMA PRODUK --}}
    <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 leading-tight">
      {{ $product->nama_produk }}
    </h2>

    {{-- RATING + PENILAIAN + STOK (satu baris, lebih gede) --}}
    <div class="flex flex-wrap items-center gap-3 text-[15px] text-gray-700 font-medium">
      <div class="flex items-center gap-1">
        <span class="text-yellow-500 text-lg">⭐</span>
        <span class="font-bold text-gray-900">
          {{ number_format($product->average_rating ?? 0, 1) }}
        </span>
      </div>
      <span class="text-gray-400">•</span>
      <span>{{ $product->ratings->count() }} penilaian</span>
      <span class="text-gray-400">•</span>
      <span>
        Stok:
        <b class="text-gray-900">{{ $product->stok }}</b>
      </span>
    </div>

    {{-- HARGA (tanpa kata “Harga”) --}}
    <p class="text-pink-700 font-extrabold text-3xl tracking-tight">
      Rp{{ number_format($product->harga,0,',','.') }}
    </p>

    {{-- BUTTON TAMBAH KOMENTAR --}}
    <button type="button" @click="openBiodata = true" class="inline-block mt-1 bg-pink-700 hover:bg-pink-800 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition">
      Tambah Komentar
    </button>

    <hr class="border-gray-100 my-1">

    {{-- DESKRIPSI PRODUK (section dengan garis pink) --}}
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
    </div>
  </div>
  </div>

  {{-- ✅ KOMENTAR FULL WIDTH DI BAWAH --}}
  <div class="max-w-6xl mx-auto mt-10">
  <div class="bg-white/95 backdrop-blur p-6 rounded-2xl shadow-sm border border-white/60">

    <div class="flex items-center justify-between mb-4">
      <h3 class="font-extrabold text-lg text-gray-900">Komentar</h3>
      <div class="text-sm text-gray-600">
        ⭐ {{ number_format($product->average_rating ?? 0, 1) }} • {{ $product->ratings->count() }} ulasan
      </div>
    </div>

    @forelse ($product->ratings as $rate)
      <div class="py-4 border-b last:border-b-0 border-gray-100">
        <div class="flex items-center justify-between">
          <p class="font-semibold text-gray-900">
            {{ $rate->user->name ?? 'Pengunjung' }}
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

    {{-- MODAL BIODATA --}}
  <div
    x-show="openBiodata"
    x-transition
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
    style="display: none;"
  >
    <div
      @click.outside="openBiodata = false"
      class="bg-white rounded-2xl w-[90%] max-w-xl p-6 shadow-lg"
    >
      <h2 class="text-xl font-bold text-pink-700 text-center mb-4">
        Harap masukkan biodata sebelum memberi komentar!
      </h2>

      <form action="{{ route('visitor.store', $product->id) }}" method="POST" class="space-y-3">
        @csrf

        <div>
          <label class="text-sm font-semibold">Nama*</label>
          <input name="nama_pengunjung" required
            class="w-full border rounded-lg px-3 py-2 mt-1"
            placeholder="Nama lengkap">
        </div>

        <div>
          <label class="text-sm font-semibold">Nomor HP*</label>
          <input name="nomor_hp" required
            class="w-full border rounded-lg px-3 py-2 mt-1"
            placeholder="08xxxxxxxxxx">
        </div>

        <div>
          <label class="text-sm font-semibold">Email*</label>
          <input name="email" required type="email"
            class="w-full border rounded-lg px-3 py-2 mt-1"
            placeholder="email@gmail.com">
        </div>

        <div>
          <label class="text-sm font-semibold">Provinsi*</label>
          <select name="nama_provinsi" required class="w-full border rounded-lg px-3 py-2 mt-1">
            <option value="">-- Pilih Provinsi --</option>
            @foreach($provinces as $prov)
              <option value="{{ $prov->nama }}">{{ $prov->nama }}</option>
            @endforeach
          </select>

        @error('kode_provinsi')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>


        <div class="flex justify-center pt-3">
          <button type="submit"
            class="bg-pink-600 hover:bg-pink-700 text-white px-5 py-2 rounded-lg font-semibold">
            Lanjut Komentar
          </button>
        </div>
      </form>
    </div>
  </div>

</div>




@endsection