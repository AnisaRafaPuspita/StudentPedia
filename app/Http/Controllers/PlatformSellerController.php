<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SellerApprovedMail;
use App\Mail\SellerRejectedMail;





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

        Mail::to($seller->email_pic)->send(new SellerApprovedMail($seller));

        return redirect()->back()->with('status', 'Seller berhasil di-approve.');
    }


    public function reject(Seller $seller)
    {
        $seller->update([
            'status_verifikasi' => 'rejected',
        ]);

        Mail::to($seller->email_pic)->send(new SellerRejectedMail($seller));

        return redirect()->back()->with('status', 'Seller berhasil di-reject.');
    }

}
