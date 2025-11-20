<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regency extends Model
{
    use HasFactory;

    protected $table = 'regencies';

    protected $fillable = [
        'province_id',
        'nama',
    ];

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function sellers()
    {
        return $this->hasMany(Seller::class, 'regency_id');
    }
}
