<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;

class WilayahController extends Controller
{
    public function provinsi()
    {
        return Province::orderBy('nama')->get();
    }

    public function kabupaten($prov)
    {
        return Regency::where('province_kode', $prov)->orderBy('nama')->get();
    }

    public function kecamatan($kab)
    {
        return District::where('regency_kode', $kab)->orderBy('nama')->get();
    }

    public function kelurahan($kec)
    {
        return Village::where('district_kode', $kec)->orderBy('nama')->get();
    }
}
