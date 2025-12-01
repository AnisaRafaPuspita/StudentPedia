<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardSellerController extends Controller
{
    /**
     * Helper: ambil seller yang dipakai sekarang
     * (sementara pakai seller pertama di tabel sellers)
     */
    private function getCurrentSeller()
    {
        return Seller::first(); // pastikan ada data di tabel sellers
    }

    // DASHBOARD PENJUAL
    public function index()
    {
        $seller = $this->getCurrentSeller();

        if (! $seller) {
            return 'Belum ada data seller di tabel sellers.';
        }

        // Ambil produk milik seller + relasi kategori & rating
        $products = Product::with(['category', 'ratings'])
            ->where('seller_id', $seller->id)
            ->get();

        // === DATA GRAFIK 1: Sebaran stok per produk ===
        $stockChart = [
            'labels' => $products->pluck('nama_produk')->values(),
            'data'   => $products->pluck('stok')->values(),
        ];

        // === DATA GRAFIK 2: Sebaran rata-rata rating per produk ===
        $ratingChart = [
            'labels' => $products->pluck('nama_produk')->values(),
            'data'   => $products->map(function ($p) {
                return $p->average_rating ?? 0;
            })->values(),
        ];

        // === DATA GRAFIK 3: Sebaran rating per provinsi ===
        $ratings = Rating::with('product.seller.province')
            ->whereHas('product', function ($q) use ($seller) {
                $q->where('seller_id', $seller->id);
            })
            ->get();

        $groupedByProvince = $ratings->groupBy(function ($rating) {
            return optional(optional($rating->product)->seller->province)->nama ?? 'Tidak diketahui';
        });

        $provinceChart = [
            'labels' => $groupedByProvince->keys()->values(),
            'data'   => $groupedByProvince->map->count()->values(),
        ];

        return view('seller.dashboardPenjual', [
            'seller'        => $seller,
            'products'      => $products,
            'stockChart'    => $stockChart,
            'ratingChart'   => $ratingChart,
            'provinceChart' => $provinceChart,
        ]);
    }

    // FORM TAMBAH PRODUK (HALAMAN UPLOAD)
    public function create()
    {
        $seller = $this->getCurrentSeller();

        if (! $seller) {
            return back()->with('error', 'Seller tidak ditemukan.');
        }

        return view('seller.uploadProduk', [
            'seller' => $seller,
        ]);
    }

    // SIMPAN PRODUK BARU (MULTI FOTO)
    public function store(Request $request)
    {
        $seller = $this->getCurrentSeller();

        if (! $seller) {
            return back()->with('error', 'Seller tidak ditemukan.');
        }

        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi'   => 'nullable|string',
            'harga'       => 'required|integer|min:0',
            'stok'        => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',

            // ✅ multi file: minimal 1, tiap file harus image
            'gambar'      => 'required',
            'gambar.*'    => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // 1. Buat produk dulu (tanpa gambar utama)
        $product = Product::create([
            'seller_id'   => $seller->id,
            'category_id' => $validated['category_id'],
            'nama_produk' => $validated['nama_produk'],
            'deskripsi'   => $validated['deskripsi'] ?? null,
            'harga'       => $validated['harga'],
            'stok'        => $validated['stok'],
            'gambar'      => null, // diisi nanti pakai foto pertama
        ]);

        // 2. Simpan semua gambar ke storage + tabel product_images
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $index => $imageFile) {
                $path = $imageFile->store('products', 'public');

                // relasi hasMany ke ProductImage
                $product->images()->create([
                    'path' => $path,
                ]);

                // foto pertama jadi gambar utama di tabel products
                if ($index === 0) {
                    $product->gambar = $path;
                    $product->save();
                }
            }
        }

        return redirect()
            ->route('seller.dashboard')
            ->with('success', 'Produk berhasil diupload!');
    }

    // FORM EDIT PRODUK (masih single image biasa)
    public function edit($id)
    {
        $seller = $this->getCurrentSeller();

        if (! $seller) {
            abort(404, 'Seller tidak ditemukan.');
        }

        $product = Product::where('seller_id', $seller->id)->findOrFail($id);

        return view('seller.editProduct', [
            'seller'  => $seller,
            'product' => $product,
        ]);
    }

    // UPDATE PRODUK (sementara masih 1 gambar)
    public function update(Request $request, $id)
    {
        $seller = $this->getCurrentSeller();

        if (! $seller) {
            abort(404, 'Seller tidak ditemukan.');
        }

        $product = Product::where('seller_id', $seller->id)->findOrFail($id);

        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi'   => 'nullable|string',
            'harga'       => 'required|integer|min:0',
            'stok'        => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            if ($product->gambar && Storage::disk('public')->exists($product->gambar)) {
                Storage::disk('public')->delete($product->gambar);
            }

            $product->gambar = $request->file('gambar')->store('products', 'public');
        }

        $product->nama_produk = $validated['nama_produk'];
        $product->deskripsi   = $validated['deskripsi'] ?? null;
        $product->harga       = $validated['harga'];
        $product->stok        = $validated['stok'];
        $product->category_id = $validated['category_id'];

        $product->save();

        return redirect()
            ->route('seller.dashboard')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    // HAPUS PRODUK
    public function destroy($id)
    {
        $seller = $this->getCurrentSeller();

        if (! $seller) {
            abort(404, 'Seller tidak ditemukan.');
        }

        $product = Product::where('seller_id', $seller->id)->findOrFail($id);

        if ($product->gambar && Storage::disk('public')->exists($product->gambar)) {
            Storage::disk('public')->delete($product->gambar);
        }

        $product->delete();

        return redirect()
            ->route('seller.dashboard')
            ->with('success', 'Produk berhasil dihapus!');
    }
}
