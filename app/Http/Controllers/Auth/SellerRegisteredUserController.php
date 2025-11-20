<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Province;

class SellerRegisteredUserController extends Controller
{
    public function create()
    {
        $provinces = Province::all();
        return view('auth.seller-register', compact('provinces'));
    }
}
