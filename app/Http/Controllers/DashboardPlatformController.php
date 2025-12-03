<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Seller;
use App\Models\Comment;
use App\Models\Rating;
use Illuminate\Support\Facades\DB;

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
         * 2) Sebaran jumlah toko per provinsi (FULL 38 provinsi)
         * provinces.kode -> sellers.province_kode
         * LEFT JOIN biar provinsi yang kosong tetap muncul 0
         */
        $tokoPerProvinsi = DB::table('provinces')
            ->leftJoin('sellers', 'sellers.province_kode', '=', 'provinces.kode')
            ->select(
                'provinces.nama as provinsi',
                DB::raw('COUNT(sellers.id) as jumlah')
            )
            ->groupBy('provinces.nama')
            ->orderBy('provinces.nama') // biar urut alfabet, lebih enak dibaca
            ->get();

        $tokoProvinsiChart = [
            'labels' => $tokoPerProvinsi->pluck('provinsi')->values()->all(),
            'data'   => $tokoPerProvinsi->pluck('jumlah')->values()->all(),
        ];

        /**
         * 3) Seller aktif & tidak aktif
         * status_verifikasi: pending/approved/rejected
         * aktif = approved
         */
        $penjualAktif = Seller::where('status_verifikasi', 'approved')->count();
        $penjualTidakAktif = Seller::where('status_verifikasi', '!=', 'approved')->count();

        $keaktifanSellerChart = [
            'labels' => ['Aktif', 'Tidak Aktif'],
            'data'   => [$penjualAktif, $penjualTidakAktif],
        ];

        /**
         * 4) Komentar & Rating total
         */
        $jumlahKomentar = Comment::count();
        $jumlahRating   = Rating::count();

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
}
