<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
// use App\Models\Student;

class SearchController extends Controller
{
    public function index()
    {
        return view('search');
    }

    public function results(Request $request)
    {
        $keyword = $request->query('query');

        $results = Product::where('nama_produk', 'like', "%$keyword%")
            ->orWhere('deskripsi', 'like', "%$keyword%")
            ->get();

        return view('result', [
            'result' => $results,
            'keyword' => $keyword
        ]);
    }

}
