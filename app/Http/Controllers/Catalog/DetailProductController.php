<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Product;

class DetailProductController extends Controller
{
    public function show($id)
    {
        // Ambil produk + semua gambar + gambar utama + rating
        $product = Product::with(['images', 'mainImage', 'ratings', 'seller'])
            ->findOrFail($id);

        return view('catalog.detailProduct', compact('product'));
    }
}
