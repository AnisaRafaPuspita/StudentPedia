<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Seller;

class SellerStatusController extends Controller
{
    public function pending()
    {
        // ambil seller milik user yang lagi login
        $seller = Seller::where('user_id', Auth::id())->first();

        return view('seller.pending', compact('seller'));
    }
}
