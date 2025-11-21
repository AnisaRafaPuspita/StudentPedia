<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function results(Request $request)
    {
        $keyword  = $request->query('query');
        $category = $request->query('category');
        $harga    = $request->query('harga');
        $toko     = $request->query('toko');
        $provinsi = $request->query('province');
        $regency  = $request->query('regency');

        // MULAI QUERY
        $products = Product::with(['seller.province', 'seller.regency']);

        // Keyword
        if ($keyword) {
            $products->where(function ($q) use ($keyword) {
                $q->where('nama_produk', 'like', "%$keyword%");
            });
        }

        // Kategori
        if ($category) {
            $products->where('category_id', $category);
        }

        // Nama toko
        if ($toko) {
            $products->whereHas('seller', function ($q) use ($toko) {
                $q->where('nama_toko', 'like', "%$toko%");
            });
        }

        // Provinsi
        if ($provinsi) {
            $products->whereHas('seller', function ($q) use ($provinsi) {
                $q->where('province_kode', $provinsi);
            });
        }

        // Kabupaten
        if ($regency) {
            $products->whereHas('seller', function ($q) use ($regency) {
                $q->where('regency_kode', $regency);
            });
        }

        // AMBIL DATA
        $products = $products->get();

        return view('catalog.index', [
            'products'    => $products,
            'keyword'     => $keyword,
            'from_search' => true
        ]);
    }

    public function index()
    {
        return redirect()->route('search.results');
    }
}
