<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

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
            'labels' => $products->pluck('nama_produk')->values()->all(),
            'data'   => $products->pluck('stok')->values()->all(),
        ];

        // === DATA GRAFIK 2: Sebaran rata-rata rating per produk ===
        $ratingChart = [
            'labels' => $products->pluck('nama_produk')->values()->all(),
            'data'   => $products->map(function ($p) {
                return round($p->average_rating ?? 0, 2);
            })->values()->all(),
        ];

        // === DATA GRAFIK 3: Sebaran pemberi rating per provinsi (pengunjung) ===
        $ratings = Rating::whereHas('product', function ($q) use ($seller) {
                $q->where('seller_id', $seller->id);
            })
            ->get();

        $groupedByProvince = $ratings->groupBy(function ($rating) {
            return $rating->nama_provinsi ?: 'Tidak diketahui';
        });

        $provinceChart = [
            'labels' => $groupedByProvince->keys()->values()->all(),
            'data'   => $groupedByProvince->map->count()->values()->all(),
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

    // SIMPAN PRODUK BARU (MULTI FOTO + KONDISI + MULTI VARIASI)
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

            'kondisi'     => 'required|in:baru,bekas',

            // variasi multi (opsional)
            'variation_type'      => 'nullable|array',
            'variation_type.*'    => 'nullable|in:warna,ukuran_sepatu,ukuran_baju',
            'variation_value'     => 'nullable|array',
            'variation_value.*'   => 'nullable|string|max:255',

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
            'kondisi'     => $validated['kondisi'],
            'gambar'      => null, // diisi nanti pakai foto pertama
        ]);

        // 2. Simpan semua gambar ke storage + tabel product_images
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $index => $imageFile) {
                $path = $imageFile->store('products', 'public');

                $product->images()->create([
                    'path' => $path,
                ]);

                // foto pertama jadi gambar utama
                if ($index === 0) {
                    $product->gambar = $path;
                    $product->save();
                }
            }
        }

        // 3. Simpan VARIASI (bisa banyak baris)
        $types  = $validated['variation_type']  ?? [];
        $values = $validated['variation_value'] ?? [];

        foreach ($types as $i => $type) {
            $value = $values[$i] ?? null;

            if ($type && $value) {
                $product->variations()->create([
                    'type'  => $type,
                    'value' => $value,
                ]);
            }
        }

        return redirect()
            ->route('seller.dashboard')
            ->with('success', 'Produk berhasil diupload!');
    }

    // FORM EDIT PRODUK
    public function edit($id)
    {
        $seller = $this->getCurrentSeller();

        if (! $seller) {
            abort(404, 'Seller tidak ditemukan.');
        }

        // load relasi images + variations buat preview / form
        $product = Product::where('seller_id', $seller->id)
            ->with(['images', 'variations'])
            ->findOrFail($id);

        return view('seller.editProduct', [
            'seller'  => $seller,
            'product' => $product,
        ]);
    }

    // UPDATE PRODUK (MULTI FOTO + KONDISI + MULTI VARIASI)
    public function update(Request $request, $id)
    {
        $seller = $this->getCurrentSeller();

        if (! $seller) {
            abort(404, 'Seller tidak ditemukan.');
        }

        $product = Product::where('seller_id', $seller->id)
            ->with(['images', 'variations'])
            ->findOrFail($id);

        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi'   => 'nullable|string',
            'harga'       => 'required|integer|min:0',
            'stok'        => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',

            'kondisi'     => 'required|in:baru,bekas',

            'variation_type'      => 'nullable|array',
            'variation_type.*'    => 'nullable|in:warna,ukuran_sepatu,ukuran_baju',
            'variation_value'     => 'nullable|array',
            'variation_value.*'   => 'nullable|string|max:255',

            'gambar'      => 'nullable',
            'gambar.*'    => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // update field teks dulu
        $product->nama_produk = $validated['nama_produk'];
        $product->deskripsi   = $validated['deskripsi'] ?? null;
        $product->harga       = $validated['harga'];
        $product->stok        = $validated['stok'];
        $product->category_id = $validated['category_id'];
        $product->kondisi     = $validated['kondisi'];
        $product->save();

        // kalau ada upload gambar baru → ganti semua gambar lama
        if ($request->hasFile('gambar')) {

            // hapus gambar utama lama
            if ($product->gambar && Storage::disk('public')->exists($product->gambar)) {
                Storage::disk('public')->delete($product->gambar);
            }

            // hapus semua record & file di product_images
            foreach ($product->images as $img) {
                if ($img->path && Storage::disk('public')->exists($img->path)) {
                    Storage::disk('public')->delete($img->path);
                }
                $img->delete();
            }

            // simpan gambar baru
            foreach ($request->file('gambar') as $index => $imageFile) {
                $path = $imageFile->store('products', 'public');

                $product->images()->create([
                    'path' => $path,
                ]);

                if ($index === 0) {
                    $product->gambar = $path;
                    $product->save();
                }
            }
        }

        // UPDATE VARIASI: hapus semua, isi ulang dari form
        $product->variations()->delete();

        $types  = $validated['variation_type']  ?? [];
        $values = $validated['variation_value'] ?? [];

        foreach ($types as $i => $type) {
            $value = $values[$i] ?? null;

            if ($type && $value) {
                $product->variations()->create([
                    'type'  => $type,
                    'value' => $value,
                ]);
            }
        }

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

        $product = Product::where('seller_id', $seller->id)
            ->with(['images', 'variations'])
            ->findOrFail($id);

        // hapus semua gambar (utama + relasi)
        if ($product->gambar && Storage::disk('public')->exists($product->gambar)) {
            Storage::disk('public')->delete($product->gambar);
        }

        foreach ($product->images as $img) {
            if ($img->path && Storage::disk('public')->exists($img->path)) {
                Storage::disk('public')->delete($img->path);
            }
            $img->delete();
        }

        // hapus variasi
        $product->variations()->delete();

        $product->delete();

        return redirect()
            ->route('seller.dashboard')
            ->with('success', 'Produk berhasil dihapus!');
    }

    // DOWNLOAD PDF (STOK / RATING)
    public function downloadPdf($type)
    {
        $user = auth()->user();
        $seller = Seller::where('user_id', $user->id)->firstOrFail();

        $productsBase = Product::with('category')
            ->withAvg('ratings', 'rating')
            ->where('seller_id', $seller->id);

        if ($type === 'stok') {
            $products = $productsBase
                ->orderByDesc('stok')
                ->get();

            $pdf = Pdf::loadView('seller.pdf.laporan_stok', [
                'seller'   => $seller,
                'products' => $products,
            ]);

            return $pdf->download('laporan-stok-produk.pdf');
        }

        if ($type === 'rating') {
            $products = $productsBase
                ->orderByDesc('ratings_avg_rating')
                ->get();

            $pdf = Pdf::loadView('seller.pdf.laporan_rating', [
                'seller'   => $seller,
                'products' => $products,
            ]);

            return $pdf->download('laporan-rating-produk.pdf');
        }

        abort(404);
    }
}
