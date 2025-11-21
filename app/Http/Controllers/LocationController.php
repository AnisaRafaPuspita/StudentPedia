<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Models\Regency;
use App\Models\District;

class LocationController extends Controller
{
    public function getRegencies($province_id)
    {
        return Regency::where('province_id', $province_id)->get();
    }

    public function getDistricts($regency_id)
    {
        return District::where('regency_id', $regency_id)->get();
    }
}
