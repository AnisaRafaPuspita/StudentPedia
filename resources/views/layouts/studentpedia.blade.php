<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>StudentPedia</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<body class="bg-pink-100 min-h-screen flex flex-col">

    {{-- HEADER --}}
    <header class="bg-pink-400 text-white py-4 shadow-md">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-6">

            {{-- LOGO --}}
            <div class="flex items-center space-x-3">
                <img src="../../../img/logo.png"
                    alt="Logo StudentPedia"
                    class="w-10 h-10 rounded-full object-cover bg-white/70 p-1">
                <span class="text-xl font-bold text-white">StudentPedia</span>
            </div>

            {{-- USER ICON --}}
            <div class="flex items-center space-x-3">
                @guest
                    <a href="{{ route('welcome') }}" class="p-2 hover:bg-pink-500/70 rounded-full transition">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-7 h-7 text-white"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6 21v-1a6 6 0 0112 0v1" />
                        </svg>
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="p-2 hover:bg-pink-500/70 rounded-full transition">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-7 h-7 text-white"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 7a4 4 0 11-8 0 4 0 4 4 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6 21v-1a6 6 0 0112 0v1" />
                        </svg>
                    </a>
                @endguest
            </div>

        </div>
    </header>

    {{-- SEARCH BAR + FILTER (kecuali kalau $hideSearch = true) --}}
    @if (!isset($hideSearch) || !$hideSearch)
        <section class="mt-8 px-4">
            <div class="max-w-5xl mx-auto flex flex-col items-center gap-4">

                <h2 class="text-gray-800 font-bold text-2xl">
                    Mau cari apa hari ini?
                </h2>

                <div class="w-full flex flex-wrap justify-center gap-3">

                    {{-- FORM SEARCH --}}
                    <form action="{{ route('search.results') }}" method="GET"
                          class="flex flex-1 min-w-[260px] max-w-3xl items-center gap-3">
                        <div class="relative flex-1">
                            <input type="text" name="query"
                                value="{{ request('query') }}"
                                placeholder="Cari produk, toko, atau kategori..."
                                class="w-full pl-11 pr-4 py-3 rounded-full bg-white text-gray-700 text-sm
                                       border border-gray-200
                                       focus:border-pink-300
                                       focus:ring-2 focus:ring-pink-100
                                       outline-none shadow-sm transition-all duration-200" />
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="absolute left-3.5 top-1/2 -translate-y-1/2 h-5 w-5 text-gray-400"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </div>

                        {{-- Tombol "Cari" kecil, bisa di-hide di layar kecil kalau mau --}}
                        <button type="submit"
                            class="hidden sm:inline-flex items-center justify-center
                                   px-5 py-3 bg-pink-500 text-white text-sm font-medium
                                   rounded-full hover:bg-pink-600 transition-colors shadow-sm">
                            Cari
                        </button>
                    </form>

                    {{-- FILTER --}}
                    <div x-data="{ openFilter: false }" class="relative">
                        <button type="button"
                            @click="openFilter = !openFilter"
                            class="flex items-center space-x-2 bg-white px-5 py-3 rounded-full border border-gray-200
                                   text-gray-700 text-sm font-medium hover:bg-gray-50 transition-colors shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 4h18M6 10h12M10 16h4" />
                            </svg>
                            <span>Filter</span>
                        </button>

                        {{-- DROPDOWN FILTER --}}
                        <div x-show="openFilter"
                            @click.outside="openFilter = false"
                            x-transition
                            class="absolute right-0 mt-3 bg-white shadow-xl rounded-xl p-5 w-80 z-50 border border-gray-100">

                            <form action="{{ route('search.results') }}" method="GET" class="space-y-3 text-sm">

                                {{-- bawa lagi keyword search --}}
                                <input type="hidden" name="query" value="{{ request('query') }}">

                                <div>
                                    <label class="text-xs font-semibold text-gray-700 mb-1.5 block">Nama Toko</label>
                                    <input type="text" name="toko"
                                        placeholder="Cari toko..."
                                        class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200
                                               focus:border-pink-300 focus:ring-2 focus:ring-pink-100 outline-none">
                                </div>

                                <div>
                                    <label class="text-xs font-semibold text-gray-700 mb-1.5 block">Kategori</label>
                                    <select name="category"
                                        class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200
                                               focus:border-pink-300 focus:ring-2 focus:ring-pink-100 outline-none">
                                        <option value="">Semua Kategori</option>
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="text-xs font-semibold text-gray-700 mb-1.5 block">Provinsi</label>
                                    <select id="provinsi" name="province"
                                        class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200
                                               focus:border-pink-300 focus:ring-2 focus:ring-pink-100 outline-none">
                                        <option value="">Pilih Provinsi</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="text-xs font-semibold text-gray-700 mb-1.5 block">Kabupaten/Kota</label>
                                    <select id="kabupaten" name="regency"
                                        class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200
                                               focus:border-pink-300 focus:ring-2 focus:ring-pink-100 outline-none">
                                        <option value="">Pilih Kabupaten/Kota</option>
                                    </select>
                                </div>

                                <button
                                    class="w-full bg-pink-500 hover:bg-pink-600 text-white text-sm font-medium
                                           py-2.5 rounded-lg mt-3 transition-colors">
                                    Terapkan Filter
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    @endif

    {{-- CONTENT --}}
    <main class="flex-1 px-4 py-8">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="bg-pink-500 py-6 text-center text-white text-sm mt-auto">
        <div class="max-w-7xl mx-auto px-6">
            <p class="font-medium">© 2025 StudentPedia. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
