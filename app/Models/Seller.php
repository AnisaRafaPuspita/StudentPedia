<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;

    protected $table = 'sellers';

    protected $fillable = [
        'user_id',
        'nama_toko',
        'deskripsi_singkat',
        'nama_pic',
        'email',
        'no_hp',
        'alamat_jalan',
        'rt',
        'rw',
        'kelurahan',
        'regency_id',
        'province_id',
        'no_ktp_pic',
        'foto_pic',
        'file_ktp_pic',
        'status_verifikasi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function regency()
    {
        return $this->belongsTo(Regency::class, 'regency_id');
    }
}
