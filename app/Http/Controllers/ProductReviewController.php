<?php

namespace App\Http\Controllers;

use App\Mail\ReviewThanksMail;
use App\Models\Rating;
use App\Models\Comment;
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
            'nomor_hp' => ['required','string','max:20'],
            'email' => ['required','email','max:100'],
        ]);

        session([
            'visitor_name'  => $validated['nama_pengunjung'],
            'visitor_phone' => $validated['nomor_hp'],
            'visitor_email' => $validated['email'],
        ]);

        // abis isi biodata langsung ke form komentar
        return redirect()->route('reviews.create', $product->id);
    }

    /**
     * 2) halaman form komentar
     */
    public function create(Product $product)
    {
        // guard: kalau belum isi biodata, balik ke detail produk
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

        if (!$visitorName || !$visitorPhone || !$visitorEmail) {
            return redirect()
                ->route('product.detailProduct', $product->id)
                ->with('msg', 'Isi biodata dulu sebelum komentar ya!');
        }

        $validated = $request->validate([
            'rating'   => ['required','integer','min:1','max:5'],
            'komentar' => ['required','string','max:1000'],
        ]);

        // 1) simpan ke ratings (ikut tabel kamu)
        $rating = Rating::create([
            'product_id'      => $product->id,
            'nama_pengunjung' => $visitorName,
            'komentar'        => $validated['komentar'],
            'rating'          => $validated['rating'],
        ]);

        // 2) simpan juga ke comments
        $comment = Comment::create([
            'product_id'      => $product->id,
            'nama_pengunjung' => $visitorName,
            'komentar'        => $validated['komentar'],
            'rating'          => $validated['rating'],
        ]);

        // 3) kirim email thankyou (jangan bikin submit gagal kalau email error)
        try {
            Mail::to($visitorEmail)->send(new ReviewThanksMail($rating, $comment, $product));
        } catch (\Throwable $e) {
            Log::error("Email gagal dikirim: ".$e->getMessage());
        }

        return redirect()->route('reviews.thanks', $product->id);
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
