<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Province;

class DetailProductController extends Controller
{
    public function show($id)
    {
        $product = Product::with([
                'images',
                'mainImage',
                'ratings.user',   
                'seller',
                'variations',
            ])->findOrFail($id);

        $provinces = Province::orderBy('nama', 'asc')->get();

        return view('catalog.detailProduct', compact('product','provinces'));
    }
}
