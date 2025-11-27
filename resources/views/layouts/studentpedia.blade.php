<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>StudentPedia</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-pink-600 min-h-screen flex flex-col">

    {{-- HEADER --}}
    <header class="bg-pink-400 text-white py-4 shadow">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-6">

        {{-- LOGO --}}
           <div class="flex items-center space-x-3">
                <img src="../../../img/logo.png"
                    alt="Logo StudentPedia"
                    class="w-12 h-12 rounded-full object-cover">
                <span class="text-xl font-bold">StudentPedia</span>
            </div>

            {{-- USER ICON --}}
            {{-- USER ICON --}}
            <div class="flex items-center space-x-3">
                @guest
                    {{-- Belum login → arahkan ke halaman login --}}
                    <a href="{{ route('welcome') }}" class="p-2">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-8 h-8 text-white"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="white" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6 21v-1a6 6 0 0112 0v1" />
                        </svg>
                    </a>
                @else
                    {{-- Sudah login → ke dashboard (nanti diarahkan sesuai role: seller/platform) --}}
                    <a href="{{ route('profile.edit') }}" class="p-2">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-8 h-8 text-white"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="white" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6 21v-1a6 6 0 0112 0v1" />
                        </svg>
                    </a>
                @endguest
            </div>

        </div>
    </header>

    {{-- SEARCH + FILTER WRAPPER --}}
    <div class="mt-10 flex flex-col items-center">

        <h2 class="text-white font-bold text-2xl mb-6">Mau cari apa hari ini?</h2>

        <div class="flex items-center gap-4">

            {{-- FORM SEARCH --}}
            <form action="{{ route('search.results') }}" method="GET" class="flex items-center gap-3">

                <div class="relative w-[600px]">
                    <input type="text" name="query"
                        value="{{ request('query') }}"
                        placeholder="Cari Barang"
                        class="w-full px-6 py-3 rounded-full bg-white text-gray-700
                                border border-[#F7B3D6]/60 
                                focus:border-[#F7B3D6]
                                focus:ring-2 focus:ring-[#F7B3D6]
                                outline-none shadow-sm transition-all duration-200" />
                </div>

                <button type="submit"
                    class="flex items-center bg-pink-300 px-4 py-2 rounded-full shadow hover:bg-pink-500 transition">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </button>
            </form>

            {{-- FILTER --}}
            <div x-data="{ openFilter: false }" class="relative">

                <button type="button"
                    @click="openFilter = !openFilter"
                    class="flex items-center space-x-2 bg-white px-5 py-3 rounded-full shadow text-gray-700 font-semibold">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 4h18M6 10h12M10 16h4" />
                    </svg>
                    <span>Filter</span>
                </button>

                {{-- DROPDOWN --}}
                <div x-show="openFilter"
                    @click.outside="openFilter = false"
                    class="absolute left-1/2 -translate-x-1/2 mt-3 bg-white shadow-lg rounded-xl p-4 w-80 z-50">

                    <form action="{{ route('search.results') }}" method="GET" class="space-y-3">

                        <input type="hidden" name="query" value="{{ request('query') }}">

                        <input type="text" name="toko"
                            placeholder="Nama Toko"
                            class="w-full px-3 py-2 rounded-lg border border-pink-300">

                        <select name="category" class="w-full px-3 py-2 rounded-lg border border-pink-300">
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->nama }}</option>
                            @endforeach
                        </select>

                        <select id="provinsi" name="province" class="w-full px-3 py-2 rounded-lg border border-pink-300">
                            <option value="">Pilih Provinsi</option>
                        </select>

                        <select id="kabupaten" name="regency" class="w-full px-3 py-2 rounded-lg border border-pink-300">
                            <option value="">Pilih Kabupaten/Kota</option>
                        </select>

                        <button class="w-full bg-pink-500 text-white font-semibold py-2 rounded-lg mt-2">
                            Terapkan Filter
                        </button>
                    </form>
                </div>
            </div>

        </div> {{-- END ROW --}}

    </div>

    {{-- CONTENT --}}
    <main class="flex-1 px-6 py-6">
        @yield('content')
    </main>


    {{-- FOOTER --}}
    <footer class="bg-pink-500 py-6 text-center text-white font-bold mt-12">
        © StudentPedia 2025 — Semua Hak Dilindungi
    </footer>

</body>
</html>
