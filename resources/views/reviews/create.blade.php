<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Komentar Produk</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-[#D60A78] text-white">
    {{-- Header --}}
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

        <section class="w-full max-w-3xl bg-[#F1E4E2] text-black rounded-[36px] shadow-2xl px-12 py-12">
            {{-- product image placeholder --}}
            <div class="mx-auto w-40 h-40 border border-black/30"></div>

            <h2 class="text-xl font-semibold text-center mt-4">
                {{ $product->name }}
            </h2>

            {{-- Star Rating --}}
            <div class="flex justify-center mt-3">
                @for($i=1; $i<=5; $i++)
                    <button type="button"
                        class="star text-5xl leading-none px-[2px] text-[#D60A78]"
                        data-value="{{ $i }}">★</button>
                @endfor
            </div>

            {{-- Form hanya rating + komentar --}}
            <form action="{{ route('reviews.store', $product->id) }}" method="POST" class="mt-6">
                @csrf

                <input type="hidden" name="rating" id="ratingInput" value="5">

                {{-- Biodata hidden dari session --}}
                <input type="hidden" name="name" value="{{ $visitorName }}">
                <input type="hidden" name="phone" value="{{ $visitorPhone }}">
                <input type="hidden" name="email" value="{{ $visitorEmail }}">

                {{-- Komentar --}}
                <div class="mb-4">
                    <textarea name="comment" rows="3" placeholder="Tulis review produk..."
                        class="w-full border border-black/20 bg-white/70 px-3 py-2 outline-none resize-none">{{ old('comment') }}</textarea>
                    @error('comment')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button
                    class="block mx-auto bg-[#D60A78] text-white font-semibold px-8 py-2 rounded-md shadow">
                    Submit
                </button>
            </form>
        </section>
    </main>

    <footer class="mt-16 bg-[#EA69A9] h-20 flex items-center justify-center">
        <div class="text-xl font-bold">StudentPedia</div>
    </footer>

    <script>
        const stars = document.querySelectorAll('.star');
        const ratingInput = document.getElementById('ratingInput');
        let currentRating = 5;

        function paintStars(rating){
            stars.forEach((s, idx) => {
                s.style.opacity = (idx < rating) ? '1' : '0.3';
            });
        }

        stars.forEach(star => {
            star.addEventListener('click', () => {
                currentRating = parseInt(star.dataset.value);
                ratingInput.value = currentRating;
                paintStars(currentRating);
            });
        });

        paintStars(currentRating);
    </script>
</body>
</html>
