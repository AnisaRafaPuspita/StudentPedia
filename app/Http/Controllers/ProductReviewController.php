<?php

namespace App\Http\Controllers;

use App\Mail\ReviewThanksMail;
use App\Models\Rating;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ProductReviewController extends Controller
{
    /**
     * 1) handle biodata popup -> simpan ke session
     */
    public function storeVisitor(Request $request, Product $product)
    {
        $validated = $request->validate([
            'nama_pengunjung'  => ['required','string','max:100'],
            'nomor_hp'         => ['required','string','max:20'],
            'email'            => ['required','email','max:100'],
            'nama_provinsi'    => ['required', 'string'],
        ]);

        session([
            'visitor_name'  => $validated['nama_pengunjung'],
            'visitor_phone' => $validated['nomor_hp'],
            'visitor_email' => $validated['email'],
            'visitor_prov'  => $validated['nama_provinsi'],
        ]);

        return redirect()->route('reviews.create', $product->id);
    }


    /**
     * 2) halaman form komentar
     */
    public function create(Product $product)
    {
        if (!session('visitor_name') || !session('visitor_phone') || !session('visitor_email')) {
            return redirect()
                ->route('product.detailProduct', $product->id)
                ->with('msg', 'Isi biodata dulu sebelum komentar ya!');
        }

        return view('reviews.create', [
            'product' => $product
        ]);
    }

    /**
     * 3) simpan rating + komentar + email thankyou
     */
    public function store(Request $request, Product $product)
    {
        $visitorName  = session('visitor_name');
        $visitorPhone = session('visitor_phone');
        $visitorEmail = session('visitor_email');
        $visitorProv = session('visitor_prov');

        if (!$visitorName || !$visitorPhone || !$visitorEmail || !$visitorProv) {
            return redirect()
                ->route('product.detailProduct', $product->id)
                ->with('msg', 'Isi biodata dulu sebelum komentar ya!');
        }

        $validated = $request->validate([
            'rating'   => ['required','integer','min:1','max:5'],
            'komentar' => ['required','string','max:1000'],
        ]);

        // 1) simpan ke ratings 
        $rating = Rating::create([
            'product_id'      => $product->id,
            'nama_pengunjung' => $visitorName,
            'email'           => $visitorEmail,
            'nomor_hp'        => $visitorPhone,
            'nama_provinsi'   => $visitorProv,
            'komentar'        => $validated['komentar'],
            'rating'          => $validated['rating'],
        ]);
        
        // kirim email thankyou 
        try {
            Mail::to($visitorEmail)->send(new ReviewThanksMail($rating, $product));
        } catch (\Throwable $e) {
            Log::error("Email gagal dikirim: ".$e->getMessage());
        }

        return redirect()
        ->route('reviews.thanks', $product->id);
    }

    /**
     * 4) halaman thanks
     */
    public function thanks(Product $product)
    {
        return view('reviews.thanks', [
            'product' => $product,
            'user'    => session('visitor_name'),
        ]);
    }
}
