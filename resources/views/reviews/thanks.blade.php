<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terima Kasih</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-[#D60A78] text-white">
    <header class="bg-[#EA69A9] h-16 flex items-center px-6">
        <div class="flex items-center gap-2">
            <div class="w-9 h-9 rounded-full bg-white flex items-center justify-center text-[#D60A78] font-extrabold">
                SP
            </div>
            <span class="font-semibold">StudentPedia</span>
        </div>
        <nav class="mx-auto text-sm font-semibold">Beranda</nav>
        <div class="text-xl">👤</div>
    </header>

    <main class="flex flex-col items-center pt-16 px-4">
        <h1 class="text-3xl font-bold mb-8">Komentar</h1>

        <section class="w-full max-w-3xl bg-[#F1E4E2] text-black rounded-[36px] shadow-2xl px-12 py-14 text-center">
            <p class="text-lg font-medium leading-relaxed">
                Terimakasih atas komentar yang telah anda berikan<br>
                {{ $user }} !
            </p>

            <a href="{{ url('/') }}"
               class="inline-block mt-6 bg-[#D60A78] text-white font-semibold px-7 py-2 rounded-md shadow">
                Kembali
            </a>
        </section>
    </main>

    <footer class="mt-16 bg-[#EA69A9] h-20 flex items-center justify-center">
        <div class="text-xl font-bold">StudentPedia</div>
    </footer>
</body>
</html>
