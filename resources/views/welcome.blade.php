<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Katalog PPL</title>
        
        @vite(['resources/css/app.css', 'resources/js/app.js']) 

        <style>
            /* Tambahkan style kustom Anda di sini jika perlu */
        </style>
    </head>
    <body class="antialiased">
        <div class="relative min-h-screen bg-pink-100 dark:bg-gray-900">
            
            @if (Route::has('login'))
                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="max-w-7xl mx-auto p-6 lg:p-8 text-center pt-24">
                <h1 class="text-4xl font-bold text-gray-800">Selamat Datang di Katalog StudentPedia</h1>
                <p class="mt-4 text-gray-600">SELAMAT BERBELANJA</p>
                
                
                <div class="mt-10">
                    <a href="{{ route('register') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-all">
                        Mulai Registrasi
                    </a>
                </div>
            </div>

            <div class="fixed bottom-0 left-0 right-0 p-6 text-center text-sm text-gray-500">
                Katalog PPL by Rimbun Sekali
            </div>

        </div>
    </body>
</html>