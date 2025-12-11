<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductVariation;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'seller_id',
        'category_id',
        'nama_produk',
        'deskripsi',
        'harga',
        'stok',
        'kondisi',
        'gambar',
    ];

    protected $casts = [
        'harga' => 'integer',
        'stok'  => 'integer',
    ];

    // ================= RELATIONSHIPS =================

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'product_id');
    }

    // banyak foto
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function mainImage()
    {
        return $this->hasOne(ProductImage::class)->latestOfMany();
    }
    
    // banyak variasi per produk (S, M, L, warna, dsb)
    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }

    // ================= ACCESSOR / ATTRIBUTE ==============

    public function getAverageRatingAttribute()
    {
        if ($this->ratings()->count() === 0) {
            return null;
        }

        return round($this->ratings()->avg('rating') ?? 0, 2);
    }

    public function getCatalogImageUrlAttribute()
    {
        $image = $this->mainImage ?? $this->images->first();

        if ($image) {
            return asset('storage/'.$image->path);
        }

        return asset('img/default.jpg');
    }
}
