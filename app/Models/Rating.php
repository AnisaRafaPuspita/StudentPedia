<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $table = 'ratings';

    protected $fillable = [
        'product_id',
        'nama_pengunjung',
        'email',
        'nomor_hp',
        'nama_provinsi',
        'komentar',
        'rating',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(user::class, 'email', 'email');
    }
}
