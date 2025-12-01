<?php

namespace App\Http\Controllers;
use App\Models\Regency;

use App\Models\District;
use App\Models\Village;

class LocationController extends Controller
{
    public function getRegencies($province_kode)
{
    return Regency::where('province_kode', $province_kode)
        ->orderBy('nama')
        ->get();
}

public function getDistricts($regency_kode)
{
    return District::where('regency_kode', $regency_kode)
        ->orderBy('nama')
        ->get();
}

public function getVillages($district_kode)
{
    return Village::where('district_kode', $district_kode)
        ->orderBy('nama')
        ->get();
}

}
