<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;

    protected $table = 'sellers';

    protected $fillable = [
        'nama_toko',
        'nama_pemilik',
        'email',
        'no_hp',
        'alamat',
        'province_id',
        'regency_id',
        'status_verifikasi',
        'email_verified_at',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // ================= RELATIONSHIPS =================

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function regency()
    {
        return $this->belongsTo(Regency::class, 'regency_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'seller_id');
    }
}
