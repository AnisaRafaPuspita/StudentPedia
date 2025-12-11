<?php 

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Product;

class CatalogController extends Controller
{
    public function index()
    {
        $products = Product::with([
                'mainImage', 
                'images'
            ])
            ->withCount('ratings') 
            ->get();

        return view('catalog.index', compact('products'));
    }
}
