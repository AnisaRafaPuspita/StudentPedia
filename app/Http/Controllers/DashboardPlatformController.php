<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Seller;
use App\Models\Rating;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf; 
use Carbon\Carbon;

class DashboardPlatformController extends Controller
{
    public function index()
    {
        /**
         * 1) Sebaran jumlah produk per kategori
         */
        $produkPerKategori = Product::join('categories', 'products.category_id', '=', 'categories.id')
            ->select('categories.nama as kategori', DB::raw('COUNT(products.id) as jumlah'))
            ->groupBy('categories.nama')
            ->orderByDesc('jumlah')
            ->get();

        $produkKategoriChart = [
            'labels' => $produkPerKategori->pluck('kategori')->values()->all(),
            'data'   => $produkPerKategori->pluck('jumlah')->values()->all(),
        ];

        /**
         * 2) Sebaran jumlah toko per provinsi
         */
        $tokoPerProvinsi = DB::table('provinces')
            ->leftJoin('sellers', 'sellers.province_kode', '=', 'provinces.kode')
            ->select(
                'provinces.nama as provinsi',
                DB::raw('COUNT(sellers.id) as jumlah')
            )
            ->groupBy('provinces.nama')
            ->orderBy('provinces.nama')
            ->get();

        $tokoProvinsiChart = [
            'labels' => $tokoPerProvinsi->pluck('provinsi')->values()->all(),
            'data'   => $tokoPerProvinsi->pluck('jumlah')->values()->all(),
        ];

        /**
         * 3) Seller aktif / tidak aktif
         */
        $penjualAktif = Seller::where('status_verifikasi', 'approved')->count();
        $penjualTidakAktif = Seller::where('status_verifikasi', '!=', 'approved')->count();

        $keaktifanSellerChart = [
            'labels' => ['Aktif', 'Tidak Aktif'],
            'data'   => [$penjualAktif, $penjualTidakAktif],
        ];

        /**
         * 4) Komentar & Rating
         */
        $jumlahKomentar = Rating::whereNotNull('komentar')->count();
        $jumlahRating   = Rating::whereNotNull('rating')->count();

        $komentarRatingChart = [
            'labels' => ['Komentar', 'Rating'],
            'data'   => [$jumlahKomentar, $jumlahRating],
        ];

        return view('platform.sellers.dashboardPlatform', compact(
            'produkKategoriChart',
            'tokoProvinsiChart',
            'keaktifanSellerChart',
            'komentarRatingChart',
            'penjualAktif',
            'penjualTidakAktif',
            'jumlahKomentar',
            'jumlahRating'
        ));
    }

    public function exportKeaktifan()
    {
        $data = Seller::select(
            'sellers.*',
            DB::raw("CASE 
                WHEN status_verifikasi = 'approved' THEN 'Aktif'
                ELSE 'Tidak Aktif'
            END AS status_label")
        )
        ->orderByRaw("status_label = 'Aktif' DESC")
        ->with('user')
        ->get();

        $tanggal = Carbon::now()->format('d-m-Y');
        $pemroses = auth()->user()->name;

        return Pdf::loadView('pdf.keaktifan', compact('data', 'tanggal', 'pemroses'))
                ->download('laporan-keaktifan-penjual.pdf');
    }

    public function exportRating()
    {
        $data = DB::table('ratings')
            ->join('products', 'ratings.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('sellers', 'products.seller_id', '=', 'sellers.id')
            ->select(
                'products.nama_produk as produk',
                'categories.nama as kategori',
                'products.harga',
                'ratings.rating',
                'sellers.nama_toko',
                'ratings.nama_provinsi as provinsi'
            )
            ->orderByDesc('ratings.rating', 'DESC')
            ->get();

        $tanggal = Carbon::now()->format('d-m-Y');
        $pemroses = auth()->user()->name;

        return Pdf::loadView('pdf.rating', compact('data','tanggal','pemroses'))
                ->download('laporan-produk-rating.pdf');
    }

    public function exportKategori()
    {
        $data = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('sellers', 'products.seller_id', '=', 'sellers.id')
            ->select(
                'products.nama_produk as produk',
                'categories.nama as kategori',
                'products.harga',
                'products.stok',
                'sellers.nama_toko'
            )
            ->orderBy('categories.nama', 'ASC')      // urut per kategori
            ->orderBy('products.nama_produk', 'ASC') // lalu urut nama produk
            ->get();

        $tanggal  = Carbon::now()->format('d-m-Y');
        $pemroses = auth()->user()->name;

        return Pdf::loadView('pdf.kategori', compact('data', 'tanggal', 'pemroses'))
                ->download('laporan-produk-kategori.pdf');
    }


    public function exportProvinsi()
    {
        $data = DB::table('sellers')
            ->leftJoin('users', 'users.id', '=', 'sellers.user_id')
            ->leftJoin('provinces', 'provinces.kode', '=', 'sellers.province_kode')
            ->select(
                'sellers.nama_toko',
                'users.name as nama_pic',
                'provinces.nama as provinsi'
            )
            ->orderBy('provinces.nama', 'DESC')
            ->get();

        $tanggal  = Carbon::now()->format('d-m-Y');
        $pemroses = auth()->user()->name;

        return Pdf::loadView('pdf.provinsi', compact('data', 'tanggal', 'pemroses'))
                ->download('laporan-toko-provinsi.pdf');
    }


}
