<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'gambar',
    ];

    protected $casts = [
        'harga' => 'integer',
        'stok'  => 'integer',
    ];

    // RELATIONSHIPS
    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id'); // Atau User::class kalau seller = users
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'product_id');
    }

    public function getAverageRatingAttribute()
    {
        if ($this->ratings()->count() === 0) {
            return null;
        }
        return round($this->ratings()->avg('rating'), 2);
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function mainImage()
    {
        return $this->hasOne(ProductImage::class)->latestOfMany();
    }
}
