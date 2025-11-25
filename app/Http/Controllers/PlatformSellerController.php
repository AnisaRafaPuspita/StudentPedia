<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Http\Request;

class PlatformSellerController extends Controller
{
    public function index()
    {
        $sellers = Seller::orderBy('created_at', 'desc')->paginate(10);

        return view('platform.sellers.index', compact('sellers'));
    }

    public function approve(Seller $seller)
    {
        $seller->update([
            'status_verifikasi' => 'approved',
        ]);

        // TODO: email approved

        return redirect()->back()->with('status', 'Seller berhasil di-approve.');
    }

    public function reject(Seller $seller)
    {
        $seller->update([
            'status_verifikasi' => 'rejected',
        ]);

        // TODO: email rejected

        return redirect()->back()->with('status', 'Seller berhasil di-reject.');
    }
}
