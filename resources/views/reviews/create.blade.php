@extends('layouts.studentpedia')
@php $hideSearch = true; @endphp
@section('content')
<div class="max-w-xl mx-auto mt-10 bg-white/95 p-6 rounded-2xl shadow">
    <h2 class="text-2xl font-bold mb-4 text-center">Komentar Produk</h2>

    <div class="text-center mb-4">
        <p class="font-semibold">{{ $product->nama_produk }}</p>
    </div>

    <form action="{{ route('reviews.store', $product->id) }}" method="POST">
        @csrf

        {{-- rating --}}
        <label class="block font-semibold mb-1">Rating (1 - 5)</label>
        <select name="rating" class="w-full border rounded-lg p-2 mb-3">
            <option value="">Pilih rating</option>
            @for($i=1; $i<=5; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
            @endfor
        </select>

        @if ($errors->any())
            <div class="text-red-600 text-sm mb-3">
                <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
                </ul>
            </div>
        @endif


        {{-- komentar --}}
        <label class="block font-semibold mb-1">Komentar</label>
        <textarea name="komentar" rows="4"
            class="w-full border rounded-lg p-2 mb-3"
            placeholder="Tulis ulasanmu...">{{ old('komentar') }}</textarea>
        @error('komentar') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

        <button type="submit"
            class="w-full bg-pink-700 hover:bg-pink-800 text-white font-semibold py-2 rounded-lg">
            Submit
        </button>
    </form>
</div>
@endsection
