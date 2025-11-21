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
            <a href="/profile" class="p-2">
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
        </div>
    </header>


    {{-- SEARCH + FILTER --}}
<div class="text-center mt-10">
    <h2 class="text-[#FFFFFF] font-bold text-2xl">Mau cari apa hari ini?</h2>

    <div class="mt-6 flex justify-center items-center space-x-4">

        {{-- INPUT --}}
        <div class="relative w-[600px]">
            <input type="text"
                   placeholder="Cari Barang"
                   class="w-full px-6 py-3 rounded-full bg-[#FFFFFF] text-gray-700 border-none focus:ring-2 focus:ring-pink-400 shadow" />
        </div>

        {{-- SEARCH BUTTON --}}
        <button class="flex items-center bg-[#F7B3D6] px-4 py-2 rounded-full shadow">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-6 w-6"
                 fill="none" viewBox="0 0 24 24"
                 stroke="white" stroke-width="2">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
        </button>

        {{-- FILTER BUTTON --}}
        <button class="flex items-center space-x-2 bg-white px-5 py-3 rounded-full shadow text-gray-700 font-semibold">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-6 w-6" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M3 4h18M6 10h12M10 16h4" />
            </svg>
            <span>Filter</span>
        </button>

    </div>
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
