@extends('layouts.studentpedia')
@php $hideSearch = true; @endphp
@section('content')
<div class="max-w-xl mx-auto mt-16 bg-white/95 p-8 rounded-2xl shadow text-center">
    <h2 class="text-3xl font-extrabold text-pink-700 mb-3">Terima kasih!</h2>

    <p class="text-gray-700">
        Terima kasih <b>{{ $user }}</b> sudah memberi ulasan untuk
        <b>{{ $product->nama_produk }}</b>.
    </p>

    <p class="text-gray-600 mt-2">
        Kami juga sudah mengirim email terima kasih ke alamatmu 📩
    </p>

    <a href="{{ route('product.detailProduct', $product->id) }}"
       class="inline-block mt-6 bg-pink-700 text-white px-5 py-2 rounded-lg">
        Kembali ke produk
    </a>
</div>
@endsection
