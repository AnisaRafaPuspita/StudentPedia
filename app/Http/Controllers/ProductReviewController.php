<?php

namespace App\Http\Controllers;

use App\Mail\ReviewThanksMail;
use App\Models\Rating;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ProductReviewController extends Controller
{
    public function create(Request $request, $productId)
    {
        // GUARD: kalau session biodata belum ada, lempar ke halaman visitor dulu
        // if (!session('visitor_name') || !session('visitor_phone') || !session('visitor_email')) {
            // return redirect()->route('visitor.form');
        //}
        session([
            'visitor_name'  => session('visitor_name')  ?? 'Test User',
            'visitor_phone' => session('visitor_phone') ?? '08123456789',
            'visitor_email' => session('visitor_email') ?? 'test@gmail.com',
        ]);


        // ambil biodata dari session
        $visitorName  = session('visitor_name');
        $visitorPhone = session('visitor_phone');
        $visitorEmail = session('visitor_email');

        // dummy product (ganti kalau kamu sudah punya model Product)
        $product = (object)[
            'id' => $productId,
            'name' => 'Kemeja Flanel Pria Premium',
            'image' => null,
        ];

        return view('reviews.create', compact(
            'product',
            'visitorName',
            'visitorPhone',
            'visitorEmail'
        ));
    }

    public function store(Request $request, $productId)
    {
        // biodata dari session (bukan dari input)
        $visitorName  = session('visitor_name');
        $visitorPhone = session('visitor_phone');
        $visitorEmail = session('visitor_email');

        // validasi yang tampil di halaman komentar ini
        $validated = $request->validate([
            'rating'  => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'max:1000'],
        ]);

        // kalau session kosong, balikin ke visitor (biar gak error)
        if (!$visitorName || !$visitorPhone || !$visitorEmail) {
            return redirect()->route('visitor.form')
                ->withErrors(['msg' => 'Isi biodata dulu sebelum komentar ya.']);
        }

        // 1) simpan rating ke tabel ratings
        $rating = Rating::create([
            'product_id' => $productId,
            'name'       => $visitorName,
            'phone'      => $visitorPhone,
            'email'      => $visitorEmail,
            'rating'     => $validated['rating'],
        ]);

        // 2) simpan komentar ke tabel comments
        $comment = Comment::create([
            'product_id' => $productId,
            'rating_id'  => $rating->id,
            'name'       => $visitorName,
            'phone'      => $visitorPhone,
            'email'      => $visitorEmail,
            'comment'    => $validated['comment'],
        ]);

        // 3) kirim email terima kasih
        Mail::to($visitorEmail)->send(new ReviewThanksMail($rating, $comment));

        return redirect()
            ->route('reviews.thanks', $productId)
            ->with('user', $visitorName);
    }

    public function thanks(Request $request, $productId)
    {
        return view('reviews.thanks', [
            'productId' => $productId,
            'user' => session('user') ?? session('visitor_name') ?? 'test user',
        ]);
    }
}
